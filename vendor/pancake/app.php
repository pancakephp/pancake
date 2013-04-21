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

        echo '<h3>Matching route!</h3>';
        echo '<pre>'.print_r($route, 1).'</pre>';
        die;
    }

    public function shutdown()
    {
        // Teardown
    }

}