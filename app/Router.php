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

        foreach ($routes as $uriPattern => $data) {
            if (preg_match("~$uriPattern~", $this->uri)) {

                if (array_key_exists(RoutesParser::DYNAMIC_ARGUMENTS_TAG, $data)) {
                    $data = $this->routesParser->addDynamicArguments($uriPattern, $data, $this->uri);
                }

                new $data['controller']($data['arguments']);
            }

        }

	}
}