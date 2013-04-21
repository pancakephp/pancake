<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Route;

require_once APP.'/routes.php';

class Collection implements \IteratorAggregate, \Countable
{

    private $routes;
    private $aliases;

    public function __construct()
    {
        $routes = \Route::getRoutes();

        foreach ($routes as $route)
        {
            $this->routes[$route->getKey()] = $route;

            // For O(1) alias lookups
            if($alias = $route->getAlias())
            {
                $this->aliases = $alias;
            }
        }

    }

    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }

    public function count()
    {
        return count($this->routes);
    }

    public function get($key)
    {
        return isset($this->routes[$key]) ? $this->routes[$key] : null;
    }

}