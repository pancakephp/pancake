<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Route;

require_once APP.'/routes.php';

class Collection implements \IteratorAggregate, \Countable
{

    private $_routes;
    private $_aliases;

    public function __construct()
    {
        $routes = \Route::getRoutes();

        foreach ($routes as $route)
        {
            $this->_routes[$route->getKey()] = $route;

            // For O(1) alias lookups
            if($alias = $route->getAlias())
            {
                $this->_aliases = $alias;
            }
        }

    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_routes);
    }

    public function count()
    {
        return count($this->_routes);
    }

    public function get($key)
    {
        return isset($this->_routes[$key]) ? $this->_routes[$key] : null;
    }

}