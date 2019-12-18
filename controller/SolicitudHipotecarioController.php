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
                
                $this->view("SolicitudHipotecario",array(
                    
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
    
    public function cargaGeneroDatosPersonales(){
        
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
    
    public function cargaEstadoCivilDatosPersonales(){
        
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
    
   
    public function cargaProvinciasDatosPersonales(){
        
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
    
    public function cargaCantonesDatosPersonales(){
        
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
    
    public function cargaParroquiasDatosPersonales(){
        
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
    
    
    public function cargaBancos(){
        
        $bancos= new BancosModel();
        
        $columnas="id_bancos, nombre_bancos";
        $tabla = "bancos";
        $where = "1=1";
        $id="id_bancos";
        $resulset = $bancos->getCondiciones($columnas,$tabla,$where,$id);
        
        if(!empty($resulset) && count($resulset)>0){
            
            echo json_encode(array('data'=>$resulset));
            
        }
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
            
            $nombre_controladores = "SolicitudHipotecario";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $solicitud_hipotecario->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer)){
            
            
            
         
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
            $_id_bancos_uno_detalle_activos =(isset($_REQUEST['id_bancos_uno_detalle_activos '])&& $_REQUEST['id_bancos_uno_detalle_activos '] !=NULL)?$_REQUEST['id_bancos_uno_detalle_activos ']:0;
            $_tipo_producto_uno_detalle_activos =(isset($_REQUEST['tipo_producto_uno_detalle_activos'])&& $_REQUEST['tipo_producto_uno_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_uno_detalle_activos']:'';
            $_valor_uno_detalle_activos =(isset($_REQUEST['valor_uno_detalle_activos'])&& $_REQUEST['valor_uno_detalle_activos'] !=NULL)?$_REQUEST['valor_uno_detalle_activos']:0;
            $_plazo_uno_detalle_activos =(isset($_REQUEST['plazo_uno_detalle_activos'])&& $_REQUEST['plazo_uno_detalle_activos'] !=NULL)?$_REQUEST['plazo_uno_detalle_activos']:'';
            $_id_bancos_dos_detalle_activos =(isset($_REQUEST['id_bancos_dos_detalle_activos'])&& $_REQUEST['id_bancos_dos_detalle_activos'] !=NULL)?$_REQUEST['id_bancos_dos_detalle_activos']:0;
            $_tipo_producto_dos_detalle_activos =(isset($_REQUEST['tipo_producto_dos_detalle_activos'])&& $_REQUEST['tipo_producto_dos_detalle_activos'] !=NULL)?$_REQUEST['tipo_producto_dos_detalle_activos']:'';
            $_valor_dos_detalle_activos =(isset($_REQUEST['valor_dos_detalle_activos'])&& $_REQUEST['valor_dos_detalle_activos'] !=NULL)?$_REQUEST['valor_dos_detalle_activos']:0;
            $_plazo_dos_detalle_activos =(isset($_REQUEST['plazo_dos_detalle_activos'])&& $_REQUEST['plazo_dos_detalle_activos'] !=NULL)?$_REQUEST['plazo_dos_detalle_activos ']:'';
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
            $_imagen_croquis_domicilio =(isset($_REQUEST['imagen_croquis_domicilio'])&& $_REQUEST['imagen_croquis_domicilio'] !=NULL)?$_REQUEST['imagen_croquis_domicilio']:'';
            $_imagen_croquis_otro_negocio =(isset($_REQUEST['imagen_croquis_otro_negocio'])&& $_REQUEST['imagen_croquis_otro_negocio'] !=NULL)?$_REQUEST['imagen_croquis_otro_negocio']:'';
            $_id_codigo_verificacion =(isset($_REQUEST['id_codigo_verificacion'])&& $_REQUEST['id_codigo_verificacion'] !=NULL)?$_REQUEST['id_codigo_verificacion']:0;
            $_id_usuarios_registra =(isset($_REQUEST['id_usuarios_registra'])&& $_REQUEST['id_usuarios_registra'] !=NULL)?$_REQUEST['id_usuarios_registra']:0;
            $_id_usuarios_oficial_credito_aprueba =(isset($_REQUEST['id_usuarios_oficial_credito_aprueba'])&& $_REQUEST['id_usuarios_oficial_credito_aprueba'] !=NULL)?$_REQUEST['id_usuarios_oficial_credito_aprueba']:0;
            $_total_activos_corrientes=$_efectivo_activos_corrientes+$_bancos_activos_corrientes+$_cuentas_cobrar_activos_corrientes+$_inversiones_activos_corrientes+$_inventarios_activos_corrientes+$_muebles_activos_corrientes+$_otros_activos_corrientes;
            $_total_activos_fijos=$_terreno_activos_fijos+$_vivienda_activos_fijos+$_vehiculo_activos_fijos+$_maquinaria_activos_fijos+$_otros_activos_fijos;
            $_total_activos=$_total_activos_corrientes+$_total_activos_fijos;
            $_total_pasivos_corrientes=$_prestamo_menor_anio_pasivo_corriente+$_prestamo_emergente_pasivo_corriente+$_cuentas_pagar_pasivo_corriente+$_proveedores_pasivo_corriente+$_obligaciones_menores_anio_pasivo_corriente+$_con_banco_pasivo_corriente+$_con_cooperativas_pasivo_corriente;
            $_total_pasivos_largo_plazo=$_prestamo_mayor_anio_pasivos_largo_plazo+$_obligaciones_mayores_anio_pasivos_largo_plazo+$_con_banco_pasivos_largo_plazo+$_con_cooperativas_pasivos_largo_plazo+$_otros_pasivos_largo_plazo;
            $_total_pasivos=$_total_pasivos_corrientes+$_total_pasivos_largo_plazo;
            $_total_ingresos_mensuales=$_sueldo_afiliado_ingresos_mensuales+$_sueldo_conyuge_ingresos_mensuales+$_comisiones_ingresos_mensuales+$_arriendos_ingresos_mensuales+$_dividendos_ingresos_mensuales+$_ingresos_negocio_ingresos_mensuales+$_pensiones_ingresos_mensuales+$_otros_uno_ingresos_mensuales+$_otros_dos_ingresos_mensuales+$_otros_tres_ingresos_mensuales;
            $_total_gastos_mensuales=$_alimentacion_gastos_mensuales+$_arriendos_gastos_mensuales+$_educacion_gastos_mensuales+$_vestuario_gastos_mensuales+$_servicios_publicos_gastos_mensuales+$_movilizacion_gastos_mensuales+$_ahorros_cooperativas_gastos_mensuales+$_cuotas_tarjetas_gastos_mensuales+$_cuotas_prestamo_gastos_mensuales+$_otros_gastos_uno_gastos_mensuales;
            $_fecha_presentacion= getdate();
            $_fecha_aprobacion= getdate();
            
            
            $funcion = "ins_solicitud_hipotecario";
            $respuesta = 0 ;
            $mensaje = "";
            $funcionadicionaluno="ins_solicitud_hipotecario_adicional_uno";
            $funcionadicionaldos="ins_solicitud_hipotecario_adicional_uno";
            
     
            
            if($_id_solicitud_hipotecario == 0){
                
                
                
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
                                '$_id_sexo_datos_conyuge',
                                '$_fecha_nacimiento_datos_conyuge',
                                '$_vive_residencia_datos_conyuge',
                                '$_celular_datos_conyuge',
                                '$_telefono_datos_conyuge',
                                '$_id_provincia_datos_conyuge',
                                '$_id_canton_datos_conyuge',
                                '$_id_parroquia_datos_conyuge',
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
                                '$_id_provincia_trabajo_datos_conyuge',
                                '$_id_canton_trabajo_datos_conyuge',
                                '$_id_parroquia_trabajo_datos_conyuge',
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
                                '$_numero_patronal_datos_independientes'

                                 ";
                
                
                $solicitud_hipotecario->setFuncion($funcion);
                $solicitud_hipotecario->setParametros($parametros);
                $resultado = $solicitud_hipotecario->llamafuncionPG();
                
                
                
                if($_id_solicitud_hipotecario > 0){
                    
                    
                    
                    $parametros = " '$_numero_empleados_datos_independientes',
                                '$_id_bancos_referencia_bancaria',
                                '$_tipo_cuenta_referencia_bancaria',
                                '$_numero_cuenta_referencia_bancaria',
                                '$_id_bancos_uno_datos_economicos',
                                '$_tipo_cuenta_uno_datos_economicos',
                                '$_numero_cuenta_uno_datos_economicos',
                                '$_id_bancos_dos_datos_economicos',
                                '$_tipo_cuenta_dos_datos_economicos',
                                '$_numero_cuenta_dos_datos_economicos',
                                '$_id_bancos_tres_datos_economicos',
                                '$_tipo_cuenta_tres_datos_economicos',
                                '$_numero_cuenta_tres_datos_economicos',
                                '$_id_bancos_cuatro_datos_economicos',
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
                                '$_id_bancos_uno_detalle_activos',
                                '$_tipo_producto_uno_detalle_activos',
                                '$_valor_uno_detalle_activos',
                                '$_plazo_uno_detalle_activos',
                                '$_id_bancos_dos_detalle_activos',
                                '$_tipo_producto_dos_detalle_activos',
                                '$_valor_dos_detalle_activos',
                                '$_plazo_dos_detalle_activos',
                                '$_id_bancos_tres_detalle_activos',
                                '$_tipo_producto_tres_detalle_activos',
                                '$_valor_tres_detalle_activos',
                                '$_plazo_tres_detalle_activos',
                                '$_id_bancos_cuatro_detalle_activos',
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
                                '$_asegurado_tres_detalle_activos'
                                
                                 ";
                    
                    
                    $solicitud_hipotecario->setFuncion($funcionadicionaluno);
                    $solicitud_hipotecario->setParametros($parametros);
                    $resultado = $solicitud_hipotecario->llamafuncionPG();
                    
                    
                    
                }
                
                
                
                
                if($_id_solicitud_hipotecario > 0){
          
                    $parametros = " '$_vehiculo_cuatro_detalle_activos',
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
                                '$_imagen_croquis_domicilio',
                                '$_imagen_croquis_otro_negocio',
                                '$_total_activos_corrientes',
                                '$_total_activos_fijos',
                                '$_total_activos',
                                '$_total_pasivos_corrientes',
                                '$_total_pasivos_largo_plazo',
                                '$_total_pasivos',
                                '$_total_ingresos_mensuales',
                                '$_total_gastos_mensuales',
                                '$_id_usuarios_registra',
                                '$_id_usuarios_oficial_credito_aprueba',
                                '$_identificador_consecutivos',
                                '$_fecha_presentacion',
                                '$_fecha_aprobacion'
                                
                                 ";
                    
                    
                    $solicitud_hipotecario->setFuncion($funcionadicionaldos);
                    $solicitud_hipotecario->setParametros($parametros);
                    $resultado = $solicitud_hipotecario->llamafuncionPG();
                
                }
                
                
                
                if(is_int((int)$resultado[0])){
                    
                    
                    $respuesta = $resultado[0];
                    $mensaje = "Solicitud Ingresada Correctamente";
                }
                
                
            }
            
            
            
            
            }
        
            
            
            
           ///
            echo json_encode(array('valor' => 1, 'mensaje'=>$_valor_dolares_datos_credito));
                    die();
             
               
                
               
                
                
                if($_id_solicitud_hipotecario > 0){
                    
                    
                    // AQUI PARA ACTUALIZA SOLICITUD
                    
                    
                }else{
                    
                    
                    // AQUI PARA GUARDAR NUEVA SOLICITUD
                    
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
                            
                            
                            $resultoficial1=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1' AND tipo_participe_datos_prestamo='Deudor'");
                            
                            if(!empty($resultoficial1)){
                                
                                $res1=count($resultoficial1);
                            }
                            
                            $resultoficial2=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2' AND tipo_participe_datos_prestamo='Deudor'");
                            
                            if(!empty($resultoficial2)){
                                $res2=count($resultoficial2);
                            }
                            
                            
                            $resultoficial3=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_3' AND tipo_participe_datos_prestamo='Deudor'");
                            
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
                                $id_oficial_credito=$id_usuarios_3;
                                
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
                            
                            $resultoficial1=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1' AND tipo_participe_datos_prestamo='Deudor'");
                            
                            if(!empty($resultoficial1)){
                                $res1=count($resultoficial1);
                            }
                            
                            $resultoficial2=$solicitud_prestamo->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2' AND tipo_participe_datos_prestamo='Deudor'");
                            
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