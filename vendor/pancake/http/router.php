<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\HTTP\Route\Collection;
use Pancake\HTTP\Route\Matcher;
use Closure;

class Router
{

    protected $routes;

    protected $filters = array();

    protected $groups = array(
        'stack'     => array(),
        'instances' => array()
    );

    public function __construct($app)
    {
        $this->routes = new Collection;
    }

    public function route(Request $request)
    {
        $path = $request->getPathInfo();

        $context = $request->getRouteContext();

        $name = (new Matcher($this->routes, $context))->match($path);

        $route = $this->routes->get($name);

        // TODO: Cleanup?
        $route->setFilters(
            array_intersect_key($this->filters, array_flip($route->getOption('before'))),
            array_intersect_key($this->filters, array_flip($route->getOption('after')))
        );

        return $route;
    }

    public function register($method, $pattern, $action)
    {
        $route = (new Route($method, $pattern))
            ->setOption('action', $action)
            ->setGroups($this->groups['stack']);

        $this->routes->add($route);

        return $route;
    }

    public function group($name, Closure $action)
    {
        $group = $this->addGroup($name);

        // Add routes
        call_user_func($action);

        // Remove the group from the stack
        array_pop($this->groups['stack']);

        // Return the group instance so that it can be updated.
        return $group;
    }

    public function addGroup($name){
        $this->groups['stack'][] = $name;
        return $this->groups['instances'][$name] = new Group();
    }

    public function getFilter($key)
    {
        return isset($this->filters[$key]) ? $this->filters[$key] : null;
    }

    public function getCollection()
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