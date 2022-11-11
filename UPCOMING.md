# Minor

#### Task

- Allow db and media to be pushed to live (with confirmation)
- Globally set writeable to recursive
- Set `writeable_mode` to group (and set group as `www-data`) for VPS
- Carry out chmod mode anyway for `vps` (code taken from main deployer package)
- Move `deploy:writable` to happen _after_ `deploy` - the typo3 `install:fixfolderstructure` was wiping out permissions
