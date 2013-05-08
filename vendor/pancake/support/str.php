<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support;

class Str
{

    public static function contains($haystack, $needle)
    {
        foreach ((array) $needle as $n)
        {
            if (!(strpos($haystack, $n) === false))
                return true;
        }

        return false;
    }

    public static function startsWith($haystack, $needle)
    {
        return strpos($haystack, $needle) === 0;
    }

    public static function endsWith($haystack, $needle)
    {
        return $needle == substr($haystack, strlen($haystack) - strlen($needle));
    }

    public static function beforeFirst($haystack, $needle)
    {
        if (!static::contains($haystack, $needle))
        {
            return $haystack;
        }

        return substr($haystack, 0, strpos($haystack, $needle));
    }

    public static function afterLast($haystack, $needle)
    {
        if (!static::contains($haystack, $needle))
        {
            return $haystack;
        }

        return substr($haystack, strrpos($haystack, $needle) + 1);
    }

    public static function studly($str)
    {
        $str = ucwords(str_replace(array('-', '_'), ' ', $str));

        return str_replace(' ', '', $str);
    }

    public static function camel($value)
    {
        return lcfirst(static::studly($value));
    }

}