<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Contenido Cartón  - <?php echo $numero_carton_documentos; ?></title>

		
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
  
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>DOCUMENTOS<small>Contenido Cartón</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


            <form id="form-usuarios" action="<?php echo $helper->url("Documentos","BuscaxCarton"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                                <div class="row">
                        		    <div class="col-xs-6 col-md-4 col-md-4 ">
                        		    <div class="form-group">
                                                          <label for="numero_carton" class="control-label">Número Cartón</label>
            											  <input type="text" name="numero_carton_documentos" value="" class="form-control"/>
		                            </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-6 col-md-8 col-md-8">
                        		    <div class="form-group">
                                                          <?php  $paginas =   0;  ?>
                                                		    <?php  $registros = 0; ?>
                                                		    <?php  $numero_carton_documentos = 0; ?>
                                                	  		<?php if ($resultSet !="") { foreach($resultSet as $res) {?>
                                                	        		
                                                		                 <?php $numero_carton_documentos =  $res->numero_carton_documentos; ?>     
                                                		    	       
                                                		            		 <?php  $paginas = $paginas + $res->paginas_documentos_legal;  ?>
                                                		                     <?php  $registros = $registros + 1 ; ?>
                                                		        <?php } ?>
                                                				   <table class="table">
                                                				        <tr>
                                                				    		<th>Resúmen del Cartón: <?php echo $numero_carton_documentos  ?>    </th>
                                                				  		</tr>
                                                			    		<tr>
                                                			    			<td> <p class="text-justify">  <strong> Se encontraton <?php echo $registros?> documentos, los cuales contienen un total de <?php echo $paginas ?> páginas.  </strong> Recuerde revisar estos documentos antes de imprimir el reporte final </p> </td>
                                                			    		</tr>
                                                			    
                                                			    
                                                			     	</table>
                                                  	
                                                  	        
                                                				<?php    }   else {?>
                                                		        
                                                		            
                                                		        <?php }  ?>
                                                            
                                    
                                    </div>
                                    </div>
                        		</div>
                    	        
                    	        
                    	        
                    	          
                    		    <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; ">
                    		    <div class="form-group">
                                                      <button type="submit" id="Buscar" name="Buscar" class="btn btn-success">Buscar</button>
                                                  
                                                          
                                    
                                </div>
                    		    </div>
                    		    </div>
                    		      
                    		        
                              
              </form>
                           




                  </div>
                </div>
              </div>
		    <!-- /page content -->
		
		<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>DOCUMENTOS <small>Contenido en el Cartón</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <table id="datatable-buttons" class="table table-striped table-bordered">
              <thead>
                        
                        <tr>
                            <th>CARTÓN: <?php if ($resultSet !="") {  echo $res->numero_carton_documentos; }?></th>
            	    		
                         </tr>
                        
                        <tr>
                            <th>Id</th>
            	    		<th>Fecha del Documento</th>
            	    		<th>Categoría</th>
            	    		<th>Subcategoría</th>
            	    		<th>Tipo Documentos</th>
            	    		<th>RUC Cliente/Proveedor</th>
            	    		<th>Nombre Cliente/Proveedor</th>
            	    		<th>Número Documento</th>
            	    		<th>Número Cheque</th>
            	    		<th>Páginas </th>
            	    		
            	    		<th></th>
            	    		
                         </tr>
                      </thead>


                      <tbody>
    					
    						<?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
            	        		<tr>
            			           <td> <?php echo $res->id_documentos_legal; ?>  </td>
            	                   <td> <?php echo $res->fecha_documentos_legal; ?>  </td>
            		               <td> <?php echo $res->nombre_categorias; ?>     </td> 
            		               <td> <?php echo $res->nombre_subcategorias; ?>  </td>
            		               <td> <?php echo $res->nombre_tipo_documentos; ?>     </td>
            		               <td> <?php echo $res->ruc_cliente_proveedor; ?>     </td>
            		               <td> <?php echo $res->nombre_cliente_proveedor; ?>     </td>
            		               <?php $numero_carton_documentos =  $res->numero_carton_documentos; ?>     
            		    	       <td> <?php echo $res->numero_credito_documentos_legal; ?>     </td>
            		    	       <td> <?php echo $res->cheque_documentos_legal; ?>     </td>
            		    	       <td> <?php echo $res->paginas_documentos_legal; ?>     </td>
            		    	       
            		            		 <?php  $paginas = $paginas + $res->paginas_documentos_legal;  ?>
            		                     <?php  $registros = $registros + 1 ; ?>
            		    
            		                 <td>
            			           		<div class="right">
            			            
            			                   <?php  if ($_SESSION["tipo_usuario"]=="usuario_local") {  ?>
                			            		 <a href=" <?php echo IP_INT . $res->id_documentos_legal; ?>  " class="btn btn-warning" target="blank" style="font-size:65%;">Ver</a>
                			            	<?php } else {?>
                			            		 <a href="<?php echo IP_EXT . $res->id_documentos_legal; ?>  " class="btn btn-warning" target="blank" style="font-size:65%;">Ver</a> 
                			            	<?php }?>
            			                    
            			                </div>
            			            
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


