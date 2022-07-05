<?php

namespace Deployer;

/**
 * default_stage
 *
 * If you just run "deploy" what happens?
 *
 * Check if file doesn't exist - e.g. deploying via CI
 */
if (!file_exists(getcwd() . '/.env')) {
	set('default_stage', 'local');
}
