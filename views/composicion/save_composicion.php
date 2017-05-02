<?php

$unidades = $_REQUEST['unidades'];
$idarticulo = $_REQUEST['idarticulo'];
//$nombrearticulo = $_REQUEST['nombrearticulo'];
$idproducto = $_GET['idproducto'];
 $raiz="../../";
require_once($raiz."modelo/comun.php");
$compo=new Composicion(array(
              "idarticulo"=>$idarticulo,
              "unidades"=>$unidades,
              "idproducto"=>$idproducto,
              ));
$id= $compo->insert();


$composicion=Composicion::getComposicion($id);
//echo json_encode($composicion);
$id = $composicion['id'];
$idarticulo = $composicion['idarticulo'];
$nombrearticulo = $composicion['nombrearticulo'];
$unidades = $composicion['unidades'];
$idproducto = $composicion['idproducto'];
$foto = $composicion['foto'];


echo json_encode(array(
    'id'=>$id ,
    'idproducto'=> $idproducto,
     'idarticulo' =>$idarticulo,
    'nombrearticulo' =>$nombrearticulo,
    "unidades"=>$unidades,
     "foto"=>$foto
));

?>