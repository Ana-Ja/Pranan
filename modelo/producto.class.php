<?php
require_once("DataObject.class.php");

class Producto extends DataObject {
  protected $data= array(
      "id"=>"",
      "nombre"=>"",
      "unidades"=>"",
      "idproveedor"=>"",
      "foto"=>"",
      "documentacion"=>""
      );


public static function getProductos( $startRow, $numRows, $order ) {
    $conn = parent::connect();
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_PRODUCTOS . " ORDER BY $order LIMIT :startRow, :numRows";
     print_r($sql);
    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":startRow", $startRow, PDO::PARAM_INT );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->execute();
    //creo una tabla donde guardare todos los objetos que he creado con cada fila leida
      $productos = array();
      foreach ( $st->fetchAll() as $row ) {
        $productos[] = new Producto( $row );
      }
      $st = $conn->query( "SELECT found_rows() AS totalRows" );
      $row = $st->fetch();
      parent::disconnect( $conn );
      return array( $productos, $row["totalRows"] );
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

  public static function getProducto($id_producto) {
    $conn = parent::connect();
    $sql = "SELECT * FROM " . TBL_PRODUCTOS . " WHERE id = :id_producto ";

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id_producto", $id_producto, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();

      parent::disconnect( $conn );
      if ( $row ) return new Producto( $row );
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

  public static function getProductos2( ) {
    $conn = parent::connect();
    $sql = "SELECT  id as idproducto,nombre as productname FROM " . TBL_PRODUCTOS . " ORDER BY productname";
   //  print_r($sql);
    try {
      $st = $conn->prepare( $sql );
      $st->execute();
      $productos = $st->fetchAll(PDO::FETCH_ASSOC);
      parent::disconnect( $conn );
   //   echo json_encode($productos);
      return $productos;
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

  public static function getProducto2($id_producto) {
    $conn = parent::connect();
    $sql = "SELECT * FROM " . TBL_PRODUCTOS . " WHERE id = :id_producto ";

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id_producto", $id_producto, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();

      parent::disconnect( $conn );
      if ( $row ) return new Producto( $row );
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

public static function getAllProductos(  ) {
    //Obtenemos todas las composiciones de un producto
    $conn = parent::connect();
    $sql = "SELECT * FROM " . TBL_PRODUCTOS . " where id in (select idproducto from composiciones) ";

  //   print_r($sql);

    try {
      $st = $conn->prepare( $sql );
    //  $st->bindValue( ":idproducto", $idproducto, PDO::PARAM_INT );
      $st->execute();
       $productos = $st->fetchAll(PDO::FETCH_ASSOC);
      parent::disconnect( $conn );
      return $productos;
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

   public function insert() {
   $conn= parent::connect();
   $sql = "INSERT INTO " . TBL_PRODUCTOS . " (
         nombre,
        unidades,
        idproveedor,
        foto,
        documentacion
      ) VALUES (
         :nombre,
         :unidades,
         :idproveedor,
         :foto,
         :documentacion
        )";
   try {
//    print_r($sql);
      $st = $conn->prepare( $sql );
    $st->bindValue( ":nombre", $this->data["nombre"], PDO::PARAM_STR );
    $st->bindValue( ":unidades", $this->data["unidades"], PDO::PARAM_INT );
    $st->bindValue( ":idproveedor", $this->data["idproveedor"], PDO::PARAM_INT );
    $st->bindValue( ":foto", $this->data["foto"], PDO::PARAM_STR );
    $st->bindValue( ":documentacion", $this->data["documentacion"], PDO::PARAM_STR );



      $st->execute();


      parent::disconnect( $conn );

    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
}
public function update() {
   $conn= parent::connect();

   $sql ="UPDATE  " . TBL_PRODUCTOS . " set
         nombre=:nombre,
        unidades=:unidades,
         idproveedor = :idproveedor,
        foto=:foto,
        documentacion=:documentacion
        where id=:id";
//echo $sql;
   try {
      $st = $conn->prepare( $sql );
    $st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT);

    $st->bindValue( ":nombre", $this->data["nombre"], PDO::PARAM_STR );
    $st->bindValue( ":unidades", $this->data["unidades"], PDO::PARAM_INT );
    $st->bindValue( ":idproveedor", $this->data["idproveedor"], PDO::PARAM_INT );
    $st->bindValue( ":foto", $this->data["foto"], PDO::PARAM_STR );
    $st->bindValue( ":documentacion", $this->data["documentacion"], PDO::PARAM_STR );


      $st->execute();


      parent::disconnect( $conn );

    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }

 }

 public  function delete() {
  $conn= parent::connect();
  $sql="Delete from " . TBL_PRODUCTOS . " where id =:id";

   try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT );
      $st->execute();
      parent::disconnect( $conn );

    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

}
?>