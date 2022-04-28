<?php

namespace Deployer;

if(get('bandstand_compile_assets', true)) {
	task('deploy:assets_build', function () {
		run('npm ci');
		run('gulp compile');
	})->local();

	after('deploy:prepare', 'deploy:assets_build');
}
