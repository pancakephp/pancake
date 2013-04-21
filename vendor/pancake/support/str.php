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

}