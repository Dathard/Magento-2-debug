<?php

namespace App\Model\Parser\Xml;

use App\Model\Framework\Loader;

class Routes
{
    const ROUTES_CONFIG_FILE = '/config/routes.xml';

    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->loader = new Loader();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getRoutes()
    {
        if (!sizeof($this->routes)) {
            $routes = [];

            foreach ($this->loader->loadXmlFile(self::ROUTES_CONFIG_FILE) as $route) {
                $attributes = $this->loader->getAttributes($route);

                if (!array_key_exists($attributes['name'], $routes)) {
                    $routes[$attributes['name']] = $attributes['path'];
                } else {
                    throw new Exception('Route "'. $attributes['name'] .'" has been declared more than once');
                }
            }

            $this->routes = $routes;
        }

        return $this->routes;
    }
}