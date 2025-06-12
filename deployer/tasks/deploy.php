<?php

namespace Deployer;

task('deploy', [

	// Standard deployer task.
	'deploy:info',

	// Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-lock
	'deploy:check_lock',

	// Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-branch-local
	'deploy:check_branch_local',

	// Read more on https://github.com/sourcebroker/deployer-extended#deploy-check-branch
	'deploy:check_branch',

	// Standard deployer task.
	'deploy:check_remote',

	// Set variables and other pre-deploy tasks
	'environment:prepare',

	// Standard deployer task.
	'deploy:setup',

	// Standard deployer task.
	'deploy:lock',

	// Standard deployer task.
	'deploy:release',

	// Standard deployer task.
	'deploy:update_code',

	// Standard deployer task.
	'deploy:shared',

	// Standard deployer task.
	'deploy:writable',

	// Standard deployer task.
	'deploy:vendors',

	// Upload front-end assets
	// Read more on https://gitlab.lldev.co.uk/packages/typo3/deployer#assets-upload
	'deploy:assets',

	// Standard deployer task.
	'deploy:clear_paths',

	// Create database backup, compress and copy to database store.
	// Read more on https://github.com/sourcebroker/deployer-extended-database#db-backup
	'db:backup',

	// Truncate caching tables, all cf_* tables
	// Read more on https://github.com/sourcebroker/deployer-extended-database#db-truncate
	'db:truncate',

	// Update database schema for TYPO3. Task from typo3_console extension.
	'typo3cms:database:updateschema',

	// Standard deployer task.
	'deploy:symlink',

	// Clear php cli cache.
	// Read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-cli
	'cache:clear_php_cli',

	// Clear TYPO3 caches
	'typo3cms:cache:flush',

	// Carry out any post-deploy tasks
	// Read more on https://gitlab.lldev.co.uk/packages/typo3/deployer#set-environment
	'environment:post-deploy',

	// Standard deployer task.
	'deploy:unlock',

	// Standard deployer task.
	'deploy:cleanup',

	// Standard deployer task.
	'deploy:success',
]);
