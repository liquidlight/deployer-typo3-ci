<?php

namespace Deployer;

task('deploy:assets', function () {
	/**
	 * Rsync our standard compiled assets
	 */
	if (is_dir($this->path('html/assets'))) {
		upload($this->path('html/assets'), '{{release_path}}/html');
	}

	if (is_dir($this->path('html/_assets'))) {
		upload($this->path('html/_assets'), '{{release_path}}/html');
	}

	/**
	 * Rsync local resources to handle compilation
	 */
	$paths = array_merge(
		(glob('app/*/Resources/Public') ?? []),
		(glob('app/*/*/Resources/Public') ?? []),
		get('ll_deployer_asset_paths', [])
	);

	if (count($paths)) {
		foreach ($paths as $path) {
			$path = ltrim($path, '/');
			$dest = explode('/', $path);
			array_pop($dest);
			$dest = implode('/', $dest);

			upload($this->path($path), '{{release_path}}/' . $dest);
		}
	}
});
