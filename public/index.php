<?php
ob_start();

session_start();

require_once $_SERVER['DOCUMENT_ROOT']."/app/ozarko/autoload.php";

use ozarko\library\Dependency as Dependency;
use ozarko\library\Router as Router;
use ozarko\library\CheckSession as CheckSession;

$di = new Dependency(); 

$di->set("db", DB);

$di->set("check", new CheckSession($di));

Router::getRoute($di)->run();

ob_end_flush();
