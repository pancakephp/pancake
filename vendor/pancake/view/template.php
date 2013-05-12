<?php
/**
 * @author      Aaron Lord <aaronlord1@gmail.com>
 * @copyright   (c) 2013 Aaron Lord
 */
namespace Pancake\View;

use Pancake\Support\Str;

class Template
{

    private $template;

    private $prefnx = '@';

    // Regular echo
    private $interpolate = array('{{', '}}');

    // Escaped echo
    private $escapolate = array('{{{', '}}}');

    private $compilers = array(
        'Layout',
        'Echos',
        'Openings',
        'Static',
        'Includes',
        'Yields',
        'Sections',
    );

    public function __construct($filename)
    {
        $this->template = $this->compile(file_get_contents($filename));
    }

    public function __toString()
    {
        return $this->template;
    }

    public function compile($value)
    {
        foreach ($this->compilers as $compiler)
        {
            $value = $this->{'compile'.$compiler}($value);
        }

        return $value;
    }

    private function compileLayout($value)
    {
        if(!Str::startsWith($value, $this->prefnx.'layout'))
            return $value;

        $lines = preg_split('/(\r?\n)/', $value);

        $pattern = $this->functionRegex('layout');

        $lines[] = preg_replace($pattern, '$1'.$this->prefnx.'include($2)', array_shift($lines));

        return implode("\r\n", $lines);
    }

    private function compileEchos($value)
    {
        return $this->compileRegularEchos($this->compileEscapedEchos($value));
    }

    private function compileRegularEchos($value)
    {
        $pattern = sprintf('/%s\s*(.+?)\s*%s/s', $this->interpolate[0], $this->interpolate[1]);

        return preg_replace($pattern, '<?php echo $1; ?>', $value);
    }

    private function compileEscapedEchos($value)
    {
        $pattern = sprintf('/%s\s*(.+?)\s*%s/s', $this->escapolate[0], $this->escapolate[1]);

        return preg_replace($pattern, '<?php echo HTML::escape($1); ?>', $value);
    }

    private function compileOpenings($value)
    {
        return $this->compileRegularOpenings($this->compileForelseOpening($value));
    }

    private function compileRegularOpenings($value)
    {
        $pattern = $this->functionRegex('(if|elseif|foreach|for|while)');

        return preg_replace($pattern, '$1<?php $2 ($3): ?>', $value);
    }

    private function compileForelseOpening($value)
    {
        $pattern = '/(?<!\w)(\s*)'.$this->prefnx.'forelse\s*\(\s*((.*)\s*as.*)\s*\)/';

        return preg_replace($pattern, '$1<?php if (isset($3) && !empty($3)): foreach ($2): ?>', $value);
    }

    private function compileStatic($value)
    {
        return str_replace(
            array(
                $this->prefnx.'else',
                $this->prefnx.'empty',
                $this->prefnx.'endif',
                $this->prefnx.'endforelse',
                $this->prefnx.'endforeach',
                $this->prefnx.'endfor',
                $this->prefnx.'endwhile',
                $this->prefnx.'stop',
                $this->prefnx.'show',
                $this->prefnx.'parent',
            ),
            array(
                '<?php else: ?>',
                '<?php endforeach; else: ?>',
                '<?php endif; ?>',
                '<?php endif; ?>',
                '<?php endforeach; ?>',
                '<?php endfor; ?>',
                '<?php endwhile; ?>',
                '<?php $this->closeSection(); ?>',
                '<?php $this->yieldSection(); ?>',
                '@parent'
            ),
            $value
        );
    }

    private function compileIncludes($value)
    {
        $pattern = $this->functionRegex('include');

        $replacement = '$1<?php echo $this->make($2, Arr::without(get_defined_vars(), array("__data", "__file"))); ?>';

        return preg_replace($pattern, $replacement, $value);
    }

    private function compileYields($value)
    {
        $pattern = $this->functionRegex('yield');

        return preg_replace($pattern, '$1<?php echo $this->yieldContent($2); ?>', $value);
    }

    private function compileSections($value)
    {
        $pattern = $this->functionRegex('section');

        return preg_replace($pattern, '$1 <?php $this->openSection($2); ?>', $value);
    }

    private function functionRegex($function)
    {
        return '/(?<!\w)(\s*)'.$this->prefnx.$function.'\s*\(\s*(.*)\s*\)/';
    }

    private function plainRegex($function)
    {
        return '/(?<!\w)(\s*)'.$this->prefnx.$function.'(\s*)/';
    }
}