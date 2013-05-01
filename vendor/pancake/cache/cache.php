<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\Cache;

class Cache
{

    public static function put($file, $contents)
    {
        $tmp = $file.'.tmp';

        if (($fhandle = fopen($tmp, 'w')) === false)
            return false;

        fwrite($fhandle, $contents);
        fclose($fhandle);
        rename($tmp, $file);

        return $file;
    }

    public static function get($file, $expiration)
    {
        if (!is_file($file))
            return false;

        if (
            // Forced expiration
            ($expiration === true) ||
            // Original file is newer than the cache
            (is_file($expiration) && (filemtime($expiration) > filemtime($file)))
        ) {
            unlink($file);
            return false;
        }

        return $file;
    }

}