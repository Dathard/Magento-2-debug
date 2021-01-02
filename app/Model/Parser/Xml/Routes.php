<?php

namespace App\Model\Parser\Xml;

use App\Model\Parser\Xml\AbstractParser;
use App\Model\Framework\Loader;
use App\Helper\Data as DataHelper;

class Routes extends AbstractParser
{
    const ROUTES_CONFIG_FILE = '/app/etc/routes.xml';

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

    /**
     * @return array
     */
    public function getRoutes()
    {
        if (!sizeof($this->routes)) {
            $routes = [];

            foreach ($this->loader->loadXmlFile(self::ROUTES_CONFIG_FILE) as $route) {
                $attributes = $this->getAttributes($route);

                if (!array_key_exists($attributes['frontName'], $routes)) {
                    $params['controller'] = $attributes['controller'];
                    $params['arguments'] = [];
                    $arguments = $route->children();

                    foreach ($arguments->children() as $argument){
                        $argumentData = $this->getAttributes($argument);

                        $params['arguments'][$argumentData['name']] = $this->dataHelper->changeType($argumentData['value'], $argumentData['type']); ;
                    }

                    $routes[$attributes['frontName']] = $params;
                } else {
                    throw new Exception('Route "'. $attributes['frontName'] .'" has been declared more than once');
                }
            }

            $this->routes = $routes;
        }

        return $this->routes;
    }
}