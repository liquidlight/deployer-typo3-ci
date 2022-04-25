<?php

namespace Deployer;

task('deploy:assets_build', function () {
	run('npm ci');
	run('gulp compile');
})->local();
after('deploy:prepare', 'deploy:assets_build');

task('deploy:assets', function () {
	upload($this->path('html/assets'), '{{release_path}}/html');
});
after('deploy:vendors', 'deploy:assets');
