<?php

class SaldosCuentaIndividualController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	
	//empieza ajax
	
	public function cargar_cuenta_individual(){
	
		session_start();
		$afiliado_transacc_cta_ind = new Afiliado_transacc_cta_indModel();
		$where_to="";
		
		
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
		
		if(!empty($cedula_usuarios)){
				
			$columnas_ind="afiliado_transacc_cta_ind.id_afiliado_transacc_cta_ind,
						  afiliado_transacc_cta_ind.ordtran,
						  afiliado_transacc_cta_ind.histo_transacsys,
						  afiliado_transacc_cta_ind.cedula,
						  afiliado_transacc_cta_ind.fecha_conta,
						  afiliado_transacc_cta_ind.descripcion,
						  afiliado_transacc_cta_ind.mes_anio,
						  afiliado_transacc_cta_ind.valorper,
						  afiliado_transacc_cta_ind.valorpat,
						  afiliado_transacc_cta_ind.saldoper,
						  afiliado_transacc_cta_ind.saldopat,
						  afiliado_transacc_cta_ind.id_afiliado";
			$tablas_ind="public.afiliado_transacc_cta_ind";
			$where_ind="1=1 AND afiliado_transacc_cta_ind.cedula='$cedula_usuarios'";
			$id_ind="afiliado_transacc_cta_ind.ordtran";
				
				
			$columnas_ind_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
			$tablas_ind_mayor="afiliado_transacc_cta_ind";
			$where_ind_mayor="cedula='$cedula_usuarios'";
				
			 
		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
		$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
		 
		 
		 
		 
		if($action == 'ajax')
		{
	
			if(!empty($search)){
	
	
				$where1=" AND (afiliado_transacc_cta_ind.descripcion LIKE '%".$search."%' OR afiliado_transacc_cta_ind.mes_anio LIKE '%".$search."%')";
	
				$where_to=$where_ind.$where1;
			}else{
	
				$where_to=$where_ind;
	
			}
	
			$html="";
			$resultSet=$afiliado_transacc_cta_ind->getCantidad("*", $tablas_ind, $where_to);
			$cantidadResult=(int)$resultSet[0]->total;
	
			$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
			$per_page = 15; //la cantidad de registros que desea mostrar
			$adjacents  = 9; //brecha entre páginas después de varios adyacentes
			$offset = ($page - 1) * $per_page;
	
			$limit = " LIMIT   '$per_page' OFFSET '$offset'";
	
			$resultSet=$afiliado_transacc_cta_ind->getCondicionesPagDesc($columnas_ind, $tablas_ind, $where_to, $id_ind, $limit);
				
			$count_query   = $cantidadResult;
			$total_pages = ceil($cantidadResult/$per_page);
	
			 
	
	
			if($cantidadResult>0)
			{
				$resultDatosMayor_Cta_individual=$afiliado_transacc_cta_ind->getCondicionesValorMayor($columnas_ind_mayor, $tablas_ind_mayor, $where_ind_mayor);
				
				if (!empty($resultDatosMayor_Cta_individual)) {  foreach($resultDatosMayor_Cta_individual as $res) {
					                    
				$fecha=$res->fecha;
				$total= $res->total; 
				}}else{
					
				$fecha="";
				$total= 0.00;				
				
				}
				
				$html.='<center><h5>Total Cuenta Individual Actualizada al '.$fecha.' : $'.$total.'</h5></center><br><br>';
				$html.='<div class="pull-left" style="margin-left:11px;">';
				$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
				$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
				$html.='</div>';
				$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
				$html.='<section style="height:425px; overflow-y:scroll;">';
				$html.= "<table id='tabla_cta_individual' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
				$html.= "<thead>";
				$html.= "<tr>";
				$html.='<th style="text-align: left;  font-size: 12px;"></th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Fecha</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Descripción</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Mes/A&ntilde;o</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Valor Personal</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Valor Patronal</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Saldo Personal</th>';
				$html.='<th style="text-align: left;  font-size: 12px;">Saldo Patronal</th>';
				$html.='</tr>';
				$html.='</thead>';
				$html.='<tbody>';
				 
				$i=0;
	
				foreach ($resultSet as $res)
				{
					$i++;
					$html.='<tr>';
					$html.='<td style="font-size: 11px;">'.$i.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->fecha_conta.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->descripcion.'</td>';
					$html.='<td style="font-size: 11px;">'.$res->mes_anio.'</td>';
					$html.='<td style="font-size: 11px;">'.number_format($res->valorper, 2, '.', ',').'</td>';
					$html.='<td style="font-size: 11px;">'.number_format($res->valorpat, 2, '.', ',').'</td>';
					$html.='<td style="font-size: 11px;">'.number_format($res->saldoper, 2, '.', ',').'</td>';
					$html.='<td style="font-size: 11px;">'.number_format($res->saldopat, 2, '.', ',').'</td>';
					 
					$html.='</tr>';
				}
	
	
				$html.='</tbody>';
				$html.='</table>';
				$html.='</section></div>';
				$html.='<div class="table-pagination pull-right">';
				$html.=''. $this->paginate_cuenta_individual("index.php", $page, $total_pages, $adjacents).'';
				$html.='</div>';
	
	
				 
			}else{
				$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
				$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
				$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
				$html.='</div>';
				$html.='</div>';
			}
			 
			 
	
			echo $html;
			die();
	
		}
	
	
		}
	
	
	}
	
	
	
	
	
	
	public function cargar_cuenta_desembolsar(){
	
		session_start();
		$afiliado_transacc_cta_desemb = new Afiliado_transacc_cta_desembModel();
		$where_to="";
	
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
	
			$columnas_desemb="afiliado_transacc_cta_desemb.id_afiliado_transacc_cta_desemb,
						  afiliado_transacc_cta_desemb.ordtran,
						  afiliado_transacc_cta_desemb.histo_transacsys,
						  afiliado_transacc_cta_desemb.cedula,
						  afiliado_transacc_cta_desemb.fecha_conta,
						  afiliado_transacc_cta_desemb.descripcion,
						  afiliado_transacc_cta_desemb.mes_anio,
						  afiliado_transacc_cta_desemb.valorper,
						  afiliado_transacc_cta_desemb.valorpat,
						  afiliado_transacc_cta_desemb.saldoper,
						  afiliado_transacc_cta_desemb.saldopat,
						  afiliado_transacc_cta_desemb.id_afiliado";
			$tablas_desemb="public.afiliado_transacc_cta_desemb";
			$where_desemb="1=1 AND afiliado_transacc_cta_desemb.cedula='$cedula_usuarios'";
			$id_desemb="afiliado_transacc_cta_desemb.ordtran";
				
				
				
			$columnas_desemb_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
			$tablas_desemb_mayor="afiliado_transacc_cta_desemb";
			$where_desemb_mayor="cedula='$cedula_usuarios'";
				
				
	
	
			$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
			$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				
				
				
				
			if($action == 'ajax')
			{
	
				if(!empty($search)){
	
	
					$where1=" AND (afiliado_transacc_cta_desemb.descripcion LIKE '%".$search."%' OR afiliado_transacc_cta_desemb.mes_anio LIKE '%".$search."%')";
	
					$where_to=$where_desemb.$where1;
				}else{
	
					$where_to=$where_desemb;
	
				}
	
				$html="";
				$resultSet=$afiliado_transacc_cta_desemb->getCantidad("*", $tablas_desemb, $where_to);
				$cantidadResult=(int)$resultSet[0]->total;
	
				$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
				$per_page = 15; //la cantidad de registros que desea mostrar
				$adjacents  = 9; //brecha entre páginas después de varios adyacentes
				$offset = ($page - 1) * $per_page;
	
				$limit = " LIMIT   '$per_page' OFFSET '$offset'";
					
				$resultSet=$afiliado_transacc_cta_desemb->getCondicionesPagDesc($columnas_desemb, $tablas_desemb, $where_to, $id_desemb, $limit);
	
				$count_query   = $cantidadResult;
				$total_pages = ceil($cantidadResult/$per_page);
	
	
	
	
				if($cantidadResult>0)
				{
					$resultDatosMayor_Cta_desembolsar=$afiliado_transacc_cta_desemb->getCondicionesValorMayor($columnas_desemb_mayor, $tablas_desemb_mayor, $where_desemb_mayor);
						
					if (!empty($resultDatosMayor_Cta_desembolsar)) {  foreach($resultDatosMayor_Cta_desembolsar as $res) {
						 
						$fecha=$res->fecha;
						$total= $res->total;
					}}else{
							
						$fecha="";
						$total= 0.00;
	
					}
	
					$html.='<center><h5>Total Cuenta Por Desembolsar Actualizada al '.$fecha.' : $'.$total.'</h5></center><br><br>';
					$html.='<div class="pull-left" style="margin-left:11px;">';
					$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
					$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
					$html.='</div>';
					$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
					$html.='<section style="height:425px; overflow-y:scroll;">';
					$html.= "<table id='tabla_cta_desembolsar' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
					$html.= "<thead>";
					$html.= "<tr>";
					$html.='<th style="text-align: left;  font-size: 12px;"></th>';
					$html.='<th style="text-align: left;  font-size: 12px;">Fecha</th>';
					$html.='<th style="text-align: left;  font-size: 12px;">Descripción</th>';
					$html.='<th style="text-align: left;  font-size: 12px;">Mes/A&ntilde;o</th>';
					$html.='<th style="text-align: left;  font-size: 12px;">Valor Personal</th>';
					$html.='<th style="text-align: left;  font-size: 12px;">Valor Patronal</th>';
					$html.='<th style="text-align: left;  font-size: 12px;">Saldo Personal</th>';
					$html.='<th style="text-align: left;  font-size: 12px;">Saldo Patronal</th>';
					$html.='</tr>';
					$html.='</thead>';
					$html.='<tbody>';
						
					$i=0;
	
					foreach ($resultSet as $res)
					{
						$i++;
						$html.='<tr>';
						$html.='<td style="font-size: 11px;">'.$i.'</td>';
						$html.='<td style="font-size: 11px;">'.$res->fecha_conta.'</td>';
						$html.='<td style="font-size: 11px;">'.$res->descripcion.'</td>';
						$html.='<td style="font-size: 11px;">'.$res->mes_anio.'</td>';
						$html.='<td style="font-size: 11px;">'.number_format($res->valorper, 2, '.', ',').'</td>';
						$html.='<td style="font-size: 11px;">'.number_format($res->valorpat, 2, '.', ',').'</td>';
						$html.='<td style="font-size: 11px;">'.number_format($res->saldoper, 2, '.', ',').'</td>';
						$html.='<td style="font-size: 11px;">'.number_format($res->saldopat, 2, '.', ',').'</td>';
	
						$html.='</tr>';
					}
	
	
					$html.='</tbody>';
					$html.='</table>';
					$html.='</section></div>';
					$html.='<div class="table-pagination pull-right">';
					$html.=''. $this->paginate_cuenta_desembolsar("index.php", $page, $total_pages, $adjacents).'';
					$html.='</div>';
	
	
						
				}else{
					$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
					$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
					$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
					$html.='</div>';
					$html.='</div>';
				}
	
	
	
				echo $html;
				die();
	
			}
	
	
		}
	
	
	}
	
	
	
	
	
	
	
	
	
	
	public function cargar_credito_ordinario(){
	
		session_start();
		$ordinario_solicitud = new Ordinario_SolicitudModel();
		$ordinario_detalle = new Ordinario_DetalleModel();
		$where_to="";
	
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
	
			
			$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
			$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
	
	
			if($action == 'ajax')
			{
				$html="";
				$columnas_ordi_cabec ="*";
				$tablas_ordi_cabec="ordinario_solicitud";
				$where_ordi_cabec="cedula='$cedula_usuarios'";
				$id_ordi_cabec="cedula";
				$resultCredOrdi_Cabec=$ordinario_solicitud->getCondicionesDesc($columnas_ordi_cabec, $tablas_ordi_cabec, $where_ordi_cabec, $id_ordi_cabec);
					
				if(!empty($resultCredOrdi_Cabec)){
						
					$_numsol_ordinario=$resultCredOrdi_Cabec[0]->numsol;
					$_cuota_ordinario=$resultCredOrdi_Cabec[0]->cuota;
					$_interes_ordinario=$resultCredOrdi_Cabec[0]->interes;
					$_tipo_ordinario=$resultCredOrdi_Cabec[0]->tipo;
					$_plazo_ordinario=$resultCredOrdi_Cabec[0]->plazo;
					$_fcred_ordinario=$resultCredOrdi_Cabec[0]->fcred;
					$_ffin_ordinario=$resultCredOrdi_Cabec[0]->ffin;
					$_cuenta_ordinario=$resultCredOrdi_Cabec[0]->cuenta;
					$_banco_ordinario=$resultCredOrdi_Cabec[0]->banco;
					
					
						
					if($_numsol_ordinario != ""){
				
						$columnas_ordi_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
							
						$tablas_ordi_detall="ordinario_detalle";
						$where_ordi_detall="numsol='$_numsol_ordinario'";
						$id_ordi_detall="pago";
				//		$resultCredOrdi_Detall=$ordinario_detalle->getCondicionesDesc($columnas_ordi_detall, $tablas_ordi_detall, $where_ordi_detall, $id_ordi_detall);
				
				
						
						if(!empty($search)){
						
						
							$where1=" AND (mes LIKE '%".$search."%' OR estado LIKE '%".$search."%')";
						
							$where_to=$where_ordi_detall.$where1;
						}else{
						
							$where_to=$where_ordi_detall;
						
						}
						
						
						
						$resultSet=$ordinario_detalle->getCantidad("*", $tablas_ordi_detall, $where_to);
						$cantidadResult=(int)$resultSet[0]->total;
						
						$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
						
						$per_page = 15; //la cantidad de registros que desea mostrar
						$adjacents  = 9; //brecha entre páginas después de varios adyacentes
						$offset = ($page - 1) * $per_page;
						
						$limit = " LIMIT   '$per_page' OFFSET '$offset'";
							
						$resultSet=$ordinario_detalle->getCondicionesPagDesc($columnas_ordi_detall, $tablas_ordi_detall, $where_to, $id_ordi_detall, $limit);
						
						$count_query   = $cantidadResult;
						$total_pages = ceil($cantidadResult/$per_page);
						
						
						
						
						if($cantidadResult>0)
						{
							
							$html.='<div class="col-lg-12 col-xs-12 col-md-12">';
							$html.='<div class="row">';
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">No de Solicitud:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_numsol_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Cuota:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuota_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Interes:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_interes_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Tipo:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_tipo_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">PLazo:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_plazo_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
							 
							 
							$html.='<div class="row">';
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Termina en:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_ffin_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Cuenta No:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuenta_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Banco:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_banco_ordinario.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
							
							
							
							
							$html.='<div class="pull-left" style="margin-left:11px;">';
							$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
							$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
							$html.='</div>';
							$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
							$html.='<section style="height:425px; overflow-y:scroll;">';
							$html.= "<table id='tabla_credito_ordinario' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
							$html.= "<thead>";
							$html.= "<tr>";
							$html.='<th style="text-align: left;  font-size: 12px;"></th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Pago</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Mes</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">A&ntilde;o</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Fecha Pago</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Capital</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Interes</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Interes por Mora</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Seguro Desgr.</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Total</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Saldo</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
							$html.='</tr>';
							$html.='</thead>';
							$html.='<tbody>';
						
							$i=0;
						
							foreach ($resultSet as $res)
							{
								$i++;
								$html.='<tr>';
								$html.='<td style="font-size: 11px;">'.$i.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->pago.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->mes.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->ano.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->fecpag.'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->capital, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->interes, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->intmor, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->seguros, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->total, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->saldo, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.$res->estado.'</td>';
								$html.='</tr>';
							}
						
						
							$html.='</tbody>';
							$html.='</table>';
							$html.='</section></div>';
							$html.='<div class="table-pagination pull-right">';
							$html.=''. $this->paginate_credito_ordinario("index.php", $page, $total_pages, $adjacents).'';
							$html.='</div>';
						
						
						
						}else{
							$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
							$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
							$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
							$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
							$html.='</div>';
							$html.='</div>';
						}
						
						
						
					}else{
						
						$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
						$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
						$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
						$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
						$html.='</div>';
						$html.='</div>';
					}
						
						
				}else{
					
					$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
					$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
					$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
					$html.='</div>';
					$html.='</div>';
					
				}
				
				
				
				echo $html;
				die();
	
			}
	
	
		}
	
	
	}
	
	
	
	
	
	
	
	
	
	public function cargar_credito_emergente(){
	
		session_start();
		$emergente_solicitud = new Emergente_SolicitudModel();
		$emergente_detalle = new Emergente_DetalleModel();
		$where_to="";
	
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
	
				
			$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
			$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
	
	
			if($action == 'ajax')
			{
				$html="";
				
				$columnas_emer_cabec ="*";
				$tablas_emer_cabec="emergente_solicitud";
				$where_emer_cabec="cedula='$cedula_usuarios'";
				$id_emer_cabec="cedula";
				$resultCredEmer_Cabec=$emergente_solicitud->getCondicionesDesc($columnas_emer_cabec, $tablas_emer_cabec, $where_emer_cabec, $id_emer_cabec);
				
				
					
				if(!empty($resultCredEmer_Cabec)){
	
					$_numsol_emergente=$resultCredEmer_Cabec[0]->numsol;
					$_cuota_emergente=$resultCredEmer_Cabec[0]->cuota;
					$_interes_emergente=$resultCredEmer_Cabec[0]->interes;
					$_tipo_emergente=$resultCredEmer_Cabec[0]->tipo;
					$_plazo_emergente=$resultCredEmer_Cabec[0]->plazo;
					$_fcred_emergente=$resultCredEmer_Cabec[0]->fcred;
					$_ffin_emergente=$resultCredEmer_Cabec[0]->ffin;
					$_cuenta_emergente=$resultCredEmer_Cabec[0]->cuenta;
					$_banco_emergente=$resultCredEmer_Cabec[0]->banco;
						
						
	
					if($_numsol_emergente != ""){
	
						
						$columnas_emer_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
						
						$tablas_emer_detall="emergente_detalle";
						$where_emer_detall="numsol='$_numsol_emergente'";
						$id_emer_detall="pago";
						//$resultCredEmer_Detall=$emergente_detalle->getCondicionesDesc($columnas_emer_detall, $tablas_emer_detall, $where_emer_detall, $id_emer_detall);
						
						
	
	
						if(!empty($search)){
	
	
							$where1=" AND (mes LIKE '%".$search."%' OR estado LIKE '%".$search."%')";
	
							$where_to=$where_emer_detall.$where1;
						}else{
	
							$where_to=$where_emer_detall;
	
						}
	
	
	
						$resultSet=$emergente_detalle->getCantidad("*", $tablas_emer_detall, $where_to);
						$cantidadResult=(int)$resultSet[0]->total;
	
						$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
						$per_page = 15; //la cantidad de registros que desea mostrar
						$adjacents  = 9; //brecha entre páginas después de varios adyacentes
						$offset = ($page - 1) * $per_page;
	
						$limit = " LIMIT   '$per_page' OFFSET '$offset'";
							
						$resultSet=$emergente_detalle->getCondicionesPagDesc($columnas_emer_detall, $tablas_emer_detall, $where_to, $id_emer_detall, $limit);
	
						$count_query   = $cantidadResult;
						$total_pages = ceil($cantidadResult/$per_page);
	
	
	
	
						if($cantidadResult>0)
						{
								
							$html.='<div class="col-lg-12 col-xs-12 col-md-12">';
							$html.='<div class="row">';
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">No de Solicitud:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_numsol_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
								
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Cuota:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuota_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
								
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Interes:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_interes_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
								
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Tipo:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_tipo_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
								
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">PLazo:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_plazo_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
								
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
	
	
							$html.='<div class="row">';
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Termina en:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_ffin_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
								
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Cuenta No:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuenta_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
								
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Banco:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_banco_emergente.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
								
								
								
								
							$html.='<div class="pull-left" style="margin-left:11px;">';
							$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
							$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
							$html.='</div>';
							$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
							$html.='<section style="height:425px; overflow-y:scroll;">';
							$html.= "<table id='tabla_credito_emergente' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
							$html.= "<thead>";
							$html.= "<tr>";
							$html.='<th style="text-align: left;  font-size: 12px;"></th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Pago</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Mes</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">A&ntilde;o</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Fecha Pago</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Capital</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Interes</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Interes por Mora</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Seguro Desgr.</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Total</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Saldo</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
							$html.='</tr>';
							$html.='</thead>';
							$html.='<tbody>';
	
							$i=0;
	
							foreach ($resultSet as $res)
							{
								$i++;
								$html.='<tr>';
								$html.='<td style="font-size: 11px;">'.$i.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->pago.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->mes.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->ano.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->fecpag.'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->capital, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->interes, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->intmor, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->seguros, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->total, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->saldo, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.$res->estado.'</td>';
								$html.='</tr>';
							}
	
	
							$html.='</tbody>';
							$html.='</table>';
							$html.='</section></div>';
							$html.='<div class="table-pagination pull-right">';
							$html.=''. $this->paginate_credito_emergente("index.php", $page, $total_pages, $adjacents).'';
							$html.='</div>';
	
	
	
						}else{
							$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
							$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
							$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
							$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
							$html.='</div>';
							$html.='</div>';
						}
	
	
	
					}else{
	
						$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
						$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
						$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
						$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
						$html.='</div>';
						$html.='</div>';
					}
	
	
				}else{
						
					$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
					$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
					$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
					$html.='</div>';
					$html.='</div>';
						
				}
	
	
	
				echo $html;
				die();
	
			}
	
	
		}
	
	
	}
	
	
	
	
	
	
	
	
	

	public function cargar_credito_2x1(){
	
		session_start();
		$c2x1_solicitud = new C2x1_solicitudModel();
		$c2x1_detalle = new C2x1_detalleModel();
		$where_to="";
	
	
		$cedula_usuarios = $_SESSION["cedula_usuarios"];
	
		if(!empty($cedula_usuarios)){
	
	
			$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
			$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
	
	
			if($action == 'ajax')
			{
				$html="";
	
				
				
				$columnas_2_x_1_cabec ="*";
				$tablas_2_x_1_cabec="c2x1_solicitud";
				$where_2_x_1_cabec="cedula='$cedula_usuarios'";
				$id_2_x_1_cabec="cedula";
				$resultCred2_x_1_Cabec=$c2x1_solicitud->getCondicionesDesc($columnas_2_x_1_cabec, $tablas_2_x_1_cabec, $where_2_x_1_cabec, $id_2_x_1_cabec);
				
				
	
					
				if(!empty($resultCred2_x_1_Cabec)){
	
					$_numsol_2x1=$resultCred2_x_1_Cabec[0]->numsol;
					$_cuota_2x1=$resultCred2_x_1_Cabec[0]->cuota;
					$_interes_2x1=$resultCred2_x_1_Cabec[0]->interes;
					$_tipo_2x1=$resultCred2_x_1_Cabec[0]->tipo;
					$_plazo_2x1=$resultCred2_x_1_Cabec[0]->plazo;
					$_fcred_2x1=$resultCred2_x_1_Cabec[0]->fcred;
					$_ffin_2x1=$resultCred2_x_1_Cabec[0]->ffin;
					$_cuenta_2x1=$resultCred2_x_1_Cabec[0]->cuenta;
					$_banco_2x1=$resultCred2_x_1_Cabec[0]->banco;
	
	
	
					if($_numsol_2x1 != ""){
	
	
						$columnas_2_x_1_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
						$tablas_2_x_1_detall="c2x1_detalle";
						$where_2_x_1_detall="numsol='$_numsol_2x1'";
						$id_2_x_1_detall="pago";
					
					
						//$resultCred2_x_1_Detall=$c2x1_detalle->getCondicionesDesc($columnas_2_x_1_detall, $tablas_2_x_1_detall, $where_2_x_1_detall, $id_2_x_1_detall);
							
	
	
						if(!empty($search)){
	
	
							$where1=" AND (mes LIKE '%".$search."%' OR estado LIKE '%".$search."%')";
	
							$where_to=$where_2_x_1_detall.$where1;
						}else{
	
							$where_to=$where_2_x_1_detall;
	
						}
	
	
	
						$resultSet=$c2x1_detalle->getCantidad("*", $tablas_2_x_1_detall, $where_to);
						$cantidadResult=(int)$resultSet[0]->total;
	
						$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	
						$per_page = 15; //la cantidad de registros que desea mostrar
						$adjacents  = 9; //brecha entre páginas después de varios adyacentes
						$offset = ($page - 1) * $per_page;
	
						$limit = " LIMIT   '$per_page' OFFSET '$offset'";
							
						$resultSet=$c2x1_detalle->getCondicionesPagDesc($columnas_2_x_1_detall, $tablas_2_x_1_detall, $where_to, $id_2_x_1_detall, $limit);
							
						$count_query   = $cantidadResult;
						$total_pages = ceil($cantidadResult/$per_page);
	
	
	
	
						if($cantidadResult>0)
						{
	
							$html.='<div class="col-lg-12 col-xs-12 col-md-12">';
							$html.='<div class="row">';
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">No de Solicitud:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_numsol_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
	
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Cuota:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuota_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
	
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Interes:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_interes_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
	
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Tipo:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_tipo_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
	
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">PLazo:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_plazo_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
	
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
	
	
							$html.='<div class="row">';
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Termina en:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_ffin_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
	
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Cuenta No:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuenta_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
	
							$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
							$html.='<div class="form-group">';
							$html.='<label for="cedula_participe" class="control-label">Banco:</label>';
							$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_banco_2x1.'" readonly>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
							$html.='</div>';
	
	
	
	
							$html.='<div class="pull-left" style="margin-left:11px;">';
							$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
							$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
							$html.='</div>';
							$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
							$html.='<section style="height:425px; overflow-y:scroll;">';
							$html.= "<table id='tabla_credito_2x1' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
							$html.= "<thead>";
							$html.= "<tr>";
							$html.='<th style="text-align: left;  font-size: 12px;"></th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Pago</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Mes</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">A&ntilde;o</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Fecha Pago</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Capital</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Interes</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Interes por Mora</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Seguro Desgr.</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Total</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Saldo</th>';
							$html.='<th style="text-align: left;  font-size: 12px;">Estado</th>';
							$html.='</tr>';
							$html.='</thead>';
							$html.='<tbody>';
	
							$i=0;
	
							foreach ($resultSet as $res)
							{
								$i++;
								$html.='<tr>';
								$html.='<td style="font-size: 11px;">'.$i.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->pago.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->mes.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->ano.'</td>';
								$html.='<td style="font-size: 11px;">'.$res->fecpag.'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->capital, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->interes, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->intmor, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->seguros, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->total, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.number_format($res->saldo, 2, '.', ',').'</td>';
								$html.='<td style="font-size: 11px;">'.$res->estado.'</td>';
								$html.='</tr>';
							}
	
	
							$html.='</tbody>';
							$html.='</table>';
							$html.='</section></div>';
							$html.='<div class="table-pagination pull-right">';
							$html.=''. $this->paginate_credito_2x1("index.php", $page, $total_pages, $adjacents).'';
							$html.='</div>';
	
	
	
						}else{
							$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
							$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
							$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
							$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
							$html.='</div>';
							$html.='</div>';
						}
	
	
	
					}else{
	
						$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
						$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
						$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
						$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
						$html.='</div>';
						$html.='</div>';
					}
	
	
				}else{
	
					$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
					$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
					$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
					$html.='</div>';
					$html.='</div>';
	
				}
	
	
	
				echo $html;
				die();
	
			}
	
	
		}
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	public function index(){
	
		session_start();
     	$roles=new RolesModel();
		
		$participe = new ParticipeModel();
		
		
		
		
		$resultParticipe="";
		
		
		
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
		
	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{

			$nombre_controladores = "SaldosCuentaIndividual";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $roles->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{	
				
				$cedula_usuarios = $_SESSION["cedula_usuarios"];
				
				if(!empty($cedula_usuarios)){
					
				/*	$columnas_ind="afiliado_transacc_cta_ind.id_afiliado_transacc_cta_ind,
						  afiliado_transacc_cta_ind.ordtran,
						  afiliado_transacc_cta_ind.histo_transacsys,
						  afiliado_transacc_cta_ind.cedula,
						  afiliado_transacc_cta_ind.fecha_conta,
						  afiliado_transacc_cta_ind.descripcion,
						  afiliado_transacc_cta_ind.mes_anio,
						  afiliado_transacc_cta_ind.valorper,
						  afiliado_transacc_cta_ind.valorpat,
						  afiliado_transacc_cta_ind.saldoper,
						  afiliado_transacc_cta_ind.saldopat,
						  afiliado_transacc_cta_ind.id_afiliado";
					$tablas_ind="public.afiliado_transacc_cta_ind";
					$where_ind="1=1 AND afiliado_transacc_cta_ind.cedula='$cedula_usuarios'";
					$id_ind="afiliado_transacc_cta_ind.ordtran";
					$resultDatos_Cta_individual=$afiliado_transacc_cta_ind->getCondicionesDesc($columnas_ind, $tablas_ind, $where_ind, $id_ind);
					
					
					$columnas_ind_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
					$tablas_ind_mayor="afiliado_transacc_cta_ind";
					$where_ind_mayor="cedula='$cedula_usuarios'";
					$resultDatosMayor_Cta_individual=$afiliado_transacc_cta_ind->getCondicionesValorMayor($columnas_ind_mayor, $tablas_ind_mayor, $where_ind_mayor);
					
					
					
					$columnas_desemb="afiliado_transacc_cta_desemb.id_afiliado_transacc_cta_desemb,
						  afiliado_transacc_cta_desemb.ordtran,
						  afiliado_transacc_cta_desemb.histo_transacsys,
						  afiliado_transacc_cta_desemb.cedula,
						  afiliado_transacc_cta_desemb.fecha_conta,
						  afiliado_transacc_cta_desemb.descripcion,
						  afiliado_transacc_cta_desemb.mes_anio,
						  afiliado_transacc_cta_desemb.valorper,
						  afiliado_transacc_cta_desemb.valorpat,
						  afiliado_transacc_cta_desemb.saldoper,
						  afiliado_transacc_cta_desemb.saldopat,
						  afiliado_transacc_cta_desemb.id_afiliado";
					$tablas_desemb="public.afiliado_transacc_cta_desemb";
					$where_desemb="1=1 AND afiliado_transacc_cta_desemb.cedula='$cedula_usuarios'";
					$id_desemb="afiliado_transacc_cta_desemb.ordtran";
					$resultDatos_Cta_desembolsar=$afiliado_transacc_cta_desemb->getCondicionesDesc($columnas_desemb, $tablas_desemb, $where_desemb, $id_desemb);
					
					
					
					$columnas_desemb_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
					$tablas_desemb_mayor="afiliado_transacc_cta_desemb";
					$where_desemb_mayor="cedula='$cedula_usuarios'";
					$resultDatosMayor_Cta_desembolsar=$afiliado_transacc_cta_desemb->getCondicionesValorMayor($columnas_desemb_mayor, $tablas_desemb_mayor, $where_desemb_mayor);
					
					
					
					
					// credito ordinario
					
					$columnas_ordi_cabec ="*";
					$tablas_ordi_cabec="ordinario_solicitud";
					$where_ordi_cabec="cedula='$cedula_usuarios'";
					$id_ordi_cabec="cedula";
					$resultCredOrdi_Cabec=$ordinario_solicitud->getCondicionesDesc($columnas_ordi_cabec, $tablas_ordi_cabec, $where_ordi_cabec, $id_ordi_cabec);
						
					if(!empty($resultCredOrdi_Cabec)){
						
						$_numsol_ordinario=$resultCredOrdi_Cabec[0]->numsol;
						
						if($_numsol_ordinario != ""){
							
							$columnas_ordi_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
								
							$tablas_ordi_detall="ordinario_detalle";
							$where_ordi_detall="numsol='$_numsol_ordinario'";
							$id_ordi_detall="pago";
							$resultCredOrdi_Detall=$ordinario_detalle->getCondicionesDesc($columnas_ordi_detall, $tablas_ordi_detall, $where_ordi_detall, $id_ordi_detall);
							
							
						}
						
						
					}
					
						
					
					
					// credito emergente
					
					$columnas_emer_cabec ="*";
					$tablas_emer_cabec="emergente_solicitud";
					$where_emer_cabec="cedula='$cedula_usuarios'";
					$id_emer_cabec="cedula";
					$resultCredEmer_Cabec=$emergente_solicitud->getCondicionesDesc($columnas_emer_cabec, $tablas_emer_cabec, $where_emer_cabec, $id_emer_cabec);
						
						
					if(!empty($resultCredEmer_Cabec)){
					
						$_numsol_emergente=$resultCredEmer_Cabec[0]->numsol;
					
						if($_numsol_emergente != ""){
							
							$columnas_emer_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
								
							$tablas_emer_detall="emergente_detalle";
							$where_emer_detall="numsol='$_numsol_emergente'";
							$id_emer_detall="pago";
							$resultCredEmer_Detall=$emergente_detalle->getCondicionesDesc($columnas_emer_detall, $tablas_emer_detall, $where_emer_detall, $id_emer_detall);
							
						}
					}
					
					
					// credito 2 x 1
					
					$columnas_2_x_1_cabec ="*";
					$tablas_2_x_1_cabec="c2x1_solicitud";
					$where_2_x_1_cabec="cedula='$cedula_usuarios'";
					$id_2_x_1_cabec="cedula";
					$resultCred2_x_1_Cabec=$c2x1_solicitud->getCondicionesDesc($columnas_2_x_1_cabec, $tablas_2_x_1_cabec, $where_2_x_1_cabec, $id_2_x_1_cabec);
						
					
					if(!empty($resultCred2_x_1_Cabec)){
							
						$_numsol_2x1=$resultCred2_x_1_Cabec[0]->numsol;
							
						if($_numsol_2x1 != ""){
				
					
							$columnas_2_x_1_detall ="numsol,
										pago,
										mes,
										ano,
										fecpag,ROUND(capital,2) as capital,
										ROUND(interes,2) as interes,
										ROUND(intmor,2) as intmor,
										ROUND(seguros,2) as seguros,
										ROUND(total,2) as total,
										ROUND(saldo,2) as saldo,
										estado";
							$tablas_2_x_1_detall="c2x1_detalle";
							$where_2_x_1_detall="numsol='$_numsol_2x1'";
							$id_2_x_1_detall="pago";
							$resultCred2_x_1_Detall=$c2x1_detalle->getCondicionesDesc($columnas_2_x_1_detall, $tablas_2_x_1_detall, $where_2_x_1_detall, $id_2_x_1_detall);
								
							
						}
					
					}
						*/	
				

					// informacion participe
					
					$columnas_participe="afiliado_extras.id_afiliado_extras,
									  afiliado_extras.cedula,
									  afiliado_extras.nombre,
									  afiliado_extras.direccion,
									  afiliado_extras.telefono,
									  afiliado_extras.celular,
									  afiliado_extras.correo,
									  afiliado_extras.edad,
									  afiliado_extras.hijos,
									  afiliado_extras.sueldo,
									  afiliado_extras.fecha_ingreso,
									  afiliado_extras.estado,
									  afiliado_extras.labor,
									  afiliado_extras.observacion,
									  afiliado_extras.estado_activacion,
									  afiliado_extras.clave,
									  afiliado_extras.administrador,
									  afiliado_extras.id_afiliado,
									  afiliado_extras.id_provincias_vivienda,
									  afiliado_extras.id_cantones_vivienda,
									  afiliado_extras.id_parroquias_vivienda,
									  afiliado_extras.id_provincias_asignacion,
									  afiliado_extras.id_cantones_asignacion,
									  afiliado_extras.id_parroquias_asignacion,
									  afiliado_extras.id_sexo,
									  afiliado_extras.id_tipo_sangre,
									  afiliado_extras.id_estado_civil,
									  afiliado_extras.id_entidades,
									  afiliado_extras.id_estado";
					$tablas_participe="public.afiliado_extras";
					$where_participe="afiliado_extras.cedula='$cedula_usuarios'";
					$id_participe="afiliado_extras.cedula";
					$resultParticipe=$participe->getCondiciones($columnas_participe, $tablas_participe, $where_participe, $id_participe);
					
						
					
					
				}else{
					
					
					$resultParticipe="";
					
				}
				
			
		
				
				$this->view("SaldosCuentaIndividual",array(
					   "resultSexo"=>$resultSexo, "resultEstado_civil"=>$resultEstado_civil, "resultTipo_sangre"=>$resultTipo_sangre, "resultEstado"=>$resultEstado, "resultEntidades"=>$resultEntidades,
					    "resultProvincias"=>$resultProvincias,
						"resultParroquias"=>$resultParroquias, "resultCantones"=>$resultCantones, 
						"resultParticipe"=>$resultParticipe
					
				));
		
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Saldos Cuenta Individual."
				
				));
				
				exit();	
			}
				
		}
		else 
		{
				$this->view("Login",array(
						"resultSet"=>""
			
				));
		
		}
	
	}
	
	
	
	
	
	
	
	
	public function ActualizarParticipe(){
		
		session_start();
		
		if (isset(  $_SESSION['nombre_usuarios']) )
		{
				
			$usuarios = new UsuariosModel();
			$participes = new ParticipeModel();
			
			if ( isset($_POST["cedula"]) )
			{
					
				$_cedula    = $_POST["cedula"];
				$_nombre     = $_POST["nombre"];
				$_direccion     = $_POST["direccion"];
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
				$_id_estado           = $_POST["id_estado"];
				$_id_provincias_vivienda          = $_POST["id_provincias_vivienda"];
				$_id_cantones_vivienda          = $_POST["id_cantones_vivienda"];
				$_id_parroquias_vivienda         = $_POST["id_parroquias_vivienda"];
				$_id_provincias_asignacion          = $_POST["id_provincias_asignacion"];
				$_id_cantones_asignacion          = $_POST["id_cantones_asignacion"];
				$_id_parroquias_asignacion         = $_POST["id_parroquias_asignacion"];
				$_observacion        = $_POST["observacion"];
				
				
				
				try {
					
					
					$colval = "nombre= '$_nombre',
					direccion = '$_direccion',
					labor = '$_labor',
					correo='$_correo',
					telefono = '$_telefono',
					celular = '$_celular',
					id_entidades = '$_id_entidades',
					sueldo = '$_sueldo',
					hijos = '$_hijos',
					edad = '$_edad',
					id_sexo = '$_id_sexo',
					id_estado_civil = '$_id_estado_civil',
					id_tipo_sangre = '$_id_tipo_sangre',
					id_provincias_vivienda = '$_id_provincias_vivienda',
					id_cantones_vivienda = '$_id_cantones_vivienda',
					id_parroquias_vivienda = '$_id_parroquias_vivienda',
					id_provincias_asignacion = '$_id_provincias_asignacion',
					id_cantones_asignacion = '$_id_cantones_asignacion',
					id_parroquias_asignacion = '$_id_parroquias_asignacion',
					observacion = '$_observacion',
					fecha_ingreso= '$_fecha_ingreso'";
					
					$tabla = "afiliado_extras";
					
					$where = "cedula = '$_cedula'";
					
					$resultado=$participes->UpdateBy($colval, $tabla, $where);
					
					
					
				} catch (Exception $e) {
					
					$this->redirect("SaldosCuentaIndividual", "index");
					
				}
	
				
				
				
				if($_correo!=""){
					try {
						$colval1 = "nombre_usuarios= '$_nombre',
						correo_usuarios='$_correo',
						telefono_usuarios = '$_telefono',
						celular_usuarios = '$_celular'";
						
						$tabla1 = "usuarios";
						
						$where1 = "cedula_usuarios = '$_cedula'";
						
						$resultado=$usuarios->UpdateBy($colval1, $tabla1, $where1);
					} catch (Exception $e) {
					}
					
				}
					
					
				$this->redirect("SaldosCuentaIndividual", "index");
	
	
			}
			else
			{
				
				$this->redirect("SaldosCuentaIndividual", "index");
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
	
	
	
	
	public function paginate_cuenta_individual($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_cta_individual(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_cta_individual(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_cta_individual(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_cta_individual(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_cta_individual(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_cta_individual($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_cta_individual(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	public function paginate_cuenta_desembolsar($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_cta_desembolsar(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_cta_desembolsar(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_cta_desembolsar(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_cta_desembolsar(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_cta_desembolsar(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_cta_desembolsar($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_cta_desembolsar(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	public function paginate_credito_ordinario($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_ordinario(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_ordinario(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_credito_ordinario(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_credito_ordinario(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_credito_ordinario(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_credito_ordinario($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_ordinario(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	
	public function paginate_credito_emergente($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_emergente(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_emergente(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_credito_emergente(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_credito_emergente(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_credito_emergente(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_credito_emergente($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_emergente(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
	
	public function paginate_credito_2x1($reload, $page, $tpages, $adjacents) {
	
		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$out = '<ul class="pagination pagination-large">';
	
		// previous label
	
		if($page==1) {
			$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
		} else if($page==2) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_2x1(1)'>$prevlabel</a></span></li>";
		}else {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_2x1(".($page-1).")'>$prevlabel</a></span></li>";
	
		}
	
		// first label
		if($page>($adjacents+1)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_credito_2x1(1)'>1</a></li>";
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
				$out.= "<li><a href='javascript:void(0);' onclick='load_credito_2x1(1)'>$i</a></li>";
			}else {
				$out.= "<li><a href='javascript:void(0);' onclick='load_credito_2x1(".$i.")'>$i</a></li>";
			}
		}
	
		// interval
	
		if($page<($tpages-$adjacents-1)) {
			$out.= "<li><a>...</a></li>";
		}
	
		// last
	
		if($page<($tpages-$adjacents)) {
			$out.= "<li><a href='javascript:void(0);' onclick='load_credito_2x1($tpages)'>$tpages</a></li>";
		}
	
		// next
	
		if($page<$tpages) {
			$out.= "<li><span><a href='javascript:void(0);' onclick='load_credito_2x1(".($page+1).")'>$nextlabel</a></span></li>";
		}else {
			$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
		}
	
		$out.= "</ul>";
		return $out;
	}
	
	
}
?>