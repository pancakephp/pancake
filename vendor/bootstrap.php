<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

$base = realpath(__DIR__.'/../');

define('BASE', $base);
define('APP', $base.'/app');
define('PUBLIC', $base.'/public');
define('STORAGE', $base.'/storage');
define('VENDOR', $base.'/vendor');
define('SYSTEM', $base.'/vendor/pancake');

require_once SYSTEM.'/support/classloader.php';

try
{
    Pancake\Support\ClassLoader::listen();

    $app = new Pancake\App;

    return $app;
}
// catch(Pancake_Exception $e)
catch(Exception $e)
{
    echo __METHOD__.' : '.__LINE__;
    echo '<pre>'.print_r($e, 1).'</pre>';
    die;
}