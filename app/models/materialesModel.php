<?php
require_once './config.php';
class materialesModel {
    private $db;

    function __construct() {
        $this->db = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
        $this->deploy();
    }
    private function deploy() {
        $query = $this->db->query('SHOW TABLES');
        $tables = $query->fetchAll();
        $password = 'admin';
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if (count($tables) == 0) {
            $sql =<<<END
            CREATE TABLE `clientes` (
              `id` int(11) NOT NULL,
              `nombre` varchar(50) NOT NULL,
              `apellido` varchar(50) NOT NULL,
              `edad` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            
            CREATE TABLE `productos` (
              `idProducto` int(11) NOT NULL,
              `producto` varchar(50) NOT NULL,
              `monto` int(11) NOT NULL,
              `descripcion` varchar(300) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
            CREATE TABLE `usuarios` (
              `id` int(11) NOT NULL,
              `user` varchar(50) NOT NULL,
              `password` varchar(255) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
    
            CREATE TABLE `ventas` (
              `idVenta` int(11) NOT NULL,
              `idProducto` int(11) NOT NULL,
              `unidades` int(11) NOT NULL,
              `montoTotal` int(11) NOT NULL,
              `cliente` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
            ALTER TABLE `clientes`
            ADD PRIMARY KEY (`id`);
            ALTER TABLE `productos`
            ADD PRIMARY KEY (`idProducto`);
            ALTER TABLE `usuarios`
            ADD PRIMARY KEY (`id`);
            ALTER TABLE `ventas`
            ADD PRIMARY KEY (`idVenta`),
            ADD KEY `cliente` (`cliente`),
            ADD KEY `idProducto` (`idProducto`);
            ALTER TABLE `clientes`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
            ALTER TABLE `productos`
            MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
            ALTER TABLE `usuarios`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
            ALTER TABLE `ventas`
            MODIFY `idVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
            ALTER TABLE `ventas`
            ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE;
            COMMIT;
            INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `edad`) VALUES
            (23, 'Agustin', 'Pagola', 19),
            (24, 'Agustin', 'Krudiger', 35),
            (25, 'Lissandro', 'Martinez', 42),
            (26, 'Lautaro', 'Perez', 69);
            INSERT INTO `productos` (`idProducto`, `producto`, `monto`, `descripcion`) VALUES
            (18, 'Bolsa de cemento', 3391, 'El cemento se utiliza para hacer hormigon, proteger las superficies, etc.'),
            (19, 'Lata de hidrofugo', 14200, 'Sirve para tapar los poros, microfisuras y fisuras que existen en el material, para así evitar que el agua pueda penetrar y dañar la estructura'),
            (20, 'Pegamento para porcelanatto', 7700, 'Es un material de agarre, que se usa para pegar baldosas de baja absorcion'),
            (21, 'Ladrillos', 36, 'Ss un material de agarre, que se usa para pegar baldosas de baja absorcion');
            INSERT INTO `usuarios` (`id`, `user`, `password`) VALUES
            (1, 'webadmin', '$hashedPassword');
            INSERT INTO `ventas` (`idVenta`, `idProducto`, `unidades`, `montoTotal`, `cliente`) VALUES
            (153, 20, 6, 46200, 26),
            (154, 19, 4, 56800, 24),
            (155, 21, 10000, 360000, 23),
            (157, 19, 5, 71000, 23);            
            END;
            
            $this->db->query($sql);
        }
    }
    function getList() {
        $query = $this->db->prepare('SELECT a.*, b.*,c.* FROM ventas a LEFT JOIN clientes b ON a.cliente=b.id LEFT JOIN productos c ON a.idProducto=c.idProducto');
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
     function insertItem($producto, $unidades,$montoTotal,$cliente) {
         $query = $this->db->prepare('INSERT INTO ventas(idProducto, unidades, montoTotal,cliente) VALUES(?,?,?,?)');
         $query->execute (array($producto, $unidades,$montoTotal, $cliente));
 
         return $this->db->lastInsertId();
     }
     function removeItem($idVenta) {
         $query = $this->db->prepare('DELETE FROM ventas WHERE idVenta = ?');
         $query->execute([$idVenta]);
     }
     function showClient($clienteId){
        $query = $this->db->prepare('SELECT nombre, apellido, edad FROM clientes WHERE id = ?');
        $query->execute(array($clienteId));
        $cliente = $query->fetch(PDO::FETCH_OBJ);
        
        return $cliente;
     }
    function obtenerPedido($idVenta){
        $query = $this->db->prepare('SELECT a.idVenta, a.idProducto, a.unidades, a.cliente, b.producto, c.nombre, c.apellido FROM ventas a LEFT JOIN productos b ON a.idProducto = b.idProducto LEFT JOIN clientes c ON a.cliente =c.id WHERE idVenta = ?');   
        $query->execute([($idVenta)]);
        $producto = $query->fetch(PDO::FETCH_OBJ);
        
        return $producto;
    }
    function actualizarItem($idVenta,$nuevoProducto,$nuevasUnidades,$nuevoMontoTotal,$nuevoCliente){
        $query = $this->db->prepare("UPDATE ventas SET idProducto='$nuevoProducto', unidades='$nuevasUnidades', montoTotal='$nuevoMontoTotal',
        cliente='$nuevoCliente'WHERE idVenta = ?");
        $query->execute(array($idVenta));
    }
    function filtrarItem($cliente){
        $query =$this->db->prepare('SELECT a.idVenta,a.idProducto,a.unidades,a.montoTotal,a.cliente, b.nombre, b.apellido,c.producto, c.monto FROM ventas a LEFT JOIN clientes b ON a.cliente=b.id LEFT JOIN productos c ON a.idProducto=c.idProducto WHERE cliente = ?');
        $query->execute(array($cliente));
        $ventasCliente = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $ventasCliente;
    }
}