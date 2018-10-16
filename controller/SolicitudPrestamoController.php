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
							solicitud_prestamo.id_sucursales";
					
					$tablas="public.solicitud_prestamo";
					$where="1=1  AND solicitud_prestamo.id_solicitud_prestamo='$_id_solicitud_prestamo'";
					$id="solicitud_prestamo.id_solicitud_prestamo";
					$resultEdit=$solicitud_prestamo->getCondiciones($columnas, $tablas, $where, $id);
					
					
					$this->view("SolicitudPrestamo",array(
							"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
							"resultProvincias"=>$resultProvincias, "resultBancos"=>$resultBancos,
							"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones,
							"resultEdit"=>$resultEdit, "resultTipoCredito"=>$resultTipoCredito, "resultSucursales"=>$resultSucursales
								
					));
					
					die();
					
				}
				
				
				$_id_usuarios= $_SESSION["id_usuarios"];
				
				$result=$solicitud_prestamo->getBy("id_usuarios_registra='$_id_usuarios'");
				
				
				if(!empty($result)){
					$_id_estado_tramites=$result[0]->id_estado_tramites;
				
					
					if($_id_estado_tramites==1){
						
						
						$error="Estimado participe usted ya cuenta con una solicitud de préstamo generada en estado pendiente.<br>Pongase en contacto con uno de nuestros oficiales de crédito para anular o aprobar la solicitud anterior.";
						
						$this->view("Error",array(
								"error"=>$error
						
						));
						die();
						
					}else{
						
						$this->view("SolicitudPrestamo",array(
								"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
								"resultProvincias"=>$resultProvincias, "resultBancos"=>$resultBancos,
								"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones,
								"resultEdit"=>$resultEdit, "resultTipoCredito"=>$resultTipoCredito, "resultSucursales"=>$resultSucursales
									
						));
						
						die();
					}
					
					
				}
				
				$this->view("SolicitudPrestamo",array(
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
			
			if (isset($_POST["tipo_participe_datos_prestamo"]))
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
				$_apellidos_solicitante_datos_personales                     = $_POST["apellidos_solicitante_datos_personales"];
				$_nombres_solicitante_datos_personales                       = $_POST["nombres_solicitante_datos_personales"];
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
				$_nombre_propietario_vivienda                                = $_POST["nombre_propietario_vivienda"];
				$_celular_propietario_vivienda                               = $_POST["celular_propietario_vivienda"];
				$_referencia_direccion_domicilio_vivienda                    = $_POST["referencia_direccion_domicilio_vivienda"];
				$_numero_casa_solicitante                                    = $_POST["numero_casa_solicitante"];
				$_numero_celular_solicitante                                 = $_POST["numero_celular_solicitante"];
				$_numero_trabajo_solicitante                                 = $_POST["numero_trabajo_solicitante"];
				$_extension_solicitante                                      = $_POST["extension_solicitante"];
				$_mode_solicitante                                           = $_POST["mode_solicitante"];
				$_apellidos_referencia_personal                              = $_POST["apellidos_referencia_personal"];
				$_nombres_referencia_personal                                = $_POST["nombres_referencia_personal"];
				$_relacion_referencia_personal                               = $_POST["relacion_referencia_personal"];
				$_numero_telefonico_referencia_personal                      = $_POST["numero_telefonico_referencia_personal"];
				$_apellidos_referencia_familiar                              = $_POST["apellidos_referencia_familiar"];
				$_nombres_referencia_familiar                                = $_POST["nombres_referencia_familiar"];
				$_parentesco_referencia_familiar                             = $_POST["parentesco_referencia_familiar"];
				$_numero_telefonico_referencia_familiar                      = $_POST["numero_telefonico_referencia_familiar"];
				$_id_entidades                                               = $_POST["id_entidades"];
				$_id_provincias_asignacion                                   = $_POST["id_provincias_asignacion"];
				$_id_cantones_asignacion                                     = $_POST["id_cantones_asignacion"];
				$_id_parroquias_asignacion                                   = $_POST["id_parroquias_asignacion"];
				$_numero_telefonico_datos_laborales                          = $_POST["numero_telefonico_datos_laborales"];
				$_interseccion_datos_laborales                               = $_POST["interseccion_datos_laborales"];
				$_calle_datos_laborales                                      = $_POST["calle_datos_laborales"];
				$_cargo_actual_datos_laborales                               = $_POST["cargo_actual_datos_laborales"];
				
				$_sueldo_total_info_economica                                = $_POST["sueldo_total_info_economica"];
				$_cuota_prestamo_ordinario_info_economica                    = $_POST["cuota_prestamo_ordinario_info_economica"];
				$_arriendos_info_economica                                   = $_POST["arriendos_info_economica"];
				$_cuota_prestamo_emergente_info_economica                    = $_POST["cuota_prestamo_emergente_info_economica"];
				$_honorarios_profesionales_info_economica                    = $_POST["honorarios_profesionales_info_economica"];
				$_cuota_otros_prestamos_info_economica                       = $_POST["cuota_otros_prestamos_info_economica"];
				$_comisiones_info_economica                                  = $_POST["comisiones_info_economica"];
				$_cuota_prestamo_iess_info_economica                         = $_POST["cuota_prestamo_iess_info_economica"];
				$_horas_suplementarias_info_economica                        = $_POST["horas_suplementarias_info_economica"];
				$_arriendos_egre_info_economica                              = $_POST["arriendos_egre_info_economica"];
				$_alimentacion_info_economica                                = $_POST["alimentacion_info_economica"];
				$_otros_ingresos_1_info_economica                            = $_POST["otros_ingresos_1_info_economica"];
				$_valor_ingresos_1_info_economica                            = $_POST["valor_ingresos_1_info_economica"];
				$_estudios_info_economica                                    = $_POST["estudios_info_economica"];
				$_otros_ingresos_2_info_economica                            = $_POST["otros_ingresos_2_info_economica"];
				$_valor_ingresos_2_info_economica                            = $_POST["valor_ingresos_2_info_economica"];
				$_pago_servicios_basicos_info_economica                      = $_POST["pago_servicios_basicos_info_economica"];
				$_otros_ingresos_3_info_economica                            = $_POST["otros_ingresos_3_info_economica"];
				$_valor_ingresos_3_info_economica                            = $_POST["valor_ingresos_3_info_economica"];
				$_pago_tarjetas_credito_info_economica                       = $_POST["pago_tarjetas_credito_info_economica"];
				$_otros_ingresos_4_info_economica                            = $_POST["otros_ingresos_4_info_economica"];
				$_valor_ingresos_4_info_economica                            = $_POST["valor_ingresos_4_info_economica"];
				$_afiliacion_cooperativas_info_economica                     = $_POST["afiliacion_cooperativas_info_economica"];
				$_otros_ingresos_5_info_economica                            = $_POST["otros_ingresos_5_info_economica"];
				$_valor_ingresos_5_info_economica                            = $_POST["valor_ingresos_5_info_economica"];
				$_ahorro_info_economica                                      = $_POST["ahorro_info_economica"];
				$_otros_ingresos_6_info_economica                            = $_POST["otros_ingresos_6_info_economica"];
				$_valor_ingresos_6_info_economica                            = $_POST["valor_ingresos_6_info_economica"];
				$_impuesto_renta_info_economica                              = $_POST["impuesto_renta_info_economica"];
				$_otros_ingresos_7_info_economica                            = $_POST["otros_ingresos_7_info_economica"];
				$_valor_ingresos_7_info_economica                            = $_POST["valor_ingresos_7_info_economica"];
				$_otros_ingresos_8_info_economica                            = $_POST["otros_ingresos_8_info_economica"];
				$_valor_ingresos_8_info_economica                            = $_POST["valor_ingresos_8_info_economica"];
				$_otros_egresos_1_info_economica                             = $_POST["otros_egresos_1_info_economica"];
				$_valor_egresos_1_info_economica                             = $_POST["valor_egresos_1_info_economica"];
				
				$_total_ingresos_mensuales  = $_sueldo_total_info_economica+$_arriendos_info_economica+$_honorarios_profesionales_info_economica+$_comisiones_info_economica+$_horas_suplementarias_info_economica+$_valor_ingresos_1_info_economica+$_valor_ingresos_2_info_economica+$_valor_ingresos_3_info_economica+$_valor_ingresos_4_info_economica+$_valor_ingresos_5_info_economica+$_valor_ingresos_6_info_economica+$_valor_ingresos_7_info_economica+$_valor_ingresos_8_info_economica;
				$_total_egresos_mensuales   = $_cuota_prestamo_ordinario_info_economica+$_cuota_prestamo_emergente_info_economica+$_cuota_otros_prestamos_info_economica+$_cuota_prestamo_iess_info_economica+$_arriendos_egre_info_economica+$_alimentacion_info_economica+$_estudios_info_economica+$_pago_servicios_basicos_info_economica+$_pago_tarjetas_credito_info_economica+$_afiliacion_cooperativas_info_economica+$_ahorro_info_economica+$_impuesto_renta_info_economica+$_valor_egresos_1_info_economica;
				
				$_numero_cedula_conyuge                                      = $_POST["numero_cedula_conyuge"];
				$_apellidos_conyuge                                          = $_POST["apellidos_conyuge"];
				$_nombres_conyuge                                            = $_POST["nombres_conyuge"];
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
				
				
				if($_id_solicitud_prestamo > 0){
					
					$columnas="id_tipo_creditos='$_id_tipo_creditos',
					tipo_pago_cuenta_bancaria='$_tipo_pago_cuenta_bancaria',
					tipo_participe_datos_prestamo='$_tipo_participe_datos_prestamo',
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
					
					
					if($_id_estado_civil_datos_personales != 1){
							
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
				
				
				$resultConsecutivos=$consecutivos->getBy("nombre_consecutivos='SOLICITUD_PRESTAMOS'");
				$_identificador_consecutivos=$resultConsecutivos[0]->identificador_consecutivos;
				
				$id_usuarios_1=0;
				$id_usuarios_2=0;
				$res1=0;
				$res2=0;
				$id_oficial_credito=0;
				
				if($_id_sucursales == 1){
							
					$resultQuito=$solicitud_prestamo->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Quito'", "id_usuarios");
						
					if(!empty($resultQuito)){
						$i==0;
						foreach ($resultQuito as $res){
							$i++;
							
							if($i==1){
								
								$id_usuarios_1=$res->id_usuarios;
							}elseif ($i==2){
								
								$id_usuarios_2=$res->id_usuarios;
							}
							
						}
					}
					
					
					$resultoficial1=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1'");
					
					if(!empty($resultoficial1)){
						
						$res1=count($resultoficial1);
					}
					
					$resultoficial2=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2'");
					
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
						
					
					
				}else{
					
					$resultGuayaquil=$solicitud_prestamo->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Guayaquil'", "id_usuarios");
						
					if(!empty($resultGuayaquil)){
						$i==0;
						foreach ($resultGuayaquil as $res){
							$i++;
								
							if($i==1){
					
								$id_usuarios_1=$res->id_usuarios;
							}elseif ($i==2){
					
								$id_usuarios_2=$res->id_usuarios;
							}
								
						}
					}
					
					$resultoficial1=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1'");
						
					if(!empty($resultoficial1)){
						$res1=count($resultoficial1);
					}
						
					$resultoficial2=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2'");
						
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
					
					
					
				}
				
				
				
				try {
	
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
								  '$_mode_solicitante',
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
								  '$id_oficial_credito'";
					$solicitud_prestamo->setFuncion($funcion);
					$solicitud_prestamo->setParametros($parametros);
					$resultado=$solicitud_prestamo->Insert();
	
					
					$consecutivos->UpdateBy("identificador_consecutivos = identificador_consecutivos+1", "consecutivos", "nombre_consecutivos = 'SOLICITUD_PRESTAMOS'  ");
					
					
					
				if($_id_estado_civil_datos_personales != 1){
					
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
							$resultado1=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
							}
						}
						
					}
					
			}	
						
				} catch (Exception $e) {
	
					echo "Error al Insertar Solicitud de Prestamo";
    				die();
	
				}
		}
				
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
	
	
	
	
	
	
	public function search(){
	
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
				  sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales AND solicitud_prestamo.id_usuarios_registra='$id_usuarios'";
	
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
				$html.='<section style="height:425px; overflow-y:scroll;">';
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
						
						$estado_tramite='Aprobado';
						
						
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
						
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
					if($aprobado_oficial_credito==1){
						$html.='<td style="font-size: 11px;"></td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					}else{
						$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					}
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
					 
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
		$domLogo=$directorio.'/view/images/lcaprem.png';
		$logo = '<img src="'.$domLogo.'" alt="Responsive image" width="200" height="50">';
		 
		
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
						  solicitud_prestamo.id_usuarios_registra, 
						  solicitud_prestamo.identificador_consecutivos,
						  solicitud_prestamo.tipo_pago_cuenta_bancaria,
						  tipo_creditos.nombre_tipo_creditos
						";
				$tablas=" public.solicitud_prestamo, 
						  public.tipo_creditos,
						  public.provincias, 
						  public.sexo, 
						  public.estado_civil, 
						  public.cantones, 
						  public.parroquias, 
						  public.entidades";
				$where="tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
					  solicitud_prestamo.id_sexo_datos_personales = sexo.id_sexo AND
					  solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
					  solicitud_prestamo.id_provincias_vivienda = provincias.id_provincias AND
					  solicitud_prestamo.id_cantones_vivienda = cantones.id_cantones AND
					  solicitud_prestamo.id_parroquias_vivienda = parroquias.id_parroquias AND
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
					
					// DATOS USUARIO
					$_id_usuarios_registra       					=$resultSoli[0]->id_usuarios_registra;
					$_identificador_consecutivos     				=$resultSoli[0]->identificador_consecutivos;
					
				
				
				
				
				
				
				$html.='<table style="width: 100%;"  border=1 cellspacing=0.0001 >';
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:center; font-size: 18px;"><b>FONDO COMPLEMENTARIO PREVISIONAL CERRADO DE CESANTÍA DE SERVIDORES Y TRABAJADORES PÚBLICOS DE FUERZAS ARMADAS CAPREMCI<br>CRÉDITO '.$_nombre_tipo_creditos.'<br>SOLICITUD DE PRESTAMO N.-<b></th>';
				$html.='</tr>';
				
				$html.='<tr>';
				$html.='<th colspan="12" style="text-align:right; font-size: 13px;"><b>Fecha de Presentación: <b> '.$_fecha_presentacion.'</th>';
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
				
				}else{
					
					
					$html.='<tr>';
						$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
						$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
						$html.='<td colspan="4" style="text-align:left; font-size: 13px;">N/A</td>';
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
				
				}
				
				
				$this->report("SolicitudPrestamo",array( "resultSet"=>$html));
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
	
	
	
	
	

	public function searchadmin(){
	
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
				      solicitud_prestamo.id_usuarios_oficial_credito_aprueba";
	
		$tablas   = "public.solicitud_prestamo,
					  public.entidades,
					  public.sexo,
					  public.estado_civil,
				      public.tipo_creditos,
				public.usuarios";
			
		$where    = "solicitud_prestamo.id_usuarios_oficial_credito_aprueba=usuarios.id_usuarios AND tipo_creditos.id_tipo_creditos=solicitud_prestamo.id_tipo_creditos AND
		solicitud_prestamo.id_estado_civil_datos_personales = estado_civil.id_estado_civil AND
		entidades.id_entidades = solicitud_prestamo.id_entidades AND
		sexo.id_sexo = solicitud_prestamo.id_sexo_datos_personales AND solicitud_prestamo.id_usuarios_oficial_credito_aprueba='$id_usuarios'";
	
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
				$html.='<section style="height:425px; overflow-y:scroll;">';
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
	
						$estado_tramite='Aprobado';
						
						
						
						
					}elseif($aprobado_oficial_credito==1){
						$estado_tramite='Pendiente';
					}
					elseif($aprobado_oficial_credito==3){
						$estado_tramite='Rechazado';
						
						
						
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
					if($aprobado_oficial_credito==1){
					$html.='<td style="font-size: 11px;"></td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index4&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index3&id_solicitud_prestamo_a='.$res->id_solicitud_prestamo.'" class="btn btn-info" style="font-size:65%;"><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=index3&id_solicitud_prestamo_r='.$res->id_solicitud_prestamo.'" class="btn btn-danger" style="font-size:65%;"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
						
					}else{
						$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
						$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-primary" style="font-size:65%;" disabled><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
						$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-danger" style="font-size:65%;" disabled><i class="glyphicon glyphicon-trash"></i></a></span></td>';
						
						
					}
					$html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestamo&action=print&id_solicitud_prestamo='.$res->id_solicitud_prestamo.'" target="_blank" class="btn btn-warning" style="font-size:65%;"><i class="glyphicon glyphicon-print"></i></a></span></td>';
	
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
							solicitud_prestamo.id_sucursales";
						
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
				$_apellidos_solicitante_datos_personales                     = $_POST["apellidos_solicitante_datos_personales"];
				$_nombres_solicitante_datos_personales                       = $_POST["nombres_solicitante_datos_personales"];
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
				$_nombre_propietario_vivienda                                = $_POST["nombre_propietario_vivienda"];
				$_celular_propietario_vivienda                               = $_POST["celular_propietario_vivienda"];
				$_referencia_direccion_domicilio_vivienda                    = $_POST["referencia_direccion_domicilio_vivienda"];
				$_numero_casa_solicitante                                    = $_POST["numero_casa_solicitante"];
				$_numero_celular_solicitante                                 = $_POST["numero_celular_solicitante"];
				$_numero_trabajo_solicitante                                 = $_POST["numero_trabajo_solicitante"];
				$_extension_solicitante                                      = $_POST["extension_solicitante"];
				$_mode_solicitante                                           = $_POST["mode_solicitante"];
				$_apellidos_referencia_personal                              = $_POST["apellidos_referencia_personal"];
				$_nombres_referencia_personal                                = $_POST["nombres_referencia_personal"];
				$_relacion_referencia_personal                               = $_POST["relacion_referencia_personal"];
				$_numero_telefonico_referencia_personal                      = $_POST["numero_telefonico_referencia_personal"];
				$_apellidos_referencia_familiar                              = $_POST["apellidos_referencia_familiar"];
				$_nombres_referencia_familiar                                = $_POST["nombres_referencia_familiar"];
				$_parentesco_referencia_familiar                             = $_POST["parentesco_referencia_familiar"];
				$_numero_telefonico_referencia_familiar                      = $_POST["numero_telefonico_referencia_familiar"];
				$_id_entidades                                               = $_POST["id_entidades"];
				$_id_provincias_asignacion                                   = $_POST["id_provincias_asignacion"];
				$_id_cantones_asignacion                                     = $_POST["id_cantones_asignacion"];
				$_id_parroquias_asignacion                                   = $_POST["id_parroquias_asignacion"];
				$_numero_telefonico_datos_laborales                          = $_POST["numero_telefonico_datos_laborales"];
				$_interseccion_datos_laborales                               = $_POST["interseccion_datos_laborales"];
				$_calle_datos_laborales                                      = $_POST["calle_datos_laborales"];
				$_cargo_actual_datos_laborales                               = $_POST["cargo_actual_datos_laborales"];
	
				$_sueldo_total_info_economica                                = $_POST["sueldo_total_info_economica"];
				$_cuota_prestamo_ordinario_info_economica                    = $_POST["cuota_prestamo_ordinario_info_economica"];
				$_arriendos_info_economica                                   = $_POST["arriendos_info_economica"];
				$_cuota_prestamo_emergente_info_economica                    = $_POST["cuota_prestamo_emergente_info_economica"];
				$_honorarios_profesionales_info_economica                    = $_POST["honorarios_profesionales_info_economica"];
				$_cuota_otros_prestamos_info_economica                       = $_POST["cuota_otros_prestamos_info_economica"];
				$_comisiones_info_economica                                  = $_POST["comisiones_info_economica"];
				$_cuota_prestamo_iess_info_economica                         = $_POST["cuota_prestamo_iess_info_economica"];
				$_horas_suplementarias_info_economica                        = $_POST["horas_suplementarias_info_economica"];
				$_arriendos_egre_info_economica                              = $_POST["arriendos_egre_info_economica"];
				$_alimentacion_info_economica                                = $_POST["alimentacion_info_economica"];
				$_otros_ingresos_1_info_economica                            = $_POST["otros_ingresos_1_info_economica"];
				$_valor_ingresos_1_info_economica                            = $_POST["valor_ingresos_1_info_economica"];
				$_estudios_info_economica                                    = $_POST["estudios_info_economica"];
				$_otros_ingresos_2_info_economica                            = $_POST["otros_ingresos_2_info_economica"];
				$_valor_ingresos_2_info_economica                            = $_POST["valor_ingresos_2_info_economica"];
				$_pago_servicios_basicos_info_economica                      = $_POST["pago_servicios_basicos_info_economica"];
				$_otros_ingresos_3_info_economica                            = $_POST["otros_ingresos_3_info_economica"];
				$_valor_ingresos_3_info_economica                            = $_POST["valor_ingresos_3_info_economica"];
				$_pago_tarjetas_credito_info_economica                       = $_POST["pago_tarjetas_credito_info_economica"];
				$_otros_ingresos_4_info_economica                            = $_POST["otros_ingresos_4_info_economica"];
				$_valor_ingresos_4_info_economica                            = $_POST["valor_ingresos_4_info_economica"];
				$_afiliacion_cooperativas_info_economica                     = $_POST["afiliacion_cooperativas_info_economica"];
				$_otros_ingresos_5_info_economica                            = $_POST["otros_ingresos_5_info_economica"];
				$_valor_ingresos_5_info_economica                            = $_POST["valor_ingresos_5_info_economica"];
				$_ahorro_info_economica                                      = $_POST["ahorro_info_economica"];
				$_otros_ingresos_6_info_economica                            = $_POST["otros_ingresos_6_info_economica"];
				$_valor_ingresos_6_info_economica                            = $_POST["valor_ingresos_6_info_economica"];
				$_impuesto_renta_info_economica                              = $_POST["impuesto_renta_info_economica"];
				$_otros_ingresos_7_info_economica                            = $_POST["otros_ingresos_7_info_economica"];
				$_valor_ingresos_7_info_economica                            = $_POST["valor_ingresos_7_info_economica"];
				$_otros_ingresos_8_info_economica                            = $_POST["otros_ingresos_8_info_economica"];
				$_valor_ingresos_8_info_economica                            = $_POST["valor_ingresos_8_info_economica"];
				$_otros_egresos_1_info_economica                             = $_POST["otros_egresos_1_info_economica"];
				$_valor_egresos_1_info_economica                             = $_POST["valor_egresos_1_info_economica"];
	
				$_total_ingresos_mensuales  = $_sueldo_total_info_economica+$_arriendos_info_economica+$_honorarios_profesionales_info_economica+$_comisiones_info_economica+$_horas_suplementarias_info_economica+$_valor_ingresos_1_info_economica+$_valor_ingresos_2_info_economica+$_valor_ingresos_3_info_economica+$_valor_ingresos_4_info_economica+$_valor_ingresos_5_info_economica+$_valor_ingresos_6_info_economica+$_valor_ingresos_7_info_economica+$_valor_ingresos_8_info_economica;
				$_total_egresos_mensuales   = $_cuota_prestamo_ordinario_info_economica+$_cuota_prestamo_emergente_info_economica+$_cuota_otros_prestamos_info_economica+$_cuota_prestamo_iess_info_economica+$_arriendos_egre_info_economica+$_alimentacion_info_economica+$_estudios_info_economica+$_pago_servicios_basicos_info_economica+$_pago_tarjetas_credito_info_economica+$_afiliacion_cooperativas_info_economica+$_ahorro_info_economica+$_impuesto_renta_info_economica+$_valor_egresos_1_info_economica;
	
				$_numero_cedula_conyuge                                      = $_POST["numero_cedula_conyuge"];
				$_apellidos_conyuge                                          = $_POST["apellidos_conyuge"];
				$_nombres_conyuge                                            = $_POST["nombres_conyuge"];
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
	
				$_id_solicitud_prestamo                               = $_POST["id_solicitud_prestamo"];
				$_tipo_pago_cuenta_bancaria                           = $_POST["tipo_pago_cuenta_bancaria"];
	
				
				if($_id_solicitud_prestamo > 0){
						
					$columnas="id_tipo_creditos='$_id_tipo_creditos',
					tipo_pago_cuenta_bancaria='$_tipo_pago_cuenta_bancaria',
					tipo_participe_datos_prestamo='$_tipo_participe_datos_prestamo',
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
						
						
					if($_id_estado_civil_datos_personales != 1){
							
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
	
	
	
	
	
	
	
	
}
?>