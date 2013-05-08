<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Exceptions;

use Pancake\HTTP\Exception\HttpException;

class BadRequestException extends HttpException
{

    public function __construct($message = null, $code = 0, $previous = null)
    {
        $message = $message ? $message : '400 Bad Request';
        parent::__construct(400, $message, $code, $previous);
    }

}