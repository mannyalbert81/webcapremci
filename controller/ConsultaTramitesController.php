<?php

class ConsultaTramitesController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	public function search_consulta_tramites(){
	
	    
		session_start();
	    $consulta_documentos= new ConsultaDocumentosModel();
	    
	    $_cedula_usuarios = $_SESSION["cedula_usuarios"];
	    
	    require_once 'core/EntidadBase_231.php';
	    $db = new EntidadBase_231();
	    
	    
		$where_to="";
		$columnas = "afiliado.cedula_afiliado, 
                      afiliado.nombres_afiliado, 
                      afiliado.apellidos_afiliado, 
                      turnos_tramites.numero_turnos_tramites, 
                      tramites_departamentos.nombre_tramites_departamentos, 
                      turnos_tramites.creado,
                      turnos_tramites.id_turnos_tramites,
                      departamentos.nombre_departamentos,
                      empleados.nombres_empleados,
                      empleados.apellidos_empleados";
	
		$tablas   = "public.afiliado, 
                      public.turnos_tramites, 
                      public.tramites_departamentos,
                      public.departamentos,
                      public.empleados";
	
		$where    = "turnos_tramites.id_afiliado = afiliado.id_afiliado AND
                     tramites_departamentos.id_tramites_departamentos = turnos_tramites.id_tramites_departamentos
                    AND empleados.id_empleados = turnos_tramites.id_empleados 
                    AND departamentos.id_departamentos = turnos_tramites.id_departamentos 
                    AND afiliado.cedula_afiliado='$_cedula_usuarios'";
	
		$id       = "turnos_tramites.id_turnos_tramites";
	
		 
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
		 
		if($action == 'ajax')
		{
	
		    
		    if(!empty($search)){
		        
		        $where1=" AND (empleados.nombres_empleados LIKE '".$search."%' OR empleados.apellidos_empleados LIKE '".$search."%' OR departamentos.nombre_departamentos LIKE '".$search."%'  OR turnos_tramites.numero_turnos_tramites LIKE '".$search."%' )";
		        
		        $where_to=$where.$where1;
		        
		    }else{
		        
		        $where_to=$where;
		        
		    }
		    
		    
	
			$html="";
			$resultSet=$db->getCantidad("*", $tablas, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 50; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$db->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
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
				$html.= "<table id='tabla_consulta_tramites' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 12px;">Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Fecha</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Departamento</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Tipo Trámite</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Atendió</th>';
				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
				 
				$i=0;
	
        			foreach ($resultSet as $res)
        			{
        				$i++;
        				$html.='<tr>';
        				$html.='<td style="font-size: 11px;">'.$res->numero_turnos_tramites.'</td>';
        				$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
        				$html.='<td style="font-size: 11px;">'.$res->nombre_departamentos.'</td>';
        				$html.='<td style="font-size: 11px;">'.$res->nombre_tramites_departamentos.'</td>';
        				$html.='<td style="font-size: 11px;">'.$res->nombres_empleados.'</td>';
        				$html.='<td style="font-size: 11px;"><span class="pull-right"><a href="index.php?controller=ConsultaTramites&action=index2&id_turnos_tramites='.$res->id_turnos_tramites.'" class="btn btn-warning" style="font-size:100%;"><i class="glyphicon glyphicon-eye-open"></i></a></span></td>';
        				$html.='</tr>';
        			}
	
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_consulta_tramites("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	 
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no tiene trámites en proceso registrados...</b>';
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
			
		    $consulta_tramites= new ConsultaTramitesModel();
	
			$nombre_controladores = "ConsultaTramites";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $consulta_tramites->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
			    
			    
			    	
				$this->view("ConsultaTramites",array(
				    "resultSet"=>""
	
				));
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Consulta Trámites"
		
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
	        
	        $consulta_tramites= new ConsultaTramitesModel();
	        
	        $nombre_controladores = "ConsultaTramites";
	        $id_rol= $_SESSION['id_rol'];
	        $resultPer = $consulta_tramites->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	        
	        if (!empty($resultPer))
	        {
	            
	            if(isset($_GET["id_turnos_tramites"])){
	                
	                
	                $_id_turnos_tramites = $_GET["id_turnos_tramites"];
	                
	                require_once 'core/EntidadBase_231.php';
	                $db = new EntidadBase_231();
	                
	                
	                $columnas="turnos_tramites.numero_turnos_tramites, 
                              tramites_departamentos.nombre_tramites_departamentos, 
                              turno_tramites_detalle.descripcion_turno_tramites_detalle, 
                              usuarios.nombre_usuario, 
                              turno_tramites_detalle.creado, 
                              estado_tramites.nombre_estado_tramites";
	                $tablas="public.turno_tramites_detalle, 
                              public.turnos_tramites, 
                              public.usuarios, 
                              public.tramites_departamentos, 
                              public.estado_tramites";
	                $where="turno_tramites_detalle.id_usuario = usuarios.id_usuario AND
                          turno_tramites_detalle.id_estado_tramites = estado_tramites.id_estado_tramites AND
                          turnos_tramites.id_turnos_tramites = turno_tramites_detalle.id_turno_tramites AND
                          tramites_departamentos.id_tramites_departamentos = turnos_tramites.id_tramites_departamentos AND turnos_tramites.id_turnos_tramites='$_id_turnos_tramites'";
	                $order_by="turnos_tramites.id_turnos_tramites";
	                
	                $resultSet=$db->getCondicionesDesc($columnas, $tablas, $where, $order_by);
	                
	                
	                $this->view("ConsultaTramitesDetalle",array(
	                    "resultSet"=>$resultSet
	                    
	                ));
	                
	                
	                
	            }else{
	                
	                
	                $this->view("ConsultaTramites",array(
	                    "resultSet"=>""
	                    
	                ));
	                
	                
	            }
	            
	            
	            
	        }
	        else
	        {
	            $this->view("Error",array(
	                "resultado"=>"No tiene Permisos de Acceso a Consulta Trámites Detalle"
	                
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
	
	
	
	public function paginate_consulta_tramites($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_consulta_tramites(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_consulta_tramites(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_consulta_tramites(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_consulta_tramites(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_consulta_tramites(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_consulta_tramites($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_consulta_tramites(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
}
?>