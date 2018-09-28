<?php

class SolicitudPrestamoController extends ControladorBase{

	public function __construct() {
		parent::__construct();
		
	}


	
	
	
	
	
	
	
	public function index(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			
			$solicitud_prestamo = new SolicitudPrestamoModel();
			
			

			$sexo= new SexoModel();
			$resultSexo = $sexo->getAll("nombre_sexo");
				
			$estado_civil= new Estado_civilModel();
			$resultEstado_civil = $estado_civil->getAll("nombre_estado_civil");
				
			$tipo_sangre= new Tipo_sangreModel();
			$resultTipo_sangre = $tipo_sangre->getAll("nombre_tipo_sangre");
				
			$estado = new EstadoModel();
			$resultEstado= $estado->getAll("nombre_estado");
				
			$entidades = new EntidadesModel();
			$resultEntidades= $entidades->getAll("nombre_entidades");
				
			$provincias = new ProvinciasModel();
			$resultProvincias= $provincias->getAll("nombre_provincias");
				
			$parroquias = new ParroquiasModel();
			$resultParroquias= $parroquias->getAll("nombre_parroquias");
				
			$cantones = new CantonesModel();
			$resultCantones= $cantones->getAll("nombre_cantones");
			
			$nombre_controladores = "SolicitudPrestamo";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitud_prestamo->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
					
				$this->view("SolicitudPrestamo",array(
						"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
					    "resultProvincias"=>$resultProvincias,
						"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones
						
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a llenar una solicitud de prestamo."
		
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