<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support\Facades;

class Response
{

    public static function make($content = '', $status = 200, array $headers = array())
    {
        return new \Pancake\HTTP\Response($content, $status, $headers);
    }

    public static function json($data = array(), $status = 200, array $headers = array())
    {
        return static::make(json_encode($data), $status, $headers)->header('Content-Type', 'application/json');
    }

}