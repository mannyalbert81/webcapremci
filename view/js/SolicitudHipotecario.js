$(document).ready(function(){
	
	cargaGeneroDatosPersonales();
	cargaEstadoCivilDatosPersonales();
	cargaProvinciasDatosPersonales();
	cargaCantonesDatosPersonales();
	cargaParroquiasDatosPersonales();
	cargaProvinciasDatosLaborales();
	cargaCantonesDatosLaborales();
	cargaParroquiasDatosLaborales();
	cargaGeneroDatosConyuge();
	cargaProvinciasDatosConyuge();
	cargaProvinciasEconomicosDatosConyuge();
	cargaBancosDatosEconomicos();
	cargaBancosDosDatosEconomicos();
	cargaBancostresDatosEconomicos();
	cargaBancoscuatroDatosEconomicos();
	cargaBancosCincoDatosEconomicos();
	cargaBancosUnodetalleActivos();
	cargaBancosDosdetalleActivos();
	cargaBancosTresdetalleActivos();
	cargaBancosCuatrodetalleActivos();
	cargaInstitucionesDatosLaborables();
	cargaSucursalesDatosGenerales();


	
})




function cargaGeneroDatosPersonales(){
	
	let $ddlGenero = $("#id_sexo");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaGeneroDatosPersonales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlGenero.empty();
		$ddlGenero.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlGenero.append("<option value= " +value.id_sexo +" >" + value.nombre_sexo  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlGenero.empty();
		$ddlGenero.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}


function cargaEstadoCivilDatosPersonales(){
	
	let $ddlEsCivil = $("#id_estado_civil");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaEstadoCivilDatosPersonales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlEsCivil.empty();
		$ddlEsCivil.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlEsCivil.append("<option value= " +value.id_estado_civil +" >" + value.nombre_estado_civil  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlEsCivil.empty();
		$ddlEsCivil.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}


function limpiar(){
	
	
	 $("#id_estado_civil").val('0');
	 $("#apellidos_solicitud_prestaciones").val('');
	 
	
	
}



function cargaProvinciasDatosPersonales(){
	
	let $ddlProvincias = $("#id_provincia");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaProvinciasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlProvincias.append("<option value= " +value.id_provincias +" >" + value.nombre_provincias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
	})
}
//cargar cantones
function cargaCantonesDatosPersonales(id_provincia){
	
	let $dllCantones = $("#id_canton");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaCantonesDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_provincias:id_provincia}
	}).done(function(datos){		
		
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllCantones.append("<option value= " +value.id_cantones +" >" + value.nombre_cantones  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_provincia").change(function() {
	

	
      var id_provincias = $(this).val();
      let $dllCantones = $("#id_canton");
      $dllCantones.empty();
      cargaCantonesDatosPersonales(id_provincias);
      
      
   
   });
	

// cargar parroquias


function cargaParroquiasDatosPersonales(id_canton){
	
	let $dllParroquias = $("#id_parroquia");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaParroquiasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_cantones:id_canton}
	}).done(function(datos){		
		
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllParroquias.append("<option value= " +value.id_parroquias +" >" + value.nombre_parroquias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_canton").change(function() {
	

	
      var id_cantones = $(this).val();
      let $dllParroquias = $("#id_parroquia");
      $dllParroquias.empty();
      cargaParroquiasDatosPersonales(id_cantones);
      
      
   
   });


/// enviar codigo

$("#btn_enviar").click(function() 
			{

		    	$('#id_codigo_verificacion').val("0");
		    	$('#numero_codigo_verificacion').val("");
		    	
		    	var celular_datos_personales = $("#celular_datos_personales").val();
		    	var numero_codigo_verificacion = $("#numero_codigo_verificacion").val();
		    	


		    	if (celular_datos_personales == "" )
		    	{
		    		swal("Alerta!", "Ingrese Celular", "error")
                   return false;
		    		
			    }
		    	else 
		    	{


		    		if(isNaN(celular_datos_personales)){

		    			swal("Alerta!", "Ingrese Solo Números", "error")
	                    return false;

					}
		    		
		    		if(celular_datos_personales.length==10){

						
					}else{
						
						swal("Alerta!", "Ingrese 10 Dgts.", "error")
	                    return false;

					}
 	
		            
				}





		    	var parametros = {celular_datos_personales:celular_datos_personales}
	    		$.ajax({
	    			beforeSend:function(){},
	    			url:"index.php?controller=SolicitudHipotecario&action=EnviarSMS",
	    			type:"POST",
	    			dataType:"json",
	    			data:parametros
	    		}).done(function(respuesta){
	    					
	    			if(respuesta.valor == 1 ){
	    				$('#id_codigo_verificacion').val("0");
	    				swal("Alerta!", "Enviado Correctamente", "success")
	               	
	    		    }else{
	    		    	$('#id_codigo_verificacion').val("0");
	    		    	swal("Alerta!", respuesta.mensaje, "error")
		    		}
	    			
	    			
	    		}).fail(function(xhr,status,error){
	    			
	    			var err = xhr.responseText
	    			console.log(err);
	    			$('#id_codigo_verificacion').val("0");
	    			swal("Alerta!", "Mensaje no Enviado", "error")
                  
	    			
	    		}).always(function(){
	    					
	    		})
	    		
	    		event.preventDefault();
				
   	      
			}); 


//// verificar código

$("#btn_verificar").click(function() 
			{
		    	
		    	var celular_datos_personales = $("#celular_datos_personales").val();
		    	var numero_codigo_verificacion = $("#numero_codigo_verificacion").val();
		    	var id_codigo_verificacion = $("#id_codigo_verificacion").val();


				if (id_codigo_verificacion > 0 ){
					swal("Alerta!", "Código Validado Correctamente", "success")
                   return false;

				}else{

					
				}

		    	
		    	if (numero_codigo_verificacion == "" )
		    	{
		    		swal("Alerta!", "Ingrese Código Verificación", "error")
                   return false;
		    		
			    }
		    	else 
		    	{


		    		if(isNaN(numero_codigo_verificacion)){

		    			swal("Alerta!", "Ingrese Solo Números", "error")
	                    return false;

					}
		    		
		    		if(numero_codigo_verificacion.length==5){

						
					}else{
						
						swal("Alerta!", "Ingrese 5 Dgts.", "error")
	                    return false;
					}
 		            
				}


		    	var parametros = {numero_codigo_verificacion:numero_codigo_verificacion}
	    		$.ajax({
	    			beforeSend:function(){},
	    			url:"index.php?controller=SolicitudHipotecario&action=Validar_Codigo_Verificacion",
	    			type:"POST",
	    			dataType:"json",
	    			data:parametros
	    		}).done(function(respuesta){
	    					
	    			if(respuesta.valor > 0 ){

	    				$('#id_codigo_verificacion').val(respuesta.id_codigo_verificacion);
	    				swal("Alerta!", "Código Validado Correctamente", "success")
	               	    
	    		    }
	    			
	    			
	    		}).fail(function(xhr,status,error){
	    			
	    			var err = xhr.responseText
	    			console.log(err);
	    			$('#id_codigo_verificacion').val("0");
	    			swal("Alerta!", "Código no Validado", "error")
                  
	    			
	    		}).always(function(){
	    					
	    		})
	    		
	    		event.preventDefault();
				
   	      
			}); 


//cargar direccion datos laborales


function cargaProvinciasDatosLaborales(){
	
	let $ddlProvincias = $("#id_provincia_datos_laborales");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaProvinciasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlProvincias.append("<option value= " +value.id_provincias +" >" + value.nombre_provincias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
	})
}

