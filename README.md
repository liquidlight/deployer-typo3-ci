# Liquid Light Deployer

This package is used by Liquid Light to deploy TYPO3 websites via CI - specifically Gitlab.

---

It is best used within Gitlab CI as it can utilise several environment variables.

The basis for this is [PHP Deployer](https://deployer.org/), however a lot of functionality comes from [deployer-extended-typo3](https://github.com/sourcebroker/deployer-extended-typo3) and it's many meta-packages.

## Options

There are several settings [defined by default](./deployer/hosts) within this package for the most common hosts.

### Hosts

Set the hostname of the server in the `deploy.php` file - the rest of the connection details should be in your `.ssh/config` file

```php
host('production')
  ->set('hostname', 'client.xxx')
;
```

#### Existing Hosts

The following hosts have a config file in the `deployer/hosts` file with some sensible defaults

- production
- staging
- local

### Set environment

It is advised you set an environment for extra config to be applied. This is set on the `host()` to allow for different envs for different hosts

```php
host('production')
  ->set('ll_deployer_environment', 'cpanel')
;
```

#### Options

- `vps` - for a fully self-managed debian based vps
- `cpanel` - for a site running with cPanel

### Assets upload

This package will upload `html/assets` if there as well as `app/*/Resources/Public`, but if you want others that are built then you need to specify them as an array. This can be set globally or on a host by host basis

e.g.

```php
set(
  'll_deployer_asset_paths',
  [
    '{{release_path}}/html/_assets'
  ]
);
```

### `.env` file upload

You can add the contents of your `.env` file as a CI/CD variable (ensure "file" is selected in the drop down) and set it as `DEPLOY_DOTENV_[ENVIRONMEENT NAME]`. This then needs to be set to an environment variable in your `.gitlab-ci.yaml` of `DEPLOY_DOTENV` to be deployed.

```yaml
  variables:
    DEPLOY_DOTENV: $DEPLOY_DOTENV_PRODUCTION
```

### Clearing OPCache

If the server has `OPCache` installed, it will need to be cleared on each deployment to allow PHP and Apache to see the new symlinks.

To do this, you need to declare an array in `public_urls` in the deploy file, along with adding the `cache:clear_php_http` task for the environment.

1. Add `->set('public_urls', ['[URL]'])` to the `production` host in `deploy.php`
2. Add the `cache:clear_php_http` task for production instances (example below)

```php
on(select('instance=production'), function ($host) {
	after('cache:clear_php_cli', 'cache:clear_php_http');
});
```

### Pushing the dastabase

Pushing the database to live is prohibeted, however there are some cases where this needs to be done.

To allow this, add the following to your local `deploy.php` file

```php
set('db_allow_push_live', true);
```