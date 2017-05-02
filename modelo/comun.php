<?php

include_once( "articulo.class.php" );
include_once( "proveedor.class.php" );
include_once( "producto.class.php" );
include_once( "composicion.class.php" );
include_once( "entrada.class.php" );




function validateField($fieldName, $missingFields) {
	if (in_array($fieldName,  $missingFields)) {
		//echo ' class ="error"';
			echo 'error';
	}
}

function setChecked(DataObject $obj, $fieldName, $fieldValue) {
	//espera un objeto derivado de la clase DataObject como puede ser un Socio o un Accesos
	if ( $obj->getValue($fieldName) == $fieldValue) {
		echo ' checked=checked"';
	}
}


function setSelected(DataObject $obj, $fieldName, $fieldValue) {
	if ( $obj->getValue($fieldName) == $fieldValue) {
		echo ' selected=selected"';
	}
}


function setSelectedNormal($fieldName, $fieldValue) {
	if ( $fieldName == $fieldValue) {
		echo ' selected=selected"';
	}
}

function checkLogin() {
	session_start();
	//compruebo si existe un objeto Socio almacenado en la variable de sesion, lo cual indica que se ha conectado alguien
	//y ademas vuelvo a cargar el objeto Socio desde la Bd con Socio->getSocio para asgurarnos que los datos guardados
	//en $_SESSIONson actuales y que sigue existiendo el miembro conectado
	if (isset($_SESSION["Socio"]) ) {
		if (!$_SESSION["Socio"] or !$_SESSION["Socio"]=Socio::getSocio($_SESSION["Socio"]->getValue("idSocio"))) {

//	if (!$_SESSION["Socio"] ) {
			$_SESSION["Socio"]="";
			header("Location:../socios/login.php");
			exit(0);
		} else {

			$Accesos=new Accesos(array(
					"idSocio"=> $_SESSION["Socio"]->getValue("idSocio"),
					"urlPagina"=>basename($_SERVER["PHP_SELF"])
					));

			$Accesos->record();
		}
	}else{
return false;	}
}

function muestraDia($fecha) {
	if ($fecha != "0000-00-00"){

    $dia= substr($fecha,8,10);

   $mes = substr($fecha,5,2);

    $anio =substr($fecha,0,4);

    $texfecha=$dia . "/" . $mes . "/" .$anio;
	  return $texfecha;
} else {
	return "";
}

   }
   function comparaFechas($fecha1, $fecha2){
    $fecha1= date_create_from_format('Y-m-d', $fecha1);
    $fecha1 =$fecha1->format("Y-m-d");
    $fecha2= date_create_from_format('Y-m-d', $fecha2);
    $fecha2 =$fecha2->format("Y-m-d");
   // print_r($fecha1);
  // print_r($fecha2);
    if ($fecha1>$fecha2) {
  //  		echo "Fecha 1 mayor que fecha2 true";
    	return  true;}
    if ($fecha1<=$fecha2)  {
  //  		echo "Fecha 1 menor que fecha2 false";
    	return  false;}
   }
function  guardarImagen($_files){

$mensajesError=array();
    $tipo_imagen = $_files["imagen"]["type"];

    $tamano_imagen = $_files["imagen"]["size"];
    if ($tamano_imagen <=TAMANO_IMAGEN){
        if ($tipo_imagen=="image/jpeg" || $tipo_imagen=="image/gif" || $tipo_imagen=="image/png" || $tipo_imagen=="application/pdf"){
          //ruta de la carpeta destino en el setrvodor
       //   $carpeta_destino=$_SERVER["DOCUMENT_ROOT"]."/images/noticias/";


	          //indocamos que se muueva de la carpeta temporal al direc. destino de mi servidor
		         if ( !move_uploaded_file($_files["imagen"]["tmp_name"], "../../".DIR_FOTOS.basename($_files["imagen"]["name"]))){
		           $mensajesError['imagen']='<p class="error" >Hay un problema con la carga del archivo. </p>". $_files["archivo"]["error"]</p>';
		         } else {
		         	if ($tipo_imagen!="application/pdf"){
		         			$ruta= "../../".DIR_FOTOS.basename($_files["imagen"]["name"]);
		         	   crearThumbnailRecortado($ruta,$ruta, 85, 85);
						 }
	         }
        }else{
          $mensajesError['imagen']='<p class="error" >Solo se puede subir imagenes .gif, .jpg, .png</p>';
        }
    }else{
      $mensajesError['imagen']='<p class="error" >El tamaño debe ser menor a 1MG</p>';
    }
    return  $mensajesError;


}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function check_date($str){
                trim($str);
                $trozos = explode ("-", $str);
                $año=$trozos[0];
                $mes=$trozos[1];
                $dia=$trozos[2];
                if(checkdate ($mes,$dia,$año)){
                return true;
                }
                else{
                return false;
                }
}

/**
 * Funcion para validar una fecha en formato:
 *  yyyy/mm/dd, yyyy/m/d, yy/m/d
 * Devuelve true|false
 */
