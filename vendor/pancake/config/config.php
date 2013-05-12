<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Config;

use Pancake\Support\Sacks\Sack;

class Config extends Sack
{

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function loadFile($files)
    {
        $app =& $this->app;

        foreach ((array) $files as $file)
        {
            $pathinfo = pathinfo($file);
            $this->register($pathinfo['filename'], require $file);
        }
    }

    public function register($key, $config)
    {
        $this->set($key, (array) $config);
    }

}