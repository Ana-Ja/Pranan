<?php
//require_once "config.php";
define("DB_DSN","mysql:dbname=pranan");
define("DB_usuario","root");
define("DB_PASSWORD","");
define("PAGE_SIZE",5);
define("TBL_ARTICULOS", "articulos");
define("TBL_PRODUCTOS", "productos");
define("TBL_PROVEEDORES", "proveedores");
define("TBL_COMPOSICIONES", "composiciones");
define("TBL_ENTRADAS", "entradas");
define("TBL_COMUNIDADES", "comunidades");
define("TBL_PROVINCIAS", "provincias");
define("TBL_MUNICIPIOS", "municipios");
define("PAGE_SIZE_ENTRADAS",10);
define("DIR_DOCUMENTA","recursos/docu/");
define("DIR_FOTOS","recursos/images/");
define("TAMANO_IMAGEN",1000000);



abstract class dataObject{
	//este $data contendra la definicion de la tablabd cuando se defina su estructura
//dentro la la clase correspondiente a cada tabla bd
	protected $data= array();

//me pasan una tabla que contiene un registro leido en la tablabd
//miro si las claves de esa tabla(quew son los campos de la tabla leida)
//coinciden con las claves de $data que contiene un array con los nombres
//de la tablabd y sus valores a ""
	public function __construct($data) {
		foreach ($data as $key=> $value) {
			if (array_key_exists($key, $this->data)) $this->data[$key]=$value;
		}
	}

	public function getValue($field) {
		if (array_key_exists($field, $this->data)) {
			return $this->data[$field];
		} else {
			die("Campo no encontrado ".$field);
		}
	}

	public function getValueEncoded($field) {
		//por si hay alguna caraceres que pasar a html como un & o acentos
		return htmlspecialchars($this->getValue($field));
	}
	protected static function connect(){
		try {
/*$host = "mysql.hostinger.es";
$usuario = "u327725143_uned";
$password = "UNED2017";
$conn= new PDO("mysql:host=$host;dbname=u327725143_uned",$usuario,$password);*/

			$conn= new PDO( DB_DSN, DB_usuario, DB_PASSWORD);
			$conn->setAttribute( PDO::ATTR_PERSISTENT, true );
			$conn-> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$conn->exec("SET CHARACTER SET utf8");

		} catch (PDOException $e) {
			die("Conexion fallida: " .$e_getMessage());
		}
		return $conn;

	}
	protected static function disconnect($conn) {
		$conn="";
	}
}
?>