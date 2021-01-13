<?php

namespace App\Model\Framework;

class Loader
{
    /**
     * @param $path
     * @return string|null
     */
    public function loadFileContent($path)
    {
        try {
            $content = file_get_contents(ROOT . $path);
        } catch (\Exception $e) {
            $content = null;
        }

        return $content;
    }

    /**
     * @param $path
     * @return SimpleXMLElement
     */
    public function loadXmlFile($path)
    {
        return simplexml_load_file(ROOT . $path);
    }
}