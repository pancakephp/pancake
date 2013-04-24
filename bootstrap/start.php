<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

/**
 * Create the application
 */
$app = new Pancake\Foundation\App;

/**
 * Set application paths
 */
$app->setPaths(require __DIR__.'/paths.php');

/**
 * Register the Alias loader
 */
$app->registerAliases(require __DIR__.'/aliases.php');

/**
 * Register the app within the Facade
 */

$app->registerFacade();

/**
 * Load the routes
 */
require_once $app['paths']['app'].'/routes.php';

/**
 * Return the app
 */
return $app;