<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Sacks\ServerSack;
use Pancake\Support\Sacks\Sack;
use Pancake\HTTP\Request\RouteContext;

class Request
{

    const GET    = 'get';
    const POST   = 'post';
    const PUT    = 'put';
    const PATCH  = 'patch';
    const DELETE = 'delete';
    const ANY    = 'get|post|put|patch|delete';

    public $query;      // $_GET
    public $request;    // $_POST
    public $server;     // $_SERVER
    public $cookie;     // $_COOKIE
    public $files;      // $_FILES
    public $session;    // $_SESSION
    public $headers;    // Headers
    public $parameters; // URI Params

    private $method;

    public function __construct()
    {
        $this->query   = new Sack($_GET);
        $this->request = new Sack($_POST);
        $this->server  = new ServerSack($_SERVER);
        $this->cookie  = new Sack($_COOKIE);
        $this->files   = new Sack($_FILES);
        // $this->session = new Sack($_SESSION);
    }

    // Normalized URI
    public function getURI(){ }

    // http://site.dev/about        returns '/about'
    public function getPathInfo()
    {
        return $this->server->get('PATH_INFO', '/');
    }

    // $_GET
    public function getQueryString(){ }

    public function getScheme(){
        return $this->isSecure() ? 'https' : 'http';
    }

    public function getHost(){
        return $this->server->get('SERVER_NAME');
    }

    public function getPort(){ }

    public function getMethod()
    {
        if($this->method === null)
        {
            $this->method = $this->server->get('request_method', static::GET);
        }

        return $this->method;
    }

    public function getRouteContext()
    {
        return new RouteContext($this);
    }

    // FIXME: Perform isSecure check
    public function isSecure(){
        return false;
    }

    public function setMethod(){ }

}