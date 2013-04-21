<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Str;
use Pancake\Support\SplClassLoader;

use ReflectionClass;

class Route
{

    private $method;
    private $pattern;
    private $action;
    private $domain;
    private $alias;

    public function __construct($method, $pattern, $action)
    {
        $this->method  = $method;
        $this->pattern = $pattern;
        $this->action  = $action;
    }

    public function alias($alias)
    {
        //..
    }

    public function filter($filter)
    {
        //..
    }

    public function where(Array $regexes)
    {
        //..
    }

    public function run()
    {
        // Call Befores

        $call = $this->callAction();

        // Call Afters

        // Return the response
        return new Response($call);
    }

    private function callAction()
    {
        return call_user_func_array($this->getCallback(), $this->getParameters());
    }

    private function getCallback()
    {
        if(is_callable($this->getAction()))
        {
            return $this->getAction();
        }

        return $this->createControllerCallback($this->getAction());
    }

    private function createControllerCallback($action)
    {
        $loader = new SplClassLoader(APP.'/controllers');
        $loader->register();

        list($controller, $method) = explode('@', $action);

        return array((new $controller), $method);
    }

    private function getParameters()
    {
        return array();
    }

    // Fucking horrible.
    public function getKey()
    {
        $domain  = isset($this->domain) ? $this->domain.' ' : '';
        $method  = !($this->method === Request::ANY) ? $this->method.' ' : '';
        $pattern = trim($this->pattern) === '/' ? '/' : rtrim(trim($this->pattern), '/');

        return $domain.$method.$pattern;
    }

    public function getMethod()
    {
        return strtoupper($this->method);
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    // Returns the pattern, if it's a static one (i.e. without dynamic parameters)
    // a dynamic pattern will return false
    public function getStaticPattern()
    {
        return !Str::contains($this->getPattern(), '{')
            ? $this->pattern
            : false;
    }

    // TODO: this
    public function getRegexPattern()
    {
        return '#^/$#s';
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getAction()
    {
        return $this->action;
    }

}