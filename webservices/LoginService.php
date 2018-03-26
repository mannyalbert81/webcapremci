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
				
				
					$listUsr = [];
				
					foreach ($resultado as $res)
					{
						$rowfoto = new stdClass();
						
						$rowfoto->id_usuarios = $res->id_usuarios;
						$rowfoto->cedula_usuarios = $res->cedula_usuarios;
						$rowfoto->nombre_usuarios = $res->nombre_usuarios;
						$rowfoto->correo_usuarios = $res->correo_usuarios;
						$rowfoto->id_rol = $res->id_rol;
						$rowfoto->id_estado = $res->id_estado;
						$rowfoto->fotografia_usuarios=base64_encode(pg_unescape_bytea($res->fotografia_usuarios));//$res->foto_fichas_fotos;
						$listUsr[]=$rowfoto;
					}
				
				
				
					echo json_encode($listUsr);
				die();
				
			}else{
				// no existe el usuarios va vacio.
				$resultadosJson = "";
				die();
			}
			
		}else{
			// no vienen los datos
			$resultadosJson = "";
			die();
		}
	   
		
		
		
	}
	else{
		
		echo "No podemos establecer conexión, intentelo mas tarde.";
		die();
	}




	