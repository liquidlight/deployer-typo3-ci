<?php

namespace Deployer;

host($host['slug'])
	->set('public_urls', [$host['url']]);
