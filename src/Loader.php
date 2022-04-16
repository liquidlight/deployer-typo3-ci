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
		$this->loadSites();

		new \SourceBroker\DeployerExtendedTypo3\Loader();

		require_once $this->path('vendor/liquidlight/bandstand/deployer/config.php');

		require_once $this->path('vendor/liquidlight/bandstand/deployer/tasks/assets.php');

		foreach($this->envs as $host) {
			require $this->path('vendor/liquidlight/bandstand/deployer/hosts/_skel.php');
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

	protected function loadSites()
	{
		$siteConfig = Yaml::parseFile($this->path('config/sites/tbc/config.yaml'));
		$regex = '/applicationContext == \"(.*?)\"/';
		$this->envs['production'] = [
			'name' => 'Production',
			'slug' => 'production',
			'url' => $siteConfig['base']
		];

		foreach($siteConfig['baseVariants'] as $env) {

			if(!isset($env['condition'])) {
				continue;
			}

			preg_match($regex, $env['condition'], $matches);

			if(!count($matches)) {
				continue;
			}

			$name = $matches[1];
			$slug = explode('/', $name);
			$slug = strtolower(isset($slug[1]) ? $slug[1] : $slug[0]);

			if(!isset($this->envs[$slug])) {
				$this->envs[$slug] = [
					'name' => $name,
					'slug' => $slug,
					'url' => $env['base']
				];
			}
		}
	}
}
