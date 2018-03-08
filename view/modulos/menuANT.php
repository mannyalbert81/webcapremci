
<?php 
$controladores=$_SESSION['controladores'];
 function getcontrolador($controlador,$controladores){
 	$display="display:none";
 	
 	if (!empty($controladores))
 	{
 	foreach ($controladores as $res)
 	{
 		if($res->nombre_controladores==$controlador)
 		{
 			$display= "display:block";
 			break;
 			
 		}
 	}
 	}
 	
 	return $display;
 }
?>






<div class="container" style="margin-top: 20px; " >
<div class="row">

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      
        
        <li class="dropdown" style="<?php echo getcontrolador("MenuAdministracion",$controladores) ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-modal-window" ><?php echo " Administración" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          
            <li style="<?php echo getcontrolador("Usuarios",$controladores) ?>">
			<a href="index.php?controller=Usuarios&action=index"><span class="glyphicon glyphicon-user" aria-hidden="true"> Usuarios</span></a>
		    </li>
			
			<li style="<?php echo getcontrolador("Roles",$controladores) ?>">
			<a href="index.php?controller=Roles&action=index"> <span class=" glyphicon glyphicon-asterisk" aria-hidden="true"> Roles de Usuario</span> </a>
			</li>
			<li style="<?php echo getcontrolador("PermisosRoles",$controladores) ?>">
			<a href="index.php?controller=PermisosRoles&action=index"><span class="glyphicon glyphicon-plus" aria-hidden="true"> Permisos Roles</span> </a>
            </li>
          
			<li><a href="index.php?controller=RegistroCartonDocumentos&action=index">Registro de Cartones</a>
			</li>
				
	          
          </ul>
        </li>
        <li class="dropdown" style="<?php echo getcontrolador("MenuDocumentos",$controladores) ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-file" ><?php echo " Gestión Documental" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        
			<li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
			<a href="index.php?controller=Documentos&action=index"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Búsqueda de Documentos</span></a>
			</li>
			<li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
			<a href="index.php?controller=DocumentosClienteProveedor&action=index"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Búsqueda Categorias + Cliente / Proveedor</span></a>
			</li>
			<li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
			<a href="index.php?controller=DocumentosTipoDocumentos&action=index"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Búsqueda Categorias + Tipo Documentos</span></a>
			</li>
	        <li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
	        <a href="index.php?controller=DocumentosCartonDocumentos&action=index"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Búsqueda Categorias + Carton Documentos</span></a>
			</li>
			<li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
			<a href="index.php?controller=DocumentosNumeroCredito&action=index"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Búsqueda Categorias + Número de Credito</span></a>
			</li>
			
          </ul>
          
         
        </li>
        

        
        <li class="dropdown" style="<?php echo getcontrolador("MenuInformes",$controladores) ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-print	" ><?php echo " Informes" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
        	<li style="<?php echo getcontrolador("Categorias",$controladores) ?>">
        	<a href="index.php?controller=Categorias&action=ReporteTotal" target="blank"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Documentos por Categorías</span></a>
			</li>
			<li style="<?php echo getcontrolador("Categorias",$controladores) ?>">
			<a href="index.php?controller=SubCategorias&action=ReporteTotal" target="blank"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Documentos por SubCategorías</span></a>
			</li>
			<li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
			<a href="index.php?controller=Documentos&action=BuscaxCarton" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Documentos por Cartón</span></a>
			</li>
			<li><a href="index.php?controller=CartonDocumentos&action=ReporteTotal" target="blank"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Listado de Cartones Registrados</span></a>
			</li>
			
			<li><a href="index.php?controller=CartonDocumentos&action=FechaCartones" target="blank"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Listado de Cartones con Rangos de Fechas</span></a>
			</li>
			
			
		
          </ul>
        </li>
        <li class="dropdown" style="<?php echo getcontrolador("MenuUtilitarios",$controladores) ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-modal-window" ><?php echo " Utilitarios" ;?> </span> <span class="caret"></span></a>
          <ul class="dropdown-menu">
          
			<li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
			<a href="index.php?controller=Documentos&action=ActualizarDocumentos"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Actualizar Documentos</span></a>
			</li>
			
			<li style="<?php echo getcontrolador("Documentos",$controladores) ?>">
			<a href="index.php?controller=VerificarCapremci&action=index"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Verificar Capremci</span></a>
			</li>
			  	<li style="<?php echo getcontrolador("ErroresImportacion",$controladores) ?>">
			<a href="index.php?controller=ErroresImportacion&action=index"><span class="glyphicon glyphicon-plus" aria-hidden="true"> Errores Importacion</span> </a>
            </li>
			
			
		  </ul>
        </li>
        
        
      </ul>
      <form class="navbar-form" role="search" action="<?php echo $helper->url("Documentos","Buscador");?>"  method="post" class="col-lg-5"  >
  		
  		    <div class="row">
		    
		    
		    <div class="col-xs-12 col-md-2">
		    <div class="form-group">
                                <input type="text" class="form-control" id="criterio_busqueda" name="contenido_busqueda" value=""  placeholder="Texto a Buscar">
            </div>
            </div>
            <div class="col-xs-12 col-md-2" style="margin-left: 17px;">
            <div class="form-group">
                <select name="criterio_busqueda" id="criterio_busqueda"  class="form-control" >
           		<option value="0"  > --TODOS--</option>
				<option value="1"  >Ruc Cliente/Proveedor</option>
				<option value="2"  >Nombre Cliente/Proveedor</option>
				<option value="3"  >Número Carton</option>
				<option value="4"  >Número Credito</option>
				<option value="7"  >Tipo de Documento</option>
				<option value="8"  >Número de Prestación</option>
		 </select>
						   		
         </div>
		    </div>
		    <div class="col-xs-12 col-md-1" style="margin-left: 15px">
		    <button type="submit"  name="btn_buscar" class="btn btn-default"><span class="glyphicon glyphicon-search" ></span></button>
            </div>
			</div> 
		
        </form>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  
</nav>
       
        
</div>
</div>

