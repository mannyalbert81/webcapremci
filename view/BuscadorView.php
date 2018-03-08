<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Búsqueda de Documentos - aDocument 2017</title>

		
		    <!-- Bootstrap -->
    		<link href="view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    		<!-- Font Awesome -->
		    <link href="view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		    <!-- NProgress -->
		    <link href="view/vendors/nprogress/nprogress.css" rel="stylesheet">
		    <!-- iCheck -->
		    <link href="view/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
			
		    <!-- bootstrap-progressbar -->
		    <link href="view/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
		    <!-- JQVMap -->
		    <link href="view/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
		    <!-- bootstrap-daterangepicker -->
		    <link href="view/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
		
		    <!-- Custom Theme Style -->
		    <link href="view/build/css/custom.min.css" rel="stylesheet">
				
			
			<!-- Datatables -->
		    <link href="view/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
		    <link href="view/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
		    <link href="view/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
		    <link href="view/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
		    <link href="view/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
					

		  <script src="view/css/bootstrapValidator.min.js"></script>
		  <script src="view/css/ValidarUsuarios.js"></script>
       
		
		

		
        	<script>
        
        		$(document).ready(function(){
        
        			$("#subcategorias").change(function() {
        
        	               // obtenemos el combo de categorias
        	                var $categorias = $("#categorias");
        	               
        					///obtengo el id seleccionado
        					var id_subcategorias = $(this).val();
        
        	               if(id_subcategorias > 0)
        
        	               {
        	            	   var datos = {
        	            			   id_subcategorias : $(this).val()
        	                   };
        
        
        	            	   //$categorias.append("<option value= " +"0" +" >"+ id_subcategorias  +"</option>");
        	                   $.post("<?php echo $helper->url("subCategorias","devuelveSubBySubcategorias"); ?>", datos, function(resultSub) {
        	            		   
                 		 		  $.each(resultSub, function(index, value) {
        
                 		 			 $('#categorias').val( value.id_categorias );//To select Blue	 
                 		 			//$("'#categorias > option[value="+value.id_categorias"+"]').attr('selected', 'selected'");
        								
        							 });
        
                 		 		 	 		   
                 		  		}, 'json');
        	                   
        	               }
        	               else
        	               {
        
        	          		 $('#categorias').val( 0 );//To select Blue
        
        			        }
        	               
        	               
        			    });
        		}); 
        
        	</script>
        		<script>
        
        		$(document).ready(function(){
        
        		    $("#fecha_documento_hasta").change(function() {
        
        
        		    	var startDate = new Date($('#fecha_documento_desde').val());
        		    	var endDate = new Date($('#fecha_documento_hasta').val());
        
        		    	if (startDate > endDate){
        
        		    		$("#fecha_documento_hasta").val("");
        		    		alert('Fecha documento DESDE mayor a  fecha FINAL');
        		    	}
        
        
        		    	
        			  });
        
        		}); 
        
        	</script>
		

	
        	<script>
        
        		$(document).ready(function(){
        
        		    $("#fecha_poliza_hasta").change(function() {
        
        
        		    	var startDate = new Date($('#fecha_poliza_desde').val());
        		    	var endDate = new Date($('#fecha_poliza_hasta').val());
        
        		    	if (startDate > endDate){
        		    		$("#fecha_poliza_hasta").val("");
        		    		alert('Fecha poliza DESDE mayor a  fecha FINAL');
        		    	}
        			  });
        		}); 
        
        	</script>
        	
	

        	<script>
        
        		$(document).ready(function(){
        
        		    $("#fecha_subida_hasta").change(function() {
        
        
        		    	var startDate = new Date($('#fecha_subida_desde').val());
        		    	var endDate = new Date($('#fecha_subida_hasta').val());
        
        		    	if (startDate > endDate){
        		    		$("#fecha_subida_hasta").val("");
        
        		    		alert('Fecha subida DESDE mayor a  fecha FINAL');
        		    	}
        			  });
        		}); 
        
        	</script>
	
	
		
             <script>
        			function myFunction() {
        			    var x = document.getElementById("categorias").value;
                            var subcategorias = document.getElementById("subcategorias");
                            $subcategorias.Empty();
        				    document.getElementById("demo").innerHTML = "You selected: " + x;
        			}
        	</script>
        	
             
        
               	        
    </head>
    
    
    <body class="nav-md"  >
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
  

        <!-- /page content -->
		
		<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>LISTADO<small>Documentos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Fecha</th>
                          <th>Categoría</th>
                          <th>Subcategoría</th>
                          <th>Tipo Documento</th>
                          <th>Cliente</th>
                     	  <th>Cartón</th>
                     	  <th>Número</th>
                     	  <th>Monto</th>
                     	  <th>Valor</th>
                     	  <th></th>
                        </tr>
                      </thead>


                      <tbody>
    					
    						
    						<?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
            	        		<tr>
            	                   <td > <?php echo $res->id_documentos_legal; ?>  </td>
            	                   <td > <?php echo $res->fecha_documentos_legal; ?>  </td>	
            	                   <td > <?php echo $res->nombre_categorias; ?>  </td>
            	                   <td > <?php echo $res->nombre_subcategorias; ?>  </td>
            	                   <td > <?php echo $res->nombre_tipo_documentos; ?>  </td>
            	                   <td > <?php echo $res->nombre_cliente_proveedor; ?>  </td>
            	                   <td > <?php echo $res->numero_carton_documentos; ?>  </td>
            	                   <td > <?php echo $res->numero_credito_documentos_legal; ?>  </td>
            	                   <td > <?php echo $res->monto_documentos_legal; ?>  </td>               
            	                   <td > <?php echo $res->valor_documentos_legal; ?>  </td>
            	                   
            	                   <td>
            	                   <?php  if ($_SESSION["tipo_usuario"]=="usuario_local") {  ?>
        			            		 <a href=" <?php echo IP_INT . $res->id_documentos_legal; ?>  " class="btn btn-warning" target="blank" style="font-size:65%;">Ver</a>
        			            	<?php } else {?>
        			            		 <a href="<?php echo IP_EXT . $res->id_documentos_legal; ?>  " class="btn btn-warning" target="blank" style="font-size:65%;">Ver</a> 
        			            	<?php }?>
									</td>
            			           
            		    		</tr>
            		        <?php } } ?>
                    
    					    

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
      </div>
    </div>

</div>
        <!-- jQuery -->
    <script src="view/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="view/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="view/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="view/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="view/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="view/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="view/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="view/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="view/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="view/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="view/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="view/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="view/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="view/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="view/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="view/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="view/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="view/vendors/jszip/dist/jszip.min.js"></script>
    <script src="view/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="view/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="view/build/js/custom.min.js"></script>
	
	<!-- codigo de las funciones -->
	<script src="view/js/funciones.js"></script> 
	
  </body>
</html>   

