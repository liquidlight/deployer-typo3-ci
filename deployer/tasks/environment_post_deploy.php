<?php

namespace Deployer;

task('environment:post-deploy', function () {

	/**
	 * Reload PHP FPM
	 */
	if (get('ll_deployer_environment') === 'vps') {
		$process = get('deployer_php_process', '/etc/init.d/php7.4-fpm');
		run('sudo ' . $process . ' reload');
	}
});

after('deploy', 'environment:post-deploy');
