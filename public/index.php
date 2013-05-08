<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

isset($_GET['pprof']) and apd_set_pprof_trace('../app/storage/traces');

require __DIR__.'/../bootstrap/autoload.php';

$app = require __DIR__.'/../bootstrap/start.php';

$app->run();

$app->shutdown();