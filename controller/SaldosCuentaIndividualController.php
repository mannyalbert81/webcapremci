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
				$where_ind="1=1 AND afiliado_transacc_cta_ind.cedula='1304924341'";
				$id_ind="afiliado_transacc_cta_ind.ordtran";
				$resultDatos_Cta_individual=$afiliado_transacc_cta_ind->getCondicionesDesc($columnas_ind, $tablas_ind, $where_ind, $id_ind);
				
				
				$columnas_ind_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
				$tablas_ind_mayor="afiliado_transacc_cta_ind";
				$where_ind_mayor="cedula='1304924341'";
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
				$where_desemb="1=1 AND afiliado_transacc_cta_desemb.cedula='1304924341'";
				$id_desemb="afiliado_transacc_cta_desemb.ordtran";
				$resultDatos_Cta_desembolsar=$afiliado_transacc_cta_desemb->getCondicionesDesc($columnas_desemb, $tablas_desemb, $where_desemb, $id_desemb);
				
				
				
				$columnas_desemb_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
				$tablas_desemb_mayor="afiliado_transacc_cta_desemb";
				$where_desemb_mayor="cedula='1304924341'";
				$resultDatosMayor_Cta_desembolsar=$afiliado_transacc_cta_desemb->getCondicionesValorMayor($columnas_desemb_mayor, $tablas_desemb_mayor, $where_desemb_mayor);
				
				
				
				// credito ordinario
				
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
				$where_ordi_detall="numsol='18943'";
				$id_ordi_detall="pago";
				$resultCredOrdi_Detall=$ordinario_detalle->getCondicionesDesc($columnas_ordi_detall, $tablas_ordi_detall, $where_ordi_detall, $id_ordi_detall);
				
				
				
				$columnas_ordi_cabec ="*";
				$tablas_ordi_cabec="ordinario_solicitud";
				$where_ordi_cabec="cedula='1304924341'";
				$id_ordi_cabec="cedula";
				$resultCredOrdi_Cabec=$ordinario_solicitud->getCondicionesDesc($columnas_ordi_cabec, $tablas_ordi_cabec, $where_ordi_cabec, $id_ordi_cabec);
				
				
				// credito emergente
				
				
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
				$where_emer_detall="numsol='4770'";
				$id_emer_detall="pago";
				$resultCredEmer_Detall=$emergente_detalle->getCondicionesDesc($columnas_emer_detall, $tablas_emer_detall, $where_emer_detall, $id_emer_detall);
				
					
				
				$columnas_emer_cabec ="*";
				$tablas_emer_cabec="emergente_solicitud";
				$where_emer_cabec="cedula='1707540843'";
				$id_emer_cabec="cedula";
				$resultCredEmer_Cabec=$emergente_solicitud->getCondicionesDesc($columnas_emer_cabec, $tablas_emer_cabec, $where_emer_cabec, $id_emer_cabec);
				
				
				
				// credito 2 x 1
				
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
				$where_2_x_1_detall="numsol='6947'";
				$id_2_x_1_detall="pago";
				$resultCred2_x_1_Detall=$c2x1_detalle->getCondicionesDesc($columnas_2_x_1_detall, $tablas_2_x_1_detall, $where_2_x_1_detall, $id_2_x_1_detall);
				
					
				
				$columnas_2_x_1_cabec ="*";
				$tablas_2_x_1_cabec="c2x1_solicitud";
				$where_2_x_1_cabec="cedula='1700519133'";
				$id_2_x_1_cabec="cedula";
				$resultCred2_x_1_Cabec=$c2x1_solicitud->getCondicionesDesc($columnas_2_x_1_cabec, $tablas_2_x_1_cabec, $where_2_x_1_cabec, $id_2_x_1_cabec);
				
				
				
				
				// informacion participe
				
				
				$columnas_participe="afiliado_extras.id_afiliado_extras, 
									  afiliado_extras.cedula, 
									  afiliado_extras.nombre, 
									  afiliado_extras.direccion, 
									  afiliado_extras.telefono, 
									  afiliado_extras.celular, 
									  afiliado_extras.correo, 
									  afiliado_extras.edad, 
									  afiliado_extras.idgenerosexual, 
									  afiliado_extras.idtiposangre, 
									  afiliado_extras.idestadocivil, 
									  afiliado_extras.hijos, 
									  afiliado_extras.sueldo, 
									  afiliado_extras.entidad, 
									  afiliado_extras.fecha_ingreso, 
									  afiliado_extras.estado, 
									  afiliado_extras.labor, 
									  afiliado_extras.observacion, 
									  afiliado_extras.idprovinciavivienda, 
									  afiliado_extras.idcantonvivienda, 
									  afiliado_extras.idparroquiavivienda, 
									  afiliado_extras.idprovinciaasignacion, 
									  afiliado_extras.idcantonasignacion, 
									  afiliado_extras.idparroquiaasignacion, 
									  afiliado_extras.estado_activacion, 
									  afiliado_extras.clave, 
									  afiliado_extras.administrador, 
									  afiliado_extras.id_afiliado";
				$tablas_participe="public.afiliado_extras";
				$where_participe="afiliado_extras.cedula='1700519133'";
				$id_participe="afiliado_extras.cedula='1700519133'";
				$resultParticipe=$participe->getCondiciones($columnas_participe, $tablas_participe, $where_participe, $id_participe);
				
				
				
				
				
				
				
				if (isset ($_GET["id_rol"])   )
				{

					$nombre_controladores = "Roles";
					$id_rol= $_SESSION['id_rol'];
					$resultPer = $roles->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
						
					if (!empty($resultPer))
					{
					
						$_id_rol = $_GET["id_rol"];
						$columnas = " id_rol, nombre_rol ";
						$tablas   = "rol";
						$where    = "id_rol = '$_id_rol' "; 
						$id       = "nombre_rol";
							
						$resultEdit = $roles->getCondiciones($columnas ,$tablas ,$where, $id);

					}
					else
					{
						$this->view("Error",array(
								"resultado"=>"No tiene Permisos de Editar Roles"
					
						));
					
					
					}
					
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
						"resultado"=>"No tiene Permisos de Acceso a Roles"
				
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
	
	
	
}
?>