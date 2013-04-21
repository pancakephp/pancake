<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Str;

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
        $this->_alias = $alias;
    }

    public function getAlias()
    {
        return $this->_alias;
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

    public function getRegexPattern()
    {
        return '#^/$#s';
    }

}