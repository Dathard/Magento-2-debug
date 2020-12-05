<?php

class PhpParserModel
{
    private $replacementRules = [];

    function __construct() {
        $this->addReplacementRules();
    }

    public function parseText($string = '')
    {
        $replacementRules = $this->getReplacementRules($string);

        foreach ($replacementRules as $rule) {
            $string = str_replace(array_shift($rule), array_pop($rule), $string);
        }

        return $string;
    }

    public function getReplacementRules($string = null)
    {
        if ($string === null) {
            return $this->replacementRules;
        }

        $replacementRules = $this->replacementRules;

        preg_match_all ('([\"\'](?<=[\"\'])[^\"\']+[\'\"])', $string, $matches);

        foreach ( array_shift($matches) as $element) {
            $replacementRules[] = [$element, '<span style="color: #DD0000">'.$element.'</span>'];
        }

        return $replacementRules;
    }

    private function addReplacementRules()
    {
        $this->replacementRules[] = ['if ', '<span style="color: #007700">if</span>'];
        $this->replacementRules[] = ['(', '<span style="color: #007700">(</span>'];
        $this->replacementRules[] = [')', '<span style="color: #007700">)</span>'];
        $this->replacementRules[] = ['{', '<span style="color: #007700">{</span>'];
        $this->replacementRules[] = ['}', '<span style="color: #007700">}</span>'];
        $this->replacementRules[] = ['[', '<span style="color: #007700">[</span>'];
        $this->replacementRules[] = [']', '<span style="color: #007700">]</span>'];
        $this->replacementRules[] = [';', '<span style="color: #007700">;</span>'];
        $this->replacementRules[] = [' = ', '<span style="color: #007700"> = </span>'];
        $this->replacementRules[] = [',', '<span style="color: #007700">,</span>'];
        $this->replacementRules[] = ['->', '<span style="color: #007700">-></span>'];
        $this->replacementRules[] = ['&&', '<span style="color: #007700">&&</span>'];
        $this->replacementRules[] = [' :', '<span style="color: #007700">:</span>'];
        $this->replacementRules[] = ['::', '<span style="color: #007700">::</span>'];
        $this->replacementRules[] = ['...', '<span style="color: #007700">...</span>'];
        $this->replacementRules[] = ['public', '<span style="color: #007700">public</span>'];
        $this->replacementRules[] = ['function', '<span style="color: #007700">function</span>'];
        $this->replacementRules[] = ['=>', '<span style="color: #007700">=></span>'];
        $this->replacementRules[] = ['   ', '&nbsp;&nbsp;&nbsp;'];
        $this->replacementRules[] = [["\r\n", "\r", "\n"], '<br>'];
    }
}