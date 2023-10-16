<?php
class clientesView{
    function __construct(){}

    function showAdminClientsList($list){
        $count = count($list);
        require './templates/clientesAdmin.phtml';
    }
    function showClientsList($list){
        $count = count($list);
        require './templates/clientes.phtml';
    }
    public function showError($error) {
        require './templates/error.phtml';
    }
    function clientEdit($clienteId,$cliente){
        require './templates/clientEdit.phtml';
    }

}
