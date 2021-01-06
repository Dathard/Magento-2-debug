<?php

namespace App\Model\Parser\Xml;

use App\Model\Framework\App\ObjectManager\Singleton;

class AbstractParser extends Singleton
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