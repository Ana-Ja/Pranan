var data={};
$(document).ready(function(){

             $( "#fecha22" ).datepicker({
              dateFormat: 'yy-mm-dd',
                  language: "es",
                  autoclose: true,
                  todayBtn: true
                  });//no permito seleccionar dias menores a fecha hoy

 $('input[type="submit"]').on('click', function() {
      resetErrors();
      console.log("he entrado aqui");
      var url = 'proccess.php';
      $.each($('form input, form select'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
      }); //end each
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
          data: data,
          success: function(resp) {
              if (resp === true) {
                    //successful validation
                    //  $('form').submit();
                       location.href="index.php";
              } else {
                  $.each(resp, function(i, v) {
                      console.log(i + " => " + v); // view in console for error messages
                      var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                      $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
                  $('input[name="'+keys[0]+'"]').focus();
              }
              return false;
          },
          error: function(msg) {
              console.log('there was a problem checking the fields');
              alert(msg);
          }
      });
      return false;
  });




  $('#guardar_articulos, #modificar_articulos, #borra_articulo').click(function(event){
     $("#messages").hide().val("");
        //información del formulario
        // var formData ="";
        //  console.log("formulario " + $(this).attr("name"));
        var form= "";
        if ( $(this).attr("name")!='borra_articulo'){
            console.log("articulos");
             var formData = new FormData(document.getElementById("formArticulos"));
             form=document.getElementById("formArticulos");


         }else{
           var formData = new FormData(document.getElementById("formborrararticulo"));
           form= document.getElementById("formborrararticulo");
            console.log("borra articulos");
         }
   //      var formData = new FormData($("#formArticulos"));
        var star= $("#star").val();
       var order= $("#ordenar").val();
       var camino='ver_articulos.php?start='+star + "&order=" + order;

       formData.append("accion", $(this).attr("name"));
        var message = "";

        console.log("antes ajax" );
      resetErrors();
      console.log("he entrado aqui");
      var url = 'trata_articulos2.php';
      $.each($('form input, form select'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
      }); //end each
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
           data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
          success: function(resp) {
              if (resp === true) {
                    //successful validation
                    //  $('form').submit();
                       location.href=camino;
              } else {
                  $.each(resp, function(i, v) {
                      console.log(i + " => " + v); // view in console for error messages
                      var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                      $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
                  $('input[name="'+keys[0]+'"]').focus();
              }
              return false;
          },
          error: function(msg) {
              console.log('there was a problem checking the fields');
              alert(msg);
          }
      });
      return false;
  });




  $('#guardar_productos, #modificar_productos, #borra_producto').click(function(event){
     $("#messages").hide().val("");
        //información del formulario
        // var formData ="";
        //  console.log("formulario " + $(this).attr("name"));
        var form= "";
        if ( $(this).attr("name")!='borra_producto'){
            console.log("articulos");
             var formData = new FormData(document.getElementById("formProductos"));
             form=document.getElementById("formProductos");


         }else{
           var formData = new FormData(document.getElementById("formborrarproducto"));
           form= document.getElementById("formborrarproducto");
            console.log("borra productos");
         }
   //      var formData = new FormData($("#formArticulos"));
        var star= $("#star").val();
       var order= $("#ordenar").val();
       var camino='ver_productos.php?start='+star + "&order=" + order;

       formData.append("accion", $(this).attr("name"));
        var message = "";

        console.log("antes ajax" );
      resetErrors();
      console.log("he entrado aqui");
      var url = 'trata_productos.php';
      $.each($('form input, form select'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
      }); //end each
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
           data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
          success: function(resp) {
              if (resp === true) {
               // alert(resp);
                    //successful validation
                    //  $('form').submit();
                       location.href=camino;
              } else {
                  $.each(resp, function(i, v) {
                      console.log(i + " => " + v); // view in console for error messages
                      var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                      $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
                  $('input[name="'+keys[0]+'"]').focus();
              }
              return false;
          },
          error: function(msg) {
              console.log('there was a problem checking the fields');
              alert(msg);
          }
      });
      return false;
  });




  $('#guardar_entradas, #modificar_entradas, #borra_entrada').click(function(event){
     $("#messages").hide().val("");
        //información del formulario
        // var formData ="";
        //  console.log("formulario " + $(this).attr("name"));
        var form= "";
        if ( $(this).attr("name")!='borra_entrada'){
            console.log("articulos");
             var formData = new FormData(document.getElementById("formEntradas"));
             form=document.getElementById("formEntradas");


         }else{
           var formData = new FormData(document.getElementById("formborrarentrada"));
           form= document.getElementById("formborrarentrada");
            console.log("borra entradas");
         }
   //      var formData = new FormData($("#formArticulos"));
        var star= $("#star").val();
       var order= $("#ordenar").val();
       var camino='ver_entradas.php?start='+star + "&order=" + order;

       formData.append("accion", $(this).attr("name"));
        var message = "";

        console.log("antes ajax" );
      resetErrors();
      console.log("he entrado aqui");
      var url = 'trata_entradas.php';
      $.each($('form input, form select'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
      }); //end each
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url: url,
           data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
          success: function(resp) {
              if (resp === true) {
               // alert(resp);
                    //successful validation
                    //  $('form').submit();
                       location.href=camino;
              } else {
                  $.each(resp, function(i, v) {
                      console.log(i + " => " + v); // view in console for error messages
                      var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                      $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
                  $('input[name="'+keys[0]+'"]').focus();
              }
              return false;
          },
          error: function(msg) {
              console.log('there was a problem checking the fields');
              alert(msg);
          }
      });
      return false;
  });





      $("#messages").hide().val("");
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $('#imagen').change(function()
    {
        console.log("Dentro dile");
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
    });


  /*   $('#myModal').on('hidden.bs.modal', function () {
              location.href='ver_articulos.php';
              alert("Cerrandooo");
           });

      $('#myModalDelete').on('hidden.bs.modal', function () {
           location.href='ver_articulos.php';
           alert("Cerrando");
         })*/

   /*   $("#formArticulos").unload(function () {
                location.href='ver_articulos.php';
                alert("Cerrandssso");
             });*/

});

