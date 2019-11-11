<?php

class SolicitudValorAportacionesController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    //maycol
    
    public function index(){
        
        session_start();
        
   
        
        if (isset($_SESSION['nombre_usuarios']))
        {
            $SolicitudPrestaciones = new SolicitudPrestacionesModel();
            $nombre_controladores = "SolicitudAportes";
            $id_rol= $_SESSION['id_rol'];
            $resultPer = $SolicitudPrestaciones->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
            
            if (!empty($resultPer))
            {
               $cedula= array();
               
               $cedula_participe = $_SESSION['cedula_usuarios'];
               array_push($cedula, $cedula_participe);
               
               
               
                
               $this->view("SolicitudValorAportaciones",array("cedula"=>$cedula
                    
                   
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