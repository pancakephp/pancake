<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

Route::get('/', function(){
    return View::make('hello');
});

// Route::get('/', 'HomeController@index');

Route::group(function()
{

    Route::get('/{age}/{location}', function($name, $age, $location)
    {
        return 'Hello '.$name.', you\'re '.$age.' from '.$location;
    })
    ->alias('me')
    ->where(array(
        'age' => '[0-9]+'
    ));

})
->domain('{name}.pancake.dev')
->where(array(
    'name' => '[A-z]+'
));


/**
 * Apply filters by ->before(string|array) & ->after(string|array).
 * Anything returned (other than null) returned from a before filter
 * will stop the request at that point.
 */
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
    echo 'After Filter<br/>';
});