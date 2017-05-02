<?php
$raiz="../../";

require_once($raiz."modelo/comun.php");


//checkLogin();


 $titulo="Listado de Entradas";
 include_once($raiz."plantilla/cabecera.php");

$fecha = "2017-04-19";
// if  (trim($fecha !="")){
//        $fecha= date_create_from_format('Y-m-d',$fecha);
//            //   $fecha= date_create_from_format('Y-m-d', $this->data["fecha"]);

//        $fecha =$fecha->format("Y-m-d");
//      }else {
//        $fecha="";
//       }
// echo $fecha;
// $entrada=new Entrada(array(
//               "id"=> 3,
//               "fecha"=>$fecha,
//               "unidades"=>4,
//               "idproveedor"=>2,
//               "idarticulo"=>4,
//                "observa"=>"aa"
//               ));
//  $entrada->insert();
$articulo=isset($_REQUEST["articulo"])?(int) $_REQUEST["articulo"]:0;
$palabra=isset($_REQUEST["palabra"])? $_REQUEST["palabra"]:"";
$todas=isset($_REQUEST["todas"])? $_REQUEST["todas"]:"";

$start = isset($_GET["start"])? (int)$_GET["start"]: 0;

$order = isset($_GET["order"])? $_GET["order"]:"fecha";
$filtro="";
$sql="";
$start=isset($_GET["start"])?(int) $_GET["start"]:0;
$texto="";
?>

<form action="index2.php" method="post" class="form-inline">
     <div class="form-group lineaanuncio">
           <label for="palabra" class="control-label" >Buscar palabra: </label>
            <input id="inp" name="palabra" class="form-control" value ="<?php echo isset($_REQUEST['palabra'])?  $_REQUEST['palabra']:""?>" />
         <div class="form-group">
            <label for="articulo" class="control-label">Ciudad</label>
              <select name="articulo" id="articulo" size="1"  class="form-control">
                          <?php
                          echo "<option value='0'>--------</option>";
                          $articulos=Articulo::getAllArticulos();
                          foreach($articulos as $fila) {

                              echo "<option value='". $fila->getValueEncoded("id") . "' ";
                                  if (isset($_REQUEST['articulo'])){
                                     if ($fila->getValueEncoded("id") == $_REQUEST['articulo']) {
                                        echo " selected=selected ";
                                      }
                                    }
                      echo "> " . $fila->getValueEncoded("nombre") . " </option>";
                              }

                          ?>

              </select>
          </div>
             <input type="submit" name="buscador" id="buscador" class="btn btn-default"btn value="Buscar" />
              <a  href="borrarFiltrosEntradas.php" class="btn btn-default" role="button">Limpiar</a>
    </div>
</form>


<section>
    <header><h2> ENTRADAS</h2></header>


<?php



 //compruebo si me han introducido busqueda y empiezo a crear la sql
 /*if (isset($_REQUEST['palabra']) && $_REQUEST['palabra']!="") {
    //CUENTA EL NUMERO DE PALABRAS
   $trozos=explode(" ",$_REQUEST['palabra']);
   $numero=count($trozos);
   $texto .="  >>  ". $_REQUEST['palabra'];
    $palabra=$_REQUEST['palabra'];
  if ($numero==1) {
   //SI SOLO HAY UNA PALABRA DE BUSQUEDA SE ESTABLECE UNA INSTRUCION CON LIKE
   $filtro = " (noticia like '%" .$_REQUEST['palabra']. "%' or titulo like '%" .$_REQUEST['palabra']. "%')";

   } elseif ($numero>1) {
  //SI HAY UNA FRASE SE UTILIZA EL ALGORTIMO DE BUSQUEDA AVANZADO DE MATCH AGAINST
  //busqueda de frases con mas de una palabra y un algoritmo especializado

  $sql="SELECT SQL_CALC_FOUND_ROWS  * , MATCH ( titulo,noticia) AGAINST ( '". $_REQUEST['palabra']. "' ) AS Puntos FROM entradas  left join municipios on entradas.id_articulo=municipios.id WHERE MATCH (  titulo,noticia ) AGAINST ( '". $_REQUEST['palabra']. "' )  ";
   }
 }*/
//si existe articulo seleccionada y esta es distinta del valor vacio
 if (isset($_REQUEST['articulo']) && $_REQUEST['articulo']!="" && Articulo::getNombreArt($_REQUEST['articulo'])!="") {
  $articulo_id=$_REQUEST['articulo'];
    if ($filtro=="") {
   $filtro = "  idarticulo = " .$_REQUEST['articulo'] ;

  }else{
  $filtro .= " and  idarticulo = " .$_REQUEST['articulo']  ;
  }
   $texto .= "  >> " . Articulo::getNombreArt($_REQUEST['articulo']);;
 }
