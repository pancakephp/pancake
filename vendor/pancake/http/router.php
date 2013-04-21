<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\HTTP\Route\Collection;
use Pancake\HTTP\Route\Matcher;

class Router
{

    private $routes;

    public function __construct()
    {
        $this->routes = new Collection;
    }

    public function route(Request $request)
    {
        $path = $request->getPathInfo();

        $name = (new Matcher($this->routes))->match($request);

        return $this->routes->get($name);
    }

}