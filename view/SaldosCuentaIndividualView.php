<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>SaldosCuentaIndividual - Template 2018</title>
 
 
 
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
	             
	            	
	         	   $.post("<?php echo $helper->url("SaldosCuentaIndividual","devuelveCanton"); ?>", datos, function(resultado) {

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
	             
	            	
	         	   $.post("<?php echo $helper->url("SaldosCuentaIndividual","devuelveParroquias"); ?>", datos, function(resultado) {

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
	             
	            	
	         	   $.post("<?php echo $helper->url("SaldosCuentaIndividual","devuelveCanton"); ?>", datos, function(resultado) {

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
	             
	            	
	         	   $.post("<?php echo $helper->url("SaldosCuentaIndividual","devuelveParroquias"); ?>", datos, function(resultado) {

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
   
    
    $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    
  })
</script>
        
        
        
        
        <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   pone_espera();
        		   load_cta_individual(1);
	   			});


        	   function pone_espera(){

        		   $.blockUI({ 
        				message: '<h4><img src="view/images/load.gif" /> Espere por favor, estamos procesando su requerimiento...</h4>',
        				css: { 
        		            border: 'none', 
        		            padding: '15px', 
        		            backgroundColor: '#000', 
        		            '-webkit-border-radius': '10px', 
        		            '-moz-border-radius': '10px', 
        		            opacity: .5, 
        		            color: '#fff',
        		           
        	        		}
        	    });
            	
		        setTimeout($.unblockUI, 3000); 
		        
        	   }
        	   
        	   function load_cta_individual(pagina){


        		   var search=$("#search").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_cta_individual_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_cta_individual_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_cuenta_individual&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_registrados").html(x);
           	               	 $("#tabla_cta_individual").tablesorter(); 
           	                 $("#load_cta_individual_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_registrados").html("Ocurrio un error al cargar la informacion de Cuenta Individaul..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>

			
			
			
			<script type="text/javascript">
     
        	   $(document).ready( function (){
        		   load_cta_desembolsar(1);
	   			});

        	   function load_cta_desembolsar(pagina){


        		   var search=$("#search_desembolsar").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_cta_desembolsar_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_cta_desembolsar_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_cuenta_desembolsar&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_desembolsar_registrados").html(x);
           	               	 $("#tabla_cta_desembolsar").tablesorter(); 
           	                 $("#load_cta_desembolsar_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_desembolsar_registrados").html("Ocurrio un error al cargar la informacion de Cuenta Individaul..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>
       
       
       
       
       
       
			<script type="text/javascript">
     
        	   $(document).ready( function (){
        		   load_credito_ordinario(1);
	   			});

        	   function load_credito_ordinario(pagina){


        		   var search=$("#search_credito_ordinario").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_credito_ordinario_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_credito_ordinario_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_credito_ordinario&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_credito_ordinario").html(x);
           	               	 $("#tabla_credito_ordinario").tablesorter(); 
           	                 $("#load_credito_ordinario_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_credito_ordinario").html("Ocurrio un error al cargar la informacion de Credito Ordinario..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>
       
       
       
       <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   load_credito_emergente(1);
	   			});

        	   function load_credito_emergente(pagina){


        		   var search=$("#search_credito_emergente").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_credito_emergente_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_credito_emergente_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_credito_emergente&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_credito_emergente").html(x);
           	               	 $("#tabla_credito_emergente").tablesorter(); 
           	                 $("#load_credito_emergente_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_credito_emergente").html("Ocurrio un error al cargar la informacion de Credito Emergente..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>
       
       
       
       
       <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   load_credito_2x1(1);
	   			});

        	   function load_credito_2x1(pagina){


        		   var search=$("#search_credito_2x1").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_credito_2x1_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_credito_2x1_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_credito_2x1&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_credito_2x1").html(x);
           	               	 $("#tabla_credito_2x1").tablesorter(); 
           	                 $("#load_credito_2x1_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_credito_2x1").html("Ocurrio un error al cargar la informacion de Credito 2 x 1..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>
       
       
       
       
         <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   load_credito_hipotecario(1);
	   			});

        	   function load_credito_hipotecario(pagina){


        		   var search=$("#search_credito_hipotecario").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_credito_hipotecario_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_credito_hipotecario_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_credito_hipotecario&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_credito_hipotecario").html(x);
           	               	 $("#tabla_credito_hipotecario").tablesorter(); 
           	                 $("#load_credito_hipotecario_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_credito_hipotecario").html("Ocurrio un error al cargar la informacion de Credito Hipotecario..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>
       
       
        <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   load_acuerdo_pago(1);
	   			});

        	   function load_acuerdo_pago(pagina){


        		   var search=$("#search_acuerdo_pago").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_acuerdo_pago_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_acuerdo_pago_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_acuerdo_pago&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_acuerdo_pago").html(x);
           	               	 $("#tabla_acuerdo_pago").tablesorter(); 
           	                 $("#load_acuerdo_pago_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_acuerdo_pago").html("Ocurrio un error al cargar la informacion de Acuerdo Pago..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>
       
       
         <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   load_refinanciamiento(1);
	   			});

        	   function load_refinanciamiento(pagina){


        		   var search=$("#search_credito_refinanciamiento").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_credito_refinanciamiento_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_credito_refinanciamiento_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=SaldosCuentaIndividual&action=cargar_credito_refinanciamiento&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#cta_credito_refinanciamiento").html(x);
           	               	 $("#tabla_credito_refinanciamiento").tablesorter(); 
           	                 $("#load_credito_refinanciamiento_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#cta_credito_refinanciamiento").html("Ocurrio un error al cargar la informacion de Credito Refinanciamiento..."+estado+"    "+error);
           	              }
           	            });


           		   }
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


		    	var id_estado  = $("#id_estado").val();
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
        
       
       
       
       
		     <script type="text/javascript">
		      $(document).ready(function(){
		      $("#actualizar_participe").click(function() {
		    	  $("#leer_mas").fadeOut("slow");
		       	   $("#div_actualizar_datos_participes").fadeIn("slow");
		          
			      });
			   }); 	
			 </script>
       
       <script>
      $(document).ready(function(){
      $(".cantidades1").inputmask();
      });
	  </script>
	
       
			        
    </head>
    
    
    <body class="nav-md"  >
    
    
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
            <?php
       $sel_menu = "";
       
    
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       	  
       	$sel_menu=$_POST['criterio'];
       	 
       }
      
	 	?>
 <div class="container">
 
   <section class="content-header">
         <small><?php echo $fecha; ?></small>
         <ol class=" pull-right breadcrumb">
         <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Panel de Consultas</li>
         </ol>
         </section>
 
  	
  	<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>PANEL DE CONSULTAS<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
					
  	
  	
         <section class="content">
          <div class='nav-tabs-custom'>
          	    <ul id="myTabs" class="nav nav-tabs">
                 
                  <li id="nav-cuenta_creaditos" class="active"><a href="#cuenta_creaditos" data-toggle="tab">Consulta de Créditos</a></li>
                   <li id="nav-cuenta_individual"><a href="#cuenta_individual" data-toggle="tab" >Consulta Cuenta Individual</a></li>
                   <li id="nav-cuenta_desembolsar"><a href="#cuenta_desembolsar" data-toggle="tab">Consulta de Cuentas por Desembolsar</a></li>
                   <li id="nav-mis_datos"><a href="#mis_datos" data-toggle="tab">Mis Datos</a></li>
                   <li id="nav-proyecte_cesantia"><a href="#proyecte_cesantia" data-toggle="tab">Proyecte su Cesantia</a></li>
                </ul>
         
  
         
 		   <div class="tab-content">
 		   <br>
           <div class="tab-pane active" id="cuenta_creaditos">
          
          
          
           <div class='nav-tabs-custom'>
           		<ul id="myTabs" class="nav nav-tabs">
                 
                  <li id="nav-credito_ordinario" class="active"><a href="#credito_ordinario" data-toggle="tab">Ordinario</a></li>
                   <li id="nav-credito_emergente"><a href="#credito_emergente" data-toggle="tab" >Emergente</a></li>
                   <li id="nav-credito_dos_x_uno"><a href="#credito_dos_x_uno" data-toggle="tab">Dos x Uno</a></li>
                   <li id="nav-credito_hipotecario"><a href="#credito_hipotecario" data-toggle="tab">Hipotecario</a></li>
                    <li id="nav-acuerdo_pago"><a href="#acuerdo_pago" data-toggle="tab">Acuerdo de Pago</a></li>
                     <li id="nav-credito_refinanciamiento"><a href="#credito_refinanciamiento" data-toggle="tab">Refinanciamiento</a></li>
                </ul>
          
           <div class="tab-content">
 		   <br>
           <div class="tab-pane active" id="credito_ordinario">
           <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Ordinario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                    <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_credito_ordinario" name="search_credito_ordinario" onkeyup="load_credito_ordinario(1)" placeholder="search.."/>
					</div>
					<br>
					
					<div id="load_credito_ordinario_registrados" ></div>	
					<div id="cta_credito_ordinario"></div>	
                   
                    
                  </div>
                </div>
              </div>
           
           </form>
         </div>
           
           
           
           
           
           
           <div class="tab-pane" id="credito_emergente">
           <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Emergente</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_credito_emergente" name="search_credito_emergente" onkeyup="load_credito_emergente(1)" placeholder="search.."/>
					</div>
					<br>
					
					<div id="load_credito_emergente_registrados" ></div>	
					<div id="cta_credito_emergente"></div>	
                    
                  </div>
                </div>
              </div>
           
           
           </form>
           
           
           
           </div>
           
           
           
           
           
           
           
           
           <div class="tab-pane" id="credito_dos_x_uno">
          <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Dos x Uno</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                    <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_credito_2x1" name="search_credito_2x1" onkeyup="load_credito_2x1(1)" placeholder="search.."/>
					</div>
					<br>
					
					<div id="load_credito_2x1_registrados" ></div>	
					<div id="cta_credito_2x1"></div>	
                    
                  </div>
                </div>
              </div>
           
           
           </form>
           </div>
           
           
           
           
           
            <div class="tab-pane" id="credito_hipotecario">
          <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Hipotecario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                    <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_credito_hipotecario" name="search_credito_hipotecario" onkeyup="load_credito_hipotecario(1)" placeholder="search.."/>
					</div>
					<br>
					
					<div id="load_credito_hipotecario_registrados" ></div>	
					<div id="cta_credito_hipotecario"></div>	
                    
                  </div>
                </div>
              </div>
           
           
           </form>
           </div>
           
           
           
           
              <div class="tab-pane" id="acuerdo_pago">
          <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Acuerdo de Pago</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                    <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_acuerdo_pago" name="search_acuerdo_pago" onkeyup="load_acuerdo_pago(1)" placeholder="search.."/>
					</div>
					<br>
					
					<div id="load_acuerdo_pago_registrados" ></div>	
					<div id="cta_acuerdo_pago"></div>	
                    
                  </div>
                </div>
              </div>
           
           
           </form>
           </div>
           
           
           
           
           
           
            <div class="tab-pane" id="credito_refinanciamiento">
          <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Refinanciamiento</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                    <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_credito_refinanciamiento" name="search_credito_refinanciamiento" onkeyup="load_refinanciamiento(1)" placeholder="search.."/>
					</div>
					<br>
					
					<div id="load_credito_refinanciamiento_registrados" ></div>	
					<div id="cta_credito_refinanciamiento"></div>	
                    
                  </div>
                </div>
              </div>
           
           
           </form>
           </div>
           
           
           
           
           </div>
          
          
           </div>
                
                
          
           </div> 
           
           
           
           
           <div class="tab-pane" id="cuenta_individual">
           <br>
           <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Cuenta Individual (Desde Enero 2011)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  
                    <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search" name="search" onkeyup="load_cta_individual(1)" placeholder="search.."/>
					</div>
					
					
					<div id="load_cta_individual_registrados" ></div>	
					<div id="cta_registrados"></div>	
                  
                  </div>
                </div>
              </div>
		
		
		
           
           
           
           
           
           
           </form>
           </div> 
           
           
           
           <div class="tab-pane" id="cuenta_desembolsar">
           <br>
           <form>
          
          
          
           	<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><small>CONSULTA DE CUENTAS POR DESEMBOLSAR - DESAFILIADOS</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                  <div class="pull-right" style="margin-right:11px;">
					<input type="text" value="" class="form-control" id="search_desembolsar" name="search_desembolsar" onkeyup="load_cta_desembolsar(1)" placeholder="search.."/>
					</div>
					
					
					<div id="load_cta_desembolsar_registrados" ></div>	
					<div id="cta_desembolsar_registrados"></div>	
                  
                  
                  
                  </div>
                </div>
              </div>
		
		
           
           </form>
          
          
           </form>
           </div> 
           
           
           
           
           
           <div class="tab-pane" id="mis_datos">
           <br>
           <form  action="<?php echo $helper->url("SaldosCuentaIndividual","ActualizarParticipe"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
           
           
       
             <?php if (!empty($resultParticipe)) { foreach($resultParticipe as $resEdit) {?>
           
            <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-user'></i> Datos Generales</h4>
	         </div>
	         <div class="panel-body">
			 
			 <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula" class="control-label">Cedula:</label>
                                                      <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $resEdit->cedula; ?>"  placeholder="cedula.." readonly>
                                                      <div id="mensaje_cedula" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Nombre:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $resEdit->nombre; ?>" placeholder="nombres..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-6 col-xs-12 col-md-6">
                    		    <div class="form-group">
                                                      <label for="direccion" class="control-label">Dirección:</label>
                                                      <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $resEdit->direccion; ?>" placeholder="dirección..">
                                                      <div id="mensaje_direccion" class="errores"></div>
                                </div>
                                </div>
                    			
                    		
         	  </div>
			 
			 
			 
			 
			 <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="labor" class="control-label">Cargo:</label>
                                                      <input type="text" class="form-control" id="labor" name="labor" value="<?php echo $resEdit->labor; ?>"  placeholder="cargo..">
                                                      <div id="mensaje_labor" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="correo" class="control-label">Email:</label>
                                                      <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $resEdit->correo; ?>" placeholder="email..">
                                                      <div id="mensaje_correo" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="telefono" class="control-label">Teléfono:</label>
                                                      <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $resEdit->telefono; ?>" placeholder="teléfono..">
                                                      <div id="mensaje_usuario_usuario" class="errores"></div>
                                </div>
                                </div>
                    			
                    		
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="celular" class="control-label">Celular:</label>
                                                      <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $resEdit->celular; ?>" placeholder="celular..">
                                                      <div id="mensaje_usuario_usuario" class="errores"></div>
                                </div>
                                </div>
         	  </div>
			 
			 
			 
			 <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_entidades" class="control-label">Fuerza:</label>
                                                      <select name="id_entidades" id="id_entidades"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEntidades as $res) {?>
                        										<option value="<?php echo $res->id_entidades; ?>" <?php if ($res->id_entidades == $resEdit->id_entidades )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_entidades; ?> </option>
                        							        <?php } ?>
                        						      </select> 
                                                      <div id="mensaje_id_entidades" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="fecha_ingreso" class="control-label">Fecha Entrada:</label>
                                                      <input type="text" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $resEdit->fecha_ingreso; ?>" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                                                      <div id="mensaje_fecha_ingreso" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="sueldo" class="control-label">Sueldo:</label>
                                                      <input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" value='<?php echo $resEdit->sueldo; ?>' 
                                                      data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                      <div id="mensaje_sueldo" class="errores"></div>
                                </div>
                                </div>
                    			
                    			
                    		
                    		
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="hijos" class="control-label">Número Hijos:</label>
                                                      <input type="number" class="form-control" id="hijos" name="hijos" value="<?php echo $resEdit->hijos; ?>" placeholder="# hijos..">
                                                      <div id="mensaje_hijos" class="errores"></div>
                                </div>
                                </div>
                    		    
         	  </div>
			 
			 
			 
			 
			 <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="edad" class="control-label">Edad:</label>
                                                      <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $resEdit->edad; ?>" placeholder="edad..">
                                                      <div id="mensaje_edad" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_sexo" class="control-label">Género:</label>
                                                       <select name="id_sexo" id="id_sexo"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultSexo as $res) {?>
                        										<option value="<?php echo $res->id_sexo; ?>" <?php if ($res->id_sexo == $resEdit->id_sexo )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_sexo; ?> </option>
                        							        <?php } ?>
                        							   </select> 
                                                      <div id="mensaje_id_sexo" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_estado_civil" class="control-label">Estado Civil:</label>
                                                      <select name="id_estado_civil" id="id_estado_civil"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEstado_civil as $res) {?>
                        										<option value="<?php echo $res->id_estado_civil; ?>" <?php if ($res->id_estado_civil == $resEdit->id_estado_civil )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_estado_civil; ?> </option>
                        							        <?php } ?>
                        							  </select> 
                                                      <div id="mensaje_id_estado_civil" class="errores"></div>
                                </div>
                                </div>
                    			
                    		
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_tipo_sangre" class="control-label">Tipo de Sangre:</label>
                                                      <select name="id_tipo_sangre" id="id_tipo_sangre"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTipo_sangre as $res) {?>
                        										<option value="<?php echo $res->id_tipo_sangre; ?>" <?php if ($res->id_tipo_sangre == $resEdit->id_tipo_sangre )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_tipo_sangre; ?> </option>
                        							        <?php } ?>
                        							  </select> 
                                                      <div id="mensaje_id_tipo_sangre" class="errores"></div>
                                </div>
                                </div>
         	  </div>
			 
			 
			  <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_estado" class="control-label">Estado:</label>
                                                      <select name="id_estado" id="id_estado"  class="form-control" disabled>
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEstado as $res) {?>
                        										<option value="<?php echo $res->id_estado; ?>" <?php if ($res->id_estado == $resEdit->id_estado )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_estado; ?> </option>
                        							        <?php } ?>
                        							  </select> 
                                                      <div id="mensaje_id_estado" class="errores"></div>
                                </div>
                                </div>
                                
              </div>
			 
			 
  			</div>
  			</div>
  			
           
           <div class="col-lg-12 col-md-12 col-xs-12"  id="leer_mas" style="text-align: center;">
				  		 <button type="button" id="actualizar_participe" name="actualizar_participe" class="btn btn-primary""><i class="glyphicon glyphicon-plus"></i> Leer Mas</button>         
		   </div>
                       
           
             <div id="div_actualizar_datos_participes" style="display: none;">
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Datos Residencia Hogar</h4>
	         </div>
	         <div class="panel-body">
			 <div class="row">
                    		   
                    		    
             					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_provincias_vivienda" class="control-label">Provincia:</label>
                                                          <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultProvincias as $res) {?>
                        										<option value="<?php echo $res->id_provincias; ?>" <?php if ($res->id_provincias == $resEdit->id_provincias_vivienda )  echo  'selected="selected"';  ?> ><?php echo $res->nombre_provincias; ?> </option>
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
                        										<option value="<?php echo $res->id_cantones; ?>" <?php if ($res->id_cantones == $resEdit->id_cantones_vivienda )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_cantones; ?> </option>
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
                        										<option value="<?php echo $res->id_parroquias; ?>" <?php if ($res->id_parroquias == $resEdit->id_parroquias_vivienda )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_parroquias; ?> </option>
                        							        <?php } ?>
                        								  </select> 
                                                          <div id="mensaje_id_parroquias_vivienda" class="errores"></div>
                                </div>
                    		    </div>
                    			
            </div>
			</div>
  			</div>
           
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Datos Residencia Asignasión</h4>
	         </div>
	         <div class="panel-body">
			 
			 
			 <div class="row">
                    		   
                    		    
             					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_provincias_asignacion" class="control-label">Provincia:</label>
                                                          <select name="id_provincias_asignacion" id="id_provincias_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultProvincias as $res) {?>
                        										<option value="<?php echo $res->id_provincias; ?>" <?php if ($res->id_provincias == $resEdit->id_provincias_asignacion )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_provincias; ?> </option>
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
                        										<option value="<?php echo $res->id_cantones; ?>" <?php if ($res->id_cantones == $resEdit->id_cantones_asignacion )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_cantones; ?> </option>
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
                        										<option value="<?php echo $res->id_parroquias; ?>" <?php if ($res->id_parroquias == $resEdit->id_parroquias_asignacion )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_parroquias; ?> </option>
                        							        <?php } ?>
                        								  </select> 
                                                          <div id="mensaje_id_parroquias_asignacion" class="errores"></div>
                                </div>
                    		    </div>
                        		
            </div>
			 
			<div class="row"> 
			 	
                    			<div class="col-lg-9 col-xs-12 col-md-9">
                    		    <div class="form-group">
                                                      <label for="observacion" class="control-label">Observación:</label>
                                                      <textarea type="text"  class="form-control" id="observacion" name="observacion" value=""  placeholder="observaciones.."><?php echo $resEdit->observacion; ?></textarea>
                                                      <div id="mensaje_observacion" class="errores"></div>
                                </div>
                    		    </div>
                    		    
                    		    
            </div>      		    
			 
			 
  			</div>
  			</div>
  			
  			  
			  			<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
				  		 <button type="submit" id="generar" name="generar" value=""   class="btn btn-success" style="margin-top: 10px;"><i class="glyphicon glyphicon-edit"></i> Actualizar Datos</button>         
					    </div>
  			
  			
            </div>
           
           
           	     <?php } } else {?>
           	     
           	     				<div class="col-lg-6 col-md-6 col-xs-12">
           	                    <div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4>Aviso!!!</h4> No hay datos para mostrar
								</div>
           	     				</div>
           	     
           	     <?php }?>
           
           
           </form>
           </div>
          
          
          
          
          
          
           
           <div class="tab-pane" id="proyecte_cesantia">
           <br>
           <form  action="<?php echo $helper->url("SaldosCuentaIndividual","index"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
          
                    		    <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="valor_prestamo" class="control-label">Valor Prestamo:</label>
                                                      <input type="text" class="form-control cantidades1" id="valor_prestamo" name="valor_prestamo" value='<?php if(!empty($sel_valor_prestamo)){echo $sel_valor_prestamo;}else{echo "0";} ?>' 
                                                      data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                      <div id="mensaje_valor_prestamo" class="errores"></div>
                                </div>
                                </div>
                                
                                
                                
                                 <div class="col-xs-12 col-md-2 col-md-2">
                        		 <div class="form-group">
                                                          <label for="tipo_prestamo" class="control-label">Tipo Crédito:</label>
                                                          <select name="tipo_prestamo" id="tipo_prestamo"  class="form-control" >
                                                         <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultInte as $res) {?>
                        										<option value="<?php echo $res->tipo_prestamo; ?>" <?php if($sel_tipo_prestamo==$res->tipo_prestamo){echo "selected";}?>><?php echo $res->tipo_prestamo; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_tipo_prestamo" class="errores"></div>
                                 </div>
                                 </div>
                                
                                
                                <div class="col-xs-12 col-md-2 col-md-2">
                        		<div class="form-group">
                                                          <label for="taza_intereses" class="control-label">% Interes:</label>
                                                          <select name="taza_intereses" id="taza_intereses"  class="form-control" >
                                                          <option value="0">--Seleccione--</option>
                        								  </select> 
                                                          <div id="mensaje_taza_intereses" class="errores"></div>
                                 </div>
                                 </div>
                                
                                <div class="col-xs-12 col-md-2 col-md-2">
                        		<div class="form-group">
                                                          <label for="cantidad_plazo_meses" class="control-label">Plazo (meses):</label>
                                                          <select name="cantidad_plazo_meses" id="cantidad_plazo_meses"  class="form-control" >
                                                         <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultPlazoMeses as $res) {?>
                        										<option value="<?php echo $res->cantidad_plazo_meses; ?>" <?php if($sel_cantidad_plazo_meses==$res->cantidad_plazo_meses){echo "selected";}?>><?php echo $res->nombre_plazo_meses; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_cantidad_plazo_meses" class="errores"></div>
                                 </div>
                                 </div>
                                
                                
                                 
                                 <div class="col-xs-12 col-md-2 col-lg-2">
		   						 <div class="form-group">
							    					  <label for="fecha_corte" class="control-label">Fecha: </label>
					                                  <input type="date" class="form-control" id="fecha_corte" name="fecha_corte" value="<?php echo $sel_fecha_corte; ?>" >
					                                 <div id="mensaje_fecha_corte" class="errores"></div>
								 </div>
								 </div>
                                 
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="valor_cuota" class="control-label">Valor Cuota:</label>
                                                      <input type="number" class="form-control" id="valor_cuota" name="valor_cuota" value="<?php if (!empty($valor_cuota)) { echo number_format($valor_cuota,2);}  else{ }?>"  placeholder="0.00" readonly>
                                                      <div id="mensaje_valor_cuota" class="errores"></div>
                                </div>
                                </div>
                                
                                 
                                </div>
                    			   	
                    			<div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="Calcular" name="Calcular" class="btn btn-success">Calcular</button>
                                </div>
                    		    </div>
                    		    </div>
          
          
          
          
           </form>
           </div> 
           
           
           </div>
           
           
           
           </div>
           </section>
           
           
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




