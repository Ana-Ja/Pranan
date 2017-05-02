<?php

$unidades = $_REQUEST['unidades'];
$id = $_REQUEST['id'];
$idarticulo = $_REQUEST['idarticulo'];
$idproducto = $_REQUEST['idproducto'];

 $raiz="../../";
require_once($raiz."modelo/comun.php");
$compo=new Composicion(array(
             "id"=>$id,
              "unidades"=>$unidades,
              "idarticulo"=>$idarticulo
              ));
    $compo->update();

$composicion=Composicion::getComposicion($id);
$id = $composicion['id'];
$idarticulo = $composicion['idarticulo'];
$idproducto = $composicion['idproducto'];
$nombrearticulo = $composicion['nombrearticulo'];
$unidades = $composicion['unidades'];

echo json_encode(array(
    'id'=>$id ,
    'idproducto'=> $idproducto,
     'idarticulo' =>$idarticulo,
    'nombrearticulo' =>$nombrearticulo,
    "unidades"=>$unidades
));


?>