<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

Route::get('/', 'Do_SomethingController@index');

Route::get('/{id}/', function()
{
    return 'ID Page';
});

// What we want to work
//
// Route::get('/', function()
// {
//     echo 'Home';
// })
// ->alias('account')  // Named route
// ->filter('auth')    // Run filters before
// ->where(array(
//     'accountid' => '[0-9]+'
// ));


// Route::group(function()
// {
//     Route::get(/* .. */);

// })
// ->domain('{account}.myside.com')
// ->filter('auth');


// Route::filter('auth', function()
// {
//     //.. Run some code
// });