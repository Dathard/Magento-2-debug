<?php

namespace App\Model\Parser\Xml;

use App\Model\Parser\Xml\Parser as XmlParser;
use App\Model\Framework\Loader;
use App\Helper\Data as DataHelper;

class Routes extends XmlParser
{
    const ROUTES_CONFIG_FILE = '/app/etc/routes.xml';
    const DYNAMIC_ARGUMENTS_TAG = 'dynamicArguments';

    /**
     * @var array
     */
    private static $instances = [];

    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var DataHelper
     */
    private $dataHelper;

    /**
     * @var array
     */
    private $routes;

    /**
     * Routes constructor.
     */
    public function __construct()
    {
        $this->loader = new Loader();
        $this->dataHelper = new DataHelper();
    }

    protected function getAttributes($tag)
    {
        $attributes = [];

        foreach($tag->attributes() as $name => $value) {
            $attributes[$name] = $value->__toString();
        }

        return $attributes;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        if (!sizeof($this->routes)) {
            $routes = [];

            foreach ($this->loader->loadXmlFile(self::ROUTES_CONFIG_FILE) as $route) {
                $attributes = $this->getAttributes($route);

                if (!array_key_exists($attributes['pattern'], $routes)) {
                    $params['controller'] = $attributes['controller'];

                    foreach ($route->children() as $argumentsCategory)
                    {
                        $arguments = [];

                        foreach ($argumentsCategory->children() as $argument){
                            $argumentData = $this->getAttributes($argument);
                            if (isset($argumentData['type'])) {
                                $arguments[$argumentData['name']] = $this->dataHelper->changeType($argumentData['value'], $argumentData['type']);
                            } else {
                                $arguments[$argumentData['name']] = $argumentData['value'];
                            }
                        }

                        $params[$argumentsCategory->getName()] = $arguments;
                    }

                    $routes[$attributes['pattern']] = $params;
                } else {
                    throw new Exception('Route "'. $attributes['pattern'] .'" has been declared more than once');
                }
            }

            $this->routes = $routes;
        }

        return $this->routes;
    }

    /**
     * @param string $uriPattern
     * @param array $data
     * @param string $uri
     * @return array
     */
    public function addDynamicArguments($uriPattern, $data, $uri)
    {
        $replacementPattern = implode('/', $data[self::DYNAMIC_ARGUMENTS_TAG]);
        $dynamicArgumentsSegment = preg_replace("~$uriPattern~", $replacementPattern, $uri);
        $dynamicArguments = explode('/', $dynamicArgumentsSegment);

        foreach ($data[self::DYNAMIC_ARGUMENTS_TAG] as $argumentName => $mask)
        {
            $data['arguments'][$argumentName] = array_shift($dynamicArguments);
        }

        unset($data[self::DYNAMIC_ARGUMENTS_TAG]);

        return $data;
    }
}