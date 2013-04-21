<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

class Response
{

    private $_content;

    public function __construct($content = '', $status = 200, $headers = array())
    {
        $this->setContent($content);
        $this->setStatusCode($status);
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    public function sendHeaders()
    {
        // Set headers

        return $this;
    }

    public function sendContent()
    {
        $out = fopen('php://output', 'wb');
        fwrite($out, $this->_content);
        fclose($out);

        return $this;
    }

    public function setContent($content)
    {
        $this->_content = (string) $content;
    }

    public function setStatusCode($status)
    {
        $this->_status_code = (int) $status;
    }

}