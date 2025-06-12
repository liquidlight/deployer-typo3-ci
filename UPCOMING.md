# Major

#### Refactor

- Remove `deploy:dotenv` task (not used)
- Remove `db_allow_push_live` and `media_allow_push_live` - set in `sourcebroker/deployer-typo3-extended`
- Remove `composer_channel` - set in `sourcebroker/deployer-typo3-extended`
- Remove `web_path` - set in `sourcebroker/deployer-typo3-media`

#### Dependencies

- Upgrade `deployer-extended-typo3` to 24
