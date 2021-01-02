<?php

namespace App;

use App\Model\Parser\Xml\Routes as RoutesParser;

class Router 
{
    /**
     * @var string
     */
    private $uri;

    /**
     * @var RoutesParser
     */
    private $routesParser;

    /**
     * Router constructor.
     * @throws Exception
     */
    public function __construct()
	{
	    $this->uri = $this->getURI();
		$this->routesParser = new RoutesParser();

		$this->run();
	}

    /**
     * @return string
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {

            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
	{
        $routes = $this->routesParser->getRoutes();

	    if (array_key_exists($this->getURI(), $routes)) {
            $route = $routes[$this->getURI()];
            new $route['controller']($route['arguments']);
        } else {

        }
	}
}