<?php

namespace LiquidLight\Deployer;

class Loader
{
	protected $path;

	protected $composer;

	public function __construct($path)
	{
		$this->path = $path;

		$this->loadComposer();

		new \SourceBroker\DeployerExtendedTypo3\Loader();

		foreach ([
			'config.php',
			'environments/cpanel.php',
			'environments/vps.php',
			'hosts/hosts.yaml.php',
			'hosts/local.php',
			'hosts/staging.php',
			'hosts/production.php',
			'tasks/assets_deploy.php',
			'tasks/cache_clear_php_http.php',
			'tasks/deploy.php',
			'tasks/reload_php.php',
			'tasks/typo3cms_cache_flush.php',
		] as $path) {
			require_once $this->path('vendor/liquidlight/deployer/deployer/' . $path);
		}
	}

	protected function path($path)
	{
		return sprintf('/%s/%s', trim($this->path, '/'), ltrim($path, '/'));
	}

	protected function loadComposer()
	{
		$composer = $this->path('composer.json');
		if (file_exists($composer)) {
			$this->composer = json_decode(file_get_contents($composer), true);
		}
	}
}
