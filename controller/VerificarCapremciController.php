<?php

class VerificarCapremciController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	
			
		
	public function index()
	{
	
	
		session_start();
	
		$documentos_legal = new DocumentosLegalModel();
		$capremci_creditos = new CapremciCreditosModel();
		
		
	
		if (isset(  $_SESSION['usuario_usuario']) )
		{
			
			
			$columnas5="tipo_credito_capremci";
			$tablas5="capremci_creditos";
			$where5="1=1 GROUP BY tipo_credito_capremci";
			$id5="tipo_credito_capremci";
			
			$resultTipCred=$capremci_creditos->getCondiciones($columnas5, $tablas5, $where5, $id5);
			
			$resultSet = "";
			
			
			$nombre_controladores = "Documentos";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $documentos_legal->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
				if (isset ($_POST["numero_credito"]) && isset ($_POST["cedula_capremci"]) && isset($_POST["nombres_capremci"]) && isset($_POST["tipo_credito_capremci"])   )
				
				{


					$numero_credito=$_POST['numero_credito'];
					$cedula_capremci=$_POST['cedula_capremci'];
					$nombres_capremci=$_POST['nombres_capremci'];
					$tipo_credito_capremci=$_POST['tipo_credito_capremci'];
					
					$columnas = "capremci_creditos.id_capremci, 
								  capremci_creditos.numero_credito, 
								  capremci_creditos.cedula_capremci, 
								  capremci_creditos.nombres_capremci, 
								  capremci_creditos.recibido_capremci, 
								  capremci_creditos.monto_capremci, 
								  capremci_creditos.fecha_ingreso_capremci, 
								  capremci_creditos.fecha_consecion_capremci, 
								  capremci_creditos.tipo_credito_capremci";
					
					
					$tablas="public.capremci_creditos";
						
					$where="1=1";
						
					$id="capremci_creditos.id_capremci";
						
					$where_0 = "";
					$where_1 = "";
					$where_2 = "";
					$where_3 = "";
					
						
						
					if($numero_credito!=""){$where_0=" AND capremci_creditos.numero_credito = '$numero_credito'";}
					
					if($cedula_capremci!=""){$where_1=" AND capremci_creditos.cedula_capremci like '$cedula_capremci'";}
						
					if($nombres_capremci!=""){$where_2=" AND capremci_creditos.nombres_capremci like '$nombres_capremci'";}
						
					if($tipo_credito_capremci!=""){$where_3=" AND capremci_creditos.tipo_credito_capremci='$tipo_credito_capremci'";}
					
					
					
					
					$where_to  = $where . $where_0 . $where_1 . $where_2 . $where_3;
					
					$id = "nombres_capremci";
					
					$resultSet=$capremci_creditos->getCondiciones("*", $tablas, $where_to, $id);
					
						
					//comienza paginacion
					
					$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
					
					if($action == 'ajax')
					{
					
						$html="";
						$resultSet=$capremci_creditos->getCantidad("*", $tablas, $where_to);
						$cantidadResult=(int)$resultSet[0]->total;
					
						$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
					
						$per_page = 15; //la cantidad de registros que desea mostrar
						$adjacents  = 9; //brecha entre páginas después de varios adyacentes
						$offset = ($page - 1) * $per_page;
					
						$limit = " LIMIT   '$per_page' OFFSET '$offset'";
					
					
						$resultSet=$capremci_creditos->getCondicionesPag($columnas, $tablas, $where_to, $id, $limit);
					
						$count_query   = $cantidadResult;
					
						$total_pages = ceil($cantidadResult/$per_page);
					
						if ($cantidadResult>0)
						{
					
							$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
							$html.='<div class="pull-left">';
							$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
							$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
							$html.='</div></div>';
							$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
							$html.='<section style="height:425px; overflow-y:scroll;">';
							$html.='<table class="table table-hover">';
							$html.='<thead>';
							$html.='<tr class="info">';
							$html.='<th style="text-align: left;  font-size: 10px;">#</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Número de Crédito</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Cedula</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Nombres y Apellidos</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Recibido</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Monto</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Fecha de Ingreso</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Fecha de Conseción</th>';
							$html.='<th style="text-align: left;  font-size: 10px;">Tipo Crédito</th>';
							
							$html.='</tr>';
							$html.='</thead>';
							$html.='<tbody>';
					
								
					
							$i=0;
								
							foreach ($resultSet as $res)
							{
								$i++;
					
								$html.='<tr>';
								$html.='<td style="font-size: 9px;">'.$i.'</td>';
								$html.='<td style="font-size: 9px;">'.$res->numero_credito.'</td>';
								$html.='<td style="font-size: 9px;">'.$res->cedula_capremci.'</td>';
								$html.='<td style="font-size: 9px;">'.$res->nombres_capremci.'</td>';
								$html.='<td style="font-size: 9px;">'.$res->recibido_capremci.'</td>';
								
								$html.='<td style="font-size: 9px;">'.$res->monto_capremci.'</td>';
								$html.='<td style="font-size: 9px;">'.$res->fecha_ingreso_capremci.'</td>';
								$html.='<td style="font-size: 9px;">'.$res->fecha_consecion_capremci.'</td>';
								$html.='<td style="font-size: 9px;">'.$res->tipo_credito_capremci.'</td>';
								$html.='</tr>';
					
					
							}
					
							$html.='</tbody>';
							$html.='</table>';
							$html.='</section></div>';
							$html.='<div class="table-pagination pull-right">';
							$html.=''. $this->paginate("index.php", $page, $total_pages, $adjacents).'';
							$html.='</div>';
					
								
						}else{
								
							$html.='<div class="alert alert-warning alert-dismissable">';
							$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
							$html.='<h4>Aviso!!!</h4> No hay datos para mostrar';
							$html.='</div>';
								
						}
					
						echo $html;
						die();
					
					}
					
						
						
				}
				
				
				
				
				
				$this->view("VerificarCapremci",array(
				    "resultTipCred"=>$resultTipCred, "resultSet"=>$resultSet
					 
					));
				
				
				
				
				
	
			}
		}
	}
	
	
	//<input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" class="btn btn-warning " />
	
	public function paginate($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_matriz(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_matriz(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_matriz(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_matriz(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_matriz(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_matriz($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_matriz(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
}

?>