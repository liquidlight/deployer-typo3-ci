<?php

namespace Deployer;

/**
 * Set local host
 */
host('local')
	->set('hostname', 'local')
	->set('deploy_path', getcwd())
	->set('labels', [
		'instance' => 'local',
	])
;
