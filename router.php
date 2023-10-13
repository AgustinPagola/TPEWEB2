<?php
require_once './app/controllers/materialesController.php';
require_once './app/controllers/authController.php';
require_once './app/controllers/aboutController.php';
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');
$action = 'home'; // accion por defecto
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}
// parsea la accion para separar accion real de parametros
$params = explode('/', $action);
switch ($params[0]) {
    case 'home':
        $controller = new materialesController();
        $controller->showList();
        break;
 
    case 'add':
        $controller = new materialesController();
        $controller->addItem();
        break;

    case 'remove':
        $controller = new materialesController();
        $controller ->removeItem($params[1]);

    case 'about':
        $controller = new aboutController();
        $controller->showAbout();
        break;
    
   
    case 'login':
        $controller = new authController();
        $controller->showLogin(); 
        break;

    case 'auth':
        $controller = new authController();
        $controller->auth();
        break;

    case 'logout':
        $controller = new authController();
        $controller->logout();
        break;
    
    case 'client':
        $controller = new materialesController();
        $controller->showClient($params[1]);
        break;

    default: 
        echo "404 Page Not Found";
        break;
    }    
?>