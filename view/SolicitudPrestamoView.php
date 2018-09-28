<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Solicitud Prestamo - Capremci</title>

	 
 
		<link rel="stylesheet" href="view/css/estilos.css">
		<link rel="stylesheet" href="view/vendors/table-sorter/themes/blue/style.css">
	
	
	
		    <!-- Bootstrap -->
    		<link href="view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    		<!-- Font Awesome -->
		    <link href="view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		    <!-- NProgress -->
		    <link href="view/vendors/nprogress/nprogress.css" rel="stylesheet">
		    
		   
		    <!-- Custom Theme Style -->
		    <link href="view/build/css/custom.min.css" rel="stylesheet">
				
			
			<!-- Datatables -->
		    <link href="view/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
		    
		   		

			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script type="text/javascript" src="view/vendors/table-sorter/jquery.tablesorter.js"></script> 
       		 <script src="view/js/jquery.blockUI.js"></script>
            <script src="view/js/jquery.inputmask.bundle.js"></script>
            
            
           
       		<script src="view/input-mask/jquery.inputmask.js"></script>
			<script src="view/input-mask/jquery.inputmask.date.extensions.js"></script>
			<script src="view/input-mask/jquery.inputmask.extensions.js"></script>
        
    
    <script type="text/javascript">
	    function sumar_ingresos (valor) {
	        var total = 0;	
	        valor = parseInt(valor); // Convertir el valor a un entero (número).
	    	
	        //total = document.getElementById('total_ingresos').innerHTML;
	    	
	        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
	        total = (total == null || total == undefined || total == "") ? 0 : total;
	    	
	        /* Esta es la suma. */
	        total = (parseInt(total) + parseInt(valor));
	    	
	        // Colocar el resultado de la suma en el control "span".
	        document.getElementById('total_ingresos').innerHTML = total;
	    }
    </script>
    
    
     <script type="text/javascript">
	    function sumar_egresos (valor) {

	        var total = 0;	
	        var id_cantones_vivienda = $("#id_cantones_vivienda");
	        valor = parseInt(valor); 
	        
	        total = (parseInt(total) + parseInt(valor));
	    	
	        // Colocar el resultado de la suma en el control "span".
	        document.getElementById('total_egresos').innerHTML = total;
	    }
    </script>
    
    
	
	<script>
		$(document).ready(function(){

			$("#id_provincias_vivienda").change(function(){
			
	            // obtenemos el combo de resultado combo 2
	           var $id_cantones_vivienda = $("#id_cantones_vivienda");
	       	

	            // lo vaciamos
	           var id_provincias_vivienda = $(this).val();

	          
	          
	            if(id_provincias_vivienda != 0)
	            {
	            	 $id_cantones_vivienda.empty();
	            	
	            	 var datos = {
	                   	   
	            			 id_provincias_vivienda:$(this).val()
	                  };
	             
	            	
	         	   $.post("<?php echo $helper->url("Afiliacion","devuelveCanton"); ?>", datos, function(resultado) {

	          		  if(resultado.length==0)
	          		   {
	          				$id_cantones_vivienda.append("<option value='0' >--Seleccione--</option>");	
	             	   }else{
	             		    $id_cantones_vivienda.append("<option value='0' >--Seleccione--</option>");
	          		 		$.each(resultado, function(index, value) {
	          		 			$id_cantones_vivienda.append("<option value= " +value.id_cantones +" >" + value.nombre_cantones  + "</option>");	
	                     		 });
	             	   }	
	            	      
	         		  }, 'json');


	            }else{

	            	var id_cantones_vivienda=$("#id_cantones_vivienda");
	            	id_cantones_vivienda.find('option').remove().end().append("<option value='0' >--Seleccione--</option>").val('0');
	            	var id_parroquias_vivienda=$("#id_parroquias_vivienda");
	            	id_parroquias_vivienda.find('option').remove().end().append("<option value='0' >--Seleccione--</option>").val('0');
	            	
	            	
	            	
	            }
	            

			});
		});
	
       

	</script>
		 
		 
		 
		 
		 
		 
		 <script>
		$(document).ready(function(){

			$("#id_cantones_vivienda").change(function(){

				
	            // obtenemos el combo de resultado combo 2
	           var $id_parroquias_vivienda = $("#id_parroquias_vivienda");
	       	

	            // lo vaciamos
	           var id_cantones_vivienda = $(this).val();

	          
	          
	            if(id_cantones_vivienda != 0)
	            {
	            	 $id_parroquias_vivienda.empty();
	            	
	            	 var datos = {
	                   	   
	            			 id_cantones_vivienda:$(this).val()
	                  };
	             
	            	
	         	   $.post("<?php echo $helper->url("Afiliacion","devuelveParroquias"); ?>", datos, function(resultado) {

	          		  if(resultado.length==0)
	          		   {
	          				$id_parroquias_vivienda.append("<option value='0' >--Seleccione--</option>");	
	             	   }else{
	             		    $id_parroquias_vivienda.append("<option value='0' >--Seleccione--</option>");
	          		 		$.each(resultado, function(index, value) {
	          		 			$id_parroquias_vivienda.append("<option value= " +value.id_parroquias +" >" + value.nombre_parroquias  + "</option>");	
	                     		 });
	             	   }	
	            	      
	         		  }, 'json');


	            }else{

	            	var id_parroquias_vivienda=$("#id_parroquias_vivienda");
	            	id_parroquias_vivienda.find('option').remove().end().append("<option value='0' >--Seleccione--</option>").val('0');
	            	
	            	
	            	
	            }
	            

			});
		});
	
       

	</script>
		    
			
        
        
        
        
        
        
        
        
        
        
        <script>
		$(document).ready(function(){

			$("#id_provincias_asignacion").change(function(){

	            // obtenemos el combo de resultado combo 2
	           var $id_cantones_asignacion = $("#id_cantones_asignacion");
	       	

	            // lo vaciamos
	           var id_provincias_asignacion = $(this).val();

	          
	          
	            if(id_provincias_asignacion != 0)
	            {
	            	 $id_cantones_asignacion.empty();
	            	
	            	 var datos = {
	                   	   
	            			 id_provincias_asignacion:$(this).val()
	                  };
	             
	            	
	         	   $.post("<?php echo $helper->url("Afiliacion","devuelveCanton"); ?>", datos, function(resultado) {

	          		  if(resultado.length==0)
	          		   {
	          				$id_cantones_asignacion.append("<option value='0' >--Seleccione--</option>");	
	             	   }else{
	             		    $id_cantones_asignacion.append("<option value='0' >--Seleccione--</option>");
	          		 		$.each(resultado, function(index, value) {
	          		 			$id_cantones_asignacion.append("<option value= " +value.id_cantones +" >" + value.nombre_cantones  + "</option>");	
	                     		 });
	             	   }	
	            	      
	         		  }, 'json');


	            }else{

	            	var id_cantones_asignacion=$("#id_cantones_asignacion");
	            	id_cantones_asignacion.find('option').remove().end().append("<option value='0' >--Seleccione--</option>").val('0');
	            	var id_parroquias_asignacion=$("#id_parroquias_asignacion");
	            	id_parroquias_asignacion.find('option').remove().end().append("<option value='0' >--Seleccione--</option>").val('0');
	            	
	            	
	            	
	            }
	            

			});
		});
	
       

	</script>
		 
		 
		 
		 
		 
		 
		 <script>
		$(document).ready(function(){

			$("#id_cantones_asignacion").change(function(){

	            // obtenemos el combo de resultado combo 2
	           var $id_parroquias_asignacion = $("#id_parroquias_asignacion");
	       	

	            // lo vaciamos
	           var id_cantones_asignacion = $(this).val();

	          
	          
	            if(id_cantones_asignacion != 0)
	            {
	            	 $id_parroquias_asignacion.empty();
	            	
	            	 var datos = {
	                   	   
	            			 id_cantones_asignacion:$(this).val()
	                  };
	             
	            	
	         	   $.post("<?php echo $helper->url("Afiliacion","devuelveParroquias"); ?>", datos, function(resultado) {

	          		  if(resultado.length==0)
	          		   {
	          				$id_parroquias_asignacion.append("<option value='0' >--Seleccione--</option>");	
	             	   }else{
	             		    $id_parroquias_asignacion.append("<option value='0' >--Seleccione--</option>");
	          		 		$.each(resultado, function(index, value) {
	          		 			$id_parroquias_asignacion.append("<option value= " +value.id_parroquias +" >" + value.nombre_parroquias  + "</option>");	
	                     		 });
	             	   }	
	            	      
	         		  }, 'json');


	            }else{

	            	var id_parroquias_asignacion=$("#id_parroquias_asignacion");
	            	id_parroquias_asignacion.find('option').remove().end().append("<option value='0' >--Seleccione--</option>").val('0');
	            	
	            	
	            	
	            }
	            

			});
		});
	
       

	</script>
		    
        
        
        
        
        <script>
		  $(function () {
		   
		    
		    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' })
		    //Money Euro
		    $('[data-mask]').inputmask()
		
		    
		  })
		</script>
		        
		        
        
       
      
       <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#generar").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var cedula = $("#cedula").val();
		    	var nombre = $("#nombre").val();
		    	var direccion = $("#direccion").val();
		    	var labor = $("#labor").val();
		    	var correo = $("#correo").val();
		    	var telefono = $("#telefono").val();
		    	var celular  = $("#celular").val();
		    	var id_entidades  = $("#id_entidades").val();
		    	var fecha_ingreso  = $("#fecha_ingreso").val();

		    	var sueldo  = $("#sueldo").val();
		    	var hijos  = $("#hijos").val();
		    	var edad  = $("#edad").val();
		    	var id_sexo  = $("#id_sexo").val();
		    	var id_estado_civil  = $("#id_estado_civil").val();
		    	var id_tipo_sangre  = $("#id_tipo_sangre").val();


		    	
		    	var id_provincias_vivienda  = $("#id_provincias_vivienda").val();
		    	var id_cantones_vivienda  = $("#id_cantones_vivienda").val();
		    	var id_parroquias_vivienda  = $("#id_parroquias_vivienda").val();

		    	var id_provincias_asignacion  = $("#id_provincias_asignacion").val();
		    	var id_cantones_asignacion  = $("#id_cantones_asignacion").val();
		    	var id_parroquias_asignacion  = $("#id_parroquias_asignacion").val();

		    	var observacion  = $("#observacion").val();
		    	
		    	if (cedula == "")
		    	{
			    	
		    		$("#mensaje_cedula").text("Introduzca Cedula");
		    		$("#mensaje_cedula").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_cedula_usuarios").fadeOut("slow"); //Muestra mensaje de error
		            
				}    
				
		    	if (nombre == "")
		    	{
			    	
		    		$("#mensaje_nombre").text("Introduzca un Nombre");
		    		$("#mensaje_nombre").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_nombre").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
		    	if (direccion == "")
		    	{
			    	
		    		$("#mensaje_direccion").text("Introduzca Dirección");
		    		$("#mensaje_direccion").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_direccion").fadeOut("slow"); //Muestra mensaje de error
		            
				}   
						    	
			
		    	if (labor == "")
		    	{
		    		
		    		$("#mensaje_labor").text("Introduzca Cargo");
		    		$("#mensaje_labor").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_labor").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	

		    	
		    	
		    	
		    	
				
		    	if (correo == "")
		    	{
			    	
		    		$("#mensaje_correo").text("Introduzca un correo");
		    		$("#mensaje_correo").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else if (regex.test($('#correo').val().trim()))
		    	{
		    		$("#mensaje_correo").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	else 
		    	{
		    		$("#mensaje_correo").text("Introduzca un correo Valido");
		    		$("#mensaje_correo").fadeIn("slow"); //Muestra mensaje de error
		            return false;	
			    }


		    

		    	if (celular == "" )
		    	{
			    	
		    		$("#mensaje_celular").text("Ingrese #");
		    		$("#mensaje_celular").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_celular").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	
		    	if (id_entidades == 0 )
		    	{
			    	
		    		$("#mensaje_id_entidades").text("Seleccione");
		    		$("#mensaje_id_entidades").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_entidades").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (fecha_ingreso == "" )
		    	{
			    	
		    		$("#mensaje_fecha_ingreso").text("Seleccione");
		    		$("#mensaje_fecha_ingreso").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_fecha_ingreso").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	

		    	if (sueldo == 0.00 )
		    	{
			    	
		    		$("#mensaje_sueldo").text("Ingrese Sueldo");
		    		$("#mensaje_sueldo").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_sueldo").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (hijos == "" )
		    	{
			    	
		    		$("#mensaje_hijos").text("Ingrese # Hijos");
		    		$("#mensaje_hijos").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_hijos").fadeOut("slow"); //Muestra mensaje de error
		            
				}



		    	if (edad == "" || edad == 0 )
		    	{
			    	
		    		$("#mensaje_edad").text("Ingrese Edad");
		    		$("#mensaje_edad").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_edad").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (id_sexo == 0 )
		    	{
			    	
		    		$("#mensaje_id_sexo").text("Seleccione");
		    		$("#mensaje_id_sexo").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_sexo").fadeOut("slow"); //Muestra mensaje de error
		            
				}

		    	if (id_estado_civil == 0 )
		    	{
			    	
		    		$("#mensaje_id_estado_civil").text("Seleccione");
		    		$("#mensaje_id_estado_civil").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_estado_civil").fadeOut("slow"); //Muestra mensaje de error
		            
				}

		    	if (id_tipo_sangre == 0 )
		    	{
			    	
		    		$("#mensaje_id_tipo_sangre").text("Seleccione");
		    		$("#mensaje_id_tipo_sangre").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_tipo_sangre").fadeOut("slow"); //Muestra mensaje de error
		            
				}



		    	if (id_provincias_vivienda == 0 )
		    	{
			    	
		    		$("#mensaje_id_provincias_vivienda").text("Seleccione");
		    		$("#mensaje_id_provincias_vivienda").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_provincias_vivienda").fadeOut("slow"); //Muestra mensaje de error
		            
				}



		    	if (id_cantones_vivienda == 0 )
		    	{
			    	
		    		$("#mensaje_id_cantones_vivienda").text("Seleccione");
		    		$("#mensaje_id_cantones_vivienda").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_cantones_vivienda").fadeOut("slow"); //Muestra mensaje de error
		            
				}
    					    
		    	if (id_parroquias_vivienda == 0 )
		    	{
			    	
		    		$("#mensaje_id_parroquias_vivienda").text("Seleccione");
		    		$("#mensaje_id_parroquias_vivienda").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_parroquias_vivienda").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (id_provincias_asignacion == 0 )
		    	{
			    	
		    		$("#mensaje_id_provincias_asignacion").text("Seleccione");
		    		$("#mensaje_id_provincias_asignacion").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_provincias_asignacion").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (id_cantones_asignacion == 0 )
		    	{
			    	
		    		$("#mensaje_id_cantones_asignacion").text("Seleccione");
		    		$("#mensaje_id_cantones_asignacion").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_cantones_asignacion").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (id_parroquias_asignacion == 0 )
		    	{
			    	
		    		$("#mensaje_id_parroquias_asignacion").text("Seleccione");
		    		$("#mensaje_id_parroquias_asignacion").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_parroquias_asignacion").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (observacion == "" )
		    	{
			    	
		    		$("#mensaje_observacion").text("Ingrese observaciones");
		    		$("#mensaje_observacion").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_observacion").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
			}); 


		        $( "#cedula" ).focus(function() {
				  $("#mensaje_cedula").fadeOut("slow");
			    });
				
				$( "#nombre" ).focus(function() {
					$("#mensaje_nombre").fadeOut("slow");
    			});
				$( "#direccion" ).focus(function() {
					$("#mensaje_direccion").fadeOut("slow");
    			});
    			
				$( "#labor" ).focus(function() {
					$("#mensaje_labor").fadeOut("slow");
    			});
				$( "#correo" ).focus(function() {
					$("#mensaje_correo").fadeOut("slow");
    			});
				$( "#celular" ).focus(function() {
					$("#mensaje_celular").fadeOut("slow");
    			});
				
				$( "#id_entidades" ).focus(function() {
					$("#mensaje_id_entidades").fadeOut("slow");
    			});
				
				$( "#fecha_ingreso" ).focus(function() {
					$("#mensaje_fecha_ingreso").fadeOut("slow");
    			});
			
				$( "#sueldo" ).focus(function() {
					$("#mensaje_sueldo").fadeOut("slow");
    			});

				$( "#hijos" ).focus(function() {
					$("#mensaje_hijos").fadeOut("slow");
    			});
				
				$( "#edad" ).focus(function() {
					$("#mensaje_edad").fadeOut("slow");
    			});

				$( "#id_sexo" ).focus(function() {
					$("#mensaje_id_sexo").fadeOut("slow");
    			});


				$( "#id_estado_civil" ).focus(function() {
					$("#mensaje_id_estado_civil").fadeOut("slow");
    			});

				$( "#id_tipo_sangre" ).focus(function() {
					$("#mensaje_id_tipo_sangre").fadeOut("slow");
    			});
				$( "#id_provincias_vivienda" ).focus(function() {
					$("#mensaje_id_provincias_vivienda").fadeOut("slow");
    			});
				$( "#id_cantones_vivienda" ).focus(function() {
					$("#mensaje_id_cantones_vivienda").fadeOut("slow");
    			});
				$( "#id_parroquias_vivienda" ).focus(function() {
					$("#mensaje_id_parroquias_vivienda").fadeOut("slow");
    			});

				$( "#id_provincias_asignacion" ).focus(function() {
					$("#mensaje_id_provincias_asignacion").fadeOut("slow");
    			});
				$( "#id_cantones_asignacion" ).focus(function() {
					$("#mensaje_id_cantones_asignacion").fadeOut("slow");
    			});
				$( "#id_parroquias_asignacion" ).focus(function() {
					$("#mensaje_id_parroquias_asignacion").fadeOut("slow");
    			});
				$( "#observacion" ).focus(function() {
					$("#mensaje_observacion").fadeOut("slow");
    			});  
		}); 

	</script>
        
       
       
       <script>
      $(document).ready(function(){
      $(".cantidades1").inputmask();
      });
	  </script>
	
       
			        
    </head>
    
    
    <body class="nav-md">
    
      <?php
        
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        ?>
    
    
       
    
    
    
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col  menu_fixed">
          <div class="left_col scroll-view">
            <?php include("view/modulos/logo.php"); ?>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php include("view/modulos/menu_profile.php"); ?>
            <!-- /menu profile quick info -->

            <br />
			<?php include("view/modulos/menu.php"); ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
		<?php include("view/modulos/head.php"); ?>	
        <!-- /top navigation -->

        <!-- page content -->
		<div class="right_col" role="main">        
           
    	<div class="container">
        <section class="content-header">
         <small><?php echo $fecha; ?></small>
         <ol class=" pull-right breadcrumb">
         <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Recomendar Afiliación</li>
         </ol>
         </section>
       
  
		
		<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Solicitud<small>Préstamo</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    
		
      
      
      
         
           <form  action="<?php echo $helper->url("SolicitudPrestamo","InsertaSolicitudPrestamo"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
           
           
      
          <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-user'></i> Datos del Préstamo</h4>
	         </div>
	         <div class="panel-body">
			 
			  <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="sueldo" class="control-label">Monto en Dólares:</label>
                                                      <input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" value='0' 
                                                      data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                      <div id="mensaje_sueldo" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Plazo en meses:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# meses..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-8 col-xs-12 col-md-8">
                    		    <div class="form-group">
                                                      <label for="direccion" class="control-label">Destino del dinero:</label>
                                                    
                                                      <div class="row">
                                                      <div class="col-lg-2 col-xs-12 col-md-2">
                                                      <input type="radio" id="estudios" name="destino_dinero" value="Estudios" class="flat-red"> Estudios
			                  						  </div>
			                  						  <div class="col-lg-2 col-xs-12 col-md-2">
			                  						  <input type="radio" id="vivienda" name="destino_dinero" value="Vivienda" class="flat-red"> Vivienda
			                  						  </div>
			                  						  <div class="col-lg-2 col-xs-12 col-md-2">
			                  						  <input type="radio" id="vehiculo" name="destino_dinero" value="Vehículo" class="flat-red"> Vehículo
			                  						  </div>
			                  						  <div class="col-lg-2 col-xs-12 col-md-2">
			                  						  <input type="radio" id="otro" name="destino_dinero" value="Otro" class="flat-red"> Otro
			                                          </div>
			                  						  <div class="col-lg-2 col-xs-12 col-md-2">
			                                          <input type="radio" id="consumo" name="destino_dinero" value="Consumo" class="flat-red"> Consumo
			                                          </div>
			                                          </div>
			                                        
			                                          <div id="mensaje_destino_dinero" class="errores"></div>
                                </div>
                                </div>
                    			
                    		
         	  </div>
			 
  			</div>
  			</div>
  			
           
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-user'></i> Datos Cuenta Bancaria</h4>
	         </div>
	         <div class="panel-body">
			 
			  <div class="row">
                    		    <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Nombre Banco:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Banco Pichincha">Banco Pichincha</option>
                        							  <option value="Banco Rumiñahui">Banco Rumiñahui</option>
                        							  <option value="Otro">Otro</option>
                        							  <option value="Retira Chueque">Retira Chueque</option>
                        							  </select> 
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Tipo Cuenta:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Ahorros">Ahorros</option>
                        							  <option value="Corriente">Corriente</option>
                        							  </select> 
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Número Cuenta:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# cuenta..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                     		
         	  </div>
			 
  			</div>
  			</div>
           
        
              <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-user'></i> Datos Personales</h4>
	         </div>
	         <div class="panel-body">
			 
			  <div class="row">
			  
			   					<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Número Cédula:</label>
                                                     <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="cédula..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
			  
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Apellidos Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="apellidos..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Nombres Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                                </div>
                    		    
                                <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Correo Electrónico:</label>
                                                      <input type="email" class="form-control" id="nombre" name="nombre" value="" placeholder="correo electrónico..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
             					</div>	
              </div>
              
              <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_sexo" class="control-label">Género:</label>
                                                       <select name="id_sexo" id="id_sexo"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultSexo as $res) {?>
                        										<option value="<?php echo $res->id_sexo; ?>" ><?php echo $res->nombre_sexo; ?> </option>
                        							        <?php } ?>
                        							   </select> 
                                                      <div id="mensaje_id_sexo" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="fecha_ingreso" class="control-label">Fecha Nacimiento:</label>
                                                      <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" min="1800-01-01" max="<?php echo date('Y-m-d');?>" value="" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask>
                                                      <div id="mensaje_fecha_ingreso" class="errores"></div>
                                </div>
                                </div>
                                
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_estado_civil" class="control-label">Estado Civil:</label>
                                                      <select name="id_estado_civil" id="id_estado_civil"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEstado_civil as $res) {?>
                        										<option value="<?php echo $res->id_estado_civil; ?>" ><?php echo $res->nombre_estado_civil; ?> </option>
                        							        <?php } ?>
                        							  </select> 
                                                      <div id="mensaje_id_estado_civil" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="direccion" class="control-label">Separación de Bienes:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Si">Si</option>
                        							  <option value="No">No</option>
                        							  </select> 
			                                          <div id="mensaje_destino_dinero" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="direccion" class="control-label">Cargas Familiares:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Si">Si</option>
                        							  <option value="No">No</option>
                        							  </select> 
			                                          <div id="mensaje_destino_dinero" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="direccion" class="control-label">Número Hijos:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="1">1</option>
                        							  <option value="2">2</option>
                        							  <option value="3">3</option>
                        							  <option value="4">4</option>
                        							  <option value="5">5</option>
                        							  <option value="6">6</option>
                        							  <option value="7">7</option>
                        							  <option value="8">8</option>
                        							  <option value="9">9</option>
                        							  <option value="10">10</option>
                        							  </select> 
			                                          <div id="mensaje_destino_dinero" class="errores"></div>
                                </div>
                                </div>
                                
              </div>
              
              
              
              
              <div class="row">
               					<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Nivel Educativo:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Primario">Primario</option>
                        							  <option value="Secundario">Secundario</option>
                        							  <option value="Técnico">Técnico</option>
                        							  <option value="Universitario">Universitario</option>
                        							  <option value="Postgrado">Postgrado</option>
                        							  </select> 
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
             					</div>	
             					
             					
              </div>
			 
  			</div>
  			</div>
             
              
              
              
                       
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Datos Exactos Domicilio</h4>
	         </div>
	         <div class="panel-body">
			 <div class="row">
                    		     
             					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_provincias_vivienda" class="control-label">Provincia:</label>
                                                          <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultProvincias as $res) {?>
                        										<option value="<?php echo $res->id_provincias; ?>"><?php echo $res->nombre_provincias; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                    		    </div>       		    
                    		   
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_cantones_vivienda" class="control-label">Cantón:</label>
                                                          <select name="id_cantones_vivienda" id="id_cantones_vivienda"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                                                            <?php foreach($resultCantones as $res) {?>
                        										<option value="<?php echo $res->id_cantones; ?>"  ><?php echo $res->nombre_cantones; ?> </option>
                        							        <?php } ?>
                                                          </select> 
                                                          <div id="mensaje_id_cantones_vivienda" class="errores"></div>
                                </div>
                    		    </div>
                    		   
                    			
                    			<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_parroquias_vivienda" class="control-label">Parroquia:</label>
                                                          <select name="id_parroquias_vivienda" id="id_parroquias_vivienda"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        								  
                        								  <?php foreach($resultParroquias as $res) {?>
                        										<option value="<?php echo $res->id_parroquias; ?>" ><?php echo $res->nombre_parroquias; ?> </option>
                        							        <?php } ?>
                        							      
                        								  </select> 
                                                          <div id="mensaje_id_parroquias_vivienda" class="errores"></div>
                                </div>
                    		    </div>
                    			
            </div>
            
            
             <div class="row">
                    		    <div class="col-lg-6 col-xs-12 col-md-6">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Barrio y/o sector:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombre barrio..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-6 col-xs-12 col-md-6">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Ciudadela y/o conjunto / Etapa / Manzana:</label>
                                                     <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombre conjunto..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
              </div>
            
            
             <div class="row">
                    		    <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Calle:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombre calle..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Número Calle:</label>
                                                     <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="# número calle..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Intersección:</label>
                                                     <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="intersección..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
              </div>
              
              
              
              <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Tipo Vivienda:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Propia">Propia</option>
                        							  <option value="Arrendada">Arrendada</option>
                        							  <option value="Anticresis">Anticresis</option>
                        							  <option value="Vive con Familiares">Vive con Familiares</option>
                        							  <option value="Otra">Otra</option>
                        							  </select> 
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Vivienda Hipotecada:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Si">Si</option>
                        							  <option value="No">No</option>
                        							  </select> 
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Tiempo Residencia:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="1">1</option>
                        							  <option value="2">2</option>
                        							  <option value="3">3</option>
                        							  <option value="4">4</option>
                        							  <option value="5">5</option>
                        							  <option value="6">6</option>
                        							  <option value="7">7</option>
                        							  <option value="8">8</option>
                        							  <option value="9">9</option>
                        							  <option value="10">10</option>
                        							  <option value="11">11</option>
                        							  <option value="12">12</option>
                        							  <option value="13">13</option>
                        							  <option value="14">14</option>
                        							  <option value="15">15</option>
                        							  <option value="16">16</option>
                        							  <option value="17">17</option>
                        							  <option value="18">18</option>
                        							  <option value="19">19</option>
                        							  <option value="20">20</option>
                        							  <option value="21">21</option>
                        							  <option value="22">22</option>
                        							  <option value="23">23</option>
                        							  <option value="24">24</option>
                        							  <option value="25">25</option>
                        							  <option value="26">26</option>
                        							  <option value="27">27</option>
                        							  <option value="28">28</option>
                        							  <option value="29">29</option>
                        							  <option value="30">30</option>
                        							  </select> 
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                                
                                
                                <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Nombre Propietario Vivienda:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombre propietario..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Celular Propietario Vivienda:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="# celular propietario..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                                
              </div>
              
              
              <div class="row">
                    		    <div class="col-lg-12 col-xs-12 col-md-12">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Referencia de la dirección del domicilio:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="referencia..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                                </div>
                    		 
              </div>
              
          
             
			</div>
  			</div>
           
           
           
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Números Telefónicos</h4>
	         </div>
	         <div class="panel-body">
			 
			 <div class="row">
                    		   
            					<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Número Casa:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="# casa..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>   
            
            					<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Número Celular:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# celular..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            
            					<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Número Trabajo:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# trabajo..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            
            					<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Extensión:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# extensión..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            					<div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Mode:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="mode..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>       		    
             	
            	
             
            </div>
			
			 
  			</div>
  			</div>
           
           
           
           
            <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Referencia Personal</h4>
	         </div>
	         <div class="panel-body">
			 
			 <div class="row">
                    		   
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Apellidos Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="apellidos..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Nombres Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Relación:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Amigo (a)">Amigo (a)</option>
                        							  <option value="Compadre">Compadre</option>
                        							  <option value="Comadre">Comadre</option>
                        							  <option value="Compañero Laboral (a)">Compañero Laboral (a)</option>
                        							  <option value="Jéfe (a)">Jéfe (a)</option>
                        							  </select>
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Número Telefónico:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# telefónico..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            </div>  
            	
             
            </div>
			
			 
  			</div>
  			</div>
           
           
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Referencia Familiar (Que no viva con usted)</h4>
	         </div>
	         <div class="panel-body">
			 
			 <div class="row">
                    		   
             					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Apellidos Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="apellidos..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Nombres Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>   
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Parentesco:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Primo (a)">Primo (a)</option>
                        							  <option value="Tío (a)">Tío (a)</option>
                        							  <option value="Hermano (a)">Hermano (a)</option>
                        							  <option value="Sobrino (a)">Sobrino (a)</option>
                        							  <option value="Abuelo (a)">Abuelo (a)</option>
                        							  <option value="Hijo (a)">Hijo (a)</option>
                        							  </select>
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Número Telefónico:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# telefónico..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            	
             
            </div>
			
			 
  			</div>
  			</div>
           
           
           
           
           
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Datos Laborales</h4>
	         </div>
	         <div class="panel-body">
			 
			 
			 <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_provincias_asignacion" class="control-label">Institución o Empresa:</label>
                                                          <select name="id_provincias_asignacion" id="id_provincias_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultProvincias as $res) {?>
                        										<option value="<?php echo $res->id_provincias; ?>" ><?php echo $res->nombre_provincias; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_provincias_asignacion" class="errores"></div>
                                </div>
                    		    </div>  
                    		    
             					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_provincias_asignacion" class="control-label">Provincia:</label>
                                                          <select name="id_provincias_asignacion" id="id_provincias_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultProvincias as $res) {?>
                        										<option value="<?php echo $res->id_provincias; ?>" ><?php echo $res->nombre_provincias; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_provincias_asignacion" class="errores"></div>
                                </div>
                    		    </div>       		    
                    		   
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_cantones_asignacion" class="control-label">Cantón:</label>
                                                          <select name="id_cantones_asignacion" id="id_cantones_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        							      
                        							      <?php foreach($resultCantones as $res) {?>
                        										<option value="<?php echo $res->id_cantones; ?>"  ><?php echo $res->nombre_cantones; ?> </option>
                        							        <?php } ?>
                        							     
                        							      </select> 
                                                          <div id="mensaje_id_cantones_asignacion" class="errores"></div>
                                </div>
                    		    </div>
                    		   
                    			
                    			<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_parroquias_asignacion" class="control-label">Parroquia:</label>
                                                          <select name="id_parroquias_asignacion" id="id_parroquias_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        								  
                        								  <?php foreach($resultParroquias as $res) {?>
                        										<option value="<?php echo $res->id_parroquias; ?>" ><?php echo $res->nombre_parroquias; ?> </option>
                        							        <?php } ?>
                        							      
                        								  </select> 
                                                          <div id="mensaje_id_parroquias_asignacion" class="errores"></div>
                                </div>
                    		    </div>
                        		
            </div>
			 
			<div class="row"> 
			 	
              					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Número Telefónico:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# telefónico..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Intersección:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="intersección..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>   
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Calle:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombre calle..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>  
            
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Cargo Actual:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="cargo actual..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            					</div>         			
                    		    
                    		    
            </div>      		    
			 
			 
  			</div>
  			</div>
  			
  			
  			
  			
  			
  			 <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Información Económica</h4>
	         </div>
	         <div class="panel-body">
			 
			 <div class="row">
                    		   
             
            <table class="col-lg-12 col-md-12 col-xs-12 tablesorter table table-striped table-bordered dt-responsive nowrap">
            
            <tr>
            <th><b>INGRESOS MENSUALES</b></th>
            <th><b>VALOR EN DÓLARES</b></th>
            <th><b>GASTOS MENSUALES</b></th>
            <th><b>VALOR EN DÓLARES</b></th>
            </tr>
            
            <tr>
            <td>Sueldo Total</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Cuota del Préstamo Ordinario CAPREMCI</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td>Arriendos</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Cuota del Préstamo Ágil CAPREMCI</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td>Honorarios Profesionales</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Cuotas de Otros Préstamos</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td>Comisiones</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Cuotas de Prestamos con el IESS</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td>Horas Suplementarias</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Arriendo</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td colspan="2" style="text-align: center;"><b>OTROS INGRESOS (detalle)</b></td>
            <td>Alimentación</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Estudios</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Pago Servicios Básicos</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Pago Tarjetas de Crédito</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" value='0' onchange="sumar_ingresos(this.value);" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Afiliación a Cooperativas</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" value='0' onchange="sumar_egresos(this.value);" data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Ahorro</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td>Impuesto a la Renta</td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td colspan="2" style="text-align: center;"><b>OTROS GASTOS (detalle)</b></td>
            </tr>
            
            <tr>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_ingresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            <td><input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres.."></td>
            <td><input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" onchange="sumar_egresos(this.value);" value='0' data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false"></td>
            </tr>
            
            
            <tr>
            <td>Total de Ingresos Mensuales</td>
            <td><span id="total_ingresos"></span></td>
            <td>Total de Gastos Mensuales</td>
            <td><span id="total_egresos"></span></td>
            </tr>
            
            </table>
             
            </div>
			 
  			</div>
  			</div>
           
           
           
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Datos del Cónyuge o Pareja</h4>
	         </div>
	         <div class="panel-body">
			 
			 
			<div class="row">
               
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Apellidos Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="apellidos..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            </div>   
                    		   
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Apellidos Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="apellidos..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            </div>  
            
           						<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Nombres Completos:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="nombres..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            </div>  
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Relación:</label>
                                                      <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                      <option value="0" selected="selected">--Seleccione--</option>
                        							  <option value="Amigo (a)">Amigo (a)</option>
                        							  <option value="Compadre">Compadre</option>
                        							  <option value="Comadre">Comadre</option>
                        							  <option value="Compañero Laboral (a)">Compañero Laboral (a)</option>
                        							  <option value="Jéfe (a)">Jéfe (a)</option>
                        							  </select>
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            </div>  
            
            
            					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_provincias_vivienda" class="control-label">Número Telefónico:</label>
                                                      <input type="number" class="form-control" id="nombre" name="nombre" value="" placeholder="# telefónico..">
                                                      <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
            </div>  
            	
             
            </div>   
			 
			 
  			</div>
  			</div>
  			
  			
  			
  			  
			  			<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
				  		 <button type="submit" id="generar" name="generar" value=""   class="btn btn-success" style="margin-top: 10px;"><i class="glyphicon glyphicon-edit"></i> Registrar Recomendación</button>         
					    </div>
  			
  			
         
      
      
       </form>
           
      
      
      
      
			      </div>
			    </div>

	</div>
	</div>
	</div>
	</div>
	</div>
	    
    
    
  
 
     <!-- Bootstrap -->
    <script src="view/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
    
    
    <!-- NProgress -->
    <script src="view/vendors/nprogress/nprogress.js"></script>
   
   
    <!-- Datatables -->
    <script src="view/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    
    
    <script src="view/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="view/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    
    
    
    <!-- Custom Theme Scripts -->
    <script src="view/build/js/custom.min.js"></script>
	<script src="view/js/jquery.inputmask.bundle.js"></script>
	<!-- codigo de las funciones -->

	
  </body>
</html>   