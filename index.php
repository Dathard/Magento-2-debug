<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));

require_once(ROOT.'/vendor/autoload.php');





$Magento2 = new App\Controller\Debug\Magento2();

$Magento2->actionDebug();


//ob_start();

//$router = new Router();
//$router->run();