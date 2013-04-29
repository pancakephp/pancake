<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\Support\Sacks;

class ServerSack extends Sack
{

    public function __construct(Array $server)
    {
        $server = array_replace(array(
            'SERVER_NAME'          => 'localhost',
            'SERVER_PORT'          => 80,
            'HTTP_HOST'            => 'localhost',
            'HTTP_USER_AGENT'      => 'Pancake/0.X',
            'HTTP_ACCEPT'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_LANGUAGE' => 'en-us,en;q=0.5',
            'HTTP_ACCEPT_CHARSET'  => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'REMOTE_ADDR'          => '127.0.0.1',
            'SCRIPT_NAME'          => '',
            'SCRIPT_FILENAME'      => '',
            'SERVER_PROTOCOL'      => 'HTTP/1.1',
            'REQUEST_TIME'         => time(),
        ), $server);

        $server['PATH_INFO'] = parse_url($server['REQUEST_URI'], PHP_URL_PATH);

        parent::__construct($server);
    }
}