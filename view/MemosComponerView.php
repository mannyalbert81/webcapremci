


<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Memos - Capremci</title>
		
		<link rel="stylesheet" href="view/css/estilos.css">
		
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
			
		    <!-- Bootstrap -->
    		<link href="view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    		<!-- Font Awesome -->
		    <link href="view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		    
		    <link href="view/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
		    
		    <link href="view/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    		<!-- starrr -->
    		<link href="view/vendors/starrr/dist/starrr.css" rel="stylesheet">
		    
		    <!-- Custom Theme Style -->
		    <link href="view/build/css/custom.min.css" rel="stylesheet">
			
			
			

			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script type="text/javascript" src="view/vendors/table-sorter/jquery.tablesorter.js"></script> 
	        <script src="view/js/jquery.blockUI.js"></script>
        
        
        <script >
		$(document).ready(function(){

		    $("#btn_to").click(function() {

	            var nombre_usuarios = $("#txt_directorio").val();
                var id_usuarios = $("#directorio").val();
          		var $usuarios_to = $("#usuarios_to");
              
               
               if (id_usuarios > 0)
               {
            	   var contar = $("#usuarios_to option").length;
            	   
	            if(contar==0){


	            	 var array1 = '';
					 var existe1 = false;
            	     
				     $("#usuarios_cc option").each(function(){
					        array1 = $(this).val();
					        if($("#directorio").val() == array1){
					        	existe1 =true;
					        }
					 });


				     if(existe1==false){
						 $usuarios_to.append("<option value= " +id_usuarios +" >" + nombre_usuarios  + "</option>");
						 $("#txt_directorio").val('');
						 $("#directorio").val(0);
					}else{
						alert("Ya Existe en Copia");
						 $("#txt_directorio").val('');
						 $("#directorio").val(0);
					}

	            	
	            	 
				}else{

					 var array = '';
					 var array1='';
					 var existe = false;
            	     
				     $("#usuarios_cc option").each(function(){
					        array = $(this).val();
					        if($("#directorio").val() == array){
					        	existe =true;
					        }
					 });
			       
				     $("#usuarios_to option").each(function(){
					        array1 = $(this).val();
					        if($("#directorio").val() == array1){
					        	existe =true;
					        }
					 });

					if(existe==false){
						 $usuarios_to.append("<option value= " +id_usuarios +" >" + nombre_usuarios  + "</option>");
						 $("#txt_directorio").val('');
						 $("#directorio").val(0);
					}else{
						alert("Ya Existe");
						 $("#txt_directorio").val('');
						 $("#directorio").val(0);
					}
				}				     
            	   	
               }else{
				alert("Ingrese nombre del funcionario.");
				 $("#txt_directorio").val('');
				 $("#directorio").val(0);
          	   
               }
                         
		      });
    
			}); 
		</script>
		
		
	
	
	
	<script >
		$(document).ready(function(){
		  
		    $("#btn_cc").click(function() {
              
		    	 var nombre_usuarios = $("#txt_directorio").val();
	             var id_usuarios = $("#directorio").val();
	          	 var $usuarios_cc = $("#usuarios_cc");



	          	 if (id_usuarios > 0)
	             {

	 	       	   var contar = $("#usuarios_cc option").length;
	            	   
		            if(contar==0){
						
						 var array1 = '';
						 var existe1 = false;
	            	     
					     $("#usuarios_to option").each(function(){
						        array1 = $(this).val();
						        if($("#directorio").val() == array1){
						        	existe1 =true;
						        }
						 });


					     if(existe1==false){
							 $usuarios_cc.append("<option value= " +id_usuarios +" >" + nombre_usuarios  + "</option>");
							 $("#txt_directorio").val('');
							 $("#directorio").val(0);
						}else{
							alert("Ya Existe en Para");
							 $("#txt_directorio").val('');
							 $("#directorio").val(0);
						}


					}else{

	           	     	
						 var array = '';
						 var array1='';
						 var existe = false;
	            	     
					     $("#usuarios_cc option").each(function(){
						        array = $(this).val();
						        if($("#directorio").val() == array){
						        	existe =true;
						        }
						 });
				       
					     $("#usuarios_to option").each(function(){
						        array1 = $(this).val();
						        if($("#directorio").val() == array1){
						        	existe =true;
						        }
						 });
						 

						if(existe==false){
							 $usuarios_cc.append("<option value= " +id_usuarios +" >" + nombre_usuarios  + "</option>");
							 $("#txt_directorio").val('');
							 $("#directorio").val(0);
						}else{
							 alert("Ya Existe");
							 $("#txt_directorio").val('');
							 $("#directorio").val(0);
						}
					}				     
	            	   	
	               }else{
					alert("Ingrese nombre del funcionario.");
					 $("#txt_directorio").val('');
					 $("#directorio").val(0);
	          	   
	               }
	          	 

                
                         
		    });
    
		}); 
	</script>	
        
       
        
        <script type="text/javascript">


        
        
        $(document).ready(function(){

        	$('#btn_borr').click(function() { 

        		 var contar_to = $("#usuarios_to option:selected").length;
        		 var contar_cc = $("#usuarios_cc option:selected").length;

				 var total_contados= contar_to+ contar_cc;
           		
				if(total_contados==0){

					alert("Seleccione para Quitar.");

				}else{

             	 !$('#usuarios_to option:selected').remove();
            	 !$('#usuarios_cc option:selected').remove(); 

 				}

            	 });
    		
  		    });
        </script>
        
        
        
        
        
        
        <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   pone_espera();
        		  
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
            	
		        setTimeout($.unblockUI, 500); 
		        
        	   }
        	 </script>
      
      
      
       <script>
		$(document).ready(function(){
		 	
			$("#txt_directorio").autocomplete({
				
				source: "<?php echo $helper->url("Memos","AutocompleteDirectorio"); ?>",
				minLength: 1,
				select: function( event, data ) 
					{
					 var identificador = data.item.id;
					 var valor = data.item.value;
					 
					 $("#txt_directorio").val(valor);
					 $("#directorio").val(identificador);
					}
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
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <?php include("view/modulos/logo.php"); ?>
            <div class="clearfix"></div>
            <?php include("view/modulos/menu_profile.php"); ?>
            <br/>
            <?php include("view/modulos/menu.php"); ?>	
          </div>
        </div>

        <?php include("view/modulos/head.php"); ?>
        
        
        <div class="right_col" role="main">
         <div class="container">
         <section class="content-header">
         <small><?php echo $fecha; ?></small>
         <ol class=" pull-right breadcrumb">
         <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Crear Memorando</li>
         </ol>
         </section>
        
        
        <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Crear Memorando<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                 <div class="x_content">
        
        
            <form action="<?php echo $helper->url("Memos","InsertaMemo"); ?>" method="post" enctype="multipart/form-data">      
        
        
            <div class="row">
        			<div class="col-lg-4 col-xs-12 col-md-4">
                          <div class="form-group">
                          <label for="txt_directorio" class="control-label">Directorios:</label>
                          <input type="text" class="form-control" id="txt_directorio" name="txt_directorio" value=""  placeholder="Ingrese Destinatario">
                    	  <input type="hidden"  id="directorio" name="directorio" value="0">
			         	  </div>
           		   </div>
           		   
           		   <div class="col-lg-4 col-xs-12 col-md-4" style="margin-top: 23px;">
           		   		  <span class="input-group-btn">
			         		<button type="button" id="btn_to" name="btn_to" class="btn btn-primary">To</button>
	                 		<button type="button" id="btn_cc" name="btn_cc" class="btn btn-info">Cc</button>
			         		<button type="button" id="btn_borr" name="btn_borr" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button>
			        	   </span>
           		   </div>
          </div>
          
        
	    
	    
	    <div class="row">
              		 <div class="col-lg-6 col-xs-12 col-md-6">
                          <div class="form-group">
                          <label for="usuarios_to" class="control-label">To:</label>
                          <select id="usuarios_to" name="usuarios_to[]" size="4" class="form-control" multiple="multiple">
				          </select>
				          <div id="mensaje_usuarios_to" class="errores"></div>
                          </div>
                     </div>
                            		    
                            		    
                    			
                     <div class="col-lg-6 col-xs-12 col-md-6">
                         <div class="form-group">
                         <label for="usuarios_cc" class="control-label">Cc:</label>
                         <select id="usuarios_cc"  name="usuarios_cc[]"  size="4" class="form-control" multiple="multiple">
				         </select>
				         <div id="mensaje_usuarios_cc" class="errores"></div>
                     	 </div>
                    </div>
        </div>
            
        
     
        
        
        <div class="row">
         	<div class="col-lg-12 col-xs-12 col-md-12">
                          <div class="form-group">
                          <label for="asunto" class="control-label">Asunto:</label>
                          <input type="text" class="form-control" id="asunto" name="asunto" value=""  placeholder="Asunto..">
                    	  <div id="mensaje_asunto" class="errores"></div>
                    	  </div>
            </div>
        </div>   
           
           
            
        
	            <div class="row">
	        	<div class="col-lg-12 col-md-12 col-xs-12">
	            <div class="box-body pad">
	                    <textarea id="editor1" name="editor1" rows="10" cols="80"></textarea>
	                    <div id="mensaje_editor1" class="errores"></div>
	            </div>
	       		</div>
	        	</div>
        	       
                 <div class="row" style="margin-top: 20px;">  
                 <div class="col-lg-3 col-xs-12 col-md-3">
                 <div class="form-group">
                             <label for="archivo_1" class="control-label">Archivo 1:</label>
                             <input type="file" class="form-control" id="archivo_1" name="archivo_1" accept="application/pdf" value="">
                             <div id="mensaje_archivo_1" class="errores"></div>
                 </div>
                 </div>
                 
                 <div class="col-lg-3 col-xs-12 col-md-3">
                 <div class="form-group">
                             <label for="archivo_2" class="control-label">Archivo 2:</label>
                             <input type="file" class="form-control" id="archivo_2" name="archivo_2" accept="application/pdf" value="">
                             <div id="mensaje_archivo_2" class="errores"></div>
                 </div>
                 </div>
                 
                 <div class="col-lg-3 col-xs-12 col-md-3">
                 <div class="form-group">
                             <label for="archivo_3" class="control-label">Archivo 3:</label>
                             <input type="file" class="form-control" id="archivo_3" name="archivo_3" accept="application/pdf" value="">
                             <div id="mensaje_archivo_3" class="errores"></div>
                 </div>
                 </div>
                 
                 
                 <div class="col-lg-3 col-xs-12 col-md-3">
                 <div class="form-group">
                             <label for="archivo_4" class="control-label">Archivo 4:</label>
                             <input type="file" class="form-control" id="archivo_4" name="archivo_4" accept="application/pdf" value="">
                             <div id="mensaje_archivo_4" class="errores"></div>
                 </div>
                 </div>
                 </div>  
           
      
           
           
           
           <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top: 20px;">
              <button type="submit" id="cancelar" name="cancelar" onclick="this.form.action='<?php echo $helper->url("Memos","index"); ?>'" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"> Cancelar</i></button>
         	  <button type="submit" id="enviar" name="enviar" class="btn btn-success"><i class="glyphicon glyphicon-envelope"> Enviar</i></button>
         	</div>
        	</form>
           
           
       </div>
           
         	
        
          </div>
          </div>
         </div>
		</div>
	   </div>
	  </div>



	<script type="text/javascript">

	$(document).ready(function(){
		
    $("#enviar").click(function() 
    {
           extensiones_permitidas = new Array(".pdf"); 
		   mierror = ""; 

		   var usuarios_to= $("#usuarios_to").val();
		   var usuarios_cc= $("#usuarios_cc").val();
		   var asunto= $("#asunto").val();
		 
		   
		   var archivo_1= $("#archivo_1").val();
		   var archivo_2= $("#archivo_2").val();
		   var archivo_3= $("#archivo_3").val();
		   var archivo_4= $("#archivo_4").val();	


		   var contar_to = $("#usuarios_to option").length;


				
		    if (contar_to==0 || contar_to =="")
	    	{
		    	$("#mensaje_usuarios_to").text("Seleccione Destinatarios");
	    		$("#mensaje_usuarios_to").fadeIn("slow"); //Muestra mensaje de error
	            return false;
		    }
	    	else 
	    	{
	    		$("#mensaje_usuarios_to").fadeOut("slow"); //Muestra mensaje de error
	            
			}

		   
		    if (asunto == "" )
	    	{
		    	
	    		$("#mensaje_asunto").text("Ingrese Asunto");
	    		$("#mensaje_asunto").fadeIn("slow"); //Muestra mensaje de error
	            return false;
		    }
	    	else 
	    	{
	    		$("#mensaje_asunto").fadeOut("slow"); //Muestra mensaje de error
	            
			}

		   
		    if(archivo_1 != ""){ 
		      extension = (archivo_1.substring(archivo_1.lastIndexOf("."))).toLowerCase(); 
		      permitida = false; 
		      for (var i = 0; i < extensiones_permitidas.length; i++) { 
		         if (extensiones_permitidas[i] == extension) { 
		         permitida = true; 
		         break; 
		         } 
		      } 
		      if (!permitida) { 

		    	  $("#mensaje_archivo_1").text("Sólo se pueden subir archivos con extensiones: "+ extensiones_permitidas.join());
		    	  $("#mensaje_archivo_1").fadeIn("slow"); //Muestra mensaje de error
		          return false;

				}else{ 

			        $("#mensaje_archivo_1").fadeOut("slow"); //Muestra mensaje de error
		      	} 
		   }


			if(archivo_2 != ""){

				  extension2 = (archivo_2.substring(archivo_2.lastIndexOf("."))).toLowerCase(); 
			      permitida2 = false; 
			      for (var i = 0; i < extensiones_permitidas.length; i++) { 
			         if (extensiones_permitidas[i] == extension2) { 
			         permitida2 = true; 
			         break; 
			         } 
			      } 
			      if (!permitida2) { 

			    	  $("#mensaje_archivo_2").text("Sólo se pueden subir archivos con extensiones: "+ extensiones_permitidas.join());
			    	  $("#mensaje_archivo_2").fadeIn("slow"); //Muestra mensaje de error
			          return false;

					}else{ 

				        $("#mensaje_archivo_2").fadeOut("slow"); //Muestra mensaje de error
			      	} 

			}

			if(archivo_3 != ""){

				  extension3 = (archivo_3.substring(archivo_3.lastIndexOf("."))).toLowerCase(); 
			      permitida3 = false; 
			      for (var i = 0; i < extensiones_permitidas.length; i++) { 
			         if (extensiones_permitidas[i] == extension3) { 
			         permitida3 = true; 
			         break; 
			         } 
			      } 
			      if (!permitida3) { 

			    	  $("#mensaje_archivo_3").text("Sólo se pueden subir archivos con extensiones: "+ extensiones_permitidas.join());
			    	  $("#mensaje_archivo_3").fadeIn("slow"); //Muestra mensaje de error
			          return false;

					}else{ 

				        $("#mensaje_archivo_3").fadeOut("slow"); //Muestra mensaje de error
			      	} 

			}




			if(archivo_4 != ""){

				  extension4 = (archivo_4.substring(archivo_4.lastIndexOf("."))).toLowerCase(); 
			      permitida4 = false; 
			      for (var i = 0; i < extensiones_permitidas.length; i++) { 
			         if (extensiones_permitidas[i] == extension4) { 
			         permitida4 = true; 
			         break; 
			         } 
			      } 
			      if (!permitida4) { 

			    	  $("#mensaje_archivo_4").text("Sólo se pueden subir archivos con extensiones: "+ extensiones_permitidas.join());
			    	  $("#mensaje_archivo_4").fadeIn("slow"); //Muestra mensaje de error
			          return false;

					}else{ 

				        $("#mensaje_archivo_4").fadeOut("slow"); //Muestra mensaje de error
			      	} 

			}



			$('#usuarios_to option').prop('selected', 'selected'); 
			$('#usuarios_cc option').prop('selected', 'selected'); 
			
		 
			 
    	}); 

	    $( "#usuarios_to" ).focus(function() {
		  $("#mensaje_usuarios_to").fadeOut("slow");
	    });

    	$( "#asunto" ).focus(function() {
		  $("#mensaje_asunto").fadeOut("slow");
	    });

    	
    	$( "#archivo_1" ).focus(function() {
  		  $("#mensaje_archivo_1").fadeOut("slow");
  	    });
  	    
    	$( "#archivo_2" ).focus(function() {
    	  $("#mensaje_archivo_2").fadeOut("slow");
        });
        
    	$( "#archivo_3" ).focus(function() {
          $("#mensaje_archivo_3").fadeOut("slow");
    	});
    	
    	$( "#archivo_4" ).focus(function() {
    	  $("#mensaje_archivo_4").fadeOut("slow");
    	});
	
    }); 
		 
	</script>


    <script src="view/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="view/build/js/custom.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
    <script src="view/AdminLTE-2.4.2/bower_components/ckeditor/ckeditor.js"></script>
	<script src="view/AdminLTE-2.4.2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
	
	<script>
	  $(function () {
	    // Replace the <textarea id="editor1"> with a CKEditor
	    // instance, using default configuration.
	    CKEDITOR.replace('editor1')
	    //bootstrap WYSIHTML5 - text editor
	    $('.textarea').wysihtml5()
   
	    
	  })
	</script>
    
    
    
		
  </body>
</html>   