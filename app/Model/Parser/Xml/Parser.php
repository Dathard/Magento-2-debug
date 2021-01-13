<?php

namespace App\Model\Parser\Xml;

class Parser
{
    private $xml = null;

    private $encoding = 'UTF-8';

    /**
     * Parser constructor.
     * @param string $version
     * @param string $encoding
     * @param bool $format_output
     */
    public function __construct(
        $version = '1.0',
        $encoding = 'UTF-8',
        $format_output = true
    ) {
        $this->init($version, $encoding, $format_output);
    }

    /**
     * @param string $version
     * @param string $encoding
     * @param bool $format_output
     */
    public function init(
        $version = '1.0',
        $encoding = 'UTF-8',
        $format_output = true
    ) {
        $this->xml = new \DOMDocument($version, $encoding);
        $this->xml->formatOutput = $format_output;
        $this->encoding = $encoding;
    }

    /**
     * @param $input_xml
     * @return mixed
     */
    public function parseToArray($input_xml)
    {
        $xml = $this->getXMLRoot();
        if (is_string($input_xml)) {
            $parsed = $xml->loadXML($input_xml);
            if (!$parsed) {
                throw new Exception('[XML2Array] Error parsing the XML string.');
            }
        } else {
            if (get_class($input_xml) != 'DOMDocument') {
                throw new Exception('[XML2Array] The input XML object should be of type: DOMDocument.');
            }
            $xml = $this->xml = $input_xml;
        }
        $array[$xml->documentElement->tagName] = $this->convert($xml->documentElement);
        $this->xml = null;

        return $array;
    }

    /**
     * @param $node
     * @return array|mixed|string
     */
    private function convert($node)
    {
        $output = [];

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

                if (is_array($output)) {
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

    /**
     * @return null
     */
    private function getXMLRoot()
    {
        if (empty($this->xml)) {
            self::init();
        }

        return $this->xml;
    }
}