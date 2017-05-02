<?php
$raiz="../../";
 include_once($raiz."modelo/comun.php");
 $productos= Producto::getProductos2();
    echo json_encode($productos);


?>