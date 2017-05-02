<?php
//echo "en trata ";
 //print_r($_POST);
//if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
  $raiz="../../";
    require_once($raiz."modelo/comun.php");
   //  print_r($_POST);
   $mensajesError=array();
 if ($_POST["accion"]=="guardar_articulos" || $_POST["accion"]=='modificar_articulos' ) {
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
     if ($_POST["accion"]=="guardar_articulos" || $_POST["accion"]=='modificar_articulos' ) {
     // echo "unidades  ".$_POST["unidades"];
         $articulo=new Articulo(array(
              "id"=> isset($_POST["idArticulo"]) ? (int) $_POST["idArticulo"]:0,
              "nombre"=>$_POST["nombre"],
              "unidades"=>$_POST["unidades"],
              "idproveedor"=>$_POST["proveedor"],
               "foto"=>$imagen_guardar
              ));
        // print_r($articulo);
         if ($_POST["accion"]=="guardar_articulos" ){
         // echo "dentro insert";
              $articulo->insert();
          }else{
        //  echo "dentro update ".$_POST["idArticulo"];
             $articulo->update();
          }

      }else{
      // echo "dentrp BORRAR ".$_POST["idArticulo"] ;
          $articulo=new Articulo(array(
              "id"=> isset($_POST["idArticulo"]) ? (int) $_POST["idArticulo"]:0));
          $articulo->delete();

      }
       echo json_encode(true);
  }

?>