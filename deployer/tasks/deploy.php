<?php

namespace Deployer;

/**
 * Unset Deploy task if we don't have the repo
 */
if (!getenv('CI_REPOSITORY_URL')) {
	task('deploy', function () {
		writeln('<fg=yellow;options=bold>warning</> <comment>getenv(\'CI_REPOSITORY_URL\') missing - deployment disabled</comment>');
	});
}