function resetErrors() {
    $('form input, form select').removeClass('inputTxtError');
    $('label.error').remove();
}

//como la utilizamos demasiadas veces, creamos una función para
//evitar repetición de código
function showMessage(message){
    $("#messages").html("").show();
    $("#messages").html(message);
}


function borrarArticulo(id,start,order){
      console.log("otra forma" + id + " start "+ start + " order " + order);
        document.formborrararticulo.idArticulo.value = id;
        document.formborrararticulo.star.value = start;
        document.formborrararticulo.ordenar.value = order;
         $("#messages").hide().val("");
       $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });

        // $("#myModalDelete").modal("show");
    }


function NuevoModalArticulo(start,order){
            console.log("order" + order);
             $("#messages").hide().val("");
            abrirModalArticulo('new', null, null, null, null,null,order,start);
        }

function abrirModalArticulo(action,id, nombre, unidades, imagen,idproveedor,order,start){
          console.log(id+ " nombre  " + nombre+ "  unidades" + unidades+ " imagen " + imagen + " order " + order+ " " + start);
           $("#messages").hide().val("");
           document.formArticulos.nombre.value = nombre;
            document.formArticulos.idArticulo.value = id;
            document.formArticulos.unidades.value = unidades;
            document.formArticulos.imagen2.value = imagen;

          //  document.formArticulos.proveedor.value = idproveedor;
            $("#etiimg").html(imagen);
            document.formArticulos.img.src ='../../recursos/images/' + imagen;
            document.formArticulos.star.value = start;
            document.formArticulos.ordenar.value = order;

            document.formArticulos.nombre.disabled = (action === 'see')?true:false;
            document.formArticulos.unidades.disabled = (action === 'see')?true:false;
            document.formArticulos.imagen.disabled = (action === 'see')?true:false;

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'new'){
                    modal.find('.modal-title').text('Creación de Articulo');
                    $('#guardar_articulos').show();
                    $('#modificar_articulos').hide();
                }else if (action === 'edit'){
                    modal.find('.modal-title').text('Actualizar Articulo');
                    $('#guardar_articulos').hide();
                    $('#modificar_articulos').show();
                }else if (action === 'see'){
                    modal.find('.modal-title').text('Ver Articulo');
                    $('#guardar_articulos').hide();
                    $('#modificar_articulos').hide();
                }
                $('#nombre').focus();

            });

}

/***********   Productos  **********/

function borrarProducto(id,start,order){
      console.log("otra forma" + id + " start "+ start + " order " + order);
        document.formborrarproducto.idProducto.value = id;
        document.formborrarproducto.star.value = start;
        document.formborrarproducto.ordenar.value = order;
         $("#messages").hide().val("");
       $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });

        // $("#myModalDelete").modal("show");
    }
function NuevoModalProducto(start,order){
            console.log("order" + order);
             $("#messages").hide().val("");
            abrirModalProducto('new', null, null, null, null,null,order,start);
        }

