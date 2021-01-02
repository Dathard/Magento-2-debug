<?php

namespace App\Helper;

class Data
{
    public function changeType($value, $type)
    {
        switch ($type) {
            case 'int':
                $value = (int)$value;
                break;
            case 'string':
                $value = (string)$value;
                break;
            case 'bool':
                $value = (bool)$value;
                break;
            default:
                throw new Exception('type "'. $type .'" is invalid');
        }

        return $value;
    }
}