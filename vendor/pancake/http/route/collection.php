<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Route;

use Pancake\HTTP\Route;

class Collection implements \IteratorAggregate, \Countable
{

    private $routes = array();

    public function add(Route $route)
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