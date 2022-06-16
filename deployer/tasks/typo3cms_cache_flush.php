<?php

namespace Deployer;

task('typo3cms:cache:flush', function () {
	$activeDir = test('[ -e {{deploy_path}}/release ]') ?
		get('deploy_path') . '/release' :
		get('deploy_path') . '/current';
	run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:flush');
});

after('cache:clear_php_http', 'typo3cms:cache:flush');
