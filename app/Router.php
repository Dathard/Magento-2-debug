<?php

namespace App;

use App\Model\Parser\Xml\Routes as RoutesParser;
use App\Model\Framework\App\Request as RequestModel;

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
     * @var RequestModel
     */
    private $request;

    /**
     * Router constructor.
     * @throws Exception
     */
    public function __construct()
	{
	    $this->routesParser = new RoutesParser();
        $this->request = RequestModel::getInstance();

		$this->run();
	}

    public function run()
	{
        $routes = $this->routesParser->getRoutes();
        $uri = $this->request->getUri();

        foreach ($routes as $uriPattern => $data) {
            if (preg_match("~$uriPattern~", $uri)) {

                if (array_key_exists(RoutesParser::DYNAMIC_ARGUMENTS_TAG, $data)) {
                    $data = $this->routesParser->addDynamicArguments($uriPattern, $data, $this->uri);
                }

                new $data['controller']($data['arguments']);
            }
        }

	}
}