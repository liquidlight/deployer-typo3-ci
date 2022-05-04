<?php

namespace LiquidLight\Bandstand;

use Symfony\Component\Yaml\Yaml;
use SourceBroker\DeployerLoader\Load;

class Loader
{
	protected $path;

	protected $composer;

	protected $envs = [];

	public function __construct($path)
	{
		$this->path = $path;

		$this->loadComposer();

		new \SourceBroker\DeployerExtendedTypo3\Loader();

		foreach([
			'config.php',
			'tasks/assets_deploy.php',
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
