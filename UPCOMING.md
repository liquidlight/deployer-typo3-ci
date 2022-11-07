# Minor

#### Task

- Set `live` environment to be `production` to prevent database overrides
- Set `reload:php` task for VPS environments
- Set `bin/composer` in vps environment
- Set `writable_use_sudo` for VPS envs
- Set `writable_mode` for cPanel envs
- Create `environment:prepare` and `environment:post-deploy` tasks to handle environment specific settings
- Add `plesk` as an accepted environment

#### Dependencies

- Update `deployer-extended-typo3` to v19
