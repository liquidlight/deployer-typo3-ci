<?php

namespace Deployer;

/**
 * Reload PHP FPM
 */
task('reload:php-fpm', function () {
	if (in_array(get('ll_deployer_environment'), ['vps'])) {
		$process = get('deployer_php_process', '/etc/init.d/php7.4-fpm');
		run('sudo ' . $process . ' reload');
	}
});

after('deploy', 'reload:php-fpm');
