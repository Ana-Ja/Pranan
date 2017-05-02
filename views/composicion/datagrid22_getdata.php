<?php
$raiz="../../";
 include_once($raiz."modelo/comun.php");
/*$result = array();
$rs = mysql_query("select * from item where itemid in (select itemid from lineitem)");

$items = array();
while($row = mysql_fetch_object($rs)){
    array_push($items, $row);
}*/
 $productos= Producto::getAllProductos();
echo json_encode($productos);

?>