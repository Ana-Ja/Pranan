<?php

require_once("DataObject.class.php");
class Entrada extends DataObject {
  protected $data=array(
    "id"=>"",
    "fecha"=>"",
    "idarticulo"=>"",
    "idproveedor"=>"",
    "unidades"=>"",
    "observa"=>""
    );


  public static function getEntradas($startRow, $numRows,$filtro, $ins){
    // $hoy=date('Y-m-d');
     $sql="";
    if ($filtro=="" and $ins=="") {
       $sql="Select SQL_CALC_FOUND_ROWS  entradas.*, nombre from entradas  left join articulos on entradas.idarticulo=articulos.id order by fecha desc Limit :startRow, :numRows ";

    }  elseif ($ins!="" && $filtro!="" ){
      $sql= $ins . " and  ". $filtro . " order by fecha desc Limit :startRow, :numRows ";
     } elseif ($filtro!="" ){
      $sql="Select SQL_CALC_FOUND_ROWS  * from entradas  left join articulos on entradas.idarticulo=articulos.id  where ". $filtro . "   order by fecha desc Limit :startRow, :numRows ";

    }  elseif ($ins!="" ){
      $sql= $ins . "  order by fecha desc Limit :startRow, :numRows ";
    }

    $conn= parent::connect();

echo $sql;
    try {
      $st=$conn->prepare($sql);
      $st->bindValue (":startRow", $startRow, PDO::PARAM_INT);
      $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
      $st->execute();
      $entradas=array();
      foreach ($st->fetchAll() as $row){
        $entradas[]=new Entrada($row);
      }
      $st=$conn-> query("Select found_rows() as totalRows");
      $row=$st->fetch();

      parent::disconnect($conn);

      return array($entradas, $row["totalRows"]);
    } catch (PDOException $e) {
      parent::disconnect($conn);
      die("Fallo en el query: " .$e->getMessage());
    }
  }
  public static function getMasEntradas($startRow, $numRows,$filtro, $ins){
     $hoy=date('Y-m-d');
     $sql="";
    if ($filtro=="" and $ins=="") {
       $sql="Select   * from entradas  left join municipios on entradas.id_ciudad=municipios.id where  (fbaja ='0000-00-00' or  fbaja>'$hoy' ) order by fecha desc Limit :startRow, :numRows ";

    }  elseif ($ins!="" && $filtro!="" ){
      $sql= $ins . " and  (fbaja ='0000-00-00' or  fbaja>'$hoy' ) and ". $filtro . " order by fecha desc Limit :startRow, :numRows ";
     } elseif ($filtro!="" ){
      $sql="Select   * from entradas  left join municipios on entradas.id_ciudad=municipios.id  where ". $filtro . " and (fbaja ='0000-00-00' or  fbaja>'$hoy' )  order by fecha desc Limit :startRow, :numRows ";

    }  elseif ($ins!="" ){
      $sql= $ins . " and  (fbaja ='0000-00-00' or  fbaja>'$hoy' )  order by fecha desc Limit :startRow, :numRows ";
    }

    $conn= parent::connect();


    try {
      $st=$conn->prepare($sql);
      $st->bindValue (":startRow", $startRow, PDO::PARAM_INT);
      $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
      $st->execute();
      $entradas=array();
      $entradas = $st->fetchAll(PDO::FETCH_ASSOC);

      parent::disconnect($conn);

      return $entradas;
    } catch (PDOException $e) {
      parent::disconnect($conn);
      die("Fallo en el query: " .$e->getMessage());
    }
  }
  public static function getEntradas2($startRow, $numRows,$order){
   // echo " order  ".$order;
      $order = ($order=='fecha')? "fecha desc, municipio asc": "municipio asc, fecha desc";
   // $order= ($order!=="fecha") ? "municipio":"fecha";
      $hoy=date('Y-m-d');
    $conn= parent::connect();

     $sql="Select SQL_CALC_FOUND_ROWS  * from entradas left join municipios on entradas.id_ciudad=municipios.id where (fbaja ='0000-00-00' or  fbaja>'$hoy' ) order by $order  Limit :startRow, :numRows ";
   // echo " sql ".$sql;
    try {
      $st=$conn->prepare($sql);
      $st->bindValue (":startRow", $startRow, PDO::PARAM_INT);
      $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
      $st->execute();
      $entradas=array();
      foreach ($st->fetchAll() as $row){
        $entradas[]=new Entrada($row);
      }
    //  print_r($entradas);
      $st=$conn-> query("Select found_rows() as totalRows");
      $row=$st->fetch();

      parent::disconnect($conn);

      return array($entradas, $row["totalRows"]);
    } catch (PDOException $e) {
      parent::disconnect($conn);
      die("Fallo en el query: " .$e->getMessage());
    }
  }

