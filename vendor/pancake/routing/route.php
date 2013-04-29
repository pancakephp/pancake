<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Routing;

use Closure;
use Pancake\HTTP\Request;
use Pancake\HTTP\Response;
use Pancake\Support\Str;
use Pancake\Support\SplClassLoader;

class Route
{
    private $host = '';

    private $path = '/';

    // HTTP methods/verps that apply to the route
    private $methods = array();

    // Set within Router, Action/Callback to run
    private $action;

    // Groups applied to the filter
    private $groups = array();

    // Set within App/Routes, allows for easy urling
    private $alias;

    // Set within App/Routes, an array of user defined patterns
    private $where = array();

    // Filters to be applied before and after the route call
    private $befores = array();
    private $afters = array();

    private $parameters;

    public function __construct($methods, $path)
    {
        $this->setMethods($methods);
        $this->setPath($path);
    }

    public function run(Request $request)
    {
        $response = $this->callBeforeFilters();

        if (!$response)
        {
            $response = $this->callAction($request);

            $this->callAfterFilters();
        }

        return new Response($response);
    }

    public function callAction(Request $request)
    {
        $callback   = $this->getCallback($this->getAction());
        $parameters = $this->getParameters($request->getPathInfo());

        return call_user_func_array($callback, $parameters);
    }

    private function createControllerCallback($action)
    {
        list($controller, $method) = explode('@', '\\'.$action);
        return array((new $controller), $method);
    }

    private function getCallback($action)
    {
        if(is_callable($action))
        {
            return $action;
        }

        return $this->createControllerCallback($action);
    }

    private function callBeforeFilters()
    {
        foreach($this->befores as $callback)
        {
            $response = $this->callFilter($callback);

            if (!is_null($response))
                return $response;
        }
    }

    private function callAfterFilters()
    {
        foreach($this->afters as $callback)
        {
            $this->callFilter($callback);
        }
    }

    private function callFilter(Closure $callback)
    {
        return call_user_func($callback);
    }

    public function getName()
    {
        return ($this->getHost() ? $this->getHost().' ' : '')
            .$this->getMethod().' '.$this->getPath();
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getMethod()
    {
        return implode('|', $this->methods);
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    private function getWhere()
    {
        return $this->where;
    }

    public function getBefores()
    {
        return $this->befores;
    }

    public function getAfters()
    {
        return $this->afters;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    // Returns the pattern, if it's a static one (i.e. without dynamic parameters)
    // a dynamic pattern will return false
    public function getStaticPattern()
    {
        return !Str::contains($this->getPath(), '{')
            ? $this->getPath()
            : false;
    }

    public function getStaticPrefix()
    {
        return Str::beforeFirst($this->getPath(), '{');
    }

    public function getRegexPattern()
    {
        return $this->generateRegex($this->getPath());
    }

    // TODO: Named matches
    public function generateRegex($pattern)
    {
        $patterns = $this->getWhere();

        // Inject user provided regex via Route::get()->where();
        if ($patterns)
        {
            foreach((array) $patterns as $key => $value)
            {
                $search[] = '{'.trim($key).'}';
                $replace[] = '('.$value.')';
            }

            $pattern = str_replace($search, $replace, $pattern);
        }

        // Set any remaining regex
        if (Str::contains($pattern, '{'))
        {
            $pattern = preg_replace('/\{[^\}]+\}/', '(.*)', $pattern);
        }

        $pattern = '#^'.$pattern.'$#s';

        return $pattern;
    }

    public function getHostStaticPattern()
    {
        return $this->getHost() && !Str::contains($this->getHost(), '{')
            ? $this->getHost()
            : false;
    }

    public function getHostStaticPrefix()
    {
        return Str::beforeFirst($this->getHost(), '{');
    }

    public function getHostRegexPattern()
    {
        return $this->generateRegex($this->getHost());
    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function setMethods($method)
    {
        $this->methods = explode('|', $method);
        return $this;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function setGroups($groups)
    {
        $this->groups = (array) $groups;
        return $this;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function setWhere(Array $where)
    {
        $this->where = array_merge($this->getWhere(), $where);
        return $this;
    }

    public function setBefore($before)
    {
        $this->befores = (array) $before;
        return $this;
    }

    public function setAfter($after)
    {
        $this->afters = (array) $after;
        return $this;
    }

    public function setParameters(Array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function alias($alias)
    {
        return $this->setAlias($alias);
    }

    public function where(Array $where)
    {
        return $this->setWhere($where);
    }

    public function before($filter)
    {
        return $this->setBefore($filter);
    }

    public function after($filter)
    {
        return $this->setAfter($filter);
    }

}