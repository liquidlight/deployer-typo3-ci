<?php

namespace Deployer;

/**
 * Set local host
 */
host('production')
	->set('branch', 'main')
	->set('log_files', 'var/log/typo3_*.log')
;

/**
 * Set production as live
 *
 * This makes `db:push` ask
 */
set('instance_live_name', 'production');
