<?php
class materialesModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=tpeweb2;charset=utf8', 'root', '');
    }
    function getList() {
        $query = $this->db->prepare('SELECT * FROM ventas');
        $query->execute();

        $list = $query->fetchAll(PDO::FETCH_OBJ);

        return $list;
    }
    function getItem() {
        $query = $this->db->prepare('SELECT * FROM ventas');
        $query->execute();
 
        $items = $query->fetchAll(PDO::FETCH_OBJ);
 
        return $items;
    }
     function insertTask($producto, $unidades,$cliente,$montoUnitario,$montoTotal) {
         $query = $this->db->prepare('INSERT INTO ventas(producto, unidades, cliente, montoUnitario,montoTotal) VALUES(?,?,?,?,?)');
         $query->execute (array($producto, $unidades, $cliente,$montoUnitario, $montoTotal));
 
         return $this->db->lastInsertId();
     }
     function removeItem($id) {
         $query = $this->db->prepare('DELETE FROM ventas WHERE id = ?');
         $query->execute([$id]);
     }
     function showClient($cliente){
        $query = $this->db->prepare('SELECT cliente FROM ventas');
        $query->execute();

        return $cliente;
     }
}