<?php

namespace Deployer;

/**
 * Set local host
 */
host('production')
	->set('branch', 'main')
	->set('labels', [
		'instance' => 'production',
	])
;

/**
 * Set production as live
 *
 * This makes `db:push` ask
 */
set('instance_live_name', 'production');
