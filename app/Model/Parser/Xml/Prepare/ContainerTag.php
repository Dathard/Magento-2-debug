<?php

namespace App\Model\Parser\Xml\Prepare;

class ContainerTag
{
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
}