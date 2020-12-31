<?php

class Magento2DebugBlock extends AbstractBlock
{
    /**
     * @var string
     */
    private static $template = '/view/templates/magento2/debug.phtml';

    private $parserBlock;

    /**
     * Magento2DebugBlock constructor.
     */
    function __construct() {
        $this->parserBlock = new ParserBlock();
    }

    /**
     * @param string $string
     * @param false $letCopy
     * @return string
     */
    public function parsePhpCode($string = '', $letCopy = false):string
    {
        return $this->parserBlock->parseCode($string, 'php', $letCopy);
    }

    /**
     * @param $block
     * @return string
     */
    public function toHtml($block):string
    {
        parent::beforeToHtml();
        require_once(ROOT . self::$template);
        parent::afterToHtml();

        return $this->content;
    }
}