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

### Pushing the database

Pushing the database to live is prohibited, however there are some cases where this needs to be done.

To allow this, add the following to your local `deploy.php` file

```php
set('db_allow_push_live', true);
```

## Common settings

### VPS

#### Configuration

Add the following settings if not set (and adjust if necessary). They can be set globally or chained to the host (e.g. `->set('writable_use_sudo', true)`)

```php
set('writable_use_sudo', true);
set('cleanup_use_sudo', true);
set('writable_mode', 'chgrp');
set('http_group', 'www-data');
```

#### Additional tasks

**`deploy:vps:writable`**

Add an extra post-deploy task to reset permissions and reboot PHP if needed

```php
after('typo3:cache:flush:pages', 'deploy:vps:writable');
```

**`service:php_fpm_reload`**

Add PHP reloading to set the correct version as documented in [deployer-extended](https://github.com/sourcebroker/deployer-extended?tab=readme-ov-file#service)

## Upgrading

### v2 -> v3

As well as removing some functionality, the v3 upgrade requires some changes to the `deploy.php` file

1. In `deploy.php`, update the require location & class invocation

```php
<?php

namespace Deployer;

require_once './vendor/autoload.php';
new \LiquidLight\Deployer\Loader();
```

2. Review each environment and remove the `ll_deployer_environment` declaration - this doesn't add any tasks or configuration any more
    - **Note:** If it was set to `vps` then follow the [**Common settings -> VPS**](#vps) steps above
    
