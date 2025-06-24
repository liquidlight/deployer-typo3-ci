<?php

namespace LiquidLight\Deployer;

class Loader
{
	public function __construct()
	{
		new \SourceBroker\DeployerLoader\Load([
			['get' => 'sourcebroker/deployer-typo3-media'],
			['get' => 'sourcebroker/deployer-typo3-database'],
			['get' => 'sourcebroker/deployer-typo3-deploy-ci'],
			['package' => 'liquidlight/deployer-extended-typo3'],
		]);
	}
}
