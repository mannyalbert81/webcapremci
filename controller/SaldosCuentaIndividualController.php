<?php

class SaldosCuentaIndividualController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		session_start();
     	$roles=new RolesModel();
		$resultSet=$roles->getAll("id_rol");
			
		$afiliado_transacc_cta_ind = new Afiliado_transacc_cta_indModel();
		$afiliado_transacc_cta_desemb = new Afiliado_transacc_cta_desembModel();
		
		$ordinario_solicitud = new Ordinario_SolicitudModel();
		$ordinario_detalle = new Ordinario_DetalleModel();
		
		$emergente_solicitud = new Emergente_SolicitudModel();
		$emergente_detalle = new Emergente_DetalleModel();
		
		$c2x1_solicitud = new C2x1_solicitudModel();
		$c2x1_detalle = new C2x1_detalleModel();
		
		$participe = new ParticipeModel();
		
		
		
		$resultEdit = "";
		$resultDatos_Cta_individual="";
		$resultDatosMayor_Cta_individual="";
		$resultDatos_Cta_desembolsar="";
		$resultDatosMayor_Cta_desembolsar="";
		$resultCredOrdi_Detall="";
		$resultCredOrdi_Cabec="";
		$resultCredEmer_Detall="";
		$resultCredEmer_Cabec="";
		$resultCred2_x_1_Detall="";
		$resultCred2_x_1_Cabec="";
		$resultParticipe="";
		
		
		
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
		
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{

			$nombre_controladores = "SaldosCuentaIndividual";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $roles->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{	
				
				$cedula_usuarios = $_SESSION["cedula_usuarios"];
				
				if(!empty($cedula_usuarios)){
					
					$columnas_ind="afiliado_transacc_cta_ind.id_afiliado_transacc_cta_ind,
						  afiliado_transacc_cta_ind.ordtran,
						  afiliado_transacc_cta_ind.histo_transacsys,
						  afiliado_transacc_cta_ind.cedula,
						  afiliado_transacc_cta_ind.fecha_conta,
						  afiliado_transacc_cta_ind.descripcion,
						  afiliado_transacc_cta_ind.mes_anio,
						  afiliado_transacc_cta_ind.valorper,
						  afiliado_transacc_cta_ind.valorpat,
						  afiliado_transacc_cta_ind.saldoper,
						  afiliado_transacc_cta_ind.saldopat,
						  afiliado_transacc_cta_ind.id_afiliado";
					$tablas_ind="public.afiliado_transacc_cta_ind";
					$where_ind="1=1 AND afiliado_transacc_cta_ind.cedula='$cedula_usuarios'";
					$id_ind="afiliado_transacc_cta_ind.ordtran";
					$resultDatos_Cta_individual=$afiliado_transacc_cta_ind->getCondicionesDesc($columnas_ind, $tablas_ind, $where_ind, $id_ind);
					
					
					$columnas_ind_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
					$tablas_ind_mayor="afiliado_transacc_cta_ind";
					$where_ind_mayor="cedula='$cedula_usuarios'";
					$resultDatosMayor_Cta_individual=$afiliado_transacc_cta_ind->getCondicionesValorMayor($columnas_ind_mayor, $tablas_ind_mayor, $where_ind_mayor);
					
					
					
					$columnas_desemb="afiliado_transacc_cta_desemb.id_afiliado_transacc_cta_desemb,
						  afiliado_transacc_cta_desemb.ordtran,
						  afiliado_transacc_cta_desemb.histo_transacsys,
						  afiliado_transacc_cta_desemb.cedula,
						  afiliado_transacc_cta_desemb.fecha_conta,
						  afiliado_transacc_cta_desemb.descripcion,
						  afiliado_transacc_cta_desemb.mes_anio,
						  afiliado_transacc_cta_desemb.valorper,
						  afiliado_transacc_cta_desemb.valorpat,
						  afiliado_transacc_cta_desemb.saldoper,
						  afiliado_transacc_cta_desemb.saldopat,
						  afiliado_transacc_cta_desemb.id_afiliado";
					$tablas_desemb="public.afiliado_transacc_cta_desemb";
					$where_desemb="1=1 AND afiliado_transacc_cta_desemb.cedula='$cedula_usuarios'";
					$id_desemb="afiliado_transacc_cta_desemb.ordtran";
					$resultDatos_Cta_desembolsar=$afiliado_transacc_cta_desemb->getCondicionesDesc($columnas_desemb, $tablas_desemb, $where_desemb, $id_desemb);
					
					
					
					$columnas_desemb_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
					$tablas_desemb_mayor="afiliado_transacc_cta_desemb";
					$where_desemb_mayor="cedula='$cedula_usuarios'";
					$resultDatosMayor_Cta_desembolsar=$afiliado_transacc_cta_desemb->getCondicionesValorMayor($columnas_desemb_mayor, $tablas_desemb_mayor, $where_desemb_mayor);
					
					
					
					
					// credito ordinario
					
					$columnas_ordi_cabec ="*";
					$tablas_ordi_cabec="ordinario_solicitud";
					$where_ordi_cabec="cedula='$cedula_usuarios'";
					$id_ordi_cabec="cedula";
					$resultCredOrdi_Cabec=$ordinario_solicitud->getCondicionesDesc($columnas_ordi_cabec, $tablas_ordi_cabec, $where_ordi_cabec, $id_ordi_cabec);
						
					if(!empty($resultCredOrdi_Cabec)){
						
						$_numsol_ordinario=$resultCredOrdi_Cabec[0]->numsol;
						
						if($_numsol_ordinario != ""){
							
							$columnas_ordi_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
								
							$tablas_ordi_detall="ordinario_detalle";
							$where_ordi_detall="numsol='$_numsol_ordinario'";
							$id_ordi_detall="pago";
							$resultCredOrdi_Detall=$ordinario_detalle->getCondicionesDesc($columnas_ordi_detall, $tablas_ordi_detall, $where_ordi_detall, $id_ordi_detall);
							
							
						}
						
						
					}
					
						
					
					
					// credito emergente
					
					$columnas_emer_cabec ="*";
					$tablas_emer_cabec="emergente_solicitud";
					$where_emer_cabec="cedula='$cedula_usuarios'";
					$id_emer_cabec="cedula";
					$resultCredEmer_Cabec=$emergente_solicitud->getCondicionesDesc($columnas_emer_cabec, $tablas_emer_cabec, $where_emer_cabec, $id_emer_cabec);
						
						
					if(!empty($resultCredEmer_Cabec)){
					
						$_numsol_emergente=$resultCredEmer_Cabec[0]->numsol;
					
						if($_numsol_emergente != ""){
							
							$columnas_emer_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
								
							$tablas_emer_detall="emergente_detalle";
							$where_emer_detall="numsol='$_numsol_emergente'";
							$id_emer_detall="pago";
							$resultCredEmer_Detall=$emergente_detalle->getCondicionesDesc($columnas_emer_detall, $tablas_emer_detall, $where_emer_detall, $id_emer_detall);
							
						}
					}
					
					
					// credito 2 x 1
					
					$columnas_2_x_1_cabec ="*";
					$tablas_2_x_1_cabec="c2x1_solicitud";
					$where_2_x_1_cabec="cedula='$cedula_usuarios'";
					$id_2_x_1_cabec="cedula";
					$resultCred2_x_1_Cabec=$c2x1_solicitud->getCondicionesDesc($columnas_2_x_1_cabec, $tablas_2_x_1_cabec, $where_2_x_1_cabec, $id_2_x_1_cabec);
						
					
					if(!empty($resultCred2_x_1_Cabec)){
							
						$_numsol_2x1=$resultCred2_x_1_Cabec[0]->numsol;
							
						if($_numsol_2x1 != ""){
				
					
							$columnas_2_x_1_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
							$tablas_2_x_1_detall="c2x1_detalle";
							$where_2_x_1_detall="numsol='$_numsol_2x1'";
							$id_2_x_1_detall="pago";
							$resultCred2_x_1_Detall=$c2x1_detalle->getCondicionesDesc($columnas_2_x_1_detall, $tablas_2_x_1_detall, $where_2_x_1_detall, $id_2_x_1_detall);
								
							
						}
					
					}
							
				

					// informacion participe
					
					$columnas_participe="afiliado_extras.id_afiliado_extras,
									  afiliado_extras.cedula,
									  afiliado_extras.nombre,
									  afiliado_extras.direccion,
									  afiliado_extras.telefono,
									  afiliado_extras.celular,
									  afiliado_extras.correo,
									  afiliado_extras.edad,
									  afiliado_extras.hijos,
									  afiliado_extras.sueldo,
									  afiliado_extras.fecha_ingreso,
									  afiliado_extras.estado,
									  afiliado_extras.labor,
									  afiliado_extras.observacion,
									  afiliado_extras.estado_activacion,
									  afiliado_extras.clave,
									  afiliado_extras.administrador,
									  afiliado_extras.id_afiliado,
									  afiliado_extras.id_provincias_vivienda,
									  afiliado_extras.id_cantones_vivienda,
									  afiliado_extras.id_parroquias_vivienda,
									  afiliado_extras.id_provincias_asignacion,
									  afiliado_extras.id_cantones_asignacion,
									  afiliado_extras.id_parroquias_asignacion,
									  afiliado_extras.id_sexo,
									  afiliado_extras.id_tipo_sangre,
									  afiliado_extras.id_estado_civil,
									  afiliado_extras.id_entidades,
									  afiliado_extras.id_estado";
					$tablas_participe="public.afiliado_extras";
					$where_participe="afiliado_extras.cedula='$cedula_usuarios'";
					$id_participe="afiliado_extras.cedula";
					$resultParticipe=$participe->getCondiciones($columnas_participe, $tablas_participe, $where_participe, $id_participe);
					
						
					
					
				}else{
					
					$resultDatos_Cta_individual="";
					$resultDatosMayor_Cta_individual="";
					$resultDatos_Cta_desembolsar="";
					$resultDatosMayor_Cta_desembolsar="";
					$resultCredOrdi_Detall="";
					$resultCredOrdi_Cabec="";
					$resultCredEmer_Detall="";
					$resultCredEmer_Cabec="";
					$resultCred2_x_1_Detall="";
					$resultCred2_x_1_Cabec="";
					$resultParticipe="";
					
				}
				
			
		
				
				$this->view("SaldosCuentaIndividual",array(
						"resultSet"=>$resultSet, "resultEdit" =>$resultEdit, "resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
					    "resultProvincias"=>$resultProvincias,
						"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones, "resultDatos_Cta_individual"=>$resultDatos_Cta_individual, "resultDatosMayor_Cta_individual"=>$resultDatosMayor_Cta_individual,
						"resultDatos_Cta_desembolsar"=>$resultDatos_Cta_desembolsar, "resultDatosMayor_Cta_desembolsar"=>$resultDatosMayor_Cta_desembolsar,
						"resultCredOrdi_Detall"=>$resultCredOrdi_Detall, "resultCredOrdi_Cabec"=>$resultCredOrdi_Cabec,
						"resultCredEmer_Cabec"=>$resultCredEmer_Cabec, "resultCredEmer_Detall"=>$resultCredEmer_Detall,
						"resultCred2_x_1_Detall"=>$resultCred2_x_1_Detall, "resultCred2_x_1_Cabec"=>$resultCred2_x_1_Cabec,
						"resultParticipe"=>$resultParticipe
					
				));
		
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Saldos Cuenta Individual."
				
				));
				
				exit();	
			}
				
		}
		else 
		{
				$this->view("Login",array(
						"resultSet"=>""
			
				));
		
		}
	
	}
	
	
	
	
	
	
	
	
	public function ActualizarParticipe(){
		
		session_start();
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
				
			$usuarios = new UsuariosModel();
			$participes = new ParticipeModel();
			
			if ( isset($_POST["cedula"]) )
			{
					
				$_cedula    = $_POST["cedula"];
				$_nombre     = $_POST["nombre"];
				$_direccion     = $_POST["direccion"];
				$_labor = $_POST["labor"];
				$_correo   = $_POST["correo"];
				$_telefono    = $_POST["telefono"];
				$_celular     = $_POST["celular"];
				$_id_entidades            = $_POST["id_entidades"];
				$_fecha_ingreso          = $_POST["fecha_ingreso"];
				$_sueldo           = $_POST["sueldo"];
				$_hijos          = $_POST["hijos"];
				$_edad           = $_POST["edad"];
				$_id_sexo          = $_POST["id_sexo"];
				$_id_estado_civil           = $_POST["id_estado_civil"];
				$_id_tipo_sangre          = $_POST["id_tipo_sangre"];
				$_id_estado           = $_POST["id_estado"];
				$_id_provincias_vivienda          = $_POST["id_provincias_vivienda"];
				$_id_cantones_vivienda          = $_POST["id_cantones_vivienda"];
				$_id_parroquias_vivienda         = $_POST["id_parroquias_vivienda"];
				$_id_provincias_asignacion          = $_POST["id_provincias_asignacion"];
				$_id_cantones_asignacion          = $_POST["id_cantones_asignacion"];
				$_id_parroquias_asignacion         = $_POST["id_parroquias_asignacion"];
				$_observacion        = $_POST["observacion"];
				
				
				
				try {
					
					
					$colval = "nombre= '$_nombre',
					direccion = '$_direccion',
					labor = '$_labor',
					correo='$_correo',
					telefono = '$_telefono',
					celular = '$_celular',
					id_entidades = '$_id_entidades',
					sueldo = '$_sueldo',
					hijos = '$_hijos',
					edad = '$_edad',
					id_sexo = '$_id_sexo',
					id_estado_civil = '$_id_estado_civil',
					id_tipo_sangre = '$_id_tipo_sangre',
					id_provincias_vivienda = '$_id_provincias_vivienda',
					id_cantones_vivienda = '$_id_cantones_vivienda',
					id_parroquias_vivienda = '$_id_parroquias_vivienda',
					id_provincias_asignacion = '$_id_provincias_asignacion',
					id_cantones_asignacion = '$_id_cantones_asignacion',
					id_parroquias_asignacion = '$_id_parroquias_asignacion',
					observacion = '$_observacion'";
					
					$tabla = "afiliado_extras";
					
					$where = "cedula = '$_cedula'";
					
					$resultado=$participes->UpdateBy($colval, $tabla, $where);
					
					
					
				} catch (Exception $e) {
					
					$this->redirect("SaldosCuentaIndividual", "index");
					
				}
	
				
				
				
				if($_correo!=""){
					try {
						$colval1 = "nombre_usuarios= '$_nombre',
						correo_usuarios='$_correo',
						telefono_usuarios = '$_telefono',
						celular_usuarios = '$_celular'";
						
						$tabla1 = "usuarios";
						
						$where1 = "cedula_usuarios = '$_cedula'";
						
						$resultado=$usuarios->UpdateBy($colval1, $tabla1, $where1);
					} catch (Exception $e) {
					}
					
				}
					
					
				$this->redirect("SaldosCuentaIndividual", "index");
	
	
			}
			else
			{
				
				$this->redirect("SaldosCuentaIndividual", "index");
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