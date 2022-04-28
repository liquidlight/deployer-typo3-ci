<?php

namespace Deployer;

/**
 * driver_typo3cms
 *
 * Use typo3 as the driver - will get db details from typo3cms command
 */
set('driver_typo3cms', true);

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
 * default_stage
 *
 * If you just run "deploy" what happens?
 */
set('default_stage', 'production');

/**
 * composer_channel
 *
 * What composer version?
 */
set('composer_channel', 2);

/**
 * shared_files
 *
 * Add .env as a shared file
 */
set('shared_files', array_merge(get('shared_files'), ['.env']));

/**
 * writable_dirs
 */
set(
	'writable_dirs',
	[
		'var',
		get('web_path') . 'typo3conf',
		get('web_path') . 'typo3temp',
		get('web_path') . 'uploads',
		get('web_path') . 'fileadmin',
	]
);
