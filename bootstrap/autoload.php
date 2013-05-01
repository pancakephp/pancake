<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

require __DIR__.'/../vendor/pancake/support/splclassloader.php';

$loader = new Pancake\Support\SplClassLoader(__DIR__.'/../vendor');
$loader->register();

$loader = new Pancake\Support\SplClassLoader(__DIR__.'/../app/controllers');
$loader->register();

$loader = new Pancake\Support\SplClassLoader(__DIR__.'/../app/models');
$loader->register();