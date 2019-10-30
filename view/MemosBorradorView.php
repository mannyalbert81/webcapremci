


<!DOCTYPE HTML>
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Memos - Capremci</title>
		
		<link rel="stylesheet" href="view/css/estilos.css">
		
			<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		    <!-- Bootstrap -->
    		<link href="view/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    		<!-- Font Awesome -->
		    <link href="view/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		    <!-- Custom Theme Style -->
		    <link href="view/build/css/custom.min.css" rel="stylesheet">

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
      
      
      
     
   
    
			        
    </head>
    
    
  <body class="nav-md">
  		
  		<?php
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha=$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        ?>
    
    
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
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
         <li class="active">Crear Memorando</li>
         </ol>
         </section>
        
          
          
        <form action="<?php echo $helper->url("Memos","index"); ?>" method="post">      
	         <div class="col-xs-12 col-md-12 col-lg-12" style="margin-left: 10px;">
	              <button type="submit" id="refrescar" name="refrescar" onclick="this.form.action='<?php echo $helper->url("Memos","index"); ?>'" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-refresh"> Refrescar</i></button>
	            
	              <?php if(!empty($envia_memo)){  if($envia_memo=='t'){  ?>
	              <button type="submit" id="componer" name="componer" onclick="this.form.action='<?php echo $helper->url("Memos","addindex"); ?>'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-pencil"> Componer</i></button>
	             <?php  }else{?>
	              <button type="submit" id="componer" name="componer" onclick="this.form.action='<?php echo $helper->url("Memos","addindex"); ?>'" disabled class="btn btn-success btn-sm"><i class="glyphicon glyphicon-pencil"> Componer</i></button>
	         
	              <?php  }}?>
	            
	         </div>
        </form>
           
          
         <div class="col-lg-12 col-md-12 col-xs-12">
             <div class="col-md-2 col-lg-2 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Folders<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                   <div class="clearfix"></div>
                 </div>
       
	       <div class="x_content">
	          <div class="col-md-12 col-lg-12 col-xs-12">
	            <div class="box-body no-padding">
	              <ul class="nav nav-pills nav-stacked">
	                <li><a href="<?php echo $helper->url("Memos","index"); ?>"><i class="fa fa-inbox"></i> Inbox
	                   <?php if(!empty($cantidadimbox)){  if($cantidadimbox>0){?>
	                  <span class="label label-primary pull-right"><?php echo $cantidadimbox;?></span>
	                  <?php }  }?>
	                  </a></li>
	                <li><a href="<?php echo $helper->url("Memos","sentindex"); ?>"><i class="fa fa-envelope-o"></i> Sent
	                 <?php if(!empty($cantidadsent)){  if($cantidadsent>0){?>
	                  
	                  <span class="label label-warning pull-right"><?php echo $cantidadsent;?></span>
	                  <?php }  }?>
	                </a></li>
	                <li><a href="<?php echo $helper->url("Memos","draftindex"); ?>"><i class="fa fa-file-text-o"></i> Drafts</a></li>
	                <li><a href="<?php echo $helper->url("Memos","junkindex"); ?>"><i class="fa fa-filter"></i> Junk</a>
	                </li>
	                <li><a href="<?php echo $helper->url("Memos","trashindex"); ?>"><i class="fa fa-trash-o"></i> Trash</a></li>
	              </ul>
	            </div>
	           </div>
	          </div>
	         </div>
	        </div>
        
        
        
        	 <div class="col-md-10 col-lg-10 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Drafts<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                 <div class="x_content">
        
           
                        <div class="col-lg-6 col-md-6 col-xs-12">
    					<div class="alert alert-warning alert-dismissable" style="margin-top:20px;">
    					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    					<h4>Aviso!!!</h4> <b>Actualmente no hay memorando guardados en borrador...</b>
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



    <script src="view/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="view/build/js/custom.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
		
  </body>
</html>   