<?php

namespace App\Model\Parser\Xml;

class AbstractParser
{
    /**
     * @param $tag
     * @return array
     */
    protected function getAttributes($tag)
    {
        $attributes = [];

        foreach($tag->attributes() as $name => $value) {
            $attributes[$name] = $value->__toString();
        }

        return $attributes;
    }
}