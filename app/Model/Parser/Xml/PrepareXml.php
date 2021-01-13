<?php

namespace App\Model\Parser\Xml;

class PrepareXml
{
    /**
     * @param string $xml
     * @return string
     */
    public function compress($xml = '')
    {
        return preg_replace(
            [
                '/\>[^\S ]+/s',
                '/[^\S ]+\</s',
                '/(\s)+/s',
                '/<!--(?![^<]*noindex)(.*?)-->/'
            ],
            [
                '>',
                '<',
                '\\1',
                ''
            ],
            $xml
        );
    }

    /**
     * @param string $xml
     * @return string
     */
    public function prepareContainerTag($xml = '')
    {
        return preg_replace(
            '<container.*name=[\'\"]([A-Za-z0-9]+)[\'\"].*\>(.*)\</container>isU',
            '$1> $2 </$1',
            $xml
        );
    }

    /**
     * @param string $xml
     * @return string
     */
    public function prepareArgumentsTag($xml = '')
    {
        return preg_replace(
            '<argument.*name=[\'\"]([A-Za-z0-9]+)[\'\"].*type=[\'\"]([A-Za-z0-9]+)[\'\"].*value=[\'\"]([A-Za-z0-9]+)[\'\"].*/>',
            '$1 type="$2" value="$3" /',
            $xml
        );
    }
}