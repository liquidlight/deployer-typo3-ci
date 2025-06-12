<?php

namespace Deployer;

/**
 * Set local host
 */
host('staging')
	->set('branch', 'env/staging')
	->set('labels', [
		'instance' => 'staging',
	])
	->set('keep_releases', 1)
;
