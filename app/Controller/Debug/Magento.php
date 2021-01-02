<?php

namespace App\Controller\Debug;

use App\Controller\AbstractController;
use App\Block\Debug\Magento2Debug as Magento2DebugBlock;

class Magento extends AbstractController
{
    protected $block;

    /**
     * Magento constructor.
     * @param array $data
     */
    function __construct(
        array $data = []
    ) {
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
        $this->showContent($this->block->toHtml($this->block));
    }
}