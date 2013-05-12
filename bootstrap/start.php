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
 * Register the app within the Facade
 */
Pancake\Support\Facades\Facade::setApp($app);

/**
 * Set application paths
 */
$app->setPaths(require __DIR__.'/paths.php');

/**
 * Register the Alias loader
 */
$app->registerAliases(require __DIR__.'/aliases.php');


/**
 * Autoload instances
 */
$app->registerWithAutoloader($app['config']['app']['autoload']);

/**
 * Load the routes
 */
require $app['paths']['app'].'/routes.php';

/**
 * Return the app
 */
return $app;