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
             
            
            
            
            $sucursales = new SucursalesModel();
            $resultSucursales= $sucursales->getAll("nombre_sucursales");
            
            
            $genero = new SexoModel();
            $resultGenero= $genero->getAll("nombre_sexo");
            
            
            $estado_civil = new Estado_civilModel();
            $resultEstadoCivil= $estado_civil->getAll("nombre_estado_civil");
            
            $provincias = new ProvinciasModel();
            $resultProvincias= $provincias->getAll("nombre_provincias");
            
            $cantones = new CantonesModel();
            $resultCantones= $cantones->getAll("nombre_cantones");
            
            
            $parroquias = new ParroquiasModel();
            $resultParroquias= $parroquias->getAll("nombre_parroquias");
            
            $banco = new BancosModel();
            $resultBancos= $banco->getAll("nombre_bancos");
            
            
            
            
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
                
                
                
                
                $resultEdit="";
                
                if(isset($_GET["id_solicitud_prestaciones"])){
                    
                    $_id_solicitud_prestaciones= $_GET["id_solicitud_prestaciones"];
                    
                    $columnas="solicitud_prestaciones.*,
                            codigo_verificacion.id_codigo_verificacion,
                            codigo_verificacion.numero_codigo_verificacion";
                    
                    $tablas="public.solicitud_prestaciones, public.codigo_verificacion";
                    $where="solicitud_prestaciones.id_codigo_verificacion= codigo_verificacion.id_codigo_verificacion AND solicitud_prestaciones.id_solicitud_prestaciones='$_id_solicitud_prestaciones'";
                    $id="solicitud_prestaciones.id_solicitud_prestaciones";
                    $resultEdit=$SolicitudPrestaciones->getCondiciones($columnas, $tablas, $where, $id);
                    
                    
                    $this->view("SolicitudPrestaciones",array(
                        "resultEdit"=>$resultEdit, "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo,
                        "resultSucursales"=>$resultSucursales, "resultGenero"=>$resultGenero, "resultEstadoCivil"=>$resultEstadoCivil, "resultProvincias"=>$resultProvincias,
                        "resultCantones"=>$resultCantones, "resultParroquias"=>$resultParroquias, "resultBancos"=>$resultBancos
                    ));
                    
                    die();
                    
                }
                
                
                
                
                
                 
                if(isset($_GET["solicitud"])){
                    
                        
                    
                    $this->view("SolicitudPrestaciones",array(
                        
                        "resultEdit"=>$resultEdit, "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo,
                        "resultSucursales"=>$resultSucursales, "resultGenero"=>$resultGenero, "resultEstadoCivil"=>$resultEstadoCivil, "resultProvincias"=>$resultProvincias,
                        "resultCantones"=>$resultCantones, "resultParroquias"=>$resultParroquias, "resultBancos"=>$resultBancos
                    ));
                        
                        die();
                    
                }
                
                
                
                
                
                $error_deudor="Permitir";
                $_id_usuarios= $_SESSION["id_usuarios"];
                
                
                $result=$SolicitudPrestaciones->getCondiciones("max(id_solicitud_prestaciones) as id_solicitud_prestaciones, id_usuarios_registra", "solicitud_prestaciones",
                    "(id_estado_tramites=1 OR id_estado_tramites=4)  AND  id_usuarios_registra='$_id_usuarios' GROUP BY id_usuarios_registra", "id_usuarios_registra");
                
                if(!empty($result)){
                    
                    $_id_solicitud_prestaciones=$result[0]->id_solicitud_prestaciones;
                    
                    $resulEsta=$SolicitudPrestaciones->getBy("id_solicitud_prestaciones='$_id_solicitud_prestaciones'");
                    
                    if(!empty($resulEsta)){
                        
                        
                        $_id_estado_tramites=$resulEsta[0]->id_estado_tramites;
                        
                        
                        if($_id_estado_tramites==1 || $_id_estado_tramites==4){
                            
                             $error_deudor="NoPermitir";
                        }else{
                            $error_deudor="Permitir";
                        }
                        
                        
                    }
                    
                    
                }
                
                
                
                $this->view("SolicitudPrestacionesSeleccion",array(
                    "error_deudor"=>$error_deudor
                ));
                
                
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a Solicitud Prestaciones"
                    
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
    
    
    
    public function cargaSucursales(){
        
        $sucursales= new SucursalesModel();
        
        $columnas="id_sucursales, nombre_sucursales";
        $tabla = "sucursales";
        $where = "1=1";
        $id="id_sucursales";
        $resulset = $sucursales->getCondiciones($columnas,$tabla,$where,$id);
        
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
        
        
        
        if (isset($_SESSION['nombre_usuarios']))
        {
        
        $solicitud = new SolicitudPrestacionesModel();
        $consecutivos = new ConsecutivosModel();
        
        $_identificador_consecutivos=0;
       
        
        
        if(isset($_POST["id_solicitud_prestaciones"])){
            
            
        
           
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
            $_tipo_cuenta_bancaria = (isset($_POST["tipo_cuenta_bancaria"])) ? $_POST["tipo_cuenta_bancaria"] : "";
            $_numero_cuenta_bancaria = (isset($_POST["numero_cuenta_bancaria"])) ? $_POST["numero_cuenta_bancaria"] : "";
            $_id_solicitud_prestaciones = (isset($_POST["id_solicitud_prestaciones"])) ? $_POST["id_solicitud_prestaciones"] : 0 ;
            $_id_codigo_verificacion = (isset($_POST["id_codigo_verificacion"])) ? $_POST["id_codigo_verificacion"] : 0 ;
            
            $_fecha_actual =    getdate();
            $_fecha_año    =	$_fecha_actual['year'];
            $_fecha_mes    =	$_fecha_actual['mon'];
            $_fecha_dia    =	$_fecha_actual['mday'];
            
            $_fecha_presentacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
            $_id_usuarios_registra = $_SESSION['id_usuarios'];
            $_id_sucursales                                       = $_POST["id_sucursales"];
            
            
            
            
            
            if($_id_solicitud_prestaciones == 0){
                
                $resultConsecutivos=$consecutivos->getBy("nombre_consecutivos='SOLICITUD_PRESTACIONES'");
                $_identificador_consecutivos=$resultConsecutivos[0]->identificador_consecutivos;
                
                $id_usuarios_1=0;
                $id_usuarios_2=0;
                $id_usuarios_3=0;
                $res1=0;
                $res2=0;
                $res3=0;
                $id_oficial_credito=0;
                
                
                
                
                if($_id_sucursales == 1){
                    
                    $resultQuito=$solicitud->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Quito' AND id_estado=1", "id_usuarios");
                    
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
                    
                    
                    $resultoficial1=$solicitud->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1'  and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                    
                    if(!empty($resultoficial1)){
                        
                        $res1=count($resultoficial1);
                    }
                    
                    $resultoficial2=$solicitud->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2'  and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                    
                    if(!empty($resultoficial2)){
                        $res2=count($resultoficial2);
                    }
                    
                    
                    $resultoficial3=$solicitud->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_3' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                    
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
                    
                    
                    /////////// por lo que se fue la angie va todo a carlos narvaez //////////
                    
                    //$id_oficial_credito=0;
                    //$id_oficial_credito=15425;
                    
                    
                    
                }else{
                    
                    $resultGuayaquil=$solicitud->getCondiciones("id_usuarios", "usuarios", "id_rol=42 AND id_departamentos=18 AND ciudad_trabajo='Guayaquil' AND id_estado=1", "id_usuarios");
                    
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
                    
                    $resultoficial1=$solicitud->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_1' and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                    
                    if(!empty($resultoficial1)){
                        $res1=count($resultoficial1);
                    }
                    
                    $resultoficial2=$solicitud->getBy("id_usuarios_oficial_credito_aprueba='$id_usuarios_2'  and to_char(creado, 'YYYY')='$_fecha_año' and to_char(creado, 'MM')=LPAD('$_fecha_mes',2,'0')");
                    
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
                
                
                try {
                    
                    $solicitud->beginTran();
                    
                
                
                $funcion = "ins_solicitud_prestaciones";
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
                                '$_tipo_cuenta_bancaria',
                                '$_numero_cuenta_bancaria',
                                '$_identificador_consecutivos',
                                '$_id_codigo_verificacion',
                                '$_id_sucursales',
                                '$_fecha_presentacion',
                                '$_id_usuarios_registra',
                                '$id_oficial_credito'";
                
               
                $solicitud->setFuncion($funcion);
                $solicitud->setParametros($parametros);
                $resultado = $solicitud->llamafuncionPG();
                
                $error = "";
                $error = pg_last_error();
                if (!empty($error) || (int)$resultado[0] <= 0){
                    throw new Exception('error ingresando solicitud');
                }
                
                if(is_int((int)$resultado[0])){
                   
                    $consecutivos->UpdateBy("identificador_consecutivos = identificador_consecutivos+1", "consecutivos", "nombre_consecutivos = 'SOLICITUD_PRESTACIONES'");
                    
                }
                
                
                
                
                //$solicitud_prestamo->EnviarMailSolCred($_correo_solicitante_datos_personales, $id_oficial_credito, $_nombres_solicitante_datos_personales, $_apellidos_solicitante_datos_personales);
                
                
                $solicitud->endTran('COMMIT');
                
                } catch (Exception $e) {
                    
                    $solicitud->endTran();
                    echo $e->getMessage();
                    die();
                    
                }
                
                
                
            }else{
                
                
                $columnas="
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
						tipo_cuenta_bancaria='$_tipo_cuenta_bancaria',
						numero_cuenta_bancaria='$_numero_cuenta_bancaria'
						";
                $tablas="solicitud_prestaciones";
                $where="id_solicitud_prestaciones = '$_id_solicitud_prestaciones'";
                $resultado2=$solicitud->UpdateBy($columnas, $tablas, $where);
                
                
               
                
                
            }
            
            
            
           
            
            
            $this->redirect("SolicitudPrestaciones", "index2");
            
            
        }else{
            
            $this->redirect("SolicitudPrestaciones","index");
            
            
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
    
    
    
    
    public function index2(){
        
        
        
        session_start();
        if (isset(  $_SESSION['nombre_usuarios']) )
        {
            $SolicitudPrestaciones = new SolicitudPrestacionesModel();
            
            $nombre_controladores = "SolicitudPrestaciones";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $SolicitudPrestaciones->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
                $this->view("ConsultaSolicitudPrestaciones",array(
                    ""=>""
                ));
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de prestaciones."
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
        $SolicitudPrestaciones = new SolicitudPrestacionesModel();
        
        $usuarios = new UsuariosModel();
        $id_usuarios=$_SESSION["id_usuarios"];
        
        $where_to="";
        $columnas = "solicitud_prestaciones.cedula_participes, 
                      solicitud_prestaciones.apellidos_solicitud_prestaciones, 
                      solicitud_prestaciones.nombres_solicitud_prestaciones, 
                      solicitud_prestaciones.id_solicitud_prestaciones, 
                      solicitud_prestaciones.celular_solicitud_prestaciones, 
                      solicitud_prestaciones.correo_solicitud_prestaciones, 
                      bancos.nombre_bancos, 
                      solicitud_prestaciones.tipo_cuenta_bancaria, 
                      solicitud_prestaciones.numero_cuenta_bancaria, 
                      solicitud_prestaciones.fecha_presentacion, 
                      solicitud_prestaciones.fecha_aprobacion, 
                      solicitud_prestaciones.id_estado_tramites, 
                      solicitud_prestaciones.id_usuarios_registra, 
                      usuarios.nombre_usuarios, 
                      usuarios.cedula_usuarios, 
                      usuarios.correo_usuarios";
        
        $tablas   = " public.solicitud_prestaciones, 
                      public.usuarios, 
                      public.bancos";
        
        $where    = " solicitud_prestaciones.id_usuarios_oficial_credito_aprueba = usuarios.id_usuarios AND
                        bancos.id_bancos = solicitud_prestaciones.id_bancos AND solicitud_prestaciones.id_usuarios_registra='$id_usuarios'";
        
        $id       = "solicitud_prestaciones.id_solicitud_prestaciones";
        
        
        $where_to=$where;
        
        
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        
        
        if($action == 'ajax')
        {
            $html="";
            $resultSet=$SolicitudPrestaciones->getCantidad("*", $tablas, $where_to);
            $cantidadResult=(int)$resultSet[0]->total;
            
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
            
            $per_page = 10; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            
            $limit = " LIMIT   '$per_page' OFFSET '$offset'";
            
            $resultSet=$SolicitudPrestaciones->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
                $html.= "<table id='tabla_solicitud_prestaciones_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
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
                    
                    $html.='<td style="font-size: 11px;">'.$res->cedula_participes.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->apellidos_solicitud_prestaciones.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->nombres_solicitud_prestaciones.'</td>';
                    $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_presentacion)).'</td>';
                    $html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
                    if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
                        $html.='<td style="font-size: 11px;"></td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestaciones&action=index&id_solicitud_prestaciones='.$res->id_solicitud_prestaciones.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                    }else{
                        $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'<br>'.$res->correo_usuarios.'</td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" title="Editar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                    }
                    $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestaciones&action=print&id_solicitud_prestaciones='.$res->id_solicitud_prestaciones.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
                    
                    $html.='</tr>';
                    
                }
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section></div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_load_solicitud_prestaciones_registrados("index.php", $page, $total_pages, $adjacents).'';
                $html.='</div>';
                
                
            }else{
                $html.='<div class="col-lg-6 col-md-6 col-xs-12">';
                $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
                $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                $html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de prestaciones registrados...</b>';
                $html.='</div>';
                $html.='</div>';
            }
            
            echo $html;
            die();
            
        }
        
        
    }
    
    
    
    public function paginate_load_solicitud_prestaciones_registrados($reload, $page, $tpages, $adjacents) {
    
        
        
        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $out = '<ul class="pagination pagination-large">';
        
        // previous label
        
        if($page==1) {
            $out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
        } else if($page==2) {
            $out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_prestaciones_registrados(1)'>$prevlabel</a></span></li>";
        }else {
            $out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_prestaciones_registrados(".($page-1).")'>$prevlabel</a></span></li>";
            
        }
        
        // first label
        if($page>($adjacents+1)) {
            $out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestaciones_registrados(1)'>1</a></li>";
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
                $out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestaciones_registrados(1)'>$i</a></li>";
            }else {
                $out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestaciones_registrados(".$i.")'>$i</a></li>";
            }
        }
        
        // interval
        
        if($page<($tpages-$adjacents-1)) {
            $out.= "<li><a>...</a></li>";
        }
        
        // last
        
        if($page<($tpages-$adjacents)) {
            $out.= "<li><a href='javascript:void(0);' onclick='load_solicitud_prestaciones_registrados($tpages)'>$tpages</a></li>";
        }
        
        // next
        
        if($page<$tpages) {
            $out.= "<li><span><a href='javascript:void(0);' onclick='load_solicitud_prestaciones_registrados(".($page+1).")'>$nextlabel</a></span></li>";
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
            
            $SolicitudPrestaciones = new SolicitudPrestacionesModel();
            
            $nombre_controladores = "SolicitudPrestaciones";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $SolicitudPrestaciones->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
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
                    $tabla_afi = "solicitud_prestaciones";
                    $where_afi = "id_solicitud_prestaciones = '$_id_solicitud_prestamo'";
                    $resultado1=$SolicitudPrestaciones->UpdateBy($colval_afi, $tabla_afi, $where_afi);
                    
                    
                    $this->redirect("SolicitudPrestamo", "index3");
                    
                }
                
                
                if(isset($_GET["id_solicitud_prestamo_r"])){
                    
                    $_id_solicitud_prestamo= $_GET["id_solicitud_prestamo_r"];
                    $_fecha_actual =    getdate();
                    $_fecha_año    =	$_fecha_actual['year'];
                    $_fecha_mes    =	$_fecha_actual['mon'];
                    $_fecha_dia    =	$_fecha_actual['mday'];
                    
                    $_fecha_aprobacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
                    
                    $colval_afi = "fecha_aprobacion='$_fecha_aprobacion', id_estado_tramites=3";
                    $tabla_afi = "solicitud_prestaciones";
                    $where_afi = "id_solicitud_prestaciones = '$_id_solicitud_prestamo'";
                    $resultado1=$SolicitudPrestaciones->UpdateBy($colval_afi, $tabla_afi, $where_afi);
                    
                    $this->redirect("SolicitudPrestaciones", "index3");
                    
                }
                
                $this->view("ConsultaSolicitudPrestacionesAdmin",array(
                    ""=>""
                ));
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de prestaciones."
                    
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
        $SolicitudPrestaciones = new SolicitudPrestacionesModel();
        $usuarios = new UsuariosModel();
        $id_usuarios=$_SESSION["id_usuarios"];
        
        $where_to="";
       
        
        $columnas = "solicitud_prestaciones.cedula_participes,
                      solicitud_prestaciones.apellidos_solicitud_prestaciones,
                      solicitud_prestaciones.nombres_solicitud_prestaciones,
                      solicitud_prestaciones.id_solicitud_prestaciones,
                      solicitud_prestaciones.celular_solicitud_prestaciones,
                      solicitud_prestaciones.correo_solicitud_prestaciones,
                      bancos.nombre_bancos,
                      solicitud_prestaciones.tipo_cuenta_bancaria,
                      solicitud_prestaciones.numero_cuenta_bancaria,
                      solicitud_prestaciones.fecha_presentacion,
                      solicitud_prestaciones.fecha_aprobacion,
                      solicitud_prestaciones.id_estado_tramites,
                      solicitud_prestaciones.id_usuarios_registra,
                      usuarios.nombre_usuarios,
                      usuarios.cedula_usuarios,
                      usuarios.correo_usuarios,
                      estado_tramites.nombre_estado_tramites_solicitud_prestamos";
        
        $tablas   = " public.solicitud_prestaciones,
                      public.usuarios,
                      public.bancos,
                      public.estado_tramites";
        
        $where    = " estado_tramites.id_estado_tramites=solicitud_prestaciones.id_estado_tramites  AND solicitud_prestaciones.id_usuarios_oficial_credito_aprueba = usuarios.id_usuarios AND
                        bancos.id_bancos = solicitud_prestaciones.id_bancos AND solicitud_prestaciones.id_usuarios_oficial_credito_aprueba='$id_usuarios'";
        
        $id       = "solicitud_prestaciones.id_solicitud_prestaciones";
        
        
      
        
        //$where_to=$where;
        
        
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        $search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
        
        if($action == 'ajax')
        {
            
            if(!empty($search)){
                
                
                $where1=" AND (solicitud_prestaciones.cedula_participes LIKE '".$search."%' OR solicitud_prestaciones.apellidos_solicitud_prestaciones ILIKE '".$search."%' OR solicitud_prestaciones.nombres_solicitud_prestaciones ILIKE '".$search."%' OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos ILIKE '".$search."%' )";
                
                $where_to=$where.$where1;
            }else{
                
                $where_to=$where;
                
            }
            
            
            $html="";
            $resultSet=$SolicitudPrestaciones->getCantidad("*", $tablas, $where_to);
            $cantidadResult=(int)$resultSet[0]->total;
            
            $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
            
            $per_page = 10; //la cantidad de registros que desea mostrar
            $adjacents  = 9; //brecha entre páginas después de varios adyacentes
            $offset = ($page - 1) * $per_page;
            
            $limit = " LIMIT   '$per_page' OFFSET '$offset'";
            
            $resultSet=$SolicitudPrestaciones->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
                $html.= "<table id='tabla_solicitud_prestaciones_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
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
                    
                    $html.='<td style="font-size: 11px;">'.$res->cedula_participes.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->apellidos_solicitud_prestaciones.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->nombres_solicitud_prestaciones.'</td>';
                    $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_presentacion)).'</td>';
                    $html.='<td style="font-size: 11px;">'.$estado_tramite.'</td>';
                    
                    if($aprobado_oficial_credito==1 || $aprobado_oficial_credito==4){
                        $html.='<td style="font-size: 11px;"></td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
                        
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestaciones&action=index4&id_solicitud_prestaciones='.$res->id_solicitud_prestaciones.'" class="btn btn-success" style="font-size:65%;" title="Editar"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestaciones&action=index3&id_solicitud_prestamo_a='.$res->id_solicitud_prestaciones.'" class="btn btn-info" style="font-size:65%;" title="Guardar"><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestaciones&action=index3&id_solicitud_prestamo_r='.$res->id_solicitud_prestaciones.'" class="btn btn-danger" style="font-size:65%;" title="Rechazar"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
                        
                    }else{
                        $html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->fecha_aprobacion)).'</td>';
                        $html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-success" style="font-size:65%;" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-primary" style="font-size:65%;" disabled><i class="glyphicon glyphicon-floppy-saved"></i></a></span></td>';
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" class="btn btn-danger" style="font-size:65%;" disabled><i class="glyphicon glyphicon-trash"></i></a></span></td>';
                        
                    }
                    $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestaciones&action=print&id_solicitud_prestaciones='.$res->id_solicitud_prestaciones.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
                    $html.='</tr>';
                    
                }
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section></div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_load_solicitud_prestaciones_registrados("index.php", $page, $total_pages, $adjacents).'';
                $html.='</div>';
                
                
            }else{
                $html.='<div class="col-lg-6 col-md-6 col-xs-12">';
                $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
                $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                $html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de prestaciones registrados...</b>';
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
            
            $SolicitudPrestaciones = new SolicitudPrestacionesModel();
            
            
            $nombre_controladores = "SolicitudPrestaciones";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $SolicitudPrestaciones->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
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
                
                if(isset($_GET["id_solicitud_prestaciones"])){
                   
                    
                    $_id_solicitud_prestaciones= $_GET["id_solicitud_prestaciones"];
                    
                    
                    $colval_afi = "id_estado_tramites=4";
                    $tabla_afi = "solicitud_prestaciones";
                    $where_afi = "id_solicitud_prestaciones = '$_id_solicitud_prestaciones'";
                    $resultado1=$SolicitudPrestaciones->UpdateBy($colval_afi, $tabla_afi, $where_afi);
                    
                    
                    $columnas="solicitud_prestaciones.*,
                            codigo_verificacion.id_codigo_verificacion,
                            codigo_verificacion.numero_codigo_verificacion";
                    
                    $tablas="public.solicitud_prestaciones, public.codigo_verificacion";
                    $where="solicitud_prestaciones.id_codigo_verificacion= codigo_verificacion.id_codigo_verificacion AND solicitud_prestaciones.id_solicitud_prestaciones='$_id_solicitud_prestaciones'";
                    $id="solicitud_prestaciones.id_solicitud_prestaciones";
                    $resultEdit=$SolicitudPrestaciones->getCondiciones($columnas, $tablas, $where, $id);
                    
                    
                    
                }
                
                
                
                
                $this->view("ActualizarSolicitudPrestacionesAdmin",array(
                    "resultEdit"=>$resultEdit, "cedula"=>$cedula, "nombres"=>$nombres, "correo"=>$correo
                ));
                
                die();
                
               
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a llenar una solicitud de prestaciones."
                    
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
    
    
    
    
    
    public function ActualizaSolicitudPrestaciones(){
        
        
        session_start();
        
        if (isset($_SESSION['nombre_usuarios']))
        {
            
            $solicitud = new SolicitudPrestacionesModel();
            
            
            if (isset($_POST["id_solicitud_prestaciones"]))
            {
                
                
                
                
                
                
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
                $_tipo_cuenta_bancaria = (isset($_POST["tipo_cuenta_bancaria"])) ? $_POST["tipo_cuenta_bancaria"] : "";
                $_numero_cuenta_bancaria = (isset($_POST["numero_cuenta_bancaria"])) ? $_POST["numero_cuenta_bancaria"] : "";
                $_id_solicitud_prestaciones = (isset($_POST["id_solicitud_prestaciones"])) ? $_POST["id_solicitud_prestaciones"] : 0 ;
                $_id_codigo_verificacion = (isset($_POST["id_codigo_verificacion"])) ? $_POST["id_codigo_verificacion"] : 0 ;
                
                $_fecha_actual =    getdate();
                $_fecha_año    =	$_fecha_actual['year'];
                $_fecha_mes    =	$_fecha_actual['mon'];
                $_fecha_dia    =	$_fecha_actual['mday'];
                
                $_fecha_presentacion=$_fecha_año.'-'.$_fecha_mes.'-'.$_fecha_dia;
                $_id_usuarios_registra = $_SESSION['id_usuarios'];
                $_id_sucursales                                       = $_POST["id_sucursales"];
                
                
                
                
                
                if($_id_solicitud_prestaciones == 0){
                    
                }else{
                    
                    
                    $columnas="
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
						tipo_cuenta_bancaria='$_tipo_cuenta_bancaria',
						numero_cuenta_bancaria='$_numero_cuenta_bancaria'
						";
                    $tablas="solicitud_prestaciones";
                    $where="id_solicitud_prestaciones = '$_id_solicitud_prestaciones'";
                    $resultado2=$solicitud->UpdateBy($columnas, $tablas, $where);
                    
                    
                    
                }
                
                
                $this->redirect("SolicitudPrestaciones", "index3");
                
                
                
            }
            else
            {
                $this->redirect("SolicitudPrestaciones", "index3");
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
            $solicitud = new SolicitudPrestacionesModel();
            
            $nombre_controladores = "SolicitudPrestaciones";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $solicitud->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
                
                
                
                $this->view("ConsultaSolicitudPrestacionesSuperAdmin",array(
                    ""=>""
                ));
                
            }
            else
            {
                $this->view("Error",array(
                    "resultado"=>"No tiene Permisos de Acceso a consultar una solicitud de prestaciones."
                    
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
        $solicitud = new SolicitudPrestacionesModel();
        
        $usuarios = new UsuariosModel();
        $id_usuarios=$_SESSION["id_usuarios"];
        
        $where_to="";
       
        
        $columnas = "solicitud_prestaciones.cedula_participes,
                      solicitud_prestaciones.apellidos_solicitud_prestaciones,
                      solicitud_prestaciones.nombres_solicitud_prestaciones,
                      solicitud_prestaciones.id_solicitud_prestaciones,
                      solicitud_prestaciones.celular_solicitud_prestaciones,
                      solicitud_prestaciones.correo_solicitud_prestaciones,
                      bancos.nombre_bancos,
                      solicitud_prestaciones.tipo_cuenta_bancaria,
                      solicitud_prestaciones.numero_cuenta_bancaria,
                      solicitud_prestaciones.fecha_presentacion,
                      solicitud_prestaciones.fecha_aprobacion,
                      solicitud_prestaciones.id_estado_tramites,
                      solicitud_prestaciones.id_usuarios_registra,
                      usuarios.nombre_usuarios,
                      usuarios.cedula_usuarios,
                      usuarios.correo_usuarios,
                      estado_tramites.nombre_estado_tramites_solicitud_prestamos";
        
        $tablas   = " public.solicitud_prestaciones,
                      public.usuarios,
                      public.bancos,
                      public.estado_tramites";
        
        $where    = " estado_tramites.id_estado_tramites=solicitud_prestaciones.id_estado_tramites  AND solicitud_prestaciones.id_usuarios_oficial_credito_aprueba = usuarios.id_usuarios AND
                        bancos.id_bancos = solicitud_prestaciones.id_bancos";
        
        $id       = "solicitud_prestaciones.id_solicitud_prestaciones";
        
        
        
        
        //$where_to=$where;
        
        
        $action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
        $search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
        
        if($action == 'ajax')
        {
            
            if(!empty($search)){
                
                $where1=" AND (solicitud_prestaciones.cedula_participes LIKE '".$search."%' OR solicitud_prestaciones.apellidos_solicitud_prestaciones ILIKE '".$search."%' OR solicitud_prestaciones.nombres_solicitud_prestaciones ILIKE '".$search."%' OR  estado_tramites.nombre_estado_tramites_solicitud_prestamos ILIKE '".$search."%' )";
                
                
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
                $html.= "<table id='tabla_solicitud_prestaciones_registrados' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
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
                    
                    $html.='<td style="font-size: 11px;">'.$res->cedula_participes.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->apellidos_solicitud_prestaciones.'</td>';
                    $html.='<td style="font-size: 11px;">'.$res->nombres_solicitud_prestaciones.'</td>';
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
                        
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><button id="btn_abrir" class="btn btn-success" type="button" data-toggle="modal" data-target="#mod_reasignar" data-id="'.$res->id_solicitud_prestaciones.'" data-cedu="'.$res->cedula_participes.'" data-nombre="'.$res->apellidos_solicitud_prestaciones.' '.$res->nombres_solicitud_prestaciones.'" data-credito="" data-usuario="'.$res->nombre_usuarios.'"  title="Reasignar" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></button></span></td>';
                        
                        
                    }else{
                        $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="javascript:void(0);" target="_blank" class="btn btn-success" style="font-size:65%;" title="Reasignar" disabled><i class="glyphicon glyphicon-edit"></i></a></span></td>';
                        
                    }
                    
                    
                    $html.='<td style="font-size: 15px;"><span class="pull-right"><a href="index.php?controller=SolicitudPrestaciones&action=print&id_solicitud_prestaciones='.$res->id_solicitud_prestaciones.'" target="_blank" class="btn btn-warning" style="font-size:65%;" title="Imprimir"><i class="glyphicon glyphicon-print"></i></a></span></td>';
                    
                    $html.='</tr>';
                    
                }
                
                $html.='</tbody>';
                $html.='</table>';
                $html.='</section></div>';
                $html.='<div class="table-pagination pull-right">';
                $html.=''. $this->paginate_load_solicitud_prestaciones_registrados("index.php", $page, $total_pages, $adjacents).'';
                $html.='</div>';
                
                
            }else{
                $html.='<div class="col-lg-6 col-md-6 col-xs-12">';
                $html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
                $html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                $html.='<h4>Aviso!!!</h4> <b>Actualmente no hay solicitud de prestaciones registrados...</b>';
                $html.='</div>';
                $html.='</div>';
            }
            
            echo $html;
            die();
            
        }
        
        
    
    
    }
    
    
    
    public function ReasignarSolicitud(){
    
        
        
        session_start();
        
        $solicitud = new SolicitudPrestacionesModel();
        
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
                    $tabla_afi = "solicitud_prestaciones";
                    $where_afi = "id_solicitud_prestaciones = '$_id_solicitud_prestamo'";
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
        
        $solicitudPrestaciones = new SolicitudPrestacionesModel();
        $id_solicitud_pretaciones =  (isset($_REQUEST['id_solicitud_prestaciones'])&& $_REQUEST['id_solicitud_prestaciones'] !=NULL)?$_REQUEST['id_solicitud_prestaciones']:0;
        
        $datos_reporte = array();
        
        if($id_solicitud_pretaciones>0){
            
            
        
        $columnas = "  solicitud_prestaciones.id_solicitud_prestaciones,
                      solicitud_prestaciones.apellidos_solicitud_prestaciones,
                      solicitud_prestaciones.nombres_solicitud_prestaciones,
                      solicitud_prestaciones.cedula_participes,
                      solicitud_prestaciones.fecha_nacimiento_solicitud_prestaciones,
                      estado_civil.id_estado_civil,
                      estado_civil.nombre_estado_civil,
                      provincias.id_provincias,
                      provincias.nombre_provincias,
                      cantones.id_cantones,
                      cantones.nombre_cantones,
                      parroquias.id_parroquias,
                      parroquias.nombre_parroquias,
                      solicitud_prestaciones.barrio_solicitud_prestaciones,
                      solicitud_prestaciones.ciudadela_solicitud_prestaciones,
                      solicitud_prestaciones.calle_solicitud_prestaciones,
                      solicitud_prestaciones.numero_calle_solicitud_prestaciones,
                      solicitud_prestaciones.interseccion_solicitud_prestaciones,
                      solicitud_prestaciones.tipo_vivienda_solicitud_prestaciones,
                      solicitud_prestaciones.vivienda_hipotecada_solicitud_prestaciones,
                      solicitud_prestaciones.referencia_dir_solicitud_prestaciones,
                      solicitud_prestaciones.telefono_solicitud_prestaciones,
                      solicitud_prestaciones.celular_solicitud_prestaciones,
                      solicitud_prestaciones.correo_solicitud_prestaciones,
                      solicitud_prestaciones.nivel_educativo_solicitud_prestaciones,
                      solicitud_prestaciones.nombres_referencia_familiar,
                      solicitud_prestaciones.apellidos_referencia_familiar,
                      solicitud_prestaciones.parentesco_referencia_familiar,
                      solicitud_prestaciones.primer_telefono_referencia_familiar,
                      solicitud_prestaciones.segundo_telefono_referencia_familiar,
                      solicitud_prestaciones.nombres_referencia_personal,
                      solicitud_prestaciones.apellidos_referencia_personal,
                      solicitud_prestaciones.parentesco_referencia_personal,
                      solicitud_prestaciones.primer_telefono_referencia_personal,
                      solicitud_prestaciones.segundo_telefono_referencia_personal,
                      solicitud_prestaciones.ultimo_cargo_solicitud_prestaciones,
                      solicitud_prestaciones.fecha_salida_solicitud_prestaciones,
                      bancos.id_bancos,
                      bancos.nombre_bancos,
                      solicitud_prestaciones.numero_cuenta_bancaria,
                      solicitud_prestaciones.creado,
                      solicitud_prestaciones.modificado,
                      sexo.id_sexo,
                      sexo.nombre_sexo";
        
        $tablas = "  public.solicitud_prestaciones,
                      public.estado_civil,
                      public.provincias,
                      public.cantones,
                      public.parroquias,
                      public.bancos,
                      public.sexo";
        $where= "  estado_civil.id_estado_civil = solicitud_prestaciones.id_estado_civil AND
  provincias.id_provincias = solicitud_prestaciones.id_provincias AND
  cantones.id_cantones = solicitud_prestaciones.id_cantones AND
  parroquias.id_parroquias = solicitud_prestaciones.id_parroquias AND
  bancos.id_bancos = solicitud_prestaciones.id_bancos AND
  sexo.id_sexo = solicitud_prestaciones.id_sexo AND
  solicitud_prestaciones.id_solicitud_prestaciones='$id_solicitud_pretaciones'";
        $id="solicitud_prestaciones.nombres_solicitud_prestaciones";
        
        $rsdatos = $solicitudPrestaciones->getCondiciones($columnas, $tablas, $where, $id);
        
        
        $datos_reporte['APELLIDOS']=$rsdatos[0]->apellidos_solicitud_prestaciones;
        $datos_reporte['NOMBRE']=$rsdatos[0]->nombres_solicitud_prestaciones;
        $datos_reporte['CEDULA']=$rsdatos[0]->cedula_participes;
        $datos_reporte['FECHA_NACIMIENTO']=$rsdatos[0]->fecha_nacimiento_solicitud_prestaciones;
        $datos_reporte['ESTADO_CIVIL']=$rsdatos[0]->nombre_estado_civil;
        $datos_reporte['PROVINCIAS']=$rsdatos[0]->nombre_provincias;
        $datos_reporte['CANTONES']=$rsdatos[0]->nombre_cantones;
        $datos_reporte['PARROQUIAS']=$rsdatos[0]->nombre_parroquias;
        $datos_reporte['BARRIO']=$rsdatos[0]->barrio_solicitud_prestaciones;
        $datos_reporte['CIUDADELA']=$rsdatos[0]->ciudadela_solicitud_prestaciones;
        $datos_reporte['CALLE']=$rsdatos[0]->calle_solicitud_prestaciones;
        $datos_reporte['NUMERO_CALLE']=$rsdatos[0]->numero_calle_solicitud_prestaciones;
        $datos_reporte['INTERSECCION']=$rsdatos[0]->interseccion_solicitud_prestaciones;
        $datos_reporte['TIPO_VIVIENDA']=$rsdatos[0]->tipo_vivienda_solicitud_prestaciones;
        $datos_reporte['VIVIENDA_HIPOTECADA']=$rsdatos[0]->vivienda_hipotecada_solicitud_prestaciones;
        $datos_reporte['REFERENCIA_DIRECCION']=$rsdatos[0]->referencia_dir_solicitud_prestaciones;
        $datos_reporte['TELEFONO']=$rsdatos[0]->telefono_solicitud_prestaciones;
        $datos_reporte['CELULAR']=$rsdatos[0]->celular_solicitud_prestaciones;
        $datos_reporte['CORREO']=$rsdatos[0]->correo_solicitud_prestaciones;
        $datos_reporte['NIVEL_EDUCTIVO']=$rsdatos[0]->nivel_educativo_solicitud_prestaciones;
        $datos_reporte['NOMBRE_REFERENCIA']=$rsdatos[0]->nombres_referencia_familiar;
        $datos_reporte['APELLIDO_REFERENCIA']=$rsdatos[0]->apellidos_referencia_familiar;
        $datos_reporte['PARENTEZCO_REFERENCIA']=$rsdatos[0]->parentesco_referencia_familiar;
        $datos_reporte['PRIMER_TELEFONO']=$rsdatos[0]->primer_telefono_referencia_familiar;
        $datos_reporte['SEGUNDO_TELEFONO']=$rsdatos[0]->segundo_telefono_referencia_familiar;
        $datos_reporte['NOMBRE_REF_PERSONAL']=$rsdatos[0]->nombres_referencia_personal;
        $datos_reporte['APELLIDO_REF_PERSONAL']=$rsdatos[0]->apellidos_referencia_personal;
        $datos_reporte['PARENTEZCO_REF_PERSONAL']=$rsdatos[0]->parentesco_referencia_personal;
        $datos_reporte['PRIMER_TEL_REF_PERSONAL']=$rsdatos[0]->primer_telefono_referencia_personal;
        $datos_reporte['SEGUNDO_TEL_REF_PERSONAL']=$rsdatos[0]->segundo_telefono_referencia_personal;
        $datos_reporte['ULTIMO_CARGO']=$rsdatos[0]->ultimo_cargo_solicitud_prestaciones;
        $datos_reporte['FECHA_SALIDA']=$rsdatos[0]->fecha_salida_solicitud_prestaciones;
        $datos_reporte['BANCO']=$rsdatos[0]->nombre_bancos;
        $datos_reporte['SEXO']=$rsdatos[0]->nombre_sexo;
        $datos_reporte['NUMERO_CUENTA']=$rsdatos[0]->numero_cuenta_bancaria;
        $datos_reporte['FECHA_SOLICITADA']=$rsdatos[0]->creado;
        
        $fechalarga=$rsdatos[0]->creado;
        $fecha=date("Y", $fechalarga);
        
        $datos_reporte['FECHA_SOLI']=$fecha;
        
        
        $this->verReporte("SolicitudPrestaciones", array('datos_reporte'=>$datos_reporte ));
        
        }
        
        
    }
    
    
    
    
    
}
?>