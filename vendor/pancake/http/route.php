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

    private $host = '';

    private $methods = array();

    private $groups = array();

    private $befores = array();

    private $afters = array();

    private $options = array(
        // Set within App/Routes, allows for easy urling
        'alias' => null,

        // Set within App/Routes, an array of user defined patterns
        'where' => array(),

        // Set within Router, Action/Callback to run
        'action' => null,

        // Set within $this->getRegexPattern, the regex pattern used to match the url
        'pattern' => null,

        'before' => array(),

        'after' => array(),
    );

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
        $callback = $this->getCallback($this->getOption('action'));
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

    private function getParameters($path)
    {
        preg_match($this->getOption('pattern'), $path, $matches);
        return array_splice($matches, 1);
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
        // TODO add domain
        return $this->getMethod().' '.$this->getPath();
    }

    public function getMethod()
    {
        return implode('|', $this->methods);
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getPath()
    {
        return $this->path;
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
        $patterns = $this->getOption('where');
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

        $this->setOption('pattern', $pattern);

        return $pattern;
    }

    public function getOption($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : null;
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

    public function setGroups($groups)
    {
        $this->groups = (array) $groups;
        return $this;
    }

    public function setFilters(Array $before, Array $after)
    {
        $this->befores = $before;
        $this->afters = $after;
    }

    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }

    public function alias($alias)
    {
        return $this->setOption('alias', $alias);
    }

    public function where(Array $where)
    {
        return $this->setOption('where', $where);
    }

    public function before($filter)
    {
        return $this->setOption('before', (array) $filter);
    }

    public function after($filter)
    {
        return $this->setOption('after', (array) $filter);
    }

}