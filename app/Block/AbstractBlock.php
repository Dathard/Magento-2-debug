<?php

namespace App\Block;

use App\Block\Parser as ParserBlock;

class AbstractBlock
{
    /**
     * @var string
     */
    public $template = '';

    /**
     * @var string
     */
    protected static $headerTemplate = '/view/templates/header.phtml';

    /**
     * @var string
     */
    protected static $sidebarTemplate = '/view/templates/sidebar.phtml';

    /**
     * @var string
     */
    protected static $footerTemplate = '/view/templates/footer.phtml';

    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var ParserBlock
     */
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

    private function beforeToHtml()
    {
        ob_start();
        require_once(ROOT . self::$headerTemplate);
        require_once(ROOT . self::$sidebarTemplate);
        echo '<div id="content">';
    }

    private function afterToHtml()
    {
        echo '</div>';
        require_once(ROOT . self::$footerTemplate);

        $content = ob_get_contents();



//        $content = preg_replace(
//            array(
//                '/\>[^\S ]+/s',
//                '/[^\S ]+\</s',
//                '/(\s)+/s',
//                '/<!--(?![^<]*noindex)(.*?)-->/'
//            ),
//            array(
//                '>',
//                '<',
//                '\\1',
//                ''
//            ),
//            $content
//        );



        ob_end_clean();

        $this->content = $content;
    }

    /**
     * @param $block
     * @return string
     */
    public function toHtml($block):string
    {
        $this->beforeToHtml();
        require_once(ROOT . $this->template);
        $this->afterToHtml();

        return $this->content;
    }
}