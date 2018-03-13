<?php
class UsuariosController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    
    
    
    public function index10(){
    	 
    	session_start();
    	$usuarios = new UsuariosModel();
    	$where_to="";
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
								  usuarios.creado";
    		
    	$tablas   = "public.usuarios,
								  public.rol,
								  public.estado";
    		
    	$where    = " rol.id_rol = usuarios.id_rol AND
								  estado.id_estado = usuarios.id_estado";
    		
    	$id       = "usuarios.id_usuarios";
    		
    	
    	
    	
    	
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    	
    	
    	
    	
    	if($action == 'ajax')
    	{
    		
    		if(!empty($search)){
    			 
    			 
    			$where1=" AND (usuarios.cedula_usuarios LIKE '".$search."%' OR usuarios.nombre_usuarios LIKE '".$search."%' OR usuarios.correo_usuarios LIKE '".$search."%' OR rol.nombre_rol LIKE '".$search."%' OR estado.nombre_estado LIKE '".$search."%')";
    			 
    			$where_to=$where.$where1;
    		}else{
    		
    			$where_to=$where;
    			 
    		}
    		
    		$html="";
    		$resultSet=$usuarios->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    		
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    		
    		$per_page = 50; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    		
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    		
    		$resultSet=$usuarios->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
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
    		$html.= "<table id='tabla_usuarios' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
    		$html.= "<thead>";
    		$html.= "<tr>";
    		$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    		$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    		$html.='<th style="text-align: left;  font-size: 12px;">Cedula</th>';
    		$html.='<th style="text-align: left;  font-size: 12px;">Nombre</th>';
    		$html.='<th style="text-align: left;  font-size: 12px;">Teléfono</th>';
    		$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
    		$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
    		$html.='<th style="text-align: left;  font-size: 12px;">Rol</th>';
    		$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
    		$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    		$html.='<th style="text-align: left;  font-size: 12px;"></th>';
    		$html.='</tr>';
    		$html.='</thead>';
    		$html.='<tbody>';
    		 
    		$i=0;
    		
    		foreach ($resultSet as $res)
    		{
    			$i++;
    			$html.='<tr>';
    			$html.='<td style="font-size: 11px;"><img src="view/DevuelveImagenView.php?id_valor='.$res->id_usuarios.'&id_nombre=id_usuarios&tabla=usuarios&campo=fotografia_usuarios" width="80" height="60"></td>';
    			$html.='<td style="font-size: 11px;">'.$i.'</td>';
    			$html.='<td style="font-size: 11px;">'.$res->cedula_usuarios.'</td>';
    			$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
    			$html.='<td style="font-size: 11px;">'.$res->telefono_usuarios.'</td>';
    			$html.='<td style="font-size: 11px;">'.$res->celular_usuarios.'</td>';
    			$html.='<td style="font-size: 11px;">'.$res->correo_usuarios.'</td>';
    			$html.='<td style="font-size: 11px;">'.$res->nombre_rol.'</td>';
    			$html.='<td style="font-size: 11px;">'.$res->nombre_estado.'</td>';
    			$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Usuarios&action=index&id_usuarios='.$res->id_usuarios.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
    			$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=Usuarios&action=borrarId&id_usuarios='.$res->id_usuarios.'" class="btn btn-danger" style="font-size:65%;"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
    			
    			$html.='</tr>';
    		}
    		
    		
    		$html.='</tbody>';
    		$html.='</table>';
    		$html.='</section></div>';
    		$html.='<div class="table-pagination pull-right">';
    		$html.=''. $this->paginate("index.php", $page, $total_pages, $adjacents).'';
    		$html.='</div>';
    		
    		
    	
    
    		 
    	}else{
    		$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    		$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    		$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    		$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay usuarios registrados...</b>';
    		$html.='</div>';
    		$html.='</div>';
    	}
    	
    	
    	
    	 
    	echo $html;
    	die();
    	 
    	} 
    	 
    	 
    	 
    	 
    	 
    }
    
    

 
    
    
    public function cargar_global_usuarios(){
    
    	session_start();
    	 
    	$i=0;
    	$usuarios = new UsuariosModel();
    	$columnas = "usuarios.cedula_usuarios";
    	
    	$tablas   = "public.usuarios";
    	
    	$where    = " 1=1";
    	
    	$id       = "usuarios.id_usuarios";
    
    
    
    	$resultSet = $usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
    
    	$i=count($resultSet);
    
    	$html="";
    	if($i>0)
    	{
    
    		$html .= "<div class='col-lg-3 col-xs-12'>";
    		$html .= "<div class='small-box bg-green'>";
    		$html .= "<div class='inner'>";
    		$html .= "<h3>$i</h3>";
    		$html .= "<p>Usuarios Registrados.</p>";
    		$html .= "</div>";
    
    
    		$html .= "<div class='icon'>";
    		$html .= "<i class='ion ion-person-add'></i>";
    		$html .= "</div>";
    		$html .= "<a href='index.php?controller=Usuarios&action=index' class='small-box-footer'>Operaciones con usuarios <i class='fa fa-arrow-circle-right'></i></a>";
    		$html .= "</div>";
    		$html .= "</div>";
    
    
    	}else{
    		 
    		$html = "<b>Actualmente no hay usuarios registrados...</b>";
    	}
    
    	echo $html;
    	die();
    
    
    
    
    
    
    
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
			
			$usuarios = new UsuariosModel();

			$nombre_controladores = "Usuarios";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
				
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
								  usuarios.creado";
						
						$tablas   = "public.usuarios,
								  public.rol,
								  public.estado";
						
						$id       = "usuarios.id_usuarios";
						
						$_id_usuarios = $_GET["id_usuarios"];
						$where    = "rol.id_rol = usuarios.id_rol AND estado.id_estado = usuarios.id_estado AND usuarios.id_usuarios = '$_id_usuarios' "; 
						$resultEdit = $usuarios->getCondiciones($columnas ,$tablas ,$where, $id); 
					}
			
					
					$this->view("Usuarios",array(
							"resultSet"=>$resultSet, "resultRol"=>$resultRol, "resultEdit" =>$resultEdit, "resultEst"=>$resultEst
				
					));
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Usuarios"
			
				));
			
			}
			
		
		}
		else 
		{
			$this->view("ErrorSesion",array(
					"resultSet"=>""
		
			));
			
		}
		
	}
	
	
	
	
	
	public function llenar_fotografia_usuarios(){
	
		session_start();
		$resultado = null;
		$usuarios=new UsuariosModel();
	
	
		
		if ($_FILES['fotografia_usuarios']['tmp_name']!="")
		{
	
		$columnas = "usuarios.cedula_usuarios,
	   			     usuarios.pass_sistemas_usuarios";
			
		$tablas   = "public.usuarios";
			
		$where    = "1=1";
			
		$id       = "usuarios.id_usuarios";
			
		$resultSet=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
	
	
		$directorio = $_SERVER['DOCUMENT_ROOT'].'/template_2018/fotografias_usuarios/';
		 
		$nombre = $_FILES['fotografia_usuarios']['name'];
		$tipo = $_FILES['fotografia_usuarios']['type'];
		$tamano = $_FILES['fotografia_usuarios']['size'];
		 
		move_uploaded_file($_FILES['fotografia_usuarios']['tmp_name'],$directorio.$nombre);
		$data = file_get_contents($directorio.$nombre);
		$imagen_usuarios = pg_escape_bytea($data);
		 
		 
		
	
		if(!empty($resultSet)){
				
			foreach ($resultSet as $res){
	
				$cedula=$res->cedula_usuarios;
				
				$colval = "fotografia_usuarios='$imagen_usuarios'";
				$tabla = "usuarios";
				$where = "cedula_usuarios = '$cedula'";
				$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
	
	
			}
				
		}
		
		
		
		$this->redirect("Roles", "index");
		
	 }
	 
	 
	 $this->view("SubirFotosUsuarios",array(
	 		"resultSet"=>""
	 
	 ));
	 
	
	}
	
	
	
	public function encriptar_maycol_postgres(){
		
		session_start();
		$resultado = null;
		$usuarios=new UsuariosModel();
		
		
		
		$columnas = "usuarios.cedula_usuarios,
	   			     usuarios.pass_sistemas_usuarios";
			
		$tablas   = "public.usuarios";
			
		$where    = "1=1 AND usuarios.cedula_usuarios='1750402859'";
			
		$id       = "usuarios.id_usuarios";
			
		$resultSet=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
		
		
		
		if(!empty($resultSet)){
			
			foreach ($resultSet as $res){
				
				$cedula=$res->cedula_usuarios;
				$clave_usuarios = $usuarios->encriptar($res->pass_sistemas_usuarios);
				
				
				$colval = "cedula_usuarios= '$cedula', clave_usuarios='$clave_usuarios'";
				$tabla = "usuarios";
				$where = "cedula_usuarios = '$cedula'";
				$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
				
				
			}
			
		}
		
		$this->redirect("Roles", "index");
		
	}
	
	
	
	public function InsertaUsuarios(){
			
		session_start();
		$resultado = null;
		$usuarios=new UsuariosModel();
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
		if (isset ($_POST["cedula_usuarios"]))
		{
			$_cedula_usuarios    = $_POST["cedula_usuarios"];
			$_nombre_usuarios     = $_POST["nombre_usuarios"];
			//$_usuario_usuario     = $_POST["usuario_usuario"];
			$_clave_usuarios      = $usuarios->encriptar($_POST["clave_usuarios"]);
			$_pass_sistemas_usuarios      = $_POST["clave_usuarios"];
			$_telefono_usuarios   = $_POST["telefono_usuarios"];
			$_celular_usuarios    = $_POST["celular_usuarios"];
			$_correo_usuarios     = $_POST["correo_usuarios"];
		    $_id_rol             = $_POST["id_rol"];
		    $_id_estado          = $_POST["id_estado"];
		    
		    $_id_usuarios          = $_POST["id_usuarios"];
		    
		    
		    if($_id_usuarios > 0){
		    	
		    	
		    	if ($_FILES['fotografia_usuarios']['tmp_name']!="")
		    	{
		    			
		    		$directorio = $_SERVER['DOCUMENT_ROOT'].'/template_2018/fotografias_usuarios/';
		    			
		    		$nombre = $_FILES['fotografia_usuarios']['name'];
		    		$tipo = $_FILES['fotografia_usuarios']['type'];
		    		$tamano = $_FILES['fotografia_usuarios']['size'];
		    			
		    		move_uploaded_file($_FILES['fotografia_usuarios']['tmp_name'],$directorio.$nombre);
		    		$data = file_get_contents($directorio.$nombre);
		    		$imagen_usuarios = pg_escape_bytea($data);
		    			
		    			
		    		$colval = "cedula_usuarios= '$_cedula_usuarios', nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios', id_rol = '$_id_rol', id_estado = '$_id_estado', fotografia_usuarios ='$imagen_usuarios'";
		    		$tabla = "usuarios";
		    		$where = "id_usuarios = '$_id_usuarios'";
		    		$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
		    			
		    	}
		    	else
		    	{
		    	
		    		$colval = "cedula_usuarios= '$_cedula_usuarios', nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios', id_rol = '$_id_rol', id_estado = '$_id_estado'";
		    		$tabla = "usuarios";
		    		$where = "id_usuarios = '$_id_usuarios'";
		    		$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
		    	
		    	}
		    	
		    	
		    	
		    }else{
		    
		    	
		    	
		    	
		    if ($_FILES['fotografia_usuarios']['tmp_name']!="")
		    {
		    
		    	$directorio = $_SERVER['DOCUMENT_ROOT'].'/template_2018/fotografias_usuarios/';
		    
		    	$nombre = $_FILES['fotografia_usuarios']['name'];
		    	$tipo = $_FILES['fotografia_usuarios']['type'];
		    	$tamano = $_FILES['fotografia_usuarios']['size'];
		    	
		    	move_uploaded_file($_FILES['fotografia_usuarios']['tmp_name'],$directorio.$nombre);
		    	$data = file_get_contents($directorio.$nombre);
		    	$imagen_usuarios = pg_escape_bytea($data);
		    
		    
		    	$funcion = "ins_usuarios";
		    	$parametros = "'$_cedula_usuarios',
		    				   '$_nombre_usuarios',
		    				   '$_clave_usuarios',
		    	               '$_pass_sistemas_usuarios',
		    	               '$_telefono_usuarios',
		    	               '$_celular_usuarios',
		    	               '$_correo_usuarios',
		    	               '$_id_rol',
		    	               '$_id_estado',
		    	               '$imagen_usuarios'";
		    	$usuarios->setFuncion($funcion);
		    	$usuarios->setParametros($parametros);
		    	$resultado=$usuarios->Insert();
		    
		    }
		    else
		    {
		    
		    	$where_TO = "cedula_usuarios = '$_cedula_usuarios'";
		    	$result=$usuarios->getBy($where_TO);
		    	 
		    	if ( !empty($result) )
		    	{
		    		 
		    		$colval = "nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios', id_rol = '$_id_rol', id_estado = '$_id_estado'";
		    		$tabla = "usuarios";
		    		$where = "cedula_usuarios = '$_cedula_usuarios'";
		    		$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
		    	}
		        else{
		        	
		        	$imagen_usuarios="";
		        	
		        	$funcion = "ins_usuarios";
		        	$parametros = "'$_cedula_usuarios',
		        	'$_nombre_usuarios',
		        	'$_clave_usuarios',
		        	'$_pass_sistemas_usuarios',
		        	'$_telefono_usuarios',
		        	'$_celular_usuarios',
		        	'$_correo_usuarios',
		        	'$_id_rol',
		        	'$_id_estado',
		        	'$imagen_usuarios'";
		        	$usuarios->setFuncion($funcion);
		        	$usuarios->setParametros($parametros);
		        	$resultado=$usuarios->Insert();
		    	}
		    
		    }
		  }
		  
		  
		  
		  $participes = new ParticipeModel();
		  	
		  if($_correo_usuarios!=""){
		  	
		  	try {
		  		$colval1 = "nombre= '$_nombre_usuarios',
		  		correo='$_correo_usuarios',
		  		telefono = '$_telefono_usuarios',
		  		celular = '$_celular_usuarios',
		  		id_estado= '$_id_estado'";
		  		
		  		$tabla1 = "afiliado_extras";
		  		
		  		$where1 = "cedula = '$_cedula_usuarios'";
		  		
		  		$resultado=$participes->UpdateBy($colval1, $tabla1, $where1);
		  		
		  	} catch (Exception $e) {
		  	}
		  	
		  	
		  }
		  
		  
		  
		    $this->redirect("Usuarios", "index");
		}
		
	   }else{
	   	
	   	$error = TRUE;
	   	$mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
	   		
	   	$this->view("Login",array(
	   			"resultSet"=>"$mensaje", "error"=>$error
	   	));
	   		
	   		
	   	die();
	   	
	   }
	}
	
	public function borrarId()
	{
		if(isset($_GET["id_usuarios"]))
		{
			$id_usuario=(int)$_GET["id_usuarios"];
	
			$usuarios=new UsuariosModel();
				
			$sesiones= new SesionesModel();
			$sesiones->deleteBy(" id_usuarios",$id_usuario);
			$usuarios->deleteBy(" id_usuarios",$id_usuario);
				
				
		}
	
		$this->redirect("Usuarios", "index");
	}
	
	
	public function resetear_clave()
	{

		session_start();
		$_usuario_usuario = "";
		$_clave_usuario = "";
		$usuarios = new UsuariosModel();
		$error = FALSE;
		
		
		$mensaje = "";
		
		if (isset($_POST['cedula_usuarios']))
		{
			$_cedula_usuarios = $_POST['cedula_usuarios'];
		
			$where = "cedula_usuarios = '$_cedula_usuarios'   ";
			$resultUsu = $usuarios->getBy($where);
			
			if(!empty($resultUsu))
			{
				foreach ($resultUsu as $res){
					
					$correo_usuario=$res->correo_usuarios;
				}
				
				
				$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
				$longitudCadena=strlen($cadena);
				$pass = "";
				$longitudPass=10;
				for($i=1 ; $i<=$longitudPass ; $i++){
					$pos=rand(0,$longitudCadena-1);
					$pass .= substr($cadena,$pos,1);
				}
				$_clave_usuario= $pass;
				$_encryp_pass = $usuarios->encriptar($_clave_usuario);
				$usuarios->UpdateBy("clave_usuarios = '$_encryp_pass', pass_sistemas_usuarios='$_clave_usuario'", "usuarios", "cedula_usuarios = '$_cedula_usuarios'  ");
					
			}
				
			if ($_clave_usuario == "")
			{
				$mensaje = "Este Usuario no existe resgistrado en nuestro sistema.";
		
				$error = TRUE;
		
			}
			else
			{
		
				$cabeceras = "MIME-Version: 1.0 \r\n";
				$cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
				$cabeceras.= "From: info@capremci.com.ec \r\n";
				$destino="$correo_usuario";
				$asunto="Claves de Acceso Capremci";
				$fecha=date("d/m/y");
				$hora=date("H:i:s");
		
				
				$resumen="
				<table rules='all'>
				<tr><td WIDTH='1000' HEIGHT='50'><center><img src='http://www.capremci.com.ec/www2/wp-content/uploads/2016/10/Logo-Capremci-h-600.jpg' WIDTH='300' HEIGHT='90'/></center></td></tr>
				</tabla>
				<p><table rules='all'></p>
				<tr style='background: #FFFFFF;'><td  WIDTH='1000' align='center'><b> BIENVENIDO A CAPREMCI </b></td></tr></p>
				<tr style='background: #FFFFFF;'><td  WIDTH='1000' align='justify'>Somos un Fondo Previsional orientado a asegurar el futuro de sus partícipes, prestando servicios complementarios para satisfacer sus necesidades; con infraestructura tecnológica – operativa de vanguardia y talento humano competitivo.</td></tr>
				</tabla>
				<p><table rules='all'></p>
				<tr style='background: #FFFFFF'><td WIDTH='1000' align='center'><b> TUS DATOS DE ACCESO SON: </b></td></tr>
				<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Usuario:</b> $_cedula_usuarios</td></tr>
				<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Clave Temporal:</b> $_clave_usuario </td></tr>
				</tabla>
				<p><table rules='all'></p>
				<tr style='background:#1C1C1C'><td WIDTH='1000' HEIGHT='50' align='center'><font color='white'>Capremci - <a href='http://www.capremci.com.ec'><FONT COLOR='#7acb5a'>www.capremci.com.ec</FONT></a> - Copyright © 2018-</font></td></tr>
				</table>
				";
		
				
		
				if(mail("$destino","Claves de Acceso Capremci","$resumen","$cabeceras"))
				{
					$mensaje = "Te hemos enviado un correo electrónico con tus datos de acceso.";
					
		
				}else{
					$mensaje = "No se pudo enviar el correo con la informacion. Intentelo nuevamente.";
					$error = TRUE;
		
				}
					
			}
				
		}
		
		$this->view("ResetUsuarios",array(
				"resultSet"=>$mensaje , "error"=>$error
		));
		
	}
	
	
	
	public function resetear_password()
	{
		session_start();
		$_usuario_usuario = "";
		$_clave_usuario = "";
		$usuarios = new UsuariosModel();
		$error = FALSE;
	
	
		$mensaje = "";
	
		if (isset($_POST['cedula_usuarios']))
		{
			$_cedula_usuarios = $_POST['cedula_usuarios'];
	
			$where = "cedula_usuarios = '$_cedula_usuarios'   ";
			$resultUsu = $usuarios->getBy($where);
	
			if(!empty($resultUsu))
			{
	
				foreach ($resultUsu as $res){
	
					$correo_usuario=$res->correo_usuarios;
					$id_estado=$res->id_estado;
					$nombre_usuario   = $res->nombre_usuarios;
					$_clave_usuario= $res->pass_sistemas_usuarios;
				}
	
	
				
					
			}
	
			if ($_clave_usuario == "")
			{
				$mensaje = "Este Usuario no existe resgistrado en nuestro sistema.";
	
				$error = TRUE;
	
	
			}
			else
			{
	
	
				if($id_estado==1){
	
						
						
					$cabeceras = "MIME-Version: 1.0 \r\n";
					$cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
					$cabeceras.= "From: info@capremci.com.ec \r\n";
					$destino="$correo_usuario";
					$asunto="Claves de Acceso Capremci";
					$fecha=date("d/m/y");
					$hora=date("H:i:s");
	
	
					$resumen="
					<table rules='all'>
					<tr><td WIDTH='1000' HEIGHT='50'><center><img src='http://www.capremci.com.ec/www2/wp-content/uploads/2016/10/Logo-Capremci-h-600.jpg' WIDTH='300' HEIGHT='90'/></center></td></tr>
					</tabla>
					<p><table rules='all'></p>
					<tr style='background: #FFFFFF;'><td  WIDTH='1000' align='center'><b> BIENVENIDO A CAPREMCI </b></td></tr></p>
					<tr style='background: #FFFFFF;'><td  WIDTH='1000' align='justify'>Somos un Fondo Previsional orientado a asegurar el futuro de sus partícipes, prestando servicios complementarios para satisfacer sus necesidades; con infraestructura tecnológica – operativa de vanguardia y talento humano competitivo.</td></tr>
					</tabla>
					<p><table rules='all'></p>
					<tr style='background: #FFFFFF'><td WIDTH='1000' align='center'><b> TUS DATOS DE ACCESO SON: </b></td></tr>
					<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Usuario:</b> $_cedula_usuarios</td></tr>
					<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Clave Temporal:</b> $_clave_usuario </td></tr>
					</tabla>
					<p><table rules='all'></p>
					<tr style='background:#1C1C1C'><td WIDTH='1000' HEIGHT='50' align='center'><font color='white'>Capremci - <a href='http://www.capremci.com.ec'><FONT COLOR='#7acb5a'>www.capremci.com.ec</FONT></a> - Copyright © 2018-</font></td></tr>
					</table>
					";
	
	
					if(mail("$destino","Claves de Acceso Capremci","$resumen","$cabeceras"))
					{
						$mensaje = "Te hemos enviado un correo electrónico a $correo_usuario con tus datos de acceso.";
	
	
					}else{
						$mensaje = "No se pudo enviar el correo con la informacion. Intentelo nuevamente.";
						$error = TRUE;
	
					}
						
	
				}else{
						
						
					$error = TRUE;
					$mensaje = "Hola $nombre_usuario tu usuario se encuentra inactivo.";
	
	
					$this->view("Login",array(
							"resultSet"=>"$mensaje", "error"=>$error
					));
	
	
					die();
						
						
						
				}
					
					
					
					
			}
	
			$this->view("Login",array(
					"resultSet"=>"$mensaje", "error"=>$error
			));
	
	
			die();
				
		}else{
				
			$mensaje = "Ingresa tu cedula para recuperar tu clave.";
			$error = TRUE;
		}
	
	
	
		$this->view("ResetUsuariosInicio",array(
				"resultSet"=>$mensaje , "error"=>$error
		));
	
	}
	
	
	
	public function resetear_clave_inicio()
	{
		session_start();
		$_usuario_usuario = "";
		$_clave_usuario = "";
		$usuarios = new UsuariosModel();
		$error = FALSE;
	
	
		$mensaje = "";
	
		if (isset($_POST['cedula_usuarios']))
		{
			$_cedula_usuarios = $_POST['cedula_usuarios'];
	
			$where = "cedula_usuarios = '$_cedula_usuarios'   ";
			$resultUsu = $usuarios->getBy($where);
				
			if(!empty($resultUsu))
			{
	
				foreach ($resultUsu as $res){
						
					$correo_usuario=$res->correo_usuarios;
					$id_estado=$res->id_estado;
					$nombre_usuario   = $res->nombre_usuarios;
				}
	
	
				$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
				$longitudCadena=strlen($cadena);
				$pass = "";
				$longitudPass=10;
				for($i=1 ; $i<=$longitudPass ; $i++){
					$pos=rand(0,$longitudCadena-1);
					$pass .= substr($cadena,$pos,1);
				}
				$_clave_usuario= $pass;
				$_encryp_pass = $usuarios->encriptar($_clave_usuario);
					
			}
	
			if ($_clave_usuario == "")
			{
				$mensaje = "Este Usuario no existe resgistrado en nuestro sistema.";
	
				$error = TRUE;
	
	
			}
			else
			{
	
				
				if($id_estado==1){
				
				$usuarios->UpdateBy("clave_usuarios = '$_encryp_pass', pass_sistemas_usuarios='$_clave_usuario'", "usuarios", "cedula_usuarios = '$_cedula_usuarios'  ");
					
					
				$cabeceras = "MIME-Version: 1.0 \r\n";
				$cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
				$cabeceras.= "From: info@capremci.com.ec \r\n";
				$destino="$correo_usuario";
				$asunto="Claves de Acceso Capremci";
				$fecha=date("d/m/y");
				$hora=date("H:i:s");
	
	
				$resumen="
				<table rules='all'>
				<tr><td WIDTH='1000' HEIGHT='50'><center><img src='http://www.capremci.com.ec/www2/wp-content/uploads/2016/10/Logo-Capremci-h-600.jpg' WIDTH='300' HEIGHT='90'/></center></td></tr>
				</tabla>
				<p><table rules='all'></p>
				<tr style='background: #FFFFFF;'><td  WIDTH='1000' align='center'><b> BIENVENIDO A CAPREMCI </b></td></tr></p>
				<tr style='background: #FFFFFF;'><td  WIDTH='1000' align='justify'>Somos un Fondo Previsional orientado a asegurar el futuro de sus partícipes, prestando servicios complementarios para satisfacer sus necesidades; con infraestructura tecnológica – operativa de vanguardia y talento humano competitivo.</td></tr>
				</tabla>
				<p><table rules='all'></p>
				<tr style='background: #FFFFFF'><td WIDTH='1000' align='center'><b> TUS DATOS DE ACCESO SON: </b></td></tr>
				<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Usuario:</b> $_cedula_usuarios</td></tr>
				<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Clave Temporal:</b> $_clave_usuario </td></tr>
				</tabla>
				<p><table rules='all'></p>
				<tr style='background:#1C1C1C'><td WIDTH='1000' HEIGHT='50' align='center'><font color='white'>Capremci - <a href='http://www.capremci.com.ec'><FONT COLOR='#7acb5a'>www.capremci.com.ec</FONT></a> - Copyright © 2018-</font></td></tr>
				</table>
				";
	
	
				if(mail("$destino","Claves de Acceso Capremci","$resumen","$cabeceras"))
				{
					$mensaje = "Te hemos enviado un correo electrónico a $correo_usuario con tus datos de acceso.";
						
	
				}else{
					$mensaje = "No se pudo enviar el correo con la informacion. Intentelo nuevamente.";
					$error = TRUE;
	
				}
			
				
				}else{
					
					
					$error = TRUE;
					$mensaje = "Hola $nombre_usuario tu usuario se encuentra inactivo.";
						
						
					$this->view("Login",array(
							"resultSet"=>"$mensaje", "error"=>$error
					));
						
						
					die();
					
					
					
				}
			
			
			
			
			}
			 
			$this->view("Login",array(
					"resultSet"=>"$mensaje", "error"=>$error
			));
			 
			 
			die();
			
		}else{
			
			$mensaje = "Ingresa tu cedula para recuperar tu clave.";
			$error = TRUE;
		}
	
	
	
		$this->view("ResetUsuariosInicio",array(
				"resultSet"=>$mensaje , "error"=>$error
		));
	
	}
	
	public function Inicio(){
	
		session_start();
		
		$this->view("Login",array(
				"allusers"=>""
		));
	}
    
    
    public function Login(){
    
    	session_destroy();
    	$usuarios=new UsuariosModel();
    
    	//Conseguimos todos los usuarios
    	$allusers=$usuarios->getLogin();
    	 
    	//Cargamos la vista index y l e pasamos valores
    	$this->view("Login",array(
    			"allusers"=>$allusers
    	));
    }
    public function Bienvenida(){
    
    	session_start();
    	
    	if(isset($_SESSION['id_usuarios']))
    	{
    		$_usuario=$_SESSION['nombre_usuarios'];
    		$_id_rol=$_SESSION['id_rol'];
    		
    		if($_id_rol==1){
    				
    		
    			$this->view("BienvenidaAdmin",array(
    					"allusers"=>$_usuario
    			));
    				
    			die();
    				
    		}else{
    				
    			$this->view("Bienvenida",array(
    					"allusers"=>$_usuario
    			));
    		
    			die();
    				
    		}
    		
    		 
    	}else{
    	
    		$this->view("Login",array(
    				"allusers"=>""
    		));
    	}
    }
    
    
    
    
    public function Loguear(){
    	
    	$error=FALSE;
    	if (isset($_POST["usuario"]) && ($_POST["clave"] ) )
    	{
    	
    		
    		$usuarios=new UsuariosModel();
    		$_usuario = $_POST["usuario"];
    		$_clave =   $usuarios->encriptar($_POST["clave"]);
    		
    		 
    		
    		$where = "cedula_usuarios = '$_usuario' AND  clave_usuarios ='$_clave'";
    	
    		$result=$usuarios->getBy($where);

    		$usuario_usuario = "";
    		$id_rol  = "";
    		$nombre_usuario = "";
    		$correo_usuario = "";
    		$ip_usuario = "";
    		
    		if ( !empty($result) )
    		{ 
    			foreach($result as $res) 
    			{
    				$id_usuario  = $res->id_usuarios;
    			    $usuario_usuario  = $res->usuario_usuario;
	    			$id_rol           = $res->id_rol;
	    			$nombre_usuario   = $res->nombre_usuarios;
	    			$correo_usuario   = $res->correo_usuarios;
	    			$id_estado        = $res->id_estado;
	    			$cedula_usuarios        = $res->cedula_usuarios;
	    			
    			}	
    			
    			if($id_estado==1){
    				
    				
    				//obtengo ip
    				$ip_usuario = $usuarios->getRealIP();
    				 
    				 
    				///registro sesion
    				$usuarios->registrarSesion($id_usuario, $usuario_usuario, $id_rol, $nombre_usuario, $correo_usuario, $ip_usuario, $cedula_usuarios);
    				 
    				//inserto en la tabla
    				$_id_usuario = $_SESSION['id_usuarios'];
    				 
    				$sesiones = new SesionesModel();
    				
    				$funcion = "ins_sesiones";
    				 
    				$parametros = " '$_id_usuario' ,'$ip_usuario' ";
    				$sesiones->setFuncion($funcion);
    				
    				$_id_rol=$_SESSION['id_rol'];
    				$usuarios->MenuDinamico($_id_rol);
    				 
    				$sesiones->setParametros($parametros);
    				 
    				 
    				$resultado=$sesiones->Insert();
    				 
    				 
    				
    				if($_id_rol==1){
    					

    					$this->view("BienvenidaAdmin",array(
    							"allusers"=>$_usuario
    					));
    					
    					die();
    					
    				}else{
    					
    					$this->view("Bienvenida",array(
    							"allusers"=>$_usuario
    					));
    						
    					die();
    					
    				}
    				
    				
    			}else{
    				
    				
    				$error = TRUE;
    				$mensaje = "Hola $nombre_usuario tu usuario se encuentra inactivo.";
    				 
    				 
    				$this->view("Login",array(
    						"resultSet"=>"$mensaje", "error"=>$error
    				));
    				 
    				 
    				die();
    			}
    			
    			
    		}
    		else
    		{
    			$error = TRUE;
    			$mensaje = "Este Usuario no existe resgistrado en nuestro sistema.";
    			
    			
	    		$this->view("Login",array(
	    				"resultSet"=>"$mensaje", "error"=>$error
	    		));
	    		
	    		
	    		die();
    		}
    		
    	} 
    	else
    	{
    		    $error = TRUE;
    			$mensaje = "Ingrese su cedula y su clave.";
    			
    			
	    		$this->view("Login",array(
	    				"resultSet"=>"$mensaje", "error"=>$error
	    		));
	    		
	    		
	    		die();
    		
    	}
    	
    }

    
   
    
    
    public function  sesion_caducada()
    {
    	session_start();
    	session_destroy();
    
    	$error = TRUE;
	    $mensaje = "Te sesión a caducado, vuelve a iniciar sesión.";
	    	
	    $this->view("Login",array(
	    		"resultSet"=>"$mensaje", "error"=>$error
	    ));
	    	
	    die();
	    		
    
    }
    
    
	public function  cerrar_sesion ()
	{
		session_start();
		session_destroy();
		
		$error = TRUE;
		$mensaje = "Te has desconectado de nuestro sistema.";
		 
		 
		$this->view("Login",array(
				"resultSet"=>"$mensaje", "error"=>$error
		));
		 
		 
		die();
		
		
	}
	
	
	
	public function  actualizo_perfil ()
	{
		session_start();
		session_destroy();
	
		$error = FALSE;
		$mensaje = "Actualizaste tus datos, vuelve a iniciar sesión.";	
			
		$this->view("Login",array(
				"resultSet"=>"$mensaje", "error"=>$error
		));
			
			
		die();
	
	
	}
	
	
	public function Actualiza ()
	{
		session_start();
		
		$rol=new RolesModel();
		$resultRol = $rol->getAll("nombre_rol");
			
		$estado = new EstadoModel();
		$resultEst = $estado->getAll("nombre_estado");
			
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			
			$usuarios = new UsuariosModel();
		
						
					
				$resultEdit = "";
					
				$_id_usuario = $_SESSION['id_usuarios'];
				
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
								  usuarios.creado";
					
					
				$tablas   = "public.usuarios,
								  public.rol,
								  public.estado";
					
				$where    = " rol.id_rol = usuarios.id_rol AND
								  estado.id_estado = usuarios.id_estado AND usuarios.id_usuarios = '$_id_usuario'";
					
				$id       = "usuarios.id_usuarios";
				
				$resultEdit=$usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
					
				
				

				if ( isset($_POST["cedula_usuarios"]) )
				{
					
					$_cedula_usuarios    = $_POST["cedula_usuarios"];
					$_nombre_usuarios     = $_POST["nombre_usuarios"];
					//$_usuario_usuario     = $_POST["usuario_usuario"];
					$_clave_usuarios      = $usuarios->encriptar($_POST["clave_usuarios"]);
					$_pass_sistemas_usuarios      = $_POST["clave_usuarios"];
					$_telefono_usuarios   = $_POST["telefono_usuarios"];
					$_celular_usuarios    = $_POST["celular_usuarios"];
					$_correo_usuarios     = $_POST["correo_usuarios"];
					$_id_rol             = $_POST["id_rol"];
					$_id_estado          = $_POST["id_estado"];
					
					$_id_usuario = $_SESSION['id_usuarios'];
					
					if ($_FILES['fotografia_usuarios']['tmp_name']!="")
					{
					
						$directorio = $_SERVER['DOCUMENT_ROOT'].'/template_2018/fotografias_usuarios/';
					
						$nombre = $_FILES['fotografia_usuarios']['name'];
						$tipo = $_FILES['fotografia_usuarios']['type'];
						$tamano = $_FILES['fotografia_usuarios']['size'];
						 
						move_uploaded_file($_FILES['fotografia_usuarios']['tmp_name'],$directorio.$nombre);
						$data = file_get_contents($directorio.$nombre);
						$imagen_usuarios = pg_escape_bytea($data);
					
					
						    $colval = "cedula_usuarios= '$_cedula_usuarios', nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios', fotografia_usuarios ='$imagen_usuarios'";
							$tabla = "usuarios";
							$where = "id_usuarios = '$_id_usuario'";
							$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
					
					}
					else
					{
						
						$colval = "cedula_usuarios= '$_cedula_usuarios', nombre_usuarios = '$_nombre_usuarios',  clave_usuarios = '$_clave_usuarios', pass_sistemas_usuarios='$_pass_sistemas_usuarios',  telefono_usuarios = '$_telefono_usuarios', celular_usuarios = '$_celular_usuarios', correo_usuarios = '$_correo_usuarios'";
						$tabla = "usuarios";
						$where = "id_usuarios = '$_id_usuario'";
						$resultado=$usuarios->UpdateBy($colval, $tabla, $where);
						
					}
					
					$participes = new ParticipeModel();
					
					if($_correo_usuarios!=""){
						try {
							$colval1 = "nombre= '$_nombre_usuarios',
							correo='$_correo_usuarios',
							telefono = '$_telefono_usuarios',
							celular = '$_celular_usuarios'";
								
							$tabla1 = "afiliado_extras";
								
							$where1 = "cedula = '$_cedula_usuarios'";
								
							$resultado=$participes->UpdateBy($colval1, $tabla1, $where1);
						} catch (Exception $e) {
						}	
						
					}
					
					
					
					
					$this->redirect("Usuarios", "actualizo_perfil");
					 
					 
				}
				else
				{
					$this->view("ActualizarUsuarios",array(
							"resultEdit" =>$resultEdit, "resultRol"=>$resultRol, "resultEst"=>$resultEst
								
					));
					
				}
				

		}
		else
		{
			$this->view("ErrorSesion",array(
			"resultSet"=>""
			));
					
		}
		
	}
	
	
	
	
	
	////// lo nuevo
	
	public function contar_roles(){
	
		session_start();
			
		$i=0;
		$roles=new RolesModel();
		$columnas = " id_rol";
		$tablas   = "rol";
		$where    = "id_rol >0 ";
		$id       = "id_rol";
			
		$resultSet = $roles->getCondiciones($columnas ,$tablas ,$where, $id);
			
	
	
		$i=count($resultSet);
	
		$html="";
		if($i>0)
		{
	
			$html .= "<div class='col-lg-3 col-xs-12'>";
			$html .= "<div class='small-box bg-yellow'>";
			$html .= "<div class='inner'>";
			$html .= "<h3>$i</h3>";
			$html .= "<p>Roles Registrados.</p>";
			$html .= "</div>";
	
	
			$html .= "<div class='icon'>";
			$html .= "<i class='ion ion-calendar'></i>";
			$html .= "</div>";
			$html .= "<a href='index.php?controller=Roles&action=index' class='small-box-footer'>Operaciones con Roles <i class='fa fa-arrow-circle-right'></i></a>";
			$html .= "</div>";
			$html .= "</div>";
	
	
		}else{
	
			$html = "<b>Actualmente no hay permisos registrados...</b>";
		}
	
		echo $html;
		die();
	
	
	}
	
	
	public function cargar_permisos_roles(){
	
		session_start();
			
		$i=0;
		$permisos_rol = new PermisosRolesModel();
		$columnas = "permisos_rol.id_permisos_rol";
		$tablas   = "public.controladores,  public.permisos_rol, public.rol";
		$where    = " controladores.id_controladores = permisos_rol.id_controladores AND permisos_rol.id_rol = rol.id_rol";
		$id       = " permisos_rol.id_permisos_rol";
		$resultSet = $permisos_rol->getCondiciones($columnas ,$tablas ,$where, $id);
	
		$i=count($resultSet);
	
		$html="";
		if($i>0)
		{
	
			$html .= "<div class='col-lg-3 col-xs-6'>";
			$html .= "<div class='small-box bg-red'>";
			$html .= "<div class='inner'>";
			$html .= "<h3>$i</h3>";
			$html .= "<p>Permisos Registrados.</p>";
			$html .= "</div>";
	
	
			$html .= "<div class='icon'>";
			$html .= "<i class='ion ion-stats-bars'></i>";
			$html .= "</div>";
			$html .= "<a href='index.php?controller=PermisosRoles&action=index' class='small-box-footer'>Operaciones con permisos <i class='fa fa-arrow-circle-right'></i></a>";
			$html .= "</div>";
			$html .= "</div>";
	
	
		}else{
	
			$html = "<b>Actualmente no hay permisos registrados...</b>";
		}
	
		echo $html;
		die();
	
	
	}
	
	
	
	
	public function cargar_sesiones(){
	
		session_start();
			
		$i=0;
	    $usuarios = new UsuariosModel();
	    $columnas = "sesiones.*";
	    $tablas   = "public.sesiones, public.usuarios";
	    $where    = "sesiones.id_usuarios = usuarios.id_usuarios";
	    $id       = "usuarios.nombre_usuarios";
	    $resultSet = $usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
	
		$i=count($resultSet);
	
		$html="";
		if($i>0)
		{
	
			$html .= "<div class='col-lg-3 col-xs-6'>";
			$html .= "<div class='small-box bg-aqua'>";
			$html .= "<div class='inner'>";
			$html .= "<h3>$i</h3>";
			$html .= "<p>Sesiones Registradas.</p>";
			$html .= "</div>";
	
	
			$html .= "<div class='icon'>";
			$html .= "<i class='ion ion-stats-bars'></i>";
			$html .= "</div>";
			$html .= "<a href='#' class='small-box-footer'>Leer Mas <i class='fa fa-arrow-circle-right'></i></a>";
			$html .= "</div>";
			$html .= "</div>";
	
	
		}else{
	
			$html = "<b>Actualmente no hay sesiones registrados...</b>";
		}
	
		echo $html;
		die();
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function paginate($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_usuarios(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_usuarios(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_usuarios(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_usuarios(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_usuarios(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_usuarios($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_usuarios(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	
	///////////////////////////////////////////////// informacion de participes ///////
	
	
	
	public function alerta_actualizacion(){
	
		session_start();
		$i=0;
		$usuarios = new UsuariosModel();
	
		
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
			
			$columnas = "usuarios.id_usuarios, usuarios.cedula_usuarios, usuarios.nombre_usuarios, usuarios.correo_usuarios";
			 
			$tablas   = "public.usuarios";
			 
			$where    = " 1=1 AND usuarios.cedula_usuarios='$cedula_usuarios'";
			 
			$id       = "usuarios.id_usuarios";
			
			
			
			$resultSet = $usuarios->getCondiciones($columnas ,$tablas ,$where, $id);
	
			$i=count($resultSet);
				
			$html="";
			if($i>0)
			{
				if (!empty($resultSet)) {
					$_id_usuarios=$resultSet[0]->id_usuarios;
					$_cedula_usuarios=$resultSet[0]->cedula_usuarios;
					$_nombre_usuarios=$resultSet[0]->nombre_usuarios;
					$_correo_usuarios=$resultSet[0]->correo_usuarios;
					
						
				}
	

				$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
				$html .= "<div class='info-box'>";
				$html .= "<span class='info-box-icon bg-aqua'><img src='view/DevuelveImagenView.php?id_valor=$_id_usuarios&id_nombre=id_usuarios&tabla=usuarios&campo=fotografia_usuarios' width='80' height='80'></span>";
				$html .= "<div class='info-box-content'>";
				$html .= "<span class='info-box-text'>Hola <strong>$_nombre_usuarios</strong><br> ayudanos actualizando tu información<br> personal.</span>";
				$html .= "</div>";
				$html .= "</div>";
				$html .= "</div>";
	
	
			}else{
	

				$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
				$html .= "<div class='info-box'>";
				$html .= "<span class='info-box-icon bg-aqua'><i class='ion ion-person-add'></i></span>";
				$html .= "<div class='info-box-content'>";
				$html .= "<span class='info-box-text'>Debes iniciar sesión.</span>";
				$html .= "</div>";
				$html .= "</div>";
				$html .= "</div>";
					
			}
	
			echo $html;
			die();
	
		}
		else{
	
	
	
			$this->redirect("Usuarios","sesion_caducada");
	
			die();
	
		}
	
	}
	
	
	
	
	
	
	public function cargar_cta_individual(){
	
		session_start();
		$i=0;
		$afiliado_transacc_cta_ind = new Afiliado_transacc_cta_indModel();
		
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
		
		if(!empty($cedula_usuarios)){
		$columnas_ind_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
		$tablas_ind_mayor="afiliado_transacc_cta_ind";
		$where_ind_mayor="cedula='$cedula_usuarios'";
		$resultSet=$afiliado_transacc_cta_ind->getCondicionesValorMayor($columnas_ind_mayor, $tablas_ind_mayor, $where_ind_mayor);
				
	
		$i=count($resultSet);
		$fecha="";
		$total= 0.00;
		$html="";
		if($i>0)
		{
			if (!empty($resultSet)) {  foreach($resultSet as $res) {
				$fecha=$res->fecha;
				$total= number_format($res->total, 2, '.', ',');
			}}else{
					
				$fecha="";
				$total= 0.00;
			
			}
	
			
	
			
			$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
			$html .= "<div class='info-box'>";
			$html .= "<span class='info-box-icon bg-red'><i class='ion ion-pie-graph'></i></span>";
			$html .= "<div class='info-box-content'>";
			$html .= "<span class='info-box-number'>$total</span>";
			$html .= "<span class='info-box-text'>Cuenta Individual Actualizada<br> al $fecha.</span>";
			$html .= "</div>";
			$html .= "</div>";
			$html .= "</div>";
			
			
			
	
		}else{
			
			
			
			$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
			$html .= "<div class='info-box'>";
			$html .= "<span class='info-box-icon bg-red'><i class='ion ion-pie-graph'></i></span>";
			$html .= "<div class='info-box-content'>";
			$html .= "<span class='info-box-number'>$total</span>";
			$html .= "<span class='info-box-text'>Actualmente no dispone cuenta<br> individual.</span>";
			$html .= "</div>";
			$html .= "</div>";
			$html .= "</div>";
			 
			
		}
	
		echo $html;
		die();
	
		}
		else{
			
			
			
			$this->redirect("Usuarios","sesion_caducada");
			
			die();
			
		}
	
	
	}
	
	
	
	
	
	
	public function cargar_cta_desembolsar(){
	
		session_start();
		$i=0;
		$afiliado_transacc_cta_desemb = new Afiliado_transacc_cta_desembModel();
		
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
			$columnas_desemb_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
			$tablas_desemb_mayor="afiliado_transacc_cta_desemb";
			$where_desemb_mayor="cedula='$cedula_usuarios'";
			$resultSet=$afiliado_transacc_cta_desemb->getCondicionesValorMayor($columnas_desemb_mayor, $tablas_desemb_mayor, $where_desemb_mayor);
				
	
			$i=count($resultSet);
			$fecha="";
			$total= 0.00;
			$html="";
			if($i>0)
			{
				if (!empty($resultSet)) {  foreach($resultSet as $res) {
					$fecha=$res->fecha;
					$total= number_format($res->total, 2, '.', ',');
				}}else{
						
					$fecha="";
					$total= 0.00;
						
				}
				
				
				$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
				$html .= "<div class='info-box'>";
				$html .= "<span class='info-box-icon bg-yellow'><i class='ion ion-stats-bars'></i></span>";
				$html .= "<div class='info-box-content'>";
				$html .= "<span class='info-box-number'>$total</span>";
				$html .= "<span class='info-box-text'>Cuenta Desembolsar Actualizada<br> al $fecha.</span>";
				$html .= "</div>";
				$html .= "</div>";
				$html .= "</div>";
	
				
	
	
			}else{
	
				
				$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
				$html .= "<div class='info-box'>";
				$html .= "<span class='info-box-icon bg-yellow'><i class='ion ion-stats-bars'></i></span>";
				$html .= "<div class='info-box-content'>";
				$html .= "<span class='info-box-number'>$total</span>";
				$html .= "<span class='info-box-text'>Actualmente no dispone Cuenta<br> Por Desembolsar.</span>";
				$html .= "</div>";
				$html .= "</div>";
				$html .= "</div>";
				
			
				
					
					
			}
	
			echo $html;
			die();
	
		}
		else{
				
				
				
			$this->redirect("Usuarios","sesion_caducada");
				
			die();
				
		}
	
	
	
	
	
	}
	
	
	
	
	
	
	
	public function cargar_credito_ordinario(){
	
		session_start();
		$i=0;
		$ordinario_solicitud = new Ordinario_SolicitudModel();
		$ordinario_detalle = new Ordinario_DetalleModel();
	
		$_numsol_ordinario="";
		$_cuota_ordinario="";
		$_interes_ordinario="";
		$_tipo_ordinario="";
		$_plazo_ordinario="";
		$_fcred_ordinario="";
		$_ffin_ordinario="";
		$_cuenta_ordinario="";
		$_banco_ordinario="";
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
			$columnas_ordi_cabec ="*";
			$tablas_ordi_cabec="ordinario_solicitud";
			$where_ordi_cabec="cedula='$cedula_usuarios'";
			$id_ordi_cabec="cedula";
			$resultSet=$ordinario_solicitud->getCondicionesDesc($columnas_ordi_cabec, $tablas_ordi_cabec, $where_ordi_cabec, $id_ordi_cabec);
			
	
			$i=count($resultSet);
			
			$html="";
			if($i>0)
			{
				if (!empty($resultSet)) { 
					$_numsol_ordinario=$resultSet[0]->numsol;
					$_cuota_ordinario=$resultSet[0]->cuota;
					$_interes_ordinario=$resultSet[0]->interes;
					$_tipo_ordinario=$resultSet[0]->tipo;
					$_plazo_ordinario=$resultSet[0]->plazo;
					$_fcred_ordinario=$resultSet[0]->fcred;
					$_ffin_ordinario=$resultSet[0]->ffin;
					$_cuenta_ordinario=$resultSet[0]->cuenta;
					$_banco_ordinario=$resultSet[0]->banco;
					
				}
	
				$html .= "<div class='col-lg-4 col-xs-12'>";
				$html .= "<div class='small-box bg-red'>";
				$html .= "<div class='inner'>";
				$html .= "<h3>$_numsol_ordinario</h3>";
				$html .= "<p>Tienes activo un crédito ordinario<br> desde $_fcred_ordinario hasta $_ffin_ordinario.</p>";
				$html .= "</div>";
	
	
				$html .= "<div class='icon'>";
				$html .= "<i class='ion ion-calendar'></i>";
				$html .= "</div>";
				$html .= "<a href='index.php?controller=SaldosCuentaIndividual&action=index' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
				$html .= "</div>";
				$html .= "</div>";
	
	
			}else{
	
				$html .= "<div class='col-lg-4 col-xs-12'>";
				$html .= "<div class='small-box bg-red'>";
				$html .= "<div class='inner'>";
				$html .= "<h3>S/N</h3>";
				$html .= "<p>Actualmente no dispone un crédito<br> ordinario.</p>";
				$html .= "</div>";
					
					
				$html .= "<div class='icon'>";
				$html .= "<i class='ion ion-calendar'></i>";
				$html .= "</div>";
				$html .= "<a href='index.php?controller=SaldosCuentaIndividual&action=index' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
				$html .= "</div>";
				$html .= "</div>";
					
					
			}
	
			echo $html;
			die();
	
		}
		else{
	
	
	
			$this->redirect("Usuarios","sesion_caducada");
	
			die();
	
		}
	
	}
	
	
	
	
	
	
	
	
	
	public function cargar_credito_emergente(){
	
		session_start();
		$i=0;
		$emergente_solicitud = new Emergente_SolicitudModel();
		$emergente_detalle = new Emergente_DetalleModel();
	
		$_numsol_emergente="";
		$_cuota_emergente="";
		$_interes_emergente="";
		$_tipo_emergente="";
		$_plazo_emergente="";
		$_fcred_emergente="";
		$_ffin_emergente="";
		$_cuenta_emergente="";
		$_banco_emergente="";
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
			$columnas_emer_cabec ="*";
				$tablas_emer_cabec="emergente_solicitud";
				$where_emer_cabec="cedula='$cedula_usuarios'";
				$id_emer_cabec="cedula";
				$resultSet=$emergente_solicitud->getCondicionesDesc($columnas_emer_cabec, $tablas_emer_cabec, $where_emer_cabec, $id_emer_cabec);
					
	
			$i=count($resultSet);
				
			$html="";
			if($i>0)
			{
				if (!empty($resultSet)) {
					
					$_numsol_emergente=$resultSet[0]->numsol;
					$_cuota_emergente=$resultSet[0]->cuota;
					$_interes_emergente=$resultSet[0]->interes;
					$_tipo_emergente=$resultSet[0]->tipo;
					$_plazo_emergente=$resultSet[0]->plazo;
					$_fcred_emergente=$resultSet[0]->fcred;
					$_ffin_emergente=$resultSet[0]->ffin;
					$_cuenta_emergente=$resultSet[0]->cuenta;
					$_banco_emergente=$resultSet[0]->banco;
						
				}
	
				$html .= "<div class='col-lg-4 col-xs-12'>";
				$html .= "<div class='small-box bg-yellow'>";
				$html .= "<div class='inner'>";
				$html .= "<h3>$_numsol_emergente</h3>";
				$html .= "<p>Tienes activo un crédito emergente<br> desde $_fcred_emergente hasta $_ffin_emergente.</p>";
				$html .= "</div>";
	
	
				$html .= "<div class='icon'>";
				$html .= "<i class='ion ion-calendar'></i>";
				$html .= "</div>";
				$html .= "<a href='index.php?controller=SaldosCuentaIndividual&action=index' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
				$html .= "</div>";
				$html .= "</div>";
	
	
			}else{
	
				$html .= "<div class='col-lg-4 col-xs-12'>";
				$html .= "<div class='small-box bg-yellow'>";
				$html .= "<div class='inner'>";
				$html .= "<h3>S/N</h3>";
				$html .= "<p>Actualmente no dispone un crédito<br> emergente.</p>";
				$html .= "</div>";
					
					
				$html .= "<div class='icon'>";
				$html .= "<i class='ion ion-calendar'></i>";
				$html .= "</div>";
				$html .= "<a href='index.php?controller=SaldosCuentaIndividual&action=index' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
				$html .= "</div>";
				$html .= "</div>";
					
					
			}
	
			echo $html;
			die();
	
		}
		else{
	
	
	
			$this->redirect("Usuarios","sesion_caducada");
	
			die();
	
		}
	
	}
	
	
	
	
	
	
	public function cargar_credito_2x1(){
	
		session_start();
		$i=0;
		$c2x1_solicitud = new C2x1_solicitudModel();
		$c2x1_detalle = new C2x1_detalleModel();
	
					$_numsol_2x1="";
					$_cuota_2x1="";
					$_interes_2x1="";
					$_tipo_2x1="";
					$_plazo_2x1="";
					$_fcred_2x1="";
					$_ffin_2x1="";
					$_cuenta_2x1="";
					$_banco_2x1="";
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
			$columnas_2_x_1_cabec ="*";
			$tablas_2_x_1_cabec="c2x1_solicitud";
			$where_2_x_1_cabec="cedula='$cedula_usuarios'";
			$id_2_x_1_cabec="cedula";
			$resultSet=$c2x1_solicitud->getCondicionesDesc($columnas_2_x_1_cabec, $tablas_2_x_1_cabec, $where_2_x_1_cabec, $id_2_x_1_cabec);
			
			
	
			$i=count($resultSet);
	
			$html="";
			if($i>0)
			{
				if (!empty($resultSet)) {
						
					$_numsol_2x1=$resultSet[0]->numsol;
					$_cuota_2x1=$resultSet[0]->cuota;
					$_interes_2x1=$resultSet[0]->interes;
					$_tipo_2x1=$resultSet[0]->tipo;
					$_plazo_2x1=$resultSet[0]->plazo;
					$_fcred_2x1=$resultSet[0]->fcred;
					$_ffin_2x1=$resultSet[0]->ffin;
					$_cuenta_2x1=$resultSet[0]->cuenta;
					$_banco_2x1=$resultSet[0]->banco;
	
				}
	
				$html .= "<div class='col-lg-4 col-xs-12'>";
				$html .= "<div class='small-box bg-aqua'>";
				$html .= "<div class='inner'>";
				$html .= "<h3>$_numsol_2x1</h3>";
				$html .= "<p>Tienes activo un crédito 2 X 1<br> desde $_fcred_2x1 hasta $_ffin_2x1.</p>";
				$html .= "</div>";
	
	
				$html .= "<div class='icon'>";
				$html .= "<i class='ion ion-calendar'></i>";
				$html .= "</div>";
				$html .= "<a href='index.php?controller=SaldosCuentaIndividual&action=index' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
				$html .= "</div>";
				$html .= "</div>";
	
	
			}else{
	
				$html .= "<div class='col-lg-4 col-xs-12'>";
				$html .= "<div class='small-box bg-aqua'>";
				$html .= "<div class='inner'>";
				$html .= "<h3>S/N</h3>";
				$html .= "<p>Actualmente no dispone un crédito<br> 2 X 1.</p>";
				$html .= "</div>";
					
					
				$html .= "<div class='icon'>";
				$html .= "<i class='ion ion-calendar'></i>";
				$html .= "</div>";
				$html .= "<a href='index.php?controller=SaldosCuentaIndividual&action=index' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
				$html .= "</div>";
				$html .= "</div>";
					
					
			}
	
			echo $html;
			die();
	
		}
		else{
	
	
	
			$this->redirect("Usuarios","sesion_caducada");
	
			die();
	
		}
	
	}
	
	
	
	
	
	
	
	
	
}
?>
