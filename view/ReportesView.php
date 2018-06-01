<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Reportes - Capremci</title>

	
		
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
        
        
    
      
         <script type="text/javascript">
		$(document).ready(function(){

		 $("#buscar").click(function(){

			var tipo_reporte = $("#tipo_reporte").val();
	     	
	    	if (tipo_reporte == 0)
	    	{
		    	
	    		$("#mensaje_tipo_reporte").text("Seleccione");
	    		$("#mensaje_tipo_reporte").fadeIn("slow"); //Muestra mensaje de error
	            return false;
		    }
	    	else 
	    	{
	    		$("#mensaje_tipo_reporte").fadeOut("slow"); //Muestra mensaje de error
	    		
			}
	
			
			});

			$( "#tipo_reporte" ).focus(function() {
			$("#mensaje_tipo_reporte").fadeOut("slow");
			});
		
	
	});


		
	/* function load_Reportes(pagina){

		var con_datos={
				  buscar : 'buscar',
				  tipo_reporte: $('#tipo_reporte').val(),
				  action:'ajax',
				  page:pagina
				  };
		$("#matriz").fadeIn('slow');
		$.ajax({
			url:"<?php echo $helper->url("Reportes","index");?>",
            type : "POST",
            async: true,			
			data: con_datos,
			 beforeSend: function(objeto){
			$("#matriz").html('<img src="view/images/ajax-loader.gif"> Cargando...');
			},
			success:function(data){
				$(".div_matriz").html(data).fadeIn('slow');
				$("#matriz").html("");
			}
		})
	}*/
	
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
            <?php include("view/modulos/menu_profile.php"); ?>
            <br/>
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
         <li class="active">Reportes</li>
         </ol>
         </section>
       
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Reportes<small>CUBES ONE</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


            <form  action="<?php echo $helper->url("Reportes","index"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12" target="_blank">
                               
                               
             <div class="col-lg-12 col-md-12 col-xs-12">
	         <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-edit'></i> Filtrar Información</h4>
	         </div>
	         <div class="panel-body">
			 <div class="panel panel-default">
  			<div class="panel-body">
  			
  			
	  			
	  		<div class="row">
	  		<div class="col-lg-2 col-xs-12 col-md-2">
	                <div class="form-group">
	                <label for="tipo_reporte" class="control-label">Tipo Reporte:</label>
	                <select name="tipo_reporte" id="tipo_reporte"  class="form-control">
				    <option value="0">--Seleccione--</option>
				  	<option value="Participes">Participes</option>
				  	</select>
				  	 <div id="mensaje_tipo_reporte" class="errores"></div>
	                </div>
	        </div>
	  		
	        
			<div class="col-lg-2 col-md-2 col-xs-12">
					<div class="form-group">
	                <label for="tipo_reporte" class="control-label">Fecha Creación Desde:</label>
	                <input type="date"  name="fcha_desde" id="fcha_desde" value="" class="form-control "/>
				  	<div id="mensaje_fcha_desde" class="errores"></div>
	                </div>
			</div>
			
			<div class="col-lg-2 col-md-2 col-xs-12">
					<div class="form-group">
	                <label for="tipo_reporte" class="control-label">Fecha Creación Hasta:</label>
	                <input type="date"  name="fcha_hasta" id="fcha_hasta" value="" class="form-control "/> 
				  	<div id="mensaje_fcha_hasta" class="errores"></div>
	                </div>
			</div>
		
		   
	       </div>	
  		
  		
  		
  			
  			
  		
      	</div>
  		
  		
  		<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
  		    
		 <button type="submit" id="buscar" name="buscar" value="Buscar"   class="btn btn-info" style="margin-top: 10px;"><i class="glyphicon glyphicon-search"></i></button>
		 
	     </div>	
  		
  	
		 </div>
		    
		 </div>
	     </div>
	     </div>
            
         
         
         
         
         
         
    	 <div class="col-lg-12 col-md-12 col-xs-12">
		 <div style="height: 200px; display: block;">
					<div id="matriz" style="position: absolute;	text-align: center;	top: 10px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
					<div class="div_matriz" ></div><!-- Datos ajax Final -->
		 </div>
		 </div>      
         
         
                            
  
        </form>
  
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
	
	<!-- codigo de las funciones -->

	
  </body>
</html>   