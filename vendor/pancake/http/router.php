<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\HTTP\Route\Collection;
use Pancake\HTTP\Route\Matcher;
use Pancake\Support\Arr;
use Closure;

class Router
{

    protected $app;

    protected $routes;

    protected $filters = array();

    protected $groups = array(
        'stack'     => array(),
        'instances' => array()
    );

    public function __construct($app)
    {
        $this->app = $app;
        $this->routes = new Collection;
    }

    public function route(Request $request)
    {
        $path = $request->getPathInfo();

        $context = $request->getRouteContext();

        $name = (new Matcher($this->routes, $context))->match($path);

        $route = $this->routes->get($name);

        $route->setBefore(Arr::only($this->filters, $route->getBefores()));
        $route->setAfter(Arr::only($this->filters, $route->getAfters()));

        return $route;
    }

    public function register($method, $pattern, $action)
    {
        $route = (new Route($method, $pattern))
            ->setAction($action)
            ->setGroups(Arr::only($this->groups['instances'], $this->groups['stack']));

        $this->routes->add($route);

        return $route;
    }

    public function group(Closure $action)
    {
        $group = $this->addGroup();

        // Add routes
        call_user_func($action);

        // Remove the group from the stack
        array_pop($this->groups['stack']);

        // Return the group instance so that it can be updated.
        return $group;
    }

    public function addGroup(){
        // Add a group instance
        $this->groups['instances'][] = new Group();

        end($this->groups['instances']);
        $index = key($this->groups['instances']);

        // Create a reference on the stack to the index of the instance.
        $this->groups['stack'][] = $index;

        // Return the group
        return $this->groups['instances'][$index];
    }

    public function getFilter($key)
    {
        return isset($this->filters[$key]) ? $this->filters[$key] : null;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function filter($name, Closure $action)
    {
        $this->filters[$name] = $action;
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