<?php
class MemosController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function index(){
    
    	session_start();
    	if (isset(  $_SESSION['nombre_usuarios']) )
    	{
    		//Creamos el objeto usuario
    		$rol=new RolesModel();
    		$resultRol = $rol->getAll("nombre_rol");
    		$resultSet="";
    		$estado = new EstadoModel();
    		$resultEst = $estado->getAll("nombre_estado");
    			
    			
    		$departamentos = new DepartamentosModel();
    		$resultDep = $departamentos->getAll("nombre_departamentos");
    			
    		$usuarios = new UsuariosModel();
    
    		$nombre_controladores = "Usuarios";
    		$id_rol= $_SESSION['id_rol'];
    		$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    
    		
    		$resultSet= "";
    		$resultRol = "";
    		$resultEdit="";
    		$resultEst = "";
    		$resultDep = "";
    	    /*
    		$_nombre_usuarios = $_POST["nombre_usuarios"];
    		
    		if (isset ($_POST["btn_to"])   )
    		{
    		
    			if ($_nombre_usuarios != "")
    			{
    				
    				
    			}
    			
    		
    		
    		}
    		*/
    		
    		
    		/*
    		if (!empty($resultPer))
    		{
    				
    				
    			$resultEdit = "";
    				
    			if (isset ($_GET["id_usuarios"])   )
    			{
    
    
    				$columnas = " usuarios.id_usuarios,
								  usuarios.cedula_usuarios,
								  usuarios.nombre_usuarios,
								  usuarios.clave_usuarios,
								  usuarios.pass_sistemas_usuarios,
								  usuarios.telefono_usuarios,
								  usuarios.celular_usuarios,
								  usuarios.correo_usuarios,
								  rol.id_rol,
								  rol.nombre_rol,
								  estado.id_estado,
								  estado.nombre_estado,
								  usuarios.fotografia_usuarios,
								  usuarios.creado,
								  usuarios.cargo_usuarios,
    			                  departamentos.identificador_departamentos,
    							  usuarios.id_departamentos,
    			                  departamentos.nombre_departamentos";
    
    				$tablas   = "public.usuarios,
								  public.rol,
								  public.estado,
								  public.departamentos";
    
    				$id       = "usuarios.id_usuarios";
    
    				$_id_usuarios = $_GET["id_usuarios"];
    				$where    = "rol.id_rol = usuarios.id_rol AND estado.id_estado = usuarios.id_estado AND usuarios.id_usuarios = '$_id_usuarios' AND usuarios.id_departamentos = departamentos.id_departamentos ";
    				$resultEdit = $usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
    			}
    				
    				
    			$this->view("Usuarios",array(
    					"resultSet"=>$resultSet, "resultRol"=>$resultRol, "resultEdit" =>$resultEdit, "resultEst"=>$resultEst, "resultDep"=>$resultDep
    
    			));
    
    		}
    		else
    		{
    			$this->view("Error",array(
    					"resultado"=>"No tiene Permisos de Acceso a Usuarios"
		
    			));
    				
    		}
    		*/	
    		
    		$this->view("Memos",array(
    				"resultSet"=>$resultSet, "resultRol"=>$resultRol, "resultEdit" =>$resultEdit, "resultEst"=>$resultEst, "resultDep"=>$resultDep
    		
    		));
    
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
    	$resultPol = $usuarios->getCondiciones("nombre_usuarios",
    			"usuarios",
    			"  UPPER(nombre_usuarios) LIKE '%$nombre_usuario%'  AND   (id_rol = 43 OR id_rol = 44 OR id_rol = 45 OR id_rol = 1) ",
    			"nombre_usuarios");
    
    
    	if(!empty($resultPol)){
    
    		foreach ($resultPol as $res){
    
    			$_nombre_usuario[] = array('id' => $res->nombre_usuarios, 'value' => $res->nombre_usuarios);
    		}
    		//echo json_encode($_ruc_cliente);
    
    	}else
    	{
    		//echo json_encode(array(array('id' =>'0,NO DATA', 'value' =>'NO DATA')));
    		$_nombre_usuario = array(array('id' =>'', 'value' =>'--TODOS--'));
    	}
    
    	echo  json_encode($_nombre_usuario);
    }
    
	
}
?>
