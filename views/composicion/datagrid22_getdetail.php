
<?php
$raiz="../../";
 include_once($raiz."modelo/comun.php");
$idproducto = $_REQUEST['itemid'];

/*$rs = mysql_query("select * from lineitem where itemid='$itemid'");
$items = array();
while($row = mysql_fetch_object($rs)){
    array_push($items, $row);
}*/

 $composiciones= Composicion::getComposiciones($idproducto);
echo json_encode($composiciones);
?>