//cargar cantones
function cargaCantonesDatosLaborales(id_provincia_datos_laborales){
	
	let $dllCantones = $("#id_canton_datos_laborales");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaCantonesDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_provincias:id_provincia_datos_laborales}
	}).done(function(datos){		
		
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllCantones.append("<option value= " +value.id_cantones +" >" + value.nombre_cantones  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_provincia_datos_laborales").change(function() {
	

	
      var id_provincias = $(this).val();
      let $dllCantones = $("#id_canton_datos_laborales");
      $dllCantones.empty();
      cargaCantonesDatosLaborales(id_provincias);
      
      
   
   });
	
//cargar parroquias


function cargaParroquiasDatosLaborales(id_canton_datos_laborales){
	
	let $dllParroquias = $("#id_parroquia_datos_laborales");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaParroquiasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_cantones:id_canton_datos_laborales}
	}).done(function(datos){		
		
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllParroquias.append("<option value= " +value.id_parroquias +" >" + value.nombre_parroquias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_canton_datos_laborales").change(function() {
	

	
      var id_cantones = $(this).val();
      let $dllParroquias = $("#id_parroquia_datos_laborales");
      $dllParroquias.empty();
      cargaParroquiasDatosLaborales(id_cantones);
      
      
   
   });
	
function cargaGeneroDatosConyuge(){
	
	let $ddlGenero = $("#id_sexo_datos_conyuge");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaGeneroDatosPersonales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlGenero.empty();
		$ddlGenero.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlGenero.append("<option value= " +value.id_sexo +" >" + value.nombre_sexo  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlGenero.empty();
		$ddlGenero.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}



function cargaSucursalesDatosGenerales(){
	
	let $ddlSucursal = $("#id_sucursales");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaSucursalesDatosGenerales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlSucursal.empty();
		$ddlSucursal.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlSucursal.append("<option value= " +value.id_sucursales +" >" + value.nombre_sucursales  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlSucursal.empty();
		$ddlSucursal.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

function cargaInstitucionesDatosLaborables(){
	
	let $ddlInstituciones = $("#id_entidades");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaInstitucionesDatosLaborables",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlInstituciones.empty();
		$ddlInstituciones.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlInstituciones.append("<option value= " +value.id_entidades +" >" + value.nombre_entidades  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlInstituciones.empty();
		$ddlInstituciones.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}


//cargar Provincias Datos Conyuge

function cargaProvinciasDatosConyuge(){
	
	let $ddlProvincias = $("#id_provincia_datos_conyuge");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaProvinciasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlProvincias.append("<option value= " +value.id_provincias +" >" + value.nombre_provincias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
	})
}

//cargar cantones
function cargaCantonesDatosConyuge(id_provincia_datos_conyuge){
	
	let $dllCantones = $("#id_canton_datos_conyuge");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaCantonesDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_provincias:id_provincia_datos_conyuge}
	}).done(function(datos){		
		
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllCantones.append("<option value= " +value.id_cantones +" >" + value.nombre_cantones  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_provincia_datos_conyuge").change(function() {
	

	
      var id_provincias = $(this).val();
      let $dllCantones = $("#id_canton_datos_conyuge");
      $dllCantones.empty();
      cargaCantonesDatosConyuge(id_provincias);
      
      
   
   });
	
//cargar parroquias


function cargaParroquiasDatosConyuge(id_canton_datos_conyuge){
	
	let $dllParroquias = $("#id_parroquia_datos_conyuge");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaParroquiasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_cantones:id_canton_datos_conyuge}
	}).done(function(datos){		
		
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllParroquias.append("<option value= " +value.id_parroquias +" >" + value.nombre_parroquias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_canton_datos_conyuge").change(function() {
	

	
      var id_cantones = $(this).val();
      let $dllParroquias = $("#id_parroquia_datos_conyuge");
      $dllParroquias.empty();
      cargaParroquiasDatosConyuge(id_cantones);
      
      
   
   });



//cargar Provincias Datos Económicos Conyuge

function cargaProvinciasEconomicosDatosConyuge(){
	
	let $ddlProvincias = $("#id_provincia_trabajo_datos_conyuge");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaProvinciasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlProvincias.append("<option value= " +value.id_provincias +" >" + value.nombre_provincias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlProvincias.empty();
		$ddlProvincias.append("<option value='0' >--Seleccione--</option>");
		
	})
}

//cargar cantones
function cargaCantonesEconomicosDatosConyuge(id_provincia_trabajo_datos_conyuge){
	
	let $dllCantones = $("#id_canton_trabajo_datos_conyuge");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaCantonesDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_provincias:id_provincia_trabajo_datos_conyuge}
	}).done(function(datos){		
		
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllCantones.append("<option value= " +value.id_cantones +" >" + value.nombre_cantones  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllCantones.empty();
		$dllCantones.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_provincia_trabajo_datos_conyuge").change(function() {
	

	
      var id_provincias = $(this).val();
      let $dllCantones = $("#id_canton_trabajo_datos_conyuge");
      $dllCantones.empty();
      cargaCantonesEconomicosDatosConyuge(id_provincias);
      
      
   
   });
	
//cargar parroquias


function cargaParroquiasEconomicosDatosConyuge(id_canton_trabajo_datos_conyuge){
	
	let $dllParroquias = $("#id_parroquia_trabajo_datos_conyuge");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaParroquiasDatosPersonales",
		type:"POST",
		dataType:"json",
		data:{id_cantones:id_canton_trabajo_datos_conyuge}
	}).done(function(datos){		
		
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$dllParroquias.append("<option value= " +value.id_parroquias +" >" + value.nombre_parroquias  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$dllParroquias.empty();
		$dllParroquias.append("<option value='0' >--Seleccione--</option>");
		
	})
	
}

$("#id_canton_trabajo_datos_conyuge").change(function() {
	

	
      var id_cantones = $(this).val();
      let $dllParroquias = $("#id_parroquia_trabajo_datos_conyuge");
      $dllParroquias.empty();
      cargaParroquiasEconomicosDatosConyuge(id_cantones);
      
      
   
   });

///cargar bancos datos económicos



function cargaBancosDatosEconomicos(){
	
	let $ddlBancos = $("#id_bancos_referencia_bancaria");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}

