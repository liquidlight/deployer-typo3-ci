<?php

namespace Deployer;

/**
 * Set local host
 */
host('local')
	->set('hostname', 'local')
	->set('deploy_path', getcwd())
	->set('log_files', 'var/log/typo3_*.log')
;
