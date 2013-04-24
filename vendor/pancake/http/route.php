<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Str;
use Pancake\Support\SplClassLoader;

class Route
{
    private $path = '/';

    private $host = '';

    private $methods = array();

    private $groups = array();

    public function __construct($methods, $path)
    {
        $this->setMethods($methods);
        $this->setPath($path);
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function setMethods($method)
    {
        $this->methods = explode('|', $method);
    }

    public function setGroups($groups)
    {
        $this->groups = (array) $groups;
    }

    public function getName()
    {
        return $this->getMethod().' '.$this->getPath();
    }

    public function getMethod()
    {
        return implode('|', $this->methods);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function alias($name)
    {
        // $this->setAlias($name);
    }
}