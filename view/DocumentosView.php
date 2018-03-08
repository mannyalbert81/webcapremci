<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Búsqueda de Documentos - aDocument 2017</title>

		
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
       
		
	    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		   
          <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	      <script src="//code.jquery.com/jquery-1.10.2.js"></script>
		  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		  <link rel="stylesheet" href="/resources/demos/style.css">
		
		<link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">
        <script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
        <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
 



					<script >
		$(document).ready(function(){

		    // cada vez que se cambia el valor del combo
		    $("#categorias").change(function() {

               // obtenemos el combo de subcategorias
                var $subcategorias = $("#subcategorias");
               // lo vaciamos
               
				///obtengo el id seleccionado
				

               var id_categorias = $(this).val();


               $subcategorias.empty();

               $subcategorias.append("<option value= " +"0" +" > --TODOS--</option>");
           
               if(id_categorias > 0)
               {
            	   var datos = {
            			   id_categorias : $(this).val()
                   };


            	   $.post("<?php echo $helper->url("subCategorias","devuelveSubcategorias"); ?>", datos, function(resultSub) {

            		 		$.each(resultSub, function(index, value) {
               		 	    $subcategorias.append("<option value= " +value.id_subcategorias +" >" + value.nombre_subcategorias  + "</option>");	
                       		 });

            		 		 	 		   
            		  }, 'json');


               }
               else
               {
            	   $.post("<?php echo $helper->url("subCategorias","devuelveAllSubcategorias"); ?>", datos, function(resultSub) {

   		 		        $.each(resultSub, function(index, value) {
          		 	    $subcategorias.append("<option value= " +value.id_subcategorias +" >" + value.nombre_subcategorias  + "</option>");	
                	  });
     		  		}, 'json');

               }
               
		    });
    
		}); 

	</script>
					  
		

		
        	<script>
        
        		$(document).ready(function(){
        
        			$("#subcategorias").change(function() {
        
        	               // obtenemos el combo de categorias
        	                var $categorias = $("#categorias");
        	               
        					///obtengo el id seleccionado
        					var id_subcategorias = $(this).val();
        
        	               if(id_subcategorias > 0)
        
        	               {
        	            	   var datos = {
        	            			   id_subcategorias : $(this).val()
        	                   };
        
        
        	            	   //$categorias.append("<option value= " +"0" +" >"+ id_subcategorias  +"</option>");
        	                   $.post("<?php echo $helper->url("subCategorias","devuelveSubBySubcategorias"); ?>", datos, function(resultSub) {
        	            		   
                 		 		  $.each(resultSub, function(index, value) {
        
                 		 			 $('#categorias').val( value.id_categorias );//To select Blue	 
                 		 			//$("'#categorias > option[value="+value.id_categorias"+"]').attr('selected', 'selected'");
        								
        							 });
        
                 		 		 	 		   
                 		  		}, 'json');
        	                   
        	               }
        	               else
        	               {
        
        	          		 $('#categorias').val( 0 );//To select Blue
        
        			        }
        	               
        	               
        			    });
        		}); 
        
        	</script>
        		<script>
        
        		$(document).ready(function(){
        
        		    $("#fecha_documento_hasta").change(function() {
        
        
        		    	var startDate = new Date($('#fecha_documento_desde').val());
        		    	var endDate = new Date($('#fecha_documento_hasta').val());
        
        		    	if (startDate > endDate){
        
        		    		$("#fecha_documento_hasta").val("");
        		    		alert('Fecha documento DESDE mayor a  fecha FINAL');
        		    	}
        
        
        		    	
        			  });
        
        		}); 
        
        	</script>
		

	
        	<script>
        
        		$(document).ready(function(){
        
        		    $("#fecha_poliza_hasta").change(function() {
        
        
        		    	var startDate = new Date($('#fecha_poliza_desde').val());
        		    	var endDate = new Date($('#fecha_poliza_hasta').val());
        
        		    	if (startDate > endDate){
        		    		$("#fecha_poliza_hasta").val("");
        		    		alert('Fecha poliza DESDE mayor a  fecha FINAL');
        		    	}
        			  });
        		}); 
        
        	</script>
        	
	

        	<script>
        
        		$(document).ready(function(){
        
        		    $("#fecha_subida_hasta").change(function() {
        
        
        		    	var startDate = new Date($('#fecha_subida_desde').val());
        		    	var endDate = new Date($('#fecha_subida_hasta').val());
        
        		    	if (startDate > endDate){
        		    		$("#fecha_subida_hasta").val("");
        
        		    		alert('Fecha subida DESDE mayor a  fecha FINAL');
        		    	}
        			  });
        		}); 
        
        	</script>
	
	</script>		
	 <script type="text/javascript">
	$(document).ready(function(){

		
		$("#btnBuscar").click(function(){
			
			load_Documentos(1);
			});

		load_nombre_cliente();
	
	});

	
	function load_Documentos(pagina){

		
		//iniciar variables
		 var doc_categorias=$("#categorias").val();
		 var doc_subcategorias=$("#subcategorias").val();
		 var doc_ruc_cli=$("#ruc_cliente_proveedor").val();
		 var doc_nombre_cli=$("#nombre_cliente_proveedor").val();
		 var doc_tipo_doc=$("#tipo_documentos").val();
		 var doc_cartones_doc=$("#carton_documentos").val();
		 var doc_fecha_doc_desde=$("#fecha_documento_desde").val();
		 var doc_fecha_doc_hasta=$("#fecha_documento_hasta").val();
		 var doc_fecha_subida_desde=$("#fecha_subida_desde").val();
		 var doc_fecha_subida_hasta=$("#fecha_subida_hasta").val();
		 var doc_numero_poliza=$("#numero_poliza").val();
		 var doc_cierre_ventas=$("#cierre_ventas_soat").val();
		 var doc_fecha_poliza_desde=$("#fecha_poliza_desde").val();
		 var doc_fecha_poliza_hasta=$("#fecha_poliza_hasta").val();
		 var doc_year=$("#year").val();

		 	
		  var con_datos={
				  categorias:doc_categorias,
				  subcategorias:doc_subcategorias,
				  ruc_cliente_proveedor:doc_ruc_cli,
				  tipo_documentos:doc_tipo_doc,
				  nombre_cliente_proveedor:doc_nombre_cli,
				  carton_documentos:doc_cartones_doc,
				  numero_poliza:doc_numero_poliza,
				  fecha_documento_desde:doc_fecha_doc_desde,
				  fecha_documento_hasta:doc_fecha_doc_hasta,
				  fecha_subida_desde:doc_fecha_subida_desde,
				  fecha_subida_hasta:doc_fecha_subida_hasta,
				  cierre_ventas_soat:doc_cierre_ventas,
				  fecha_poliza_desde:doc_fecha_poliza_desde,
				  fecha_poliza_hasta:doc_fecha_poliza_hasta,
				  year:doc_year,
				  action:'ajax',
				  page:pagina
				  };


		$("#Documentos").fadeIn('slow');
		$.ajax({
			url:"<?php echo $helper->url("Documentos","buscar");?>",
            type : "POST",
            async: true,			
			data: con_datos,
			 beforeSend: function(objeto){
			$("#Documentos").html('<img src="view/images/ajax-loader.gif"> Cargando...');
			},
			success:function(data){
				$(".Documentos").html(data).fadeIn('slow');
				$("#Documentos").html("");
			}
		})
	}

	function load_nombre_cliente()
	{
		
	    var _resultCli='';<?php  //echo json_encode($resultCli); ?>
	    var _sel_nombre_cliente_proveedor = $("#nombre_cliente_proveedor");
	    _sel_nombre_cliente_proveedor.empty();
	    _sel_nombre_cliente_proveedor.append("<option value= " +"0" +" > --TODOS--</option>");

	    if(_resultCli.length>0)
	    {
		    console.log('hay datos');
	    	 $.each(_resultCli, function(index, value) {

	    		 _sel_nombre_cliente_proveedor.append("<option value= " +value.id_cliente_proveedor +" >" + value.nombre_cliente_proveedor  + "</option>");	
	     		
				 });
	    }else{
	    	console.log('no hay datos');
		    }
	    
	}

	</script>
		
	
     <script>
	$(document).ready(function(){
 	
	$("#txt_nombre_cliente_proveedor").autocomplete({
		source: "<?php echo $helper->url("Documentos","AutocompleteNombreCliente"); ?>",
		minLength: 1,
		select: function( event, data ) 
			{
			 var respueta = data.item.id;
			 var res = respueta.split(',');
			 
			 $("#nombre_cliente_proveedor").val(res[0]);
			 $("#ruc_cliente_proveedor").val(res[0]);
			 
             $("#txt_nombre_cliente_proveedor").val(data.item.value);
             $("#txt_ruc_cliente_proveedor").val(res[1]);
	            //alert(data);
			}
	 });
		
	$("#txt_nombre_cliente_proveedor").focusout(function(){

		if($("#txt_nombre_cliente_proveedor").val()==''||$("#txt_nombre_cliente_proveedor").val()==null)
		{
			 $("#nombre_cliente_proveedor").val(0);
			 $("#ruc_cliente_proveedor").val(0);
			 $("#txt_nombre_cliente_proveedor").val('');
	         $("#txt_ruc_cliente_proveedor").val('');
			 
		}
						
	});
						
	});
		
					
    </script>
    
    <script>
	$(document).ready(function(){

	 	
	$("#txt_ruc_cliente_proveedor").autocomplete({
		
		source: "<?php echo $helper->url("Documentos","AutocompleteRucCliente"); ?>",
		minLength: 1,
		select: function( event, data ) 
		{
		 var respueta = data.item.id;
		 var res = respueta.split(',');
		 
		 $("#nombre_cliente_proveedor").val(res[0]);
		 $("#ruc_cliente_proveedor").val(res[0]);
		 
         $("#txt_nombre_cliente_proveedor").val(res[1]);
         $("#txt_ruc_cliente_proveedor").val(data.item.value);
            //alert(data);
		}
	 });
		
	$("#txt_ruc_cliente_proveedor").focusout(function(){

		if($("#txt_ruc_cliente_proveedor").val()==''||$("#txt_ruc_cliente_proveedor").val()==null)
		{
			 $("#nombre_cliente_proveedor").val(0);
			 $("#ruc_cliente_proveedor").val(0);
			 $("#txt_nombre_cliente_proveedor").val('');
	         $("#txt_ruc_cliente_proveedor").val('');
	            //alert(data);
			 
		}
						
	});
	});
		
					
    </script>
    
    <script>
	$(document).ready(function(){
 	
	$("#txt_tipo_documentos").autocomplete({
		source: "<?php echo $helper->url("Documentos","AutocompleteTipoDoc"); ?>",
		minLength: 1,
		select: function( event, data ) 
		{
		 var respueta = data.item.id;
		 $("#tipo_documentos").val(respueta);
		 
         $("#txt_tipo_documentos").val(data.item.value);
		}
	 });
		
	$("#txt_tipo_documentos").focusout(function(){

		if($("#txt_tipo_documentos").val()==''||$("#txt_tipo_documentos").val()==null)
		{
			 $("#tipo_documentos").val(0);
		}
						
	});
	});
		
					
    </script>
				
		
             <script>
        			function myFunction() {
        			    var x = document.getElementById("categorias").value;
                            var subcategorias = document.getElementById("subcategorias");
                            $subcategorias.Empty();
        				    document.getElementById("demo").innerHTML = "You selected: " + x;
        			}
        	</script>
        	
             
        
               
            <?php
       
    		   $sel_categorias = 0;
    		   $sel_subcategorias = 0;
    		   $sel_year = 0;
    		   $sel_cliente_proveedor = 0;
    		   $sel_tipo_documentos = 0;
    		   $sel_carton_documentos = 0;
    		   $sel_fecha_documento_desde = "";
    		   $sel_fecha_documento_hasta = "";
    		   
    		   if($_SERVER['REQUEST_METHOD']=='POST' )
    		   {
    		      $sel_categorias = $_POST['categorias'];
    		      $sel_subcategorias = $_POST['subcategorias'];
    		      $sel_year = $_POST['year'];
    		      $sel_cliente_proveedor = $_POST['nombre_cliente_proveedor'];
    		      $sel_tipo_documentos = $_POST['tipo_documentos'];
    		      $sel_carton_documentos = $_POST['carton_documentos'];
    		      $sel_fecha_documento_desde = $_POST['fecha_documento_desde'];
    		      $sel_fecha_documento_hasta = $_POST['fecha_documento_hasta'];
    		      
    		       
    		   }
    		   
    		?>
		     	        
			        
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
                    <h2>BÚSQUEDA <small>Documentos</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

						<form action="<?php echo $helper->url("Documentos","index"); ?>" method="post" class="col-xs-12 col-md-12 col-md-12">
                              
                	      <div class="row">
                        	   <div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Categorias</label>
                                         <select name="categorias" id="categorias"  class="form-control"   >
                            	                <option value="0"  > --TODOS--</option>
                            			    	 <?php foreach($resultCat as $resCat) {?>
                            					 		<?php if ($sel_categorias > 0){?>
                            					 			<option value="<?php echo $resCat->id_categorias; ?>"  <?php if ($resCat->id_categorias == $sel_categorias) {echo "selected"; }  ?>     > <?php echo $resCat->nombre_categorias; ?> </option>
                            					 		
                            					 		<?php  } else { ?>
                            					 			
                            					 			<option value="<?php echo $resCat->id_categorias; ?>"  > <?php echo $resCat->nombre_categorias; ?> </option>
                            					 		
                            					 		<?php }  ?>
                            	 		
                            				 	 <?php } ?>
                            			</select>
                            			
                                
                                    </div>
                            	</div>
                            	
                            	<div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Subcategorias</label>
                                         <select name="subcategorias" id="subcategorias"  class="form-control">
                    							<option value="0"  > --TODOS--</option>
                    				    	 <?php foreach($resultSub as $resSub) {?>
                    					 		<?php if ($sel_subcategorias > 0){?>
                    					 				<option value="<?php echo $resSub->id_subcategorias;?>"  <?php if ($resSub->id_subcategorias == $sel_subcategorias) {echo "selected"; }  ?>     > <?php echo $resSub->nombre_subcategorias; ?> </option>
                    					 			<?php  } else { ?>
                    					 				<option value="<?php echo $resSub->id_subcategorias;?>" > <?php echo $resSub->nombre_subcategorias; ?> </option>
                    					 			<?php }  ?>
                    	 				 	<?php } ?>
                    						
                    					</select>
                            			
                                
                                    </div>
                            	</div>
								
								<div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Ruc-Ci Cliente</label>
                                		 <input type="text" class="form-control" id="txt_ruc_cliente_proveedor" name="txt_ruc_cliente_proveedor" value=""  placeholder="Ingrese Ruc Cliente">
                 		 				 <input type="hidden"  id="ruc_cliente_proveedor" name="ruc_cliente_proveedor" value="0">
                                
                                    </div>
                            	</div>
								
								<div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Nombres Cliente</label>
                                		 <input type="text" class="form-control" id="txt_nombre_cliente_proveedor" name="txt_nombre_cliente_proveedor" value=""  placeholder="Ingrese nombre Cliente">
                 		  				 <input type="hidden"  id="nombre_cliente_proveedor" name="nombre_cliente_proveedor" value="0">
                                
                                    </div>
                            	</div>
								<div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Tipo Documento</label>
                            				  <input type="text" class="form-control" id="txt_tipo_documentos" name="txt_tipo_documentos" value=""  placeholder="Ingrese Tipo Doc">
        					         		  <input type="hidden"  id="tipo_documentos" name="tipo_documentos" value="0">
		    
                                    </div>
                            	</div>                          
            					<div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Carpeta/Carton</label>
                                			<select name="carton_documentos" id="carton_documentos"  class="form-control">
                    							<option value="0"  > --TODOS--</option>
                    					      	 <?php foreach($resultCar as $resCar) {?>
                    						 		<?php if ($sel_carton_documentos > 0){?>
                    						 			<option value="<?php echo $resCar->id_carton_documentos;?>"  <?php if ($resCar->id_carton_documentos == $sel_carton_documentos) {echo "selected"; }  ?>     > <?php echo $resCar->numero_carton_documentos; ?> </option>
                    					 			<?php  } else { ?>
                    					 			
                    					 				<option value="<?php echo $resCar->id_carton_documentos;?>" > <?php echo $resCar->numero_carton_documentos; ?> </option>
                    					 		
                    					 			<?php }  ?>
                    	 		
                    					 	 	<?php } ?>	
                    			        
                    					</select>
                       	 		
                            				
                            				
                                    </div>
                            	</div>                          
                          </div>	
                	        
						                 	        
                	        
                	        
                   	      <div class="row">
                        	   <div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Año</label>
                  						 <select name="year" id="year"  class="form-control">
                							<option value="0"  > --TODOS--</option>
                				        
                    				        <?php for($i = date ("Y") ; $i > 1899 ; $i --) {?>
                    				         	<?php if ($sel_year > 0){?>
                    				         			<option value="<?php echo $i; ?>" <?php if ($i == $sel_year) {echo "selected"; }  ?>  ><?php echo $i; ?> </option>
                    				         		<?php  } else { ?>
                    				         			<option value="<?php echo $i; ?>" ><?php echo $i; ?> </option>
                    						    	<?php }  ?>
                    						    <?php } ?>
                    					   		    
                	     			     </select>	              
                                    </div>
                            	</div>
                            	
                            	<div class="col-xs-3 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Fecha Desde</label>
                     					 <?php if ($sel_fecha_documento_desde == "" ) { ?>	
                    				   		<input type="date" name="fecha_documento_desde" id="fecha_documento_desde"  class="form-control"   />
                    					 <?php } else {?>	
                    					 	<input type="date" value="<?php echo $sel_fecha_documento_desde ?>"  name="fecha_documento_desde" id="fecha_documento_desde"   class="form-control"   />
                    					 <?php }?>	           
                                    </div>
                            	</div>
								
								<div class="col-xs-3 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         <label for="nombre_rol" class="control-label">Fecha Hasta</label>
                                         <?php if ($sel_fecha_documento_hasta == "" ) { ?>	
                    				   		<input type="date" name="fecha_documento_hasta" id="fecha_documento_hasta"  class="form-control"   />
                    					 <?php } else {?>	
                    					 	<input type="date" value="<?php echo $sel_fecha_documento_hasta ?>"  name="fecha_documento_hasta" id="fecha_documento_hasta"   class="form-control"   />
                    					 <?php }?>
                                    </div>
                            	</div>
								
								<div class="col-xs-6 col-md-2 col-md-2 ">
                                   <div class="form-group">
                                         
                                
                                    </div>
                            	</div>
		                  </div> 
                	        
                    		<div class="row">
                    				<br>
                    			    <div class="col-xs-12 col-md-12 col-lg-12" style="text-align: center; ">
 		                	   		    <div class="form-group">
                    	                  <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-success">Buscar</button>
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
                    <h2>LISTADO<small>Usuarios</small></h2>
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
                          <th>Fecha</th>
                          <th>Categoría</th>
                          <th>Subcategoría</th>
                          <th>Tipo Documento</th>
                          <th>Cliente</th>
                     	  <th>Cartón</th>
                     	  <th>Número</th>
                     	  <th>Monto</th>
                     	  <th>Valor</th>
                     	  <th></th>
                        </tr>
                      </thead>


                      <tbody>
    					
    						
    						<?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
            	        		<tr>
            	                   <td > <?php echo $res->id_documentos_legal; ?>  </td>
            	                   <td > <?php echo $res->fecha_documentos_legal; ?>  </td>	
            	                   <td > <?php echo $res->nombre_categorias; ?>  </td>
            	                   <td > <?php echo $res->nombre_subcategorias; ?>  </td>
            	                   <td > <?php echo $res->nombre_tipo_documentos; ?>  </td>
            	                   <td > <?php echo $res->nombre_cliente_proveedor; ?>  </td>
            	                   <td > <?php echo $res->numero_carton_documentos; ?>  </td>
            	                   <td > <?php echo $res->numero_credito_documentos_legal; ?>  </td>
            	                   <td > <?php echo $res->monto_documentos_legal; ?>  </td>               
            	                   <td > <?php echo $res->valor_documentos_legal; ?>  </td>
            	                   
            	                   <td>
            	                   <?php  if ($_SESSION["tipo_usuario"]=="usuario_local") {  ?>
        			            		 <a href=" <?php echo IP_INT . $res->id_documentos_legal; ?>  " class="btn btn-warning" target="blank" style="font-size:65%;">Ver</a>
        			            	<?php } else {?>
        			            		 <a href="<?php echo IP_EXT . $res->id_documentos_legal; ?>  " class="btn btn-warning" target="blank" style="font-size:65%;">Ver</a> 
        			            	<?php }?>
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



