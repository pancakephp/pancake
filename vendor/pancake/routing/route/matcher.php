<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Routing\Route;

use Pancake\Support\Str;
use Pancake\HTTP\Request;
use Pancake\HTTP\Request\RouteContext;

class Matcher
{

    public function __construct(Collection $routes, RouteContext $context)
    {
        $this->routes  = $routes;
        $this->context = $context;
    }

    public function match($path)
    {
        $host   = $this->context->getHost();
        $method = $this->context->getMethod();

        foreach ($this->routes as $name => $route)
        {

            // Check the method
            if (!(in_array($method, $route->getMethods())))
                continue;

            // Static matches
            // > Path
            if (!$route->getStaticPattern() && !(Str::startsWith($path, $route->getStaticPrefix())))
                continue;

            // > Host
            if ($route->getHostStaticPattern() && !(Str::startsWith($host, $route->getHostStaticPrefix())))
                continue;

            // Regex matching
            // Host
            if ($route->getHost() && !preg_match($route->getHostRegexPattern(), $host, $matches))
                continue;

            $parameters = isset($matches) ? array_splice($matches, 1) : array();

            // > Path
            if (!preg_match($route->getRegexPattern(), $path, $matches))
                continue;

            $parameters = array_merge($parameters, array_splice($matches, 1));
            $route->setParameters($parameters);

            return $name;
        }

        throw new \Exception('404');
    }

}