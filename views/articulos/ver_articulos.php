<?php
$raiz="../../";

require_once($raiz."modelo/comun.php");


//checkLogin();


 $titulo="Listado de Articulos";
 include_once($raiz."plantilla/cabecera.php");

$start = isset($_GET["start"])? (int)$_GET["start"]: 0;

$order = isset($_GET["order"])? $_GET["order"]:"nombre";

echo "get ".$order."  est";
list($articulos, $totalRows) = Articulo::getArticulos($start, PAGE_SIZE,$order);
?>
 <div id="contenido_usu" >



            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de Articulos</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Unidades</th>
                        <th>Proveedor</th>
                        <th>Foto</th>
                        <th >
                             <a href='<?php echo $raiz."/informes/articulos_inf.php" ?>'> <span class="glyphicon glyphicon-print btn btn-primary btn-sm" aria-hidden="true" title="Imprimir"></span> </a>
                            <button type="button"
                                class="btn btn-sm btn-primary"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="NuevoModalArticulo('<?php echo $start?>','<?php echo $order?>')">NUEVO</button>
                        </th>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($articulos as $fila) {

                                echo "<tr>";
                                echo '<td>' .  $fila->getValueEncoded("id")  . '</td>';
                                echo '<td>' . $fila->getValueEncoded("nombre")  . '</td>';
                                echo '<td>' . $fila->getValueEncoded("unidades")  . '</td>';
                                echo '<td>' .  $fila->getValueEncoded("idproveedor")  . '</td>';
                                echo '<td>' .  $fila->getValueEncoded("foto") . '</td>';
                                // echo '<td><button class="btn btn-primary" onclick="editar(' .   $fila->getValueEncoded("id_articulo")  . ')">Editar</button></td>';
                      ?>
                                <td><a id="ver-articulo" name="ver-articulo"type="button"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="abrirModalArticulo('see',
                                            '<?php print( $fila->getValueEncoded("id")); ?>', '<?php print($fila->getValueEncoded("nombre") ); ?>',
                                            '<?php print($fila->getValueEncoded("unidades")); ?>', '<?php print($fila->getValueEncoded("foto") ); ?>',
                                            '<?php print($fila->getValueEncoded("idproveedor")); ?>',
                                            '<?php print($order); ?>','<?php print($start); ?>')">
                                            <span class="glyphicon glyphicon-info-sign btn btn-success btn-sm" aria-hidden="true" title="Ver"></span> </a>

                                 <a id="edit-articulo" name="edit-articulo" type="button"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="abrirModalArticulo('edit',
                                            '<?php print( $fila->getValueEncoded("id")); ?>', '<?php print($fila->getValueEncoded("nombre") ); ?>',
                                            '<?php print($fila->getValueEncoded("unidades")); ?>', '<?php print($fila->getValueEncoded("foto") ); ?>',
                                            '<?php print($fila->getValueEncoded("idproveedor")); ?>',
                                            '<?php print($order); ?>','<?php print($start); ?>')">
                                            <span class="glyphicon glyphicon-pencil btn btn-warning btn-sm" aria-hidden="true" title="Editar"></span> </a>
                              <a type="button" data-toggle="modal" data-target="#myModalDelete" id ="borrarnoticia"
                                      onclick="borrarArticulo('<?php echo $fila->getValueEncoded("id")  ?>','<?php echo $start?>','<?php echo $order?>')">
                                    <span class="glyphicon glyphicon-trash btn btn-danger btn-sm" aria-hidden="true" title="Borrar"></span> </a>
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
                <h4 class="modal-title" id="myModalLabel">Creación de Articulo</h4>
            </div>
            <form role="form" name="formArticulos" id="formArticulos" method="post"  ENCTYPE="multipart/form-data" action= "trata_articulos2.php">
                         <div id="messages" class="alert alert-danger" role="alert"></div>
                         <input type="text" readonly class="form-control" id="star" name="star" value="<?php echo $start?>" >
                         <input type="text" readonly class="form-control" id="ordenar" name="ordenar"  value="<?php echo $order?>" >
                        <input type="hidden" readonly class="form-control" id="idArticulo" name="idArticulo"  >

                <div class="modal-body">
                    <div class="input-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="" required size="80" >
                        <small class="text-muted"></small>
                    </div>
                    <div class="input-group">
                        <label for="unidades">Unidades</label>
                        <input type="text" class="form-control" id="unidades" name="unidades" placeholder="Unidades" aria-describedby="sizing-addon2">
                    </div>

                   <div class="input-group">
                        <label for="proveedor">Proveedor</label>
                         <select name="proveedor" id="proveedor"  class="form-control"  size="1" aria-describedby="sizing-addon2">
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
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" placeholder="Foto" aria-describedby="sizing-addon2"  >
                        <input type="hidden" class="form-control" id="imagen2" name="imagen2" placeholder="Foto" aria-describedby="sizing-addon2"  >

                        <small class="text-muted" id="etiimg"></small>
                       <img src='' id="img" width="30%" alt ='Imagen' class="img-responsive img-rounded"/>
                    </div>


                </div>
                <div class="modal-footer">
                    <button id="guardar_articulos" name="guardar_articulos" type="submit" class="btn btn-primary">Guardar</button>
                    <button id="modificar_articulos" name="modificar_articulos" type="submit" class="btn btn-primary">Actualizar</button>

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
                   <form role="form" name="formborrararticulo" id="formborrararticulo" method="post" >
                        <div class="modal-body">
                          <p>¿Realmente quiere borrar este articulo?</p>
                         <input type="text" readonly class="form-control" id="idArticulo" name="idArticulo"  >
                         <input type="hidden" readonly class="form-control" id="star" name="star"  >
                         <input type="hidden" readonly class="form-control" id="ordenar" name="ordenar"  >

                        </div>
                        <div class="modal-footer">
                                <button id="borra_articulo" name="borra_articulo" type="submit" class="btn btn-primary">Aceptar</button>
                                <button id="cancel"type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

<script type="text/javascript">
/* $("#formArticulos #modificar").click(function () {

                alert("Cerrandssso");
                location.href='ver_articulos.php';
               location.reload(true);
             });
$("#formArticulos #borra_articulo").click(function () {
     alert("Borrando");
                location.href='ver_articulos.php';
               location.reload(true);

             });
$("#formArticulos #guardar").click(function () {

                alert("guardando");
                location.href='ver_articulos.php';
               location.reload(true);
             });*/
</script>

<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <?php if ($start >0) {?>
        <a href="ver_articulos.php?start=<?php echo max($start - PAGE_SIZE,0)?>&amp;order=<?php echo $order ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      <?php }?>
    </li>

    <?php
      $totalPaginas= ceil($totalRows/PAGE_SIZE);
      for($i=1; $i<=$totalPaginas; $i++){
        $pag = PAGE_SIZE * ($i-1); ?>
       <li><a href='ver_articulos.php?start=<?php echo $pag?>&amp;order=<?php echo $order?>'><?php echo $i?></a></li>
       <?php }
        if ($start+PAGE_SIZE< $totalRows) {?>
         <li>
            <a  href="ver_articulos.php?start=<?php echo min($start + PAGE_SIZE,$totalRows)?>&amp;order=<?php echo $order ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
    <?php } ?>
  </ul>
</nav>

