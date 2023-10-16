<?php
require_once './app/models/clientesModel.php';
require_once './app/views/clientesView.php';
require_once './app/models/materialesModel.php';
class clientesController{

    private $view;
    private $model;
    private $materialesModel;

    function __construct()
    {
     $this->view = new clientesView();
     $this->model = new clientesModel();  
     $this->materialesModel = new materialesModel(); 
     
    }
    function showClients() {
        $list = $this->model->getClients();
        
        if(AuthHelper::checkLogin()){
            $this->view->showAdminClientsList($list);
        }
        else{
            $this->view->showClientsList($list);
        }
    }
    function checkRegisteredUser($nombre, $apellido){
       
        $clientsList = $this->model-> getClients();
        foreach ($clientsList as $client){
            if($nombre == $client->nombre && $apellido == $client->apellido){
                return true;
            }

    }
}
    function addClient(){
            // obtengo los datos del usuario
            AuthHelper::verify();
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $edad = $_POST['edad'];
            
            // validaciones
            if (empty($nombre) || empty($apellido)|| empty($edad)) {
                $this->view->showError("Debe completar todos los campos");
                return;
            }
            if($this->checkRegisteredUser($nombre, $apellido)){
                $this->view->showError("El cliente ya se encuentra registrado en la base de datos");
            }
            else{$id = $this->model->insertClient($nombre, $apellido, $edad);
           
                 if ($id) {
                header('Location: ' . BASE_URL .'clients');
                } else {
                    $this->view->showError("Error al insertar el pedido");            
            }
        }
        }    
        function removeClient($id){
            AuthHelper::verify();
            $this->model->removeClient($id);
            header('Location: ' . BASE_URL .'clients');
    
        }
        function clientEdit($clienteId){
            AuthHelper::verify();
        $cliente = $this->materialesModel->showClient($clienteId);
        $this->view->clientEdit($clienteId,$cliente);
        }
        function actualizarCliente($clienteId){
            AuthHelper::verify();
        $nuevoNombre = $_POST['nombre'];
        $nuevoApellido = $_POST['apellido'];
        $nuevaEdad = $_POST['edad'];
        
        $this->model->actualizarCliente($clienteId,$nuevoNombre,$nuevoApellido,$nuevaEdad);
        header('Location: ' . BASE_URL .'clients');
        }
    }

