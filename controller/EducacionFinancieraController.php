<?php

class EducacionFinancieraController extends ControladorBase{

	public function __construct() {
		parent::__construct();
		
	}


	
	public function search(){
	
		session_start();
		
		$encuestas_cabeza = new EncuestasCabezaModel();
		$encuestas_detalle = new EncuestasModel();
		$where_to="";
		$columnas = " 
				  encuentas_participes_cabeza.id_encuentas_participes_cabeza,  
				  encuentas_participes_cabeza.id_usuarios, 
				  usuarios.cedula_usuarios, 
				  usuarios.nombre_usuarios, 
				  usuarios.celular_usuarios, 
				  usuarios.correo_usuarios, 
				  usuarios.fotografia_usuarios, 
				  estado.nombre_estado, 
				  encuentas_participes_cabeza.creado";
	
		$tablas   = "public.usuarios, 
				  public.encuentas_participes_cabeza, 
				  public.estado";
	
		$where    = "encuentas_participes_cabeza.id_usuarios = usuarios.id_usuarios AND
  				  estado.id_estado = usuarios.id_estado";
	
		$id       = "encuentas_participes_cabeza.id_encuentas_participes_cabeza";
	
		 
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
		$desde=  (isset($_REQUEST['desde'])&& $_REQUEST['desde'] !=NULL)?$_REQUEST['desde']:'';
		$hasta=  (isset($_REQUEST['hasta'])&& $_REQUEST['hasta'] !=NULL)?$_REQUEST['hasta']:'';
		 
		$where2="";
		 
		 
		if($action == 'ajax')
		{
	
			if(!empty($search)){
	
				
				if($desde!="" && $hasta!=""){
					
					$where2=" AND DATE(encuentas_participes_cabeza.creado)  BETWEEN '$desde' AND '$hasta'";
					
					
				}
	
				$where1=" AND (usuarios.cedula_usuarios LIKE '".$search."%' OR usuarios.nombre_usuarios LIKE '".$search."%' OR usuarios.correo_usuarios LIKE '".$search."%' OR usuarios.celular_usuarios LIKE '".$search."%' )";
	
				$where_to=$where.$where1.$where2;
			}else{
				if($desde!="" && $hasta!=""){
						
					$where2=" AND DATE(encuentas_participes_cabeza.creado)  BETWEEN '$desde' AND '$hasta'";	
						
				}
				
				$where_to=$where.$where2;
	
			}
	
			$html="";
			$resultSet=$encuestas_cabeza->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$encuestas_cabeza->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
				$html.= "<table id='tabla_encuestas_realizadas' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Nombre</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Fecha Encuesta</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Ver Encuesta</th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
				 
				$i=0;
	
				foreach ($resultSet as $res)
				{
					$i++;
					$html.='<tr>';
					$html.='<td style="font-size: 11px;">'.$i.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->cedula_usuarios.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->correo_usuarios.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->celular_usuarios.'</td>';
					$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
					$html.='<td style="font-size: 11px;"><a href="index.php?controller=Encuestas&action=print_enc&id_encuestas='.$res->id_encuentas_participes_cabeza.'" target="_blank" class="btn btn-warning" style="font-size:85%;"><i class="glyphicon glyphicon-eye-open"></i></a></td>';
					$html.='</tr>';
				}
	
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_load_encuestas_realizadas("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	 
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay encuestas registradas...</b>';
				$html.='</div>';
				$html.='</div>';
			}
			 
			 
			 
	
			echo $html;
			die();
	
		}
	
	
	}
	
	
	
	
	
	
	
