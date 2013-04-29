<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support;

class Arr
{
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }
}