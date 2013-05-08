<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 *
 * Verb      Path                   Action     Route
 * -------------------------------------------------------------
 * get       /resource              index      resource@index
 * get       /resource/create       create     resource@create
 * post      /resource              store      resource@store
 * get       /resource/{id}         show       resource@show
 * get       /resource/{id}/edit    edit       resource@edit
 * put       /resource/{id}         update     resource@update
 * delete    /resource/{id}         destroy    resource@destroy
 */

Route::get('/', 'HomeController@index');

Route::get('/database', function()
{
    $extracts = DB::query('SELECT * FROM `extracts` LIMIT 1;')->execute();
    return Response::json($extracts);
});

Route::get('/redirect', 'Home_TestController@redirect');

Route::group(function()
{

    Route::get('/{location}', function($name, $location)
    {
        return 'Hello '.$name.', you\'re from '.$location;
    })
    ->alias('me')
    ->where(array(
        'age' => '[0-9]+'
    ));

})
->prefix('location')
->before(array('beforeFilterOne', 'beforeFilterTwo'))
->after('afterFilter')
->host('{name}.pancake.dev')
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
    // ..
});

Route::filter('beforeFilterTwo', function()
{
    // ..
});

Route::filter('afterFilter', function()
{
    // ..
});