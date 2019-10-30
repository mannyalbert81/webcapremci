<?php

class CreditosSimuladorController extends ControladorBase{
    
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
                
                $this->view("CreditosSimulador",array(
                    
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
    

    
    
}
?>