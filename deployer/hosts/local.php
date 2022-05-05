<?php

namespace Deployer;

/**
 * Set local host
 */
host('local')
	->hostname('local')
	->set('deploy_path', getcwd())
;

