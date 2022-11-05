# Liquid Light Deployer

PHP Deployer package for deploying Liquid Light TYPO3 websites. It uses Gitlab CI

## Options

### Hosts

Make a `host.ci.yaml` with the details if you wish to connect locally.

E.g.

```yaml
production:
  hostname: 123.123.123
  user: username
  port: 22
```

### Set environment

It is advised you set an environment for extra config to be applied. This is set on the `host()` to allow for different envs for different hosts

```php
host('production')
  ->set('ll_deployer_environment', 'cpanel')
;
```

- `vps`
- `cpanel`

### Assets upload

Will upload `html/assets` if there as well as `app/*/Resources/Public`, but if you want others that are built then you need to specify them as an array

```php
set('ll_deployer_asset_paths', ['app/nlw/Resources/Public']);
```

## Setup

You need for this process:

- Site to be using composer†
- Site to have a `package.json` file
- Site to not rely on any tech from Gizmo

1. Run a `composer update` and `npm update` (commit any changes to lock files)
2. Create a `deploy.php` in the root of the project - **see below** for example contents
   - Set the `deploy_path` to `/var/www/[domain]` (you may need to deploy to a parallel folder as an interim)
   - Make sure the default SSH user has read & write access to the `deploy_path` on the live server (`775`)
3. `composer req liquidlight/deployer`
4. Ensure the **npm `scripts` block** (below) is in your `package.json`
5. Add deployment stage to `.gitlab-ci.yml` (see below)
   - Update the environment URL
   - Verify [front-end asset build process](https://gitlab.lldev.co.uk/devops/gitlab-ci/-/blob/main/jobs/deployment/deployer.deploy.gitlab-ci.yml) is correct for the site
6. Add `host.ci.yaml` to `.gitignore`
7. Make a `host.ci.yaml` file and populate with the sever details (see example above)
8. Ensure your `.env` (or `.env.local`) file has `INSTANCE="local"` in it (if using development server, this already exists)
9. Run `./vendor/bin/dep deploy:prepare production` - this makes the skeleton files on live and ensures you can connect
10. On the live server - Populate the `shared` folder (located in your `deploy_path`) with folder & file structure of that below. Run the following in `shared`
    - `touch .env`
    - `mkdir -p var html/{fileadmin,typo3temp,uploads}/`
    - Add details to the `.env` file and make sure it has:
       - `INSTANCE="production"` (it should match your `host.ci.yaml` name)
       - `TYPO3_DB_HOST="localhost"` (or wherever the database is hosted)
11. On Gitlab - Add a CI/CD variable with the title/key of `DEPLOY_HOST_PRODUCTION` and the value being set to the contents of `host.ci.yaml` (which you populated in step 7)
    - Go to the repository
    - Click **Settings -> CI/CD** on the left
    - Expand **Variables** and click **Add Variable**
12. Set a second CI variable of `DEPLOYER_FLAGS` to `-vvv` for maximum output
13. On the live server check that:
    - add the Deployment server SSH **public key** to the `authorized_keys` file - this can be found in Lastpass under "Gitlab CI Deployer"
    - Allow incoming SSH connections from `deployment.service.liquidlight.uk`
    - Ensure `git` and `composer` are installed
14. Commit all your changes and push to Gitlab (e.g. `Task: Add deployer for automated deployments`) and push to Gitlab
15. On Gitlab, click the ▶️ button and watch the logs for issues
    - You may need to set the `bin/php` or `bin/composer` paths (e.g. NLW)
    - The `http_user` may need to be set (e.g. CST)
    - The `writable_mode` might need to be changed
    - You may need to set `set('writable_use_sudo', false);` if there is no sudo
16. Once happy it is deploying correctly, remove the `DEPLOYER_FLAGS` CI variabel
16. If there are any folders or files on the live server you want to keep (e.g. `blog` folder), these need to be moved into the `shared` folder and added to the `shared_files` array (see CST & Liquid Light as examples)
17. Update the file in `/etc/cron.d/[domain_name]` to point to the correct place
18. Update the `apache` config (if converting an existing site) to point to `current/html`

### Code Examples

#### `deploy.php`

```php
<?php

namespace Deployer;

require_once __DIR__ . '/vendor/sourcebroker/deployer-loader/autoload.php';
new \LiquidLight\Deployer\Loader(__DIR__);

host('production')
	->set('deploy_path', '/var/www/[domain]')
	->set('writable_mode', 'chmod')
;

task('reload:php-fpm', function () {
	run('sudo /etc/init.d/php7.4-fpm reload');
});

after('deploy', 'reload:php-fpm');
```

### `package.json`

```
   "scripts": {
		"dev": "./node_modules/.bin/gulp watch --dev",
		"watch": "./node_modules/.bin/gulp watch",
		"build": "./node_modules/.bin/gulp ci"
	},
```

### `.gitlab-ci.yml`

```
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

production:deploy:
  stage: deployment
  environment:
    name: production
    url: [domain name - including https]
  extends:
    - .production:deploy
```
