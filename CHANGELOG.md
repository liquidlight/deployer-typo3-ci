# 1.2.0

**11th November 2022**

#### Task

- Allow db and media to be pushed to live (with confirmation)
- Globally set writeable to recursive
- Set `writeable_mode` to group (and set group as `www-data`) for VPS
- Carry out chmod mode anyway for `vps` (code taken from main deployer package)
- Move `deploy:writable` to happen _after_ `deploy` - the typo3 `install:fixfolderstructure` was wiping out permissions


# 1.1.0

**7th November 2022**

#### Task

- Set `live` environment to be `production` to prevent database overrides
- Set `reload:php` task for VPS environments
- Set `bin/composer` in vps environment
- Set `writable_use_sudo` for VPS envs
- Set `writable_mode` for all envs
- Create `environment:prepare` and `environment:post-deploy` tasks to handle environment specific settings
- Add `plesk` as an accepted environment

#### Dependencies

- Update `deployer-extended-typo3` to v19


# 1.0.0

**11th August 2022**

Initial release of Liquid Light Deployer.
