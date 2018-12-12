<?php

class CalificacionesController extends ControladorBase{

	public function __construct() {
		parent::__construct();
		
	}

	
	public function search(){
	
		session_start();
		
		$evaluacion = new EvaluacionFuncionariosModel();
		$where_to="";
		$columnas = "e.id_evaluacion_funcionarios, 
				  e.calificacion_funcionario, 
				  e.id_usuarios_funcionario,
				  e.creado, 
				  e.id_usuarios_participe,
				  u.cedula_usuarios as cedula_funcionario, 
				  u.nombre_usuarios as nombre_funcionario,
				  e.id_usuarios_funcionario,
				  (select us.cedula_usuarios from usuarios us where us.id_usuarios=e.id_usuarios_participe) as cedula_participe,
				  (select us.nombre_usuarios from usuarios us where us.id_usuarios=e.id_usuarios_participe) as nombre_participe";
	
		$tablas   = " public.evaluacion_funcionarios e, 
  					  public.usuarios u";
	
		$where    = "u.id_usuarios = e.id_usuarios_funcionario";
	
		$id       = "e.id_evaluacion_funcionarios";
	
		 
		
		 
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
		$desde=  (isset($_REQUEST['desde'])&& $_REQUEST['desde'] !=NULL)?$_REQUEST['desde']:'';
		$hasta=  (isset($_REQUEST['hasta'])&& $_REQUEST['hasta'] !=NULL)?$_REQUEST['hasta']:'';
		 
		$where2="";
		 
		 
		if($action == 'ajax')
		{
	
			if(!empty($search)){
	
				
				if($desde!="" && $hasta!=""){
					
					$where2=" AND DATE(e.creado)  BETWEEN '$desde' AND '$hasta'";
					
					
				}
	
				$where1=" AND (e.calificacion_funcionario LIKE '%".$search."%' OR u.cedula_usuarios LIKE '%".$search."%' OR u.nombre_usuarios LIKE '%".$search."%' )";
	
				$where_to=$where.$where1.$where2;
			}else{
				if($desde!="" && $hasta!=""){
						
					$where2=" AND DATE(e.creado)  BETWEEN '$desde' AND '$hasta'";	
						
				}
				
				$where_to=$where.$where2;
	
			}
	
			$html="";
			$resultSet=$evaluacion->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$evaluacion->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
				$html.= "<table id='tabla_calificaciones_realizadas' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Cedula Funcionario</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Nombre Funcionario</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Calificación</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Cedula Participe</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Nombre Participe</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Fecha Registro</th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
				 
				$i=0;
	
				foreach ($resultSet as $res)
				{
					$i++;
					$html.='<tr>';
					$html.='<td style="font-size: 11px;">'.$i.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->cedula_funcionario.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_funcionario.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->calificacion_funcionario.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->cedula_participe.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->nombre_participe.'</td>';
					$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
					$html.='</tr>';
				}
	
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_load_calificaciones("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	 
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay calificaciones registradas...</b>';
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
			
			$evaluacion = new EvaluacionFuncionariosModel();
			
			$nombre_controladores = "Calificaciones";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $evaluacion->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
					
				$this->view("ConsultaCalificaciones",array(
						""=>""));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a consultar Calificaciones."
		
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
	
	
	
	
	
	
	
	
	public function paginate_load_calificaciones($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_calificaciones(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_calificaciones(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_calificaciones(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_calificaciones(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_calificaciones(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_calificaciones($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_calificaciones(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	
}
?>