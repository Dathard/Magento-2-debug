<?php

namespace App\Model\Framework\View;

use App\Model\Framework\Loader;
use App\Model\Parser\Xml\Parser as XmlParser;

class Layout
{
    const LAYOUT_DIRECTORY = '\\view\\layout\\';
    const TEMPLATES_DIRECTORY = '\\view\\templates\\';

    private $handle;

    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var XmlParser
     */
    private $xmlParser;

    public function __construct()
    {
        $this->loader = new Loader();
        $this->xmlParser = new XmlParser();
    }

    /**
     * @param string $handle
     */
    public function setHandle($handle)
    {
        $this->handle = (string)$handle;
    }

    /**
     * @return string
     */
    public function executeRenderer()
    {
        if (is_null($this->handle)) {
            return '';
        }

        $layout = $this->loader->loadFileContent(self::LAYOUT_DIRECTORY . $this->handle . '.xml');


        $layout = preg_replace(
            array(
                '/\>[^\S ]+/s',
                '/[^\S ]+\</s',
                '/(\s)+/s',
                '/<!--(?![^<]*noindex)(.*?)-->/'
            ),
            array(
                '>',
                '<',
                '\\1',
                ''
            ),
            $layout
        );

        $layout = $this->xmlParser->prepareArgumentsTag($layout);
        $layout = $this->xmlParser->prepareContainerTag($layout);
        $layout = $this->xmlParser->parseToArray($layout);

        var_dump($layout);

        die();
    }
}