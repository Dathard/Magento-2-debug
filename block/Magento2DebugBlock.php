<?php

class Magento2DebugBlock
{
    private $phpParserModel;

    function __construct() {
        $this->phpParserModel = new PhpParserModel();
    }

    public function parsePhpCode($string = null)
    {
        return '++++++11';

        return $this->phpParserModel->parseText($string);
    }

    public static function toHtml($block)
    {
        return require_once(ROOT . '/view/templates/magento2/debug.php');
    }
}