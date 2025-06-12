<?php

namespace Deployer;

task('typo3cms:cache:flush', function () {
	$activeDir = test('[ -e {{deploy_path}}/release ]') ?
		get('deploy_path') . '/release' :
		get('deploy_path') . '/current';
	run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3}} cache:flush');
});
