<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Educación Financiera - Capremci</title>

	 
 
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
            
              <link rel="stylesheet" href="view/AdminLTE-2.4.2/plugins/iCheck/all.css">
           
       		<script src="view/input-mask/jquery.inputmask.js"></script>
			<script src="view/input-mask/jquery.inputmask.date.extensions.js"></script>
			<script src="view/input-mask/jquery.inputmask.extensions.js"></script>
        
    
       
      
       <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#generar").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var respuesta_pregunta_1 = $("#respuesta_pregunta_1").val();
		    	var respuesta_pregunta_2 = $("#respuesta_pregunta_2").val();
		    	var respuesta_pregunta_3 = $("#respuesta_pregunta_3").val();
		    	var respuesta_pregunta_4 = $("#respuesta_pregunta_4").val();
		    	

				
    	        if($("#respuesta_pregunta_1").is(':checked') || $("#respuesta_pregunta_11").is(':checked')) {  
	
    	        } else {  

    	        	swal("Alerta!", "Conteste Pregunta 1", "error")
                    return false;
    	        		
    	        }  


    	        
    	        if($("#respuesta_pregunta_2").is(':checked') || $("#respuesta_pregunta_22").is(':checked')) {  
	
    	        } else {  

    	        	swal("Alerta!", "Conteste Pregunta 2", "error")
	        		 return false;
	        	
    	        } 

    	        if($("#respuesta_pregunta_3").is(':checked') || $("#respuesta_pregunta_33").is(':checked')) {  
	
    	        } else {  

    	        	swal("Alerta!", "Conteste Pregunta 3", "error")
	        		 return false;
    	        } 


    	        if($("#respuesta_pregunta_4").is(':checked') || $("#respuesta_pregunta_44").is(':checked')) {  
    
    	        } else {  

    	        	swal("Alerta!", "Conteste Pregunta 4", "error")
	        		 return false;
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
         <li class="active">Educación Financiera</li>
         </ol>
         </section>
       
  
 
      
  
		
		<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Encuesta<small>Educación Financiera</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
          
         
          
      <div class="col-lg-12 col-md-12 col-xs-12">
      <div class="col-lg-7 col-md-7 col-xs-12">
       		<iframe id="reproducir_video" width="100%" height="500px"></iframe>
      </div>
      <div class="col-lg-5 col-md-5 col-xs-12">
       
       <div id="encuesta" style="display:none;">
       
       <form  action="<?php echo $helper->url("EducacionFinanciera","InsertaEducacionFinanciera"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
           
           
      
          <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-user'></i> Encuesta Educación Financiera</h4>
	         </div>
	         <div class="panel-body">
			 
			         
           
			 
			 <div class="row">
			 	<label  class="control-label"><?php echo $pregunta_1;?></label>
			    <input type="hidden" id="pregunta_1" name="pregunta_1" value="<?php echo $id_pregunta_1;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-2 col-md-2 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_1" name="respuesta_pregunta_1" value="TRUE" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-2 col-md-2 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_11" name="respuesta_pregunta_1" value="FALSE" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
			              
		          </div>        
	                
	            </div>
              </div>
			 
			 
           
           
               <div class="row">
			 	<label class="control-label"><?php echo $pregunta_2;?></label>
			     <input type="hidden" id="pregunta_2" name="pregunta_2" value="<?php echo $id_pregunta_2;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 25px;">
				  <div class="row">
				  
				           <div class="col-lg-2 col-md-2 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_2" name="respuesta_pregunta_2" value="TRUE" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-2 col-md-2 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_22" name="respuesta_pregunta_2" value="FALSE" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
			                
			               
		          </div>        
	                    
	                    
	             
	            </div>
              </div>
           
           
            
            
            
            
               <div class="row">
			 	<label value="<?php echo $id_pregunta_3;?>" class="control-label"><?php echo $pregunta_3;?></label>
			    <input type="hidden" id="pregunta_3" name="pregunta_3" value="<?php echo $id_pregunta_3;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 25px;">
				  <div class="row">
				  
				           <div class="col-lg-2 col-md-2 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_3" name="respuesta_pregunta_3" value="TRUE" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-2 col-md-2 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_33" name="respuesta_pregunta_3" value="FALSE" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
			                
		          </div>        
	                    
	              
	            </div>
              </div>
        
              
           
           
           
              <div class="row">
			 	<label class="control-label"><?php echo $pregunta_4;?></label>
			     <input type="hidden" id="pregunta_4" name="pregunta_4" value="<?php echo $id_pregunta_4;?>">
			     <div class="col-lg-12 col-md-12 col-xs-12" style="margin-top: 15px;">
				  <div class="row">
				  
				           <div class="col-lg-2 col-md-2 col-xs-12">
				            <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_4" name="respuesta_pregunta_4" value="TRUE" class="flat-red">
			                  Si
			                </span>
			                </div>
			                </div>
			                
			                <div class="col-lg-2 col-md-2 col-xs-12">
			                <div class="form-group">
			                <span>
			                  <input type="radio" id="respuesta_pregunta_44" name="respuesta_pregunta_4" value="FALSE" class="flat-red">
			                  No
			                </span>
			                </div>
			                </div>
			                
		          </div>        
	                    
	                
	            </div>
              </div>
        
           
			  			<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
				  		 <button type="submit" id="generar" name="generar" value=""   class="btn btn-success" style="margin-top: 10px;"><i class="glyphicon glyphicon-edit"></i> Registrar Encuesta</button>         
					    </div>
  			
  		</div></div>	
         
      
      
       </form>
          
      </div>    
          
           
      </div>
      
  </div>
         
         
      
			      </div>
			    </div>

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
	<script src="view/js/jquery.inputmask.bundle.js"></script>
	<!-- codigo de las funciones -->

<script src="view/AdminLTE-2.4.2/plugins/iCheck/icheck.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
  $(function () {

 $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    
    })
</script>

<script type="text/javascript">
	
	  $(document).ready( function (){

		  	video();
		  
			});


		
	function video(){

			    imgficha = 'view/images/educacion financiera modulo 1.mp4';

		        $("#reproducir_video").attr({'src':imgficha});
	}
	
	//setInterval(video, 10);
	
	</script>


<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $("#encuesta").fadeIn(1500);
    },280000);
});
</script>


	
  </body>
</html>   