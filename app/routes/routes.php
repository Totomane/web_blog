<?php
declare(strict_types=1);
require __DIR__ . '/../controllers/PageController.php';

$routes = [
    'home' => 'home',
    'about' => 'about',
    'contact' => 'contact',
    'project' => 'project',
    'create' => 'create',
    'login' => 'login',
    'register' => 'register',
    'logout' => 'logout',
    'delete_project' => 'delete_project',
];

$action = $_GET['action'] ?? 'home';
$id = isset($_GET['id']) ? (int) $_GET['id'] : null;

$controller = new PageController();

if (array_key_exists($action, $routes)) {
    $method = $routes[$action];
    if (method_exists($controller, $method)) {
        $controller->$method($id);
        return;
    }
}

$controller->error(404, "Action non trouvée habibi");
