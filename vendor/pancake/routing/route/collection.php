<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Routing\Route;

use Pancake\Routing\Route;

class Collection implements \IteratorAggregate, \Countable
{

    private $routes = array();

    private $aliases = array();

    public function addRoute(Route $route)
    {
        $name = $route->getName();

        unset($this->routes[$name]);

        $this->routes[$name] = $route;
    }

    public function get($key)
    {
        return isset($this->routes[$key]) ? $this->routes[$key] : null;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }

    public function count()
    {
        return count($this->routes);
    }

}