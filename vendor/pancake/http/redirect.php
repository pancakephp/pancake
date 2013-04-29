<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\HTTP\Redirector;
use Pancake\Routing\Route\Collection;

class Redirect
{
    private $routes;

    public function __construct(Collection $routes)
    {
        $this->routes = $routes;
    }

    // TODO: This is an O(n) search, could be an O(1)?
    public function to($alias)
    {
        foreach($this->routes as $route)
        {
            if($route->getAlias() == $alias)
            {
                return new Redirector($route);
            }
        }
    }
}