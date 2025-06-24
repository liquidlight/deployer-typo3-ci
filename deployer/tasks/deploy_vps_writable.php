<?php

namespace Deployer;

task('deploy:vps:writable', function () {
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
});
