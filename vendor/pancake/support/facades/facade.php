<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support\Facades;

abstract class Facade
{

    protected static $app;

    protected static $facadeInstances;

    public static function setApp($app)
    {
        static::$app = $app;
    }

    protected static function getFacadeAccessor()
    {
        throw new \Exception('Accessor has not been set');
    }

    public static function getFacadeInstance($name)
    {
        return static::$app[$name];
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = static::getFacadeInstance(static::getFacadeAccessor());

        switch (count($arguments))
        {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($arguments[0]);

            case 2:
                return $instance->$method($arguments[0], $arguments[1]);

            case 3:
                return $instance->$method($arguments[0], $arguments[1], $arguments[2]);

            case 4:
                return $instance->$method($arguments[0], $arguments[1], $arguments[2], $arguments[3]);

            default:
                return call_user_func_array(array($instance, $method), $arguments);
        }
    }

}