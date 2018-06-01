<?php

class ReportesController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	
	public function index(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			
			$usuarios = new UsuariosModel();
	
			$nombre_controladores = "Reportes";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
				if(isset($_POST['buscar']))
				{
					  
					$parametros = array();
					 
					$parametros['tipo_reporte']=isset($_POST['tipo_reporte'])?trim($_POST['tipo_reporte']):'';
					//$parametros['id_usuarios'] = $_SESSION['id_usuarios']?trim($_SESSION['id_usuarios']):'';
					
					
					
					
					$pagina="conReportes.aspx";
					 
					$conexion_rpt = array();
					$conexion_rpt['pagina']=$pagina;
					$conexion_rpt['port']="59584";
					 
					$this->view("ReporteRpt", array(
							"parametros"=>$parametros,"conexion_rpt"=>$conexion_rpt
					));
					 
					die();
					 
				}
				
					
					
				$this->view("Reportes",array(
						"resultSet"=>""
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Reportes"
		
				));
					
			}
				
	
		}
		else
		{
		$error = TRUE;
	   	$mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
	   		
	   	$this->view("Login",array(
	   			"resultSet"=>"$mensaje", "error"=>$error
	   	));
	   		
	   		
	   	die();
				
		}
	
	}
	
	
	
}
?>