	public function index(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			
			$eduacion_financiera_cabeza = new EducacionFinancieraCabezaModel();
			$eduacion_financiera_detalle = new EducacionFinancieraDetalleModel();
			$preguntas_educacion_financiera = new PreguntasEducacionFinancieraModel();
	
			$contador=0;
			$pregunta_1 = "";
			$pregunta_2 = "";
			$pregunta_3 = "";
			$pregunta_4 = "";
			$pregunta_5 = "";
			$pregunta_6 = "";
			$pregunta_7 = "";
			$pregunta_8 = "";
			
			$id_pregunta_1 = "";
			$id_pregunta_2 = "";
			$id_pregunta_3 = "";
			$id_pregunta_4 = "";
			$id_pregunta_5 = "";
			$id_pregunta_6 = "";
			$id_pregunta_7 = "";
			$id_pregunta_8 = "";
			
			$nombre_controladores = "EducacionFinanciera";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $eduacion_financiera_cabeza->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
					
				$columnas="id_preguntas_educacion_financiera, nombre_preguntas_educacion_financiera";
				$tablas="preguntas_educacion_financiera";
				$where="1=1";
				$id="id_preguntas_educacion_financiera";
				$resultPreguntas=$preguntas_educacion_financiera->getCondiciones($columnas, $tablas, $where, $id);
				
				
				
				if(!empty($resultPreguntas)){
					
					foreach ($resultPreguntas as $res){
						
						$contador++;
						
						if($contador==1){
						    $id_pregunta_1=$res->id_preguntas_educacion_financiera;
						    $pregunta_1=$res->nombre_preguntas_educacion_financiera;
							
						}else if($contador==2){
						    $id_pregunta_2=$res->id_preguntas_educacion_financiera;
						    $pregunta_2=$res->nombre_preguntas_educacion_financiera;
							
						}
						else if($contador==3){
						    $id_pregunta_3=$res->id_preguntas_educacion_financiera;
							$pregunta_3=$res->nombre_preguntas_educacion_financiera;
								
						}else if($contador==4){
						    $id_pregunta_4=$res->id_preguntas_educacion_financiera;
						    $pregunta_4=$res->nombre_preguntas_educacion_financiera;
							
						}else if($contador==5){
						    $id_pregunta_5=$res->id_preguntas_educacion_financiera;
						    $pregunta_5=$res->nombre_preguntas_educacion_financiera;
							
						}else if($contador==6){
						    $id_pregunta_6=$res->id_preguntas_educacion_financiera;
						    $pregunta_6=$res->nombre_preguntas_educacion_financiera;
							
						}else if($contador==7){
						    $id_pregunta_7=$res->id_preguntas_educacion_financiera;
						    $pregunta_7=$res->nombre_preguntas_educacion_financiera;
							
						}else if($contador==8){
						    $id_pregunta_8=$res->id_preguntas_educacion_financiera;
						    $pregunta_8=$res->nombre_preguntas_educacion_financiera;
							
						}
						
					}
					
				}
				
				
					
				$this->view("EducacionFinanciera",array(
						"pregunta_1"=>$pregunta_1, "pregunta_2"=>$pregunta_2, "pregunta_3"=>$pregunta_3,
						"pregunta_4"=>$pregunta_4, "pregunta_5"=>$pregunta_5, "pregunta_6"=>$pregunta_6,
						"pregunta_7"=>$pregunta_7, "pregunta_8"=>$pregunta_8,
						"id_pregunta_1"=>$id_pregunta_1, "id_pregunta_2"=>$id_pregunta_2, "id_pregunta_3"=>$id_pregunta_3,
						"id_pregunta_4"=>$id_pregunta_4, "id_pregunta_5"=>$id_pregunta_5, "id_pregunta_6"=>$id_pregunta_6,
						"id_pregunta_7"=>$id_pregunta_7, "id_pregunta_8"=>$id_pregunta_8
						
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Educación Financiera"
		
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
	
	
	
	
	
	
	
	public function index2(){
		
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
				
		    $eduacion_financiera_cabeza = new EducacionFinancieraCabezaModel();
		    $eduacion_financiera_detalle = new EducacionFinancieraDetalleModel();
		    $preguntas_educacion_financiera = new PreguntasEducacionFinancieraModel();
	
			$nombre_controladores = "EducacionFinanciera";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $eduacion_financiera_cabeza->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
					
				$this->view("ConsultaEducacionFinanciera",array(
						"resultSet"=>"", "total"=>""
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Educación Financiera"
	
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
	


	public function InsertaEducacionFinanciera(){
	
		session_start();
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
			$usuarios = new UsuariosModel();
			$eduacion_financiera_cabeza = new EducacionFinancieraCabezaModel();
			$eduacion_financiera_detalle = new EducacionFinancieraDetalleModel();
				
			if ( isset($_POST["pregunta_1"]) )
			{
				
				$_id_usuarios = $_SESSION['id_usuarios'];
				$_pregunta_1    = $_POST["pregunta_1"];
				$_pregunta_2    = $_POST["pregunta_2"];
				$_pregunta_3    = $_POST["pregunta_3"];
				$_pregunta_4    = $_POST["pregunta_4"];
				/*$_pregunta_5    = $_POST["pregunta_5"];
				$_pregunta_6    = $_POST["pregunta_6"];
				$_pregunta_7    = $_POST["pregunta_7"];
				$_pregunta_8    = $_POST["pregunta_8"];
				*/
				
				$_respuesta_pregunta_1    = $_POST["respuesta_pregunta_1"];
				$_respuesta_pregunta_2    = $_POST["respuesta_pregunta_2"];
				$_respuesta_pregunta_3    = $_POST["respuesta_pregunta_3"];
				$_respuesta_pregunta_4    = $_POST["respuesta_pregunta_4"];
				/*$_respuesta_pregunta_5    = $_POST["respuesta_pregunta_5"];
				$_respuesta_pregunta_6    = $_POST["respuesta_pregunta_6"];
				$_respuesta_pregunta_7    = $_POST["respuesta_pregunta_7"];
				$_respuesta_pregunta_8    = $_POST["respuesta_pregunta_8"];
				
				
				$_comentario_respuesta_1    = $_POST["comentario_respuesta_1"];
				$_comentario_respuesta_2    = $_POST["comentario_respuesta_2"];
				$_comentario_respuesta_3    = $_POST["comentario_respuesta_3"];
				$_comentario_respuesta_4    = $_POST["comentario_respuesta_4"];
				$_comentario_respuesta_5    = $_POST["comentario_respuesta_5"];
				$_comentario_respuesta_6    = $_POST["comentario_respuesta_6"];
				$_comentario_respuesta_7    = $_POST["comentario_respuesta_7"];
				$_comentario_respuesta_8    = $_POST["comentario_respuesta_8"];
				*/
				
				
				
	
				try {
					
					$funcion = "public.ins_educacion_financiera_cabeza";
					$parametros = "'$_id_usuarios'";
					$eduacion_financiera_cabeza->setFuncion($funcion);
					$eduacion_financiera_cabeza->setParametros($parametros);
					$resultado=$eduacion_financiera_cabeza->Insert();
					
					
					$resultEducacionFinancieraCabeza= $eduacion_financiera_cabeza->getBy("id_usuarios='$_id_usuarios' order by id_educacion_financiera_cabeza DESC");
					$id_educacion_financiera_cabeza=$resultEducacionFinancieraCabeza[0]->id_educacion_financiera_cabeza;
					
					
				} catch (Exception $e) {
						
					echo "Error al Insertar Educación Financiera Cabeza";
    				die();
						
				}
	
	
				
				
				if ($id_educacion_financiera_cabeza > 0){
					
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_1', '$_respuesta_pregunta_1'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 1";
						die();
						
					}
					
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_2', '$_respuesta_pregunta_2'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 2";
						die();
					
					}
					
					
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_3', '$_respuesta_pregunta_3'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 3";
						die();
					
					}
						
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_4', '$_respuesta_pregunta_4'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 4";
						die();
							
					}
					
					/*
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_5', '$_respuesta_pregunta_5'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 5";
						die();
							
					}
					
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_6', '$_respuesta_pregunta_6'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 6";
						die();
							
					}
					
					
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_7', '$_respuesta_pregunta_7'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 7";
						die();
							
					}
						
					try {
						$funcion = "public.ins_educacion_financiera_detalle";
						$parametros = "'$id_educacion_financiera_cabeza', '$_id_usuarios', '$_pregunta_8', '$_respuesta_pregunta_8'";
						$eduacion_financiera_detalle->setFuncion($funcion);
						$eduacion_financiera_detalle->setParametros($parametros);
						$resultado=$eduacion_financiera_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Educación Financiera Detalle 8";
						die();
							
					}
					*/
					
				}else{
					
					$this->redirect("EducacionFinanciera", "index");
					
				}
	
	
					
					
				$this->redirect("Usuarios", "Bienvenida");
	
	
			}
			else
			{
	
				$this->redirect("Usuarios", "Bienvenida");
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
	
	
	
	public function cargar_educacion_financiera(){
	
		session_start();
		$id_rol=$_SESSION["id_rol"];
		$i=0;
	    $encuestas = new EncuestasCabezaModel();
		$columnas = "id_encuentas_participes_cabeza";
		$tablas   = "public.encuentas_participes_cabeza";
		$where    = "1=1";
		$id       = "id_encuentas_participes_cabeza";
		$resultSet = $encuestas->getCondiciones($columnas ,$tablas ,$where, $id);
	
		$i=count($resultSet);
	
		$html="";
		if($i>0)
		{
	
			$html .= "<div class='col-lg-3 col-xs-12'>";
			$html .= "<div class='small-box bg-yellow'>";
			$html .= "<div class='inner'>";
			$html .= "<h3>$i</h3>";
			$html .= "<p>Encuestas Realizadas.</p>";
			$html .= "</div>";
			$html .= "<div class='icon'>";
			$html .= "<i class='ion ion-pie-graph'></i>";
			$html .= "</div>";
				
			if($id_rol==1 || $id_rol==43 || $id_rol==45){
				$html .= "<a href='index.php?controller=Encuestas&action=index2' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
			}else{
				$html .= "<a href='#' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
			}
			$html .= "</div>";
			$html .= "</div>";
	
	
		}else{
	
			$html = "<b>Actualmente no hay encuestas realizadas...</b>";
		}
	
		echo $html;
		die();
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function paginate_load_encuestas_realizadas($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_encuestas_realizadas(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_encuestas_realizadas(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_encuestas_realizadas(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_encuestas_realizadas(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_encuestas_realizadas(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_encuestas_realizadas($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_encuestas_realizadas(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	public function print_enc()
	{
	
		session_start();
		$usuarios= new UsuariosModel();
	
		$encuestas_cabeza = new EncuestasCabezaModel();
		$encuestas_detalle = new EncuestasModel();
		
		$html="";
	
	
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
		$fechaactual = getdate();
		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$fechaactual=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
		 
		$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/webcapremci';
		$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';
		$domLogo=$directorio.'/view/images/lcaprem.png';
		$logo = '<img src="'.$domLogo.'" alt="Responsive image" width="200" height="50">';
		 
	
	
		if(!empty($cedula_usuarios)){
				
	
			if(isset($_GET["id_encuestas"])){
	
				    $id_encuestas=$_GET["id_encuestas"];
						
					$columnas_encuestas_cabec ="encuentas_participes_cabeza.id_encuentas_participes_cabeza, encuentas_participes_cabeza.id_usuarios, 
											  usuarios.cedula_usuarios, 
											  usuarios.nombre_usuarios, 
											  usuarios.celular_usuarios, 
											  usuarios.correo_usuarios, 
											  usuarios.fotografia_usuarios, 
											  estado.nombre_estado, 
											  encuentas_participes_cabeza.creado";
					$tablas_encuestas_cabec="public.usuarios, 
										  public.encuentas_participes_cabeza, 
										  public.estado";
					$where_encuestas_cabec="encuentas_participes_cabeza.id_usuarios = usuarios.id_usuarios AND
  											estado.id_estado = usuarios.id_estado AND encuentas_participes_cabeza.id_encuentas_participes_cabeza='$id_encuestas'";
					$id_encuestas_cabec="encuentas_participes_cabeza.id_encuentas_participes_cabeza";
					$resultEncuestas_Cabec=$encuestas_cabeza->getCondicionesDesc($columnas_encuestas_cabec, $tablas_encuestas_cabec, $where_encuestas_cabec, $id_encuestas_cabec);
	
						
	
					if(!empty($resultEncuestas_Cabec)){
							
						$_id_encuentas_participes_cabeza=$resultEncuestas_Cabec[0]->id_encuentas_participes_cabeza;
						$_id_usuarios=$resultEncuestas_Cabec[0]->id_usuarios;
						$_fecha_encuesta=date("d/m/Y", strtotime($resultEncuestas_Cabec[0]->creado));
						$_nombre_usuarios=$resultEncuestas_Cabec[0]->nombre_usuarios;
						$_cedula_usuarios=$resultEncuestas_Cabec[0]->cedula_usuarios;
						
							
						if($_id_encuentas_participes_cabeza > 0 && $_id_usuarios > 0){
	
							$columnas_encuestas_detall =" encuentas_participes_detalle.id_preguntas_encuestas_participes, 
														  preguntas_encuestas_participes.nombre_preguntas_encuestas_participes, 
														  encuentas_participes_detalle.respuestas_encuestas_participes, 
														  encuentas_participes_detalle.comentario_encuestas_participes";
								
							$tablas_encuestas_detall="public.encuentas_participes_detalle, 
 													 public.preguntas_encuestas_participes";
							$where_encuestas_detall="preguntas_encuestas_participes.id_preguntas_encuestas_participes = encuentas_participes_detalle.id_preguntas_encuestas_participes
							AND encuentas_participes_detalle.id_encuentas_participes_cabeza='$_id_encuentas_participes_cabeza'";
							$id_encuestas_detall="encuentas_participes_detalle.id_preguntas_encuestas_participes";
							$resultSet=$encuestas_detalle->getCondiciones($columnas_encuestas_detall, $tablas_encuestas_detall, $where_encuestas_detall, $id_encuestas_detall);
	
							
							
							
								
							$html.='<p style="text-align: right;">'.$logo.'<hr style="height: 2px; background-color: black;"></p>';
							$html.='<p style="text-align: right; font-size: 13px;"><b>Impreso:</b> '.$fechaactual.'</p>';
							$html.='<p style="text-align: center; font-size: 16px;"><b>ENCUESTA SERVICIOS ONLINE</b></p>';
	
							$html.= '<p style="margin-top:15px; text-align: justify; font-size: 13px;"><b>NOMBRES:</b> '.$_nombre_usuarios.'  <b style="margin-left: 20%; font-size: 13px;">IDENTIFICACIÓN:</b> '.$_cedula_usuarios.'</p>';
	                        $html.= '<p style="margin-top:15px; text-align: justify; font-size: 13px;"><b>ENCUESTA REALIZADA EL:</b> '.$_fecha_encuesta.'</p>';
							
	                        
	                        if (!empty($resultSet)){
	                        	
	                        	$pregunta="";
	                        	$respuesta="";
	                        	$comentario="";
	                        	
		                        foreach ($resultSet as $res){
		                       
		                        $numero = $res->id_preguntas_encuestas_participes;
		                        $pregunta = $res->nombre_preguntas_encuestas_participes;
		                        $respuesta = $res->respuestas_encuestas_participes;
		                        $comentario = $res->comentario_encuestas_participes;
		                        
		                        
		                        if($numero==1){
		                        
		                        	$html.= "<b>$pregunta</b>";
		                        	
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	
		                        	if($respuesta=='Bueno'){
		                        		
		                        	$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Bueno</u></b></th>';
		                        		 
		                        	}else{
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Bueno</th>';
		                        		 
		                        	}	
		                        	
		                        	if($respuesta=='Intermedio'){
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Intermedio</u></b></th>';
		                        		 
		                        	}else{
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Intermedio</th>';
		                        		 
		                        	}
		                        	 
		                        	
		                        	if($respuesta=='Malo'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Malo</u></b></th>';
		                        		 
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Malo</th>';
		                        		 
		                        	}
			                    $html.='</tr>';
			                    
			                    
			                    if($comentario!=''){
			                    
			                    $html.= '<tr>';
			                    $html.='<td  colspan="3" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
			                    $html.='</tr>';
			                    
			                    }
			                    
			                    $html.='</table>';
		                        
		                        } elseif ($numero==2){
		                        	
		                        	$html.= "<br>";
		                        	$html.= "<b>$pregunta</b>";
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	
		                        	if($respuesta=='Si'){
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Si</u></b></th>';
		                        		 
		                        	}else{
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Si</th>';
		                        		
		                        	}
		                        	
		                        	
		                        	if($respuesta=='Algo'){
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Algo</u></b></th>';
		                        		 
		                        	}else{
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Algo</th>';
		                        	
		                        	}
		                        	
		                        	
		                        	if($respuesta=='Nada'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Nada</u></b></th>';
		                        		 
		                        	}else{
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Nada</th>';
		                        		 
		                        	}
		                        	
		                        	$html.='</tr>';
		                        	
		                        	if($comentario!=''){
		                        	
		                        	$html.= '<tr>';
		                        	$html.='<td  colspan="3" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
		                        	$html.='</tr>';
		                        	}
		                        	$html.='</table>';
		                        }
		                        
		                        elseif ($numero==3){
		                        	$html.= "<br>";
		                        	$html.= "<b>$pregunta</b>";
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	
		                        	if($respuesta=='Los Colores'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Los Colores</u></b></th>';
		                        		 
		                        	}else{
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Los Colores</th>';
		                        		 
		                        	}
		                        	
		                        	if($respuesta=='La Información'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>La Información</u></b></th>';
		                        		 
		                        	}else{
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">La Información</th>';
		                        		 
		                        	}
		                        	
		                        	if($respuesta=='Las Imágenes'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Las Imágenes</u></b></th>';
		                        		 
		                        	}else{
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Las Imágenes</th>';
		                        		 
		                        	}
		                        	
		                        	if($respuesta=='Nada'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Nada</u></b></th>';
		                        		 
		                        	}else{
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Nada</th>';
		                        		 
		                        	}
		                        	
		                        	$html.='</tr>';
		                        	 
		                        	
		                        	if($comentario!=''){
		                        	$html.= '<tr>';
		                        	$html.='<td  colspan="4" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
		                        	$html.='</tr>';
		                        	}
		                        	$html.='</table>';
		                        	
		                        	 
		                        }
		                        
		                        elseif ($numero==4){
		                        	$html.= "<br>";
		                        	$html.= "<b>$pregunta</b>";
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	
		                        	if($respuesta=='1'){
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>1</u></b></th>';
		                        	}else{
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">1</th>';
		                        	}
		                        	
		                        	if($respuesta=='2'){
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>2</u></b></th>';
		                        	}else{
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">2</th>';
		                        	}
		                        	
		                        	if($respuesta=='3'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>3</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">3</th>';
		                        	}
		                        	
		                        	if($respuesta=='4'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>4</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">4</th>';
		                        	}
		                        	
		                        	if($respuesta=='5'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>5</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">5</th>';
		                        	}
		                        	
		                        	if($respuesta=='6'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>6</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">6</th>';
		                        	}
		                        	
		                        	if($respuesta=='7'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>7</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">7</th>';
		                        	}
		                        	
		                        	if($respuesta=='8'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>8</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">8</th>';
		                        	}
		                        	
		                        	if($respuesta=='9'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>9</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">9</th>';
		                        	}
		                        	
		                        	if($respuesta=='10'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>10</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">10</th>';
		                        	}
		                        	 
		                        	$html.='</tr>';
		                        	 
		                        	if($comentario!=''){
		                        	$html.= '<tr>';
		                        	$html.='<td  colspan="10" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
		                        	$html.='</tr>';
		                        	}
		                        	$html.='</table>';
		                        	
		                        	
		                        }elseif ($numero==5){
		                        	$html.= "<br>";
		                        	$html.= "<b>$pregunta</b>";
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	
		                        	if($respuesta=='Si'){
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Si</u></b></th>';
		                        	}else{
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Si</th>';
		                        	}
		                        	
		                        	if($respuesta=='Intermedio'){
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Intermedio</u></b></th>';
		                        	}else{
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Intermedio</th>';
		                        	}
		                        	
		                        	
		                        	if($respuesta=='No'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>No</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">No</th>';
		                        	}
		                        	
		                        	$html.='</tr>';
		                        	 
		                        	if($comentario!=''){
		                        	
		                        	$html.= '<tr>';
		                        	$html.='<td  colspan="3" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
		                        	$html.='</tr>';
		                        	}
		                        	$html.='</table>';
		                        	
		                        	
		                        }elseif ($numero==6){
		                        	$html.= "<br>";
		                        	$html.= "<b>$pregunta</b>";
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	
		                        	if($respuesta=='Si'){
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Si</u></b></th>';
		                        		 
		                        	}else {
		                        		
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Si</th>';
		                        	}
		                        	
		                        	if($respuesta=='No'){
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>No</u></b></th>';
		                        		 
		                        	}else {
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">No</th>';
		                        	}
		                        	
		                        	$html.='</tr>';
		                        	
		                        	if($comentario!=''){
		                        	
		                        	$html.= '<tr>';
		                        	$html.='<td  colspan="2" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
		                        	$html.='</tr>';
		                        	}
		                        	$html.='</table>';
		                        	
		                        }elseif ($numero==7){
		                        	$html.= "<br>";
		                        	$html.= "<b>$pregunta</b>";
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	if($respuesta=='Si'){
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Si</u></b></th>';
		                        		 
		                        	}else {
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Si</th>';
		                        	}
		                        	 
		                        	if($respuesta=='No'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>No</u></b></th>';
		                        		 
		                        	}else {
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">No</th>';
		                        	}
		                        	$html.='</tr>';
		                        	 
		                        	if($comentario!=''){
		                        	
		                        	$html.= '<tr>';
		                        	$html.='<td  colspan="2" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
		                        	$html.='</tr>';
		                        	}
		                        	$html.='</table>';
		                        	
		                        }elseif ($numero==8){
		                        	$html.= "<br>";
		                        	$html.= "<b>$pregunta</b>";
		                        	$html.= "<table style='width: 100%; margin-top:10px;'>";
		                        	$html.= '<tr>';
		                        	if($respuesta=='Si'){
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Si</u></b></th>';
		                        	}else{
		                        	
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Si</th>';
		                        	}
		                        	 
		                        	if($respuesta=='Intermedio'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>Intermedio</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">Intermedio</th>';
		                        	}
		                        	 
		                        	 
		                        	if($respuesta=='No'){
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;"><b><u>No</u></b></th>';
		                        	}else{
		                        		 
		                        		$html.='<th style="text-align: center;  font-size: 15px; font-weight: normal;">No</th>';
		                        	}
		                        	 
		                        	$html.='</tr>';
		                        	 
		                        	if($comentario!=''){
		                        	
		                        	$html.= '<tr>';
		                        	$html.='<td  colspan="3" style="text-align: justify;  font-size: 15px;"><b>Porque:</b> '.$comentario.'</td>';
		                        	$html.='</tr>';
		                        	}
		                        	$html.='</table>';
		                        	
		                        	
		                        }
		                        
		                        
		                         
		                        }	
		                       
		                        
	                        }
	                        
						}
							
					}
	
						
					$this->report("Encuestas",array( "resultSet"=>$html));
					die();
						
						
						
						
				
	
	
	
			}else{
	
				$this->redirect("Usuarios","sesion_caducada");
	
			}
				
	
		}else{
	
			$this->redirect("Usuarios","sesion_caducada");
	
		}
	
	}
	
	
	
	
	
	
	
	
}
?>