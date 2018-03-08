<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Usuarios - aDocument 2015</title>

		
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
            <?php
       $sel_menu = "";
       
    
       if($_SERVER['REQUEST_METHOD']=='POST' )
       {
       	 
       	 
       	$sel_menu=$_POST['criterio'];
       	
       	 
       }
      
	 	?>
    <div class="container">
  
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>INSERTAR<small>Usuarios</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


            <form id="form-usuarios" action="<?php echo $helper->url("Usuarios","Actualiza"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                                <?php if ($resultEdit !="" ) { foreach($resultEdit as $resEdit) {?>
                                
                                <div class="row">
                        		    <div class="col-xs-6 col-md-4 col-md-4 ">
                        		    <div class="form-group">
                                                          <label for="nombre_usuario" class="control-label">Nombres Usuario</label>
                                                          <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $resEdit->nombre_usuario; ?>"  placeholder="Nombres">
                                                          <span class="help-block"></span>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-6 col-md-2 col-md-2">
                        		    <div class="form-group">
                                                          <label for="usuario_usuario" class="control-label">Usuario</label>
                                                          <input type="text" class="form-control" id="usuario_usuario" name="usuario_usuario" value="<?php echo $resEdit->usuario_usuario; ?>"  placeholder="Usuario">
                                                          <span class="help-block"></span>
                                    </div>
                                    </div>
                        			
                        			
                        			<div class="col-xs-6 col-md-2 col-md-2">
                        		    <div class="form-group">
                                                          <label for="clave_usuario" class="control-label">Password</label>
                                                          <input type="password" class="form-control" id="clave_usuario" name="clave_usuario" value=""  placeholder="Password">
                                                          <span class="help-block"></span>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-6 col-md-2 col-md-2">
                        		    <div class="form-group">
                                                          <label for="clave_usuario_r" class="control-label">Repita Password</label>
                                                          <input type="password" class="form-control" id="clave_usuario_r" name="clave_usuario_r" value=""  placeholder="Repita Password">
                                                          <span class="help-block"></span>
                                    </div>
                                    </div>
                        			
                        			
                        			<div class="col-xs-6 col-md-2 col-md-2">
                            		    <div class="form-group">
                                                              <label for="telefono_usuario" class="control-label">Teléfono Usuario</label>
                                                              <input type="text" class="form-control" id="telefono_usuario" name="telefono_usuario" value="<?php echo $resEdit->telefono_usuario; ?>"  placeholder="Teléfono">
                                                              <span class="help-block"></span>
                                        </div>
                            		</div>
                            		    	
                    			
                    			
                    			
                    			</div>
                    			
                                <div class="row">
                    		    
                        		    <div class="col-xs-6 col-md-2 col-md-2">
                        		    <div class="form-group">
                                                          <label for="celular_usuario" class="control-label">Celular Usuario</label>
                                                          <input type="text" class="form-control" id="celular_usuario" name="celular_usuario" value="<?php echo $resEdit->celular_usuario; ?>"  placeholder="Celular">
                                                          <span class="help-block"></span>
                                    </div>
                                    </div>
                        		    <div class="col-xs-6 col-md-4 col-md-4">
                        		    <div class="form-group">
                                                          <label for="correo_usuario" class="control-label">Correo Usuario</label>
                                                          <input type="text" class="form-control" id="correo_usuario" name="correo_usuario" value="<?php echo $resEdit->correo_usuario; ?>"  placeholder="Correo">
                                                          <span class="help-block"></span>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-xs-6 col-md-3 col-md-3">
                        		   <div class="form-group">
                                                          <label for="id_rol" class="control-label">Rol </label>
                                                          <select name="id_rol" id="id_rol"  class="form-control" >
                                                          <option value="" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultRol as $res) {?>
                        										<option value="<?php echo $res->id_rol; ?>" <?php if ($res->id_rol == $resEdit->id_rol )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_rol; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <span class="help-block"></span>
                                    </div>
                                    </div>
                                    
                                    <div class="col-xs-6 col-md-3 col-md-3">
                        		   <div class="form-group">
                                                          <label for="id_estado" class="control-label">Estado </label>
                                                          <select name="id_estado" id="id_estado"  class="form-control" >
                                                          <option value="" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEst as $res) {?>
                        										<option value="<?php echo $res->id_estado; ?>" <?php if ($res->id_estado == $resEdit->id_estado )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_estado; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <span class="help-block"></span>
                                    </div>
                                    </div>
                    			</div>
                                
                                
                    		     <?php } } else {?>
                    		    
                    		   
									                    		   
                    		   
                    		     <div class="row">
                    		    
                    		    
                    		
                    		    
                    		    
                    		    <div class="col-lg-4 col-xs-6 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre_usuario" class="control-label">Nombres Usuario</label>
                                                      <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="" required="required" placeholder="Nombres">
                                                      <span class="help-block"></span>
                                </div>
                                
                                
                    		    </div>
                    		    
                    		    <div class="col-lg-2 col-xs-6 col-md-2">
                    		    <div class="form-group">
                                                      <label for="usuario_usuario" class="control-label">Usuario</label>
                                                      <input type="text" class="form-control" id="usuario_usuario" name="usuario_usuario" value=""  required="required" placeholder="Usuario">
                                                      <span class="help-block"></span>
                                </div>
                                </div>
                    			
                    			
                    				 <div class="col-lg-2 col-xs-6 col-md-2">
                        		    <div class="form-group">
                                                          <label for="clave_usuario" class="control-label">Password</label>
                                                          <input type="password" class="form-control" id="clave_usuario" name="clave_usuario" value="" required="required"  placeholder="Password">
                                                          <span class="help-block"></span>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-lg-2 col-xs-6 col-md-2">
                        		    <div class="form-group">
                                                          <label for="clave_usuario_r" class="control-label">Repita Password</label>
                                                          <input type="password" class="form-control" id="clave_usuario_r" name="clave_usuario_r" value="" required="required"  placeholder="Repita Password">
                                                          <span class="help-block"></span>
                                    </div>
                                    </div>
                    			
                    			
                    				 <div class="col-lg-2 col-xs-6 col-md-2">
                            		    <div class="form-group">
                                                              <label for="telefono_usuario" class="control-label">Teléfono Usuario</label>
                                                              <input type="text" class="form-control" id="telefono_usuario" name="telefono_usuario" value=""  placeholder="Teléfono">
                                                              <span class="help-block"></span>
                                        </div>
                            		    </div>
                            		    
                            		    
                    				
                    			</div>
                    			
                               
                    			
                    			<div class="row">
                        			<div class="col-lg-2 col-xs-6 col-md-2">
                                		    <div class="form-group">
                                                                  <label for="celular_usuario" class="control-label">Celular Usuario</label>
                                                                  <input type="text" class="form-control" id="celular_usuario" name="celular_usuario" value=""  placeholder="Celular">
                                                                  <span class="help-block"></span>
                                            </div>
                                    </div>
                        		    <div class="col-lg-4 col-xs-6 col-md-4">
                        		    <div class="form-group">
                                                          <label for="correo_usuario" class="control-label">Correo Usuario</label>
                                                          <input type="text" class="form-control" id="correo_usuario" name="correo_usuario" value=""  required="required" placeholder="Correo">
                                                          <span class="help-block"></span>
                                    </div>
                        		    </div>
                        		    
                        		    <div class="col-lg-3 col-xs-6 col-md-3">
                        		   <div class="form-group">
                                                          <label for="id_rol" class="control-label">Rol </label>
                                                          <select name="id_rol" id="id_rol"  class="form-control" >
                                                          <option value="" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultRol as $res) {?>
                        										<option value="<?php echo $res->id_rol; ?>" ><?php echo $res->nombre_rol; ?> </option>
                        							    
                        							        <?php } ?>
                        								   </select> 
                                                          <span class="help-block"></span>
                                    </div>
                                    
                                    </div>
                                    
                                    <div class="col-lg-3 col-xs-6 col-md-3">
                        		   <div class="form-group">
                                                          <label for="id_estado" class="control-label">Estado </label>
                                                          <select name="id_estado" id="id_estado"  class="form-control" >
                                                          <option value="" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEst as $res) {?>
                        										<option value="<?php echo $res->id_estado; ?>"><?php echo $res->nombre_estado; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <span class="help-block"></span>
                                    </div>
                                    </div>
                                
                                
                                </div>
                    	           	
                    		     <?php } ?>
                    		      
                    		    <div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; ">
                    		    <div class="form-group">
                                                      <button type="submit" id="Guardar" name="Guardar" class="btn btn-success">Guardar</button>
                                </div>
                    		    </div>
                    		    </div>
                    		      
                    		        
                              
              </form>
                           




                  </div>
                </div>
              </div>
		
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
      
        <!-- /page content -->
		
				
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

