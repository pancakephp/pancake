<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Routing;

use Pancake\Support\Str;
use Pancake\Routing\Route;

class Group
{

    private $routes = array();

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function setHosts($host)
    {
        foreach($this->routes as $route)
        {
            $route->setHost($host);
        }

        return $this;
    }

    public function setWheres(Array $where)
    {
        foreach($this->routes as $route)
        {
            $route->setWhere($where);
        }

        return $this;
    }

    public function host($host)
    {
        return $this->setHosts($host);
    }

    public function where(Array $where)
    {
        return $this->setWheres($where);
    }

}