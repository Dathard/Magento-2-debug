<?php

namespace App\Model\Parser\Xml\Prepare;

class ArgumentsTag
{
    /**
     * @param string $xml
     * @return string
     */
    public function prepareArgumentsTag($xml = '')
    {


        $xml = preg_replace(
            '<container.*name=[\'\"]([A-Za-z0-9]+)[\'\"].*\>(.*)\</container>isU',
            '$1> $2 </$1',
            $xml
        );



        return preg_replace(
            '<argument.*name=[\'\"]([A-Za-z0-9]+)[\'\"].*type=[\'\"]([A-Za-z0-9]+)[\'\"].*value=[\'\"]([A-Za-z0-9]+)[\'\"].*/>',
            '$1 type="$2" value="$3" /',
            $xml
        );
    }
}