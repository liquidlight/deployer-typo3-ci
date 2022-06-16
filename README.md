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
