<?php
//igual lo podria usar para limpiar los actchivos subidos
//http://fernando-gaitan.com.ar/subir-archivos-con-ajax-y-mostrar-precarga/
if (isset($_POST['archivo'])) {
    $archivo = $_POST['archivo'];
    if (file_exists("archivos_subidos/$archivo")) {
        unlink("archivos_subidos/$archivo");
        echo 1;
    } else {
        echo 0;
    }
}
?>
