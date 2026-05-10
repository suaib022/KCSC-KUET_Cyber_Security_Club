<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/app.php';
require_once APP_ROOT . '/app/Helpers/functions.php';
require_once APP_ROOT . '/app/Controllers/HomeController.php';

$controller = new HomeController();
$controller->index();
