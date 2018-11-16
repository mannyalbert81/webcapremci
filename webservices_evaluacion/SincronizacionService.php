<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();

$da = new ConectarService();
$conn = $da->conexion();


if(isset($_GET['cedula']))
{
	$_cedula=trim($_GET['cedula']);
	$_calificacion=trim($_GET['calificacion']);
	$_imei=trim($_GET['imei']);
	
	$_id_usuarios=0;
	$resultado=$db->getBy("usuarios", "cedula_usuarios='$_cedula'");
	
	
	$resultadosJson="";
	$listUsr = [];
	if(!empty($resultado))
	{
		$result_imei=$db->getBy("asignacion_tablet_funcionarios", "serial_tablet='$_imei'");
		
		
		if(!empty($result_imei)){
			$_id_usuarios_funcionario=$result_imei[0]->id_usuarios_funcionario;
				
		}else{
			$_id_usuarios_funcionario=0;
		}
		
		
		
	foreach ($resultado as $res){
		
		$_id_usuarios=$res->id_usuarios;
		
		$rowfoto = new stdClass();
		
		$rowfoto->id_usuarios = $res->id_usuarios;
		$rowfoto->nombre_usuarios = $res->nombre_usuarios;
		$listUsr[]=$rowfoto;
		
		
	}
		
	if($_id_usuarios>0 && $_id_usuarios_funcionario>0){
		
		if(!$conn){
			
			
		}else{
			
			$sql="INSERT INTO evaluacion_funcionarios (id_evaluacion_funcionarios, id_usuarios_participe, id_usuarios_funcionario, calificacion_funcionario) VALUES (DEFAULT,'$_id_usuarios','$_id_usuarios_funcionario', '$_calificacion')";
			$query_new_insert = pg_query($conn,$sql);
			
		
			
		}
		
		
		$resultadosJson = json_encode($listUsr);
		echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
		
		
	}else{ 
		die();
	}
	
		
	}else{ 
		die();
	}
	
	
} 
			



?>
	