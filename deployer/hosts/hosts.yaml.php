<?php

namespace Deployer;

// Set the file which gets created by CiI
$file = getcwd() . '/host.ci.yaml';

// If the deploy target is set, put it in the file
if (getenv('DEPLOY_TARGET')) {
	file_put_contents($file, getenv('DEPLOY_TARGET'));
}

// Load the host.ci.yaml
if (file_exists($file)) {
	inventory($file);
}
