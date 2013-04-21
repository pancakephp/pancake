<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Sack;

class Request
{

    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const ANY = 'ANY';

    public $query; // $_GET
    public $request; // $_POST
    public $server; // $_SERVER
    public $files; // $_FILES
    public $session; // Fom session handler
    public $headers; // Headers
    public $parameters; // From the URI e.g. /{id}/

    private $method = null;

    public function __construct()
    {
        $this->server = new Sack($_SERVER);
    }

    public function getURI()
    {
        // Normalized URI
    }

    // http://site.dev/about        returns '/about'
    public function getPathInfo()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return urldecode($uri);
    }

    public function getQueryString()
    {
        // $_GET
    }

    public function getProtocol()
    {
        // http || https
    }

    public function getPort(){ }

    public function isSecure()
    {

    }

    public function setMethod()
    {
        // Set verb
    }

    public function getMethod()
    {
        if($this->method === null)
        {
            $this->method = $this->server->get('request_method', self::GET);
        }

        return $this->method;
    }


}