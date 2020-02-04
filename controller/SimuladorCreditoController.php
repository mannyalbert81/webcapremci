<?php

class SimuladorCreditoController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}



	public function index(){
	
		session_start();
     	$permisos_roles=new PermisosRolesModel();
		
     	$intereses = new InteresesModel();
	    $resultInte=$intereses->getAll("nombre_intereses");

	    $plazo_meses = new PlazoMesesModel();
	    $resultPlazoMeses =$plazo_meses->getAll("cantidad_plazo_meses");
		
	    $interes_mensual = 0;
	    $plazo_dias = 0;
	    $cant_cuotas = 0;
	    $tasa_mora = 0;
	    $mora_mensual = 0;
	    $valor_cuota = 0;

	
		if (isset(  $_SESSION['nombre_usuarios']) )
		{

			$nombre_controladores = "SimuladorCredito";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $permisos_roles->getPermisosVer("controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
			if (!empty($resultPer))
			{
				$resultAmortizacion=array();
				$resultDatos=array();
				
				if(isset($_POST["valor_prestamo"])){
					

					$interes=0;
					$total= isset($_POST['valor_prestamo'])?(double)$_POST['valor_prestamo']:2;
					$porcentaje_capital=isset($_POST['taza_intereses'])?(double)$_POST['taza_intereses']:2;
					$total_capital=$total-($total*$porcentaje_capital);
					$fecha_corte=$_POST['fecha_corte'];
					$fecha_emision='';
						
						
					array_push($resultDatos,array('total'=> $total,'porcentaje_capital'=>$porcentaje_capital,'total_capital'=>$total_capital));
					
					
					//valores
					$_tasa_interes_amortizacion_cabeza = $_POST['taza_intereses'];
					$tasa= $_tasa_interes_amortizacion_cabeza;
					$_capital_prestado_amortizacion_cabeza = $_POST['valor_prestamo'];
					$_plazo_meses_amortizacion_cabeza = $_POST['cantidad_plazo_meses'];
					
					
					////resultados
					$interes_mensual = $tasa / 12;
					$plazo_dias = $_plazo_meses_amortizacion_cabeza * 30;
					$cant_cuotas = $_plazo_meses_amortizacion_cabeza;
					
					
					$valor_cuota =  ($_capital_prestado_amortizacion_cabeza * $interes_mensual) /  (1- pow((1+$interes_mensual), -$_plazo_meses_amortizacion_cabeza ))  ;
					
					
					$numero_cuotas=$_POST['cantidad_plazo_meses'];
					
					//$resultAmortizacion=$this->tablaAmortizacion($saldo_capital, $numero_cuotas, $fecha_corte, $total );
					$resultAmortizacion=$this->tablaAmortizacion($_capital_prestado_amortizacion_cabeza, $numero_cuotas, $interes_mensual, $valor_cuota, $fecha_corte, $_tasa_interes_amortizacion_cabeza);
					
					
					
				}
				
				
				
				$this->view("SimuladorCredito",array(
						"resultInte"=>$resultInte, "resultPlazoMeses"=>$resultPlazoMeses, 'resultDatos'=>$resultDatos,'resultAmortizacion'=>$resultAmortizacion, 'valor_cuota'=>$valor_cuota
				));
		
				
				
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No tiene Permisos de Acceso a Simulador Crédito."
				
				));
				
				exit();	
			}
				
		}
		else{
       	
       	$this->redirect("Usuarios","sesion_caducada");
       	
       }
	
	}
	
	
	
	
	
	
	public function tablaAmortizacion($_capital_prestado_amortizacion_cabeza, $numero_cuotas, $interes_mensual, $valor_cuota, $fecha_corte, $_tasa_interes_amortizacion_cabeza )
	{
		//array donde guardar tabla amortizacion
		$resultAmortizacion=array();
		 
	
		$capital = $_capital_prestado_amortizacion_cabeza;
		$inter_ant= $interes_mensual;
		$interes=  $capital * $inter_ant;
		$amortizacion = $valor_cuota - $interes;
		$saldo_inicial= $capital - $amortizacion;
	
	
	
		for( $i = 0; $i <= $numero_cuotas; $i++) {
				
			if ($i == 0)
			{
				$interes= 0;
				$amortizacion = 0;
				$saldo_inicial= $capital;
				$fecha=strtotime('+0 day',strtotime($fecha_corte));
				$fecha=date('Y-m-d',$fecha);
				$fecha_corte=$fecha;
				$valor = 0;
				$saldo_inicial_ant = $capital;
			}
			else
			{
	
	
				$saldo_inicial_ant = $saldo_inicial_ant - $amortizacion;
				$interes= $saldo_inicial_ant * $inter_ant;
				$amortizacion = $valor_cuota - $interes;
	
				$saldo_inicial= $saldo_inicial_ant  - $amortizacion;
	
	
				$fecha=strtotime('+30 day',strtotime($fecha_corte));
				$fecha=date('Y-m-d',$fecha);
				$fecha_corte=$fecha;
				$valor = $valor_cuota;
					
					
					
			}
			
				
	
			$resultAmortizacion['tabla'][]=array(
					array('pagos_trimestrales'=> $i,
							'saldo_inicial'=>$saldo_inicial,
							'interes'=>$interes,
							'amortizacion'=>$amortizacion,
							'pagos'=>$valor,
							'fecha_pago'=>$fecha
					));
		}
	
	
	
		return $resultAmortizacion;
	
	
	}
	
	
	public function TazaIntereses()
	{
		if(isset($_POST["tipo_prestamo"]))
		{
			
			$tipo_prestamo=$_POST["tipo_prestamo"];
			$intereses=new InteresesModel();
			$columnas = "nombre_intereses, taza_intereses";
			$tablas="intereses";
			$where="1=1 AND tipo_prestamo='$tipo_prestamo'";
			$id="nombre_intereses";
	
			$resultado=$intereses->getCondiciones($columnas ,$tablas , $where, $id);
	
			echo json_encode($resultado);
	
		}else{
			$resultado="";
			echo json_encode($resultado);
			
		}
	
	}
	
	
}
?>