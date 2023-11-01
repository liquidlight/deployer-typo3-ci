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

