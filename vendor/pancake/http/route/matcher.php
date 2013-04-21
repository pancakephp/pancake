<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Route;

use \Pancake\HTTP\Request;

class Matcher
{

    public function __construct(Collection $routes)
    {
        $this->routes  = $routes;
    }

    public function match(Request $request)
    {
        $pathinfo = $request->getPathInfo();
        $method   = $request->getMethod();

        foreach ($this->routes as $name => $route)
        {
            // Check for a static pattern match first
            if (!$route->getStaticPattern() && !($pathinfo == $route->getStaticPattern()))
                continue;

            if (!preg_match($route->getRegexPattern(), $pathinfo, $matches))
                continue;

            // TODO: Matches on domain

            if (!($route->getMethod() === $method))
                continue;

            return $name;
        }
    }

}