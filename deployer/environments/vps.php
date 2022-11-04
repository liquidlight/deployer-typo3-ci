<?php

namespace Deployer;

if (get('deployer_environment', false) === 'vps') {
	/**
	 * writable_use_sudo
	 * @package deployer
	 *
	 * Using sudo in writable commands?
	 */
	set('writable_use_sudo', true);

	after('deploy', 'reload:php-fpm');
}
