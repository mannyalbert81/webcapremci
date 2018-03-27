<?php

require_once '../core/DB_Functions.php';
$db = new DB_Functions();


if(isset($_GET['action'])){
	
	if(isset($_GET['cargar'])){
	

		
		$cargar=$_GET["cargar"];
		
			if($cargar=='cargar_usuarios')
			{
				
				$columnas = "usuarios.cedula_usuarios";
				$tablas   = "public.usuarios";
				$where    = " 1=1";
				$id       = "usuarios.id_usuarios";
				$resultSet = $db->getCondiciones($columnas ,$tablas ,$where, $id);
				
				$i=0;
				$i=count($resultSet);
				
				
				$html="";
				if($i>0)
				{
				
					$html .= "<div class='col-lg-3 col-xs-12'>";
					$html .= "<div class='small-box bg-green'>";
					$html .= "<div class='inner'>";
					$html .= "<h3>$i</h3>";
					$html .= "<p>Usuarios Registrados.</p>";
					$html .= "</div>";
				
				
					$html .= "<div class='icon'>";
					$html .= "<i class='ion ion-person-add'></i>";
					$html .= "</div>";
					$html .= "<a href='Usuarios.html' class='small-box-footer'>Operaciones con usuarios <i class='fa fa-arrow-circle-right'></i></a>";
					$html .= "</div>";
					$html .= "</div>";
				
				
				}else{
					 
					$html .= "<b>Actualmente no hay usuarios registrados...</b>";
				}
				
				
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
				
			}
			
			
			
			
			if($cargar=='cargar_sesiones')
			{
			
			
		   
		    $columnas = "sesiones.id_sesiones";
		    $tablas   = "public.sesiones, public.usuarios";
		    $where    = "sesiones.id_usuarios = usuarios.id_usuarios";
		    $id       = "usuarios.nombre_usuarios";
		    $resultSet = $db->getCondiciones($columnas ,$tablas ,$where, $id);
		    
		    $i=0;
			$i=count($resultSet);
			
			$html="";
			if($i>0)
			{
		
				$html .= "<div class='col-lg-3 col-xs-12'>";
				$html .= "<div class='small-box bg-aqua'>";
				$html .= "<div class='inner'>";
				$html .= "<h3>$i</h3>";
				$html .= "<p>Sesiones Registradas.</p>";
				$html .= "</div>";
		        $html .= "<div class='icon'>";
				$html .= "<i class='ion ion-stats-bars'></i>";
				$html .= "</div>";
				
				$html .= "<a href='Sesiones.html' class='small-box-footer'>Leer Mas<i class='fa fa-arrow-circle-right'></i></a>";
				
				$html .= "</div>";
				$html .= "</div>";
		
		
			}else{
		
				$html = "<b>Actualmente no hay sesiones registrados...</b>";
			}
			
			
				$resultadosJson = json_encode($html);
				echo $_GET['jsoncallback'] . '(' . $resultadosJson . ');';
			
			}
			
}		
			
			
}











	
?>