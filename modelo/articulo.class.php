<?php
require_once("DataObject.class.php");

class Articulo extends DataObject {
  protected $data= array(
      "id"=>"",
      "nombre"=>"",
      "unidades"=>"",
      "idproveedor"=>"",
      "foto"=>"",
      "documentacion"=>""
      );

  public static function getArticulos( $startRow, $numRows, $order ) {
    $conn = parent::connect();
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_ARTICULOS . " ORDER BY $order LIMIT :startRow, :numRows";
     print_r($sql);
    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":startRow", $startRow, PDO::PARAM_INT );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->execute();
    //creo una tabla donde guardare todos los objetos que he creado con cada fila leida
      $articulos = array();
      foreach ( $st->fetchAll() as $row ) {
        $articulos[] = new Articulo( $row );
      }
      $st = $conn->query( "SELECT found_rows() AS totalRows" );
      $row = $st->fetch();
      parent::disconnect( $conn );
      return array( $articulos, $row["totalRows"] );
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

  public static function getArticulo($id_articulo) {
    $conn = parent::connect();
    $sql = "SELECT * FROM " . TBL_ARTICULOS . " WHERE id = :id_articulo ";

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id_articulo", $id_articulo, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();

      parent::disconnect( $conn );
      if ( $row ) return new Articulo( $row );
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

  public static function getArticulos2( ) {
    $conn = parent::connect();
    $sql = "SELECT id as idarticulo,nombre as nombrearticulo FROM " . TBL_ARTICULOS . " ORDER BY nombrearticulo";
   //  print_r($sql);
    try {
      $st = $conn->prepare( $sql );
      $st->execute();
      $articulos = $st->fetchAll(PDO::FETCH_ASSOC);
      parent::disconnect( $conn );
   //   echo json_encode($productos);
      return $articulos;
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

    public static function getProveedor($id) {
      $conn =parent::connect();
      $sql="select nombre from proveedores where id=:id";

      try {
        $st=$conn->prepare($sql);
        $st-> bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row=$st->fetch();
        parent::disconnect($conn);
        if ($row)
          return $row['nombre'];
      } catch (PDOException $e) {
          parent::disconnect($conn);
         die("Fallo en el query: " .$e->getMessage());
    }
  }

    public static function getNombreArt($id) {
      $conn =parent::connect();
      $sql="select nombre from articulos where id=:id";

      try {
        $st=$conn->prepare($sql);
        $st-> bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row=$st->fetch();
        parent::disconnect($conn);
        if ($row)
          return $row['nombre'];
      } catch (PDOException $e) {
          parent::disconnect($conn);
         die("Fallo en el query: " .$e->getMessage());
    }
  }

  public static function getAllArticulos(  ) {
    $conn = parent::connect();
    $sql = "SELECT * FROM " . TBL_ARTICULOS .  " ORDER BY nombre";
     print_r($sql);
    try {
      $st = $conn->prepare( $sql );
      $st->execute();
    //creo una tabla donde guardare todos los objetos que he creado con cada fila leida
      $articulos = array();
      foreach ( $st->fetchAll() as $row ) {
        $articulos[] = new Articulo( $row );
      }
      parent::disconnect( $conn );
   //    print_r($articulos);
      return $articulos ;
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }
   public function insert() {
   $conn= parent::connect();
   $sql = "INSERT INTO " . TBL_ARTICULOS . " (
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

   $sql ="UPDATE  " . TBL_ARTICULOS . " set
        nombre=:nombre,
        unidades=:unidades,
         idproveedor = :idproveedor,
        foto=:foto,
        documentacion=:documentacion
        where id=:id";
//echo $sql;
//echo " sql idart ".$this->data["id"];
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
  $sql="Delete from " . TBL_ARTICULOS . " where id =:id";

   try {
 //   echo " sql idart ".$this->data["id"]. " sql ".$sql;

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