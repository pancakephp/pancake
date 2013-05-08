<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Exceptions;

use Pancake\HTTP\Exceptions\HttpException;

class NotFoundException extends HttpException
{

    public function __construct($message = null, $code = 0, $previous = null)
    {
        $message = $message ? $message : '404 Not Found';
        parent::__construct(404, $message, $code, $previous);
    }

}