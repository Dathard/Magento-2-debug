<?php

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