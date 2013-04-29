<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */

namespace Pancake\HTTP;

use Pancake\Support\Str;

class Group
{
    private $domain;

    private $where = array();

    // Filters to be applied before and after the route call
    private $befores = array();
    private $afters = array();


    public function getDomainRegexPattern()
    {
        $patterns = $this->getWhere();
        $pattern = str_replace('.', '\\.', $this->getDomain());

        // Inject user provided regex via Route::group()->domain()->where();
        if ($patterns)
        {
            $search = array();
            $replace = array();

            foreach($patterns as $key => $value)
            {
                $search[] = '{'.trim($key).'}';
                $replace[] = '('.$value.')';
            }

            $pattern = str_replace($search, $replace, $pattern);
        }

        // Set any remaining regex
        if (Str::contains($pattern, '{'))
        {
            $pattern = preg_replace('/\{[^\}]+\}/', '(.*)', $pattern);
        }

        $pattern = '#^'.$pattern.'$#s';

        return $pattern;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function getWhere()
    {
        return $this->where;
    }

    public function domain($domain)
    {
        $this->domain = $domain;
        return $this;
    }

    public function where(Array $where)
    {
        $this->where = $where;
        return $this;
    }
}