<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Foundation;

use Closure;
use Pancake\HTTP\Router;

abstract class Store implements \ArrayAccess
{

    protected $store = array();

    protected $instances = array();

    protected $aliases = array();

    public function __set($key, $value)
    {
        $this[$key] = $value;
    }

    public function __get($key)
    {
        return $this[$key];
    }

    public function share(Closure $closure)
    {
        $app =& $this;
        return function() use ($closure, $app)
        {
            static $object = false;

            if(!$object)
            {
                $object = $closure($app);
            }

            return $object;
        };
    }

    public function set($key, $value)
    {
        $this->store[$key] = $value;
    }

    public function get($key)
    {
        $key = $this->getAlias($key);

        if(isset($this->instances[$key]))
        {
            return $this->instances[$key];
        }

        if(isset($this->store[$key]))
        {
            if(is_callable($this->store[$key]))
            {
                return $this->instances[$key] = call_user_func($this->store[$key]);
            }

            return $this->store[$key];
        }

        return $key;
    }

    protected function getAlias($alias)
    {
        return isset($this->aliases[$alias]) ? $this->aliases[$alias] : $alias;
    }

    public function offsetGet($key) {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetExists($key)
    {
        return isset($this->store[$key]);
    }

    public function offsetUnset($key)
    {
        unset($this->store[$key]);
    }

}