<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Actualizar Documentos - aDocument 2017</title>

		
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
        <div class="col-md-3 left_col  menu_fixed">">
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
   
		   $sel_id_documentos_legal = "";
		   
		   if($_SERVER['REQUEST_METHOD']=='POST' )
		   {
		      $sel_id_documentos_legal = $_POST['id_documentos_legal'];
		   
		   }
		   
		?>
  
    <div class="container">
  
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>ACTUALIZAR<small>Documentos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


            <form id="form-usuarios" action="<?php echo $helper->url("Documentos","ActualizarDocumentos"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                                
					<div class="row">
                       <div class="col-xs-12 col-md-3 col-md-3 ">
                    	    <div class="form-group">
                                 <label for="id_documentos_legal" class="control-label">Id del Documento</label>
                                 <input type="text" name="id_documentos_legal" value="<?php echo $sel_id_documentos_legal;?>" class="form-control"/>
                                 <span class="help-block"></span>
                             </div>
                       </div>
                       <div class="col-xs-12 col-md-3 col-md-3">
                           		<div style="margin-top: 10%;">
                           			<?php if (!empty($resultSet))  { ?>
                		           		 <input type="submit"name="btnBorrar" value="Borrar" class="btn btn-danger"/> 
                		           <?php    } else {?>
                		           		<input type="submit"name="btnComprobar" value="Comprobar" class="btn btn-success"/> 
                		           
                		           <?php }?> 
                		           
                           		</div>
                           		
                           		
                           
                       </div>
                       
                   
                       <div class="col-xs-12 col-md-3 col-md-3 ">
                    	    <div class="form-group">
                                 <label for="ruc_cliente" class="control-label">Ruc-Ci Cliente</label>
                                 <input type="text" name="ruc_cliente_proveedor" value="" class="form-control"/>
                                 <span class="help-block"></span>
                             </div>
                       </div>
                       <div class="col-xs-12 col-md-3 col-md-3">
                           <div class="form-group">
                           		<label for="nombre_cliente" class="control-label">Nombre Cliente</label>
                   				<input type="text" name="nombre_cliente_proveedor" value="" class="form-control"/>            
                           </div>
                       </div>
                       
                   </div>
                   <div class="row">
                       <div class="col-xs-12 col-md-3 col-md-3 ">
                    	    <div class="form-group">
                                 <label for="numero_carton" class="control-label">Cartónn o Carpeta</label>
                                 <input type="text" name="numero_carton_documentos" value="" class="form-control"/>
                                 <span class="help-block"></span>
                             </div>
                       </div>
                       <div class="col-xs-12 col-md-3 col-md-3">
                           <div class="form-group">
                           		<label for="numero_documento" class="control-label">Número de Documento</label>
                   				<input type="text" name="numero_credito_documentos_legal" value="" class="form-control"/>            
                           </div>
                       </div>
                       
                   
                       <div class="col-xs-12 col-md-3 col-md-3 ">
                    	    <div class="form-group">
                                 <label for="monto_documento" class="control-label">Monto del Documento</label>
                                 <input type="number" name="monto_documentos_legal" value="" class="form-control"/> 
                                 <span class="help-block"></span>
                             </div>
                       </div>
                       <div class="col-xs-12 col-md-3 col-md-3">
                           <div class="form-group">
                           		<label for="tipo_documento" class="control-label">Tipo de Documento</label>
                   				<select name="id_tipo_documentos" id="id_tipo_documentos"  class="form-control" >
                            		<option value="0"  > --Seleccione--</option>
        				         	<?php foreach($resultTipoDocumentos as $res) {?>
        								<option value="<?php echo $res->id_tipo_documentos; ?>"><?php echo $res->nombre_tipo_documentos; ?> </option>
        						    <?php } ?>
            					</select>            
                           </div>
                       </div>
                       
                   </div>
                   
				   <div class="row">
                       <div class="col-xs-12 col-md-3 col-md-3 ">
                    	    <div class="form-group">
                                 <label for="fecha_documento" class="control-label">Fecha del Documento</label>
                                 <input type="date" name="fecha_documentos_legal" value="" class="form-control"/>
                                 <span class="help-block"></span>
                             </div>
                       </div>
                       <div class="col-xs-12 col-md-3 col-md-3">
                           <div class="form-group">
                           		<label for="estado_documento" class="control-label">Estado de Lectura</label>
                   				<select name="estado_lecturas" id="estado_lecturas"  class="form-control" >
            	                  <option value="TRUE"  > LEIDO</option>
            	                  <option value="FALSE"  > NO LEIDO</option>
            			   	    </select>            
                           </div>
                       </div>
                   	   <div class="col-xs-12 col-md-3 col-lg-3" style="text-align: center; ">
                       		<div class="form-group">
                             	<div style="margin-top: 10%;">
                             	<button type="submit" id="Guardar" name="Guardar" class="btn btn-success">Guardar</button>
                             	</div>
                            </div>
                       </div>	    
                   </div>
                   
                          
              </form>
            </div>
          </div>
       </div>

        <!-- /page content -->
		
		<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>LISTADO<small>Documento</small></h2>
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
                          <th>Subcatgoría</th>
                          <th>Tipo Documento</th>
                          <th>Ruc-Ci Cliente</th>
                          <th>Nombre Cliente</th>
                          <th>Fecha Documento</th>
                         
                        </tr>
                      </thead>


                      <tbody>
    					
    						<?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
            	        		<tr>
            
            				      <td > <?php echo $res->id_documentos_legal; ?>  </td>
                	              <td > <?php echo $res->nombre_subcategorias; ?>  </td>
                		          <td > <?php echo $res->nombre_tipo_documentos; ?>     </td> 
                		          <td > <?php echo $res->ruc_cliente_proveedor; ?>  </td>
                		          <td > <?php echo $res->nombre_cliente_proveedor; ?>  </td>
                		          <td > <?php echo date($res->fecha_documentos_legal); ?>  </td>
                		    	
            	                   
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
