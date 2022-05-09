<?php

namespace Deployer;

/**
 * Unset HTTP cache clear as it fails with HTTP auth
 */
task('cache:clear_php_http', function () {});
