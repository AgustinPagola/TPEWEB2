<?php
require_once './app/models/productoModel.php';
require_once './app/views/productoView.php';
class productoController{

    private $view;
    private $model;

    function __construct()
    {
     $this->view = new productoView();
     $this->model = new productoModel();   
    }
    function showProducts() {
        $list = $this->model->getProducts();
        if(AuthHelper::checkLogin()){
            $this->view->showAdminProductsList($list);
        }
        else{
            $this->view->showProductsList($list);
        }
    }
    function addProduct(){
        AuthHelper::verify();
            // obtengo los datos del usuario
            $producto = $_POST['producto'];
            $monto = $_POST['precio'];
            $descripcion = $_POST['descripcion'];
            
            // validaciones
            if (empty($producto) || empty($monto)|| empty($descripcion)) {
                $this->view->showError("Debe completar todos los campos");
                return;
            }
    
            $idProducto = $this->model->insertProduct($producto, $monto, $descripcion);
            if ($idProducto) {
                header('Location: ' . BASE_URL .'products');
            } else {
                $this->view->showError("Error al insertar el pedido");            
        }  
    }
    function removeProduct($idProducto){
        AuthHelper::verify();
        $this->model->removeProduct($idProducto);
        header('Location: ' . BASE_URL .'products');

    }
    public function showProduct($idProducto){
        $producto = $this->model->showProduct($idProducto);
        $this->view->showProduct($producto);
     }
    function editProduct($idProducto){
        AuthHelper::verify();
        $productos = $this->model->getProducts();
        $producto = $this->model->showProduct($idProducto);
 
            $this->view->editProduct($idProducto,$producto,$productos);

        }
        
     
     function actualizarProducto($idProducto){
        AuthHelper::verify();
        $nuevoProducto = $_POST['producto'];
        $nuevoPrecio = $_POST['precio'];
        $nuevaDescripcion = $_POST['descripcion'];

        $this->model->actualizarItem($idProducto,$nuevoProducto,$nuevoPrecio,$nuevaDescripcion);
        header('Location: ' . BASE_URL .'products');
     }
}