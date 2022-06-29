# Bandstand

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
set('bandstand_asset_paths', ['app/nlw/Resources/Public']);
```

## Setup

1. Add `deploy.php`
2. `composer req liquidlight/bandstand`
3. Add deployment stage to Gitlab CI
4. Add `host.ci.yaml` to gitignore
5. Make a `host.ci.yaml` file with the format above
6. Ensure your `.env` file has `INSTANCE="local"` in it
7. Run `./vendor/bin/dep deploy:prepare production` to make the files on live
8. On the live server - Populate the `shared` folder with the right layout
  - Make sure the `.env` folder has both an `INSTANCE` and `TYPO3_DB_HOST="localhost"` (or relevant) variable set
9. On Gitlab - Add a CI/CD variable with the title of `DEPLOY_HOST_PRODUCTION` and the value of the yaml file
10. On the live server - add the Deployment SSH public key, found in Lastpass under "Gitlab CI Deployer"

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
