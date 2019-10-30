
$(document).ready( function (){
	
	aporte_actual_participe();
	cargaTipoAportaciones();
		
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
	    	console.log( );
            $("#cedula_participes");
             console.log(x);
          }
   
	});
}