function cargaBancosDosDatosEconomicos(){
	
	let $ddlBancos = $("#id_bancos_uno_datos_economicos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}

function cargaBancostresDatosEconomicos(){
	
	let $ddlBancos = $("#id_bancos_dos_datos_economicos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}


function cargaBancoscuatroDatosEconomicos(){
	
	let $ddlBancos = $("#id_bancos_tres_datos_economicos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}






function cargaBancosCincoDatosEconomicos(){
	
	let $ddlBancos = $("#id_bancos_cuatro_datos_economicos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}

function cargaBancosUnodetalleActivos(){
	
	let $ddlBancos = $("#id_bancos_uno_detalle_activos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}


function cargaBancosDosdetalleActivos(){
	
	let $ddlBancos = $("#id_bancos_dos_detalle_activos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}

function cargaBancosTresdetalleActivos(){
	
	let $ddlBancos = $("#id_bancos_tres_detalle_activos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}


function cargaBancosCuatrodetalleActivos(){
	
	let $ddlBancos = $("#id_bancos_cuatro_detalle_activos");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudHipotecario&action=cargaBancos",
		type:"POST",
		dataType:"json",
		data:null
	}).done(function(datos){		
		
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
		$.each(datos.data, function(index, value) {
			$ddlBancos.append("<option value= " +value.id_bancos +" >" + value.nombre_bancos  + "</option>");	
  		});
		
	}).fail(function(xhr,status,error){
		var err = xhr.responseText
		console.log(err)
		$ddlBancos.empty();
		$ddlBancos.append("<option value='0' >--Seleccione--</option>");
		
	})
}

function checkIt(evt) {
    evt = (evt) ? evt : window.event
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        status = "This field accepts numbers only."
        return false
    }
    status = ""
    return true
}










// INSERTAR SOLICITUD

	$("#btn_Guardar").click(function() 
	{

			    	
		    	var id_solicitud_hipotecario = $("#id_solicitud_hipotecario").val();
		    	var valor_dolares_datos_credito = $("#valor_dolares_datos_credito").val();
		    	var plazo_meses_datos_credito = $("#plazo_meses_datos_credito").val();
		    	var destino_dinero_datos_credito = $("#destino_dinero_datos_credito").val();
		    	var cedula_datos_personales = $("#cedula_datos_personales").val();
		    	var nombres_datos_personales = $("#nombres_datos_personales").val();
		    	var apellidos_datos_personales = $("#apellidos_datos_personales").val();
		    	var id_sexo = $("#id_sexo").val();
		    	var id_estado_civil = $("#id_estado_civil").val();
		    	var fecha_nacimiento_datos_personales = $("#fecha_nacimiento_datos_personales").val();
		    	var separacion_bienes_datos_personales = $("#separacion_bienes_datos_personales").val();
		    	var cargas_familiares_datos_personales = $("#cargas_familiares_datos_personales").val();
		    	var numero_hijos_datos_personales = $("#numero_hijos_datos_personales").val();
		    	var email_datos_personales = $("#email_datos_personales").val();
		    	var nivel_educativo_datos_personales = $("#nivel_educativo_datos_personales").val();
		    	var id_provincia = $("#id_provincia").val();
		    	var id_canton = $("#id_canton").val();
		    	var id_parroquia = $("#id_parroquia").val();
		    	var barrio_datos_personales = $("#barrio_datos_personales").val();
		    	var ciudadela_datos_personales = $("#ciudadela_datos_personales").val();
		    	var calle_datos_personales = $("#calle_datos_personales").val();
		    	var numero_calle_datos_personales = $("#numero_calle_datos_personales").val();
		    	var interseccion_datos_personales = $("#interseccion_datos_personales").val();
		    	var tipo_vivienda_datos_personales = $("#tipo_vivienda_datos_personales").val();
		    	var vivienda_hipotecada_datos_personales = $("#vivienda_hipotecada_datos_personales").val();
		    	var tiempo_residencia_datos_personales = $("#tiempo_residencia_datos_personales").val();
		    	var referencia_domiciliaria_datos_perdonales = $("#referencia_domiciliaria_datos_perdonales").val();
		    	var nombre_arrendatario_datos_personales = $("#nombre_arrendatario_datos_personales").val();
		    	var apellido_arrendatario_datos_personales = $("#apellido_arrendatario_datos_personales").val();
		    	var celular_arrendatario_datos_personales = $("#celular_arrendatario_datos_personales").val();
		    	var telefono_datos_personales = $("#telefono_datos_personales").val();
		    	var celular_datos_personales = $("#celular_datos_personales").val();
		    	var telf_trabajo_datos_personales = $("#telf_trabajo_datos_personales").val();
		    	var ext_telef_datos_personales = $("#ext_telef_datos_personales").val();
		    	var node_telef_datos_personales = $("#node_telef_datos_personales").val();
		    	var id_codigo_verificacion = $("#id_codigo_verificacion").val();
		    	var nombres_referencia_familiar_datos_personales = $("#nombres_referencia_familiar_datos_personales").val();
		    	var apellidos_referencia_familiar_datos_personales = $("#apellidos_referencia_familiar_datos_personales").val();
		    	var parentesco_referencia_familiar_datos_personales = $("#parentesco_referencia_familiar_datos_personales").val();
		    	var primer_telefono_ref_familiar_datos_personales = $("#primer_telefono_ref_familiar_datos_personales").val();
		    	var segundo_telefono_ref_familiar_datos_personales = $("#segundo_telefono_ref_familiar_datos_personales").val();
		    	var nombres_referencia_personal_datos_personales = $("#nombres_referencia_personal_datos_personales").val();
		    	var apellidos_referencia_personal_datos_personales = $("#apellidos_referencia_personal_datos_personales").val();
		    	var relacion_referencia_personal_datos_personales = $("#relacion_referencia_personal_datos_personales").val();
		    	var primer_telefono_ref_personal_datos_personales = $("#primer_telefono_ref_personal_datos_personales").val();
		    	var segundo_telefono_ref_personal_datos_personales = $("#segundo_telefono_ref_personal_datos_personales").val();
		    	var id_entidades = $("#id_entidades").val();
		    	var reparto_unidad_datos_laborales = $("#reparto_unidad_datos_laborales").val();
		    	var seccion_datos_laborales = $("#seccion_datos_laborales").val();
		    	var nombres_jefe_datos_laborales = $("#nombres_jefe_datos_laborales").val();
		    	var apellidos_jefe_datos_laborales = $("#apellidos_jefe_datos_laborales").val();
		    	var telefono_jefe_datos_laborales = $("#telefono_jefe_datos_laborales").val();
		    	var cargo_actual_datos_laborales = $("#cargo_actual_datos_laborales").val();
		    	var anios_servicio_datos_laborales = $("#anios_servicio_datos_laborales").val();
		    	var id_provincia_datos_laborales = $("#id_provincia_datos_laborales").val();
		    	var id_canton_datos_laborales = $("#id_canton_datos_laborales").val();
		    	var id_parroquia_datos_laborales = $("#id_parroquia_datos_laborales").val();
		    	var calle_datos_laborales = $("#calle_datos_laborales").val();
		    	var numero_calle_datos_laborales = $("#numero_calle_datos_laborales").val();
		    	var interseccion_datos_laborales = $("#interseccion_datos_laborales").val();
		    	var referencia_direccion_trabajo_datos_laborales = $("#referencia_direccion_trabajo_datos_laborales").val();
		    	var cedula_datos_conyuge = $("#cedula_datos_conyuge").val();
		    	var nombres_datos_conyuge = $("#nombres_datos_conyuge").val();
		    	var apellidos_datos_conyuge = $("#apellidos_datos_conyuge").val();
		    	var id_sexo_datos_conyuge = $("#id_sexo_datos_conyuge").val();
		    	var fecha_nacimiento_datos_conyuge = $("#fecha_nacimiento_datos_conyuge").val();
		    	var vive_residencia_datos_conyuge = $("#vive_residencia_datos_conyuge").val();
		    	var telefono_datos_conyuge = $("#telefono_datos_conyuge").val();
		    	var celular_datos_conyuge = $("#celular_datos_conyuge").val();
		    	var id_provincia_datos_conyuge = $("#id_provincia_datos_conyuge").val();
		    	var id_canton_datos_conyuge = $("#id_canton_datos_conyuge").val();
		    	var id_parroquia_datos_conyuge = $("#id_parroquia_datos_conyuge").val();
		    	var barrio_datos_conyuge = $("#barrio_datos_conyuge").val();
		    	var ciudadela_datos_conyuge = $("#ciudadela_datos_conyuge").val();
		    	var calle_datos_conyuge = $("#calle_datos_conyuge").val();
		    	var numero_calle_datos_conyuge = $("#numero_calle_datos_conyuge").val();
		    	var interseccion_datos_conyuge = $("#interseccion_datos_conyuge").val();
		    	var actividad_economica_datos_conyuge = $("#actividad_economica_datos_conyuge").val();
		    	var empresa_datos_conyuge = $("#empresa_datos_conyuge").val();
		    	var naturaleza_negocio_datos_conyuge = $("#naturaleza_negocio_datos_conyuge").val();
		    	var cargo_datos_conyuge = $("#cargo_datos_conyuge").val();
		    	var anios_laborados_datos_conyuge = $("#anios_laborados_datos_conyuge").val();
		    	var tipo_contrato_datos_conyuge = $("#tipo_contrato_datos_conyuge").val();
		    	var nombres_jefe_datos_conyuge = $("#nombres_jefe_datos_conyuge").val();
		    	var apellidos_jefe_datos_conyuge = $("#apellidos_jefe_datos_conyuge").val();
		    	var telefono_jefe_datos_conyuge = $("#telefono_jefe_datos_conyuge").val();
		    	var id_provincia_trabajo_datos_conyuge = $("#id_provincia_trabajo_datos_conyuge").val();
		    	var id_canton_trabajo_datos_conyuge = $("#id_canton_trabajo_datos_conyuge").val();
		    	var id_parroquia_trabajo_datos_conyuge = $("#id_parroquia_trabajo_datos_conyuge").val();
		    	var calle_trabajo_datos_conyuge = $("#calle_trabajo_datos_conyuge").val();
		    	var nuemero_calle_trabajo_datos_conyuge = $("#nuemero_calle_trabajo_datos_conyuge").val();
		    	var interseccion_trabajo_datos_conyuge = $("#interseccion_trabajo_datos_conyuge").val();
		    	var referencia_trabajo_datos_conyuge = $("#referencia_trabajo_datos_conyuge").val();
		    	var actividad_principal_datos_independientes = $("#actividad_principal_datos_independientes").val();
		    	var ruc_datos_independientes = $("#ruc_datos_independientes").val();
		    	var detalle_actividades_datos_independientes = $("#detalle_actividades_datos_independientes").val();
		    	var local_datos_independientes = $("#local_datos_independientes").val();
		    	var nombres_propietario_datos_independientes = $("#nombres_propietario_datos_independientes").val();
		    	var apellidos_propietario_datos_independientes = $("#apellidos_propietario_datos_independientes").val();
		    	var telefono_propietario_datos_independientes = $("#telefono_propietario_datos_independientes").val();
		    	var tiempo_funcionamiento_datos_independientes = $("#tiempo_funcionamiento_datos_independientes").val();
		    	var numero_patronal_datos_independientes = $("#numero_patronal_datos_independientes").val();
		    	var numero_empleados_datos_independientes = $("#numero_empleados_datos_independientes").val();
		    	var id_bancos_referencia_bancaria = $("#id_bancos_referencia_bancaria").val();
		    	var tipo_cuenta_referencia_bancaria = $("#tipo_cuenta_referencia_bancaria").val();
		    	var numero_cuenta_referencia_bancaria = $("#numero_cuenta_referencia_bancaria").val();
		    	var id_bancos_uno_datos_economicos = $("#id_bancos_uno_datos_economicos").val();
		    	var tipo_cuenta_uno_datos_economicos = $("#tipo_cuenta_uno_datos_economicos").val();
		    	var numero_cuenta_uno_datos_economicos = $("#numero_cuenta_uno_datos_economicos").val();
		    	var id_bancos_dos_datos_economicos = $("#id_bancos_dos_datos_economicos").val();
		    	var tipo_cuenta_dos_datos_economicos = $("#tipo_cuenta_dos_datos_economicos").val();
		    	var numero_cuenta_dos_datos_economicos = $("#numero_cuenta_dos_datos_economicos").val();
		    	var id_bancos_tres_datos_economicos = $("#id_bancos_tres_datos_economicos").val();
		    	var tipo_cuenta_tres_datos_economicos = $("#tipo_cuenta_tres_datos_economicos").val();
		    	var numero_cuenta_tres_datos_economicos = $("#numero_cuenta_tres_datos_economicos").val();
		    	var id_bancos_cuatro_datos_economicos = $("#id_bancos_cuatro_datos_economicos").val();
		    	var tipo_cuenta_cuatro_datos_economicos = $("#tipo_cuenta_cuatro_datos_economicos").val();
		    	var numero_cuenta_cuatro_datos_economicos = $("#numero_cuenta_cuatro_datos_economicos").val();
		    	var empresa_uno_datos_economicos = $("#empresa_uno_datos_economicos").val();
		    	var direccion_uno_datos_economicos = $("#direccion_uno_datos_economicos").val();
		    	var numero_telefono_uno_datos_economicos = $("#numero_telefono_uno_datos_economicos").val();
		    	var empresa_dos_datos_economicos = $("#empresa_dos_datos_economicos").val();
		    	var direccion_dos_datos_economicos = $("#direccion_dos_datos_economicos").val();
		    	var numero_telefono_dos_datos_economicos = $("#numero_telefono_dos_datos_economicos").val();
		    	var empresa_tres_datos_economicos = $("#empresa_tres_datos_economicos").val();
		    	var direccion_tres_datos_economicos = $("#direccion_tres_datos_economicos").val();
		    	var numero_telefono_tres_datos_economicos = $("#numero_telefono_tres_datos_economicos").val();
		    	var empresa_cuatro_datos_economicos = $("#empresa_cuatro_datos_economicos").val();
		    	var direccion_cuatro_datos_economicos = $("#direccion_cuatro_datos_economicos").val();
		    	var numero_telefono_cuatro_datos_economicos = $("#numero_telefono_cuatro_datos_economicos").val();
		    	var efectivo_activos_corrientes = $("#efectivo_activos_corrientes").val();
		    	var prestamo_menor_anio_pasivo_corriente = $("#prestamo_menor_anio_pasivo_corriente").val();
		    	var bancos_activos_corrientes = $("#bancos_activos_corrientes").val();
		    	var prestamo_emergente_pasivo_corriente = $("#prestamo_emergente_pasivo_corriente").val();
		    	var cuentas_cobrar_activos_corrientes = $("#cuentas_cobrar_activos_corrientes").val();
		    	var cuentas_pagar_pasivo_corriente = $("#cuentas_pagar_pasivo_corriente").val();
		    	var inversiones_activos_corrientes = $("#inversiones_activos_corrientes").val();
		    	var proveedores_pasivo_corriente = $("#proveedores_pasivo_corriente").val();
		    	var inventarios_activos_corrientes = $("#inventarios_activos_corrientes").val();
		    	var obligaciones_menores_anio_pasivo_corriente = $("#obligaciones_menores_anio_pasivo_corriente").val();
		    	var muebles_activos_corrientes = $("#muebles_activos_corrientes").val();
		    	var con_banco_pasivo_corriente = $("#con_banco_pasivo_corriente").val();
		    	var otros_activos_corrientes = $("#otros_activos_corrientes").val();
		    	var con_cooperativas_pasivo_corriente = $("#con_cooperativas_pasivo_corriente").val();
		    	var terreno_activos_fijos = $("#terreno_activos_fijos").val();
		    	var prestamo_mayor_anio_pasivos_largo_plazo = $("#prestamo_mayor_anio_pasivos_largo_plazo").val();
		    	var vivienda_activos_fijos = $("#vivienda_activos_fijos").val();
		    	var obligaciones_mayores_anio_pasivos_largo_plazo = $("#obligaciones_mayores_anio_pasivos_largo_plazo").val();
		    	var vehiculo_activos_fijos = $("#vehiculo_activos_fijos").val();
		    	var con_banco_pasivos_largo_plazo = $("#con_banco_pasivos_largo_plazo").val();
		    	var maquinaria_activos_fijos = $("#maquinaria_activos_fijos").val();
		    	var con_cooperativas_pasivos_largo_plazo = $("#con_cooperativas_pasivos_largo_plazo").val();
		    	var otros_activos_fijos = $("#otros_activos_fijos").val();
		    	var otros_pasivos_largo_plazo = $("#otros_pasivos_largo_plazo").val();
		    	var patrimonio = $("#patrimonio").val();
		    	var valor_prestacion_activos_intangibles = $("#valor_prestacion_activos_intangibles").val();
		    	var garantias_capremci = $("#garantias_capremci").val();
		    	var id_bancos_uno_detalle_activos = $("#id_bancos_uno_detalle_activos").val();
		    	var tipo_producto_uno_detalle_activos = $("#tipo_producto_uno_detalle_activos").val();
		    	var valor_uno_detalle_activos = $("#valor_uno_detalle_activos").val();
		    	var plazo_uno_detalle_activos = $("#plazo_uno_detalle_activos").val();
		    	var id_bancos_dos_detalle_activos = $("#id_bancos_dos_detalle_activos").val();
		    	var tipo_producto_dos_detalle_activos = $("#tipo_producto_dos_detalle_activos").val();
		    	var valor_dos_detalle_activos = $("#valor_dos_detalle_activos").val();
		    	var plazo_dos_detalle_activos = $("#plazo_dos_detalle_activos").val();
		    	var id_bancos_tres_detalle_activos = $("#id_bancos_tres_detalle_activos").val();
		    	var tipo_producto_tres_detalle_activos = $("#tipo_producto_tres_detalle_activos").val();
		    	var valor_tres_detalle_activos = $("#valor_tres_detalle_activos").val();
		    	var plazo_tres_detalle_activos = $("#plazo_tres_detalle_activos").val();
		    	var id_bancos_cuatro_detalle_activos = $("#id_bancos_cuatro_detalle_activos").val();
		    	var tipo_producto_cuatro_detalle_activos = $("#tipo_producto_cuatro_detalle_activos").val();
		    	var valor_cuatro_detalle_activos = $("#valor_cuatro_detalle_activos").val();
		    	var plazo_cuatro_detalle_activos = $("#plazo_cuatro_detalle_activos").val();
		    	var muebles_uno_detalle_activos = $("#muebles_uno_detalle_activos").val();
		    	var direccion_uno_detalle_activos = $("#direccion_uno_detalle_activos").val();
		    	var valor_muebles_uno_detalle_activos = $("#valor_muebles_uno_detalle_activos").val();
		    	var esta_hipotecado_uno_detalle_activos = $("#esta_hipotecado_uno_detalle_activos").val();
		    	var muebles_dos_detalle_activos = $("#muebles_dos_detalle_activos").val();
		    	var direccion_dos_detalle_activos = $("#direccion_dos_detalle_activos").val();
		    	var valor_muebles_dos_detalle_activos = $("#valor_muebles_dos_detalle_activos").val();
		    	var esta_hipotecado_dos_detalle_activos = $("#esta_hipotecado_dos_detalle_activos").val();
		    	var muebles_tres_detalle_activos = $("#muebles_tres_detalle_activos").val();
		    	var direccion_tres_detalle_activos = $("#direccion_tres_detalle_activos").val();
		    	var valor_muebles_tres_detalle_activos = $("#valor_muebles_tres_detalle_activos").val();
		    	var esta_hipotecado_tres_detalle_activos = $("#esta_hipotecado_tres_detalle_activos").val();
		    	var muebles_cuatro_detalle_activos = $("#muebles_cuatro_detalle_activos").val();
		    	var direccion_cuatro_detalle_activos = $("#direccion_cuatro_detalle_activos").val();
		    	var valor_muebles_cuatro_detalle_activos = $("#valor_muebles_cuatro_detalle_activos").val();
		    	var esta_hipotecada_cuatro_detalle_activos = $("#esta_hipotecada_cuatro_detalle_activos").val();
		    	var vehiculo_uno_detalle_activos = $("#vehiculo_uno_detalle_activos").val();
		    	var valor_vehiculo_uno_detalle_activos = $("#valor_vehiculo_uno_detalle_activos").val();
		    	var uso_uno_detalle_activos = $("#uso_uno_detalle_activos").val();
		    	var asegurado_uno_detalle_activos = $("#asegurado_uno_detalle_activos").val();
		    	var vehiculo_dos_detalle_activos = $("#vehiculo_dos_detalle_activos").val();
		    	var valor_vehiculo_dos_detalle_activos = $("#valor_vehiculo_dos_detalle_activos").val();
		    	var uso_dos_detalle_activos = $("#uso_dos_detalle_activos").val();
		    	var asegurado_dos_detalle_activos = $("#asegurado_dos_detalle_activos").val();
		    	var vehiculo_tres_detalle_activos = $("#vehiculo_tres_detalle_activos").val();
		    	var valor_vehiculo_tres_detalle_activos = $("#valor_vehiculo_tres_detalle_activos").val();
		    	var uso_tres_detalle_activos = $("#uso_tres_detalle_activos").val();
		    	var asegurado_tres_detalle_activos = $("#asegurado_tres_detalle_activos").val();
		    	var vehiculo_cuatro_detalle_activos = $("#vehiculo_cuatro_detalle_activos").val();
		    	var valor_vehiculo_cuatro_detalle_activos = $("#valor_vehiculo_cuatro_detalle_activos").val();
		    	var uso_cuatro_detalle_activos = $("#uso_cuatro_detalle_activos").val();
		    	var asegurado_cuatro_detalle_activos = $("#asegurado_cuatro_detalle_activos").val();
		    	var otros_uno_detalle_activos = $("#otros_uno_detalle_activos").val();
		    	var valor_otros_uno_detalle_activos = $("#valor_otros_uno_detalle_activos").val();
		    	var observacion_otro_uno_detalle_activos = $("#observacion_otro_uno_detalle_activos").val();
		    	var otros_dos_detalle_activos = $("#otros_dos_detalle_activos").val();
		    	var valor_otros_dos_detalle_activos = $("#valor_otros_dos_detalle_activos").val();
		    	var observacion_dos_detalle_activos = $("#observacion_dos_detalle_activos").val();
		    	var institucion_uno_detalle_pasivos = $("#institucion_uno_detalle_pasivos").val();
		    	var valor_uno_detalle_pasivos = $("#valor_uno_detalle_pasivos").val();
		    	var destino_uno_detalle_pasivos = $("#destino_uno_detalle_pasivos").val();
		    	var garantia_uno_detalle_pasivos = $("#garantia_uno_detalle_pasivos").val();
		    	var plazo_uno_detalle_pasivos = $("#plazo_uno_detalle_pasivos").val();
		    	var saldo_uno_detalle_pasivos = $("#saldo_uno_detalle_pasivos").val();
		    	var institucion_dos_detalle_pasivos = $("#institucion_dos_detalle_pasivos").val();
		    	var valor_dos_detalle_pasivos = $("#valor_dos_detalle_pasivos").val();
		    	var destino_dos_detalle_pasivos = $("#destino_dos_detalle_pasivos").val();
		    	var garantia_dos_detalle_pasivos = $("#garantia_dos_detalle_pasivos").val();
		    	var plazo_dos_detalle_pasivos = $("#plazo_dos_detalle_pasivos").val();
		    	var saldo_dos_detalle_pasivos = $("#saldo_dos_detalle_pasivos").val();
		    	var institucion_tres_detalle_pasivos = $("#institucion_tres_detalle_pasivos").val();
		    	var valor_tres_detalle_pasivos = $("#valor_tres_detalle_pasivos").val();
		    	var destino_tres_detalle_pasivos = $("#destino_tres_detalle_pasivos").val();
		    	var garantia_tres_detalle_pasivos = $("#garantia_tres_detalle_pasivos").val();
		    	var plazo_tres_detalle_pasivos = $("#plazo_tres_detalle_pasivos").val();
		    	var saldo_tres_detalle_pasivos = $("#saldo_tres_detalle_pasivos").val();
		    	var institucion_cuatro_detalle_pasivos = $("#institucion_cuatro_detalle_pasivos").val();
		    	var valor_cuatro_detalle_pasivos = $("#valor_cuatro_detalle_pasivos").val();
		    	var destino_cuatro_detalle_pasivos = $("#destino_cuatro_detalle_pasivos").val();
		    	var garantia_cuatro_detalle_pasivos = $("#garantia_cuatro_detalle_pasivos").val();
		    	var plazo_cuatro_detalle_pasivos = $("#plazo_cuatro_detalle_pasivos").val();
		    	var saldo_cuatro_detalle_pasivos = $("#saldo_cuatro_detalle_pasivos").val();
		    	var institucion_cinco_detalle_pasivos = $("#institucion_cinco_detalle_pasivos").val();
		    	var valor_cinco_detalle_pasivos = $("#valor_cinco_detalle_pasivos").val();
		    	var destino_cinco_detalle_pasivos = $("#destino_cinco_detalle_pasivos").val();
		    	var garantia_cinco_detalle_pasivos = $("#garantia_cinco_detalle_pasivos").val();
		    	var plazo_cinco_detalle_pasivos = $("#plazo_cinco_detalle_pasivos").val();
		    	var saldo_cinco_detalle_pasivos = $("#saldo_cinco_detalle_pasivos").val();
		    	var sueldo_afiliado_ingresos_mensuales = $("#sueldo_afiliado_ingresos_mensuales").val();
		    	var alimentacion_gastos_mensuales = $("#alimentacion_gastos_mensuales").val();
		    	var sueldo_conyuge_ingresos_mensuales = $("#sueldo_conyuge_ingresos_mensuales").val();
		    	var arriendos_gastos_mensuales = $("#arriendos_gastos_mensuales").val();
		    	var comisiones_ingresos_mensuales = $("#comisiones_ingresos_mensuales").val();
		    	var educacion_gastos_mensuales = $("#educacion_gastos_mensuales").val();
		    	var arriendos_ingresos_mensuales = $("#arriendos_ingresos_mensuales").val();
		    	var vestuario_gastos_mensuales = $("#vestuario_gastos_mensuales").val();
		    	var dividendos_ingresos_mensuales = $("#dividendos_ingresos_mensuales").val();
		    	var servicios_publicos_gastos_mensuales = $("#servicios_publicos_gastos_mensuales").val();
		    	var ingresos_negocio_ingresos_mensuales = $("#ingresos_negocio_ingresos_mensuales").val();
		    	var movilizacion_gastos_mensuales = $("#movilizacion_gastos_mensuales").val();
		    	var pensiones_ingresos_mensuales = $("#pensiones_ingresos_mensuales").val();
		    	var ahorros_cooperativas_gastos_mensuales = $("#ahorros_cooperativas_gastos_mensuales").val();
		    	var cuotas_tarjetas_gastos_mensuales = $("#cuotas_tarjetas_gastos_mensuales").val();
		    	var otros_detalle_uno_ingresos_mensuales = $("#otros_detalle_uno_ingresos_mensuales").val();
		    	var otros_uno_ingresos_mensuales = $("#otros_uno_ingresos_mensuales").val();
		    	var cuotas_prestamo_gastos_mensuales = $("#cuotas_prestamo_gastos_mensuales").val();
		    	var otros_detalle_dos_ingresos_mensuales = $("#otros_detalle_dos_ingresos_mensuales").val();
		    	var otros_dos_ingresos_mensuales = $("#otros_dos_ingresos_mensuales").val();
		    	var otros_detalle_tres_ingresos_mensuales = $("#otros_detalle_tres_ingresos_mensuales").val();
		    	var otros_tres_ingresos_mensuales = $("#otros_tres_ingresos_mensuales").val();
		    	var otros_detalle_uno_gastos_mensuales = $("#otros_detalle_uno_gastos_mensuales").val();
		    	var otros_gastos_uno_gastos_mensuales = $("#otros_gastos_uno_gastos_mensuales").val();
		    	var imagen_croquis_domicilio = $("#imagen_croquis_domicilio").val();
		    	var imagen_croquis_otro_negocio = $("#imagen_croquis_otro_negocio").val();
		    	var id_sucursales = $("#id_sucursales").val();
		    	
		    	
		    	

		    	

		    	var parametros = {
		    			id_solicitud_hipotecario:id_solicitud_hipotecario,
		    			valor_dolares_datos_credito:valor_dolares_datos_credito,
		    			plazo_meses_datos_credito:plazo_meses_datos_credito,
		    			destino_dinero_datos_credito:destino_dinero_datos_credito,
		    			cedula_datos_personales:cedula_datos_personales,
		    			nombres_datos_personales:nombres_datos_personales,
		    			apellidos_datos_personales:apellidos_datos_personales,
		    			id_sexo:id_sexo,
		    			id_estado_civil:id_estado_civil,
		    			fecha_nacimiento_datos_personales:fecha_nacimiento_datos_personales,
		    			separacion_bienes_datos_personales:separacion_bienes_datos_personales,
		    			cargas_familiares_datos_personales:cargas_familiares_datos_personales,
		    			numero_hijos_datos_personales:numero_hijos_datos_personales,
		    			email_datos_personales:email_datos_personales,
		    			nivel_educativo_datos_personales:nivel_educativo_datos_personales,
		    			id_provincia:id_provincia,
		    			id_canton:id_canton,
		    			id_parroquia:id_parroquia,
		    			barrio_datos_personales:barrio_datos_personales,
		    			ciudadela_datos_personales:ciudadela_datos_personales,
		    			calle_datos_personales:calle_datos_personales,
		    			numero_calle_datos_personales:numero_calle_datos_personales,
		    			interseccion_datos_personales:interseccion_datos_personales,
		    			tipo_vivienda_datos_personales:tipo_vivienda_datos_personales,
		    			vivienda_hipotecada_datos_personales:vivienda_hipotecada_datos_personales,
		    			tiempo_residencia_datos_personales:tiempo_residencia_datos_personales,
		    			referencia_domiciliaria_datos_perdonales:referencia_domiciliaria_datos_perdonales,
		    			nombre_arrendatario_datos_personales:nombre_arrendatario_datos_personales,
		    			apellido_arrendatario_datos_personales:apellido_arrendatario_datos_personales,
		    			celular_arrendatario_datos_personales:celular_arrendatario_datos_personales,
		    			telefono_datos_personales:telefono_datos_personales,
		    			celular_datos_personales:celular_datos_personales,
		    			telf_trabajo_datos_personales:telf_trabajo_datos_personales,
		    			ext_telef_datos_personales:ext_telef_datos_personales,
		    			node_telef_datos_personales:node_telef_datos_personales,
		    			id_codigo_verificacion:id_codigo_verificacion,
		    			nombres_referencia_familiar_datos_personales:nombres_referencia_familiar_datos_personales,
		    			apellidos_referencia_familiar_datos_personales:apellidos_referencia_familiar_datos_personales,
		    			parentesco_referencia_familiar_datos_personales:parentesco_referencia_familiar_datos_personales,
		    			primer_telefono_ref_familiar_datos_personales:primer_telefono_ref_familiar_datos_personales,
		    			segundo_telefono_ref_familiar_datos_personales:segundo_telefono_ref_familiar_datos_personales,
		    			nombres_referencia_personal_datos_personales:nombres_referencia_personal_datos_personales,
		    			apellidos_referencia_personal_datos_personales:apellidos_referencia_personal_datos_personales,
		    			relacion_referencia_personal_datos_personales:relacion_referencia_personal_datos_personales,
		    			primer_telefono_ref_personal_datos_personales:primer_telefono_ref_personal_datos_personales,
		    			segundo_telefono_ref_personal_datos_personales:segundo_telefono_ref_personal_datos_personales,
		    			id_entidades:id_entidades,
		    			reparto_unidad_datos_laborales:reparto_unidad_datos_laborales,
		    			seccion_datos_laborales:seccion_datos_laborales,
		    			nombres_jefe_datos_laborales:nombres_jefe_datos_laborales,
		    			apellidos_jefe_datos_laborales:apellidos_jefe_datos_laborales,
		    			telefono_jefe_datos_laborales:telefono_jefe_datos_laborales,
		    			cargo_actual_datos_laborales:cargo_actual_datos_laborales,
		    			anios_servicio_datos_laborales:anios_servicio_datos_laborales,
		    			id_provincia_datos_laborales:id_provincia_datos_laborales,
		    			id_canton_datos_laborales:id_canton_datos_laborales,
		    			id_parroquia_datos_laborales:id_parroquia_datos_laborales,
		    			calle_datos_laborales:calle_datos_laborales,
		    			numero_calle_datos_laborales:numero_calle_datos_laborales,
		    			interseccion_datos_laborales:interseccion_datos_laborales,
		    			referencia_direccion_trabajo_datos_laborales:referencia_direccion_trabajo_datos_laborales,
		    			cedula_datos_conyuge:cedula_datos_conyuge,
		    			nombres_datos_conyuge:nombres_datos_conyuge,
		    			apellidos_datos_conyuge:apellidos_datos_conyuge,
		    			id_sexo_datos_conyuge:id_sexo_datos_conyuge,
		    			fecha_nacimiento_datos_conyuge:fecha_nacimiento_datos_conyuge,
		    			vive_residencia_datos_conyuge:vive_residencia_datos_conyuge,
		    			telefono_datos_conyuge:telefono_datos_conyuge,
		    			celular_datos_conyuge:celular_datos_conyuge,
		    			id_provincia_datos_conyuge:id_provincia_datos_conyuge,
		    			id_canton_datos_conyuge:id_canton_datos_conyuge,
		    			id_parroquia_datos_conyuge:id_parroquia_datos_conyuge,
		    			barrio_datos_conyuge:barrio_datos_conyuge,
		    			ciudadela_datos_conyuge:ciudadela_datos_conyuge,
		    			calle_datos_conyuge:calle_datos_conyuge,
		    			numero_calle_datos_conyuge:numero_calle_datos_conyuge,
		    			interseccion_datos_conyuge:interseccion_datos_conyuge,
		    			actividad_economica_datos_conyuge:actividad_economica_datos_conyuge,
		    			empresa_datos_conyuge:empresa_datos_conyuge,
		    			naturaleza_negocio_datos_conyuge:naturaleza_negocio_datos_conyuge,
		    			cargo_datos_conyuge:cargo_datos_conyuge,
		    			anios_laborados_datos_conyuge:anios_laborados_datos_conyuge,
		    			tipo_contrato_datos_conyuge:tipo_contrato_datos_conyuge,
		    			nombres_jefe_datos_conyuge:nombres_jefe_datos_conyuge,
		    			apellidos_jefe_datos_conyuge:apellidos_jefe_datos_conyuge,
		    			telefono_jefe_datos_conyuge:telefono_jefe_datos_conyuge,
		    			id_provincia_trabajo_datos_conyuge:id_provincia_trabajo_datos_conyuge,
		    			id_canton_trabajo_datos_conyuge:id_canton_trabajo_datos_conyuge,
		    			id_parroquia_trabajo_datos_conyuge:id_parroquia_trabajo_datos_conyuge,
		    			calle_trabajo_datos_conyuge:calle_trabajo_datos_conyuge,
		    			nuemero_calle_trabajo_datos_conyuge:nuemero_calle_trabajo_datos_conyuge,
		    			interseccion_trabajo_datos_conyuge:interseccion_trabajo_datos_conyuge,
		    			referencia_trabajo_datos_conyuge:referencia_trabajo_datos_conyuge,
		    			actividad_principal_datos_independientes:actividad_principal_datos_independientes,
		    			ruc_datos_independientes:ruc_datos_independientes,
		    			detalle_actividades_datos_independientes:detalle_actividades_datos_independientes,
		    			local_datos_independientes:local_datos_independientes,
		    			nombres_propietario_datos_independientes:nombres_propietario_datos_independientes,
		    			apellidos_propietario_datos_independientes:apellidos_propietario_datos_independientes,
		    			telefono_propietario_datos_independientes:telefono_propietario_datos_independientes,
		    			tiempo_funcionamiento_datos_independientes:tiempo_funcionamiento_datos_independientes,
		    			numero_patronal_datos_independientes:numero_patronal_datos_independientes,
		    			numero_empleados_datos_independientes:numero_empleados_datos_independientes,
		    			id_bancos_referencia_bancaria:id_bancos_referencia_bancaria,
		    			tipo_cuenta_referencia_bancaria:tipo_cuenta_referencia_bancaria,
		    			numero_cuenta_referencia_bancaria:numero_cuenta_referencia_bancaria,
		    			id_bancos_uno_datos_economicos:id_bancos_uno_datos_economicos,
		    			tipo_cuenta_uno_datos_economicos:tipo_cuenta_uno_datos_economicos,
		    			numero_cuenta_uno_datos_economicos:numero_cuenta_uno_datos_economicos,
		    			id_bancos_dos_datos_economicos:id_bancos_dos_datos_economicos,
		    			tipo_cuenta_dos_datos_economicos:tipo_cuenta_dos_datos_economicos,
		    			numero_cuenta_dos_datos_economicos:numero_cuenta_dos_datos_economicos,
		    			id_bancos_tres_datos_economicos:id_bancos_tres_datos_economicos,
		    			tipo_cuenta_tres_datos_economicos:tipo_cuenta_tres_datos_economicos,
		    			numero_cuenta_tres_datos_economicos:numero_cuenta_tres_datos_economicos,
		    			id_bancos_cuatro_datos_economicos:id_bancos_cuatro_datos_economicos,
		    			tipo_cuenta_cuatro_datos_economicos:tipo_cuenta_cuatro_datos_economicos,
		    			numero_cuenta_cuatro_datos_economicos:numero_cuenta_cuatro_datos_economicos,
		    			empresa_uno_datos_economicos:empresa_uno_datos_economicos,
		    			direccion_uno_datos_economicos:direccion_uno_datos_economicos,
		    			numero_telefono_uno_datos_economicos:numero_telefono_uno_datos_economicos,
		    			empresa_dos_datos_economicos:empresa_dos_datos_economicos,
		    			direccion_dos_datos_economicos:direccion_dos_datos_economicos,
		    			numero_telefono_dos_datos_economicos:numero_telefono_dos_datos_economicos,
		    			empresa_tres_datos_economicos:empresa_tres_datos_economicos,
		    			direccion_tres_datos_economicos:direccion_tres_datos_economicos,
		    			numero_telefono_tres_datos_economicos:numero_telefono_tres_datos_economicos,
		    			empresa_cuatro_datos_economicos:empresa_cuatro_datos_economicos,
		    			direccion_cuatro_datos_economicos:direccion_cuatro_datos_economicos,
		    			numero_telefono_cuatro_datos_economicos:numero_telefono_cuatro_datos_economicos,
		    			efectivo_activos_corrientes:efectivo_activos_corrientes,
		    			prestamo_menor_anio_pasivo_corriente:prestamo_menor_anio_pasivo_corriente,
		    			bancos_activos_corrientes:bancos_activos_corrientes,
		    			prestamo_emergente_pasivo_corriente:prestamo_emergente_pasivo_corriente,
		    			cuentas_cobrar_activos_corrientes:cuentas_cobrar_activos_corrientes,
		    			cuentas_pagar_pasivo_corriente:cuentas_pagar_pasivo_corriente,
		    			inversiones_activos_corrientes:inversiones_activos_corrientes,
		    			proveedores_pasivo_corriente:proveedores_pasivo_corriente,
		    			inventarios_activos_corrientes:inventarios_activos_corrientes,
		    			obligaciones_menores_anio_pasivo_corriente:obligaciones_menores_anio_pasivo_corriente,
		    			muebles_activos_corrientes:muebles_activos_corrientes,
		    			con_banco_pasivo_corriente:con_banco_pasivo_corriente,
		    			otros_activos_corrientes:otros_activos_corrientes,
		    			con_cooperativas_pasivo_corriente:con_cooperativas_pasivo_corriente,
		    			terreno_activos_fijos:terreno_activos_fijos,
		    			prestamo_mayor_anio_pasivos_largo_plazo:prestamo_mayor_anio_pasivos_largo_plazo,
		    			vivienda_activos_fijos:vivienda_activos_fijos,
		    			obligaciones_mayores_anio_pasivos_largo_plazo:obligaciones_mayores_anio_pasivos_largo_plazo,
		    			vehiculo_activos_fijos:vehiculo_activos_fijos,
		    			con_banco_pasivos_largo_plazo:con_banco_pasivos_largo_plazo,
		    			maquinaria_activos_fijos:maquinaria_activos_fijos,
		    			con_cooperativas_pasivos_largo_plazo:con_cooperativas_pasivos_largo_plazo,
		    			otros_activos_fijos:otros_activos_fijos,
		    			otros_pasivos_largo_plazo:otros_pasivos_largo_plazo,
		    			patrimonio:patrimonio,
		    			valor_prestacion_activos_intangibles:valor_prestacion_activos_intangibles,
		    			garantias_capremci:garantias_capremci,
		    			id_bancos_uno_detalle_activos:id_bancos_uno_detalle_activos,
		    			tipo_producto_uno_detalle_activos:tipo_producto_uno_detalle_activos,
		    			valor_uno_detalle_activos:valor_uno_detalle_activos,
		    			plazo_uno_detalle_activos:plazo_uno_detalle_activos,
		    			id_bancos_dos_detalle_activos:id_bancos_dos_detalle_activos,
		    			tipo_producto_dos_detalle_activos:tipo_producto_dos_detalle_activos,
		    			valor_dos_detalle_activos:valor_dos_detalle_activos,
		    			plazo_dos_detalle_activos:plazo_dos_detalle_activos,
		    			id_bancos_tres_detalle_activos:id_bancos_tres_detalle_activos,
		    			tipo_producto_tres_detalle_activos:tipo_producto_tres_detalle_activos,
		    			valor_tres_detalle_activos:valor_tres_detalle_activos,
		    			plazo_tres_detalle_activos:plazo_tres_detalle_activos,
		    			id_bancos_cuatro_detalle_activos:id_bancos_cuatro_detalle_activos,
		    			tipo_producto_cuatro_detalle_activos:tipo_producto_cuatro_detalle_activos,
		    			valor_cuatro_detalle_activos:valor_cuatro_detalle_activos,
		    			plazo_cuatro_detalle_activos:plazo_cuatro_detalle_activos,
		    			muebles_uno_detalle_activos:muebles_uno_detalle_activos,
		    			direccion_uno_detalle_activos:direccion_uno_detalle_activos,
		    			valor_muebles_uno_detalle_activos:valor_muebles_uno_detalle_activos,
		    			esta_hipotecado_uno_detalle_activos:esta_hipotecado_uno_detalle_activos,
		    			muebles_dos_detalle_activos:muebles_dos_detalle_activos,
		    			direccion_dos_detalle_activos:direccion_dos_detalle_activos,
		    			valor_muebles_dos_detalle_activos:valor_muebles_dos_detalle_activos,
		    			esta_hipotecado_dos_detalle_activos:esta_hipotecado_dos_detalle_activos,
		    			muebles_tres_detalle_activos:muebles_tres_detalle_activos,
		    			direccion_tres_detalle_activos:direccion_tres_detalle_activos,
		    			valor_muebles_tres_detalle_activos:valor_muebles_tres_detalle_activos,
		    			esta_hipotecado_tres_detalle_activos:esta_hipotecado_tres_detalle_activos,
		    			muebles_cuatro_detalle_activos:muebles_cuatro_detalle_activos,
		    			direccion_cuatro_detalle_activos:direccion_cuatro_detalle_activos,
		    			valor_muebles_cuatro_detalle_activos:valor_muebles_cuatro_detalle_activos,
		    			esta_hipotecada_cuatro_detalle_activos:esta_hipotecada_cuatro_detalle_activos,
		    			vehiculo_uno_detalle_activos:vehiculo_uno_detalle_activos,
		    			valor_vehiculo_uno_detalle_activos:valor_vehiculo_uno_detalle_activos,
		    			uso_uno_detalle_activos:uso_uno_detalle_activos,
		    			asegurado_uno_detalle_activos:asegurado_uno_detalle_activos,
		    			vehiculo_dos_detalle_activos:vehiculo_dos_detalle_activos,
		    			valor_vehiculo_dos_detalle_activos:valor_vehiculo_dos_detalle_activos,
		    			uso_dos_detalle_activos:uso_dos_detalle_activos,
		    			asegurado_dos_detalle_activos:asegurado_dos_detalle_activos,
		    			vehiculo_tres_detalle_activos:vehiculo_tres_detalle_activos,
		    			valor_vehiculo_tres_detalle_activos:valor_vehiculo_tres_detalle_activos,
		    			uso_tres_detalle_activos:uso_tres_detalle_activos,
		    			asegurado_tres_detalle_activos:asegurado_tres_detalle_activos,
		    			vehiculo_cuatro_detalle_activos:vehiculo_cuatro_detalle_activos,
		    			valor_vehiculo_cuatro_detalle_activos:valor_vehiculo_cuatro_detalle_activos,
		    			uso_cuatro_detalle_activos:uso_cuatro_detalle_activos,
		    			asegurado_cuatro_detalle_activos:asegurado_cuatro_detalle_activos,
		    			otros_uno_detalle_activos:otros_uno_detalle_activos,
		    			valor_otros_uno_detalle_activos:valor_otros_uno_detalle_activos,
		    			observacion_otro_uno_detalle_activos:observacion_otro_uno_detalle_activos,
		    			otros_dos_detalle_activos:otros_dos_detalle_activos,
		    			valor_otros_dos_detalle_activos:valor_otros_dos_detalle_activos,
		    			observacion_dos_detalle_activos:observacion_dos_detalle_activos,
		    			institucion_uno_detalle_pasivos:institucion_uno_detalle_pasivos,
		    			valor_uno_detalle_pasivos:valor_uno_detalle_pasivos,
		    			destino_uno_detalle_pasivos:destino_uno_detalle_pasivos,
		    			garantia_uno_detalle_pasivos:garantia_uno_detalle_pasivos,
		    			plazo_uno_detalle_pasivos:plazo_uno_detalle_pasivos,
		    			saldo_uno_detalle_pasivos:saldo_uno_detalle_pasivos,
		    			institucion_dos_detalle_pasivos:institucion_dos_detalle_pasivos,
		    			valor_dos_detalle_pasivos:valor_dos_detalle_pasivos,
		    			destino_dos_detalle_pasivos:destino_dos_detalle_pasivos,
		    			garantia_dos_detalle_pasivos:garantia_dos_detalle_pasivos,
		    			plazo_dos_detalle_pasivos:plazo_dos_detalle_pasivos,
		    			saldo_dos_detalle_pasivos:saldo_dos_detalle_pasivos,
		    			institucion_tres_detalle_pasivos:institucion_tres_detalle_pasivos,
		    			valor_tres_detalle_pasivos:valor_tres_detalle_pasivos,
		    			destino_tres_detalle_pasivos:destino_tres_detalle_pasivos,
		    			garantia_tres_detalle_pasivos:garantia_tres_detalle_pasivos,
		    			plazo_tres_detalle_pasivos:plazo_tres_detalle_pasivos,
		    			saldo_tres_detalle_pasivos:saldo_tres_detalle_pasivos,
		    			institucion_cuatro_detalle_pasivos:institucion_cuatro_detalle_pasivos,
		    			valor_cuatro_detalle_pasivos:valor_cuatro_detalle_pasivos,
		    			destino_cuatro_detalle_pasivos:destino_cuatro_detalle_pasivos,
		    			garantia_cuatro_detalle_pasivos:garantia_cuatro_detalle_pasivos,
		    			plazo_cuatro_detalle_pasivos:plazo_cuatro_detalle_pasivos,
		    			saldo_cuatro_detalle_pasivos:saldo_cuatro_detalle_pasivos,
		    			institucion_cinco_detalle_pasivos:institucion_cinco_detalle_pasivos,
		    			valor_cinco_detalle_pasivos:valor_cinco_detalle_pasivos,
		    			destino_cinco_detalle_pasivos:destino_cinco_detalle_pasivos,
		    			garantia_cinco_detalle_pasivos:garantia_cinco_detalle_pasivos,
		    			plazo_cinco_detalle_pasivos:plazo_cinco_detalle_pasivos,
		    			saldo_cinco_detalle_pasivos:saldo_cinco_detalle_pasivos,
		    			sueldo_afiliado_ingresos_mensuales:sueldo_afiliado_ingresos_mensuales,
		    			alimentacion_gastos_mensuales:alimentacion_gastos_mensuales,
		    			sueldo_conyuge_ingresos_mensuales:sueldo_conyuge_ingresos_mensuales,
		    			arriendos_gastos_mensuales:arriendos_gastos_mensuales,
		    			comisiones_ingresos_mensuales:comisiones_ingresos_mensuales,
		    			educacion_gastos_mensuales:educacion_gastos_mensuales,
		    			arriendos_ingresos_mensuales:arriendos_ingresos_mensuales,
		    			vestuario_gastos_mensuales:vestuario_gastos_mensuales,
		    			dividendos_ingresos_mensuales:dividendos_ingresos_mensuales,
		    			servicios_publicos_gastos_mensuales:servicios_publicos_gastos_mensuales,
		    			ingresos_negocio_ingresos_mensuales:ingresos_negocio_ingresos_mensuales,
		    			movilizacion_gastos_mensuales:movilizacion_gastos_mensuales,
		    			pensiones_ingresos_mensuales:pensiones_ingresos_mensuales,
		    			ahorros_cooperativas_gastos_mensuales:ahorros_cooperativas_gastos_mensuales,
		    			cuotas_tarjetas_gastos_mensuales:cuotas_tarjetas_gastos_mensuales,
		    			otros_detalle_uno_ingresos_mensuales:otros_detalle_uno_ingresos_mensuales,
		    			otros_uno_ingresos_mensuales:otros_uno_ingresos_mensuales,
		    			cuotas_prestamo_gastos_mensuales:cuotas_prestamo_gastos_mensuales,
		    			otros_detalle_dos_ingresos_mensuales:otros_detalle_dos_ingresos_mensuales,
		    			otros_dos_ingresos_mensuales:otros_dos_ingresos_mensuales,
		    			otros_detalle_tres_ingresos_mensuales:otros_detalle_tres_ingresos_mensuales,
		    			otros_tres_ingresos_mensuales:otros_tres_ingresos_mensuales,
		    			otros_detalle_uno_gastos_mensuales:otros_detalle_uno_gastos_mensuales,
		    			otros_gastos_uno_gastos_mensuales:otros_gastos_uno_gastos_mensuales,
		    			imagen_croquis_domicilio:imagen_croquis_domicilio,
		    			imagen_croquis_otro_negocio:imagen_croquis_otro_negocio,
		    			id_sucursales:id_sucursales
		    			
		    			
		    	
		    	}
	    		
		    	
		    	
		    	
		    	
		    	
		    	
		    	
		    	
		    	$.ajax({
	    			beforeSend:function(){},
	    			url:"index.php?controller=SolicitudHipotecario&action=InsertaSolicitudPrestamo",
	    			type:"POST",
	    			dataType:"json",
	    			data:parametros
	    		}).done(function(respuesta){
	    					
	    			if(respuesta.valor == 1 ){
	    				
	    				swal("Alerta!", "llego " + respuesta.mensaje, "success")
	               	
	    		    }else{
	    		    	
	    		    	swal("Alerta!", "no llego " + respuesta.mensaje, "error")
		    		}
	    			
	    			
	    		}).fail(function(xhr,status,error){
	    			
	    			var err = xhr.responseText
	    			console.log(err);
	    			$('#id_codigo_verificacion').val("0");
	    			swal("Alerta!", "Mensaje no Enviado", "error")
                  
	    			
	    		}).always(function(){
	    					
	    		})
	    		
	    		event.preventDefault();
				
   	      
			}); 



