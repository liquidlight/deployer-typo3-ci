<?php

namespace Deployer;

task('typo3:install:extensionsetupifpossible', function () {
    run('cd {{release_or_current_path}} && {{bin/php}} {{bin/typo3}} install:extensionsetupifpossible -v --fail-on-error');
})->desc('Setup TYPO3 extensions if possible')->hidden();