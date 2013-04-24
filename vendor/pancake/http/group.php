<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

class Group
{
    public $filters = array();

    public function filter($name)
    {
        $this->filters[] = $name;

        return $this;
    }

    public function domain()
    {
        return $this;
    }
}