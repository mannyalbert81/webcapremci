<!DOCTYPE html>
<html lang="en">
  <head>
  	
		<link rel="stylesheet" href="view/css/estilos.css">
		<link rel="stylesheet" href="view/vendors/table-sorter/themes/blue/style.css">
			<link href="view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    	    <link href="view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		    <link href="view/vendors/nprogress/nprogress.css" rel="stylesheet">
		    <link href="view/build/css/custom.min.css" rel="stylesheet">
		    <link href="view/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
	
			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
			<script type="text/javascript" src="view/vendors/table-sorter/jquery.tablesorter.js"></script> 
        <script src="view/js/jquery.blockUI.js"></script>
    
    
    
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
    
    
    
	   
	   <style type="text/css">
		   
		   #dg {
				padding-bottom: 30px;
				text-align: center;
			}

			#dg h4 {
				font-weight: 700;
			}

			.tilt {
			  -webkit-transition: all 0.5s ease;
				 -moz-transition: all 0.5s ease;
				   -o-transition: all 0.5s ease;
				  -ms-transition: all 0.5s ease;
					  transition: all 0.5s ease;
			}
			 
			.tilt:hover {
			  -webkit-transform: rotate(-10deg);
				 -moz-transform: rotate(-10deg);
				   -o-transform: rotate(-10deg);
				  -ms-transform: rotate(-10deg);
					  transform: rotate(-10deg);
			}

	   </style>
	   
   
    
  </head>

  <body class="nav-md">
  
  
        <?php
        
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        ?>
  
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <?php include("view/modulos/logo.php"); ?>

            <div class="clearfix"></div>
			<?php include("view/modulos/menu_profile.php"); ?>

            <br />
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
         <li class="active">Información</li>
         </ol>
         </section>
        
         <div class="col-lg-12 col-md-12 col-xs-12">
          <div id="dg">
          	<h4>DESCARGATE NUESTRO APLICATIVO MÓVIL</h4>
		    <div class="row" style="margin-top: 30px;">
				
				<div class="col-lg-4 col-md-4 col-xs-12">
					<div class="tilt">
					<a href="https://play.google.com/store/apps/details?id=jcaprem.com" target="_blank"><img src="view/images/p01.png" alt=""></a>
					</div>
					ANDROID (Disponible en Google Play)
				</div>

				<div class="col-lg-4 col-md-4 col-xs-12">
					<div class="tilt">
					<a href="#"><img src="view/images/p03.png" alt=""></a>
					</div>
					IOS (Proximamente)
				</div>

				<div class="col-lg-4 col-md-4 col-xs-12">
					<div class="tilt">
					<a href="#"><img src="view/images/p02.png" alt=""></a>
					</div>
					WINDOWS PHONE (Proximamente)
				</div>
				
			</div>
		  </div>
         </div> 
          
          
          
          
        <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
           
		    <div id="dg">
            	<h4>RECOMIENDANOS UNA NUEVA AFILIACIÓN</h4>
            </div>     
             <p align="justify"><h5>Estimado Participe, incorporamos en nuestro sistema un formulario de afiliación, ya puedes recomendarnos una persona que forme parte de las Fuerzas Armadas, que este interesada en formar parte de CAPREMCI, ingresa los datos de la nueva persona y nosotros nos pondremos en contacto con tu recomendado.</h5></p>
            
            <section>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="margin-top: 15px;">
                        <div class="row" style="text-align: center;">
                            <div class="col-xs-12 col-sm-3 col-md-12 col-lg-12">
                                <img src="view/images/reco_afi_1.png" style="width: 100%; text-align: center;" class="img-responsive">
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="margin-top: 15px;">
                        <div class="row" style="text-align: center;">
                            <div class="col-xs-12 col-sm-3 col-md-12 col-lg-12">
                                <img src="view/images/reco_afi_2.png" style="width: 100%; text-align: center;" class="img-responsive">
                            </div>
                           
                        </div>
                    </div>
				</div>
            </section>
            
            
                      
        </div>
          
          
          
          
        <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 30px;">
            <div id="dg">
            	<h4>CONOCE NUESTROS CONVENIOS</h4>
            </div>     
              <p align="justify"><h5>Aprovecha nuestros convenios, hacercate a una de sus sucursales mas cercana y recibe exelentes descuentos, para poder adquirirlos solo basta con llevar tu cédula de identidad.</h5></p>
                           
          <section>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="margin-top: 15px;">
                        <div class="row" style="text-align: center;">
                            <div class="col-xs-12 col-sm-3 col-md-12 col-lg-12">
                                <img src="view/images/metrooptica.jpg" style="width: 100%; text-align: center;" class="img-responsive">
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="margin-top: 15px;">
                        <div class="row" style="text-align: center;">
                            <div class="col-xs-12 col-sm-3 col-md-12 col-lg-12">
                                <img src="view/images/bliss_spa.jpg" style="width: 100%; text-align: center;" class="img-responsive">
                            </div>
                           
                        </div>
                    </div>
                     <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style="margin-top: 15px;">
                        <div class="row" style="text-align: center;">
                            <div class="col-xs-12 col-sm-3 col-md-12 col-lg-12">
                                <img src="view/images/multilimpio.jpg" style="width: 100%; text-align: center;" class="img-responsive">
                            </div>
                           
                        </div>
                    </div>
                </div>
            </section>
         <br><br><br>
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
	
	<!-- codigo de las funciones -->
	
      
  </body>
</html>
