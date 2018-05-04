<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Usuarios - Capremci</title>

	
		
		<link rel="stylesheet" href="view/css/estilos.css">
		<link rel="stylesheet" href="view/vendors/table-sorter/themes/blue/style.css">
	
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
			
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
        
        
        
        <script >
		$(document).ready(function(){
		    // cada vez que se cambia el valor del combo
		    $("#btn_to").click(function() {
               // obtenemos el combo de subcategorias
                
                
                var nombre_usuarios = $("#txt_directorio").val();

          
				
                var $usuarios_to = $("#usuarios_to");
                // lo vaciamos
               
               if (nombre_usuarios !="")
               {
            	   $usuarios_to.append("<option value= " +nombre_usuarios +";"+" >" + nombre_usuarios  + "</option>");



               	    $("#usuarios_to").each(function(){
            	        
						var _usuario_to = $(this).text();
						var valNew=_usuario_to.split(';');
						for (i = 0;i<valNew.length;i++)
						{
							alert(valNew);
					    }
						
                      });




            	   	
               }
                         
		    });
    
		}); 
	</script>
	<script >
		$(document).ready(function(){
		    // cada vez que se cambia el valor del combo
		    $("#btn_cc").click(function() {
               // obtenemos el combo de subcategorias
                
                
                var nombre_usuarios = $("#txt_directorio").val();

          
				
                var $usuarios_cc = $("#usuarios_cc");
                // lo vaciamos
               
               if (nombre_usuarios !="")
               {
            	   $usuarios_cc.append("<option value= " +nombre_usuarios +" >" + nombre_usuarios  + "</option>");	
               }
                         
		    });
    
		}); 
	</script>	
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <script type="text/javascript">
     
        	   $(document).ready( function (){
        		   pone_espera();
        		   load_usuarios(1);
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

        	   
        	   function load_usuarios(pagina){


        		   var search=$("#search").val();
                   var con_datos={
           					  action:'ajax',
           					  page:pagina
           					  };
                 $("#load_registrados").fadeIn('slow');
           	     $.ajax({
           	               beforeSend: function(objeto){
           	                 $("#load_registrados").html('<center><img src="view/images/ajax-loader.gif"> Cargando...</center>')
           	               },
           	               url: 'index.php?controller=Usuarios&action=index10&search='+search,
           	               type: 'POST',
           	               data: con_datos,
           	               success: function(x){
           	                 $("#users_registrados").html(x);
           	               	 $("#tabla_usuarios").tablesorter(); 
           	                 $("#load_registrados").html("");
           	               },
           	              error: function(jqXHR,estado,error){
           	                $("#users_registrados").html("Ocurrio un error al cargar la informacion de Usuarios..."+estado+"    "+error);
           	              }
           	            });


           		   }
        </script>
        
        
         <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    $("#Cancelar").click(function() 
			{
			 $("#cedula_usuarios").val("");
		     $("#nombre_usuarios").val("");
		     $("#clave_usuarios").val("");
		     $("#clave_usuarios_r").val("");
		     $("#telefono_usuarios").val("");
		     $("#celular_usuarios").val("");
		     $("#correo_usuarios").val("");
		     $("#id_rol").val("");
		     $("#id_estado").val("");
		     $("#fotografia_usuarios").val("");
		     $("#id_usuarios").val("");
		     $("#id_departamentos").val("");
		     $("#cargo_usuarios").val("");
		     $("#identificador_departamentos").val("");
		     
		     
		    }); 
		    }); 
			</script>
        
        
        
        
         
        <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#Guardar").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var cedula_usuarios = $("#cedula_usuarios").val();
		    	var nombre_usuarios = $("#nombre_usuarios").val();
		    	//var usuario_usuario = $("#usuario_usuario").val();
		    	var clave_usuarios = $("#clave_usuarios").val();
		    	var cclave_usuarios = $("#clave_usuarios_r").val();
		    	var celular_usuarios = $("#celular_usuarios").val();
		    	var correo_usuarios  = $("#correo_usuarios").val();
		    	var id_rol  = $("#id_rol").val();
		    	var id_estado  = $("#id_estado").val();
		    	var id_departamentos  = $("#id_departamentos").val();
		    	var cargo_usuarios  = $("#cargo_usuarios").val();
		    	var identificador_departamentos  = $("#identificador_departamentos").val();
		    	if (cedula_usuarios == "")
		    	{
			    	
		    		$("#mensaje_cedula_usuarios").text("Introduzca Identificación");
		    		$("#mensaje_cedula_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_cedula_usuarios").fadeOut("slow"); //Muestra mensaje de error
		            
				}    
				
		    	if (nombre_usuarios == "")
		    	{
			    	
		    		$("#mensaje_nombre_usuarios").text("Introduzca un Nombre");
		    		$("#mensaje_nombre_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_nombre_usuarios").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	
		    	/*if (usuario_usuario == "")
		    	{
			    	
		    		$("#mensaje_usuario_usuario").text("Introduzca un Usuario");
		    		$("#mensaje_usuario_usuario").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_usuario_usuario").fadeOut("slow"); //Muestra mensaje de error
		            
				}   */
						    	
			
		    	if (clave_usuarios == "")
		    	{
		    		
		    		$("#mensaje_clave_usuarios").text("Introduzca una Clave");
		    		$("#mensaje_clave_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }else if (clave_usuarios.length<4){
			    	$("#mensaje_clave_usuarios").text("Introduzca minimo 4 números");
		    		$("#mensaje_clave_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;
				}else if (clave_usuarios.length>4){
			    	$("#mensaje_clave_usuarios").text("Introduzca máximo 4 números");
		    		$("#mensaje_clave_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;
				}
		    	else 
		    	{
		    		$("#mensaje_clave_usuarios").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	

		    	if (cclave_usuarios == "")
		    	{
		    		
		    		$("#mensaje_clave_usuarios_r").text("Introduzca una Clave");
		    		$("#mensaje_clave_usuarios_r").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_clave_usuarios_r").fadeOut("slow"); 
		            
				}
		    	
		    	if (clave_usuarios != cclave_usuarios)
		    	{
			    	
		    		$("#mensaje_clave_usuarios_r").text("Claves no Coinciden");
		    		$("#mensaje_clave_usuarios_r").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else
		    	{
		    		$("#mensaje_clave_usuarios_r").fadeOut("slow"); 
			        
		    	}	
				

				//los telefonos
		    	
		    	if (celular_usuarios == "" )
		    	{
			    	
		    		$("#mensaje_celular_usuarios").text("Ingrese un Celular");
		    		$("#mensaje_celular_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_celular_usuarios").fadeOut("slow"); //Muestra mensaje de error
		            
				}

				// correos
				
		    	if (correo_usuarios == "")
		    	{
			    	
		    		$("#mensaje_correo_usuarios").text("Introduzca un correo");
		    		$("#mensaje_correo_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else if (regex.test($('#correo_usuarios').val().trim()))
		    	{
		    		$("#mensaje_correo_usuarios").fadeOut("slow"); //Muestra mensaje de error
		            
				}
		    	else 
		    	{
		    		$("#mensaje_correo_usuarios").text("Introduzca un correo Valido");
		    		$("#mensaje_correo_usuarios").fadeIn("slow"); //Muestra mensaje de error
		            return false;	
			    }

		    	
		    	if (id_rol == 0 )
		    	{
			    	
		    		$("#mensaje_id_rol").text("Seleccione");
		    		$("#mensaje_id_rol").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_rol").fadeOut("slow"); //Muestra mensaje de error
		            
				}



		    	if (id_estado == 0 )
		    	{
			    	
		    		$("#mensaje_id_estado").text("Seleccione");
		    		$("#mensaje_id_estado").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_estado").fadeOut("slow"); //Muestra mensaje de error
		            
				}


		    	if (id_departamentos == 0 )
		    	{
			    	
		    		$("#mensaje_id_departamentos").text("Seleccione");
		    		$("#mensaje_id_departamentos").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_id_departamentos").fadeOut("slow"); //Muestra mensaje de error
		            
				}
								    

			}); 


		        $( "#cedula_usuarios" ).focus(function() {
				  $("#mensaje_cedula_usuarios").fadeOut("slow");
			    });
				
				$( "#nombre_usuarios" ).focus(function() {
					$("#mensaje_nombre_usuarios").fadeOut("slow");
    			});
				/*$( "#usuario_usuario" ).focus(function() {
					$("#mensaje_usuario_usuario").fadeOut("slow");
    			});*/
    			
				$( "#clave_usuarios" ).focus(function() {
					$("#mensaje_clave_usuarios").fadeOut("slow");
    			});
				$( "#clave_usuarios_r" ).focus(function() {
					$("#mensaje_clave_usuarios_r").fadeOut("slow");
    			});
				
				$( "#celular_usuarios" ).focus(function() {
					$("#mensaje_celular_usuarios").fadeOut("slow");
    			});
				
				$( "#correo_usuarios" ).focus(function() {
					$("#mensaje_correo_usuarios").fadeOut("slow");
    			});
			
				$( "#id_rol" ).focus(function() {
					$("#mensaje_id_rol").fadeOut("slow");
    			});

				$( "#id_estado" ).focus(function() {
					$("#mensaje_id_estado").fadeOut("slow");
    			});
				

				$( "#id_departamentos" ).focus(function() {
					$("#mensaje_id_departamentos").fadeOut("slow");
    			});
				
		       
				    
		}); 

	</script>
        
        
        
        
    <script >   
    function numeros(e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "0123456789";
    especiales = [8,37,39,46];
 
    tecla_especial = false
    for(var i in especiales){
    if(key == especiales[i]){	
     tecla_especial = true;
     break;
        } 
    }
 
    if(letras.indexOf(tecla)==-1 && !tecla_especial)
        return false;
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
				
			$("#txt_directorio").focusout(function(){
		
				if($("#txt_directorio").val()==''||$("#txt_directorio").val()==null)
				{
					 $("#txt_directorio").val('');
					 $("#directorio").val(0);
					 
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

            <!-- menu profile quick info -->
            <?php include("view/modulos/menu_profile.php"); ?>
            <!-- /menu profile quick info -->

            <br />

            
            <!-- sidebar menu -->
            <?php include("view/modulos/menu.php"); ?>	
           
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php include("view/modulos/head.php"); ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Crear Memoramdum</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="button">Go!</button>
                          </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Asistente <small>Memorandum</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <!-- Smart Wizard -->
                    <p>Siga las instrucciones para crear un Memorandum</p>
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                              Paso 1<br />
                                              <small>fecha y asunto</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                              Paso 2<br />
                                              <small>destinatarios</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                              Paso 3<br />
                                              <small>contenido</small>
                                          </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-4">
                            <span class="step_no">4</span>
                            <span class="step_descr">
                                              Paso 4<br />
                                              <small>previsualizar y enviar</small>
                                          </span>
                          </a>
                        </li>
                      </ul>
                      <div id="step-1">
                        <form class="form-horizontal form-label-left">

                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numero_memos_cab">Número <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="text" id="numero_memos_cab" name="numero_memos_cab" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fecha_memos_cab">Fecha <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input type="date" id="fecha_memos_cab" name="fecha_memos_cab" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Middle Name / Initial</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="asunto_memos_cab" name="asunto_memos_cab" required="required" class="form-control col-md-7 col-xs-12" type="text" >
                            </div>
                          </div>
                          
                        </form>

                      </div>
                      <div id="step-2">
                       <form class="form-horizontal form-label-left">
							<div class="form-group">
	                        	<label class="control-label col-md-2 col-sm-2 col-xs-12">Directorios</label>
	                        	<div class="col-md-4 col-sm-4 col-xs-12">
	                          		
                 		 			<div class="input-group">
			                            <input type="text" class="form-control" id="txt_directorio" name="txt_directorio" value=""  placeholder="Seleccione Destinatario">
                 		 			    <input type="hidden"  id="directorio" name="directorio" value="0">
			                            <span class="input-group-btn">
			                            <button type="button" id="btn_to" name="btn_to" class="btn btn-primary">To</button>
										<button type="button" id="btn_cc" name="btn_cc" class="btn btn-info">Cc</button>
			                             </span>
			                          </div>
			                    	
	                        	</div>
	                        </div>
	                              <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Multiple</label>
				                        <div class="col-md-9 col-sm-9 col-xs-12">
				                          <select id="usuarios_to" name="usuarios_to"  class="select2_multiple form-control" multiple="multiple">
				                            
				                        
				                          </select>
				                        </div>
				                      </div>
				                      <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Multiple</label>
				                        <div class="col-md-9 col-sm-9 col-xs-12">
				                          <select id="usuarios_cc"  name="usuarios_cc"  class="select2_multiple form-control" multiple="multiple">
				                        
				                          </select>
				                        </div>
				                      </div>
                 		 		
                          
                          
                        </form>
                      </div>

                    </div>
                    <!-- End SmartWizard Content -->





                                        <!-- End SmartWizard Content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- FastClick -->
    <script src="view/vendors/fastclick/lib/fastclick.js"></script>
    <!-- jQuery Smart Wizard -->
    <script src="view/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

 
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
    
    
    <!-- jQuery Tags Input -->
    <script src="view/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="view/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="view/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="view/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="view/vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="view/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="view/vendors/starrr/dist/starrr.js"></script>
    
	 
	      
		  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	
  </body>    
    
   
	<!-- codigo de las funciones -->

	
  </body>
</html>   