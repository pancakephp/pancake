<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake;

use Pancake\HTTP\Request;
use Pancake\HTTP\Router;

class App
{

    const VERSION = '0.0.0';

    public function __construct()
    {
        $this->request = new Request;
    }

    public function run()
    {
        $route = (new Router)->route($this->request);

        // Global Befores

        $response = $route->run();

        // Global Afters

        $response->send();
    }

    public function shutdown()
    {
        //..
    }

}