function validateDateEn($date)
{
	echo  "Fecha ".$date;
	if ($date != ""){
    $pattern="/^((19|20)?[0-9]{2})[\/|-](0?[1-9]|[1][012])[\/|-](0?[1-9]|[12][0-9]|3[01])$/";
      if(preg_match($pattern,$date)){
        return true;
      }else{

       return false;
      }
    }
      return true;

}

//funcio para generar la imagen de un anuncio
//recibe la url o archivo de la imagen
function genera_imagen_ciudad($archivo) {
	$nombre=explode('.',$archivo);
	$a='<img border="0" src="../images/noticias/' . $archivo. '" title="' . $nombre[0] . '" width="80" height="80" alt="imagen" />';

	return	 $a;

}

/**
 * Crea un thumbail de un imagen con el ancho y el alto pasados como parametros,
 * recortando en caso de ser necesario la dimension mas grande por ambos lados.
 *
 * @param type $nombreImagen Nombre completo de la imagen incluida la ruta y la extension.
 * @param type $nombreThumbnail Nombre completo para el thumbnail incluida la ruta y la extension.
 * @param type $nuevoAncho Ancho para el thumbnail.
 * @param type $nuevoAlto Alto para el thumbnail.
 */
function crearThumbnailRecortado($nombreImagen, $nombreThumbnail, $nuevoAncho, $nuevoAlto){

    // Obtiene las dimensiones de la imagen.
    list($ancho, $alto) = getimagesize($nombreImagen);

    // Si la division del ancho de la imagen entre el ancho del thumbnail es mayor
    // que el alto de la imagen entre el alto del thumbnail entoces igulamos el
    // alto de la imagen  con el alto del thumbnail y calculamos cual deberia ser
    // el ancho para la imagen (Seria mayor que el ancho del thumbnail).
    // Si la relacion entre los altos fuese mayor entonces el altoImagen seria
    // mayor que el alto del thumbnail.
    if ($ancho/$nuevoAncho > $alto/$nuevoAlto){
        $altoImagen = $nuevoAlto;
        $factorReduccion = $alto / $nuevoAlto;
        $anchoImagen = $ancho / $factorReduccion;
    }
    else{
        $anchoImagen = $nuevoAncho;
        $factorReduccion = $ancho / $nuevoAncho;
        $altoImagen = $alto / $factorReduccion;
    }

    // Abre la imagen original.
    list($imagen, $tipo)= abrirImagen($nombreImagen);

    // Crea la nueva imagen (el thumbnail).
    $thumbnail = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

    // Si la relacion entre los anchos es mayor que la relacion entre los altos
    // entonces el ancho de la imagen que se esta creando sera mayor que el del
    // thumbnail porlo que se centrara para que se corte por la derecha y por la
    // izquierda. Si el alto fuese mayor lo mismo se cortaria la imagen por arriba
    // y por abajo.
    if ($ancho/$nuevoAncho > $alto/$nuevoAlto){
        imagecopyresampled($thumbnail , $imagen, ($nuevoAncho-$anchoImagen)/2, 0, 0, 0, $anchoImagen, $altoImagen, $ancho, $alto);
    }  else {
        imagecopyresampled($thumbnail , $imagen, 0, ($nuevoAlto-$altoImagen)/2, 0, 0, $anchoImagen, $altoImagen, $ancho, $alto);
    }

    // Guarda la imagen.
    guardarImagenThumb($thumbnail, $nombreThumbnail, $tipo);
}

    /**
 * Abre la imagen con el nombre pasado como parametro y devuelve un array con la imagen y el tipo de imagen.
 *
 * @param type $nombre Nombre completo de la imagen incluida la ruta y la extension.
 * @return Devuelve la imagen abierta.
 */
function abrirImagen($nombre){
    $info = getimagesize($nombre);
    switch ($info["mime"]){
        case "image/jpeg":
            $imagen = imagecreatefromjpeg($nombre);
            break;
        case "image/gif":
            $imagen = imagecreatefromgif($nombre);
            break;
        case "image/png":
            $imagen = imagecreatefrompng($nombre);
            break;
        default :
            echo "Error: No es un tipo de imagen permitido.";
    }
    $resultado[0]= $imagen;
    $resultado[1]= $info["mime"];
    return $resultado;
}

/**
 * Guarda la imagen con el nombre pasado como parametro.
 *
 * @param type $imagen La imagen que se quiere guardar
 * @param type $nombre Nombre completo de la imagen incluida la ruta y la extension.
 * @param type $tipo Formato en el que se guardara la imagen.
 */
function guardarImagenThumb($imagen, $nombre, $tipo){
    switch ($tipo){
        case "image/jpeg":
            imagejpeg($imagen, $nombre, 100); // El 100 es la calidade de la imagen (entre 1 y 100. Con 100 sin compresion ni perdida de calidad.).
            break;
        case "image/gif":
            imagegif($imagen, $nombre);
            break;
        case "image/png":
            imagepng($imagen, $nombre, 9); // El 9 es grado de compresion de la imagen (entre 0 y 9. Con 9 maxima compresion pero igual calidad.).
            break;
        default :
            echo "Error: Tipo de imagen no permitido.";
    }
}


?>