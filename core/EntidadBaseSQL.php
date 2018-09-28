<?php
class EntidadBaseSQL{
    
    private $con;
    
    
    public function __construct() {
        require_once 'ConectarSQL.php';
        $db = new ConectarSQL();
        $this->con=$db->conexion();
     }
    
     

    public function getCondiciones($columnas ,$tablas , $where, $id){
    	
    	$query=sqlsrv_query($this->con, "SELECT $columnas FROM $tablas WHERE $where ORDER BY $id  ASC");
    	$resultSet = array();
    	while ($row = sqlsrv_fetch_object($query)) {
    		$resultSet[]=$row;
    	}
    
    	return $resultSet;
    }
    
    
}
?>
