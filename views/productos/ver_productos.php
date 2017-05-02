<?php
$raiz="../../";

require_once($raiz."modelo/comun.php");


//checkLogin();


 $titulo="Listado de Productos";
 include_once($raiz."plantilla/cabecera.php");

$start = isset($_GET["start"])? (int)$_GET["start"]: 0;

$order = isset($_GET["order"])? $_GET["order"]:"nombre";

list($productos, $totalRows) = Producto::getProductos($start, PAGE_SIZE,$order);

 //$productos= Articulo::getArticulos2();
//   echo json_encode($productos);

/*  $composiciones= Composicion::getComposiciones(3);
     echo "</br>Compo " . json_encode($composiciones);*/

?>
 <div id="contenido_usu" >



            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de Productos</h3>
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
                             <a href='<?php echo $raiz."/informes/productos_inf.php" ?>'> <span class="glyphicon glyphicon-print btn btn-primary btn-sm" aria-hidden="true" title="Imprimir"></span> </a>
                            <button type="button"
                                class="btn btn-sm btn-primary"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="NuevoModalProducto('<?php echo $start?>','<?php echo $order?>')">NUEVO</button>
                        </th>
                        </thead>
                        <tbody>
                            <?php

                            if ($totalRows >0){
                            foreach ($productos as $fila) {

                                echo "<tr>";
                                echo '<td>' .  $fila->getValueEncoded("id")  . '</td>';
                                echo '<td>' . $fila->getValueEncoded("nombre")  . '</td>';
                                echo '<td>' . $fila->getValueEncoded("unidades")  . '</td>';
                                echo '<td>' .  $fila->getValueEncoded("idproveedor")  . '</td>';
                                echo '<td>' .  $fila->getValueEncoded("foto") . '</td>';
                                // echo '<td><button class="btn btn-primary" onclick="editar(' .   $fila->getValueEncoded("id_producto")  . ')">Editar</button></td>';
                      ?>
                                <td><a id="ver-producto" name="ver-producto"type="button"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="abrirModalProducto('see',
                                            '<?php print( $fila->getValueEncoded("id")); ?>', '<?php print($fila->getValueEncoded("nombre") ); ?>',
                                            '<?php print($fila->getValueEncoded("unidades")); ?>', '<?php print($fila->getValueEncoded("foto") ); ?>',
                                            '<?php print($fila->getValueEncoded("idproveedor")); ?>',
                                            '<?php print($order); ?>','<?php print($start); ?>')">
                                            <span class="glyphicon glyphicon-info-sign btn btn-success btn-sm" aria-hidden="true" title="Ver"></span> </a>

                                 <a id="edit-producto" name="edit-producto" type="button"
                                data-toggle="modal"
                                data-target="#myModal"
                                onclick="abrirModalProducto('edit',
                                            '<?php print( $fila->getValueEncoded("id")); ?>', '<?php print($fila->getValueEncoded("nombre") ); ?>',
                                            '<?php print($fila->getValueEncoded("unidades")); ?>', '<?php print($fila->getValueEncoded("foto") ); ?>',
                                            '<?php print($fila->getValueEncoded("idproveedor")); ?>',
                                            '<?php print($order); ?>','<?php print($start); ?>')">
                                            <span class="glyphicon glyphicon-pencil btn btn-warning btn-sm" aria-hidden="true" title="Editar"></span> </a>

                              <a type="button" data-toggle="modal" data-target="#myModalDelete" id ="borrarproducto"
                                      onclick="borrarProducto('<?php echo $fila->getValueEncoded("id")  ?>','<?php echo $start?>','<?php echo $order?>')">
                                    <span class="glyphicon glyphicon-trash btn btn-danger btn-sm" aria-hidden="true" title="Borrar"></span> </a>


                                     <a id="desglose-producto" name="desglose-producto" type="button"
                                data-toggle="modal"
                                data-target="#myModalDesglose"
                                onclick="abrirModalDesglose(
                                            '<?php print( $fila->getValueEncoded("id")); ?>', '<?php print($fila->getValueEncoded("nombre") ); ?>',
                                            '<?php print($fila->getValueEncoded("unidades")); ?>', '<?php print($fila->getValueEncoded("foto") ); ?>',
                                            '<?php print($fila->getValueEncoded("idproveedor")); ?>',
                                            '<?php print($order); ?>','<?php print($start); ?>')">
                                            <span class="glyphicon glyphicon-th-list btn btn-warning btn-sm" aria-hidden="true" title="Desglose Modal"></span> </a>

 <a href="../composicion/index.php?idproducto=<?php print( $fila->getValueEncoded("id")); ?>"> <span class="glyphicon glyphicon-th-list   btn btn-warning btn-sm" aria-hidden="true" title="Desglose"></span> </a>


                         <?php

                            }}
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
                <h4 class="modal-title" id="myModalLabel">Creación de Producto</h4>
            </div>
            <form role="form" name="formProductos" id="formProductos" method="post"  ENCTYPE="multipart/form-data" action= "trata_productos.php">
                         <div id="messages" class="alert alert-danger" role="alert"></div>
                         <input type="text" readonly class="form-control" id="star" name="star" value="<?php echo $start?>" >
                         <input type="text" readonly class="form-control" id="ordenar" name="ordenar"  value="<?php echo $order?>" >
                        <input type="hidden" readonly class="form-control" id="idProducto" name="idProducto"  >

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
                    <button id="guardar_productos" name="guardar_productos" type="submit" class="btn btn-primary">Guardar</button>
                    <button id="modificar_productos" name="modificar_productos" type="submit" class="btn btn-primary">Actualizar</button>

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
                   <form role="form" name="formborrarproducto" id="formborrarproducto" method="post" >
                        <div class="modal-body">
                          <p>¿Realmente quiere borrar este producto?</p>
                         <input type="text" readonly class="form-control" id="idProducto" name="idProducto"  >
                         <input type="hidden" readonly class="form-control" id="star" name="star"  >
                         <input type="hidden" readonly class="form-control" id="ordenar" name="ordenar"  >

                        </div>
                        <div class="modal-footer">
                                <button id="borra_producto" name="borra_producto" type="submit" class="btn btn-primary">Aceptar</button>
                                <button id="cancel"type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


