<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Simulador - Creditos</title>

		
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
         <li class="active">Simulador</li>
         </ol>
         </section>
         
         
         
         
         
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Simulador<small>Creditos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

				<form id="frm_solicitudes" action="<?php echo $helper->url("CreditosSimulador","Index"); ?>" method="post" class="col-lg-12 col-md-12 col-xs-12">      
   		 				
   		 				 <div class="box-body">
   		 				 <div class="row">
          		<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="cedula_participes" class="control-label">Cedula:</label>
                    	<input type="text" readonly="readonly" class="form-control" id="cedula_participes" name="cedula_participes" placeholder="C.I." value="<?php echo $cedula[0]?>">
                        <input type="hidden" name="id_solicitud_prestaciones" id="id_solicitud_prestaciones" value="0" />
                        <div id="mensaje_cedula_participes" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="nombres_solicitud_prestaciones" class="control-label">Nombres:</label>
                    	<input type="text" readonly="readonly" class="form-control" id="nombres_solicitud_prestaciones" name="nombres_solicitud_prestaciones" placeholder="Nombres" value="<?php echo $nombres[0]?>">
                        <div id="mensaje_nombres_solicitud_prestaciones" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="apellidos_solicitud_prestaciones" class="control-label">Apellidos:</label>
                    	<input type="text" readonly="readonly" class="form-control" id="apellidos_solicitud_prestaciones" name="apellidos_solicitud_prestaciones" placeholder="Apellidos" >
                        <div id="mensaje_apellidos_solicitud_prestaciones" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="apellidos_solicitud_prestaciones" class="control-label">Fecha de Nacimiento:</label>
                    	<input type="text" readonly="readonly" class="form-control" id="apellidos_solicitud_prestaciones" name="apellidos_solicitud_prestaciones" placeholder="Fecha" >
                        <div id="mensaje_apellidos_solicitud_prestaciones" class="errores"></div>
                 	</div>
             	</div>
          	</div> 
          
          
           <div class="row">
          		<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="cedula_participes" class="control-label">Cuenta Individual:</label>
                    	<input type="text" readonly="readonly" class="form-control" id="cedula_participes" name="cedula_participes" placeholder="C.I." value="<?php echo $cedula[0]?>">
                        <input type="hidden" name="id_solicitud_prestaciones" id="id_solicitud_prestaciones" value="0" />
                        <div id="mensaje_cedula_participes" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="nombres_solicitud_prestaciones" class="control-label">Capital de Créditos:</label>
                    	<input type="text" readonly="readonly" class="form-control" id="nombres_solicitud_prestaciones" name="nombres_solicitud_prestaciones" placeholder="Nombres" value="<?php echo $nombres[0]?>">
                        <div id="mensaje_nombres_solicitud_prestaciones" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="apellidos_solicitud_prestaciones" class="control-label">Disponible:</label>
                    	<input type="text"  readonly="readonly" class="form-control" id="apellidos_solicitud_prestaciones" name="apellidos_solicitud_prestaciones" placeholder="Apellidos" >
                        <div id="mensaje_apellidos_solicitud_prestaciones" class="errores"></div>
                 	</div>
             	</div>
             	
          	</div> 
          	
          	<div class="row">
          		<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="tipo_credito" class="control-label">Tipo Crédito:</label>
                    	<select name="tipo_credito" id="tipo_credito"  class="form-control">
                                      <option value="" selected="selected">--Seleccione--</option>
                                      <option value=9 >ORDINARIO</option>
                                      <option value=12>EMERGENTE</option>
    					</select> 
                        <div id="mensaje_tipo_credito" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="monto_credito" class="control-label">Monto Crédito:</label>
              			<input type=number step=10 class="form-control" id="monto_credito" name="monto_credito"">
                        <div id="mensaje_monto_credito" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
                		<label for="fecha_permiso" class="control-label">Fecha de Corte:</label>
                    	<input type="date"  class="form-control" id="fecha_corte" name="fecha_corte" placeholder="Fecha">
                        <div id="mensaje_fecha" class="errores"></div>
                 	</div>
             	</div>
             	<div class="col-xs-6 col-md-3 col-lg-3 ">
            		<div class="form-group">
            			<div id="select_cuotas"></div>
                 	</div>
             	</div>
          	</div>
          	
          	
                         </div>   		  
                        			</div>	
							    
								   
						            		        
                           		 <div class="row">
    			     <div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
				  	    <div class="form-group">
    	                  <button type="submit" id="Guardar" name="Guardar" value=""   class="btn btn-success" style="margin-top: 10px;"><i class="glyphicon glyphicon-edit"></i> Simular</button>         
					   
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
	
	
  </body>
</html>   