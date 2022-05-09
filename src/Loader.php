<?php

namespace LiquidLight\Bandstand;

class Loader
{
	protected $path;

	protected $composer;

	public function __construct($path)
	{
		$this->path = $path;

		$this->loadComposer();

		new \SourceBroker\DeployerExtendedTypo3\Loader();

		foreach([
			'config.php',
			'hosts/local.php',
			'hosts/staging.php',
			'hosts/production.php',
			'tasks/assets_deploy.php',
			'tasks/cache_clear_php_http.php',
		] as $path) {
			require_once $this->path('vendor/liquidlight/bandstand/deployer/' . $path);
		}

	}

	protected function path($path)
	{
		return sprintf('/%s/%s', trim($this->path, '/'), ltrim($path, '/'));
	}

	protected function loadComposer()
	{
		$composer = $this->path('composer.json');
		if(file_exists($composer)) {
			$this->composer = json_decode(file_get_contents($composer), true);
		}
	}
}
