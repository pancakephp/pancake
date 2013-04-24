<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support;

class Aliases
{
    protected $aliases;

    protected $registered = false;

    protected static $instance;

    public function __construct($aliases)
    {
        $this->aliases = (array) $aliases;
    }

    public static function getInstance($aliases)
    {
        if(!static::$instance)
        {
            static::$instance = new self($aliases);
        }

        $aliases = array_merge(static::$instance->getAliases(), $aliases);

        static::$instance->setAliases($aliases);

        return static::$instance;
    }

    public function registerLoader()
    {
        if(!$this->registered)
        {
            spl_autoload_register(array($this, 'loadAlias'), true, true);
            $this->registered = true;
        }
    }

    public function setAliases($aliases)
    {
        $this->aliases = (array) $aliases;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function loadAlias($alias)
    {
        if(isset($this->aliases[$alias]))
        {
            return class_alias($this->aliases[$alias], $alias);
        }
    }
}