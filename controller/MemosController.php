<?php
class MemosController extends ControladorBase{
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function index(){
    
    	session_start();
    	if (isset(  $_SESSION['nombre_usuarios']) )
    	{
    		
    		$totalimbox=0;
    		$totalsent=0;
    		$id_usuarios=$_SESSION["id_usuarios"];
    		$usuarios = new UsuariosModel();
    		$memos_cabeza = new MemosCabezaModel();
    		$memos_detalle = new MemosDetalleModel();
    		$nombre_controladores = "Memos";
    		$id_rol= $_SESSION['id_rol'];
    		$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    
    		
    		if(!empty($resultPer)){
    			
    			
    			
    			
    			if(isset($_GET["ident"]) && isset($_GET["tip"])){
    				
    				
    				$id_memos_cab= $_GET["ident"];
    				$tipo=$_GET["tip"];
    				
    				if($id_memos_cab>0){
    					
    					
    					date_default_timezone_set('America/Guayaquil');
    					$fechaActual = date('d-m-Y H:i:s');
    					
    					if($tipo=="Approve"){
    						
    						$memos_cabeza->UpdateBy("apr_ger_memos_cab='TRUE', fecha_apr_ger_memos_cab='$fechaActual', id_estado_tramites=2", "memos_cab", "id_memos_cab='$id_memos_cab'");
    						
    					}
    					
    					
    					if($tipo=="Received"){
    					
    						$memos_cabeza->UpdateBy("rev_sec_memos_cab='TRUE', fecha_rev_sec_memos_cab='$fechaActual', id_estado_tramites=4", "memos_cab", "id_memos_cab='$id_memos_cab'");
    					
    					}
    					
    					
    					/*
    					if($tipo=="Remove"){
    							
    						$memos_cabeza->UpdateBy("id_estado_tramites=3", "memos_cab", "id_memos_cab='$id_memos_cab'");
    							
    					}
    					*/
    				}
    				
    				
    				
    			}
    			
    			
    			if($id_rol==45){
    			
    				$columnas="*";
    				$tablas="public.memos_det, public.memos_cab";
    				$where="memos_cab.id_memos_cab = memos_det.id_memos_cab AND memos_det.id_usuarios='$id_usuarios' AND (memos_cab.id_estado_tramites=4 OR memos_cab.id_estado_tramites=2)";
    				$totalimbox=$memos_detalle->getCantidad($columnas, $tablas, $where);
    					
    			
    			}else{
    			
    				 
    				$columnas1="*";
    				$tablas1="memos_det";
    				$where1="id_usuarios='$id_usuarios'";
    				$totalimbox=$memos_detalle->getCantidad($columnas1, $tablas1, $where1);
    			
    			}
    			$cantidadimbox=(int)$totalimbox[0]->total;
    			 
    			$columnas2="*";
    			$tablas2="memos_cab";
    			$where2="id_usuarios='$id_usuarios'";
    			$totalsent=$memos_cabeza->getCantidad($columnas2, $tablas2, $where2);
    			$cantidadsent=(int)$totalsent[0]->total;
    			
    			
    			
    			
    			
    		$this->view("Memos",array(
    				"cantidadimbox"=>$cantidadimbox, "cantidadsent"=>$cantidadsent
    		
    		));
    		
    		}else{
    			
    			
    		}
    
    	}
    	else{
    
    		$this->redirect("Usuarios","sesion_caducada");
    
    	}
    
    }
    
    
    
