<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Route;

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
        foreach ($this->routes as $name => $route)
        {
            // Check for a static pattern match first
            if (!$route->getStaticPattern() && !(Str::startsWith($path, $route->getStaticPrefix())))
                continue;

            if (!preg_match($route->getRegexPattern(), $path, $matches))
                continue;

            // TODO: Matches on domain

            if (!(in_array($this->context->getMethod(), $route->getMethods())))
                continue;

            return $name;
        }
    }

}