<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

class Do_SomethingController // extends doController
{

    public function index()
    {
        return 'Hello '.$this->_world();
    }

    private function _world()
    {
        return 'World!';
    }

}