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
				echo json_encode($resultado);
				die();
			}else{
				// no existe el usuarios va vacio.
				echo "Cedula o Contraseña Incorrecta";
				die();
			}
			
		}else{
			// no vienen los datos
			echo "No podemos establecer conexión, intentelo mas tarde.";
			die();
		}
	   
	}
	else{
		
		echo "No podemos establecer conexión, intentelo mas tarde.";
		die();
	}




	