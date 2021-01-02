<?php

define('ROOT', dirname(__FILE__));
//require_once(ROOT.'/config/routes.xml');

$path = ROOT.'/app/etc/config.xml';

$config = simplexml_load_file($path);

$configuration = [];

foreach ($config->children() as $section) {
    $groups = [];

    foreach ($section->children() as $group) {
        $fields = [];

        foreach ($group->children() as $field) {

            $attributes = getField($field);

            switch ($attributes['type']) {
                case 'int':
                    $value = (int)$attributes['value'];
                    break;
                case 'string':
                    $value = (string)$attributes['value'];
                    break;
                case 'bool':
                    $value = (bool)$attributes['value'];
                    break;
                default:
                    throw new Exception('Error');
            }

            $fields[$attributes['id']] = $value;
        }

        $groups[$group->getName()] = $fields;
    }

    $configuration[$section->getName()] = $groups;
}

function getField($tag)
{
    $attributes = [];

    foreach($tag->attributes() as $name => $value) {
        $attributes[$name] = $value->__toString();
    }

    return $attributes;
}

print_r($configuration);

die();


ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');

ob_start();

$router = new Router();
$router->run();