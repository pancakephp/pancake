<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

Route::any('/', 'HomeController@index');

Route::get('/{name}/{age}', function($name, $age){
    return 'Hello '.$name.', you\'re '.$age;
})
->where(array(
    'age' => '[0-9]+'
));


Route::group('authed', function(){

    Route::get('/login', 'Secure_Login@index');
    Route::post('/login', 'Secure_Login@authenticate');

    Route::group('account', function(){

        Route::get('/account/{id}', function($account, $id){
            //..
        })
        ->alias('account');

    })
    ->domain('{account}.mysite.com');

})
->filter(array('auth', 'https'));


/*
Route::filter('auth', function(){ });
*/