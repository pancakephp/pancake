<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\Support;

class ClassLoader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'loadClass'), true, true);
    }

    public static function listen()
    {
        return new self();
    }

    public function loadClass($classname)
    {
        $classname = ltrim($classname, '\\');
        $filename  = '';
        $namespace = '';

        if ($pos = strrpos($classname, '\\'))
        {
            $namespace = substr($classname, 0, $pos);
            $classname = substr($classname, $pos + 1);
            $filename  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
        }

        $filename .= str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
        $filename = VENDOR.'/'.$filename;

        if(!file_exists($filename))
            throw new \Exception($classname.' ~ File does not exist : '.$filename);

        require_once $filename;
    }
}