if ($texto!=""){
echo "<h4>Filtros: ".$texto."</h4>";
}

?>

    <?php


list( $entradas, $totalRows) = Entrada::getEntradas( $start, PAGE_SIZE_ENTRADAS, $filtro, $sql);




if ($totalRows==0) {
  echo '<div class="alert alert-danger" role="alert"><h3>No existen entradas con esos filtros</h3></div';
} else {

?>
 <div id="contenido_usu" >


            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de Entradas</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Articulo</th>
                        <th>Proveedor</th>
                        <th>Unidades</th>
                        <th >
                             <a href='<?php echo $raiz."/informes/entradas_inf.php" ?>'> <span class="glyphicon glyphicon-print btn btn-primary btn-sm" aria-hidden="true" title="Imprimir"></span> </a>
                            <button type="button"
                                class="btn btn-sm btn-primary"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="NuevoModalEntrada('<?php echo $start?>','<?php echo $order?>')">NUEVO</button>
                        </th>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($entradas as $fila) {

                                echo "<tr>";
                                echo '<td>' .  $fila->getValueEncoded("id")  . '</td>';
                                echo '<td>' . $fila->getValueEncoded("fecha")  . '</td>';
                                echo '<td>' . $fila->getValueEncoded("idarticulo")  . '</td>';
                                echo '<td>' .  $fila->getValueEncoded("idproveedor")  . '</td>';
                                echo '<td>' .  $fila->getValueEncoded("unidades") . '</td>';
                                // echo '<td><button class="btn btn-primary" onclick="editar(' .   $fila->getValueEncoded("id_entrada")  . ')">Editar</button></td>';
                      ?>
                                <td><a id="ver-entrada" name="ver-entrada"type="button"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="abrirModalEntrada('see',
                                            '<?php print( $fila->getValueEncoded("id")); ?>', '<?php print($fila->getValueEncoded("fecha") ); ?>',
                                            '<?php print($fila->getValueEncoded("idarticulo")); ?>', '<?php print($fila->getValueEncoded("idproveedor") ); ?>',
                                            '<?php print($fila->getValueEncoded("unidades")); ?>', '<?php print($fila->getValueEncoded("observa")); ?>',
                                            '<?php print($order); ?>','<?php print($start); ?>')">
                                            <span class="glyphicon glyphicon-info-sign btn btn-success btn-sm" aria-hidden="true" title="Ver"></span> </a>

                                 <a id="edit-entrada" name="edit-entrada" type="button"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="abrirModalEntrada('edit',
                                            '<?php print( $fila->getValueEncoded("id")); ?>', '<?php print($fila->getValueEncoded("fecha") ); ?>',
                                            '<?php print($fila->getValueEncoded("idarticulo")); ?>', '<?php print($fila->getValueEncoded("idproveedor") ); ?>',
                                            '<?php print($fila->getValueEncoded("unidades")); ?>', '<?php print($fila->getValueEncoded("observa")); ?>',
                                            '<?php print($order); ?>','<?php print($start); ?>')">
                                            <span class="glyphicon glyphicon-pencil btn btn-warning btn-sm" aria-hidden="true" title="Editar"></span> </a>
                              <a type="button" data-toggle="modal" data-target="#myModalDelete" id ="borrarentrada"
                                      onclick="borrarEntrada('<?php echo $fila->getValueEncoded("id")  ?>','<?php echo $start?>','<?php echo $order?>')">
                                    <span class="glyphicon glyphicon-trash btn btn-danger btn-sm" aria-hidden="true" title="Borrar"></span> </a>

                         <?php

                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php
   }
?>
<!-- ////////////   MODAl DE ALTA ******//////
 -->