    public function index_readmail(){
    
    	session_start();
    	if (isset(  $_SESSION['nombre_usuarios']) )
    	{
    		$totalimbox=0;
    		$totalsent=0;
    		$usuarios= new UsuariosModel();
    		$memos_cabeza = new MemosCabezaModel();
    		$memos_detalle = new MemosDetalleModel();
    		$id_usuarios = $_SESSION["id_usuarios"];
    		$memos_pdf = new MemosPdfModel();
    		$html="";
    		
    		
    		
    		if (isset($_GET["identi"]) && isset($_GET["tip"])){
    			
    			$id_memos_cab=$_GET["identi"];
    			$tipo=$_GET["tip"];
    			
    			if($tipo=="imbox_p"){
    				
    				$memos_detalle->UpdateBy("revisado_det='TRUE'", "memos_det", "id_memos_cab='$id_memos_cab' AND id_usuarios='$id_usuarios' AND tipo_memos_det='1'");
    				
    			}
    			
    			if($tipo=="imbox_c"){
    				
    				$memos_detalle->UpdateBy("revisado_det='TRUE'", "memos_det", "id_memos_cab='$id_memos_cab' AND id_usuarios='$id_usuarios'  AND tipo_memos_det='2'");
    				
    			}
    			
    			
    			if($tipo=="imbox_as"){
    			
    				$memos_detalle->UpdateBy("revisado_det='TRUE'", "memos_det", "id_memos_cab='$id_memos_cab' AND id_usuarios='$id_usuarios'  AND tipo_memos_det='3'");
    			
    			}
    			
    			
    		}
    		
    		
    		
    		if (isset($_GET["identi"])){
    			
    			$id_memos_cab=$_GET["identi"];
    			
    			
    			$columnas = "memos_cab.id_memos_cab,
    			      memos_cab.fecha_memos_cab,
					  memos_cab.numero_memos_cab,
					  memos_cab.asunto_memos_cab,
    			      memos_cab.rev_sec_memos_cab,
    				  memos_cab.cuerpo_memos_cab,	
					  estado_tramites.nombre_estado_tramites,
					  usuarios.nombre_usuarios";
    			$tablas  = "public.memos_cab,
					  public.estado_tramites,
				      public.usuarios";
	    			
    			$where    = " memos_cab.id_usuarios = usuarios.id_usuarios AND
    			estado_tramites.id_estado_tramites = memos_cab.id_estado_tramites AND memos_cab.id_memos_cab='$id_memos_cab'";
    			
    			$id       = "memos_cab.id_memos_cab";
    			$resultSet=$memos_cabeza->getCondiciones($columnas, $tablas, $where, $id);
    			
    			
    			$_grupo_correos_de="";
    			
    			if(!empty($resultSet)){
    				
	    			foreach($resultSet as $res  )
	    			{
	    				
	    			$nombre_usu_de=$res->nombre_usuarios;
	    			$asunto=$res->asunto_memos_cab;
	    			$fecha_memos_cab=$res->fecha_memos_cab;
	    			$cuerpo_memos_cab = $res->cuerpo_memos_cab;
	    			$nombre_estado_tramites= $res->nombre_estado_tramites;
	    			}
	    			$_grupo_correos_de="<pre><strong>DE:</strong>       $nombre_usu_de</pre>";
	    		
    			}
    			
    			$_array_usuarios_to= $memos_detalle->getBy("id_memos_cab='$id_memos_cab' AND tipo_memos_det=1");
    			
    			
    			// FORMAR DESTINATARIOS PARA
    			$count_to=0;
    			$_id_usuarios_to=0;
    			$_cargo_usuarios_to="";
    			$_nombre_usuarios_to="";
    			$_grupo_correos_to="";
    			$_total_registro_to=count($_array_usuarios_to);
    			
    			
    			if($_total_registro_to>0){
    			
    				$_grupo_correos_to="<pre><strong>PARA:     </strong>";
    					
    				foreach($_array_usuarios_to as $res  )
    				{
    					$count_to++;
    					$_id_usuarios_to = $res->id_usuarios;
    						
    					if($_id_usuarios_to > 0){
    			
    						$resultUsuariosTo = $usuarios->getBy("id_usuarios = '$_id_usuarios_to' ");
    			
    						if(!empty($resultUsuariosTo)){
    						
    							$_nombre_usuarios_to=$resultUsuariosTo[0]->nombre_usuarios;
    						}
    					
    					}
    						
    					if($count_to==$_total_registro_to){
    			
    						$_grupo_correos_to.= "$_nombre_usuarios_to</pre>";
    					
    					}else{
    			
    						$_grupo_correos_to.= "$_nombre_usuarios_to, ";
    			
    					}
    						
    				}
    			
    			}
    			
    			// TERMINA DESTINATARIOS PARA
    			
    			
    			
    			$_array_usuarios_cc= $memos_detalle->getBy("id_memos_cab='$id_memos_cab' AND tipo_memos_det=2");
    			
    			// TERMINA DESTINATARIOS COPIA
    			
    			$count_cc=0;
    			$_id_usuarios_cc=0;
    			$_cargo_usuarios_cc="";
    			$_nombre_usuarios_cc="";
    			$_grupo_correos_cc="";
    			$_total_registro_cc=count($_array_usuarios_cc);
    			
    			
    			if($_total_registro_cc>0){
    			
    				$_grupo_correos_cc="<pre><strong>CC:       </strong>";
    					
    				foreach($_array_usuarios_cc as $res  )
    				{
    					$count_cc++;
    					$_id_usuarios_cc = $res->id_usuarios;;
    						
    					if($_id_usuarios_cc > 0){
    			
    						$resultUsuariosCc = $usuarios->getBy("id_usuarios = '$_id_usuarios_cc' ");
    			
    						if(!empty($resultUsuariosCc)){
    							
    							$_nombre_usuarios_cc=$resultUsuariosCc[0]->nombre_usuarios;
    						}
    							
    					}
    						
    			
    					if($count_cc==$_total_registro_cc){
    			
    						$_grupo_correos_cc.="$_nombre_usuarios_cc</pre>";
    			
    					}else{
    			
    						$_grupo_correos_cc.="$_nombre_usuarios_cc, ";
    							
    					}
    						
    				}
    			
    			}
    			
    			
    			// TERMINA DESTINATARIOS COPIA
    			
    			
    			$columnas_pdf="id_memos_pdf, id_tipo_memos_pdf";
    			$tablas_pdf="memos_pdf";
    			$where_pdf="id_memos_cab='$id_memos_cab' AND id_tipo_memos_pdf=1";
    			$id_pdf="id_memos_pdf";
    			$resultSetMem=$memos_pdf->getCondiciones($columnas_pdf, $tablas_pdf, $where_pdf, $id_pdf);
    			
    			
    			$columnas_pdf_adj="id_memos_pdf, id_tipo_memos_pdf";
    			$tablas_pdf_adj="memos_pdf";
    			$where_pdf_adj="id_memos_cab='$id_memos_cab' AND id_tipo_memos_pdf=2";
    			$id_pdf_adj="id_memos_pdf";
    			$resultSetAdj=$memos_pdf->getCondiciones($columnas_pdf_adj, $tablas_pdf_adj, $where_pdf_adj, $id_pdf_adj);
    			$count_Adj=count($resultSetAdj);
    			
    			
    		
    			$html.="$_grupo_correos_de";
    			$html.="$_grupo_correos_to";
    			if(!empty($_grupo_correos_cc)){
    			$html.="$_grupo_correos_cc";
    			}
    			$html.="<pre><strong>ASUNTO:</strong>   $asunto</pre>";
    			$html.="<pre><strong>FECHA:</strong>    $fecha_memos_cab</pre>";
    			
    			$html.="<div class='box-body pad'>";
    			$html.="<textarea id='editor1' name='editor1' rows='10' cols='80'>$cuerpo_memos_cab</textarea>";
    			$html.="<div id='mensaje_editor' class='errores'></div>";
    			$html.="</div>";
    			
    			
    			if(!empty($resultSetMem)){
    				
    				
    				$html.="<table class='table table-hover' style='margin-top:20px;'>";
    				$html.='<thead>';
    				$html.="<tr  class='bg-primary'>";
    				$html.='<th style="text-align: left;  font-size: 14px;">Memorando</th>';
    				if(!empty($count_Adj)){
    					
    					if($count_Adj==1){
    						
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 1</th>';
    					}
    					if($count_Adj==2){
    					
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 1</th>';
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 2</th>';
    					}
    					
    					if($count_Adj==3){
    							
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 1</th>';
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 2</th>';
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 3</th>';
    					}
    					
    					if($count_Adj==4){
    							
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 1</th>';
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 2</th>';
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 3</th>';
    						$html.='<th style="text-align: left;  font-size: 14px;">Archivo Adj 4</th>';
    						
    					}
    					
    				}
    				
    				
    				$html.="</tr>";
    				$html.='</thead>';
    				$html.='<tbody>';
    				
    				$html.="<tr>";
    				foreach ($resultSetMem as $res){
    				
    					$id_memos_pdf=$res->id_memos_pdf;
    					
    					$html.='<td><a target="_blank" href="view/DevuelvePDFView.php?id_valor='.$res->id_memos_pdf.'&id_nombre=id_memos_pdf&tabla=memos_pdf&campo=archivo_memos_pdf"><img src="view/images/logo_pdf.png" width="40" height="40"></a></td>';
    					
    				}
    				
    				if(!empty($resultSetAdj)){
    					
    					foreach ($resultSetAdj as $res1){
    					
    						$id_memos_pdf=$res1->id_memos_pdf;
    							
    						$html.='<td><a target="_blank" href="view/DevuelvePDFView.php?id_valor='.$res1->id_memos_pdf.'&id_nombre=id_memos_pdf&tabla=memos_pdf&campo=archivo_memos_pdf"><img src="view/images/logo_pdf.png" width="40" height="40"></a></td>';
    							
    					}
    				}
    				
    				$html.="</tr>";
    				$html.='</tbody>';
    				$html.="</table>";
    				
    			}
    			
    			
    			
    			$id_rol=$_SESSION["id_rol"];
    			
    			if($id_rol==45){
    				
    				if($nombre_estado_tramites=='RECIBIDO'){
    					
    					
    					$html.='<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 5px">';
    					$html.='<a href="index.php?controller=Memos&action=index&ident='.$id_memos_cab.'&tip=Cancel" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></a>';
    					$html.='<a href="index.php?controller=Memos&action=index&ident='.$id_memos_cab.'&tip=Approve" class="btn btn-success" ><i class="glyphicon glyphicon-floppy-saved"> Aprobar</i></a>';
    					//$html.='<a href="index.php?controller=Memos&action=index&ident='.$id_memos_cab.'&tip=Remove" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
    					$html.='</div>';
    					 
    					
    				}
    				
    				
    				
    				
    			}elseif ($id_rol==44){
    				
    				
    				if($nombre_estado_tramites=='PENDIENTE'){
    				
    				$html.='<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 5px">';
    				$html.='<a href="index.php?controller=Memos&action=index&ident='.$id_memos_cab.'&tip=Cancel" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-remove"> Cancelar</i></a>';
    				$html.='<a href="index.php?controller=Memos&action=index&ident='.$id_memos_cab.'&tip=Received" class="btn btn-success" ><i class="glyphicon glyphicon-floppy-saved"> Recibir</i></a>';
    				//$html.='<a href="index.php?controller=Memos&action=index&ident='.$id_memos_cab.'&tip=Remove" class="btn btn-danger" ><i class="glyphicon glyphicon-trash"></i> Eliminar</a>';
    				$html.='</div>';
    				
    				}
    			}
    			
    			
    			
    		}
    		
    		
    		
    		if($id_rol==45){
    			 
    			$columnas="*";
    			$tablas="public.memos_det, public.memos_cab";
    			$where="memos_cab.id_memos_cab = memos_det.id_memos_cab AND memos_det.id_usuarios='$id_usuarios' AND (memos_cab.id_estado_tramites=4 OR memos_cab.id_estado_tramites=2)";
    			$totalimbox=$memos_detalle->getCantidad($columnas, $tablas, $where);
    				
    			 
    		}else{
    			 
    				
    			$columnas1="*";
    			$tablas1="memos_det";
    			$where1="id_usuarios='$id_usuarios'";
    			$totalimbox=$memos_detalle->getCantidad($columnas1, $tablas1, $where1);
    			 
    		}
    		$cantidadimbox=(int)$totalimbox[0]->total;
    		
    		$columnas2="*";
    		$tablas2="memos_cab";
    		$where2="id_usuarios='$id_usuarios'";
    		$totalsent=$memos_cabeza->getCantidad($columnas2, $tablas2, $where2);
    		$cantidadsent=(int)$totalsent[0]->total;
    		
    		
    			 
    			$this->view("MemosRevisados",array(
    					"html"=>$html, "cantidadimbox"=>$cantidadimbox, "cantidadsent"=>$cantidadsent
    
    			));
    
    		
    
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
    		
    		$nombre_controladores = "Memos";
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
    				'$asunto',
    				'$editor1'";
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
    				
    				
    				
    			
    				
    				
    				//INSERTANDO PARA RECEPCION
    				
    				
    				
    				
    				$funcion = "ins_memos_det";
    				$parametros = "'15408','3','$id_memos_cab'";
    				$memos_detalle->setFuncion($funcion);
    				$memos_detalle->setParametros($parametros);
    				$resultado=$memos_detalle->Insert();
    				
    				
    				
    				
    				
    				
    				//TERMINA INSERTANDO PARA RECEPCION
    				
    				
    				
    				
    				
    				


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
    					$parametros = "'$id_memos_cab','$archivo_1','2'";
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
    					$parametros = "'$id_memos_cab','$archivo_2','2'";
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
    					$parametros = "'$id_memos_cab','$archivo_3','2'";
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
    					$parametros = "'$id_memos_cab','$archivo_4','2'";
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
    			$cuadro_infor.="<pre><strong style='text-transform: uppercase;'>FECHA:    $_ciudad_trabajo, $fechaactual</strong></pre>";
    			
    			
    			
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
    
    		$nombre_controladores = "Memos";
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
    			$totalimbox=0;
    			$totalsent=0;
    			$id_usuarios=$_SESSION["id_usuarios"];
    			
    			$memos_cabeza = new MemosCabezaModel();
    			$memos_detalle = new MemosDetalleModel();
    			$nombre_controladores = "Memos";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    	
    			if(!empty($resultPer)){
    				 
    				
    				if($id_rol==45){
    					 
    					$columnas="*";
    					$tablas="public.memos_det, public.memos_cab";
    					$where="memos_cab.id_memos_cab = memos_det.id_memos_cab AND memos_det.id_usuarios='$id_usuarios' AND (memos_cab.id_estado_tramites=4 OR memos_cab.id_estado_tramites=2)";
    					$totalimbox=$memos_detalle->getCantidad($columnas, $tablas, $where);
    						
    					 
    				}else{
    					 
    						
    					$columnas1="*";
    					$tablas1="memos_det";
    					$where1="id_usuarios='$id_usuarios'";
    					$totalimbox=$memos_detalle->getCantidad($columnas1, $tablas1, $where1);
    					 
    				}
    				$cantidadimbox=(int)$totalimbox[0]->total;
    				
    				$columnas2="*";
    				$tablas2="memos_cab";
    				$where2="id_usuarios='$id_usuarios'";
    				$totalsent=$memos_cabeza->getCantidad($columnas2, $tablas2, $where2);
    				$cantidadsent=(int)$totalsent[0]->total;
    				
    				
    				$this->view("MemosEnviados",array(
    						"cantidadimbox"=>$cantidadimbox, "cantidadsent"=>$cantidadsent
    
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
    			$totalimbox=0;
    			$totalsent=0;
    			$id_usuarios=$_SESSION["id_usuarios"];
    			 
    			$memos_cabeza = new MemosCabezaModel();
    			$memos_detalle = new MemosDetalleModel();
    			$nombre_controladores = "Memos";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    			 
    			if(!empty($resultPer)){
    					
    				
    				if($id_rol==45){
    				
    					$columnas="*";
    					$tablas="public.memos_det, public.memos_cab";
    					$where="memos_cab.id_memos_cab = memos_det.id_memos_cab AND memos_det.id_usuarios='$id_usuarios' AND (memos_cab.id_estado_tramites=4 OR memos_cab.id_estado_tramites=2)";
    					$totalimbox=$memos_detalle->getCantidad($columnas, $tablas, $where);
    				
    				
    				}else{
    				
    				
    					$columnas1="*";
    					$tablas1="memos_det";
    					$where1="id_usuarios='$id_usuarios'";
    					$totalimbox=$memos_detalle->getCantidad($columnas1, $tablas1, $where1);
    				
    				}
    				$cantidadimbox=(int)$totalimbox[0]->total;
    				
    				$columnas2="*";
    				$tablas2="memos_cab";
    				$where2="id_usuarios='$id_usuarios'";
    				$totalsent=$memos_cabeza->getCantidad($columnas2, $tablas2, $where2);
    				$cantidadsent=(int)$totalsent[0]->total;
    				
    				
    				$this->view("MemosBorrador",array(
    							"cantidadimbox"=>$cantidadimbox, "cantidadsent"=>$cantidadsent
    	
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
    			$totalimbox=0;
    			$totalsent=0;
    			$id_usuarios=$_SESSION["id_usuarios"];
    			 
    			$memos_cabeza = new MemosCabezaModel();
    			$memos_detalle = new MemosDetalleModel();
    			$nombre_controladores = "Memos";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    	
    			if(!empty($resultPer)){
    				
    				if($id_rol==45){
    				
    					$columnas="*";
    					$tablas="public.memos_det, public.memos_cab";
    					$where="memos_cab.id_memos_cab = memos_det.id_memos_cab AND memos_det.id_usuarios='$id_usuarios' AND (memos_cab.id_estado_tramites=4 OR memos_cab.id_estado_tramites=2)";
    					$totalimbox=$memos_detalle->getCantidad($columnas, $tablas, $where);
    				
    				
    				}else{
    				
    				
    					$columnas1="*";
    					$tablas1="memos_det";
    					$where1="id_usuarios='$id_usuarios'";
    					$totalimbox=$memos_detalle->getCantidad($columnas1, $tablas1, $where1);
    				
    				}
    				$cantidadimbox=(int)$totalimbox[0]->total;
    				
    				$columnas2="*";
    				$tablas2="memos_cab";
    				$where2="id_usuarios='$id_usuarios'";
    				$totalsent=$memos_cabeza->getCantidad($columnas2, $tablas2, $where2);
    				$cantidadsent=(int)$totalsent[0]->total;
    				
    				
    				$this->view("MemosBasura",array(
    							"cantidadimbox"=>$cantidadimbox, "cantidadsent"=>$cantidadsent
   
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
    			$totalimbox=0;
    			$totalsent=0;
    			$id_usuarios=$_SESSION["id_usuarios"];
    			 
    			$memos_cabeza = new MemosCabezaModel();
    			$memos_detalle = new MemosDetalleModel();
    			$nombre_controladores = "Memos";
    			$id_rol= $_SESSION['id_rol'];
    			$resultPer = $usuarios->getPermisosEditar("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
    			 
    			if(!empty($resultPer)){
    					
    				if($id_rol==45){
    				
    					$columnas="*";
    					$tablas="public.memos_det, public.memos_cab";
    					$where="memos_cab.id_memos_cab = memos_det.id_memos_cab AND memos_det.id_usuarios='$id_usuarios' AND (memos_cab.id_estado_tramites=4 OR memos_cab.id_estado_tramites=2)";
    					$totalimbox=$memos_detalle->getCantidad($columnas, $tablas, $where);
    				
    				
    				}else{
    				
    				
    					$columnas1="*";
    					$tablas1="memos_det";
    					$where1="id_usuarios='$id_usuarios'";
    					$totalimbox=$memos_detalle->getCantidad($columnas1, $tablas1, $where1);
    				
    				}
    				$cantidadimbox=(int)$totalimbox[0]->total;
    				
    				$columnas2="*";
    				$tablas2="memos_cab";
    				$where2="id_usuarios='$id_usuarios'";
    				$totalsent=$memos_cabeza->getCantidad($columnas2, $tablas2, $where2);
    				$cantidadsent=(int)$totalsent[0]->total;
    				
    				
    				$this->view("MemosEliminados",array(
    							"cantidadimbox"=>$cantidadimbox, "cantidadsent"=>$cantidadsent
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    ////////////////////////////////////////////////////////////// CARGAS DE INFORMACION MEMOS ///////////////////////////////////
    
    
    
    public function cargar_imbox(){
    
    	session_start();
    	$id_usuarios=$_SESSION["id_usuarios"];
    	$memos_cabeza = new MemosCabezaModel();
    	$memos_detalle = new MemosDetalleModel();
    	$usuarios = new UsuariosModel();
    	$estado= new EstadoTramitesModel();
    	
    	 
    	 
    	if (isset($_SESSION['id_rol']) )
    	{
    	
    		$id_rol=$_SESSION["id_rol"];
    		
    		
    		if($id_rol==45){
    			
    			// GERENTE
    			
    			
    			$where_to="";
    			$columnas = "*";
    			
    			$tablas   = "memos_det";
    			
    			$where    = "1=1 AND memos_det.id_usuarios='$id_usuarios'";
    			
    			$id       = "memos_det.id_memos_det";
    			
    			
    			$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    			$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    			
    			
    			
    			
    			if($action == 'ajax')
    			{
    			
    				if(!empty($search)){
    			
    					  $where1="";
    					//$where1=" AND (UPPER(memos_det.numero_memos_cab) LIKE '%".mb_strtoupper($search)."%' )";
    			
    					$where_to=$where.$where1;
    				}else{
    			
    					$where_to=$where;
    			
    				}
    			
    				$html="";
    				$resultSet=$memos_detalle->getCantidad("*", $tablas, $where_to);
    				$cantidadResult=(int)$resultSet[0]->total;
    			
    				$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    			
    				$per_page = 30; //la cantidad de registros que desea mostrar
    				$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    				$offset = ($page - 1) * $per_page;
    			
    				$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    			
    				$resultSet=$memos_detalle->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
    				$count_query   = $cantidadResult;
    				$total_pages = ceil($cantidadResult/$per_page);
    			
    				 
    			
    				if($cantidadResult>0)
    				{
    			
    					$html.='<div class="pull-left">';
    					$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
    					$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>';
    					$html.='</div><br><br>';
    					$html.='<div class="table-responsive mailbox-messages">';
    					$html.='<section style="height:425px; overflow-y:scroll;">';
    					$html.= "<table id='tabla_cargar_imbox' class='tablesorter table table-hover table-striped nowrap'>";
    					$html.= "<thead>";
    					$html.= "<tr class='bg-primary'>";
    					$html.='<th style="text-align: left;  font-size: 14px;"></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>Subject</b></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>From</b></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>Date</b></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>State</b></th>';
    					$html.='</tr>';
    					$html.='</thead>';
    					$html.='<tbody>';
    			
    					$i=0;
    			
    					foreach ($resultSet as $res)
    					{
    						$i++;
    						$id_memos_cab=$res->id_memos_cab;
    						$revisado_det=$res->revisado_det;
    						$tipo_memos_det= $res->tipo_memos_det;
    			
    						$resultCabeza= $memos_cabeza->getBy("id_memos_cab='$id_memos_cab'");
    						$id=$resultCabeza[0]->id_usuarios;
    						$asunto_memos_cab=$resultCabeza[0]->asunto_memos_cab;
    						$fecha_memos_cab=$resultCabeza[0]->fecha_memos_cab;
    						$id_estado_tramites=$resultCabeza[0]->id_estado_tramites;
    			
    						if($id_estado_tramites==4 || $id_estado_tramites==2){
    						
    						
    						$resultUsuarios= $usuarios->getBy("id_usuarios='$id'");
    						$nombre=$resultUsuarios[0]->nombre_usuarios;
    			
    						$resultEstadoTramites= $estado->getBy("id_estado_tramites='$id_estado_tramites'");
    						$nombre_estado_tramites=$resultEstadoTramites[0]->nombre_estado_tramites;
    			
    						
    						
    						
    						if($tipo_memos_det==1){
    			
    							if($revisado_det=="t"){
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 11px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_p">'.$asunto_memos_cab.'</a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 11px;">'.$nombre.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$fecha_memos_cab.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$nombre_estado_tramites.'</td>';
    								$html.='</tr>';
    									
    									
    							}else{
    									
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 12px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_p"><b>'.$asunto_memos_cab.'</b></a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 12px;"><b>'.$nombre.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$fecha_memos_cab.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$nombre_estado_tramites.'</b></td>';
    								$html.='</tr>';
    							}
    			
    			
    						}
    			
    			
    						if($tipo_memos_det==2){
    								
    							if($revisado_det=="t"){
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 11px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_c">'.$asunto_memos_cab.'</a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 11px;">'.$nombre.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$fecha_memos_cab.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$nombre_estado_tramites.'</td>';
    								$html.='</tr>';
    									
    									
    							}else{
    									
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 12px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_c"><b>'.$asunto_memos_cab.'</b></a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 12px;"><b>'.$nombre.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$fecha_memos_cab.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$nombre_estado_tramites.'</b></td>';
    								$html.='</tr>';
    							}
    								
    								
    						}
    			
    			
    			
    			
    			
    			
    						if($tipo_memos_det==3){
    			
    			
    			
    							if($revisado_det=="t"){
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 11px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_as">'.$asunto_memos_cab.'</a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 11px;">'.$nombre.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$fecha_memos_cab.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$nombre_estado_tramites.'</td>';
    								$html.='</tr>';
    									
    									
    							}else{
    									
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 12px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_as"><b>'.$asunto_memos_cab.'</b></a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 12px;"><b>'.$nombre.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$fecha_memos_cab.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$nombre_estado_tramites.'</b></td>';
    								$html.='</tr>';
    							}
    			
    			
    						}
    			
    			
    						}
    			
    					}
    			
    			
    					$html.='</tbody>';
    					$html.='</table>';
    					$html.='</section></div>';
    					$html.='<div class="table-pagination pull-right">';
    					$html.=''. $this->paginate_imbox("index.php", $page, $total_pages, $adjacents).'';
    					$html.='</div>';
    			
    			
    			
    				}else{
    					$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    					$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    					$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    					$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay memorando recibidos...</b>';
    					$html.='</div>';
    					$html.='</div>';
    				}
    				 
    				 
    				echo $html;
    				die();
    			
    			}
    			
    			
    			
    			
    			
    			
    			
    		}else{
    			
    			// TODOS
    			
    			
    			$where_to="";
    			$columnas = "*";
    			
    			$tablas   = "memos_det";
    			
    			$where    = "1=1 AND memos_det.id_usuarios='$id_usuarios'";
    			
    			$id       = "memos_det.id_memos_det";
    			
    			
    			$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    			$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    			
    			
    			
    			
    			if($action == 'ajax')
    			{
    			
    				if(!empty($search)){
    			
    					$where1="";
    					//$where1=" AND (UPPER(memos_det.numero_memos_cab) LIKE '%".mb_strtoupper($search)."%' )";
    			
    					$where_to=$where.$where1;
    				}else{
    			
    					$where_to=$where;
    			
    				}
    			
    				$html="";
    				$resultSet=$memos_detalle->getCantidad("*", $tablas, $where_to);
    				$cantidadResult=(int)$resultSet[0]->total;
    			
    				$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    			
    				$per_page = 30; //la cantidad de registros que desea mostrar
    				$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    				$offset = ($page - 1) * $per_page;
    			
    				$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    			
    				$resultSet=$memos_detalle->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
    				$count_query   = $cantidadResult;
    				$total_pages = ceil($cantidadResult/$per_page);
    			
    				 
    			
    				if($cantidadResult>0)
    				{
    			
    					$html.='<div class="pull-left">';
    					$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
    					$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>';
    					$html.='</div><br><br>';
    					$html.='<div class="table-responsive mailbox-messages">';
    					$html.='<section style="height:425px; overflow-y:scroll;">';
    					$html.= "<table id='tabla_cargar_imbox' class='tablesorter table table-hover table-striped nowrap'>";
    					$html.= "<thead>";
    					$html.= "<tr class='bg-primary'>";
    					$html.='<th style="text-align: left;  font-size: 14px;"></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>Subject</b></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>From</b></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>Date</b></th>';
    					$html.='<th style="text-align: left;  font-size: 14px;"><b>State</b></th>';
    					$html.='</tr>';
    					$html.='</thead>';
    					$html.='<tbody>';
    			
    					$i=0;
    			
    					foreach ($resultSet as $res)
    					{
    						$i++;
    						$id_memos_cab=$res->id_memos_cab;
    						$revisado_det=$res->revisado_det;
    						$tipo_memos_det= $res->tipo_memos_det;
    			
    						$resultCabeza= $memos_cabeza->getBy("id_memos_cab='$id_memos_cab'");
    						$id=$resultCabeza[0]->id_usuarios;
    						$asunto_memos_cab=$resultCabeza[0]->asunto_memos_cab;
    						$fecha_memos_cab=$resultCabeza[0]->fecha_memos_cab;
    						$id_estado_tramites=$resultCabeza[0]->id_estado_tramites;
    			
    						$resultUsuarios= $usuarios->getBy("id_usuarios='$id'");
    						$nombre=$resultUsuarios[0]->nombre_usuarios;
    			
    						$resultEstadoTramites= $estado->getBy("id_estado_tramites='$id_estado_tramites'");
    						$nombre_estado_tramites=$resultEstadoTramites[0]->nombre_estado_tramites;
    			
    						if($tipo_memos_det==1){
    			
    							if($revisado_det=="t"){
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 11px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_p">'.$asunto_memos_cab.'</a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 11px;">'.$nombre.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$fecha_memos_cab.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$nombre_estado_tramites.'</td>';
    								$html.='</tr>';
    									
    									
    							}else{
    									
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 12px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_p"><b>'.$asunto_memos_cab.'</b></a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 12px;"><b>'.$nombre.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$fecha_memos_cab.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$nombre_estado_tramites.'</b></td>';
    								$html.='</tr>';
    							}
    			
    			
    						}
    			
    			
    						if($tipo_memos_det==2){
    								
    								
    								
    							if($revisado_det=="t"){
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 11px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_c">'.$asunto_memos_cab.'</a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 11px;">'.$nombre.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$fecha_memos_cab.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$nombre_estado_tramites.'</td>';
    								$html.='</tr>';
    									
    									
    							}else{
    									
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 12px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_c"><b>'.$asunto_memos_cab.'</b></a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 12px;"><b>'.$nombre.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$fecha_memos_cab.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$nombre_estado_tramites.'</b></td>';
    								$html.='</tr>';
    							}
    								
    								
    						}
    			
    			
    			
    			
    			
    			
    						if($tipo_memos_det==3){
    			
    			
    			
    							if($revisado_det=="t"){
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 11px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_as">'.$asunto_memos_cab.'</a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 11px;">'.$nombre.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$fecha_memos_cab.'</td>';
    								$html.='<td class="mailbox-date" style="font-size: 11px;">'.$nombre_estado_tramites.'</td>';
    								$html.='</tr>';
    									
    									
    							}else{
    									
    								$html.='<tr>';
    								$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    								$html.='<td class="mailbox-subject" style="font-size: 12px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'&tip=imbox_as"><b>'.$asunto_memos_cab.'</b></a></td>';
    								$html.='<td class="mailbox-name" style="font-size: 12px;"><b>'.$nombre.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$fecha_memos_cab.'</b></td>';
    								$html.='<td class="mailbox-date" style="font-size: 12px;"><b>'.$nombre_estado_tramites.'</b></td>';
    								$html.='</tr>';
    							}
    			
    			
    						}
    			
    			
    					}
    			
    			
    					$html.='</tbody>';
    					$html.='</table>';
    					$html.='</section></div>';
    					$html.='<div class="table-pagination pull-right">';
    					$html.=''. $this->paginate_imbox("index.php", $page, $total_pages, $adjacents).'';
    					$html.='</div>';
    			
    			
    			
    				}else{
    					$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
    					$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
    					$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    					$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay memorando recibidos...</b>';
    					$html.='</div>';
    					$html.='</div>';
    				}
    				 
    				 
    				echo $html;
    				die();
    			
    			}
    			
    			
    			
    			
    		}
    		
    		
    		
    	}else{
    		
    		die();
    	}
    	
    	
    }
    
    
    
    
    
    
    
    
    public function cargar_sent(){
    
    	session_start();
    	$id_usuarios=$_SESSION["id_usuarios"];
    	$memos_cabeza = new MemosCabezaModel();
    	$memos_detalle = new MemosDetalleModel();
    	$usuarios = new UsuariosModel();
    	 
    	
    	
    	$where_to="";
    	$columnas = " memos_cab.id_memos_cab,
    			      memos_cab.fecha_memos_cab, 
					  memos_cab.numero_memos_cab, 
					  memos_cab.asunto_memos_cab,
    			      memos_cab.rev_sec_memos_cab,
					  estado_tramites.nombre_estado_tramites, 
					  usuarios.nombre_usuarios";
    
    	$tablas   = "public.memos_cab, 
					  public.estado_tramites, 
					  public.usuarios";
    
    	$where    = " memos_cab.id_usuarios = usuarios.id_usuarios AND
  					 estado_tramites.id_estado_tramites = memos_cab.id_estado_tramites AND memos_cab.id_usuarios='$id_usuarios'";
    
    	$id       = "memos_cab.id_memos_cab";
    
    
    	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
    	$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
    
    
    
    
    	if($action == 'ajax')
    	{
    
    		if(!empty($search)){
    
    
    			$where1=" AND (UPPER(memos_cab.numero_memos_cab) LIKE '%".mb_strtoupper($search)."%' OR UPPER(memos_cab.asunto_memos_cab) LIKE '%".mb_strtoupper($search)."%' OR UPPER(estado_tramites.nombre_estado_tramites) LIKE '%".mb_strtoupper($search)."%' OR UPPER(usuarios.nombre_usuarios) LIKE '%".mb_strtoupper($search)."%')";
    
    			$where_to=$where.$where1;
    		}else{
    
    			$where_to=$where;
    
    		}
    
    		$html="";
    		$resultSet=$memos_cabeza->getCantidad("*", $tablas, $where_to);
    		$cantidadResult=(int)$resultSet[0]->total;
    
    		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
    
    		$per_page = 30; //la cantidad de registros que desea mostrar
    		$adjacents  = 9; //brecha entre páginas después de varios adyacentes
    		$offset = ($page - 1) * $per_page;
    
    		$limit = " LIMIT   '$per_page' OFFSET '$offset'";
    
    		$resultSet=$memos_cabeza->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
    		$count_query   = $cantidadResult;
    		$total_pages = ceil($cantidadResult/$per_page);
    
    		 
    		
    
    
    		if($cantidadResult>0)
    		{
    
    			$html.='<div class="pull-left">';
    			$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
    			$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>';
    			$html.='</div><br><br>';
    			$html.='<div class="table-responsive mailbox-messages">';
    			$html.='<section style="height:425px; overflow-y:scroll;">';
    			$html.= "<table id='tabla_cargar_sent' class='tablesorter table table-hover table-striped nowrap'>";
    			$html.= "<thead>";
    			$html.= "<tr class='bg-primary'>";
    			$html.='<th style="text-align: left;  font-size: 14px;"></th>';
    			$html.='<th style="text-align: left;  font-size: 14px;"><b>Subject</b></th>';
    			$html.='<th style="text-align: left;  font-size: 14px;"><b>To</b></th>';
    			$html.='<th style="text-align: left;  font-size: 14px;"><b>Date</b></th>';
    			$html.='<th style="text-align: left;  font-size: 14px;"><b>State</b></th>';
    			$html.='</tr>';
    			$html.='</thead>';
    			$html.='<tbody>';
    
    			$i=0;
    
    			foreach ($resultSet as $res)
    			{
    				$i++;
    				$id_memos_cab=$res->id_memos_cab;
    				$nombre_estado_tramites=$res->nombre_estado_tramites;
    				$rev_sec_memos_cab=$res->rev_sec_memos_cab;
    				$resultDetalle= $memos_detalle->getBy("id_memos_cab='$id_memos_cab' AND tipo_memos_det=1");
    				$id=$resultDetalle[0]->id_usuarios;
    				
    				$resultUsuarios= $usuarios->getBy("id_usuarios='$id'");
    				$nombre=$resultUsuarios[0]->nombre_usuarios;
    			
    			
    					$html.='<tr>';
    					$html.='<td style="font-size: 11px;"><input type="checkbox"></td>';
    					$html.='<td class="mailbox-subject" style="font-size: 11px;"><a href="index.php?controller=Memos&action=index_readmail&identi='.$id_memos_cab.'">'.$res->asunto_memos_cab.'</a></td>';
    					$html.='<td class="mailbox-name" style="font-size: 11px;">'.$nombre.'</td>';
    					$html.='<td class="mailbox-date" style="font-size: 11px;">'.$res->fecha_memos_cab.'</td>';
    					$html.='<td class="mailbox-date" style="font-size: 11px;">'.$nombre_estado_tramites.'</td>';
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
    			$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay memorando enviados...</b>';
    			$html.='</div>';
    			$html.='</div>';
    		}
    		 
    		 
    		echo $html;
    		die();
    
    	}
    
    }
    
    
    


    public function paginate_imbox($reload, $page, $tpages, $adjacents) {
    
    	$prevlabel = "&lsaquo; Prev";
    	$nextlabel = "Next &rsaquo;";
    	$out = '<ul class="pagination pagination-large">';
    
    	// previous label
    
    	if($page==1) {
    		$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
    	} else if($page==2) {
    		$out.= "<li><span><a href='javascript:void(0);' onclick='load_imbox(1)'>$prevlabel</a></span></li>";
    	}else {
    		$out.= "<li><span><a href='javascript:void(0);' onclick='load_imbox(".($page-1).")'>$prevlabel</a></span></li>";
    
    	}
    
    	// first label
    	if($page>($adjacents+1)) {
    		$out.= "<li><a href='javascript:void(0);' onclick='load_imbox(1)'>1</a></li>";
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
    			$out.= "<li><a href='javascript:void(0);' onclick='load_imbox(1)'>$i</a></li>";
    		}else {
    			$out.= "<li><a href='javascript:void(0);' onclick='load_imbox(".$i.")'>$i</a></li>";
    		}
    	}
    
    	// interval
    
    	if($page<($tpages-$adjacents-1)) {
    		$out.= "<li><a>...</a></li>";
    	}
    
    	// last
    
    	if($page<($tpages-$adjacents)) {
    		$out.= "<li><a href='javascript:void(0);' onclick='load_imbox($tpages)'>$tpages</a></li>";
    	}
    
    	// next
    
    	if($page<$tpages) {
    		$out.= "<li><span><a href='javascript:void(0);' onclick='load_imbox(".($page+1).")'>$nextlabel</a></span></li>";
    	}else {
    		$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
    	}
    
    	$out.= "</ul>";
    	return $out;
    }
    
    
    
    
    
    
    public function paginate($reload, $page, $tpages, $adjacents) {
    
    	$prevlabel = "&lsaquo; Prev";
    	$nextlabel = "Next &rsaquo;";
    	$out = '<ul class="pagination pagination-large">';
    
    	// previous label
    
    	if($page==1) {
    		$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
    	} else if($page==2) {
    		$out.= "<li><span><a href='javascript:void(0);' onclick='load_sent(1)'>$prevlabel</a></span></li>";
    	}else {
    		$out.= "<li><span><a href='javascript:void(0);' onclick='load_sent(".($page-1).")'>$prevlabel</a></span></li>";
    
    	}
    
    	// first label
    	if($page>($adjacents+1)) {
    		$out.= "<li><a href='javascript:void(0);' onclick='load_sent(1)'>1</a></li>";
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
    			$out.= "<li><a href='javascript:void(0);' onclick='load_sent(1)'>$i</a></li>";
    		}else {
    			$out.= "<li><a href='javascript:void(0);' onclick='load_sent(".$i.")'>$i</a></li>";
    		}
    	}
    
    	// interval
    
    	if($page<($tpages-$adjacents-1)) {
    		$out.= "<li><a>...</a></li>";
    	}
    
    	// last
    
    	if($page<($tpages-$adjacents)) {
    		$out.= "<li><a href='javascript:void(0);' onclick='load_sent($tpages)'>$tpages</a></li>";
    	}
    
    	// next
    
    	if($page<$tpages) {
    		$out.= "<li><span><a href='javascript:void(0);' onclick='load_sent(".($page+1).")'>$nextlabel</a></span></li>";
    	}else {
    		$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
    	}
    
    	$out.= "</ul>";
    	return $out;
    }
    
    
    
    
    
    
    
	
}
?>
