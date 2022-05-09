<?php

namespace Deployer;

/**
 * Set local host
 */
host('production')
	->set('branch', 'env/production')
	->addSshOption('StrictHostKeyChecking', 'no');
;
