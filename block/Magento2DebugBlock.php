<?php

class Magento2DebugBlock extends AbstractBlock
{
    private static $template = '/view/templates/magento2/debug.phtml';

    private $parserBlock;

    function __construct() {
        $this->parserBlock = new ParserBlock();
    }

    public function parsePhpCode($string = '', $letCopy = false)
    {
        return $this->parserBlock->parseCode($string, 'php', $letCopy);
    }

    public function toHtml($block)
    {
        parent::beforeToHtml();
        require_once(ROOT . self::$template);
        parent::afterToHtml();
    }
}