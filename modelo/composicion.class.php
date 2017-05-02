<?php
require_once("DataObject.class.php");

class Composicion extends DataObject {
  protected $data= array(
      "id"=>"",
      "idproducto"=>"",
      "idarticulo"=>"",
      "unidades"=>""
      );

  public static function getComposiciones( $idproducto ) {
    //Obtenemos todas las composiciones de un producto
    $conn = parent::connect();
    $sql = "SELECT composiciones.id as id, idproducto, idarticulo , articulos.nombre as nombrearticulo, composiciones.unidades, articulos.foto FROM " . TBL_COMPOSICIONES .  " left join ". TBL_ARTICULOS ." on composiciones.idarticulo=articulos.id where idproducto = :idproducto ORDER BY composiciones.id";

  //   print_r($sql);

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":idproducto", $idproducto, PDO::PARAM_INT );
      $st->execute();
       $composiciones = $st->fetchAll(PDO::FETCH_ASSOC);
      parent::disconnect( $conn );
      return $composiciones;
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }
public static function getComposicionesInforme( $idproducto ) {
    //Obtenemos todas las composiciones de un producto
    $conn = parent::connect();
    $sql = "SELECT idarticulo , articulos.nombre , composiciones.unidades as unidades, articulos.foto  FROM " . TBL_COMPOSICIONES .  " left join ". TBL_ARTICULOS ." on composiciones.idarticulo=articulos.id where idproducto = :idproducto ORDER BY articulos.nombre";

  //   print_r($sql);

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":idproducto", $idproducto, PDO::PARAM_INT );
      $st->execute();
       $composiciones = $st->fetchAll(PDO::FETCH_ASSOC);
      parent::disconnect( $conn );
      return $composiciones;
    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

    public static function getComposicion($id) {
    $conn = parent::connect();
  //     $sql = "SELECT composiciones.id, idproducto , productos.nombre as productname, composiciones.unidades FROM " . TBL_COMPOSICIONES .  " left join ". TBL_PRODUCTOS ." on composiciones.idproducto=productos.id where composiciones.id = :id ORDER BY composiciones.id";
       $sql = "SELECT composiciones.id, idproducto, idarticulo , articulos.nombre as nombrearticulo, composiciones.unidades , articulos.foto FROM " . TBL_COMPOSICIONES .  " left join ". TBL_ARTICULOS ." on composiciones.idarticulo=articulos.id where composiciones.id = :id ORDER BY composiciones.id";

   //  print_r($sql);

    try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $id, PDO::PARAM_INT );
      $st->execute();
     //  $composicion = $st->fetchAll(PDO::FETCH_ASSOC);
            parent::disconnect( $conn );
        $row=$st->fetch();
         if ($row)
          return $row;

    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
  }

   public function insert() {
   $conn= parent::connect();
  $sql = "INSERT INTO " . TBL_COMPOSICIONES . " (
         idproducto,
        idarticulo,
        unidades
      ) VALUES (
         :idproducto,
         :idarticulo,
         :unidades
        )";

   try {
//    print_r($sql);
      $st = $conn->prepare( $sql );
    $st->bindValue( ":idproducto", $this->data["idproducto"], PDO::PARAM_INT );
   $st->bindValue( ":unidades", $this->data["unidades"], PDO::PARAM_INT );
    $st->bindValue( ":idarticulo", $this->data["idarticulo"], PDO::PARAM_INT );

      $st->execute();
      $id=$conn->lastInsertId("id");
     // echo "</br>ID insertado ".$id;
      return $id;
      parent::disconnect( $conn );

    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }
}
public function update() {
   $conn= parent::connect();

   $sql ="UPDATE  " . TBL_COMPOSICIONES . " set
        idarticulo=:idarticulo,
         unidades = :unidades
        where id=:id";
//echo $sql;
//echo " sql idart ".$this->data["id"];
   try {
      $st = $conn->prepare( $sql );
     $st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT);

  //  $st->bindValue( ":idproducto", $this->data["idproducto"], PDO::PARAM_INT );
    $st->bindValue( ":unidades", $this->data["unidades"], PDO::PARAM_INT );
    $st->bindValue( ":idarticulo", $this->data["idarticulo"], PDO::PARAM_INT );


      $st->execute();


      parent::disconnect( $conn );

    } catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    }

 }

 public  function delete() {
  $conn= parent::connect();
  $sql="Delete from " . TBL_COMPOSICIONES . " where id =:id";

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