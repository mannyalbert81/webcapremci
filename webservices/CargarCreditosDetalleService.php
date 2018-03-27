<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();

if(isset($_GET['cargar'])){
	
	if(isset($_GET['cedula'])){
	
		$cargar=$_GET["cargar"];
		$cedula_usuarios=$_GET["cedula"];
		
		if(!empty($cedula_usuarios)){
			
			
			if($cargar=='cargar_cta_individual')
			{	
				
				$where_to="";

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
					$resultSet=$db->getCantidad("*", $tablas_ind, $where_to);
					$cantidadResult=(int)$resultSet[0]->total;
				
					$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
					$per_page = 10; //la cantidad de registros que desea mostrar
					$adjacents  = 5; //brecha entre páginas después de varios adyacentes
					$offset = ($page - 1) * $per_page;
				
					$limit = " LIMIT   '$per_page' OFFSET '$offset'";
				
					$resultSet=$db->getCondicionesPagDesc($columnas_ind, $tablas_ind, $where_to, $id_ind, $limit);
				
					$count_query   = $cantidadResult;
					$total_pages = ceil($cantidadResult/$per_page);
				
				
				
				
					if($cantidadResult>0)
					{
						$resultDatosMayor_Cta_individual=$db->getCondicionesValorMayor($columnas_ind_mayor, $tablas_ind_mayor, $where_ind_mayor);
				
						if (!empty($resultDatosMayor_Cta_individual)) {  foreach($resultDatosMayor_Cta_individual as $res) {
							 
							$fecha=$res->fecha;
							$total= number_format($res->total, 2, '.', ',');
						}}else{
								
							$fecha="";
							$total= 0.00;
				
						}
				
						$html.='<center><h5>Total Cuenta Individual Actualizada al '.$fecha.' : $'.$total.'</h5></center>';
						$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
						$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=cta_individual" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
						$html.='</div>';
						$html.='<div class="pull-left" style="margin-left:11px;">';
						$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
						$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
						$html.='</div>';
						$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
						$html.='<section style="height:380px; overflow-y:scroll;">';
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
						$html.=''. $db->paginate_cuenta_individual("index.php", $page, $total_pages, $adjacents).'';
						$html.='</div>';
				
							
					}else{
						$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
						$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
						$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
						$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
						$html.='</div>';
						$html.='</div>';
					}
				
						
			    $resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				}
				
				
				
			}
			
			
			
			if($cargar=='cargar_cta_desembolsar')
			{
				$where_to="";


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
					$resultSet=$db->getCantidad("*", $tablas_desemb, $where_to);
					$cantidadResult=(int)$resultSet[0]->total;
				
					$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
					$per_page = 10; //la cantidad de registros que desea mostrar
					$adjacents  = 5; //brecha entre páginas después de varios adyacentes
					$offset = ($page - 1) * $per_page;
				
					$limit = " LIMIT   '$per_page' OFFSET '$offset'";
						
					$resultSet=$db->getCondicionesPagDesc($columnas_desemb, $tablas_desemb, $where_to, $id_desemb, $limit);
				
					$count_query   = $cantidadResult;
					$total_pages = ceil($cantidadResult/$per_page);
				
				
				
				
					if($cantidadResult>0)
					{
						$resultDatosMayor_Cta_desembolsar=$db->getCondicionesValorMayor($columnas_desemb_mayor, $tablas_desemb_mayor, $where_desemb_mayor);
				
						if (!empty($resultDatosMayor_Cta_desembolsar)) {  foreach($resultDatosMayor_Cta_desembolsar as $res) {
								
							$fecha=$res->fecha;
							$total= number_format($res->total, 2, '.', ',');
						}}else{
								
							$fecha="";
							$total= 0.00;
				
						}
				
						$html.='<center><h5>Total Cuenta Por Desembolsar Actualizada al '.$fecha.' : $'.$total.'</h5></center>';
						$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
						$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=cta_desembolsar" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
						$html.='</div>';
							
						$html.='<div class="pull-left" style="margin-left:11px;">';
						$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
						$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
						$html.='</div>';
						$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
						$html.='<section style="height:380px; overflow-y:scroll;">';
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
						$html.=''. $db->paginate_cuenta_desembolsar("index.php", $page, $total_pages, $adjacents).'';
						$html.='</div>';
				
				
				
					}else{
						$html.='<div class="col-lg-6 col-md-6 col-xs-12">';
						$html.='<div class="alert alert-info alert-dismissable" style="margin-top:40px;">';
						$html.='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
						$html.='<h4>Aviso!!!</h4> <b>Actualmente no hay datos para mostrar...</b>';
						$html.='</div>';
						$html.='</div>';
					}
				
				
				
					
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				}
				
				
				
			}
			
			
			if($cargar=='cargar_credito_ordinario')
			{
				
				$where_to="";
				
				$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
				$search = (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				
				
				if($action == 'ajax')
				{
					$html="";
					$columnas_ordi_cabec ="*";
					$tablas_ordi_cabec="ordinario_solicitud";
					$where_ordi_cabec="cedula='$cedula_usuarios'";
					$id_ordi_cabec="cedula";
					$resultCredOrdi_Cabec=$db->getCondicionesDesc($columnas_ordi_cabec, $tablas_ordi_cabec, $where_ordi_cabec, $id_ordi_cabec);
						
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
						$_valor_ordinario= number_format($resultCredOrdi_Cabec[0]->valor, 2, '.', ',');
							
							
				
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
				
				
				
							$resultSet=$db->getCantidad("*", $tablas_ordi_detall, $where_to);
							$cantidadResult=(int)$resultSet[0]->total;
				
							$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
							$per_page = 10; //la cantidad de registros que desea mostrar
							$adjacents  = 5; //brecha entre páginas después de varios adyacentes
							$offset = ($page - 1) * $per_page;
				
							$limit = " LIMIT   '$per_page' OFFSET '$offset'";
								
							$resultSet=$db->getCondicionesPagDesc($columnas_ordi_detall, $tablas_ordi_detall, $where_to, $id_ordi_detall, $limit);
				
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
								$html.='<label for="cedula_participe" class="control-label">Monto Concedido:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_valor_ordinario.'" readonly>';
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
								$html.='</div>';
				
				
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_ordinario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
									
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
									
									
									
								$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
								$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=ordinario" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
								$html.='</div>';
									
									
									
									
								$html.='<div class="pull-left" style="margin-left:11px;">';
								$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
								$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
								$html.='</div>';
								$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
								$html.='<section style="height:380px; overflow-y:scroll;">';
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
								$html.=''. $db->paginate_credito_ordinario("index.php", $page, $total_pages, $adjacents).'';
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
				
				
					$resultadosJson = json_encode($html);
					echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
					
				}
			
				
			}
			
			
			
			if($cargar=='cargar_credito_emergente')
			{
				
				$where_to="";
				
			
				$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
				$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				
				
				if($action == 'ajax')
				{
					$html="";
				
					$columnas_emer_cabec ="*";
					$tablas_emer_cabec="emergente_solicitud";
					$where_emer_cabec="cedula='$cedula_usuarios'";
					$id_emer_cabec="cedula";
					$resultCredEmer_Cabec=$db->getCondicionesDesc($columnas_emer_cabec, $tablas_emer_cabec, $where_emer_cabec, $id_emer_cabec);
				
						
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
						$_valor_emergente= number_format($resultCredEmer_Cabec[0]->valor, 2, '.', ',');
				
				
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
				
							$resultSet=$db->getCantidad("*", $tablas_emer_detall, $where_to);
							$cantidadResult=(int)$resultSet[0]->total;
				
							$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
							$per_page = 10; //la cantidad de registros que desea mostrar
							$adjacents  = 5; //brecha entre páginas después de varios adyacentes
							$offset = ($page - 1) * $per_page;
				
							$limit = " LIMIT   '$per_page' OFFSET '$offset'";
								
							$resultSet=$db->getCondicionesPagDesc($columnas_emer_detall, $tablas_emer_detall, $where_to, $id_emer_detall, $limit);
				
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
								$html.='<label for="cedula_participe" class="control-label">Monto Concedido:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_valor_emergente.'" readonly>';
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
								$html.='</div>';
				
				
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_emergente.'" readonly>';
								$html.='</div>';
								$html.='</div>';
									
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
				
				
								$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
								$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=emergente" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
								$html.='</div>';
				
				
								$html.='<div class="pull-left" style="margin-left:11px;">';
								$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
								$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
								$html.='</div>';
								$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
								$html.='<section style="height:380px; overflow-y:scroll;">';
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
								$html.=''. $db->paginate_credito_emergente("index.php", $page, $total_pages, $adjacents).'';
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
				
				
				
					$resultadosJson = json_encode($html);
				    echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				}
				
				
				
				
				
				
				
				
			}
			
			
			if($cargar=='cargar_credito_2x1')
			{
				
				$where_to="";



				$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
				$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				
				
				if($action == 'ajax')
				{
					$html="";
				
				
				
					$columnas_2_x_1_cabec ="*";
					$tablas_2_x_1_cabec="c2x1_solicitud";
					$where_2_x_1_cabec="cedula='$cedula_usuarios'";
					$id_2_x_1_cabec="cedula";
					$resultCred2_x_1_Cabec=$db->getCondicionesDesc($columnas_2_x_1_cabec, $tablas_2_x_1_cabec, $where_2_x_1_cabec, $id_2_x_1_cabec);
				
				
				
						
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
						$_valor_2x1= number_format($resultCred2_x_1_Cabec[0]->valor, 2, '.', ',');
				
				
				
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
				
				
				
							$resultSet=$db->getCantidad("*", $tablas_2_x_1_detall, $where_to);
							$cantidadResult=(int)$resultSet[0]->total;
				
							$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
							$per_page = 10; //la cantidad de registros que desea mostrar
							$adjacents  = 5; //brecha entre páginas después de varios adyacentes
							$offset = ($page - 1) * $per_page;
				
							$limit = " LIMIT   '$per_page' OFFSET '$offset'";
								
							$resultSet=$db->getCondicionesPagDesc($columnas_2_x_1_detall, $tablas_2_x_1_detall, $where_to, $id_2_x_1_detall, $limit);
								
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
								$html.='<label for="cedula_participe" class="control-label">Monto Concedido:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_valor_2x1.'" readonly>';
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
								$html.='</div>';
				
				
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_2x1.'" readonly>';
								$html.='</div>';
								$html.='</div>';
									
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
				
								$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
								$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=2_x_1" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
								$html.='</div>';
				
				
								$html.='<div class="pull-left" style="margin-left:11px;">';
								$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
								$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
								$html.='</div>';
								$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
								$html.='<section style="height:380px; overflow-y:scroll;">';
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
								$html.=''. $db->paginate_credito_2x1("index.php", $page, $total_pages, $adjacents).'';
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
				
				
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				}
				
				
			}
			
			
			if($cargar=='cargar_credito_hipotecario')
			{
				$where_to="";


				$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
				$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				
				
				if($action == 'ajax')
				{
					$html="";
				
					$columnas_hipo_cabec ="*";
					$tablas_hipo_cabec="hipotecario_solicitud";
					$where_hipo_cabec="cedula='$cedula_usuarios'";
					$id_hipo_cabec="cedula";
					$resultCredHipo_Cabec=$db->getCondicionesDesc($columnas_hipo_cabec, $tablas_hipo_cabec, $where_hipo_cabec, $id_hipo_cabec);
				
				
						
					if(!empty($resultCredHipo_Cabec)){
				
						$_numsol_hipotecario=$resultCredHipo_Cabec[0]->numsol;
						$_cuota_hipotecario=$resultCredHipo_Cabec[0]->cuota;
						$_interes_hipotecario=$resultCredHipo_Cabec[0]->interes;
						$_tipo_hipotecario=$resultCredHipo_Cabec[0]->tipo;
						$_plazo_hipotecario=$resultCredHipo_Cabec[0]->plazo;
						$_fcred_hipotecario=$resultCredHipo_Cabec[0]->fcred;
						$_ffin_hipotecario=$resultCredHipo_Cabec[0]->ffin;
						$_cuenta_hipotecario=$resultCredHipo_Cabec[0]->cuenta;
						$_banco_hipotecario=$resultCredHipo_Cabec[0]->banco;
						$_valor_hipotecario= number_format($resultCredHipo_Cabec[0]->valor, 2, '.', ',');
				
				
				
						if($_numsol_hipotecario != ""){
				
				
							$columnas_hipo_detall ="numsol,
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
				
							$tablas_hipo_detall="hipotecario_detalle";
							$where_hipo_detall="numsol='$_numsol_hipotecario'";
							$id_hipo_detall="pago";
							//$resultCredEmer_Detall=$emergente_detalle->getCondicionesDesc($columnas_emer_detall, $tablas_emer_detall, $where_emer_detall, $id_emer_detall);
				
				
				
				
							if(!empty($search)){
				
				
								$where1=" AND (mes LIKE '%".$search."%' OR estado LIKE '%".$search."%')";
				
								$where_to=$where_hipo_detall.$where1;
							}else{
				
								$where_to=$where_hipo_detall;
				
							}
				
				
				
							$resultSet=$db->getCantidad("*", $tablas_hipo_detall, $where_to);
							$cantidadResult=(int)$resultSet[0]->total;
				
							$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
							$per_page = 10; //la cantidad de registros que desea mostrar
							$adjacents  = 5; //brecha entre páginas después de varios adyacentes
							$offset = ($page - 1) * $per_page;
				
							$limit = " LIMIT   '$per_page' OFFSET '$offset'";
								
							$resultSet=$db->getCondicionesPagDesc($columnas_hipo_detall, $tablas_hipo_detall, $where_to, $id_hipo_detall, $limit);
				
							$count_query   = $cantidadResult;
							$total_pages = ceil($cantidadResult/$per_page);
				
				
				
				
							if($cantidadResult>0)
							{
				
								$html.='<div class="col-lg-12 col-xs-12 col-md-12">';
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">No de Solicitud:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_numsol_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
									
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Monto Concedido:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_valor_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
									
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Cuota:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuota_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Interes:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_interes_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Tipo:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_tipo_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">PLazo:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_plazo_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
				
				
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
									
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Termina en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_ffin_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Cuenta No:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuenta_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Banco:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_banco_hipotecario.'" readonly>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
								$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=hipotecario" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
								$html.='</div>';
				
				
								$html.='<div class="pull-left" style="margin-left:11px;">';
								$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
								$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
								$html.='</div>';
								$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
								$html.='<section style="height:380px; overflow-y:scroll;">';
								$html.= "<table id='tabla_credito_hipotecario' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
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
								$html.=''. $db->paginate_credito_hipotecario("index.php", $page, $total_pages, $adjacents).'';
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
				
				
					$resultadosJson = json_encode($html);
					echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				}
				
				
				
				
			}
			
			
			if($cargar=='cargar_acuerdo_pago')
			{
				
				$where_to="";


				$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
				$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				
				
				if($action == 'ajax')
				{
					$html="";
				
					$columnas_app_cabec ="*";
					$tablas_app_cabec="app_solicitud";
					$where_app_cabec="cedula='$cedula_usuarios'";
					$id_app_cabec="cedula";
					$resultCredApp_Cabec=$db->getCondicionesDesc($columnas_app_cabec, $tablas_app_cabec, $where_app_cabec, $id_app_cabec);
				
				
						
					if(!empty($resultCredApp_Cabec)){
				
						$_numsol_app=$resultCredApp_Cabec[0]->numsol;
						$_cuota_app=$resultCredApp_Cabec[0]->cuota;
						$_interes_app=$resultCredApp_Cabec[0]->interes;
						$_tipo_app=$resultCredApp_Cabec[0]->tipo;
						$_plazo_app=$resultCredApp_Cabec[0]->plazo;
						$_fcred_app=$resultCredApp_Cabec[0]->fcred;
						$_ffin_app=$resultCredApp_Cabec[0]->ffin;
						$_cuenta_app=$resultCredApp_Cabec[0]->cuenta;
						$_banco_app=$resultCredApp_Cabec[0]->banco;
						$_valor_app= number_format($resultCredApp_Cabec[0]->valor, 2, '.', ',');
				
				
						if($_numsol_app != ""){
				
				
							$columnas_app_detall ="numsol,
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
				
							$tablas_app_detall="app_detalle";
							$where_app_detall="numsol='$_numsol_app'";
							$id_app_detall="pago";
							//$resultCredEmer_Detall=$emergente_detalle->getCondicionesDesc($columnas_emer_detall, $tablas_emer_detall, $where_emer_detall, $id_emer_detall);
				
				
				
				
							if(!empty($search)){
				
				
								$where1=" AND (mes LIKE '%".$search."%' OR estado LIKE '%".$search."%')";
				
								$where_to=$where_app_detall.$where1;
							}else{
				
								$where_to=$where_app_detall;
				
							}
				
				
				
							$resultSet=$db->getCantidad("*", $tablas_app_detall, $where_to);
							$cantidadResult=(int)$resultSet[0]->total;
				
							$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
							$per_page = 10; //la cantidad de registros que desea mostrar
							$adjacents  = 5; //brecha entre páginas después de varios adyacentes
							$offset = ($page - 1) * $per_page;
				
							$limit = " LIMIT   '$per_page' OFFSET '$offset'";
								
							$resultSet=$db->getCondicionesPagDesc($columnas_app_detall, $tablas_app_detall, $where_to, $id_app_detall, $limit);
				
							$count_query   = $cantidadResult;
							$total_pages = ceil($cantidadResult/$per_page);
				
				
				
				
							if($cantidadResult>0)
							{
				
								$html.='<div class="col-lg-12 col-xs-12 col-md-12">';
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">No de Solicitud:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_numsol_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
									
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Monto Concedido:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_valor_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
									
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Cuota:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuota_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Interes:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_interes_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Tipo:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_tipo_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">PLazo:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_plazo_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
				
				
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
									
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Termina en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_ffin_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Cuenta No:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuenta_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Banco:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_banco_app.'" readonly>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
				
				
								$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
								$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=acuerdo_pago" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
								$html.='</div>';
				
								$html.='<div class="pull-left" style="margin-left:11px;">';
								$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
								$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
								$html.='</div>';
								$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
								$html.='<section style="height:425px; overflow-y:scroll;">';
								$html.= "<table id='tabla_acuerdo_pago' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
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
								$html.=''. $db->paginate_acuerdo_pago("index.php", $page, $total_pages, $adjacents).'';
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
				
					
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				}
				
				
				
			}
			
			
			if($cargar=='cargar_credito_refinanciamiento')
			{
				
				$where_to="";



				$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
				$search =  (isset($_REQUEST['search'])&& $_REQUEST['search'] !=NULL)?$_REQUEST['search']:'';
				
				
				if($action == 'ajax')
				{
					$html="";
				
					$columnas_refi_cabec ="*";
					$tablas_refi_cabec="refinanciamiento_solicitud";
					$where_refi_cabec="cedula='$cedula_usuarios'";
					$id_refi_cabec="cedula";
					$resultCredRefi_Cabec=$db->getCondicionesDesc($columnas_refi_cabec, $tablas_refi_cabec, $where_refi_cabec, $id_refi_cabec);
				
				
						
					if(!empty($resultCredRefi_Cabec)){
				
						$_numsol_refinanciamiento=$resultCredRefi_Cabec[0]->numsol;
						$_cuota_refinanciamiento=$resultCredRefi_Cabec[0]->cuota;
						$_interes_refinanciamiento=$resultCredRefi_Cabec[0]->interes;
						$_tipo_refinanciamiento=$resultCredRefi_Cabec[0]->tipo;
						$_plazo_refinanciamiento=$resultCredRefi_Cabec[0]->plazo;
						$_fcred_refinanciamiento=$resultCredRefi_Cabec[0]->fcred;
						$_ffin_refinanciamiento=$resultCredRefi_Cabec[0]->ffin;
						$_cuenta_refinanciamiento=$resultCredRefi_Cabec[0]->cuenta;
						$_banco_refinanciamiento=$resultCredRefi_Cabec[0]->banco;
						$_valor_refinanciamiento= number_format($resultCredRefi_Cabec[0]->valor, 2, '.', ',');
				
				
				
						if($_numsol_refinanciamiento != ""){
				
				
							$columnas_refi_detall ="numsol,
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
				
							$tablas_refi_detall="refinanciamiento_detalle";
							$where_refi_detall="numsol='$_numsol_refinanciamiento'";
							$id_refi_detall="pago";
							//$resultCredEmer_Detall=$emergente_detalle->getCondicionesDesc($columnas_emer_detall, $tablas_emer_detall, $where_emer_detall, $id_emer_detall);
				
				
				
				
							if(!empty($search)){
				
				
								$where1=" AND (mes LIKE '%".$search."%' OR estado LIKE '%".$search."%')";
				
								$where_to=$where_refi_detall.$where1;
							}else{
				
								$where_to=$where_refi_detall;
				
							}
				
				
				
							$resultSet=$db->getCantidad("*", $tablas_refi_detall, $where_to);
							$cantidadResult=(int)$resultSet[0]->total;
				
							$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
				
							$per_page = 10; //la cantidad de registros que desea mostrar
							$adjacents  = 5; //brecha entre páginas después de varios adyacentes
							$offset = ($page - 1) * $per_page;
				
							$limit = " LIMIT   '$per_page' OFFSET '$offset'";
								
							$resultSet=$db->getCondicionesPagDesc($columnas_refi_detall, $tablas_refi_detall, $where_to, $id_refi_detall, $limit);
				
							$count_query   = $cantidadResult;
							$total_pages = ceil($cantidadResult/$per_page);
				
				
				
				
							if($cantidadResult>0)
							{
				
								$html.='<div class="col-lg-12 col-xs-12 col-md-12">';
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">No de Solicitud:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_numsol_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Monto Concedido:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_valor_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Cuota:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuota_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Interes:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_interes_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Tipo:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_tipo_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">PLazo:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_plazo_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
				
				
								$html.='<div class="row">';
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Concedido en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_fcred_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Termina en:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_ffin_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Cuenta No:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_cuenta_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-2 col-xs-12 col-md-2">';
								$html.='<div class="form-group">';
								$html.='<label for="cedula_participe" class="control-label">Banco:</label>';
								$html.='<input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="'.$_banco_refinanciamiento.'" readonly>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
								$html.='</div>';
				
								$html.='<div class="col-lg-12 col-md-12 col-xs-12" style="margin-top:20px; text-align: center;">';
								$html.='<a href="index.php?controller=SaldosCuentaIndividual&action=generar_reporte&credito=refinanciamiento" class="btn btn-success" target="_blank"><i class="glyphicon glyphicon-print"></i> Imprimir</a>';
								$html.='</div>';
				
				
								$html.='<div class="pull-left" style="margin-left:11px;">';
								$html.='<span class="form-control"><strong>Registros: </strong>'.$cantidadResult.'</span>';
								$html.='<input type="hidden" value="'.$cantidadResult.'" id="total_query" name="total_query"/>' ;
								$html.='</div>';
								$html.='<div class="col-lg-12 col-md-12 col-xs-12">';
								$html.='<section style="height:380px; overflow-y:scroll;">';
								$html.= "<table id='tabla_credito_refinanciamiento' class='tablesorter table table-striped table-bordered dt-responsive nowrap'>";
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
								$html.=''. $db->paginate_credito_refinanciamiento("index.php", $page, $total_pages, $adjacents).'';
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
				
				
				
					$resultadosJson = json_encode($html);
				    echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				}
				
				
				
			}
			
			
			
		}
		
		
	}
	
	
}











	
?>