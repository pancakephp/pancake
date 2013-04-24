<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

require __DIR__.'/../bootstrap/autoload.php';

$app = require __DIR__.'/../bootstrap/start.php';

$app->run();

$app->shutdown();