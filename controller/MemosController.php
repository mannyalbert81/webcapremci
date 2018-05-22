<?php
class MemosController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function index(){
    
    	session_start();
    	if (isset(  $_SESSION['nombre_usuarios']) )
    	{
    		
    		$usuarios = new UsuariosModel();
    
    		$nombre_controladores = "Usuarios";
    		$id_rol= $_SESSION['id_rol'];
    		$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    
    		
    		if(!empty($resultPer)){
    		
    		$this->view("Memos",array(
    				"resultSet"=>""
    		
    		));
    		
    		}else{
    			
    			
    		}
    
    	}
    	else{
    
    		$this->redirect("Usuarios","sesion_caducada");
    
    	}
    
    }
    
    
    
    
    
    
    
    
    
    public function addindex(){
    
    	session_start();
    	if (isset($_SESSION['nombre_usuarios']) )
    	{	 
    		$usuarios = new UsuariosModel();
    
    		$nombre_controladores = "Usuarios";
    		$id_rol= $_SESSION['id_rol'];
    		$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    
    		if(!empty($resultPer)){
    			
    			$this->view("MemosComponer",array(
    					"resultSet"=>""
    			
    			));
    			
    	     }else{
    			
    		 }
    		 
	    	}
	    	else{
	    
	    		$this->redirect("Usuarios","sesion_caducada");
	    
	    	}
    
    	}
    
    
    
    	


    	public function sentindex(){
    	
    		session_start();
    		if (isset($_SESSION['nombre_usuarios']) )
    		{
    			$usuarios = new UsuariosModel();
    	
    			$nombre_controladores = "Usuarios";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    	
    			if(!empty($resultPer)){
    				 
    				$this->view("MemosEnviados",array(
    						"resultSet"=>""
    
    				));
    				 
    			}else{
    				 
    			}
    			 
    		}
    		else{
    		  
    			$this->redirect("Usuarios","sesion_caducada");
    		  
    		}
    	
    	}
    	
    	
    	
    	
    	
    	
    	public function draftindex(){
    		 
    		session_start();
    		if (isset($_SESSION['nombre_usuarios']) )
    		{
    			$usuarios = new UsuariosModel();
    			 
    			$nombre_controladores = "Usuarios";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    			 
    			if(!empty($resultPer)){
    					
    				$this->view("MemosBorrador",array(
    						"resultSet"=>""
    	
    				));
    					
    			}else{
    					
    			}
    	
    		}
    		else{
    	
    			$this->redirect("Usuarios","sesion_caducada");
    	
    		}
    		 
    	}
    	
    	
    	
    	
    	public function junkindex(){
    		 
    		session_start();
    		if (isset($_SESSION['nombre_usuarios']) )
    		{
    			$usuarios = new UsuariosModel();
    	
    			$nombre_controladores = "Usuarios";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    	
    			if(!empty($resultPer)){
    					
    				$this->view("MemosBasura",array(
    						"resultSet"=>""
   
    				));
    					
    			}else{
    					
    			}
    			 
    		}
    		else{
    			 
    			$this->redirect("Usuarios","sesion_caducada");
    			 
    		}
    		 
    	}
    	
    	
    	
    	
    	
    	public function trashindex(){
    		 
    		session_start();
    		if (isset($_SESSION['nombre_usuarios']) )
    		{
    			$usuarios = new UsuariosModel();
    			 
    			$nombre_controladores = "Usuarios";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    			 
    			if(!empty($resultPer)){
    					
    				$this->view("MemosEliminados",array(
    						"resultSet"=>""
    				));
    					
    			}else{
    					
    			}
    	
    		}
    		else{
    	
    			$this->redirect("Usuarios","sesion_caducada");
    	
    		}
    		 
    	}
	
    public function AutocompleteDirectorio(){
    
    	session_start();
    
    	$nombre_usuario = strtoupper($_GET['term']);
    	$_nombre_usuario = array();
    
    	$usuarios = new UsuariosModel();
    
    
    	//Tipo de Documento
    	$resultPol = $usuarios->getCondiciones("nombre_usuarios, id_usuarios",
    			"usuarios",
    			"  UPPER(nombre_usuarios) LIKE '%$nombre_usuario%'  AND   (id_rol = 43 OR id_rol = 44 OR id_rol = 45 OR id_rol = 1) ",
    			"nombre_usuarios");
    
    
    	if(!empty($resultPol)){
    
    		foreach ($resultPol as $res){
    
    			$_nombre_usuario[] = array('id' => $res->id_usuarios, 'value' => $res->nombre_usuarios);
    		}
    		//echo json_encode($_ruc_cliente);
    
    	}else
    	{
    		//echo json_encode(array(array('id' =>'0,NO DATA', 'value' =>'NO DATA')));
    		$_nombre_usuario = array(array('id' =>'', 'value' =>'No Existen Concidencias de '.$nombre_usuario.''));
    	}
    
    	echo  json_encode($_nombre_usuario);
    }
    
	
}
?>
