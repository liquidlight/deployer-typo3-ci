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

### Assets upload

Will upload `html/assets` if there as well as `app/*/Resources/Public`, but if you want others that are built then you need to specify them as an array

```php
set('ll_deployer_asset_paths', ['app/nlw/Resources/Public']);
```

## Setup

You need for this process:

- Site to be using composer
- Site to have a `package.json` file
- Site to not rely on any tech from Gizmo

1. Run a `composer update` and `npm update`
2. Create a `deploy.php` in the root of the project - **see below** for example contents
   - Set the deploy path to `/var/www/[domain]` (you may need to deploy to a parallel folder as an interim)
   - Make sure the default SSH user has read & write access (`775`)
3. `composer req liquidlight/deployer`
4. Add the **npm scripts block** (below) to your `package.json`
5. Add deployment stage to `.gitlab-ci.yml`
   - You may need to split the CI file into the more verbose version found on projects such as CST and LWG
   - Update the environment URL
   - Verify front-end asset build process is correct for the site
6. Add `host.ci.yaml` to `.gitignore`
7. Make a `host.ci.yaml` file with the format above
8. Ensure your `.env` (or `.env.local`) file has `INSTANCE="local"` in it (if using development server, this already exists)
9. Run `./vendor/bin/dep deploy:prepare production` - this makes the skeleton files on live and ensures you can connect
10. On the live server - Populate the `shared` folder (located in your `deploy_path`) with folder & file structure of that below
    - Make sure the `.env` file has:
       - `INSTANCE="production"` (it should match your `host.ci.yaml` name)
       - `TYPO3_DB_HOST="localhost"` (or wherever the database is hosted)
11. On Gitlab - Add a CI/CD variable with the title/key of `DEPLOY_HOST_PRODUCTION` and the value being set to the contents of `host.ci.yaml` (which you populated in step 6)
    - Go to the repository
    - Click **Settings -> CI/CD** on the left
    - Expand **Variables** and click **Add Variable**
10. On the live server
    - add the Deployment server SSH **public key** to the `authorized_keys` file - this can be found in Lastpass under "Gitlab CI Deployer"
    - Allow incoming SSH connections from `deployment.service.liquidlight.uk`
    - Ensure `git` and `composer` are installed
11. Commit all your changes and push to Gitlab (e.g. `Task: Add deployer for automated deployments`)
12. Set a CI variable of `DEPLOYER_FLAGS` to `-vvv` for maximum output
12. On Gitlab, click the ▶️ button and watch the logs for issues
    - You may need to set the `bin/php` or `bin/composer` paths (e.g. NLW)
    - The `http_user` may need to be set (e.g. CST)
    - The `writable_mode` might need to be changed
    - You may need to set `set('writable_use_sudo', false);` if there is no sudo
13. If there are any folders or files on the live server you want to keep (e.g. `blog` folder), these need to be moved into the `shared` folder and added to the `shared_files` array (see CST & Liquid Light as examples)
14. Update the file in `/etc/cron.d/[domain_name]` to point to the correct place
15. Update the `apache` config (if converting an existing site) to point to `current/html`

### Code Examples

#### `deploy.php`

```php
<?php

namespace Deployer;

require_once __DIR__ . '/vendor/sourcebroker/deployer-loader/autoload.php';
new \LiquidLight\Deployer\Loader(__DIR__);

host('production')
	->set('deploy_path', '')
;

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
    url:
  extends:
    - .production:deploy
```

### Shared Folder Structure

```
shared/
  .env
  html/
    fileadmin/
    typo3temp/
    uploads/
  var/
```

- `touch .env`
- `mkdir -p var html/{fileadmin,typo3temp,uploads}/`
