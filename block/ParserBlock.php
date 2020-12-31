<?php

class ParserBlock
{
    /**
     * @var string
     */
    private static $phpTemplate = '/view/templates/code/parse/php.phtml';

    private $phpParserModel;

    /**
     * ParserBlock constructor.
     */
    function __construct() {
        $this->phpParserModel = new PhpParserModel();
    }

    /**
     * @param string $code
     * @param string $type
     * @param false $letCopy
     * @return string
     */
    public function parseCode($code = '', $type = 'php', $letCopy = false):string
    {
        $processedСode = $this->phpParserModel->parseText($code);

        ob_start();
        $this->toHtml($code, $processedСode, $type, $letCopy);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @param string $code
     * @param string $processedСode
     * @param string $type
     * @param false $letCopy
     */
    private function toHtml($code = '', $processedСode = '', $type = 'php', $letCopy = false)
    {
        if ($type === 'php'){
            require (ROOT . self::$phpTemplate);
        }
    }
}