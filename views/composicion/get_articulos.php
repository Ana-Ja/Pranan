<?php
$raiz="../../";
 include_once($raiz."modelo/comun.php");
 $articulos= Articulo::getArticulos2();
    echo json_encode($articulos);


?>