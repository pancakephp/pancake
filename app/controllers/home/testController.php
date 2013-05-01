<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
class Home_TestController extends HomeController
{

    public function redirect()
    {
        Redirect::to('home')->now();

        // Redirect->params(array('name' => 'Aaron', 'age' => 21))->now();
    }
}