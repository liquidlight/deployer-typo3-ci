<?php

namespace Deployer;

/**
 * Set local host
 */
host('staging')
	->set('branch', 'env/staging')
	->set('log_files', 'var/log/typo3_*.log')
	->set('labels', [
		'instance' => 'staging',
	])
	->set('keep_releases', 1)
	->set('infisical_environment', 'staging')
;
