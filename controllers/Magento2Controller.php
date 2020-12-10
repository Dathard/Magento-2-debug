<?php

class Magento2Controller extends AbstractController
{

    public function actionDebug()
    {
        $block = new Magento2DebugBlock();
        $this->showContent($block->toHtml($block));

        return true;
    }

}