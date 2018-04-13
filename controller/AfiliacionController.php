<?php

class AfiliacionController extends ControladorBase{

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
			
			
			$sexo= new SexoModel();
			$resultSexo = $sexo->getAll("nombre_sexo");
			
			$estado_civil= new Estado_civilModel();
			$resultEstado_civil = $estado_civil->getAll("nombre_estado_civil");
			
			$tipo_sangre= new Tipo_sangreModel();
			$resultTipo_sangre = $tipo_sangre->getAll("nombre_tipo_sangre");
			
			$estado = new EstadoModel();
			$resultEstado= $estado->getAll("nombre_estado");
			
			$entidades = new EntidadesModel();
			$resultEntidades= $entidades->getAll("nombre_entidades");
			
			$provincias = new ProvinciasModel();
			$resultProvincias= $provincias->getAll("nombre_provincias");
			
			$parroquias = new ParroquiasModel();
			$resultParroquias= $parroquias->getAll("nombre_parroquias");
			
			$cantones = new CantonesModel();
			$resultCantones= $cantones->getAll("nombre_cantones");
			
			
			$afiliacion = new AfiliadoRecomendacionModel();
	
			$nombre_controladores = "AfiliadoRecomendacion";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $afiliacion->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
					
					
				$this->view("AfiliadoRecomendacion",array(
						"resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
					    "resultProvincias"=>$resultProvincias,
						"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Afiliado Recomendación"
		
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
				
			$afiliacion = new AfiliadoRecomendacionModel();
	
			$nombre_controladores = "AfiliadoRecomendacion";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $afiliacion->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
	
					
					
				$this->view("ConsultaAfiliacionesRecomendadas",array(
						"resultSexo"=>""
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Afiliado Recomendación"
	
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
	
	
	
	
	public function devuelveCanton()
	{
		session_start();
		$resultCan = array();
	
	
		if(isset($_POST["id_provincias_vivienda"]))
		{
	
			$id_provincias=(int)$_POST["id_provincias_vivienda"];
	
			$cantones=new CantonesModel();
	
			$resultCan = $cantones->getBy(" id_provincias = '$id_provincias'  ");
	
	
		}
	
		if(isset($_POST["id_provincias_asignacion"]))
		{
	
			$id_provincias=(int)$_POST["id_provincias_asignacion"];
	
			$cantones=new CantonesModel();
	
			$resultCan = $cantones->getBy(" id_provincias = '$id_provincias'  ");
	
	
		}
			
		echo json_encode($resultCan);
	
	}
	
	
	
	
	
	
	
	public function devuelveParroquias()
	{
		session_start();
		$resultParr = array();
	
	
		if(isset($_POST["id_cantones_vivienda"]))
		{
	
			$id_cantones_vivienda=(int)$_POST["id_cantones_vivienda"];
	
			$parroquias=new ParroquiasModel();
	
			$resultParr = $parroquias->getBy(" id_cantones = '$id_cantones_vivienda'  ");
	
	
		}
		if(isset($_POST["id_cantones_asignacion"]))
		{
	
			$id_cantones_vivienda=(int)$_POST["id_cantones_asignacion"];
	
			$parroquias=new ParroquiasModel();
	
			$resultParr = $parroquias->getBy(" id_cantones = '$id_cantones_vivienda'  ");
	
	
		}
			
		echo json_encode($resultParr);
	
	}
	
	
	
	
	
	
	
	
	
	
	
	


	public function InsertaRecomendacion(){
	
		session_start();
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
	
			$usuarios = new UsuariosModel();
			$afiliacion = new AfiliadoRecomendacionModel();
				
			if ( isset($_POST["cedula"]) )
			{
				
				$_cedula    = $_POST["cedula"];
				$_nombre     = $_POST["nombre"];
				$_direccion     = $_POST["direccion"];
				$_id_usuarios_sugiere = $_SESSION['id_usuarios'];
				
				
				$_labor = $_POST["labor"];
				$_correo   = $_POST["correo"];
				$_telefono    = $_POST["telefono"];
				$_celular     = $_POST["celular"];
				$_id_entidades            = $_POST["id_entidades"];
				$_fecha_ingreso          = $_POST["fecha_ingreso"];
				$_sueldo           = $_POST["sueldo"];
				$_hijos          = $_POST["hijos"];
				$_edad           = $_POST["edad"];
				$_id_sexo          = $_POST["id_sexo"];
				$_id_estado_civil           = $_POST["id_estado_civil"];
				$_id_tipo_sangre          = $_POST["id_tipo_sangre"];
				
				$_id_provincias_vivienda          = $_POST["id_provincias_vivienda"];
				$_id_cantones_vivienda          = $_POST["id_cantones_vivienda"];
				$_id_parroquias_vivienda         = $_POST["id_parroquias_vivienda"];
				$_id_provincias_asignacion          = $_POST["id_provincias_asignacion"];
				$_id_cantones_asignacion          = $_POST["id_cantones_asignacion"];
				$_id_parroquias_asignacion         = $_POST["id_parroquias_asignacion"];
				$_observacion        = $_POST["observacion"];
	
	
	
				try {
						
						
					
						
					$funcion = "public.afiliado_recomendacion";
					$parametros = "'$_cedula',
					'$_nombre',
					'$_direccion',
					'$_fecha_ingreso',
					'$_id_usuarios_sugiere',
					'$_id_provincias_vivienda',
					'$_id_cantones_vivienda',
					'$_id_parroquias_vivienda',
					'$_id_provincias_asignacion',
					'$_id_cantones_asignacion',
					'$_id_parroquias_asignacion',
					'$_id_sexo',
					'$_id_tipo_sangre',
					'$_id_estado_civil',
					'$_id_entidades',
					'$_telefono',
					'$_celular',
					'$_correo',
					'$_edad',
					'$_hijos',
					'$_sueldo'";
					$afiliacion->setFuncion($funcion);
					$afiliacion->setParametros($parametros);
					$resultado=$afiliacion->Insert();
						
					
					
					
					
					
				} catch (Exception $e) {
						
					$this->redirect("Afiliacion", "index");
						
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