
$(document).ready( function (){
	
	aporte_actual_participe();
	cargaTipoAportaciones();
	ValidarSolicitudes();
		
});



function aporte_actual_participe()
{
	
	var cedula = $("#cedula_participe").val();
	console.log(cedula);
	
    var base_url = 'http://localhost:4000/rp_c/webservices/';
    var pag_service = 'CargarTipoAportesParticipesService.php?jsoncallback=?';
  
    
    var con_datos={
            cargar:'cargar',
            cedula:cedula,
            action:'ajax'
   };

	 
	$.ajax({
        url: base_url+pag_service,
        type: 'GET',
        data: con_datos,
	    dataType: 'json',
	    success: function(x){
	    	console.log( );
            $("#aporte_actual_participes").html(x);
             console.log(x);
          },
         error: function(jqXHR,estado,error){
           $("#aporte_actual_participes").html("Ocurrio un error al cargar la información..."+estado+"    "+error);
           
           console.log(jqXHR.responseText)
         }
   
	});
}

function cargaTipoAportaciones(){
	
	let $ddlTipoAportaciones = $("#id_tipo_aportaciones");
	 
	var base_url = 'http://localhost:4000/rp_c/webservices/';
     var pag_service = 'CargarTipoAportesParticipesService.php?jsoncallback=?';
     var con_datos={
             cargar:'selec_tipo_aportaciones',
             action:'ajax'
             
    };
	
	$.ajax({
		
		url: base_url+pag_service, 
	    data:con_datos,
		type:"GET",
		dataType:"json",
		success: function(datos){
		    
			 $ddlTipoAportaciones.empty();
				$ddlTipoAportaciones.append("<option value='0' >--Seleccione--</option>");
				
				$.each(datos.data, function(index, value) {
					$ddlTipoAportaciones.append("<option value= " +value.id_tipo_aportacion +" >" + value.nombre_tipo_aportacion  + "</option>");	
		  		});
			 
	             console.log(datos);
	          },
	         error: function(jqXHR,estado,error){
	        	 $ddlTipoAportaciones.empty();
	           console.log(jqXHR.responseText)
	         }
		
	});
	
}


function cargacedula(){
	
	var cedula = $("#cedula_participe").val();
	console.log(cedula);
	
    var base_url = 'http://localhost:4000/rp_c/webservices/';
    var pag_service = 'CargarTipoAportesParticipesService.php?jsoncallback=?';
  
    
    var con_datos={
            cargar:'cargar_cedula_participe',
            cedula:cedula,
            action:'ajax'
   };

	 
	$.ajax({
        url: base_url+pag_service,
        type: 'GET',
        data: con_datos,
	    dataType: 'json',
	    success: function(x){
            $("#cedula_participes");
             console.log(x);
          }
   
	});
}

function CambiaTipoAporte(elemento){
	
	var ddltipoAportacion = $(elemento);
	var nombreTipoAportacion = ddltipoAportacion.find('option:selected').text().trim();
	
	if( nombreTipoAportacion == "VALOR"){
		
		$("#valor_solicitud_aportaciones").attr("readonly",false);
		$("#valor_porcentaje_solicitud_aportaciones").attr("disabled",true);
		$("#valor_porcentaje_solicitud_aportaciones").val(0);
		$("#razon_solicitud_prestaciones").attr("readonly",false);
		
	}else if( nombreTipoAportacion == "PORCENTAJE" ){
		
		$("#valor_solicitud_aportaciones").attr("readonly",true); 
		$("#valor_solicitud_aportaciones").val("");
		$("#valor_porcentaje_solicitud_aportaciones").attr("disabled",false);
		$("#razon_solicitud_prestaciones").attr("readonly",false);
		
	}else{
		$("#valor_solicitud_aportaciones").attr("readonly",true);
		$("#valor_solicitud_aportaciones").val("");
		$("#valor_porcentaje_solicitud_aportaciones").attr("disabled",true);
		$("#valor_porcentaje_solicitud_aportaciones").val(0);
		$("#razon_solicitud_prestaciones").attr("readonly",true);
		
	}
	
	
}

