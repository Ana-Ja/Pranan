<!DOCTYPE html>
<html lang="es">

<head><meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">


<title><?php echo $titulo ?></title>
 <link rel="shortcut icon" href="<?php echo $raiz; ?>images/favicon.ico" type="image/x-icon" />

<link rel="stylesheet" href="<?php echo $raiz; ?>jquery-ui-1.11.4.custom/jquery-ui.min.css" />
<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<link rel='stylesheet' type='text/css' href='<?php echo $raiz; ?>/css/estilos.css'/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
  <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
  <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">


<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

<script src="<?php echo $raiz; ?>jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

<script src="<?php echo $raiz; ?>js/jquery.ui.datepicker-es.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script></head>

  <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.easyui.min.js"></script>
  <script type="text/javascript" src="http://www.jeasyui.com/easyui/jquery.edatagrid.js"></script>
  <script type="text/javascript" src="http://www.jeasyui.com/easyui/datagrid-detailview.js"></script>
<script type="text/javascript" src="<?php echo $raiz; ?>js/uploader.js"></script>
<script type="text/javascript" src="<?php echo $raiz; ?>js/modales.js"></script>

</head>
<body>
  <div class="container">
     <nav class="navbar navbar-inverse ">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#miMenu">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>


               <a class="navbar-brand" href="<?php echo $raiz;?>views/articulos/ver_articulos.php">UNED</a>

        </div>
        <div class="collapse navbar-collapse" id="miMenu">
          <ul class="nav navbar-nav">

                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Articu <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $raiz; ?>socios/ver_socios.php">Mantenimiento de Socios</a></li>
                    <li><a href="<?php echo $raiz; ?>socios/ver_noticias.php">Mantenimiento Noticias</a></li>
                   <li><a href="<?php echo $raiz; ?>socios/ver_usuarios.php">Mantenimiento Usuarios</a></li>

                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo $raiz; ?>socios/subir_archivos.php">Subir Documentación</a></li>
                    <li><a href="<?php echo $raiz; ?>socios/documentos.php">Bajar Documentación</a></li>
                  </ul>
                </li>




                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Socios <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo $raiz; ?>socios/ver_noticias.php">Noticias</a></li>
                     <li><a href="<?php echo $raiz; ?>socios/documentos.php">Bajar Documentación</a></li>
                     <li><a href="<?php echo $raiz; ?>socios/subir_archivos.php">Subir Documentación</a></li>
                  </ul>
                </li>


            <li id="desc"><a href="<?php echo $raiz;?>views/articulos/ver_articulos.php" >Articulos</a></li>
            <li id="desc"><a href="<?php echo $raiz;?>views/productos/ver_productos.php" >Productos</a></li>
             <li id="desc"><a href="<?php  echo $raiz;?>views/composicion/listacompo.php" >Lista Composiciones</a></li>
            <li id="desc"><a href="<?php  echo $raiz;?>views/entradas/ver_entradas.php" >Entradas</a></li>








          </ul>

        </div>
      </div> <!--  fin conteiner fluid -->
      </nav>
<div id="wrapper"><!--  no borrar si no se estropea el footer -->

