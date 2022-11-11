<?php

namespace Deployer;

task('environment:post-deploy', function () {

	/**
	 * Reload PHP FPM
	 */
	if (get('ll_deployer_environment') === 'vps') {

		/**
		 * chmod
		 * @package deployer
		 *
		 * Run "chmod" mode from recipe/deploy/writable.php
		 */
		$dirs = join(' ', get('writable_dirs'));
		$recursive = get('writable_recursive') ? '-R' : '';
		$sudo = get('writable_use_sudo') ? 'sudo' : '';

		cd('{{release_path}}');
		run("$sudo chmod $recursive {{writable_chmod_mode}} $dirs");

		/**
		 * reload php
		 * @package custom
		 *
		 * Reload PHP
		 */
		$process = get('deployer_php_process', '/etc/init.d/php7.4-fpm');
		run('sudo ' . $process . ' reload');
	}
});

after('deploy', 'deploy:writable');
after('deploy', 'environment:post-deploy');
