<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support\Facades;

class Route extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'router';
    }

}