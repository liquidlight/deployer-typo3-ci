<?php

namespace Deployer;

task('deploy:dotenv', function () {
	if (getenv('DEPLOY_DOTENV')) {
		upload(getenv('DEPLOY_DOTENV'), '{{release_or_current_path}}/.env');
	}
});
