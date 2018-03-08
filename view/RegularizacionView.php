<!DOCTYPE HTML>
<?php require_once 'config/global.php';?> 
<html lang="es">
      <head>
        <meta charset="utf-8"/>
        <title>Regularizacion - aDocument 2017</title>
   
        <style>
            input{
                margin-top:5px;
                margin-bottom:5px;
            }
            .right{
                float:right;
            }
                
            
        </style>
    </head>
    <body style="background-color: #F6FADE">
    
       <?php include("view/modulos/head.php"); ?>
       
       <?php include("view/modulos/menu.php"); ?>
  
  
  
       
        <div class="container">
  
  	  <div class="row" style="background-color: #FAFAFA;">
       
      <form action="<?php echo $helper->url("Regularizacion","index"); ?>" method="post" class="col-lg-5">
            <h4 style="color:#ec971f;">Regularizacion de  Documentos</h4>
            <hr/>
				<?php echo $parametros; ?>
            	<div class="form-group">
          			<div class="row">
          				<div class="col-sm-6 col-md-4">
          					<input type="text" class="form-control" name="contenido_busqueda" id="criterio_busqueda" placeholder="texto a buscar">
          				</div>
          				<div class="col-sm-6 col-md-4">
          					<select id="criterio_busqueda" name="criterio_busqueda" class="form-control">
								<option value="1"  >Id Dcoumento</option>
								<option value="2"  >Numero de Credito</option>
								<option value="3"  >Identificacion Cliente</option>
							</select>
          				</div>
          				<div class="col-sm-6 col-md-4">
          					<button type="submit"  name="btnbuscar" class="btn btn-default"><span class="glyphicon glyphicon-search	" ><?php echo " Buscar" ;?> </span></button>
          				</div>
          			</div>
          		</div>	
          
          	<?php if (!empty($resultSet) && ($seleccionado == "SI")    ) {  foreach($resultSet as $res) {?>
        	  			
          <div class="row">
          	<div class="col-sm-6 col-md-6">
          		<p class="navbar-text">Fecha Presentacion</p>
          	</div>
          	<div class="col-sm-6 col-md-6">
          		<p class="navbar-text">Deudor</p>
          	</div>
          </div>			
		  <div class="row">
          	<div class="col-sm-6 col-md-6">
          		<input type="hidden" class="form-control" name="id_documentos_legal" id="id_documentos_legal" value="<?php echo $res->id_documentos_legal; ?>">
          		<input type="hidden" class="form-control" name="numero_regularizacion" id="numero_regularizacion" value="<?php echo $res->numero_credito_documentos_legal; ?>">
          		<input type="date" class="form-control" name="fecha_presentacion_regularizacion" id="fecha_presentacion_regularizacion" value="<?php echo substr($res->fecha_documentos_legal,0,10); ?>">
          	</div>
          	<div class="col-sm-6 col-md-6">
          		<select id="deudor_regularizacion" name="deudor_regularizacion" class="form-control">
					<option value="TRUE"  >SI</option>
					<option value="FALSE"  >NO</option>
				</select>
          		
          	</div>
          </div>			
		  
		    			
		  <div class="row">
          	<div class="col-sm-4 col-md-4">
          		<p class="navbar-text">Identificacion</p>
          	</div>
          	<div class="col-sm-8 col-md-8">
          		<p class="navbar-text">Nombre y Apellidos</p>
          	</div>
          </div>			
		  <div class="row">
          	<div class="col-sm-6 col-md-6">
          		<input type="text" class="form-control" name="identificacion_regularizacion" id="identificacion_regularizacion" value=" <?php echo $res->ruc_cliente_proveedor; ?> " >
          	</div>
          	<div class="col-sm-6 col-md-6">
          		<input type="text" class="form-control" name="nombre_regularizacion" id="nombre_regularizacion" value="<?php echo $res->nombre_cliente_proveedor; ?>">
          	</div>
          </div>			
		
		  <div class="row">
          	<div class="col-sm-4 col-md-4">
          		<p class="navbar-text">Monto Dolares</p>
          	</div>
          	<div class="col-sm-4 col-md-4">
          		<p class="navbar-text">Plazo Meses</p>
          	</div>
          	  	<div class="col-sm-4 col-md-4">
          		<p class="navbar-text">Destino Dinero</p>
          	</div>
        
          </div>			
		  <div class="row">
          	<div class="col-sm-4 col-md-4">
          		<input type="text" class="form-control" name="monto_dolares_regularizacion" id="monto_dolares_regularizacion" value=" <?php echo $res->monto_documentos_legal; ?>">
          	</div>
          	<div class="col-sm-4 col-md-4">
          		<input type="text" class="form-control" name="plazo_meses_regularizacion" id="plazo_meses_regularizacion" value=" <?php echo $res->plazo_meses_documentos_legal; ?>">
          	</div>
          	<div class="col-sm-4 col-md-4">
          		<input type="text" class="form-control" name="destino_dinero_regularizacion" id="destino_dinero_regularizacion" value=" <?php echo $res->destino_documentos_legal; ?>">
          	</div>
          	
          </div>			
		    <hr>
		  <div class="row">
          	<div class="col-sm-4 col-md-4">
          		<input type="date" class="form-control" name="fecha_regularizacion" id="fecha_regularizacion" value="<?php echo substr($res->fecha_documentos_legal,0,10); ?>">
          	</div>
          	<div class="col-sm-4 col-md-4">
          		
          	</div>
          	<div class="col-sm-4 col-md-4">
          		<input type="submit" name="btnGuardar" value="Guardar" class="btn btn-success"/>
          	</div>
          	
          </div>			
			 	 	
						
			
           
		  <hr>
			
			  <?php }?>
		  
		  <?php }?>
		  
          </form>
       
        <?php if (!empty($resultSet)) {  foreach($resultSet as $res) {?>
        
        
        <div class="col-lg-7">
            <h4 style="color:#ec971f;">Detalle del Documentos</h4>
            <hr/>
        </div>
        <section class="col-lg-7 usuario" style="height:600px;overflow-y:scroll;">
        <table class="table table-hover">
	         <tr>
	    		<th style="font-size:85%;">Id</th>
	    		<th style="font-size:85%;">Fecha</th>
	    		<th style="font-size:85%;" >Numero</th>
	    		<th style="font-size:85%;">RUC/CI</th>
	    		<th style="font-size:85%;">Nombre</th>
	    		<th style="font-size:85%;">Monto</th>
	    		<th style="font-size:85%;">Plazo</th>
	    		<th style="font-size:85%;">Destino</th>
	    		<th></th>
	    		<th></th>
	  		  </tr>
            
	          <tr>
	              <td style="font-size:85%;"> <?php echo $res->id_documentos_legal; ?>  </td>
	              <td style="font-size:85%;"> <?php echo substr($res->fecha_documentos_legal,0,10); ?>  </td>
		          <td style="font-size:85%;"> <?php echo $res->numero_credito_documentos_legal; ?>     </td> 
		          <td style="font-size:85%;"> <?php echo $res->ruc_cliente_proveedor; ?>  </td>
		          <td style="font-size:85%;"> <?php echo $res->nombre_cliente_proveedor; ?>  </td>
		          <td style="font-size:85%;"> <?php echo $res->monto_documentos_legal; ?>  </td>
		          <td style="font-size:85%;"> <?php echo $res->plazo_meses_documentos_legal; ?>  </td>
		          <td style="font-size:85%;"> <?php echo $res->destino_documentos_legal; ?>  </td>
		          
		          <td>
		          	<a href="<?php echo $helper->url("Regularizacion","index"); ?>&id_documentos_legal=<?php echo $res->id_documentos_legal; ?>" class="btn btn-success" ><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> </a>
		          </td>
		         <?php if ($res->regularizado == "t")  {?>	
		          <td>
		            <a href=" <?php echo IP_REG . $res->id_documentos_legal; ?>  " class="btn btn-warning" target="blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a> 
		          	
		          </td>
		          <?php } ?>
		   		</tr>
	      
            
       	  </table>     
        </section>
	      
	      <?php } } ?>
            
            
      </div>
       </div>
       
        <footer class="col-lg-12">
           <?php include("view/modulos/footer.php"); ?>
        </footer>
     </body>  
    </html>   