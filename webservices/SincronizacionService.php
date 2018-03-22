<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();

if(isset($_GET['id_usuario']))
{
	$_id_usuario=trim($_GET['id_usuario']);
	$columnas = "
  				us.id_usuario,
				us.nombres_usuario,
 				us.apellidos_usuario,
 			 	us.usuario_usuario,
  				us.celular_usuario,
  				us.telefono_usuario,
			    es.nombre_estado";
	
	$tabla = "usuarios us INNER JOIN  estado es
				ON us.id_estado = es.id_estado";
	$where = "us.id_usuario = '$_id_usuario' AND es.nombre_estado='ACTIVO' ";
	
	
	$resultado = $db->getCondiciones($columnas, $tabla, $where);
	$resultadosJson="";
	
	if(!empty($resultado))
	{
		$listusuario = [];
		foreach ($resultado as $res)
		{
			$rowlist = new stdClass();	
			$rowlist->id_usuario = $res->id_usuario;
			$rowlist->nombres_usuario = $res->nombres_usuario;
			$rowlist->apellidos_usuario = $res->apellidos_usuario;
			$rowlist->usuario_usuario = $res->usuario_usuario;
			$rowlist->celular_usuario = $res->celular_usuario;
			$rowlist->telefono_usuario = $res->telefono_usuario;
			$rowlist->nombre_estado = $res->nombre_estado;
			$listusuario[]=$rowlist;
		}
		
		$resultadosJson = json_encode($listusuario);
		
	}else{ 
		//$resultadosJson=json_encode(array(array('nombres'=>1,'apellidos'=>1,'usuario'=>1,'celular'=>1,'telefono'=>1)));
		echo "No existe Usuario";
	}
	
	echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
} 
			



?>
	