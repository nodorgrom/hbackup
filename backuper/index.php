<?php 
// FRONT CONTROLLER
// FRONT CONTROLLER
// FRONT CONTROLLER
// FRONT CONTROLLER

// Общие настройки

ini_set('display_errors',1);
error_reporting(E_ALL);

// Подключение необходимых файлов
define('ROOT', dirname(__FILE__)); // /www/backuper
require_once ROOT . '/components/functions.php';
require_once ROOT . '/components/Router.php';
require_once ROOT . '/components/Db.php';


// установка и соединение с БД








// Вызов Router
$router = new Router();
$router->run();
