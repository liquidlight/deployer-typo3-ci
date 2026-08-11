<?php

namespace Deployer;

task('deploy', [

	// Standard deployer task.
	'deploy:info',

	// Standard deployer task.
	'deploy:setup',

	// Standard deployer task.
	'deploy:lock',

	// Standard deployer task.
	'deploy:release',

	// deployer-typo3-deploy-ci task.
	'file:upload_build',

	// liquidlight/deployer-typo3-ci task.
	'secrets:fetch',

	// Standard deployer task.
	'deploy:shared',

	// Standard deployer task.
	'deploy:writable',

	// Create database backup, compress and copy to database store.
	// Read more on https://github.com/sourcebroker/deployer-extended-database#db-backup
	'db:backup',

	// liquidlight/deployer-typo3-ci task.
	'typo3:install:extensionsetupifpossible',

	// Standard Deployer task.
	'deploy:symlink',

	// sourcebroker/deployer-extended special task. Read more on https://github.com/sourcebroker/deployer-extended#cache-clear-php-cli
	'cache:clear_php_cli',

	// deployer-typo3-deploy-ci task.
	'typo3:cache:flush:pages',

	// Standard Deployer task.
	'deploy:unlock',

	// Standard Deployer task.
	'deploy:cleanup',

	// Standard Deployer task.
	'deploy:success'
]);
