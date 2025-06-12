<?php

namespace Deployer;

task('deploy', [

	// Standard deployer task.
	'deploy:info',

	// Set variables and other pre-deploy tasks
	'environment:prepare',

	// Standard deployer task.
	'deploy:setup',

	// Standard deployer task.
	'deploy:lock',

	// Standard deployer task.
	'deploy:release',

	// deployer-typo3-deploy-ci task.
	'file:upload_build',

	// Standard deployer task.
	'deploy:shared',

	// Standard deployer task.
	'deploy:writable',

	// Standard deployer task.
	'deploy:clear_paths',

	// Create database backup, compress and copy to database store.
	// Read more on https://github.com/sourcebroker/deployer-extended-database#db-backup
	'db:backup',

	// Truncate caching tables, all cf_* tables
	// Read more on https://github.com/sourcebroker/deployer-extended-database#db-truncate
	'db:truncate',

	// deployer-typo3-deploy-ci task.
	'typo3:cache:warmup:system',

	// deployer-typo3-deploy-ci task.
	'typo3:extension:setup',

	// Standard Deployer task.
	'deploy:symlink',

	// sourcebroker/deployer-extended special task.Add commentMore actions
	// read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-cli
	'cache:clear_php_cli',

	// deployer-typo3-deploy-ci task.
	'typo3:cache:flush:pages',

	// Carry out any post-deploy tasks
	// Read more on https://gitlab.lldev.co.uk/packages/typo3/deployer#set-environment
	'environment:post-deploy',

	// Standard Deployer task.
	'deploy:unlock',

	// Standard Deployer task.
	'deploy:cleanup',

	// Standard Deployer task.
	'deploy:success'
]);
