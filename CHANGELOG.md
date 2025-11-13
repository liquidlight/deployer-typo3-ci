# 3.1.1

**13th November 2025**

#### Fix

- Run `chgrp` with `chmod` in `deploy:vps:writable`

# 3.1.0

**24th October 2025**

#### Feature

- Specify `shared_dirs` to include `typo3temp`

#### Refactor

- Remove `COMPOSER_AUTH` env - composer installs are done locally

# 3.0.0

**3rd October 2025**

#### Feature

- Expand `clear_paths` to include more files
- Expand `ignore_tables_out` to include more tables
- Update `deploy` task to match `deployer-typo3-deploy-ci`

#### Refactor

- Remove `deploy:dotenv` task (not used)
- Remove `db_allow_push_live` and `media_allow_push_live` - set in `sourcebroker/deployer-typo3-extended`
- Remove `composer_channel` - set in `sourcebroker/deployer-typo3-extended`
- Remove `web_path` - set in `sourcebroker/deployer-typo3-media`
- Remove `log_files` - set in `sourcebroker/deployer-typo3-deploy`
- Remove `env` as a `shared_file` - set in `sourcebroker/deployer-typo3-deploy`
- Remove `environment:` tasks - they should now be set locally
- Remove PHP reloading so the command can be set locally

#### Dependencies

- Replace `deployer-extended-typo3` with the separate packages
    - `sourcebroker/deployer-typo3-deploy-ci`
    - `sourcebroker/deployer-typo3-database`
    - `sourcebroker/deployer-typo3-media`
    - `sourcebroker/deployer-extended`


# 2.6.2

**17th June 2025**

#### Fix

- Re-add `deploy:writable` after deployment of assets to set `var` folder permissions correctly

# 2.6.1

**17th June 2025**

#### Fix

- Restart PHP 7.4 only if it was previously running

# 2.6.0

**12th June 2025**

#### Feature

- Upgrade `sourcebroker/deployer-extended-typo3` to `23.0` (#1)


# 2.5.0

**14th November 2024**

#### Feature

- Allow syncing of assets for TYPO3 v12
- Prohibit pushing of the database to live

# 2.4.0

**16th January 2024**

#### Dependencies

- Update `sourcebroker/deployer-extended-typo3` to `21.0.0`

# 2.3.1

**21st November 2023**

#### Fix

- Make file loader relative to current file instead of hardcoding it


# 2.3.0

**17th November 2023**

#### Feature

- Move the package to open-source and rename
- Only keep 1 deployment for staging environment

# 2.2.1

**16th August 2023**

#### Fix

- Remove `deploy:check_composer_install` as it didn't take into account dev dependencies

# 2.2.0

**14th August 2023**

#### Feature

- Pass `COMPOSER_AUTH` environment variable to the target
- Remove `.env.example` from live server
- Redefine the `deploy` tasks to add Liquid Light tasks and remove http cache clear (#3)
- Allow uploading of `.env` file with `DEPLOY_DOTENV` environment variable
- Add `labels` to environments to allow adding specific tasks

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
