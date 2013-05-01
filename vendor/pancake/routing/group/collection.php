<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\Routing\Group;

use Pancake\Routing\Group;
use Pancake\Routing\Route;

class Collection implements \IteratorAggregate, \Countable
{
    private $groups = array();

    private $stack = array();

    public function open()
    {
        $this->groups[] = new Group();

        end($this->groups);
        $index = key($this->groups);

        // Create a reference on the stack to the instance.
        $this->stack[] = $index;
    }

    public function close()
    {
        array_pop($this->stack);
    }

    public function instance()
    {
        return end($this->groups);
    }

    public function addRoute(Route $route)
    {
        if($group = $this->instance())
        {
            $group->addRoute($route);
        }
    }

    public function updateRoutes()
    {
        foreach($this->groups as $group)
        {
            $group->updateRoutes();
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->groups);
    }

    public function count()
    {
        return count($this->groups);
    }
}