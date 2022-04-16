<?php

namespace Deployer;

if (isset(
	$this->composer['extra'],
	$this->composer['extra']['typo3/cms'],
	$this->composer['extra']['typo3/cms']['web-dir']
)) {
	set('web_path', $this->composer['extra']['typo3/cms']['web-dir']);
}

set('default_stage', 'local');
set('composer_channel', 2);
set('shared_files', ['.env']);
