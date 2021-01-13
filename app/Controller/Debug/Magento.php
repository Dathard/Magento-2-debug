<?php

namespace App\Controller\Debug;

use App\Controller\AbstractController;
use App\Block\Debug\Magento2Debug as Magento2DebugBlock;
use App\Model\Framework\View\Layout;

class Magento extends AbstractController
{
    protected $block;

    protected $layout;

    /**
     * Magento constructor.
     * @param array $data
     */
    function __construct(
        array $data = []
    ) {
        $this->layout = new Layout();

        switch ($data['magentoVersion']) {
            case 1:
//                $this->block = new Magento1DebugBlock();
                break;
            case 2:
                $this->block = new Magento2DebugBlock();
                break;
            default:
                $this->block = new Magento2DebugBlock();
        }

        $this->execute();
    }

    public function execute()
    {
//        $this->layout->setHandle('magento_2_debug');
//        $this->layout->executeRenderer();

        $this->showContent($this->block->toHtml($this->block));
    }
}