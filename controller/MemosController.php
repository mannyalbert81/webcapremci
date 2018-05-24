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
    	$editor1="";
    	
    	if (isset($_SESSION['nombre_usuarios']) )
    	{
    		$usuarios = new UsuariosModel();
    	    $memos_cabeza = new MemosCabezaModel();
    	    $memos_detalle = new MemosDetalleModel();
    		$memos_pdf = new MemosPdfModel();
    		
    		$nombre_controladores = "Usuarios";
    		$id_rol= $_SESSION['id_rol'];
    		$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    	
    		if(!empty($resultPer)){
    			
    			if(isset($_POST["enviar"])){
    			
    				
    			$_array_usuarios_to = $_POST['usuarios_to'];
    			$_array_usuarios_cc = $_POST['usuarios_cc'];
    			
    			$asunto =$_POST["asunto"];
    			$editor1 = $_POST["editor1"];
    			
    			$id_usuarios=$_SESSION["id_usuarios"];
    			$resultDepartamento = $usuarios->getBy("id_usuarios = '$id_usuarios' ");
    			$_id_departamentos=$resultDepartamento[0]->id_departamentos;
    			$_cargo_usuarios=$resultDepartamento[0]->cargo_usuarios;
    			$_nombre_usuarios=$resultDepartamento[0]->nombre_usuarios;
    			$_ciudad_trabajo=$resultDepartamento[0]->ciudad_trabajo;
    			
    			
    			$departamentos = new DepartamentosModel();
    			$resultConsecutivo= $departamentos->getBy("id_departamentos='$_id_departamentos'");
    			$numero_consecutivo_departamentos=$resultConsecutivo[0]->numero_consecutivo_departamentos;
    			$identificador_memorando=$resultConsecutivo[0]->identificador_departamentos;
    			$anio_memorando=$resultConsecutivo[0]->anio;
    			
    			date_default_timezone_set('America/Guayaquil');
    			$fechaActual = date('d-m-Y H:i:s');
    			
    			$numero_memorando="No. ".$anio_memorando."-".$numero_consecutivo_departamentos."-".$identificador_memorando;
    			
    				
    			
    			try {
    				
    				$funcion = "ins_memos_cab";
    				$parametros = "'$fechaActual',
    				'$numero_memorando',
    				'$id_usuarios',
    				'$_id_departamentos',
    				'$asunto'";
    				$memos_cabeza->setFuncion($funcion);
    				$memos_cabeza->setParametros($parametros);
    				$resultado=$memos_cabeza->Insert();
    				
    				
    				$resultMemosCabeza= $memos_cabeza->getBy("numero_memos_cab='$numero_memorando' AND id_usuarios='$id_usuarios' AND id_departamentos='$_id_departamentos'");
    				$id_memos_cab=$resultMemosCabeza[0]->id_memos_cab;
    				
    				
    			} catch (Exception $e) {
    				
    				echo "Error al Insertar Memos Cabeza";
    				die();
    				
    			}
    			
    			
    			
    			
    			
    			if($id_memos_cab > 0){
    				
    				
    				
    				
    				
    				// FORMAR DESTINATARIOS PARA
    				$count_to=0;
    				$_id_usuarios_to=0;
    				$_cargo_usuarios_to="";
    				$_nombre_usuarios_to="";
    				$_grupo_correos_to="";
    				$_total_registro_to=count($_array_usuarios_to);
    				
    				
    				if($_total_registro_to>0){
    				
    					$_grupo_correos_to="<pre><strong>PARA:     </strong>";
    					
    					foreach($_array_usuarios_to as $id  )
    					{
    						$count_to++;
    						$_id_usuarios_to = $id;
    							
    						if($_id_usuarios_to > 0){
    				
    							$resultUsuariosTo = $usuarios->getBy("id_usuarios = '$_id_usuarios_to' ");
    								
    							if(!empty($resultUsuariosTo)){
    									
    								$_cargo_usuarios_to=$resultUsuariosTo[0]->cargo_usuarios;
    								$_nombre_usuarios_to=$resultUsuariosTo[0]->nombre_usuarios;
    							}
    							
    							
    							$funcion = "ins_memos_det";
    							$parametros = "'$_id_usuarios_to','1','$id_memos_cab'";
    							$memos_detalle->setFuncion($funcion);
    							$memos_detalle->setParametros($parametros);
    							$resultado=$memos_detalle->Insert();
    				
    						}
    							
    						if($count_to==1){
    				
    							$_grupo_correos_to.= "<strong>$_nombre_usuarios_to</strong></pre><pre><strong>          $_cargo_usuarios_to</strong></pre><br>";
    							
    								
    						}else{
    				
    							$_grupo_correos_to.= "<pre><strong>          $_nombre_usuarios_to</strong></pre><pre><strong>          $_cargo_usuarios_to</strong></pre><br>";
    								
    						}
    							
    					}
    					 
    				}
    				
    				// TERMINA DESTINATARIOS PARA
    				
    				
    				
    				
    				
    				
    				
    				
    				
    				
    				
    				// TERMINA DESTINATARIOS COPIA
    				
    				$count_cc=0;
    				$_id_usuarios_cc=0;
    				$_cargo_usuarios_cc="";
    				$_nombre_usuarios_cc="";
    				$_grupo_correos_cc="";
    				$_total_registro_cc=count($_array_usuarios_cc);
    				
    				
    				
    				if($_total_registro_cc>0){
    				
    					$_grupo_correos_cc="<pre><strong>CC:       </strong>";
    					
    					foreach($_array_usuarios_cc as $id  )
    					{
    						$count_cc++;
    						$_id_usuarios_cc = $id;
    							
    						if($_id_usuarios_cc > 0){
    				
    							$resultUsuariosCc = $usuarios->getBy("id_usuarios = '$_id_usuarios_cc' ");
    				
    							if(!empty($resultUsuariosCc)){
    									
    								$_cargo_usuarios_cc=$resultUsuariosCc[0]->cargo_usuarios;
    								$_nombre_usuarios_cc=$resultUsuariosCc[0]->nombre_usuarios;
    							}
    				
    							$funcion = "ins_memos_det";
    							$parametros = "'$_id_usuarios_cc','2','$id_memos_cab'";
    							$memos_detalle->setFuncion($funcion);
    							$memos_detalle->setParametros($parametros);
    							$resultado=$memos_detalle->Insert();
    							
    						}
    							
    						
    						
    						if($count_cc==1){
    				
    							$_grupo_correos_cc.="<strong>$_nombre_usuarios_cc</strong></pre><pre><strong>          $_cargo_usuarios_cc</strong></pre><br>";
    						
    						}else{

    							$_grupo_correos_cc.="<pre><strong>          $_nombre_usuarios_cc</strong></pre><pre><strong>          $_cargo_usuarios_cc</strong></pre><br>";
    							
    						}
    							
    					}
    				
    				}
    				
    				
    				// TERMINA DESTINATARIOS COPIA
    				
    				
    				
    				
    				
    				
    				
    				
    				
    				
    				


    				//REGOGIENDO ARCHIVO 1
    				
    				if ($_FILES['archivo_1']['tmp_name']!="")
    				{
    					$directorio_1 = $_SERVER['DOCUMENT_ROOT'].'/webcapremci/memos_adjuntos/';
    					$nombre_1 = $_FILES['archivo_1']['name'];
    					$tipo_1 = $_FILES['archivo_1']['type'];
    					$tamano_1 = $_FILES['archivo_1']['size'];
    				
    					move_uploaded_file($_FILES['archivo_1']['tmp_name'],$directorio_1.$nombre_1);
    					$data_1 = file_get_contents($directorio_1.$nombre_1);
    					$archivo_1 = pg_escape_bytea($data_1);
    						
    					
    					$funcion = "ins_memos_pdf";
    					$parametros = "'$id_memos_cab','$archivo_1'";
    					$memos_pdf->setFuncion($funcion);
    					$memos_pdf->setParametros($parametros);
    					$resultado=$memos_pdf->Insert();
    					
    						
    				}else{
    						
    					$archivo_1="";
    				}
    				
    				//TERMINA ARCHIVO 1
    				
    				
    				
    				
    				//REGOGIENDO ARCHIVO 2
    				
    				if ($_FILES['archivo_2']['tmp_name']!="")
    				{
    					$directorio_2 = $_SERVER['DOCUMENT_ROOT'].'/webcapremci/memos_adjuntos/';
    					$nombre_2 = $_FILES['archivo_2']['name'];
    					$tipo_2 = $_FILES['archivo_2']['type'];
    					$tamano_2 = $_FILES['archivo_2']['size'];
    				
    					move_uploaded_file($_FILES['archivo_2']['tmp_name'],$directorio_2.$nombre_2);
    					$data_2 = file_get_contents($directorio_2.$nombre_2);
    					$archivo_2 = pg_escape_bytea($data_2);
    				
    				
    					$funcion = "ins_memos_pdf";
    					$parametros = "'$id_memos_cab','$archivo_2'";
    					$memos_pdf->setFuncion($funcion);
    					$memos_pdf->setParametros($parametros);
    					$resultado=$memos_pdf->Insert();
    					
    					
    				}else{
    				
    					$archivo_2="";
    				}
    				
    				//TERMINA ARCHIVO 2
    				
    				
    				
    				
    				//REGOGIENDO ARCHIVO 3
    				
    				if ($_FILES['archivo_3']['tmp_name']!="")
    				{
    					$directorio_3 = $_SERVER['DOCUMENT_ROOT'].'/webcapremci/memos_adjuntos/';
    					$nombre_3 = $_FILES['archivo_3']['name'];
    					$tipo_3 = $_FILES['archivo_3']['type'];
    					$tamano_3 = $_FILES['archivo_3']['size'];
    				
    					move_uploaded_file($_FILES['archivo_3']['tmp_name'],$directorio_3.$nombre_3);
    					$data_3 = file_get_contents($directorio_3.$nombre_3);
    					$archivo_3 = pg_escape_bytea($data_3);
    				
    					$funcion = "ins_memos_pdf";
    					$parametros = "'$id_memos_cab','$archivo_3'";
    					$memos_pdf->setFuncion($funcion);
    					$memos_pdf->setParametros($parametros);
    					$resultado=$memos_pdf->Insert();
    				
    				}else{
    				
    					$archivo_3="";
    				
    				}
    				
    				//TERMINA ARCHIVO 3
    				
    				
    				
    				
    				
    				//REGOGIENDO ARCHIVO 4
    				if ($_FILES['archivo_4']['tmp_name']!="")
    				{
    					$directorio_4 = $_SERVER['DOCUMENT_ROOT'].'/webcapremci/memos_adjuntos/';
    					$nombre_4 = $_FILES['archivo_4']['name'];
    					$tipo_4 = $_FILES['archivo_4']['type'];
    					$tamano_4 = $_FILES['archivo_4']['size'];
    				
    					move_uploaded_file($_FILES['archivo_4']['tmp_name'],$directorio_4.$nombre_4);
    					$data_4 = file_get_contents($directorio_4.$nombre_4);
    					$archivo_4 = pg_escape_bytea($data_4);
    				
    					
    					$funcion = "ins_memos_pdf";
    					$parametros = "'$id_memos_cab','$archivo_4'";
    					$memos_pdf->setFuncion($funcion);
    					$memos_pdf->setParametros($parametros);
    					$resultado=$memos_pdf->Insert();
    					
    				}else{
    				
    					$archivo_4="";
    				
    				}
    				//TERMINA ARCHIVO 4
    				
    				
    				
    				
    				
    				//REGOGIENDO ARCHIVO GENERADO MEMO
    				
    				//TERMINA ARCHIVO GENERADO MEMO
    				
    				
    				
    				
    			}
    				
    			$departamentos->UpdateBy("numero_consecutivo_departamentos=numero_consecutivo_departamentos+1", "departamentos", "id_departamentos='$_id_departamentos'");
    			 
    			
    			$fechaactual = $fechaActual;
    			$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    			$fechaactual=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
    			 
    			
    			$cuadro_infor="";
    			$cuadro_infor.="<pre><strong>DE:       $_nombre_usuarios</strong></pre><pre><strong>          $_cargo_usuarios</strong></pre><br>";
    			if($_grupo_correos_to!=""){$cuadro_infor.="$_grupo_correos_to";}
    			if($_grupo_correos_cc!=""){$cuadro_infor.="$_grupo_correos_cc";}
    			$cuadro_infor.="<pre><strong>ASUNTO:   $asunto</strong></pre><br>";
    			$cuadro_infor.="<pre><strong style='text-transform: uppercase;'>FECHA:    $_ciudad_trabajo, $fechaactual</strong></pre><pre>";
    			
    			
    			
    			$cuadro_firma="<div style='font-family: Arial; font-size:11pt; color:#000000; width: 30%; text-align: left; margin-top:20px;'>";
    			$cuadro_firma.="<p>Atentamente,</p>";
    			$cuadro_firma.="<strong><hr style='margin-top:60px; border-color: black;'></strong>";
    			$cuadro_firma.="<strong>$_nombre_usuarios</strong><br>";
    			$cuadro_firma.="<strong>$_cargo_usuarios</strong><br>";
    			$cuadro_firma.="<strong>FCPC EMCIS FF.AA</strong><br>";
    			$cuadro_firma.="<strong>Fono: 3828870</strong><br>";
    			$cuadro_firma.="<strong>www.capremci.com.ec</strong>";
    			$cuadro_firma.="</div>";
    			
    			
    			$dicContenido = array(
    					'TITULOPAG'=>"Capremci 2018",
    					'NOMBREFICHA'=>"MEMORANDO",
    					'NUMEROMEMORANDO'=>$numero_memorando,
    					'CUERPO'=>$editor1,
    					'CUADROINFORMACION'=>$cuadro_infor,
    					'CUADROFRIMA'=>$cuadro_firma
    			);
    			
    			$this->verReporte('Memorandu',array(
    					'dicContenido'=>$dicContenido, 'numero_memorando'=>$numero_memorando, 'id_memos_cab'=>$id_memos_cab
    			));
    			
    				
    				
    			}
    			
    				
    			 
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
