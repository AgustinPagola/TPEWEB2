<?php
class productoView{
    function __construct(){}

    function showAdminProductsList($list){
        $count = count($list);
        require './templates/productsAdmin.phtml';
    }
    function showProductsList($list){
        $count = count($list);
        require './templates/products.phtml';
    }
    public function showError($error) {
        require './templates/error.phtml';
    }
    public function showProduct($producto){
        require './templates/product.phtml';
    }
    function editProduct($idProducto,$producto,$productos){
        require './templates/productEdit.phtml';
    }
}
