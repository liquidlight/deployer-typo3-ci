<?php

namespace Deployer;

task('deploy:assets', function () {
	if(is_dir($this->path('html/assets'))) {
		upload($this->path('html/assets'), '{{release_path}}/html');
	}
	if(is_dir($this->path('html/_assets'))) {
		upload($this->path('html/_assets'), '{{release_path}}/html');
	}
});

after('deploy:vendors', 'deploy:assets');
