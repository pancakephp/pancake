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

    private $_routes;

    public function __construct()
    {
        $this->_routes = new Collection;
    }

    public function route(Request $request)
    {
        $path = $request->getPathInfo();

        $name = (new Matcher($this->_routes))->match($request);

        return $this->_routes->get($name);
    }

}