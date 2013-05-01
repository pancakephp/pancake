<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
class HomeController extends Controller
{

    public function index()
    {
        return View::make('hello');
    }

}