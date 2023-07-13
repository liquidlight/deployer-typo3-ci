# 2.1.0

**13th July 2023**

#### Backend

- Set `log_files` location for all environments

#### Bug

- Fix glob for resources to handle nested app folder

# 2.0.0

#### Feature

- Update `sourcebroker/deployer-extended-typo3` to version 20 (which brings in deployer version 7). [See the documentation](https://gitlab.lldev.co.uk/packages/typo3/deployer#upgrading-to-version-2) for how to migrate

# 1.3.0

**19th December 2022**

#### Task

- Remove reliance on `host.ci.yaml`

# 1.2.1

**17th November 2022**

#### Bug

- Set cleanup to use `sudo` on VPS

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
