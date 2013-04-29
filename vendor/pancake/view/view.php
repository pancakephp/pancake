<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\View;

class View
{

    public function make($view)
    {
        return 'View::make('.$view.')';
    }

}