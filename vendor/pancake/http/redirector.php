<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\HTTP;

class Redirector
{

    public function __construct(Route $route)
    {

    }

    public function params(Array $params)
    {
        return $this;
    }

    public function now()
    {
        echo 'Perform the redirect...<br/>';
        echo __METHOD__.' : '.__LINE__.'<pre>'.print_r($this, 1).'</pre>'; die;
    }

}