    public static function getEntrada($id) {
      $conn =parent::connect();
      $sql="select * from entradas where id=:id";

      try {
        $st=$conn->prepare($sql);
        $st-> bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row=$st->fetch();
        parent::disconnect($conn);
        if ($row)
          return new Entrada($row);
      } catch (PDOException $e) {
          parent::disconnect($conn);
         die("Fallo en el query: " .$e->getMessage());
    }
  }



     public function insert() {
     $conn=parent::connect();
     if  (trim($this->data["fecha"])!=""){
       $fecha= date_create_from_format('Y-m-d', $this->data["fecha"]);
       $fecha =$fecha->format("Y-m-d");
     }else {
      $fecha="";
     }
     $sql = "insert into entradas (
      fecha,
      idarticulo,
      idproveedor,
      unidades,
      observa
      ) VALUES (
      :fecha,
      :idarticulo,
      :idproveedor,
      :unidades,
      :observa
      )";
     try {
       $st= $conn->prepare($sql);
       $st->bindValue(":fecha", $fecha, PDO::PARAM_STR);
       $st->bindValue(":unidades", $this->data["unidades"], PDO::PARAM_INT);
       $st->bindValue(":idarticulo", $this->data["idarticulo"], PDO::PARAM_INT);
       $st->bindValue(":idproveedor", $this->data["idproveedor"], PDO::PARAM_INT);
       $st->bindValue(":observa", $this->data["observa"], PDO::PARAM_STR);

       $row=$st->execute();
     parent::disconnect($conn);
     } catch (PDOException $e) {
      parent::disconnect($conn);
      die("Fallo en el query: " .$e->getMessage());
    }
   }

   public function update() {
    $conn=parent::connect();
     if  (trim($this->data["fecha"])!=""){
             $fecha= date_create_from_format('Y-m-d', $this->data["fecha"]);

       $fecha =$fecha->format("Y-m-d");
     }else {
       $fecha="";
      }
    $sql = "Update entradas SET
      fecha =:fecha,
      idarticulo=:idarticulo,
      idproveedor=:idproveedor,
      unidades=:unidades,
      observa=:observa
      where id=:id";
    try {

       $st= $conn->prepare($sql);
         $st->bindValue(":id", $this->data["id"], PDO::PARAM_INT);
       $st->bindValue(":fecha", $fecha, PDO::PARAM_STR);
       $st->bindValue(":unidades", $this->data["unidades"], PDO::PARAM_INT);
       $st->bindValue(":idarticulo", $this->data["idarticulo"], PDO::PARAM_INT);
       $st->bindValue(":observa",  $this->data["observa"] , PDO::PARAM_STR);
       $st->bindValue(":idproveedor", $this->data["idproveedor"], PDO::PARAM_INT);

       $row=$st->execute();
       parent::disconnect($conn);
       } catch (PDOException $e) {
      parent::disconnect($conn);
      die("Fallo en el query: " .$e->getMessage());
       }


   }

   public function delete() {
      $conn=parent::connect();
      $sql= "Delete  from entradas where id=:id";
      try {
       $st= $conn->prepare($sql);
         $st->bindValue(":id", $this->data["id"], PDO::PARAM_INT);
       $row=$st->execute();
       parent::disconnect($conn);
       } catch (PDOException $e) {
      parent::disconnect($conn);
      die("Fallo en el query: " .$e->getMessage());
       }

   }
}
?>