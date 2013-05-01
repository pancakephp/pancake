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

    private $host;

    private $where;

    private $prefix;

    private $before;

    private $after;

    public function addRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function updateRoutes()
    {
        foreach($this->routes as $route)
        {
            $this->host and $route->setHost($this->host);

            $this->where and $route->setWhere($this->where);

            $this->prefix and $route->setPath('/'.$this->prefix.'/'.trim($route->getPath(), '/'));

            $this->before and $route->setBefore($this->before);

            $this->after and $route->setAfter($this->after);
        }
    }

    public function host($host)
    {
        $this->host = $host;
        return $this;
    }

    public function where(Array $where)
    {
        $this->where = $where;
        return $this;
    }

    public function prefix($prefix)
    {
        $this->prefix = trim($prefix, '/');
        return $this;
    }

    public function before($before)
    {
        $this->before = $before;
        return $this;
    }

    public function after($after)
    {
        $this->after = $after;
        return $this;
    }

}