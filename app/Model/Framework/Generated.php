<?php

namespace App\Model\Framework;

class Generated
{
    /**
     * @return string
     */
    private static function getFileName():string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];
        $url = explode('/', $url);

        return array_pop($url) . '.html';
    }

    /**
     * @param string $content
     */
    public static function save($content = '')
    {
        $filePath = ROOT . '/generated/' . self::getFileName();

        $file = fopen($filePath, 'w');
        fwrite($file,$content);
        fclose($file);
    }
}