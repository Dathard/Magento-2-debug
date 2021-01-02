<?php

namespace App\Model\Framework;

class Loader
{
    /**
     * @param $path
     * @return SimpleXMLElement
     */
    public function loadXmlFile($path)
    {
        return simplexml_load_file(ROOT . $path);
    }

}