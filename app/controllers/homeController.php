<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
class HomeController // extends Controller
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