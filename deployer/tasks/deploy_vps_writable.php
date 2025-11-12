<?php

/**
 * Not used in standard deploy but a requirement for VPS
 */

namespace Deployer;

task('deploy:vps:writable', function () {
	/**
	 * chmod & chgrp
	 * @package deployer
	 *
	 * Run "chmod" mode from recipe/deploy/writable.php
	 */
	$dirs = join(' ', get('writable_dirs'));
	$recursive = get('writable_recursive') ? '-R' : '';
	$sudo = get('writable_use_sudo') ? 'sudo' : '';

	cd('{{release_path}}');

	// chgrp
	run("$sudo chgrp -L $recursive {{http_group}} $dirs");

	// chmod
	run("$sudo chmod $recursive {{writable_chmod_mode}} $dirs");
});
