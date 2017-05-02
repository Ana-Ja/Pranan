<?php
  $raiz="../../";
    require_once($raiz."modelo/comun.php");
   //  print_r($_POST);
   $mensajesError=array();
 if ($_POST["accion"]=="guardar_productos" || $_POST["accion"]=='modificar_productos' ) {
    if ($_FILES["imagen"]["name"]=="") {
        $imagen_guardar= $_POST["imagen2"];
    }else {
        $imagen_guardar= $_FILES["imagen"]["name"];
         $mensajesError=guardarImagen($_FILES);
   //   print_r( $mensajesError);
    }
   //$mensajesError['prueba']='Error de prueba';

}
   if (count($mensajesError)>0) {
  // echo "AAAA";
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
   //   echo "antes guardar ". $_POST["accion"];
     if ($_POST["accion"]=="guardar_productos" || $_POST["accion"]=='modificar_productos' ) {
  //   echo "unidades  ".$_POST["unidades"];
         $producto=new Producto(array(
              "id"=> isset($_POST["idProducto"]) ? (int) $_POST["idProducto"]:0,
              "nombre"=>$_POST["nombre"],
              "unidades"=>$_POST["unidades"],
              "idproveedor"=>$_POST["proveedor"],
               "foto"=>$imagen_guardar
              ));
       // print_r($producto);
         if ($_POST["accion"]=="guardar_productos" ){
      //    echo "dentro insert";
              $producto->insert();
          }else{
        // echo "dentro update ".$_POST["idProducto"];
             $producto->update();
          }

      }else{
      // echo "dentrp BORRAR ".$_POST["idProducto"] ;
          $producto=new Producto(array(
              "id"=> isset($_POST["idProducto"]) ? (int) $_POST["idProducto"]:0));
          $producto->delete();

      }
      echo json_encode(true);
    //  echo "Final";
  }

?>