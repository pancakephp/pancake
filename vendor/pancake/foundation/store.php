<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Foundation;

abstract class Store implements \ArrayAccess
{

    protected $store = array();

    protected $aliases = array();

    public function __get($key)
    {
        return $this[$key];
    }

    public function __set($key, $value)
    {
        $this[$key] = $value;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            $this->store[] = $value;
        }
        else
        {
            $this->store[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->store[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->store[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->store[$offset]) ? $this->store[$offset] : null;
    }

}