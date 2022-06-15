<?php

namespace Deployer;

if(!get('bandstand_skip_deploy_webroot_assets', false)) {
	task('deploy:assets', function () {
		upload($this->path('html/assets'), '{{release_path}}/html');
	});

	after('deploy:vendors', 'deploy:assets');
}
