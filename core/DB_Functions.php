<?php


class DB_Functions {

	private $conn;

	// constructor
	function __construct() {
		require_once 'ConectarService.php';
		// connecting to database
		$db = new ConectarService();
		$this->conn = $db->conexion();
	}

	// destructor
	function __destruct() {
		 
	}

	
	
	public function encriptar($cadena){
		$key='rominajasonrosabal';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
		return $encrypted; //Devuelve el string encriptado
	
	}
	
	public function desencriptar($cadena){
		$key='rominajasonrosabal';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		return $decrypted;  //Devuelve el string desencriptado
	}
	
	public function getBy($tabla, $where){
			
		$query=pg_query($this->conn, "SELECT * FROM $tabla WHERE $where ");
		$resultSet = array();
			
		while ($row = pg_fetch_object($query)) {
			$resultSet[]=$row;
		}
		return $resultSet;
	}
	
	public function getCondiciones($columnas, $tabla, $where){
			
		$query=pg_query($this->conn, "SELECT $columnas FROM $tabla WHERE   $where ");
		$resultSet = array();
			
		while ($row = pg_fetch_object($query)) {
			$resultSet[]=$row;
		}
		return $resultSet;
	}
	
	public function getCondicionesValorMayor($columnas ,$tablas , $where){
	
		$query=pg_query($this->conn, "SELECT $columnas FROM $tablas WHERE $where");
		$resultSet = array();
		while ($row = pg_fetch_object($query)) {
			$resultSet[]=$row;
		}
	
		return $resultSet;
	}
	
	
	
	public function getCondicionesDesc($columnas ,$tablas , $where, $id){
	
		$query=pg_query($this->conn, "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  DESC");
		$resultSet = array();
		while ($row = pg_fetch_object($query)) {
			$resultSet[]=$row;
		}
	
		return $resultSet;
	}
	
}

?>


