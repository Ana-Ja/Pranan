<?php

$raiz="../../";

require_once($raiz."modelo/comun.php");


//checkLogin();


 $titulo="Composiciones";
 include_once($raiz."plantilla/cabecera.php");

/* $composiciones= Composicion::getComposiciones(3);
     echo "</br>Compo " . json_encode($composiciones);*/
//$idproducto = $_GET['idproducto'];


//echo json_encode(Composicion::getComposicion($id));
$composicion=Composicion::getComposicion(89);



?>
 <div class="panel panel-primary">
    <div class="panel-heading">
      <a href='<?php echo $raiz."/informes/dispositivos_inf.php" ?>'> <span class="glyphicon glyphicon-print btn btn-primary btn-sm" aria-hidden="true" title="Imprimir"></span> </a>
      <span class="panel-title">Desgloseee Productos</span>

       <!--  <h3 class="panel-title">Desglose Productos</h3> -->
    </div>

    <div class="panel-body">
      <table id="dg" class="table table-striped" style="width:100%;height:auto"
              url="datagrid22_getdata.php" resizable="true" height:'auto'
              title="Desglose Productos"  pagination="true"
              singleSelect="true" fitColumns="true">
          <thead>
              <tr>
                  <th field="id" width="20">Id</th>
                  <th field="nombre" align="left" width="100">Nombre</th>
                  <th field="unidades" align="right" width="20">Unidades</th>
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
    </div>

 </div>



<script type="text/javascript">

    $(function(){

      $('#dg').datagrid({
        view: detailview,
        detailFormatter:function(index,row){
          return '<div style="padding:2px"><table  class="ddv" id="ddv-' + index + '"  ></table></div>';
        },
        onExpandRow: function(index,row){
          $('#ddv-'+index).datagrid({
            url:'datagrid22_getdetail.php?itemid='+row.id,
            fitColumns:true,
            singleSelect:true,
            rownumbers:true,
            loadMsg:'',
            height:'auto',
            columns:[[
              {field:'idarticulo',title:'id',width:10},
              {field:'nombrearticulo',title:'Articulo',width:100},
              {field:'unidades',title:'Unidades',width:10,align:'right'},
              {field:'foto',title:'foto',width:20, align:'center',
                            formatter: function (value, row, index) {
                                var src='';
                                if (value !=''){
                                    src = '../../recursos/images/' + row.foto;
                                    return '<img src=' + src + '  />';
                                  }
                            }


                  }

            ]],
            onResize:function(){
              $('#dg').datagrid('fixDetailRowHeight',index);
            // $('#dg').datagrid('resize');
            },
            onLoadSuccess:function(){
              setTimeout(function(){
                $('#dg').datagrid('fixDetailRowHeight',index);
                $('#dg').datagrid('resize');
                  $('#ddv-'+index).datagrid('resize');
              },0);
            }
          });
          $('#dg').datagrid('fixDetailRowHeight',index);
             // $('#dg').datagrid('resize');
        }
      });
    });

  </script>