function ValidarSolicitudes(){
		
	var mibtn = $("#btnContinuarSolicitud");
	var _cedula = $("#cedula_participe");		
		
    var _url = "http://localhost:4000/rp_c/index.php?controller=Recaudacion&action=crss_ValidarSolicitudes&jsoncallback=?"
    var parametros={
	        metodo:"BUSCAR",
	        cedula:_cedula.val(),
	        }
    
    $.ajax({
		url:_url,
        type: 'GET',
        data: parametros,
	    dataType: 'json'
	}).done(function(x){
		console.log("INGRESO EXITO NUEVO");
		mibtn.attr("disabled",true);
		console.log(x);
		
	}).fail(function(xhr, status, error){
		console.log("INGRESO ERROR NUEVo");
		var status = xhr.status;
		console.log(status);
		console.log( xhr.responseText);
	});
	
}

function RegistraSolicitud(){
	
	var mibtn = $("#btnGuardarSolicitud");
	var _cedula = $("#cedula_participe");
	var _tipo_aportacion = $("#id_tipo_aportaciones");
	var _valor_aportacion = $("#valor_solicitud_aportaciones"); 
	var _porcentaje_aportacion = $("#valor_porcentaje_solicitud_aportaciones"); 
	var _observacion_aportacion = $("#razon_solicitud_prestaciones");
	
	if( _cedula.val() == "" || _cedula.val().length == 0 ){
		//console.log("validacion cedula");
		_cedula.notify("Cedula no identificada",{ position:"buttom left", autoHideDelay: 2000});
		return false;
	}
	
	if( _tipo_aportacion.val() == 0 ){
		_tipo_aportacion.notify("Seleccione el tipo de aporte",{ position:"buttom left", autoHideDelay: 2000});
		return false;
	}else{
		
		var nombre_aporte = _tipo_aportacion.find("option:selected").text();
		
		if( nombre_aporte == "VALOR" ){
			
			if ( _valor_aportacion.val() == "" || _valor_aportacion.val().length == 0){
				_valor_aportacion.notify("Ingrese un valor de aporte",{ position:"buttom left", autoHideDelay: 2000});
				return false;
			}
		} 
		
		if( nombre_aporte == "PORCENTAJE" ){
			
			if ( _porcentaje_aportacion.val() == 0){
				_porcentaje_aportacion.notify("Seleccione porcentaje aportacion",{ position:"buttom left", autoHideDelay: 2000});
				return false;
			}
		} 
	}
	
	if( _observacion_aportacion.val() == "" || _observacion_aportacion.val().length == 0 ){
		_observacion_aportacion.notify("Ingrese una razon",{ position:"buttom left", autoHideDelay: 2000});
		return false;
	}
	
    var _url = "http://localhost:4000/rp_c/index.php?controller=Recaudacion&action=crss_ingresar_solicitud&jsoncallback=?"
    var parametros={
	        metodo:"GUARDAR",
	        cedula:_cedula.val(),
	        id_tipo_aportacion: _tipo_aportacion.val(),
	        valor_aportacion: _valor_aportacion.val(),
	        porcentaje_aportacion: _porcentaje_aportacion.val(),
	        observacion_aportacion: _observacion_aportacion.val(),
	        }
    
    $.ajax({
    	beforeSend:function(){ mibtn.attr("disabled",true);},
		url:_url,
        type: 'GET',
        data: parametros,
	    dataType: 'json',
	    complete:function(){ mibtn.attr("disabled",false);}
	}).done(function(x){
		
		
		
		swal({
  		  title: "SolicitudPrestaciones",
  		  text: datos.mensaje,
  		  icon: "success",
  		  button: "Aceptar",
  		});
		
	}).fail(function(xhr, status, error){
		console.log(xhr.responseText)
		var status = xhr.status;
    	if( xhr.status == 404 ){
    		
    		swal({
    	  		  title: "Solicitud Aportes",
    	  		  text: "Participe no encontrado",
    	  		  icon: "error",
    	  		  button: "Aceptar",
    	  		});
    	}
	});
    
   
}




