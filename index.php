<?php
define('ROOT', dirname(__FILE__));

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once(ROOT.'/vendor/autoload.php');

require_once(ROOT.'/configParser.php');

die();
require_once(ROOT.'/vendor/autoload.php');

new App\Router();