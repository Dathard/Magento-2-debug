<?php

class XML2Array {

    private static $xml = null;
    private static $encoding = 'UTF-8';

    public static function init($version = '1.0', $encoding = 'UTF-8', $format_output = true)
    {
        self::$xml = new DOMDocument($version, $encoding);
        self::$xml->formatOutput = $format_output;
        self::$encoding = $encoding;
    }

    public static function &createArray($input_xml)
    {
        $xml = self::getXMLRoot();
        if (is_string($input_xml)) {
            $parsed = $xml->loadXML($input_xml);
            if (!$parsed) {
                throw new Exception('[XML2Array] Error parsing the XML string.');
            }
        } else {
            if (get_class($input_xml) != 'DOMDocument') {
                throw new Exception('[XML2Array] The input XML object should be of type: DOMDocument.');
            }
            $xml = self::$xml = $input_xml;
        }
        $array[$xml->documentElement->tagName] = self::convert($xml->documentElement);
        self::$xml = null;

        return $array;
    }

    private static function convert($node)
    {
        $output = array();

        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
                $output['@cdata'] = trim($node->textContent);
                break;
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:
                for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
                    $child = $node->childNodes->item($i);
                    $v = self::convert($child);
                    if (isset($child->tagName)) {
                        $t = $child->tagName;

                        if (!isset($output[$t])) {
                            $output[$t] = array();
                        }
                        $output[$t][] = $v;
                    } else {
                        if($v !== '') {
                            $output = $v;
                        }
                    }
                }

                if(is_array($output)) {
                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v)==1) {
                            $output[$t] = $v[0];
                        }
                    }
                    if (empty($output)) {
                        $output = '';
                    }
                }

                if ($node->attributes->length) {
                    $a = array();
                    foreach ($node->attributes as $attrName => $attrNode) {
                        $a[$attrName] = (string) $attrNode->value;
                    }

                    if (!is_array($output)) {
                        if (!isset($output)) {
                            $output = array('value' => $output);
                        } else {
                            $output = [];
                        }
                    }
                    $output = array_merge($output, $a);
                }
                break;
        }

        return $output;
    }

    private static function getXMLRoot(){
        if (empty(self::$xml)) {
            self::init();
        }

        return self::$xml;
    }
}




$ssString = file_get_contents('layout/test.xml');



$ssString = preg_replace(
    '<argument.*name=[\'\"]([A-Za-z0-9]+)[\'\"].*type=[\'\"]([A-Za-z0-9]+)[\'\"].*value=[\'\"]([A-Za-z0-9]+)[\'\"].*/>',
    '$1 type="$2" value="$3" /',
    $ssString
);


$asArray2 = new App\Model\Parser\Xml\AbstractParser();

$asArray2 = $asArray2->createArray($ssString);
echo "<pre>";
print_r($asArray2);
exit;