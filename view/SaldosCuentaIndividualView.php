<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>SaldosCuentaIndividual - Template 2018</title>

		    <link rel="stylesheet" href="view/css/estilos.css">
		    
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
					

			<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <script src="view/js/jquery.inputmask.bundle.js"></script>
       
       
       
		     <script type="text/javascript">
		      $(document).ready(function(){
		      $("#actualizar_participe").click(function() {
		    	  $("#leer_mas").fadeOut("slow");
		       	   $("#div_actualizar_datos_participes").fadeIn("slow");
		          
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
         <h1>
         <small><?php echo $fecha; ?></small>
         </h1>
   </section>
 
  	
  	<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>PANEL DE CONSULTAS<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
					
  	
  	
         <section class="content">
          <div class='nav-tabs-custom'>
          	    <ul id="myTabs" class="nav nav-tabs">
                 
                  <li id="nav-cuenta_creaditos" class="active"><a href="#cuenta_creaditos" data-toggle="tab">Consulta de Créditos</a></li>
                   <li id="nav-cuenta_individual"><a href="#cuenta_individual" data-toggle="tab" >Consulta Cuenta Individual</a></li>
                   <li id="nav-cuenta_desembolsar"><a href="#cuenta_desembolsar" data-toggle="tab">Consulta de Cuentas por Desembolsar</a></li>
                   <li id="nav-mis_datos"><a href="#mis_datos" data-toggle="tab">Mis Datos</a></li>
                   <li id="nav-proyecte_cesantia"><a href="#proyecte_cesantia" data-toggle="tab">Proyecte su Cesantia</a></li>
                </ul>
         
  
         
 		   <div class="tab-content">
 		   <br>
           <div class="tab-pane active" id="cuenta_creaditos">
          
          
          
           <div class='nav-tabs-custom'>
           		<ul id="myTabs" class="nav nav-tabs">
                 
                  <li id="nav-credito_ordinario" class="active"><a href="#credito_ordinario" data-toggle="tab">Ordinario</a></li>
                   <li id="nav-credito_emergente"><a href="#credito_emergente" data-toggle="tab" >Emergente</a></li>
                   <li id="nav-credito_dos_x_uno"><a href="#credito_dos_x_uno" data-toggle="tab">Dos x Uno</a></li>
                </ul>
          
           <div class="tab-content">
 		   <br>
           <div class="tab-pane active" id="credito_ordinario">
           <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Ordinario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                   <?php if (!empty($resultCredOrdi_Cabec) && !empty($resultCredOrdi_Detall)) {?>
                  
                     <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">No de Solicitud:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->numsol;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Cuota:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->cuota;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Interes:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->interes;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Tipo:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->tipo;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">PLazo:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->plazo;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Concedido en:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->fcred;}}else{} ?>" readonly>
                                </div>
                                </div>
                               
           </div>
           
           
            <div class="row">
                    	       
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Termina en:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->ffin;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Cuenta No:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->cuenta;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Banco:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredOrdi_Cabec)){ foreach ($resultCredOrdi_Cabec as $res){ echo $res->banco;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
            </div>
              
              		
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Pago</th>
                          <th>Mes</th>
                          <th>A&ntilde;o</th>
                          <th>Fecha Pago</th>
                          <th>Capital</th>
                          <th>Interes</th>
                          <th>Interes por Mora</th>
                          <th>Seguro Desgr.</th>
                          <th>Total</th>
                          <th>Saldo</th>
                          <th>Estado</th>
                        </tr>
                      </thead>


                      <tbody>
    					
    				
    						<?php if (!empty($resultCredOrdi_Detall)) {  foreach($resultCredOrdi_Detall as $res) {?>
    						
            	        		<tr>
            	        		   <td> <?php echo $res->pago; ?>  </td> 
            		               <td> <?php echo $res->mes; ?>  </td> 
            		               <td> <?php echo $res->ano; ?> </td>
            		               <td> <?php echo $res->fecpag; ?></td>
            		               <td> <?php echo number_format($res->capital, 2, '.', ','); ?> </td>
            		               <td> <?php echo number_format($res->interes, 2, '.', ','); ?>  </td>
            		               <td> <?php echo number_format($res->intmor, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->seguros, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->total, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->saldo, 2, '.', ','); ?>      </td>
            		               <td> <?php echo $res->estado; ?>      </td>
            		    		</tr>
            		        <?php } } ?>
                    
    					
                      </tbody>
                    </table>
                    
                    
                    <?php }else{?>
                    
                    
                                <div class="col-lg-6 col-md-6 col-xs-12">
           	                    <div class="alert alert-info alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4>Aviso!!!</h4> No tienes un crédito ordinario para mostrar.
								</div>
           	     				</div>
                    
                    <?php }?>
                    
                  </div>
                </div>
              </div>
           
           </form>
         </div>
           
           
           
           
           
           
           <div class="tab-pane" id="credito_emergente">
           <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Emergente</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                    <?php if (!empty($resultCredEmer_Cabec) && !empty($resultCredEmer_Detall)) {?>
                  
                  
                  
                     <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">No de Solicitud:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->numsol;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Cuota:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->cuota;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Interes:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->interes;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Tipo:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->tipo;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">PLazo:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->plazo;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Concedido en:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->fcred;}}else{} ?>" readonly>
                                </div>
                                </div>
                               
           </div>
           
           
            <div class="row">
                    	       
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Termina en:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->ffin;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Cuenta No:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->cuenta;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Banco:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCredEmer_Cabec)){ foreach ($resultCredEmer_Cabec as $res){ echo $res->banco;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
            </div>
           
              
              
              		
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Pago</th>
                          <th>Mes</th>
                          <th>A&ntilde;o</th>
                          <th>Fecha Pago</th>
                          <th>Capital</th>
                          <th>Interes</th>
                          <th>Interes por Mora</th>
                          <th>Seguro Desgr.</th>
                          <th>Total</th>
                          <th>Saldo</th>
                          <th>Estado</th>
                        </tr>
                      </thead>


                      <tbody>
    					
    				
    						<?php if (!empty($resultCredEmer_Detall)) {  foreach($resultCredEmer_Detall as $res) {?>
    						
            	        		<tr>
            	        		   <td> <?php echo $res->pago; ?>  </td> 
            		               <td> <?php echo $res->mes; ?>  </td> 
            		               <td> <?php echo $res->ano; ?> </td>
            		               <td> <?php echo $res->fecpag; ?></td>
            		               <td> <?php echo number_format($res->capital, 2, '.', ','); ?> </td>
            		               <td> <?php echo number_format($res->interes, 2, '.', ','); ?>  </td>
            		               <td> <?php echo number_format($res->intmor, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->seguros, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->total, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->saldo, 2, '.', ','); ?>      </td>
            		               <td> <?php echo $res->estado; ?>      </td>
            		    		</tr>
            		        <?php } } ?>
                    
    					
                      </tbody>
                    </table>
                    
                    
                     <?php }else{?>
                    
                    
                                <div class="col-lg-6 col-md-6 col-xs-12">
           	                    <div class="alert alert-info alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4>Aviso!!!</h4> No tienes un crédito emergente para mostrar.
								</div>
           	     				</div>
                    
                    <?php }?>
                    
                  </div>
                </div>
              </div>
           
           
           </form>
           
           
           
           </div>
           
           
           
           
           
           
           
           
           <div class="tab-pane" id="credito_dos_x_uno">
          <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
             <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Crédito Dos x Uno</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                  
                   <?php if (!empty($resultCred2_x_1_Cabec) && !empty($resultCred2_x_1_Detall)) {?>
                  
                  
                  
                     <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">No de Solicitud:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->numsol;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Cuota:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->cuota;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Interes:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->interes;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Tipo:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->tipo;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">PLazo:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->plazo;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Concedido en:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->fcred;}}else{} ?>" readonly>
                                </div>
                                </div>
                               
           </div>
           
           
            <div class="row">
                    	       
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Termina en:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->ffin;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Cuenta No:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->cuenta;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
                                <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula_participe" class="control-label">Banco:</label>
                                                      <input type="text" class="form-control" id="cedula_participe" name="cedula_participe" value="<?php if(!empty($resultCred2_x_1_Cabec)){ foreach ($resultCred2_x_1_Cabec as $res){ echo $res->banco;}}else{} ?>" readonly>
                                </div>
                                </div>
                                
            </div>
           
              
              
              		
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Pago</th>
                          <th>Mes</th>
                          <th>A&ntilde;o</th>
                          <th>Fecha Pago</th>
                          <th>Capital</th>
                          <th>Interes</th>
                          <th>Interes por Mora</th>
                          <th>Seguro Desgr.</th>
                          <th>Total</th>
                          <th>Saldo</th>
                          <th>Estado</th>
                        </tr>
                      </thead>


                      <tbody>
    					
    				
    						<?php if (!empty($resultCred2_x_1_Detall)) {  foreach($resultCred2_x_1_Detall as $res) {?>
    						
            	        		<tr>
            	        		   <td> <?php echo $res->pago; ?>  </td> 
            		               <td> <?php echo $res->mes; ?>  </td> 
            		               <td> <?php echo $res->ano; ?> </td>
            		               <td> <?php echo $res->fecpag; ?></td>
            		               <td> <?php echo number_format($res->capital, 2, '.', ','); ?> </td>
            		               <td> <?php echo number_format($res->interes, 2, '.', ','); ?>  </td>
            		               <td> <?php echo number_format($res->intmor, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->seguros, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->total, 2, '.', ','); ?>      </td>
            		               <td> <?php echo number_format($res->saldo, 2, '.', ','); ?>      </td>
            		               <td> <?php echo $res->estado; ?>      </td>
            		    		</tr>
            		        <?php } } ?>
                    
    					
                      </tbody>
                    </table>
                    
                    
                    
                      <?php }else{?>
                    
                    
                                <div class="col-lg-6 col-md-6 col-xs-12">
           	                    <div class="alert alert-info alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4>Aviso!!!</h4> No tienes un crédito 2x1 para mostrar.
								</div>
           	     				</div>
                    
                    <?php }?>
                    
                    
                  </div>
                </div>
              </div>
           
           
           </form>
          
          
           </div>
           
           
           </div>
          
          
           </div>
                
                
          
           </div> 
           
           
           
           
           <div class="tab-pane" id="cuenta_individual">
           <br>
           <form>
           <div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Cuenta Individual (Desde Enero 2011)</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <?php if (!empty($resultDatosMayor_Cta_individual)) {  foreach($resultDatosMayor_Cta_individual as $res) {?>
                   
                    <?php
                    $fecha=$res->fecha;
                    $total= $res->total; 
                    ?>
                    <?php }}?>
					
					<center><h5>Total Cuenta Individual Actualizada al <?php if ($fecha !=""){echo $fecha;}else{ echo "";}?> : $ <?php if($total != ""){echo $total;}else{ echo "0.00";}?></h5></center>
					
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                         
                          <th>Fecha</th>
                          <th>Descripción</th>
                          <th>Mes/A&ntilde;o</th>
                          <th>Valor Personal</th>
                          <th>Valor Patronal</th>
                          <th>Saldo Personal</th>
                          <th>Saldo Patronal</th>
                         
                        </tr>
                      </thead>


                      <tbody>
    					
    				
    						<?php if (!empty($resultDatos_Cta_individual)) {  foreach($resultDatos_Cta_individual as $res) {?>
    						
    							
            	        		<tr>
            	        		   <td> <?php echo $res->fecha_conta; ?>  </td> 
            		               <td> <?php echo $res->descripcion; ?>  </td> 
            		               <td> <?php echo $res->mes_anio; ?> </td>
            		               <td> <?php echo number_format($res->valorper, 2, '.', ','); ?></td>
            		               <td> <?php echo number_format($res->valorpat, 2, '.', ','); ?> </td>
            		               <td> <?php echo number_format($res->saldoper, 2, '.', ','); ?>  </td>
            		               <td> <?php echo number_format($res->saldopat, 2, '.', ','); ?>      </td>
            		               
            		    		</tr>
            		        <?php } } ?>
                    
    					
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
		
		
		
           
           
           
           
           
           
           </form>
           </div> 
           
           
           
           <div class="tab-pane" id="cuenta_desembolsar">
           <br>
           <form>
          
          
          
           	<div class="col-md-12 col-lg-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><small>CONSULTA DE CUENTAS POR DESEMBOLSAR - DESAFILIADOS</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <?php if (!empty($resultDatosMayor_Cta_desembolsar)) {  foreach($resultDatosMayor_Cta_desembolsar as $res) {?>
                   
                    <?php
                    $fecha1=$res->fecha;
                    $total1= $res->total; 
                    ?>
                    <?php }} ?>	
					
					 <center><h5>Total Cuenta Por Desembolsar Actualizada al <?php if ($fecha1 !=""){echo $fecha1;}else{ echo "";}?> : $ <?php if($total1 != ""){echo $total1;}else{ echo "0.00";}?></h5></center>
					
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                         
                          <th>Fecha</th>
                          <th>Descripción</th>
                          <th>Mes/A&ntilde;o</th>
                          <th>Valor Personal</th>
                          <th>Valor Patronal</th>
                          <th>Saldo Personal</th>
                          <th>Saldo Patronal</th>
                         
                        </tr>
                      </thead>


                      <tbody>
    					
    				
    						<?php if (!empty($resultDatos_Cta_desembolsar)) {  foreach($resultDatos_Cta_desembolsar as $res) {?>
    						
    							
            	        		<tr>
            	        		   <td> <?php echo $res->fecha_conta; ?>  </td> 
            		               <td> <?php echo $res->descripcion; ?>  </td> 
            		               <td> <?php echo $res->mes_anio; ?> </td>
            		               <td> <?php echo number_format($res->valorper, 2, '.', ','); ?></td>
            		               <td> <?php echo number_format($res->valorpat, 2, '.', ','); ?> </td>
            		               <td> <?php echo number_format($res->saldoper, 2, '.', ','); ?>  </td>
            		               <td> <?php echo number_format($res->saldopat, 2, '.', ','); ?>      </td>
            		               
            		    		</tr>
            		        <?php } } ?>
                    
    					
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
		
		
           
           </form>
          
          
           </form>
           </div> 
           
           
           
           
           
           <div class="tab-pane" id="mis_datos">
           <br>
           <form  action="<?php echo $helper->url("SaldosCuentaIndividual","ActualizarParticipe"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
           
           
       
             <?php if (!empty($resultParticipe)) { foreach($resultParticipe as $resEdit) {?>
           
            <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-user'></i> Datos Generales</h4>
	         </div>
	         <div class="panel-body">
			 
			 <div class="row">
                    		    <div class="col-lg-2 col-xs-12 col-md-2">
                    		    <div class="form-group">
                                                      <label for="cedula" class="control-label">Cedula:</label>
                                                      <input type="text" class="form-control" id="cedula" name="cedula" value="<?php echo $resEdit->cedula; ?>"  placeholder="cedula.." readonly>
                                                      <div id="mensaje_cedula" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-4 col-xs-12 col-md-4">
                    		    <div class="form-group">
                                                      <label for="nombre" class="control-label">Nombre:</label>
                                                      <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $resEdit->nombre; ?>" placeholder="nombres..">
                                                      <div id="mensaje_nombre" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-6 col-xs-12 col-md-6">
                    		    <div class="form-group">
                                                      <label for="direccion" class="control-label">Dirección:</label>
                                                      <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $resEdit->direccion; ?>" placeholder="dirección..">
                                                      <div id="mensaje_direccion" class="errores"></div>
                                </div>
                                </div>
                    			
                    		
         	  </div>
			 
			 
			 
			 
			 <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="labor" class="control-label">Cargo:</label>
                                                      <input type="text" class="form-control" id="labor" name="labor" value="<?php echo $resEdit->labor; ?>"  placeholder="cargo..">
                                                      <div id="mensaje_labor" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="correo" class="control-label">Email:</label>
                                                      <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $resEdit->correo; ?>" placeholder="email..">
                                                      <div id="mensaje_correo" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="telefono" class="control-label">Teléfono:</label>
                                                      <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $resEdit->telefono; ?>" placeholder="teléfono..">
                                                      <div id="mensaje_usuario_usuario" class="errores"></div>
                                </div>
                                </div>
                    			
                    		
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="celular" class="control-label">Celular:</label>
                                                      <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $resEdit->celular; ?>" placeholder="celular..">
                                                      <div id="mensaje_usuario_usuario" class="errores"></div>
                                </div>
                                </div>
         	  </div>
			 
			 
			 
			 <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_entidades" class="control-label">Fuerza:</label>
                                                      <select name="id_entidades" id="id_entidades"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEntidades as $res) {?>
                        										<option value="<?php echo $res->id_entidades; ?>" <?php if ($res->id_entidades == $resEdit->id_entidades )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_entidades; ?> </option>
                        							        <?php } ?>
                        						      </select> 
                                                      <div id="mensaje_id_entidades" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="fecha_ingreso" class="control-label">Fecha Entrada:</label>
                                                      <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $resEdit->fecha_ingreso; ?>" placeholder="fecha entrada..">
                                                      <div id="mensaje_fecha_ingreso" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="sueldo" class="control-label">Sueldo:</label>
                                                      <input type="text" class="form-control cantidades1" id="sueldo" name="sueldo" value='<?php echo $resEdit->sueldo; ?>' 
                                                      data-inputmask="'alias': 'numeric', 'autoGroup': true, 'digits': 2, 'digitsOptional': false">
                                                      <div id="mensaje_usuario_usuario" class="errores"></div>
                                </div>
                                </div>
                    			
                    			
                    		
                    		
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="hijos" class="control-label">Número Hijos:</label>
                                                      <input type="number" class="form-control" id="hijos" name="hijos" value="<?php echo $resEdit->hijos; ?>" placeholder="# hijos..">
                                                      <div id="mensaje_hijos" class="errores"></div>
                                </div>
                                </div>
                    		    
         	  </div>
			 
			 
			 
			 
			 <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="edad" class="control-label">Edad:</label>
                                                      <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $resEdit->edad; ?>" placeholder="edad..">
                                                      <div id="mensaje_edad" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_sexo" class="control-label">Género:</label>
                                                       <select name="id_sexo" id="id_sexo"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultSexo as $res) {?>
                        										<option value="<?php echo $res->id_sexo; ?>" <?php if ($res->id_sexo == $resEdit->id_sexo )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_sexo; ?> </option>
                        							        <?php } ?>
                        							   </select> 
                                                      <div id="mensaje_id_sexo" class="errores"></div>
                                </div>
                                </div>
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_estado_civil" class="control-label">Estado Civil:</label>
                                                      <select name="id_estado_civil" id="id_estado_civil"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEstado_civil as $res) {?>
                        										<option value="<?php echo $res->id_estado_civil; ?>" <?php if ($res->id_estado_civil == $resEdit->id_estado_civil )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_estado_civil; ?> </option>
                        							        <?php } ?>
                        							  </select> 
                                                      <div id="mensaje_id_estado_civil" class="errores"></div>
                                </div>
                                </div>
                    			
                    		
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_tipo_sangre" class="control-label">Tipo de Sangre:</label>
                                                      <select name="id_tipo_sangre" id="id_tipo_sangre"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultTipo_sangre as $res) {?>
                        										<option value="<?php echo $res->id_tipo_sangre; ?>" <?php if ($res->id_tipo_sangre == $resEdit->id_tipo_sangre )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_tipo_sangre; ?> </option>
                        							        <?php } ?>
                        							  </select> 
                                                      <div id="mensaje_id_tipo_sangre" class="errores"></div>
                                </div>
                                </div>
         	  </div>
			 
			 
			  <div class="row">
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                      <label for="id_estado" class="control-label">Estado:</label>
                                                      <select name="id_estado" id="id_estado"  class="form-control" disabled>
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultEstado as $res) {?>
                        										<option value="<?php echo $res->id_estado; ?>" <?php if ($res->id_estado == $resEdit->id_estado )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_estado; ?> </option>
                        							        <?php } ?>
                        							  </select> 
                                                      <div id="mensaje_id_estado" class="errores"></div>
                                </div>
                                </div>
                                
              </div>
			 
			 
  			</div>
  			</div>
  			
           
           <div class="col-lg-12 col-md-12 col-xs-12"  id="leer_mas" style="text-align: center;">
				  		 <button type="button" id="actualizar_participe" name="actualizar_participe" class="btn btn-primary""><i class="glyphicon glyphicon-plus"></i> Leer Mas</button>         
		   </div>
                       
           
             <div id="div_actualizar_datos_participes" style="display: none;">
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Datos Residencia Hogar</h4>
	         </div>
	         <div class="panel-body">
			 <div class="row">
                    		   
                    		    
             					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_provincias_vivienda" class="control-label">Provincia:</label>
                                                          <select name="id_provincias_vivienda" id="id_provincias_vivienda"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultProvincias as $res) {?>
                        										<option value="<?php echo $res->id_provincias; ?>" <?php if ($res->id_provincias == $resEdit->id_provincias_vivienda )  echo  'selected="selected"';  ?> ><?php echo $res->nombre_provincias; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_provincias_vivienda" class="errores"></div>
                                </div>
                    		    </div>       		    
                    		   
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_cantones_vivienda" class="control-label">Cantón:</label>
                                                          <select name="id_cantones_vivienda" id="id_cantones_vivienda"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                                                            <?php foreach($resultCantones as $res) {?>
                        										<option value="<?php echo $res->id_cantones; ?>" <?php if ($res->id_cantones == $resEdit->id_cantones_vivienda )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_cantones; ?> </option>
                        							        <?php } ?>
                        							      
                        								  </select> 
                                                          <div id="mensaje_id_cantones_vivienda" class="errores"></div>
                                </div>
                    		    </div>
                    		   
                    			
                    			<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_parroquias_vivienda" class="control-label">Parroquia:</label>
                                                          <select name="id_parroquias_vivienda" id="id_parroquias_vivienda"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        								  <?php foreach($resultParroquias as $res) {?>
                        										<option value="<?php echo $res->id_parroquias; ?>" <?php if ($res->id_parroquias == $resEdit->id_parroquias_vivienda )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_parroquias; ?> </option>
                        							        <?php } ?>
                        								  </select> 
                                                          <div id="mensaje_id_parroquias_vivienda" class="errores"></div>
                                </div>
                    		    </div>
                    			
            </div>
			</div>
  			</div>
           
           
             <div class="panel panel-info">
	         <div class="panel-heading">
	         <h4><i class='glyphicon glyphicon-home'></i> Datos Residencia Asignasión</h4>
	         </div>
	         <div class="panel-body">
			 
			 
			 <div class="row">
                    		   
                    		    
             					<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_provincias_asignacion" class="control-label">Provincia:</label>
                                                          <select name="id_provincias_asignacion" id="id_provincias_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        									<?php foreach($resultProvincias as $res) {?>
                        										<option value="<?php echo $res->id_provincias; ?>" <?php if ($res->id_provincias == $resEdit->id_provincias_asignacion )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_provincias; ?> </option>
                        							        <?php } ?>
                        								   </select> 
                                                          <div id="mensaje_id_provincias_asignacion" class="errores"></div>
                                </div>
                    		    </div>       		    
                    		   
                    		    
                    		    <div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_cantones_asignacion" class="control-label">Cantón:</label>
                                                          <select name="id_cantones_asignacion" id="id_cantones_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        							      
                        							      <?php foreach($resultCantones as $res) {?>
                        										<option value="<?php echo $res->id_cantones; ?>" <?php if ($res->id_cantones == $resEdit->id_cantones_asignacion )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_cantones; ?> </option>
                        							        <?php } ?>
                        							      
                        							      </select> 
                                                          <div id="mensaje_id_cantones_asignacion" class="errores"></div>
                                </div>
                    		    </div>
                    		   
                    			
                    			<div class="col-lg-3 col-xs-12 col-md-3">
                    		    <div class="form-group">
                                                          <label for="id_parroquias_asignacion" class="control-label">Parroquia:</label>
                                                          <select name="id_parroquias_asignacion" id="id_parroquias_asignacion"  class="form-control" >
                                                          <option value="0" selected="selected">--Seleccione--</option>
                        								  <?php foreach($resultParroquias as $res) {?>
                        										<option value="<?php echo $res->id_parroquias; ?>" <?php if ($res->id_parroquias == $resEdit->id_parroquias_asignacion )  echo  ' selected="selected" '  ;  ?> ><?php echo $res->nombre_parroquias; ?> </option>
                        							        <?php } ?>
                        								  </select> 
                                                          <div id="mensaje_id_parroquias_asignacion" class="errores"></div>
                                </div>
                    		    </div>
                        		
            </div>
			 
			<div class="row"> 
			 	
                    			<div class="col-lg-9 col-xs-12 col-md-9">
                    		    <div class="form-group">
                                                      <label for="observacion" class="control-label">Observación:</label>
                                                      <textarea type="text"  class="form-control" id="observacion" name="observacion" value=""  placeholder="observaciones.."><?php echo $resEdit->observacion; ?></textarea>
                                                      <div id="mensaje_observacion" class="errores"></div>
                                </div>
                    		    </div>
                    		    
                    		    
            </div>      		    
			 
			 
  			</div>
  			</div>
  			
  			  
			  			<div class="col-lg-12 col-md-12 col-xs-12 " style="text-align: center; margin-top: 10px">
				  		 <button type="submit" id="generar" name="generar" value=""   class="btn btn-success" style="margin-top: 10px;"><i class="glyphicon glyphicon-edit"></i> Actualizar Datos</button>         
					    </div>
  			
  			
            </div>
           
           
           	     <?php } } else {?>
           	     
           	     				<div class="col-lg-6 col-md-6 col-xs-12">
           	                    <div class="alert alert-warning alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<h4>Aviso!!!</h4> No hay datos para mostrar
								</div>
           	     				</div>
           	     
           	     <?php }?>
           
           
           </form>
           </div>
          
          
          
          
          
          
           
           <div class="tab-pane" id="proyecte_cesantia">
           <br>
           <form  action="<?php echo $helper->url("Usuarios","InsertaUsuarios"); ?>" method="post" enctype="multipart/form-data"  class="col-lg-12 col-md-12 col-xs-12">
          
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
           </section>
           
           
           </div>
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




