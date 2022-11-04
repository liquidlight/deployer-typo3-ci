<?php

namespace Deployer;

if (get('deployer_environment', false) === 'cpanel') {
	/**
	 * writable_mode
	 * @package deployer
	 *
	 * What writeable mode should we use?
	 */
	set('writable_mode', 'chmod');
}

