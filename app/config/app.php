<?php
return array(

    'debug' => true,

    'timezone' => 'UTC',

    'locale' => 'en',

    'key' => 'Keep it secret, keep it safe.',

    'autoload' => array(
        $app['paths']['app'].'/controllers',
        $app['paths']['app'].'/models',
    )
);