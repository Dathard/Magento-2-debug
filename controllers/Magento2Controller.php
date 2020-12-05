<?php

class Magento2Controller
{

    public function actionDebug()
    {
        $block = new Magento2DebugBlock();
        $block->toHtml($block);

        return true;
    }

}