<!--
    Create - Read - Update
    Creamos una ventana Modal que utilizaremos para crear un nuevo usduario, actualizarlo o mostrarlo.
    We create a modal window used to create a new language, update or display.-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Creación de Entrada</h4>
            </div>
            <form role="form" name="formEntradas" id="formEntradas" method="post"  ENCTYPE="multipart/form-data" action= "trata_entradas.php">
                         <div id="messages" class="alert alert-danger" role="alert"></div>
                         <input type="text" readonly class="form-control" id="star" name="star" value="<?php echo $start?>" >
                         <input type="text" readonly class="form-control" id="ordenar" name="ordenar"  value="<?php echo $order?>" >
                        <input type="hidden" readonly class="form-control" id="idEntrada" name="idEntrada"  >

                <div class="modal-body">
                    <div class="input-group">
                        <label for="fecha2">Fecha</label>
                        <input type="text" class="datepicker" id="fecha2" name="fecha2" placeholder="" required  >
                        <small class="text-muted"></small>
                    </div>

                     <div class="input-group">
                        <label for="idarticulo">Articulo</label>
                         <select name="idarticulo" id="idarticulo"  class="form-control"  size="1" aria-describedby="sizing-addon2">
                            <option value='0'>--------</option>
 <?php
                         $articuloes= Articulo::getAllArticulos();
                          foreach ( $articuloes as $articulo) { ?>
                          <option value="<?php echo $articulo->getValueEncoded("id")?>"<?php
                                        if (isset( $fila)) setSelected( $fila, "idarticulo", $fila->getValueEncoded("idarticulo"))   ;?>
                                         ><?php echo $articulo->getValueEncoded("nombre") ?></option>
                          <?php }  ?>
                      </select>
                    </div>

                   <div class="input-group">
                        <label for="idproveedor">Proveedor</label>
                         <select name="idproveedor" id="idproveedor"  class="form-control"  size="1" aria-describedby="sizing-addon2">
                            <option value='0'>--------</option>
 <?php
                         $proveedores= Proveedor::getProveedores();
                          foreach ( $proveedores as $proveedor) { ?>
                          <option value="<?php echo $proveedor->getValueEncoded("id")?>"<?php
                                        if (isset( $fila)) setSelected( $fila, "idproveedor", $fila->getValueEncoded("idproveedor"))   ;?>
                                         ><?php echo $proveedor->getValueEncoded("nombre") ?></option>
                          <?php }  ?>
                      </select>
                    </div>

                    <div class="input-group">
                        <label for="unidades">Unidades</label>
                        <input type="text" class="form-control" id="unidades" name="unidades" placeholder="Unidades" aria-describedby="sizing-addon2">
                    </div>

                    <div class="input-group">
                        <label for="unidades">Observaciones</label>
                        <input type="text" class="form-control" id="observa" name="observa" placeholder="Unidades" aria-describedby="sizing-addon2">
                    </div>



                </div>
                <div class="modal-footer">
                    <button id="guardar_entradas" name="guardar_entradas" type="submit" class="btn btn-primary">Guardar</button>
                    <button id="modificar_entradas" name="modificar_entradas" type="submit" class="btn btn-primary">Actualizar</button>

                    <button id="cancel"type="submit" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal DELETE -->
        <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalDeleteLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalDeleteLabel">Borrar</h4>
                    </div>
                   <form role="form" name="formborrarentrada" id="formborrarentrada" method="post" >
                        <div class="modal-body">
                          <p>¿Realmente quiere borrar esta entrada?</p>
                         <input type="text" readonly class="form-control" id="idEntrada" name="idEntrada"  >
                         <input type="hidden" readonly class="form-control" id="star" name="star"  >
                         <input type="hidden" readonly class="form-control" id="ordenar" name="ordenar"  >

                        </div>
                        <div class="modal-footer">
                                <button id="borra_entrada" name="borra_entrada" type="submit" class="btn btn-primary">Aceptar</button>
                                <button id="cancel"type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<script type="text/javascript">
/* $("#formEntradas #modificar").click(function () {

                alert("Cerrandssso");
                location.href='ver_entradas.php';
               location.reload(true);
             });
$("#formEntradas #borra_entrada").click(function () {
     alert("Borrando");
                location.href='ver_entradas.php';
               location.reload(true);

             });
$("#formEntradas #guardar").click(function () {

                alert("guardando");
                location.href='ver_entradas.php';
               location.reload(true);
             });*/
</script>

<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <?php if ($start >0) {?>
        <a href="ver_entradas.php?start=<?php echo max($start - PAGE_SIZE,0)?>&amp;order=<?php echo $order ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      <?php }?>
    </li>

    <?php
      $totalPaginas= ceil($totalRows/PAGE_SIZE);
      for($i=1; $i<=$totalPaginas; $i++){
        $pag = PAGE_SIZE * ($i-1); ?>
       <li><a href='ver_entradas.php?start=<?php echo $pag?>&amp;order=<?php echo $order?>'><?php echo $i?></a></li>
       <?php }
        if ($start+PAGE_SIZE< $totalRows) {?>
         <li>
            <a  href="ver_entradas.php?start=<?php echo min($start + PAGE_SIZE,$totalRows)?>&amp;order=<?php echo $order ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
    <?php } ?>
  </ul>
</nav>

