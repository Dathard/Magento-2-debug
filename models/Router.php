<?php 

class Router 
{
    const ROUTES_CONFIG_FILE = '/config/routes.xml';

    /**
     * @var string
     */
    private $uri;

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
	    $this->uri = $this->getURI();
		$this->routes = $this->getAllRoutes();
	}

    /**
     * @param $path
     * @return SimpleXMLElement
     */
    public function loadXmlFile($path)
    {
        return simplexml_load_file(ROOT . $path);
    }

    /**
     * @param $tag
     * @return array
     */
    private function getAttributes($tag)
    {
        $attributes = [];

        foreach($tag->attributes() as $name => $value) {
            $attributes[$name] = $value->__toString();
        }

        return $attributes;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getAllRoutes()
    {
        $routes = [];

        foreach ($this->loadXmlFile(self::ROUTES_CONFIG_FILE) as $route) {
            $attributes = $this->getAttributes($route);

            if (!array_key_exists($attributes['name'], $routes)) {
                $routes[$attributes['name']] = $attributes['path'];
            } else {
                throw new Exception('Route "'. $attributes['name'] .'" has been declared more than once');
            }
        }

        return $routes;
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
		foreach ($this->routes as $uriPattern => $path) {

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