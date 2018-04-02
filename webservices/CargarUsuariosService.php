<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();


if(isset($_GET['action'])){
	
	if(isset($_GET['cargar'])){
			
		$cargar=$_GET["cargar"];
		
			if($cargar=='cargar_usuarios')
			{
				
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
					$resultSet=$db->getCantidad("*", $tablas, $where_to);
					$cantidadResult=(int)$resultSet[0]->total;
				
					$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
					$per_page = 10; //la cantidad de registros que desea mostrar
					$adjacents  = 5; //brecha entre páginas después de varios adyacentes
					$offset = ($page - 1) * $per_page;
				
					$limit = " LIMIT   '$per_page' OFFSET '$offset'";
				
					$resultSet=$db->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
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
						$html.= "<table id='tabla_usuarios' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
						$html.= "<thead>";
						$html.= "<tr>";
						$html.='<th style="text-align: left;  font-size: 12px;"></th>';
						$html.='<th style="text-align: left;  font-size: 12px;"></th>';
						$html.='<th style="text-align: left;  font-size: 12px;"></th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Cedula</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Nombre</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Teléfono</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Celular</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Correo</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Rol</th>';
						$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
				        $html.='</tr>';
						$html.='</thead>';
						$html.='<tbody>';
						 
						$i=0;
				
						foreach ($resultSet as $res)
						{
							$foto=base64_encode(pg_unescape_bytea($res->fotografia_usuarios));
							$imgficha = 'data:image/png;base64,'.$foto;
								
							$i++;
							$html.='<tr>';
							$html.='<td style="font-size: 11px;"><img src="'.$imgficha.'" width="70" height="50"></td>';
							$html.='<td style="font-size: 18px;"><span class="pull-right"><a href="ConsultaAdmin.html?cedula_participe='.$res->cedula_usuarios.'" class="btn btn-warning" style="font-size:65%;"><i class="glyphicon glyphicon-eye-open"></i></a></span></td>';
							$html.='<td style="font-size: 11px;">'.$i.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->cedula_usuarios.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->nombre_usuarios.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->telefono_usuarios.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->celular_usuarios.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->correo_usuarios.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->nombre_rol.'</td>';
							$html.='<td style="font-size: 11px;">'.$res->nombre_estado.'</td>';
							$html.='</tr>';
						}
				
				
						$html.='</tbody>';
						$html.='</table>';
						$html.='</section></div>';
						$html.='<div class="table-pagination pull-right">';
						$html.=''. $db->paginate("index.php", $page, $total_pages, $adjacents).'';
						$html.='</div>';
				
				
						 
					}else{
						$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
						$html.='<div class="alert alert-warning alert-dismissable" style="margin-top:40px;">';
						$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
						$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay usuarios registrados...</b>';
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