<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

Route::any('/', 'HomeController@index')
->before(array('beforeFilterOne', 'beforeFilterTwo'))
->after('afterFilter');

Route::get('/{name}/{age}', function($name, $age)
{
    return 'Hello '.$name.', you\'re '.$age;
})
// ->alias('me')
->where(array(
    'age' => '[0-9]+'
));

Route::filter('beforeFilterOne', function()
{
    echo 'Before Filter One<br/>';
});

Route::filter('beforeFilterTwo', function()
{
    echo 'Before Filter Two<br/>';
});

Route::filter('afterFilter', function()
{
    return 'After Filter<br/>';
});