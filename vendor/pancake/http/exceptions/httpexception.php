<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Exceptions;

abstract class HttpException extends \Exception
{

    public function __construct($message = null, $code = 0, $previous = null){

    }

}