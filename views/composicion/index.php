<?php
//http://www.jeasyui.com/tutorial/app/crud2.php
//https://www.jeasyui.com/forum/index.php?topic=2501.msg5634#msg5634
// *** SI PONEMOS ECHO EN EL CODIGO(UPDATE, INSERT...), no se actualizan los valores
//en el datagrid cuando das de alta o modificas
//en htdocs/jessyui tengo descargados los ejemplos de jessyui
$raiz="../../";

require_once($raiz."modelo/comun.php");


//checkLogin();


 $titulo="Composiciones";
 include_once($raiz."plantilla/cabecera.php");

/* $composiciones= Composicion::getComposiciones(3);
     echo "</br>Compo " . json_encode($composiciones);*/
$idproducto = $_GET['idproducto'];


//echo json_encode(Composicion::getComposicion($id));
$producto=Producto::getProducto2($idproducto);



?>

              <div class="panel panel-primary">
                <div class="panel-heading">
                    <p class="panel-title">Articulos del  <?php echo $producto->getValueEncoded("nombre") ?></p>
                </div>
                <div class="panel-body">
                  <input type="hidden" readonly class="form-control" id="idpro" name="idpro"  value="<?php echo $idproducto ?>" >

                    <table id="dg"  style="width:100%;height:auto"
                          toolbar="#toolbar" pagination="true" idField="id"
                          rownumbers="true" fitColumns="true" singleSelect="true">
                        <thead>
                          <tr>
                          <!--  <th field="idarticulo" width="50" editor="{type:'validatebox',options:{required:true}}">First Name</th>
                            <th field="idproducto" width="50" editor="{type:'validatebox',options:{required:true}}">Last Name</th> -->
                                       <!--     <th data-options="field:'id',width:80">ID</th>-->
                                           <th data-options="field:'idproducto',width:10 ">Producto</th>

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
                                                    url:'get_articulos.php',
                                                    required:true
                                                }
                                            }">Articulo</th>
                            <th data-options="field:'unidades',width:20,align:'right',editor:'numberbox'">Unidades</th>
                            <th data-options="field:'foto',width:20,align:'center',
                                            formatter:function(value,row){
                                                var src='';

                                                if (value !=''){
                                                    src = '../../recursos/images/' + row.foto;
                                                return '<img src=' + src + '  />';
                                                  }
                                            }">Foto</th>
                          </tr>
                        </thead>
                      </table>
                      <div id="toolbar">
                        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:$('#dg').edatagrid('addRow')">New</a>
                        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:$('#dg').edatagrid('destroyRow')">Destroy</a>
                        <a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="javascript:$('#dg').edatagrid('saveRow')">Save</a>
                        <a href="#" class="easyui-linkbutton" iconCls="icon-undo" plain="true" onclick="javascript:$('#dg').edatagrid('cancelRow')">Cancel</a>
                      </div>





                </div>
            </div>




<script type="text/javascript">
     var idproducto= $('#idpro').val();
    $('#dg').edatagrid({
        url: 'get_composicion.php?idproducto=' + idproducto,
        saveUrl: 'save_composicion.php?idproducto=' + idproducto,
        updateUrl: 'update_composicion.php',
        destroyUrl: 'destroy_composicion.php'
    });
</script>