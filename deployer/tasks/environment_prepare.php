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
			 * writable_mode
			 * @package deployer
			 *
			 * What writeable mode should we use?
			 */
			set('writable_mode', 'chgrp');

			/**
			 * http_group
			 * @package deployer
			 *
			 * Used to make a writable directory by a server. Used in chgrp mode of writable_mode only. Attempts automatically to detect http user in process list.
			 */
			set('http_group', 'www-data');

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

			/**
			 * writable_chmod_mode
			 * @package deployer
			 *
			 * What permissions should "writable_dirs" have?
			 */
			set('writable_chmod_mode', '0775');

			break;

		default:
			break;
	}
});

before('deploy:prepare', 'environment:prepare');
