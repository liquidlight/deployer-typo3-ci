<?php

namespace Deployer;

if (isset(
	$this->composer['extra'],
	$this->composer['extra']['typo3/cms'],
	$this->composer['extra']['typo3/cms']['web-dir']
)) {
	set('web_path', rtrim($this->composer['extra']['typo3/cms']['web-dir'], '/') . '/');
}

set('default_stage', 'local');
set('composer_channel', 2);
set('shared_files', ['.env']);

set('writable_dirs', function () {
	return [
		'var',
		get('web_path') . 'typo3conf',
		get('web_path') . 'typo3temp',
		get('web_path') . 'uploads',
		get('web_path') . 'fileadmin',
	];
});
