<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Solicitud Valor Aportación - Capremci</title>

	 
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
            
            <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
		
			<script>
			    //webshims.activeLang("en");
			    webshims.setOptions('forms-ext', { datepicker: { dateFormat: 'yy/mm/dd' } });
				webshims.polyfill('forms forms-ext');
			</script>
           
           
			
			
			
			     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>  
		         <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			
        
    	
       
       
        <script type="text/javascript">

            enviando = false; //Obligaremos a entrar el if en el primer submit
            
            function checkSubmit() {
                if (!enviando) {
            		enviando= true;
            		return true;
                } else {
                    //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                   
                  
                    return false;
                }
            }
        
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
           
    	<div class="container">
        <section class="content-header">
         <small><?php echo $fecha; ?></small>
         <ol class=" pull-right breadcrumb">
         <li><a href="<?php echo $helper->url("Usuarios","Bienvenida"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Solicitud Préstamo</li>
         </ol>
         </section>
         
          <section id="pnl_main" class="">
         
         	 <div class="x_panel">
                  <div class="x_title">
                    <h2> Generar Solicitud <small>Aportaciones</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
           
          			<form  action="<?php echo $helper->url("SolicitudValorPrestaciones","index"); ?>" method="post"  class="">
           
                     <div class="col-lg-6 col-md-6 col-xs-12">
                     	<div class="panel panel-info">
        	         		<div class="panel-heading">
        	         			<h4><i class="fa fa-briefcase" aria-hidden="true"></i> Solicitud </h4>
        	         		</div>
        	         		<div class="panel-body">			 
    			  				<div class="row">
    			  					<h4 class="center" id="msgGenerar"> </h4>
    			  					<div class="text-center">
                                      <img src="view/images/deudor.jpg" class="rounded" alt="..." style="text-align:center;  width: 50%;">
                                    </div>
    			  					<!-- <p style="text-align: center;"><strong>Estimado participe usted ya cuenta con una solicitud de préstamo generada.</strong></p> -->  
    			           
                                     <div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 30px">
                                     	<button class="btn btn-success" id="btnContinuarSolicitud"> <i class="fa fa-share" aria-hidden="true"></i> Continuar </button>
            				  		 </div>	  		 
    				  		 	
                       
             	  				</div>         	  
             	  			</div>
  			  			</div>
  			  		</div>
           
                     <div class="col-lg-6 col-md-6 col-xs-12">
          			 	<div class="panel panel-info">
        	         		<div class="panel-heading">
        	         			<h4><i class="fa fa-list-alt" aria-hidden="true"></i> Lista Solicitudes</h4>
        	         		</div>
            	         	<div class="panel-body">
            			  		<div class="row">
            			  			<h4 class="center" id="msgConsulta"> </h4>
            			  			<div class="text-center">
                                      <img src="view/images/deudor.jpg" class="rounded" alt="..." style="text-align:center;  width: 50%;">
                                    </div>    			  						
    			  					<!-- <p style="text-align: center;"><strong>Estimado participe usted ya cuenta con una solicitud de garantía generada.</strong></p> -->
    			  					<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 30px">
    			  						<button class="btn btn-info" id="btnVerSolicitud"> <i class="fa fa-columns" aria-hidden="true"></i> Ver Solicitudes </button>            				  			
            				  		</div>	
             	  				</div>
             	  
             	  			</div>
  			  			</div>
  			  		</div>
   				   </form>
		      </div>
		    </div>        
         </section>
         
         <section class="">
         
         	 <div class="x_panel">
                 <div class="x_title">
                    <h2 class="text-info">Estado actual Aportaciones</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                 </div>
                 <div class="x_content">          
    		    
        		    <div class="row">
          			 	<input type="hidden" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php echo $_SESSION["cedula_usuarios"]?>" /> 
        				<div id="aporte_actual_participes"></div>
          			 
          		 	</div>
      			 
	      		 </div>
	      	</div>
        
         </section>
         
         <section class="">
         
         	 <div class="x_panel">
                  <div class="x_title">
                    <h2>Solicitud<small>Aportación</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
           
      				<div class="row">
                        <div class="col-xs-6 col-md-3 col-lg-3 ">
                    		<div class="form-group">
                        		<label for="cedula_participes" class="control-label">Cedula:</label>
                            	<input type="text" readonly="readonly" class="form-control" id="cedula_participes" name="cedula_participes" placeholder="C.I." value="<?php echo $cedula[0]?>">
                                <input type="hidden" name="id_solicitud_prestaciones" id="id_solicitud_prestaciones" value="0" />
                                <div id="mensaje_cedula_participes" class="errores"></div>
                         	</div>
                     	</div>
                     	
              			<div class="col-xs-12 col-md-3 col-md-3 ">
                		    <div class="form-group">
                		    					  
                              <label for="id_tipo_aportaciones" class="control-label">Tipo Aportaciones:</label>
                              <select  class="form-control" id="id_tipo_aportaciones" name="id_tipo_aportaciones" onchange="CambiaTipoAporte(this)">                              
                              </select>                         
                              <div id="mensaje_id_tipo_aportaciones" class="errores"></div>
                            </div>
                    	</div>
                    	
                    	<div class="col-xs-6 col-md-3 col-lg-3 ">
                    		<div class="form-group">
                        		<label for="valor_solicitud_aportaciones" class="control-label">Valor Contribución:</label>
                            	<input type="text" class="form-control" id="valor_solicitud_aportaciones" name="valor_solicitud_aportaciones" placeholder="valor">
                                <div id="mensaje_nombres_solicitud_prestaciones" class="errores"></div>
                         	</div>
                     	</div>
             	
                     	<div class="col-xs-6 col-md-3 col-lg-3 ">
                     	
                     	    <div class="form-group">                		    					  
                              <label for="valor_porcentaje_solicitud_aportaciones" class="control-label">Tipo Aportaciones:</label>
                              <select  class="form-control" id="valor_porcentaje_solicitud_aportaciones" name="valor_porcentaje_solicitud_aportaciones" > 
                                <option value="0">--Seleccione--</option>
                              	<option value="9.1"> 9.1% </option>
                              	<option value="7"> 7%</option>                             
                              </select>                         
                              <div id="mensaje_id_tipo_aportaciones" class="errores"></div>
                            </div>
                     	
                    		
                     	</div>
      			 	</div>
      			 
      			 <div class="row">
      			 
          			 <div class="col-xs-6 col-md-6 col-lg-6 ">
                		<div class="form-group">
                    		<label for="razon_solicitud_prestaciones" class="control-label">Observación (Ingrese una Razon):</label>
                        	<input type="text" class="form-control" id="razon_solicitud_prestaciones" name="razon_solicitud_prestaciones" placeholder="razon">
                            <div id="mensaje_nombres_solicitud_prestaciones" class="errores"></div>
                     	</div>
                 	</div>
          			
          			  			 
      			 </div>
      			 
      			 <div class="row">
    			     <div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
				  	    <div class="form-group">
    	                  <button  id="btnGuardarSolicitud" name="btnGuardarSolicitud" value=""   class="btn btn-success" onclick="RegistraSolicitud()" ><i class="glyphicon glyphicon-edit"></i> Registrar Solicitud</button>         
					   
	                    </div>
	                    
        		    </div> 	    
    		    </div>
    		   
	      		</div>
	      	</div>
        
         </section>
         
         
 
	</div>
	</div>
	</div>
	</div>
	    
    
    
    
    
     <!-- Bootstrap -->
    <script src="view/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
   
    <!-- Custom Theme Scripts -->
    <script src="view/build/js/custom.min.js"></script>

	<!-- codigo de las funciones -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script> -->
    <script src="view/js/notificaciones/notify.js"></script>
    <script src="view/js/swalAlert.js"></script>	
	<script src="view/js/BuscarParticipes.js?1.30"></script>
  </body>
</html>   