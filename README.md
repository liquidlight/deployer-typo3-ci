# Liquid Light Deployer

PHP Deployer package for deploying Liquid Light TYPO3 websites. It is best used withing Gitlab CI as it can utlise several environment variables.

The bais for this is [PHP Deployer](https://deployer.org/), however a lot of functionality comes from [deployer-extended-typo3](https://github.com/sourcebroker/deployer-extended-typo3) and it's many meta-packages.

## Options

There are several settings [defined by default](./deployer/hosts) within this package for the most common hosts.


### Hosts

Set the hostname of the server in the `deploy.php` file - the rest of the connection details should be in your `.ssh/config` file

```php
host('production')
  ->set('hostname', 'client.xxx')
;
```

### Set environment

It is advised you set an environment for extra config to be applied. This is set on the `host()` to allow for different envs for different hosts

```php
host('production')
  ->set('ll_deployer_environment', 'cpanel')
;
```

#### Options

- `vps`
- `cpanel`

### Assets upload

Will upload `html/assets` if there as well as `app/*/Resources/Public`, but if you want others that are built then you need to specify them as an array

```php
->set('ll_deployer_asset_paths', ['app/nlw/Resources/Public']);
```

### `.env` file upload

Add the contents of your `.env` file as a CI/CD variable (ensure "file" is selected in the drop down) and set it as `DEPLOY_DOTENV_XXX`. This then needs to be set to an environment varibale of `DEPLOY_DOTENV` to be deployed.

```yaml
  variables:
    DEPLOY_DOTENV: $DEPLOY_DOTENV_PRODUCTION
```

### Clearing OPCache

If the server has `OPCache` installed, it will need to be cleared on each deployment to allow PHP and Apache to see the new symlinks.

To do this, you need to declare an array in `public_urls` in the deploy file, along with adding the `cache:clear_php_http` task for the environment.

1. Add `->set('public_urls', ['[URL]'])` to the `production` host in `deploy.php`
2. Add the `cache:clear_php_http` task for prodiction intances (example below)

```php
on(select('instance=production'), function ($host) {
	after('cache:clear_php_cli', 'cache:clear_php_http');
});
```


## Setup

You need for this process:

- Site to be using composer
- Site to have a `package.json` file
- Site to be using `.env` files
- Site to not rely on any tech from Gizmo

### Setup a new site

@TODO: Fill in

### Converting Zync to Deployer

1. Run a `composer update` and `npm update` (commit any changes to lock files)
2. On the live server, check that `git` and `composer` are installed
3. Create a `deploy.php` in the root of the project - **see below** for example contents
   - Set the `deploy_path` to `/var/www/[domain]` or `/home/[user]/www` if using cPanel (you may need to deploy to a parallel folder as an interim)
   - Make sure the default SSH user has read & write access to the `deploy_path` on the live server (`775`)
4. `composer req liquidlight/deployer`
5. Ensure the **npm `scripts` block** (below) is in your `package.json`
6. Add deployment stage to `.gitlab-ci.yml` (see below)
   - Update the environment URL
   - Verify [front-end asset build process](https://gitlab.lldev.co.uk/devops/gitlab-ci/-/blob/main/jobs/deployment/deployer.deploy.gitlab-ci.yml) is correct for the site
7. Ensure your `.env` (or `.env.local`) file has `INSTANCE="local"` in it (if using development server, this already exists)
8. Run `./vendor/bin/dep deploy:setup production` - This creates the files and folders needed on the live server
9.  On the live server - Populate the `shared` folder (located in your `deploy_path`) with folder & file structure of that below. Run the following in `shared`
    - `mkdir -p var html/{fileadmin,typo3temp,uploads}/` - if this is a site being migrated, copy the contents of `fileadmin` and `uploads` (`rsync -vaz [path/to/site]/html/fileadmin/ fileadmin/`)
    - `sudo find . -type d -exec chmod 775 {} \;` - reset the folder permissions
10. On Gitlab - Add a CI/CD variable with the title/key of `DEPLOY_HOST_PRODUCTION` and the value being that of the SSH config value
    - Go to the repository
    - Click **Settings -> CI/CD** on the left
    - Expand **Variables** and click **Add Variable**
11. On Gitlab - Add a CI/CD variable with the title/key of `DEPLOY_DOTENV_PRODUCTION` and the value being that of the `.env` file - make sure **file** is selected in the _Type_ dropdown
11. Set a third CI variable of `DEPLOYER_FLAGS` to `-vvv` for maximum output
12. If there are any folders or files on the live server you want to keep (e.g. `blog` folder), these need to be moved into the `shared` folder and added to the `shared_files` array (see CST & Liquid Light as examples) - these can be identified by folders ignored in the `project.inc`
13. Commit all your changes and push to Gitlab (e.g. `feat: Add deployer for automated deployments`) and push to Gitlab
14. On Gitlab, click the ▶️ button and watch the logs for issues
    - You may need to set the `bin/php` or `bin/composer` paths (e.g. NLW)
    - The `http_user` may need to be set (e.g. CST)
    - The `writable_mode` might need to be changed
    - You may need to set `set('writable_use_sudo', false);` if there is no sudo
15. Once happy it is deploying correctly, remove the `DEPLOYER_FLAGS` CI variable & add `deployer` as a Topic in Gitlab (remove `npm-project` and `composer-project`)
16. Update the file in `/etc/cron.d/[domain_name]` to point to the correct place (or update in cPanel)
17. Update the `apache` config (if converting an existing site) to point to `current/html` (for cPanel, repoint the `public_html` symlink to `www/current/html`)
18. Regenerate the [SSL certificate with Certbot](https://hub.lldocs.dev/sysadmin/debian/ssl-certificates?#installing-and-generating-ssl-certificate) to point to the new web root (you can run `certbot renew --dry-run` to see the currently active domains & sites)
19. Run the search scheduler & any other tasks that might make temporary files to check they work
20. Test the forms and search
21. Consider setting up [Renovate](https://gitlab.lldev.co.uk/devops/renovate#set-up-a-new-repository)

### Code Examples

#### `deploy.php`

```php
<?php

namespace Deployer;

require_once __DIR__ . '/vendor/sourcebroker/deployer-loader/autoload.php';
new \LiquidLight\Deployer\Loader(__DIR__);

/**
 * Hosts
 */

// Production
host('production')
	->set('hostname', 'client.xxx')
	->set('ll_deployer_environment', 'cpanel')
	->set('deploy_path', '/home/[user]/www')
;
```

### `package.json`

```json
  "scripts": {
    "dev": "./node_modules/.bin/gulp watch --dev",
    "watch": "./node_modules/.bin/gulp watch",
    "build": "./node_modules/.bin/gulp compile",
    "gulp": "./node_modules/.bin/gulp"
  },
```

### `.gitlab-ci.yml`

```yaml
###
# Gitlab CI
#
# @author Mike Street
# @date 06-2021
#
###

include:
  - project: 'devops/gitlab-ci'
    file: '.gitlab-ci-template.yml'

stages:
  - linting
  - testing
  - deployment

# Define stages for jobs
php:coding-standards:
  stage: linting
  extends:
    - .php:coding-standards

js:eslint:
  stage: linting
  extends:
    - .js:eslint

scss:stylelint:
  stage: linting
  extends:
    - .scss:stylelint

package:audit:
  extends:
    - .package:audit

production:deploy:
  stage: deployment
  variables:
    DEPLOY_DOTENV: $DEPLOY_DOTENV_PRODUCTION
  environment:
    name: production
    url: [domain name - including https]
  extends:
    - .production:deploy
```

### `.env`

```
TYPO3_CONTEXT="Production"
INSTANCE="production"

# DB
TYPO3_DB_USER=""
TYPO3_DB_PASSWORD=""
TYPO3_DB_NAME=""
TYPO3_DB_HOST="localhost"
```
