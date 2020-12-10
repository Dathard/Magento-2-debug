<?php

class AbstractBlock
{
    private static $headerTemplate = '/view/templates/header.phtml';
    private static $sidebarTemplate = '/view/templates/sidebar.phtml';
    private static $footerTemplate = '/view/templates/footer.phtml';

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
        ob_end_clean();

        $this->content = $content;
    }

}