<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP\Request;

use Pancake\HTTP\Request;

class RouteContext
{

    private $path_info;
    private $method;
    private $host;
    private $scheme;

    public function __construct(Request $request)
    {
        $this->setPathInfo($request->getPathInfo());
        $this->setMethod($request->getMethod());
        $this->setHost($request->getHost());
        $this->setScheme($request->getScheme());
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setPathInfo($path_info)
    {
        $this->path_info = $path_info;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }

}