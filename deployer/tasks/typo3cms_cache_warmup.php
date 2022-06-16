<?php

namespace Deployer;

task('typo3cms:cache:warmup', function () {
	$activeDir = test('[ -e {{deploy_path}}/release ]') ?
		get('deploy_path') . '/release' :
		get('deploy_path') . '/current';
	run('cd ' . $activeDir . ' &&  {{bin/php}} {{bin/typo3cms}} cache:warmup');
});

after('typo3cms:cache:flush', 'typo3cms:cache:warmup');
