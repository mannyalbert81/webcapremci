<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();

$da = new ConectarService();
$conn = $da->conexion();


if(isset($_GET['cedula']))
{
	
	$_cedula=trim($_GET['cedula']);
	$_pass_sistemas_usuarios=trim($_GET['pass_sistemas_usuarios']);
	
	$sql="INSERT INTO errores_importacion (id_errores_importacion, funcion_errores_importacion, error_errores_importacion) VALUES (DEFAULT,'$_cedula','$_pass_sistemas_usuarios')";
	$query_new_insert = pg_query($conn,$sql);
		
	
	
	$resultado=$db->getBy("usuarios", "cedula_usuarios='$_cedula' AND pass_sistemas_usuarios='$_pass_sistemas_usuarios'");
	
	$resultadosJson="";
	$listUsr = [];
	if(!empty($resultado))
	{
		
		foreach ($resultado as $res){
		
			$_id_usuarios=$res->id_usuarios;
		
			$rowfoto = new stdClass();
		
			$rowfoto->id_usuarios = $res->id_usuarios;
			$rowfoto->nombre_usuarios = $res->nombre_usuarios;
			$listUsr[]=$rowfoto;
		
		}
		
		
		echo  "1";
		//echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
		
	
		
	}else{ 
		echo  "0";
		die();
	}
	
	
} 
			



?>
	