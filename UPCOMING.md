# Major

#### Feature

- Expand `clear_paths` to include more files
- Update `deploy` task to match `deployer-typo3-deploy-ci`

#### Refactor

- Remove `deploy:dotenv` task (not used)
- Remove `db_allow_push_live` and `media_allow_push_live` - set in `sourcebroker/deployer-typo3-extended`
- Remove `composer_channel` - set in `sourcebroker/deployer-typo3-extended`
- Remove `web_path` - set in `sourcebroker/deployer-typo3-media`
- Remove `log_files` - set in `sourcebroker/deployer-typo3-deploy`
- Remove `env` as a `shared_file` - set in `sourcebroker/deployer-typo3-deploy`

#### Dependencies

- Upgrade `deployer-extended-typo3` to 24
