<?php

namespace Deployer;

/**
 * web_path
 *
 * Use the web path from composer
 */
if (isset(
	$this->composer['extra'],
	$this->composer['extra']['typo3/cms'],
	$this->composer['extra']['typo3/cms']['web-dir']
)) {
	set('web_path', rtrim($this->composer['extra']['typo3/cms']['web-dir'], '/') . '/');
}

/**
 * composer_channel
 *
 * What composer version?
 */
set('composer_channel', 2);
