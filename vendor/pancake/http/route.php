<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Closure;
use Pancake\Support\Str;
use Pancake\Support\SplClassLoader;

class Route
{
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
        $callback = $this->getCallback($this->getAction());
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
        return $this->getMethod().' '.$this->getPath();
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
        $patterns = $this->getWhere();
        $pattern = $this->getPath();

        // Inject user provided regex via Route::get()->where();
        if ($patterns)
        {
            $search = array();
            $replace = array();

            foreach($patterns as $key => $value)
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

    public function getDomainRegexPattern()
    {
       foreach($this->getGroups() as $group)
       {
           if ($group->getDomain())
               return $group->getDomainRegexPattern();
       }
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

    public function setBefore(Array $before)
    {
        $this->befores = $before;
        return $this;
    }

    public function setAfter(Array $after)
    {
        $this->afters = $after;
        return $this;
    }

    public function setParameters(Array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function alias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function where(Array $where)
    {
        $this->where = $where;
        return $this;
    }

    public function before($filter)
    {
        $this->before = (array) $filter;
        return $this;
    }

    public function after($filter)
    {
        $this->after = (array) $filter;
        return $this;
    }

}