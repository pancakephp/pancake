<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\Support;

use Pancake\Support\Str;

class ClassLoader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'loadClass'), true);
    }

    public static function listen()
    {
        return new self();
    }

    public function loadClass($classname)
    {
        $filename = self::_getFilename($classname);

        $filename = VENDOR.'/'.$filename;

        if (!file_exists($filename))
            throw new \Exception($classname.' ~ File does not exist : '.$filename);

        require_once $filename;
    }

    private static function _getFilename($classname, $ds = '_')
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

        $filename .= str_replace($ds, DIRECTORY_SEPARATOR, $classname) . '.php';

        return $filename;
    }

}