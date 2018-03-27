<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();


if(isset($_GET['action'])){
	
	if(isset($_GET['cargar'])){
	

		
		$cargar=$_GET["cargar"];
		
			if($cargar=='cargar_sesiones')
			{
				
				$where_to="";
				$columnas = "sesiones.id_sesiones,
					  usuarios.id_usuarios,
					  usuarios.cedula_usuarios,
					  usuarios.nombre_usuarios,
					  usuarios.correo_usuarios,
					  sesiones.ip_sesiones,
					  sesiones.creado,
					  sesiones.modificado";
				
				$tablas   = "public.sesiones,
					  public.usuarios";
				
				$where    = "usuarios.id_usuarios = sesiones.id_usuarios";
				
				$id       = "sesiones.id_sesiones";
				
					
					
					
					
				$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
				$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				$desde=  (isset($_REQUEST['desde'])&& $_REQUEST['desde'] !=NULL)?$_REQUEST['desde']:'';
				$hasta=  (isset($_REQUEST['hasta'])&& $_REQUEST['hasta'] !=NULL)?$_REQUEST['hasta']:'';
					
				$where2="";
					
					
				if($action == 'ajax')
				{
				
					if(!empty($search)){
				
				
						if($desde!="" && $hasta!=""){
								
							$where2=" AND DATE(sesiones.creado)  BETWEEN '$desde' AND '$hasta'";
								
								
						}
				
						$where1=" AND (usuarios.cedula_usuarios LIKE '".$search."%' OR usuarios.nombre_usuarios LIKE '".$search."%' OR usuarios.correo_usuarios LIKE '".$search."%')";
				
						$where_to=$where.$where1.$where2;
					}else{
						if($desde!="" && $hasta!=""){
				
							$where2=" AND DATE(sesiones.creado)  BETWEEN '$desde' AND '$hasta'";
				
						}
				
						$where_to=$where.$where2;
				
					}
				
					$html="";
					$resultSet=$db->getCantidad("*", $tablas, $where_to);
					$cantidadResult=(int)$resultSet[0]->total;
				
					$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
					$per_page = 10; //la cantidad de registros que desea mostrar
					$adjacents  = 5; //brecha entre páginas después de varios adyacentes
					$offset = ($page - 1) * $per_page;
				
					$limit = " LIMIT   '$per_page' OFFSET '$offset'";
				
					$resultSet=$db->getCondicionesPagDesc($columnas, $tablas, $where_to, $id, $limit);
					$count_query   = $cantidadResult;
					$total_pages = ceil($cantidadResult/$per_page);
				
				
				
				
				
					if($cantidadResult>0)
					{
				
						$html.='<div class="pull-left" style="margin-left:11px; margin-top:20px;">';
						$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
						$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
						$html.='</div>';
						$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
						$html.='<section style="height:380px; overflow-y:scroll;">';
						$html.= "<table id='tabla_sesiones' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
						$html.= "<thead>";
						$html.= "<tr>";
						$html.='<th style="text-align: left;  font-size: 12px;"></th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Cedula</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Nombre</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Ip</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Fecha Ultimo Acceso</th>';
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
							$html.='<td style="font-size: 11px;">'.$res->ip_sesiones.'</td>';
							$html.='<td style="font-size: 11px;">'.date("d/m/Y", strtotime($res->creado)).'</td>';
							$html.='</tr>';
						}
				
				
						$html.='</tbody>';
						$html.='</table>';
						$html.='</section></div>';
						$html.='<div class="table-pagination pull-right">';
						$html.=''. $db->paginate_sesiones("index.php", $page, $total_pages, $adjacents).'';
						$html.='</div>';
				
				
					}else{
						$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
						$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
						$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
						$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay sesiones registradas...</b>';
						$html.='</div>';
						$html.='</div>';
					}
				
				
				
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
			}
			
			
			}	
			
				
}		
			
			
}











	
?>