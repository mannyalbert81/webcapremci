<!DOCTYPE HTML>
<html lang="es">

  <head>
      
        <meta charset="utf-8"/>
        <title>Reporte  - contabilidad 2016</title>
        
   <style type="text/css">
       .pagina {
		   position: relative;
		   padding-bottom: 50.25%;
		   overflow: hidden;
		}
		.pagina iframe
	 	{
	    position: absolute;
	    display: block;
	    top: 0;
	    left: 15%;
	    width: 85.1%;
	    height: 100%;
	    align: center;
		}
   </style>
       
         	
  </head>
  <body >
  
  <?php
  //conexion servidor reporte
  require_once 'config/global.php';
  
  //datos del controlador
  
  //para externa 
  
  /*
  $url = IP_REPORTE;
   if(!empty($conexion_rpt))
   {
   	$pagina = $conexion_rpt['pagina'];
   	$url .=$pagina;
    }
    
   $cadena_param="?";
    
   if(!empty($parametros))
   {
   	foreach ($parametros as $param=>$valor)
   	{
   		if($valor!=''||$valor!=null)
   		{
   			//$cadena_param.=$param."=$valor&"; //aqui se realizo cambio
   			$cadena_param.=$param."=".$valor."&";
   		}
   	}
   
   }
   $cadena_param=trim($cadena_param,'&');
   $url.=$cadena_param;
   $url;
   */
   
   
   
   
   
   //PRUEBAS LOCALES
  //para pruebas de local port: visual define
  //port desde la vista

   $url = "";
   if(!empty($conexion_rpt))
   {
	   $port = $conexion_rpt['port'];
	   $pagina = $conexion_rpt['pagina'];
	   $url = "http://localhost:$port/Php/Contendor/$pagina";
   }
   
   $cadena_param="?";
   
   if(!empty($parametros))
   {
   		foreach ($parametros as $param=>$valor)
   		{
   			
   			if($valor!=''||$valor!=null)
   			{
   				$cadena_param.=$param."=".$valor."&";
   			}
   		}
   
   }
   $cadena_param=trim($cadena_param,'&');
   
   //die($cadena_param);
   $url.=$cadena_param;
   $url;
 
  ?>
    
   <div class="pagina" >
   <iframe src="<?php echo $url; ?>" align="middle" noresize frameborder="0" marginwidth="0" marginheight="0">
   </iframe>
  </div>
  
 
  </body>  

  </html>   
    

