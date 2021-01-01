<?php

namespace App\Controller\Debug;

use App\Controller\AbstractController;

use App\Block\Debug\Magento2Debug;

class Magento2 extends AbstractController
{
    function __construct() {
        $this->Magento2DebugBlock = new Magento2Debug();
    }

    /**
     * @return bool
     */
    public function actionDebug()
    {
        $this->showContent($this->Magento2DebugBlock->toHtml($this->Magento2DebugBlock));

        return true;
    }
}