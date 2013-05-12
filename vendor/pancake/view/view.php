<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\View;

use Pancake\View\Template;
use Pancake\Cache\Cache;

class View
{
    private $path;

    private $cache;

    private $sections = array();

    private $section_stack = array();

    public function __construct($app)
    {
        $this->path  = $app['paths']['views'];
        $this->cache = $app['paths']['storage'].'/views';
    }

    public function make($file, $data = array())
    {
        $file = str_replace('.', '/', $file);
        $file = $this->path.'/'.$file.'.php';
        $cache = $this->cache.'/'.md5($file);

        if (!($stored = Cache::get($cache, $file)))
        {
            $stored = Cache::put($cache, new Template($file));
        }

        return $this->render($stored, $data);
    }

    private function render($__file, Array $__data)
    {
        ob_start();
        extract($__data);
        include $__file;
        return ob_get_clean();
    }

    // Yeild the contents of a section
    private function yieldContent($section)
    {
        return isset($this->sections[$section]) ? $this->sections[$section] : '';
    }

    private function yieldSection()
    {
        return $this->yieldContent($this->closeSection());
    }

    private function openSection($section)
    {
        ob_start();
        $this->section_stack[] = $section;
    }

    private function closeSection()
    {
        $last = array_pop($this->section_stack);
        $this->extendSection($last, ob_get_clean());
        return $last;
    }

    private function extendSection($section, $content)
    {
        if (isset($this->sections[$section]))
        {
            $content = str_replace('@parent', $content, $this->sections[$section]);
        }

        $this->sections[$section] = $content;
    }

}