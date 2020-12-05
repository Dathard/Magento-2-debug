<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Підключення файлів системи
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/components/Autoload.php');

// 3. Виклик Router

ob_start();

$router = new Router();
$router->run();

$content = ob_get_contents();
ob_end_clean();

echo $content;