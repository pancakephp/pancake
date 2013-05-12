<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 *
 * @see  https://github.com/pancakephp/pancake/wiki/Routing
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
->before('auth')
->host('{name}.pancake.dev')
->where(array(
    'name' => '[A-z]+'
));

Route::get('/login', function ()
{
    return 'Login';
});