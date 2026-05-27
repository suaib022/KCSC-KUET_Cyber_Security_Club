<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/app.php';
require_once APP_ROOT . '/app/Helpers/functions.php';
require_once APP_ROOT . '/app/Controllers/JoinController.php';

$controller = new JoinController();

// Route based on request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store();
} else {
    $controller->index();
}