<!-- Modal DESGLOSE -->
        <div class="modal fade" id="myModalDesglose" tabindex="-1" role="dialog" aria-labelledby="myModalDesgloseLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalDesgloseLabel">DESGLOSE</h4>
                    </div>
                    <div class="panel panel-primary">
                       <div class="panel-heading">
                           <h3 class="panel-title">Articulos</h3>
                       </div>
                       <div class="panel-body">

                    <table id="dg" style="height:auto"
                          toolbar="#toolbar" pagination="true" idField="id"
                          rownumbers="true" fitColumns="true" singleSelect="true">
                        <thead>
                          <tr>
                          <!--  <th field="idarticulo" width="50" editor="{type:'validatebox',options:{required:true}}">First Name</th>
                            <th field="idproducto" width="50" editor="{type:'validatebox',options:{required:true}}">Last Name</th> -->
                                       <!--     <th data-options="field:'id',width:80">ID</th>
                                           <th data-options="field:'idproducto',width:80">Producto</th>-->

                            <th data-options="field:'idarticulo',width:100,
                                            formatter:function(value,row){
                                                return row.nombrearticulo;
                                            },
                                            editor:{
                                                type:'combobox',
                                                options:{
                                                    valueField:'idarticulo',
                                                    textField:'nombrearticulo',
                                                    method:'get',
                                                    url:'../composicion/get_articulos.php',
                                                    required:true
                                                }
                                            }">Articulo</th>
                            <th data-options="field:'unidades',width:80,align:'right',editor:'numberbox'">Unidades</th>
                           <!--  <th data-options="field:'foto',width:20,align:'center',
                                            formatter:function(value,row){
                                                var src='';

                                                if (value !=''){
                                                    src = '../../recursos/images/' + row.foto;
                                                return '<img src=' + src + '  />';
                                                  }
                                            }">Foto</th> -->
                          </tr>
                        </thead>
                      </table>
                  </div>

                </div>
                      <div id="toolbar">
                        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">New</a>
                        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>
                        <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>
                        <a href="#" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
                      </div>

                <form role="form" name="formDesglose" id="formDesglose" method="post" >
                        <div class="modal-body">

                         <input type="hidden" readonly class="form-control" id="idProducto" name="idProducto"  >
                         <input type="hidden" readonly class="form-control" id="star" name="star"  >
                         <input type="hidden" readonly class="form-control" id="ordenar" name="ordenar"  >

                        </div>
                        <div class="modal-footer">
                                <button id="cancel"type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>



                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->



<script type="text/javascript">
   /* $('#dg').edatagrid({
        url: '../composicion/get_composicion.php?idproducto=6',
        saveUrl: '../composicion/save_composicion.php',
        updateUrl: '../composicion/update_composicion.php',
        destroyUrl: '../composicion/destroy_composicion.php'
    });*/
</script>

<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <?php if ($start >0) {?>
        <a href="ver_productos.php?start=<?php echo max($start - PAGE_SIZE,0)?>&amp;order=<?php echo $order ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      <?php }?>
    </li>

    <?php
      $totalPaginas= ceil($totalRows/PAGE_SIZE);
      for($i=1; $i<=$totalPaginas; $i++){
        $pag = PAGE_SIZE * ($i-1); ?>
       <li><a href='ver_productos.php?start=<?php echo $pag?>&amp;order=<?php echo $order?>'><?php echo $i?></a></li>
       <?php }
        if ($start+PAGE_SIZE< $totalRows) {?>
         <li>
            <a  href="ver_productos.php?start=<?php echo min($start + PAGE_SIZE,$totalRows)?>&amp;order=<?php echo $order ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
    <?php } ?>
  </ul>
</nav>
