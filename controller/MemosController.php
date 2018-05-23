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
    
    
    
    
    
    public function InsertaMemo(){
    	
    	session_start();
    	
    	$_array_usuarios_to=array();
    	$_array_usuarios_cc=array();
    	$asunto="";
    	$editor_one="";
    	
    	if (isset($_SESSION['nombre_usuarios']) )
    	{
    		$usuarios = new UsuariosModel();
    	
    		$nombre_controladores = "Usuarios";
    		$id_rol= $_SESSION['id_rol'];
    		$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    	
    		if(!empty($resultPer)){
    			
    			if(isset($_POST["enviar"])){
    				
    				
    			$_array_usuarios_to = $_POST['usuarios_to'];
    			$_array_usuarios_cc = $_POST['usuarios_cc'];
    			
    			$asunto =$_POST["asunto"];
    			$editor1 = $_POST["editor1"];
    			
    			
    			
    			
    			DIE($editor1);
    			
    			// FORMAR DESTINATARIOS PARA
    				$count_to=0;
    				$_id_usuarios_to=0;
    				$_correo_usuarios_to="";
    				$_grupo_correos_to="";
    				$_total_registro_to=count($_array_usuarios_to);
    				
    				
    				if($_total_registro_to>0){
    				
    				
    				foreach($_array_usuarios_to as $id  )
    				{
    					$count_to++;
    					$_id_usuarios_to = $id;
    					
    					if($_id_usuarios_to > 0){
    						
    						$resultUsuariosTo = $usuarios->getBy("id_usuarios = '$_id_usuarios_to' ");
    					
    						if(!empty($resultUsuariosTo)){
    							
    							$_correo_usuarios_to=$resultUsuariosTo[0]->correo_usuarios;
    						}
    						
    					}
    					
    					if($count_to==$_total_registro_to){
    						
    						$_grupo_correos_to.= $_correo_usuarios_to;
    					
    					}else{
    						
    						$_grupo_correos_to.= $_correo_usuarios_to.", ";
    					}
    					
    				}	
    			
    				}
    				
    				// TERMINA DESTINATARIOS PARA
    				
    				
    				// TERMINA DESTINATARIOS COPIA
    				
    				$count_cc=0;
    				$_id_usuarios_cc=0;
    				$_correo_usuarios_cc="";
    				$_grupo_correos_cc="";
    				$_total_registro_cc=count($_array_usuarios_cc);
    				
    				
    				
    				if($_total_registro_cc>0){
    				
    				
    					foreach($_array_usuarios_cc as $id  )
    					{
    						$count_cc++;
    						$_id_usuarios_cc = $id;
    							
    						if($_id_usuarios_cc > 0){
    				
    							$resultUsuariosCc = $usuarios->getBy("id_usuarios = '$_id_usuarios_cc' ");
    								
    							if(!empty($resultUsuariosCc)){
    									
    								$_correo_usuarios_cc=$resultUsuariosCc[0]->correo_usuarios;
    							}
    				
    						}
    							
    						if($count_cc==$_total_registro_cc){
    				
    							$_grupo_correos_cc.= $_correo_usuarios_cc;
    								
    						}else{
    				
    							$_grupo_correos_cc.= $_correo_usuarios_cc.", ";
    						}
    							
    					}
    					 
    				}
    				
    				
    				// TERMINA DESTINATARIOS PARA
    			
    			
    			}
    			
    			
    			
    			
    			
    			
    			$this->redirect("Memos","index");
    			
    			
    			 
    		}else{
    			
    			die("ESTIMADO USUARIO AL MOMENTO NO TIENE PERMISOS PARA GENERAR MEMORANDUM EN EL SISTEMA.");
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
