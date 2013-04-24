<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Foundation;

use Pancake\HTTP\Request;
use Pancake\HTTP\Router;
use Pancake\Support\Aliases;
use Pancake\Support\Facades\Facade;

class App extends Store
{
    const VERSION = '0.0.0';

    public function __construct()
    {
        $this->request = new Request;
        $this->router  = new Router;
    }

    public function run()
    {
        $response = $this->dispatch($this->request);
        $response->send();
    }

    public function shutdown()
    {
        //..
    }

    private function dispatch(Request $request)
    {
        $route = $this->router->route($request);

        // TODO: Global Befores

        $response = $route->run($request);

        // TODO: Global Afters

        return $response;
    }

    public function setPaths(Array $paths)
    {
        $this->offsetSet('paths', $paths);
    }

    public function registerAliases(Array $aliases)
    {
        $instance = Aliases::getInstance($aliases);

        $instance->registerLoader();

        $this->aliases = $instance->getAliases();
    }

    public function registerFacade()
    {
        Facade::setApp($this);
    }

}