<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support;

class Sack
{

    public $values = array();

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

}