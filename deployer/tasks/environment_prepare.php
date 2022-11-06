<?php

namespace Deployer;

/**
 * Set config based on environment
 */
task('environment:prepare', function () {
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
			writeln('Environment: cPanel');

			/**
			 * writable_mode
			 * @package deployer
			 *
			 * What writeable mode should we use?
			 */
			set('writable_mode', 'chmod');

			break;

		default:
			writeln('Environment: Default');
			break;
	}
});

before('deploy:prepare', 'environment:prepare');
