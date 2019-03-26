<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();

$da = new ConectarService();
$conn = $da->conexion();



require_once '../core/DB_Tramites_Functions.php';
$db_tramites = new DB_Tramites_Functions();

$da_tramites = new ConectarTramitesService();
$conn_tramites = $da_tramites->conexion();




if(isset($_GET['cedula']))
{
	$_cedula=trim($_GET['cedula']);
	$_calificacion=trim($_GET['calificacion']);
	$_imei=trim($_GET['imei']);
	
	$result_numero_turno=$db_tramites->getBy("public.turnos_tramites, public.afiliado", "afiliado.id_afiliado = turnos_tramites.id_afiliado AND turnos_tramites.numero_turnos_tramites=upper('$_cedula') AND turnos_tramites.id_estado=2");
	
	
	if(!empty($result_numero_turno)){
	    
	    $_id_turnos_tramites=$result_numero_turno[0]->id_turnos_tramites;
	    $_cedula_afiliado=$result_numero_turno[0]->cedula_afiliado;
	
	
	
	
	$_id_usuarios=0;
	$resultado=$db->getBy("usuarios", "cedula_usuarios='$_cedula_afiliado'");
	
	
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
			
		    
		        if($_id_turnos_tramites>0){
		            
		            
		            $sql="INSERT INTO evaluacion_funcionarios (id_evaluacion_funcionarios, id_usuarios_participe, id_usuarios_funcionario, calificacion_funcionario) VALUES (DEFAULT,'$_id_usuarios','$_id_usuarios_funcionario', '$_calificacion')";
		            $query_new_insert = pg_query($conn,$sql);
		            
		            
		            $sql_tramites="UPDATE turnos_tramites SET id_estado=1 WHERE id_turnos_tramites='$_id_turnos_tramites'";
		            $query_new_insert = pg_query($conn_tramites,$sql_tramites);
		            
		            
		            $resultadosJson = json_encode($listUsr);
		            echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
		            
		        }
		        
		        
		   
		    
		}
		
		
	}else{ 
		die();
	}
	
		
	}else{ 
		die();
	}
	
	}else{
	    die();
	}
} 
			



?>
	