<?php

	require_once '../core/DB_Functions.php';
	$db = new DB_Functions();
	$resultado="";
	$accion=(isset($_POST['action']))?$_POST['action']:'';
	$_cedula_usuarios  = (isset($_POST['cedula_usuarios']))?$_POST['cedula_usuarios']:'';	
	$_clave_usuarios  = (isset($_POST['clave_usuarios']))?$_POST['clave_usuarios']:'';

	if($accion=="consulta"){
		
		if($_cedula_usuarios!="" && $_clave_usuarios!=""){
			
			$_clave=$db->encriptar($_clave_usuarios);
			$tabla="usuarios";
			$where = "cedula_usuarios = '$_cedula_usuarios' AND clave_usuarios ='$_clave'";
			$resultado=$db->getBy($tabla, $where);
			
			if(!empty($resultado)){
				// existe el usuario va lleno.
				$resultadosJson = json_encode($resultado);
				
			}else{
				// no existe el usuarios va vacio.
				$resultadosJson = "";
			}
			
		}else{
			// no vienen los datos
			$resultadosJson = "";
		}
	   
		
		echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
		
	}
	else{
		
		echo "No podemos establecer conexión, intentelo mas tarde.";
		die();
	}




	