function abrirModalProducto(action,id, nombre, unidades, imagen,idproveedor,order,start){
          console.log(id+ " nombre  " + nombre+ "  unidades" + unidades+ " imagen " + imagen + " order " + order+ " " + start);
           $("#messages").hide().val("");
           document.formProductos.nombre.value = nombre;
            document.formProductos.idProducto.value = id;
            document.formProductos.unidades.value = unidades;
            document.formProductos.imagen2.value = imagen;

          //  document.formProductos.proveedor.value = idproveedor;
            $("#etiimg").html(imagen);
            document.formProductos.img.src ='../../recursos/images/' + imagen;
            document.formProductos.star.value = start;
            document.formProductos.ordenar.value = order;

            document.formProductos.nombre.disabled = (action === 'see')?true:false;
            document.formProductos.unidades.disabled = (action === 'see')?true:false;
            document.formProductos.imagen.disabled = (action === 'see')?true:false;

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                if (action === 'new'){
                    modal.find('.modal-title').text('Creación de Producto');
                    $('#guardar_productos').show();
                    $('#modificar_productos').hide();
                }else if (action === 'edit'){
                    modal.find('.modal-title').text('Actualizar Producto');
                    $('#guardar_productos').hide();
                    $('#modificar_productos').show();
                }else if (action === 'see'){
                    modal.find('.modal-title').text('Ver Producto');
                    $('#guardar_productos').hide();
                    $('#modificar_productos').hide();
                }else if (action === 'desglose'){
                    modal.find('.modal-title').text('Ver Desglose');
                    $('#guardar_productos').hide();
                    $('#modificar_productos').hide();
                }
                $('#nombre').focus();

            });

}

/***********   DESGLOSE  **********/

function abrirModalDesglose(id, nombre, unidades, imagen,idproveedor,order,start){
        //  console.log(id+ " nombre  " + nombre+ "  unidades" + unidades+ " imagen " + imagen + " order " + order+ " " + start);

            document.formDesglose.idProducto.value = id;
            document.formDesglose.star.value = start;
            document.formDesglose.ordenar.value = order;

            $('#myModalDesglose').on('shown.bs.modal', function () {
                var modal = $(this);
                $('#dg').edatagrid({
                    url: '../composicion/get_composicion.php?idproducto='+id,
                    saveUrl: '../composicion/save_composicion.php?idproducto='+id,
                    updateUrl: '../composicion/update_composicion.php',
                    destroyUrl: '../composicion/destroy_composicion.php'
                });

               // $('#nombre').focus();

            });

}


/***********   Entradas  **********/
   function borrarEntrada(id,start,order){
      console.log("otra formaaa" + id + " start "+ start + " order " + order);
        document.formborrarentrada.idEntrada.value = id;
        document.formborrarentrada.star.value = start;
        document.formborrarentrada.ordenar.value = order;
         $("#messages").hide().val("");
       $('#myModalDelete').on('shown.bs.modal', function () {
            $('#myInput').focus()
        });

        // $("#myModalDelete").modal("show");
    }
function NuevoModalEntrada(start,order){
            console.log("order" + order);
             $("#messages").hide().val("");
            abrirModalEntrada('new', null, null, null, null , null,null,order,start);
        }

function abrirModalEntrada(action,id,fecha,  idarticulo, idproveedor, unidades, observa ,order,start){
          console.log(id+ " fecha  " + fecha+ "  unidades" + unidades+ " idarticulo " + idarticulo + " order " + order+ " " + start);
           $("#messages").hide().val("");
           document.formEntradas.fecha2.value = fecha;
           document.formEntradas.idEntrada.value = id;
            document.formEntradas.idproveedor.value = idproveedor;
            document.formEntradas.unidades.value = unidades;
            document.formEntradas.idarticulo.value = idarticulo;
            document.formEntradas.observa.value = observa;
          //  $( "#fecha" ).datepicker({ dateFormat: 'yy-mm-dd'});//no permito seleccionar dias menores a fecha hoy


            document.formEntradas.star.value = start;
            document.formEntradas.ordenar.value = order;

            document.formEntradas.fecha2.disabled = (action === 'see')?true:false;
            document.formEntradas.unidades.disabled = (action === 'see')?true:false;
            document.formEntradas.idproveedor.disabled = (action === 'see')?true:false;
            document.formEntradas.idarticulo.disabled = (action === 'see')?true:false;
            document.formEntradas.observa.disabled = (action === 'see')?true:false;

            $('#myModal').on('shown.bs.modal', function () {
                var modal = $(this);
                // bootstrap-datepicker
                $('#fecha2').datepicker({
                 dateFormat: 'yy-mm-dd',
                  language: "es",
                  autoclose: true,
                  todayBtn: true
                }).on(
                  'show', function() {
                  // Obtener valores actuales z-index de cada elemento
                  var zIndexModal = $('#myModal').css('z-index');
                  var zIndexFecha = $('.datepicker').css('z-index');

                        // alert(zIndexModal + zIndexFEcha);

                        // Re asignamos el valor z-index para mostrar sobre la ventana modal
                        $('.datepicker').css('z-index',zIndexModal+1);
                });

                if (action === 'new'){
                    modal.find('.modal-title').text('Creación de Entrada');
                    $('#guardar_entradas').show();
                    $('#modificar_entradas').hide();
                }else if (action === 'edit'){
                    modal.find('.modal-title').text('Actualizar Entrada');
                    $('#guardar_entradas').hide();
                    $('#modificar_entradas').show();
                }else if (action === 'see'){
                    modal.find('.modal-title').text('Ver Entrada');
                    $('#guardar_entradas').hide();
                    $('#modificar_entradas').hide();

                }
                $('#fecha').focus();

            });

}
//});