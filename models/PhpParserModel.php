<?php

class PhpParserModel
{
    /**
     * @var array
     */
    private $replacementRules = [];

    /**
     * PhpParserModel constructor.
     */
    function __construct() {
        $this->addReplacementRules();
    }

    /**
     * @param string $string
     * @return mixed|string|string[]
     */
    public function parseText($string = '')
    {
        $replacementRules = $this->getReplacementRules($string);

        foreach ($replacementRules as $rule) {
            $string = str_replace(array_shift($rule), array_pop($rule), $string);
        }

        return $string;
    }

    /**
     * @param null $string
     * @return array
     */
    public function getReplacementRules($string = null)
    {
        if ($string === null) {
            return $this->replacementRules;
        }

        $replacementRules = $this->replacementRules;

        preg_match_all ('([\"\'](?<=[\"\'])[^\"\']+[\'\"])', $string, $matches);

        foreach ( array_shift($matches) as $element) {
            $replacementRules[] = [$element, '<span class="s2">'.$element.'</span>'];
        }

        return $replacementRules;
    }

    private function addReplacementRules()
    {
        $this->replacementRules[] = [' if ', '<span class="kd">if</span>'];
        $this->replacementRules[] = ['(', '<span class="kd">(</span>'];
        $this->replacementRules[] = [')', '<span class="kd">)</span>'];
        $this->replacementRules[] = ['{', '<span class="kd">{</span>'];
        $this->replacementRules[] = ['}', '<span class="kd">}</span>'];
        $this->replacementRules[] = ['[', '<span class="kd">[</span>'];
        $this->replacementRules[] = [']', '<span class="kd">]</span>'];
        $this->replacementRules[] = [';', '<span class="kd">;</span>'];
        $this->replacementRules[] = [' = ', '<span class="kd"> = </span>'];
        $this->replacementRules[] = [',', '<span class="kd">,</span>'];
        $this->replacementRules[] = ['->', '<span class="kd">-></span>'];
        $this->replacementRules[] = ['&&', '<span class="kd">&&</span>'];
        $this->replacementRules[] = [' :', '<span class="kd">:</span>'];
        $this->replacementRules[] = ['::', '<span class="kd">::</span>'];
        $this->replacementRules[] = ['...', '<span class="kd">...</span>'];
        $this->replacementRules[] = ['public', '<span class="kd">public</span>'];
        $this->replacementRules[] = ['function', '<span class="kd">function</span>'];
        $this->replacementRules[] = ['=>', '<span class="kd">=></span>'];
        $this->replacementRules[] = ['   ', '&nbsp;&nbsp;&nbsp;'];
        $this->replacementRules[] = [["\r\n", "\r", "\n"], '<br>'];
    }
}