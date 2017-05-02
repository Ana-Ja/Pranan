<?php
//echo "en trata ";
 //print_r($_POST);
//if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
  $raiz="../../";
    require_once($raiz."modelo/comun.php");
   $mensajesError=array();


   if (count($mensajesError)>0) {
  //  echo "AAAA";
         if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($mensajesError);
                exit;
             }
      //This is when Javascript is turned off:
          echo '<ul>';
           foreach($mensajesError as $key => $value){
              echo '<li>'. $value . '</li>';
           }
           echo '</ul>';
           echo "error";
           exit;
    } else {
      //echo "antes guardar";
     if ($_POST["accion"]=="guardar_entradas" || $_POST["accion"]=='modificar_entradas' ) {
     // echo "unidades  ".$_POST["unidades"];
         $entrada=new Entrada(array(
              "id"=> isset($_POST["idEntrada"]) ? (int) $_POST["idEntrada"]:0,
              "fecha"=>$_POST["fecha2"],
              "unidades"=>$_POST["unidades"],
              "idproveedor"=>$_POST["idproveedor"],
              "idarticulo"=>$_POST["idarticulo"],
               "observa"=>$_POST["observa"]
              ));
        // print_r($articulo);
         if ($_POST["accion"]=="guardar_entradas" ){
         // echo "dentro insert";
              $entrada->insert();
          }else{
        //  echo "dentro update ".$_POST["idEntrada"];
             $entrada->update();
          }

      }else{
          $entrada=new Entrada(array(
              "id"=> isset($_POST["idEntrada"]) ? (int) $_POST["idEntrada"]:0));
          $entrada->delete();

      }
       echo json_encode(true);
  }

?>