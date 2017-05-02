<?php
$raiz="../../";

 include_once($raiz."modelo/comun.php");
 $idproducto = $_REQUEST['idproducto'];
  $composiciones= Composicion::getComposiciones($idproducto);
   echo json_encode( $composiciones);
?>