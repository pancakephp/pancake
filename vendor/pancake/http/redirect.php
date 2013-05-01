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

    public function to($alias)
    {
        return $this;
    }

    public function now()
    {
        return;
    }
}