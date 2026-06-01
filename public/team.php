<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/app.php';
require_once APP_ROOT . '/app/Helpers/functions.php';
require_once APP_ROOT . '/app/Controllers/TeamController.php';

$controller = new TeamController();
$controller->index();
