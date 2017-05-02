<?php

$id = $_REQUEST['id'];
 $raiz="../../";
require_once($raiz."modelo/comun.php");
$compo=new Composicion(array(
             "id"=>$id
              ));
              $compo->delete();

echo json_encode(array('success'=>true));
?>