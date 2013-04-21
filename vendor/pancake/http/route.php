<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Str;
use Pancake\Support\ClassLoader;

class Route
{

    private $_method;
    private $_pattern;
    private $_action;
    private $_domain;
    private $_alias;

    public function __construct($method, $pattern, $action)
    {
        $this->_method  = $method;
        $this->_pattern = $pattern;
        $this->_action  = $action;
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

        $call = $this->_call();

        echo __METHOD__.' : '.__LINE__;
        echo '<pre>'.print_r($call, 1).'</pre>';
        die;

        // Call Afters

        return new Response('Hello world!');
    }

    private function _call()
    {
        return call_user_func_array($this->_getCallable(), $this->_getParameters());
    }

    private function _getCallable()
    {
        if(is_callable($this->getAction()))
        {
            return $this->getAction();
        }

        list($controller, $method) = explode('@', $this->_action);

        require_once APP.'/controllers/'.str_replace('.', '/', $controller).'.php';

        // Normalize the classname
        $controller = Str::studly(Str::afterLast($controller, '.').' controller');

        return array((new $controller), $method);
    }

    private function _getParameters()
    {
        return array();
    }

    // Fucking horrible.
    public function getKey()
    {
        $domain  = isset($this->_domain) ? $this->_domain.' ' : '';
        $method  = !($this->_method === Request::ANY) ? $this->_method.' ' : '';
        $pattern = trim($this->_pattern) === '/' ? '/' : rtrim(trim($this->_pattern), '/');

        return $domain.$method.$pattern;
    }

    public function getMethod()
    {
        return strtoupper($this->_method);
    }

    public function getPattern()
    {
        return $this->_pattern;
    }

    // Returns the pattern, if it's a static one (i.e. without dynamic parameters)
    // a dynamic pattern will return false
    public function getStaticPattern()
    {
        return !Str::contains($this->getPattern(), '{')
            ? $this->_pattern
            : false;
    }

    // TODO: this
    public function getRegexPattern()
    {
        return '#^/$#s';
    }

    public function getAlias()
    {
        return $this->_alias;
    }

    public function getAction()
    {
        return $this->_action;
    }

}