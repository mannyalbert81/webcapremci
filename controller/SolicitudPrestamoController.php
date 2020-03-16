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
			$resultEstado_civil = $estado_civil->getBy("nombre_estado_civil<>'Ninguna' ");
				
			$tipo_sangre= new Tipo_sangreModel();
			$resultTipo_sangre = $tipo_sangre->getAll("nombre_tipo_sangre");
				
			$estado = new EstadoModel();
			$resultEstado= $estado->getAll("nombre_estado");
			
			$bancos = new BancosModel();
			$resultBancos= $bancos->getAll("id_bancos");
				
			$entidades = new EntidadesModel();
			$resultEntidades= $entidades->getAll("nombre_entidades");
				
			$provincias = new ProvinciasModel();
			$resultProvincias= $provincias->getAll("nombre_provincias");
				
			$parroquias = new ParroquiasModel();
			$resultParroquias= $parroquias->getAll("nombre_parroquias");
				
			$cantones = new CantonesModel();
			$resultCantones= $cantones->getAll("nombre_cantones");
			
			$tipo_credito = new TipoCreditoModel();
			$resultTipoCredito= $tipo_credito->getAll("nombre_tipo_creditos");
				
			
			$sucursales = new SucursalesModel();
			$resultSucursales= $sucursales->getAll("nombre_sucursales");
			
			$resultTipoParticipe=array('0'=>'--Seleccione--','Deudor'=>'Deudor', 'Garante'=>'Garante');
			
			$nombre_controladores = "SolicitudPrestamo";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitud_prestamo->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				$resultEdit="";
				
				if(isset($_GET["id_solicitud_prestamo"])){
					
					$_id_solicitud_prestamo= $_GET["id_solicitud_prestamo"];
					
					$columnas="solicitud_prestamo.id_solicitud_prestamo, 
							  solicitud_prestamo.tipo_participe_datos_prestamo, 
							  solicitud_prestamo.monto_datos_prestamo, 
							  solicitud_prestamo.plazo_datos_prestamo, 
							  solicitud_prestamo.destino_dinero_datos_prestamo, 
							  solicitud_prestamo.nombre_banco_cuenta_bancaria, 
							  solicitud_prestamo.tipo_cuenta_cuenta_bancaria, 
							  solicitud_prestamo.numero_cuenta_cuenta_bancaria, 
							  solicitud_prestamo.numero_cedula_datos_personales, 
							  solicitud_prestamo.apellidos_solicitante_datos_personales, 
							  solicitud_prestamo.nombres_solicitante_datos_personales, 
							  solicitud_prestamo.correo_solicitante_datos_personales, 
							  solicitud_prestamo.id_sexo_datos_personales, 
							  solicitud_prestamo.fecha_nacimiento_datos_personales, 
							  solicitud_prestamo.id_estado_civil_datos_personales, 
							  solicitud_prestamo.separacion_bienes_datos_personales, 
							  solicitud_prestamo.cargas_familiares_datos_personales, 
							  solicitud_prestamo.numero_hijos_datos_personales, 
							  solicitud_prestamo.nivel_educativo_datos_personales, 
							  solicitud_prestamo.id_provincias_vivienda, 
							  solicitud_prestamo.id_cantones_vivienda, 
							  solicitud_prestamo.id_parroquias_vivienda, 
							  solicitud_prestamo.barrio_sector_vivienda, 
							  solicitud_prestamo.ciudadela_conjunto_etapa_manzana_vivienda, 
							  solicitud_prestamo.calle_vivienda, 
							  solicitud_prestamo.numero_calle_vivienda, 
							  solicitud_prestamo.intersecion_vivienda, 
							  solicitud_prestamo.tipo_vivienda, 
							  solicitud_prestamo.vivienda_hipotecada_vivienda, 
							  solicitud_prestamo.tiempo_residencia_vivienda, 
							  solicitud_prestamo.nombre_propietario_vivienda, 
							  solicitud_prestamo.celular_propietario_vivienda, 
							  solicitud_prestamo.referencia_direccion_domicilio_vivienda, 
							  solicitud_prestamo.numero_casa_solicitante, 
							  solicitud_prestamo.numero_celular_solicitante, 
							  solicitud_prestamo.numero_trabajo_solicitante, 
							  solicitud_prestamo.extension_solicitante, 
							  solicitud_prestamo.apellidos_referencia_personal, 
							  solicitud_prestamo.mode_solicitante, 
							  solicitud_prestamo.nombres_referencia_personal, 
							  solicitud_prestamo.relacion_referencia_personal, 
							  solicitud_prestamo.numero_telefonico_referencia_personal, 
							  solicitud_prestamo.apellidos_referencia_familiar, 
							  solicitud_prestamo.nombres_referencia_familiar, 
							  solicitud_prestamo.parentesco_referencia_familiar, 
							  solicitud_prestamo.numero_telefonico_referencia_familiar, 
							  solicitud_prestamo.id_entidades, 
							  solicitud_prestamo.id_provincias_asignacion, 
							  solicitud_prestamo.id_cantones_asignacion, 
							  solicitud_prestamo.id_parroquias_asignacion, 
							  solicitud_prestamo.numero_telefonico_datos_laborales, 
							  solicitud_prestamo.interseccion_datos_laborales, 
							  solicitud_prestamo.calle_datos_laborales, 
							  solicitud_prestamo.cargo_actual_datos_laborales, 
							  solicitud_prestamo.sueldo_total_info_economica, 
							  solicitud_prestamo.cuota_prestamo_ordinario_info_economica, 
							  solicitud_prestamo.arriendos_info_economica, 
							  solicitud_prestamo.cuota_prestamo_emergente_info_economica, 
							  solicitud_prestamo.honorarios_profesionales_info_economica, 
							  solicitud_prestamo.cuota_otros_prestamos_info_economica, 
							  solicitud_prestamo.comisiones_info_economica, 
							  solicitud_prestamo.cuota_prestamo_iess_info_economica, 
							  solicitud_prestamo.horas_suplementarias_info_economica, 
							  solicitud_prestamo.arriendos_egre_info_economica, 
							  solicitud_prestamo.alimentacion_info_economica, 
							  solicitud_prestamo.otros_ingresos_1_info_economica, 
							  solicitud_prestamo.valor_ingresos_1_info_economica, 
							  solicitud_prestamo.estudios_info_economica, 
							  solicitud_prestamo.otros_ingresos_2_info_economica, 
							  solicitud_prestamo.valor_ingresos_2_info_economica, 
							  solicitud_prestamo.pago_servicios_basicos_info_economica, 
							  solicitud_prestamo.otros_ingresos_3_info_economica, 
							  solicitud_prestamo.valor_ingresos_3_info_economica, 
							  solicitud_prestamo.pago_tarjetas_credito_info_economica, 
							  solicitud_prestamo.otros_ingresos_4_info_economica, 
							  solicitud_prestamo.valor_ingresos_4_info_economica, 
							  solicitud_prestamo.afiliacion_cooperativas_info_economica, 
							  solicitud_prestamo.otros_ingresos_5_info_economica, 
							  solicitud_prestamo.valor_ingresos_5_info_economica, 
							  solicitud_prestamo.ahorro_info_economica, 
							  solicitud_prestamo.otros_ingresos_6_info_economica, 
							  solicitud_prestamo.valor_ingresos_6_info_economica, 
							  solicitud_prestamo.impuesto_renta_info_economica, 
							  solicitud_prestamo.otros_ingresos_7_info_economica, 
							  solicitud_prestamo.valor_ingresos_7_info_economica, 
							  solicitud_prestamo.otros_ingresos_8_info_economica, 
							  solicitud_prestamo.valor_ingresos_8_info_economica, 
							  solicitud_prestamo.otros_egresos_1_info_economica, 
							  solicitud_prestamo.valor_egresos_1_info_economica, 
							  solicitud_prestamo.total_ingresos_mensuales, 
							  solicitud_prestamo.total_egresos_mensuales, 
							  solicitud_prestamo.numero_cedula_conyuge, 
							  solicitud_prestamo.apellidos_conyuge, 
							  solicitud_prestamo.nombres_conyuge, 
							  solicitud_prestamo.id_sexo_conyuge, 
							  solicitud_prestamo.fecha_nacimiento_conyuge, 
							  solicitud_prestamo.convive_afiliado_conyuge, 
							  solicitud_prestamo.numero_telefonico_conyuge, 
							  solicitud_prestamo.actividad_economica_conyuge, 
							  solicitud_prestamo.fecha_presentacion, 
							  solicitud_prestamo.fecha_aprobacion, 
							  solicitud_prestamo.id_estado_tramites, 
							  solicitud_prestamo.id_usuarios_oficial_credito_aprueba, 
							  solicitud_prestamo.id_usuarios_registra, 
							  solicitud_prestamo.identificador_consecutivos,
							  solicitud_prestamo.tipo_pago_cuenta_bancaria,
							solicitud_prestamo.id_tipo_creditos,
							solicitud_prestamo.id_sucursales,
					        solicitud_prestamo.cedula_deudor_a_garantizar,
				            solicitud_prestamo.nombre_deudor_a_garantizar,
                            codigo_verificacion.id_codigo_verificacion,
                            codigo_verificacion.numero_codigo_verificacion";
					
					$tablas="public.solicitud_prestamo, public.codigo_verificacion";
					$where="solicitud_prestamo.id_codigo_verificacion= codigo_verificacion.id_codigo_verificacion AND solicitud_prestamo.id_solicitud_prestamo='$_id_solicitud_prestamo'";
					$id="solicitud_prestamo.id_solicitud_prestamo";
					$resultEdit=$solicitud_prestamo->getCondiciones($columnas, $tablas, $where, $id);
					
					
					$this->view("SolicitudPrestamo",array(
							"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
							"resultProvincias"=>$resultProvincias, "resultBancos"=>$resultBancos,
							"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones,
							"resultEdit"=>$resultEdit, "resultTipoCredito"=>$resultTipoCredito, "resultSucursales"=>$resultSucursales,
							"resultTipoParticipe"=>$resultTipoParticipe	
					));
					
					die();
					
				}
				
				$resultUsu=array();
				$_id_usuarios= $_SESSION["id_usuarios"];
				
				if(isset($_GET["solicitud"])){
					
					$_tipo_solicitud_prestamo= $_GET["solicitud"];
					
					
					
					$usuarios = new UsuariosModel();
					
					$columnas_usuarios="usuarios.cedula_usuarios, 
                                        usuarios.nombre_usuarios";
					$tablas_usuarios="public.usuarios";
					$where_usuarios="usuarios.id_usuarios='$_id_usuarios'";
					$id_usuarios="usuarios.cedula_usuarios";
					
					$resultUsu=$usuarios->getCondiciones($columnas_usuarios, $tablas_usuarios, $where_usuarios, $id_usuarios);
					
					
					
					if($_tipo_solicitud_prestamo=='d'){
						
						$resultTipoParticipe=array('0'=>'--Seleccione--','Deudor'=>'Deudor');
						
						$this->view("SolicitudPrestamo",array(
								"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
								"resultProvincias"=>$resultProvincias, "resultBancos"=>$resultBancos,
								"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones,
								"resultEdit"=>$resultEdit, "resultTipoCredito"=>$resultTipoCredito, "resultSucursales"=>$resultSucursales,
						        "resultTipoParticipe"=>$resultTipoParticipe, "resultUsu"=>$resultUsu
						));
						
						die();
						
					}else{
						
						
						$resultTipoParticipe=array('0'=>'--Seleccione--','Garante'=>'Garante');
						
						$this->view("SolicitudPrestamo",array(
								"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
								"resultProvincias"=>$resultProvincias, "resultBancos"=>$resultBancos,
								"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones,
								"resultEdit"=>$resultEdit, "resultTipoCredito"=>$resultTipoCredito, "resultSucursales"=>$resultSucursales,
						        "resultTipoParticipe"=>$resultTipoParticipe, "resultUsu"=>$resultUsu
									
						));
						
						die();
						
					}
					
					
					
				}
				
				
				
				$error_deudor="Permitir";
				$error_garante="Permitir";
			
				
				$result=$solicitud_prestamo->getCondiciones("max(id_solicitud_prestamo) as id_solicitud_prestamo, id_usuarios_registra", "solicitud_prestamo",
						"(id_estado_tramites=1 OR id_estado_tramites=4) AND tipo_participe_datos_prestamo='Deudor' AND  id_usuarios_registra='$_id_usuarios' GROUP BY id_usuarios_registra", "id_usuarios_registra");
				
				if(!empty($result)){
					
					$_id_solicitud_prestamo=$result[0]->id_solicitud_prestamo;
					
					$resulEsta=$solicitud_prestamo->getBy("id_solicitud_prestamo='$_id_solicitud_prestamo'");
						
					if(!empty($resulEsta)){
						
					
					$_id_estado_tramites=$resulEsta[0]->id_estado_tramites;
				
					
					if($_id_estado_tramites==1 || $_id_estado_tramites==4){
						
						//$error="Estimado participe usted ya cuenta con una solicitud de préstamo generada en estado pendiente.<br>Pongase en contacto con uno de nuestros oficiales de crédito para anular o aprobar la solicitud anterior.";
						$error_deudor="NoPermitir";
					}else{
						$error_deudor="Permitir";
					}
					
					
					}
					
					
				}
				
				
				$result1=$solicitud_prestamo->getCondiciones("max(id_solicitud_prestamo) as id_solicitud_prestamo, id_usuarios_registra", "solicitud_prestamo",
						"(id_estado_tramites=1 OR id_estado_tramites=4) AND tipo_participe_datos_prestamo='Garante' AND  id_usuarios_registra='$_id_usuarios' GROUP BY id_usuarios_registra", "id_usuarios_registra");
				
				if(!empty($result1)){
					
					$_id_solicitud_prestamo1=$result1[0]->id_solicitud_prestamo;
					
					$resulEsta1=$solicitud_prestamo->getBy("id_solicitud_prestamo='$_id_solicitud_prestamo1'");
					
					if(!empty($resulEsta1)){
							
					
					$_id_estado_tramites1=$resulEsta1[0]->id_estado_tramites;
				
						
					if($_id_estado_tramites1==1 || $_id_estado_tramites1==4){
				
						$error_garante="NoPermitir";
					}else{
						$error_garante="Permitir";
					}
						
				}
				
				
				}
				
				$this->view("SolicitudPrestamoSeleccion",array(
						"error_deudor"=>$error_deudor, "error_garante"=>$error_garante
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
	
	


	public function InsertaSolicitudPrestamo(){
	
		session_start();
	
		if (isset($_SESSION['nombre_usuarios']))
		{
	
			$usuarios = new UsuariosModel();
			$solicitud_prestamo = new SolicitudPrestamoModel();
			$consecutivos = new ConsecutivosModel();
			
			$_identificador_consecutivos = 0;
			$_total_ingresos_mensuales   = 0;
			$_total_egresos_mensuales    = 0;
			
			if (isset($_POST["numero_cedula_datos_personales"]))
			{
	
				$_id_tipo_creditos                                           = $_POST["id_tipo_creditos"];
				$_tipo_participe_datos_prestamo                              = $_POST["tipo_participe_datos_prestamo"];
				$_monto_datos_prestamo                                       = $_POST["monto_datos_prestamo"];
				$_plazo_datos_prestamo                                       = $_POST["plazo_datos_prestamo"];
				$_destino_dinero_datos_prestamo                              = $_POST["destino_dinero_datos_prestamo"];
				$_id_banco_cuenta_bancaria                                   = $_POST["id_banco_cuenta_bancaria"];
				$_tipo_cuenta_cuenta_bancaria                                = $_POST["tipo_cuenta_cuenta_bancaria"];
				$_numero_cuenta_cuenta_bancaria                              = $_POST["numero_cuenta_cuenta_bancaria"];
				$_numero_cedula_datos_personales                             = $_POST["numero_cedula_datos_personales"];
				$_apellidos_solicitante_datos_personales                     = mb_strtoupper ($_POST["apellidos_solicitante_datos_personales"]);
				$_nombres_solicitante_datos_personales                       = mb_strtoupper ($_POST["nombres_solicitante_datos_personales"]);
				$_correo_solicitante_datos_personales                        = $_POST["correo_solicitante_datos_personales"];
				$_id_sexo_datos_personales                                   = $_POST["id_sexo_datos_personales"];
				$_fecha_nacimiento_datos_personales                          = $_POST["fecha_nacimiento_datos_personales"];
				$_id_estado_civil_datos_personales                           = $_POST["id_estado_civil_datos_personales"];
				$_separacion_bienes_datos_personales                         = $_POST["separacion_bienes_datos_personales"];
				$_cargas_familiares_datos_personales                         = $_POST["cargas_familiares_datos_personales"];
				$_numero_hijos_datos_personales                              = $_POST["numero_hijos_datos_personales"];
				$_nivel_educativo_datos_personales                           = $_POST["nivel_educativo_datos_personales"];
				$_id_provincias_vivienda                                     = $_POST["id_provincias_vivienda"];
				$_id_cantones_vivienda                                       = $_POST["id_cantones_vivienda"];
				$_id_parroquias_vivienda                                     = $_POST["id_parroquias_vivienda"];
				$_barrio_sector_vivienda                                     = $_POST["barrio_sector_vivienda"];
				$_ciudadela_conjunto_etapa_manzana_vivienda                  = $_POST["ciudadela_conjunto_etapa_manzana_vivienda"];
				$_calle_vivienda                                             = $_POST["calle_vivienda"];
				$_numero_calle_vivienda                                      = $_POST["numero_calle_vivienda"];
				$_intersecion_vivienda                                       = $_POST["intersecion_vivienda"];
				$_tipo_vivienda                                              = $_POST["tipo_vivienda"];
				$_vivienda_hipotecada_vivienda                               = $_POST["vivienda_hipotecada_vivienda"];
				$_tiempo_residencia_vivienda                                 = $_POST["tiempo_residencia_vivienda"];
				$_nombre_propietario_vivienda                                = mb_strtoupper ($_POST["nombre_propietario_vivienda"]);
				$_celular_propietario_vivienda                               = $_POST["celular_propietario_vivienda"];
				$_referencia_direccion_domicilio_vivienda                    = $_POST["referencia_direccion_domicilio_vivienda"];
				$_numero_casa_solicitante                                    = $_POST["numero_casa_solicitante"];
				$_numero_celular_solicitante                                 = $_POST["numero_celular_solicitante"];
				$_id_codigo_verificacion                                     = $_POST["id_codigo_verificacion"];
				
				
				$_numero_trabajo_solicitante                                 = $_POST["numero_trabajo_solicitante"];
				$_extension_solicitante                                      = $_POST["extension_solicitante"];
				$_mode_solicitante                                           = $_POST["mode_solicitante"];
				$_apellidos_referencia_personal                              = mb_strtoupper ($_POST["apellidos_referencia_personal"]);
				$_nombres_referencia_personal                                = mb_strtoupper ($_POST["nombres_referencia_personal"]);
				$_relacion_referencia_personal                               = $_POST["relacion_referencia_personal"];
				$_numero_telefonico_referencia_personal                      = $_POST["numero_telefonico_referencia_personal"];
				$_apellidos_referencia_familiar                              = mb_strtoupper ($_POST["apellidos_referencia_familiar"]);
				$_nombres_referencia_familiar                                = mb_strtoupper ($_POST["nombres_referencia_familiar"]);
				$_parentesco_referencia_familiar                             = $_POST["parentesco_referencia_familiar"];
				$_numero_telefonico_referencia_familiar                      = $_POST["numero_telefonico_referencia_familiar"];
				$_id_entidades                                               = $_POST["id_entidades"];
				$_id_provincias_asignacion                                   = $_POST["id_provincias_asignacion"];
				$_id_cantones_asignacion                                     = $_POST["id_cantones_asignacion"];
				$_id_parroquias_asignacion                                   = $_POST["id_parroquias_asignacion"];
				$_numero_telefonico_datos_laborales                          = $_POST["numero_telefonico_datos_laborales"];
				$_interseccion_datos_laborales                               = $_POST["interseccion_datos_laborales"];
				$_calle_datos_laborales                                      = $_POST["calle_datos_laborales"];
				$_cargo_actual_datos_laborales                               = mb_strtoupper ($_POST["cargo_actual_datos_laborales"]);
				
				
				
				
				$_sueldo_total_info_economica                                = (isset($_REQUEST['sueldo_total_info_economica'])&& $_REQUEST['sueldo_total_info_economica'] !=NULL)?$_REQUEST['sueldo_total_info_economica']:0;
				$_cuota_prestamo_ordinario_info_economica                    = (isset($_REQUEST['cuota_prestamo_ordinario_info_economica'])&& $_REQUEST['cuota_prestamo_ordinario_info_economica'] !=NULL)?$_REQUEST['cuota_prestamo_ordinario_info_economica']:0;
				$_arriendos_info_economica                                   = (isset($_REQUEST['arriendos_info_economica'])&& $_REQUEST['arriendos_info_economica'] !=NULL)?$_REQUEST['arriendos_info_economica']:0;
				$_cuota_prestamo_emergente_info_economica                    = (isset($_REQUEST['cuota_prestamo_emergente_info_economica'])&& $_REQUEST['cuota_prestamo_emergente_info_economica'] !=NULL)?$_REQUEST['cuota_prestamo_emergente_info_economica']:0;
				$_honorarios_profesionales_info_economica                    = (isset($_REQUEST['honorarios_profesionales_info_economica'])&& $_REQUEST['honorarios_profesionales_info_economica'] !=NULL)?$_REQUEST['honorarios_profesionales_info_economica']:0;
				$_cuota_otros_prestamos_info_economica                       = (isset($_REQUEST['cuota_otros_prestamos_info_economica'])&& $_REQUEST['cuota_otros_prestamos_info_economica'] !=NULL)?$_REQUEST['cuota_otros_prestamos_info_economica']:0;
				$_comisiones_info_economica                                  = (isset($_REQUEST['comisiones_info_economica'])&& $_REQUEST['comisiones_info_economica'] !=NULL)?$_REQUEST['comisiones_info_economica']:0;
				$_cuota_prestamo_iess_info_economica                         = (isset($_REQUEST['cuota_prestamo_iess_info_economica'])&& $_REQUEST['cuota_prestamo_iess_info_economica'] !=NULL)?$_REQUEST['cuota_prestamo_iess_info_economica']:0;
				$_horas_suplementarias_info_economica                        = (isset($_REQUEST['horas_suplementarias_info_economica'])&& $_REQUEST['horas_suplementarias_info_economica'] !=NULL)?$_REQUEST['horas_suplementarias_info_economica']:0;
				$_arriendos_egre_info_economica                              = (isset($_REQUEST['arriendos_egre_info_economica'])&& $_REQUEST['arriendos_egre_info_economica'] !=NULL)?$_REQUEST['arriendos_egre_info_economica']:0;
				$_alimentacion_info_economica                                = (isset($_REQUEST['alimentacion_info_economica'])&& $_REQUEST['alimentacion_info_economica'] !=NULL)?$_REQUEST['alimentacion_info_economica']:0;
				$_otros_ingresos_1_info_economica                            = $_POST["otros_ingresos_1_info_economica"];
				$_valor_ingresos_1_info_economica                            = (isset($_REQUEST['valor_ingresos_1_info_economica'])&& $_REQUEST['valor_ingresos_1_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_1_info_economica']:0;
				$_estudios_info_economica                                    = (isset($_REQUEST['estudios_info_economica'])&& $_REQUEST['estudios_info_economica'] !=NULL)?$_REQUEST['estudios_info_economica']:0;
				$_otros_ingresos_2_info_economica                            = $_POST["otros_ingresos_2_info_economica"];
				$_valor_ingresos_2_info_economica                            = (isset($_REQUEST['valor_ingresos_2_info_economica'])&& $_REQUEST['valor_ingresos_2_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_2_info_economica']:0;
				$_pago_servicios_basicos_info_economica                      = (isset($_REQUEST['pago_servicios_basicos_info_economica'])&& $_REQUEST['pago_servicios_basicos_info_economica'] !=NULL)?$_REQUEST['pago_servicios_basicos_info_economica']:0;
				$_otros_ingresos_3_info_economica                            = $_POST["otros_ingresos_3_info_economica"];
				$_valor_ingresos_3_info_economica                            = (isset($_REQUEST['valor_ingresos_3_info_economica'])&& $_REQUEST['valor_ingresos_3_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_3_info_economica']:0;
				$_pago_tarjetas_credito_info_economica                       = (isset($_REQUEST['pago_tarjetas_credito_info_economica'])&& $_REQUEST['pago_tarjetas_credito_info_economica'] !=NULL)?$_REQUEST['pago_tarjetas_credito_info_economica']:0;
				$_otros_ingresos_4_info_economica                            = $_POST["otros_ingresos_4_info_economica"];
				$_valor_ingresos_4_info_economica                            = (isset($_REQUEST['valor_ingresos_4_info_economica'])&& $_REQUEST['valor_ingresos_4_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_4_info_economica']:0;
				$_afiliacion_cooperativas_info_economica                     = (isset($_REQUEST['afiliacion_cooperativas_info_economica'])&& $_REQUEST['afiliacion_cooperativas_info_economica'] !=NULL)?$_REQUEST['afiliacion_cooperativas_info_economica']:0;
				$_otros_ingresos_5_info_economica                            = $_POST["otros_ingresos_5_info_economica"];
				$_valor_ingresos_5_info_economica                            = (isset($_REQUEST['valor_ingresos_5_info_economica'])&& $_REQUEST['valor_ingresos_5_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_5_info_economica']:0;
				$_ahorro_info_economica                                      = (isset($_REQUEST['ahorro_info_economica'])&& $_REQUEST['ahorro_info_economica'] !=NULL)?$_REQUEST['ahorro_info_economica']:0;
				$_otros_ingresos_6_info_economica                            = $_POST["otros_ingresos_6_info_economica"];
				$_valor_ingresos_6_info_economica                            = (isset($_REQUEST['valor_ingresos_6_info_economica'])&& $_REQUEST['valor_ingresos_6_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_6_info_economica']:0;
				$_impuesto_renta_info_economica                              = (isset($_REQUEST['impuesto_renta_info_economica'])&& $_REQUEST['impuesto_renta_info_economica'] !=NULL)?$_REQUEST['impuesto_renta_info_economica']:0;
				$_otros_ingresos_7_info_economica                            = $_POST["otros_ingresos_7_info_economica"];
				$_valor_ingresos_7_info_economica                            = (isset($_REQUEST['valor_ingresos_7_info_economica'])&& $_REQUEST['valor_ingresos_7_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_7_info_economica']:0;
				$_otros_ingresos_8_info_economica                            = $_POST["otros_ingresos_8_info_economica"];
				$_valor_ingresos_8_info_economica                            = (isset($_REQUEST['valor_ingresos_8_info_economica'])&& $_REQUEST['valor_ingresos_8_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_8_info_economica']:0;
				$_otros_egresos_1_info_economica                             = $_POST["otros_egresos_1_info_economica"];
				$_valor_egresos_1_info_economica                             = (isset($_REQUEST['valor_egresos_1_info_economica'])&& $_REQUEST['valor_egresos_1_info_economica'] !=NULL)?$_REQUEST['valor_egresos_1_info_economica']:0;
				
				$_total_ingresos_mensuales  = $_sueldo_total_info_economica+$_arriendos_info_economica+$_honorarios_profesionales_info_economica+$_comisiones_info_economica+$_horas_suplementarias_info_economica+$_valor_ingresos_1_info_economica+$_valor_ingresos_2_info_economica+$_valor_ingresos_3_info_economica+$_valor_ingresos_4_info_economica+$_valor_ingresos_5_info_economica+$_valor_ingresos_6_info_economica+$_valor_ingresos_7_info_economica+$_valor_ingresos_8_info_economica;
				$_total_egresos_mensuales   = $_cuota_prestamo_ordinario_info_economica+$_cuota_prestamo_emergente_info_economica+$_cuota_otros_prestamos_info_economica+$_cuota_prestamo_iess_info_economica+$_arriendos_egre_info_economica+$_alimentacion_info_economica+$_estudios_info_economica+$_pago_servicios_basicos_info_economica+$_pago_tarjetas_credito_info_economica+$_afiliacion_cooperativas_info_economica+$_ahorro_info_economica+$_impuesto_renta_info_economica+$_valor_egresos_1_info_economica;
				
				$_numero_cedula_conyuge                                      = $_POST["numero_cedula_conyuge"];
				$_apellidos_conyuge                                          = mb_strtoupper ($_POST["apellidos_conyuge"]);
				$_nombres_conyuge                                            = mb_strtoupper ($_POST["nombres_conyuge"]);
				$_id_sexo_conyuge                                            = $_POST["id_sexo_conyuge"];
				$_fecha_nacimiento_conyuge                                   = $_POST["fecha_nacimiento_conyuge"];
				$_convive_afiliado_conyuge                                   = $_POST["convive_afiliado_conyuge"];
				$_numero_telefonico_conyuge                                  = $_POST["numero_telefonico_conyuge"];
				$_actividad_economica_conyuge                                = $_POST["actividad_economica_conyuge"];
				
				$_fecha_actual =    getdate();
				$_fecha_año    =	$_fecha_actual['year'];
				$_fecha_mes    =	$_fecha_actual['mon'];
				$_fecha_dia    =	$_fecha_actual['mday'];
					
				$_fecha_presentacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
				$_id_usuarios_registra = $_SESSION['id_usuarios'];
				
				$_id_solicitud_prestamo                               = $_POST["id_solicitud_prestamo"];
				$_tipo_pago_cuenta_bancaria                           = $_POST["tipo_pago_cuenta_bancaria"];
				$_id_sucursales                                       = $_POST["id_sucursales"];
				
				$_nombre_deudor_a_garantizar                                       = $_POST["nombre_deudor_a_garantizar"];
				$_cedula_deudor_a_garantizar                                       = $_POST["cedula_deudor_a_garantizar"];
				
				
				if($_id_solicitud_prestamo > 0){
					
					$id_oficial_credito=0;
					if($_tipo_participe_datos_prestamo=='Garante'){
							
							
						$resultDeudor=$solicitud_prestamo->getCondiciones("max(id_solicitud_prestamo) as id, id_usuarios_oficial_credito_aprueba", "solicitud_prestamo",
								"(id_estado_tramites=1 OR id_estado_tramites=4) and numero_cedula_datos_personales ='$_cedula_deudor_a_garantizar' AND tipo_participe_datos_prestamo='Deudor' GROUP BY id_usuarios_oficial_credito_aprueba", "id_usuarios_oficial_credito_aprueba");
						$id_oficial_credito=$resultDeudor[0]->id_usuarios_oficial_credito_aprueba;
						$id_solicitud_prestamo_a_garantizar=$resultDeudor[0]->id;
					
						
						$resultGarante=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_oficial_credito'");
						$_id_sucursales=$resultGarante[0]->id_sucursales;
						
						
						$resultGarante_Conse=$solicitud_prestamo->getBy("id_solicitud_prestamo='$id_solicitud_prestamo_a_garantizar'");
						$_consecutivo_soli=$resultGarante_Conse[0]->identificador_consecutivos;
						
						
						$columnas="identificador_consecutivos_deudor='$_consecutivo_soli',
                        id_sucursales='$_id_sucursales',
                        id_tipo_creditos='$_id_tipo_creditos',
						tipo_pago_cuenta_bancaria='$_tipo_pago_cuenta_bancaria',
						monto_datos_prestamo='$_monto_datos_prestamo',
						plazo_datos_prestamo='$_plazo_datos_prestamo',
						destino_dinero_datos_prestamo='$_destino_dinero_datos_prestamo',
						nombre_banco_cuenta_bancaria='$_id_banco_cuenta_bancaria',
						tipo_cuenta_cuenta_bancaria='$_tipo_cuenta_cuenta_bancaria',
						numero_cuenta_cuenta_bancaria='$_numero_cuenta_cuenta_bancaria',
						numero_cedula_datos_personales='$_numero_cedula_datos_personales',
						apellidos_solicitante_datos_personales='$_apellidos_solicitante_datos_personales',
						nombres_solicitante_datos_personales='$_nombres_solicitante_datos_personales',
						correo_solicitante_datos_personales='$_correo_solicitante_datos_personales',
						id_sexo_datos_personales='$_id_sexo_datos_personales',
						fecha_nacimiento_datos_personales='$_fecha_nacimiento_datos_personales',
						id_estado_civil_datos_personales='$_id_estado_civil_datos_personales',
						separacion_bienes_datos_personales='$_separacion_bienes_datos_personales',
						cargas_familiares_datos_personales='$_cargas_familiares_datos_personales',
						numero_hijos_datos_personales='$_numero_hijos_datos_personales',
						nivel_educativo_datos_personales='$_nivel_educativo_datos_personales',
						id_provincias_vivienda='$_id_provincias_vivienda',
						id_cantones_vivienda='$_id_cantones_vivienda',
						id_parroquias_vivienda='$_id_parroquias_vivienda',
						barrio_sector_vivienda='$_barrio_sector_vivienda',
						ciudadela_conjunto_etapa_manzana_vivienda='$_ciudadela_conjunto_etapa_manzana_vivienda',
						calle_vivienda='$_calle_vivienda',
						numero_calle_vivienda='$_numero_calle_vivienda',
						intersecion_vivienda='$_intersecion_vivienda',
						tipo_vivienda='$_tipo_vivienda',
						vivienda_hipotecada_vivienda='$_vivienda_hipotecada_vivienda',
						tiempo_residencia_vivienda='$_tiempo_residencia_vivienda',
						nombre_propietario_vivienda='$_nombre_propietario_vivienda',
						celular_propietario_vivienda='$_celular_propietario_vivienda',
						referencia_direccion_domicilio_vivienda='$_referencia_direccion_domicilio_vivienda',
						numero_casa_solicitante='$_numero_casa_solicitante',
						numero_celular_solicitante='$_numero_celular_solicitante',
						numero_trabajo_solicitante='$_numero_trabajo_solicitante',
						extension_solicitante='$_extension_solicitante',
						mode_solicitante='$_mode_solicitante',
						apellidos_referencia_personal='$_apellidos_referencia_personal',
						nombres_referencia_personal='$_nombres_referencia_personal',
						relacion_referencia_personal='$_relacion_referencia_personal',
						numero_telefonico_referencia_personal='$_numero_telefonico_referencia_personal',
						apellidos_referencia_familiar='$_apellidos_referencia_familiar',
						nombres_referencia_familiar='$_nombres_referencia_familiar',
						parentesco_referencia_familiar='$_parentesco_referencia_familiar',
						numero_telefonico_referencia_familiar='$_numero_telefonico_referencia_familiar',
						id_entidades='$_id_entidades',
						id_provincias_asignacion='$_id_provincias_asignacion',
						id_cantones_asignacion='$_id_cantones_asignacion',
						id_parroquias_asignacion='$_id_parroquias_asignacion',
						numero_telefonico_datos_laborales='$_numero_telefonico_datos_laborales',
						interseccion_datos_laborales='$_interseccion_datos_laborales',
						calle_datos_laborales='$_calle_datos_laborales',
						cargo_actual_datos_laborales='$_cargo_actual_datos_laborales',
						sueldo_total_info_economica='$_sueldo_total_info_economica',
						cuota_prestamo_ordinario_info_economica='$_cuota_prestamo_ordinario_info_economica',
						arriendos_info_economica='$_arriendos_info_economica',
						cuota_prestamo_emergente_info_economica='$_cuota_prestamo_emergente_info_economica',
						honorarios_profesionales_info_economica='$_honorarios_profesionales_info_economica',
						cuota_otros_prestamos_info_economica='$_cuota_otros_prestamos_info_economica',
						comisiones_info_economica='$_comisiones_info_economica',
						cuota_prestamo_iess_info_economica='$_cuota_prestamo_iess_info_economica',
						horas_suplementarias_info_economica='$_horas_suplementarias_info_economica',
						arriendos_egre_info_economica='$_arriendos_egre_info_economica',
						alimentacion_info_economica='$_alimentacion_info_economica',
						otros_ingresos_1_info_economica='$_otros_ingresos_1_info_economica',
						valor_ingresos_1_info_economica='$_valor_ingresos_1_info_economica',
						estudios_info_economica='$_estudios_info_economica',
						otros_ingresos_2_info_economica='$_otros_ingresos_2_info_economica',
						valor_ingresos_2_info_economica='$_valor_ingresos_2_info_economica',
						pago_servicios_basicos_info_economica='$_pago_servicios_basicos_info_economica',
						otros_ingresos_3_info_economica='$_otros_ingresos_3_info_economica',
						valor_ingresos_3_info_economica='$_valor_ingresos_3_info_economica',
						pago_tarjetas_credito_info_economica='$_pago_tarjetas_credito_info_economica',
						otros_ingresos_4_info_economica='$_otros_ingresos_4_info_economica',
						valor_ingresos_4_info_economica='$_valor_ingresos_4_info_economica',
						afiliacion_cooperativas_info_economica='$_afiliacion_cooperativas_info_economica',
						otros_ingresos_5_info_economica='$_otros_ingresos_5_info_economica',
						valor_ingresos_5_info_economica='$_valor_ingresos_5_info_economica',
						ahorro_info_economica='$_ahorro_info_economica',
						otros_ingresos_6_info_economica='$_otros_ingresos_6_info_economica',
						valor_ingresos_6_info_economica='$_valor_ingresos_6_info_economica',
						impuesto_renta_info_economica='$_impuesto_renta_info_economica',
						otros_ingresos_7_info_economica='$_otros_ingresos_7_info_economica',
						valor_ingresos_7_info_economica='$_valor_ingresos_7_info_economica',
						otros_ingresos_8_info_economica='$_otros_ingresos_8_info_economica',
						valor_ingresos_8_info_economica='$_valor_ingresos_8_info_economica',
						otros_egresos_1_info_economica='$_otros_egresos_1_info_economica',
						valor_egresos_1_info_economica='$_valor_egresos_1_info_economica',
						total_ingresos_mensuales='$_total_ingresos_mensuales',
						total_egresos_mensuales='$_total_egresos_mensuales',
						cedula_deudor_a_garantizar='$_cedula_deudor_a_garantizar',
						nombre_deudor_a_garantizar='$_nombre_deudor_a_garantizar',
						id_usuarios_oficial_credito_aprueba='$id_oficial_credito',
                        id_codigo_verificacion='$_id_codigo_verificacion'";
						$tablas="solicitud_prestamo";
						$where="id_solicitud_prestamo = '$_id_solicitud_prestamo'";
						$resultado2=$solicitud_prestamo->UpdateBy($columnas, $tablas, $where);
							
							
						if($_id_estado_civil_datos_personales != 1 && $_id_estado_civil_datos_personales != 5 && $_id_estado_civil_datos_personales != 3){
								
							$colval_afi = "numero_cedula_conyuge= '$_numero_cedula_conyuge',
							apellidos_conyuge='$_apellidos_conyuge',
							nombres_conyuge='$_nombres_conyuge',
							id_sexo_conyuge='$_id_sexo_conyuge',
							fecha_nacimiento_conyuge='$_fecha_nacimiento_conyuge',
							convive_afiliado_conyuge='$_convive_afiliado_conyuge',
							numero_telefonico_conyuge='$_numero_telefonico_conyuge',
							actividad_economica_conyuge='$_actividad_economica_conyuge'";
							$tabla_afi = "solicitud_prestamo";
							$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
							$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
								
						}else{
						
						
							if($_id_sexo_conyuge >0 && $_fecha_nacimiento_conyuge!=""){
									
								$colval_afi = "numero_cedula_conyuge= '$_numero_cedula_conyuge',
								apellidos_conyuge='$_apellidos_conyuge',
								nombres_conyuge='$_nombres_conyuge',
								id_sexo_conyuge='$_id_sexo_conyuge',
								fecha_nacimiento_conyuge='$_fecha_nacimiento_conyuge',
								convive_afiliado_conyuge='$_convive_afiliado_conyuge',
								numero_telefonico_conyuge='$_numero_telefonico_conyuge',
								actividad_economica_conyuge='$_actividad_economica_conyuge'";
								$tabla_afi = "solicitud_prestamo";
								$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
								$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
									
							}else{
									
								$colval_afi = "numero_cedula_conyuge= '',
											apellidos_conyuge='',
											nombres_conyuge='',
											id_sexo_conyuge=NULL,
											fecha_nacimiento_conyuge=NULL,
											convive_afiliado_conyuge='',
											numero_telefonico_conyuge='',
											actividad_economica_conyuge=''";
								$tabla_afi = "solicitud_prestamo";
								$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
								$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
						
							}
						
						}
							
						
						
						
						
							
					}else{
						

						$columnas="id_tipo_creditos='$_id_tipo_creditos',
						tipo_pago_cuenta_bancaria='$_tipo_pago_cuenta_bancaria',
						monto_datos_prestamo='$_monto_datos_prestamo',
						plazo_datos_prestamo='$_plazo_datos_prestamo',
						destino_dinero_datos_prestamo='$_destino_dinero_datos_prestamo',
						nombre_banco_cuenta_bancaria='$_id_banco_cuenta_bancaria',
						tipo_cuenta_cuenta_bancaria='$_tipo_cuenta_cuenta_bancaria',
						numero_cuenta_cuenta_bancaria='$_numero_cuenta_cuenta_bancaria',
						numero_cedula_datos_personales='$_numero_cedula_datos_personales',
						apellidos_solicitante_datos_personales='$_apellidos_solicitante_datos_personales',
						nombres_solicitante_datos_personales='$_nombres_solicitante_datos_personales',
						correo_solicitante_datos_personales='$_correo_solicitante_datos_personales',
						id_sexo_datos_personales='$_id_sexo_datos_personales',
						fecha_nacimiento_datos_personales='$_fecha_nacimiento_datos_personales',
						id_estado_civil_datos_personales='$_id_estado_civil_datos_personales',
						separacion_bienes_datos_personales='$_separacion_bienes_datos_personales',
						cargas_familiares_datos_personales='$_cargas_familiares_datos_personales',
						numero_hijos_datos_personales='$_numero_hijos_datos_personales',
						nivel_educativo_datos_personales='$_nivel_educativo_datos_personales',
						id_provincias_vivienda='$_id_provincias_vivienda',
						id_cantones_vivienda='$_id_cantones_vivienda',
						id_parroquias_vivienda='$_id_parroquias_vivienda',
						barrio_sector_vivienda='$_barrio_sector_vivienda',
						ciudadela_conjunto_etapa_manzana_vivienda='$_ciudadela_conjunto_etapa_manzana_vivienda',
						calle_vivienda='$_calle_vivienda',
						numero_calle_vivienda='$_numero_calle_vivienda',
						intersecion_vivienda='$_intersecion_vivienda',
						tipo_vivienda='$_tipo_vivienda',
						vivienda_hipotecada_vivienda='$_vivienda_hipotecada_vivienda',
						tiempo_residencia_vivienda='$_tiempo_residencia_vivienda',
						nombre_propietario_vivienda='$_nombre_propietario_vivienda',
						celular_propietario_vivienda='$_celular_propietario_vivienda',
						referencia_direccion_domicilio_vivienda='$_referencia_direccion_domicilio_vivienda',
						numero_casa_solicitante='$_numero_casa_solicitante',
						numero_celular_solicitante='$_numero_celular_solicitante',
						numero_trabajo_solicitante='$_numero_trabajo_solicitante',
						extension_solicitante='$_extension_solicitante',
						mode_solicitante='$_mode_solicitante',
						apellidos_referencia_personal='$_apellidos_referencia_personal',
						nombres_referencia_personal='$_nombres_referencia_personal',
						relacion_referencia_personal='$_relacion_referencia_personal',
						numero_telefonico_referencia_personal='$_numero_telefonico_referencia_personal',
						apellidos_referencia_familiar='$_apellidos_referencia_familiar',
						nombres_referencia_familiar='$_nombres_referencia_familiar',
						parentesco_referencia_familiar='$_parentesco_referencia_familiar',
						numero_telefonico_referencia_familiar='$_numero_telefonico_referencia_familiar',
						id_entidades='$_id_entidades',
						id_provincias_asignacion='$_id_provincias_asignacion',
						id_cantones_asignacion='$_id_cantones_asignacion',
						id_parroquias_asignacion='$_id_parroquias_asignacion',
						numero_telefonico_datos_laborales='$_numero_telefonico_datos_laborales',
						interseccion_datos_laborales='$_interseccion_datos_laborales',
						calle_datos_laborales='$_calle_datos_laborales',
						cargo_actual_datos_laborales='$_cargo_actual_datos_laborales',
						sueldo_total_info_economica='$_sueldo_total_info_economica',
						cuota_prestamo_ordinario_info_economica='$_cuota_prestamo_ordinario_info_economica',
						arriendos_info_economica='$_arriendos_info_economica',
						cuota_prestamo_emergente_info_economica='$_cuota_prestamo_emergente_info_economica',
						honorarios_profesionales_info_economica='$_honorarios_profesionales_info_economica',
						cuota_otros_prestamos_info_economica='$_cuota_otros_prestamos_info_economica',
						comisiones_info_economica='$_comisiones_info_economica',
						cuota_prestamo_iess_info_economica='$_cuota_prestamo_iess_info_economica',
						horas_suplementarias_info_economica='$_horas_suplementarias_info_economica',
						arriendos_egre_info_economica='$_arriendos_egre_info_economica',
						alimentacion_info_economica='$_alimentacion_info_economica',
						otros_ingresos_1_info_economica='$_otros_ingresos_1_info_economica',
						valor_ingresos_1_info_economica='$_valor_ingresos_1_info_economica',
						estudios_info_economica='$_estudios_info_economica',
						otros_ingresos_2_info_economica='$_otros_ingresos_2_info_economica',
						valor_ingresos_2_info_economica='$_valor_ingresos_2_info_economica',
						pago_servicios_basicos_info_economica='$_pago_servicios_basicos_info_economica',
						otros_ingresos_3_info_economica='$_otros_ingresos_3_info_economica',
						valor_ingresos_3_info_economica='$_valor_ingresos_3_info_economica',
						pago_tarjetas_credito_info_economica='$_pago_tarjetas_credito_info_economica',
						otros_ingresos_4_info_economica='$_otros_ingresos_4_info_economica',
						valor_ingresos_4_info_economica='$_valor_ingresos_4_info_economica',
						afiliacion_cooperativas_info_economica='$_afiliacion_cooperativas_info_economica',
						otros_ingresos_5_info_economica='$_otros_ingresos_5_info_economica',
						valor_ingresos_5_info_economica='$_valor_ingresos_5_info_economica',
						ahorro_info_economica='$_ahorro_info_economica',
						otros_ingresos_6_info_economica='$_otros_ingresos_6_info_economica',
						valor_ingresos_6_info_economica='$_valor_ingresos_6_info_economica',
						impuesto_renta_info_economica='$_impuesto_renta_info_economica',
						otros_ingresos_7_info_economica='$_otros_ingresos_7_info_economica',
						valor_ingresos_7_info_economica='$_valor_ingresos_7_info_economica',
						otros_ingresos_8_info_economica='$_otros_ingresos_8_info_economica',
						valor_ingresos_8_info_economica='$_valor_ingresos_8_info_economica',
						otros_egresos_1_info_economica='$_otros_egresos_1_info_economica',
						valor_egresos_1_info_economica='$_valor_egresos_1_info_economica',
						total_ingresos_mensuales='$_total_ingresos_mensuales',
						total_egresos_mensuales='$_total_egresos_mensuales',
						cedula_deudor_a_garantizar='$_cedula_deudor_a_garantizar',
						nombre_deudor_a_garantizar='$_nombre_deudor_a_garantizar',
                        id_codigo_verificacion='$_id_codigo_verificacion'";
						$tablas="solicitud_prestamo";
						$where="id_solicitud_prestamo = '$_id_solicitud_prestamo'";
						$resultado2=$solicitud_prestamo->UpdateBy($columnas, $tablas, $where);
							
							
						if($_id_estado_civil_datos_personales != 1 && $_id_estado_civil_datos_personales != 5 && $_id_estado_civil_datos_personales != 3){
								
							$colval_afi = "numero_cedula_conyuge= '$_numero_cedula_conyuge',
							apellidos_conyuge='$_apellidos_conyuge',
							nombres_conyuge='$_nombres_conyuge',
							id_sexo_conyuge='$_id_sexo_conyuge',
							fecha_nacimiento_conyuge='$_fecha_nacimiento_conyuge',
							convive_afiliado_conyuge='$_convive_afiliado_conyuge',
							numero_telefonico_conyuge='$_numero_telefonico_conyuge',
							actividad_economica_conyuge='$_actividad_economica_conyuge'";
							$tabla_afi = "solicitud_prestamo";
							$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
							$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
								
						}else{
						
						
							if($_id_sexo_conyuge >0 && $_fecha_nacimiento_conyuge!=""){
									
								$colval_afi = "numero_cedula_conyuge= '$_numero_cedula_conyuge',
								apellidos_conyuge='$_apellidos_conyuge',
								nombres_conyuge='$_nombres_conyuge',
								id_sexo_conyuge='$_id_sexo_conyuge',
								fecha_nacimiento_conyuge='$_fecha_nacimiento_conyuge',
								convive_afiliado_conyuge='$_convive_afiliado_conyuge',
								numero_telefonico_conyuge='$_numero_telefonico_conyuge',
								actividad_economica_conyuge='$_actividad_economica_conyuge'";
								$tabla_afi = "solicitud_prestamo";
								$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
								$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
									
							}else{
									
								$colval_afi = "numero_cedula_conyuge= '',
								apellidos_conyuge='',
								nombres_conyuge='',
								id_sexo_conyuge=NULL,
								fecha_nacimiento_conyuge=NULL,
								convive_afiliado_conyuge='',
								numero_telefonico_conyuge='',
								actividad_economica_conyuge=''";
								$tabla_afi = "solicitud_prestamo";
								$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
								$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
						
							}
						
						}
						
					}
					
				}else{
				$_identificador_consecutivos=0;
				$resultConsecutivos=$consecutivos->getBy("nombre_consecutivos='SOLICITUD_PRESTAMOS'");
				$_identificador_consecutivos=$resultConsecutivos[0]->identificador_consecutivos;
				
				$id_usuarios_1=0;
				$id_usuarios_2=0;
				$id_usuarios_3=0;
				$res1=0;
				$res2=0;
				$res3=0;
				$id_oficial_credito=0;
				
				if($_tipo_participe_datos_prestamo=='Garante'){
					
					
				$resultDeudor=$solicitud_prestamo->getCondiciones("max(id_solicitud_prestamo) as id, id_usuarios_oficial_credito_aprueba", "solicitud_prestamo", 
			    "(id_estado_tramites=1 OR id_estado_tramites=4) and numero_cedula_datos_personales ='$_cedula_deudor_a_garantizar' AND tipo_participe_datos_prestamo='Deudor' GROUP BY id_usuarios_oficial_credito_aprueba", "id_usuarios_oficial_credito_aprueba");
				$id_oficial_credito=$resultDeudor[0]->id_usuarios_oficial_credito_aprueba;
				$id_solicitud_prestamo_a_garantizar=$resultDeudor[0]->id;
				
				
				$resultGarante=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_oficial_credito'");
				$_id_sucursales=$resultGarante[0]->id_sucursales;
				
				$resultGarante_Conse=$solicitud_prestamo->getBy("id_solicitud_prestamo='$id_solicitud_prestamo_a_garantizar'");
				$_identificador_consecutivos_deudor=$resultGarante_Conse[0]->identificador_consecutivos;
				
				
				
				}else{
					
				    $_identificador_consecutivos_deudor="";
				    
				    
					if($_id_sucursales == 1){
							
						$resultQuito=$solicitud_prestamo->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Quito' AND id_estado=1", "id_usuarios");
					
						if(!empty($resultQuito)){
							$i=0;
							foreach ($resultQuito as $res){
								$i++;
									
								if($i==1){
					
									$id_usuarios_1=$res->id_usuarios;
								}elseif ($i==2){
					
									$id_usuarios_2=$res->id_usuarios;
								}else{
									$id_usuarios_3=$res->id_usuarios;
								}	
							}
						}
							
							
						$resultoficial1=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1' AND tipo_participe_datos_prestamo='Deudor' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
							
						if(!empty($resultoficial1)){
					
							$res1=count($resultoficial1);
						}
							
						$resultoficial2=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2' AND tipo_participe_datos_prestamo='Deudor' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
							
						if(!empty($resultoficial2)){
							$res2=count($resultoficial2);
						}
						
						
						$resultoficial3=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_3' AND tipo_participe_datos_prestamo='Deudor' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
							
						if(!empty($resultoficial3)){
							$res3=count($resultoficial3);
						}
						
						if($res1==$res2){
						    
						    $id_oficial_credito=$id_usuarios_1;
						}
						elseif ($res1>$res2){
						    
						    $id_oficial_credito=$id_usuarios_2;
						}
						elseif ($res2>$res1){
						    
						    $id_oficial_credito=$id_usuarios_1;
						}
						
						
						/////////// por lo que se fue la angie va todo a carlos narvaez //////////
						
						//$id_oficial_credito=0;
						//$id_oficial_credito=15425;
						
						
						
					}else{
							
						$resultGuayaquil=$solicitud_prestamo->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Guayaquil' AND id_estado=1", "id_usuarios");
					
						if(!empty($resultGuayaquil)){
							$i=0;
							foreach ($resultGuayaquil as $res){
								$i++;
					
								if($i==1){
										
									$id_usuarios_1=$res->id_usuarios;
								}elseif ($i==2){
										
									$id_usuarios_2=$res->id_usuarios;
								}
					
							}
						}
							
						$resultoficial1=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1' AND tipo_participe_datos_prestamo='Deudor' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
					
						if(!empty($resultoficial1)){
							$res1=count($resultoficial1);
						}
					
						$resultoficial2=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2' AND tipo_participe_datos_prestamo='Deudor' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
					
						if(!empty($resultoficial2)){
							$res2=count($resultoficial2);
						}
							
						if($res1==$res2){
								
							$id_oficial_credito=$id_usuarios_1;
						}
						elseif ($res1>$res2){
								
							$id_oficial_credito=$id_usuarios_2;
						}
						elseif ($res2>$res1){
								
							$id_oficial_credito=$id_usuarios_1;
						}
							
						
						
						$id_oficial_credito=15417;
						
						
					}
					
				}
				
				
				try {
	
				    $solicitud_prestamo->beginTran();
				    
				    
					$funcion = "public.ins_solicitud_prestamo";
					$parametros = "'$_tipo_participe_datos_prestamo',
								  '$_monto_datos_prestamo',
								  '$_plazo_datos_prestamo',
								  '$_destino_dinero_datos_prestamo',
								  '$_tipo_cuenta_cuenta_bancaria',
								  '$_numero_cuenta_cuenta_bancaria',
								  '$_numero_cedula_datos_personales',
								  '$_apellidos_solicitante_datos_personales',
								  '$_nombres_solicitante_datos_personales',
								  '$_correo_solicitante_datos_personales',
								  '$_id_sexo_datos_personales',
								  '$_fecha_nacimiento_datos_personales',
								  '$_id_estado_civil_datos_personales',
								  '$_separacion_bienes_datos_personales',
								  '$_cargas_familiares_datos_personales',
								  '$_numero_hijos_datos_personales',
								  '$_nivel_educativo_datos_personales',
								  '$_id_provincias_vivienda',
								  '$_id_cantones_vivienda',
								  '$_id_parroquias_vivienda',
								  '$_barrio_sector_vivienda',
								  '$_ciudadela_conjunto_etapa_manzana_vivienda',
								  '$_calle_vivienda',
								  '$_numero_calle_vivienda',
								  '$_intersecion_vivienda',
								  '$_tipo_vivienda',
								  '$_vivienda_hipotecada_vivienda',
								  '$_tiempo_residencia_vivienda',
								  '$_nombre_propietario_vivienda',
								  '$_celular_propietario_vivienda',
								  '$_referencia_direccion_domicilio_vivienda',
								  '$_numero_casa_solicitante',
								  '$_numero_celular_solicitante',
								  '$_numero_trabajo_solicitante',
								  '$_extension_solicitante',
								  '$_apellidos_referencia_personal',
								  '$_nombres_referencia_personal',
								  '$_relacion_referencia_personal',
								  '$_numero_telefonico_referencia_personal',
								  '$_apellidos_referencia_familiar',
								  '$_nombres_referencia_familiar',
								  '$_parentesco_referencia_familiar',
								  '$_numero_telefonico_referencia_familiar',
								  '$_id_entidades',
								  '$_id_provincias_asignacion',
								  '$_id_cantones_asignacion',
								  '$_id_parroquias_asignacion',
								  '$_numero_telefonico_datos_laborales',
								  '$_interseccion_datos_laborales',
								  '$_calle_datos_laborales',
								  '$_cargo_actual_datos_laborales',
								  '$_sueldo_total_info_economica',
								  '$_cuota_prestamo_ordinario_info_economica',
								  '$_arriendos_info_economica',
								  '$_cuota_prestamo_emergente_info_economica',
								  '$_honorarios_profesionales_info_economica',
								  '$_cuota_otros_prestamos_info_economica',
								  '$_comisiones_info_economica',
								  '$_cuota_prestamo_iess_info_economica',
								  '$_horas_suplementarias_info_economica',
								  '$_arriendos_egre_info_economica',
								  '$_alimentacion_info_economica',
								  '$_otros_ingresos_1_info_economica',
								  '$_valor_ingresos_1_info_economica',
								  '$_estudios_info_economica',
								  '$_otros_ingresos_2_info_economica',
								  '$_valor_ingresos_2_info_economica',
								  '$_pago_servicios_basicos_info_economica',
								  '$_otros_ingresos_3_info_economica',
								  '$_valor_ingresos_3_info_economica',
								  '$_pago_tarjetas_credito_info_economica',
								  '$_otros_ingresos_4_info_economica',
								  '$_valor_ingresos_4_info_economica',
								  '$_afiliacion_cooperativas_info_economica',
								  '$_otros_ingresos_5_info_economica',
								  '$_valor_ingresos_5_info_economica',
								  '$_ahorro_info_economica',
								  '$_otros_ingresos_6_info_economica',
								  '$_valor_ingresos_6_info_economica',
								  '$_impuesto_renta_info_economica',
								  '$_otros_ingresos_7_info_economica',
								  '$_valor_ingresos_7_info_economica',
								  '$_otros_ingresos_8_info_economica',
								  '$_valor_ingresos_8_info_economica',
								  '$_otros_egresos_1_info_economica',
								  '$_valor_egresos_1_info_economica',
								  '$_total_ingresos_mensuales',
								  '$_total_egresos_mensuales',
								  '$_fecha_presentacion',
								  '$_id_usuarios_registra',
								  '$_identificador_consecutivos',
								  '$_id_tipo_creditos',
								  '$_id_banco_cuenta_bancaria',
					              '$_tipo_pago_cuenta_bancaria',
					              '$_id_sucursales',
								  '$id_oficial_credito',
					              '$_cedula_deudor_a_garantizar',
					              '$_nombre_deudor_a_garantizar',
                                  '$_identificador_consecutivos_deudor',
                                  '$_id_codigo_verificacion'";
					$solicitud_prestamo->setFuncion($funcion);
					$solicitud_prestamo->setParametros($parametros);
					$resultado=$solicitud_prestamo->llamafuncionPG();
					
					$error = "";
					$error = pg_last_error();
					if (!empty($error) || (int)$resultado[0] <= 0){
					    throw new Exception('error ingresando solicitud');
					}
					
				
					
				   $consecutivos->UpdateBy("identificador_consecutivos = identificador_consecutivos+1", "consecutivos", "nombre_consecutivos = 'SOLICITUD_PRESTAMOS'");
					
					
					
					
					
				    if($_id_estado_civil_datos_personales != 1 && $_id_estado_civil_datos_personales != 5 && $_id_estado_civil_datos_personales != 3){
					
					$resultSolicitud="";
					$resultSolicitud=$solicitud_prestamo->getBy("identificador_consecutivos='$_identificador_consecutivos' AND id_usuarios_registra='$_id_usuarios_registra' AND fecha_presentacion='$_fecha_presentacion' AND tipo_participe_datos_prestamo='$_tipo_participe_datos_prestamo'");
					
					
					$_id_solicitud_prestamo=0;
					if(!empty($resultSolicitud)){
						 
						$_id_solicitud_prestamo=$resultSolicitud[0]->id_solicitud_prestamo;
						 
						if($_id_solicitud_prestamo>0){
							
							if($_id_sexo_conyuge >0 && $_fecha_nacimiento_conyuge!=""){
							$colval_afi = "numero_cedula_conyuge= '$_numero_cedula_conyuge',
							apellidos_conyuge='$_apellidos_conyuge',
							nombres_conyuge='$_nombres_conyuge',
							id_sexo_conyuge='$_id_sexo_conyuge',
							fecha_nacimiento_conyuge='$_fecha_nacimiento_conyuge',
							convive_afiliado_conyuge='$_convive_afiliado_conyuge',
							numero_telefonico_conyuge='$_numero_telefonico_conyuge',
							actividad_economica_conyuge='$_actividad_economica_conyuge'";
							$tabla_afi = "solicitud_prestamo";
							$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo' AND identificador_consecutivos='$_identificador_consecutivos'";
							$resultado1=$solicitud_prestamo->ActualizarBy($colval_afi, $tabla_afi, $where_afi);
							
						
							
							$error = "";
							$error = pg_last_error();
							
							
							if (!empty($error) || (int)$resultado1 <= 0){
							    throw new Exception('error actualizando conyuge solicitud');
							}
							
							}
						}
						
					}
					
			}	
			
			
			    $solicitud_prestamo->EnviarMailSolCred($_correo_solicitante_datos_personales, $id_oficial_credito, $_nombres_solicitante_datos_personales, $_apellidos_solicitante_datos_personales);
			
			    
			    $solicitud_prestamo->endTran('COMMIT');
						
				} catch (Exception $e) {
	
				    $solicitud_prestamo->endTran();
					echo $e->getMessage();
    				die();
	
				}
		}
				
		
		
		
		
		//ACTUALIZAR DATOS EN USUARIOS
		
		$usuarios_act = new UsuariosModel();
		
		$colval_usu = "telefono_usuarios='$_numero_casa_solicitante',
                                       celular_usuarios='$_numero_celular_solicitante',
                                       correo_usuarios='$_correo_solicitante_datos_personales'";
		$tabla_usu = "usuarios";
		$where_usu = "cedula_usuarios = '$_numero_cedula_datos_personales'";
		$resultUsu=$usuarios_act->UpdateBy($colval_usu, $tabla_usu, $where_usu);
		
		
		
		
		
		
		//ACTUALIZAR DATOS EN SQL
		require_once 'core/EntidadBaseSQL.php';
		$db = new EntidadBaseSQL();
		
		$colval_partner = "PHONE='$_numero_casa_solicitante',
                                           PARNERT_MOVIL_PHONE='$_numero_celular_solicitante',
                                           EMAIL='$_correo_solicitante_datos_personales',
                                           BIRTH_DATE='$_fecha_nacimiento_datos_personales'";
		$tabla_partner = "one.PARTNER";
		$where_partner = "IDENTITY_CARD = '$_numero_cedula_datos_personales'";
		$resultPartner=$db->UpdateBy_SQL($colval_partner, $tabla_partner, $where_partner);
		
		
		
		
		
		
		
				$this->redirect("SolicitudPrestamo", "index2");
	
	
			}
			else
			{
	
				$this->redirect("SolicitudPrestamo", "index");
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
	
	
	
	
	
	public function AutocompleteCedula(){
		 
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		$solicitud_prestamo = new SolicitudPrestamoModel();
		$numero_cedula_datos_personales = $_GET['term'];
		 
		$resultSet=$solicitud_prestamo->getBy("numero_cedula_datos_personales LIKE '$numero_cedula_datos_personales%' AND tipo_participe_datos_prestamo='Deudor' AND id_estado_tramites in (1,4)");
		 
		if(!empty($resultSet)){
			 
			foreach ($resultSet as $res){
				 
				$_numero_cedula_datos_personales[] = $res->numero_cedula_datos_personales;
			}
			echo json_encode($_numero_cedula_datos_personales);
		}
		 
	}
	 
	
	


	public function AutocompleteDevuelveNombres(){
		 
		session_start();
		$_id_usuarios= $_SESSION['id_usuarios'];
		 
		$solicitud_prestamo = new SolicitudPrestamoModel();
		 
		$cedula_deudor_a_garantizar = $_POST['cedula_deudor_a_garantizar'];
		$resultSet=$solicitud_prestamo->getBy("numero_cedula_datos_personales = '$cedula_deudor_a_garantizar' AND tipo_participe_datos_prestamo='Deudor' AND id_estado_tramites in (1,4)");
		 
		$respuesta = new stdClass();
		 
		if(!empty($resultSet)){
			 
			$respuesta->apellidos_solicitante_datos_personales = $resultSet[0]->apellidos_solicitante_datos_personales;
			$respuesta->nombres_solicitante_datos_personales = $resultSet[0]->nombres_solicitante_datos_personales;
			 
			echo json_encode($respuesta);
		}
		 
	}
	 
	

	public function index2(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			$solicitud_prestamo = new SolicitudPrestamoModel();
			$nombre_controladores = "SolicitudPrestamo";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitud_prestamo->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				$this->view("ConsultaSolicitudPrestamo",array(
						""=>""
				));
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de prestamo."
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
	
	
	
	
	
	
	public function search_deudor(){
	
		session_start();
		$solicitud_prestamo = new SolicitudPrestamoModel();
		$usuarios = new UsuariosModel();
		$id_usuarios=$_SESSION["id_usuarios"];
		
		$where_to="";
		$columnas = "solicitud_prestamo.id_solicitud_prestamo, 
					  solicitud_prestamo.tipo_participe_datos_prestamo, 
					  solicitud_prestamo.monto_datos_prestamo, 
					  solicitud_prestamo.plazo_datos_prestamo, 
					  solicitud_prestamo.destino_dinero_datos_prestamo, 
					  solicitud_prestamo.nombre_banco_cuenta_bancaria, 
					  solicitud_prestamo.tipo_cuenta_cuenta_bancaria, 
					  solicitud_prestamo.numero_cuenta_cuenta_bancaria, 
					  solicitud_prestamo.numero_cedula_datos_personales, 
					  solicitud_prestamo.apellidos_solicitante_datos_personales, 
					  solicitud_prestamo.nombres_solicitante_datos_personales, 
					  solicitud_prestamo.correo_solicitante_datos_personales, 
					  sexo.nombre_sexo, 
					  solicitud_prestamo.fecha_nacimiento_datos_personales, 
					  estado_civil.nombre_estado_civil, 
					  solicitud_prestamo.fecha_presentacion, 
					  solicitud_prestamo.fecha_aprobacion, 
					  solicitud_prestamo.id_estado_tramites, 
					  solicitud_prestamo.identificador_consecutivos,
				      solicitud_prestamo.tipo_pago_cuenta_bancaria,
				      tipo_creditos.nombre_tipo_creditos,
				      usuarios.nombre_usuarios,
				      usuarios.correo_usuarios,
				      solicitud_prestamo.id_usuarios_oficial_credito_aprueba";
	
		$tablas   = "public.solicitud_prestamo, 
					  public.entidades, 
					  public.sexo, 
					  public.estado_civil,
				      public.tipo_creditos,
				      public.usuarios";
					
		$where    = "solicitud_prestamo.id_usuarios_oficial_credito_aprueba = usuarios.id_usuarios AND tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
				  solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
				  entidades.id_entidades = solicitud_prestamo.id_entidades AND
				  sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales AND solicitud_prestamo.id_usuarios_registra='$id_usuarios' AND solicitud_prestamo.tipo_participe_datos_prestamo='Deudor'";
	
		$id       = "solicitud_prestamo.id_solicitud_prestamo";
	
			
		$where_to=$where;
			
			
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
			
			
		if($action == 'ajax')
		{
			$html="";
			$resultSet=$solicitud_prestamo->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$solicitud_prestamo->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
			$count_query   = $cantidadResult;
			$total_pages = ceil($cantidadResult/$per_page);
	
	
			if($cantidadResult>0)
			{
				
				$html.='<div class="pull-left" style="margin-left:11px;">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div>';
				$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
				$html.='<section style="height:250px; overflow-y:scroll;">';
				$html.= "<table id='tabla_solicitud_prestamos_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Crédito</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Tipo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Monto</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Plazo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Transacción</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Presentación</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Fecha T</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Oficial C</th>';
				
				$html.='<th colspan="2" style="text-align: right;  font-size: 11px;"></th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					
				$i=0;
	
				foreach ($resultSet as $res)
				{
					
					$aprobado_oficial_credito=$res->id_estado_tramites;
					if($aprobado_oficial_credito==2){
						
						$estado_tramite='Guardado';
						
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
						
					}elseif($aprobado_oficial_credito==4){
						$estado_tramite='Revisado';
						
					}
					
					$html.='<tr>';
					
					$html.='<td style="font-size: 11px;">'.$res->numero_cedula_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->apellidos_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombres_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_creditos.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_participe_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->monto_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->plazo_datos_prestamo.' meses</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_pago_cuenta_bancaria.'</td>';
					$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_presentacion)).'</td>';
					$html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
					if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
						$html.='<td style="font-size: 11px;"></td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					}else{
						$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" title="Editar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					}
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
					 
					$html.='</tr>';
				
				}
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_load_solicitud_prestamos_registrados("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de prestamos registrados...</b>';
				$html.='</div>';
				$html.='</div>';
			}
	
			echo $html;
			die();
	
		}
	
	}
	
	
	
	
	public function search_garantes(){
	
		session_start();
		$solicitud_prestamo = new SolicitudPrestamoModel();
		$usuarios = new UsuariosModel();
		$id_usuarios=$_SESSION["id_usuarios"];
	
		$where_to="";
		$columnas = "solicitud_prestamo.id_solicitud_prestamo,
					  solicitud_prestamo.tipo_participe_datos_prestamo,
					  solicitud_prestamo.monto_datos_prestamo,
					  solicitud_prestamo.plazo_datos_prestamo,
					  solicitud_prestamo.destino_dinero_datos_prestamo,
					  solicitud_prestamo.nombre_banco_cuenta_bancaria,
					  solicitud_prestamo.tipo_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cedula_datos_personales,
					  solicitud_prestamo.apellidos_solicitante_datos_personales,
					  solicitud_prestamo.nombres_solicitante_datos_personales,
					  solicitud_prestamo.correo_solicitante_datos_personales,
					  sexo.nombre_sexo,
					  solicitud_prestamo.fecha_nacimiento_datos_personales,
					  estado_civil.nombre_estado_civil,
					  solicitud_prestamo.fecha_presentacion,
					  solicitud_prestamo.fecha_aprobacion,
					  solicitud_prestamo.id_estado_tramites,
					  solicitud_prestamo.identificador_consecutivos,
				      solicitud_prestamo.tipo_pago_cuenta_bancaria,
				      tipo_creditos.nombre_tipo_creditos,
				      usuarios.nombre_usuarios,
				      usuarios.correo_usuarios,
				      solicitud_prestamo.id_usuarios_oficial_credito_aprueba,
				      solicitud_prestamo.cedula_deudor_a_garantizar,
				      solicitud_prestamo.nombre_deudor_a_garantizar";
	
		$tablas   = "public.solicitud_prestamo,
					  public.entidades,
					  public.sexo,
					  public.estado_civil,
				      public.tipo_creditos,
				      public.usuarios";
			
		$where    = "solicitud_prestamo.id_usuarios_oficial_credito_aprueba = usuarios.id_usuarios AND tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
		solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
		entidades.id_entidades = solicitud_prestamo.id_entidades AND
		sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales AND solicitud_prestamo.id_usuarios_registra='$id_usuarios' AND solicitud_prestamo.tipo_participe_datos_prestamo='Garante'";
	
		$id       = "solicitud_prestamo.id_solicitud_prestamo";
	
			
		$where_to=$where;
			
			
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
			
			
		if($action == 'ajax')
		{
			$html="";
			$resultSet=$solicitud_prestamo->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$solicitud_prestamo->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
			$count_query   = $cantidadResult;
			$total_pages = ceil($cantidadResult/$per_page);
	
	
			if($cantidadResult>0)
			{
	
				$html.='<div class="pull-left" style="margin-left:11px;">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div>';
				$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
				$html.='<section style="height:250px; overflow-y:scroll;">';
				$html.= "<table id='tabla_solicitud_prestamos_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
	
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Crédito</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Tipo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Monto</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Plazo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula Deudor</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombres Deudor</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Fecha T</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Oficial C</th>';
	
				$html.='<th colspan="2" style="text-align: right;  font-size: 11px;"></th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					
				$i=0;
	
				foreach ($resultSet as $res)
				{
						
					$aprobado_oficial_credito=$res->id_estado_tramites;
					if($aprobado_oficial_credito==2){
	
						$estado_tramite='Guardado';
	
	
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
					}elseif($aprobado_oficial_credito==4){
						$estado_tramite='Revisado';
						
					}
						
					$html.='<tr>';
						
					$html.='<td style="font-size: 11px;">'.$res->numero_cedula_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->apellidos_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombres_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_creditos.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_participe_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->monto_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->plazo_datos_prestamo.' meses</td>';
					$html.='<td style="font-size: 11px;">'.$res->cedula_deudor_a_garantizar.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_deudor_a_garantizar.'</td>';
					$html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
					
					if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
						$html.='<td style="font-size: 11px;"></td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					}else{
						$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" title="Editar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					}
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
					$html.='</tr>';
	
				}
	
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->load_solicitud_garantias_registrados("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de garantías de prestamos registrados...</b>';
				$html.='</div>';
				$html.='</div>';
			}
	
			echo $html;
			die();
	
		}
	
	}
	
	
	
	
	
	
	
	public function  imprimir_pruebas () {
	    
	    
	    //session_start();
	    $usuarios = new UsuariosModel();
	    $solicitud_prestamo = new SolicitudPrestamoModel();
	    
	    $html="";
	    
	   // $id_usuarios = $_SESSION["id_usuarios"];
	    $fechaactual = getdate();
	    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	    $fechaactual=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
	    
	    $directorio = $_SERVER ['DOCUMENT_ROOT'] . '/webcapremci';
	    $dom=$directorio.'/view/dompdf/dompdf_config.inc.php';
	    $domLogo=$directorio.'/view/images/logo_contrato_adhesion.jpg';
	    $logo = '<img src="'.$domLogo.'" width="100%">';
	    
	    
	    
	    
	    $columnas="*";
	    $tablas="usuarios";
	    $where="cedula_usuarios='1712771318'";
	    $id="id_usuarios";
	    $resultSoli=$usuarios->getCondicionesDesc($columnas, $tablas, $where, $id);
	    
	    
	    
	    if(!empty($resultSoli)){
	        
	        // DATOS DEL PRESTAMO
	        $_numero_cedula_datos_personales       			=$resultSoli[0]->cedula_usuarios;
	        $_apellidos_solicitante_datos_personales       	=$resultSoli[0]->nombre_usuarios;
	        $_nombre_oficial_credito= "DIANA NAVARRETE";
	        
	    }
	    
	    // PARA GENERAR QR
	    require dirname(__FILE__)."\phpqrcode\qrlib.php";
	    
	    $ubicacion = dirname(__FILE__).'\..\barcode_participes\\';
	    
	    //Si no existe la carpeta la creamos
	    if (!file_exists($ubicacion))
	        mkdir($ubicacion);
	        
	        $i++;
	        $filename = $ubicacion.$_numero_cedula_datos_personales.'.png';
	        
	        //Parametros de Condiguracion
	        
	        $tamaño = 5; //Tama�o de Pixel
	        $level = 'L'; //Precisi�n Baja
	        $framSize = 3; //Tama�o en blanco
	        $contenido = $_numero_cedula_datos_personales; //Texto
	        
	        //Enviamos los parametros a la Funci�n para generar c�digo QR
	        QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
	        
	        $qr_participes = '<img src="'.$filename.'">';
	    
	    
	        
	        $html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$logo.'</div>';
	        
	        $html.='<table style="width: 100%; margin-top:30px;" >';
	        $html.='<tr>';
	        $html.='<th colspan="12" style="text-align:center; font-size: 18px;"><b>REGISTRO DE FIRMAS<b></th>';
	        $html.='</tr>';
	        $html.='<tr>';
	        $html.='<th colspan="12" style="text-align:center; font-size: 18px;"></th>';
	        $html.='</tr>';
	        $html.='<tr>';
	        $html.='<th colspan="12" style="text-align:left; font-size: 15px; font-weight: normal;"><b>No. de Cedula:</b> '.$_numero_cedula_datos_personales.'</th>';
	        $html.='</tr>';
	        $html.='<tr>';
	        $html.='<th colspan="12" style="text-align:left; font-size: 15px; font-weight: normal;"><b>Apellidos y Nombres:</b> '.$_apellidos_solicitante_datos_personales.'</th>';
	        $html.='</tr>';
	        
	        $html.='</table>';
	        
	        
	        $html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$qr_participes.'</div>';
	        
	        $html.='<table style="width: 100%;">';
	        $html.='<tr>';
	        $html.='<td colspan="2" style="text-align:center; font-size: 18px;"></th>';
	        $html.='<td colspan="8" style="text-align:center; font-size: 12px;"><b>Revisado por:</b> '.$_nombre_oficial_credito.'</th>';
	        $html.='<td colspan="2" style="text-align:center; font-size: 18px;"></th>';
	        $html.='</tr>';
	        $html.='</table>';
	        
	        $html.='<table style="width: 100%;">';
	        $html.='<tr>';
	        $html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
	        $html.='<th colspan="8" style="text-align:center; font-size: 18px;"><div style="width: 100%; height: 150px; border: 1px solid;"></div></th>';
	        $html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
	        $html.='</tr>';
	        $html.='</table>';
	        
	        $html.='<table style="width: 100%;">';
	        $html.='<tr>';
	        $html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
	        $html.='<th colspan="8" style="text-align:left; font-size: 14px; font-weight: normal;"><b>Nota: </b>Debe firmar dentro del recuadro sin colocar marcas fuera del mismo. La firma debe ser igual a la de la cédula.</th>';
	        $html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
	        $html.='</tr>';
	        $html.='</table>';
	    
	    
	    $this->report("SolicitudPrestamo",array("resultSet"=>$html));
	    die();
	    
	    
	    
	    
	}
	
	
	
	
	
	public function print()
	{
	
		session_start();
		$usuarios = new UsuariosModel();
		$solicitud_prestamo = new SolicitudPrestamoModel();
		
		$html="";
		
		$id_usuarios = $_SESSION["id_usuarios"];
		$fechaactual = getdate();
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fechaactual=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		 
		$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/webcapremci';
		$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';
		$domLogo=$directorio.'/view/images/logo_contrato_adhesion.jpg';
		$logo = '<img src="'.$domLogo.'" width="100%">';
		 
		
		if(!empty($id_usuarios)){
			
			if(isset($_GET["id_solicitud_prestamo"])){
			
				$id_solicitud_prestamo=$_GET["id_solicitud_prestamo"];
				
				$columnas="solicitud_prestamo.id_solicitud_prestamo, 
						  solicitud_prestamo.tipo_participe_datos_prestamo, 
						  solicitud_prestamo.monto_datos_prestamo, 
						  solicitud_prestamo.plazo_datos_prestamo, 
						  solicitud_prestamo.destino_dinero_datos_prestamo, 
						  solicitud_prestamo.nombre_banco_cuenta_bancaria,
						  solicitud_prestamo.tipo_cuenta_cuenta_bancaria, 
						  solicitud_prestamo.numero_cuenta_cuenta_bancaria, 
						  solicitud_prestamo.numero_cedula_datos_personales, 
						  solicitud_prestamo.apellidos_solicitante_datos_personales, 
						  solicitud_prestamo.nombres_solicitante_datos_personales, 
						  solicitud_prestamo.correo_solicitante_datos_personales, 
						  sexo.nombre_sexo, 
						  solicitud_prestamo.fecha_nacimiento_datos_personales, 
						  estado_civil.nombre_estado_civil, 
						  solicitud_prestamo.separacion_bienes_datos_personales, 
						  solicitud_prestamo.cargas_familiares_datos_personales, 
						  solicitud_prestamo.numero_hijos_datos_personales, 
						  solicitud_prestamo.nivel_educativo_datos_personales, 
						  provincias.nombre_provincias, 
						  cantones.nombre_cantones, 
						  parroquias.nombre_parroquias, 
						  solicitud_prestamo.barrio_sector_vivienda, 
						  solicitud_prestamo.ciudadela_conjunto_etapa_manzana_vivienda, 
						  solicitud_prestamo.calle_vivienda, 
						  solicitud_prestamo.numero_calle_vivienda, 
						  solicitud_prestamo.intersecion_vivienda, 
						  solicitud_prestamo.tipo_vivienda, 
						  solicitud_prestamo.vivienda_hipotecada_vivienda, 
						  solicitud_prestamo.tiempo_residencia_vivienda, 
						  solicitud_prestamo.nombre_propietario_vivienda, 
						  solicitud_prestamo.celular_propietario_vivienda, 
						  solicitud_prestamo.referencia_direccion_domicilio_vivienda, 
						  solicitud_prestamo.numero_casa_solicitante, 
						  solicitud_prestamo.numero_celular_solicitante, 
						  solicitud_prestamo.numero_trabajo_solicitante, 
						  solicitud_prestamo.extension_solicitante, 
						  solicitud_prestamo.mode_solicitante, 
						  solicitud_prestamo.apellidos_referencia_personal, 
						  solicitud_prestamo.nombres_referencia_personal, 
						  solicitud_prestamo.relacion_referencia_personal, 
						  solicitud_prestamo.numero_telefonico_referencia_personal, 
						  solicitud_prestamo.apellidos_referencia_familiar, 
						  solicitud_prestamo.nombres_referencia_familiar, 
						  solicitud_prestamo.parentesco_referencia_familiar, 
						  solicitud_prestamo.numero_telefonico_referencia_familiar, 
						  entidades.nombre_entidades, 
						  solicitud_prestamo.id_provincias_asignacion, 
						  solicitud_prestamo.id_cantones_asignacion, 
						  solicitud_prestamo.id_parroquias_asignacion, 
						  solicitud_prestamo.numero_telefonico_datos_laborales, 
						  solicitud_prestamo.interseccion_datos_laborales, 
						  solicitud_prestamo.calle_datos_laborales, 
						  solicitud_prestamo.cargo_actual_datos_laborales, 
						  solicitud_prestamo.sueldo_total_info_economica, 
						  solicitud_prestamo.cuota_prestamo_ordinario_info_economica, 
						  solicitud_prestamo.arriendos_info_economica, 
						  solicitud_prestamo.cuota_prestamo_emergente_info_economica, 
						  solicitud_prestamo.honorarios_profesionales_info_economica, 
						  solicitud_prestamo.cuota_otros_prestamos_info_economica, 
						  solicitud_prestamo.comisiones_info_economica, 
						  solicitud_prestamo.cuota_prestamo_iess_info_economica, 
						  solicitud_prestamo.horas_suplementarias_info_economica, 
						  solicitud_prestamo.arriendos_egre_info_economica, 
						  solicitud_prestamo.alimentacion_info_economica, 
						  solicitud_prestamo.otros_ingresos_1_info_economica, 
						  solicitud_prestamo.valor_ingresos_1_info_economica, 
						  solicitud_prestamo.estudios_info_economica, 
						  solicitud_prestamo.otros_ingresos_2_info_economica, 
						  solicitud_prestamo.valor_ingresos_2_info_economica, 
						  solicitud_prestamo.pago_servicios_basicos_info_economica, 
						  solicitud_prestamo.otros_ingresos_3_info_economica, 
						  solicitud_prestamo.valor_ingresos_3_info_economica, 
						  solicitud_prestamo.pago_tarjetas_credito_info_economica, 
						  solicitud_prestamo.otros_ingresos_4_info_economica, 
						  solicitud_prestamo.valor_ingresos_4_info_economica, 
						  solicitud_prestamo.afiliacion_cooperativas_info_economica, 
						  solicitud_prestamo.otros_ingresos_5_info_economica, 
						  solicitud_prestamo.valor_ingresos_5_info_economica, 
						  solicitud_prestamo.ahorro_info_economica, 
						  solicitud_prestamo.otros_ingresos_6_info_economica, 
						  solicitud_prestamo.valor_ingresos_6_info_economica, 
						  solicitud_prestamo.impuesto_renta_info_economica, 
						  solicitud_prestamo.otros_ingresos_7_info_economica, 
						  solicitud_prestamo.valor_ingresos_7_info_economica, 
						  solicitud_prestamo.otros_ingresos_8_info_economica, 
						  solicitud_prestamo.valor_ingresos_8_info_economica, 
						  solicitud_prestamo.otros_egresos_1_info_economica, 
						  solicitud_prestamo.valor_egresos_1_info_economica, 
						  solicitud_prestamo.total_ingresos_mensuales, 
						  solicitud_prestamo.total_egresos_mensuales, 
						  solicitud_prestamo.numero_cedula_conyuge, 
						  solicitud_prestamo.apellidos_conyuge, 
						  solicitud_prestamo.nombres_conyuge, 
						  solicitud_prestamo.id_sexo_conyuge, 
						  solicitud_prestamo.fecha_nacimiento_conyuge, 
						  solicitud_prestamo.convive_afiliado_conyuge, 
						  solicitud_prestamo.numero_telefonico_conyuge, 
						  solicitud_prestamo.actividad_economica_conyuge, 
						  solicitud_prestamo.fecha_presentacion, 
                          solicitud_prestamo.fecha_aprobacion,
						  solicitud_prestamo.id_usuarios_registra, 
						  solicitud_prestamo.identificador_consecutivos,
						  solicitud_prestamo.tipo_pago_cuenta_bancaria,
						  tipo_creditos.nombre_tipo_creditos,
						  solicitud_prestamo.id_sucursales,
						  solicitud_prestamo.porcentaje_aportacion,
                          usuarios.nombre_usuarios";
				$tablas=" public.solicitud_prestamo, 
						  public.tipo_creditos,
						  public.provincias, 
						  public.sexo, 
						  public.estado_civil, 
						  public.cantones, 
						  public.parroquias, 
						  public.entidades,
                          public.usuarios";
				$where="tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
					  solicitud_prestamo.id_sexo_datos_personales = sexo.id_sexo AND
					  solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
					  solicitud_prestamo.id_provincias_vivienda = provincias.id_provincias AND
					  solicitud_prestamo.id_cantones_vivienda = cantones.id_cantones AND
					  solicitud_prestamo.id_parroquias_vivienda = parroquias.id_parroquias AND
                      usuarios.id_usuarios = solicitud_prestamo.id_usuarios_oficial_credito_aprueba AND
					  entidades.id_entidades = solicitud_prestamo.id_entidades AND solicitud_prestamo.id_solicitud_prestamo='$id_solicitud_prestamo'";
				$id="solicitud_prestamo.id_solicitud_prestamo";
				
				$resultSoli=$solicitud_prestamo->getCondicionesDesc($columnas, $tablas, $where, $id);
				
				
				
				if(!empty($resultSoli)){
						
					// DATOS DEL PRESTAMO
					$_id_solicitud_prestamo       					=$resultSoli[0]->id_solicitud_prestamo;
					$_tipo_participe_datos_prestamo       			=$resultSoli[0]->tipo_participe_datos_prestamo;
					$_monto_datos_prestamo       					=$resultSoli[0]->monto_datos_prestamo;
					$_plazo_datos_prestamo       					=$resultSoli[0]->plazo_datos_prestamo;
					$_destino_dinero_datos_prestamo       			=$resultSoli[0]->destino_dinero_datos_prestamo;
					
					
					$_nombre_tipo_creditos                          =$resultSoli[0]->nombre_tipo_creditos;
					$_tipo_pago_cuenta_bancaria                     =$resultSoli[0]->tipo_pago_cuenta_bancaria;
					$_nombre_bancos_datos_prestamo       			=$resultSoli[0]->nombre_banco_cuenta_bancaria;
					
					$_abreviaciones_bancos="";
					$bancos = new BancosModel();
					$resultBank= $bancos->getBy("nombre_bancos='$_nombre_bancos_datos_prestamo'");
					if(!empty($resultBank)){
						$_abreviaciones_bancos       			=$resultBank[0]->abreviaciones_bancos;
					}else{
						$_abreviaciones_bancos="";
					}
					
						
					
					
					
					$_tipo_cuenta_cuenta_bancaria       			=$resultSoli[0]->tipo_cuenta_cuenta_bancaria;
					$_numero_cuenta_cuenta_bancaria       			=$resultSoli[0]->numero_cuenta_cuenta_bancaria;
					$_numero_cedula_datos_personales       			=$resultSoli[0]->numero_cedula_datos_personales;
					
					// DATOS PERSONALES
					$_apellidos_solicitante_datos_personales        =$resultSoli[0]->apellidos_solicitante_datos_personales;
					$_nombres_solicitante_datos_personales       	=$resultSoli[0]->nombres_solicitante_datos_personales;
					$_correo_solicitante_datos_personales       	=$resultSoli[0]->correo_solicitante_datos_personales;
					$_nombre_sexo_solicitante_datos_personales      =$resultSoli[0]->nombre_sexo;
					$_fecha_nacimiento_datos_personales       		=$resultSoli[0]->fecha_nacimiento_datos_personales;
					$_nombre_estado_civil_solicitante_datos_personales  =$resultSoli[0]->nombre_estado_civil;
					$_separacion_bienes_datos_personales       		=$resultSoli[0]->separacion_bienes_datos_personales;
					$_cargas_familiares_datos_personales       		=$resultSoli[0]->cargas_familiares_datos_personales;
					$_numero_hijos_datos_personales       			=$resultSoli[0]->numero_hijos_datos_personales;
					$_nivel_educativo_datos_personales       		=$resultSoli[0]->nivel_educativo_datos_personales;
					
					//DIRECCIÓN EXACTA DEL DOMICILIO
					$_nombre_provincias_vivienda       				=$resultSoli[0]->nombre_provincias;
					$_nombre_cantones_vivienda       				=$resultSoli[0]->nombre_cantones;
					$_nombre_parroquias_vivienda       				=$resultSoli[0]->nombre_parroquias;
					$_barrio_sector_vivienda       					=$resultSoli[0]->barrio_sector_vivienda;
					$_ciudadela_conjunto_etapa_manzana_vivienda     =$resultSoli[0]->ciudadela_conjunto_etapa_manzana_vivienda;
					$_calle_vivienda       							=$resultSoli[0]->calle_vivienda;
					$_numero_calle_vivienda       					=$resultSoli[0]->numero_calle_vivienda;
					$_intersecion_vivienda       					=$resultSoli[0]->intersecion_vivienda;
					$_tipo_vivienda       							=$resultSoli[0]->tipo_vivienda;
					$_vivienda_hipotecada_vivienda       			=$resultSoli[0]->vivienda_hipotecada_vivienda;
					$_tiempo_residencia_vivienda       				=$resultSoli[0]->tiempo_residencia_vivienda;
					$_nombre_propietario_vivienda       			=$resultSoli[0]->nombre_propietario_vivienda;
					$_celular_propietario_vivienda       			=$resultSoli[0]->celular_propietario_vivienda;
					$_referencia_direccion_domicilio_vivienda       =$resultSoli[0]->referencia_direccion_domicilio_vivienda;
					$_numero_casa_solicitante       				=$resultSoli[0]->numero_casa_solicitante;
					$_numero_celular_solicitante       				=$resultSoli[0]->numero_celular_solicitante;
					$_numero_trabajo_solicitante       				=$resultSoli[0]->numero_trabajo_solicitante;
					$_extension_solicitante       					=$resultSoli[0]->extension_solicitante;
					$_mode_solicitante       						=$resultSoli[0]->mode_solicitante;
					$_apellidos_referencia_personal       			=$resultSoli[0]->apellidos_referencia_personal;
					$_nombres_referencia_personal       			=$resultSoli[0]->nombres_referencia_personal;
					$_relacion_referencia_personal       			=$resultSoli[0]->relacion_referencia_personal;
					$_numero_telefonico_referencia_personal       	=$resultSoli[0]->numero_telefonico_referencia_personal;
					$_apellidos_referencia_familiar       			=$resultSoli[0]->apellidos_referencia_familiar;
					$_nombres_referencia_familiar       			=$resultSoli[0]->nombres_referencia_familiar;
					$_parentesco_referencia_familiar       			=$resultSoli[0]->parentesco_referencia_familiar;
					$_numero_telefonico_referencia_familiar         =$resultSoli[0]->numero_telefonico_referencia_familiar;
					
					// DATOS LABORALES
					$_nombre_entidades       						=$resultSoli[0]->nombre_entidades;
					$_id_provincias_asignacion       				=$resultSoli[0]->id_provincias_asignacion;
					
					$provincias = new ProvinciasModel();
					$resultProvincias= $provincias->getBy("id_provincias='$_id_provincias_asignacion'");
					$_nombre_provincias_asignacion       				=$resultProvincias[0]->nombre_provincias;
					
					
						
					$_id_cantones_asignacion       					=$resultSoli[0]->id_cantones_asignacion;
					$cantones = new CantonesModel();
					$resultCantones= $cantones->getBy("id_cantones='$_id_cantones_asignacion'");
					$_nombre_cantones_asignacion       				=$resultCantones[0]->nombre_cantones;
					
					
					$_id_parroquias_asignacion       				=$resultSoli[0]->id_parroquias_asignacion;
					$parroquias = new ParroquiasModel();
					$resultParroquias= $parroquias->getBy("id_parroquias='$_id_parroquias_asignacion'");
					$_nombre_parroquias_asignacion       				=$resultParroquias[0]->nombre_parroquias;
					
					
					$_numero_telefonico_datos_laborales       		=$resultSoli[0]->numero_telefonico_datos_laborales;
					$_interseccion_datos_laborales       			=$resultSoli[0]->interseccion_datos_laborales;
					$_calle_datos_laborales       					=$resultSoli[0]->calle_datos_laborales;
					$_cargo_actual_datos_laborales       			=$resultSoli[0]->cargo_actual_datos_laborales;
					
					// INFORMACIÓN ECONONÓMICA
					$_sueldo_total_info_economica       			=$resultSoli[0]->sueldo_total_info_economica;
					$_cuota_prestamo_ordinario_info_economica       =$resultSoli[0]->cuota_prestamo_ordinario_info_economica;
					$_arriendos_info_economica       				=$resultSoli[0]->arriendos_info_economica;
					$_cuota_prestamo_emergente_info_economica       =$resultSoli[0]->cuota_prestamo_emergente_info_economica;
					$_honorarios_profesionales_info_economica       =$resultSoli[0]->honorarios_profesionales_info_economica;
					$_cuota_otros_prestamos_info_economica       	=$resultSoli[0]->cuota_otros_prestamos_info_economica;
					$_comisiones_info_economica       				=$resultSoli[0]->comisiones_info_economica;
					$_cuota_prestamo_iess_info_economica       		=$resultSoli[0]->cuota_prestamo_iess_info_economica;
					$_horas_suplementarias_info_economica       	=$resultSoli[0]->horas_suplementarias_info_economica;
					$_arriendos_egre_info_economica       			=$resultSoli[0]->arriendos_egre_info_economica;
					$_alimentacion_info_economica       			=$resultSoli[0]->alimentacion_info_economica;
					$_otros_ingresos_1_info_economica       		=$resultSoli[0]->otros_ingresos_1_info_economica;
					$_valor_ingresos_1_info_economica       		=$resultSoli[0]->valor_ingresos_1_info_economica;
					$_estudios_info_economica       				=$resultSoli[0]->estudios_info_economica;
					$_otros_ingresos_2_info_economica       		=$resultSoli[0]->otros_ingresos_2_info_economica;
					$_valor_ingresos_2_info_economica       		=$resultSoli[0]->valor_ingresos_2_info_economica;
					$_pago_servicios_basicos_info_economica       	=$resultSoli[0]->pago_servicios_basicos_info_economica;
					$_otros_ingresos_3_info_economica       		=$resultSoli[0]->otros_ingresos_3_info_economica;
					$_valor_ingresos_3_info_economica       		=$resultSoli[0]->valor_ingresos_3_info_economica;
					$_pago_tarjetas_credito_info_economica       	=$resultSoli[0]->pago_tarjetas_credito_info_economica;
					$_otros_ingresos_4_info_economica       		=$resultSoli[0]->otros_ingresos_4_info_economica;
					$_valor_ingresos_4_info_economica       		=$resultSoli[0]->valor_ingresos_4_info_economica;
					$_afiliacion_cooperativas_info_economica        =$resultSoli[0]->afiliacion_cooperativas_info_economica;
					$_otros_ingresos_5_info_economica       		=$resultSoli[0]->otros_ingresos_5_info_economica;
					$_valor_ingresos_5_info_economica       		=$resultSoli[0]->valor_ingresos_5_info_economica;
					$_ahorro_info_economica       					=$resultSoli[0]->ahorro_info_economica;
					$_otros_ingresos_6_info_economica       		=$resultSoli[0]->otros_ingresos_6_info_economica;
					$_valor_ingresos_6_info_economica       		=$resultSoli[0]->valor_ingresos_6_info_economica;
					$_impuesto_renta_info_economica       			=$resultSoli[0]->impuesto_renta_info_economica;
					$_otros_ingresos_7_info_economica       		=$resultSoli[0]->otros_ingresos_7_info_economica;
					$_valor_ingresos_7_info_economica       		=$resultSoli[0]->valor_ingresos_7_info_economica;
					$_otros_ingresos_8_info_economica       		=$resultSoli[0]->otros_ingresos_8_info_economica;
					$_valor_ingresos_8_info_economica       		=$resultSoli[0]->valor_ingresos_8_info_economica;
					$_otros_egresos_1_info_economica       			=$resultSoli[0]->otros_egresos_1_info_economica;
					$_valor_egresos_1_info_economica       			=$resultSoli[0]->valor_egresos_1_info_economica;
					$_total_ingresos_mensuales       				=$resultSoli[0]->total_ingresos_mensuales;
					$_total_egresos_mensuales       				=$resultSoli[0]->total_egresos_mensuales;
					
					// DATOS DEL CONYUGE
					$_numero_cedula_conyuge       					=$resultSoli[0]->numero_cedula_conyuge;
					$_apellidos_conyuge       						=$resultSoli[0]->apellidos_conyuge;
					$_nombres_conyuge       						=$resultSoli[0]->nombres_conyuge;
					
					$_id_sexo_conyuge       						=$resultSoli[0]->id_sexo_conyuge;
					
					if($_id_sexo_conyuge>0){
					$sexo= new SexoModel();
					$resultSexo = $sexo->getBy("id_sexo='$_id_sexo_conyuge'");
					$_nombre_sexo_conyuge       				    =$resultSexo[0]->nombre_sexo;
					}else{
						$_nombre_sexo_conyuge="";
					}
					
					$_fecha_nacimiento_conyuge       				=$resultSoli[0]->fecha_nacimiento_conyuge;
					$_convive_afiliado_conyuge       				=$resultSoli[0]->convive_afiliado_conyuge;
					$_numero_telefonico_conyuge       				=$resultSoli[0]->numero_telefonico_conyuge;
					$_actividad_economica_conyuge       			=$resultSoli[0]->actividad_economica_conyuge;
					
				
					// FECHA DE PRESENTACION
					$_fecha_presentacion       						=$resultSoli[0]->fecha_presentacion;
					$_fecha_aprobacion       						=$resultSoli[0]->fecha_aprobacion;
					
					
					
					/*
					if(!empty($_fecha_aprobacion)){
					    
					    
					}else{
					    
					    
					    date_default_timezone_set('America/Guayaquil');
					    $_fecha_aprobacion = date('Y-m-d');
					    
					}
					*/
					
					
					// DATOS USUARIO
					$_id_usuarios_registra       					=$resultSoli[0]->id_usuarios_registra;
					$_identificador_consecutivos     				=$resultSoli[0]->identificador_consecutivos;
					
					$creado                                          ="a los <b>".date('d',strtotime($_fecha_aprobacion))."</b> días del mes de <b>".$meses[date('n',strtotime($_fecha_aprobacion))-1]. "</b> del <b>".date('Y',strtotime($_fecha_aprobacion))."</b>";
					
					$_id_sucursales                                 =$resultSoli[0]->id_sucursales;
					
					if($_id_sucursales>0){
						$sucursales = new SucursalesModel();
						$resultSucursales = $sucursales->getBy("id_sucursales='$_id_sucursales'");
						$_nombre_sucursales       				    =$resultSucursales[0]->nombre_sucursales;
					}else{
						$_nombre_sucursales="";
					}
					
					$_porcentaje_aportacion                     =$resultSoli[0]->porcentaje_aportacion;
					
					$_nombre_oficial_credito                     =$resultSoli[0]->nombre_usuarios;
					
						
				
					
					
				/*
				 // PARA GENERAR CODIGO DE BARRAS
				include dirname(__FILE__).'\barcode.php';
				
				
				$ubicacion =   dirname(__FILE__).'\..\barcode_participes'.'\\'.$_numero_cedula_datos_personales.'.png';
				barcode($ubicacion, $_numero_cedula_datos_personales, 20, 'horizontal', 'code128', FALSE);
				*/
				
					
					
					
				// PARA GENERAR QR
					require dirname(__FILE__)."\phpqrcode\qrlib.php";
					
					$ubicacion = dirname(__FILE__).'\..\barcode_participes\\';
					
					//Si no existe la carpeta la creamos
					if (!file_exists($ubicacion))
					    mkdir($ubicacion);
					    
					    $i++;
					    $filename = $ubicacion.$_numero_cedula_datos_personales.'.png';
					  
					    //Parametros de Condiguracion
					    
					    $tamaño = 5; //Tama�o de Pixel
					    $level = 'L'; //Precisi�n Baja
					    $framSize = 3; //Tama�o en blanco
					    $contenido = $_numero_cedula_datos_personales; //Texto
					    
					    //Enviamos los parametros a la Funci�n para generar c�digo QR
					    QRcode::png($contenido, $filename, $level, $tamaño, $framSize);
					    
					    $qr_participes = '<img src="'.$filename.'">';
					    
					    
				
				
				$html.='<table style="width: 100%;"  border=1 cellspacing=0.0001 >';
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 18px;"><b>FONDO COMPLEMENTARIO PREVISIONAL CERRADO DE CESANTÍA DE SERVIDORES Y TRABAJADORES PÚBLICOS DE FUERZAS ARMADAS CAPREMCI<br>CRÉDITO '.$_nombre_tipo_creditos.'<br>SOLICITUD DE PRESTAMO N.-<b></th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:right; font-size: 13px;"><b>Fecha de Presentación: <b> '.$_fecha_aprobacion.'</th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 16px;"><b>DATOS DEL PRESTAMO<b></th>';
				$html.='</tr>';
				
				$html.='<tr>';
				if($_tipo_participe_datos_prestamo=='Deudor'){
					$html.='<td colspan="6" style="text-align:center; font-size: 13px;"><u><b>DEUDOR</b></u></td>';
					$html.='<td colspan="6" style="text-align:center; font-size: 13px;"><b>GARANTE</b></td>';
				}else{
					$html.='<td colspan="6" style="text-align:center; font-size: 13px;"><b>DEUDOR</b></td>';
					$html.='<td colspan="6" style="text-align:center; font-size: 13px;"><u><b>GARANTE</b></u></td>';
				}
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="1" style="text-align:center; font-size: 13px;">Monto en dólares</th>';
				$html.='<th colspan="1" style="text-align:center; font-size: 13px;">Plazo en meses</th>';
				$html.='<th colspan="10" style="text-align:center; font-size: 13px;">Destino del dinero</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				
				$html.='<td colspan="1" style="text-align:center; font-size: 13px;">'.$_monto_datos_prestamo.'</td>';
				$html.='<td colspan="1" style="text-align:center; font-size: 13px;">'.$_plazo_datos_prestamo.'</td>';
				
					if($_destino_dinero_datos_prestamo=='Estudios'){
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_destino_dinero_datos_prestamo.'</u></td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vivienda</td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vehículo</td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Consumo</td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Otro</td>';
					}elseif($_destino_dinero_datos_prestamo=='Vivienda'){
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Estudios</td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_destino_dinero_datos_prestamo.'</u></td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vehículo</td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Consumo</td>';
					   $html.='<td colspan="2" style="text-align:center; font-size: 13px;">Otro</td>';
					}
					elseif($_destino_dinero_datos_prestamo=='Vehículo'){
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Estudios</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vivienda</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_destino_dinero_datos_prestamo.'</u></td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Consumo</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Otro</td>';
					}
					elseif($_destino_dinero_datos_prestamo=='Consumo'){
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Estudios</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vivienda</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vehículo</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_destino_dinero_datos_prestamo.'</u></td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Otro</td>';
					}
					elseif($_destino_dinero_datos_prestamo=='Otro'){
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Estudios</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vivienda</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vehículo</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Consumo</td>';
						$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_destino_dinero_datos_prestamo.'</u></td>';
						
					}
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Para depósito en mi cuenta del</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Cuenta Actualizada Ahorros #</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Cuenta Actualizada Corriente #</th>';
				$html.='</tr>';
				
				
				if($_tipo_pago_cuenta_bancaria=='Depósito'){
				
					
						$html.='<tr>';
						if($_tipo_cuenta_cuenta_bancaria=='Ahorros'){
							
							$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_nombre_bancos_datos_prestamo.'</td>';
							$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_numero_cuenta_cuenta_bancaria.'</td>';
							$html.='<td colspan="4" style="text-align:center; font-size: 13px;">N/A</td>';
							
						}else{
							
							$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_bancos_datos_prestamo.'</td>';
							$html.='<td colspan="4" style="text-align:center; font-size: 13px;">N/A</td>';
							$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_numero_cuenta_cuenta_bancaria.'</td>';
						
						}
						$html.='</tr>';
				
						$html.='<tr>';
						$html.='<td colspan="12" style="text-align:left; font-size: 13px;"><b>Retira Cheque:</b> <u>No</u></td>';
						$html.='</tr>';
						
				}else{
					
					$html.='<tr>';
					if($_tipo_cuenta_cuenta_bancaria=='Ahorros'){
							
						$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_nombre_bancos_datos_prestamo.'</td>';
						$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_numero_cuenta_cuenta_bancaria.'</td>';
						$html.='<td colspan="4" style="text-align:center; font-size: 13px;">N/A</td>';
							
					}else{
							
						$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_bancos_datos_prestamo.'</td>';
						$html.='<td colspan="4" style="text-align:center; font-size: 13px;">N/A</td>';
						$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_numero_cuenta_cuenta_bancaria.'</td>';
					
					}
					$html.='</tr>';
					
					
					$html.='<tr>';
					$html.='<td colspan="12" style="text-align:left; font-size: 13px;"><b>Retira Cheque:</b> <u>Si</u></td>';
					$html.='</tr>';
				}
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 16px;"><b>DATOS PERSONALES<b></th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="9" style="text-align:left; font-size: 13px;">Apellidos y Nombres Completos</th>';
				$html.='<th colspan="3" style="text-align:left; font-size: 13px;">No. de Cédula</th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<td colspan="9" style="text-align:left; font-size: 13px;">'.$_apellidos_solicitante_datos_personales.' '.$_nombres_solicitante_datos_personales.'</td>';
				$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_numero_cedula_datos_personales.'</td>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="2" style="text-align:center; font-size: 13px;">Dirección Electrónica</th>';
				$html.='<th colspan="10" style="text-align:center; font-size: 13px;">Nivel Educativo</th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_correo_solicitante_datos_personales.'</td>';
				
				if($_nivel_educativo_datos_personales=='Primario'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nivel_educativo_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Secundario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Técnico</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Universitario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Postgrado</td>';
				}
				elseif($_nivel_educativo_datos_personales=='Secundario'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Primario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nivel_educativo_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Técnico</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Universitario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Postgrado</td>';
				}
				elseif($_nivel_educativo_datos_personales=='Técnico'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Primario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Secundario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nivel_educativo_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Universitario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Postgrado</td>';
				}
				
				elseif($_nivel_educativo_datos_personales=='Universitario'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Primario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Secundario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Técnico</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nivel_educativo_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Postgrado</td>';
				}
				elseif($_nivel_educativo_datos_personales=='Postgrado'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Primario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Secundario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Técnico</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Universitario</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nivel_educativo_datos_personales.'</u></td>';
					
				}
				
				
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="1" style="text-align:center; font-size: 13px;">Género</th>';
				$html.='<th colspan="1" style="text-align:center; font-size: 13px;">Fecha Nacimiento</th>';
				$html.='<th colspan="10" style="text-align:center; font-size: 13px;">Estado Civil</th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<td colspan="1" style="text-align:left; font-size: 13px;">'.$_nombre_sexo_solicitante_datos_personales.'</td>';
				$html.='<td colspan="1" style="text-align:left; font-size: 13px;">'.$_fecha_nacimiento_datos_personales.'</td>';
				
				if($_nombre_estado_civil_solicitante_datos_personales=='Soltero'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nombre_estado_civil_solicitante_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Casado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Divorciado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Union Libre</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Viudo</td>';
					
				}elseif($_nombre_estado_civil_solicitante_datos_personales=='Casado'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Soltero</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nombre_estado_civil_solicitante_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Divorciado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Union Libre</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Viudo</td>';
					
				}elseif($_nombre_estado_civil_solicitante_datos_personales=='Divorciado'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Soltero</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Casado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nombre_estado_civil_solicitante_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Union Libre</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Viudo</td>';
					
				}elseif($_nombre_estado_civil_solicitante_datos_personales=='Union Libre'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Soltero</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Casado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Divorciado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nombre_estado_civil_solicitante_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Viudo</td>';
				
				}elseif($_nombre_estado_civil_solicitante_datos_personales=='Viudo'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Soltero</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Casado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Divorciado</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Union Libre</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_nombre_estado_civil_solicitante_datos_personales.'</u></td>';
				}
				
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Separación de bienes</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Cargas familiares</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Número de cargas familiares</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				if($_separacion_bienes_datos_personales=='Si'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_separacion_bienes_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">No</td>';
					
				}else{
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Si</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_separacion_bienes_datos_personales.'</u></td>';
				}
				
				if($_cargas_familiares_datos_personales=='Si'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_cargas_familiares_datos_personales.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">No</td>';
						
				}else{
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Si</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_cargas_familiares_datos_personales.'</u></td>';
				}
				
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_numero_hijos_datos_personales.'</td>';
				$html.='</tr>';
				
				
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 16px;"><b>DIRECCIÓN EXACTA DEL DOMICILIO<b></th>';
				$html.='</tr>';
				
				
				
				$html.='<tr>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Provincia</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Cantón</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Parroquia</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_nombre_provincias_vivienda.'</td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_nombre_cantones_vivienda.'</td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">'.$_nombre_parroquias_vivienda.'</td>';
				$html.='</tr>';
				
				
				
				$html.='<tr>';
				$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Barrio y/o sector</th>';
				$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Ciudadela y/o conjunto / Etapa / Manzana</th>';
				$html.='</tr>';
				
				$html.='<tr>';
				
				if($_barrio_sector_vivienda!=""){
					$html.='<td colspan="6" style="text-align:justify; font-size: 13px;">'.$_barrio_sector_vivienda.'</td>';
					
				}else{
					$html.='<td colspan="6" style="text-align:justify; font-size: 13px;">N/A</td>';
					
				}
				
				
				if($_ciudadela_conjunto_etapa_manzana_vivienda!=""){
					$html.='<td colspan="6" style="text-align:justify; font-size: 13px;">'.$_ciudadela_conjunto_etapa_manzana_vivienda.'</td>';
					
						
				}else{
					$html.='<td colspan="6" style="text-align:justify; font-size: 13px;">N/A</td>';
					
						
				}
				
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Calle</th>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Número</th>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Intersección</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				
				if($_calle_vivienda!=""){
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_calle_vivienda.'</td>';
				}else{
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				
				if($_numero_calle_vivienda!=""){
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_numero_calle_vivienda.'</td>';
				}else{
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				
				if($_intersecion_vivienda!=""){
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_intersecion_vivienda.'</td>';
				}else{
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				
				
				
				
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="8" style="text-align:center; font-size: 13px;">Vivienda</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Su vivienda está hipotecada</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				if($_tipo_vivienda=='Propia'){
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;"><u>'.$_tipo_vivienda.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Arrendada</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Anticresis</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vive con Familiares</td>';
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Otra</td>';
						
				}elseif($_tipo_vivienda=='Arrendada'){
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Propia</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_tipo_vivienda.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Anticresis</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vive con Familiares</td>';
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Otra</td>';
						
				}elseif($_tipo_vivienda=='Anticresis'){
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Propia</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Arrendada</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_tipo_vivienda.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vive con Familiares</td>';
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Otra</td>';
						
				}
				elseif($_tipo_vivienda=='Vive con Familiares'){
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Propia</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Arrendada</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Anticresis</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_tipo_vivienda.'</u></td>';
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Otra</td>';
				
				}elseif($_tipo_vivienda=='Otra'){
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;">Propia</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Arrendada</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Anticresis</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Vive con Familiares</td>';
					$html.='<td colspan="1" style="text-align:center; font-size: 13px;"><u>'.$_tipo_vivienda.'</u></td>';
				}
				
				
				if($_vivienda_hipotecada_vivienda=='Si'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_vivienda_hipotecada_vivienda.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">No</td>';
						
				}else{
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Si</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_vivienda_hipotecada_vivienda.'</u></td>';
				}
				
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="2" style="text-align:center; font-size: 13px;">Tiempo de residencia</th>';
				$html.='<th colspan="10" style="text-align:left; font-size: 13px;">Si no tiene vivienda propia escriba el nombre y número telefónico del propietario</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_tiempo_residencia_vivienda.'</td>';
				
				if($_nombre_propietario_vivienda!=""){
					$html.='<td colspan="8" style="text-align:justify; font-size: 13px;">'.$_nombre_propietario_vivienda.'</td>';
					
				}else{
					$html.='<td colspan="8" style="text-align:justify; font-size: 13px;">N/A</td>';
					
				}
				
				
				if($_celular_propietario_vivienda!=""){
					$html.='<td colspan="2" style="text-align:justify; font-size: 13px;">'.$_celular_propietario_vivienda.'</td>';
						
				}else{
					$html.='<td colspan="2" style="text-align:justify; font-size: 13px;">N/A</td>';
						
				}
				
				
				
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:left; font-size: 13px;">Referencia de la dirección del domicilio</th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<td colspan="12" style="text-align:left; font-size: 13px;">'.$_referencia_direccion_domicilio_vivienda.'</td>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Casa</th>';
				$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Celular</th>';
				$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Trabajo</th>';
				$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Ext</th>';
				$html.='<th colspan="2" style="text-align:left; font-size: 13px;">Mode</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_numero_casa_solicitante.'</td>';
				$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_numero_celular_solicitante.'</td>';
				
				
				if($_numero_trabajo_solicitante!=""){
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_numero_trabajo_solicitante.'</td>';
				}else{
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				
				if($_extension_solicitante!=""){
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_extension_solicitante.'</td>';
				}else{
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				
				if($_mode_solicitante!=""){
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">'.$_mode_solicitante.'</td>';
				}else{
					$html.='<td colspan="2" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				
				
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Referencia Familiar que no viva con Ud</th>';
				$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Parentesco</th>';
				$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Número Telefónico</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<td colspan="6" style="text-align:left; font-size: 13px;">'.$_apellidos_referencia_familiar.' '.$_nombres_referencia_familiar.'</td>';
				$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_parentesco_referencia_familiar.'</td>';
				$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_numero_telefonico_referencia_familiar.'</td>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Referencia Personal</th>';
				$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Relación</th>';
				$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Número Telefónico</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<td colspan="6" style="text-align:left; font-size: 13px;">'.$_apellidos_referencia_personal.' '.$_nombres_referencia_personal.'</td>';
				$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_relacion_referencia_personal.'</td>';
				$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_numero_telefonico_referencia_personal.'</td>';
				$html.='</tr>';
				
				
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 16px;"><b>DATOS LABORALES<b></th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Institución o Empresa</th>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Provincia</th>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Cantón</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_entidades.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_provincias_asignacion.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_cantones_asignacion.'</td>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Parroquia</th>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Número</th>';
				$html.='<th colspan="4" style="text-align:left; font-size: 13px;">Intersección</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_nombre_parroquias_asignacion.'</td>';
				if($_numero_telefonico_datos_laborales!=""){
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_numero_telefonico_datos_laborales.'</td>';
					
				}else{
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
					
				}
				
				if($_interseccion_datos_laborales!=""){
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_interseccion_datos_laborales.'</td>';
					
				}else{
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Calle</th>';
				$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Cargo Actual</th>';
				$html.='</tr>';
				
				$html.='<tr>';
				if($_calle_datos_laborales!=""){
					$html.='<td colspan="6" style="text-align:left; font-size: 13px;">'.$_calle_datos_laborales.'</td>';
					
				}else{
					$html.='<td colspan="6" style="text-align:left; font-size: 13px;">N/A</td>';
					
				}
				
				if($_cargo_actual_datos_laborales!=""){
					$html.='<td colspan="6" style="text-align:left; font-size: 13px;">'.$_cargo_actual_datos_laborales.'</td>';
						
				}else{
					$html.='<td colspan="6" style="text-align:left; font-size: 13px;">N/A</td>';
				}
				
				$html.='</tr>';
				
				
				//$html.='</table>';
				
				//$html.='<table style="page-break-after:always; width: 100%;"  border=1 cellspacing=0.0001 >';
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 16px;"><b>INFORMACIÓN ECONÓMICA<b></th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Ingresos Mensuales</th>';
				$html.='<th colspan="2" style="text-align:center; font-size: 13px;">Valor en dólares</th>';
				$html.='<th colspan="4" style="text-align:center; font-size: 13px;">Gastos Mensuales</th>';
				$html.='<th colspan="2" style="text-align:center; font-size: 13px;">Valor en dólares</th>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Sueldo Total</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_sueldo_total_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Cuota del Préstamo Ordinario CAPREMCI</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_cuota_prestamo_ordinario_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Arriendos</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_arriendos_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Cuota del Préstamo Emergente CAPREMCI</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_cuota_prestamo_emergente_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Honorarios Profesionales</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_honorarios_profesionales_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Cuotas de Otros Préstamos</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_cuota_otros_prestamos_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Comisiones</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_comisiones_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Cuotas de Prestamos con el IESS</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_cuota_prestamo_iess_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Horas Suplementarias</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_horas_suplementarias_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Arriendo</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_arriendos_egre_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="6" style="text-align:center; font-size: 13px;"><b>OTROS INGRESOS (detalle)</b></td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Alimentación</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_alimentacion_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_1_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_1_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Estudios</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_estudios_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_2_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_2_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Pago Servicios Básicos</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_pago_servicios_basicos_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_3_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_3_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Pago Tarjetas de Crédito</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_pago_tarjetas_credito_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_4_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_4_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Afiliación a Cooperativas</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_afiliacion_cooperativas_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_5_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_5_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Ahorro</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_ahorro_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_6_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_6_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">Impuesto a la Renta</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_impuesto_renta_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_7_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_7_info_economica.'</td>';
				$html.='<td colspan="6" style="text-align:center; font-size: 13px;"><b>OTROS GASTOS (detalle)</b></td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_ingresos_8_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_ingresos_8_info_economica.'</td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_otros_egresos_1_info_economica.'</td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;">'.$_valor_egresos_1_info_economica.'</td>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;"><b>Total de Ingresos Mensuales</b></td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><b>'.$_total_ingresos_mensuales.'</b></td>';
				$html.='<td colspan="4" style="text-align:left; font-size: 13px;"><b>Total de Gastos Mensuales</b></td>';
				$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><b>'.$_total_egresos_mensuales.'</b></td>';
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 16px;"><b>DATOS DEL CÓNYUGE O PAREJA<b></th>';
				$html.='</tr>';
				
				if($_apellidos_conyuge!="" && $_nombres_conyuge!=""){
					$html.='<tr>';
					$html.='<th colspan="8" style="text-align:left; font-size: 13px;">Apellidos y Nombres Completos</th>';
					$html.='<th colspan="4" style="text-align:left; font-size: 13px;">No. de Cédula</th>';
					$html.='</tr>';
					
					$html.='<tr>';
					$html.='<td colspan="8" style="text-align:left; font-size: 13px;">'.$_apellidos_conyuge.' '.$_nombres_conyuge.'</td>';
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">'.$_numero_cedula_conyuge.'</td>';
					$html.='</tr>';
					
					$html.='<tr>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Género</th>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Fecha Nacimiento</th>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Vive en la residencia del afiliado</th>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Número telefónico</th>';
					$html.='</tr>';
					
					
					$html.='<tr>';
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_nombre_sexo_conyuge.'</td>';
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_fecha_nacimiento_conyuge.'</td>';
					$html.='<td colspan="3" style="text-align:center; font-size: 13px;">'.$_convive_afiliado_conyuge.'</td>';
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">'.$_numero_telefonico_conyuge.'</td>';
					$html.='</tr>';
				
				}else{
					
					$html.='<tr>';
					$html.='<th colspan="8" style="text-align:left; font-size: 13px;">Apellidos y Nombres Completos</th>';
					$html.='<th colspan="4" style="text-align:left; font-size: 13px;">No. de Cédula</th>';
					$html.='</tr>';
					
					$html.='<tr>';
					$html.='<td colspan="8" style="text-align:left; font-size: 13px;">N/A</td>';
					$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
					$html.='</tr>';
					
					$html.='<tr>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Género</th>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Fecha Nacimiento</th>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Vive en la residencia del afiliado</th>';
					$html.='<th colspan="3" style="text-align:left; font-size: 13px;">Número telefónico</th>';
					$html.='</tr>';
					
					
					$html.='<tr>';
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">N/A</td>';
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">N/A</td>';
					$html.='<td colspan="3" style="text-align:center; font-size: 13px;">N/A</td>';
					$html.='<td colspan="3" style="text-align:left; font-size: 13px;">N/A</td>';
					$html.='</tr>';
				}
				
				
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 14px;"><b>Actividad económica del cónyuge<b></th>';
				$html.='</tr>';
				
				$html.='<tr>';
				if($_actividad_economica_conyuge=='Ama de Casa'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_actividad_economica_conyuge.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Empleado Público</td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">Libre Ejercicio Profesional</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Independiente</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Jubilado</td>';
				}elseif ($_actividad_economica_conyuge=='Empleado Público'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Ama de Casa</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_actividad_economica_conyuge.'</u></td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">Libre Ejercicio Profesional</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Independiente</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Jubilado</td>';
					
				}elseif ($_actividad_economica_conyuge=='Libre Ejercicio Profesional'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Ama de Casa</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Empleado Público</td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;"><u>'.$_actividad_economica_conyuge.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Independiente</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Jubilado</td>';
					
				}elseif ($_actividad_economica_conyuge=='Independiente'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Ama de Casa</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Empleado Público</td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">Libre Ejercicio Profesional</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_actividad_economica_conyuge.'</u></td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Jubilado</td>';
					
				}elseif ($_actividad_economica_conyuge=='Jubilado'){
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Ama de Casa</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Empleado Público</td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">Libre Ejercicio Profesional</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Independiente</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;"><u>'.$_actividad_economica_conyuge.'</u></td>';
					
				}else {
					
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Ama de Casa</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Empleado Público</td>';
					$html.='<td colspan="4" style="text-align:center; font-size: 13px;">Libre Ejercicio Profesional</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Independiente</td>';
					$html.='<td colspan="2" style="text-align:center; font-size: 13px;">Jubilado</td>';
						
				}
				
				$html.='</tr>';
				
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:justify; font-size: 10px;">"Declaro y me responsabilizo que toda la información en esta solicitud es correcta. Así mismo, expresamente autorizo que se obtenga de cualquier fuente de
																						información referencias relativas a mi comportamiento crediticio, manejo de mi(s) tarjeta(s) de crédito, etc., y ,en general al cumplimiento de mis obligaciones,
																						así como confiero mi autorización expresa para obtener, procesar, reportar y suministrar cualquier información de carácter crediticio, financiero y comercial a
																						cualquier central de información debidamente constituida. Adicionalmente autorizo que se proporcione y obtenga cualquier información de carácter crediticio,
																						financiero y comercial que requiera un tercero interesado en adquirir cartera respecto a la cual sea (nos) obligados principales o garantes. Los valores que estoy
																						(amos) solicitando sean financiados, van a tener un destino lícito y no serán utilizados en ninguna actividad que esté relacionada con el cultivo, producción,
																						transporte, tráfico, etc., de estupefacientes o sustancias psicotrópicas.
																						Autorizo a ustedes y a las autoridades competentes para que se realice la verificación de esta información (Circular SB-91-336). Declaro(amos) bajo juramento que
																						los fondos utilizados para pagar la obligación crediticia tienen origen licito, no provienen ni provendrán de ninguna actividad prohibida por la ley, ni son fruto
																						del tráfico de sustancias estupefacientes y psicotrópicas, ni de ninguna actividad relacionada con el lavado de activos. En cconsecuencia asumimos cualquier tipo
																						de responsabilidad civil y penal por la veracidad de esta declaración."</th>';
				$html.='</tr>';
				
				
				if($_tipo_participe_datos_prestamo=='Deudor'){
					$html.='<tr>';
					$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Nombres del Solicitante</th>';
					$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Firma</th>';
					$html.='</tr>';
				}else{
					$html.='<tr>';
					$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Nombres del Garante</th>';
					$html.='<th colspan="6" style="text-align:left; font-size: 13px;">Firma</th>';
					$html.='</tr>';
				}
				
				$html.='<tr>';
				$html.='<td colspan="6" rowspan="6" style="text-align:left; font-size: 13px;">'.$_apellidos_solicitante_datos_personales.' '.$_nombres_solicitante_datos_personales.'</td>';
				$html.='<td colspan="6" rowspan="6" style="text-align:left; font-size: 13px;"></td>';
				$html.='</tr>';
				
				$html.='</table>';
				
				
				
				
				
				$html.='<div style="page-break-after:always;"></div>';
				
				
				$html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$logo.'</div>';
				
				$html.='<table style="width: 100%; margin-top:30px;" >';
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 18px;"><b>REGISTRO DE FIRMAS<b></th>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 18px;"></th>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:left; font-size: 15px; font-weight: normal;"><b>No. de Cedula:</b> '.$_numero_cedula_datos_personales.'</th>';
				$html.='</tr>';
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:left; font-size: 15px; font-weight: normal;"><b>Apellidos y Nombres:</b> '.$_apellidos_solicitante_datos_personales.' '.$_nombres_solicitante_datos_personales.'</th>';
				$html.='</tr>';
				
				$html.='</table>';
				
				
				$html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$qr_participes.'</div>';
				
				$html.='<table style="width: 100%;">';
				$html.='<tr>';
				$html.='<td colspan="2" style="text-align:center; font-size: 18px;"></th>';
				$html.='<td colspan="8" style="text-align:center; font-size: 12px;"><b>Revisado por:</b> '.$_nombre_oficial_credito.'</th>';
				$html.='<td colspan="2" style="text-align:center; font-size: 18px;"></th>';
				$html.='</tr>';
				$html.='</table>';
				
				$html.='<table style="width: 100%;">';
				$html.='<tr>';
				$html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
				$html.='<th colspan="8" style="text-align:center; font-size: 18px;"><div style="width: 100%; height: 150px; border: 1px solid;"></div></th>';
				$html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
				$html.='</tr>';
				$html.='</table>';
				
				$html.='<table style="width: 100%;">';
				$html.='<tr>';
				$html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
				$html.='<th colspan="8" style="text-align:left; font-size: 14px; font-weight: normal;"><b>Nota: </b>Debe firmar dentro del recuadro sin colocar marcas fuera del mismo. La firma debe ser igual a la de la cédula.</th>';
				$html.='<th colspan="2" style="text-align:center; font-size: 18px;"></th>';
				$html.='</tr>';
				$html.='</table>';
				
				
				
			
				
				
				
				
				$html.='<div style="page-break-after:always;"></div>';
				
				
				$html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$logo.'</div>';
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:center; font-size: 16px;"><b>AUTORIZACIÓN DE DESCUENTO DE ROL DE PAGOS<b></p><br>';
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Yo, <b>'.$_apellidos_solicitante_datos_personales.' '.$_nombres_solicitante_datos_personales.'</b>, con cédula de ciudadanía No. <b>'.$_numero_cedula_datos_personales.'</b>, en mi calidad de Servidor
				Público, Funcionario, Empleado, Trabajador u Otro, de Fuerzas Armadas en: Fuerza o Entidad Patronal: <b>'.$_nombre_entidades.'</b>.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Declaro expresamente que estoy afiliado al Fondo Complementario Previsional Cerrado
					de Cesantía de Servidores y Trabajadores Públicos de Fuerzas Armadas "CAPREMCI",
					y como tal he venido recibiendo los beneficios que el Fondo otorga.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Por lo tanto, AUTORIZO e INSTRUYO expresa, irrevocable e indefinidamente, a mi
				empleador <b>'.$_nombre_entidades.'</b> que proceda con
				el descuento de mi Remuneración u Otros Ingresos, los valores correspondientes a las
				Aportaciones, Cuotas de Préstamos, Intereses de mora, Acreditaciones Indebidas,
				Prestaciones, Servicios Recibidos, o por cualquier otra obligación que mantengo (a) con
				el Fondo Complementario Previsional Cerrado de Cesantía de Servidores y Trabajadores
				Públicos de Fuerzas Armadas "CAPREMCI", hasta su total cancelación, sea en calidad de
				afiliado, deudor y o garante solidario.</p>';
				
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Acepto expresa e irrevocablemente que cualquier variación al porcentaje de aportación
					me será comunicada a través de los Delegados a la Asamblea General, o por cualquier
					otro medio que el Fondo defina para el efecto.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">En <b>'.$_nombre_sucursales.'</b>, '.$creado.'.</p>';
				
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Declaro que la firma que estampo en este documento es la mía propia y que la utilizo
					en todo acto público o privado.</p>';
				
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:left; font-size: 15px;">Atentamente,</p><br><br>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:left; font-size: 15px;">...................................<br>Firma afiliado</p>';
				
				
				$html.='<div style="page-break-after:always;"></div>';
				$html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$logo.'</div>';
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:center; font-size: 16px;"><b>AUTORIZACIÓN DE DÉBITOS AUTOMÁTICOS<b></p>';
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Señores: Fondo Complementario Previsional Cerrado de Cesantía de Servidores y Trabajadores Públicos de Fuerzas Armadas "CAPREMCI".</p>';
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Yo, <b>'.$_apellidos_solicitante_datos_personales.' '.$_nombres_solicitante_datos_personales.'</b>, con cédula de ciudadanía No. <b>'.$_numero_cedula_datos_personales.'</b>. AUTORIZO E INSTRUYO expresa, irrevocable e indefinidamente a ustedes a ordenar, en mi
						nombre y representación, el (los) débito (s) de mi (s) cuenta (s):</p>';
				
				if($_tipo_pago_cuenta_bancaria=='Depósito' || $_tipo_pago_cuenta_bancaria=='Retira Cheque'){
					
					if($_tipo_cuenta_cuenta_bancaria=='Ahorros'){
							
						$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:left; font-size: 15px;">Cuenta Ahorros No: <b>'.$_numero_cuenta_cuenta_bancaria.'</b></p>';
							
					}else{
						$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:left; font-size: 15px;">Cuenta Corriente No: <b>'.$_numero_cuenta_cuenta_bancaria.'</b></p>';
					}
				
				}else{
					$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:left; font-size: 15px;">Cuenta Ahorros No: ___________________<br>Cuenta Corriente No: __________________</p>';
				}
				
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">que mantengo en '.$_abreviaciones_bancos.' <b>'.$_nombre_bancos_datos_prestamo.'</b>, en adelante simplemente denominado "el
						Banco", por aportaciones, cuotas de préstamos, intereses de mora, acreditaciones indebidas,
						prestaciones, servicios recibidos, o por cualquier otra obligación que mantengo (a) con el Fondo
						Complementario Previsional Cerrado de Cesantía de Servidores y Trabajadores Públicos de
						Fuerzas Armadas "CAPREMCI", hasta su total cancelación, sea en calidad de afiliado, deudor y
						o garante solidario.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Los valores correspondientes a las obligaciones que mantengo (a) con el Fondo serán debitados
						hasta la total cancelación de las mismas, y acreditados a la cuenta que el Fondo Complementario
						Previsional Cerrado de Cesantía de Servidores y Trabajadores Públicos de Fuerzas Armadas
						"CAPREMCI" designe.</p>';

				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Me comprometo a mantener los fondos suficientes en mi (s) cuenta (s) referida (s), a fin de cubrir
						los valores cuyos débitos autorizo a través de este instrumento, y autorizo a debitar de mi cuenta
						la comisión o costo que '.$_abreviaciones_bancos.' <b>'.$_nombre_bancos_datos_prestamo.'</b> estipule en sus tarifarios
						vigentes por efecto de la prestación de servicio de intermediación de cobranza, así como también
						el valor resultante por cualquier modificación que a futuro se estableciere a dicho costo y que se
						incluya en el respectivo tarifario, valores que me obligo a pagar al Banco y autorizo debitar de mi
						cuenta corriente o de ahorros antes referida, durante todo el tiempo que subsista la prestación
						del mencionado servicio, y asumir cualquier tipo de impuesto que secausare.
						Cualquier instrucción tendiente a revocar esta autorización de débito, me obligo a presentarla al
						Fondo Complementario Previsional Cerrado de Cesantía de Servidores y Trabajadores Públicos
						de Fuerzas Armadas "CAPREMCI" con al menos 30 días calendario de anticipación, y autorizo a
						este para que lo trámite ante el Banco, siempre y cuando me encuentre al día en mis obligaciones
						para con el Fondo.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">De igual manera dejo constancia que este procedimiento no constituye embargo ni retención
						arbitraria alguna, por obedecer a mi expreso consentimiento para el fiel cumplimiento de mis
						obligaciones con el Fondo.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Eximo al Banco de toda responsabilidad por los pagos que efectúe al Fondo Complementario
						Previsional Cerrado de Cesantía de Servidores y Trabajadores Públicos de Fuerzas Armadas
						"CAPREMCI" en virtud de la presente Autorización de Débito, por lo que renuncio a presentar,
						por este concepto, cualquier acción legal, jurídica o extrajudicial en contra del Banco.</p>';
				
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">En <b>'.$_nombre_sucursales.'</b>, '.$creado.'.</p><br>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:left; font-size: 15px;">...................................<br>Firma afiliado</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Por el Fondo Complementario Previsional Cerrado de Cesantía de Servidores y Trabajadores
						Públicos de Fuerzas Armadas "CAPREMCI".</p>';
				
				$html.='<div style="page-break-after:always;"></div>';
				$html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$logo.'</div>';
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:center; font-size: 16px;"><b>CONTRATO DE ADHESIÓN AL FONDO COMPLEMENTARIO PREVISIONAL CERRADO DE CESANTÍA DE SERVIDORES Y TRABAJADORES PUBLICOS DE FUERZAS ARMADAS - CAPREMCI.<b></p><br>';
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>PRIMERA.- COMPARECIENTES.-</b> Comparecen a la suscripción del presente CONTRATO DE ADHESIÓN por una parte, el señor(a) <b>'.$_apellidos_solicitante_datos_personales.' '.$_nombres_solicitante_datos_personales.'</b>, por sus propios y personales derechos, en adelante se le denominará como el PARTÍCIPE, y por otra parte, el Fondo Complementario Previsional Cerrado de Cesantía de Servidores y Trabajadores Públicos de Fuerzas Armadas - "CAPREMCI" representado legalmente por su Representante Legal, en adelante se le denominará como el FONDO.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>SEGUNDA.- ANTECEDENTES.-</b><br><b>2.1.</b> El Fondo es una entidad de derecho privado, sin fines de lucro y de beneficio social, regulado por la Ley de Seguridad Social y controlado por la Superintendencia de Bancos, administrado bajo el régimen de contribución definida con un sistema de financiamiento de capitalización, en el cual cada uno de los partícipes tiene su cuenta individual.<br><b>2.2.</b> El PARTÍCIPE es una persona natural, dependiente civil de una de las Entidades Patronales relacionadas con las Fuerzas Armadas del Ecuador, capaz de afiliarse y ser parte del FONDO.</p>';
				
				$_var_procentajes="";
				if($_porcentaje_aportacion=='7%'){
					
					$_var_procentajes="<u><b>$_porcentaje_aportacion</b></u> o 9.1%";
				}else{
					$_var_procentajes="7% o <u><b>$_porcentaje_aportacion</b></u>";
				}
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>TERCERA.- ADHESIÓN.-</b> Con los antecedentes expuestos, el PARTÍCIPE se adhiere voluntaria y expresamente al FONDO y por lo tanto, dispone expresa, voluntaria e irrevocablemente que el aporte personal para la constitución de su Cuenta Individual sea el '.$_var_procentajes.' de su Remuneración Mensual Unificada (RMU). El PARTÍCIPE autoriza e instruye al FONDO que este valor sea debitado mensual y prioritariamente de su rol de pagos, o de la cuenta de ahorros de '.$_abreviaciones_bancos.' <b>'.$_nombre_bancos_datos_prestamo.'</b> N° <b>'.$_numero_cuenta_cuenta_bancaria.'</b> valor que debe ser recaudado y transferido, inmediatamente a la cuenta corriente del Banco General Rumiñahui Nº 8000589904 del FONDO.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Por su parte, el FONDO acepta la adhesión del PARTÍCIPE y se compromete en otorgar los beneficios y servicios que éste oferta, en las mismas condiciones que el resto de PARTÍCIPES del FONDO, siempre y cuando el PARTÍCIPE se encuentre al día en el cumplimiento de sus obligaciones económicas para con el FONDO.</p>';
				
				 
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>CUARTA.- DERECHOS Y OBLIGACIONES DEL PARTÍCIPE.-</b> Se establecen en los artículos 8 y 9 del Estatuto Vigente.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>QUINTA.- CONFORMACIÓN DE LA CUENTA INDIVIDUAL.-</b> Las cuentas de capitalización individual están conformadas por el aporte personal del PARTÍCIPE más sus rendimientos; el voluntario adicional, de ser el caso y sus rendimientos; y el aporte patronal y sus rendimientos alcanzados por las inversiones privativas y no privativas del FONDO en su conjunto.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>SEXTA.- RECONOCIMIENTO DE RENDIMIENTOS.-</b> Los rendimientos que correspondan a la cuenta de la capitalización de los PARTÍCIPES serán registrados después del cierre del periodo fiscal.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>SÉPTIMA.- RECONOCIMIENTO DE LA CESANTÍA.-</b> La CESANTÍA que el FONDO ofrece, será entregada a favor del PARTÍCIPE, cuando se cumplan una de las siguientes condiciones:<br><b>7.1</b> Haber cesado en sus funciones laborales definitivamente en las Entidades dependientes y adscritas de las Fuerzas Armadas a las que pertenezcan;<br><b>7.2</b> Fallecimiento;</p>';
				
				$html.='<div style="page-break-after:always;"></div>';
				$html.='<div style="margin-left: 25px; margin-right: 25px; text-align:center;">'.$logo.'</div>';
				
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>OCTAVA.- PROCEDIMIENTO PARA LA LIQUIDACIÓN DE LA CESANTÍA.-</b> Será aquel determinado en el Estatuto vigente y en los respectivos reglamentos del FONDO.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>NOVENA.- INFORMACIÓN DE CUENTA INDIVIDUAL.-</b> Toda la información financiera relativa al Fondo y a la situación de cada cuenta individual se encuentra a disposición del afiliado en la página web institucional y excepcionalmente por escrito.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>DÉCIMA.- DE LA DESAFILIACIÓN VOLUNTARIA.-</b> Es un derecho del PARTÍCIPE y se sujetará a los requisitos y condiciones previstos en el Estatuto vigente y en los respectivos reglamentos del FONDO y a las normas expedidas por la Junta de Política y Regulación Monetaria y Financiera.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>DÉCIMA PRIMERA.- DECLARACIÓN DE CONOCIMIENTO Y ACEPTACIÓN DEL ESTATUTO DEL FONDO.-</b> El PARTÍCIPE declara que conoce, y entiende las disposiciones establecidas en el Estatuto y Reglamentos del FONDO, sus derechos y obligaciones, y por lo tanto las ACEPTA expresa e incondicionalmente.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;"><b>DÉCIMA SEGUNDA.- DE LA SOLUCIÓN DE CONTROVERSIAS.-</b></p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">Las controversias que se generen entre los partícipes y la administración del Fondo, relacionadas a derechos y obligaciones, se someterán a la resolución de la Asamblea General de Representantes.</p>';
				
				$html.='<p style="margin-left: 25px; margin-right: 25px; text-align:justify; font-size: 15px;">En la ciudad de <b>'.$_nombre_sucursales.'</b>, '.$creado.', las partes suscriben el presente Contrato por duplicado.</p>';
				
				
				$html.= "<table style='margin-left: 15px; margin-right: 15px; width: 100%; margin-top:50px;'>";
				$html.= '<tr>';
				$html.='<th colspan="6" style="text-align:center; font-size: 15px; font-weight: normal;">________________________<br>Firma Participe<br>C.C. '.$_numero_cedula_datos_personales.'</th>';
				$html.='<th colspan="6" style="text-align:center; font-size: 15px; font-weight: normal;"><br>________________________<br>Ing. Stephany Zurita Cedeño<br>Representante Legal<br>"Capremci"</th>';
				$html.= '<tr>';
				$html.='</table>';
				
				
				
				}
				
				$this->report("SolicitudPrestamo",array("resultSet"=>$html));
				die();
				
			}
		
		}else{
			
			$this->redirect("Usuarios","sesion_caducada");
		}
		
	}
	
	
	

	public function paginate_load_solicitud_prestamos_registrados($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_prestamos_registrados(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_prestamos_registrados(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestamos_registrados(1)'>1</a></li>";
		}
		// interval
		if($page>($adjacents+2)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// pages
	
		$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
		$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
		for($i=$pmin; $i<=$pmax; $i++) {
			if($i==$page) {
				$out.= "<li class='active'><a>$i</a></li>";
			}else if($i==1) {
				$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestamos_registrados(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestamos_registrados(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestamos_registrados($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_prestamos_registrados(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	public function load_solicitud_garantias_registrados($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_garantias_registrados(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_garantias_registrados(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_garantias_registrados(1)'>1</a></li>";
		}
		// interval
		if($page>($adjacents+2)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// pages
	
		$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
		$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
		for($i=$pmin; $i<=$pmax; $i++) {
			if($i==$page) {
				$out.= "<li class='active'><a>$i</a></li>";
			}else if($i==1) {
				$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_garantias_registrados(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_garantias_registrados(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_garantias_registrados($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_garantias_registrados(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	///////////////////////////////////////////////////////// ADMINISTRADOR///////////////////////////////////////////////////////
	
	
	
	public function index3(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			$solicitud_prestamo = new SolicitudPrestamoModel();
			$nombre_controladores = "SolicitudPrestamo";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitud_prestamo->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
	
					if(isset($_GET["id_solicitud_prestamo_a"])){
						
						$_id_solicitud_prestamo= $_GET["id_solicitud_prestamo_a"];
						$_fecha_actual =    getdate();
						$_fecha_año    =	$_fecha_actual['year'];
						$_fecha_mes    =	$_fecha_actual['mon'];
						$_fecha_dia    =	$_fecha_actual['mday'];
							
						$_fecha_aprobacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
						$_id_usuarios_aprueba = $_SESSION['id_usuarios'];
						
						$colval_afi = "fecha_aprobacion='$_fecha_aprobacion', id_estado_tramites=2";
						$tabla_afi = "solicitud_prestamo";
						$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
						$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
						
						
						$this->redirect("SolicitudPrestamo", "index3");
						
					}
					
					
					if(isset($_GET["id_solicitud_prestamo_r"])){
					
						$_id_solicitud_prestamo= $_GET["id_solicitud_prestamo_r"];
						$_fecha_actual =    getdate();
						$_fecha_año    =	$_fecha_actual['year'];
						$_fecha_mes    =	$_fecha_actual['mon'];
						$_fecha_dia    =	$_fecha_actual['mday'];
							
						$_fecha_aprobacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
						$_id_usuarios_aprueba = $_SESSION['id_usuarios'];
					
						$colval_afi = "fecha_aprobacion='$_fecha_aprobacion', id_estado_tramites=3";
						$tabla_afi = "solicitud_prestamo";
						$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
						$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
					
						$this->redirect("SolicitudPrestamo", "index3");
						
					}
				
				$this->view("ConsultaSolicitudPrestamoAdmin",array(
						""=>""
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de prestamo."
	
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
	
	

	public function searchadmin_deudor(){
	
		session_start();
		$solicitud_prestamo = new SolicitudPrestamoModel();
		$usuarios = new UsuariosModel();
		$id_usuarios=$_SESSION["id_usuarios"];
	
		$where_to="";
		$columnas = "solicitud_prestamo.id_solicitud_prestamo,
					  solicitud_prestamo.tipo_participe_datos_prestamo,
					  solicitud_prestamo.monto_datos_prestamo,
					  solicitud_prestamo.plazo_datos_prestamo,
					  solicitud_prestamo.destino_dinero_datos_prestamo,
					  solicitud_prestamo.nombre_banco_cuenta_bancaria,
					  solicitud_prestamo.tipo_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cedula_datos_personales,
					  solicitud_prestamo.apellidos_solicitante_datos_personales,
					  solicitud_prestamo.nombres_solicitante_datos_personales,
					  solicitud_prestamo.correo_solicitante_datos_personales,
					  sexo.nombre_sexo,
					  solicitud_prestamo.fecha_nacimiento_datos_personales,
					  estado_civil.nombre_estado_civil,
					  solicitud_prestamo.fecha_presentacion,
					  solicitud_prestamo.fecha_aprobacion,
					  solicitud_prestamo.id_estado_tramites,
					  solicitud_prestamo.identificador_consecutivos,
				      solicitud_prestamo.tipo_pago_cuenta_bancaria,
				      tipo_creditos.nombre_tipo_creditos,
				      usuarios.nombre_usuarios,
				      usuarios.correo_usuarios,
				      solicitud_prestamo.id_usuarios_oficial_credito_aprueba,
				      estado_tramites.nombre_estado_tramites_solicitud_prestamos";
	
		$tablas   = "public.solicitud_prestamo,
					  public.entidades,
					  public.sexo,
					  public.estado_civil,
				      public.tipo_creditos,
				      public.usuarios,
				      public.estado_tramites";
			
		$where    = "solicitud_prestamo.id_estado_tramites= estado_tramites.id_estado_tramites  AND  solicitud_prestamo.id_usuarios_oficial_credito_aprueba=usuarios.id_usuarios AND tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
		solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
		entidades.id_entidades = solicitud_prestamo.id_entidades AND
		sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales AND solicitud_prestamo.id_usuarios_oficial_credito_aprueba='$id_usuarios' AND solicitud_prestamo.tipo_participe_datos_prestamo='Deudor'";
	
		$id       = "solicitud_prestamo.id_solicitud_prestamo";
	
			
		//$where_to=$where;
			
			
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
			
		if($action == 'ajax')
		{
			
			if(!empty($search)){
			
			
				$where1=" AND (solicitud_prestamo.numero_cedula_datos_personales LIKE '".$search."%' OR solicitud_prestamo.apellidos_solicitante_datos_personales LIKE '".$search."%' OR solicitud_prestamo.nombres_solicitante_datos_personales LIKE '".$search."%' OR tipo_creditos.nombre_tipo_creditos LIKE '".$search."%'  OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos LIKE '".$search."%' )";
			
				$where_to=$where.$where1;
			}else{
			
				$where_to=$where;
			
			}
			
			
			$html="";
			$resultSet=$solicitud_prestamo->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 10; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$solicitud_prestamo->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
			$count_query   = $cantidadResult;
			$total_pages = ceil($cantidadResult/$per_page);
	
	
			if($cantidadResult>0)
			{
	
				$html.='<div class="pull-left" style="margin-left:11px;">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div>';
				$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
				$html.='<section style="height:350px; overflow-y:scroll;">';
				$html.= "<table id='tabla_solicitud_prestamos_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
	
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Crédito</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Tipo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Monto</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Plazo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Transacción</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Presentación</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Fecha T</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Oficial C</th>';
				$html.='<th colspan="4" style="text-align: right;  font-size: 11px;"></th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					
				$i=0;
	
				foreach ($resultSet as $res)
				{
						
					$aprobado_oficial_credito=$res->id_estado_tramites;
					if($aprobado_oficial_credito==2){
	
						$estado_tramite='Guardado';
						
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}
					elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
						
					}elseif($aprobado_oficial_credito==4){
						$estado_tramite='Revisado';
						
					}
						
					$html.='<tr>';
						
					$html.='<td style="font-size: 11px;">'.$res->numero_cedula_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->apellidos_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombres_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_creditos.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_participe_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->monto_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->plazo_datos_prestamo.' meses</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_pago_cuenta_bancaria.'</td>';
					$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_presentacion)).'</td>';
					$html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
					
					if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
					$html.='<td style="font-size: 11px;"></td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index4&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index3&id_solicitud_prestamo_a='.$res->id_solicitud_prestamo.'" class="btn btn-info" style="font-size:65%;" title="Guardar"><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index3&id_solicitud_prestamo_r='.$res->id_solicitud_prestamo.'" class="btn btn-danger" style="font-size:65%;" title="Rechazar"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
						
					}else{
						$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-primary" style="font-size:65%;" disabled><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-danger" style="font-size:65%;" disabled><i class="glyphicon glyphicon-trash"></i></a></span></td>';
						
					}
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
					$html.='</tr>';
	
				}
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_load_solicitud_prestamos_registrados("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de prestamos registrados...</b>';
				$html.='</div>';
				$html.='</div>';
			}
	
			echo $html;
			die();
	
		}
	
	}
	
	
	
	


	public function searchadmin_garantes(){
	
		session_start();
		$solicitud_prestamo = new SolicitudPrestamoModel();
		$usuarios = new UsuariosModel();
		$id_usuarios=$_SESSION["id_usuarios"];
	
		$where_to="";
		$columnas = "solicitud_prestamo.id_solicitud_prestamo,
					  solicitud_prestamo.tipo_participe_datos_prestamo,
					  solicitud_prestamo.monto_datos_prestamo,
					  solicitud_prestamo.plazo_datos_prestamo,
					  solicitud_prestamo.destino_dinero_datos_prestamo,
					  solicitud_prestamo.nombre_banco_cuenta_bancaria,
					  solicitud_prestamo.tipo_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cedula_datos_personales,
					  solicitud_prestamo.apellidos_solicitante_datos_personales,
					  solicitud_prestamo.nombres_solicitante_datos_personales,
					  solicitud_prestamo.correo_solicitante_datos_personales,
					  sexo.nombre_sexo,
					  solicitud_prestamo.fecha_nacimiento_datos_personales,
					  estado_civil.nombre_estado_civil,
					  solicitud_prestamo.fecha_presentacion,
					  solicitud_prestamo.fecha_aprobacion,
					  solicitud_prestamo.id_estado_tramites,
					  solicitud_prestamo.identificador_consecutivos,
				      solicitud_prestamo.tipo_pago_cuenta_bancaria,
				      tipo_creditos.nombre_tipo_creditos,
				      usuarios.nombre_usuarios,
				      usuarios.correo_usuarios,
				      solicitud_prestamo.id_usuarios_oficial_credito_aprueba,
				      solicitud_prestamo.cedula_deudor_a_garantizar,
				      solicitud_prestamo.nombre_deudor_a_garantizar,
				      estado_tramites.nombre_estado_tramites_solicitud_prestamos";
	
		$tablas   = "public.solicitud_prestamo,
					  public.entidades,
					  public.sexo,
					  public.estado_civil,
				      public.tipo_creditos,
				      public.usuarios,
				      public.estado_tramites";
			
		$where    = "solicitud_prestamo.id_estado_tramites= estado_tramites.id_estado_tramites AND solicitud_prestamo.id_usuarios_oficial_credito_aprueba=usuarios.id_usuarios AND tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
		solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
		entidades.id_entidades = solicitud_prestamo.id_entidades AND
		sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales AND solicitud_prestamo.id_usuarios_oficial_credito_aprueba='$id_usuarios' AND solicitud_prestamo.tipo_participe_datos_prestamo='Garante'";
	
		$id       = "solicitud_prestamo.id_solicitud_prestamo";
	
			
		//$where_to=$where;
			
			
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
			
		if($action == 'ajax')
		{
			if(!empty($search)){
					
				$where1=" AND (solicitud_prestamo.numero_cedula_datos_personales LIKE '".$search."%' OR solicitud_prestamo.apellidos_solicitante_datos_personales LIKE '".$search."%' OR solicitud_prestamo.nombres_solicitante_datos_personales LIKE '".$search."%' OR tipo_creditos.nombre_tipo_creditos LIKE '".$search."%' OR solicitud_prestamo.cedula_deudor_a_garantizar LIKE '".$search."%'  OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos LIKE '".$search."%')";
					
				$where_to=$where.$where1;
			}else{
					
				$where_to=$where;
			}
			
			$html="";
			$resultSet=$solicitud_prestamo->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 10; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
			$resultSet=$solicitud_prestamo->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
			$count_query   = $cantidadResult;
			$total_pages = ceil($cantidadResult/$per_page);
	
			if($cantidadResult>0)
			{
				$html.='<div class="pull-left" style="margin-left:11px;">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div>';
				$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
				$html.='<section style="height:350px; overflow-y:scroll;">';
				$html.= "<table id='tabla_solicitud_prestamos_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Crédito</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Tipo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Monto</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Plazo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula Deudor</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombre Deudor</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Fecha T</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Oficial C</th>';
				$html.='<th colspan="4" style="text-align: right;  font-size: 11px;"></th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					
				$i=0;
	
				foreach ($resultSet as $res)
				{
	
					$aprobado_oficial_credito=$res->id_estado_tramites;
					if($aprobado_oficial_credito==2){
						$estado_tramite='Guardado';
	
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}
					elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
					}elseif($aprobado_oficial_credito==4){
						$estado_tramite='Revisado';
						
					}
	
					$html.='<tr>';
	
					$html.='<td style="font-size: 11px;">'.$res->numero_cedula_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->apellidos_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombres_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_creditos.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_participe_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->monto_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->plazo_datos_prestamo.' meses</td>';
					$html.='<td style="font-size: 11px;">'.$res->cedula_deudor_a_garantizar.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_deudor_a_garantizar.'</td>';
					$html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
					if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
						$html.='<td style="font-size: 11px;"></td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
	
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index4&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index3&id_solicitud_prestamo_a='.$res->id_solicitud_prestamo.'" class="btn btn-info" style="font-size:65%;" title="Guardar"><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index3&id_solicitud_prestamo_r='.$res->id_solicitud_prestamo.'" class="btn btn-danger" style="font-size:65%;" title="Rechazar"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
	
					}else{
						$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-primary" style="font-size:65%;" disabled><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-danger" style="font-size:65%;" disabled><i class="glyphicon glyphicon-trash"></i></a></span></td>';
	
					}
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
					$html.='</tr>';
	
				}
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->load_solicitud_garantias_registrados("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de garantías de prestamos registrados...</b>';
				$html.='</div>';
				$html.='</div>';
			}
	
			echo $html;
			die();
	
		}
	
	}
	
	
	
	
	

	public function index4(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
				
			$solicitud_prestamo = new SolicitudPrestamoModel();
				
			$sexo= new SexoModel();
			$resultSexo = $sexo->getAll("nombre_sexo");
	
			$estado_civil= new Estado_civilModel();
			$resultEstado_civil = $estado_civil->getBy("nombre_estado_civil<>'Ninguna' ");
	
			$tipo_sangre= new Tipo_sangreModel();
			$resultTipo_sangre = $tipo_sangre->getAll("nombre_tipo_sangre");
	
			$estado = new EstadoModel();
			$resultEstado= $estado->getAll("nombre_estado");
				
			$bancos = new BancosModel();
			$resultBancos= $bancos->getAll("id_bancos");
	
			$entidades = new EntidadesModel();
			$resultEntidades= $entidades->getAll("nombre_entidades");
	
			$provincias = new ProvinciasModel();
			$resultProvincias= $provincias->getAll("nombre_provincias");
	
			$parroquias = new ParroquiasModel();
			$resultParroquias= $parroquias->getAll("nombre_parroquias");
	
			$cantones = new CantonesModel();
			$resultCantones= $cantones->getAll("nombre_cantones");
				
			$tipo_credito = new TipoCreditoModel();
			$resultTipoCredito= $tipo_credito->getAll("nombre_tipo_creditos");
	
			$sucursales = new SucursalesModel();
			$resultSucursales= $sucursales->getAll("nombre_sucursales");
				
				
				
			$nombre_controladores = "SolicitudPrestamo";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitud_prestamo->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				$resultEdit="";
	
				if(isset($_GET["id_solicitud_prestamo"])){
						
					$_id_solicitud_prestamo= $_GET["id_solicitud_prestamo"];
						
						
						$colval_afi = "id_estado_tramites=4";
						$tabla_afi = "solicitud_prestamo";
						$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
						$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
					
					
					$columnas="solicitud_prestamo.id_solicitud_prestamo,
							  solicitud_prestamo.tipo_participe_datos_prestamo,
							  solicitud_prestamo.monto_datos_prestamo,
							  solicitud_prestamo.plazo_datos_prestamo,
							  solicitud_prestamo.destino_dinero_datos_prestamo,
							  solicitud_prestamo.nombre_banco_cuenta_bancaria,
							  solicitud_prestamo.tipo_cuenta_cuenta_bancaria,
							  solicitud_prestamo.numero_cuenta_cuenta_bancaria,
							  solicitud_prestamo.numero_cedula_datos_personales,
							  solicitud_prestamo.apellidos_solicitante_datos_personales,
							  solicitud_prestamo.nombres_solicitante_datos_personales,
							  solicitud_prestamo.correo_solicitante_datos_personales,
							  solicitud_prestamo.id_sexo_datos_personales,
							  solicitud_prestamo.fecha_nacimiento_datos_personales,
							  solicitud_prestamo.id_estado_civil_datos_personales,
							  solicitud_prestamo.separacion_bienes_datos_personales,
							  solicitud_prestamo.cargas_familiares_datos_personales,
							  solicitud_prestamo.numero_hijos_datos_personales,
							  solicitud_prestamo.nivel_educativo_datos_personales,
							  solicitud_prestamo.id_provincias_vivienda,
							  solicitud_prestamo.id_cantones_vivienda,
							  solicitud_prestamo.id_parroquias_vivienda,
							  solicitud_prestamo.barrio_sector_vivienda,
							  solicitud_prestamo.ciudadela_conjunto_etapa_manzana_vivienda,
							  solicitud_prestamo.calle_vivienda,
							  solicitud_prestamo.numero_calle_vivienda,
							  solicitud_prestamo.intersecion_vivienda,
							  solicitud_prestamo.tipo_vivienda,
							  solicitud_prestamo.vivienda_hipotecada_vivienda,
							  solicitud_prestamo.tiempo_residencia_vivienda,
							  solicitud_prestamo.nombre_propietario_vivienda,
							  solicitud_prestamo.celular_propietario_vivienda,
							  solicitud_prestamo.referencia_direccion_domicilio_vivienda,
							  solicitud_prestamo.numero_casa_solicitante,
							  solicitud_prestamo.numero_celular_solicitante,
							  solicitud_prestamo.numero_trabajo_solicitante,
							  solicitud_prestamo.extension_solicitante,
							  solicitud_prestamo.apellidos_referencia_personal,
							  solicitud_prestamo.mode_solicitante,
							  solicitud_prestamo.nombres_referencia_personal,
							  solicitud_prestamo.relacion_referencia_personal,
							  solicitud_prestamo.numero_telefonico_referencia_personal,
							  solicitud_prestamo.apellidos_referencia_familiar,
							  solicitud_prestamo.nombres_referencia_familiar,
							  solicitud_prestamo.parentesco_referencia_familiar,
							  solicitud_prestamo.numero_telefonico_referencia_familiar,
							  solicitud_prestamo.id_entidades,
							  solicitud_prestamo.id_provincias_asignacion,
							  solicitud_prestamo.id_cantones_asignacion,
							  solicitud_prestamo.id_parroquias_asignacion,
							  solicitud_prestamo.numero_telefonico_datos_laborales,
							  solicitud_prestamo.interseccion_datos_laborales,
							  solicitud_prestamo.calle_datos_laborales,
							  solicitud_prestamo.cargo_actual_datos_laborales,
							  solicitud_prestamo.sueldo_total_info_economica,
							  solicitud_prestamo.cuota_prestamo_ordinario_info_economica,
							  solicitud_prestamo.arriendos_info_economica,
							  solicitud_prestamo.cuota_prestamo_emergente_info_economica,
							  solicitud_prestamo.honorarios_profesionales_info_economica,
							  solicitud_prestamo.cuota_otros_prestamos_info_economica,
							  solicitud_prestamo.comisiones_info_economica,
							  solicitud_prestamo.cuota_prestamo_iess_info_economica,
							  solicitud_prestamo.horas_suplementarias_info_economica,
							  solicitud_prestamo.arriendos_egre_info_economica,
							  solicitud_prestamo.alimentacion_info_economica,
							  solicitud_prestamo.otros_ingresos_1_info_economica,
							  solicitud_prestamo.valor_ingresos_1_info_economica,
							  solicitud_prestamo.estudios_info_economica,
							  solicitud_prestamo.otros_ingresos_2_info_economica,
							  solicitud_prestamo.valor_ingresos_2_info_economica,
							  solicitud_prestamo.pago_servicios_basicos_info_economica,
							  solicitud_prestamo.otros_ingresos_3_info_economica,
							  solicitud_prestamo.valor_ingresos_3_info_economica,
							  solicitud_prestamo.pago_tarjetas_credito_info_economica,
							  solicitud_prestamo.otros_ingresos_4_info_economica,
							  solicitud_prestamo.valor_ingresos_4_info_economica,
							  solicitud_prestamo.afiliacion_cooperativas_info_economica,
							  solicitud_prestamo.otros_ingresos_5_info_economica,
							  solicitud_prestamo.valor_ingresos_5_info_economica,
							  solicitud_prestamo.ahorro_info_economica,
							  solicitud_prestamo.otros_ingresos_6_info_economica,
							  solicitud_prestamo.valor_ingresos_6_info_economica,
							  solicitud_prestamo.impuesto_renta_info_economica,
							  solicitud_prestamo.otros_ingresos_7_info_economica,
							  solicitud_prestamo.valor_ingresos_7_info_economica,
							  solicitud_prestamo.otros_ingresos_8_info_economica,
							  solicitud_prestamo.valor_ingresos_8_info_economica,
							  solicitud_prestamo.otros_egresos_1_info_economica,
							  solicitud_prestamo.valor_egresos_1_info_economica,
							  solicitud_prestamo.total_ingresos_mensuales,
							  solicitud_prestamo.total_egresos_mensuales,
							  solicitud_prestamo.numero_cedula_conyuge,
							  solicitud_prestamo.apellidos_conyuge,
							  solicitud_prestamo.nombres_conyuge,
							  solicitud_prestamo.id_sexo_conyuge,
							  solicitud_prestamo.fecha_nacimiento_conyuge,
							  solicitud_prestamo.convive_afiliado_conyuge,
							  solicitud_prestamo.numero_telefonico_conyuge,
							  solicitud_prestamo.actividad_economica_conyuge,
							  solicitud_prestamo.fecha_presentacion,
							  solicitud_prestamo.fecha_aprobacion,
							  solicitud_prestamo.id_estado_tramites,
							  solicitud_prestamo.id_usuarios_oficial_credito_aprueba,
							  solicitud_prestamo.id_usuarios_registra,
							  solicitud_prestamo.identificador_consecutivos,
							  solicitud_prestamo.tipo_pago_cuenta_bancaria,
							solicitud_prestamo.id_tipo_creditos,
							solicitud_prestamo.id_sucursales,
					        solicitud_prestamo.cedula_deudor_a_garantizar,
				            solicitud_prestamo.nombre_deudor_a_garantizar,
							solicitud_prestamo.porcentaje_aportacion";
						
					$tablas="public.solicitud_prestamo";
					$where="1=1  AND solicitud_prestamo.id_solicitud_prestamo='$_id_solicitud_prestamo'";
					$id="solicitud_prestamo.id_solicitud_prestamo";
					$resultEdit=$solicitud_prestamo->getCondiciones($columnas, $tablas, $where, $id);
						
				}
	
					
				$this->view("ActualizarSolicitudPrestamoAdmin",array(
						"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
						"resultProvincias"=>$resultProvincias, "resultBancos"=>$resultBancos,
						"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones,
						"resultEdit"=>$resultEdit, "resultTipoCredito"=>$resultTipoCredito, "resultSucursales"=>$resultSucursales
	
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
	
	
	


	public function ActualizaSolicitudPrestamo(){
	
		session_start();
	
		if (isset($_SESSION['nombre_usuarios']))
		{
	
			$usuarios = new UsuariosModel();
			$solicitud_prestamo = new SolicitudPrestamoModel();
			$consecutivos = new ConsecutivosModel();
				
			$_identificador_consecutivos = 0;
			$_total_ingresos_mensuales   = 0;
			$_total_egresos_mensuales    = 0;
				
			if (isset($_POST["id_solicitud_prestamo"]))
			{
	
				$_id_tipo_creditos                                           = $_POST["id_tipo_creditos"];
				$_tipo_participe_datos_prestamo                              = $_POST["tipo_participe_datos_prestamo"];
				$_monto_datos_prestamo                                       = $_POST["monto_datos_prestamo"];
				$_plazo_datos_prestamo                                       = $_POST["plazo_datos_prestamo"];
				$_destino_dinero_datos_prestamo                              = $_POST["destino_dinero_datos_prestamo"];
				$_id_banco_cuenta_bancaria                                   = $_POST["id_banco_cuenta_bancaria"];
				$_tipo_cuenta_cuenta_bancaria                                = $_POST["tipo_cuenta_cuenta_bancaria"];
				$_numero_cuenta_cuenta_bancaria                              = $_POST["numero_cuenta_cuenta_bancaria"];
				$_numero_cedula_datos_personales                             = $_POST["numero_cedula_datos_personales"];
				$_apellidos_solicitante_datos_personales                     = mb_strtoupper ($_POST["apellidos_solicitante_datos_personales"]);
				$_nombres_solicitante_datos_personales                       = mb_strtoupper ($_POST["nombres_solicitante_datos_personales"]);
				$_correo_solicitante_datos_personales                        = $_POST["correo_solicitante_datos_personales"];
				$_id_sexo_datos_personales                                   = $_POST["id_sexo_datos_personales"];
				$_fecha_nacimiento_datos_personales                          = $_POST["fecha_nacimiento_datos_personales"];
				$_id_estado_civil_datos_personales                           = $_POST["id_estado_civil_datos_personales"];
				$_separacion_bienes_datos_personales                         = $_POST["separacion_bienes_datos_personales"];
				$_cargas_familiares_datos_personales                         = $_POST["cargas_familiares_datos_personales"];
				$_numero_hijos_datos_personales                              = $_POST["numero_hijos_datos_personales"];
				$_nivel_educativo_datos_personales                           = $_POST["nivel_educativo_datos_personales"];
				$_id_provincias_vivienda                                     = $_POST["id_provincias_vivienda"];
				$_id_cantones_vivienda                                       = $_POST["id_cantones_vivienda"];
				$_id_parroquias_vivienda                                     = $_POST["id_parroquias_vivienda"];
				$_barrio_sector_vivienda                                     = $_POST["barrio_sector_vivienda"];
				$_ciudadela_conjunto_etapa_manzana_vivienda                  = $_POST["ciudadela_conjunto_etapa_manzana_vivienda"];
				$_calle_vivienda                                             = $_POST["calle_vivienda"];
				$_numero_calle_vivienda                                      = $_POST["numero_calle_vivienda"];
				$_intersecion_vivienda                                       = $_POST["intersecion_vivienda"];
				$_tipo_vivienda                                              = $_POST["tipo_vivienda"];
				$_vivienda_hipotecada_vivienda                               = $_POST["vivienda_hipotecada_vivienda"];
				$_tiempo_residencia_vivienda                                 = $_POST["tiempo_residencia_vivienda"];
				$_nombre_propietario_vivienda                                = mb_strtoupper ($_POST["nombre_propietario_vivienda"]);
				$_celular_propietario_vivienda                               = $_POST["celular_propietario_vivienda"];
				$_referencia_direccion_domicilio_vivienda                    = $_POST["referencia_direccion_domicilio_vivienda"];
				$_numero_casa_solicitante                                    = $_POST["numero_casa_solicitante"];
				$_numero_celular_solicitante                                 = $_POST["numero_celular_solicitante"];
				$_numero_trabajo_solicitante                                 = $_POST["numero_trabajo_solicitante"];
				$_extension_solicitante                                      = $_POST["extension_solicitante"];
				$_mode_solicitante                                           = $_POST["mode_solicitante"];
				$_apellidos_referencia_personal                              = mb_strtoupper ($_POST["apellidos_referencia_personal"]);
				$_nombres_referencia_personal                                = mb_strtoupper ($_POST["nombres_referencia_personal"]);
				$_relacion_referencia_personal                               = $_POST["relacion_referencia_personal"];
				$_numero_telefonico_referencia_personal                      = $_POST["numero_telefonico_referencia_personal"];
				$_apellidos_referencia_familiar                              = mb_strtoupper ($_POST["apellidos_referencia_familiar"]);
				$_nombres_referencia_familiar                                = mb_strtoupper ($_POST["nombres_referencia_familiar"]);
				$_parentesco_referencia_familiar                             = $_POST["parentesco_referencia_familiar"];
				$_numero_telefonico_referencia_familiar                      = $_POST["numero_telefonico_referencia_familiar"];
				$_id_entidades                                               = $_POST["id_entidades"];
				$_id_provincias_asignacion                                   = $_POST["id_provincias_asignacion"];
				$_id_cantones_asignacion                                     = $_POST["id_cantones_asignacion"];
				$_id_parroquias_asignacion                                   = $_POST["id_parroquias_asignacion"];
				$_numero_telefonico_datos_laborales                          = $_POST["numero_telefonico_datos_laborales"];
				$_interseccion_datos_laborales                               = $_POST["interseccion_datos_laborales"];
				$_calle_datos_laborales                                      = $_POST["calle_datos_laborales"];
				$_cargo_actual_datos_laborales                               = mb_strtoupper ($_POST["cargo_actual_datos_laborales"]);
	
				
	
				
				$_sueldo_total_info_economica                                = (isset($_REQUEST['sueldo_total_info_economica'])&& $_REQUEST['sueldo_total_info_economica'] !=NULL)?$_REQUEST['sueldo_total_info_economica']:0;
				$_cuota_prestamo_ordinario_info_economica                    = (isset($_REQUEST['cuota_prestamo_ordinario_info_economica'])&& $_REQUEST['cuota_prestamo_ordinario_info_economica'] !=NULL)?$_REQUEST['cuota_prestamo_ordinario_info_economica']:0;
				$_arriendos_info_economica                                   = (isset($_REQUEST['arriendos_info_economica'])&& $_REQUEST['arriendos_info_economica'] !=NULL)?$_REQUEST['arriendos_info_economica']:0;
				$_cuota_prestamo_emergente_info_economica                    = (isset($_REQUEST['cuota_prestamo_emergente_info_economica'])&& $_REQUEST['cuota_prestamo_emergente_info_economica'] !=NULL)?$_REQUEST['cuota_prestamo_emergente_info_economica']:0;
				$_honorarios_profesionales_info_economica                    = (isset($_REQUEST['honorarios_profesionales_info_economica'])&& $_REQUEST['honorarios_profesionales_info_economica'] !=NULL)?$_REQUEST['honorarios_profesionales_info_economica']:0;
				$_cuota_otros_prestamos_info_economica                       = (isset($_REQUEST['cuota_otros_prestamos_info_economica'])&& $_REQUEST['cuota_otros_prestamos_info_economica'] !=NULL)?$_REQUEST['cuota_otros_prestamos_info_economica']:0;
				$_comisiones_info_economica                                  = (isset($_REQUEST['comisiones_info_economica'])&& $_REQUEST['comisiones_info_economica'] !=NULL)?$_REQUEST['comisiones_info_economica']:0;
				$_cuota_prestamo_iess_info_economica                         = (isset($_REQUEST['cuota_prestamo_iess_info_economica'])&& $_REQUEST['cuota_prestamo_iess_info_economica'] !=NULL)?$_REQUEST['cuota_prestamo_iess_info_economica']:0;
				$_horas_suplementarias_info_economica                        = (isset($_REQUEST['horas_suplementarias_info_economica'])&& $_REQUEST['horas_suplementarias_info_economica'] !=NULL)?$_REQUEST['horas_suplementarias_info_economica']:0;
				$_arriendos_egre_info_economica                              = (isset($_REQUEST['arriendos_egre_info_economica'])&& $_REQUEST['arriendos_egre_info_economica'] !=NULL)?$_REQUEST['arriendos_egre_info_economica']:0;
				$_alimentacion_info_economica                                = (isset($_REQUEST['alimentacion_info_economica'])&& $_REQUEST['alimentacion_info_economica'] !=NULL)?$_REQUEST['alimentacion_info_economica']:0;
				$_otros_ingresos_1_info_economica                            = $_POST["otros_ingresos_1_info_economica"];
				$_valor_ingresos_1_info_economica                            = (isset($_REQUEST['valor_ingresos_1_info_economica'])&& $_REQUEST['valor_ingresos_1_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_1_info_economica']:0;
				$_estudios_info_economica                                    = (isset($_REQUEST['estudios_info_economica'])&& $_REQUEST['estudios_info_economica'] !=NULL)?$_REQUEST['estudios_info_economica']:0;
				$_otros_ingresos_2_info_economica                            = $_POST["otros_ingresos_2_info_economica"];
				$_valor_ingresos_2_info_economica                            = (isset($_REQUEST['valor_ingresos_2_info_economica'])&& $_REQUEST['valor_ingresos_2_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_2_info_economica']:0;
				$_pago_servicios_basicos_info_economica                      = (isset($_REQUEST['pago_servicios_basicos_info_economica'])&& $_REQUEST['pago_servicios_basicos_info_economica'] !=NULL)?$_REQUEST['pago_servicios_basicos_info_economica']:0;
				$_otros_ingresos_3_info_economica                            = $_POST["otros_ingresos_3_info_economica"];
				$_valor_ingresos_3_info_economica                            = (isset($_REQUEST['valor_ingresos_3_info_economica'])&& $_REQUEST['valor_ingresos_3_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_3_info_economica']:0;
				$_pago_tarjetas_credito_info_economica                       = (isset($_REQUEST['pago_tarjetas_credito_info_economica'])&& $_REQUEST['pago_tarjetas_credito_info_economica'] !=NULL)?$_REQUEST['pago_tarjetas_credito_info_economica']:0;
				$_otros_ingresos_4_info_economica                            = $_POST["otros_ingresos_4_info_economica"];
				$_valor_ingresos_4_info_economica                            = (isset($_REQUEST['valor_ingresos_4_info_economica'])&& $_REQUEST['valor_ingresos_4_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_4_info_economica']:0;
				$_afiliacion_cooperativas_info_economica                     = (isset($_REQUEST['afiliacion_cooperativas_info_economica'])&& $_REQUEST['afiliacion_cooperativas_info_economica'] !=NULL)?$_REQUEST['afiliacion_cooperativas_info_economica']:0;
				$_otros_ingresos_5_info_economica                            = $_POST["otros_ingresos_5_info_economica"];
				$_valor_ingresos_5_info_economica                            = (isset($_REQUEST['valor_ingresos_5_info_economica'])&& $_REQUEST['valor_ingresos_5_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_5_info_economica']:0;
				$_ahorro_info_economica                                      = (isset($_REQUEST['ahorro_info_economica'])&& $_REQUEST['ahorro_info_economica'] !=NULL)?$_REQUEST['ahorro_info_economica']:0;
				$_otros_ingresos_6_info_economica                            = $_POST["otros_ingresos_6_info_economica"];
				$_valor_ingresos_6_info_economica                            = (isset($_REQUEST['valor_ingresos_6_info_economica'])&& $_REQUEST['valor_ingresos_6_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_6_info_economica']:0;
				$_impuesto_renta_info_economica                              = (isset($_REQUEST['impuesto_renta_info_economica'])&& $_REQUEST['impuesto_renta_info_economica'] !=NULL)?$_REQUEST['impuesto_renta_info_economica']:0;
				$_otros_ingresos_7_info_economica                            = $_POST["otros_ingresos_7_info_economica"];
				$_valor_ingresos_7_info_economica                            = (isset($_REQUEST['valor_ingresos_7_info_economica'])&& $_REQUEST['valor_ingresos_7_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_7_info_economica']:0;
				$_otros_ingresos_8_info_economica                            = $_POST["otros_ingresos_8_info_economica"];
				$_valor_ingresos_8_info_economica                            = (isset($_REQUEST['valor_ingresos_8_info_economica'])&& $_REQUEST['valor_ingresos_8_info_economica'] !=NULL)?$_REQUEST['valor_ingresos_8_info_economica']:0;
				$_otros_egresos_1_info_economica                             = $_POST["otros_egresos_1_info_economica"];
				$_valor_egresos_1_info_economica                             = (isset($_REQUEST['valor_egresos_1_info_economica'])&& $_REQUEST['valor_egresos_1_info_economica'] !=NULL)?$_REQUEST['valor_egresos_1_info_economica']:0;
				
				
				
				
				$_total_ingresos_mensuales  = $_sueldo_total_info_economica+$_arriendos_info_economica+$_honorarios_profesionales_info_economica+$_comisiones_info_economica+$_horas_suplementarias_info_economica+$_valor_ingresos_1_info_economica+$_valor_ingresos_2_info_economica+$_valor_ingresos_3_info_economica+$_valor_ingresos_4_info_economica+$_valor_ingresos_5_info_economica+$_valor_ingresos_6_info_economica+$_valor_ingresos_7_info_economica+$_valor_ingresos_8_info_economica;
				$_total_egresos_mensuales   = $_cuota_prestamo_ordinario_info_economica+$_cuota_prestamo_emergente_info_economica+$_cuota_otros_prestamos_info_economica+$_cuota_prestamo_iess_info_economica+$_arriendos_egre_info_economica+$_alimentacion_info_economica+$_estudios_info_economica+$_pago_servicios_basicos_info_economica+$_pago_tarjetas_credito_info_economica+$_afiliacion_cooperativas_info_economica+$_ahorro_info_economica+$_impuesto_renta_info_economica+$_valor_egresos_1_info_economica;
	
				$_numero_cedula_conyuge                                      = $_POST["numero_cedula_conyuge"];
				$_apellidos_conyuge                                          = mb_strtoupper ($_POST["apellidos_conyuge"]);
				$_nombres_conyuge                                            = mb_strtoupper ($_POST["nombres_conyuge"]);
				$_id_sexo_conyuge                                            = $_POST["id_sexo_conyuge"];
				$_fecha_nacimiento_conyuge                                   = $_POST["fecha_nacimiento_conyuge"];
				$_convive_afiliado_conyuge                                   = $_POST["convive_afiliado_conyuge"];
				$_numero_telefonico_conyuge                                  = $_POST["numero_telefonico_conyuge"];
				$_actividad_economica_conyuge                                = $_POST["actividad_economica_conyuge"];
	
				$_fecha_actual =    getdate();
				$_fecha_año    =	$_fecha_actual['year'];
				$_fecha_mes    =	$_fecha_actual['mon'];
				$_fecha_dia    =	$_fecha_actual['mday'];
					
				$_fecha_aprobacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
				$_id_usuarios_aprueba = $_SESSION['id_usuarios'];
	
				$_id_solicitud_prestamo  			                               = $_POST["id_solicitud_prestamo"];
				$_tipo_pago_cuenta_bancaria         			                   = $_POST["tipo_pago_cuenta_bancaria"];
				$_nombre_deudor_a_garantizar                                       = $_POST["nombre_deudor_a_garantizar"];
				$_cedula_deudor_a_garantizar                                       = $_POST["cedula_deudor_a_garantizar"];
				$_porcentaje_aportacion                                            = $_POST["porcentaje_aportacion"];
				
				if($_id_solicitud_prestamo > 0){
						
					$columnas="porcentaje_aportacion='$_porcentaje_aportacion',
					id_tipo_creditos='$_id_tipo_creditos',
					tipo_pago_cuenta_bancaria='$_tipo_pago_cuenta_bancaria',
					monto_datos_prestamo='$_monto_datos_prestamo',
					plazo_datos_prestamo='$_plazo_datos_prestamo',
					destino_dinero_datos_prestamo='$_destino_dinero_datos_prestamo',
					nombre_banco_cuenta_bancaria='$_id_banco_cuenta_bancaria',
					tipo_cuenta_cuenta_bancaria='$_tipo_cuenta_cuenta_bancaria',
					numero_cuenta_cuenta_bancaria='$_numero_cuenta_cuenta_bancaria',
					numero_cedula_datos_personales='$_numero_cedula_datos_personales',
					apellidos_solicitante_datos_personales='$_apellidos_solicitante_datos_personales',
					nombres_solicitante_datos_personales='$_nombres_solicitante_datos_personales',
					correo_solicitante_datos_personales='$_correo_solicitante_datos_personales',
					id_sexo_datos_personales='$_id_sexo_datos_personales',
					fecha_nacimiento_datos_personales='$_fecha_nacimiento_datos_personales',
					id_estado_civil_datos_personales='$_id_estado_civil_datos_personales',
					separacion_bienes_datos_personales='$_separacion_bienes_datos_personales',
					cargas_familiares_datos_personales='$_cargas_familiares_datos_personales',
					numero_hijos_datos_personales='$_numero_hijos_datos_personales',
					nivel_educativo_datos_personales='$_nivel_educativo_datos_personales',
					id_provincias_vivienda='$_id_provincias_vivienda',
					id_cantones_vivienda='$_id_cantones_vivienda',
					id_parroquias_vivienda='$_id_parroquias_vivienda',
					barrio_sector_vivienda='$_barrio_sector_vivienda',
					ciudadela_conjunto_etapa_manzana_vivienda='$_ciudadela_conjunto_etapa_manzana_vivienda',
					calle_vivienda='$_calle_vivienda',
					numero_calle_vivienda='$_numero_calle_vivienda',
					intersecion_vivienda='$_intersecion_vivienda',
					tipo_vivienda='$_tipo_vivienda',
					vivienda_hipotecada_vivienda='$_vivienda_hipotecada_vivienda',
					tiempo_residencia_vivienda='$_tiempo_residencia_vivienda',
					nombre_propietario_vivienda='$_nombre_propietario_vivienda',
					celular_propietario_vivienda='$_celular_propietario_vivienda',
					referencia_direccion_domicilio_vivienda='$_referencia_direccion_domicilio_vivienda',
					numero_casa_solicitante='$_numero_casa_solicitante',
					numero_celular_solicitante='$_numero_celular_solicitante',
					numero_trabajo_solicitante='$_numero_trabajo_solicitante',
					extension_solicitante='$_extension_solicitante',
					mode_solicitante='$_mode_solicitante',
					apellidos_referencia_personal='$_apellidos_referencia_personal',
					nombres_referencia_personal='$_nombres_referencia_personal',
					relacion_referencia_personal='$_relacion_referencia_personal',
					numero_telefonico_referencia_personal='$_numero_telefonico_referencia_personal',
					apellidos_referencia_familiar='$_apellidos_referencia_familiar',
					nombres_referencia_familiar='$_nombres_referencia_familiar',
					parentesco_referencia_familiar='$_parentesco_referencia_familiar',
					numero_telefonico_referencia_familiar='$_numero_telefonico_referencia_familiar',
					id_entidades='$_id_entidades',
					id_provincias_asignacion='$_id_provincias_asignacion',
					id_cantones_asignacion='$_id_cantones_asignacion',
					id_parroquias_asignacion='$_id_parroquias_asignacion',
					numero_telefonico_datos_laborales='$_numero_telefonico_datos_laborales',
					interseccion_datos_laborales='$_interseccion_datos_laborales',
					calle_datos_laborales='$_calle_datos_laborales',
					cargo_actual_datos_laborales='$_cargo_actual_datos_laborales',
					sueldo_total_info_economica='$_sueldo_total_info_economica',
					cuota_prestamo_ordinario_info_economica='$_cuota_prestamo_ordinario_info_economica',
					arriendos_info_economica='$_arriendos_info_economica',
					cuota_prestamo_emergente_info_economica='$_cuota_prestamo_emergente_info_economica',
					honorarios_profesionales_info_economica='$_honorarios_profesionales_info_economica',
					cuota_otros_prestamos_info_economica='$_cuota_otros_prestamos_info_economica',
					comisiones_info_economica='$_comisiones_info_economica',
					cuota_prestamo_iess_info_economica='$_cuota_prestamo_iess_info_economica',
					horas_suplementarias_info_economica='$_horas_suplementarias_info_economica',
					arriendos_egre_info_economica='$_arriendos_egre_info_economica',
					alimentacion_info_economica='$_alimentacion_info_economica',
					otros_ingresos_1_info_economica='$_otros_ingresos_1_info_economica',
					valor_ingresos_1_info_economica='$_valor_ingresos_1_info_economica',
					estudios_info_economica='$_estudios_info_economica',
					otros_ingresos_2_info_economica='$_otros_ingresos_2_info_economica',
					valor_ingresos_2_info_economica='$_valor_ingresos_2_info_economica',
					pago_servicios_basicos_info_economica='$_pago_servicios_basicos_info_economica',
					otros_ingresos_3_info_economica='$_otros_ingresos_3_info_economica',
					valor_ingresos_3_info_economica='$_valor_ingresos_3_info_economica',
					pago_tarjetas_credito_info_economica='$_pago_tarjetas_credito_info_economica',
					otros_ingresos_4_info_economica='$_otros_ingresos_4_info_economica',
					valor_ingresos_4_info_economica='$_valor_ingresos_4_info_economica',
					afiliacion_cooperativas_info_economica='$_afiliacion_cooperativas_info_economica',
					otros_ingresos_5_info_economica='$_otros_ingresos_5_info_economica',
					valor_ingresos_5_info_economica='$_valor_ingresos_5_info_economica',
					ahorro_info_economica='$_ahorro_info_economica',
					otros_ingresos_6_info_economica='$_otros_ingresos_6_info_economica',
					valor_ingresos_6_info_economica='$_valor_ingresos_6_info_economica',
					impuesto_renta_info_economica='$_impuesto_renta_info_economica',
					otros_ingresos_7_info_economica='$_otros_ingresos_7_info_economica',
					valor_ingresos_7_info_economica='$_valor_ingresos_7_info_economica',
					otros_ingresos_8_info_economica='$_otros_ingresos_8_info_economica',
					valor_ingresos_8_info_economica='$_valor_ingresos_8_info_economica',
					otros_egresos_1_info_economica='$_otros_egresos_1_info_economica',
					valor_egresos_1_info_economica='$_valor_egresos_1_info_economica',
					total_ingresos_mensuales='$_total_ingresos_mensuales',
					total_egresos_mensuales='$_total_egresos_mensuales'";
					$tablas="solicitud_prestamo";
					$where="id_solicitud_prestamo = '$_id_solicitud_prestamo'";
					$resultado2=$solicitud_prestamo->UpdateBy($columnas, $tablas, $where);
						
						
					if($_id_estado_civil_datos_personales != 1 && $_id_estado_civil_datos_personales != 5 && $_id_estado_civil_datos_personales != 3){
							
						$colval_afi = "numero_cedula_conyuge= '$_numero_cedula_conyuge',
						apellidos_conyuge='$_apellidos_conyuge',
						nombres_conyuge='$_nombres_conyuge',
						id_sexo_conyuge='$_id_sexo_conyuge',
						fecha_nacimiento_conyuge='$_fecha_nacimiento_conyuge',
						convive_afiliado_conyuge='$_convive_afiliado_conyuge',
						numero_telefonico_conyuge='$_numero_telefonico_conyuge',
						actividad_economica_conyuge='$_actividad_economica_conyuge'";
						$tabla_afi = "solicitud_prestamo";
						$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
						$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
							
					}else{
	
	
						if($_id_sexo_conyuge >0 && $_fecha_nacimiento_conyuge!=""){
								
							$colval_afi = "numero_cedula_conyuge= '$_numero_cedula_conyuge',
							apellidos_conyuge='$_apellidos_conyuge',
							nombres_conyuge='$_nombres_conyuge',
							id_sexo_conyuge='$_id_sexo_conyuge',
							fecha_nacimiento_conyuge='$_fecha_nacimiento_conyuge',
							convive_afiliado_conyuge='$_convive_afiliado_conyuge',
							numero_telefonico_conyuge='$_numero_telefonico_conyuge',
							actividad_economica_conyuge='$_actividad_economica_conyuge'";
							$tabla_afi = "solicitud_prestamo";
							$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
							$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
								
						}else{
								
							$colval_afi = "numero_cedula_conyuge= '',
							apellidos_conyuge='',
							nombres_conyuge='',
							id_sexo_conyuge=NULL,
							fecha_nacimiento_conyuge=NULL,
							convive_afiliado_conyuge='',
							numero_telefonico_conyuge='',
							actividad_economica_conyuge=''";
							$tabla_afi = "solicitud_prestamo";
							$where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
							$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
	
						}
	
					}
						
				}
	
				
				
				
				
				//ACTUALIZAR DATOS EN USUARIOS
				
				$usuarios_act = new UsuariosModel();
				
				$colval_usu = "telefono_usuarios='$_numero_casa_solicitante',
                                       celular_usuarios='$_numero_celular_solicitante',
                                       correo_usuarios='$_correo_solicitante_datos_personales'";
				$tabla_usu = "usuarios";
				$where_usu = "cedula_usuarios = '$_numero_cedula_datos_personales'";
				$resultUsu=$usuarios_act->UpdateBy($colval_usu, $tabla_usu, $where_usu);
				
				
				
				//ACTUALIZAR DATOS EN SQL
				require_once 'core/EntidadBaseSQL.php';
				$db = new EntidadBaseSQL();
				
				$colval_partner = "PHONE='$_numero_casa_solicitante',
                                           PARNERT_MOVIL_PHONE='$_numero_celular_solicitante',
                                           EMAIL='$_correo_solicitante_datos_personales',
                                           BIRTH_DATE='$_fecha_nacimiento_datos_personales";
				$tabla_partner = "one.PARTNER";
				$where_partner = "IDENTITY_CARD = '$_numero_cedula_datos_personales'";
				$resultPartner=$db->UpdateBy_SQL($colval_partner, $tabla_partner, $where_partner);
				
				
				
				$this->redirect("SolicitudPrestamo", "index3");
	
			}
			else
			{
				$this->redirect("SolicitudPrestamo", "index3");
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
	
	
	
	
	public function index5(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			$solicitud_prestamo = new SolicitudPrestamoModel();
			$nombre_controladores = "SolicitudPrestamo";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $solicitud_prestamo->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
	
			    
			   
				$this->view("ConsultaSolicitudPrestamoSuperAdmin",array(
						""=>""
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de prestamo."
	
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
	
	
	public function searchadminsuper_deudor(){
	
		session_start();
		$solicitud_prestamo = new SolicitudPrestamoModel();
		$usuarios = new UsuariosModel();
		$id_usuarios=$_SESSION["id_usuarios"];
	
		$where_to="";
		$columnas = "solicitud_prestamo.id_solicitud_prestamo,
					  solicitud_prestamo.tipo_participe_datos_prestamo,
					  solicitud_prestamo.monto_datos_prestamo,
					  solicitud_prestamo.plazo_datos_prestamo,
					  solicitud_prestamo.destino_dinero_datos_prestamo,
					  solicitud_prestamo.nombre_banco_cuenta_bancaria,
					  solicitud_prestamo.tipo_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cedula_datos_personales,
					  solicitud_prestamo.apellidos_solicitante_datos_personales,
					  solicitud_prestamo.nombres_solicitante_datos_personales,
					  solicitud_prestamo.correo_solicitante_datos_personales,
					  sexo.nombre_sexo,
					  solicitud_prestamo.fecha_nacimiento_datos_personales,
					  estado_civil.nombre_estado_civil,
					  solicitud_prestamo.fecha_presentacion,
					  solicitud_prestamo.fecha_aprobacion,
					  solicitud_prestamo.id_estado_tramites,
					  solicitud_prestamo.identificador_consecutivos,
				      solicitud_prestamo.tipo_pago_cuenta_bancaria,
				      tipo_creditos.nombre_tipo_creditos,
				      usuarios.nombre_usuarios,
				      usuarios.correo_usuarios,
				      solicitud_prestamo.id_usuarios_oficial_credito_aprueba,
				      estado_tramites.nombre_estado_tramites_solicitud_prestamos";
	
		$tablas   = "public.solicitud_prestamo,
					  public.entidades,
					  public.sexo,
					  public.estado_civil,
				      public.tipo_creditos,
				public.usuarios,
				      public.estado_tramites";
			
		$where    = "solicitud_prestamo.id_estado_tramites= estado_tramites.id_estado_tramites AND solicitud_prestamo.id_usuarios_oficial_credito_aprueba=usuarios.id_usuarios AND tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
		solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
		entidades.id_entidades = solicitud_prestamo.id_entidades AND
		sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales AND solicitud_prestamo.tipo_participe_datos_prestamo='Deudor'";
	
		$id       = "solicitud_prestamo.id_solicitud_prestamo";
	
			
		//$where_to=$where;
			
			
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
			
		if($action == 'ajax')
		{
				
			if(!empty($search)){
					
					
				$where1=" AND (solicitud_prestamo.numero_cedula_datos_personales LIKE '".$search."%' OR solicitud_prestamo.apellidos_solicitante_datos_personales LIKE '".$search."%' OR solicitud_prestamo.nombres_solicitante_datos_personales LIKE '".$search."%' OR tipo_creditos.nombre_tipo_creditos LIKE '".$search."%'  OR usuarios.nombre_usuarios LIKE '".$search."%' OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos LIKE '".$search."%')";
					
				$where_to=$where.$where1;
			}else{
					
				$where_to=$where;
					
			}
				
				
			$html="";
			$resultSet=$solicitud_prestamo->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 10; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$solicitud_prestamo->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
			$count_query   = $cantidadResult;
			$total_pages = ceil($cantidadResult/$per_page);
	
			if($cantidadResult>0)
			{
	
				$html.='<div class="pull-left" style="margin-left:11px;">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div>';
				$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
				$html.='<section style="height:350px; overflow-y:scroll;">';
				$html.= "<table id='tabla_solicitud_prestamos_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
	
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Crédito</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Tipo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Monto</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Plazo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Transacción</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Presentación</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Fecha T</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Oficial C</th>';
				$html.='<th style="text-align: right;  font-size: 11px;"></th>';
				$html.='<th style="text-align: right;  font-size: 11px;"></th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					
				$i=0;
	
				foreach ($resultSet as $res)
				{
	
					$aprobado_oficial_credito=$res->id_estado_tramites;
					if($aprobado_oficial_credito==2){
						$estado_tramite='Guardado';
	
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}
					elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
	
					}elseif($aprobado_oficial_credito==4){
						$estado_tramite='Revisado';
						
					}
	
					$html.='<tr>';
	
					$html.='<td style="font-size: 11px;">'.$res->numero_cedula_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->apellidos_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombres_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_creditos.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_participe_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->monto_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->plazo_datos_prestamo.' meses</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_pago_cuenta_bancaria.'</td>';
					$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_presentacion)).'</td>';
					$html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
					if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
						$html.='<td style="font-size: 11px;"></td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
	
					}else{
					    
					    if(!empty($res->fecha_aprobacion)){
					        
					        $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
					        
					    }else{
					        
					        $html.='<td style="font-size: 11px;"></td>';
					    }
					    
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						
					}
					
					
					if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
					   
					    $html.='<td style="font-size: 15px;"><span class="pull-right"><button id="btn_abrir" class="btn btn-success" type="button" data-toggle="modal" data-target="#mod_reasignar" data-id="'.$res->id_solicitud_prestamo.'" data-cedu="'.$res->numero_cedula_datos_personales.'" data-nombre="'.$res->apellidos_solicitante_datos_personales.' '.$res->nombres_solicitante_datos_personales.'" data-credito="'.$res->nombre_tipo_creditos.'" data-usuario="'.$res->nombre_usuarios.'"  title="Reasignar" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></button></span></td>';
					    
					     
					}else{
					    $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" target="_blank" class="btn btn-success" style="font-size:65%;" title="Reasignar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					    
					}
					
					
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
					
					$html.='</tr>';
	
				}
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_load_solicitud_prestamos_registrados("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de prestamos registrados...</b>';
				$html.='</div>';
				$html.='</div>';
			}
	
			echo $html;
			die();
	
		}
	
	}
	
	
	
	
	
	
	public function searchadminsuper_garantes(){
	
		session_start();
		$solicitud_prestamo = new SolicitudPrestamoModel();
		$usuarios = new UsuariosModel();
		$id_usuarios=$_SESSION["id_usuarios"];
	
		$where_to="";
		$columnas = "solicitud_prestamo.id_solicitud_prestamo,
					  solicitud_prestamo.tipo_participe_datos_prestamo,
					  solicitud_prestamo.monto_datos_prestamo,
					  solicitud_prestamo.plazo_datos_prestamo,
					  solicitud_prestamo.destino_dinero_datos_prestamo,
					  solicitud_prestamo.nombre_banco_cuenta_bancaria,
					  solicitud_prestamo.tipo_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cuenta_cuenta_bancaria,
					  solicitud_prestamo.numero_cedula_datos_personales,
					  solicitud_prestamo.apellidos_solicitante_datos_personales,
					  solicitud_prestamo.nombres_solicitante_datos_personales,
					  solicitud_prestamo.correo_solicitante_datos_personales,
					  sexo.nombre_sexo,
					  solicitud_prestamo.fecha_nacimiento_datos_personales,
					  estado_civil.nombre_estado_civil,
					  solicitud_prestamo.fecha_presentacion,
					  solicitud_prestamo.fecha_aprobacion,
					  solicitud_prestamo.id_estado_tramites,
					  solicitud_prestamo.identificador_consecutivos,
				      solicitud_prestamo.tipo_pago_cuenta_bancaria,
				      tipo_creditos.nombre_tipo_creditos,
				      usuarios.nombre_usuarios,
				      usuarios.correo_usuarios,
				      solicitud_prestamo.id_usuarios_oficial_credito_aprueba,
				      solicitud_prestamo.cedula_deudor_a_garantizar,
				      solicitud_prestamo.nombre_deudor_a_garantizar,
				      estado_tramites.nombre_estado_tramites_solicitud_prestamos";
	
		$tablas   = "public.solicitud_prestamo,
					  public.entidades,
					  public.sexo,
					  public.estado_civil,
				      public.tipo_creditos,
				public.usuarios,
				      public.estado_tramites";
			
		$where    = "solicitud_prestamo.id_estado_tramites= estado_tramites.id_estado_tramites AND solicitud_prestamo.id_usuarios_oficial_credito_aprueba=usuarios.id_usuarios AND tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
		solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
		entidades.id_entidades = solicitud_prestamo.id_entidades AND
		sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales  AND solicitud_prestamo.tipo_participe_datos_prestamo='Garante'";
	
		$id       = "solicitud_prestamo.id_solicitud_prestamo";
	
			
		//$where_to=$where;
			
			
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
			
		if($action == 'ajax')
		{
			if(!empty($search)){
					
				$where1=" AND (solicitud_prestamo.numero_cedula_datos_personales LIKE '".$search."%' OR solicitud_prestamo.apellidos_solicitante_datos_personales LIKE '".$search."%' OR solicitud_prestamo.nombres_solicitante_datos_personales LIKE '".$search."%' OR tipo_creditos.nombre_tipo_creditos LIKE '".$search."%' OR solicitud_prestamo.cedula_deudor_a_garantizar LIKE '".$search."%'  OR usuarios.nombre_usuarios LIKE '".$search."%' OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos LIKE '".$search."%')";
					
				$where_to=$where.$where1;
			}else{
					
				$where_to=$where;
			}
				
			$html="";
			$resultSet=$solicitud_prestamo->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 10; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
			$resultSet=$solicitud_prestamo->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
			$count_query   = $cantidadResult;
			$total_pages = ceil($cantidadResult/$per_page);
	
			if($cantidadResult>0)
			{
				$html.='<div class="pull-left" style="margin-left:11px;">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div>';
				$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
				$html.='<section style="height:350px; overflow-y:scroll;">';
				$html.= "<table id='tabla_solicitud_garantias_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Crédito</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Tipo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Monto</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Plazo</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Cedula Deudor</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Nombre Deudor</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Fecha T</th>';
				$html.='<th style="text-align: left;  font-size: 11px;">Oficial C</th>';
				$html.='<th style="text-align: right;  font-size: 11px;"></th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
					
				$i=0;
	
				foreach ($resultSet as $res)
				{
	
					$aprobado_oficial_credito=$res->id_estado_tramites;
					if($aprobado_oficial_credito==2){
						$estado_tramite='Guardado';
	
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}
					elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
					}elseif($aprobado_oficial_credito==4){
						$estado_tramite='Revisado';
						
					}
	
					$html.='<tr>';
	
					$html.='<td style="font-size: 11px;">'.$res->numero_cedula_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->apellidos_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombres_solicitante_datos_personales.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_tipo_creditos.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->tipo_participe_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->monto_datos_prestamo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->plazo_datos_prestamo.' meses</td>';
					$html.='<td style="font-size: 11px;">'.$res->cedula_deudor_a_garantizar.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_deudor_a_garantizar.'</td>';
					$html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
					if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
						$html.='<td style="font-size: 11px;"></td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
	
					}else{
						$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						
					}
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
					$html.='</tr>';
	
				}
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->load_solicitud_garantias_registrados("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de garantías de prestamos registrados...</b>';
				$html.='</div>';
				$html.='</div>';
			}
	
			echo $html;
			die();
	
		}
	
	}
	
	
	public function cargar_oficiales_credito(){
	    
	    $usuarios = null;
	    $usuarios = new UsuariosModel();
	    
	    $query = "select * from usuarios where id_rol=42 and id_estado=1 and id_departamentos=18 order by ciudad_trabajo";
	    
	    $resulset = $usuarios->enviaquery($query);
	    
	    if(!empty($resulset) && count($resulset)>0){
	        
	        echo json_encode(array('data'=>$resulset));
	        
	    }
	}
	
	
	
	
	public function ReasignarSolicitud(){
	    
	    session_start();
	    $solicitud_prestamo = new SolicitudPrestamoModel();
	    $usuarios = new UsuariosModel();
	    //controlador IngresoCuentasPagar
	    
	    //valida usuario logeado  dc 2019-05-20
	    if(!isset($_SESSION['id_usuarios'])){
	        echo 'Session Caducada';
	        exit();
	    }
	    //variables desde fn JS submit frm_genera_lote
	    //dc 2019-04-30
	    
	    
	    
	    $_id_solicitud_prestamo =(isset($_POST['id_solicitud_prestamo'])) ? $_POST['id_solicitud_prestamo'] : 0;
	    $_id_nuevo_oficial =(isset($_POST['id_nuevo_oficial'])) ? $_POST['id_nuevo_oficial'] : 0;
	    
	    
	    if($_id_nuevo_oficial > 0){
	        
	        $resulset=$usuarios->getBy("id_usuarios='$_id_nuevo_oficial'");
	        
	        if(!empty($resulset)){
	            
	            
	            $ciudad_trabajo = $resulset[0]->ciudad_trabajo;
	            
	            
	            if($ciudad_trabajo=="Quito"){
	                
	                $id_sucursales=1;
	                
	            }else{
	                
	                $id_sucursales=2;
	            }
	            
	            
	            if($id_sucursales > 0){
	                
	                
	                $resultDeudor=$solicitud_prestamo->getBy("id_solicitud_prestamo='$_id_solicitud_prestamo'");
	                
	                if(!empty($resultDeudor)){
	                    
	                    $identificador_consecutivos = $resultDeudor[0]->identificador_consecutivos;
	                    
	                    
	                    if(!empty($identificador_consecutivos)){
	                        
	                        $resulGaranConse=$solicitud_prestamo->getBy("identificador_consecutivos_deudor='$identificador_consecutivos'");
	                        
	                        
	                        if(!empty($resulGaranConse)){
	                            
	                            $id_solicitud_prestamo_garante = $resulGaranConse[0]->id_solicitud_prestamo;
	                            
	                            
	                            if ($id_solicitud_prestamo_garante > 0){
	                                
	                              
	                                $colval_afi_1 = "id_usuarios_oficial_credito_aprueba='$_id_nuevo_oficial', id_sucursales='$id_sucursales'";
	                                $tabla_afi_1 = "solicitud_prestamo";
	                                $where_afi_1 = "id_solicitud_prestamo = '$id_solicitud_prestamo_garante'";
	                                $resultado_1=$solicitud_prestamo->UpdateBy($colval_afi_1, $tabla_afi_1, $where_afi_1);
	                                
	                                
	                            }
	                            
	                        }
	                        
	                        
	                    }
	                    
	                }
	                
	                
	                $colval_afi = "id_usuarios_oficial_credito_aprueba='$_id_nuevo_oficial', id_sucursales='$id_sucursales'";
	                $tabla_afi = "solicitud_prestamo";
	                $where_afi = "id_solicitud_prestamo = '$_id_solicitud_prestamo'";
	                //$resultado=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
	                $resultado=$solicitud_prestamo->editBy($colval_afi, $tabla_afi, $where_afi);	                
	                
	                
	                
	                
	                
	                
	                if((int)$resultado > 0){
	                    
	                    echo json_encode(array('valor' => $resultado));
	                    return;
	                
	                }
	                
	                
	            }
	            
	          
	            
	            
	        }
	        
	        
	    }
	    
	    $pgError = pg_last_error();
	    
	    echo "no se actualizo. ".$pgError;
	    
	}
	
	
	
	
	
	public function EnviarSMS(){
	    
	    session_start();
	    $solicitud_prestamo = new SolicitudPrestamoModel();
	    $usuarios = new UsuariosModel();
	    $resultado=2;
	    $cadena_recortada="";
	    $codigo_verificacion = new CodigoVerificacionModel();
	    $mensaje_retorna="";
	   
	    if(!isset($_SESSION['id_usuarios'])){
	        echo 'Session Caducada';
	        exit();
	    }
	    
	    $_id_usuarios = $_SESSION['id_usuarios'];
	    $_numero_celular_solicitante =(isset($_POST['numero_celular_solicitante'])) ? $_POST['numero_celular_solicitante'] : '';
	    
	    
	    if(!empty($_numero_celular_solicitante)){
	        
	        
	        
	        $resulset=$usuarios->getBy("id_usuarios='$_id_usuarios'");
	        
	        if(!empty($resulset)){
	            
	            
	            $nombre_usuarios = $resulset[0]->nombre_usuarios;
	            
	            
	            if(!empty($nombre_usuarios)){
	                
	                
	                $cadena = "1234567890";
	                $longitudCadena=strlen($cadena);
	                $codigo = "";
	                $longitudPass=5;
	                for($i=1 ; $i<=$longitudPass ; $i++){
	                    $pos=rand(0,$longitudCadena-1);
	                    $codigo .= substr($cadena,$pos,1);
	                }
	                
	                $cadena_recortada=$this->comsumir_mensaje_plus($_numero_celular_solicitante, $nombre_usuarios, $codigo);
	                
	                
	                
	                if($cadena_recortada=='100'){
	                    
	                    $funcion = "ins_codigo_verificacion";
	                    $parametros = " '$_id_usuarios','$codigo', '$_numero_celular_solicitante'";
	                    $codigo_verificacion->setFuncion($funcion);
	                    $codigo_verificacion->setParametros($parametros);
	                    $resultado=$codigo_verificacion->llamafuncionPG();
	                    
	                    $mensaje_retorna="Enviado Correctamente";
	                    
	                }else if ($cadena_recortada=='101'){
	                    
	                    
	                    $funcion = "ins_codigo_verificacion";
	                    $parametros = " '$_id_usuarios','$codigo', '$_numero_celular_solicitante'";
	                    $codigo_verificacion->setFuncion($funcion);
	                    $codigo_verificacion->setParametros($parametros);
	                    $resultado=$codigo_verificacion->llamafuncionPG();
	                    
	                    $mensaje_retorna="Despacho en Cola";
	                    
	                }else if ($cadena_recortada=='200'){
	                    
	                    $mensaje_retorna="Estructura no Válida";
	                    
	                }else if ($cadena_recortada=='201'){
	                    
	                    $mensaje_retorna="Método no Existe";
	                    
	                }else if ($cadena_recortada=='202'){
	                    
	                    $mensaje_retorna="Parámetros Incompletos";
	                    
	                }else if ($cadena_recortada=='302'){
	                    
	                    $mensaje_retorna="Cliente no Existe";
	                    
	                }else if ($cadena_recortada=='303'){
	                    
	                    $mensaje_retorna="Mensaje muy Grande";
	                    
	                }else if ($cadena_recortada=='307'){
	                    
	                    $mensaje_retorna="Cliente no tiene Servicio Online";
	                    
	                }else if ($cadena_recortada=='309'){
	                    
	                    $mensaje_retorna="Token Inválido";
	                    
	                }else if ($cadena_recortada=='310'){
	                    
	                    $mensaje_retorna="Shortcode no disponible para el Cliente";
	                    
	                }else if ($cadena_recortada=='311'){
	                    
	                    $mensaje_retorna="Acceso Remoto no Permitido";
	                    
	                }else if ($cadena_recortada=='312'){
	                    
	                    $mensaje_retorna="Teléfono Destino en Lista Negra";
	                    
	                }else if ($cadena_recortada=='313'){
	                    
	                    $mensaje_retorna="Mensaje no Asignado";
	                    
	                }else if ($cadena_recortada=='314'){
	                    
	                    $mensaje_retorna="Data Variable no coincide con parámetro enviados";
	                    
	                }else if ($cadena_recortada=='315'){
	                    
	                    $mensaje_retorna="Teléfono Incorrecto";
	                    
	                }else if ($cadena_recortada=='400'){
	                    
	                    $mensaje_retorna="No se pudo procesar";
	                    
	                }else{
	                    
	                    $mensaje_retorna="Error Desconocido Vuelva a Intentarlo.";
	                }
	                
	                
	                
	                if((int)$resultado > 0){
	                    
	                    echo json_encode(array('valor' => $resultado, 'mensaje'=>$mensaje_retorna));
	                    die();
	                    
	                }
	                
	                
	            }
	           
	            
	        }
	        
	        
	    }
	    
	    $pgError = pg_last_error();
	    
	    echo "no se envio sms. ".$pgError;
	    
	}
	
	
	
	
	
	
	
	public function comsumir_mensaje_plus($celular, $nombres, $codigo){
	    
	    
	    
	    $respuesta="";
	    $nombres_final="";
	    
	    // quito el primero 0
	    $celular_final=ltrim($celular, "0");
	    
	    // relleno espacios en blanco por _
	    $nombres_final= str_replace(' ','_',$nombres);
	   // $nombres_final= str_replace('Ñ','N',$nombres);
	    // genero codigo de verificacion
	    
	    
	    $variables="";
	    $variables.="<pedido>";
	    
	    $variables.="<metodo>SMSEnvio</metodo>";
	    $variables.="<id_cbm>767</id_cbm>";
	    $variables.="<token>yPoJWsNjcThx2o0I</token>";
	    $variables.="<id_transaccion>2002</id_transaccion>";
	    $variables.="<telefono>$celular_final</telefono>";
	    
	    // poner el id_mensaje parametrizado en el sistema
	    
	    $variables.="<id_mensaje>22442</id_mensaje>";
	    
	    // poner 1 si va con variables
	    // poner 0 si va sin variables y sin la etiquetas datos
	    $variables.="<dt_variable>1</dt_variable>";
	    $variables.="<datos>";
	    
	    
	    /// el numero de valores va dependiendo del mensaje si usa 1 o 2 variables.
	    $variables.="<valor>$nombres_final</valor>";
	    $variables.="<valor>$codigo</valor>";
	    $variables.="</datos>";
	    $variables.="</pedido>";
	    
	    
	    $SMSPlusUrl = "https://smsplus.net.ec/smsplus/ws/mensajeria.php?xml={$variables}";
	    $ResponseData = file_get_contents($SMSPlusUrl);
	    
	   
	    $xml = simplexml_load_string($ResponseData);
	    
	    //convert into json
	    $json  = json_encode($xml);
	    
	    //convert into associative array
	    $xmlArr = json_decode($json, true);
	    
	    $respuesta= $xmlArr['cod_respuesta'];
	    
	    return $respuesta;
	    
	    
	    
	}
	
	
	
	
	
	public function Validar_Codigo_Verificacion(){
	     
	    session_start();
	   
	    $codigo_verificacion = new CodigoVerificacionModel();
	    $resultado=0;
	    
	    if(!isset($_SESSION['id_usuarios'])){
	        echo 'Session Caducada';
	        exit();
	    }
	    
	    $_id_usuarios = $_SESSION['id_usuarios'];
	    $_numero_codigo_verificacion =(isset($_POST['numero_codigo_verificacion'])) ? $_POST['numero_codigo_verificacion'] : '';
	    
	    
	    if(!empty($_numero_codigo_verificacion)){
	        
	        
	        date_default_timezone_set('America/Guayaquil');
	        $fechaActual = date('Y-m-d');
	        
	        $resulset=$codigo_verificacion->getBy("id_usuarios='$_id_usuarios' AND numero_codigo_verificacion='$_numero_codigo_verificacion' AND validado_codigo_verificacion='FALSE' AND date(creado) between '$fechaActual' and '$fechaActual'");
	        
	        if(!empty($resulset)){
	            
	            
	            $id_codigo_verificacion = $resulset[0]->id_codigo_verificacion;
	            
	            
	            
	            $colval_afi = "validado_codigo_verificacion='TRUE'";
	            $tabla_afi = "codigo_verificacion";
	            $where_afi = "id_codigo_verificacion = '$id_codigo_verificacion'";
	            $resultado=$codigo_verificacion->editBy($colval_afi, $tabla_afi, $where_afi);
	            
	                
	                
	                
	                if((int)$resultado > 0){
	                    
	                    echo json_encode(array('valor' => $resultado, 'id_codigo_verificacion'=>$id_codigo_verificacion));
	                    die();
	                    
	                }
	                
	                
	          
	            
	            
	        }
	        
	        
	    }
	    
	    $pgError = pg_last_error();
	    
	    echo "codigo no existe. ".$pgError;
	    
	    
	    
	}
	
	
	
	
	
	
	
	
	
	
	
	
}
?>