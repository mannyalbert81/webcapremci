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
				
				$columnas_ind_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
				$tablas_ind_mayor="afiliado_transacc_cta_ind";
				$where_ind_mayor="cedula='$cedula_usuarios'";
				$result_Cta_Ind=$db->getCondicionesValorMayor($columnas_ind_mayor, $tablas_ind_mayor, $where_ind_mayor);
				
				$i=0;
				$i=count($result_Cta_Ind);
				$fecha="";
				$total= 0.00;
				$html="";
				if($i>0)
				{
					if (!empty($result_Cta_Ind)) {  foreach($result_Cta_Ind as $res) {
						$fecha=$res->fecha;
						$total= number_format($res->total, 2, '.', ',');
					}}else{
							
						$fecha="";
						$total= 0.00;
							
					}
				
						
					$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
					$html .= "<div class='info-box'>";
					$html .= "<span class='info-box-icon bg-red'><i class='ion ion-pie-graph'></i></span>";
					$html .= "<div class='info-box-content'>";
					$html .= "<span class='info-box-number'>$total</span>";
					$html .= "<span class='info-box-text'>Cuenta Individual Actualizada<br> al $fecha.</span>";
					$html .= "</div>";
					$html .= "</div>";
					$html .= "</div>";
						
				
				}else{
						
						
					$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
					$html .= "<div class='info-box'>";
					$html .= "<span class='info-box-icon bg-red'><i class='ion ion-pie-graph'></i></span>";
					$html .= "<div class='info-box-content'>";
					$html .= "<span class='info-box-number'>$total</span>";
					$html .= "<span class='info-box-text'>Actualmente no dispone cuenta<br> individual.</span>";
					$html .= "</div>";
					$html .= "</div>";
					$html .= "</div>";
						
				}
				
				
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				
			}
			
			
			
			if($cargar=='cargar_cta_desembolsar')
			{
			
				$columnas_desemb_mayor = "sum(valorper+valorpat) as total, max(fecha_conta) as fecha";
				$tablas_desemb_mayor="afiliado_transacc_cta_desemb";
				$where_desemb_mayor="cedula='$cedula_usuarios'";
				$result_Cta_Desem=$db->getCondicionesValorMayor($columnas_desemb_mayor, $tablas_desemb_mayor, $where_desemb_mayor);
				
				$i=0;
				$i=count($result_Cta_Desem);
				$fecha="";
				$total= 0.00;
				$html="";
				if($i>0)
				{
					if (!empty($result_Cta_Desem)) {  foreach($result_Cta_Desem as $res) {
						$fecha=$res->fecha;
						$total= number_format($res->total, 2, '.', ',');
					}}else{
				
						$fecha="";
						$total= 0.00;
				
					}
				
				
					$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
					$html .= "<div class='info-box'>";
					$html .= "<span class='info-box-icon bg-yellow'><i class='ion ion-stats-bars'></i></span>";
					$html .= "<div class='info-box-content'>";
					$html .= "<span class='info-box-number'>$total</span>";
					$html .= "<span class='info-box-text'>Cuenta Desembolsar Actualizada<br> al $fecha.</span>";
					$html .= "</div>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				
				
				}else{
				
				
					$html .= "<div class='col-md-4 col-sm-6 col-xs-12'>";
					$html .= "<div class='info-box'>";
					$html .= "<span class='info-box-icon bg-yellow'><i class='ion ion-stats-bars'></i></span>";
					$html .= "<div class='info-box-content'>";
					$html .= "<span class='info-box-number'>$total</span>";
					$html .= "<span class='info-box-text'>Actualmente no dispone Cuenta<br> Por Desembolsar.</span>";
					$html .= "</div>";
					$html .= "</div>";
					$html .= "</div>";
				
						
				}
					
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
			}
			
			
			if($cargar=='cargar_credito_ordinario')
			{
				$i=0;
				$columnas_ordi_cabec ="*";
				$tablas_ordi_cabec="ordinario_solicitud";
				$where_ordi_cabec="cedula='$cedula_usuarios'";
				$id_ordi_cabec="cedula";
				$resultSet=$db->getCondicionesDesc($columnas_ordi_cabec, $tablas_ordi_cabec, $where_ordi_cabec, $id_ordi_cabec);
					
				
				$i=count($resultSet);
					
				$html="";
				if($i>0)
				{
					if (!empty($resultSet)) {
						$_numsol_ordinario=$resultSet[0]->numsol;
						$_cuota_ordinario=$resultSet[0]->cuota;
						$_interes_ordinario=$resultSet[0]->interes;
						$_tipo_ordinario=$resultSet[0]->tipo;
						$_plazo_ordinario=$resultSet[0]->plazo;
						$_fcred_ordinario=$resultSet[0]->fcred;
						$_ffin_ordinario=$resultSet[0]->ffin;
						$_cuenta_ordinario=$resultSet[0]->cuenta;
						$_banco_ordinario=$resultSet[0]->banco;
						$_valor_ordinario=number_format($resultSet[0]->valor, 2, '.', ',');
							
					}
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-red'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>$_valor_ordinario</h3>";
					$html .= "<p>Tienes activo un crédito ordinario<br> desde $_fcred_ordinario hasta $_ffin_ordinario.</p>";
					$html .= "</div>";
				
				
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoOrdinario.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				}else{
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-red'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>0.00</h3>";
					$html .= "<p>Actualmente no dispone un crédito<br> ordinario.</p>";
					$html .= "</div>";
						
						
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoOrdinario.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
							
				}
				
				$resultadosJson = json_encode($html);
				
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
				
			}
			
			
			
			if($cargar=='cargar_credito_emergente')
			{
				$i=0;
				$columnas_emer_cabec ="*";
				$tablas_emer_cabec="emergente_solicitud";
				$where_emer_cabec="cedula='$cedula_usuarios'";
				$id_emer_cabec="cedula";
				$resultSet=$db->getCondicionesDesc($columnas_emer_cabec, $tablas_emer_cabec, $where_emer_cabec, $id_emer_cabec);
					
				
				$i=count($resultSet);
				
				$html="";
				if($i>0)
				{
					if (!empty($resultSet)) {
							
						$_numsol_emergente=$resultSet[0]->numsol;
						$_cuota_emergente=$resultSet[0]->cuota;
						$_interes_emergente=$resultSet[0]->interes;
						$_tipo_emergente=$resultSet[0]->tipo;
						$_plazo_emergente=$resultSet[0]->plazo;
						$_fcred_emergente=$resultSet[0]->fcred;
						$_ffin_emergente=$resultSet[0]->ffin;
						$_cuenta_emergente=$resultSet[0]->cuenta;
						$_banco_emergente=$resultSet[0]->banco;
						$_valor_emergente=number_format($resultSet[0]->valor, 2, '.', ',');
					}
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-yellow'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>$_valor_emergente</h3>";
					$html .= "<p>Tienes activo un crédito emergente<br> desde $_fcred_emergente hasta $_ffin_emergente.</p>";
					$html .= "</div>";
				
				
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoEmergente.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				}else{
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-yellow'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>0.00</h3>";
					$html .= "<p>Actualmente no dispone un crédito<br> emergente.</p>";
					$html .= "</div>";
						
						
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoEmergente.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
						
						
				}
				
				
				$resultadosJson = json_encode($html);
				
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
			
			}
			
			
			if($cargar=='cargar_credito_2x1')
			{
				$i=0;
				$columnas_2_x_1_cabec ="*";
				$tablas_2_x_1_cabec="c2x1_solicitud";
				$where_2_x_1_cabec="cedula='$cedula_usuarios'";
				$id_2_x_1_cabec="cedula";
				$resultSet=$db->getCondicionesDesc($columnas_2_x_1_cabec, $tablas_2_x_1_cabec, $where_2_x_1_cabec, $id_2_x_1_cabec);
					
				
				$i=count($resultSet);
				
				$html="";
				if($i>0)
				{
					if (!empty($resultSet)) {
				
						$_numsol_2x1=$resultSet[0]->numsol;
						$_cuota_2x1=$resultSet[0]->cuota;
						$_interes_2x1=$resultSet[0]->interes;
						$_tipo_2x1=$resultSet[0]->tipo;
						$_plazo_2x1=$resultSet[0]->plazo;
						$_fcred_2x1=$resultSet[0]->fcred;
						$_ffin_2x1=$resultSet[0]->ffin;
						$_cuenta_2x1=$resultSet[0]->cuenta;
						$_banco_2x1=$resultSet[0]->banco;
						$_valor_2x1=number_format($resultSet[0]->valor, 2, '.', ',');
					}
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-aqua'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>$_valor_2x1</h3>";
					$html .= "<p>Tienes activo un crédito 2 X 1<br> desde $_fcred_2x1 hasta $_ffin_2x1.</p>";
					$html .= "</div>";
				
				
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='Credito2x1.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				}else{
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-aqua'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>0.00</h3>";
					$html .= "<p>Actualmente no dispone un crédito<br> 2 X 1.</p>";
					$html .= "</div>";
						
						
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='Credito2x1.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
						
						
				}
				
				
				$resultadosJson = json_encode($html);
				
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
					
			}
			
			
			if($cargar=='cargar_credito_hipotecario')
			{
				$i=0;
				$columnas_hipotecario_cabec ="*";
				$tablas_hipotecario_cabec="hipotecario_solicitud";
				$where_hipotecario_cabec="cedula='$cedula_usuarios'";
				$id_hipotecario_cabec="cedula";
				$resultSet=$db->getCondicionesDesc($columnas_hipotecario_cabec, $tablas_hipotecario_cabec, $where_hipotecario_cabec, $id_hipotecario_cabec);
				
				
				
				$i=count($resultSet);
				
				$html="";
				if($i>0)
				{
					if (!empty($resultSet)) {
				
						$_numsol_hipotecario=$resultSet[0]->numsol;
						$_cuota_hipotecario=$resultSet[0]->cuota;
						$_interes_hipotecario=$resultSet[0]->interes;
						$_tipo_hipotecario=$resultSet[0]->tipo;
						$_plazo_hipotecario=$resultSet[0]->plazo;
						$_fcred_hipotecario=$resultSet[0]->fcred;
						$_ffin_hipotecario=$resultSet[0]->ffin;
						$_cuenta_hipotecario=$resultSet[0]->cuenta;
						$_banco_hipotecario=$resultSet[0]->banco;
						$_valor_hipotecario=number_format($resultSet[0]->valor, 2, '.', ',');
					}
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-green'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>$_valor_hipotecario</h3>";
					$html .= "<p>Tienes activo un crédito hipotecario<br> desde $_fcred_hipotecario hasta $_ffin_hipotecario.</p>";
					$html .= "</div>";
				
				
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoHipotecario.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				}else{
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-green'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>0.00</h3>";
					$html .= "<p>Actualmente no dispone un crédito<br> hipotecario.</p>";
					$html .= "</div>";
						
						
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoHipotecario.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
						
						
				}
				
					
					
				$resultadosJson = json_encode($html);
				
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
			}
			
			
			if($cargar=='cargar_acuerdo_pago')
			{
				$i=0;
				$columnas_app_cabec ="*";
				$tablas_app_cabec="app_solicitud";
				$where_app_cabec="cedula='$cedula_usuarios'";
				$id_app_cabec="cedula";
				$resultSet=$db->getCondicionesDesc($columnas_app_cabec, $tablas_app_cabec, $where_app_cabec, $id_app_cabec);
				
				
				
				$i=count($resultSet);
				
				$html="";
				if($i>0)
				{
					if (!empty($resultSet)) {
				
						$_numsol_app=$resultSet[0]->numsol;
						$_cuota_app=$resultSet[0]->cuota;
						$_interes_app=$resultSet[0]->interes;
						$_tipo_app=$resultSet[0]->tipo;
						$_plazo_app=$resultSet[0]->plazo;
						$_fcred_app=$resultSet[0]->fcred;
						$_ffin_app=$resultSet[0]->ffin;
						$_cuenta_app=$resultSet[0]->cuenta;
						$_banco_app=$resultSet[0]->banco;
						$_valor_app=number_format($resultSet[0]->valor, 2, '.', ',');
				
					}
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-primary'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>$_valor_app</h3>";
					$html .= "<p>Tienes activo un acuerdo de pago<br> desde $_fcred_app hasta $_ffin_app.</p>";
					$html .= "</div>";
				
				
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='AcuerdoPago.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				}else{
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-primary'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>0.00</h3>";
					$html .= "<p>Actualmente no dispone un acuerdo<br> de pago.</p>";
					$html .= "</div>";
						
						
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='AcuerdoPago.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
						
						
				}
				
				
				
				$resultadosJson = json_encode($html);
				
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
					
			}
			
			
			if($cargar=='cargar_credito_refinanciamiento')
			{
				$i=0;
				$columnas_refi_cabec ="*";
				$tablas_refi_cabec="refinanciamiento_solicitud";
				$where_refi_cabec="cedula='$cedula_usuarios'";
				$id_refi_cabec="cedula";
				$resultSet=$db->getCondicionesDesc($columnas_refi_cabec, $tablas_refi_cabec, $where_refi_cabec, $id_refi_cabec);
				
				
				$i=count($resultSet);
				
				$html="";
				if($i>0)
				{
					if (!empty($resultSet)) {
				
						$_numsol_refinanciamiento=$resultSet[0]->numsol;
						$_cuota_refinanciamiento=$resultSet[0]->cuota;
						$_interes_refinanciamiento=$resultSet[0]->interes;
						$_tipo_refinanciamiento=$resultSet[0]->tipo;
						$_plazo_refinanciamiento=$resultSet[0]->plazo;
						$_fcred_refinanciamiento=$resultSet[0]->fcred;
						$_ffin_refinanciamiento=$resultSet[0]->ffin;
						$_cuenta_refinanciamiento=$resultSet[0]->cuenta;
						$_banco_refinanciamiento=$resultSet[0]->banco;
						$_valor_refinanciamiento=number_format($resultSet[0]->valor, 2, '.', ',');
					}
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-info'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>$_valor_refinanciamiento</h3>";
					$html .= "<p>Tienes activo un crédito hipotecario<br> desde $_fcred_refinanciamiento hasta $_ffin_refinanciamiento.</p>";
					$html .= "</div>";
				
				
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoRefinanciamiento.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				}else{
				
					$html .= "<div class='col-lg-4 col-xs-12'>";
					$html .= "<div class='small-box bg-info'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>0.00</h3>";
					$html .= "<p>Actualmente no dispone un crédito<br> de refinanciamiento.</p>";
					$html .= "</div>";
						
						
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-calendar'></i>";
					$html .= "</div>";
					$html .= "<a href='CreditoRefinanciamiento.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
						
						
				}
				
				
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
			}
			
			
			
		}
		
		
	}
	
	
}











	
?>