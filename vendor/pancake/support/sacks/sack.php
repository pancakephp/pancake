<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support\Sacks;

class Sack implements \ArrayAccess, \IteratorAggregate, \Countable
{

    private $values = array();

    public function __construct(array $array)
    {
        $this->set($array);
    }

    public function set($keys, $value = null)
    {
        if (is_array($keys))
        {
            foreach ($keys as $key => $value)
            {
                $this->set($key, $value);
            }
        }
        else
        {
            $this->values[$keys] = $value;
        }
    }

    public function get($key, $default = null)
    {
        if (isset($this->values[$key]))
        {
            return $this->values[$key];
        }

        return $default;
    }

    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    public function offsetExists($key)
    {
        return isset($this->values[$key]);
    }

    public function offsetUnset($key)
    {
        unset($this->values[$key]);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->values);
    }

    public function count()
    {
        return count($this->values);
    }

}