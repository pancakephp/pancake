<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\Support;

class SplClassLoader
{
    private $ext = '.php';
    private $namespace_seperator = '\\';
    private $include_path;

    public function __construct($include_path = null)
    {
        $this->include_path = $include_path;
    }

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    public function loadClass($classname)
    {
        $ds = DIRECTORY_SEPARATOR;
        $classname = ltrim($classname, $this->namespace_seperator);
        $filename  = '';
        $namespace = '';

        if ($pos = strrpos($classname, $this->namespace_seperator))
        {
            $namespace = substr($classname, 0, $pos);
            $classname = substr($classname, $pos + 1);
            $filename  = str_replace($this->namespace_seperator, $ds, $namespace).$ds;
        }

        $filename .= str_replace('_', $ds, $classname) . $this->ext;

        $filename = (!($this->include_path === null) ? $this->include_path.$ds : '').$filename;

        !is_file($filename) ?: require $filename;
    }
}