<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
class HTML
{

    public static function escape($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }

}