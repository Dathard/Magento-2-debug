<?php

class AbstractBlock
{
    /**
     * @var string
     */
    private static $headerTemplate = '/view/templates/header.phtml';

    /**
     * @var string
     */
    private static $sidebarTemplate = '/view/templates/sidebar.phtml';

    /**
     * @var string
     */
    private static $footerTemplate = '/view/templates/footer.phtml';

    /**
     * @var string
     */
    protected $content = '';

    protected function beforeToHtml()
    {
        ob_start();
        require_once(ROOT . self::$headerTemplate);
        require_once(ROOT . self::$sidebarTemplate);
        echo '<div id="content">';
    }

    protected function afterToHtml()
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

}