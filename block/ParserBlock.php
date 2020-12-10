<?php

class ParserBlock
{
    private static $phpTemplate = '/view/templates/code/parse/php.phtml';

    private $phpParserModel;

    function __construct() {
        $this->phpParserModel = new PhpParserModel();
    }

    public function parseCode($code = '', $type = 'php', $letCopy = false):string
    {
        $processedСode = $this->phpParserModel->parseText($code);

        ob_start();
        $this->toHtml($code, $processedСode, $type, $letCopy);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    private function toHtml($code = '', $processedСode = '', $type = 'php', $letCopy = false)
    {
        if ($type === 'php'){
            require (ROOT . self::$phpTemplate);
        }
    }
}