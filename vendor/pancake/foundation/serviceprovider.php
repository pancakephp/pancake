<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\Foundation;

use Pancake\Support\Str;

class ServiceProvider
{
    protected $private;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function register()
    {
        $methods = get_class_methods($this);

        foreach($methods as $method)
        {
            if(Str::startsWith($method, 'register') && !($method == 'register'))
            {
                $this->$method();
            }
        }
    }

    private function registerRouter()
    {
        $this->app->router = $this->app->share(function($app)
        {
            return new \Pancake\HTTP\Router($app);
        });
    }

    private function registerRequest()
    {
        $this->app->request = $this->app->share(function($app)
        {
            return new \Pancake\HTTP\Request;
        });
    }
}