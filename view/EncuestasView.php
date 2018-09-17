<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Encuestas - Capremci</title>

	 
 
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
            
              <link rel="stylesheet" href="view/AdminLTE-2.4.2/plugins/iCheck/all.css">
           
       		<script src="view/input-mask/jquery.inputmask.js"></script>
			<script src="view/input-mask/jquery.inputmask.date.extensions.js"></script>
			<script src="view/input-mask/jquery.inputmask.extensions.js"></script>
        
    
       
      
       <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#generar").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var respuesta_pregunta_1 = $("#respuesta_pregunta_1").val();
		    	var respuesta_pregunta_2 = $("#respuesta_pregunta_2").val();
		    	var respuesta_pregunta_3 = $("#respuesta_pregunta_3").val();
		    	var respuesta_pregunta_4 = $("#respuesta_pregunta_4").val();
		    	var respuesta_pregunta_5 = $("#respuesta_pregunta_5").val();
		    	var respuesta_pregunta_6 = $("#respuesta_pregunta_6").val();
		    	var respuesta_pregunta_7 = $("#respuesta_pregunta_7").val();
		    	var respuesta_pregunta_8 = $("#respuesta_pregunta_8").val();


		    	var comentario_respuesta_1 = $("#comentario_respuesta_1").val();
		    	var comentario_respuesta_2 = $("#comentario_respuesta_2").val();
		    	var comentario_respuesta_3 = $("#comentario_respuesta_3").val();
		    	var comentario_respuesta_4 = $("#comentario_respuesta_4").val();
		    	var comentario_respuesta_5 = $("#comentario_respuesta_5").val();
		    	var comentario_respuesta_6 = $("#comentario_respuesta_6").val();
		    	var comentario_respuesta_7 = $("#comentario_respuesta_7").val();
		    	var comentario_respuesta_8 = $("#comentario_respuesta_8").val();


				
		    	        if($("#respuesta_pregunta_1").is(':checked') || $("#respuesta_pregunta_11").is(':checked') || $("#respuesta_pregunta_111").is(':checked')) {  



                            if($("#respuesta_pregunta_1").is(':checked')){

                            	$("#mensaje_comentario_respuesta_1").fadeOut("slow");

                            }else if($("#respuesta_pregunta_11").is(':checked')){



								if(comentario_respuesta_1==""){

									$("#mensaje_comentario_respuesta_1").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_1").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_1").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }else if($("#respuesta_pregunta_111").is(':checked')){

                            	if(comentario_respuesta_1==""){

									$("#mensaje_comentario_respuesta_1").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_1").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_1").fadeOut("slow");
									
									}
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_1").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_1").fadeIn("slow"); 
				            return false;
		    	        }  





		    	        if($("#respuesta_pregunta_2").is(':checked') || $("#respuesta_pregunta_22").is(':checked') || $("#respuesta_pregunta_222").is(':checked')) {  



                            if($("#respuesta_pregunta_2").is(':checked')){

                            	$("#mensaje_comentario_respuesta_2").fadeOut("slow");

                            }else if($("#respuesta_pregunta_22").is(':checked')){



								if(comentario_respuesta_2==""){

									$("#mensaje_comentario_respuesta_2").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_2").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_2").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }else if($("#respuesta_pregunta_222").is(':checked')){

                            	if(comentario_respuesta_2==""){

									$("#mensaje_comentario_respuesta_2").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_2").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_2").fadeOut("slow");
									
									}
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_2").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_2").fadeIn("slow"); 
				            return false;
		    	        }  
		    	        






		    	        if($("#respuesta_pregunta_3").is(':checked') || $("#respuesta_pregunta_33").is(':checked') || $("#respuesta_pregunta_333").is(':checked')|| $("#respuesta_pregunta_3333").is(':checked')) {  



                            if($("#respuesta_pregunta_3333").is(':checked')){

                            	$("#mensaje_comentario_respuesta_3").fadeOut("slow");

                            }else if($("#respuesta_pregunta_333").is(':checked')){



								if(comentario_respuesta_3==""){

									$("#mensaje_comentario_respuesta_3").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_3").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_3").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }else if($("#respuesta_pregunta_33").is(':checked')){

                            	if(comentario_respuesta_3==""){

									$("#mensaje_comentario_respuesta_3").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_3").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_3").fadeOut("slow");
									
									}
                            	
                            }else if($("#respuesta_pregunta_3").is(':checked')){

                            	if(comentario_respuesta_3==""){

									$("#mensaje_comentario_respuesta_3").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_3").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_3").fadeOut("slow");
									
									}
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_3").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_3").fadeIn("slow"); 
				            return false;
		    	        }  






		    	        if($("#respuesta_pregunta_4").is(':checked') || $("#respuesta_pregunta_44").is(':checked') || 
				    	   $("#respuesta_pregunta_444").is(':checked') || $("#respuesta_pregunta_4444").is(':checked')
				    	   || $("#respuesta_pregunta_44444").is(':checked') || $("#respuesta_pregunta_444444").is(':checked')
				    	   || $("#respuesta_pregunta_4444444").is(':checked') || $("#respuesta_pregunta_44444444").is(':checked')
				    	   || $("#respuesta_pregunta_444444444").is(':checked') || $("#respuesta_pregunta_4444444444").is(':checked')) {  



                            if($("#respuesta_pregunta_4444444444").is(':checked')){

                            	$("#mensaje_comentario_respuesta_4").fadeOut("slow");

                            }else if($("#respuesta_pregunta_444444444").is(':checked')){



								if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }else if($("#respuesta_pregunta_44444444").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }else if($("#respuesta_pregunta_4444444").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }else if($("#respuesta_pregunta_444444").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }else if($("#respuesta_pregunta_44444").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }else if($("#respuesta_pregunta_4444").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }else if($("#respuesta_pregunta_444").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }else if($("#respuesta_pregunta_44").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }
                            else if($("#respuesta_pregunta_4").is(':checked')){

                            	if(comentario_respuesta_4==""){

									$("#mensaje_comentario_respuesta_4").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_4").fadeOut("slow");
									
									}
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_4").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_4").fadeIn("slow"); 
				            return false;
		    	        }  
		    	    





		    	        if($("#respuesta_pregunta_5").is(':checked') || $("#respuesta_pregunta_55").is(':checked') || $("#respuesta_pregunta_555").is(':checked')) {  



                            if($("#respuesta_pregunta_5").is(':checked')){

                            	$("#mensaje_comentario_respuesta_5").fadeOut("slow");

                            }else if($("#respuesta_pregunta_55").is(':checked')){



								if(comentario_respuesta_5==""){

									$("#mensaje_comentario_respuesta_5").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_5").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_5").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }else if($("#respuesta_pregunta_555").is(':checked')){

                            	if(comentario_respuesta_5==""){

									$("#mensaje_comentario_respuesta_5").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_5").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_5").fadeOut("slow");
									
									}
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_5").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_5").fadeIn("slow"); 
				            return false;
		    	        }  








		    	        if($("#respuesta_pregunta_6").is(':checked') || $("#respuesta_pregunta_66").is(':checked')) {  



                            if($("#respuesta_pregunta_6").is(':checked')){

                            	$("#mensaje_comentario_respuesta_6").fadeOut("slow");

                            }else if($("#respuesta_pregunta_66").is(':checked')){



								if(comentario_respuesta_6==""){

									$("#mensaje_comentario_respuesta_6").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_6").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_6").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_6").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_6").fadeIn("slow"); 
				            return false;
		    	        }  




		    	        if($("#respuesta_pregunta_7").is(':checked') || $("#respuesta_pregunta_77").is(':checked')) {  



                            if($("#respuesta_pregunta_7").is(':checked')){

                            	$("#mensaje_comentario_respuesta_7").fadeOut("slow");

                            }else if($("#respuesta_pregunta_77").is(':checked')){



								if(comentario_respuesta_7==""){

									$("#mensaje_comentario_respuesta_7").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_7").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_7").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_7").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_7").fadeIn("slow"); 
				            return false;
		    	        }  






		    	        if($("#respuesta_pregunta_8").is(':checked') || $("#respuesta_pregunta_88").is(':checked') || $("#respuesta_pregunta_888").is(':checked')) {  



                            if($("#respuesta_pregunta_8").is(':checked')){

                            	$("#mensaje_comentario_respuesta_8").fadeOut("slow");

                            }else if($("#respuesta_pregunta_88").is(':checked')){



								if(comentario_respuesta_8==""){

									$("#mensaje_comentario_respuesta_8").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_8").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_8").fadeOut("slow");
									
									}
                            	
                            	
                            	
                            }else if($("#respuesta_pregunta_888").is(':checked')){

                            	if(comentario_respuesta_8==""){

									$("#mensaje_comentario_respuesta_8").text("Explique Motivo");
	    				    		$("#mensaje_comentario_respuesta_8").fadeIn("slow"); 
	    				            return false;

								}else{

									$("#mensaje_comentario_respuesta_8").fadeOut("slow");
									
									}
                            	
                            }


		    	        	
		    	        } else {  
		    	        	$("#mensaje_comentario_respuesta_8").text("Seleccione una opción");
				    		$("#mensaje_comentario_respuesta_8").fadeIn("slow"); 
				            return false;
		    	        }  

		    	        

		    	    	
		    	
		    	
			}); 


		        $( "#comentario_respuesta_1" ).focus(function() {
				  $("#mensaje_comentario_respuesta_1").fadeOut("slow");
			    });

		        $( "#comentario_respuesta_2" ).focus(function() {
					  $("#mensaje_comentario_respuesta_2").fadeOut("slow");
				 });

		        $( "#comentario_respuesta_3" ).focus(function() {
					  $("#mensaje_comentario_respuesta_3").fadeOut("slow");
				 });  

		        $( "#comentario_respuesta_4" ).focus(function() {
					  $("#mensaje_comentario_respuesta_4").fadeOut("slow");
				 });

		        $( "#comentario_respuesta_5" ).focus(function() {
					  $("#mensaje_comentario_respuesta_5").fadeOut("slow");
				 });

		        $( "#comentario_respuesta_6" ).focus(function() {
					  $("#mensaje_comentario_respuesta_6").fadeOut("slow");
				 });
				 
		        $( "#comentario_respuesta_7" ).focus(function() {
					  $("#mensaje_comentario_respuesta_7").fadeOut("slow");
				 });

		        $( "#comentario_respuesta_8" ).focus(function() {
					  $("#mensaje_comentario_respuesta_8").fadeOut("slow");
				 });
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
         <li class="active">Realizar Encuesta</li>
         </ol>
         </section>
       
  
		
		<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Realizar<small>Encuesta</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    
		
      
      
      
         
           <form  action="<?php echo $helper->url("Encuestas","InsertaEncuestas"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
           
           
      
          <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-user'></i> Encuesta Pagina Web y Servicios Online</h4>
	         </div>
	         <div class="panel-body">
			 
			 <div class="row">
			 	<label  class="control-label"><?php echo $pregunta_1;?></label>
			    <input type="hidden" id="pregunta_1" name="pregunta_1" value="<?php echo $id_pregunta_1;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-4 col-md-4 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_1" name="respuesta_pregunta_1" value="Bueno" class="flat-red">
			                  Bueno
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_11" name="respuesta_pregunta_1" value="Intermedio" class="flat-red">
			                  Intermedio
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_111" name="respuesta_pregunta_1" value="Malo" class="flat-red">
			                  Malo
			                </span>
			                </div>
			                </div>
			                
		          </div>        
	                        <div id="mensaje_respuesta_pregunta_1" class="errores"></div>    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_1" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_1" name="comentario_respuesta_1"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_1" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
			 
			 
           
           
               <div class="row">
			 	<label class="control-label"><?php echo $pregunta_2;?></label>
			     <input type="hidden" id="pregunta_2" name="pregunta_2" value="<?php echo $id_pregunta_2;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-4 col-md-4 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_2" name="respuesta_pregunta_2" value="Si" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_22" name="respuesta_pregunta_2" value="Algo" class="flat-red">
			                  Algo
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_222" name="respuesta_pregunta_2" value="Nada" class="flat-red">
			                  Nada
			                </span>
			                </div>
			                </div>
		          </div>        
	                    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_2" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_2" name="comentario_respuesta_2"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_2" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
           
           
            
            
            
            
               <div class="row">
			 	<label value="<?php echo $id_pregunta_3;?>" class="control-label"><?php echo $pregunta_3;?></label>
			    <input type="hidden" id="pregunta_3" name="pregunta_3" value="<?php echo $id_pregunta_3;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-3 col-md-3 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_3" name="respuesta_pregunta_3" value="Los Colores" class="flat-red">
			                  Los Colores
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-3 col-md-3 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_33" name="respuesta_pregunta_3" value="La Información" class="flat-red">
			                  La Información
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-3 col-md-3 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_333" name="respuesta_pregunta_3" value="Las Imágenes" class="flat-red">
			                  Las Imágenes
			                </span>
			                </div>
			                </div>
			                
			                
			                 <div class="col-lg-3 col-md-3 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_3333" name="respuesta_pregunta_3" value="Nada" class="flat-red">
			                  Nada
			                </span>
			                </div>
			                </div>
		          </div>        
	                    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_3" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_3" name="comentario_respuesta_3"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_3" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
        
              
           
           
           
              <div class="row">
			 	<label class="control-label"><?php echo $pregunta_4;?></label>
			     <input type="hidden" id="pregunta_4" name="pregunta_4" value="<?php echo $id_pregunta_4;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-1 col-md-1 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_4" name="respuesta_pregunta_4" value="1" class="flat-red">
			                  1
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_44" name="respuesta_pregunta_4" value="2" class="flat-red">
			                  2
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_444" name="respuesta_pregunta_4" value="3" class="flat-red">
			                  3
			                </span>
			                </div>
			                </div>
			                
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_4444" name="respuesta_pregunta_4" value="4" class="flat-red">
			                  4
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_44444" name="respuesta_pregunta_4" value="5" class="flat-red">
			                  5
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_444444" name="respuesta_pregunta_4" value="6" class="flat-red">
			                  6
			                </span>
			                </div>
			                </div>
			                
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_4444444" name="respuesta_pregunta_4" value="7" class="flat-red">
			                  7
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_444444444" name="respuesta_pregunta_4" value="8" class="flat-red">
			                  8
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_444444444" name="respuesta_pregunta_4" value="9" class="flat-red">
			                  9
			                </span>
			                </div>
			                </div>
			                
			                
			                
			                <div class="col-lg-1 col-md-1 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_4444444444" name="respuesta_pregunta_4" value="10" class="flat-red">
			                  10
			                </span>
			                </div>
			                </div>
		          </div>        
	                    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_4" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_4" name="comentario_respuesta_4"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_4" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
        
           
           
           
              
              
              <div class="row">
			 	<label class="control-label"><?php echo $pregunta_5;?></label>
			     <input type="hidden" id="pregunta_5" name="pregunta_5" value="<?php echo $id_pregunta_5;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-4 col-md-4 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_5" name="respuesta_pregunta_5" value="Si" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_55" name="respuesta_pregunta_5" value="Intermedio" class="flat-red">
			                  Intermedio
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_555" name="respuesta_pregunta_5" value="No" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
		          </div>        
	                    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_5" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_5" name="comentario_respuesta_5"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_5" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
        
           
           
           
           
              
              <div class="row">
			 	<label class="control-label"><?php echo $pregunta_6;?></label>
			     <input type="hidden" id="pregunta_6" name="pregunta_6" value="<?php echo $id_pregunta_6;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-4 col-md-4 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_6" name="respuesta_pregunta_6" value="Si" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_66" name="respuesta_pregunta_6" value="No" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
			                
			               
		          </div>        
	                    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_6" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_6" name="comentario_respuesta_6"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_6" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
        
           
           
           
           
               
              <div class="row">
			 	<label class="control-label"><?php echo $pregunta_7;?></label>
			     <input type="hidden" id="pregunta_7" name="pregunta_7" value="<?php echo $id_pregunta_7;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-4 col-md-4 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_7" name="respuesta_pregunta_7" value="Si" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_77" name="respuesta_pregunta_7" value="No" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
			                
			               
		          </div>        
	                    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_7" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_7" name="comentario_respuesta_7"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_7" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
        
           
           
           
           
              <div class="row">
			 	<label class="control-label"><?php echo $pregunta_8;?></label>
			     <input type="hidden" id="pregunta_8" name="pregunta_8" value="<?php echo $id_pregunta_8;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-4 col-md-4 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_8" name="respuesta_pregunta_8" value="Si" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_88" name="respuesta_pregunta_8" value="Intermedio" class="flat-red">
			                  Intermedio
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-4 col-md-4 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_888" name="respuesta_pregunta_8" value="No" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
		          </div>        
	                    
	                    
	                <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
                    <div class="form-group">
	                                      <label for="comentario_respuesta_8" class="control-label">Porque:</label>               
	                                      <textarea  class="form-control" id="comentario_respuesta_8" name="comentario_respuesta_8"  placeholder="Explique el motivo.." ></textarea>
	                                      <div id="mensaje_comentario_respuesta_8" class="errores"></div>
	                </div>
                    </div>
	            </div>
              </div>
        
           
           
  			
  			  
			  			<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
				  		 <button type="submit" id="generar" name="generar" value=""   class="btn btn-success" style="margin-top: 10px;"><i class="glyphicon glyphicon-edit"></i> Registrar Encuesta</button>         
					    </div>
  			
  		</div></div>	
         
      
      
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

<script src="view/AdminLTE-2.4.2/plugins/iCheck/icheck.min.js"></script>


<script>
  $(function () {

 $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    
    })
</script>



	
  </body>
</html>   