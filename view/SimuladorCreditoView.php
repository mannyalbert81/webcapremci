<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>SimuladorCrédito - Capremci</title>

		
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
            	
		        setTimeout($.unblockUI, 3000); 
		        
        	   }

        	   </script>
        
        
        
        <script>
		$(document).ready(function(){


			
			$("#tipo_prestamo").click(function(){

	            // obtenemos el combo de resultado combo 2
	           var $taza_intereses = $("#taza_intereses");
	       	

	            // lo vaciamos
	           var tipo_prestamo = $(this).val();

	          
	          
	            if(tipo_prestamo != 0)
	            {
	            	 $taza_intereses.empty();
	            	
	            	 var datos = {
	                   	   
	            			 tipo_prestamo:$(this).val()
	                  };
	             
	            	
	         	   $.post("<?php echo $helper->url("SimuladorCredito","TazaIntereses"); ?>", datos, function(resultado) {

	          		  if(resultado.length==0)
	          		   {
	          				$taza_intereses.append("<option value='0' >--Seleccione--</option>");	
	             	   }else{
	             		    $taza_intereses.append("<option value='0' >--Seleccione--</option>");
	          		 		$.each(resultado, function(index, value) {
	          		 			$taza_intereses.append("<option value= " +value.taza_intereses +" >" + value.nombre_intereses  + "</option>");	
	                     		 });
	             	   }	
	            	      
	         		  }, 'json');


	            }else{

	            	var taza_intereses=$("#taza_intereses");
	            	taza_intereses.find('option').remove().end().append("<option value='0' >--Seleccione--</option>").val('0');
	            	
	            	
	            	
	            }
	            

			});
		});
	
       

	</script>
        
        
        
        
        
        <script >
		    // cada vez que se cambia el valor del combo
		    $(document).ready(function(){
		    
		    $("#Calcular").click(function() 
			{
		    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		    	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;

		    	var valor_prestamo = $("#valor_prestamo").val();

		    	var tipo_prestamo = $("#tipo_prestamo").val();
		    	var taza_intereses = $("#taza_intereses").val();
		    	
		    	var cantidad_plazo_meses = $("#cantidad_plazo_meses").val();
		    	var fecha_corte = $("#fecha_corte").val();
		    	
		    	if (valor_prestamo == 0.00)
		    	{
			    	
		    		$("#mensaje_valor_prestamo").text("Introduzca Valor");
		    		$("#mensaje_valor_prestamo").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_valor_prestamo").fadeOut("slow"); //Muestra mensaje de error
		            
				}    

		    	if (tipo_prestamo == 0)
		    	{
			    	
		    		$("#mensaje_tipo_prestamo").text("Seleccione Tipo");
		    		$("#mensaje_tipo_prestamo").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_tipo_prestamo").fadeOut("slow"); //Muestra mensaje de error
		            
				}

		    	if (taza_intereses == 0)
		    	{
			    	
		    		$("#mensaje_taza_intereses").text("Seleccione Interes");
		    		$("#mensaje_taza_intereses").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_taza_intereses").fadeOut("slow"); //Muestra mensaje de error
		            
				}
				
		    	if (cantidad_plazo_meses == 0)
		    	{
			    	
		    		$("#mensaje_cantidad_plazo_meses").text("Seleccione Plazo");
		    		$("#mensaje_cantidad_plazo_meses").fadeIn("slow"); //Muestra mensaje de error
		            return false;
			    }
		    	else 
		    	{
		    		$("#mensaje_cantidad_plazo_meses").fadeOut("slow"); //Muestra mensaje de error
		            
				} 



				if(fecha_corte==""){
					$("#mensaje_fecha_corte").text("Seleccione Fecha");
		    		$("#mensaje_fecha_corte").fadeIn("slow"); //Muestra mensaje de error
		            return false;
				}
				else 
		    	{
		    		$("#mensaje_fecha_corte").fadeOut("slow"); //Muestra mensaje de error
		            
				}			    

			}); 


		        $( "#valor_prestamo" ).focus(function() {
				  $("#mensaje_valor_prestamo").fadeOut("slow");
			    });
		        $( "#tipo_prestamo" ).focus(function() {
					  $("#mensaje_tipo_prestamo").fadeOut("slow");
				});
		        $( "#taza_intereses" ).focus(function() {
					  $("#mensaje_taza_intereses").fadeOut("slow");
				});
		        
		        $( "#cantidad_plazo_meses" ).focus(function() {
					  $("#mensaje_cantidad_plazo_meses").fadeOut("slow");
				});
		        $( "#fecha_corte" ).focus(function() {
					  $("#mensaje_fecha_corte").fadeOut("slow");
				});
				    
		}); 

	</script>
	
	
	<script>
      $(document).ready(function(){
      $(".cantidades1").inputmask();
      });
	  </script>
	
	
	
	
      		        
    </head>
    
    
    <body class="nav-md"  >
    
      <?php
        
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        
        
       
        
        $sel_valor_prestamo="";
        $sel_tipo_prestamo="";
        $sel_cantidad_plazo_meses="";
        $sel_taza_intereses="";
        $sel_fecha_corte="";
        
        
        
        if($_SERVER['REQUEST_METHOD']=='POST' )
        {
        	$sel_valor_prestamo=$_POST['valor_prestamo'];
        	$sel_tipo_prestamo=$_POST['tipo_prestamo'];
        	$sel_cantidad_plazo_meses=$_POST['cantidad_plazo_meses'];
        	$sel_taza_intereses=$_POST['taza_intereses'];
        	$sel_fecha_corte=$_POST['fecha_corte'];
        	
        	
        }
        
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
         <li class="active">Simulador de Crédito</li>
         </ol>
         </section>
  	
  	
  	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Simulador de Crédito<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


            <form  action="<?php echo $helper->url("SimuladorCredito","index"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
                               
                     
                    		    <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="valor_prestamo" class="control-label">Valor Prestamo:</label>
                                                      <input type="text" class="form-control cantidades1" id="valor_prestamo" name="valor_prestamo" value='<?php if(!empty($sel_valor_prestamo)){echo $sel_valor_prestamo;}else{echo "0";} ?>' 
                                                      data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                      <div id="mensaje_valor_prestamo" class="errores"></div>
                                </div>
                                </div>
                                
                                
                                
                                 <div class="col-xs-12 col-md-2 col-md-2">
                        		 <div class="form-group">
                                                          <label for="tipo_prestamo" class="control-label">Tipo Crédito:</label>
                                                          <select name="tipo_prestamo" id="tipo_prestamo"  class="form-control" >
                                                         <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultInte as $res) {?>
                        										<option value="<?php echo $res->tipo_prestamo; ?>" <?php if($sel_tipo_prestamo==$res->tipo_prestamo){echo "selected";}?>><?php echo $res->tipo_prestamo; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_tipo_prestamo" class="errores"></div>
                                 </div>
                                 </div>
                                
                                
                                <div class="col-xs-12 col-md-2 col-md-2">
                        		<div class="form-group">
                                                          <label for="taza_intereses" class="control-label">% Interes:</label>
                                                          <select name="taza_intereses" id="taza_intereses"  class="form-control" >
                                                          <option value="0">--Seleccione--</option>
                        								  </select> 
                                                          <div id="mensaje_taza_intereses" class="errores"></div>
                                 </div>
                                 </div>
                                
                                <div class="col-xs-12 col-md-2 col-md-2">
                        		<div class="form-group">
                                                          <label for="cantidad_plazo_meses" class="control-label">Plazo (meses):</label>
                                                          <select name="cantidad_plazo_meses" id="cantidad_plazo_meses"  class="form-control" >
                                                         <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultPlazoMeses as $res) {?>
                        										<option value="<?php echo $res->cantidad_plazo_meses; ?>" <?php if($sel_cantidad_plazo_meses==$res->cantidad_plazo_meses){echo "selected";}?>><?php echo $res->nombre_plazo_meses; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_cantidad_plazo_meses" class="errores"></div>
                                 </div>
                                 </div>
                                
                                
                                 
                                 <div class="col-xs-12 col-md-2 col-lg-2">
		   						 <div class="form-group">
							    					  <label for="fecha_corte" class="control-label">Fecha: </label>
					                                  <input type="date" class="form-control" id="fecha_corte" name="fecha_corte" value="<?php echo $sel_fecha_corte; ?>" >
					                                 <div id="mensaje_fecha_corte" class="errores"></div>
								 </div>
								 </div>
                                 
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="valor_cuota" class="control-label">Valor Cuota:</label>
                                                      <input type="number" class="form-control" id="valor_cuota" name="valor_cuota" value="<?php if (!empty($valor_cuota)) { echo number_format($valor_cuota,2);}  else{ }?>"  placeholder="0.00" readonly>
                                                      <div id="mensaje_valor_cuota" class="errores"></div>
                                </div>
                                </div>
                                
                                 
                                </div>
                    			   	
                    			<div class="row">
                    		    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; margin-top:20px">
                    		    <div class="form-group">
                                                      <button type="submit" id="Calcular" name="Calcular" class="btn btn-success">Calcular</button>
                                </div>
                    		    </div>
                    		    </div>
                    	
              	   </form>
  
                  </div>
                </div>
              </div>
              
              
              
              
              <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Amortización<small>Cuotas</small></h2>
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
                          
                         
                          <th>Cuota</th>
                          <th>Saldo Inicial</th>
                          <th>Interes Normal</th>
                          <th>Amortización</th>
                          <th>Pagos</th>
                          <th>Fecha Pago</th>
                          </tr>
                      </thead>


                      <tbody>
    					
    				
    						<?php if (!empty($resultAmortizacion)) {  foreach($resultAmortizacion['tabla'] as $res) {?>
    						
    							
            	        		<tr>
            	        		   <td> <?php echo $res[0]['pagos_trimestrales']; ?>      </td>
            	                   <td> <?php echo number_format($res[0]['saldo_inicial'],2); ?>  </td> 
            		               <td> <?php echo number_format($res[0]['interes'],2); ?>  </td> 
            		               <td> <?php echo number_format($res[0]['amortizacion'],2); ?> </td>
            		               <td> <?php echo number_format($res[0]['pagos'],2); ?></td>
            		               <td> <?php echo $res[0]['fecha_pago']; ?> </td>
            		              
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
	
	
  </body>
</html>   