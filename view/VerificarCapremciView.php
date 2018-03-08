<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Usuarios - aDocument 2017</title>

		
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
                    <h2>BUSCADOR<small>Clientes Capremci</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


            <form id="formularioPrincipal" action="<?php echo $helper->url("VerificarCapremci","index"); ?>" method="post" class="form-horizontal" class="col-xs-12 col-md-12 col-md-12 " >
                                
                                   <div class="row">
                        		    <div class="col-xs-6 col-md-3 col-md-3 ">
                        		    <div class="form-group">
                                                          <label for="nombre_usuario" class="control-label">Número Crédito</label>
                                                          <input type="number"  name="numero_credito" id="numero_credito" value="" class="form-control "/>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-6 col-md-3 col-md-3">
                        		    <div class="form-group">
                                                          <label for="usuario_usuario" class="control-label">Identificación</label>
                                                          <input type="text"  name="cedula_capremci" id="cedula_capremci" value="" class="form-control "/>
                                                          
                                    </div>
                                    </div>
                        			
                        			
                        			<div class="col-xs-6 col-md-4 col-md-4">
                        		    <div class="form-group">
                                                          <label for="clave_usuario" class="control-label">Nombres</label>
                                                          <input type="text"  name="nombres_capremci" id="nombres_capremci" value="" class="form-control "/>
                                                          <span class="help-block"></span>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-6 col-md-2 col-md-2">
                        		    <div class="form-group">
                                                          <label for="clave_usuario_r" class="control-label">Repita Password</label>
                                                          <select name="tipo_credito_capremci" id="tipo_credito_capremci"  class="form-control" >
                                            			  		<option value=""><?php echo "--TODOS--";  ?> </option>
                                            					<?php foreach($resultTipCred as $res) {?>
                                            						<option value="<?php echo $res->tipo_credito_capremci; ?>"><?php echo $res->tipo_credito_capremci;  ?> </option>
                                            			        <?php } ?>
                                            				</select>
                                                          
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
                    <h2>LISTADO<small>Clientes Capremci</small></h2>
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
                          <th>Número de Crédito</th>
                          <th>Identificación</th>
                          <th>Nombres y Apellidos</th>
                          <th>Recibido</th>
                          <th>Monto</th>
                          <th>Tipo Crédito</th>
                          <th>Fecha de Ingreso</th>
                          <th>Fecha Conseción</th>
                          
                          
                        </tr>
                      </thead>




                      <tbody>
    					
    						<?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
            	        		<tr>
            	        		
            	                   <td > <?php echo $res->numero_credito; ?>  </td>
            		               <td > <?php echo $res->cedula_capremci; ?>     </td> 
            		               <td > <?php echo $res->nombres_capremci; ?>  </td>
            		               <td > <?php echo $res->recibido_capremci; ?>  </td>
            		               <td > <?php echo $res->monto_capremci; ?>  </td>
            		               <td > <?php echo $res->tipo_credito_capremci; ?>  </td>
            		               <td > <?php echo $res->fecha_ingreso_capremci; ?>  </td>
            		               <td > <?php echo $res->fecha_consecion_capremci; ?>  </td>
            		           	   
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
























