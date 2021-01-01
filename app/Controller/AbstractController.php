<?php

namespace App\Controller;

use App\Model\Framework\Generated as GeneratedModel;

class AbstractController
{
    /**
     * @param $content
     */
    protected function showContent($content)
    {
        GeneratedModel::save($content);

        echo $content;
    }

}