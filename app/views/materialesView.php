<?php
class materialesView{
    function __construct(){  
    }
    function showList($list,$clientList){
        $count = count($list);
        $count = count($clientList);
        require './templates/materiales.phtml';
    }
    public function showError($error) {
        require './templates/error.phtml';
    }
    function showAdminList($list, $productList,$clientList){
        $count = count($clientList);
        $count = count($list);
        $count = count($productList);
        require './templates/materialesAdmin.phtml';
    }
    public function showClient($cliente){

        require './templates/client.phtml';
    } 
    function editItem($product,$products,$clients){
        
        require './templates/itemEdit.phtml';
        
    }
    function flitrarItem($list){
        
        require './templates/listaFiltrada.phtml';
    }

}
