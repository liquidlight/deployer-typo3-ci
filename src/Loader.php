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

		new \SourceBroker\DeployerLoader\Load([
			['get' => 'sourcebroker/deployer-typo3-media'],
			['get' => 'sourcebroker/deployer-typo3-database'],
			['get' => 'sourcebroker/deployer-typo3-deploy'],
			['get' => 'sourcebroker/deployer-extended-typo3'],
		]);

		foreach ([
			'config.php',
			'hosts/local.php',
			'hosts/staging.php',
			'hosts/production.php',
			'tasks/deploy_assets.php',
			'tasks/environment_post_deploy.php',
			'tasks/environment_prepare.php',
			'tasks/typo3cms_cache_flush.php',
			'tasks/deploy.php',
		] as $path) {
			require_once dirname(__FILE__) . '/../deployer/' . $path;
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
