<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

class Route extends Pancake\HTTP\Route
{
    private static $routes;

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function register($method, $pattern, $action)
    {
        return self::$routes[] = new self($method, $pattern, $action);
    }

    public static function get($pattern, $action)
    {
        return self::register(Request::GET, $pattern, $action);
    }

    public static function post($pattern, $action)
    {
        return self::register(Request::POST, $pattern, $action);
    }

    public static function put($pattern, $action)
    {
        return self::register(Request::PUT, $pattern, $action);
    }

    public static function delete($pattern, $action)
    {
        return self::register(Request::DELETE, $pattern, $action);
    }

    public static function any($pattern, $action)
    {
        return self::register(Request::ANY, $pattern, $action);
    }

}