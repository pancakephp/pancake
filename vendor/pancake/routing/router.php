<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Routing;

use Pancake\Routing\Group\Collection as GroupCollection;
use Pancake\Routing\Route\Collection as RouteCollection;
use Pancake\Routing\Route\Matcher;
use Pancake\HTTP\Request;
use Pancake\HTTP\Response;
use Pancake\Support\Arr;
use \Pancake\HTTP\Exceptions\HttpException;

class Router
{

    protected $app;

    protected $routes;

    protected $groups;

    protected $filters = array();

    public function __construct($app)
    {
        $this->app = $app;
        $this->groups = new GroupCollection;
        $this->routes = new RouteCollection;
    }

    public function route(Request $request)
    {
        $this->groups->updateRoutes();

        $route = $this->findRoute($request);

        $route->setBefore(Arr::only($this->filters, $route->getBefores()));
        $route->setAfter(Arr::only($this->filters, $route->getAfters()));

        return $route;
    }

    protected function findRoute(Request $request)
    {
        try
        {
            $path = $request->getPathInfo();

            $context = $request->getRouteContext();

            $name = (new Matcher($this->routes, $context))->match($path);

            return $this->routes->get($name);
        }
        catch(HttpException $e)
        {
            die('<pre>'.print_r($e, 1).'</pre>');
        }
    }

    public function register($method, $pattern, $action)
    {
        $route = (new Route($method, $pattern))->setAction($action);

        $this->groups->addRoute($route);
        $this->routes->addRoute($route);

        return $route;
    }

    public function group(\Closure $action)
    {
        $this->groups->open();

        call_user_func($action);

        $this->groups->close();

        return $this->groups->instance();
    }

    public function filter($name, \Closure $action)
    {
        $this->filters[$name] = $action;
    }

    public function getFilter($key)
    {
        return isset($this->filters[$key]) ? $this->filters[$key] : null;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function get($pattern, $action)
    {
        return $this->register(Request::GET, $pattern, $action);
    }

    public function post($pattern, $action)
    {
        return $this->register(Request::POST, $pattern, $action);
    }

    public function put($pattern, $action)
    {
        return $this->register(Request::PUT, $pattern, $action);
    }

    public function patch($pattern, $action)
    {
        return $this->register(Request::PATCH, $pattern, $action);
    }

    public function delete($pattern, $action)
    {
        return $this->register(Request::DELETE, $pattern, $action);
    }

    public function any($pattern, $action)
    {
        return $this->register(Request::ANY, $pattern, $action);
    }

}