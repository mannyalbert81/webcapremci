<?php

	require_once '../core/DB_Functions.php';
	$db = new DB_Functions();
	$resultado="";
	
	$accion=(isset($_POST['action']))?$_POST['action']:'';
	$_nombres  = (isset($_POST['nombres']))?$_POST['nombres']:'';	
	$_email  = (isset($_POST['email']))?$_POST['email']:'';
	$_asunto  = (isset($_POST['asuntos']))?$_POST['asuntos']:'';
	$_mensaje  = (isset($_POST['mensajes']))?$_POST['mensajes']:'';
	
	
	
	
	
	if($accion=="enviar"){
		
		if($_nombres !="" && $_email !="" && $_asunto !="" && $_mensaje !=""){
			$respuesta="";
			$cabeceras = "MIME-Version: 1.0 \r\n";
			$cabeceras .= "Content-type: text/html; charset=utf-8 \r\n";
			$cabeceras .= "From: info@capremci.com.ec \r\n";
			$destino="maycol@masoft.net";
			$asunto="Preguntas Participes Capremci";
			$fecha=date("d/m/y");
			$hora=date("H:i:s");
			
			$resumen="
			<table rules='all'>
			<tr><td WIDTH='1000' HEIGHT='50'><center><img src='http://18.218.148.189:80/view/images/bcaprem.jpg' WIDTH='300' HEIGHT='150'/></center></td></tr>
			</tabla>
			<p><table rules='all'></p>
			<tr style='background: #FFFFFF'><td WIDTH='1000' align='center'><b> PREGUNTAS CAPREMCI: </b></td></tr>
			<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Nombres:</b> $_nombres</td></tr>
			<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Email:</b> $_email</td></tr>
			<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Asunto:</b> $_asunto</td></tr>
			<tr style='background: #FFFFFF;'><td WIDTH='1000' > <b>Mensaje:</b> $_mensaje</td></tr>
			
			</tabla>
			<p><table rules='all'></p>
			<tr style='background:#1C1C1C'><td WIDTH='1000' HEIGHT='50' align='center'><font color='white'>Capremci - <a href='http://www.capremci.com.ec'><FONT COLOR='#7acb5a'>www.capremci.com.ec</FONT></a> - Copyright © 2018-</font></td></tr>
			</table>
			";
			
			
			if(mail("$destino","Preguntas Participes Capremci","$resumen","$cabeceras"))
			{
				
				
				$respuesta .="<div class='row'>";
				$respuesta .="<div class='col-lg-6 col-md-6 col-xs-12'>";
				$respuesta .="<div class='alert alert-success' role='alert'>Su mensaje se ha enviado correctamente. Te responderemos al correo ingresado $_email.";
				$respuesta .="</div>";
                $respuesta .="</div>";
	            $respuesta .="</div>";
				
				 echo json_encode($respuesta);
				 
				
			
			}else{
				
				
				$respuesta .="<div class='row'>";
				$respuesta .="<div class='col-lg-6 col-md-6 col-xs-12'>";
				$respuesta .="<div class='alert alert-danger' role='alert'>No se pudo enviar el mensaje con la información. Intentelo nuevamente.";
				$respuesta .="</div>";
				$respuesta .="</div>";
				$respuesta .="</div>";
				
				
				
				echo json_encode($respuesta);
			}
			
				
			
		}else{
			
		}
	   
			
	}
	
	



	