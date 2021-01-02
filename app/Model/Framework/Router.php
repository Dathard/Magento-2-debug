<?php

namespace App\Model\Framework;

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
		foreach ($this->routesParser->getRoutes() as $uriPattern => $path) {

			if (preg_match("~$uriPattern~", $this->uri)) {

				// Отримуєм внутрішній шлях із зовнішнього відповідно правилу
				$internalRoute = preg_replace("~$uriPattern~", $path, $this->uri);

				// Якщо запит співпадає, визначити який контролер і action обробляють запит
				$segments = explode('/', $internalRoute);

				$controllerName = array_shift($segments).'Controller';
				$controllerName = ucfirst($controllerName);

				$actionName = 'action'.ucfirst(array_shift($segments));

				$parameters = $segments;

				$controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

				if (file_exists($controllerFile)) {
					include_once($controllerFile);
				}

				$controllerObject = new $controllerName;

				if ( method_exists($controllerObject, $actionName) ) {
					$result = call_user_func_array(array($controllerObject, $actionName), $parameters);

					if ( $result === 404 ) {
						include_once(ROOT . '/controllers/ErrorController.php');

						ErrorController::actionNotFound();
					}

					if ($result != null) {
						break;
					}
				} else {
					include_once(ROOT . '/controllers/ErrorController.php');
				}
			}
		}
	}

}