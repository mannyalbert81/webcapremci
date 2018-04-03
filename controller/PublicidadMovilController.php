<?php

class PublicidadMovilController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}

	
	public function index(){
	
		session_start();
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			$publicidad_movil = new PublicidadMovilModel();
	
			$nombre_controladores = "PublicidadMovil";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $publicidad_movil->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				
				$resultEdit = "";
					
				if (isset ($_GET["id_publicidad_movil"])   )
				{
					$_id_publicidad_movil = $_GET["id_publicidad_movil"];
				
					$columnas = "id_publicidad_movil";
					$tablas   = "publicidad_movil";
					$where    = "id_publicidad_movil = '$_id_publicidad_movil' ";
					$id       = "id_publicidad_movil";
					$resultEdit = $publicidad_movil->getCondiciones($columnas ,$tablas ,$where, $id);
				}	
					
				$this->view("PublicidadMovil",array(
						"resultEdit"=>$resultEdit
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Publicidad Movil"
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
	
	
	
	
	public function borrarId()
	{
		if(isset($_GET["id_publicidad_movil"]))
		{
			$id_publicidad_movil=(int)$_GET["id_publicidad_movil"];
	
			$publicidad_movil = new PublicidadMovilModel();
			
			$publicidad_movil->deleteBy(" id_publicidad_movil",$id_publicidad_movil);
		
		}
	
		$this->redirect("PublicidadMovil", "index");
	}
	
	
	public function InsertaPublicidadMovil(){
			
		session_start();
		$resultado = null;
		$publicidad_movil = new PublicidadMovilModel();
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
			if (isset ($_POST["id_publicidad_movil"]))
			{
				$_id_publicidad_movil         = $_POST["id_publicidad_movil"];
				$_id_usuarios         = $_SESSION['id_usuarios'];
	
	
				if($_id_publicidad_movil > 0){
					 
					 
					if ($_FILES['imagen_baner']['tmp_name']!="")
					{
						$directorio = $_SERVER['DOCUMENT_ROOT'].'/webcapremci/banner/';
						 
						$nombre = $_FILES['imagen_baner']['name'];
						$tipo = $_FILES['imagen_baner']['type'];
						$tamano = $_FILES['imagen_baner']['size'];
						 
						move_uploaded_file($_FILES['imagen_baner']['tmp_name'],$directorio.$nombre);
						$data = file_get_contents($directorio.$nombre);
						$imagen_usuarios = pg_escape_bytea($data);
						 
						 
						$colval = "id_usuarios= '$_id_usuarios', imagen_baner ='$imagen_usuarios'";
						$tabla = "publicidad_movil";
						$where = "id_publicidad_movil = '$_id_publicidad_movil'";
						$resultado=$publicidad_movil->UpdateBy($colval, $tabla, $where);
						 
					}
					
				}else{
	
					 
					 
					if ($_FILES['imagen_baner']['tmp_name']!="")
					{
	
						$directorio = $_SERVER['DOCUMENT_ROOT'].'/webcapremci/banner/';
						$nombre = $_FILES['imagen_baner']['name'];
						$tipo = $_FILES['imagen_baner']['type'];
						$tamano = $_FILES['imagen_baner']['size'];
						 
						move_uploaded_file($_FILES['imagen_baner']['tmp_name'],$directorio.$nombre);
						$data = file_get_contents($directorio.$nombre);
						$imagen_usuarios = pg_escape_bytea($data);
	
	
						$funcion = "publicidad_movil";
						$parametros = "'$_id_usuarios',
						'$imagen_usuarios'";
						$publicidad_movil->setFuncion($funcion);
						$publicidad_movil->setParametros($parametros);
						$resultado=$publicidad_movil->Insert();
	
					}
				
					
				}
	
				$this->redirect("PublicidadMovil", "index");
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
	
	
	
	
	
	public function cargar_publicidad(){
	
		session_start();
		$publicidad_movil = new PublicidadMovilModel();
		$where_to="";
	
		$columnas = "id_publicidad_movil, id_usuarios, imagen_baner, creado, modificado";
		$tablas   = "publicidad_movil";
		$where    = "1=1";
		$id       = "id_publicidad_movil";
	
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		
			
		if($action == 'ajax')
		{
				$where_to=$where;
	
			$html="";
			$resultSet=$publicidad_movil->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$publicidad_movil->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
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
				$html.= "<table id='tabla_publicidad' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Banner Publicidad</th>';
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
					$html.='<td style="font-size: 11px;">'.$i.'</td>';
					$html.='<td style="font-size: 11px;"><img src="view/DevuelveImagenView.php?id_valor='.$res->id_publicidad_movil.'&id_nombre=id_publicidad_movil&tabla=publicidad_movil&campo=imagen_baner" width="500" height="150"></td>';
    				$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=PublicidadMovil&action=index&id_publicidad_movil='.$res->id_publicidad_movil.'" class="btn btn-success" style="font-size:65%;"><i class="glyphicon glyphicon-edit"></i></a></span></td>';
					$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="index.php?controller=PublicidadMovil&action=borrarId&id_publicidad_movil='.$res->id_publicidad_movil.'" class="btn btn-danger" style="font-size:65%;"><i class="glyphicon glyphicon-trash"></i></a></span></td>';
					
					$html.='</tr>';
				}
	
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_publicidad("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay publicidad registradas...</b>';
				$html.='</div>';
				$html.='</div>';
			}
	
	
			echo $html;
			die();
	
		}
	
	
	}
	
	
	
	
	public function paginate_publicidad($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_publicidad(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_publicidad(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_publicidad(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_publicidad(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_publicidad(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_publicidad($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_publicidad(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
}
?>