<?php
require_once './app/models/materialesModel.php';
require_once './app/views/materialesView.php';
require_once './app/models/productoModel.php';
require_once './app/models/clientesModel.php';
class materialesController{

    private $view;
    private $model;
    private $productModel;
    private $clientesModel;

    function __construct()
    {
     $this->view = new materialesView();
     $this->model = new materialesModel();   
     $this->productModel = new productoModel();
     $this->clientesModel = new clientesModel();

    }
    function showList() {
        $list = $this->model->getList();
        $productList = $this->productModel->getProducts();
        $clientList = $this->clientesModel->getClients();
        if(AuthHelper::checkLogin()){
            $this->view->showAdminList($list ,$productList, $clientList);
        }
        else{
            $this->view->showList($list,$clientList);
        }
    }
    function traerMonto($id){
        $producto = $this->productModel->showProduct($id);
        $precioUnitario = $producto->monto;
        return $precioUnitario;
    }
    function addItem() {
        AuthHelper::verify();
        // obtengo los datos del usuario
        $producto = $_POST['producto'];
        $unidades = $_POST['unidades'];
        $cliente = $_POST['cliente'];
        $precioUnitario = $this->traerMonto($producto);
        
        // validaciones
        if (empty($producto) || empty($unidades)|| empty($cliente)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }
        $montoTotal = $precioUnitario*$unidades;

        $idVenta = $this->model->insertItem($producto, $unidades,$montoTotal,$cliente);
        if ($idVenta) {
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showError("Error al insertar el pedido");
        }
    } 
    function removeItem($idVenta){
        AuthHelper::verify();
        $this->model->removeItem($idVenta);
        header('Location: ' . BASE_URL);

    }
    public function showClient($clienteId){
        
       $cliente = $this->model->showClient($clienteId);
            
      
       $this->view->showClient($cliente);
    }
    function editItem($idVenta){
    AuthHelper::verify();
    $product= $this->model->obtenerPedido($idVenta);
    $products= $this->productModel->getProducts();
    $clients = $this->clientesModel->getClients();
    $this->view->editItem($product,$products,$clients);
    }
    function actualizarItem($idVenta){
        AuthHelper::verify();
        $nuevoProducto = $_POST['producto'];
        $nuevasUnidades = $_POST['unidades'];
        $nuevoCliente = $_POST['cliente'];
        $nuevoPrecioUnitario = $this->traerMonto($nuevoProducto);
        $nuevoMontoTotal = $nuevoPrecioUnitario*$nuevasUnidades;


        $this->model->actualizarItem($idVenta,$nuevoProducto,$nuevasUnidades,$nuevoMontoTotal,$nuevoCliente);
        header('Location: ' . BASE_URL);
    }
    function filtrarItem(){
        AuthHelper::init();
        $products= $this->productModel->getProducts();
        $clients = $this->clientesModel->getClients();
        $list = $this->model->filtrarItem($_POST['filtroCliente']);
        if(empty($_POST['filtroCliente'])){
            $this->view->showError("Seleccione un cliente");
            return;
        }
        if(empty($list)){
            $this->view->showError("No existen compras con este cliente");
            return;
        }
        if(AuthHelper::checkLogin()){
            $this->view->showAdminList($list ,$products, $clients);
        }
        else{
            $this->view->showList($list,$clients);
        }

    }
    
}

?>