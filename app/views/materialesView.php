<?php
class materialesView{
    function __construct(){  
    }
    function showList($list){
        $count = count($list);
        require './templates/materiales.phtml';
    }
    public function showError($error) {
        require 'templates/error.phtml';
    }
    public function showClient($cliente){
        $count = count($cliente);
        require 'templates/client.phtml';
    }
    function showAdminList($list){
        $count = count($list);
        require './templates/materialesAdmin.phtml';
    }
}