<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\HTTP\Route\Collection;

class Redirect
{
    private $routes;

    public function __construct(Collection $routes)
    {
        $this->routes = $routes;
    }

    public function to($alias)
    {
        // echo __METHOD__.' : '.__LINE__;
        // echo '<pre>'.print_r($this, 1).'</pre>';

        // die($alias);
    }

}