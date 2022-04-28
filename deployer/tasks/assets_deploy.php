<?php

namespace Deployer;

if(get('bandstand_compile_assets', true)) {
	task('deploy:assets', function () {
		upload($this->path('html/assets'), '{{release_path}}/html');
	});

	after('deploy:vendors', 'deploy:assets');
}
