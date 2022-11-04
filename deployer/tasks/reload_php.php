<?php

namespace Deployer;

/**
 * Reload PHP FPM
 */
task('reload:php-fpm', function () {
	$process = get('deployer_php_process', '/etc/init.d/php7.4-fpm');
	run('sudo ' . $process . ' reload');
});
