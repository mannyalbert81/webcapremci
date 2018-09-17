<?php

class EncuestasController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	
	public function search(){
	
		session_start();
		$afiliacion = new AfiliadoRecomendacionModel();
		$where_to="";
		$columnas = " usuarios.cedula_usuarios, 
				  usuarios.nombre_usuarios, 
				  afiliado_recomendacion.cedula, 
				  afiliado_recomendacion.nombre, 
				  afiliado_recomendacion.direccion, 
				  afiliado_recomendacion.telefono, 
				  afiliado_recomendacion.celular, 
				  afiliado_recomendacion.correo, 
				  afiliado_recomendacion.edad, 
				  afiliado_recomendacion.hijos, 
				  afiliado_recomendacion.sueldo, 
				  afiliado_recomendacion.fecha_ingreso, 
				  parroquias.nombre_parroquias, 
				  provincias.nombre_provincias, 
				  cantones.nombre_cantones, 
				  tipo_sangre.nombre_tipo_sangre, 
				  sexo.nombre_sexo, 
				  estado_civil.nombre_estado_civil, 
				  entidades.nombre_entidades,
				  afiliado_recomendacion.creado";
	
		$tablas   = "public.afiliado_recomendacion, 
				  public.usuarios, 
				  public.parroquias, 
				  public.provincias, 
				  public.cantones, 
				  public.sexo, 
				  public.tipo_sangre, 
				  public.estado_civil, 
				  public.entidades";
	
		$where    = "
				  afiliado_recomendacion.id_provincias_asignacion = provincias.id_provincias AND
				  afiliado_recomendacion.id_cantones_asignacion = cantones.id_cantones AND
				  afiliado_recomendacion.id_parroquias_asignacion = parroquias.id_parroquias AND
				  usuarios.id_usuarios = afiliado_recomendacion.id_usuarios_sugiere AND
				  sexo.id_sexo = afiliado_recomendacion.id_sexo AND
				  tipo_sangre.id_tipo_sangre = afiliado_recomendacion.id_tipo_sangre AND
				  estado_civil.id_estado_civil = afiliado_recomendacion.id_estado_civil AND
				  entidades.id_entidades = afiliado_recomendacion.id_entidades";
	
		$id       = "afiliado_recomendacion.id_afiliado_recomendacion";
	
		 
		 
		 
		 
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
		$desde=  (isset($_REQUEST['desde'])&& $_REQUEST['desde'] !=NULL)?$_REQUEST['desde']:'';
		$hasta=  (isset($_REQUEST['hasta'])&& $_REQUEST['hasta'] !=NULL)?$_REQUEST['hasta']:'';
		 
		$where2="";
		 
		 
		if($action == 'ajax')
		{
	
			if(!empty($search)){
	
				
				if($desde!="" && $hasta!=""){
					
					$where2=" AND DATE(afiliado_recomendacion.creado)  BETWEEN '$desde' AND '$hasta'";
					
					
				}
	
				$where1=" AND (usuarios.cedula_usuarios LIKE '".$search."%' OR usuarios.nombre_usuarios LIKE '".$search."%' OR usuarios.correo_usuarios LIKE '".$search."%' OR afiliado_recomendacion.cedula_usuarios LIKE '".$search."%' OR afiliado_recomendacion.nombre_usuarios LIKE '".$search."%' OR afiliado_recomendacion.correo_usuarios LIKE '".$search."%')";
	
				$where_to=$where.$where1.$where2;
			}else{
				if($desde!="" && $hasta!=""){
						
					$where2=" AND DATE(afiliado_recomendacion.creado)  BETWEEN '$desde' AND '$hasta'";	
						
				}
				
				$where_to=$where.$where2;
	
			}
	
			$html="";
			$resultSet=$afiliacion->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$afiliacion->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
				$html.= "<table id='tabla_afiliaciones_recomendadas' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Cedula Sugiere</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Nombre Sugiere</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Cedula</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Nombre</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Fuerza</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Sueldo</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Edad</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Hijos</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Provincia Asig.</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Cantón Asig.</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Parroquia Asig.</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Creado</th>';
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
					$html.='<td style="font-size: 11px;">'.$res->cedula.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre.'</td>';
					
					$html.='<td style="font-size: 11px;">'.$res->correo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->celular.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_entidades.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->sueldo.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->edad.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->hijos.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_provincias.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_cantones.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_parroquias.'</td>';
					
					$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
					$html.='</tr>';
				}
	
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_load_afiliaciones_recomendadas("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	 
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay afiliaciones recomendadas registradas...</b>';
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
			
			$encuestas = new EncuestasModel();
			$preguntas = new PreguntasEncuentasModel();
	
			$contador=0;
			$pregunta_1 = "";
			$pregunta_2 = "";
			$pregunta_3 = "";
			$pregunta_4 = "";
			$pregunta_5 = "";
			$pregunta_6 = "";
			$pregunta_8 = "";
			$pregunta_8 = "";
			
			$id_pregunta_1 = "";
			$id_pregunta_2 = "";
			$id_pregunta_3 = "";
			$id_pregunta_4 = "";
			$id_pregunta_5 = "";
			$id_pregunta_6 = "";
			$id_pregunta_8 = "";
			$id_pregunta_8 = "";
			
			$nombre_controladores = "Encuestas";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $encuestas->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
					
				$columnas="id_preguntas_encuestas_participes, nombre_preguntas_encuestas_participes";
				$tablas="preguntas_encuestas_participes";
				$where="1=1";
				$id="id_preguntas_encuestas_participes";
				$resultPreguntas=$preguntas->getCondiciones($columnas, $tablas, $where, $id);
				
				
				
				if(!empty($resultPreguntas)){
					
					foreach ($resultPreguntas as $res){
						
						$contador++;
						
						if($contador==1){
							$id_pregunta_1=$res->id_preguntas_encuestas_participes;
							$pregunta_1=$res->nombre_preguntas_encuestas_participes;
							
						}else if($contador==2){
							$id_pregunta_2=$res->id_preguntas_encuestas_participes;
							$pregunta_2=$res->nombre_preguntas_encuestas_participes;
							
						}
						else if($contador==3){
							$id_pregunta_3=$res->id_preguntas_encuestas_participes;
							$pregunta_3=$res->nombre_preguntas_encuestas_participes;
								
						}else if($contador==4){
							$id_pregunta_4=$res->id_preguntas_encuestas_participes;
							$pregunta_4=$res->nombre_preguntas_encuestas_participes;
							
						}else if($contador==5){
							$id_pregunta_5=$res->id_preguntas_encuestas_participes;
							$pregunta_5=$res->nombre_preguntas_encuestas_participes;
							
						}else if($contador==6){
							$id_pregunta_6=$res->id_preguntas_encuestas_participes;
							$pregunta_6=$res->nombre_preguntas_encuestas_participes;
							
						}else if($contador==7){
							$id_pregunta_7=$res->id_preguntas_encuestas_participes;
							$pregunta_7=$res->nombre_preguntas_encuestas_participes;
							
						}else if($contador==8){
							$id_pregunta_8=$res->id_preguntas_encuestas_participes;
							$pregunta_8=$res->nombre_preguntas_encuestas_participes;
							
						}
						
					}
					
				}
				
				
				
				
				
				
					
				$this->view("Encuestas",array(
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
						"resultado"=>"No tiene Permisos de Acceso a ser Encuestado"
		
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
				
			$encuestas = new EncuestasModel();
	
			$nombre_controladores = "Encuestas";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $encuestas->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
	
					
					
				$this->view("ConsultaEncuestas",array(
						"resultSexo"=>""
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Encuestas"
	
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
	
	
	
	
	
	
	
	
	


	public function InsertaEncuestas(){
	
		session_start();
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
			$usuarios = new UsuariosModel();
			$encuestas_detalle = new EncuestasModel();
			$encuestas_cabeza = new EncuestasCabezaModel();
				
			if ( isset($_POST["pregunta_1"]) )
			{
				
				$_id_usuarios = $_SESSION['id_usuarios'];
				$_pregunta_1    = $_POST["pregunta_1"];
				$_pregunta_2    = $_POST["pregunta_2"];
				$_pregunta_3    = $_POST["pregunta_3"];
				$_pregunta_4    = $_POST["pregunta_4"];
				$_pregunta_5    = $_POST["pregunta_5"];
				$_pregunta_6    = $_POST["pregunta_6"];
				$_pregunta_7    = $_POST["pregunta_7"];
				$_pregunta_8    = $_POST["pregunta_8"];
				
				$_respuesta_pregunta_1    = $_POST["respuesta_pregunta_1"];
				$_respuesta_pregunta_2    = $_POST["respuesta_pregunta_2"];
				$_respuesta_pregunta_3    = $_POST["respuesta_pregunta_3"];
				$_respuesta_pregunta_4    = $_POST["respuesta_pregunta_4"];
				$_respuesta_pregunta_5    = $_POST["respuesta_pregunta_5"];
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
				
				
				
				
				
	
	
	
				try {
					
					
					$funcion = "public.ins_encuentas_participes_cabeza";
					$parametros = "'$_id_usuarios'";
					$encuestas_cabeza->setFuncion($funcion);
					$encuestas_cabeza->setParametros($parametros);
					$resultado=$encuestas_cabeza->Insert();
					
					
					
					$resultEncuestasCabeza= $encuestas_cabeza->getBy("id_usuarios='$_id_usuarios' order by id_encuentas_participes_cabeza DESC");
					$id_encuentas_participes_cabeza=$resultEncuestasCabeza[0]->id_encuentas_participes_cabeza;
					
					
					
					
				} catch (Exception $e) {
						
					echo "Error al Insertar Encuestas Cabeza";
    				die();
						
				}
	
	
				
				
				if ($id_encuentas_participes_cabeza > 0){
					
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_1', '$_id_usuarios', '$_respuesta_pregunta_1', '$_comentario_respuesta_1', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 1";
						die();
						
					}
					
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_2', '$_id_usuarios', '$_respuesta_pregunta_2', '$_comentario_respuesta_2', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 2";
						die();
					
					}
					
					
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_3', '$_id_usuarios', '$_respuesta_pregunta_3', '$_comentario_respuesta_3', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 3";
						die();
					
					}
						
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_4', '$_id_usuarios', '$_respuesta_pregunta_4', '$_comentario_respuesta_4', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 4";
						die();
							
					}
					
					
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_5', '$_id_usuarios', '$_respuesta_pregunta_5', '$_comentario_respuesta_5', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 5";
						die();
							
					}
					
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_6', '$_id_usuarios', '$_respuesta_pregunta_6', '$_comentario_respuesta_6', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 6";
						die();
							
					}
					
					
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_7', '$_id_usuarios', '$_respuesta_pregunta_7', '$_comentario_respuesta_7', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 7";
						die();
							
					}
						
					try {
						$funcion = "public.ins_encuentas_participes_detalle";
						$parametros = "'$_pregunta_8', '$_id_usuarios', '$_respuesta_pregunta_8', '$_comentario_respuesta_8', '$id_encuentas_participes_cabeza'";
						$encuestas_detalle->setFuncion($funcion);
						$encuestas_detalle->setParametros($parametros);
						$resultado=$encuestas_detalle->Insert();
					} catch (Exception $e) {
						echo "Error al Insertar Encuestas Detalle 8";
						die();
							
					}
					
					
				}else{
					
					$this->redirect("Encuestas", "index");
					
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
	
	
	
	public function cargar_afiliado_recomendado(){
	
		session_start();
		$id_rol=$_SESSION["id_rol"];
		$i=0;
	    $afiliacion = new AfiliadoRecomendacionModel();
		$columnas = "afiliado_recomendacion.cedula";
		$tablas   = "public.afiliado_recomendacion, public.usuarios";
		$where    = "usuarios.id_usuarios = afiliado_recomendacion.id_usuarios_sugiere";
		$id       = "afiliado_recomendacion.cedula";
		$resultSet = $afiliacion->getCondiciones($columnas ,$tablas ,$where, $id);
	
		$i=count($resultSet);
	
		$html="";
		if($i>0)
		{
	
			$html .= "<div class='col-lg-3 col-xs-12'>";
			$html .= "<div class='small-box bg-green'>";
			$html .= "<div class='inner'>";
			$html .= "<h3>$i</h3>";
			$html .= "<p>Afiliaciones Recomendadas.</p>";
			$html .= "</div>";
			$html .= "<div class='icon'>";
			$html .= "<i class='ion ion-stats-bars'></i>";
			$html .= "</div>";
				
			if($id_rol==1){
				$html .= "<a href='index.php?controller=Afiliacion&action=index2' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
			}else{
				$html .= "<a href='#' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
			}
			$html .= "</div>";
			$html .= "</div>";
	
	
		}else{
	
			$html = "<b>Actualmente no hay afiliaciones recomendadas...</b>";
		}
	
		echo $html;
		die();
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function paginate_load_afiliaciones_recomendadas($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_afiliaciones_recomendadas(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_afiliaciones_recomendadas(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_afiliaciones_recomendadas(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_afiliaciones_recomendadas(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_afiliaciones_recomendadas(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_afiliaciones_recomendadas($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_afiliaciones_recomendadas(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
}
?>