<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Sacks\HeaderSack;

class Response
{
    private $content;

    private $status_code;

    private $headers;

    public function __construct($content = '', $status = 200, $headers = array())
    {
        $this->headers = new HeaderSack($headers);
        $this->setContent($content);
        $this->setStatusCode($status);
    }

    public function __toString()
    {
        return $this->content;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    public function header($key, $value)
    {
        $this->headers->set($key, $value);

        return $this;
    }

    public function sendHeaders()
    {
        if(headers_sent())
            return $this;

        foreach ($this->headers as $name => $value)
        {
            header($name.': '.$value);
        }

        return $this;
    }

    public function sendContent()
    {
        $out = fopen('php://output', 'wb');
        fwrite($out, $this->content);
        fclose($out);

        return $this;
    }

    public function setContent($content)
    {
        $this->content = (string) $content;
    }

    public function setStatusCode($status)
    {
        $this->status_code = (int) $status;
    }

}