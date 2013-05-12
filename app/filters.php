<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 *
 * @see  https://github.com/pancakephp/pancake/wiki/Routing#filters
 */

/**
 * Global before & after filters
 */
App::before(function ()
{
    // ..
});


App::after(function ()
{
    // ..
});

/**
 * Regular filters
 */
Route::filter('csrf', function()
{
    // ..
});

Route::filter('auth', function()
{
    echo 'Auth Filter';
});