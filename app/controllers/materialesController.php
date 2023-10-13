<?php
require_once './app/models/materialesModel.php';
require_once './app/views/materialesView.php';
class materialesController{

    private $view;
    private $model;

    function __construct()
    {
     $this->view = new materialesView();
     $this->model = new materialesModel();   

    }
    function showList() {
        $list = $this->model->getList();
        
        if(AuthHelper::checkLogin()){
            $this->view->showAdminList($list);
        }
        else{
            $this->view->showList($list);
        }
    }
    function addItem() {
        // obtengo los datos del usuario
        $producto = $_POST['producto'];
        $unidades = $_POST['unidades'];
        $cliente = $_POST['cliente'];
        $montoUnitario = '';
        if($producto == "bolsa de cemento"){
            $montoUnitario = 500;
        }
        elseif($producto == "pegamento para porcelanatto"){
            $montoUnitario = 7000;
        }
        elseif($producto == "lata de hidrofugo"){
            $montoUnitario = 15500;
        }
        elseif($producto == "bolsa de arena"){
            $montoUnitario = 1000;
        }
        elseif($producto == "ladrillos"){
            $montoUnitario = 50;
        }
        $montoTotal = $montoUnitario*$unidades;

        // validaciones
        if (empty($producto) || empty($unidades)|| empty($cliente)) {
            $this->view->showError("Debe completar todos los campos");
            return;
        }

        $id = $this->model->insertTask($producto, $unidades, $cliente, $montoUnitario,$montoTotal);
        if ($id) {
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showError("Error al insertar la tarea");
        }
    }  
    function removeItem($id){
        $this->model->removeItem($id);
        header('Location: ' . BASE_URL);

    }
    public function showClient($cliente){
        $this->model->showClient($cliente);
        $this->view->showClient($cliente);
    }

}

?>