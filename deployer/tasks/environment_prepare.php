<?php

namespace Deployer;

/**
 * Set config based on environment
 */
task('environment:prepare', function () {
	writeln('Environment: ' . (get('ll_deployer_environment') ?: 'Default'));

	switch (get('ll_deployer_environment')) {
		case 'vps':
			/**
			 * writable_use_sudo
			 * @package deployer
			 *
			 * Using sudo in writable commands?
			 */
			set('writable_use_sudo', true);

			/**
			* bin/composer
			* @package deployer
			*
			* Set default composer path
			*/
			set('bin/composer', '/usr/local/bin/composer');

			break;
		case 'cpanel':
		case 'plesk':
			/**
			 * writable_mode
			 * @package deployer
			 *
			 * What writeable mode should we use?
			 */
			set('writable_mode', 'chmod');

			break;

		default:
			break;
	}
});

before('deploy:prepare', 'environment:prepare');
