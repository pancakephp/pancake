<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Foundation;

use Pancake\HTTP\Request;
use Pancake\Support\Aliases;
use Pancake\Config\Config;
use Pancake\Support\SplClassLoader;

class App extends Store
{
    const VERSION = '0.0.0';

    public function __construct()
    {
        $this->register(new ServiceProvider($this));
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
        $this->paths = $paths;
    }

    public function registerWithAutoloader($paths)
    {
        foreach ($paths as $path)
        {
            $loader = new SplClassLoader($path);
            $loader->register();
        }
    }

    public function registerAliases(Array $aliases)
    {
        $this->register(Aliases::getInstance($aliases));
    }

    private function register($provider)
    {
        $provider->register();
    }

}