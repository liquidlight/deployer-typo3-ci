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

	// Standard deployer task.
	'deploy:shared',

	// Standard deployer task.
	'deploy:writable',

	// Create database backup, compress and copy to database store.
	// Read more on https://github.com/sourcebroker/deployer-extended-database#db-backup
	'db:backup',

	// deployer-typo3-deploy-ci task.
	'typo3:cache:warmup:system',

	// deployer-typo3-deploy-ci task.
	'typo3:extension:setup',

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
