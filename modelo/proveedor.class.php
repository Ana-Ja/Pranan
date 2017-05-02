<?php
require_once("DataObject.class.php");

class Proveedor extends DataObject {
  protected $data= array(
      "id"=>"",
      "nombre"=>""
      );
public static function getProveedores() {

    $conn = parent::connect();
    $sql = "SELECT * FROM " . TBL_PROVEEDORES . "  ORDER BY nombre";

    try {
      $st = $conn->prepare( $sql );
      echo "SQL".$sql;
      $st->execute();
    //creo una tabla donde guardare todos los objetos que he creado con cada fila leida
      $proveedores = array();
      foreach ( $st->fetchAll() as $row ) {
        $proveedores[] = new Proveedor( $row );
      };
    //  $provedores = $st->fetchAll(PDO::FETCH_ASSOC);
    //  echo "en Provvedores ".$provedores;
      print_r(json_encode($proveedores));
      parent::disconnect( $conn );
      return $proveedores;
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }
 }

?>