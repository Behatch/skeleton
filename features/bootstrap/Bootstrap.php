<?php

/*
 * This script helps loading dependencies in a clean way.
 * Please require_once this script in each context you create.
 */
require_once __DIR__.'/../../mink.phar';

ini_set('include_path', ini_get('include_path') . ':' . __DIR__.'/../../lib/vendor/PHPUnit-3.5.3');
require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';
