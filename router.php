<?php
require_once './app/controllers/materialesController.php';
require_once './app/controllers/authController.php';
require_once './app/controllers/productoController.php';
require_once './app/controllers/clientesController.php';
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
        break;
    case 'edit':
        $controller = new materialesController();
        $controller ->editItem($params[1]); 
        break;
    case 'client':
        $controller = new materialesController();
        $controller->showClient($params[1]);
        break;
    case 'actualizarItem':
        $controller = new materialesController();
        $controller->actualizarItem($params[1]);
        break;
    case 'filtrar':
        $controller = new materialesController();
        $controller->filtrarItem();
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
    



    case 'products':
        $controller = new productoController();
        $controller->showProducts();
        break;
    case 'addProduct':
        $controller = new productoController();
        $controller->addProduct();
        break;
    case 'removeProduct':
        $controller = new productoController();
        $controller ->removeProduct($params[1]);
        break;
    case 'product':
        $controller = new productoController();
        $controller ->showProduct($params[1]);
        break;
    case 'editProduct':
        $controller = new productoController();
        $controller ->editProduct($params[1]); 
        break;
    case 'actualizarProducto':
        $controller = new productoController();
        $controller ->actualizarProducto($params[1]);
        break;   



    case 'clients':
        $controller = new clientesController();
        $controller->showClients();
        break;
    case 'addClient':
        $controller = new clientesController();
        $controller->addClient();
        break;
    case 'removeClient':
        $controller = new clientesController();
        $controller ->removeClient($params[1]);
        break;
    case 'clientEdit':
        $controller = new clientesController();
        $controller ->clientEdit($params[1]); 
        break;
    case 'actualizarCliente':
        $controller = new clientesController();
        $controller ->actualizarCliente($params[1]);
        break;
    default: 
        echo "404 Page Not Found";
        break;
    }    
?>