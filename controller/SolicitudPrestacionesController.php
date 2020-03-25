<?php

class SolicitudPrestacionesController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    //maycol
    
    public function index(){
        
        session_start();
        
   
        
        if (isset($_SESSION['nombre_usuarios']))
        {
            $SolicitudPrestaciones = new SolicitudPrestacionesModel();
            //NOTIFICACIONES
            //$controladores->MostrarNotificaciones($_SESSION['id_usuarios']);
            
            $nombre_controladores = "SolicitudPrestaciones";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $SolicitudPrestaciones->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
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
                
                $this->view("SolicitudPrestaciones",array(
                    
                    "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo
                ));
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a Controladores"
                    
                ));
                
                exit();
            }
            
        }
        else{
            
            $this->redirect("Usuarios","sesion_caducada");
            
        }
        
    }
    
    
    
    public function cargaGenero(){
        
        $genero= new SexoModel();
        
        $columnas="id_sexo, nombre_sexo";
        $tabla = "sexo";
        $where = "1=1";
        $id="nombre_sexo";
        $resulset = $genero->getCondiciones($columnas,$tabla,$where,$id);
        
        if(!empty($resulset) && count($resulset)>0){
            
            echo json_encode(array('data'=>$resulset));
            
        }
    }
    
    public function cargaEstadoCivil(){
        
        $estadocivil= new Estado_civilModel();
        
        $columnas="id_estado_civil, nombre_estado_civil";
        $tabla = "estado_civil";
        $where = "1=1";
        $id="nombre_estado_civil";
        $resulset = $estadocivil->getCondiciones($columnas,$tabla,$where,$id);
        
        if(!empty($resulset) && count($resulset)>0){
            
            echo json_encode(array('data'=>$resulset));
            
        }
    }
    
    
    public function cargaProvincias(){
        
        $provincias= new ProvinciasModel();
        
        $columnas="id_provincias, nombre_provincias";
        $tabla = "provincias";
        $where = "1=1";
        $id="id_provincias";
        $resulset = $provincias->getCondiciones($columnas,$tabla,$where,$id);
        
        if(!empty($resulset) && count($resulset)>0){
            
            echo json_encode(array('data'=>$resulset));
            
        }
    }
    
    public function cargaCantones(){
        
       $cantones= new CantonesModel();
        
        
       $id_provincias = (isset($_POST['id_provincias'])) ? $_POST['id_provincias'] : 0;
        
       if($id_provincias > 0){
            $columnas="id_cantones, nombre_cantones";
            $tabla = "cantones";
            $where = "id_provincias='$id_provincias'";
            $id="id_cantones";
            $resulset = $cantones->getCondiciones($columnas,$tabla,$where,$id);
            
            if(!empty($resulset) && count($resulset)>0){
                
                echo json_encode(array('data'=>$resulset));
                
            }
        }
        
    }
    
    public function cargaParroquias(){
        
        $parroquias= new ParroquiasModel();
        
        
        $id_cantones = (isset($_POST['id_cantones'])) ? $_POST['id_cantones'] : 0;
        
        if($id_cantones > 0){
            $columnas="id_parroquias, nombre_parroquias";
            $tabla = "parroquias";
            $where = "id_cantones='$id_cantones'";
            $id="id_parroquias";
            $resulset = $parroquias->getCondiciones($columnas,$tabla,$where,$id);
            
            if(!empty($resulset) && count($resulset)>0){
                
                echo json_encode(array('data'=>$resulset));
                
            }
        }
        
    }
    
    public function cargaBancos(){
        
        $bancos= new BancosModel();
        
        $columnas="id_bancos, nombre_bancos";
        $tabla = "bancos";
        $where = "1=1";
        $id="nombre_bancos";
        $resulset = $bancos->getCondiciones($columnas,$tabla,$where,$id);
        
        if(!empty($resulset) && count($resulset)>0){
            
            echo json_encode(array('data'=>$resulset));
            
        }
    }
    
    public function InsertarSolicitud()
    {
        
        session_start();
        
        
        
        
        $solicitud = new SolicitudPrestacionesModel();
        $consecutivos = new ConsecutivosModel();
        
        $_identificador_consecutivos=0;
        $resultConsecutivos=$consecutivos->getBy("nombre_consecutivos='SOLICITUD_PRESTACIONES'");
        $_identificador_consecutivos=$resultConsecutivos[0]->identificador_consecutivos;
        
        
        
        $nombre_controladores = "SolicitudPrestaciones";
        $id_rol= $_SESSION['id_rol'];
        $resultPer = $solicitud->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
        
        if (!empty($resultPer)){
            
           
            $_apellidos_solicitud_prestaciones = (isset($_POST["apellidos_solicitud_prestaciones"])) ? $_POST["apellidos_solicitud_prestaciones"] : "";
            $_nombres_solicitud_prestaciones = (isset($_POST["nombres_solicitud_prestaciones"])) ? $_POST["nombres_solicitud_prestaciones"] : "";
            $_cedula_participes = (isset($_POST["cedula_participes"])) ? $_POST["cedula_participes"] : "";
            $_id_sexo = (isset($_POST["id_sexo"])) ? $_POST["id_sexo"] : 0 ;
            $_fecha_nacimiento_solicitud_prestaciones = (isset($_POST["fecha_nacimiento_solicitud_prestaciones"])) ? $_POST["fecha_nacimiento_solicitud_prestaciones"] : 0 ;
            $_id_estado_civil = (isset($_POST["id_estado_civil"])) ? $_POST["id_estado_civil"] : 0 ;
            $_id_provincias = (isset($_POST["id_provincias"])) ? $_POST["id_provincias"] : 0 ;
            $_id_cantones = (isset($_POST["id_cantones"])) ? $_POST["id_cantones"] : 0 ;
            $_id_parroquias = (isset($_POST["id_parroquias"])) ? $_POST["id_parroquias"] : 0 ;
            $_barrio_solicitud_prestaciones = (isset($_POST["barrio_solicitud_prestaciones"])) ? $_POST["barrio_solicitud_prestaciones"] : "";
            $_ciudadela_solicitud_prestaciones = (isset($_POST["ciudadela_solicitud_prestaciones"])) ? $_POST["ciudadela_solicitud_prestaciones"] : "";
            $_calle_solicitud_prestaciones = (isset($_POST["calle_solicitud_prestaciones"])) ? $_POST["calle_solicitud_prestaciones"] : "";
            $_numero_calle_solicitud_prestaciones = (isset($_POST["numero_calle_solicitud_prestaciones"])) ? $_POST["numero_calle_solicitud_prestaciones"] : "";
            $_interseccion_solicitud_prestaciones = (isset($_POST["interseccion_solicitud_prestaciones"])) ? $_POST["interseccion_solicitud_prestaciones"] : "";
            $_tipo_vivienda_solicitud_prestaciones = (isset($_POST["tipo_vivienda_solicitud_prestaciones"])) ? $_POST["tipo_vivienda_solicitud_prestaciones"] : "";
            $_vivienda_hipotecada_solicitud_prestaciones = (isset($_POST["vivienda_hipotecada_solicitud_prestaciones"])) ? $_POST["vivienda_hipotecada_solicitud_prestaciones"] : "";
            $_referencia_dir_solicitud_prestaciones = (isset($_POST["referencia_dir_solicitud_prestaciones"])) ? $_POST["referencia_dir_solicitud_prestaciones"] : "";
            $_telefono_solicitud_prestaciones = (isset($_POST["telefono_solicitud_prestaciones"])) ? $_POST["telefono_solicitud_prestaciones"] : "";
            $_celular_solicitud_prestaciones = (isset($_POST["celular_solicitud_prestaciones"])) ? $_POST["celular_solicitud_prestaciones"] : "";
            $_correo_solicitud_prestaciones = (isset($_POST["correo_solicitud_prestaciones"])) ? $_POST["correo_solicitud_prestaciones"] : "";
            $_nivel_educativo_solicitud_prestaciones = (isset($_POST["nivel_educativo_solicitud_prestaciones"])) ? $_POST["nivel_educativo_solicitud_prestaciones"] : "";
            $_nombres_referencia_familiar = (isset($_POST["nombres_referencia_familiar"])) ? $_POST["nombres_referencia_familiar"] : "";
            $_apellidos_referencia_familiar = (isset($_POST["apellidos_referencia_familiar"])) ? $_POST["apellidos_referencia_familiar"] : "";
            $_parentesco_referencia_familiar = (isset($_POST["parentesco_referencia_familiar"])) ? $_POST["parentesco_referencia_familiar"] : "";
            $_primer_telefono_referencia_familiar = (isset($_POST["primer_telefono_referencia_familiar"])) ? $_POST["primer_telefono_referencia_familiar"] : "";
            $_segundo_telefono_referencia_familiar = (isset($_POST["segundo_telefono_referencia_familiar"])) ? $_POST["segundo_telefono_referencia_familiar"] : "";
            $_nombres_referencia_personal = (isset($_POST["nombres_referencia_personal"])) ? $_POST["nombres_referencia_personal"] : "";
            $_apellidos_referencia_personal = (isset($_POST["apellidos_referencia_personal"])) ? $_POST["apellidos_referencia_personal"] : "";
            $_parentesco_referencia_personal = (isset($_POST["parentesco_referencia_personal"])) ? $_POST["parentesco_referencia_personal"] : "";
            $_primer_telefono_referencia_personal = (isset($_POST["primer_telefono_referencia_personal"])) ? $_POST["primer_telefono_referencia_personal"] : "";
            $_segundo_telefono_referencia_personal = (isset($_POST["segundo_telefono_referencia_personal"])) ? $_POST["segundo_telefono_referencia_personal"] : "";
            $_ultimo_cargo_solicitud_prestaciones = (isset($_POST["ultimo_cargo_solicitud_prestaciones"])) ? $_POST["ultimo_cargo_solicitud_prestaciones"] : "";
            $_fecha_salida_solicitud_prestaciones = (isset($_POST["fecha_salida_solicitud_prestaciones"])) ? $_POST["fecha_salida_solicitud_prestaciones"] : "";
            $_id_bancos = (isset($_POST["id_bancos"])) ? $_POST["id_bancos"] : 0 ;
            $_numero_cuenta_ahorros_bancaria = (isset($_POST["numero_cuenta_ahorros_bancaria"])) ? $_POST["numero_cuenta_ahorros_bancaria"] : "";
            $_numero_cuenta_corriente_bancaria = (isset($_POST["numero_cuenta_corriente_bancaria"])) ? $_POST["numero_cuenta_corriente_bancaria"] : "";
            $_id_solicitud_prestaciones = (isset($_POST["id_solicitud_prestaciones"])) ? $_POST["id_solicitud_prestaciones"] : 0 ;
            $_id_codigo_verificacion = (isset($_POST["id_codigo_verificacion"])) ? $_POST["id_codigo_verificacion"] : 0 ;
            /*si es insertado enviar en cero el id_banco a la funcion*/
            
            
            $funcion = "ins_solicitud_prestaciones";
            $respuesta = 0 ;
            $mensaje = "";
            
            if($_id_solicitud_prestaciones == 0){
                
                
                
                $parametros = " '$_apellidos_solicitud_prestaciones',
                                '$_nombres_solicitud_prestaciones',
                                '$_cedula_participes',
                                '$_id_sexo',
                                '$_fecha_nacimiento_solicitud_prestaciones',
                                '$_id_estado_civil',
                                '$_id_provincias', 
                                '$_id_cantones',
                                '$_id_parroquias',
                                '$_barrio_solicitud_prestaciones',
                                '$_ciudadela_solicitud_prestaciones',
                                '$_calle_solicitud_prestaciones',
                                '$_numero_calle_solicitud_prestaciones',
                                '$_interseccion_solicitud_prestaciones', 
                                '$_tipo_vivienda_solicitud_prestaciones',
                                '$_vivienda_hipotecada_solicitud_prestaciones',
                                '$_referencia_dir_solicitud_prestaciones',
                                '$_telefono_solicitud_prestaciones',
                                '$_celular_solicitud_prestaciones',
                                '$_correo_solicitud_prestaciones',
                                '$_nivel_educativo_solicitud_prestaciones', 
                                '$_nombres_referencia_familiar', 
                                '$_apellidos_referencia_familiar', 
                                '$_parentesco_referencia_familiar', 
                                '$_primer_telefono_referencia_familiar', 
                                '$_segundo_telefono_referencia_familiar', 
                                '$_nombres_referencia_personal', 
                                '$_apellidos_referencia_personal', 
                                '$_parentesco_referencia_personal', 
                                '$_primer_telefono_referencia_personal', 
                                '$_segundo_telefono_referencia_personal', 
                                '$_ultimo_cargo_solicitud_prestaciones', 
                                '$_fecha_salida_solicitud_prestaciones',
                                '$_id_bancos',
                                '$_numero_cuenta_ahorros_bancaria',
                                '$_numero_cuenta_corriente_bancaria',
                                '$_identificador_consecutivos',
                                '$_id_codigo_verificacion'
                                
                 
                                 ";
                
               
                $solicitud->setFuncion($funcion);
                $solicitud->setParametros($parametros);
                $resultado = $solicitud->llamafuncionPG();
                
                
                if(is_int((int)$resultado[0])){
                   
                    
                    $respuesta = $resultado[0];
                    $mensaje = "Solicitud Ingresada Correctamente";
                }
                
                
                $consecutivos->UpdateBy("identificador_consecutivos = identificador_consecutivos+1", "consecutivos", "nombre_consecutivos = 'SOLICITUD_PRESTACIONES'");
                
                
                //$solicitud_prestamo->EnviarMailSolCred($_correo_solicitante_datos_personales, $id_oficial_credito, $_nombres_solicitante_datos_personales, $_apellidos_solicitante_datos_personales);
                
                
                /// INSERTAR
                
                
                
            }elseif ($_id_solicitud_prestaciones > 0){
                
                
                $columnas="
                        identificador_consecutivos_deudor='$_identificador_consecutivos',
                        apellidos_solicitud_prestaciones='$_apellidos_solicitud_prestaciones',
                        nombres_solicitud_prestaciones='$_nombres_solicitud_prestaciones',
						cedula_participes='$_cedula_participes',
						id_sexo='$_id_sexo',
						fecha_nacimiento_solicitud_prestaciones='$_fecha_nacimiento_solicitud_prestaciones',
						id_estado_civil='$_id_estado_civil',
						id_provincias='$_id_provincias',
                        id_cantones='$_id_cantones',
                        id_parroquias='$_id_parroquias',
						barrio_solicitud_prestaciones='$_barrio_solicitud_prestaciones',
						ciudadela_solicitud_prestaciones='$_ciudadela_solicitud_prestaciones',
						calle_solicitud_prestaciones='$_calle_solicitud_prestaciones',
						numero_calle_solicitud_prestaciones='$_numero_calle_solicitud_prestaciones',
						interseccion_solicitud_prestaciones='$_interseccion_solicitud_prestaciones',
                        tipo_vivienda_solicitud_prestaciones='$_tipo_vivienda_solicitud_prestaciones',
						vivienda_hipotecada_solicitud_prestaciones='$_vivienda_hipotecada_solicitud_prestaciones',
						referencia_dir_solicitud_prestaciones='$_referencia_dir_solicitud_prestaciones',
						telefono_solicitud_prestaciones='$_telefono_solicitud_prestaciones',
                        celular_solicitud_prestaciones='$_celular_solicitud_prestaciones',
                        correo_solicitud_prestaciones='$_correo_solicitud_prestaciones',
						nivel_educativo_solicitud_prestaciones='$_nivel_educativo_solicitud_prestaciones',
						nombres_referencia_familiar='$_nombres_referencia_familiar',
						apellidos_referencia_familiar='$_apellidos_referencia_familiar',
						parentesco_referencia_familiar='$_parentesco_referencia_familiar',
						primer_telefono_referencia_familiar='$_primer_telefono_referencia_familiar',
                        segundo_telefono_referencia_familiar='$_segundo_telefono_referencia_familiar',
                        nombres_referencia_personal='$_nombres_referencia_personal',
						apellidos_referencia_personal='$_apellidos_referencia_personal',
						parentesco_referencia_personal='$_parentesco_referencia_personal',
						primer_telefono_referencia_personal='$_primer_telefono_referencia_personal',
                        segundo_telefono_referencia_personal='$_segundo_telefono_referencia_personal',
                        ultimo_cargo_solicitud_prestaciones='$_ultimo_cargo_solicitud_prestaciones',
						fecha_salida_solicitud_prestaciones='$_fecha_salida_solicitud_prestaciones',
						id_bancos='$_id_bancos',
						numero_cuenta_ahorros_bancaria='$_numero_cuenta_ahorros_bancaria',
						numero_cuenta_corriente_bancaria='$_numero_cuenta_corriente_bancaria',
						identificador_consecutivos='$_identificador_consecutivos',
                        id_codigo_verificacion='$_id_codigo_verificacion'
						";
                $tablas="solicitud_prestaciones";
                $where="id_solicitud_prestaciones = '$_id_solicitud_prestaciones'";
                $resultado2=$solicitud->UpdateBy($columnas, $tablas, $where);
                
                
                
                if(is_int((int)$resultado2[0])){
                    $respuesta = $resultado2[0];
                    $mensaje = "Solicitud Actualizada Correctamente";
                }
                
                
            }
            
            
            
            if((int)$respuesta > 0 ){
                
                echo json_encode(array('respuesta'=>$respuesta,'mensaje'=>$mensaje));
                exit();
            }
            
            echo "Error al Ingresar la Solicitud";
            exit();
            
        }
        else
        {
            $this->view_Inventario("Error",array(
                "resultado"=>"No tiene Permisos de Insertar Solicitudes"
                
            ));
            
            
        }
        
    }
    
    
    public function EnviarSMS(){
        
        session_start();
        $solicitud_prestaciones = new SolicitudPrestacionesModel();
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
        $_celular_solicitud_prestaciones =(isset($_POST['celular_solicitud_prestaciones'])) ? $_POST['celular_solicitud_prestaciones'] : '';
        
        
        if(!empty($_celular_solicitud_prestaciones)){
            
            
            
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
                    
                    $cadena_recortada=$this->comsumir_mensaje_plus($_celular_solicitud_prestaciones, $nombre_usuarios, $codigo);
                    
                    
                    
                    if($cadena_recortada=='100'){
                        
                        $funcion = "ins_codigo_verificacion";
                        $parametros = " '$_id_usuarios','$codigo', '$_celular_solicitud_prestaciones'";
                        $codigo_verificacion->setFuncion($funcion);
                        $codigo_verificacion->setParametros($parametros);
                        $resultado=$codigo_verificacion->llamafuncionPG();
                        
                        $mensaje_retorna="Enviado Correctamente";
                        
                    }else if ($cadena_recortada=='101'){
                        
                        
                        $funcion = "ins_codigo_verificacion";
                        $parametros = " '$_id_usuarios','$codigo', '$_celular_solicitud_prestaciones'";
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
    
    
    
    
    
    public function reporte_cesantias(){
        session_start();
        
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        
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
        
        
        
        
        
        
      //  $productos = new ProductosModel();
        $id_productos =  (isset($_REQUEST['id_productos'])&& $_REQUEST['id_productos'] !=NULL)?$_REQUEST['id_productos']:'';
        
        $datos_reporte = array();
        
        $columnas = "   productos.id_productos,
                      productos.codigo_productos,
                      productos.marca_productos,
                      productos.nombre_productos";
        
        $tablas = "   public.productos";
        $where= "  productos.id_productos='$id_productos'";
        $id="productos.id_productos";
        
        $rsdatos = $productos->getCondiciones($columnas, $tablas, $where, $id);
        
        
        $datos_reporte['NOMBRE_PRODUCTOS']=$rsdatos[0]->nombre_productos;
        $datos_reporte['MARCA_PRODUCTOS']=$rsdatos[0]->marca_productos;
        $datos_reporte['CODIGO_PRODUCTO']=$rsdatos[0]->codigo_productos;
        
        
        
        $columnas = " productos.id_productos,
                      productos.codigo_productos,
                      productos.marca_productos,
                      productos.nombre_productos,
                      productos.ult_precio_productos,
                      productos.minimo_productos,
                      saldo_productos.entradas_f_saldo_productos,
                      saldo_productos.salidas_f_saldo_productos,
                      saldo_productos.saldos_f_saldo_productos";
        
        $tablas = "  public.productos,
                    public.saldo_productos";
        $where= "saldo_productos.id_productos = productos.id_productos AND productos.id_productos='$id_productos'";
        $id="productos.id_productos";
        
        $productos_detalle = $productos->getCondiciones($columnas, $tablas, $where, $id);
        
        $html='';
        
        
        $html.='<table class="12" style="width:98px;" border=1>';
        $html.='<tr>';
        $html.='<th colspan="2" style="text-align: center; font-size: 11px;">Entrada</th>';
        $html.='<th colspan="2" style="text-align: center; font-size: 11px;">Precio</th>';
        $html.='<th colspan="2" style="text-align: center; font-size: 11px;">Salida</th>';
        $html.='<th colspan="2" style="text-align: center; font-size: 11px;">Stock</th>';
        
        $html.='</tr>';
        
        
        
        
        foreach ($productos_detalle as $res)
        {
            
            
            $html.='<tr >';
            $html.='<td colspan="2" style="text-align: center; font-size: 11px;" align="center">'.intval($res->entradas_f_saldo_productos).'</td>';
            $html.='<td colspan="2" style="text-align: center; font-size: 11px;" align="right">'.$res->ult_precio_productos.'</td>';
            $html.='<td colspan="2" style="text-align: center; font-size: 11px;" align="center">'.intval($res->salidas_f_saldo_productos).'</td>';
            $html.='<td colspan="2" style="text-align: center; font-size: 11px;" align="center">'.intval($res->saldos_f_saldo_productos).'</td>';
            
            
            
            $html.='</td>';
            $html.='</tr>';
        }
        
        $html.='</table>';
        
        $datos_reporte['TABLA_MOVIMIENTOS']= $html;
        
        
        
        
        
        
        
        
        
        $this->verReporte("ReporteMovimientosProductos", array('datos_empresa'=>$datos_empresa, 'datos_cabecera'=>$datos_cabecera, 'datos_reporte'=>$datos_reporte ));
        
        
        
    }
    
    
   

    
    
}
?>