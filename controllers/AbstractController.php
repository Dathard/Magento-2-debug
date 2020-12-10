<?php

class AbstractController
{
    protected function showContent($content)
    {
        GeneratedModel::save($content);

        echo $content;
    }

}