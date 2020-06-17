<?php

class SolicitudHipotecarioController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    //maycol
    
    public function index(){
        
        session_start();
        
   
        
        if (isset($_SESSION['nombre_usuarios']))
        {
            $Solicitudhipotecario = new SolicitudHipotecarioModel();
            
            
            $sucursales = new SucursalesModel();
            $resultSucursales= $sucursales->getAll("nombre_sucursales");
            
            
            $genero = new SexoModel();
            $resultGenero= $genero->getAll("nombre_sexo");
            
            
            $estado_civil = new Estado_civilModel();
            $resultEstadoCivil = $estado_civil->getBy("nombre_estado_civil<>'Ninguna' ");
            
            $provincias = new ProvinciasModel();
            $resultProvincias= $provincias->getAll("nombre_provincias");
            
            $cantones = new CantonesModel();
            $resultCantones= $cantones->getAll("nombre_cantones");
            
            
            $parroquias = new ParroquiasModel();
            $resultParroquias= $parroquias->getAll("nombre_parroquias");
            
            $banco = new BancosModel();
            $resultBancos= $banco->getAll("nombre_bancos");
            
            $institucion = new InstitucionModel();
            $resultInstitucion= $institucion->getAll("nombre_entidades");
            
            
            
            $nombre_controladores = "SolicitudHipotecario";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $Solicitudhipotecario->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
                $cedula = array();
                $nombres = array();
                $correo = array();
                $cedula_usuarios = $_SESSION['cedula_usuarios'];
                array_push($cedula, $cedula_usuarios);
                $nombres_usuarios=$_SESSION['nombre_usuarios'];
                array_push($nombres, $nombres_usuarios);
                $correo_usuarios=$_SESSION['correo_usuarios'];
                array_push($correo, $correo_usuarios);
                
                
                
                $resultEdit="";
                
                if(isset($_GET["id_solicitud_hipotecario"])){
                    
                    $_id_solicitud_hipotecario= $_GET["id_solicitud_hipotecario"];
                    
                    $columnas="solicitud_hipotecario.*,
                            codigo_verificacion.id_codigo_verificacion,
                            codigo_verificacion.numero_codigo_verificacion";
                    
                    $tablas="public.solicitud_hipotecario, public.codigo_verificacion";
                    $where="solicitud_hipotecario.id_codigo_verificacion= codigo_verificacion.id_codigo_verificacion AND solicitud_hipotecario.id_solicitud_hipotecario='$_id_solicitud_hipotecario'";
                    $id="solicitud_hipotecario.id_solicitud_hipotecario";
                    $resultEdit=$Solicitudhipotecario->getCondiciones($columnas, $tablas, $where, $id);
                    
                    
                    $this->view("SolicitudHipotecario",array(
                        "resultEdit"=>$resultEdit, "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo,
                        "resultSucursales"=>$resultSucursales, "resultGenero"=>$resultGenero, "resultEstadoCivil"=>$resultEstadoCivil, "resultProvincias"=>$resultProvincias,
                        "resultCantones"=>$resultCantones, "resultParroquias"=>$resultParroquias, "resultBancos"=>$resultBancos, "resultInstitucion"=>$resultInstitucion
                    ));
                    
                    die();
                    
                }
                
                
                if(isset($_GET["solicitud"])){
                    
                    
                    
                    $this->view("SolicitudHipotecario",array(
                        
                        "resultEdit"=>$resultEdit, "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo,
                        "resultSucursales"=>$resultSucursales, "resultGenero"=>$resultGenero, "resultEstadoCivil"=>$resultEstadoCivil, "resultProvincias"=>$resultProvincias,
                        "resultCantones"=>$resultCantones, "resultParroquias"=>$resultParroquias, "resultBancos"=>$resultBancos, "resultInstitucion"=>$resultInstitucion
                    ));
                    
                    die();
                    
                }
                
                $error_deudor="Permitir";
                $_id_usuarios= $_SESSION["id_usuarios"];
                
                
                $result=$Solicitudhipotecario->getCondiciones("max(id_solicitud_hipotecario) as id_solicitud_hipotecario, id_usuarios_registra", "solicitud_hipotecario",
                    "(id_estado_tramites=1 OR id_estado_tramites=4)  AND  id_usuarios_registra='$_id_usuarios' GROUP BY id_usuarios_registra", "id_usuarios_registra");
                
                if(!empty($result)){
                    
                    $_id_solicitud_hipotecario=$result[0]->id_solicitud_hipotecario;
                    
                    $resulEsta=$Solicitudhipotecario->getBy("id_solicitud_hipotecario='$_id_solicitud_hipotecario'");
                    
                    if(!empty($resulEsta)){
                        
                        
                        $_id_estado_tramites=$resulEsta[0]->id_estado_tramites;
                        
                        
                        if($_id_estado_tramites==1 || $_id_estado_tramites==4){
                            
                            $error_deudor="NoPermitir";
                        }else{
                            $error_deudor="Permitir";
                        }
                        
                        
                    }
                    
                    
                }
                
                
                
                $this->view("SolicitudHipotecarioSeleccion",array(
                    
                    "error_deudor"=>$error_deudor    ));
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a Solicitud Hipotecario"
                    
                ));
                
                exit();
            }
            
        }
        else{
            
            $this->redirect("Usuarios","sesion_caducada");
            
        }
        
    }
    


    
    
    public function EnviarSMS(){
        
        session_start();
        $solicitud_hipotecario = new SolicitudHipotecarioModel();
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
        $_celular_hipotecario_prestaciones =(isset($_POST['celular_datos_personales'])) ? $_POST['celular_datos_personales'] : '';
        
        
        if(!empty($_celular_hipotecario_prestaciones)){
            
            
            
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
                    
                    $cadena_recortada=$this->comsumir_mensaje_plus($_celular_hipotecario_prestaciones, $nombre_usuarios, $codigo);
                    
                    
                    
                    if($cadena_recortada=='100'){
                        
                        $funcion = "ins_codigo_verificacion";
                        $parametros = " '$_id_usuarios','$codigo', '$_celular_hipotecario_prestaciones'";
                        $codigo_verificacion->setFuncion($funcion);
                        $codigo_verificacion->setParametros($parametros);
                        $resultado=$codigo_verificacion->llamafuncionPG();
                        
                        $mensaje_retorna="Enviado Correctamente";
                        
                    }else if ($cadena_recortada=='101'){
                        
                        
                        $funcion = "ins_codigo_verificacion";
                        $parametros = " '$_id_usuarios','$codigo', '$_celular_hipotecario_prestaciones'";
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
    

    
    
    public function InsertaSolicitudPrestamo(){
        
        
        
        session_start();
        
        if (isset($_SESSION['nombre_usuarios']))
        {
            
            $usuarios = new UsuariosModel();
            $solicitud_hipotecario = new SolicitudHipotecarioModel();
            $consecutivos = new ConsecutivosModel();
            
            $_identificador_consecutivos = 0;
            $_total_activos_corrientes   = 0;
            $_total_activos_fijos       = 0;
            $_total_activos            =    0;
            $_total_pasivos_corrientes =  0;
            $_total_pasivos_largo_plazo =0;
            $_total_pasivos    =  0;
            $_total_ingresos_mensuales =0;
            $_total_gastos_mensuales  = 0;
            
           
            
            
            $_id_solicitud_hipotecario =(isset($_POST['id_solicitud_hipotecario'])) ? $_POST['id_solicitud_hipotecario'] : 0;
            $_valor_dolares_datos_credito =(isset($_REQUEST['valor_dolares_datos_credito'])&& $_REQUEST['valor_dolares_datos_credito'] !=NULL)?$_REQUEST['valor_dolares_datos_credito']:0;
            $_plazo_meses_datos_credito =(isset($_REQUEST['plazo_meses_datos_credito'])&& $_REQUEST['plazo_meses_datos_credito'] !=NULL)?$_REQUEST['plazo_meses_datos_credito']:'';
            $_destino_dinero_datos_credito =(isset($_REQUEST['destino_dinero_datos_credito'])&& $_REQUEST['destino_dinero_datos_credito'] !=NULL)?$_REQUEST['destino_dinero_datos_credito']:'';
            $_nombres_datos_personales=(isset($_REQUEST['nombres_datos_personales'])&& $_REQUEST['nombres_datos_personales'] !=NULL)?$_REQUEST['nombres_datos_personales']:'';
            $_apellidos_datos_personales =(isset($_REQUEST['apellidos_datos_personales'])&& $_REQUEST['apellidos_datos_personales'] !=NULL)?$_REQUEST['apellidos_datos_personales']:'';
            $_cedula_datos_personales =(isset($_REQUEST['cedula_datos_personales'])&& $_REQUEST['cedula_datos_personales'] !=NULL)?$_REQUEST['cedula_datos_personales']:'';
            $_id_sexo =(isset($_REQUEST['id_sexo'])&& $_REQUEST['id_sexo'] !=NULL)?$_REQUEST['id_sexo']:0;
            $_fecha_nacimiento_datos_personales =(isset($_REQUEST['fecha_nacimiento_datos_personales'])&& $_REQUEST['fecha_nacimiento_datos_personales'] !=NULL)?$_REQUEST['fecha_nacimiento_datos_personales']:'';
            $_id_estado_civil =(isset($_REQUEST['id_estado_civil'])&& $_REQUEST['id_estado_civil'] !=NULL)?$_REQUEST['id_estado_civil']:0;
            $_separacion_bienes_datos_personales =(isset($_REQUEST['separacion_bienes_datos_personales'])&& $_REQUEST['separacion_bienes_datos_personales'] !=NULL)?$_REQUEST['separacion_bienes_datos_personales']:'';
            $_cargas_familiares_datos_personales =(isset($_REQUEST['cargas_familiares_datos_personales'])&& $_REQUEST['cargas_familiares_datos_personales'] !=NULL)?$_REQUEST['cargas_familiares_datos_personales']:'';
            $_numero_hijos_datos_personales =(isset($_REQUEST['numero_hijos_datos_personales'])&& $_REQUEST['numero_hijos_datos_personales'] !=NULL)?$_REQUEST['numero_hijos_datos_personales']:'';
            $_id_provincia =(isset($_REQUEST['id_provincia'])&& $_REQUEST['id_provincia'] !=NULL)?$_REQUEST['id_provincia']:0;
            $_id_canton=(isset($_REQUEST['id_canton'])&& $_REQUEST['id_canton'] !=NULL)?$_REQUEST['id_canton']:0;
            $_id_parroquia =(isset($_REQUEST['id_parroquia'])&& $_REQUEST['id_parroquia'] !=NULL)?$_REQUEST['id_parroquia']:0;
            $_barrio_datos_personales =(isset($_REQUEST['barrio_datos_personales'])&& $_REQUEST['barrio_datos_personales'] !=NULL)?$_REQUEST['barrio_datos_personales']:'';
            $_ciudadela_datos_personales =(isset($_REQUEST['ciudadela_datos_personales'])&& $_REQUEST['ciudadela_datos_personales'] !=NULL)?$_REQUEST['ciudadela_datos_personales']:'';
            $_calle_datos_personalescharacter =(isset($_REQUEST['calle_datos_personalescharacter'])&& $_REQUEST['calle_datos_personalescharacter'] !=NULL)?$_REQUEST['calle_datos_personalescharacter']:'';
            $_numero_calle_datos_personales =(isset($_REQUEST['numero_calle_datos_personales'])&& $_REQUEST['numero_calle_datos_personales'] !=NULL)?$_REQUEST['numero_calle_datos_personales']:'';
            $_interseccion_datos_personales =(isset($_REQUEST['interseccion_datos_personales'])&& $_REQUEST['interseccion_datos_personales'] !=NULL)?$_REQUEST['interseccion_datos_personales']:'';
            $_tipo_vivienda_datos_personales =(isset($_REQUEST['tipo_vivienda_datos_personales'])&& $_REQUEST['tipo_vivienda_datos_personales'] !=NULL)?$_REQUEST['tipo_vivienda_datos_personales']:'';
            $_vivienda_hipotecada_datos_personales =(isset($_REQUEST['vivienda_hipotecada_datos_personales'])&& $_REQUEST['vivienda_hipotecada_datos_personales'] !=NULL)?$_REQUEST['vivienda_hipotecada_datos_personales']:'';
            $_tiempo_residencia_datos_personales =(isset($_REQUEST['tiempo_residencia_datos_personales'])&& $_REQUEST['tiempo_residencia_datos_personales'] !=NULL)?$_REQUEST['tiempo_residencia_datos_personales']:'';
            $_referencia_domiciliaria_datos_perdonales =(isset($_REQUEST['referencia_domiciliaria_datos_perdonales'])&& $_REQUEST['referencia_domiciliaria_datos_perdonales'] !=NULL)?$_REQUEST['referencia_domiciliaria_datos_perdonales']:'';
            $_nombre_arrendatario_datos_personales =(isset($_REQUEST['nombre_arrendatario_datos_personales'])&& $_REQUEST['nombre_arrendatario_datos_personales'] !=NULL)?$_REQUEST['nombre_arrendatario_datos_personales']:'';
            $_apellido_arrendatario_datos_personales =(isset($_REQUEST['apellido_arrendatario_datos_personales'])&& $_REQUEST['apellido_arrendatario_datos_personales'] !=NULL)?$_REQUEST['apellido_arrendatario_datos_personales']:'';
            $_celular_arrendatario_datos_personales =(isset($_REQUEST['celular_arrendatario_datos_personales'])&& $_REQUEST['celular_arrendatario_datos_personales'] !=NULL)?$_REQUEST['celular_arrendatario_datos_personales']:'';
            $_telefono_datos_personales =(isset($_REQUEST['telefono_datos_personales'])&& $_REQUEST['telefono_datos_personales'] !=NULL)?$_REQUEST['telefono_datos_personales']:'';
            $_celular_datos_personales =(isset($_REQUEST['celular_datos_personales'])&& $_REQUEST['celular_datos_personales'] !=NULL)?$_REQUEST['celular_datos_personales']:'';
            $_telf_trabajo_datos_personales =(isset($_REQUEST['telf_trabajo_datos_personales'])&& $_REQUEST['telf_trabajo_datos_personales'] !=NULL)?$_REQUEST['telf_trabajo_datos_personales']:'';
            $_ext_telef_datos_personales =(isset($_REQUEST['ext_telef_datos_personales'])&& $_REQUEST['ext_telef_datos_personales'] !=NULL)?$_REQUEST['ext_telef_datos_personales']:'';
            $_node_telef_datos_personales=(isset($_REQUEST['node_telef_datos_personales'])&& $_REQUEST['node_telef_datos_personales'] !=NULL)?$_REQUEST['node_telef_datos_personales']:'';
            $_email_datos_personales =(isset($_REQUEST['email_datos_personales'])&& $_REQUEST['email_datos_personales'] !=NULL)?$_REQUEST['email_datos_personales']:'';
            $_nivel_educativo_datos_personales =(isset($_REQUEST['nivel_educativo_datos_personales'])&& $_REQUEST['nivel_educativo_datos_personales'] !=NULL)?$_REQUEST['nivel_educativo_datos_personales']:'';
            $_nombres_referencia_familiar_datos_personales=(isset($_REQUEST['nombres_referencia_familiar_datos_personales'])&& $_REQUEST['nombres_referencia_familiar_datos_personales'] !=NULL)?$_REQUEST['nombres_referencia_familiar_datos_personales']:'';
            $_apellidos_referencia_familiar_datos_personales =(isset($_REQUEST['apellidos_referencia_familiar_datos_personales'])&& $_REQUEST['apellidos_referencia_familiar_datos_personales'] !=NULL)?$_REQUEST['apellidos_referencia_familiar_datos_personales']:'';
            $_parentesco_referencia_familiar_datos_personales =(isset($_REQUEST['parentesco_referencia_familiar_datos_personales'])&& $_REQUEST['parentesco_referencia_familiar_datos_personales'] !=NULL)?$_REQUEST['parentesco_referencia_familiar_datos_personales']:'';
            $_primer_telefono_ref_familiar_datos_personales =(isset($_REQUEST['primer_telefono_ref_familiar_datos_personales'])&& $_REQUEST['primer_telefono_ref_familiar_datos_personales'] !=NULL)?$_REQUEST['primer_telefono_ref_familiar_datos_personales']:'';
            $_segundo_telefono_ref_familiar_datos_personales =(isset($_REQUEST['segundo_telefono_ref_familiar_datos_personales'])&& $_REQUEST['segundo_telefono_ref_familiar_datos_personales'] !=NULL)?$_REQUEST['segundo_telefono_ref_familiar_datos_personales']:'';
            $_nombres_referencia_personal_datos_personales =(isset($_REQUEST['nombres_referencia_personal_datos_personales'])&& $_REQUEST['nombres_referencia_personal_datos_personales'] !=NULL)?$_REQUEST['nombres_referencia_personal_datos_personales']:'';
            $_apellidos_referencia_personal_datos_personales=(isset($_REQUEST['apellidos_referencia_personal_datos_personales'])&& $_REQUEST['apellidos_referencia_personal_datos_personales'] !=NULL)?$_REQUEST['apellidos_referencia_personal_datos_personales']:'';
            $_relacion_referencia_personal_datos_personales =(isset($_REQUEST['relacion_referencia_personal_datos_personales'])&& $_REQUEST['relacion_referencia_personal_datos_personales'] !=NULL)?$_REQUEST['relacion_referencia_personal_datos_personales']:'';
            $_primer_telefono_ref_personal_datos_personales =(isset($_REQUEST['primer_telefono_ref_personal_datos_personales'])&& $_REQUEST['primer_telefono_ref_personal_datos_personales'] !=NULL)?$_REQUEST['primer_telefono_ref_personal_datos_personales']:'';
            $_segundo_telefono_ref_personal_datos_personales =(isset($_REQUEST['segundo_telefono_ref_personal_datos_personales'])&& $_REQUEST['segundo_telefono_ref_personal_datos_personales'] !=NULL)?$_REQUEST['segundo_telefono_ref_personal_datos_personales']:'';
            $_id_entidades =(isset($_REQUEST['id_entidades'])&& $_REQUEST['id_entidades'] !=NULL)?$_REQUEST['id_entidades']:0;
            $_reparto_unidad_datos_laborales =(isset($_REQUEST['reparto_unidad_datos_laborales'])&& $_REQUEST['reparto_unidad_datos_laborales'] !=NULL)?$_REQUEST['reparto_unidad_datos_laborales']:'';
            $_seccion_datos_laborales =(isset($_REQUEST['seccion_datos_laborales'])&& $_REQUEST['seccion_datos_laborales'] !=NULL)?$_REQUEST['seccion_datos_laborales']:'';
            $_nombres_jefe_datos_laborales =(isset($_REQUEST['nombres_jefe_datos_laborales'])&& $_REQUEST['nombres_jefe_datos_laborales'] !=NULL)?$_REQUEST['nombres_jefe_datos_laborales']:'';
            $_apellidos_jefe_datos_laborales =(isset($_REQUEST['apellidos_jefe_datos_laborales'])&& $_REQUEST['apellidos_jefe_datos_laborales'] !=NULL)?$_REQUEST['apellidos_jefe_datos_laborales']:'';
            $_telefono_jefe_datos_laborales =(isset($_REQUEST['telefono_jefe_datos_laborales'])&& $_REQUEST['telefono_jefe_datos_laborales'] !=NULL)?$_REQUEST['telefono_jefe_datos_laborales']:'';
            $_id_provincia_datos_laborales =(isset($_REQUEST['id_provincia_datos_laborales'])&& $_REQUEST['id_provincia_datos_laborales'] !=NULL)?$_REQUEST['id_provincia_datos_laborales']:0;
            $_id_canton_datos_laborales =(isset($_REQUEST['id_canton_datos_laborales'])&& $_REQUEST['id_canton_datos_laborales'] !=NULL)?$_REQUEST['id_canton_datos_laborales']:0;
            $_id_parroquia_datos_laborales =(isset($_REQUEST['id_parroquia_datos_laborales'])&& $_REQUEST['id_parroquia_datos_laborales'] !=NULL)?$_REQUEST['id_parroquia_datos_laborales']:0;
            $_calle_datos_laborales =(isset($_REQUEST['calle_datos_laborales'])&& $_REQUEST['calle_datos_laborales'] !=NULL)?$_REQUEST['calle_datos_laborales']:'';
            $_numero_calle_datos_laborales =(isset($_REQUEST['numero_calle_datos_laborales'])&& $_REQUEST['numero_calle_datos_laborales'] !=NULL)?$_REQUEST['numero_calle_datos_laborales']:'';
            $_interseccion_datos_laborales =(isset($_REQUEST['interseccion_datos_laborales'])&& $_REQUEST['interseccion_datos_laborales'] !=NULL)?$_REQUEST['interseccion_datos_laborales']:'';
            $_referencia_direccion_trabajo_datos_laborales =(isset($_REQUEST['referencia_direccion_trabajo_datos_laborales'])&& $_REQUEST['referencia_direccion_trabajo_datos_laborales'] !=NULL)?$_REQUEST['referencia_direccion_trabajo_datos_laborales']:'';
            $_cargo_actual_datos_laborales=(isset($_REQUEST['cargo_actual_datos_laborales'])&& $_REQUEST['cargo_actual_datos_laborales'] !=NULL)?$_REQUEST['cargo_actual_datos_laborales']:'';
            $_anios_servicio_datos_laborales =(isset($_REQUEST['anios_servicio_datos_laborales'])&& $_REQUEST['anios_servicio_datos_laborales'] !=NULL)?$_REQUEST['anios_servicio_datos_laborales']:'';
            $_nombres_datos_conyuge =(isset($_REQUEST['nombres_datos_conyuge'])&& $_REQUEST['nombres_datos_conyuge'] !=NULL)?$_REQUEST['nombres_datos_conyuge']:'';
            $_apellidos_datos_conyuge =(isset($_REQUEST['apellidos_datos_conyuge'])&& $_REQUEST['apellidos_datos_conyuge'] !=NULL)?$_REQUEST['apellidos_datos_conyuge']:'';
            $_cedula_datos_conyuge =(isset($_REQUEST['cedula_datos_conyuge'])&& $_REQUEST['cedula_datos_conyuge'] !=NULL)?$_REQUEST['cedula_datos_conyuge']:'';
            $_id_sexo_datos_conyuge =(isset($_REQUEST['id_sexo_datos_conyuge'])&& $_REQUEST['id_sexo_datos_conyuge'] !=0)?$_REQUEST['id_sexo_datos_conyuge']:'null';
            $_fecha_nacimiento_datos_conyuge =(isset($_REQUEST['fecha_nacimiento_datos_conyuge'])&& $_REQUEST['fecha_nacimiento_datos_conyuge'] !="")?$_REQUEST['fecha_nacimiento_datos_conyuge']:'null';
            $_vive_residencia_datos_conyuge =(isset($_REQUEST['vive_residencia_datos_conyuge'])&& $_REQUEST['vive_residencia_datos_conyuge'] !=NULL)?$_REQUEST['vive_residencia_datos_conyuge']:'';
            $_celular_datos_conyuge =(isset($_REQUEST['celular_datos_conyuge'])&& $_REQUEST['celular_datos_conyuge'] !=NULL)?$_REQUEST['celular_datos_conyuge']:'';
            $_telefono_datos_conyuge =(isset($_REQUEST['telefono_datos_conyuge'])&& $_REQUEST['telefono_datos_conyuge'] !=NULL)?$_REQUEST['telefono_datos_conyuge']:'';
            $_id_provincia_datos_conyuge =(isset($_REQUEST['id_provincia_datos_conyuge'])&& $_REQUEST['id_provincia_datos_conyuge'] !=0)?$_REQUEST['id_provincia_datos_conyuge']:'null';
            $_id_canton_datos_conyuge =(isset($_REQUEST['id_canton_datos_conyuge'])&& $_REQUEST['id_canton_datos_conyuge'] !=0)?$_REQUEST['id_canton_datos_conyuge']:'null';
            $_id_parroquia_datos_conyuge =(isset($_REQUEST['id_parroquia_datos_conyuge'])&& $_REQUEST['id_parroquia_datos_conyuge'] !=0)?$_REQUEST['id_parroquia_datos_conyuge']:'null';
            $_barrio_datos_conyuge =(isset($_REQUEST['barrio_datos_conyuge'])&& $_REQUEST['barrio_datos_conyuge'] !=NULL)?$_REQUEST['barrio_datos_conyuge']:'';
            $_ciudadela_datos_conyuge =(isset($_REQUEST['ciudadela_datos_conyuge'])&& $_REQUEST['ciudadela_datos_conyuge'] !=NULL)?$_REQUEST['ciudadela_datos_conyuge']:'';
            $_calle_datos_conyuge =(isset($_REQUEST['calle_datos_conyuge'])&& $_REQUEST['calle_datos_conyuge'] !=NULL)?$_REQUEST['calle_datos_conyuge']:'';
            $_numero_calle_datos_conyuge =(isset($_REQUEST['numero_calle_datos_conyuge'])&& $_REQUEST['numero_calle_datos_conyuge'] !=NULL)?$_REQUEST['numero_calle_datos_conyuge']:'';
            $_interseccion_datos_conyuge =(isset($_REQUEST['interseccion_datos_conyuge'])&& $_REQUEST['interseccion_datos_conyuge'] !=NULL)?$_REQUEST['interseccion_datos_conyuge']:'';
            $_actividad_economica_datos_conyuge=(isset($_REQUEST['actividad_economica_datos_conyuge'])&& $_REQUEST['actividad_economica_datos_conyuge'] !=NULL)?$_REQUEST['actividad_economica_datos_conyuge']:'';
            $_empresa_datos_conyuge =(isset($_REQUEST['empresa_datos_conyuge'])&& $_REQUEST['empresa_datos_conyuge'] !=NULL)?$_REQUEST['empresa_datos_conyuge']:'';
            $_naturaleza_negocio_datos_conyuge =(isset($_REQUEST['naturaleza_negocio_datos_conyuge'])&& $_REQUEST['naturaleza_negocio_datos_conyuge'] !=NULL)?$_REQUEST['naturaleza_negocio_datos_conyuge']:'';
            $_cargo_datos_conyuge =(isset($_REQUEST['cargo_datos_conyuge'])&& $_REQUEST['cargo_datos_conyuge'] !=NULL)?$_REQUEST['cargo_datos_conyuge']:'';
            $_tipo_contrato_datos_conyuge =(isset($_REQUEST['tipo_contrato_datos_conyuge'])&& $_REQUEST['tipo_contrato_datos_conyuge'] !=NULL)?$_REQUEST['tipo_contrato_datos_conyuge']:'';
            $_anios_laborados_datos_conyuge =(isset($_REQUEST['anios_laborados_datos_conyuge'])&& $_REQUEST['anios_laborados_datos_conyuge'] !=NULL)?$_REQUEST['anios_laborados_datos_conyuge']:'';
            $_nombres_jefe_datos_conyuge =(isset($_REQUEST['nombres_jefe_datos_conyuge'])&& $_REQUEST['nombres_jefe_datos_conyuge'] !=NULL)?$_REQUEST['nombres_jefe_datos_conyuge']:'';
            $_apellidos_jefe_datos_conyuge =(isset($_REQUEST['apellidos_jefe_datos_conyuge'])&& $_REQUEST['apellidos_jefe_datos_conyuge'] !=NULL)?$_REQUEST['apellidos_jefe_datos_conyuge']:'';
            $_telefono_jefe_datos_conyuge =(isset($_REQUEST['telefono_jefe_datos_conyuge'])&& $_REQUEST['telefono_jefe_datos_conyuge'] !=NULL)?$_REQUEST['telefono_jefe_datos_conyuge']:'';
            $_id_provincia_trabajo_datos_conyuge =(isset($_REQUEST['id_provincia_trabajo_datos_conyuge'])&& $_REQUEST['id_provincia_trabajo_datos_conyuge'] !=0)?$_REQUEST['id_provincia_trabajo_datos_conyuge']:'null';
            $_id_canton_trabajo_datos_conyuge =(isset($_REQUEST['id_canton_trabajo_datos_conyuge'])&& $_REQUEST['id_canton_trabajo_datos_conyuge'] !=0)?$_REQUEST['id_canton_trabajo_datos_conyuge']:'null';
            $_id_parroquia_trabajo_datos_conyuge =(isset($_REQUEST['id_parroquia_trabajo_datos_conyuge'])&& $_REQUEST['id_parroquia_trabajo_datos_conyuge'] !=0)?$_REQUEST['id_parroquia_trabajo_datos_conyuge']:'null';
            $_calle_trabajo_datos_conyuge =(isset($_REQUEST['calle_trabajo_datos_conyuge'])&& $_REQUEST['calle_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['calle_trabajo_datos_conyuge']:'';
            $_nuemero_calle_trabajo_datos_conyuge =(isset($_REQUEST['nuemero_calle_trabajo_datos_conyuge'])&& $_REQUEST['nuemero_calle_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['nuemero_calle_trabajo_datos_conyuge']:'';
            $_interseccion_trabajo_datos_conyuge =(isset($_REQUEST['interseccion_trabajo_datos_conyuge'])&& $_REQUEST['interseccion_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['interseccion_trabajo_datos_conyuge']:'';
            $_referencia_trabajo_datos_conyuge =(isset($_REQUEST['referencia_trabajo_datos_conyuge'])&& $_REQUEST['referencia_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['referencia_trabajo_datos_conyuge']:'';
            $_actividad_principal_datos_independientes =(isset($_REQUEST['actividad_principal_datos_independientes'])&& $_REQUEST['actividad_principal_datos_independientes'] !=NULL)?$_REQUEST['actividad_principal_datos_independientes']:'';
            $_ruc_datos_independientes =(isset($_REQUEST['ruc_datos_independientes'])&& $_REQUEST['ruc_datos_independientes'] !=NULL)?$_REQUEST['ruc_datos_independientes']:'';
            $_detalle_actividades_datos_independientes =(isset($_REQUEST['detalle_actividades_datos_independientes'])&& $_REQUEST['detalle_actividades_datos_independientes'] !=NULL)?$_REQUEST['detalle_actividades_datos_independientes']:'';
            $_local_datos_independientes =(isset($_REQUEST['local_datos_independientes'])&& $_REQUEST['local_datos_independientes'] !=NULL)?$_REQUEST['local_datos_independientes']:'';
            $_nombres_propietario_datos_independientes =(isset($_REQUEST['nombres_propietario_datos_independientes'])&& $_REQUEST['nombres_propietario_datos_independientes'] !=NULL)?$_REQUEST['nombres_propietario_datos_independientes']:'';
            $_apellidos_propietario_datos_independientes =(isset($_REQUEST['apellidos_propietario_datos_independientes'])&& $_REQUEST['apellidos_propietario_datos_independientes'] !=NULL)?$_REQUEST['apellidos_propietario_datos_independientes']:'';
            $_telefono_propietario_datos_independientes =(isset($_REQUEST['telefono_propietario_datos_independientes'])&& $_REQUEST['telefono_propietario_datos_independientes'] !=NULL)?$_REQUEST['telefono_propietario_datos_independientes']:'';
            $_tiempo_funcionamiento_datos_independientes =(isset($_REQUEST['tiempo_funcionamiento_datos_independientes'])&& $_REQUEST['tiempo_funcionamiento_datos_independientes'] !=NULL)?$_REQUEST['tiempo_funcionamiento_datos_independientes']:'';
            $_numero_patronal_datos_independientes =(isset($_REQUEST['numero_patronal_datos_independientes'])&& $_REQUEST['numero_patronal_datos_independientes'] !=NULL)?$_REQUEST['numero_patronal_datos_independientes']:'';
            $_numero_empleados_datos_independientes=(isset($_REQUEST['numero_empleados_datos_independientes'])&& $_REQUEST['numero_empleados_datos_independientes'] !=NULL)?$_REQUEST['numero_empleados_datos_independientes']:'';
            $_id_bancos_referencia_bancaria =(isset($_REQUEST['id_bancos_referencia_bancaria'])&& $_REQUEST['id_bancos_referencia_bancaria'] !=0)?$_REQUEST['id_bancos_referencia_bancaria']:'null';
            $_tipo_cuenta_referencia_bancaria =(isset($_REQUEST['tipo_cuenta_referencia_bancaria'])&& $_REQUEST['tipo_cuenta_referencia_bancaria'] !=NULL)?$_REQUEST['tipo_cuenta_referencia_bancaria']:'';
            $_numero_cuenta_referencia_bancaria =(isset($_REQUEST['numero_cuenta_referencia_bancaria'])&& $_REQUEST['numero_cuenta_referencia_bancaria'] !=NULL)?$_REQUEST['numero_cuenta_referencia_bancaria']:'';
            $_id_bancos_uno_datos_economicos =(isset($_REQUEST['id_bancos_uno_datos_economicos'])&& $_REQUEST['id_bancos_uno_datos_economicos'] !=0)?$_REQUEST['id_bancos_uno_datos_economicos']:'null';
            $_tipo_cuenta_uno_datos_economicos =(isset($_REQUEST['tipo_cuenta_uno_datos_economicos'])&& $_REQUEST['tipo_cuenta_uno_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_uno_datos_economicos']:'';
            $_numero_cuenta_uno_datos_economicos =(isset($_REQUEST['numero_cuenta_uno_datos_economicos'])&& $_REQUEST['numero_cuenta_uno_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_uno_datos_economicos']:'';
            $_id_bancos_dos_datos_economicos =(isset($_REQUEST['id_bancos_dos_datos_economicos'])&& $_REQUEST['id_bancos_dos_datos_economicos'] !=0)?$_REQUEST['id_bancos_dos_datos_economicos']:'null';
            $_tipo_cuenta_dos_datos_economicos =(isset($_REQUEST['tipo_cuenta_dos_datos_economicos'])&& $_REQUEST['tipo_cuenta_dos_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_dos_datos_economicos']:'';
            $_numero_cuenta_dos_datos_economicos =(isset($_REQUEST['numero_cuenta_dos_datos_economicos'])&& $_REQUEST['numero_cuenta_dos_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_dos_datos_economicos']:'';
            $_id_bancos_tres_datos_economicos =(isset($_REQUEST['id_bancos_tres_datos_economicos'])&& $_REQUEST['id_bancos_tres_datos_economicos'] !=0)?$_REQUEST['id_bancos_tres_datos_economicos']:'null';
            $_tipo_cuenta_tres_datos_economicos =(isset($_REQUEST['tipo_cuenta_tres_datos_economicos'])&& $_REQUEST['tipo_cuenta_tres_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_tres_datos_economicos']:'';
            $_numero_cuenta_tres_datos_economicos =(isset($_REQUEST['numero_cuenta_tres_datos_economicos'])&& $_REQUEST['numero_cuenta_tres_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_tres_datos_economicos']:'';
            $_id_bancos_cuatro_datos_economicos =(isset($_REQUEST['id_bancos_cuatro_datos_economicos'])&& $_REQUEST['id_bancos_cuatro_datos_economicos'] !=0)?$_REQUEST['id_bancos_cuatro_datos_economicos']:'null';
            $_tipo_cuenta_cuatro_datos_economicos =(isset($_REQUEST['tipo_cuenta_cuatro_datos_economicos'])&& $_REQUEST['tipo_cuenta_cuatro_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_cuatro_datos_economicos']:'';
            $_numero_cuenta_cuatro_datos_economicos =(isset($_REQUEST['numero_cuenta_cuatro_datos_economicos'])&& $_REQUEST['numero_cuenta_cuatro_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_cuatro_datos_economicos']:'';
            $_empresa_uno_datos_economicos =(isset($_REQUEST['empresa_uno_datos_economicos'])&& $_REQUEST['empresa_uno_datos_economicos'] !=NULL)?$_REQUEST['empresa_uno_datos_economicos']:'';
            $_direccion_uno_datos_economicos =(isset($_REQUEST['direccion_uno_datos_economicos'])&& $_REQUEST['direccion_uno_datos_economicos'] !=NULL)?$_REQUEST['direccion_uno_datos_economicos']:'';
            $_numero_telefono_uno_datos_economicos =(isset($_REQUEST['numero_telefono_uno_datos_economicos'])&& $_REQUEST['numero_telefono_uno_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_uno_datos_economicos']:'';
            $_empresa_dos_datos_economicos =(isset($_REQUEST['empresa_dos_datos_economicos'])&& $_REQUEST['empresa_dos_datos_economicos'] !=NULL)?$_REQUEST['empresa_dos_datos_economicos']:'';
            $_direccion_dos_datos_economicos =(isset($_REQUEST['direccion_dos_datos_economicos'])&& $_REQUEST['direccion_dos_datos_economicos'] !=NULL)?$_REQUEST['direccion_dos_datos_economicos']:'';
            $_numero_telefono_dos_datos_economicos =(isset($_REQUEST['numero_telefono_dos_datos_economicos'])&& $_REQUEST['numero_telefono_dos_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_dos_datos_economicos']:'';
            $_empresa_tres_datos_economicos =(isset($_REQUEST['empresa_tres_datos_economicos'])&& $_REQUEST['empresa_tres_datos_economicos'] !=NULL)?$_REQUEST['empresa_tres_datos_economicos']:'';
            $_direccion_tres_datos_economicos =(isset($_REQUEST['direccion_tres_datos_economicos'])&& $_REQUEST['direccion_tres_datos_economicos'] !=NULL)?$_REQUEST['direccion_tres_datos_economicos']:'';
            $_numero_telefono_tres_datos_economicos =(isset($_REQUEST['numero_telefono_tres_datos_economicos'])&& $_REQUEST['numero_telefono_tres_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_tres_datos_economicos']:'';
            $_empresa_cuatro_datos_economicos =(isset($_REQUEST['empresa_cuatro_datos_economicos'])&& $_REQUEST['empresa_cuatro_datos_economicos'] !=NULL)?$_REQUEST['empresa_cuatro_datos_economicos']:'';
            $_direccion_cuatro_datos_economicos =(isset($_REQUEST['direccion_cuatro_datos_economicos'])&& $_REQUEST['direccion_cuatro_datos_economicos'] !=NULL)?$_REQUEST['direccion_cuatro_datos_economicos']:'';
            $_numero_telefono_cuatro_datos_economicos =(isset($_REQUEST['numero_telefono_cuatro_datos_economicos'])&& $_REQUEST['numero_telefono_cuatro_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_cuatro_datos_economicos']:'';
            $_efectivo_activos_corrientes =(isset($_REQUEST['efectivo_activos_corrientes'])&& $_REQUEST['efectivo_activos_corrientes'] !=NULL)?$_REQUEST['efectivo_activos_corrientes']:0;
            $_bancos_activos_corrientes =(isset($_REQUEST['bancos_activos_corrientes'])&& $_REQUEST['bancos_activos_corrientes'] !=NULL)?$_REQUEST['bancos_activos_corrientes']:0;
            $_cuentas_cobrar_activos_corrientes =(isset($_REQUEST['cuentas_cobrar_activos_corrientes'])&& $_REQUEST['cuentas_cobrar_activos_corrientes'] !=NULL)?$_REQUEST['cuentas_cobrar_activos_corrientes']:0;
            $_inversiones_activos_corrientes =(isset($_REQUEST['inversiones_activos_corrientes'])&& $_REQUEST['inversiones_activos_corrientes'] !=NULL)?$_REQUEST['inversiones_activos_corrientes']:0;
            $_inventarios_activos_corrientes =(isset($_REQUEST['inventarios_activos_corrientes'])&& $_REQUEST['inventarios_activos_corrientes'] !=NULL)?$_REQUEST['inventarios_activos_corrientes']:0;
            $_muebles_activos_corrientes=(isset($_REQUEST['muebles_activos_corrientes'])&& $_REQUEST['muebles_activos_corrientes'] !=NULL)?$_REQUEST['muebles_activos_corrientes']:0;
            $_otros_activos_corrientes =(isset($_REQUEST['otros_activos_corrientes'])&& $_REQUEST['otros_activos_corrientes'] !=NULL)?$_REQUEST['otros_activos_corrientes']:0;
            $_terreno_activos_fijos =(isset($_REQUEST['terreno_activos_fijos'])&& $_REQUEST['terreno_activos_fijos'] !=NULL)?$_REQUEST['terreno_activos_fijos']:0;
            $_vivienda_activos_fijos =(isset($_REQUEST['vivienda_activos_fijos'])&& $_REQUEST['vivienda_activos_fijos'] !=NULL)?$_REQUEST['vivienda_activos_fijos']:0;
            $_vehiculo_activos_fijos =(isset($_REQUEST['vehiculo_activos_fijos'])&& $_REQUEST['vehiculo_activos_fijos'] !=NULL)?$_REQUEST['vehiculo_activos_fijos']:0;
            $_maquinaria_activos_fijos=(isset($_REQUEST['maquinaria_activos_fijos'])&& $_REQUEST['maquinaria_activos_fijos'] !=NULL)?$_REQUEST['maquinaria_activos_fijos']:0;
            $_otros_activos_fijos =(isset($_REQUEST['otros_activos_fijos'])&& $_REQUEST['otros_activos_fijos'] !=NULL)?$_REQUEST['otros_activos_fijos']:0;
            $_valor_prestacion_activos_intangibles =(isset($_REQUEST['valor_prestacion_activos_intangibles'])&& $_REQUEST['valor_prestacion_activos_intangibles'] !=NULL)?$_REQUEST['valor_prestacion_activos_intangibles']:0;
            $_prestamo_menor_anio_pasivo_corriente =(isset($_REQUEST['prestamo_menor_anio_pasivo_corriente'])&& $_REQUEST['prestamo_menor_anio_pasivo_corriente'] !=NULL)?$_REQUEST['prestamo_menor_anio_pasivo_corriente']:0;
            $_prestamo_emergente_pasivo_corriente =(isset($_REQUEST['prestamo_emergente_pasivo_corriente'])&& $_REQUEST['prestamo_emergente_pasivo_corriente'] !=NULL)?$_REQUEST['prestamo_emergente_pasivo_corriente']:0;
            $_cuentas_pagar_pasivo_corriente =(isset($_REQUEST['cuentas_pagar_pasivo_corriente'])&& $_REQUEST['cuentas_pagar_pasivo_corriente'] !=NULL)?$_REQUEST['cuentas_pagar_pasivo_corriente']:0;
            $_proveedores_pasivo_corriente =(isset($_REQUEST['proveedores_pasivo_corriente'])&& $_REQUEST['proveedores_pasivo_corriente'] !=NULL)?$_REQUEST['proveedores_pasivo_corriente']:0;
            $_obligaciones_menores_anio_pasivo_corriente =(isset($_REQUEST['obligaciones_menores_anio_pasivo_corriente'])&& $_REQUEST['obligaciones_menores_anio_pasivo_corriente'] !=NULL)?$_REQUEST['obligaciones_menores_anio_pasivo_corriente']:0;
            $_con_banco_pasivo_corriente=(isset($_REQUEST['con_banco_pasivo_corriente'])&& $_REQUEST['con_banco_pasivo_corriente'] !=NULL)?$_REQUEST['con_banco_pasivo_corriente']:0;
            $_con_cooperativas_pasivo_corriente =(isset($_REQUEST['con_cooperativas_pasivo_corriente'])&& $_REQUEST['con_cooperativas_pasivo_corriente'] !=NULL)?$_REQUEST['con_cooperativas_pasivo_corriente']:0;
            $_prestamo_mayor_anio_pasivos_largo_plazo =(isset($_REQUEST['prestamo_mayor_anio_pasivos_largo_plazo'])&& $_REQUEST['prestamo_mayor_anio_pasivos_largo_plazo'] !=NULL)?$_REQUEST['prestamo_mayor_anio_pasivos_largo_plazo']:0;
            $_obligaciones_mayores_anio_pasivos_largo_plazo =(isset($_REQUEST['obligaciones_mayores_anio_pasivos_largo_plazo'])&& $_REQUEST['obligaciones_mayores_anio_pasivos_largo_plazo'] !=NULL)?$_REQUEST['obligaciones_mayores_anio_pasivos_largo_plazo']:0;
            $_con_banco_pasivos_largo_plazo =(isset($_REQUEST['con_banco_pasivos_largo_plazo'])&& $_REQUEST['con_banco_pasivos_largo_plazo'] !=NULL)?$_REQUEST['con_banco_pasivos_largo_plazo']:0;
            $_con_cooperativas_pasivos_largo_plazo =(isset($_REQUEST['con_cooperativas_pasivos_largo_plazo'])&& $_REQUEST['con_cooperativas_pasivos_largo_plazo'] !=NULL)?$_REQUEST['con_cooperativas_pasivos_largo_plazo']:0;
            $_otros_pasivos_largo_plazo =(isset($_REQUEST['otros_pasivos_largo_plazo'])&& $_REQUEST['otros_pasivos_largo_plazo'] !=NULL)?$_REQUEST['otros_pasivos_largo_plazo']:0;
            $_patrimonio =(isset($_REQUEST['patrimonio'])&& $_REQUEST['patrimonio'] !=NULL)?$_REQUEST['patrimonio']:0;
            $_garantias_capremci =(isset($_REQUEST['_garantias_capremci'])&& $_REQUEST['_garantias_capremci'] !=NULL)?$_REQUEST['_garantias_capremci']:0;
            $_id_bancos_uno_detalle_activos =(isset($_REQUEST['id_bancos_uno_detalle_activos'])&& $_REQUEST['id_bancos_uno_detalle_activos'] !=0)?$_REQUEST['id_bancos_uno_detalle_activos']:'null';
            $_tipo_producto_uno_detalle_activos =(isset($_REQUEST['tipo_producto_uno_detalle_activos'])&& $_REQUEST['tipo_producto_uno_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_uno_detalle_activos']:'';
            $_valor_uno_detalle_activos =(isset($_REQUEST['valor_uno_detalle_activos'])&& $_REQUEST['valor_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_uno_detalle_activos']:0;
            $_plazo_uno_detalle_activos =(isset($_REQUEST['plazo_uno_detalle_activos'])&& $_REQUEST['plazo_uno_detalle_activos'] !=NULL)?$_REQUEST['plazo_uno_detalle_activos']:'';
            $_id_bancos_dos_detalle_activos =(isset($_REQUEST['id_bancos_dos_detalle_activos'])&& $_REQUEST['id_bancos_dos_detalle_activos'] !=0)?$_REQUEST['id_bancos_dos_detalle_activos']:'null';
            $_tipo_producto_dos_detalle_activos =(isset($_REQUEST['tipo_producto_dos_detalle_activos'])&& $_REQUEST['tipo_producto_dos_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_dos_detalle_activos']:'';
            $_valor_dos_detalle_activos =(isset($_REQUEST['valor_dos_detalle_activos'])&& $_REQUEST['valor_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_dos_detalle_activos']:0;
            $_plazo_dos_detalle_activos =(isset($_REQUEST['plazo_dos_detalle_activos'])&& $_REQUEST['plazo_dos_detalle_activos'] !=NULL)?$_REQUEST['plazo_dos_detalle_activos']:'';
            $_id_bancos_tres_detalle_activos =(isset($_REQUEST['id_bancos_tres_detalle_activos'])&& $_REQUEST['id_bancos_tres_detalle_activos'] !=0)?$_REQUEST['id_bancos_tres_detalle_activos']:'null';
            $_tipo_producto_tres_detalle_activos =(isset($_REQUEST['tipo_producto_tres_detalle_activos'])&& $_REQUEST['tipo_producto_tres_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_tres_detalle_activos']:'';
            $_valor_tres_detalle_activos =(isset($_REQUEST['valor_tres_detalle_activos'])&& $_REQUEST['valor_tres_detalle_activos'] !=NULL)?$_REQUEST['valor_tres_detalle_activos']:0;
            $_plazo_tres_detalle_activos =(isset($_REQUEST['plazo_tres_detalle_activos'])&& $_REQUEST['plazo_tres_detalle_activos'] !=NULL)?$_REQUEST['plazo_tres_detalle_activos']:'';
            $_id_bancos_cuatro_detalle_activos =(isset($_REQUEST['id_bancos_cuatro_detalle_activos'])&& $_REQUEST['id_bancos_cuatro_detalle_activos'] !=0)?$_REQUEST['id_bancos_cuatro_detalle_activos']:'null';
            $_tipo_producto_cuatro_detalle_activos =(isset($_REQUEST['tipo_producto_cuatro_detalle_activos'])&& $_REQUEST['tipo_producto_cuatro_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_cuatro_detalle_activos']:'';
            $_valor_cuatro_detalle_activos =(isset($_REQUEST['valor_cuatro_detalle_activos'])&& $_REQUEST['valor_cuatro_detalle_activos'] !=NULL)?$_REQUEST['valor_cuatro_detalle_activos']:0;
            $_plazo_cuatro_detalle_activos =(isset($_REQUEST['plazo_cuatro_detalle_activos'])&& $_REQUEST['plazo_cuatro_detalle_activos'] !=NULL)?$_REQUEST['plazo_cuatro_detalle_activos']:'';
            $_muebles_uno_detalle_activos =(isset($_REQUEST['muebles_uno_detalle_activos'])&& $_REQUEST['muebles_uno_detalle_activos'] !=NULL)?$_REQUEST['muebles_uno_detalle_activos']:'';
            $_direccion_uno_detalle_activos =(isset($_REQUEST['direccion_uno_detalle_activos'])&& $_REQUEST['direccion_uno_detalle_activos'] !=NULL)?$_REQUEST['direccion_uno_detalle_activos']:'';
            $_valor_muebles_uno_detalle_activos =(isset($_REQUEST['valor_muebles_uno_detalle_activos'])&& $_REQUEST['valor_muebles_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_uno_detalle_activos']:0;
            $_esta_hipotecado_uno_detalle_activos =(isset($_REQUEST['esta_hipotecado_uno_detalle_activos'])&& $_REQUEST['esta_hipotecado_uno_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecado_uno_detalle_activos']:'';
            $_muebles_dos_detalle_activos =(isset($_REQUEST['muebles_dos_detalle_activos'])&& $_REQUEST['muebles_dos_detalle_activos'] !=NULL)?$_REQUEST['muebles_dos_detalle_activos']:'';
            $_direccion_dos_detalle_activos =(isset($_REQUEST['direccion_dos_detalle_activos'])&& $_REQUEST['direccion_dos_detalle_activos'] !=NULL)?$_REQUEST['direccion_dos_detalle_activos']:'';
            $_valor_muebles_dos_detalle_activos =(isset($_REQUEST['valor_muebles_dos_detalle_activos'])&& $_REQUEST['valor_muebles_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_dos_detalle_activos']:0;
            $_esta_hipotecado_dos_detalle_activos =(isset($_REQUEST['esta_hipotecado_dos_detalle_activos'])&& $_REQUEST['esta_hipotecado_dos_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecado_dos_detalle_activos']:'';
            $_muebles_tres_detalle_activos =(isset($_REQUEST['muebles_tres_detalle_activos'])&& $_REQUEST['muebles_tres_detalle_activos'] !=NULL)?$_REQUEST['muebles_tres_detalle_activos']:'';
            $_direccion_tres_detalle_activos =(isset($_REQUEST['direccion_tres_detalle_activos'])&& $_REQUEST['direccion_tres_detalle_activos'] !=NULL)?$_REQUEST['direccion_tres_detalle_activos']:'';
            $_valor_muebles_tres_detalle_activos =(isset($_REQUEST['valor_muebles_tres_detalle_activos'])&& $_REQUEST['valor_muebles_tres_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_tres_detalle_activos']:0;
            $_esta_hipotecado_tres_detalle_activos =(isset($_REQUEST['esta_hipotecado_tres_detalle_activos'])&& $_REQUEST['esta_hipotecado_tres_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecado_tres_detalle_activos']:'';
            $_muebles_cuatro_detalle_activos =(isset($_REQUEST['muebles_cuatro_detalle_activos'])&& $_REQUEST['muebles_cuatro_detalle_activos'] !=NULL)?$_REQUEST['muebles_cuatro_detalle_activos']:'';
            $_direccion_cuatro_detalle_activos =(isset($_REQUEST['direccion_cuatro_detalle_activos'])&& $_REQUEST['direccion_cuatro_detalle_activos'] !=NULL)?$_REQUEST['direccion_cuatro_detalle_activos']:'';
            $_valor_muebles_cuatro_detalle_activos =(isset($_REQUEST['valor_muebles_cuatro_detalle_activos'])&& $_REQUEST['valor_muebles_cuatro_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_cuatro_detalle_activos']:0;
            $_esta_hipotecada_cuatro_detalle_activos =(isset($_REQUEST['esta_hipotecada_cuatro_detalle_activos'])&& $_REQUEST['esta_hipotecada_cuatro_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecada_cuatro_detalle_activos']:'';
            $_vehiculo_uno_detalle_activos =(isset($_REQUEST['vehiculo_uno_detalle_activos'])&& $_REQUEST['vehiculo_uno_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_uno_detalle_activos']:'';
            $_valor_vehiculo_uno_detalle_activos =(isset($_REQUEST['valor_vehiculo_uno_detalle_activos'])&& $_REQUEST['valor_vehiculo_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_uno_detalle_activos']:0;
            $_uso_uno_detalle_activos=(isset($_REQUEST['uso_uno_detalle_activos'])&& $_REQUEST['uso_uno_detalle_activos'] !=NULL)?$_REQUEST['uso_uno_detalle_activos']:'';
            $_asegurado_uno_detalle_activos =(isset($_REQUEST['asegurado_uno_detalle_activos'])&& $_REQUEST['asegurado_uno_detalle_activos'] !=NULL)?$_REQUEST['asegurado_uno_detalle_activos']:'';
            $_vehiculo_dos_detalle_activos =(isset($_REQUEST['vehiculo_dos_detalle_activos'])&& $_REQUEST['vehiculo_dos_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_dos_detalle_activos']:'';
            $_valor_vehiculo_dos_detalle_activos =(isset($_REQUEST['valor_vehiculo_dos_detalle_activos'])&& $_REQUEST['valor_vehiculo_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_dos_detalle_activos']:0;
            $_uso_dos_detalle_activos =(isset($_REQUEST['uso_dos_detalle_activos'])&& $_REQUEST['uso_dos_detalle_activos'] !=NULL)?$_REQUEST['uso_dos_detalle_activos']:'';
            $_asegurado_dos_detalle_activos =(isset($_REQUEST['asegurado_dos_detalle_activos'])&& $_REQUEST['asegurado_dos_detalle_activos'] !=NULL)?$_REQUEST['asegurado_dos_detalle_activos']:'';
            $_vehiculo_tres_detalle_activos =(isset($_REQUEST['vehiculo_tres_detalle_activos'])&& $_REQUEST['vehiculo_tres_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_tres_detalle_activos']:'';
            $_valor_vehiculo_tres_detalle_activos =(isset($_REQUEST['valor_vehiculo_tres_detalle_activos'])&& $_REQUEST['valor_vehiculo_tres_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_tres_detalle_activos']:0;
            $_uso_tres_detalle_activos  =(isset($_REQUEST['uso_tres_detalle_activos character'])&& $_REQUEST['uso_tres_detalle_activos character'] !=NULL)?$_REQUEST['uso_tres_detalle_activos character']:'';
            $_asegurado_tres_detalle_activos =(isset($_REQUEST['asegurado_tres_detalle_activos'])&& $_REQUEST['asegurado_tres_detalle_activos'] !=NULL)?$_REQUEST['asegurado_tres_detalle_activos']:'';
            $_vehiculo_cuatro_detalle_activos=(isset($_REQUEST['vehiculo_cuatro_detalle_activos'])&& $_REQUEST['vehiculo_cuatro_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_cuatro_detalle_activos']:'';
            $_valor_vehiculo_cuatro_detalle_activos =(isset($_REQUEST['valor_vehiculo_cuatro_detalle_activos'])&& $_REQUEST['valor_vehiculo_cuatro_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_cuatro_detalle_activos']:0;
            $_uso_cuatro_detalle_activos=(isset($_REQUEST['uso_cuatro_detalle_activos'])&& $_REQUEST['uso_cuatro_detalle_activos'] !=NULL)?$_REQUEST['uso_cuatro_detalle_activos']:'';
            $_asegurado_cuatro_detalle_activos =(isset($_REQUEST['asegurado_cuatro_detalle_activos'])&& $_REQUEST['asegurado_cuatro_detalle_activos'] !=NULL)?$_REQUEST['asegurado_cuatro_detalle_activos']:'';
            $_otros_uno_detalle_activos =(isset($_REQUEST['otros_uno_detalle_activos'])&& $_REQUEST['otros_uno_detalle_activos'] !=NULL)?$_REQUEST['otros_uno_detalle_activos']:'';
            $_valor_otros_uno_detalle_activos =(isset($_REQUEST['valor_otros_uno_detalle_activos'])&& $_REQUEST['valor_otros_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_otros_uno_detalle_activos']:0;
            $_observacion_otro_uno_detalle_activos =(isset($_REQUEST['observacion_otro_uno_detalle_activos'])&& $_REQUEST['observacion_otro_uno_detalle_activos'] !=NULL)?$_REQUEST['observacion_otro_uno_detalle_activos']:'';
            $_otros_dos_detalle_activos =(isset($_REQUEST['otros_dos_detalle_activos'])&& $_REQUEST['otros_dos_detalle_activos'] !=NULL)?$_REQUEST['otros_dos_detalle_activos']:'';
            $_valor_otros_dos_detalle_activos =(isset($_REQUEST['valor_otros_dos_detalle_activos'])&& $_REQUEST['valor_otros_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_otros_dos_detalle_activos']:'';
            $_observacion_dos_detalle_activos =(isset($_REQUEST['observacion_dos_detalle_activos'])&& $_REQUEST['observacion_dos_detalle_activos'] !=NULL)?$_REQUEST['observacion_dos_detalle_activos']:'';
            $_institucion_uno_detalle_pasivos =(isset($_REQUEST['institucion_uno_detalle_pasivos'])&& $_REQUEST['institucion_uno_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_uno_detalle_pasivos']:'';
            $_valor_uno_detalle_pasivos =(isset($_REQUEST['valor_uno_detalle_pasivos'])&& $_REQUEST['valor_uno_detalle_pasivos'] !=NULL)?$_REQUEST['valor_uno_detalle_pasivos']:'';
            $_destino_uno_detalle_pasivos =(isset($_REQUEST['destino_uno_detalle_pasivos'])&& $_REQUEST['destino_uno_detalle_pasivos'] !=NULL)?$_REQUEST['destino_uno_detalle_pasivos']:'';
            $_garantia_uno_detalle_pasivos =(isset($_REQUEST['garantia_uno_detalle_pasivos'])&& $_REQUEST['garantia_uno_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_uno_detalle_pasivos']:'';
            $_plazo_uno_detalle_pasivos =(isset($_REQUEST['plazo_uno_detalle_pasivos'])&& $_REQUEST['plazo_uno_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_uno_detalle_pasivos']:'';
            $_saldo_uno_detalle_pasivos =(isset($_REQUEST['saldo_uno_detalle_pasivos'])&& $_REQUEST['saldo_uno_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_uno_detalle_pasivos']:'';
            $_institucion_dos_detalle_pasivos =(isset($_REQUEST['institucion_dos_detalle_pasivos'])&& $_REQUEST['institucion_dos_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_dos_detalle_pasivos']:'';
            $_valor_dos_detalle_pasivos =(isset($_REQUEST['valor_dos_detalle_pasivos'])&& $_REQUEST['valor_dos_detalle_pasivos'] !=NULL)?$_REQUEST['valor_dos_detalle_pasivos']:0;
            $_destino_dos_detalle_pasivos =(isset($_REQUEST['destino_dos_detalle_pasivos'])&& $_REQUEST['destino_dos_detalle_pasivos'] !=NULL)?$_REQUEST['destino_dos_detalle_pasivos']:'';
            $_garantia_dos_detalle_pasivos =(isset($_REQUEST['garantia_dos_detalle_pasivos'])&& $_REQUEST['garantia_dos_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_dos_detalle_pasivos']:'';
            $_plazo_dos_detalle_pasivos =(isset($_REQUEST['plazo_dos_detalle_pasivos'])&& $_REQUEST['plazo_dos_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_dos_detalle_pasivos']:'';
            $_saldo_dos_detalle_pasivos =(isset($_REQUEST['saldo_dos_detalle_pasivos'])&& $_REQUEST['saldo_dos_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_dos_detalle_pasivos']:'';
            $_institucion_tres_detalle_pasivos =(isset($_REQUEST['institucion_tres_detalle_pasivos'])&& $_REQUEST['institucion_tres_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_tres_detalle_pasivos']:'';
            $_valor_tres_detalle_pasivos =(isset($_REQUEST['valor_tres_detalle_pasivos'])&& $_REQUEST['valor_tres_detalle_pasivos'] !=NULL)?$_REQUEST['valor_tres_detalle_pasivos']:0;
            $_destino_tres_detalle_pasivos =(isset($_REQUEST['destino_tres_detalle_pasivos'])&& $_REQUEST['destino_tres_detalle_pasivos'] !=NULL)?$_REQUEST['destino_tres_detalle_pasivos']:'';
            $_garantia_tres_detalle_pasivos =(isset($_REQUEST['garantia_tres_detalle_pasivos'])&& $_REQUEST['garantia_tres_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_tres_detalle_pasivos']:'';
            $_plazo_tres_detalle_pasivos =(isset($_REQUEST['plazo_tres_detalle_pasivos'])&& $_REQUEST['plazo_tres_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_tres_detalle_pasivos']:'';
            $_saldo_tres_detalle_pasivos  =(isset($_REQUEST['saldo_tres_detalle_pasivos'])&& $_REQUEST['saldo_tres_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_tres_detalle_pasivos']:'';
            $_institucion_cuatro_detalle_pasivos =(isset($_REQUEST['institucion_cuatro_detalle_pasivos'])&& $_REQUEST['institucion_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_cuatro_detalle_pasivos']:'';
            $_valor_cuatro_detalle_pasivos =(isset($_REQUEST['valor_cuatro_detalle_pasivos'])&& $_REQUEST['valor_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['valor_cuatro_detalle_pasivos']:0;
            $_destino_cuatro_detalle_pasivos =(isset($_REQUEST['destino_cuatro_detalle_pasivos'])&& $_REQUEST['destino_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['destino_cuatro_detalle_pasivos']:'';
            $_garantia_cuatro_detalle_pasivos =(isset($_REQUEST['garantia_cuatro_detalle_pasivos'])&& $_REQUEST['garantia_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_cuatro_detalle_pasivos']:'';
            $_plazo_cuatro_detalle_pasivos =(isset($_REQUEST['plazo_cuatro_detalle_pasivos'])&& $_REQUEST['plazo_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_cuatro_detalle_pasivos']:'';
            $_saldo_cuatro_detalle_pasivos =(isset($_REQUEST['saldo_cuatro_detalle_pasivos'])&& $_REQUEST['saldo_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_cuatro_detalle_pasivos']:'';
            $_institucion_cinco_detalle_pasivos =(isset($_REQUEST['institucion_cinco_detalle_pasivos'])&& $_REQUEST['institucion_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_cinco_detalle_pasivos']:'';
            $_valor_cinco_detalle_pasivos=(isset($_REQUEST['valor_cinco_detalle_pasivos'])&& $_REQUEST['valor_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['valor_cinco_detalle_pasivos']:0;
            $_destino_cinco_detalle_pasivos =(isset($_REQUEST['destino_cinco_detalle_pasivos'])&& $_REQUEST['destino_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['destino_cinco_detalle_pasivos']:'';
            $_garantia_cinco_detalle_pasivos =(isset($_REQUEST['garantia_cinco_detalle_pasivos'])&& $_REQUEST['garantia_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_cinco_detalle_pasivos']:'';
            $_plazo_cinco_detalle_pasivos =(isset($_REQUEST['plazo_cinco_detalle_pasivos'])&& $_REQUEST['plazo_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_cinco_detalle_pasivos']:'';
            $_saldo_cinco_detalle_pasivos =(isset($_REQUEST['saldo_cinco_detalle_pasivos'])&& $_REQUEST['saldo_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_cinco_detalle_pasivos']:'';
            $_sueldo_afiliado_ingresos_mensuales =(isset($_REQUEST['sueldo_afiliado_ingresos_mensuales'])&& $_REQUEST['sueldo_afiliado_ingresos_mensuales'] !=NULL)?$_REQUEST['sueldo_afiliado_ingresos_mensuales']:0;
            $_sueldo_conyuge_ingresos_mensuales =(isset($_REQUEST['sueldo_conyuge_ingresos_mensuales'])&& $_REQUEST['sueldo_conyuge_ingresos_mensuales'] !=NULL)?$_REQUEST['sueldo_conyuge_ingresos_mensuales']:0;
            $_comisiones_ingresos_mensuales =(isset($_REQUEST['comisiones_ingresos_mensuales'])&& $_REQUEST['comisiones_ingresos_mensuales'] !=NULL)?$_REQUEST['comisiones_ingresos_mensuales']:0;
            $_arriendos_ingresos_mensuales =(isset($_REQUEST['arriendos_ingresos_mensuales'])&& $_REQUEST['arriendos_ingresos_mensuales'] !=NULL)?$_REQUEST['arriendos_ingresos_mensuales']:0;
            $_dividendos_ingresos_mensuales =(isset($_REQUEST['dividendos_ingresos_mensuales'])&& $_REQUEST['dividendos_ingresos_mensuales'] !=NULL)?$_REQUEST['dividendos_ingresos_mensuales']:0;
            $_ingresos_negocio_ingresos_mensuales =(isset($_REQUEST['ingresos_negocio_ingresos_mensuales'])&& $_REQUEST['ingresos_negocio_ingresos_mensuales'] !=NULL)?$_REQUEST['ingresos_negocio_ingresos_mensuales']:0;
            $_pensiones_ingresos_mensuales =(isset($_REQUEST['pensiones_ingresos_mensuales'])&& $_REQUEST['pensiones_ingresos_mensuales'] !=NULL)?$_REQUEST['pensiones_ingresos_mensuales']:0;
            $_otros_detalle_uno_ingresos_mensuales =(isset($_REQUEST['otros_detalle_uno_ingresos_mensuales'])&& $_REQUEST['otros_detalle_uno_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_uno_ingresos_mensuales']:'';
            $_otros_uno_ingresos_mensuales =(isset($_REQUEST['otros_uno_ingresos_mensuales'])&& $_REQUEST['otros_uno_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_uno_ingresos_mensuales']:0;
            $_otros_detalle_dos_ingresos_mensuales =(isset($_REQUEST['otros_detalle_dos_ingresos_mensuales'])&& $_REQUEST['otros_detalle_dos_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_dos_ingresos_mensuales']:'';
            $_otros_dos_ingresos_mensuales =(isset($_REQUEST['otros_dos_ingresos_mensuales'])&& $_REQUEST['otros_dos_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_dos_ingresos_mensuales']:0;
            $_otros_detalle_tres_ingresos_mensuales =(isset($_REQUEST['otros_detalle_tres_ingresos_mensuales'])&& $_REQUEST['otros_detalle_tres_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_tres_ingresos_mensuales']:'';
            $_otros_tres_ingresos_mensuales =(isset($_REQUEST['otros_tres_ingresos_mensuales'])&& $_REQUEST['otros_tres_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_tres_ingresos_mensuales']:0;
            $_alimentacion_gastos_mensuales =(isset($_REQUEST['alimentacion_gastos_mensuales'])&& $_REQUEST['alimentacion_gastos_mensuales'] !=NULL)?$_REQUEST['alimentacion_gastos_mensuales']:0;
            $_arriendos_gastos_mensuales =(isset($_REQUEST['arriendos_gastos_mensuales'])&& $_REQUEST['arriendos_gastos_mensuales'] !=NULL)?$_REQUEST['arriendos_gastos_mensuales']:0;
            $_educacion_gastos_mensuales =(isset($_REQUEST['educacion_gastos_mensuales'])&& $_REQUEST['educacion_gastos_mensuales'] !=NULL)?$_REQUEST['educacion_gastos_mensuales']:0;
            $_vestuario_gastos_mensuales =(isset($_REQUEST['vestuario_gastos_mensuales'])&& $_REQUEST['vestuario_gastos_mensuales'] !=NULL)?$_REQUEST['vestuario_gastos_mensuales']:0;
            $_servicios_publicos_gastos_mensuales =(isset($_REQUEST['servicios_publicos_gastos_mensuales'])&& $_REQUEST['servicios_publicos_gastos_mensuales'] !=NULL)?$_REQUEST['servicios_publicos_gastos_mensuales']:0;
            $_movilizacion_gastos_mensuales =(isset($_REQUEST['movilizacion_gastos_mensuales'])&& $_REQUEST['movilizacion_gastos_mensuales'] !=NULL)?$_REQUEST['movilizacion_gastos_mensuales']:0;
            $_ahorros_cooperativas_gastos_mensuales =(isset($_REQUEST['ahorros_cooperativas_gastos_mensuales'])&& $_REQUEST['ahorros_cooperativas_gastos_mensuales'] !=NULL)?$_REQUEST['ahorros_cooperativas_gastos_mensuales']:0;
            $_cuotas_tarjetas_gastos_mensuales =(isset($_REQUEST['cuotas_tarjetas_gastos_mensuales'])&& $_REQUEST['cuotas_tarjetas_gastos_mensuales'] !=NULL)?$_REQUEST['cuotas_tarjetas_gastos_mensuales']:0;
            $_cuotas_prestamo_gastos_mensuales =(isset($_REQUEST['cuotas_prestamo_gastos_mensuales'])&& $_REQUEST['cuotas_prestamo_gastos_mensuales'] !=NULL)?$_REQUEST['cuotas_prestamo_gastos_mensuales']:0;
            $_otros_detalle_uno_gastos_mensuales =(isset($_REQUEST['otros_detalle_uno_gastos_mensuales'])&& $_REQUEST['otros_detalle_uno_gastos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_uno_gastos_mensuales']:'';
            $_otros_gastos_uno_gastos_mensuales =(isset($_REQUEST['otros_gastos_uno_gastos_mensuales'])&& $_REQUEST['otros_gastos_uno_gastos_mensuales'] !=NULL)?$_REQUEST['otros_gastos_uno_gastos_mensuales']:0;
            
            
            
            
            
            $_id_codigo_verificacion =(isset($_REQUEST['id_codigo_verificacion'])&& $_REQUEST['id_codigo_verificacion'] !=NULL)?$_REQUEST['id_codigo_verificacion']:0;
            $_id_sucursales =(isset($_REQUEST['id_sucursales'])&& $_REQUEST['id_sucursales'] !=NULL)?$_REQUEST['id_sucursales']:0;
            $_identificador_consecutivos=(isset($_REQUEST['identificador_consecutivos'])&& $_REQUEST['identificador_consecutivos'] !=NULL)?$_REQUEST['identificador_consecutivos']:0;
            
            
            
            
            $_total_activos_corrientes=$_efectivo_activos_corrientes+$_bancos_activos_corrientes+$_cuentas_cobrar_activos_corrientes+$_inversiones_activos_corrientes+$_inventarios_activos_corrientes+$_muebles_activos_corrientes+$_otros_activos_corrientes;
            $_total_activos_fijos=$_terreno_activos_fijos+$_vivienda_activos_fijos+$_vehiculo_activos_fijos+$_maquinaria_activos_fijos+$_otros_activos_fijos;
            $_total_activos=$_total_activos_corrientes+$_total_activos_fijos;
            $_total_pasivos_corrientes=$_prestamo_menor_anio_pasivo_corriente+$_prestamo_emergente_pasivo_corriente+$_cuentas_pagar_pasivo_corriente+$_proveedores_pasivo_corriente+$_obligaciones_menores_anio_pasivo_corriente+$_con_banco_pasivo_corriente+$_con_cooperativas_pasivo_corriente;
            $_total_pasivos_largo_plazo=$_prestamo_mayor_anio_pasivos_largo_plazo+$_obligaciones_mayores_anio_pasivos_largo_plazo+$_con_banco_pasivos_largo_plazo+$_con_cooperativas_pasivos_largo_plazo+$_otros_pasivos_largo_plazo;
            $_total_pasivos=$_total_pasivos_corrientes+$_total_pasivos_largo_plazo;
            
            
            
            $_total_ingresos_mensuales=$_sueldo_afiliado_ingresos_mensuales+$_sueldo_conyuge_ingresos_mensuales+$_comisiones_ingresos_mensuales+$_arriendos_ingresos_mensuales+$_dividendos_ingresos_mensuales+$_ingresos_negocio_ingresos_mensuales+$_pensiones_ingresos_mensuales+$_otros_uno_ingresos_mensuales+$_otros_dos_ingresos_mensuales+$_otros_tres_ingresos_mensuales;
            $_total_gastos_mensuales=$_alimentacion_gastos_mensuales+$_arriendos_gastos_mensuales+$_educacion_gastos_mensuales+$_vestuario_gastos_mensuales+$_servicios_publicos_gastos_mensuales+$_movilizacion_gastos_mensuales+$_ahorros_cooperativas_gastos_mensuales+$_cuotas_tarjetas_gastos_mensuales+$_cuotas_prestamo_gastos_mensuales+$_otros_gastos_uno_gastos_mensuales;
           
            
            
            
           
            
            $_fecha_actual =    getdate();
            $_fecha_año    =	$_fecha_actual['year'];
            $_fecha_mes    =	$_fecha_actual['mon'];
            $_fecha_dia    =	$_fecha_actual['mday'];
            
            $_fecha_presentacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
            $_id_usuarios_registra = $_SESSION['id_usuarios'];
            
            
            
            
           
            
                 
            if($_id_solicitud_hipotecario > 0){
            
                
                // para actualizar la solicitud de credito hipotexario 
                
                $columnas="id_sucursales, fecha_aprobacion, fecha_presentacion, id_usuarios_oficial_credito_aprueba";
                $tablas="solicitud_hipotecario";
                $where="id_solicitud_hipotecario='$_id_solicitud_hipotecario'";
                $id="id_solicitud_hipotecario";
                $Resulr=$solicitud_hipotecario->getCondiciones($columnas, $tablas, $where, $id);
                
                
                
                if(!empty($Resulr)){
                  
                    $_id_sucursales = $Resulr[0]->id_sucursales;
                    $_fecha_presentacion = $Resulr[0]->fecha_presentacion;
                    $_fecha_aprobacion = $Resulr[0]->fecha_aprobacion;
                    $id_oficial_credito = $Resulr[0]->id_usuarios_oficial_credito_aprueba;
                    
                    if($_fecha_aprobacion==""){
                        
                        $_fecha_aprobacion='null';
                    }
                    
                    if($_fecha_presentacion==""){
                        
                        $_fecha_presentacion='null';
                    }
                    
                }
                
                
                try {
                    
                    $solicitud_hipotecario->beginTran();
                    
                    
                    $funcion = "ins_solicitud_hipotecario";
                    $parametros = " '$_valor_dolares_datos_credito',
                                '$_plazo_meses_datos_credito',
                                '$_destino_dinero_datos_credito',
                                '$_nombres_datos_personales',
                                '$_apellidos_datos_personales',
                                '$_cedula_datos_personales',
                                '$_id_sexo',
                                '$_fecha_nacimiento_datos_personales',
                                '$_id_estado_civil',
                                '$_separacion_bienes_datos_personales',
                                '$_cargas_familiares_datos_personales',
                                '$_numero_hijos_datos_personales',
                                '$_id_provincia',
                                '$_id_canton',
                                '$_id_parroquia',
                                '$_barrio_datos_personales',
                                '$_ciudadela_datos_personales',
                                '$_calle_datos_personalescharacter',
                                '$_numero_calle_datos_personales',
                                '$_interseccion_datos_personales',
                                '$_tipo_vivienda_datos_personales',
                                '$_vivienda_hipotecada_datos_personales',
                                '$_tiempo_residencia_datos_personales',
                                '$_referencia_domiciliaria_datos_perdonales',
                                '$_nombre_arrendatario_datos_personales',
                                '$_apellido_arrendatario_datos_personales',
                                '$_celular_arrendatario_datos_personales',
                                '$_telefono_datos_personales',
                                '$_celular_datos_personales',
                                '$_telf_trabajo_datos_personales',
                                '$_ext_telef_datos_personales',
                                '$_node_telef_datos_personales',
                                '$_email_datos_personales',
                                '$_nivel_educativo_datos_personales',
                                '$_nombres_referencia_familiar_datos_personales',
                                '$_apellidos_referencia_familiar_datos_personales',
                                '$_parentesco_referencia_familiar_datos_personales',
                                '$_primer_telefono_ref_familiar_datos_personales',
                                '$_segundo_telefono_ref_familiar_datos_personales',
                                '$_nombres_referencia_personal_datos_personales',
                                '$_apellidos_referencia_personal_datos_personales',
                                '$_relacion_referencia_personal_datos_personales',
                                '$_primer_telefono_ref_personal_datos_personales',
                                '$_segundo_telefono_ref_personal_datos_personales',
                                '$_id_entidades',
                                '$_reparto_unidad_datos_laborales',
                                '$_seccion_datos_laborales',
                                '$_nombres_jefe_datos_laborales',
                                '$_apellidos_jefe_datos_laborales',
                                '$_telefono_jefe_datos_laborales',
                                '$_id_provincia_datos_laborales',
                                '$_id_canton_datos_laborales',
                                '$_id_parroquia_datos_laborales',
                                '$_calle_datos_laborales',
                                '$_numero_calle_datos_laborales',
                                '$_interseccion_datos_laborales',
                                '$_referencia_direccion_trabajo_datos_laborales',
                                '$_cargo_actual_datos_laborales',
                                '$_anios_servicio_datos_laborales',
                                '$_nombres_datos_conyuge',
                                '$_apellidos_datos_conyuge',
                                '$_cedula_datos_conyuge',
                                 $_id_sexo_datos_conyuge,
                                 $_fecha_nacimiento_datos_conyuge,
                                '$_vive_residencia_datos_conyuge',
                                '$_celular_datos_conyuge',
                                '$_telefono_datos_conyuge',
                                 $_id_provincia_datos_conyuge,
                                 $_id_canton_datos_conyuge,
                                 $_id_parroquia_datos_conyuge,
                                '$_barrio_datos_conyuge',
                                '$_ciudadela_datos_conyuge',
                                '$_calle_datos_conyuge',
                                '$_numero_calle_datos_conyuge',
                                '$_interseccion_datos_conyuge',
                                '$_actividad_economica_datos_conyuge',
                                '$_empresa_datos_conyuge',
                                '$_naturaleza_negocio_datos_conyuge',
                                '$_cargo_datos_conyuge',
                                '$_tipo_contrato_datos_conyuge',
                                '$_anios_laborados_datos_conyuge',
                                '$_nombres_jefe_datos_conyuge',
                                '$_apellidos_jefe_datos_conyuge',
                                '$_telefono_jefe_datos_conyuge',
                                 $_id_provincia_trabajo_datos_conyuge,
                                 $_id_canton_trabajo_datos_conyuge,
                                 $_id_parroquia_trabajo_datos_conyuge,
                                '$_calle_trabajo_datos_conyuge',
                                '$_nuemero_calle_trabajo_datos_conyuge',
                                '$_interseccion_trabajo_datos_conyuge',
                                '$_referencia_trabajo_datos_conyuge',
                                '$_actividad_principal_datos_independientes',
                                '$_ruc_datos_independientes',
                                '$_detalle_actividades_datos_independientes',
                                '$_local_datos_independientes',
                                '$_nombres_propietario_datos_independientes',
                                '$_apellidos_propietario_datos_independientes',
                                '$_telefono_propietario_datos_independientes',
                                '$_tiempo_funcionamiento_datos_independientes',
                                '$_identificador_consecutivos'";
                                 
                                 
                                 $solicitud_hipotecario->setFuncion($funcion);
                                 $solicitud_hipotecario->setParametros($parametros);
                                 $resultado = $solicitud_hipotecario->llamafuncionPG();
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 $error = "";
                                 $error = pg_last_error();
                                 if (!empty($error) || (int)$resultado[0] <= 0){
                                     throw new Exception('error actualizando solicitud hipotecario');
                                 }
                                 else{
                                     
                                     $id = $resultado[0];
                                     
                                     
                                     $funcionadicionaluno="ins_solicitud_hipotecario_adicional_uno";
                                     $parametros1 = " '$id',
                                 '$_numero_empleados_datos_independientes',
                                 $_id_bancos_referencia_bancaria,
                                '$_tipo_cuenta_referencia_bancaria',
                                '$_numero_cuenta_referencia_bancaria',
                                 $_id_bancos_uno_datos_economicos,
                                '$_tipo_cuenta_uno_datos_economicos',
                                '$_numero_cuenta_uno_datos_economicos',
                                 $_id_bancos_dos_datos_economicos,
                                '$_tipo_cuenta_dos_datos_economicos',
                                '$_numero_cuenta_dos_datos_economicos',
                                 $_id_bancos_tres_datos_economicos,
                                '$_tipo_cuenta_tres_datos_economicos',
                                '$_numero_cuenta_tres_datos_economicos',
                                 $_id_bancos_cuatro_datos_economicos,
                                '$_tipo_cuenta_cuatro_datos_economicos',
                                '$_numero_cuenta_cuatro_datos_economicos',
                                '$_empresa_uno_datos_economicos',
                                '$_direccion_uno_datos_economicos',
                                '$_numero_telefono_uno_datos_economicos',
                                '$_empresa_dos_datos_economicos',
                                '$_direccion_dos_datos_economicos',
                                '$_numero_telefono_dos_datos_economicos',
                                '$_empresa_tres_datos_economicos',
                                '$_direccion_tres_datos_economicos',
                                '$_numero_telefono_tres_datos_economicos',
                                '$_empresa_cuatro_datos_economicos',
                                '$_direccion_cuatro_datos_economicos ',
                                '$_numero_telefono_cuatro_datos_economicos',
                                '$_efectivo_activos_corrientes',
                                '$_bancos_activos_corrientes',
                                '$_cuentas_cobrar_activos_corrientes',
                                '$_inversiones_activos_corrientes',
                                '$_inventarios_activos_corrientes',
                                '$_muebles_activos_corrientes',
                                '$_otros_activos_corrientes',
                                '$_terreno_activos_fijos',
                                '$_vivienda_activos_fijos',
                                '$_vehiculo_activos_fijos',
                                '$_maquinaria_activos_fijos',
                                '$_otros_activos_fijos',
                                '$_valor_prestacion_activos_intangibles',
                                '$_prestamo_menor_anio_pasivo_corriente',
                                '$_prestamo_emergente_pasivo_corriente',
                                '$_cuentas_pagar_pasivo_corriente',
                                '$_proveedores_pasivo_corriente',
                                '$_obligaciones_menores_anio_pasivo_corriente',
                                '$_con_banco_pasivo_corriente',
                                '$_con_cooperativas_pasivo_corriente',
                                '$_prestamo_mayor_anio_pasivos_largo_plazo',
                                '$_obligaciones_mayores_anio_pasivos_largo_plazo',
                                '$_con_banco_pasivos_largo_plazo',
                                '$_con_cooperativas_pasivos_largo_plazo',
                                '$_otros_pasivos_largo_plazo',
                                '$_patrimonio',
                                '$_garantias_capremci',
                                 $_id_bancos_uno_detalle_activos,
                                '$_tipo_producto_uno_detalle_activos',
                                '$_valor_uno_detalle_activos',
                                '$_plazo_uno_detalle_activos',
                                 $_id_bancos_dos_detalle_activos,
                                '$_tipo_producto_dos_detalle_activos',
                                '$_valor_dos_detalle_activos',
                                '$_plazo_dos_detalle_activos',
                                 $_id_bancos_tres_detalle_activos,
                                '$_tipo_producto_tres_detalle_activos',
                                '$_valor_tres_detalle_activos',
                                '$_plazo_tres_detalle_activos',
                                 $_id_bancos_cuatro_detalle_activos,
                                '$_tipo_producto_cuatro_detalle_activos',
                                '$_valor_cuatro_detalle_activos',
                                '$_plazo_cuatro_detalle_activos',
                                '$_muebles_uno_detalle_activos',
                                '$_direccion_uno_detalle_activos',
                                '$_valor_muebles_uno_detalle_activos',
                                '$_esta_hipotecado_uno_detalle_activos',
                                '$_muebles_dos_detalle_activos',
                                '$_direccion_dos_detalle_activos',
                                '$_valor_muebles_dos_detalle_activos',
                                '$_esta_hipotecado_dos_detalle_activos',
                                '$_muebles_tres_detalle_activos',
                                '$_direccion_tres_detalle_activos',
                                '$_valor_muebles_tres_detalle_activos',
                                '$_esta_hipotecado_tres_detalle_activos',
                                '$_muebles_cuatro_detalle_activos',
                                '$_direccion_cuatro_detalle_activos',
                                '$_valor_muebles_cuatro_detalle_activos',
                                '$_esta_hipotecada_cuatro_detalle_activos',
                                '$_vehiculo_uno_detalle_activos',
                                '$_valor_vehiculo_uno_detalle_activos',
                                '$_uso_uno_detalle_activos',
                                '$_asegurado_uno_detalle_activos',
                                '$_vehiculo_dos_detalle_activos',
                                '$_valor_vehiculo_dos_detalle_activos',
                                '$_uso_dos_detalle_activos',
                                '$_asegurado_dos_detalle_activos',
                                '$_vehiculo_tres_detalle_activos',
                                '$_valor_vehiculo_tres_detalle_activos',
                                '$_uso_tres_detalle_activos',
                                '$_asegurado_tres_detalle_activos'";
                                 
                                 
                                 $solicitud_hipotecario->setFuncion($funcionadicionaluno);
                                 $solicitud_hipotecario->setParametros($parametros1);
                                 $resultado1 = $solicitud_hipotecario->llamafuncionPG();
                                 
                                 $error="";
                                 $error = pg_last_error();
                                 if (!empty($error) || (int)$resultado1[0] <= 0){
                                     throw new Exception('error actualizando solicitud hipotecario');
                                 }
                                 
                                 
                                 
                                 $funcionadicionaldos="ins_solicitud_hipotecario_adicional_dos";
                                 $parametros2 = " '$id',
                                '$_vehiculo_cuatro_detalle_activos',
                                '$_valor_vehiculo_cuatro_detalle_activos',
                                '$_uso_cuatro_detalle_activos',
                                '$_asegurado_cuatro_detalle_activos',
                                '$_otros_uno_detalle_activos',
                                '$_valor_otros_uno_detalle_activos',
                                '$_observacion_otro_uno_detalle_activos',
                                '$_otros_dos_detalle_activos',
                                '$_valor_otros_dos_detalle_activos',
                                '$_observacion_dos_detalle_activos',
                                '$_institucion_uno_detalle_pasivos',
                                '$_valor_uno_detalle_pasivos',
                                '$_destino_uno_detalle_pasivos',
                                '$_garantia_uno_detalle_pasivos',
                                '$_plazo_uno_detalle_pasivos',
                                '$_saldo_uno_detalle_pasivos',
                                '$_institucion_dos_detalle_pasivos',
                                '$_valor_dos_detalle_pasivos',
                                '$_destino_dos_detalle_pasivos',
                                '$_garantia_dos_detalle_pasivos',
                                '$_plazo_dos_detalle_pasivos',
                                '$_saldo_dos_detalle_pasivos',
                                '$_institucion_tres_detalle_pasivos',
                                '$_valor_tres_detalle_pasivos',
                                '$_destino_tres_detalle_pasivos',
                                '$_garantia_tres_detalle_pasivos',
                                '$_plazo_tres_detalle_pasivos',
                                '$_saldo_tres_detalle_pasivos',
                                '$_institucion_cuatro_detalle_pasivos',
                                '$_valor_cuatro_detalle_pasivos',
                                '$_destino_cuatro_detalle_pasivos',
                                '$_garantia_cuatro_detalle_pasivos',
                                '$_plazo_cuatro_detalle_pasivos',
                                '$_saldo_cuatro_detalle_pasivos',
                                '$_institucion_cinco_detalle_pasivos',
                                '$_valor_cinco_detalle_pasivos',
                                '$_destino_cinco_detalle_pasivos',
                                '$_garantia_cinco_detalle_pasivos',
                                '$_plazo_cinco_detalle_pasivos',
                                '$_saldo_cinco_detalle_pasivos',
                                '$_sueldo_afiliado_ingresos_mensuales',
                                '$_sueldo_conyuge_ingresos_mensuales',
                                '$_comisiones_ingresos_mensuales',
                                '$_arriendos_ingresos_mensuales',
                                '$_dividendos_ingresos_mensuales',
                                '$_ingresos_negocio_ingresos_mensuales',
                                '$_pensiones_ingresos_mensuales',
                                '$_otros_detalle_uno_ingresos_mensuales',
                                '$_otros_uno_ingresos_mensuales',
                                '$_otros_detalle_dos_ingresos_mensuales',
                                '$_otros_dos_ingresos_mensuales',
                                '$_otros_detalle_tres_ingresos_mensuales',
                                '$_otros_tres_ingresos_mensuales',
                                '$_alimentacion_gastos_mensuales',
                                '$_arriendos_gastos_mensuales',
                                '$_educacion_gastos_mensuales',
                                '$_vestuario_gastos_mensuales',
                                '$_servicios_publicos_gastos_mensuales',
                                '$_movilizacion_gastos_mensuales',
                                '$_ahorros_cooperativas_gastos_mensuales',
                                '$_cuotas_tarjetas_gastos_mensuales',
                                '$_cuotas_prestamo_gastos_mensuales',
                                '$_otros_detalle_uno_gastos_mensuales',
                                '$_otros_gastos_uno_gastos_mensuales',
                                '$_id_codigo_verificacion',
                                '$_total_activos_corrientes',
                                '$_total_activos_fijos',
                                '$_total_activos',
                                '$_total_pasivos_corrientes',
                                '$_total_pasivos_largo_plazo',
                                '$_total_pasivos',
                                '$_total_ingresos_mensuales',
                                '$_total_gastos_mensuales',
                                '$_id_usuarios_registra',
                                '$id_oficial_credito',
                                '$_identificador_consecutivos',
                                '$_fecha_presentacion',
                                 $_fecha_aprobacion,
                                '$_id_sucursales',
                                '$_numero_patronal_datos_independientes'";
                                 
                                 
                                 $solicitud_hipotecario->setFuncion($funcionadicionaldos);
                                 $solicitud_hipotecario->setParametros($parametros2);
                                 $resultado2 = $solicitud_hipotecario->llamafuncionPG();
                                 
                                 
                                 
                                 
                                 
                                 $error="";
                                 $error = pg_last_error();
                                 if (!empty($error) || (int)$resultado2[0] <= 0){
                                     throw new Exception('error actualizando solicitud hipotecario');
                                 }
                                 
                                 
                                 }
                                 
                                 
                                 
                                 $solicitud_hipotecario->endTran('COMMIT');
                                 
                                 
                                 echo json_encode(array('id'=>$id,'mensaje'=>"Solicitud Actualizada Correctamente"));
                                 exit();
                                 
                                 
                                 
                                 
                                 
                } catch (Exception $e) {
                    
                    $solicitud_hipotecario->endTran();
                    
                    
                    echo json_encode(array('id'=>0,'mensaje'=>"Error Actualizando Solicitud ".$e->getMessage()));
                    die();
                    
                }
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                // termina actualizacion
                
                
                
                
                
                
            }else{
                    
                  
                
            // para guardar la solicitud de credito hipotecario    
              
                
                
                
                $_identificador_consecutivos=0;
                $resultConsecutivos=$consecutivos->getBy("nombre_consecutivos='PRUEBAS'");
                $_identificador_consecutivos=$resultConsecutivos[0]->identificador_consecutivos;
                
                
                
                
                $id_usuarios_1=0;
                $id_usuarios_2=0;
                $id_usuarios_3=0;
                $res1=0;
                $res2=0;
                $res3=0;
                $id_oficial_credito=0;
                
          
                   
                
                //empicesa if de sucursales
                    
                    if($_id_sucursales == 1){
                        
                        $resultQuito=$solicitud_hipotecario->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Quito' AND id_estado=1", "id_usuarios");
                        
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
                        
                        
                        $resultoficial1=$solicitud_hipotecario->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                        
                        if(!empty($resultoficial1)){
                            
                            $res1=count($resultoficial1);
                        }
                        
                        $resultoficial2=$solicitud_hipotecario->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                        
                        if(!empty($resultoficial2)){
                            $res2=count($resultoficial2);
                        }
                        
                        
                        $resultoficial3=$solicitud_hipotecario->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_3' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                        
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
                        }else{
                            
                            $id_oficial_credito=$id_usuarios_1;
                        }
                        
                       
                        
                    }else{
                        
                        $resultGuayaquil=$solicitud_hipotecario->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Guayaquil' AND id_estado=1", "id_usuarios");
                        
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
                        
                        $resultoficial1=$solicitud_hipotecario->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                        
                        if(!empty($resultoficial1)){
                            $res1=count($resultoficial1);
                        }
                        
                        $resultoficial2=$solicitud_hipotecario->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                        
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
                    
                
                    
                    //termina if de sucursales
                    
                    
                    
                    try {
                        
                        $solicitud_hipotecario->beginTran();
                        
                        
                        $funcion = "ins_solicitud_hipotecario";
                        $parametros = " '$_valor_dolares_datos_credito',
                                '$_plazo_meses_datos_credito',
                                '$_destino_dinero_datos_credito',
                                '$_nombres_datos_personales',
                                '$_apellidos_datos_personales',
                                '$_cedula_datos_personales',
                                '$_id_sexo',
                                '$_fecha_nacimiento_datos_personales',
                                '$_id_estado_civil',
                                '$_separacion_bienes_datos_personales',
                                '$_cargas_familiares_datos_personales',
                                '$_numero_hijos_datos_personales',
                                '$_id_provincia',
                                '$_id_canton',
                                '$_id_parroquia',
                                '$_barrio_datos_personales',
                                '$_ciudadela_datos_personales',
                                '$_calle_datos_personalescharacter',
                                '$_numero_calle_datos_personales',
                                '$_interseccion_datos_personales',
                                '$_tipo_vivienda_datos_personales',
                                '$_vivienda_hipotecada_datos_personales',
                                '$_tiempo_residencia_datos_personales',
                                '$_referencia_domiciliaria_datos_perdonales',
                                '$_nombre_arrendatario_datos_personales',
                                '$_apellido_arrendatario_datos_personales',
                                '$_celular_arrendatario_datos_personales',
                                '$_telefono_datos_personales',
                                '$_celular_datos_personales',
                                '$_telf_trabajo_datos_personales',
                                '$_ext_telef_datos_personales',
                                '$_node_telef_datos_personales',
                                '$_email_datos_personales',
                                '$_nivel_educativo_datos_personales',
                                '$_nombres_referencia_familiar_datos_personales',
                                '$_apellidos_referencia_familiar_datos_personales',
                                '$_parentesco_referencia_familiar_datos_personales',
                                '$_primer_telefono_ref_familiar_datos_personales',
                                '$_segundo_telefono_ref_familiar_datos_personales',
                                '$_nombres_referencia_personal_datos_personales',
                                '$_apellidos_referencia_personal_datos_personales',
                                '$_relacion_referencia_personal_datos_personales',
                                '$_primer_telefono_ref_personal_datos_personales',
                                '$_segundo_telefono_ref_personal_datos_personales',
                                '$_id_entidades',
                                '$_reparto_unidad_datos_laborales',
                                '$_seccion_datos_laborales',
                                '$_nombres_jefe_datos_laborales',
                                '$_apellidos_jefe_datos_laborales',
                                '$_telefono_jefe_datos_laborales',
                                '$_id_provincia_datos_laborales',
                                '$_id_canton_datos_laborales',
                                '$_id_parroquia_datos_laborales',
                                '$_calle_datos_laborales',
                                '$_numero_calle_datos_laborales',
                                '$_interseccion_datos_laborales',
                                '$_referencia_direccion_trabajo_datos_laborales',
                                '$_cargo_actual_datos_laborales',
                                '$_anios_servicio_datos_laborales',
                                '$_nombres_datos_conyuge',
                                '$_apellidos_datos_conyuge',
                                '$_cedula_datos_conyuge',
                                 $_id_sexo_datos_conyuge,
                                 $_fecha_nacimiento_datos_conyuge,
                                '$_vive_residencia_datos_conyuge',
                                '$_celular_datos_conyuge',
                                '$_telefono_datos_conyuge',
                                 $_id_provincia_datos_conyuge,
                                 $_id_canton_datos_conyuge,
                                 $_id_parroquia_datos_conyuge,
                                '$_barrio_datos_conyuge',
                                '$_ciudadela_datos_conyuge',
                                '$_calle_datos_conyuge',
                                '$_numero_calle_datos_conyuge',
                                '$_interseccion_datos_conyuge',
                                '$_actividad_economica_datos_conyuge',
                                '$_empresa_datos_conyuge',
                                '$_naturaleza_negocio_datos_conyuge',
                                '$_cargo_datos_conyuge',
                                '$_tipo_contrato_datos_conyuge',
                                '$_anios_laborados_datos_conyuge',
                                '$_nombres_jefe_datos_conyuge',
                                '$_apellidos_jefe_datos_conyuge',
                                '$_telefono_jefe_datos_conyuge',
                                 $_id_provincia_trabajo_datos_conyuge,
                                 $_id_canton_trabajo_datos_conyuge,
                                 $_id_parroquia_trabajo_datos_conyuge,
                                '$_calle_trabajo_datos_conyuge',
                                '$_nuemero_calle_trabajo_datos_conyuge',
                                '$_interseccion_trabajo_datos_conyuge',
                                '$_referencia_trabajo_datos_conyuge',
                                '$_actividad_principal_datos_independientes',
                                '$_ruc_datos_independientes',
                                '$_detalle_actividades_datos_independientes',
                                '$_local_datos_independientes',
                                '$_nombres_propietario_datos_independientes',
                                '$_apellidos_propietario_datos_independientes',
                                '$_telefono_propietario_datos_independientes',
                                '$_tiempo_funcionamiento_datos_independientes',
                                '$_identificador_consecutivos'";
                        
                        
                        $solicitud_hipotecario->setFuncion($funcion);
                        $solicitud_hipotecario->setParametros($parametros);
                        $resultado = $solicitud_hipotecario->llamafuncionPG();
                        
                        
                        
                        
                        
                        
                        
                        $error = "";
                        $error = pg_last_error();
                        if (!empty($error) || (int)$resultado[0] <= 0){
                            throw new Exception('error ingresando solicitud hipotecario');
                        }
                        else{
                            
                            $id = $resultado[0];
                            
                           
                            $funcionadicionaluno="ins_solicitud_hipotecario_adicional_uno";
                            $parametros1 = " '$id',
                                 '$_numero_empleados_datos_independientes',
                                 $_id_bancos_referencia_bancaria,
                                '$_tipo_cuenta_referencia_bancaria',
                                '$_numero_cuenta_referencia_bancaria',
                                 $_id_bancos_uno_datos_economicos,
                                '$_tipo_cuenta_uno_datos_economicos',
                                '$_numero_cuenta_uno_datos_economicos',
                                 $_id_bancos_dos_datos_economicos,
                                '$_tipo_cuenta_dos_datos_economicos',
                                '$_numero_cuenta_dos_datos_economicos',
                                 $_id_bancos_tres_datos_economicos,
                                '$_tipo_cuenta_tres_datos_economicos',
                                '$_numero_cuenta_tres_datos_economicos',
                                 $_id_bancos_cuatro_datos_economicos,
                                '$_tipo_cuenta_cuatro_datos_economicos',
                                '$_numero_cuenta_cuatro_datos_economicos',
                                '$_empresa_uno_datos_economicos',
                                '$_direccion_uno_datos_economicos',
                                '$_numero_telefono_uno_datos_economicos',
                                '$_empresa_dos_datos_economicos',
                                '$_direccion_dos_datos_economicos',
                                '$_numero_telefono_dos_datos_economicos',
                                '$_empresa_tres_datos_economicos',
                                '$_direccion_tres_datos_economicos',
                                '$_numero_telefono_tres_datos_economicos',
                                '$_empresa_cuatro_datos_economicos',
                                '$_direccion_cuatro_datos_economicos ',
                                '$_numero_telefono_cuatro_datos_economicos',
                                '$_efectivo_activos_corrientes',
                                '$_bancos_activos_corrientes',
                                '$_cuentas_cobrar_activos_corrientes',
                                '$_inversiones_activos_corrientes',
                                '$_inventarios_activos_corrientes',
                                '$_muebles_activos_corrientes',
                                '$_otros_activos_corrientes',
                                '$_terreno_activos_fijos',
                                '$_vivienda_activos_fijos',
                                '$_vehiculo_activos_fijos',
                                '$_maquinaria_activos_fijos',
                                '$_otros_activos_fijos',
                                '$_valor_prestacion_activos_intangibles',
                                '$_prestamo_menor_anio_pasivo_corriente',
                                '$_prestamo_emergente_pasivo_corriente',
                                '$_cuentas_pagar_pasivo_corriente',
                                '$_proveedores_pasivo_corriente',
                                '$_obligaciones_menores_anio_pasivo_corriente',
                                '$_con_banco_pasivo_corriente',
                                '$_con_cooperativas_pasivo_corriente',
                                '$_prestamo_mayor_anio_pasivos_largo_plazo',
                                '$_obligaciones_mayores_anio_pasivos_largo_plazo',
                                '$_con_banco_pasivos_largo_plazo',
                                '$_con_cooperativas_pasivos_largo_plazo',
                                '$_otros_pasivos_largo_plazo',
                                '$_patrimonio',
                                '$_garantias_capremci',
                                 $_id_bancos_uno_detalle_activos,
                                '$_tipo_producto_uno_detalle_activos',
                                '$_valor_uno_detalle_activos',
                                '$_plazo_uno_detalle_activos',
                                 $_id_bancos_dos_detalle_activos,
                                '$_tipo_producto_dos_detalle_activos',
                                '$_valor_dos_detalle_activos',
                                '$_plazo_dos_detalle_activos',
                                 $_id_bancos_tres_detalle_activos,
                                '$_tipo_producto_tres_detalle_activos',
                                '$_valor_tres_detalle_activos',
                                '$_plazo_tres_detalle_activos',
                                 $_id_bancos_cuatro_detalle_activos,
                                '$_tipo_producto_cuatro_detalle_activos',
                                '$_valor_cuatro_detalle_activos',
                                '$_plazo_cuatro_detalle_activos',
                                '$_muebles_uno_detalle_activos',
                                '$_direccion_uno_detalle_activos',
                                '$_valor_muebles_uno_detalle_activos',
                                '$_esta_hipotecado_uno_detalle_activos',
                                '$_muebles_dos_detalle_activos',
                                '$_direccion_dos_detalle_activos',
                                '$_valor_muebles_dos_detalle_activos',
                                '$_esta_hipotecado_dos_detalle_activos',
                                '$_muebles_tres_detalle_activos',
                                '$_direccion_tres_detalle_activos',
                                '$_valor_muebles_tres_detalle_activos',
                                '$_esta_hipotecado_tres_detalle_activos',
                                '$_muebles_cuatro_detalle_activos',
                                '$_direccion_cuatro_detalle_activos',
                                '$_valor_muebles_cuatro_detalle_activos',
                                '$_esta_hipotecada_cuatro_detalle_activos',
                                '$_vehiculo_uno_detalle_activos',
                                '$_valor_vehiculo_uno_detalle_activos',
                                '$_uso_uno_detalle_activos',
                                '$_asegurado_uno_detalle_activos',
                                '$_vehiculo_dos_detalle_activos',
                                '$_valor_vehiculo_dos_detalle_activos',
                                '$_uso_dos_detalle_activos',
                                '$_asegurado_dos_detalle_activos',
                                '$_vehiculo_tres_detalle_activos',
                                '$_valor_vehiculo_tres_detalle_activos',
                                '$_uso_tres_detalle_activos',
                                '$_asegurado_tres_detalle_activos'";
                            
                            
                            $solicitud_hipotecario->setFuncion($funcionadicionaluno);
                            $solicitud_hipotecario->setParametros($parametros1);
                            $resultado1 = $solicitud_hipotecario->llamafuncionPG();
                            
                            $error="";
                            $error = pg_last_error();
                            if (!empty($error) || (int)$resultado1[0] <= 0){
                                throw new Exception('error ingresando solicitud hipotecario');
                            }
                            
                            
                            
                            $funcionadicionaldos="ins_solicitud_hipotecario_adicional_dos";
                            $parametros2 = " '$id',
                                '$_vehiculo_cuatro_detalle_activos',
                                '$_valor_vehiculo_cuatro_detalle_activos',
                                '$_uso_cuatro_detalle_activos',
                                '$_asegurado_cuatro_detalle_activos',
                                '$_otros_uno_detalle_activos',
                                '$_valor_otros_uno_detalle_activos',
                                '$_observacion_otro_uno_detalle_activos',
                                '$_otros_dos_detalle_activos',
                                '$_valor_otros_dos_detalle_activos',
                                '$_observacion_dos_detalle_activos',
                                '$_institucion_uno_detalle_pasivos',
                                '$_valor_uno_detalle_pasivos',
                                '$_destino_uno_detalle_pasivos',
                                '$_garantia_uno_detalle_pasivos',
                                '$_plazo_uno_detalle_pasivos',
                                '$_saldo_uno_detalle_pasivos',
                                '$_institucion_dos_detalle_pasivos',
                                '$_valor_dos_detalle_pasivos',
                                '$_destino_dos_detalle_pasivos',
                                '$_garantia_dos_detalle_pasivos',
                                '$_plazo_dos_detalle_pasivos',
                                '$_saldo_dos_detalle_pasivos',
                                '$_institucion_tres_detalle_pasivos',
                                '$_valor_tres_detalle_pasivos',
                                '$_destino_tres_detalle_pasivos',
                                '$_garantia_tres_detalle_pasivos',
                                '$_plazo_tres_detalle_pasivos',
                                '$_saldo_tres_detalle_pasivos',
                                '$_institucion_cuatro_detalle_pasivos',
                                '$_valor_cuatro_detalle_pasivos',
                                '$_destino_cuatro_detalle_pasivos',
                                '$_garantia_cuatro_detalle_pasivos',
                                '$_plazo_cuatro_detalle_pasivos',
                                '$_saldo_cuatro_detalle_pasivos',
                                '$_institucion_cinco_detalle_pasivos',
                                '$_valor_cinco_detalle_pasivos',
                                '$_destino_cinco_detalle_pasivos',
                                '$_garantia_cinco_detalle_pasivos',
                                '$_plazo_cinco_detalle_pasivos',
                                '$_saldo_cinco_detalle_pasivos',
                                '$_sueldo_afiliado_ingresos_mensuales',
                                '$_sueldo_conyuge_ingresos_mensuales',
                                '$_comisiones_ingresos_mensuales',
                                '$_arriendos_ingresos_mensuales',
                                '$_dividendos_ingresos_mensuales',
                                '$_ingresos_negocio_ingresos_mensuales',
                                '$_pensiones_ingresos_mensuales',
                                '$_otros_detalle_uno_ingresos_mensuales',
                                '$_otros_uno_ingresos_mensuales',
                                '$_otros_detalle_dos_ingresos_mensuales',
                                '$_otros_dos_ingresos_mensuales',
                                '$_otros_detalle_tres_ingresos_mensuales',
                                '$_otros_tres_ingresos_mensuales',
                                '$_alimentacion_gastos_mensuales',
                                '$_arriendos_gastos_mensuales',
                                '$_educacion_gastos_mensuales',
                                '$_vestuario_gastos_mensuales',
                                '$_servicios_publicos_gastos_mensuales',
                                '$_movilizacion_gastos_mensuales',
                                '$_ahorros_cooperativas_gastos_mensuales',
                                '$_cuotas_tarjetas_gastos_mensuales',
                                '$_cuotas_prestamo_gastos_mensuales',
                                '$_otros_detalle_uno_gastos_mensuales',
                                '$_otros_gastos_uno_gastos_mensuales',
                                '$_id_codigo_verificacion',
                                '$_total_activos_corrientes',
                                '$_total_activos_fijos',
                                '$_total_activos',
                                '$_total_pasivos_corrientes',
                                '$_total_pasivos_largo_plazo',
                                '$_total_pasivos',
                                '$_total_ingresos_mensuales',
                                '$_total_gastos_mensuales',
                                '$_id_usuarios_registra',
                                '$id_oficial_credito',
                                '$_identificador_consecutivos',
                                '$_fecha_presentacion',
                                 null,
                                '$_id_sucursales',
                                '$_numero_patronal_datos_independientes'";
                            
                            
                            $solicitud_hipotecario->setFuncion($funcionadicionaldos);
                            $solicitud_hipotecario->setParametros($parametros2);
                            $resultado2 = $solicitud_hipotecario->llamafuncionPG();
                            
                            
                            
                            
                            
                            $error="";
                            $error = pg_last_error();
                            if (!empty($error) || (int)$resultado2[0] <= 0){
                                throw new Exception('error ingresando solicitud hipotecario');
                            }
                            
                            
                        }
                        
                        
                        $consecutivos->UpdateBy("identificador_consecutivos = identificador_consecutivos+1", "consecutivos", "nombre_consecutivos = 'PRUEBAS'");
                        
                        
                        // envia el correo electronio al señor
                        
                        $solicitud_hipotecario->EnviarMailSolCredHipotecario($_email_datos_personales, $id_oficial_credito, $_nombres_datos_personales, $_apellidos_datos_personales);
                        
                        $solicitud_hipotecario->endTran('COMMIT');
                        
                        
                        echo json_encode(array('id'=>$id,'mensaje'=>"Solicitud Guardada Correctamente"));
                        exit();
                        
                       
                        
                        
                        
                    } catch (Exception $e) {
                        
                        $solicitud_hipotecario->endTran();
                       
                        
                        echo json_encode(array('id'=>0,'mensaje'=>"Error Generando Solicitud ".$e->getMessage()));
                         die();
                        
                    }
                    
                    
                    
                    
                    
                    
                    
                
              
         }
         
         
         
         
        // $this->redirect("SolicitudHipotecario", "index2");
         
         
         
         
        }else{
            
            
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
            $SolicitudHipotecario = new SolicitudHipotecarioModel();
            
            $nombre_controladores = "SolicitudHipotecario";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $SolicitudHipotecario->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
                $this->view("ConsultaSolicitudHipotecario",array(
                    ""=>""
                ));
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de hipotecario."
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
        $Solicitudhipotecario = new SolicitudHipotecarioModel();
        
        $usuarios = new UsuariosModel();
        $id_usuarios=$_SESSION["id_usuarios"];
        
        $where_to="";
        $columnas = "   solicitud_hipotecario.id_solicitud_hipotecario, 
  solicitud_hipotecario.valor_dolares_datos_credito, 
  solicitud_hipotecario.plazo_meses_datos_credito, 
  solicitud_hipotecario.destino_dinero_datos_credito, 
  solicitud_hipotecario.nombres_datos_personales, 
  solicitud_hipotecario.apellidos_datos_personales, 
  solicitud_hipotecario.cedula_datos_personales, 
  sexo.id_sexo, 
  sexo.nombre_sexo, 
  solicitud_hipotecario.fecha_nacimiento_datos_personales, 
  solicitud_hipotecario.separacion_bienes_datos_personales, 
  solicitud_hipotecario.cargas_familiares_datos_personales, 
  solicitud_hipotecario.numero_hijos_datos_personales, 
  solicitud_hipotecario.barrio_datos_personales, 
  solicitud_hipotecario.ciudadela_datos_personales, 
  solicitud_hipotecario.calle_datos_personales, 
  solicitud_hipotecario.numero_calle_datos_personales, 
  solicitud_hipotecario.interseccion_datos_personales, 
  solicitud_hipotecario.tipo_vivienda_datos_personales, 
  solicitud_hipotecario.vivienda_hipotecada_datos_personales, 
  solicitud_hipotecario.tiempo_residencia_datos_personales, 
  solicitud_hipotecario.referencia_domiciliaria_datos_perdonales, 
  solicitud_hipotecario.nombre_arrendatario_datos_personales, 
  solicitud_hipotecario.apellido_arrendatario_datos_personales, 
  solicitud_hipotecario.celular_arrendatario_datos_personales, 
  solicitud_hipotecario.telefono_datos_personales, 
  solicitud_hipotecario.celular_datos_personales, 
  solicitud_hipotecario.telf_trabajo_datos_personales, 
  solicitud_hipotecario.ext_telef_datos_personales, 
  solicitud_hipotecario.node_telef_datos_personales, 
  solicitud_hipotecario.email_datos_personales, 
  solicitud_hipotecario.nivel_educativo_datos_personales, 
  solicitud_hipotecario.nombres_referencia_familiar_datos_personales, 
  solicitud_hipotecario.apellidos_referencia_familiar_datos_personales, 
  solicitud_hipotecario.parentesco_referencia_familiar_datos_personales, 
  solicitud_hipotecario.primer_telefono_ref_familiar_datos_personales, 
  solicitud_hipotecario.segundo_telefono_ref_familiar_datos_personales, 
  solicitud_hipotecario.nombres_referencia_personal_datos_personales, 
  solicitud_hipotecario.apellidos_referencia_personal_datos_personales, 
  solicitud_hipotecario.relacion_referencia_personal_datos_personales, 
  solicitud_hipotecario.primer_telefono_ref_personal_datos_personales, 
  solicitud_hipotecario.segundo_telefono_ref_personal_datos_personales, 
  entidades.id_entidades, 
  entidades.nombre_entidades, 
  solicitud_hipotecario.reparto_unidad_datos_laborales, 
  solicitud_hipotecario.seccion_datos_laborales, 
  solicitud_hipotecario.nombres_jefe_datos_laborales, 
  solicitud_hipotecario.apellidos_jefe_datos_laborales, 
  solicitud_hipotecario.telefono_jefe_datos_laborales, 
  solicitud_hipotecario.calle_datos_laborales, 
  solicitud_hipotecario.numero_calle_datos_laborales, 
  solicitud_hipotecario.interseccion_datos_laborales, 
  solicitud_hipotecario.referencia_direccion_trabajo_datos_laborales, 
  solicitud_hipotecario.cargo_actual_datos_laborales, 
  solicitud_hipotecario.anios_servicio_datos_laborales, 
  solicitud_hipotecario.nombres_datos_conyuge, 
  solicitud_hipotecario.apellidos_datos_conyuge, 
  solicitud_hipotecario.cedula_datos_conyuge, 
  solicitud_hipotecario.fecha_nacimiento_datos_conyuge, 
  solicitud_hipotecario.vive_residencia_datos_conyuge, 
  solicitud_hipotecario.celular_datos_conyuge, 
  solicitud_hipotecario.telefono_datos_conyuge, 
  solicitud_hipotecario.barrio_datos_conyuge, 
  solicitud_hipotecario.ciudadela_datos_conyuge, 
  solicitud_hipotecario.calle_datos_conyuge, 
  solicitud_hipotecario.numero_calle_datos_conyuge, 
  solicitud_hipotecario.interseccion_datos_conyuge, 
  solicitud_hipotecario.actividad_economica_datos_conyuge, 
  solicitud_hipotecario.empresa_datos_conyuge, 
  solicitud_hipotecario.naturaleza_negocio_datos_conyuge, 
  solicitud_hipotecario.cargo_datos_conyuge, 
  solicitud_hipotecario.tipo_contrato_datos_conyuge, 
  solicitud_hipotecario.anios_laborados_datos_conyuge, 
  solicitud_hipotecario.nombres_jefe_datos_conyuge, 
  solicitud_hipotecario.apellidos_jefe_datos_conyuge, 
  solicitud_hipotecario.telefono_jefe_datos_conyuge, 
  solicitud_hipotecario.calle_trabajo_datos_conyuge, 
  solicitud_hipotecario.nuemero_calle_trabajo_datos_conyuge, 
  solicitud_hipotecario.interseccion_trabajo_datos_conyuge, 
  solicitud_hipotecario.referencia_trabajo_datos_conyuge, 
  solicitud_hipotecario.actividad_principal_datos_independientes, 
  solicitud_hipotecario.ruc_datos_independientes, 
  solicitud_hipotecario.detalle_actividades_datos_independientes, 
  solicitud_hipotecario.local_datos_independientes, 
  solicitud_hipotecario.nombres_propietario_datos_independientes, 
  solicitud_hipotecario.apellidos_propietario_datos_independientes, 
  solicitud_hipotecario.telefono_propietario_datos_independientes, 
  solicitud_hipotecario.tiempo_funcionamiento_datos_independientes, 
  solicitud_hipotecario.numero_patronal_datos_independientes, 
  solicitud_hipotecario.numero_empleados_datos_independientes, 
  solicitud_hipotecario.tipo_cuenta_referencia_bancaria, 
  solicitud_hipotecario.numero_cuenta_referencia_bancaria, 
  solicitud_hipotecario.tipo_cuenta_uno_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_uno_datos_economicos, 
  solicitud_hipotecario.tipo_cuenta_dos_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_dos_datos_economicos, 
  solicitud_hipotecario.tipo_cuenta_tres_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_tres_datos_economicos, 
  solicitud_hipotecario.tipo_cuenta_cuatro_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_cuatro_datos_economicos, 
  solicitud_hipotecario.empresa_uno_datos_economicos, 
  solicitud_hipotecario.direccion_uno_datos_economicos, 
  solicitud_hipotecario.numero_telefono_uno_datos_economicos, 
  solicitud_hipotecario.empresa_dos_datos_economicos, 
  solicitud_hipotecario.direccion_dos_datos_economicos, 
  solicitud_hipotecario.numero_telefono_dos_datos_economicos, 
  solicitud_hipotecario.empresa_tres_datos_economicos, 
  solicitud_hipotecario.direccion_tres_datos_economicos, 
  solicitud_hipotecario.numero_telefono_tres_datos_economicos, 
  solicitud_hipotecario.empresa_cuatro_datos_economicos, 
  solicitud_hipotecario.direccion_cuatro_datos_economicos, 
  solicitud_hipotecario.numero_telefono_cuatro_datos_economicos, 
  solicitud_hipotecario.efectivo_activos_corrientes, 
  solicitud_hipotecario.bancos_activos_corrientes, 
  solicitud_hipotecario.cuentas_cobrar_activos_corrientes, 
  solicitud_hipotecario.inversiones_activos_corrientes, 
  solicitud_hipotecario.inventarios_activos_corrientes, 
  solicitud_hipotecario.muebles_activos_corrientes, 
  solicitud_hipotecario.otros_activos_corrientes, 
  solicitud_hipotecario.terreno_activos_fijos, 
  solicitud_hipotecario.vivienda_activos_fijos, 
  solicitud_hipotecario.vehiculo_activos_fijos, 
  solicitud_hipotecario.maquinaria_activos_fijos, 
  solicitud_hipotecario.otros_activos_fijos, 
  solicitud_hipotecario.valor_prestacion_activos_intangibles, 
  solicitud_hipotecario.prestamo_menor_anio_pasivo_corriente, 
  solicitud_hipotecario.prestamo_emergente_pasivo_corriente, 
  solicitud_hipotecario.cuentas_pagar_pasivo_corriente, 
  solicitud_hipotecario.proveedores_pasivo_corriente, 
  solicitud_hipotecario.obligaciones_menores_anio_pasivo_corriente, 
  solicitud_hipotecario.con_banco_pasivo_corriente, 
  solicitud_hipotecario.con_cooperativas_pasivo_corriente, 
  solicitud_hipotecario.prestamo_mayor_anio_pasivos_largo_plazo, 
  solicitud_hipotecario.obligaciones_mayores_anio_pasivos_largo_plazo, 
  solicitud_hipotecario.con_banco_pasivos_largo_plazo, 
  solicitud_hipotecario.con_cooperativas_pasivos_largo_plazo, 
  solicitud_hipotecario.otros_pasivos_largo_plazo, 
  solicitud_hipotecario.patrimonio, 
  solicitud_hipotecario.garantias_capremci, 
  solicitud_hipotecario.tipo_producto_uno_detalle_activos, 
  solicitud_hipotecario.valor_uno_detalle_activos, 
  solicitud_hipotecario.plazo_uno_detalle_activos, 
  solicitud_hipotecario.tipo_producto_dos_detalle_activos, 
  solicitud_hipotecario.valor_dos_detalle_activos, 
  solicitud_hipotecario.plazo_dos_detalle_activos, 
  solicitud_hipotecario.tipo_producto_tres_detalle_activos, 
  solicitud_hipotecario.valor_tres_detalle_activos, 
  solicitud_hipotecario.plazo_tres_detalle_activos, 
  solicitud_hipotecario.tipo_producto_cuatro_detalle_activos, 
  solicitud_hipotecario.valor_cuatro_detalle_activos, 
  solicitud_hipotecario.plazo_cuatro_detalle_activos, 
  solicitud_hipotecario.muebles_uno_detalle_activos, 
  solicitud_hipotecario.direccion_uno_detalle_activos, 
  solicitud_hipotecario.valor_muebles_uno_detalle_activos, 
  solicitud_hipotecario.esta_hipotecado_uno_detalle_activos, 
  solicitud_hipotecario.muebles_dos_detalle_activos, 
  solicitud_hipotecario.direccion_dos_detalle_activos, 
  solicitud_hipotecario.valor_muebles_dos_detalle_activos, 
  solicitud_hipotecario.esta_hipotecado_dos_detalle_activos, 
  solicitud_hipotecario.muebles_tres_detalle_activos, 
  solicitud_hipotecario.direccion_tres_detalle_activos, 
  solicitud_hipotecario.valor_muebles_tres_detalle_activos, 
  solicitud_hipotecario.esta_hipotecado_tres_detalle_activos, 
  solicitud_hipotecario.muebles_cuatro_detalle_activos, 
  solicitud_hipotecario.direccion_cuatro_detalle_activos, 
  solicitud_hipotecario.valor_muebles_cuatro_detalle_activos, 
  solicitud_hipotecario.esta_hipotecada_cuatro_detalle_activos, 
  solicitud_hipotecario.vehiculo_uno_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_uno_detalle_activos, 
  solicitud_hipotecario.uso_uno_detalle_activos, 
  solicitud_hipotecario.asegurado_uno_detalle_activos, 
  solicitud_hipotecario.vehiculo_dos_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_dos_detalle_activos, 
  solicitud_hipotecario.uso_dos_detalle_activos, 
  solicitud_hipotecario.asegurado_dos_detalle_activos, 
  solicitud_hipotecario.vehiculo_tres_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_tres_detalle_activos, 
  solicitud_hipotecario.uso_tres_detalle_activos, 
  solicitud_hipotecario.asegurado_tres_detalle_activos, 
  solicitud_hipotecario.vehiculo_cuatro_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_cuatro_detalle_activos, 
  solicitud_hipotecario.uso_cuatro_detalle_activos, 
  solicitud_hipotecario.asegurado_cuatro_detalle_activos, 
  solicitud_hipotecario.otros_uno_detalle_activos, 
  solicitud_hipotecario.valor_otros_uno_detalle_activos, 
  solicitud_hipotecario.observacion_otro_uno_detalle_activos, 
  solicitud_hipotecario.otros_dos_detalle_activos, 
  solicitud_hipotecario.valor_otros_dos_detalle_activos, 
  solicitud_hipotecario.observacion_dos_detalle_activos, 
  solicitud_hipotecario.institucion_uno_detalle_pasivos, 
  solicitud_hipotecario.valor_uno_detalle_pasivos, 
  solicitud_hipotecario.destino_uno_detalle_pasivos, 
  solicitud_hipotecario.garantia_uno_detalle_pasivos, 
  solicitud_hipotecario.plazo_uno_detalle_pasivos, 
  solicitud_hipotecario.saldo_uno_detalle_pasivos, 
  solicitud_hipotecario.institucion_dos_detalle_pasivos, 
  solicitud_hipotecario.valor_dos_detalle_pasivos, 
  solicitud_hipotecario.destino_dos_detalle_pasivos, 
  solicitud_hipotecario.garantia_dos_detalle_pasivos, 
  solicitud_hipotecario.plazo_dos_detalle_pasivos, 
  solicitud_hipotecario.saldo_dos_detalle_pasivos, 
  solicitud_hipotecario.institucion_tres_detalle_pasivos, 
  solicitud_hipotecario.valor_tres_detalle_pasivos, 
  solicitud_hipotecario.destino_tres_detalle_pasivos, 
  solicitud_hipotecario.garantia_tres_detalle_pasivos, 
  solicitud_hipotecario.plazo_tres_detalle_pasivos, 
  solicitud_hipotecario.saldo_tres_detalle_pasivos, 
  solicitud_hipotecario.institucion_cuatro_detalle_pasivos, 
  solicitud_hipotecario.valor_cuatro_detalle_pasivos, 
  solicitud_hipotecario.destino_cuatro_detalle_pasivos, 
  solicitud_hipotecario.garantia_cuatro_detalle_pasivos, 
  solicitud_hipotecario.plazo_cuatro_detalle_pasivos, 
  solicitud_hipotecario.saldo_cuatro_detalle_pasivos, 
  solicitud_hipotecario.institucion_cinco_detalle_pasivos, 
  solicitud_hipotecario.valor_cinco_detalle_pasivos, 
  solicitud_hipotecario.destino_cinco_detalle_pasivos, 
  solicitud_hipotecario.garantia_cinco_detalle_pasivos, 
  solicitud_hipotecario.plazo_cinco_detalle_pasivos, 
  solicitud_hipotecario.saldo_cinco_detalle_pasivos, 
  solicitud_hipotecario.sueldo_afiliado_ingresos_mensuales, 
  solicitud_hipotecario.sueldo_conyuge_ingresos_mensuales, 
  solicitud_hipotecario.comisiones_ingresos_mensuales, 
  solicitud_hipotecario.arriendos_ingresos_mensuales, 
  solicitud_hipotecario.dividendos_ingresos_mensuales, 
  solicitud_hipotecario.ingresos_negocio_ingresos_mensuales, 
  solicitud_hipotecario.pensiones_ingresos_mensuales, 
  solicitud_hipotecario.otros_detalle_uno_ingresos_mensuales, 
  solicitud_hipotecario.otros_uno_ingresos_mensuales, 
  solicitud_hipotecario.otros_detalle_dos_ingresos_mensuales, 
  solicitud_hipotecario.otros_dos_ingresos_mensuales, 
  solicitud_hipotecario.otros_detalle_tres_ingresos_mensuales, 
  solicitud_hipotecario.otros_tres_ingresos_mensuales, 
  solicitud_hipotecario.alimentacion_gastos_mensuales, 
  solicitud_hipotecario.arriendos_gastos_mensuales, 
  solicitud_hipotecario.educacion_gastos_mensuales, 
  solicitud_hipotecario.vestuario_gastos_mensuales, 
  solicitud_hipotecario.servicios_publicos_gastos_mensuales, 
  solicitud_hipotecario.movilizacion_gastos_mensuales, 
  solicitud_hipotecario.ahorros_cooperativas_gastos_mensuales, 
  solicitud_hipotecario.cuotas_tarjetas_gastos_mensuales, 
  solicitud_hipotecario.cuotas_prestamo_gastos_mensuales, 
  solicitud_hipotecario.otros_detalle_uno_gastos_mensuales, 
  solicitud_hipotecario.otros_gastos_uno_gastos_mensuales, 
  solicitud_hipotecario.total_activos_corrientes, 
  solicitud_hipotecario.total_activos_fijos, 
  solicitud_hipotecario.total_activos, 
  solicitud_hipotecario.total_pasivos_corrientes, 
  solicitud_hipotecario.total_pasivos_largo_plazo, 
  solicitud_hipotecario.total_pasivos, 
  solicitud_hipotecario.total_ingresos_mensuales, 
  solicitud_hipotecario.total_gastos_mensuales, 
  solicitud_hipotecario.identificador_consecutivos, 
  solicitud_hipotecario.fecha_presentacion, 
  solicitud_hipotecario.fecha_aprobacion, 
  sucursales.id_sucursales, 
  sucursales.nombre_sucursales, 
  estado_civil.id_estado_civil, 
  estado_civil.nombre_estado_civil, 
  solicitud_hipotecario.id_provincia, 
  solicitud_hipotecario.id_canton, 
  solicitud_hipotecario.id_parroquia, 
  solicitud_hipotecario.id_provincia_datos_laborales, 
  solicitud_hipotecario.id_canton_datos_laborales, 
  solicitud_hipotecario.id_parroquia_datos_laborales, 
  solicitud_hipotecario.id_sexo_datos_conyuge, 
  solicitud_hipotecario.id_provincia_datos_conyuge, 
  solicitud_hipotecario.id_canton_datos_conyuge, 
  solicitud_hipotecario.id_parroquia_datos_conyuge, 
  solicitud_hipotecario.id_provincia_trabajo_datos_conyuge, 
  solicitud_hipotecario.id_canton_trabajo_datos_conyuge, 
  solicitud_hipotecario.id_parroquia_trabajo_datos_conyuge, 
  solicitud_hipotecario.id_bancos_referencia_bancaria, 
  solicitud_hipotecario.id_bancos_uno_datos_economicos, 
  solicitud_hipotecario.id_bancos_dos_datos_economicos, 
  solicitud_hipotecario.id_bancos_tres_datos_economicos, 
  solicitud_hipotecario.id_bancos_cuatro_datos_economicos, 
  solicitud_hipotecario.id_bancos_uno_detalle_activos, 
  solicitud_hipotecario.id_bancos_dos_detalle_activos, 
  solicitud_hipotecario.id_bancos_tres_detalle_activos, 
  solicitud_hipotecario.id_bancos_cuatro_detalle_activos, 
  solicitud_hipotecario.id_usuarios_registra, 
  usuarios.id_usuarios, 
  usuarios.cedula_usuarios, 
  usuarios.nombre_usuarios, 
  usuarios.correo_usuarios,
  solicitud_hipotecario.id_estado_tramites";
        
        $tablas   = "  	  public.solicitud_hipotecario, 
	  public.sexo, 
	  public.entidades, 
	  public.sucursales, 
	  public.estado_civil, 
	  public.usuarios
";
        
        $where    = "    sexo.id_sexo = solicitud_hipotecario.id_sexo AND
  entidades.id_entidades = solicitud_hipotecario.id_entidades AND
  sucursales.id_sucursales = solicitud_hipotecario.id_sucursales AND
  estado_civil.id_estado_civil = solicitud_hipotecario.id_estado_civil AND
  usuarios.id_usuarios = solicitud_hipotecario.id_usuarios_oficial_credito_aprueba AND solicitud_hipotecario.id_usuarios_registra='$id_usuarios'";
        
        $id       = "solicitud_hipotecario.id_solicitud_hipotecario";
        
        
        $where_to=$where;
        
        
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        
        
        if($action == 'ajax')
        {
            $html="";
            $resultSet=$Solicitudhipotecario->getCantidad("*", $tablas, $where_to);
            $cantidadResult=(int)$resultSet[0]->total;
            
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
            
            $per_page = 10; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            
            $limit = " LIMIT   '$per_page' OFFSET '$offset'";
            
            $resultSet=$Solicitudhipotecario->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
                $html.= "<table id='tabla_solicitud_hipotecrio_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
                $html.= "<thead>";
                $html.= "<tr>";
                
                $html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
                $html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
                $html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
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
                    
                    $html.='<td style="font-size: 11px;">'.$res->cedula_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->apellidos_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->nombres_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_presentacion)).'</td>';
                    $html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
                    if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
                        $html.='<td style="font-size: 11px;"></td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudHipotecario&action=index&id_solicitud_hipotecario='.$res->id_solicitud_hipotecario.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                    }else{
                        $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" title="Editar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                    }
                    $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudHipotecario&action=print&id_solicitud_hipotecario='.$res->id_solicitud_hipotecario.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
                    
                    $html.='</tr>';
                    
                }
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section></div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_load_solicitud_hipotecario_registrados("index.php", $page, $total_pages, $adjacents).'';
                $html.='</div>';
                
                
            }else{
                $html.='<div class="col-lg-6 col-md-6 col-xs-12">';
                $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
                $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                $html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de hipotecario registrados...</b>';
                $html.='</div>';
                $html.='</div>';
            }
            
            echo $html;
            die();
            
        }
        
        
    }
    
    
    
    public function paginate_load_solicitud_hipotecario_registrados($reload, $page, $tpages, $adjacents) {
        
        
        
        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $out = '<ul class="pagination pagination-large">';
        
        // previous label
        
        if($page==1) {
            $out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
        } else if($page==2) {
            $out.= "<li><span><a href='javascript:void(0);' onclick='solicitud_hipotecario_registrados(1)'>$prevlabel</a></span></li>";
        }else {
            $out.= "<li><span><a href='javascript:void(0);' onclick='solicitud_hipotecario_registrados(".($page-1).")'>$prevlabel</a></span></li>";
            
        }
        
        // first label
        if($page>($adjacents+1)) {
            $out.= "<li><a href='javascript:void(0);' onclick='solicitud_hipotecario_registrados(1)'>1</a></li>";
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
                $out.= "<li><a href='javascript:void(0);' onclick='solicitud_hipotecario_registrados(1)'>$i</a></li>";
            }else {
                $out.= "<li><a href='javascript:void(0);' onclick='solicitud_hipotecario_registrados(".$i.")'>$i</a></li>";
            }
        }
        
        // interval
        
        if($page<($tpages-$adjacents-1)) {
            $out.= "<li><a>...</a></li>";
        }
        
        // last
        
        if($page<($tpages-$adjacents)) {
            $out.= "<li><a href='javascript:void(0);' onclick='solicitud_hipotecario_registrados($tpages)'>$tpages</a></li>";
        }
        
        // next
        
        if($page<$tpages) {
            $out.= "<li><span><a href='javascript:void(0);' onclick='solicitud_hipotecario_registrados(".($page+1).")'>$nextlabel</a></span></li>";
        }else {
            $out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
        }
        
        $out.= "</ul>";
        return $out;
        
        
    }
    
    public function index3(){
        
        
        session_start();
        if (isset(  $_SESSION['nombre_usuarios']) )
        {
            
            $SolicitudHipotecario = new SolicitudHipotecarioModel();
            
            $nombre_controladores = "SolicitudHipotecario";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $SolicitudHipotecario->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
                
                if(isset($_GET["id_solicitud_prestamo_a"])){
                    
                    $_id_solicitud_prestamo= $_GET["id_solicitud_prestamo_a"];
                    $_fecha_actual =    getdate();
                    $_fecha_año    =	$_fecha_actual['year'];
                    $_fecha_mes    =	$_fecha_actual['mon'];
                    $_fecha_dia    =	$_fecha_actual['mday'];
                    
                    $_fecha_aprobacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
                    
                    $colval_afi = "fecha_aprobacion='$_fecha_aprobacion', id_estado_tramites=2";
                    $tabla_afi = "solicitud_hipotecario";
                    $where_afi = "id_solicitud_hipotecario = '$_id_solicitud_prestamo'";
                    $resultado1=$SolicitudHipotecario->UpdateBy($colval_afi, $tabla_afi, $where_afi);
                    
                    
                    $this->redirect("SolicitudHipotecario", "index3");
                    
                }
                
                
                if(isset($_GET["id_solicitud_prestamo_r"])){
                    
                    $_id_solicitud_prestamo= $_GET["id_solicitud_prestamo_r"];
                    $_fecha_actual =    getdate();
                    $_fecha_año    =	$_fecha_actual['year'];
                    $_fecha_mes    =	$_fecha_actual['mon'];
                    $_fecha_dia    =	$_fecha_actual['mday'];
                    
                    $_fecha_aprobacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
                    
                    $colval_afi = "fecha_aprobacion='$_fecha_aprobacion', id_estado_tramites=3";
                    $tabla_afi = "solicitud_hipotecario";
                    $where_afi = "id_solicitud_hipotecario = '$_id_solicitud_prestamo'";
                    $resultado1=$SolicitudHipotecario->UpdateBy($colval_afi, $tabla_afi, $where_afi);
                    
                    $this->redirect("SolicitudHipotecario", "index3");
                    
                }
                
                $this->view("ConsultaSolicitudHipotecarioAdmin",array(
                    ""=>""
                ));
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a consultar una solicitud Hipotecario."
                    
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
        $SolicitudHipotecario = new SolicitudHipotecarioModel();
        $usuarios = new UsuariosModel();
        $id_usuarios=$_SESSION["id_usuarios"];
        
        $where_to="";
        
        
        $columnas = "   solicitud_hipotecario.id_solicitud_hipotecario, 
  solicitud_hipotecario.valor_dolares_datos_credito, 
  solicitud_hipotecario.plazo_meses_datos_credito, 
  solicitud_hipotecario.destino_dinero_datos_credito, 
  solicitud_hipotecario.nombres_datos_personales, 
  solicitud_hipotecario.apellidos_datos_personales, 
  solicitud_hipotecario.cedula_datos_personales, 
  sexo.id_sexo, 
  sexo.nombre_sexo, 
  solicitud_hipotecario.fecha_nacimiento_datos_personales, 
  solicitud_hipotecario.separacion_bienes_datos_personales, 
  solicitud_hipotecario.cargas_familiares_datos_personales, 
  solicitud_hipotecario.numero_hijos_datos_personales, 
  solicitud_hipotecario.barrio_datos_personales, 
  solicitud_hipotecario.ciudadela_datos_personales, 
  solicitud_hipotecario.calle_datos_personales, 
  solicitud_hipotecario.numero_calle_datos_personales, 
  solicitud_hipotecario.interseccion_datos_personales, 
  solicitud_hipotecario.tipo_vivienda_datos_personales, 
  solicitud_hipotecario.vivienda_hipotecada_datos_personales, 
  solicitud_hipotecario.tiempo_residencia_datos_personales, 
  solicitud_hipotecario.referencia_domiciliaria_datos_perdonales, 
  solicitud_hipotecario.nombre_arrendatario_datos_personales, 
  solicitud_hipotecario.apellido_arrendatario_datos_personales, 
  solicitud_hipotecario.celular_arrendatario_datos_personales, 
  solicitud_hipotecario.telefono_datos_personales, 
  solicitud_hipotecario.celular_datos_personales, 
  solicitud_hipotecario.telf_trabajo_datos_personales, 
  solicitud_hipotecario.ext_telef_datos_personales, 
  solicitud_hipotecario.node_telef_datos_personales, 
  solicitud_hipotecario.email_datos_personales, 
  solicitud_hipotecario.nivel_educativo_datos_personales, 
  solicitud_hipotecario.nombres_referencia_familiar_datos_personales, 
  solicitud_hipotecario.apellidos_referencia_familiar_datos_personales, 
  solicitud_hipotecario.parentesco_referencia_familiar_datos_personales, 
  solicitud_hipotecario.primer_telefono_ref_familiar_datos_personales, 
  solicitud_hipotecario.segundo_telefono_ref_familiar_datos_personales, 
  solicitud_hipotecario.nombres_referencia_personal_datos_personales, 
  solicitud_hipotecario.apellidos_referencia_personal_datos_personales, 
  solicitud_hipotecario.relacion_referencia_personal_datos_personales, 
  solicitud_hipotecario.primer_telefono_ref_personal_datos_personales, 
  solicitud_hipotecario.segundo_telefono_ref_personal_datos_personales, 
  entidades.id_entidades, 
  entidades.nombre_entidades, 
  solicitud_hipotecario.reparto_unidad_datos_laborales, 
  solicitud_hipotecario.seccion_datos_laborales, 
  solicitud_hipotecario.nombres_jefe_datos_laborales, 
  solicitud_hipotecario.apellidos_jefe_datos_laborales, 
  solicitud_hipotecario.telefono_jefe_datos_laborales, 
  solicitud_hipotecario.calle_datos_laborales, 
  solicitud_hipotecario.numero_calle_datos_laborales, 
  solicitud_hipotecario.interseccion_datos_laborales, 
  solicitud_hipotecario.referencia_direccion_trabajo_datos_laborales, 
  solicitud_hipotecario.cargo_actual_datos_laborales, 
  solicitud_hipotecario.anios_servicio_datos_laborales, 
  solicitud_hipotecario.nombres_datos_conyuge, 
  solicitud_hipotecario.apellidos_datos_conyuge, 
  solicitud_hipotecario.cedula_datos_conyuge, 
  solicitud_hipotecario.fecha_nacimiento_datos_conyuge, 
  solicitud_hipotecario.vive_residencia_datos_conyuge, 
  solicitud_hipotecario.celular_datos_conyuge, 
  solicitud_hipotecario.telefono_datos_conyuge, 
  solicitud_hipotecario.barrio_datos_conyuge, 
  solicitud_hipotecario.ciudadela_datos_conyuge, 
  solicitud_hipotecario.calle_datos_conyuge, 
  solicitud_hipotecario.numero_calle_datos_conyuge, 
  solicitud_hipotecario.interseccion_datos_conyuge, 
  solicitud_hipotecario.actividad_economica_datos_conyuge, 
  solicitud_hipotecario.empresa_datos_conyuge, 
  solicitud_hipotecario.naturaleza_negocio_datos_conyuge, 
  solicitud_hipotecario.cargo_datos_conyuge, 
  solicitud_hipotecario.tipo_contrato_datos_conyuge, 
  solicitud_hipotecario.anios_laborados_datos_conyuge, 
  solicitud_hipotecario.nombres_jefe_datos_conyuge, 
  solicitud_hipotecario.apellidos_jefe_datos_conyuge, 
  solicitud_hipotecario.telefono_jefe_datos_conyuge, 
  solicitud_hipotecario.calle_trabajo_datos_conyuge, 
  solicitud_hipotecario.nuemero_calle_trabajo_datos_conyuge, 
  solicitud_hipotecario.interseccion_trabajo_datos_conyuge, 
  solicitud_hipotecario.referencia_trabajo_datos_conyuge, 
  solicitud_hipotecario.actividad_principal_datos_independientes, 
  solicitud_hipotecario.ruc_datos_independientes, 
  solicitud_hipotecario.detalle_actividades_datos_independientes, 
  solicitud_hipotecario.local_datos_independientes, 
  solicitud_hipotecario.nombres_propietario_datos_independientes, 
  solicitud_hipotecario.apellidos_propietario_datos_independientes, 
  solicitud_hipotecario.telefono_propietario_datos_independientes, 
  solicitud_hipotecario.tiempo_funcionamiento_datos_independientes, 
  solicitud_hipotecario.numero_patronal_datos_independientes, 
  solicitud_hipotecario.numero_empleados_datos_independientes, 
  solicitud_hipotecario.tipo_cuenta_referencia_bancaria, 
  solicitud_hipotecario.numero_cuenta_referencia_bancaria, 
  solicitud_hipotecario.tipo_cuenta_uno_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_uno_datos_economicos, 
  solicitud_hipotecario.tipo_cuenta_dos_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_dos_datos_economicos, 
  solicitud_hipotecario.tipo_cuenta_tres_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_tres_datos_economicos, 
  solicitud_hipotecario.tipo_cuenta_cuatro_datos_economicos, 
  solicitud_hipotecario.numero_cuenta_cuatro_datos_economicos, 
  solicitud_hipotecario.empresa_uno_datos_economicos, 
  solicitud_hipotecario.direccion_uno_datos_economicos, 
  solicitud_hipotecario.numero_telefono_uno_datos_economicos, 
  solicitud_hipotecario.empresa_dos_datos_economicos, 
  solicitud_hipotecario.direccion_dos_datos_economicos, 
  solicitud_hipotecario.numero_telefono_dos_datos_economicos, 
  solicitud_hipotecario.empresa_tres_datos_economicos, 
  solicitud_hipotecario.direccion_tres_datos_economicos, 
  solicitud_hipotecario.numero_telefono_tres_datos_economicos, 
  solicitud_hipotecario.empresa_cuatro_datos_economicos, 
  solicitud_hipotecario.direccion_cuatro_datos_economicos, 
  solicitud_hipotecario.numero_telefono_cuatro_datos_economicos, 
  solicitud_hipotecario.efectivo_activos_corrientes, 
  solicitud_hipotecario.bancos_activos_corrientes, 
  solicitud_hipotecario.cuentas_cobrar_activos_corrientes, 
  solicitud_hipotecario.inversiones_activos_corrientes, 
  solicitud_hipotecario.inventarios_activos_corrientes, 
  solicitud_hipotecario.muebles_activos_corrientes, 
  solicitud_hipotecario.otros_activos_corrientes, 
  solicitud_hipotecario.terreno_activos_fijos, 
  solicitud_hipotecario.vivienda_activos_fijos, 
  solicitud_hipotecario.vehiculo_activos_fijos, 
  solicitud_hipotecario.maquinaria_activos_fijos, 
  solicitud_hipotecario.otros_activos_fijos, 
  solicitud_hipotecario.valor_prestacion_activos_intangibles, 
  solicitud_hipotecario.prestamo_menor_anio_pasivo_corriente, 
  solicitud_hipotecario.prestamo_emergente_pasivo_corriente, 
  solicitud_hipotecario.cuentas_pagar_pasivo_corriente, 
  solicitud_hipotecario.proveedores_pasivo_corriente, 
  solicitud_hipotecario.obligaciones_menores_anio_pasivo_corriente, 
  solicitud_hipotecario.con_banco_pasivo_corriente, 
  solicitud_hipotecario.con_cooperativas_pasivo_corriente, 
  solicitud_hipotecario.prestamo_mayor_anio_pasivos_largo_plazo, 
  solicitud_hipotecario.obligaciones_mayores_anio_pasivos_largo_plazo, 
  solicitud_hipotecario.con_banco_pasivos_largo_plazo, 
  solicitud_hipotecario.con_cooperativas_pasivos_largo_plazo, 
  solicitud_hipotecario.otros_pasivos_largo_plazo, 
  solicitud_hipotecario.patrimonio, 
  solicitud_hipotecario.garantias_capremci, 
  solicitud_hipotecario.tipo_producto_uno_detalle_activos, 
  solicitud_hipotecario.valor_uno_detalle_activos, 
  solicitud_hipotecario.plazo_uno_detalle_activos, 
  solicitud_hipotecario.tipo_producto_dos_detalle_activos, 
  solicitud_hipotecario.valor_dos_detalle_activos, 
  solicitud_hipotecario.plazo_dos_detalle_activos, 
  solicitud_hipotecario.tipo_producto_tres_detalle_activos, 
  solicitud_hipotecario.valor_tres_detalle_activos, 
  solicitud_hipotecario.plazo_tres_detalle_activos, 
  solicitud_hipotecario.tipo_producto_cuatro_detalle_activos, 
  solicitud_hipotecario.valor_cuatro_detalle_activos, 
  solicitud_hipotecario.plazo_cuatro_detalle_activos, 
  solicitud_hipotecario.muebles_uno_detalle_activos, 
  solicitud_hipotecario.direccion_uno_detalle_activos, 
  solicitud_hipotecario.valor_muebles_uno_detalle_activos, 
  solicitud_hipotecario.esta_hipotecado_uno_detalle_activos, 
  solicitud_hipotecario.muebles_dos_detalle_activos, 
  solicitud_hipotecario.direccion_dos_detalle_activos, 
  solicitud_hipotecario.valor_muebles_dos_detalle_activos, 
  solicitud_hipotecario.esta_hipotecado_dos_detalle_activos, 
  solicitud_hipotecario.muebles_tres_detalle_activos, 
  solicitud_hipotecario.direccion_tres_detalle_activos, 
  solicitud_hipotecario.valor_muebles_tres_detalle_activos, 
  solicitud_hipotecario.esta_hipotecado_tres_detalle_activos, 
  solicitud_hipotecario.muebles_cuatro_detalle_activos, 
  solicitud_hipotecario.direccion_cuatro_detalle_activos, 
  solicitud_hipotecario.valor_muebles_cuatro_detalle_activos, 
  solicitud_hipotecario.esta_hipotecada_cuatro_detalle_activos, 
  solicitud_hipotecario.vehiculo_uno_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_uno_detalle_activos, 
  solicitud_hipotecario.uso_uno_detalle_activos, 
  solicitud_hipotecario.asegurado_uno_detalle_activos, 
  solicitud_hipotecario.vehiculo_dos_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_dos_detalle_activos, 
  solicitud_hipotecario.uso_dos_detalle_activos, 
  solicitud_hipotecario.asegurado_dos_detalle_activos, 
  solicitud_hipotecario.vehiculo_tres_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_tres_detalle_activos, 
  solicitud_hipotecario.uso_tres_detalle_activos, 
  solicitud_hipotecario.asegurado_tres_detalle_activos, 
  solicitud_hipotecario.vehiculo_cuatro_detalle_activos, 
  solicitud_hipotecario.valor_vehiculo_cuatro_detalle_activos, 
  solicitud_hipotecario.uso_cuatro_detalle_activos, 
  solicitud_hipotecario.asegurado_cuatro_detalle_activos, 
  solicitud_hipotecario.otros_uno_detalle_activos, 
  solicitud_hipotecario.valor_otros_uno_detalle_activos, 
  solicitud_hipotecario.observacion_otro_uno_detalle_activos, 
  solicitud_hipotecario.otros_dos_detalle_activos, 
  solicitud_hipotecario.valor_otros_dos_detalle_activos, 
  solicitud_hipotecario.observacion_dos_detalle_activos, 
  solicitud_hipotecario.institucion_uno_detalle_pasivos, 
  solicitud_hipotecario.valor_uno_detalle_pasivos, 
  solicitud_hipotecario.destino_uno_detalle_pasivos, 
  solicitud_hipotecario.garantia_uno_detalle_pasivos, 
  solicitud_hipotecario.plazo_uno_detalle_pasivos, 
  solicitud_hipotecario.saldo_uno_detalle_pasivos, 
  solicitud_hipotecario.institucion_dos_detalle_pasivos, 
  solicitud_hipotecario.valor_dos_detalle_pasivos, 
  solicitud_hipotecario.destino_dos_detalle_pasivos, 
  solicitud_hipotecario.garantia_dos_detalle_pasivos, 
  solicitud_hipotecario.plazo_dos_detalle_pasivos, 
  solicitud_hipotecario.saldo_dos_detalle_pasivos, 
  solicitud_hipotecario.institucion_tres_detalle_pasivos, 
  solicitud_hipotecario.valor_tres_detalle_pasivos, 
  solicitud_hipotecario.destino_tres_detalle_pasivos, 
  solicitud_hipotecario.garantia_tres_detalle_pasivos, 
  solicitud_hipotecario.plazo_tres_detalle_pasivos, 
  solicitud_hipotecario.saldo_tres_detalle_pasivos, 
  solicitud_hipotecario.institucion_cuatro_detalle_pasivos, 
  solicitud_hipotecario.valor_cuatro_detalle_pasivos, 
  solicitud_hipotecario.destino_cuatro_detalle_pasivos, 
  solicitud_hipotecario.garantia_cuatro_detalle_pasivos, 
  solicitud_hipotecario.plazo_cuatro_detalle_pasivos, 
  solicitud_hipotecario.saldo_cuatro_detalle_pasivos, 
  solicitud_hipotecario.institucion_cinco_detalle_pasivos, 
  solicitud_hipotecario.valor_cinco_detalle_pasivos, 
  solicitud_hipotecario.destino_cinco_detalle_pasivos, 
  solicitud_hipotecario.garantia_cinco_detalle_pasivos, 
  solicitud_hipotecario.plazo_cinco_detalle_pasivos, 
  solicitud_hipotecario.saldo_cinco_detalle_pasivos, 
  solicitud_hipotecario.sueldo_afiliado_ingresos_mensuales, 
  solicitud_hipotecario.sueldo_conyuge_ingresos_mensuales, 
  solicitud_hipotecario.comisiones_ingresos_mensuales, 
  solicitud_hipotecario.arriendos_ingresos_mensuales, 
  solicitud_hipotecario.dividendos_ingresos_mensuales, 
  solicitud_hipotecario.ingresos_negocio_ingresos_mensuales, 
  solicitud_hipotecario.pensiones_ingresos_mensuales, 
  solicitud_hipotecario.otros_detalle_uno_ingresos_mensuales, 
  solicitud_hipotecario.otros_uno_ingresos_mensuales, 
  solicitud_hipotecario.otros_detalle_dos_ingresos_mensuales, 
  solicitud_hipotecario.otros_dos_ingresos_mensuales, 
  solicitud_hipotecario.otros_detalle_tres_ingresos_mensuales, 
  solicitud_hipotecario.otros_tres_ingresos_mensuales, 
  solicitud_hipotecario.alimentacion_gastos_mensuales, 
  solicitud_hipotecario.arriendos_gastos_mensuales, 
  solicitud_hipotecario.educacion_gastos_mensuales, 
  solicitud_hipotecario.vestuario_gastos_mensuales, 
  solicitud_hipotecario.servicios_publicos_gastos_mensuales, 
  solicitud_hipotecario.movilizacion_gastos_mensuales, 
  solicitud_hipotecario.ahorros_cooperativas_gastos_mensuales, 
  solicitud_hipotecario.cuotas_tarjetas_gastos_mensuales, 
  solicitud_hipotecario.cuotas_prestamo_gastos_mensuales, 
  solicitud_hipotecario.otros_detalle_uno_gastos_mensuales, 
  solicitud_hipotecario.otros_gastos_uno_gastos_mensuales, 
  solicitud_hipotecario.total_activos_corrientes, 
  solicitud_hipotecario.total_activos_fijos, 
  solicitud_hipotecario.total_activos, 
  solicitud_hipotecario.total_pasivos_corrientes, 
  solicitud_hipotecario.total_pasivos_largo_plazo, 
  solicitud_hipotecario.total_pasivos, 
  solicitud_hipotecario.total_ingresos_mensuales, 
  solicitud_hipotecario.total_gastos_mensuales, 
  solicitud_hipotecario.identificador_consecutivos, 
  solicitud_hipotecario.fecha_presentacion, 
  solicitud_hipotecario.fecha_aprobacion, 
  estado_civil.id_estado_civil, 
  estado_civil.nombre_estado_civil, 
  solicitud_hipotecario.id_provincia, 
  solicitud_hipotecario.id_canton, 
  solicitud_hipotecario.id_parroquia, 
  solicitud_hipotecario.id_provincia_datos_laborales, 
  solicitud_hipotecario.id_canton_datos_laborales, 
  solicitud_hipotecario.id_parroquia_datos_laborales, 
  solicitud_hipotecario.id_sexo_datos_conyuge, 
  solicitud_hipotecario.id_provincia_datos_conyuge, 
  solicitud_hipotecario.id_canton_datos_conyuge, 
  solicitud_hipotecario.id_parroquia_datos_conyuge, 
  solicitud_hipotecario.id_provincia_trabajo_datos_conyuge, 
  solicitud_hipotecario.id_canton_trabajo_datos_conyuge, 
  solicitud_hipotecario.id_parroquia_trabajo_datos_conyuge, 
  solicitud_hipotecario.id_bancos_referencia_bancaria, 
  solicitud_hipotecario.id_bancos_uno_datos_economicos, 
  solicitud_hipotecario.id_bancos_dos_datos_economicos, 
  solicitud_hipotecario.id_bancos_tres_datos_economicos, 
  solicitud_hipotecario.id_bancos_cuatro_datos_economicos, 
  solicitud_hipotecario.id_bancos_uno_detalle_activos, 
  solicitud_hipotecario.id_bancos_dos_detalle_activos, 
  solicitud_hipotecario.id_bancos_tres_detalle_activos, 
  solicitud_hipotecario.id_bancos_cuatro_detalle_activos, 
  solicitud_hipotecario.id_usuarios_registra, 
  estado_tramites.id_estado_tramites, 
  estado_tramites.nombre_estado_tramites_solicitud_prestamos, 
  solicitud_hipotecario.id_usuarios_oficial_credito_aprueba, 
  usuarios.id_usuarios, 
  usuarios.cedula_usuarios, 
  usuarios.nombre_usuarios, 
  usuarios.correo_usuarios";
        
        $tablas   = "   public.solicitud_hipotecario, 
  public.sexo, 
  public.entidades, 
  public.estado_civil, 
  public.usuarios, 
  public.estado_tramites
";
        
        $where    = "   sexo.id_sexo = solicitud_hipotecario.id_sexo AND
  entidades.id_entidades = solicitud_hipotecario.id_entidades AND
  estado_civil.id_estado_civil = solicitud_hipotecario.id_estado_civil AND
  usuarios.id_usuarios = solicitud_hipotecario.id_usuarios_oficial_credito_aprueba AND
  estado_tramites.id_estado_tramites = solicitud_hipotecario.id_estado_tramites AND solicitud_hipotecario.id_usuarios_oficial_credito_aprueba='$id_usuarios'";
        
        $id       = "solicitud_hipotecario.id_solicitud_hipotecario";
        
        
        
        
        
        //$where_to=$where;
        
        
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        $search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
        
        if($action == 'ajax')
        {
            
            if(!empty($search)){
                
                
                $where1=" AND (solicitud_hipotecario.cedula_datos_personales LIKE '".$search."%' OR solicitud_hipotecario.apellidos_datos_personales ILIKE '".$search."%' OR solicitud_hipotecario.nombres_datos_personales ILIKE '".$search."%' OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos ILIKE '".$search."%' )";
                
                $where_to=$where.$where1;
            }else{
                
                $where_to=$where;
                
            }
            
            
            $html="";
            $resultSet=$SolicitudHipotecario->getCantidad("*", $tablas, $where_to);
            $cantidadResult=(int)$resultSet[0]->total;
            
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
            
            $per_page = 10; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            
            $limit = " LIMIT   '$per_page' OFFSET '$offset'";
            
            $resultSet=$SolicitudHipotecario->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
                $html.= "<table id='tabla_solicitud_hipotecario_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
                $html.= "<thead>";
                $html.= "<tr>";
                
                $html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
                $html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
                $html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
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
                    
                    $html.='<td style="font-size: 11px;">'.$res->nombres_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->apellidos_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->nombres_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_presentacion)).'</td>';
                    $html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
                    
                    if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
                        $html.='<td style="font-size: 11px;"></td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
                        
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudHipotecario&action=index4&id_solicitud_hipotecario='.$res->id_solicitud_hipotecario.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudHipotecario&action=index3&id_solicitud_prestamo_a='.$res->id_solicitud_hipotecario.'" class="btn btn-info" style="font-size:65%;" title="Guardar"><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudHipotecario&action=index3&id_solicitud_prestamo_r='.$res->id_solicitud_hipotecario.'" class="btn btn-danger" style="font-size:65%;" title="Rechazar"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
                        
                    }else{
                        $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-primary" style="font-size:65%;" disabled><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-danger" style="font-size:65%;" disabled><i class="glyphicon glyphicon-trash"></i></a></span></td>';
                        
                    }
                    $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudHipotecario&action=print&id_solicitud_hipotecario='.$res->id_solicitud_hipotecario.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
                    $html.='</tr>';
                    
                }
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section></div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_load_solicitud_hipotecario_registrados("index.php", $page, $total_pages, $adjacents).'';
                $html.='</div>';
                
                
            }else{
                $html.='<div class="col-lg-6 col-md-6 col-xs-12">';
                $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
                $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                $html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud Hipotecario registrados...</b>';
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
            
            $Solicitudhipotecario = new SolicitudHipotecarioModel();
            
            
            $sucursales = new SucursalesModel();
            $resultSucursales= $sucursales->getAll("nombre_sucursales");
            
            
            $genero = new SexoModel();
            $resultGenero= $genero->getAll("nombre_sexo");
            
            
            $estado_civil = new Estado_civilModel();
            $resultEstadoCivil = $estado_civil->getBy("nombre_estado_civil<>'Ninguna' ");
            
            
            $provincias = new ProvinciasModel();
            $resultProvincias= $provincias->getAll("nombre_provincias");
            
            $cantones = new CantonesModel();
            $resultCantones= $cantones->getAll("nombre_cantones");
            
            
            $parroquias = new ParroquiasModel();
            $resultParroquias= $parroquias->getAll("nombre_parroquias");
            
            $banco = new BancosModel();
            $resultBancos= $banco->getAll("nombre_bancos");
            
            $institucion = new InstitucionModel();
            $resultInstitucion= $institucion->getAll("nombre_entidades");
            
            
            
            $nombre_controladores = "SolicitudHipotecario";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $Solicitudhipotecario->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
                
                $cedula = array();
                $nombres = array();
                $correo = array();
                $cedula_usuarios = $_SESSION['cedula_usuarios'];
                array_push($cedula, $cedula_usuarios);
                $nombres_usuarios=$_SESSION['nombre_usuarios'];
                array_push($nombres, $nombres_usuarios);
                $correo_usuarios=$_SESSION['correo_usuarios'];
                array_push($correo, $correo_usuarios);
                
                
                
                $resultEdit="";
                
                if(isset($_GET["id_solicitud_hipotecario"])){
                    
                    
                    $_id_solicitud_hipotecario= $_GET["id_solicitud_hipotecario"];
                    
                    
                    $colval_afi = "id_estado_tramites=4";
                    $tabla_afi = "solicitud_hipotecario";
                    $where_afi = "id_solicitud_hipotecario = '$_id_solicitud_hipotecario'";
                    $resultado1=$Solicitudhipotecario->UpdateBy($colval_afi, $tabla_afi, $where_afi);
                    
                    
                    $columnas="solicitud_hipotecario.*,
                            codigo_verificacion.id_codigo_verificacion,
                            codigo_verificacion.numero_codigo_verificacion";
                    
                    $tablas="public.solicitud_hipotecario, public.codigo_verificacion";
                    $where="solicitud_hipotecario.id_codigo_verificacion= codigo_verificacion.id_codigo_verificacion AND solicitud_hipotecario.id_solicitud_hipotecario='$_id_solicitud_hipotecario'";
                    $id="solicitud_hipotecario.id_solicitud_hipotecario";
                    $resultEdit=$Solicitudhipotecario->getCondiciones($columnas, $tablas, $where, $id);
                    
                    
                    
                }
                
                
                
                
                $this->view("ActualizarSolicitudHipotecarioAdmin",array(     "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo, "resultEdit"=>$resultEdit, "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo,
                    "resultSucursales"=>$resultSucursales, "resultGenero"=>$resultGenero, "resultEstadoCivil"=>$resultEstadoCivil, "resultProvincias"=>$resultProvincias,
                    "resultCantones"=>$resultCantones, "resultParroquias"=>$resultParroquias, "resultBancos"=>$resultBancos, "resultInstitucion"=>$resultInstitucion
                    
                ));
                
                die();
                
                
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a llenar una solicitud hipotecario."
                    
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
    
    
    
    public function ActualizaSolicitudHipotecario(){
        
        
        session_start();
        
        if (isset($_SESSION['nombre_usuarios']))
        {
            
            $solicitudhipotecario = new SolicitudHipotecarioModel();
            
            
            if (isset($_POST["id_solicitud_hipotecario"]))
            {
                
                
                
                
                $_identificador_consecutivos = 0;
                $_total_activos_corrientes   = 0;
                $_total_activos_fijos       = 0;
                $_total_activos            =    0;
                $_total_pasivos_corrientes =  0;
                $_total_pasivos_largo_plazo =0;
                $_total_pasivos    =  0;
                $_total_ingresos_mensuales =0;
                $_total_gastos_mensuales  = 0;
                
                
                
                
                $_id_solicitud_hipotecario =(isset($_POST['id_solicitud_hipotecario'])) ? $_POST['id_solicitud_hipotecario'] : 0;
                $_valor_dolares_datos_credito =(isset($_REQUEST['valor_dolares_datos_credito'])&& $_REQUEST['valor_dolares_datos_credito'] !=NULL)?$_REQUEST['valor_dolares_datos_credito']:0;
                $_plazo_meses_datos_credito =(isset($_REQUEST['plazo_meses_datos_credito'])&& $_REQUEST['plazo_meses_datos_credito'] !=NULL)?$_REQUEST['plazo_meses_datos_credito']:'';
                $_destino_dinero_datos_credito =(isset($_REQUEST['destino_dinero_datos_credito'])&& $_REQUEST['destino_dinero_datos_credito'] !=NULL)?$_REQUEST['destino_dinero_datos_credito']:'';
                $_nombres_datos_personales=(isset($_REQUEST['nombres_datos_personales'])&& $_REQUEST['nombres_datos_personales'] !=NULL)?$_REQUEST['nombres_datos_personales']:'';
                $_apellidos_datos_personales =(isset($_REQUEST['apellidos_datos_personales'])&& $_REQUEST['apellidos_datos_personales'] !=NULL)?$_REQUEST['apellidos_datos_personales']:'';
                $_cedula_datos_personales =(isset($_REQUEST['cedula_datos_personales'])&& $_REQUEST['cedula_datos_personales'] !=NULL)?$_REQUEST['cedula_datos_personales']:'';
                $_id_sexo =(isset($_REQUEST['id_sexo'])&& $_REQUEST['id_sexo'] !=NULL)?$_REQUEST['id_sexo']:0;
                $_fecha_nacimiento_datos_personales =(isset($_REQUEST['fecha_nacimiento_datos_personales'])&& $_REQUEST['fecha_nacimiento_datos_personales'] !=NULL)?$_REQUEST['fecha_nacimiento_datos_personales']:'';
                $_id_estado_civil =(isset($_REQUEST['id_estado_civil'])&& $_REQUEST['id_estado_civil'] !=NULL)?$_REQUEST['id_estado_civil']:0;
                $_separacion_bienes_datos_personales =(isset($_REQUEST['separacion_bienes_datos_personales'])&& $_REQUEST['separacion_bienes_datos_personales'] !=NULL)?$_REQUEST['separacion_bienes_datos_personales']:'';
                $_cargas_familiares_datos_personales =(isset($_REQUEST['cargas_familiares_datos_personales'])&& $_REQUEST['cargas_familiares_datos_personales'] !=NULL)?$_REQUEST['cargas_familiares_datos_personales']:'';
                $_numero_hijos_datos_personales =(isset($_REQUEST['numero_hijos_datos_personales'])&& $_REQUEST['numero_hijos_datos_personales'] !=NULL)?$_REQUEST['numero_hijos_datos_personales']:'';
                $_id_provincia =(isset($_REQUEST['id_provincia'])&& $_REQUEST['id_provincia'] !=NULL)?$_REQUEST['id_provincia']:0;
                $_id_canton=(isset($_REQUEST['id_canton'])&& $_REQUEST['id_canton'] !=NULL)?$_REQUEST['id_canton']:0;
                $_id_parroquia =(isset($_REQUEST['id_parroquia'])&& $_REQUEST['id_parroquia'] !=NULL)?$_REQUEST['id_parroquia']:0;
                $_barrio_datos_personales =(isset($_REQUEST['barrio_datos_personales'])&& $_REQUEST['barrio_datos_personales'] !=NULL)?$_REQUEST['barrio_datos_personales']:'';
                $_ciudadela_datos_personales =(isset($_REQUEST['ciudadela_datos_personales'])&& $_REQUEST['ciudadela_datos_personales'] !=NULL)?$_REQUEST['ciudadela_datos_personales']:'';
                $_calle_datos_personales =(isset($_REQUEST['calle_datos_personales'])&& $_REQUEST['calle_datos_personales'] !=NULL)?$_REQUEST['calle_datos_personales']:'';
                $_numero_calle_datos_personales =(isset($_REQUEST['numero_calle_datos_personales'])&& $_REQUEST['numero_calle_datos_personales'] !=NULL)?$_REQUEST['numero_calle_datos_personales']:'';
                $_interseccion_datos_personales =(isset($_REQUEST['interseccion_datos_personales'])&& $_REQUEST['interseccion_datos_personales'] !=NULL)?$_REQUEST['interseccion_datos_personales']:'';
                $_tipo_vivienda_datos_personales =(isset($_REQUEST['tipo_vivienda_datos_personales'])&& $_REQUEST['tipo_vivienda_datos_personales'] !=NULL)?$_REQUEST['tipo_vivienda_datos_personales']:'';
                $_vivienda_hipotecada_datos_personales =(isset($_REQUEST['vivienda_hipotecada_datos_personales'])&& $_REQUEST['vivienda_hipotecada_datos_personales'] !=NULL)?$_REQUEST['vivienda_hipotecada_datos_personales']:'';
                $_tiempo_residencia_datos_personales =(isset($_REQUEST['tiempo_residencia_datos_personales'])&& $_REQUEST['tiempo_residencia_datos_personales'] !=NULL)?$_REQUEST['tiempo_residencia_datos_personales']:'';
                $_referencia_domiciliaria_datos_perdonales =(isset($_REQUEST['referencia_domiciliaria_datos_perdonales'])&& $_REQUEST['referencia_domiciliaria_datos_perdonales'] !=NULL)?$_REQUEST['referencia_domiciliaria_datos_perdonales']:'';
                $_nombre_arrendatario_datos_personales =(isset($_REQUEST['nombre_arrendatario_datos_personales'])&& $_REQUEST['nombre_arrendatario_datos_personales'] !=NULL)?$_REQUEST['nombre_arrendatario_datos_personales']:'';
                $_apellido_arrendatario_datos_personales =(isset($_REQUEST['apellido_arrendatario_datos_personales'])&& $_REQUEST['apellido_arrendatario_datos_personales'] !=NULL)?$_REQUEST['apellido_arrendatario_datos_personales']:'';
                $_celular_arrendatario_datos_personales =(isset($_REQUEST['celular_arrendatario_datos_personales'])&& $_REQUEST['celular_arrendatario_datos_personales'] !=NULL)?$_REQUEST['celular_arrendatario_datos_personales']:'';
                $_telefono_datos_personales =(isset($_REQUEST['telefono_datos_personales'])&& $_REQUEST['telefono_datos_personales'] !=NULL)?$_REQUEST['telefono_datos_personales']:'';
                $_celular_datos_personales =(isset($_REQUEST['celular_datos_personales'])&& $_REQUEST['celular_datos_personales'] !=NULL)?$_REQUEST['celular_datos_personales']:'';
                $_telf_trabajo_datos_personales =(isset($_REQUEST['telf_trabajo_datos_personales'])&& $_REQUEST['telf_trabajo_datos_personales'] !=NULL)?$_REQUEST['telf_trabajo_datos_personales']:'';
                $_ext_telef_datos_personales =(isset($_REQUEST['ext_telef_datos_personales'])&& $_REQUEST['ext_telef_datos_personales'] !=NULL)?$_REQUEST['ext_telef_datos_personales']:'';
                $_node_telef_datos_personales=(isset($_REQUEST['node_telef_datos_personales'])&& $_REQUEST['node_telef_datos_personales'] !=NULL)?$_REQUEST['node_telef_datos_personales']:'';
                $_email_datos_personales =(isset($_REQUEST['email_datos_personales'])&& $_REQUEST['email_datos_personales'] !=NULL)?$_REQUEST['email_datos_personales']:'';
                $_nivel_educativo_datos_personales =(isset($_REQUEST['nivel_educativo_datos_personales'])&& $_REQUEST['nivel_educativo_datos_personales'] !=NULL)?$_REQUEST['nivel_educativo_datos_personales']:'';
                $_nombres_referencia_familiar_datos_personales=(isset($_REQUEST['nombres_referencia_familiar_datos_personales'])&& $_REQUEST['nombres_referencia_familiar_datos_personales'] !=NULL)?$_REQUEST['nombres_referencia_familiar_datos_personales']:'';
                $_apellidos_referencia_familiar_datos_personales =(isset($_REQUEST['apellidos_referencia_familiar_datos_personales'])&& $_REQUEST['apellidos_referencia_familiar_datos_personales'] !=NULL)?$_REQUEST['apellidos_referencia_familiar_datos_personales']:'';
                $_parentesco_referencia_familiar_datos_personales =(isset($_REQUEST['parentesco_referencia_familiar_datos_personales'])&& $_REQUEST['parentesco_referencia_familiar_datos_personales'] !=NULL)?$_REQUEST['parentesco_referencia_familiar_datos_personales']:'';
                $_primer_telefono_ref_familiar_datos_personales =(isset($_REQUEST['primer_telefono_ref_familiar_datos_personales'])&& $_REQUEST['primer_telefono_ref_familiar_datos_personales'] !=NULL)?$_REQUEST['primer_telefono_ref_familiar_datos_personales']:'';
                $_segundo_telefono_ref_familiar_datos_personales =(isset($_REQUEST['segundo_telefono_ref_familiar_datos_personales'])&& $_REQUEST['segundo_telefono_ref_familiar_datos_personales'] !=NULL)?$_REQUEST['segundo_telefono_ref_familiar_datos_personales']:'';
                $_nombres_referencia_personal_datos_personales =(isset($_REQUEST['nombres_referencia_personal_datos_personales'])&& $_REQUEST['nombres_referencia_personal_datos_personales'] !=NULL)?$_REQUEST['nombres_referencia_personal_datos_personales']:'';
                $_apellidos_referencia_personal_datos_personales=(isset($_REQUEST['apellidos_referencia_personal_datos_personales'])&& $_REQUEST['apellidos_referencia_personal_datos_personales'] !=NULL)?$_REQUEST['apellidos_referencia_personal_datos_personales']:'';
                $_relacion_referencia_personal_datos_personales =(isset($_REQUEST['relacion_referencia_personal_datos_personales'])&& $_REQUEST['relacion_referencia_personal_datos_personales'] !=NULL)?$_REQUEST['relacion_referencia_personal_datos_personales']:'';
                $_primer_telefono_ref_personal_datos_personales =(isset($_REQUEST['primer_telefono_ref_personal_datos_personales'])&& $_REQUEST['primer_telefono_ref_personal_datos_personales'] !=NULL)?$_REQUEST['primer_telefono_ref_personal_datos_personales']:'';
                $_segundo_telefono_ref_personal_datos_personales =(isset($_REQUEST['segundo_telefono_ref_personal_datos_personales'])&& $_REQUEST['segundo_telefono_ref_personal_datos_personales'] !=NULL)?$_REQUEST['segundo_telefono_ref_personal_datos_personales']:'';
                $_id_entidades =(isset($_REQUEST['id_entidades'])&& $_REQUEST['id_entidades'] !=NULL)?$_REQUEST['id_entidades']:0;
                $_reparto_unidad_datos_laborales =(isset($_REQUEST['reparto_unidad_datos_laborales'])&& $_REQUEST['reparto_unidad_datos_laborales'] !=NULL)?$_REQUEST['reparto_unidad_datos_laborales']:'';
                $_seccion_datos_laborales =(isset($_REQUEST['seccion_datos_laborales'])&& $_REQUEST['seccion_datos_laborales'] !=NULL)?$_REQUEST['seccion_datos_laborales']:'';
                $_nombres_jefe_datos_laborales =(isset($_REQUEST['nombres_jefe_datos_laborales'])&& $_REQUEST['nombres_jefe_datos_laborales'] !=NULL)?$_REQUEST['nombres_jefe_datos_laborales']:'';
                $_apellidos_jefe_datos_laborales =(isset($_REQUEST['apellidos_jefe_datos_laborales'])&& $_REQUEST['apellidos_jefe_datos_laborales'] !=NULL)?$_REQUEST['apellidos_jefe_datos_laborales']:'';
                $_telefono_jefe_datos_laborales =(isset($_REQUEST['telefono_jefe_datos_laborales'])&& $_REQUEST['telefono_jefe_datos_laborales'] !=NULL)?$_REQUEST['telefono_jefe_datos_laborales']:'';
                $_id_provincia_datos_laborales =(isset($_REQUEST['id_provincia_datos_laborales'])&& $_REQUEST['id_provincia_datos_laborales'] !=NULL)?$_REQUEST['id_provincia_datos_laborales']:0;
                $_id_canton_datos_laborales =(isset($_REQUEST['id_canton_datos_laborales'])&& $_REQUEST['id_canton_datos_laborales'] !=NULL)?$_REQUEST['id_canton_datos_laborales']:0;
                $_id_parroquia_datos_laborales =(isset($_REQUEST['id_parroquia_datos_laborales'])&& $_REQUEST['id_parroquia_datos_laborales'] !=NULL)?$_REQUEST['id_parroquia_datos_laborales']:0;
                $_calle_datos_laborales =(isset($_REQUEST['calle_datos_laborales'])&& $_REQUEST['calle_datos_laborales'] !=NULL)?$_REQUEST['calle_datos_laborales']:'';
                $_numero_calle_datos_laborales =(isset($_REQUEST['numero_calle_datos_laborales'])&& $_REQUEST['numero_calle_datos_laborales'] !=NULL)?$_REQUEST['numero_calle_datos_laborales']:'';
                $_interseccion_datos_laborales =(isset($_REQUEST['interseccion_datos_laborales'])&& $_REQUEST['interseccion_datos_laborales'] !=NULL)?$_REQUEST['interseccion_datos_laborales']:'';
                $_referencia_direccion_trabajo_datos_laborales =(isset($_REQUEST['referencia_direccion_trabajo_datos_laborales'])&& $_REQUEST['referencia_direccion_trabajo_datos_laborales'] !=NULL)?$_REQUEST['referencia_direccion_trabajo_datos_laborales']:'';
                $_cargo_actual_datos_laborales=(isset($_REQUEST['cargo_actual_datos_laborales'])&& $_REQUEST['cargo_actual_datos_laborales'] !=NULL)?$_REQUEST['cargo_actual_datos_laborales']:'';
                $_anios_servicio_datos_laborales =(isset($_REQUEST['anios_servicio_datos_laborales'])&& $_REQUEST['anios_servicio_datos_laborales'] !=NULL)?$_REQUEST['anios_servicio_datos_laborales']:'';
                $_nombres_datos_conyuge =(isset($_REQUEST['nombres_datos_conyuge'])&& $_REQUEST['nombres_datos_conyuge'] !=NULL)?$_REQUEST['nombres_datos_conyuge']:'';
                $_apellidos_datos_conyuge =(isset($_REQUEST['apellidos_datos_conyuge'])&& $_REQUEST['apellidos_datos_conyuge'] !=NULL)?$_REQUEST['apellidos_datos_conyuge']:'';
                $_cedula_datos_conyuge =(isset($_REQUEST['cedula_datos_conyuge'])&& $_REQUEST['cedula_datos_conyuge'] !=NULL)?$_REQUEST['cedula_datos_conyuge']:'';
                $_id_sexo_datos_conyuge =(isset($_REQUEST['id_sexo_datos_conyuge'])&& $_REQUEST['id_sexo_datos_conyuge'] !=NULL)?$_REQUEST['id_sexo_datos_conyuge']:0;
                $_fecha_nacimiento_datos_conyuge =(isset($_REQUEST['fecha_nacimiento_datos_conyuge'])&& $_REQUEST['fecha_nacimiento_datos_conyuge'] !=NULL)?$_REQUEST['fecha_nacimiento_datos_conyuge']:'';
                $_vive_residencia_datos_conyuge =(isset($_REQUEST['vive_residencia_datos_conyuge'])&& $_REQUEST['vive_residencia_datos_conyuge'] !=NULL)?$_REQUEST['vive_residencia_datos_conyuge']:'';
                $_celular_datos_conyuge =(isset($_REQUEST['celular_datos_conyuge'])&& $_REQUEST['celular_datos_conyuge'] !=NULL)?$_REQUEST['celular_datos_conyuge']:'';
                $_telefono_datos_conyuge =(isset($_REQUEST['telefono_datos_conyuge'])&& $_REQUEST['telefono_datos_conyuge'] !=NULL)?$_REQUEST['telefono_datos_conyuge']:'';
                $_id_provincia_datos_conyuge =(isset($_REQUEST['id_provincia_datos_conyuge'])&& $_REQUEST['id_provincia_datos_conyuge'] !=NULL)?$_REQUEST['id_provincia_datos_conyuge']:0;
                $_id_canton_datos_conyuge =(isset($_REQUEST['id_canton_datos_conyuge'])&& $_REQUEST['id_canton_datos_conyuge'] !=NULL)?$_REQUEST['id_canton_datos_conyuge']:0;
                $_id_parroquia_datos_conyuge =(isset($_REQUEST['id_parroquia_datos_conyuge'])&& $_REQUEST['id_parroquia_datos_conyuge'] !=NULL)?$_REQUEST['id_parroquia_datos_conyuge']:0;
                $_barrio_datos_conyuge =(isset($_REQUEST['barrio_datos_conyuge'])&& $_REQUEST['barrio_datos_conyuge'] !=NULL)?$_REQUEST['barrio_datos_conyuge']:'';
                $_ciudadela_datos_conyuge =(isset($_REQUEST['ciudadela_datos_conyuge'])&& $_REQUEST['ciudadela_datos_conyuge'] !=NULL)?$_REQUEST['ciudadela_datos_conyuge']:'';
                $_calle_datos_conyuge =(isset($_REQUEST['calle_datos_conyuge'])&& $_REQUEST['calle_datos_conyuge'] !=NULL)?$_REQUEST['calle_datos_conyuge']:'';
                $_numero_calle_datos_conyuge =(isset($_REQUEST['numero_calle_datos_conyuge'])&& $_REQUEST['numero_calle_datos_conyuge'] !=NULL)?$_REQUEST['numero_calle_datos_conyuge']:'';
                $_interseccion_datos_conyuge =(isset($_REQUEST['interseccion_datos_conyuge'])&& $_REQUEST['interseccion_datos_conyuge'] !=NULL)?$_REQUEST['interseccion_datos_conyuge']:'';
                $_actividad_economica_datos_conyuge=(isset($_REQUEST['actividad_economica_datos_conyuge'])&& $_REQUEST['actividad_economica_datos_conyuge'] !=NULL)?$_REQUEST['actividad_economica_datos_conyuge']:'';
                $_empresa_datos_conyuge =(isset($_REQUEST['empresa_datos_conyuge'])&& $_REQUEST['empresa_datos_conyuge'] !=NULL)?$_REQUEST['empresa_datos_conyuge']:'';
                $_naturaleza_negocio_datos_conyuge =(isset($_REQUEST['naturaleza_negocio_datos_conyuge'])&& $_REQUEST['naturaleza_negocio_datos_conyuge'] !=NULL)?$_REQUEST['naturaleza_negocio_datos_conyuge']:'';
                $_cargo_datos_conyuge =(isset($_REQUEST['cargo_datos_conyuge'])&& $_REQUEST['cargo_datos_conyuge'] !=NULL)?$_REQUEST['cargo_datos_conyuge']:'';
                $_tipo_contrato_datos_conyuge =(isset($_REQUEST['tipo_contrato_datos_conyuge'])&& $_REQUEST['tipo_contrato_datos_conyuge'] !=NULL)?$_REQUEST['tipo_contrato_datos_conyuge']:'';
                $_anios_laborados_datos_conyuge =(isset($_REQUEST['anios_laborados_datos_conyuge'])&& $_REQUEST['anios_laborados_datos_conyuge'] !=NULL)?$_REQUEST['anios_laborados_datos_conyuge']:'';
                $_nombres_jefe_datos_conyuge =(isset($_REQUEST['nombres_jefe_datos_conyuge'])&& $_REQUEST['nombres_jefe_datos_conyuge'] !=NULL)?$_REQUEST['nombres_jefe_datos_conyuge']:'';
                $_apellidos_jefe_datos_conyuge =(isset($_REQUEST['apellidos_jefe_datos_conyuge'])&& $_REQUEST['apellidos_jefe_datos_conyuge'] !=NULL)?$_REQUEST['apellidos_jefe_datos_conyuge']:'';
                $_telefono_jefe_datos_conyuge =(isset($_REQUEST['telefono_jefe_datos_conyuge'])&& $_REQUEST['telefono_jefe_datos_conyuge'] !=NULL)?$_REQUEST['telefono_jefe_datos_conyuge']:'';
                $_id_provincia_trabajo_datos_conyuge =(isset($_REQUEST['id_provincia_trabajo_datos_conyuge'])&& $_REQUEST['id_provincia_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['id_provincia_trabajo_datos_conyuge']:0;
                $_id_canton_trabajo_datos_conyuge =(isset($_REQUEST['id_canton_trabajo_datos_conyuge'])&& $_REQUEST['id_canton_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['id_canton_trabajo_datos_conyuge']:0;
                $_id_parroquia_trabajo_datos_conyuge =(isset($_REQUEST['id_parroquia_trabajo_datos_conyuge'])&& $_REQUEST['id_parroquia_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['id_parroquia_trabajo_datos_conyuge']:0;
                $_calle_trabajo_datos_conyuge =(isset($_REQUEST['calle_trabajo_datos_conyuge'])&& $_REQUEST['calle_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['calle_trabajo_datos_conyuge']:'';
                $_nuemero_calle_trabajo_datos_conyuge =(isset($_REQUEST['nuemero_calle_trabajo_datos_conyuge'])&& $_REQUEST['nuemero_calle_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['nuemero_calle_trabajo_datos_conyuge']:'';
                $_interseccion_trabajo_datos_conyuge =(isset($_REQUEST['interseccion_trabajo_datos_conyuge'])&& $_REQUEST['interseccion_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['interseccion_trabajo_datos_conyuge']:'';
                $_referencia_trabajo_datos_conyuge =(isset($_REQUEST['referencia_trabajo_datos_conyuge'])&& $_REQUEST['referencia_trabajo_datos_conyuge'] !=NULL)?$_REQUEST['referencia_trabajo_datos_conyuge']:'';
                $_actividad_principal_datos_independientes =(isset($_REQUEST['actividad_principal_datos_independientes'])&& $_REQUEST['actividad_principal_datos_independientes'] !=NULL)?$_REQUEST['actividad_principal_datos_independientes']:'';
                $_ruc_datos_independientes =(isset($_REQUEST['ruc_datos_independientes'])&& $_REQUEST['ruc_datos_independientes'] !=NULL)?$_REQUEST['ruc_datos_independientes']:'';
                $_detalle_actividades_datos_independientes =(isset($_REQUEST['detalle_actividades_datos_independientes'])&& $_REQUEST['detalle_actividades_datos_independientes'] !=NULL)?$_REQUEST['detalle_actividades_datos_independientes']:'';
                $_local_datos_independientes =(isset($_REQUEST['local_datos_independientes'])&& $_REQUEST['local_datos_independientes'] !=NULL)?$_REQUEST['local_datos_independientes']:'';
                $_nombres_propietario_datos_independientes =(isset($_REQUEST['nombres_propietario_datos_independientes'])&& $_REQUEST['nombres_propietario_datos_independientes'] !=NULL)?$_REQUEST['nombres_propietario_datos_independientes']:'';
                $_apellidos_propietario_datos_independientes =(isset($_REQUEST['apellidos_propietario_datos_independientes'])&& $_REQUEST['apellidos_propietario_datos_independientes'] !=NULL)?$_REQUEST['apellidos_propietario_datos_independientes']:'';
                $_telefono_propietario_datos_independientes =(isset($_REQUEST['telefono_propietario_datos_independientes'])&& $_REQUEST['telefono_propietario_datos_independientes'] !=NULL)?$_REQUEST['telefono_propietario_datos_independientes']:'';
                $_tiempo_funcionamiento_datos_independientes =(isset($_REQUEST['tiempo_funcionamiento_datos_independientes'])&& $_REQUEST['tiempo_funcionamiento_datos_independientes'] !=NULL)?$_REQUEST['tiempo_funcionamiento_datos_independientes']:'';
                $_numero_patronal_datos_independientes =(isset($_REQUEST['numero_patronal_datos_independientes'])&& $_REQUEST['numero_patronal_datos_independientes'] !=NULL)?$_REQUEST['numero_patronal_datos_independientes']:'';
                $_numero_empleados_datos_independientes=(isset($_REQUEST['numero_empleados_datos_independientes'])&& $_REQUEST['numero_empleados_datos_independientes'] !=NULL)?$_REQUEST['numero_empleados_datos_independientes']:'';
                $_id_bancos_referencia_bancaria =(isset($_REQUEST['id_bancos_referencia_bancaria'])&& $_REQUEST['id_bancos_referencia_bancaria'] !=NULL)?$_REQUEST['id_bancos_referencia_bancaria']:0;
                $_tipo_cuenta_referencia_bancaria =(isset($_REQUEST['tipo_cuenta_referencia_bancaria'])&& $_REQUEST['tipo_cuenta_referencia_bancaria'] !=NULL)?$_REQUEST['tipo_cuenta_referencia_bancaria']:'';
                $_numero_cuenta_referencia_bancaria =(isset($_REQUEST['numero_cuenta_referencia_bancaria'])&& $_REQUEST['numero_cuenta_referencia_bancaria'] !=NULL)?$_REQUEST['numero_cuenta_referencia_bancaria']:'';
                $_id_bancos_uno_datos_economicos =(isset($_REQUEST['id_bancos_uno_datos_economicos'])&& $_REQUEST['id_bancos_uno_datos_economicos'] !=NULL)?$_REQUEST['id_bancos_uno_datos_economicos']:0;
                $_tipo_cuenta_uno_datos_economicos =(isset($_REQUEST['tipo_cuenta_uno_datos_economicos'])&& $_REQUEST['tipo_cuenta_uno_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_uno_datos_economicos']:'';
                $_numero_cuenta_uno_datos_economicos =(isset($_REQUEST['numero_cuenta_uno_datos_economicos'])&& $_REQUEST['numero_cuenta_uno_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_uno_datos_economicos']:'';
                $_id_bancos_dos_datos_economicos =(isset($_REQUEST['id_bancos_dos_datos_economicos'])&& $_REQUEST['id_bancos_dos_datos_economicos'] !=NULL)?$_REQUEST['id_bancos_dos_datos_economicos']:0;
                $_tipo_cuenta_dos_datos_economicos =(isset($_REQUEST['tipo_cuenta_dos_datos_economicos'])&& $_REQUEST['tipo_cuenta_dos_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_dos_datos_economicos']:'';
                $_numero_cuenta_dos_datos_economicos =(isset($_REQUEST['numero_cuenta_dos_datos_economicos'])&& $_REQUEST['numero_cuenta_dos_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_dos_datos_economicos']:'';
                $_id_bancos_tres_datos_economicos =(isset($_REQUEST['id_bancos_tres_datos_economicos'])&& $_REQUEST['id_bancos_tres_datos_economicos'] !=NULL)?$_REQUEST['id_bancos_tres_datos_economicos']:0;
                $_tipo_cuenta_tres_datos_economicos =(isset($_REQUEST['tipo_cuenta_tres_datos_economicos'])&& $_REQUEST['tipo_cuenta_tres_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_tres_datos_economicos']:'';
                $_numero_cuenta_tres_datos_economicos =(isset($_REQUEST['numero_cuenta_tres_datos_economicos'])&& $_REQUEST['numero_cuenta_tres_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_tres_datos_economicos']:'';
                $_id_bancos_cuatro_datos_economicos =(isset($_REQUEST['id_bancos_cuatro_datos_economicos'])&& $_REQUEST['id_bancos_cuatro_datos_economicos'] !=NULL)?$_REQUEST['id_bancos_cuatro_datos_economicos']:0;
                $_tipo_cuenta_cuatro_datos_economicos =(isset($_REQUEST['tipo_cuenta_cuatro_datos_economicos'])&& $_REQUEST['tipo_cuenta_cuatro_datos_economicos'] !=NULL)?$_REQUEST['tipo_cuenta_cuatro_datos_economicos']:'';
                $_numero_cuenta_cuatro_datos_economicos =(isset($_REQUEST['numero_cuenta_cuatro_datos_economicos'])&& $_REQUEST['numero_cuenta_cuatro_datos_economicos'] !=NULL)?$_REQUEST['numero_cuenta_cuatro_datos_economicos']:'';
                $_empresa_uno_datos_economicos =(isset($_REQUEST['empresa_uno_datos_economicos'])&& $_REQUEST['empresa_uno_datos_economicos'] !=NULL)?$_REQUEST['empresa_uno_datos_economicos']:'';
                $_direccion_uno_datos_economicos =(isset($_REQUEST['direccion_uno_datos_economicos'])&& $_REQUEST['direccion_uno_datos_economicos'] !=NULL)?$_REQUEST['direccion_uno_datos_economicos']:'';
                $_numero_telefono_uno_datos_economicos =(isset($_REQUEST['numero_telefono_uno_datos_economicos'])&& $_REQUEST['numero_telefono_uno_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_uno_datos_economicos']:'';
                $_empresa_dos_datos_economicos =(isset($_REQUEST['empresa_dos_datos_economicos'])&& $_REQUEST['empresa_dos_datos_economicos'] !=NULL)?$_REQUEST['empresa_dos_datos_economicos']:'';
                $_direccion_dos_datos_economicos =(isset($_REQUEST['direccion_dos_datos_economicos'])&& $_REQUEST['direccion_dos_datos_economicos'] !=NULL)?$_REQUEST['direccion_dos_datos_economicos']:'';
                $_numero_telefono_dos_datos_economicos =(isset($_REQUEST['numero_telefono_dos_datos_economicos'])&& $_REQUEST['numero_telefono_dos_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_dos_datos_economicos']:'';
                $_empresa_tres_datos_economicos =(isset($_REQUEST['empresa_tres_datos_economicos'])&& $_REQUEST['empresa_tres_datos_economicos'] !=NULL)?$_REQUEST['empresa_tres_datos_economicos']:'';
                $_direccion_tres_datos_economicos =(isset($_REQUEST['direccion_tres_datos_economicos'])&& $_REQUEST['direccion_tres_datos_economicos'] !=NULL)?$_REQUEST['direccion_tres_datos_economicos']:'';
                $_numero_telefono_tres_datos_economicos =(isset($_REQUEST['numero_telefono_tres_datos_economicos'])&& $_REQUEST['numero_telefono_tres_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_tres_datos_economicos']:'';
                $_empresa_cuatro_datos_economicos =(isset($_REQUEST['empresa_cuatro_datos_economicos'])&& $_REQUEST['empresa_cuatro_datos_economicos'] !=NULL)?$_REQUEST['empresa_cuatro_datos_economicos']:'';
                $_direccion_cuatro_datos_economicos =(isset($_REQUEST['direccion_cuatro_datos_economicos'])&& $_REQUEST['direccion_cuatro_datos_economicos'] !=NULL)?$_REQUEST['direccion_cuatro_datos_economicos']:'';
                $_numero_telefono_cuatro_datos_economicos =(isset($_REQUEST['numero_telefono_cuatro_datos_economicos'])&& $_REQUEST['numero_telefono_cuatro_datos_economicos'] !=NULL)?$_REQUEST['numero_telefono_cuatro_datos_economicos']:'';
                $_efectivo_activos_corrientes =(isset($_REQUEST['efectivo_activos_corrientes'])&& $_REQUEST['efectivo_activos_corrientes'] !=NULL)?$_REQUEST['efectivo_activos_corrientes']:0;
                $_bancos_activos_corrientes =(isset($_REQUEST['bancos_activos_corrientes'])&& $_REQUEST['bancos_activos_corrientes'] !=NULL)?$_REQUEST['bancos_activos_corrientes']:0;
                $_cuentas_cobrar_activos_corrientes =(isset($_REQUEST['cuentas_cobrar_activos_corrientes'])&& $_REQUEST['cuentas_cobrar_activos_corrientes'] !=NULL)?$_REQUEST['cuentas_cobrar_activos_corrientes']:0;
                $_inversiones_activos_corrientes =(isset($_REQUEST['inversiones_activos_corrientes'])&& $_REQUEST['inversiones_activos_corrientes'] !=NULL)?$_REQUEST['inversiones_activos_corrientes']:0;
                $_inventarios_activos_corrientes =(isset($_REQUEST['inventarios_activos_corrientes'])&& $_REQUEST['inventarios_activos_corrientes'] !=NULL)?$_REQUEST['inventarios_activos_corrientes']:0;
                $_muebles_activos_corrientes=(isset($_REQUEST['muebles_activos_corrientes'])&& $_REQUEST['muebles_activos_corrientes'] !=NULL)?$_REQUEST['muebles_activos_corrientes']:0;
                $_otros_activos_corrientes =(isset($_REQUEST['otros_activos_corrientes'])&& $_REQUEST['otros_activos_corrientes'] !=NULL)?$_REQUEST['otros_activos_corrientes']:0;
                $_terreno_activos_fijos =(isset($_REQUEST['terreno_activos_fijos'])&& $_REQUEST['terreno_activos_fijos'] !=NULL)?$_REQUEST['terreno_activos_fijos']:0;
                $_vivienda_activos_fijos =(isset($_REQUEST['vivienda_activos_fijos'])&& $_REQUEST['vivienda_activos_fijos'] !=NULL)?$_REQUEST['vivienda_activos_fijos']:0;
                $_vehiculo_activos_fijos =(isset($_REQUEST['vehiculo_activos_fijos'])&& $_REQUEST['vehiculo_activos_fijos'] !=NULL)?$_REQUEST['vehiculo_activos_fijos']:0;
                $_maquinaria_activos_fijos=(isset($_REQUEST['maquinaria_activos_fijos'])&& $_REQUEST['maquinaria_activos_fijos'] !=NULL)?$_REQUEST['maquinaria_activos_fijos']:0;
                $_otros_activos_fijos =(isset($_REQUEST['otros_activos_fijos'])&& $_REQUEST['otros_activos_fijos'] !=NULL)?$_REQUEST['otros_activos_fijos']:0;
                $_valor_prestacion_activos_intangibles =(isset($_REQUEST['valor_prestacion_activos_intangibles'])&& $_REQUEST['valor_prestacion_activos_intangibles'] !=NULL)?$_REQUEST['valor_prestacion_activos_intangibles']:0;
                $_prestamo_menor_anio_pasivo_corriente =(isset($_REQUEST['prestamo_menor_anio_pasivo_corriente'])&& $_REQUEST['prestamo_menor_anio_pasivo_corriente'] !=NULL)?$_REQUEST['prestamo_menor_anio_pasivo_corriente']:0;
                $_prestamo_emergente_pasivo_corriente =(isset($_REQUEST['prestamo_emergente_pasivo_corriente'])&& $_REQUEST['prestamo_emergente_pasivo_corriente'] !=NULL)?$_REQUEST['prestamo_emergente_pasivo_corriente']:0;
                $_cuentas_pagar_pasivo_corriente =(isset($_REQUEST['cuentas_pagar_pasivo_corriente'])&& $_REQUEST['cuentas_pagar_pasivo_corriente'] !=NULL)?$_REQUEST['cuentas_pagar_pasivo_corriente']:0;
                $_proveedores_pasivo_corriente =(isset($_REQUEST['proveedores_pasivo_corriente'])&& $_REQUEST['proveedores_pasivo_corriente'] !=NULL)?$_REQUEST['proveedores_pasivo_corriente']:0;
                $_obligaciones_menores_anio_pasivo_corriente =(isset($_REQUEST['obligaciones_menores_anio_pasivo_corriente'])&& $_REQUEST['obligaciones_menores_anio_pasivo_corriente'] !=NULL)?$_REQUEST['obligaciones_menores_anio_pasivo_corriente']:0;
                $_con_banco_pasivo_corriente=(isset($_REQUEST['con_banco_pasivo_corriente'])&& $_REQUEST['con_banco_pasivo_corriente'] !=NULL)?$_REQUEST['con_banco_pasivo_corriente']:0;
                $_con_cooperativas_pasivo_corriente =(isset($_REQUEST['con_cooperativas_pasivo_corriente'])&& $_REQUEST['con_cooperativas_pasivo_corriente'] !=NULL)?$_REQUEST['con_cooperativas_pasivo_corriente']:0;
                $_prestamo_mayor_anio_pasivos_largo_plazo =(isset($_REQUEST['prestamo_mayor_anio_pasivos_largo_plazo'])&& $_REQUEST['prestamo_mayor_anio_pasivos_largo_plazo'] !=NULL)?$_REQUEST['prestamo_mayor_anio_pasivos_largo_plazo']:0;
                $_obligaciones_mayores_anio_pasivos_largo_plazo =(isset($_REQUEST['obligaciones_mayores_anio_pasivos_largo_plazo'])&& $_REQUEST['obligaciones_mayores_anio_pasivos_largo_plazo'] !=NULL)?$_REQUEST['obligaciones_mayores_anio_pasivos_largo_plazo']:0;
                $_con_banco_pasivos_largo_plazo =(isset($_REQUEST['con_banco_pasivos_largo_plazo'])&& $_REQUEST['con_banco_pasivos_largo_plazo'] !=NULL)?$_REQUEST['con_banco_pasivos_largo_plazo']:0;
                $_con_cooperativas_pasivos_largo_plazo =(isset($_REQUEST['con_cooperativas_pasivos_largo_plazo'])&& $_REQUEST['con_cooperativas_pasivos_largo_plazo'] !=NULL)?$_REQUEST['con_cooperativas_pasivos_largo_plazo']:0;
                $_otros_pasivos_largo_plazo =(isset($_REQUEST['otros_pasivos_largo_plazo'])&& $_REQUEST['otros_pasivos_largo_plazo'] !=NULL)?$_REQUEST['otros_pasivos_largo_plazo']:0;
                $_patrimonio =(isset($_REQUEST['patrimonio'])&& $_REQUEST['patrimonio'] !=NULL)?$_REQUEST['patrimonio']:0;
                $_garantias_capremci =(isset($_REQUEST['_garantias_capremci'])&& $_REQUEST['_garantias_capremci'] !=NULL)?$_REQUEST['_garantias_capremci']:0;
                $_id_bancos_uno_detalle_activos =(isset($_REQUEST['id_bancos_uno_detalle_activos'])&& $_REQUEST['id_bancos_uno_detalle_activos'] !=NULL)?$_REQUEST['id_bancos_uno_detalle_activos']:0;
                $_tipo_producto_uno_detalle_activos =(isset($_REQUEST['tipo_producto_uno_detalle_activos'])&& $_REQUEST['tipo_producto_uno_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_uno_detalle_activos']:'';
                $_valor_uno_detalle_activos =(isset($_REQUEST['valor_uno_detalle_activos'])&& $_REQUEST['valor_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_uno_detalle_activos']:0;
                $_plazo_uno_detalle_activos =(isset($_REQUEST['plazo_uno_detalle_activos'])&& $_REQUEST['plazo_uno_detalle_activos'] !=NULL)?$_REQUEST['plazo_uno_detalle_activos']:'';
                $_id_bancos_dos_detalle_activos =(isset($_REQUEST['id_bancos_dos_detalle_activos'])&& $_REQUEST['id_bancos_dos_detalle_activos'] !=NULL)?$_REQUEST['id_bancos_dos_detalle_activos']:0;
                $_tipo_producto_dos_detalle_activos =(isset($_REQUEST['tipo_producto_dos_detalle_activos'])&& $_REQUEST['tipo_producto_dos_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_dos_detalle_activos']:'';
                $_valor_dos_detalle_activos =(isset($_REQUEST['valor_dos_detalle_activos'])&& $_REQUEST['valor_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_dos_detalle_activos']:0;
                $_plazo_dos_detalle_activos =(isset($_REQUEST['plazo_dos_detalle_activos'])&& $_REQUEST['plazo_dos_detalle_activos'] !=NULL)?$_REQUEST['plazo_dos_detalle_activos']:'';
                $_id_bancos_tres_detalle_activos =(isset($_REQUEST['id_bancos_tres_detalle_activos'])&& $_REQUEST['id_bancos_tres_detalle_activos'] !=NULL)?$_REQUEST['id_bancos_tres_detalle_activos']:0;
                $_tipo_producto_tres_detalle_activos =(isset($_REQUEST['tipo_producto_tres_detalle_activos'])&& $_REQUEST['tipo_producto_tres_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_tres_detalle_activos']:'';
                $_valor_tres_detalle_activos =(isset($_REQUEST['valor_tres_detalle_activos'])&& $_REQUEST['valor_tres_detalle_activos'] !=NULL)?$_REQUEST['valor_tres_detalle_activos']:0;
                $_plazo_tres_detalle_activos =(isset($_REQUEST['plazo_tres_detalle_activos'])&& $_REQUEST['plazo_tres_detalle_activos'] !=NULL)?$_REQUEST['plazo_tres_detalle_activos']:'';
                $_id_bancos_cuatro_detalle_activos =(isset($_REQUEST['id_bancos_cuatro_detalle_activos'])&& $_REQUEST['id_bancos_cuatro_detalle_activos'] !=NULL)?$_REQUEST['id_bancos_cuatro_detalle_activos']:0;
                $_tipo_producto_cuatro_detalle_activos =(isset($_REQUEST['tipo_producto_cuatro_detalle_activos'])&& $_REQUEST['tipo_producto_cuatro_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_cuatro_detalle_activos']:'';
                $_valor_cuatro_detalle_activos =(isset($_REQUEST['valor_cuatro_detalle_activos'])&& $_REQUEST['valor_cuatro_detalle_activos'] !=NULL)?$_REQUEST['valor_cuatro_detalle_activos']:0;
                $_plazo_cuatro_detalle_activos =(isset($_REQUEST['plazo_cuatro_detalle_activos'])&& $_REQUEST['plazo_cuatro_detalle_activos'] !=NULL)?$_REQUEST['plazo_cuatro_detalle_activos']:'';
                $_muebles_uno_detalle_activos =(isset($_REQUEST['muebles_uno_detalle_activos'])&& $_REQUEST['muebles_uno_detalle_activos'] !=NULL)?$_REQUEST['muebles_uno_detalle_activos']:'';
                $_direccion_uno_detalle_activos =(isset($_REQUEST['direccion_uno_detalle_activos'])&& $_REQUEST['direccion_uno_detalle_activos'] !=NULL)?$_REQUEST['direccion_uno_detalle_activos']:'';
                $_valor_muebles_uno_detalle_activos =(isset($_REQUEST['valor_muebles_uno_detalle_activos'])&& $_REQUEST['valor_muebles_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_uno_detalle_activos']:0;
                $_esta_hipotecado_uno_detalle_activos =(isset($_REQUEST['esta_hipotecado_uno_detalle_activos'])&& $_REQUEST['esta_hipotecado_uno_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecado_uno_detalle_activos']:'';
                $_muebles_dos_detalle_activos =(isset($_REQUEST['muebles_dos_detalle_activos'])&& $_REQUEST['muebles_dos_detalle_activos'] !=NULL)?$_REQUEST['muebles_dos_detalle_activos']:'';
                $_direccion_dos_detalle_activos =(isset($_REQUEST['direccion_dos_detalle_activos'])&& $_REQUEST['direccion_dos_detalle_activos'] !=NULL)?$_REQUEST['direccion_dos_detalle_activos']:'';
                $_valor_muebles_dos_detalle_activos =(isset($_REQUEST['valor_muebles_dos_detalle_activos'])&& $_REQUEST['valor_muebles_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_dos_detalle_activos']:0;
                $_esta_hipotecado_dos_detalle_activos =(isset($_REQUEST['esta_hipotecado_dos_detalle_activos'])&& $_REQUEST['esta_hipotecado_dos_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecado_dos_detalle_activos']:'';
                $_muebles_tres_detalle_activos =(isset($_REQUEST['muebles_tres_detalle_activos'])&& $_REQUEST['muebles_tres_detalle_activos'] !=NULL)?$_REQUEST['muebles_tres_detalle_activos']:'';
                $_direccion_tres_detalle_activos =(isset($_REQUEST['direccion_tres_detalle_activos'])&& $_REQUEST['direccion_tres_detalle_activos'] !=NULL)?$_REQUEST['direccion_tres_detalle_activos']:'';
                $_valor_muebles_tres_detalle_activos =(isset($_REQUEST['valor_muebles_tres_detalle_activos'])&& $_REQUEST['valor_muebles_tres_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_tres_detalle_activos']:0;
                $_esta_hipotecado_tres_detalle_activos =(isset($_REQUEST['esta_hipotecado_tres_detalle_activos'])&& $_REQUEST['esta_hipotecado_tres_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecado_tres_detalle_activos']:'';
                $_muebles_cuatro_detalle_activos =(isset($_REQUEST['muebles_cuatro_detalle_activos'])&& $_REQUEST['muebles_cuatro_detalle_activos'] !=NULL)?$_REQUEST['muebles_cuatro_detalle_activos']:'';
                $_direccion_cuatro_detalle_activos =(isset($_REQUEST['direccion_cuatro_detalle_activos'])&& $_REQUEST['direccion_cuatro_detalle_activos'] !=NULL)?$_REQUEST['direccion_cuatro_detalle_activos']:'';
                $_valor_muebles_cuatro_detalle_activos =(isset($_REQUEST['valor_muebles_cuatro_detalle_activos'])&& $_REQUEST['valor_muebles_cuatro_detalle_activos'] !=NULL)?$_REQUEST['valor_muebles_cuatro_detalle_activos']:0;
                $_esta_hipotecada_cuatro_detalle_activos =(isset($_REQUEST['esta_hipotecada_cuatro_detalle_activos'])&& $_REQUEST['esta_hipotecada_cuatro_detalle_activos'] !=NULL)?$_REQUEST['esta_hipotecada_cuatro_detalle_activos']:'';
                $_vehiculo_uno_detalle_activos =(isset($_REQUEST['vehiculo_uno_detalle_activos'])&& $_REQUEST['vehiculo_uno_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_uno_detalle_activos']:'';
                $_valor_vehiculo_uno_detalle_activos =(isset($_REQUEST['valor_vehiculo_uno_detalle_activos'])&& $_REQUEST['valor_vehiculo_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_uno_detalle_activos']:0;
                $_uso_uno_detalle_activos=(isset($_REQUEST['uso_uno_detalle_activos'])&& $_REQUEST['uso_uno_detalle_activos'] !=NULL)?$_REQUEST['uso_uno_detalle_activos']:'';
                $_asegurado_uno_detalle_activos =(isset($_REQUEST['asegurado_uno_detalle_activos'])&& $_REQUEST['asegurado_uno_detalle_activos'] !=NULL)?$_REQUEST['asegurado_uno_detalle_activos']:'';
                $_vehiculo_dos_detalle_activos =(isset($_REQUEST['vehiculo_dos_detalle_activos'])&& $_REQUEST['vehiculo_dos_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_dos_detalle_activos']:'';
                $_valor_vehiculo_dos_detalle_activos =(isset($_REQUEST['valor_vehiculo_dos_detalle_activos'])&& $_REQUEST['valor_vehiculo_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_dos_detalle_activos']:0;
                $_uso_dos_detalle_activos =(isset($_REQUEST['uso_dos_detalle_activos'])&& $_REQUEST['uso_dos_detalle_activos'] !=NULL)?$_REQUEST['uso_dos_detalle_activos']:'';
                $_asegurado_dos_detalle_activos =(isset($_REQUEST['asegurado_dos_detalle_activos'])&& $_REQUEST['asegurado_dos_detalle_activos'] !=NULL)?$_REQUEST['asegurado_dos_detalle_activos']:'';
                $_vehiculo_tres_detalle_activos =(isset($_REQUEST['vehiculo_tres_detalle_activos'])&& $_REQUEST['vehiculo_tres_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_tres_detalle_activos']:'';
                $_valor_vehiculo_tres_detalle_activos =(isset($_REQUEST['valor_vehiculo_tres_detalle_activos'])&& $_REQUEST['valor_vehiculo_tres_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_tres_detalle_activos']:0;
                $_uso_tres_detalle_activos  =(isset($_REQUEST['uso_tres_detalle_activos character'])&& $_REQUEST['uso_tres_detalle_activos character'] !=NULL)?$_REQUEST['uso_tres_detalle_activos character']:'';
                $_asegurado_tres_detalle_activos =(isset($_REQUEST['asegurado_tres_detalle_activos'])&& $_REQUEST['asegurado_tres_detalle_activos'] !=NULL)?$_REQUEST['asegurado_tres_detalle_activos']:'';
                $_vehiculo_cuatro_detalle_activos=(isset($_REQUEST['vehiculo_cuatro_detalle_activos'])&& $_REQUEST['vehiculo_cuatro_detalle_activos'] !=NULL)?$_REQUEST['vehiculo_cuatro_detalle_activos']:'';
                $_valor_vehiculo_cuatro_detalle_activos =(isset($_REQUEST['valor_vehiculo_cuatro_detalle_activos'])&& $_REQUEST['valor_vehiculo_cuatro_detalle_activos'] !=NULL)?$_REQUEST['valor_vehiculo_cuatro_detalle_activos']:0;
                $_uso_cuatro_detalle_activos=(isset($_REQUEST['uso_cuatro_detalle_activos'])&& $_REQUEST['uso_cuatro_detalle_activos'] !=NULL)?$_REQUEST['uso_cuatro_detalle_activos']:'';
                $_asegurado_cuatro_detalle_activos =(isset($_REQUEST['asegurado_cuatro_detalle_activos'])&& $_REQUEST['asegurado_cuatro_detalle_activos'] !=NULL)?$_REQUEST['asegurado_cuatro_detalle_activos']:'';
                $_otros_uno_detalle_activos =(isset($_REQUEST['otros_uno_detalle_activos'])&& $_REQUEST['otros_uno_detalle_activos'] !=NULL)?$_REQUEST['otros_uno_detalle_activos']:'';
                $_valor_otros_uno_detalle_activos =(isset($_REQUEST['valor_otros_uno_detalle_activos'])&& $_REQUEST['valor_otros_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_otros_uno_detalle_activos']:0;
                $_observacion_otro_uno_detalle_activos =(isset($_REQUEST['observacion_otro_uno_detalle_activos'])&& $_REQUEST['observacion_otro_uno_detalle_activos'] !=NULL)?$_REQUEST['observacion_otro_uno_detalle_activos']:'';
                $_otros_dos_detalle_activos =(isset($_REQUEST['otros_dos_detalle_activos'])&& $_REQUEST['otros_dos_detalle_activos'] !=NULL)?$_REQUEST['otros_dos_detalle_activos']:'';
                $_valor_otros_dos_detalle_activos =(isset($_REQUEST['valor_otros_dos_detalle_activos'])&& $_REQUEST['valor_otros_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_otros_dos_detalle_activos']:'';
                $_observacion_dos_detalle_activos =(isset($_REQUEST['observacion_dos_detalle_activos'])&& $_REQUEST['observacion_dos_detalle_activos'] !=NULL)?$_REQUEST['observacion_dos_detalle_activos']:'';
                $_institucion_uno_detalle_pasivos =(isset($_REQUEST['institucion_uno_detalle_pasivos'])&& $_REQUEST['institucion_uno_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_uno_detalle_pasivos']:'';
                $_valor_uno_detalle_pasivos =(isset($_REQUEST['valor_uno_detalle_pasivos'])&& $_REQUEST['valor_uno_detalle_pasivos'] !=NULL)?$_REQUEST['valor_uno_detalle_pasivos']:'';
                $_destino_uno_detalle_pasivos =(isset($_REQUEST['destino_uno_detalle_pasivos'])&& $_REQUEST['destino_uno_detalle_pasivos'] !=NULL)?$_REQUEST['destino_uno_detalle_pasivos']:'';
                $_garantia_uno_detalle_pasivos =(isset($_REQUEST['garantia_uno_detalle_pasivos'])&& $_REQUEST['garantia_uno_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_uno_detalle_pasivos']:'';
                $_plazo_uno_detalle_pasivos =(isset($_REQUEST['plazo_uno_detalle_pasivos'])&& $_REQUEST['plazo_uno_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_uno_detalle_pasivos']:'';
                $_saldo_uno_detalle_pasivos =(isset($_REQUEST['saldo_uno_detalle_pasivos'])&& $_REQUEST['saldo_uno_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_uno_detalle_pasivos']:'';
                $_institucion_dos_detalle_pasivos =(isset($_REQUEST['institucion_dos_detalle_pasivos'])&& $_REQUEST['institucion_dos_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_dos_detalle_pasivos']:'';
                $_valor_dos_detalle_pasivos =(isset($_REQUEST['valor_dos_detalle_pasivos'])&& $_REQUEST['valor_dos_detalle_pasivos'] !=NULL)?$_REQUEST['valor_dos_detalle_pasivos']:0;
                $_destino_dos_detalle_pasivos =(isset($_REQUEST['destino_dos_detalle_pasivos'])&& $_REQUEST['destino_dos_detalle_pasivos'] !=NULL)?$_REQUEST['destino_dos_detalle_pasivos']:'';
                $_garantia_dos_detalle_pasivos =(isset($_REQUEST['garantia_dos_detalle_pasivos'])&& $_REQUEST['garantia_dos_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_dos_detalle_pasivos']:'';
                $_plazo_dos_detalle_pasivos =(isset($_REQUEST['plazo_dos_detalle_pasivos'])&& $_REQUEST['plazo_dos_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_dos_detalle_pasivos']:'';
                $_saldo_dos_detalle_pasivos =(isset($_REQUEST['saldo_dos_detalle_pasivos'])&& $_REQUEST['saldo_dos_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_dos_detalle_pasivos']:'';
                $_institucion_tres_detalle_pasivos =(isset($_REQUEST['institucion_tres_detalle_pasivos'])&& $_REQUEST['institucion_tres_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_tres_detalle_pasivos']:'';
                $_valor_tres_detalle_pasivos =(isset($_REQUEST['valor_tres_detalle_pasivos'])&& $_REQUEST['valor_tres_detalle_pasivos'] !=NULL)?$_REQUEST['valor_tres_detalle_pasivos']:0;
                $_destino_tres_detalle_pasivos =(isset($_REQUEST['destino_tres_detalle_pasivos'])&& $_REQUEST['destino_tres_detalle_pasivos'] !=NULL)?$_REQUEST['destino_tres_detalle_pasivos']:'';
                $_garantia_tres_detalle_pasivos =(isset($_REQUEST['garantia_tres_detalle_pasivos'])&& $_REQUEST['garantia_tres_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_tres_detalle_pasivos']:'';
                $_plazo_tres_detalle_pasivos =(isset($_REQUEST['plazo_tres_detalle_pasivos'])&& $_REQUEST['plazo_tres_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_tres_detalle_pasivos']:'';
                $_saldo_tres_detalle_pasivos  =(isset($_REQUEST['saldo_tres_detalle_pasivos'])&& $_REQUEST['saldo_tres_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_tres_detalle_pasivos']:'';
                $_institucion_cuatro_detalle_pasivos =(isset($_REQUEST['institucion_cuatro_detalle_pasivos'])&& $_REQUEST['institucion_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_cuatro_detalle_pasivos']:'';
                $_valor_cuatro_detalle_pasivos =(isset($_REQUEST['valor_cuatro_detalle_pasivos'])&& $_REQUEST['valor_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['valor_cuatro_detalle_pasivos']:0;
                $_destino_cuatro_detalle_pasivos =(isset($_REQUEST['destino_cuatro_detalle_pasivos'])&& $_REQUEST['destino_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['destino_cuatro_detalle_pasivos']:'';
                $_garantia_cuatro_detalle_pasivos =(isset($_REQUEST['garantia_cuatro_detalle_pasivos'])&& $_REQUEST['garantia_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_cuatro_detalle_pasivos']:'';
                $_plazo_cuatro_detalle_pasivos =(isset($_REQUEST['plazo_cuatro_detalle_pasivos'])&& $_REQUEST['plazo_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_cuatro_detalle_pasivos']:'';
                $_saldo_cuatro_detalle_pasivos =(isset($_REQUEST['saldo_cuatro_detalle_pasivos'])&& $_REQUEST['saldo_cuatro_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_cuatro_detalle_pasivos']:'';
                $_institucion_cinco_detalle_pasivos =(isset($_REQUEST['institucion_cinco_detalle_pasivos'])&& $_REQUEST['institucion_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['institucion_cinco_detalle_pasivos']:'';
                $_valor_cinco_detalle_pasivos=(isset($_REQUEST['valor_cinco_detalle_pasivos'])&& $_REQUEST['valor_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['valor_cinco_detalle_pasivos']:0;
                $_destino_cinco_detalle_pasivos =(isset($_REQUEST['destino_cinco_detalle_pasivos'])&& $_REQUEST['destino_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['destino_cinco_detalle_pasivos']:'';
                $_garantia_cinco_detalle_pasivos =(isset($_REQUEST['garantia_cinco_detalle_pasivos'])&& $_REQUEST['garantia_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['garantia_cinco_detalle_pasivos']:'';
                $_plazo_cinco_detalle_pasivos =(isset($_REQUEST['plazo_cinco_detalle_pasivos'])&& $_REQUEST['plazo_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['plazo_cinco_detalle_pasivos']:'';
                $_saldo_cinco_detalle_pasivos =(isset($_REQUEST['saldo_cinco_detalle_pasivos'])&& $_REQUEST['saldo_cinco_detalle_pasivos'] !=NULL)?$_REQUEST['saldo_cinco_detalle_pasivos']:'';
                $_sueldo_afiliado_ingresos_mensuales =(isset($_REQUEST['sueldo_afiliado_ingresos_mensuales'])&& $_REQUEST['sueldo_afiliado_ingresos_mensuales'] !=NULL)?$_REQUEST['sueldo_afiliado_ingresos_mensuales']:0;
                $_sueldo_conyuge_ingresos_mensuales =(isset($_REQUEST['sueldo_conyuge_ingresos_mensuales'])&& $_REQUEST['sueldo_conyuge_ingresos_mensuales'] !=NULL)?$_REQUEST['sueldo_conyuge_ingresos_mensuales']:0;
                $_comisiones_ingresos_mensuales =(isset($_REQUEST['comisiones_ingresos_mensuales'])&& $_REQUEST['comisiones_ingresos_mensuales'] !=NULL)?$_REQUEST['comisiones_ingresos_mensuales']:0;
                $_arriendos_ingresos_mensuales =(isset($_REQUEST['arriendos_ingresos_mensuales'])&& $_REQUEST['arriendos_ingresos_mensuales'] !=NULL)?$_REQUEST['arriendos_ingresos_mensuales']:0;
                $_dividendos_ingresos_mensuales =(isset($_REQUEST['dividendos_ingresos_mensuales'])&& $_REQUEST['dividendos_ingresos_mensuales'] !=NULL)?$_REQUEST['dividendos_ingresos_mensuales']:0;
                $_ingresos_negocio_ingresos_mensuales =(isset($_REQUEST['ingresos_negocio_ingresos_mensuales'])&& $_REQUEST['ingresos_negocio_ingresos_mensuales'] !=NULL)?$_REQUEST['ingresos_negocio_ingresos_mensuales']:0;
                $_pensiones_ingresos_mensuales =(isset($_REQUEST['pensiones_ingresos_mensuales'])&& $_REQUEST['pensiones_ingresos_mensuales'] !=NULL)?$_REQUEST['pensiones_ingresos_mensuales']:0;
                $_otros_detalle_uno_ingresos_mensuales =(isset($_REQUEST['otros_detalle_uno_ingresos_mensuales'])&& $_REQUEST['otros_detalle_uno_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_uno_ingresos_mensuales']:'';
                $_otros_uno_ingresos_mensuales =(isset($_REQUEST['otros_uno_ingresos_mensuales'])&& $_REQUEST['otros_uno_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_uno_ingresos_mensuales']:0;
                $_otros_detalle_dos_ingresos_mensuales =(isset($_REQUEST['otros_detalle_dos_ingresos_mensuales'])&& $_REQUEST['otros_detalle_dos_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_dos_ingresos_mensuales']:'';
                $_otros_dos_ingresos_mensuales =(isset($_REQUEST['otros_dos_ingresos_mensuales'])&& $_REQUEST['otros_dos_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_dos_ingresos_mensuales']:0;
                $_otros_detalle_tres_ingresos_mensuales =(isset($_REQUEST['otros_detalle_tres_ingresos_mensuales'])&& $_REQUEST['otros_detalle_tres_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_tres_ingresos_mensuales']:'';
                $_otros_tres_ingresos_mensuales =(isset($_REQUEST['otros_tres_ingresos_mensuales'])&& $_REQUEST['otros_tres_ingresos_mensuales'] !=NULL)?$_REQUEST['otros_tres_ingresos_mensuales']:0;
                $_alimentacion_gastos_mensuales =(isset($_REQUEST['alimentacion_gastos_mensuales'])&& $_REQUEST['alimentacion_gastos_mensuales'] !=NULL)?$_REQUEST['alimentacion_gastos_mensuales']:0;
                $_arriendos_gastos_mensuales =(isset($_REQUEST['arriendos_gastos_mensuales'])&& $_REQUEST['arriendos_gastos_mensuales'] !=NULL)?$_REQUEST['arriendos_gastos_mensuales']:0;
                $_educacion_gastos_mensuales =(isset($_REQUEST['educacion_gastos_mensuales'])&& $_REQUEST['educacion_gastos_mensuales'] !=NULL)?$_REQUEST['educacion_gastos_mensuales']:0;
                $_vestuario_gastos_mensuales =(isset($_REQUEST['vestuario_gastos_mensuales'])&& $_REQUEST['vestuario_gastos_mensuales'] !=NULL)?$_REQUEST['vestuario_gastos_mensuales']:0;
                $_servicios_publicos_gastos_mensuales =(isset($_REQUEST['servicios_publicos_gastos_mensuales'])&& $_REQUEST['servicios_publicos_gastos_mensuales'] !=NULL)?$_REQUEST['servicios_publicos_gastos_mensuales']:0;
                $_movilizacion_gastos_mensuales =(isset($_REQUEST['movilizacion_gastos_mensuales'])&& $_REQUEST['movilizacion_gastos_mensuales'] !=NULL)?$_REQUEST['movilizacion_gastos_mensuales']:0;
                $_ahorros_cooperativas_gastos_mensuales =(isset($_REQUEST['ahorros_cooperativas_gastos_mensuales'])&& $_REQUEST['ahorros_cooperativas_gastos_mensuales'] !=NULL)?$_REQUEST['ahorros_cooperativas_gastos_mensuales']:0;
                $_cuotas_tarjetas_gastos_mensuales =(isset($_REQUEST['cuotas_tarjetas_gastos_mensuales'])&& $_REQUEST['cuotas_tarjetas_gastos_mensuales'] !=NULL)?$_REQUEST['cuotas_tarjetas_gastos_mensuales']:0;
                $_cuotas_prestamo_gastos_mensuales =(isset($_REQUEST['cuotas_prestamo_gastos_mensuales'])&& $_REQUEST['cuotas_prestamo_gastos_mensuales'] !=NULL)?$_REQUEST['cuotas_prestamo_gastos_mensuales']:0;
                $_otros_detalle_uno_gastos_mensuales =(isset($_REQUEST['otros_detalle_uno_gastos_mensuales'])&& $_REQUEST['otros_detalle_uno_gastos_mensuales'] !=NULL)?$_REQUEST['otros_detalle_uno_gastos_mensuales']:'';
                $_otros_gastos_uno_gastos_mensuales =(isset($_REQUEST['otros_gastos_uno_gastos_mensuales'])&& $_REQUEST['otros_gastos_uno_gastos_mensuales'] !=NULL)?$_REQUEST['otros_gastos_uno_gastos_mensuales']:0;
                
                
                
                
                
                $_id_codigo_verificacion =(isset($_REQUEST['id_codigo_verificacion'])&& $_REQUEST['id_codigo_verificacion'] !=NULL)?$_REQUEST['id_codigo_verificacion']:0;
                $_id_sucursales =(isset($_REQUEST['id_sucursales'])&& $_REQUEST['id_sucursales'] !=NULL)?$_REQUEST['id_sucursales']:0;
                
                
                
                
                
                $_total_activos_corrientes=$_efectivo_activos_corrientes+$_bancos_activos_corrientes+$_cuentas_cobrar_activos_corrientes+$_inversiones_activos_corrientes+$_inventarios_activos_corrientes+$_muebles_activos_corrientes+$_otros_activos_corrientes;
                $_total_activos_fijos=$_terreno_activos_fijos+$_vivienda_activos_fijos+$_vehiculo_activos_fijos+$_maquinaria_activos_fijos+$_otros_activos_fijos;
                $_total_activos=$_total_activos_corrientes+$_total_activos_fijos;
                $_total_pasivos_corrientes=$_prestamo_menor_anio_pasivo_corriente+$_prestamo_emergente_pasivo_corriente+$_cuentas_pagar_pasivo_corriente+$_proveedores_pasivo_corriente+$_obligaciones_menores_anio_pasivo_corriente+$_con_banco_pasivo_corriente+$_con_cooperativas_pasivo_corriente;
                $_total_pasivos_largo_plazo=$_prestamo_mayor_anio_pasivos_largo_plazo+$_obligaciones_mayores_anio_pasivos_largo_plazo+$_con_banco_pasivos_largo_plazo+$_con_cooperativas_pasivos_largo_plazo+$_otros_pasivos_largo_plazo;
                $_total_pasivos=$_total_pasivos_corrientes+$_total_pasivos_largo_plazo;
                
                
                
                $_total_ingresos_mensuales=$_sueldo_afiliado_ingresos_mensuales+$_sueldo_conyuge_ingresos_mensuales+$_comisiones_ingresos_mensuales+$_arriendos_ingresos_mensuales+$_dividendos_ingresos_mensuales+$_ingresos_negocio_ingresos_mensuales+$_pensiones_ingresos_mensuales+$_otros_uno_ingresos_mensuales+$_otros_dos_ingresos_mensuales+$_otros_tres_ingresos_mensuales;
                $_total_gastos_mensuales=$_alimentacion_gastos_mensuales+$_arriendos_gastos_mensuales+$_educacion_gastos_mensuales+$_vestuario_gastos_mensuales+$_servicios_publicos_gastos_mensuales+$_movilizacion_gastos_mensuales+$_ahorros_cooperativas_gastos_mensuales+$_cuotas_tarjetas_gastos_mensuales+$_cuotas_prestamo_gastos_mensuales+$_otros_gastos_uno_gastos_mensuales;
                
                
                
                
                
                
                $_fecha_actual =    getdate();
                $_fecha_año    =	$_fecha_actual['year'];
                $_fecha_mes    =	$_fecha_actual['mon'];
                $_fecha_dia    =	$_fecha_actual['mday'];
                
                $_fecha_presentacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
                $_id_usuarios_registra = $_SESSION['id_usuarios'];
                
                $_id_sucursales                                       = $_POST["id_sucursales"];
                
                
                if($_id_solicitud_hipotecario == 0){
                    
                }else{
                    
                    
                    $columnas="
                    valor_dolares_datos_credito	=	'$_valor_dolares_datos_credito',
                    plazo_meses_datos_credito	=	'$_plazo_meses_datos_credito',
                    destino_dinero_datos_credito	=	'$_destino_dinero_datos_credito',
                    nombres_datos_personales	=	'$_nombres_datos_personales',
                    apellidos_datos_personales	=	'$_apellidos_datos_personales',
                    cedula_datos_personales	=	'$_cedula_datos_personales',
                    id_sexo	=	'$_id_sexo',
                    fecha_nacimiento_datos_personales	=	'$_fecha_nacimiento_datos_personales',
                    id_estado_civil	=	'$_id_estado_civil',
                    separacion_bienes_datos_personales	=	'$_separacion_bienes_datos_personales',
                    cargas_familiares_datos_personales	=	'$_cargas_familiares_datos_personales',
                    numero_hijos_datos_personales	=	'$_numero_hijos_datos_personales',
                    id_provincia	=	'$_id_provincia',
                    id_canton	=	'$_id_canton',
                    id_parroquia	=	'$_id_parroquia',
                    barrio_datos_personales	=	'$_barrio_datos_personales',
                    ciudadela_datos_personales	=	'$_ciudadela_datos_personales',
                    calle_datos_personales	=	'$_calle_datos_personales',
                    numero_calle_datos_personales	=	'$_numero_calle_datos_personales',
                    interseccion_datos_personales	=	'$_interseccion_datos_personales',
                    tipo_vivienda_datos_personales	=	'$_tipo_vivienda_datos_personales',
                    vivienda_hipotecada_datos_personales	=	'$_vivienda_hipotecada_datos_personales',
                    tiempo_residencia_datos_personales	=	'$_tiempo_residencia_datos_personales',
                    referencia_domiciliaria_datos_perdonales	=	'$_referencia_domiciliaria_datos_perdonales',
                    nombre_arrendatario_datos_personales	=	'$_nombre_arrendatario_datos_personales',
                    apellido_arrendatario_datos_personales	=	'$_apellido_arrendatario_datos_personales',
                    celular_arrendatario_datos_personales	=	'$_celular_arrendatario_datos_personales',
                    telefono_datos_personales	=	'$_telefono_datos_personales',
                    celular_datos_personales	=	'$_celular_datos_personales',
                    telf_trabajo_datos_personales	=	'$_telf_trabajo_datos_personales',
                    ext_telef_datos_personales	=	'$_ext_telef_datos_personales',
                    node_telef_datos_personales	=	'$_node_telef_datos_personales',
                    email_datos_personales	=	'$_email_datos_personales',
                    nivel_educativo_datos_personales	=	'$_nivel_educativo_datos_personales',
                    nombres_referencia_familiar_datos_personales	=	'$_nombres_referencia_familiar_datos_personales',
                    apellidos_referencia_familiar_datos_personales	=	'$_apellidos_referencia_familiar_datos_personales',
                    parentesco_referencia_familiar_datos_personales	=	'$_parentesco_referencia_familiar_datos_personales',
                    primer_telefono_ref_familiar_datos_personales	=	'$_primer_telefono_ref_familiar_datos_personales',
                    segundo_telefono_ref_familiar_datos_personales	=	'$_segundo_telefono_ref_familiar_datos_personales',
                    nombres_referencia_personal_datos_personales	=	'$_nombres_referencia_personal_datos_personales',
                    apellidos_referencia_personal_datos_personales	=	'$_apellidos_referencia_personal_datos_personales',
                    relacion_referencia_personal_datos_personales	=	'$_relacion_referencia_personal_datos_personales',
                    primer_telefono_ref_personal_datos_personales	=	'$_primer_telefono_ref_personal_datos_personales',
                    segundo_telefono_ref_personal_datos_personales	=	'$_segundo_telefono_ref_personal_datos_personales',
                    id_entidades	=	'$_id_entidades',
                    reparto_unidad_datos_laborales	=	'$_reparto_unidad_datos_laborales',
                    seccion_datos_laborales	=	'$_seccion_datos_laborales',
                    nombres_jefe_datos_laborales	=	'$_nombres_jefe_datos_laborales',
                    apellidos_jefe_datos_laborales	=	'$_apellidos_jefe_datos_laborales',
                    telefono_jefe_datos_laborales	=	'$_telefono_jefe_datos_laborales',
                    id_provincia_datos_laborales	=	'$_id_provincia_datos_laborales',
                    id_canton_datos_laborales	=	'$_id_canton_datos_laborales',
                    id_parroquia_datos_laborales	=	'$_id_parroquia_datos_laborales',
                    calle_datos_laborales	=	'$_calle_datos_laborales',
                    numero_calle_datos_laborales	=	'$_numero_calle_datos_laborales',
                    interseccion_datos_laborales	=	'$_interseccion_datos_laborales',
                    referencia_direccion_trabajo_datos_laborales	=	'$_referencia_direccion_trabajo_datos_laborales',
                    cargo_actual_datos_laborales	=	'$_cargo_actual_datos_laborales',
                    anios_servicio_datos_laborales	=	'$_anios_servicio_datos_laborales',
                    nombres_datos_conyuge	=	'$_nombres_datos_conyuge',
                    apellidos_datos_conyuge	=	'$_apellidos_datos_conyuge',
                    cedula_datos_conyuge	=	'$_cedula_datos_conyuge',
                    id_sexo_datos_conyuge	=	'$_id_sexo_datos_conyuge',
                    fecha_nacimiento_datos_conyuge	=	'$_fecha_nacimiento_datos_conyuge',
                    vive_residencia_datos_conyuge	=	'$_vive_residencia_datos_conyuge',
                    celular_datos_conyuge	=	'$_celular_datos_conyuge',
                    telefono_datos_conyuge	=	'$_telefono_datos_conyuge',
                    id_provincia_datos_conyuge	=	'$_id_provincia_datos_conyuge',
                    id_canton_datos_conyuge	=	'$_id_canton_datos_conyuge',
                    id_parroquia_datos_conyuge	=	'$_id_parroquia_datos_conyuge',
                    barrio_datos_conyuge	=	'$_barrio_datos_conyuge',
                    ciudadela_datos_conyuge	=	'$_ciudadela_datos_conyuge',
                    calle_datos_conyuge	=	'$_calle_datos_conyuge',
                    numero_calle_datos_conyuge	=	'$_numero_calle_datos_conyuge',
                    interseccion_datos_conyuge	=	'$_interseccion_datos_conyuge',
                    actividad_economica_datos_conyuge	=	'$_actividad_economica_datos_conyuge',
                    empresa_datos_conyuge	=	'$_empresa_datos_conyuge',
                    naturaleza_negocio_datos_conyuge	=	'$_naturaleza_negocio_datos_conyuge',
                    cargo_datos_conyuge	=	'$_cargo_datos_conyuge',
                    tipo_contrato_datos_conyuge	=	'$_tipo_contrato_datos_conyuge',
                    anios_laborados_datos_conyuge	=	'$_anios_laborados_datos_conyuge',
                    nombres_jefe_datos_conyuge	=	'$_nombres_jefe_datos_conyuge',
                    apellidos_jefe_datos_conyuge	=	'$_apellidos_jefe_datos_conyuge',
                    telefono_jefe_datos_conyuge	=	'$_telefono_jefe_datos_conyuge',
                    id_provincia_trabajo_datos_conyuge	=	'$_id_provincia_trabajo_datos_conyuge',
                    id_canton_trabajo_datos_conyuge	=	'$_id_canton_trabajo_datos_conyuge',
                    id_parroquia_trabajo_datos_conyuge	=	'$_id_parroquia_trabajo_datos_conyuge',
                    calle_trabajo_datos_conyuge	=	'$_calle_trabajo_datos_conyuge',
                    nuemero_calle_trabajo_datos_conyuge	=	'$_nuemero_calle_trabajo_datos_conyuge',
                    interseccion_trabajo_datos_conyuge	=	'$_interseccion_trabajo_datos_conyuge',
                    referencia_trabajo_datos_conyuge	=	'$_referencia_trabajo_datos_conyuge',
                    actividad_principal_datos_independientes	=	'$_actividad_principal_datos_independientes',
                    ruc_datos_independientes	=	'$_ruc_datos_independientes',
                    detalle_actividades_datos_independientes	=	'$_detalle_actividades_datos_independientes',
                    local_datos_independientes	=	'$_local_datos_independientes',
                    nombres_propietario_datos_independientes	=	'$_nombres_propietario_datos_independientes',
                    apellidos_propietario_datos_independientes	=	'$_apellidos_propietario_datos_independientes',
                    telefono_propietario_datos_independientes	=	'$_telefono_propietario_datos_independientes',
                    tiempo_funcionamiento_datos_independientes	=	'$_tiempo_funcionamiento_datos_independientes',
                    numero_patronal_datos_independientes	=	'$_numero_patronal_datos_independientes',
                    numero_empleados_datos_independientes	=	'$_numero_empleados_datos_independientes',
                    id_bancos_referencia_bancaria	=	'$_id_bancos_referencia_bancaria',
                    tipo_cuenta_referencia_bancaria	=	'$_tipo_cuenta_referencia_bancaria',
                    numero_cuenta_referencia_bancaria	=	'$_numero_cuenta_referencia_bancaria',
                    id_bancos_uno_datos_economicos	=	'$_id_bancos_uno_datos_economicos',
                    tipo_cuenta_uno_datos_economicos	=	'$_tipo_cuenta_uno_datos_economicos',
                    numero_cuenta_uno_datos_economicos	=	'$_numero_cuenta_uno_datos_economicos',
                    id_bancos_dos_datos_economicos	=	'$_id_bancos_dos_datos_economicos',
                    tipo_cuenta_dos_datos_economicos	=	'$_tipo_cuenta_dos_datos_economicos',
                    numero_cuenta_dos_datos_economicos	=	'$_numero_cuenta_dos_datos_economicos',
                    id_bancos_tres_datos_economicos	=	'$_id_bancos_tres_datos_economicos',
                    tipo_cuenta_tres_datos_economicos	=	'$_tipo_cuenta_tres_datos_economicos',
                    numero_cuenta_tres_datos_economicos	=	'$_numero_cuenta_tres_datos_economicos',
                    id_bancos_cuatro_datos_economicos	=	'$_id_bancos_cuatro_datos_economicos',
                    tipo_cuenta_cuatro_datos_economicos	=	'$_tipo_cuenta_cuatro_datos_economicos',
                    numero_cuenta_cuatro_datos_economicos	=	'$_numero_cuenta_cuatro_datos_economicos',
                    empresa_uno_datos_economicos	=	'$_empresa_uno_datos_economicos',
                    direccion_uno_datos_economicos	=	'$_direccion_uno_datos_economicos',
                    numero_telefono_uno_datos_economicos	=	'$_numero_telefono_uno_datos_economicos',
                    empresa_dos_datos_economicos	=	'$_empresa_dos_datos_economicos',
                    direccion_dos_datos_economicos	=	'$_direccion_dos_datos_economicos',
                    numero_telefono_dos_datos_economicos	=	'$_numero_telefono_dos_datos_economicos',
                    empresa_tres_datos_economicos	=	'$_empresa_tres_datos_economicos',
                    direccion_tres_datos_economicos	=	'$_direccion_tres_datos_economicos',
                    numero_telefono_tres_datos_economicos	=	'$_numero_telefono_tres_datos_economicos',
                    empresa_cuatro_datos_economicos	=	'$_empresa_cuatro_datos_economicos',
                    direccion_cuatro_datos_economicos	=	'$_direccion_cuatro_datos_economicos',
                    numero_telefono_cuatro_datos_economicos	=	'$_numero_telefono_cuatro_datos_economicos',
                    efectivo_activos_corrientes	=	'$_efectivo_activos_corrientes',
                    bancos_activos_corrientes	=	'$_bancos_activos_corrientes',
                    cuentas_cobrar_activos_corrientes	=	'$_cuentas_cobrar_activos_corrientes',
                    inversiones_activos_corrientes	=	'$_inversiones_activos_corrientes',
                    inventarios_activos_corrientes	=	'$_inventarios_activos_corrientes',
                    muebles_activos_corrientes	=	'$_muebles_activos_corrientes',
                    otros_activos_corrientes	=	'$_otros_activos_corrientes',
                    terreno_activos_fijos	=	'$_terreno_activos_fijos',
                    vivienda_activos_fijos	=	'$_vivienda_activos_fijos',
                    vehiculo_activos_fijos	=	'$_vehiculo_activos_fijos',
                    maquinaria_activos_fijos	=	'$_maquinaria_activos_fijos',
                    otros_activos_fijos	=	'$_otros_activos_fijos',
                    valor_prestacion_activos_intangibles	=	'$_valor_prestacion_activos_intangibles',
                    prestamo_menor_anio_pasivo_corriente	=	'$_prestamo_menor_anio_pasivo_corriente',
                    prestamo_emergente_pasivo_corriente	=	'$_prestamo_emergente_pasivo_corriente',
                    cuentas_pagar_pasivo_corriente	=	'$_cuentas_pagar_pasivo_corriente',
                    proveedores_pasivo_corriente	=	'$_proveedores_pasivo_corriente',
                    obligaciones_menores_anio_pasivo_corriente	=	'$_obligaciones_menores_anio_pasivo_corriente',
                    con_banco_pasivo_corriente	=	'$_con_banco_pasivo_corriente',
                    con_cooperativas_pasivo_corriente	=	'$_con_cooperativas_pasivo_corriente',
                    prestamo_mayor_anio_pasivos_largo_plazo	=	'$_prestamo_mayor_anio_pasivos_largo_plazo',
                    obligaciones_mayores_anio_pasivos_largo_plazo	=	'$_obligaciones_mayores_anio_pasivos_largo_plazo',
                    con_banco_pasivos_largo_plazo	=	'$_con_banco_pasivos_largo_plazo',
                    con_cooperativas_pasivos_largo_plazo	=	'$_con_cooperativas_pasivos_largo_plazo',
                    otros_pasivos_largo_plazo	=	'$_otros_pasivos_largo_plazo',
                    patrimonio	=	'$_patrimonio',
                    garantias_capremci	=	'$_garantias_capremci',
                    id_bancos_uno_detalle_activos	=	'$_id_bancos_uno_detalle_activos',
                    tipo_producto_uno_detalle_activos	=	'$_tipo_producto_uno_detalle_activos',
                    valor_uno_detalle_activos	=	'$_valor_uno_detalle_activos',
                    plazo_uno_detalle_activos	=	'$_plazo_uno_detalle_activos',
                    id_bancos_dos_detalle_activos	=	'$_id_bancos_dos_detalle_activos',
                    tipo_producto_dos_detalle_activos	=	'$_tipo_producto_dos_detalle_activos',
                    valor_dos_detalle_activos	=	'$_valor_dos_detalle_activos',
                    plazo_dos_detalle_activos	=	'$_plazo_dos_detalle_activos',
                    id_bancos_tres_detalle_activos	=	'$_id_bancos_tres_detalle_activos',
                    tipo_producto_tres_detalle_activos	=	'$_tipo_producto_tres_detalle_activos',
                    valor_tres_detalle_activos	=	'$_valor_tres_detalle_activos',
                    plazo_tres_detalle_activos	=	'$_plazo_tres_detalle_activos',
                    id_bancos_cuatro_detalle_activos	=	'$_id_bancos_cuatro_detalle_activos',
                    tipo_producto_cuatro_detalle_activos	=	'$_tipo_producto_cuatro_detalle_activos',
                    valor_cuatro_detalle_activos	=	'$_valor_cuatro_detalle_activos',
                    plazo_cuatro_detalle_activos	=	'$_plazo_cuatro_detalle_activos',
                    muebles_uno_detalle_activos	=	'$_muebles_uno_detalle_activos',
                    direccion_uno_detalle_activos	=	'$_direccion_uno_detalle_activos',
                    valor_muebles_uno_detalle_activos	=	'$_valor_muebles_uno_detalle_activos',
                    esta_hipotecado_uno_detalle_activos	=	'$_esta_hipotecado_uno_detalle_activos',
                    muebles_dos_detalle_activos	=	'$_muebles_dos_detalle_activos',
                    direccion_dos_detalle_activos	=	'$_direccion_dos_detalle_activos',
                    valor_muebles_dos_detalle_activos	=	'$_valor_muebles_dos_detalle_activos',
                    esta_hipotecado_dos_detalle_activos	=	'$_esta_hipotecado_dos_detalle_activos',
                    muebles_tres_detalle_activos	=	'$_muebles_tres_detalle_activos',
                    direccion_tres_detalle_activos	=	'$_direccion_tres_detalle_activos',
                    valor_muebles_tres_detalle_activos	=	'$_valor_muebles_tres_detalle_activos',
                    esta_hipotecado_tres_detalle_activos	=	'$_esta_hipotecado_tres_detalle_activos',
                    muebles_cuatro_detalle_activos	=	'$_muebles_cuatro_detalle_activos',
                    direccion_cuatro_detalle_activos	=	'$_direccion_cuatro_detalle_activos',
                    valor_muebles_cuatro_detalle_activos	=	'$_valor_muebles_cuatro_detalle_activos',
                    esta_hipotecada_cuatro_detalle_activos	=	'$_esta_hipotecada_cuatro_detalle_activos',
                    vehiculo_uno_detalle_activos	=	'$_vehiculo_uno_detalle_activos',
                    valor_vehiculo_uno_detalle_activos	=	'$_valor_vehiculo_uno_detalle_activos',
                    uso_uno_detalle_activos	=	'$_uso_uno_detalle_activos',
                    asegurado_uno_detalle_activos	=	'$_asegurado_uno_detalle_activos',
                    vehiculo_dos_detalle_activos	=	'$_vehiculo_dos_detalle_activos',
                    valor_vehiculo_dos_detalle_activos	=	'$_valor_vehiculo_dos_detalle_activos',
                    uso_dos_detalle_activos	=	'$_uso_dos_detalle_activos',
                    asegurado_dos_detalle_activos	=	'$_asegurado_dos_detalle_activos',
                    vehiculo_tres_detalle_activos	=	'$_vehiculo_tres_detalle_activos',
                    valor_vehiculo_tres_detalle_activos	=	'$_valor_vehiculo_tres_detalle_activos',
                    uso_tres_detalle_activos	=	'$_uso_tres_detalle_activos',
                    asegurado_tres_detalle_activos	=	'$_asegurado_tres_detalle_activos',
                    vehiculo_cuatro_detalle_activos	=	'$_vehiculo_cuatro_detalle_activos',
                    valor_vehiculo_cuatro_detalle_activos	=	'$_valor_vehiculo_cuatro_detalle_activos',
                    uso_cuatro_detalle_activos	=	'$_uso_cuatro_detalle_activos',
                    asegurado_cuatro_detalle_activos	=	'$_asegurado_cuatro_detalle_activos',
                    otros_uno_detalle_activos	=	'$_otros_uno_detalle_activos',
                    valor_otros_uno_detalle_activos	=	'$_valor_otros_uno_detalle_activos',
                    observacion_otro_uno_detalle_activos	=	'$_observacion_otro_uno_detalle_activos',
                    otros_dos_detalle_activos	=	'$_otros_dos_detalle_activos',
                    valor_otros_dos_detalle_activos	=	'$_valor_otros_dos_detalle_activos',
                    observacion_dos_detalle_activos	=	'$_observacion_dos_detalle_activos',
                    institucion_uno_detalle_pasivos	=	'$_institucion_uno_detalle_pasivos',
                    valor_uno_detalle_pasivos	=	'$_valor_uno_detalle_pasivos',
                    destino_uno_detalle_pasivos	=	'$_destino_uno_detalle_pasivos',
                    garantia_uno_detalle_pasivos	=	'$_garantia_uno_detalle_pasivos',
                    plazo_uno_detalle_pasivos	=	'$_plazo_uno_detalle_pasivos',
                    saldo_uno_detalle_pasivos	=	'$_saldo_uno_detalle_pasivos',
                    institucion_dos_detalle_pasivos	=	'$_institucion_dos_detalle_pasivos',
                    valor_dos_detalle_pasivos	=	'$_valor_dos_detalle_pasivos',
                    destino_dos_detalle_pasivos	=	'$_destino_dos_detalle_pasivos',
                    garantia_dos_detalle_pasivos	=	'$_garantia_dos_detalle_pasivos',
                    plazo_dos_detalle_pasivos	=	'$_plazo_dos_detalle_pasivos',
                    saldo_dos_detalle_pasivos	=	'$_saldo_dos_detalle_pasivos',
                    institucion_tres_detalle_pasivos	=	'$_institucion_tres_detalle_pasivos',
                    valor_tres_detalle_pasivos	=	'$_valor_tres_detalle_pasivos',
                    destino_tres_detalle_pasivos	=	'$_destino_tres_detalle_pasivos',
                    garantia_tres_detalle_pasivos	=	'$_garantia_tres_detalle_pasivos',
                    plazo_tres_detalle_pasivos	=	'$_plazo_tres_detalle_pasivos',
                    saldo_tres_detalle_pasivos	=	'$_saldo_tres_detalle_pasivos',
                    institucion_cuatro_detalle_pasivos	=	'$_institucion_cuatro_detalle_pasivos',
                    valor_cuatro_detalle_pasivos	=	'$_valor_cuatro_detalle_pasivos',
                    destino_cuatro_detalle_pasivos	=	'$_destino_cuatro_detalle_pasivos',
                    garantia_cuatro_detalle_pasivos	=	'$_garantia_cuatro_detalle_pasivos',
                    plazo_cuatro_detalle_pasivos	=	'$_plazo_cuatro_detalle_pasivos',
                    saldo_cuatro_detalle_pasivos	=	'$_saldo_cuatro_detalle_pasivos',
                    institucion_cinco_detalle_pasivos	=	'$_institucion_cinco_detalle_pasivos',
                    valor_cinco_detalle_pasivos	=	'$_valor_cinco_detalle_pasivos',
                    destino_cinco_detalle_pasivos	=	'$_destino_cinco_detalle_pasivos',
                    garantia_cinco_detalle_pasivos	=	'$_garantia_cinco_detalle_pasivos',
                    plazo_cinco_detalle_pasivos	=	'$_plazo_cinco_detalle_pasivos',
                    saldo_cinco_detalle_pasivos	=	'$_saldo_cinco_detalle_pasivos',
                    sueldo_afiliado_ingresos_mensuales	=	'$_sueldo_afiliado_ingresos_mensuales',
                    sueldo_conyuge_ingresos_mensuales	=	'$_sueldo_conyuge_ingresos_mensuales',
                    comisiones_ingresos_mensuales	=	'$_comisiones_ingresos_mensuales',
                    arriendos_ingresos_mensuales	=	'$_arriendos_ingresos_mensuales',
                    dividendos_ingresos_mensuales	=	'$_dividendos_ingresos_mensuales',
                    ingresos_negocio_ingresos_mensuales	=	'$_ingresos_negocio_ingresos_mensuales',
                    pensiones_ingresos_mensuales	=	'$_pensiones_ingresos_mensuales',
                    otros_detalle_uno_ingresos_mensuales	=	'$_otros_detalle_uno_ingresos_mensuales',
                    otros_uno_ingresos_mensuales	=	'$_otros_uno_ingresos_mensuales',
                    otros_detalle_dos_ingresos_mensuales	=	'$_otros_detalle_dos_ingresos_mensuales',
                    otros_dos_ingresos_mensuales	=	'$_otros_dos_ingresos_mensuales',
                    otros_detalle_tres_ingresos_mensuales	=	'$_otros_detalle_tres_ingresos_mensuales',
                    otros_tres_ingresos_mensuales	=	'$_otros_tres_ingresos_mensuales',
                    alimentacion_gastos_mensuales	=	'$_alimentacion_gastos_mensuales',
                    arriendos_gastos_mensuales	=	'$_arriendos_gastos_mensuales',
                    educacion_gastos_mensuales	=	'$_educacion_gastos_mensuales',
                    vestuario_gastos_mensuales	=	'$_vestuario_gastos_mensuales',
                    servicios_publicos_gastos_mensuales	=	'$_servicios_publicos_gastos_mensuales',
                    movilizacion_gastos_mensuales	=	'$_movilizacion_gastos_mensuales',
                    ahorros_cooperativas_gastos_mensuales	=	'$_ahorros_cooperativas_gastos_mensuales',
                    cuotas_tarjetas_gastos_mensuales	=	'$_cuotas_tarjetas_gastos_mensuales',
                    cuotas_prestamo_gastos_mensuales	=	'$_cuotas_prestamo_gastos_mensuales',
                    otros_detalle_uno_gastos_mensuales	=	'$_otros_detalle_uno_gastos_mensuales',
                    otros_gastos_uno_gastos_mensuales	=	'$_otros_gastos_uno_gastos_mensuales',
                    id_codigo_verificacion	=	'$_id_codigo_verificacion',
                    total_activos_corrientes	=	'$_total_activos_corrientes',
                    total_activos_fijos	=	'$_total_activos_fijos',
                    total_activos	=	'$_total_activos',
                    total_pasivos_corrientes	=	'$_total_pasivos_corrientes',
                    total_pasivos_largo_plazo	=	'$_total_pasivos_largo_plazo',
                    total_pasivos	=	'$_total_pasivos',
                    total_ingresos_mensuales	=	'$_total_ingresos_mensuales',
                    total_gastos_mensuales	=	'$_total_gastos_mensuales',
                    id_usuarios_registra	=	'$_id_usuarios_registra',
                    identificador_consecutivos	=	'$_identificador_consecutivos',
                    fecha_presentacion	=	'$_fecha_presentacion',
                    fecha_aprobacion	=	'$_fecha_aprobacion',
                    id_estado_tramites	=	'$_id_estado_tramites',
                    id_sucursales	=	'$_id_sucursales'




";
                    $tablas="solicitud_hipotecario";
                    $where="id_solicitud_hipotecario = '$_id_solicitud_hipotecario'";
                    $resultado2=$solicitudhipotecario->UpdateBy($columnas, $tablas, $where);
                    
                    
                    
                }
                
                
                $this->redirect("SolicitudHipotecario", "index3");
                
                
                
            }
            else
            {
                $this->redirect("SolicitudHipotecario", "index3");
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
            $solicitudhipotecario = new SolicitudHipotecarioModel();
            
            $nombre_controladores = "SolicitudHipotecario";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $solicitudhipotecario->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
                
                
                $this->view("ConsultaSolicitudHipotecarioSuperAdmin",array(
                    ""=>""
                ));
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de Hipotecario."
                    
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
    
    
    public function searchadminsuper(){
        
        session_start();
        $solicitud = new SolicitudHipotecarioModel();
        
        $usuarios = new UsuariosModel();
        $id_usuarios=$_SESSION["id_usuarios"];
        
        $where_to="";
        
        
        $columnas = " solicitud_hipotecario.id_solicitud_hipotecario,
                  solicitud_hipotecario.valor_dolares_datos_credito,
                  solicitud_hipotecario.plazo_meses_datos_credito,
                  solicitud_hipotecario.destino_dinero_datos_credito,
                  solicitud_hipotecario.nombres_datos_personales,
                  solicitud_hipotecario.apellidos_datos_personales,
                  solicitud_hipotecario.cedula_datos_personales,
                  sexo.id_sexo,
                  sexo.nombre_sexo,
                  solicitud_hipotecario.fecha_nacimiento_datos_personales,
                  solicitud_hipotecario.separacion_bienes_datos_personales,
                  solicitud_hipotecario.cargas_familiares_datos_personales,
                  solicitud_hipotecario.numero_hijos_datos_personales,
                  solicitud_hipotecario.barrio_datos_personales,
                  solicitud_hipotecario.ciudadela_datos_personales,
                  solicitud_hipotecario.calle_datos_personales,
                  solicitud_hipotecario.numero_calle_datos_personales,
                  solicitud_hipotecario.interseccion_datos_personales,
                  solicitud_hipotecario.tipo_vivienda_datos_personales,
                  solicitud_hipotecario.vivienda_hipotecada_datos_personales,
                  solicitud_hipotecario.tiempo_residencia_datos_personales,
                  solicitud_hipotecario.referencia_domiciliaria_datos_perdonales,
                  solicitud_hipotecario.nombre_arrendatario_datos_personales,
                  solicitud_hipotecario.apellido_arrendatario_datos_personales,
                  solicitud_hipotecario.celular_arrendatario_datos_personales,
                  solicitud_hipotecario.telefono_datos_personales,
                  solicitud_hipotecario.celular_datos_personales,
                  solicitud_hipotecario.telf_trabajo_datos_personales,
                  solicitud_hipotecario.ext_telef_datos_personales,
                  solicitud_hipotecario.node_telef_datos_personales,
                  solicitud_hipotecario.email_datos_personales,
                  solicitud_hipotecario.nivel_educativo_datos_personales,
                  solicitud_hipotecario.nombres_referencia_familiar_datos_personales,
                  solicitud_hipotecario.apellidos_referencia_familiar_datos_personales,
                  solicitud_hipotecario.parentesco_referencia_familiar_datos_personales,
                  solicitud_hipotecario.primer_telefono_ref_familiar_datos_personales,
                  solicitud_hipotecario.segundo_telefono_ref_familiar_datos_personales,
                  solicitud_hipotecario.nombres_referencia_personal_datos_personales,
                  solicitud_hipotecario.apellidos_referencia_personal_datos_personales,
                  solicitud_hipotecario.relacion_referencia_personal_datos_personales,
                  solicitud_hipotecario.primer_telefono_ref_personal_datos_personales,
                  solicitud_hipotecario.segundo_telefono_ref_personal_datos_personales,
                  entidades.id_entidades,
                  entidades.nombre_entidades,
                  solicitud_hipotecario.reparto_unidad_datos_laborales,
                  solicitud_hipotecario.seccion_datos_laborales,
                  solicitud_hipotecario.nombres_jefe_datos_laborales,
                  solicitud_hipotecario.apellidos_jefe_datos_laborales,
                  solicitud_hipotecario.telefono_jefe_datos_laborales,
                  solicitud_hipotecario.calle_datos_laborales,
                  solicitud_hipotecario.numero_calle_datos_laborales,
                  solicitud_hipotecario.interseccion_datos_laborales,
                  solicitud_hipotecario.referencia_direccion_trabajo_datos_laborales,
                  solicitud_hipotecario.cargo_actual_datos_laborales,
                  solicitud_hipotecario.anios_servicio_datos_laborales,
                  solicitud_hipotecario.nombres_datos_conyuge,
                  solicitud_hipotecario.apellidos_datos_conyuge,
                  solicitud_hipotecario.cedula_datos_conyuge,
                  solicitud_hipotecario.fecha_nacimiento_datos_conyuge,
                  solicitud_hipotecario.vive_residencia_datos_conyuge,
                  solicitud_hipotecario.celular_datos_conyuge,
                  solicitud_hipotecario.telefono_datos_conyuge,
                  solicitud_hipotecario.barrio_datos_conyuge,
                  solicitud_hipotecario.ciudadela_datos_conyuge,
                  solicitud_hipotecario.calle_datos_conyuge,
                  solicitud_hipotecario.numero_calle_datos_conyuge,
                  solicitud_hipotecario.interseccion_datos_conyuge,
                  solicitud_hipotecario.actividad_economica_datos_conyuge,
                  solicitud_hipotecario.empresa_datos_conyuge,
                  solicitud_hipotecario.naturaleza_negocio_datos_conyuge,
                  solicitud_hipotecario.cargo_datos_conyuge,
                  solicitud_hipotecario.tipo_contrato_datos_conyuge,
                  solicitud_hipotecario.anios_laborados_datos_conyuge,
                  solicitud_hipotecario.nombres_jefe_datos_conyuge,
                  solicitud_hipotecario.apellidos_jefe_datos_conyuge,
                  solicitud_hipotecario.telefono_jefe_datos_conyuge,
                  solicitud_hipotecario.calle_trabajo_datos_conyuge,
                  solicitud_hipotecario.nuemero_calle_trabajo_datos_conyuge,
                  solicitud_hipotecario.interseccion_trabajo_datos_conyuge,
                  solicitud_hipotecario.referencia_trabajo_datos_conyuge,
                  solicitud_hipotecario.actividad_principal_datos_independientes,
                  solicitud_hipotecario.ruc_datos_independientes,
                  solicitud_hipotecario.detalle_actividades_datos_independientes,
                  solicitud_hipotecario.local_datos_independientes,
                  solicitud_hipotecario.nombres_propietario_datos_independientes,
                  solicitud_hipotecario.apellidos_propietario_datos_independientes,
                  solicitud_hipotecario.telefono_propietario_datos_independientes,
                  solicitud_hipotecario.tiempo_funcionamiento_datos_independientes,
                  solicitud_hipotecario.numero_patronal_datos_independientes,
                  solicitud_hipotecario.numero_empleados_datos_independientes,
                  solicitud_hipotecario.tipo_cuenta_referencia_bancaria,
                  solicitud_hipotecario.numero_cuenta_referencia_bancaria,
                  solicitud_hipotecario.tipo_cuenta_uno_datos_economicos,
                  solicitud_hipotecario.numero_cuenta_uno_datos_economicos,
                  solicitud_hipotecario.tipo_cuenta_dos_datos_economicos,
                  solicitud_hipotecario.numero_cuenta_dos_datos_economicos,
                  solicitud_hipotecario.tipo_cuenta_tres_datos_economicos,
                  solicitud_hipotecario.numero_cuenta_tres_datos_economicos,
                  solicitud_hipotecario.tipo_cuenta_cuatro_datos_economicos,
                  solicitud_hipotecario.numero_cuenta_cuatro_datos_economicos,
                  solicitud_hipotecario.empresa_uno_datos_economicos,
                  solicitud_hipotecario.direccion_uno_datos_economicos,
                  solicitud_hipotecario.numero_telefono_uno_datos_economicos,
                  solicitud_hipotecario.empresa_dos_datos_economicos,
                  solicitud_hipotecario.direccion_dos_datos_economicos,
                  solicitud_hipotecario.numero_telefono_dos_datos_economicos,
                  solicitud_hipotecario.empresa_tres_datos_economicos,
                  solicitud_hipotecario.direccion_tres_datos_economicos,
                  solicitud_hipotecario.numero_telefono_tres_datos_economicos,
                  solicitud_hipotecario.empresa_cuatro_datos_economicos,
                  solicitud_hipotecario.direccion_cuatro_datos_economicos,
                  solicitud_hipotecario.numero_telefono_cuatro_datos_economicos,
                  solicitud_hipotecario.efectivo_activos_corrientes,
                  solicitud_hipotecario.bancos_activos_corrientes,
                  solicitud_hipotecario.cuentas_cobrar_activos_corrientes,
                  solicitud_hipotecario.inversiones_activos_corrientes,
                  solicitud_hipotecario.inventarios_activos_corrientes,
                  solicitud_hipotecario.muebles_activos_corrientes,
                  solicitud_hipotecario.otros_activos_corrientes,
                  solicitud_hipotecario.terreno_activos_fijos,
                  solicitud_hipotecario.vivienda_activos_fijos,
                  solicitud_hipotecario.vehiculo_activos_fijos,
                  solicitud_hipotecario.maquinaria_activos_fijos,
                  solicitud_hipotecario.otros_activos_fijos,
                  solicitud_hipotecario.valor_prestacion_activos_intangibles,
                  solicitud_hipotecario.prestamo_menor_anio_pasivo_corriente,
                  solicitud_hipotecario.prestamo_emergente_pasivo_corriente,
                  solicitud_hipotecario.cuentas_pagar_pasivo_corriente,
                  solicitud_hipotecario.proveedores_pasivo_corriente,
                  solicitud_hipotecario.obligaciones_menores_anio_pasivo_corriente,
                  solicitud_hipotecario.con_banco_pasivo_corriente,
                  solicitud_hipotecario.con_cooperativas_pasivo_corriente,
                  solicitud_hipotecario.prestamo_mayor_anio_pasivos_largo_plazo,
                  solicitud_hipotecario.obligaciones_mayores_anio_pasivos_largo_plazo,
                  solicitud_hipotecario.con_banco_pasivos_largo_plazo,
                  solicitud_hipotecario.con_cooperativas_pasivos_largo_plazo,
                  solicitud_hipotecario.otros_pasivos_largo_plazo,
                  solicitud_hipotecario.patrimonio,
                  solicitud_hipotecario.garantias_capremci,
                  solicitud_hipotecario.tipo_producto_uno_detalle_activos,
                  solicitud_hipotecario.valor_uno_detalle_activos,
                  solicitud_hipotecario.plazo_uno_detalle_activos,
                  solicitud_hipotecario.tipo_producto_dos_detalle_activos,
                  solicitud_hipotecario.valor_dos_detalle_activos,
                  solicitud_hipotecario.plazo_dos_detalle_activos,
                  solicitud_hipotecario.tipo_producto_tres_detalle_activos,
                  solicitud_hipotecario.valor_tres_detalle_activos,
                  solicitud_hipotecario.plazo_tres_detalle_activos,
                  solicitud_hipotecario.tipo_producto_cuatro_detalle_activos,
                  solicitud_hipotecario.valor_cuatro_detalle_activos,
                  solicitud_hipotecario.plazo_cuatro_detalle_activos,
                  solicitud_hipotecario.muebles_uno_detalle_activos,
                  solicitud_hipotecario.direccion_uno_detalle_activos,
                  solicitud_hipotecario.valor_muebles_uno_detalle_activos,
                  solicitud_hipotecario.esta_hipotecado_uno_detalle_activos,
                  solicitud_hipotecario.muebles_dos_detalle_activos,
                  solicitud_hipotecario.direccion_dos_detalle_activos,
                  solicitud_hipotecario.valor_muebles_dos_detalle_activos,
                  solicitud_hipotecario.esta_hipotecado_dos_detalle_activos,
                  solicitud_hipotecario.muebles_tres_detalle_activos,
                  solicitud_hipotecario.direccion_tres_detalle_activos,
                  solicitud_hipotecario.valor_muebles_tres_detalle_activos,
                  solicitud_hipotecario.esta_hipotecado_tres_detalle_activos,
                  solicitud_hipotecario.muebles_cuatro_detalle_activos,
                  solicitud_hipotecario.direccion_cuatro_detalle_activos,
                  solicitud_hipotecario.valor_muebles_cuatro_detalle_activos,
                  solicitud_hipotecario.esta_hipotecada_cuatro_detalle_activos,
                  solicitud_hipotecario.vehiculo_uno_detalle_activos,
                  solicitud_hipotecario.valor_vehiculo_uno_detalle_activos,
                  solicitud_hipotecario.uso_uno_detalle_activos,
                  solicitud_hipotecario.asegurado_uno_detalle_activos,
                  solicitud_hipotecario.vehiculo_dos_detalle_activos,
                  solicitud_hipotecario.valor_vehiculo_dos_detalle_activos,
                  solicitud_hipotecario.uso_dos_detalle_activos,
                  solicitud_hipotecario.asegurado_dos_detalle_activos,
                  solicitud_hipotecario.vehiculo_tres_detalle_activos,
                  solicitud_hipotecario.valor_vehiculo_tres_detalle_activos,
                  solicitud_hipotecario.uso_tres_detalle_activos,
                  solicitud_hipotecario.asegurado_tres_detalle_activos,
                  solicitud_hipotecario.vehiculo_cuatro_detalle_activos,
                  solicitud_hipotecario.valor_vehiculo_cuatro_detalle_activos,
                  solicitud_hipotecario.uso_cuatro_detalle_activos,
                  solicitud_hipotecario.asegurado_cuatro_detalle_activos,
                  solicitud_hipotecario.otros_uno_detalle_activos,
                  solicitud_hipotecario.valor_otros_uno_detalle_activos,
                  solicitud_hipotecario.observacion_otro_uno_detalle_activos,
                  solicitud_hipotecario.otros_dos_detalle_activos,
                  solicitud_hipotecario.valor_otros_dos_detalle_activos,
                  solicitud_hipotecario.observacion_dos_detalle_activos,
                  solicitud_hipotecario.institucion_uno_detalle_pasivos,
                  solicitud_hipotecario.valor_uno_detalle_pasivos,
                  solicitud_hipotecario.destino_uno_detalle_pasivos,
                  solicitud_hipotecario.garantia_uno_detalle_pasivos,
                  solicitud_hipotecario.plazo_uno_detalle_pasivos,
                  solicitud_hipotecario.saldo_uno_detalle_pasivos,
                  solicitud_hipotecario.institucion_dos_detalle_pasivos,
                  solicitud_hipotecario.valor_dos_detalle_pasivos,
                  solicitud_hipotecario.destino_dos_detalle_pasivos,
                  solicitud_hipotecario.garantia_dos_detalle_pasivos,
                  solicitud_hipotecario.plazo_dos_detalle_pasivos,
                  solicitud_hipotecario.saldo_dos_detalle_pasivos,
                  solicitud_hipotecario.institucion_tres_detalle_pasivos,
                  solicitud_hipotecario.valor_tres_detalle_pasivos,
                  solicitud_hipotecario.destino_tres_detalle_pasivos,
                  solicitud_hipotecario.garantia_tres_detalle_pasivos,
                  solicitud_hipotecario.plazo_tres_detalle_pasivos,
                  solicitud_hipotecario.saldo_tres_detalle_pasivos,
                  solicitud_hipotecario.institucion_cuatro_detalle_pasivos,
                  solicitud_hipotecario.valor_cuatro_detalle_pasivos,
                  solicitud_hipotecario.destino_cuatro_detalle_pasivos,
                  solicitud_hipotecario.garantia_cuatro_detalle_pasivos,
                  solicitud_hipotecario.plazo_cuatro_detalle_pasivos,
                  solicitud_hipotecario.saldo_cuatro_detalle_pasivos,
                  solicitud_hipotecario.institucion_cinco_detalle_pasivos,
                  solicitud_hipotecario.valor_cinco_detalle_pasivos,
                  solicitud_hipotecario.destino_cinco_detalle_pasivos,
                  solicitud_hipotecario.garantia_cinco_detalle_pasivos,
                  solicitud_hipotecario.plazo_cinco_detalle_pasivos,
                  solicitud_hipotecario.saldo_cinco_detalle_pasivos,
                  solicitud_hipotecario.sueldo_afiliado_ingresos_mensuales,
                  solicitud_hipotecario.sueldo_conyuge_ingresos_mensuales,
                  solicitud_hipotecario.comisiones_ingresos_mensuales,
                  solicitud_hipotecario.arriendos_ingresos_mensuales,
                  solicitud_hipotecario.dividendos_ingresos_mensuales,
                  solicitud_hipotecario.ingresos_negocio_ingresos_mensuales,
                  solicitud_hipotecario.pensiones_ingresos_mensuales,
                  solicitud_hipotecario.otros_detalle_uno_ingresos_mensuales,
                  solicitud_hipotecario.otros_uno_ingresos_mensuales,
                  solicitud_hipotecario.otros_detalle_dos_ingresos_mensuales,
                  solicitud_hipotecario.otros_dos_ingresos_mensuales,
                  solicitud_hipotecario.otros_detalle_tres_ingresos_mensuales,
                  solicitud_hipotecario.otros_tres_ingresos_mensuales,
                  solicitud_hipotecario.alimentacion_gastos_mensuales,
                  solicitud_hipotecario.arriendos_gastos_mensuales,
                  solicitud_hipotecario.educacion_gastos_mensuales,
                  solicitud_hipotecario.vestuario_gastos_mensuales,
                  solicitud_hipotecario.servicios_publicos_gastos_mensuales,
                  solicitud_hipotecario.movilizacion_gastos_mensuales,
                  solicitud_hipotecario.ahorros_cooperativas_gastos_mensuales,
                  solicitud_hipotecario.cuotas_tarjetas_gastos_mensuales,
                  solicitud_hipotecario.cuotas_prestamo_gastos_mensuales,
                  solicitud_hipotecario.otros_detalle_uno_gastos_mensuales,
                  solicitud_hipotecario.otros_gastos_uno_gastos_mensuales,
                  solicitud_hipotecario.total_activos_corrientes,
                  solicitud_hipotecario.total_activos_fijos,
                  solicitud_hipotecario.total_activos,
                  solicitud_hipotecario.total_pasivos_corrientes,
                  solicitud_hipotecario.total_pasivos_largo_plazo,
                  solicitud_hipotecario.total_pasivos,
                  solicitud_hipotecario.total_ingresos_mensuales,
                  solicitud_hipotecario.total_gastos_mensuales,
                  solicitud_hipotecario.identificador_consecutivos,
                  solicitud_hipotecario.fecha_presentacion,
                  solicitud_hipotecario.fecha_aprobacion,
                  estado_civil.id_estado_civil,
                  estado_civil.nombre_estado_civil,
                  solicitud_hipotecario.id_provincia,
                  solicitud_hipotecario.id_canton,
                  solicitud_hipotecario.id_parroquia,
                  solicitud_hipotecario.id_provincia_datos_laborales,
                  solicitud_hipotecario.id_canton_datos_laborales,
                  solicitud_hipotecario.id_parroquia_datos_laborales,
                  solicitud_hipotecario.id_sexo_datos_conyuge,
                  solicitud_hipotecario.id_provincia_datos_conyuge,
                  solicitud_hipotecario.id_canton_datos_conyuge,
                  solicitud_hipotecario.id_parroquia_datos_conyuge,
                  solicitud_hipotecario.id_provincia_trabajo_datos_conyuge,
                  solicitud_hipotecario.id_canton_trabajo_datos_conyuge,
                  solicitud_hipotecario.id_parroquia_trabajo_datos_conyuge,
                  solicitud_hipotecario.id_bancos_referencia_bancaria,
                  solicitud_hipotecario.id_bancos_uno_datos_economicos,
                  solicitud_hipotecario.id_bancos_dos_datos_economicos,
                  solicitud_hipotecario.id_bancos_tres_datos_economicos,
                  solicitud_hipotecario.id_bancos_cuatro_datos_economicos,
                  solicitud_hipotecario.id_bancos_uno_detalle_activos,
                  solicitud_hipotecario.id_bancos_dos_detalle_activos,
                  solicitud_hipotecario.id_bancos_tres_detalle_activos,
                  solicitud_hipotecario.id_bancos_cuatro_detalle_activos,
                  solicitud_hipotecario.id_usuarios_registra,
                  estado_tramites.id_estado_tramites,
                  estado_tramites.nombre_estado_tramites_solicitud_prestamos,
                  solicitud_hipotecario.id_usuarios_oficial_credito_aprueba,
                  usuarios.id_usuarios,
                  usuarios.cedula_usuarios,
                  usuarios.nombre_usuarios,
                  usuarios.correo_usuarios";
        
        $tablas   = "   public.solicitud_hipotecario,
                      public.sexo,
                      public.entidades,
                      public.estado_civil,
                      public.usuarios,
                      public.estado_tramites
                    ";
        
        $where    = "   sexo.id_sexo = solicitud_hipotecario.id_sexo AND
  entidades.id_entidades = solicitud_hipotecario.id_entidades AND
  estado_civil.id_estado_civil = solicitud_hipotecario.id_estado_civil AND
  usuarios.id_usuarios = solicitud_hipotecario.id_usuarios_oficial_credito_aprueba AND
  estado_tramites.id_estado_tramites = solicitud_hipotecario.id_estado_tramites ";
        
        $id       = "solicitud_hipotecario.id_solicitud_hipotecario";
        
        
        
        
        //$where_to=$where;
        
        
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        $search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
        
        if($action == 'ajax')
        {
            
            if(!empty($search)){
                
                $where1=" AND (solicitud_hipotecario.cedula_datos_personales LIKE '".$search."%' OR solicitud_hipotecario.apellidos_datos_personales ILIKE '".$search."%' OR solicitud_hipotecario.nombres_datos_personales ILIKE '".$search."%' OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos ILIKE '".$search."%' )";
                
                
                $where_to=$where.$where1;
            }else{
                
                $where_to=$where;
                
            }
            
            
            $html="";
            $resultSet=$solicitud->getCantidad("*", $tablas, $where_to);
            $cantidadResult=(int)$resultSet[0]->total;
            
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
            
            $per_page = 10; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            
            $limit = " LIMIT   '$per_page' OFFSET '$offset'";
            
            $resultSet=$solicitud->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
                $html.= "<table id='tabla_solicitud_hipotecario_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
                $html.= "<thead>";
                $html.= "<tr>";
                
                $html.='<th style="text-align: left;  font-size: 11px;">Cedula</th>';
                $html.='<th style="text-align: left;  font-size: 11px;">Apellidos</th>';
                $html.='<th style="text-align: left;  font-size: 11px;">Nombres</th>';
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
                    
                    $html.='<td style="font-size: 11px;">'.$res->cedula_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->apellidos_datos_personales.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->nombres_datos_personales.'</td>';
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
                        
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><button id="btn_abrir" class="btn btn-success" type="button" data-toggle="modal" data-target="#mod_reasignar" data-id="'.$res->id_solicitud_hipotecario.'" data-cedu="'.$res->cedula_datos_personales.'" data-nombre="'.$res->apellidos_datos_personales.' '.$res->nombres_datos_personales.'" data-credito="" data-usuario="'.$res->nombre_usuarios.'"  title="Reasignar" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></button></span></td>';
                        
                        
                    }else{
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" target="_blank" class="btn btn-success" style="font-size:65%;" title="Reasignar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                        
                    }
                    
                    
                    $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudHipotecario&action=print&id_solicitud_hipotecario='.$res->id_solicitud_hipotecario.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
                    
                    $html.='</tr>';
                    
                }
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section></div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_load_solicitud_hipotecario_registrados("index.php", $page, $total_pages, $adjacents).'';
                $html.='</div>';
                
                
            }else{
                $html.='<div class="col-lg-6 col-md-6 col-xs-12">';
                $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
                $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                $html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de hipotecario registrados...</b>';
                $html.='</div>';
                $html.='</div>';
            }
            
            echo $html;
            die();
            
        }
        
        
        
        
    }
    
    
    public function ReasignarSolicitud(){
        
        
        session_start();
        
        $solicitud = new SolicitudHipotecarioModel();
        
        $usuarios = new UsuariosModel();
        
        if(!isset($_SESSION['id_usuarios'])){
            echo 'Session Caducada';
            exit();
        }
        
        
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
                    
                    
                    
                    $colval_afi = "id_usuarios_oficial_credito_aprueba='$_id_nuevo_oficial', id_sucursales='$id_sucursales'";
                    $tabla_afi = "solicitud_hipotecario";
                    $where_afi = "id_solicitud_hipotecario = '$_id_solicitud_prestamo'";
                    //$resultado=$solicitud_prestamo->UpdateBy($colval_afi, $tabla_afi, $where_afi);
                    $resultado=$solicitud->editBy($colval_afi, $tabla_afi, $where_afi);
                    
                    
                    
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function print(){
        session_start();
        
        //   $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        /*
         $entidades = new EntidadesModel();
         $datos_empresa = array();
         $rsdatosEmpresa = $entidades->getBy("id_entidades = 1");
         
         if(!empty($rsdatosEmpresa) && count($rsdatosEmpresa)>0){
         //llenar nombres con variables que va en html de reporte
         $datos_empresa['NOMBREEMPRESA']=$rsdatosEmpresa[0]->nombre_entidades;
         $datos_empresa['DIRECCIONEMPRESA']=$rsdatosEmpresa[0]->direccion_entidades;
         $datos_empresa['TELEFONOEMPRESA']=$rsdatosEmpresa[0]->telefono_entidades;
         $datos_empresa['RUCEMPRESA']=$rsdatosEmpresa[0]->ruc_entidades;
         $datos_empresa['FECHAEMPRESA']=date('Y-m-d H:i');
         $datos_empresa['USUARIOEMPRESA']=(isset($_SESSION['usuario_usuarios']))?$_SESSION['usuario_usuarios']:'';
         }
         
         //NOTICE DATA
         $datos_cabecera = array();
         $datos_cabecera['USUARIO'] = (isset($_SESSION['nombre_usuarios'])) ? $_SESSION['nombre_usuarios'] : 'N/D';
         $datos_cabecera['FECHA'] = date('Y/m/d');
         $datos_cabecera['HORA'] = date('h:i:s');
         
         */
        
        
        
        
        $solicitudHipotecario = new SolicitudHipotecarioModel();
        $id_solicitud_hipotecario =  (isset($_REQUEST['id_solicitud_hipotecario'])&& $_REQUEST['id_solicitud_hipotecario'] !=NULL)?$_REQUEST['id_solicitud_hipotecario']:'';
        
        $datos_reporte = array();
        
        $columnas = " solicitud_hipotecario.id_solicitud_hipotecario, 
                      solicitud_hipotecario.valor_dolares_datos_credito, 
                      solicitud_hipotecario.plazo_meses_datos_credito, 
                      solicitud_hipotecario.destino_dinero_datos_credito, 
                      solicitud_hipotecario.nombres_datos_personales, 
                      solicitud_hipotecario.apellidos_datos_personales, 
                      solicitud_hipotecario.cedula_datos_personales, 
                      sexo.id_sexo, 
                      sexo.nombre_sexo, 
                      solicitud_hipotecario.fecha_nacimiento_datos_personales, 
                      solicitud_hipotecario.separacion_bienes_datos_personales, 
                      solicitud_hipotecario.cargas_familiares_datos_personales, 
                      solicitud_hipotecario.numero_hijos_datos_personales, 
                      solicitud_hipotecario.barrio_datos_personales, 
                      solicitud_hipotecario.ciudadela_datos_personales, 
                      solicitud_hipotecario.calle_datos_personales, 
                      solicitud_hipotecario.numero_calle_datos_personales, 
                      solicitud_hipotecario.interseccion_datos_personales, 
                      solicitud_hipotecario.tipo_vivienda_datos_personales, 
                      solicitud_hipotecario.vivienda_hipotecada_datos_personales, 
                      solicitud_hipotecario.tiempo_residencia_datos_personales, 
                      solicitud_hipotecario.referencia_domiciliaria_datos_perdonales, 
                      solicitud_hipotecario.nombre_arrendatario_datos_personales, 
                      solicitud_hipotecario.apellido_arrendatario_datos_personales, 
                      solicitud_hipotecario.celular_arrendatario_datos_personales, 
                      solicitud_hipotecario.telefono_datos_personales, 
                      solicitud_hipotecario.celular_datos_personales, 
                      solicitud_hipotecario.telf_trabajo_datos_personales, 
                      solicitud_hipotecario.ext_telef_datos_personales, 
                      solicitud_hipotecario.node_telef_datos_personales, 
                      solicitud_hipotecario.email_datos_personales, 
                      solicitud_hipotecario.nivel_educativo_datos_personales, 
                      solicitud_hipotecario.nombres_referencia_familiar_datos_personales, 
                      solicitud_hipotecario.apellidos_referencia_familiar_datos_personales, 
                      solicitud_hipotecario.parentesco_referencia_familiar_datos_personales, 
                      solicitud_hipotecario.primer_telefono_ref_familiar_datos_personales, 
                      solicitud_hipotecario.segundo_telefono_ref_familiar_datos_personales, 
                      solicitud_hipotecario.nombres_referencia_personal_datos_personales, 
                      solicitud_hipotecario.apellidos_referencia_personal_datos_personales, 
                      solicitud_hipotecario.relacion_referencia_personal_datos_personales, 
                      solicitud_hipotecario.primer_telefono_ref_personal_datos_personales, 
                      solicitud_hipotecario.segundo_telefono_ref_personal_datos_personales, 
                      entidades.id_entidades, 
                      entidades.nombre_entidades, 
                      solicitud_hipotecario.reparto_unidad_datos_laborales, 
                      solicitud_hipotecario.seccion_datos_laborales, 
                      solicitud_hipotecario.nombres_jefe_datos_laborales, 
                      solicitud_hipotecario.apellidos_jefe_datos_laborales, 
                      solicitud_hipotecario.telefono_jefe_datos_laborales, 
                      solicitud_hipotecario.calle_datos_laborales, 
                      solicitud_hipotecario.numero_calle_datos_laborales, 
                      solicitud_hipotecario.interseccion_datos_laborales, 
                      solicitud_hipotecario.referencia_direccion_trabajo_datos_laborales, 
                      solicitud_hipotecario.cargo_actual_datos_laborales, 
                      solicitud_hipotecario.anios_servicio_datos_laborales, 
                      solicitud_hipotecario.nombres_datos_conyuge, 
                      solicitud_hipotecario.apellidos_datos_conyuge, 
                      solicitud_hipotecario.cedula_datos_conyuge, 
                      solicitud_hipotecario.fecha_nacimiento_datos_conyuge, 
                      solicitud_hipotecario.vive_residencia_datos_conyuge, 
                      solicitud_hipotecario.celular_datos_conyuge, 
                      solicitud_hipotecario.telefono_datos_conyuge, 
                      solicitud_hipotecario.barrio_datos_conyuge, 
                      solicitud_hipotecario.ciudadela_datos_conyuge, 
                      solicitud_hipotecario.calle_datos_conyuge, 
                      solicitud_hipotecario.numero_calle_datos_conyuge, 
                      solicitud_hipotecario.interseccion_datos_conyuge, 
                      solicitud_hipotecario.actividad_economica_datos_conyuge, 
                      solicitud_hipotecario.empresa_datos_conyuge, 
                      solicitud_hipotecario.naturaleza_negocio_datos_conyuge, 
                      solicitud_hipotecario.cargo_datos_conyuge, 
                      solicitud_hipotecario.tipo_contrato_datos_conyuge, 
                      solicitud_hipotecario.anios_laborados_datos_conyuge, 
                      solicitud_hipotecario.nombres_jefe_datos_conyuge, 
                      solicitud_hipotecario.apellidos_jefe_datos_conyuge, 
                      solicitud_hipotecario.telefono_jefe_datos_conyuge, 
                      solicitud_hipotecario.calle_trabajo_datos_conyuge, 
                      solicitud_hipotecario.nuemero_calle_trabajo_datos_conyuge, 
                      solicitud_hipotecario.interseccion_trabajo_datos_conyuge, 
                      solicitud_hipotecario.referencia_trabajo_datos_conyuge, 
                      solicitud_hipotecario.actividad_principal_datos_independientes, 
                      solicitud_hipotecario.ruc_datos_independientes, 
                      solicitud_hipotecario.detalle_actividades_datos_independientes, 
                      solicitud_hipotecario.local_datos_independientes, 
                      solicitud_hipotecario.nombres_propietario_datos_independientes, 
                      solicitud_hipotecario.apellidos_propietario_datos_independientes, 
                      solicitud_hipotecario.telefono_propietario_datos_independientes, 
                      solicitud_hipotecario.tiempo_funcionamiento_datos_independientes, 
                      solicitud_hipotecario.numero_patronal_datos_independientes, 
                      solicitud_hipotecario.numero_empleados_datos_independientes, 
                      solicitud_hipotecario.tipo_cuenta_referencia_bancaria, 
                      solicitud_hipotecario.numero_cuenta_referencia_bancaria, 
                      solicitud_hipotecario.tipo_cuenta_uno_datos_economicos, 
                      solicitud_hipotecario.numero_cuenta_uno_datos_economicos, 
                      solicitud_hipotecario.tipo_cuenta_dos_datos_economicos, 
                      solicitud_hipotecario.numero_cuenta_dos_datos_economicos, 
                      solicitud_hipotecario.tipo_cuenta_tres_datos_economicos, 
                      solicitud_hipotecario.numero_cuenta_tres_datos_economicos, 
                      solicitud_hipotecario.tipo_cuenta_cuatro_datos_economicos, 
                      solicitud_hipotecario.numero_cuenta_cuatro_datos_economicos, 
                      solicitud_hipotecario.empresa_uno_datos_economicos, 
                      solicitud_hipotecario.direccion_uno_datos_economicos, 
                      solicitud_hipotecario.numero_telefono_uno_datos_economicos, 
                      solicitud_hipotecario.empresa_dos_datos_economicos, 
                      solicitud_hipotecario.direccion_dos_datos_economicos, 
                      solicitud_hipotecario.numero_telefono_dos_datos_economicos, 
                      solicitud_hipotecario.empresa_tres_datos_economicos, 
                      solicitud_hipotecario.direccion_tres_datos_economicos, 
                      solicitud_hipotecario.numero_telefono_tres_datos_economicos, 
                      solicitud_hipotecario.empresa_cuatro_datos_economicos, 
                      solicitud_hipotecario.direccion_cuatro_datos_economicos, 
                      solicitud_hipotecario.numero_telefono_cuatro_datos_economicos, 
                      solicitud_hipotecario.efectivo_activos_corrientes, 
                      solicitud_hipotecario.bancos_activos_corrientes, 
                      solicitud_hipotecario.cuentas_cobrar_activos_corrientes, 
                      solicitud_hipotecario.inversiones_activos_corrientes, 
                      solicitud_hipotecario.inventarios_activos_corrientes, 
                      solicitud_hipotecario.muebles_activos_corrientes, 
                      solicitud_hipotecario.otros_activos_corrientes, 
                      solicitud_hipotecario.terreno_activos_fijos, 
                      solicitud_hipotecario.vivienda_activos_fijos, 
                      solicitud_hipotecario.vehiculo_activos_fijos, 
                      solicitud_hipotecario.maquinaria_activos_fijos, 
                      solicitud_hipotecario.otros_activos_fijos, 
                      solicitud_hipotecario.valor_prestacion_activos_intangibles, 
                      solicitud_hipotecario.prestamo_menor_anio_pasivo_corriente, 
                      solicitud_hipotecario.prestamo_emergente_pasivo_corriente, 
                      solicitud_hipotecario.cuentas_pagar_pasivo_corriente, 
                      solicitud_hipotecario.proveedores_pasivo_corriente, 
                      solicitud_hipotecario.obligaciones_menores_anio_pasivo_corriente, 
                      solicitud_hipotecario.con_banco_pasivo_corriente, 
                      solicitud_hipotecario.con_cooperativas_pasivo_corriente, 
                      solicitud_hipotecario.prestamo_mayor_anio_pasivos_largo_plazo, 
                      solicitud_hipotecario.obligaciones_mayores_anio_pasivos_largo_plazo, 
                      solicitud_hipotecario.con_banco_pasivos_largo_plazo, 
                      solicitud_hipotecario.con_cooperativas_pasivos_largo_plazo, 
                      solicitud_hipotecario.otros_pasivos_largo_plazo, 
                      solicitud_hipotecario.patrimonio, 
                      solicitud_hipotecario.garantias_capremci, 
                      solicitud_hipotecario.tipo_producto_uno_detalle_activos, 
                      solicitud_hipotecario.valor_uno_detalle_activos, 
                      solicitud_hipotecario.plazo_uno_detalle_activos, 
                      solicitud_hipotecario.tipo_producto_dos_detalle_activos, 
                      solicitud_hipotecario.valor_dos_detalle_activos, 
                      solicitud_hipotecario.plazo_dos_detalle_activos, 
                      solicitud_hipotecario.tipo_producto_tres_detalle_activos, 
                      solicitud_hipotecario.valor_tres_detalle_activos, 
                      solicitud_hipotecario.plazo_tres_detalle_activos, 
                      solicitud_hipotecario.tipo_producto_cuatro_detalle_activos, 
                      solicitud_hipotecario.valor_cuatro_detalle_activos, 
                      solicitud_hipotecario.plazo_cuatro_detalle_activos, 
                      solicitud_hipotecario.muebles_uno_detalle_activos, 
                      solicitud_hipotecario.direccion_uno_detalle_activos, 
                      solicitud_hipotecario.valor_muebles_uno_detalle_activos, 
                      solicitud_hipotecario.esta_hipotecado_uno_detalle_activos, 
                      solicitud_hipotecario.muebles_dos_detalle_activos, 
                      solicitud_hipotecario.direccion_dos_detalle_activos, 
                      solicitud_hipotecario.valor_muebles_dos_detalle_activos, 
                      solicitud_hipotecario.esta_hipotecado_dos_detalle_activos, 
                      solicitud_hipotecario.muebles_tres_detalle_activos, 
                      solicitud_hipotecario.direccion_tres_detalle_activos, 
                      solicitud_hipotecario.valor_muebles_tres_detalle_activos, 
                      solicitud_hipotecario.esta_hipotecado_tres_detalle_activos, 
                      solicitud_hipotecario.muebles_cuatro_detalle_activos, 
                      solicitud_hipotecario.direccion_cuatro_detalle_activos, 
                      solicitud_hipotecario.valor_muebles_cuatro_detalle_activos, 
                      solicitud_hipotecario.esta_hipotecada_cuatro_detalle_activos, 
                      solicitud_hipotecario.vehiculo_uno_detalle_activos, 
                      solicitud_hipotecario.valor_vehiculo_uno_detalle_activos, 
                      solicitud_hipotecario.uso_uno_detalle_activos, 
                      solicitud_hipotecario.asegurado_uno_detalle_activos, 
                      solicitud_hipotecario.vehiculo_dos_detalle_activos, 
                      solicitud_hipotecario.valor_vehiculo_dos_detalle_activos, 
                      solicitud_hipotecario.uso_dos_detalle_activos, 
                      solicitud_hipotecario.asegurado_dos_detalle_activos, 
                      solicitud_hipotecario.vehiculo_tres_detalle_activos, 
                      solicitud_hipotecario.valor_vehiculo_tres_detalle_activos, 
                      solicitud_hipotecario.uso_tres_detalle_activos, 
                      solicitud_hipotecario.asegurado_tres_detalle_activos, 
                      solicitud_hipotecario.vehiculo_cuatro_detalle_activos, 
                      solicitud_hipotecario.valor_vehiculo_cuatro_detalle_activos, 
                      solicitud_hipotecario.uso_cuatro_detalle_activos, 
                      solicitud_hipotecario.asegurado_cuatro_detalle_activos, 
                      solicitud_hipotecario.otros_uno_detalle_activos, 
                      solicitud_hipotecario.valor_otros_uno_detalle_activos, 
                      solicitud_hipotecario.observacion_otro_uno_detalle_activos, 
                      solicitud_hipotecario.otros_dos_detalle_activos, 
                      solicitud_hipotecario.valor_otros_dos_detalle_activos, 
                      solicitud_hipotecario.observacion_dos_detalle_activos, 
                      solicitud_hipotecario.institucion_uno_detalle_pasivos, 
                      solicitud_hipotecario.valor_uno_detalle_pasivos, 
                      solicitud_hipotecario.destino_uno_detalle_pasivos, 
                      solicitud_hipotecario.garantia_uno_detalle_pasivos, 
                      solicitud_hipotecario.plazo_uno_detalle_pasivos, 
                      solicitud_hipotecario.saldo_uno_detalle_pasivos, 
                      solicitud_hipotecario.institucion_dos_detalle_pasivos, 
                      solicitud_hipotecario.valor_dos_detalle_pasivos, 
                      solicitud_hipotecario.destino_dos_detalle_pasivos, 
                      solicitud_hipotecario.garantia_dos_detalle_pasivos, 
                      solicitud_hipotecario.plazo_dos_detalle_pasivos, 
                      solicitud_hipotecario.saldo_dos_detalle_pasivos, 
                      solicitud_hipotecario.institucion_tres_detalle_pasivos, 
                      solicitud_hipotecario.valor_tres_detalle_pasivos, 
                      solicitud_hipotecario.destino_tres_detalle_pasivos, 
                      solicitud_hipotecario.garantia_tres_detalle_pasivos, 
                      solicitud_hipotecario.plazo_tres_detalle_pasivos, 
                      solicitud_hipotecario.saldo_tres_detalle_pasivos, 
                      solicitud_hipotecario.institucion_cuatro_detalle_pasivos, 
                      solicitud_hipotecario.valor_cuatro_detalle_pasivos, 
                      solicitud_hipotecario.destino_cuatro_detalle_pasivos, 
                      solicitud_hipotecario.garantia_cuatro_detalle_pasivos, 
                      solicitud_hipotecario.plazo_cuatro_detalle_pasivos, 
                      solicitud_hipotecario.saldo_cuatro_detalle_pasivos, 
                      solicitud_hipotecario.institucion_cinco_detalle_pasivos, 
                      solicitud_hipotecario.valor_cinco_detalle_pasivos, 
                      solicitud_hipotecario.destino_cinco_detalle_pasivos, 
                      solicitud_hipotecario.garantia_cinco_detalle_pasivos, 
                      solicitud_hipotecario.plazo_cinco_detalle_pasivos, 
                      solicitud_hipotecario.saldo_cinco_detalle_pasivos, 
                      solicitud_hipotecario.sueldo_afiliado_ingresos_mensuales, 
                      solicitud_hipotecario.sueldo_conyuge_ingresos_mensuales, 
                      solicitud_hipotecario.comisiones_ingresos_mensuales, 
                      solicitud_hipotecario.arriendos_ingresos_mensuales, 
                      solicitud_hipotecario.dividendos_ingresos_mensuales, 
                      solicitud_hipotecario.ingresos_negocio_ingresos_mensuales, 
                      solicitud_hipotecario.pensiones_ingresos_mensuales, 
                      solicitud_hipotecario.otros_detalle_uno_ingresos_mensuales, 
                      solicitud_hipotecario.otros_uno_ingresos_mensuales, 
                      solicitud_hipotecario.otros_detalle_dos_ingresos_mensuales, 
                      solicitud_hipotecario.otros_dos_ingresos_mensuales, 
                      solicitud_hipotecario.otros_detalle_tres_ingresos_mensuales, 
                      solicitud_hipotecario.otros_tres_ingresos_mensuales, 
                      solicitud_hipotecario.alimentacion_gastos_mensuales, 
                      solicitud_hipotecario.arriendos_gastos_mensuales, 
                      solicitud_hipotecario.educacion_gastos_mensuales, 
                      solicitud_hipotecario.vestuario_gastos_mensuales, 
                      solicitud_hipotecario.servicios_publicos_gastos_mensuales, 
                      solicitud_hipotecario.movilizacion_gastos_mensuales, 
                      solicitud_hipotecario.ahorros_cooperativas_gastos_mensuales, 
                      solicitud_hipotecario.cuotas_tarjetas_gastos_mensuales, 
                      solicitud_hipotecario.cuotas_prestamo_gastos_mensuales, 
                      solicitud_hipotecario.otros_detalle_uno_gastos_mensuales, 
                      solicitud_hipotecario.otros_gastos_uno_gastos_mensuales, 
                      solicitud_hipotecario.total_activos_corrientes, 
                      solicitud_hipotecario.total_activos_fijos, 
                      solicitud_hipotecario.total_activos, 
                      solicitud_hipotecario.total_pasivos_corrientes, 
                      solicitud_hipotecario.total_pasivos_largo_plazo, 
                      solicitud_hipotecario.total_pasivos, 
                      solicitud_hipotecario.total_ingresos_mensuales, 
                      solicitud_hipotecario.total_gastos_mensuales, 
                      solicitud_hipotecario.identificador_consecutivos, 
                      solicitud_hipotecario.fecha_presentacion, 
                      solicitud_hipotecario.fecha_aprobacion, 
                      estado_civil.id_estado_civil, 
                      estado_civil.nombre_estado_civil, 
                      solicitud_hipotecario.id_provincia, 
                      solicitud_hipotecario.id_canton, 
                      solicitud_hipotecario.id_parroquia, 
                      solicitud_hipotecario.id_provincia_datos_laborales, 
                      solicitud_hipotecario.id_canton_datos_laborales, 
                      solicitud_hipotecario.id_parroquia_datos_laborales, 
                      solicitud_hipotecario.id_sexo_datos_conyuge, 
                      solicitud_hipotecario.id_provincia_datos_conyuge, 
                      solicitud_hipotecario.id_canton_datos_conyuge, 
                      solicitud_hipotecario.id_parroquia_datos_conyuge, 
                      solicitud_hipotecario.id_provincia_trabajo_datos_conyuge, 
                      solicitud_hipotecario.id_canton_trabajo_datos_conyuge, 
                      solicitud_hipotecario.id_parroquia_trabajo_datos_conyuge, 
                      solicitud_hipotecario.id_bancos_referencia_bancaria, 
                      solicitud_hipotecario.id_bancos_uno_datos_economicos, 
                      solicitud_hipotecario.id_bancos_dos_datos_economicos, 
                      solicitud_hipotecario.id_bancos_tres_datos_economicos, 
                      solicitud_hipotecario.id_bancos_cuatro_datos_economicos, 
                      solicitud_hipotecario.id_bancos_uno_detalle_activos, 
                      solicitud_hipotecario.id_bancos_dos_detalle_activos, 
                      solicitud_hipotecario.id_bancos_tres_detalle_activos, 
                      solicitud_hipotecario.id_bancos_cuatro_detalle_activos, 
                      solicitud_hipotecario.id_usuarios_registra, 
                      estado_tramites.id_estado_tramites, 
                      estado_tramites.nombre_estado_tramites, 
                      solicitud_hipotecario.id_usuarios_oficial_credito_aprueba, 
                      usuarios.id_usuarios, 
                      usuarios.cedula_usuarios, 
                      usuarios.nombre_usuarios, 
                      usuarios.correo_usuarios";
        
        $tablas = "   public.solicitud_hipotecario, 
                      public.sexo, 
                      public.entidades, 
                      public.estado_civil, 
                      public.usuarios, 
                      public.estado_tramites";
        $where= "     sexo.id_sexo = solicitud_hipotecario.id_sexo AND
                      entidades.id_entidades = solicitud_hipotecario.id_entidades AND
                      estado_civil.id_estado_civil = solicitud_hipotecario.id_estado_civil AND
                      usuarios.id_usuarios = solicitud_hipotecario.id_usuarios_oficial_credito_aprueba AND
                      estado_tramites.id_estado_tramites = solicitud_hipotecario.id_estado_tramites AND
                        solicitud_hipotecario.id_solicitud_hipotecario='$id_solicitud_hipotecario'";
        $id="solicitud_hipotecario.id_solicitud_hipotecario";
        
        $rsdatos = $solicitudHipotecario->getCondiciones($columnas, $tablas, $where, $id);
        
        
        $datos_reporte['VALOR_CREDITO']=$rsdatos[0]->valor_dolares_datos_credito;
        $datos_reporte['PLAZO_MESES']=$rsdatos[0]->plazo_meses_datos_credito;
        $datos_reporte['DESTINO_DINERO']=$rsdatos[0]->destino_dinero_datos_credito;
        $datos_reporte['NOMBRES_DATOS_PER']=$rsdatos[0]->nombres_datos_personales;
        $datos_reporte['APELLIDOS_DATOS_PER']=$rsdatos[0]->apellidos_datos_personales;
        $datos_reporte['CED_DATOS_PER']=$rsdatos[0]->cedula_datos_personales;
        $datos_reporte['GENERO_DATOS_PER']=$rsdatos[0]->nombre_sexo;
        $datos_reporte['FECHA_NAC_DATOS_PER']=$rsdatos[0]->fecha_nacimiento_datos_personales;
        $datos_reporte['ESTADO_CIVIL']=$rsdatos[0]->nombre_estado_civil;
        $datos_reporte['SEPARACION_BIENES']=$rsdatos[0]->separacion_bienes_datos_personales;
        $datos_reporte['CARGAS_FAMI_DATOS_PER']=$rsdatos[0]->cargas_familiares_datos_personales;
        $datos_reporte['PROVINCIA_DAT_PER']=$rsdatos[0]->cargas_familiares_datos_personales;
        $datos_reporte['CANTON_DAT_PER']=$rsdatos[0]->cargas_familiares_datos_personales;
        $datos_reporte['PARROQUA_DAT_PER']=$rsdatos[0]->cargas_familiares_datos_personales;
        $datos_reporte['BARRIO_DAT_PER']=$rsdatos[0]->barrio_datos_personales;
        $datos_reporte['CIUDADELA_DAT_PER']=$rsdatos[0]->ciudadela_datos_personales;
        $datos_reporte['CALLE_DAT_PER']=$rsdatos[0]->calle_datos_personales;
        $datos_reporte['NUM_CALLE_DAT_PER']=$rsdatos[0]->numero_calle_datos_personales;
        $datos_reporte['INTERSE_DAT_PER']=$rsdatos[0]->interseccion_datos_personales;
        $datos_reporte['TIPO_VIVIENDA_DAT_PER']=$rsdatos[0]->tipo_vivienda_datos_personales;
        $datos_reporte['VIVIENDA_HIPO_DAT_PER']=$rsdatos[0]->vivienda_hipotecada_datos_personales;
        $datos_reporte['TIEMPO_RESI_DAT_PER']=$rsdatos[0]->tiempo_residencia_datos_personales;
        $datos_reporte['REFERENCIA_DOM_DAT_PER']=$rsdatos[0]->referencia_domiciliaria_datos_perdonales;
        $datos_reporte['NOM_ARRENDA_DAT_PER']=$rsdatos[0]->nombre_arrendatario_datos_personales;
        $datos_reporte['APELLI_ARREN_DAT_PER']=$rsdatos[0]->apellido_arrendatario_datos_personales;
        $datos_reporte['CELU_ARREN_DAT_PER']=$rsdatos[0]->celular_arrendatario_datos_personales;
        $datos_reporte['TELEF_DAT_PER']=$rsdatos[0]->telefono_datos_personales;
        $datos_reporte['CELU_DA_PER']=$rsdatos[0]->celular_datos_personales;
        $datos_reporte['TELEF_TRA_DAT_PER']=$rsdatos[0]->telf_trabajo_datos_personales;
        $datos_reporte['EXT_DAT_PER']=$rsdatos[0]->ext_telef_datos_personales;
        $datos_reporte['NODE_DAT_PER']=$rsdatos[0]->node_telef_datos_personales;
        $datos_reporte['CORREO_DAT_PER']=$rsdatos[0]->email_datos_personales;
        $datos_reporte['NIVEL_EDU_DAT_PER']=$rsdatos[0]->nivel_educativo_datos_personales;
        $datos_reporte['NOM_REF_FAMI']=$rsdatos[0]->nombres_referencia_familiar_datos_personales;
        $datos_reporte['APELL_REF_FAMI']=$rsdatos[0]->apellidos_referencia_familiar_datos_personales;
        $datos_reporte['PARENTE_REF_FAMI_DAT_PER']=$rsdatos[0]->parentesco_referencia_familiar_datos_personales;
        $datos_reporte['TELEF_FAMI_DAT_PER']=$rsdatos[0]->primer_telefono_ref_familiar_datos_personales;
        $datos_reporte['TELEF_DOS_FAMI_DAT_PER']=$rsdatos[0]->segundo_telefono_ref_familiar_datos_personales;
        $datos_reporte['NOM_REF_PERSON_DAT_PER']=$rsdatos[0]->nombres_referencia_personal_datos_personales;
        $datos_reporte['APELLI_REF_PERSON_DAT_PER']=$rsdatos[0]->apellidos_referencia_personal_datos_personales;
        $datos_reporte['RELACIO_PERSO_DAT_PERSO']=$rsdatos[0]->relacion_referencia_personal_datos_personales;
        $datos_reporte['TELEF_REF_PER_DAT_PER']=$rsdatos[0]->primer_telefono_ref_personal_datos_personales;
        $datos_reporte['TELEF_DOR_REF_PER_DAT_PER']=$rsdatos[0]->segundo_telefono_ref_personal_datos_personales;
        $datos_reporte['INST_DAT_LABO']=$rsdatos[0]->nombre_entidades;
        $datos_reporte['REPARTO_UNIDAD_DATOS_LABORALES']=$rsdatos[0]->reparto_unidad_datos_laborales;
        $datos_reporte['SECCION_DATOS_LABORALES']=$rsdatos[0]->seccion_datos_laborales;
        $datos_reporte['NOMBRES_JEFE_DATOS_LABORALES']=$rsdatos[0]->nombres_jefe_datos_laborales;
        $datos_reporte['APELLIDOS_JEFE_DATOS_LABORALES']=$rsdatos[0]->apellidos_jefe_datos_laborales;
        $datos_reporte['TELEFONO_JEFE_DATOS_LABORALES']=$rsdatos[0]->telefono_jefe_datos_laborales;
        $datos_reporte['PROVINCIA_DATOS_LABORALES']=$rsdatos[0]->telefono_jefe_datos_laborales;
        $datos_reporte['CANTON_DATOS_LABORALES']=$rsdatos[0]->telefono_jefe_datos_laborales;
        $datos_reporte['PARROQUIA_DATOS_LABORALES']=$rsdatos[0]->telefono_jefe_datos_laborales;
        $datos_reporte['CALLE_DATOS_LABORALES']=$rsdatos[0]->calle_datos_laborales;
        $datos_reporte['NUMERO_CALLE_DATOS_LABORALES']=$rsdatos[0]->numero_calle_datos_laborales;
        $datos_reporte['INTERSECCION_DATOS_LABORALES']=$rsdatos[0]->interseccion_datos_laborales;
        $datos_reporte['REFERENCIA_DIRECCION_TRABAJO_DATOS_LABORALES']=$rsdatos[0]->referencia_direccion_trabajo_datos_laborales;
        $datos_reporte['CARGO_ACTUAL_DATOS_LABORALES']=$rsdatos[0]->cargo_actual_datos_laborales;
        $datos_reporte['ANIOS_SERVICIO_DATOS_LABORALES']=$rsdatos[0]->anios_servicio_datos_laborales;
        $datos_reporte['NOMBRES_DATOS_CONYUGE']=$rsdatos[0]->nombres_datos_conyuge;
        $datos_reporte['APELLIDOS_DATOS_CONYUGE']=$rsdatos[0]->apellidos_datos_conyuge;
        $datos_reporte['CEDULA_DATOS_CONYUGE']=$rsdatos[0]->cedula_datos_conyuge;
        $datos_reporte['SEXO_DATOS_CONYUGE']=$rsdatos[0]->cedula_datos_conyuge;
        $datos_reporte['FECHA_NACIMIENTO_DATOS_CONYUGE']=$rsdatos[0]->fecha_nacimiento_datos_conyuge;
        $datos_reporte['VIVE_RESIDENCIA_DATOS_CONYUGE']=$rsdatos[0]->vive_residencia_datos_conyuge;
        $datos_reporte['CELULAR_DATOS_CONYUGE']=$rsdatos[0]->celular_datos_conyuge;
        $datos_reporte['TELEFONO_DATOS_CONYUGE']=$rsdatos[0]->telefono_datos_conyuge;
        $datos_reporte['BARRIO_DATOS_CONYUGE']=$rsdatos[0]->barrio_datos_conyuge;
        $datos_reporte['CIUDADELA_DATOS_CONYUGE']=$rsdatos[0]->ciudadela_datos_conyuge;
        $datos_reporte['CALLE_DATOS_CONYUGE']=$rsdatos[0]->calle_datos_conyuge;
        $datos_reporte['NUMERO_CALLE_DATOS_CONYUGE']=$rsdatos[0]->numero_calle_datos_conyuge;
        $datos_reporte['INTERSECCION_DATOS_CONYUGE']=$rsdatos[0]->interseccion_datos_conyuge;
        $datos_reporte['ACTIVIDAD_ECONOMICA_DATOS_CONYUGE']=$rsdatos[0]->actividad_economica_datos_conyuge;
        $datos_reporte['EMPRESA_DATOS_CONYUGE']=$rsdatos[0]->empresa_datos_conyuge;
        $datos_reporte['NATURALEZA_NEGOCIO_DATOS_CONYUGE']=$rsdatos[0]->naturaleza_negocio_datos_conyuge;
        $datos_reporte['CARGO_DATOS_CONYUGE']=$rsdatos[0]->cargo_datos_conyuge;
        $datos_reporte['TIPO_CONTRATO_DATOS_CONYUGE']=$rsdatos[0]->tipo_contrato_datos_conyuge;
        $datos_reporte['ANIOS_LABORADOS_DATOS_CONYUGE']=$rsdatos[0]->anios_laborados_datos_conyuge;
        $datos_reporte['NOMBRES_JEFE_DATOS_CONYUGE']=$rsdatos[0]->nombres_jefe_datos_conyuge;
        $datos_reporte['APELLIDOS_JEFE_DATOS_CONYUGE']=$rsdatos[0]->apellidos_jefe_datos_conyuge;
        $datos_reporte['TELEFONO_JEFE_DATOS_CONYUGE']=$rsdatos[0]->telefono_jefe_datos_conyuge;
        $datos_reporte['CALLE_TRABAJO_DATOS_CONYUGE']=$rsdatos[0]->calle_trabajo_datos_conyuge;
        $datos_reporte['NUEMERO_CALLE_TRABAJO_DATOS_CONYUGE']=$rsdatos[0]->nuemero_calle_trabajo_datos_conyuge;
        $datos_reporte['INTERSECCION_TRABAJO_DATOS_CONYUGE']=$rsdatos[0]->interseccion_trabajo_datos_conyuge;
        $datos_reporte['REFERENCIA_TRABAJO_DATOS_CONYUGE']=$rsdatos[0]->referencia_trabajo_datos_conyuge;
        $datos_reporte['ACTIVIDAD_PRINCIPAL_DATOS_INDEPENDIENTES']=$rsdatos[0]->actividad_principal_datos_independientes;
        $datos_reporte['RUC_DATOS_INDEPENDIENTES']=$rsdatos[0]->ruc_datos_independientes;
        $datos_reporte['DETALLE_ACTIVIDADES_DATOS_INDEPENDIENTES']=$rsdatos[0]->detalle_actividades_datos_independientes;
        $datos_reporte['LOCAL_DATOS_INDEPENDIENTES']=$rsdatos[0]->local_datos_independientes;
        $datos_reporte['NOMBRES_PROPIETARIO_DATOS_INDEPENDIENTES']=$rsdatos[0]->nombres_propietario_datos_independientes;
        $datos_reporte['APELLIDOS_PROPIETARIO_DATOS_INDEPENDIENTES']=$rsdatos[0]->apellidos_propietario_datos_independientes;
        $datos_reporte['TELEFONO_PROPIETARIO_DATOS_INDEPENDIENTES']=$rsdatos[0]->telefono_propietario_datos_independientes;
        $datos_reporte['TIEMPO_FUNCIONAMIENTO_DATOS_INDEPENDIENTES']=$rsdatos[0]->tiempo_funcionamiento_datos_independientes;
        $datos_reporte['NUMERO_PATRONAL_DATOS_INDEPENDIENTES']=$rsdatos[0]->numero_patronal_datos_independientes;
        $datos_reporte['NUMERO_EMPLEADOS_DATOS_INDEPENDIENTES']=$rsdatos[0]->numero_empleados_datos_independientes;
        $datos_reporte['TIPO_CUENTA_REFERENCIA_BANCARIA']=$rsdatos[0]->tipo_cuenta_referencia_bancaria;
        $datos_reporte['NUMERO_CUENTA_REFERENCIA_BANCARIA']=$rsdatos[0]->numero_cuenta_referencia_bancaria;
        $datos_reporte['TIPO_CUENTA_UNO_DATOS_ECONOMICOS']=$rsdatos[0]->tipo_cuenta_uno_datos_economicos;
        $datos_reporte['NUMERO_CUENTA_UNO_DATOS_ECONOMICOS']=$rsdatos[0]->numero_cuenta_uno_datos_economicos;
        $datos_reporte['TIPO_CUENTA_DOS_DATOS_ECONOMICOS']=$rsdatos[0]->tipo_cuenta_dos_datos_economicos;
        $datos_reporte['NUMERO_CUENTA_DOS_DATOS_ECONOMICOS']=$rsdatos[0]->numero_cuenta_dos_datos_economicos;
        $datos_reporte['TIPO_CUENTA_TRES_DATOS_ECONOMICOS']=$rsdatos[0]->tipo_cuenta_tres_datos_economicos;
        $datos_reporte['NUMERO_CUENTA_TRES_DATOS_ECONOMICOS']=$rsdatos[0]->numero_cuenta_tres_datos_economicos;
        $datos_reporte['TIPO_CUENTA_CUATRO_DATOS_ECONOMICOS']=$rsdatos[0]->tipo_cuenta_cuatro_datos_economicos;
        $datos_reporte['NUMERO_CUENTA_CUATRO_DATOS_ECONOMICOS']=$rsdatos[0]->numero_cuenta_cuatro_datos_economicos;
        $datos_reporte['EMPRESA_UNO_DATOS_ECONOMICOS']=$rsdatos[0]->empresa_uno_datos_economicos;
        $datos_reporte['DIRECCION_UNO_DATOS_ECONOMICOS']=$rsdatos[0]->direccion_uno_datos_economicos;
        $datos_reporte['NUMERO_TELEFONO_UNO_DATOS_ECONOMICOS']=$rsdatos[0]->numero_telefono_uno_datos_economicos;
        $datos_reporte['EMPRESA_DOS_DATOS_ECONOMICOS']=$rsdatos[0]->empresa_dos_datos_economicos;
        $datos_reporte['DIRECCION_DOS_DATOS_ECONOMICOS']=$rsdatos[0]->direccion_dos_datos_economicos;
        $datos_reporte['NUMERO_TELEFONO_DOS_DATOS_ECONOMICOS']=$rsdatos[0]->numero_telefono_dos_datos_economicos;
        $datos_reporte['EMPRESA_TRES_DATOS_ECONOMICOS']=$rsdatos[0]->empresa_tres_datos_economicos;
        $datos_reporte['DIRECCION_TRES_DATOS_ECONOMICOS']=$rsdatos[0]->direccion_tres_datos_economicos;
        $datos_reporte['NUMERO_TELEFONO_TRES_DATOS_ECONOMICOS']=$rsdatos[0]->numero_telefono_tres_datos_economicos;
        $datos_reporte['EMPRESA_CUATRO_DATOS_ECONOMICOS']=$rsdatos[0]->empresa_cuatro_datos_economicos;
        $datos_reporte['DIRECCION_CUATRO_DATOS_ECONOMICOS']=$rsdatos[0]->direccion_cuatro_datos_economicos;
        $datos_reporte['NUMERO_TELEFONO_CUATRO_DATOS_ECONOMICOS']=$rsdatos[0]->numero_telefono_cuatro_datos_economicos;
        $datos_reporte['EFECTIVO_ACTIVOS_CORRIENTES']=$rsdatos[0]->efectivo_activos_corrientes;
        $datos_reporte['BANCOS_ACTIVOS_CORRIENTES']=$rsdatos[0]->bancos_activos_corrientes;
        $datos_reporte['CUENTAS_COBRAR_ACTIVOS_CORRIENTES']=$rsdatos[0]->cuentas_cobrar_activos_corrientes;
        $datos_reporte['INVERSIONES_ACTIVOS_CORRIENTES']=$rsdatos[0]->inversiones_activos_corrientes;
        $datos_reporte['INVENTARIOS_ACTIVOS_CORRIENTES']=$rsdatos[0]->inventarios_activos_corrientes;
        $datos_reporte['MUEBLES_ACTIVOS_CORRIENTES']=$rsdatos[0]->muebles_activos_corrientes;
        $datos_reporte['OTROS_ACTIVOS_CORRIENTES']=$rsdatos[0]->otros_activos_corrientes;
        $datos_reporte['TERRENO_ACTIVOS_FIJOS']=$rsdatos[0]->terreno_activos_fijos;
        $datos_reporte['VIVIENDA_ACTIVOS_FIJOS']=$rsdatos[0]->vivienda_activos_fijos;
        $datos_reporte['VEHICULO_ACTIVOS_FIJOS']=$rsdatos[0]->vehiculo_activos_fijos;
        $datos_reporte['MAQUINARIA_ACTIVOS_FIJOS']=$rsdatos[0]->maquinaria_activos_fijos;
        $datos_reporte['OTROS_ACTIVOS_FIJOS']=$rsdatos[0]->otros_activos_fijos;
        $datos_reporte['VALOR_PRESTACION_ACTIVOS_INTANGIBLES']=$rsdatos[0]->valor_prestacion_activos_intangibles;
        $datos_reporte['PRESTAMO_MENOR_ANIO_PASIVO_CORRIENTE']=$rsdatos[0]->prestamo_menor_anio_pasivo_corriente;
        $datos_reporte['PRESTAMO_EMERGENTE_PASIVO_CORRIENTE']=$rsdatos[0]->prestamo_emergente_pasivo_corriente;
        $datos_reporte['CUENTAS_PAGAR_PASIVO_CORRIENTE']=$rsdatos[0]->cuentas_pagar_pasivo_corriente;
        $datos_reporte['PROVEEDORES_PASIVO_CORRIENTE']=$rsdatos[0]->proveedores_pasivo_corriente;
        $datos_reporte['OBLIGACIONES_MENORES_ANIO_PASIVO_CORRIENTE']=$rsdatos[0]->obligaciones_menores_anio_pasivo_corriente;
        $datos_reporte['CON_BANCO_PASIVO_CORRIENTE']=$rsdatos[0]->con_banco_pasivo_corriente;
        $datos_reporte['CON_COOPERATIVAS_PASIVO_CORRIENTE']=$rsdatos[0]->con_cooperativas_pasivo_corriente;
        $datos_reporte['PRESTAMO_MAYOR_ANIO_PASIVOS_LARGO_PLAZO']=$rsdatos[0]->prestamo_mayor_anio_pasivos_largo_plazo;
        $datos_reporte['OBLIGACIONES_MAYORES_ANIO_PASIVOS_LARGO_PLAZO']=$rsdatos[0]->obligaciones_mayores_anio_pasivos_largo_plazo;
        $datos_reporte['CON_BANCO_PASIVOS_LARGO_PLAZO']=$rsdatos[0]->con_banco_pasivos_largo_plazo;
        $datos_reporte['CON_COOPERATIVAS_PASIVOS_LARGO_PLAZO']=$rsdatos[0]->con_cooperativas_pasivos_largo_plazo;
        $datos_reporte['OTROS_PASIVOS_LARGO_PLAZO']=$rsdatos[0]->otros_pasivos_largo_plazo;
        $datos_reporte['PATRIMONIO']=$rsdatos[0]->patrimonio;
        $datos_reporte['GARANTIAS_CAPREMCI']=$rsdatos[0]->garantias_capremci;
        $datos_reporte['TIPO_PRODUCTO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->tipo_producto_uno_detalle_activos;
        $datos_reporte['VALOR_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->valor_uno_detalle_activos;
        $datos_reporte['PLAZO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->plazo_uno_detalle_activos;
        $datos_reporte['TIPO_PRODUCTO_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->tipo_producto_dos_detalle_activos;
        $datos_reporte['VALOR_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->valor_dos_detalle_activos;
        $datos_reporte['PLAZO_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->plazo_dos_detalle_activos;
        $datos_reporte['TIPO_PRODUCTO_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->tipo_producto_tres_detalle_activos;
        $datos_reporte['VALOR_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->valor_tres_detalle_activos;
        $datos_reporte['PLAZO_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->plazo_tres_detalle_activos;
        $datos_reporte['TIPO_PRODUCTO_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->tipo_producto_cuatro_detalle_activos;
        $datos_reporte['VALOR_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->valor_cuatro_detalle_activos;
        $datos_reporte['PLAZO_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->plazo_cuatro_detalle_activos;
        $datos_reporte['MUEBLES_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->muebles_uno_detalle_activos;
        $datos_reporte['DIRECCION_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->direccion_uno_detalle_activos;
        $datos_reporte['VALOR_MUEBLES_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->valor_muebles_uno_detalle_activos;
        $datos_reporte['ESTA_HIPOTECADO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->esta_hipotecado_uno_detalle_activos;
        $datos_reporte['MUEBLES_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->muebles_dos_detalle_activos;
        $datos_reporte['DIRECCION_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->direccion_dos_detalle_activos;
        $datos_reporte['VALOR_MUEBLES_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->valor_muebles_dos_detalle_activos;
        $datos_reporte['ESTA_HIPOTECADO_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->esta_hipotecado_dos_detalle_activos;
        $datos_reporte['MUEBLES_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->muebles_tres_detalle_activos;
        $datos_reporte['DIRECCION_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->direccion_tres_detalle_activos;
        $datos_reporte['VALOR_MUEBLES_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->valor_muebles_tres_detalle_activos;
        $datos_reporte['ESTA_HIPOTECADO_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->esta_hipotecado_tres_detalle_activos;
        $datos_reporte['MUEBLES_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->muebles_cuatro_detalle_activos;
        $datos_reporte['DIRECCION_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->direccion_cuatro_detalle_activos;
        $datos_reporte['VALOR_MUEBLES_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->valor_muebles_cuatro_detalle_activos;
        $datos_reporte['ESTA_HIPOTECADA_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->esta_hipotecada_cuatro_detalle_activos;
        $datos_reporte['VEHICULO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->vehiculo_uno_detalle_activos;
        $datos_reporte['VALOR_VEHICULO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->valor_vehiculo_uno_detalle_activos;
        $datos_reporte['USO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->uso_uno_detalle_activos;
        $datos_reporte['ASEGURADO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->asegurado_uno_detalle_activos;
        $datos_reporte['VEHICULO_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->vehiculo_dos_detalle_activos;
        $datos_reporte['VALOR_VEHICULO_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->valor_vehiculo_dos_detalle_activos;
        $datos_reporte['USO_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->uso_dos_detalle_activos;
        $datos_reporte['ASEGURADO_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->asegurado_dos_detalle_activos;
        $datos_reporte['VEHICULO_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->vehiculo_tres_detalle_activos;
        $datos_reporte['VALOR_VEHICULO_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->valor_vehiculo_tres_detalle_activos;
        $datos_reporte['USO_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->uso_tres_detalle_activos;
        $datos_reporte['ASEGURADO_TRES_DETALLE_ACTIVOS']=$rsdatos[0]->asegurado_tres_detalle_activos;
        $datos_reporte['VEHICULO_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->vehiculo_cuatro_detalle_activos;
        $datos_reporte['VALOR_VEHICULO_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->valor_vehiculo_cuatro_detalle_activos;
        $datos_reporte['USO_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->uso_cuatro_detalle_activos;
        $datos_reporte['ASEGURADO_CUATRO_DETALLE_ACTIVOS']=$rsdatos[0]->asegurado_cuatro_detalle_activos;
        $datos_reporte['OTROS_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->otros_uno_detalle_activos;
        $datos_reporte['VALOR_OTROS_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->valor_otros_uno_detalle_activos;
        $datos_reporte['OBSERVACION_OTRO_UNO_DETALLE_ACTIVOS']=$rsdatos[0]->observacion_otro_uno_detalle_activos;
        $datos_reporte['OTROS_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->otros_dos_detalle_activos;
        $datos_reporte['VALOR_OTROS_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->valor_otros_dos_detalle_activos;
        $datos_reporte['OBSERVACION_DOS_DETALLE_ACTIVOS']=$rsdatos[0]->observacion_dos_detalle_activos;
        $datos_reporte['INSTITUCION_UNO_DETALLE_PASIVOS']=$rsdatos[0]->institucion_uno_detalle_pasivos;
        $datos_reporte['VALOR_UNO_DETALLE_PASIVOS']=$rsdatos[0]->valor_uno_detalle_pasivos;
        $datos_reporte['DESTINO_UNO_DETALLE_PASIVOS']=$rsdatos[0]->destino_uno_detalle_pasivos;
        $datos_reporte['GARANTIA_UNO_DETALLE_PASIVOS']=$rsdatos[0]->garantia_uno_detalle_pasivos;
        $datos_reporte['PLAZO_UNO_DETALLE_PASIVOS']=$rsdatos[0]->plazo_uno_detalle_pasivos;
        $datos_reporte['SALDO_UNO_DETALLE_PASIVOS']=$rsdatos[0]->saldo_uno_detalle_pasivos;
        $datos_reporte['INSTITUCION_DOS_DETALLE_PASIVOS']=$rsdatos[0]->institucion_dos_detalle_pasivos;
        $datos_reporte['VALOR_DOS_DETALLE_PASIVOS']=$rsdatos[0]->valor_dos_detalle_pasivos;
        $datos_reporte['DESTINO_DOS_DETALLE_PASIVOS']=$rsdatos[0]->destino_dos_detalle_pasivos;
        $datos_reporte['GARANTIA_DOS_DETALLE_PASIVOS']=$rsdatos[0]->garantia_dos_detalle_pasivos;
        $datos_reporte['PLAZO_DOS_DETALLE_PASIVOS']=$rsdatos[0]->plazo_dos_detalle_pasivos;
        $datos_reporte['SALDO_DOS_DETALLE_PASIVOS']=$rsdatos[0]->saldo_dos_detalle_pasivos;
        $datos_reporte['INSTITUCION_TRES_DETALLE_PASIVOS']=$rsdatos[0]->institucion_tres_detalle_pasivos;
        $datos_reporte['VALOR_TRES_DETALLE_PASIVOS']=$rsdatos[0]->valor_tres_detalle_pasivos;
        $datos_reporte['DESTINO_TRES_DETALLE_PASIVOS']=$rsdatos[0]->destino_tres_detalle_pasivos;
        $datos_reporte['GARANTIA_TRES_DETALLE_PASIVOS']=$rsdatos[0]->garantia_tres_detalle_pasivos;
        $datos_reporte['PLAZO_TRES_DETALLE_PASIVOS']=$rsdatos[0]->plazo_tres_detalle_pasivos;
        $datos_reporte['SALDO_TRES_DETALLE_PASIVOS']=$rsdatos[0]->saldo_tres_detalle_pasivos;
        $datos_reporte['INSTITUCION_CUATRO_DETALLE_PASIVOS']=$rsdatos[0]->institucion_cuatro_detalle_pasivos;
        $datos_reporte['VALOR_CUATRO_DETALLE_PASIVOS']=$rsdatos[0]->valor_cuatro_detalle_pasivos;
        $datos_reporte['DESTINO_CUATRO_DETALLE_PASIVOS']=$rsdatos[0]->destino_cuatro_detalle_pasivos;
        $datos_reporte['GARANTIA_CUATRO_DETALLE_PASIVOS']=$rsdatos[0]->garantia_cuatro_detalle_pasivos;
        $datos_reporte['PLAZO_CUATRO_DETALLE_PASIVOS']=$rsdatos[0]->plazo_cuatro_detalle_pasivos;
        $datos_reporte['SALDO_CUATRO_DETALLE_PASIVOS']=$rsdatos[0]->saldo_cuatro_detalle_pasivos;
        $datos_reporte['INSTITUCION_CINCO_DETALLE_PASIVOS']=$rsdatos[0]->institucion_cinco_detalle_pasivos;
        $datos_reporte['VALOR_CINCO_DETALLE_PASIVOS']=$rsdatos[0]->valor_cinco_detalle_pasivos;
        $datos_reporte['DESTINO_CINCO_DETALLE_PASIVOS']=$rsdatos[0]->destino_cinco_detalle_pasivos;
        $datos_reporte['GARANTIA_CINCO_DETALLE_PASIVOS']=$rsdatos[0]->garantia_cinco_detalle_pasivos;
        $datos_reporte['PLAZO_CINCO_DETALLE_PASIVOS']=$rsdatos[0]->plazo_cinco_detalle_pasivos;
        $datos_reporte['SALDO_CINCO_DETALLE_PASIVOS']=$rsdatos[0]->saldo_cinco_detalle_pasivos;
        $datos_reporte['SUELDO_AFILIADO_INGRESOS_MENSUALES']=$rsdatos[0]->sueldo_afiliado_ingresos_mensuales;
        $datos_reporte['SUELDO_CONYUGE_INGRESOS_MENSUALES']=$rsdatos[0]->sueldo_conyuge_ingresos_mensuales;
        $datos_reporte['COMISIONES_INGRESOS_MENSUALES']=$rsdatos[0]->comisiones_ingresos_mensuales;
        $datos_reporte['ARRIENDOS_INGRESOS_MENSUALES']=$rsdatos[0]->arriendos_ingresos_mensuales;
        $datos_reporte['DIVIDENDOS_INGRESOS_MENSUALES']=$rsdatos[0]->dividendos_ingresos_mensuales;
        $datos_reporte['INGRESOS_NEGOCIO_INGRESOS_MENSUALES']=$rsdatos[0]->ingresos_negocio_ingresos_mensuales;
        $datos_reporte['PENSIONES_INGRESOS_MENSUALES']=$rsdatos[0]->pensiones_ingresos_mensuales;
        $datos_reporte['OTROS_DETALLE_UNO_INGRESOS_MENSUALES']=$rsdatos[0]->otros_detalle_uno_ingresos_mensuales;
        $datos_reporte['OTROS_UNO_INGRESOS_MENSUALES']=$rsdatos[0]->otros_uno_ingresos_mensuales;
        $datos_reporte['OTROS_DETALLE_DOS_INGRESOS_MENSUALES']=$rsdatos[0]->otros_detalle_dos_ingresos_mensuales;
        $datos_reporte['OTROS_DOS_INGRESOS_MENSUALES']=$rsdatos[0]->otros_dos_ingresos_mensuales;
        $datos_reporte['OTROS_DETALLE_TRES_INGRESOS_MENSUALES']=$rsdatos[0]->otros_detalle_tres_ingresos_mensuales;
        $datos_reporte['OTROS_TRES_INGRESOS_MENSUALES']=$rsdatos[0]->otros_tres_ingresos_mensuales;
        $datos_reporte['ALIMENTACION_GASTOS_MENSUALES']=$rsdatos[0]->alimentacion_gastos_mensuales;
        $datos_reporte['ARRIENDOS_GASTOS_MENSUALES']=$rsdatos[0]->arriendos_gastos_mensuales;
        $datos_reporte['EDUCACION_GASTOS_MENSUALES']=$rsdatos[0]->educacion_gastos_mensuales;
        $datos_reporte['VESTUARIO_GASTOS_MENSUALES']=$rsdatos[0]->vestuario_gastos_mensuales;
        $datos_reporte['SERVICIOS_PUBLICOS_GASTOS_MENSUALES']=$rsdatos[0]->servicios_publicos_gastos_mensuales;
        $datos_reporte['MOVILIZACION_GASTOS_MENSUALES']=$rsdatos[0]->movilizacion_gastos_mensuales;
        $datos_reporte['AHORROS_COOPERATIVAS_GASTOS_MENSUALES']=$rsdatos[0]->ahorros_cooperativas_gastos_mensuales;
        $datos_reporte['CUOTAS_TARJETAS_GASTOS_MENSUALES']=$rsdatos[0]->cuotas_tarjetas_gastos_mensuales;
        $datos_reporte['CUOTAS_PRESTAMO_GASTOS_MENSUALES']=$rsdatos[0]->cuotas_prestamo_gastos_mensuales;
        $datos_reporte['OTROS_DETALLE_UNO_GASTOS_MENSUALES']=$rsdatos[0]->otros_detalle_uno_gastos_mensuales;
        $datos_reporte['OTROS_GASTOS_UNO_GASTOS_MENSUALES']=$rsdatos[0]->otros_gastos_uno_gastos_mensuales;
        $datos_reporte['TOTAL_ACTIVOS_CORRIENTES']=$rsdatos[0]->total_activos_corrientes;
        $datos_reporte['TOTAL_ACTIVOS_FIJOS']=$rsdatos[0]->total_activos_fijos;
        $datos_reporte['TOTAL_ACTIVOS']=$rsdatos[0]->total_activos;
        $datos_reporte['TOTAL_PASIVOS_CORRIENTES']=$rsdatos[0]->total_pasivos_corrientes;
        $datos_reporte['TOTAL_PASIVOS_LARGO_PLAZO']=$rsdatos[0]->total_pasivos_largo_plazo;
        $datos_reporte['TOTAL_PASIVOS']=$rsdatos[0]->total_pasivos;
        $datos_reporte['TOTAL_INGRESOS_MENSUALES']=$rsdatos[0]->total_ingresos_mensuales;
        $datos_reporte['TOTAL_GASTOS_MENSUALES']=$rsdatos[0]->total_gastos_mensuales;
        $datos_reporte['IDENTIFICADOR_CONSECUTIVOS']=$rsdatos[0]->identificador_consecutivos;
        $datos_reporte['FECHA_PRESENTACION']=$rsdatos[0]->fecha_presentacion;
        $datos_reporte['FECHA_APROBACION']=$rsdatos[0]->fecha_aprobacion;
      
                
        
        $this->verReporte("SolicitudHipotecario", array('datos_reporte'=>$datos_reporte ));
        
        
        
    }
    
    
    
    
}
?>