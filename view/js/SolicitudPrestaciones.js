$(document).ready(function(){
	
})









$("#Guardar").click(function() {
	//selecionarTodos();
	
	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;
	 var id_sucursales                                  = $("#id_sucursales").val();
	 
	var cedula_participes  = $("#cedula_participes").val();
	var nombres_solicitud_prestaciones  = $("#nombres_solicitud_prestaciones").val();
	var apellidos_solicitud_prestaciones  = $("#apellidos_solicitud_prestaciones").val();
	var id_sexo  = $("#id_sexo").val();
	var fecha_nacimiento_solicitud_prestaciones  = $("#fecha_nacimiento_solicitud_prestaciones").val();
	var id_estado_civil  = $("#id_estado_civil").val();
	var id_provincias  = $("#id_provincias").val();
	var id_cantones  = $("#id_cantones").val();
	var id_parroquias  = $("#id_parroquias").val();
	var barrio_solicitud_prestaciones  = $("#barrio_solicitud_prestaciones").val();
	var ciudadela_solicitud_prestaciones  = $("#ciudadela_solicitud_prestaciones").val();
	var calle_solicitud_prestaciones  = $("#calle_solicitud_prestaciones").val();
	var numero_calle_solicitud_prestaciones  = $("#numero_calle_solicitud_prestaciones").val();
	var interseccion_solicitud_prestaciones  = $("#interseccion_solicitud_prestaciones").val();
	var tipo_vivienda_solicitud_prestaciones  = $("#tipo_vivienda_solicitud_prestaciones").val();
	var vivienda_hipotecada_solicitud_prestaciones  = $("#vivienda_hipotecada_solicitud_prestaciones").val();
	var referencia_dir_solicitud_prestaciones  = $("#referencia_dir_solicitud_prestaciones").val();
	var telefono_solicitud_prestaciones  = $("#telefono_solicitud_prestaciones").val();
	var celular_solicitud_prestaciones  = $("#celular_solicitud_prestaciones").val();
	var nombres_referencia_familiar  = $("#nombres_referencia_familiar").val();
	var apellidos_referencia_familiar  = $("#apellidos_referencia_familiar").val();
	var parentesco_referencia_familiar  = $("#parentesco_referencia_familiar").val();
	var primer_telefono_referencia_familiar  = $("#primer_telefono_referencia_familiar").val();
	var segundo_telefono_referencia_familiar  = $("#segundo_telefono_referencia_familiar").val();
	var nombres_referencia_personal  = $("#nombres_referencia_personal").val();
	var apellidos_referencia_personal  = $("#apellidos_referencia_personal").val();
	var parentesco_referencia_personal  = $("#parentesco_referencia_personal").val();
	var primer_telefono_referencia_personal  = $("#primer_telefono_referencia_personal").val();
	var segundo_telefono_referencia_personal  = $("#segundo_telefono_referencia_personal").val();
	var ultimo_cargo_solicitud_prestaciones  = $("#ultimo_cargo_solicitud_prestaciones").val();
	var fecha_salida_solicitud_prestaciones  = $("#fecha_salida_solicitud_prestaciones").val();
	var id_bancos  = $("#id_bancos").val();
	var tipo_cuenta_bancaria  = $("#tipo_cuenta_bancaria").val();
	var numero_cuenta_bancaria  = $("#numero_cuenta_bancaria").val();
	var id_codigo_verificacion        			     = $("#id_codigo_verificacion").val();
	var numero_codigo_verificacion                     = $("#numero_codigo_verificacion").val();
	 var tiempo = tiempo || 1000;
	  
	 
	 if (id_sucursales == 0)
 	{
	    	
 		$("#mensaje_id_sucursales").text("Seleccione Sucursal");
 		$("#mensaje_id_sucursales").fadeIn("slow"); //Muestra mensaje de error
 		 
 		 $("html, body").animate({ scrollTop: $(mensaje_id_sucursales).offset().top }, tiempo);
 		 return false;
        
	    }
 	else 
 	{
 		$("#mensaje_id_sucursales").fadeOut("slow"); //Muestra mensaje de error
         
		} 

	if (cedula_participes  == "")
	{    	
		$("#mensaje_cedula_participes").text("Ingrese un número de cédula");
		$("#mensaje_cedula_participes").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_cedula_participes).offset().top }, tiempo);
          
        return false
    }    
	
	else
		{
		
		$("#mensaje_cedula_participes").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (nombres_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_nombres_solicitud_prestaciones").text("Ingrese los  Nombres");
		$("#mensaje_nombres_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_nombres_solicitud_prestaciones).offset().top }, tiempo);
        
		return false
    }    
	
	else
		{
		
		$("#mensaje_nombres_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (apellidos_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_apellidos_solicitud_prestaciones").text("Ingrese los Apellidos");
		$("#mensaje_apellidos_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_apellidos_solicitud_prestaciones).offset().top }, tiempo);
        
		return false
    }    
	
	else
		{
		
		$("#mensaje_apellidos_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (id_sexo  == 0)
	{    	
		$("#mensaje_id_sexo").text("Ingrese un Género");
		$("#mensaje_id_sexo").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_id_sexo).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_id_sexo").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (fecha_nacimiento_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_fecha_nacimiento_solicitud_prestaciones").text("Ingrese una Fecha");
		$("#mensaje_fecha_nacimiento_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_fecha_nacimiento_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_fecha_nacimiento_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (id_estado_civil  == 0)
	{    	
		$("#mensaje_id_estado_civil").text("Ingrese un Estado");
		$("#mensaje_id_estado_civil").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_id_estado_civil).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_id_estado_civil").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (correo_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_correo_solicitud_prestaciones").text("Ingrese un E-mail");
		$("#mensaje_correo_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_correo_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_correo_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (nivel_educativo_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_nivel_educativo_solicitud_prestaciones").text("Ingrese un Nivel");
		$("#mensaje_nivel_educativo_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_nivel_educativo_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_nivel_educativo_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	
	if (id_provincias  == 0)
	{    	
		$("#mensaje_id_provincias").text("Ingrese una Provincias");
		$("#mensaje_id_provincias").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_id_provincias).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_id_provincias").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	if (id_cantones  == 0)
	{    	
		$("#mensaje_id_cantones").text("Ingrese un Cantón");
		$("#mensaje_id_cantones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_id_cantones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_id_cantones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	if (id_parroquias  == 0)
	{    	
		$("#mensaje_id_parroquias").text("Ingrese una Parroquia");
		$("#mensaje_id_parroquias").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_id_parroquias).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_id_parroquias").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	if (barrio_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_barrio_solicitud_prestaciones").text("Ingrese Barrio");
		$("#mensaje_barrio_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_barrio_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_barrio_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	if (ciudadela_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_ciudadela_solicitud_prestaciones").text("Ingrese una Ciudadela");
		$("#mensaje_ciudadela_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_ciudadela_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_ciudadela_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	if (calle_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_calle_solicitud_prestaciones").text("Ingrese una Calle");
		$("#mensaje_calle_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_calle_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_calle_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (numero_calle_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_numero_calle_solicitud_prestaciones").text("Ingrese un número de calle");
		$("#mensaje_numero_calle_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_numero_calle_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_numero_calle_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (interseccion_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_interseccion_solicitud_prestaciones").text("Ingrese una Intersección");
		$("#mensaje_interseccion_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_interseccion_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_interseccion_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (tipo_vivienda_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_tipo_vivienda_solicitud_prestaciones").text("Ingrese una Tipo de Vivienda");
		$("#mensaje_tipo_vivienda_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_tipo_vivienda_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_tipo_vivienda_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (vivienda_hipotecada_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_vivienda_hipotecada_solicitud_prestaciones").text("Eliga una Opción");
		$("#mensaje_vivienda_hipotecada_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_vivienda_hipotecada_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_vivienda_hipotecada_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (referencia_dir_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_referencia_dir_solicitud_prestaciones").text("Ingrese una Referencia");
		$("#mensaje_referencia_dir_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_referencia_dir_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_referencia_dir_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (telefono_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_telefono_solicitud_prestaciones").text("Ingrese una numero Teléfono");
		$("#mensaje_telefono_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_telefono_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_telefono_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	
	
	
	
	/// validacion número d celular
	
	if (celular_solicitud_prestaciones == "" )
	{
    	
		$("#mensaje_celular_solicitud_prestaciones").text("Ingrese # celular");
		$("#mensaje_celular_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
        
        $("html, body").animate({ scrollTop: $(mensaje_celular_solicitud_prestaciones).offset().top }, tiempo);
        return false;
    }
	else 
	{


		if(isNaN(celular_solicitud_prestaciones)){

			$("#mensaje_celular_solicitud_prestaciones").text("Ingrese Solo Números");
    		$("#mensaje_celular_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
    		  $("html, body").animate({ scrollTop: $(mensaje_celular_solicitud_prestaciones).offset().top }, tiempo);
            return false;

		}
		
		if(celular_solicitud_prestaciones.length==10){

			$("#mensaje_celular_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
		}else{
			
			$("#mensaje_celular_solicitud_prestaciones").text("Ingrese 10 dígitos");
    		$("#mensaje_celular_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
    		 $("html, body").animate({ scrollTop: $(mensaje_celular_solicitud_prestaciones).offset().top }, tiempo);
            return false;
		}
    	
		
        
	}


	if (numero_codigo_verificacion == "" )
	{
    	
		$("#mensaje_numero_codigo_verificacion").text("Ingrese Código Verficación");
		$("#mensaje_numero_codigo_verificacion").fadeIn("slow"); //Muestra mensaje de error
        
        $("html, body").animate({ scrollTop: $(mensaje_numero_codigo_verificacion).offset().top }, tiempo);
        return false;
    }
	else 
	{
		$("#mensaje_numero_codigo_verificacion").fadeOut("slow"); //Muestra mensaje de error
        
	}

	
	if (id_codigo_verificacion == 0 )
	{
    	
		$("#mensaje_numero_codigo_verificacion").text("Verifique su Código");
		$("#mensaje_numero_codigo_verificacion").fadeIn("slow"); //Muestra mensaje de error
        
        $("html, body").animate({ scrollTop: $(mensaje_numero_codigo_verificacion).offset().top }, tiempo);
        return false;
    }
	else 
	{
		$("#mensaje_numero_codigo_verificacion").fadeOut("slow"); //Muestra mensaje de error
        
	}
	
	
	
	
	
	
	
	if (nombres_referencia_familiar  == "")
	{    	
		$("#mensaje_nombres_referencia_familiar").text("Ingrese un nombre");
		$("#mensaje_nombres_referencia_familiar").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_nombres_referencia_familiar).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_nombres_referencia_familiar").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (apellidos_referencia_familiar  == "")
	{    	
		$("#mensaje_apellidos_referencia_familiar").text("Ingrese un apellido");
		$("#mensaje_apellidos_referencia_familiar").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_apellidos_referencia_familiar).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_apellidos_referencia_familiar").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (parentesco_referencia_familiar  == "")
	{    	
		$("#mensaje_parentesco_referencia_familiar").text("Ingrese un parentesco");
		$("#mensaje_parentesco_referencia_familiar").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_parentesco_referencia_familiar).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_parentesco_referencia_familiar").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (primer_telefono_referencia_familiar  == "")
	{    	
		$("#mensaje_primer_telefono_referencia_familiar").text("Ingrese un teléfonor");
		$("#mensaje_primer_telefono_referencia_familiar").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_primer_telefono_referencia_familiar).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_mensaje_primer_telefono_referencia_familiar").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (segundo_telefono_referencia_familiar  == "")
	{    	
		$("#mensaje_segundo_telefono_referencia_familiar").text("Ingrese un teléfono");
		$("#mensaje_segundo_telefono_referencia_familiar").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_segundo_telefono_referencia_familiar).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_segundo_telefono_referencia_familiar").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (nombres_referencia_personal  == "")
	{    	
		$("#mensaje_nombres_referencia_personal").text("Ingrese un Nombre");
		$("#mensaje_nombres_referencia_personal").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_nombres_referencia_personal).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_nombres_referencia_personal").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (apellidos_referencia_personal  == "")
	{    	
		$("#mensaje_apellidos_referencia_personal").text("Ingrese un apellido");
		$("#mensaje_apellidos_referencia_personal").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_apellidos_referencia_personal).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_apellidos_referencia_personal").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (parentesco_referencia_personal  == "")
	{    	
		$("#mensaje_parentesco_referencia_personal").text("Ingrese un Parentesco");
		$("#mensaje_parentesco_referencia_personal").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_parentesco_referencia_personal).offset().top }, tiempo);
        
		return false
    }    
	
	else
		{
		
		$("#mensaje_parentesco_referencia_personal").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (primer_telefono_referencia_personal  == "")
	{    	
		$("#mensaje_primer_telefono_referencia_personal").text("Ingrese un número de teléfono");
		$("#mensaje_primer_telefono_referencia_personal").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_primer_telefono_referencia_personal).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_primer_telefono_referencia_personal").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (segundo_telefono_referencia_personal  == "")
	{    	
		$("#mensaje_segundo_telefono_referencia_personal").text("Ingrese un número de teléfono");
		$("#mensaje_segundo_telefono_referencia_personal").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_segundo_telefono_referencia_personal).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_segundo_telefono_referencia_personal").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (ultimo_cargo_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_ultimo_cargo_solicitud_prestaciones").text("Ingrese un cargo");
		$("#mensaje_ultimo_cargo_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_ultimo_cargo_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_ultimo_cargo_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (fecha_salida_solicitud_prestaciones  == "")
	{    	
		$("#mensaje_fecha_salida_solicitud_prestaciones").text("Ingrese una Fecha");
		$("#mensaje_fecha_salida_solicitud_prestaciones").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_fecha_salida_solicitud_prestaciones).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_fecha_salida_solicitud_prestaciones").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	if (id_bancos  == 0)
	{    	
		$("#mensaje_id_bancos").text("Ingrese un Banco");
		$("#mensaje_id_bancos").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_id_bancos).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_id_bancos").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	
	if (tipo_cuenta_bancaria  == 0)
	{    	
		$("#mensaje_tipo_cuenta_bancaria").text("Seleccione Tipo");
		$("#mensaje_tipo_cuenta_bancaria").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_tipo_cuenta_bancaria).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_tipo_cuenta_bancaria").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	
	if (numero_cuenta_bancaria  == "")
	{    	
		$("#mensaje_numero_cuenta_bancaria").text("Seleccione Tipo");
		$("#mensaje_numero_cuenta_bancaria").fadeIn("slow"); //Muestra mensaje de error
		$("html, body").animate({ scrollTop: $(mensaje_numero_cuenta_bancaria).offset().top }, tiempo);
        
        return false
    }    
	
	else
		{
		
		$("#mensaje_numero_cuenta_bancaria").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	
	
	
	
	
	
	
	
	
                    				
});

		$( "#id_sucursales" ).focus(function() {
			  $("#mensaje_id_sucursales").fadeOut("slow");
		  });
		
		$( "#cedula_participes" ).focus(function() {
			  $("#mensaje_cedula_participes").fadeOut("slow");
		   });
		
		$( "#nombres_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_nombres_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#apellidos_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_apellidos_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#id_sexo" ).focus(function() {
			  $("#mensaje_id_sexo").fadeOut("slow");
		   });
		$( "#fecha_nacimiento_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_fecha_nacimiento_solicitud_prestaciones").fadeOut("slow");
		   });
		$( "#id_estado_civil" ).focus(function() {
			  $("#mensaje_id_estado_civil").fadeOut("slow");
		   });
		
		$( "#id_provincias" ).focus(function() {
			  $("#mensaje_id_provincias").fadeOut("slow");
		   });
		
		$( "#id_cantones" ).focus(function() {
			  $("#mensaje_id_cantones").fadeOut("slow");
		   });
		
		$( "#id_parroquias" ).focus(function() {
			  $("#mensaje_id_parroquias").fadeOut("slow");
		   });
		$( "#barrio_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_barrio_solicitud_prestaciones").fadeOut("slow");
		   });
		$( "#ciudadela_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_ciudadela_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#calle_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_calle_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#numero_calle_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_numero_calle_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#interseccion_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_interseccion_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#tipo_vivienda_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_tipo_vivienda_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#vivienda_hipotecada_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_vivienda_hipotecada_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#referencia_dir_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_referencia_dir_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#telefono_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_telefono_solicitud_prestaciones").fadeOut("slow");
		   });
		
		
		$( "#celular_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_celular_solicitud_prestaciones").fadeOut("slow");
		});

      $( "#numero_codigo_verificacion" ).focus(function() {
			  $("#mensaje_numero_codigo_verificacion").fadeOut("slow");
		});
      
		
		$( "#nombres_referencia_familiar" ).focus(function() {
			  $("#mensaje_nombres_referencia_familiar").fadeOut("slow");
		   });
		
		$( "#apellidos_referencia_familiar" ).focus(function() {
			  $("#mensaje_apellidos_referencia_familiar").fadeOut("slow");
		   });
		
		$( "#parentesco_referencia_familiar" ).focus(function() {
			  $("#mensaje_parentesco_referencia_familiar").fadeOut("slow");
		   });
		
		$( "#primer_telefono_referencia_familiar" ).focus(function() {
			  $("#mensaje_primer_telefono_referencia_familiar").fadeOut("slow");
		   });
		
		$( "#segundo_telefono_referencia_familiar" ).focus(function() {
			  $("#mensaje_segundo_telefono_referencia_familiar").fadeOut("slow");
		   });
		
		$( "#nombres_referencia_personal" ).focus(function() {
			  $("#mensaje_nombres_referencia_personal").fadeOut("slow");
		   });
		
		$( "#apellidos_referencia_personal" ).focus(function() {
			  $("#mensaje_apellidos_referencia_personal").fadeOut("slow");
		   });
		
		$( "#parentesco_referencia_personal" ).focus(function() {
			  $("#mensaje_parentesco_referencia_personal").fadeOut("slow");
		   });
		
		$( "#primer_telefono_referencia_personal" ).focus(function() {
			  $("#mensaje_primer_telefono_referencia_personal").fadeOut("slow");
		   });
		$( "#segundo_telefono_referencia_personal" ).focus(function() {
			  $("#mensaje_segundo_telefono_referencia_personal").fadeOut("slow");
		   });
		
		$( "#ultimo_cargo_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_ultimo_cargo_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#fecha_salida_solicitud_prestaciones" ).focus(function() {
			  $("#mensaje_fecha_salida_solicitud_prestaciones").fadeOut("slow");
		   });
		
		$( "#id_bancos" ).focus(function() {
			  $("#mensaje_id_bancos").fadeOut("slow");
			  
		   });
		
		
		$( "#tipo_cuenta_bancaria" ).focus(function() {
			  $("#mensaje_tipo_cuenta_bancaria").fadeOut("slow");
			  
		   });
		
		$( "#numero_cuenta_bancaria" ).focus(function() {
			  $("#mensaje_numero_cuenta_bancaria").fadeOut("slow");
			  
		   });
		
		
		/// enviar codigo
		
		 $("#btn_enviar").click(function() 
					{

				    	$('#id_codigo_verificacion').val("0");
				    	$('#numero_codigo_verificacion').val("");
				    	
				    	var celular_solicitud_prestaciones = $("#celular_solicitud_prestaciones").val();
				    	var numero_codigo_verificacion = $("#numero_codigo_verificacion").val();
				    	


				    	if (celular_solicitud_prestaciones == "" )
				    	{
				    		swal("Alerta!", "Ingrese Celular", "error")
		                    return false;
				    		
					    }
				    	else 
				    	{


				    		if(isNaN(celular_solicitud_prestaciones)){

				    			swal("Alerta!", "Ingrese Solo Números", "error")
			                    return false;

							}
				    		
				    		if(celular_solicitud_prestaciones.length==10){

								
							}else{
								
								swal("Alerta!", "Ingrese 10 Dgts.", "error")
			                    return false;

							}
		  	
				            
						}





				    	var parametros = {celular_solicitud_prestaciones:celular_solicitud_prestaciones}
			    		$.ajax({
			    			beforeSend:function(){},
			    			url:"index.php?controller=SolicitudPrestaciones&action=EnviarSMS",
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
				    	
				    	var celular_solicitud_prestaciones = $("#celular_solicitud_prestaciones").val();
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
			    			url:"index.php?controller=SolicitudPrestaciones&action=Validar_Codigo_Verificacion",
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


/// solo número
		 
		 function soloNumeros(e)
		 {
		 	var key = window.Event ? e.which : e.keyCode
		 	return ((key >= 48 && key <= 57) || (key==8))
		 }
		 
		 
		 
		 var enviando = false; //Obligaremos a entrar el if en el primer submit
         
         function checkSubmit() {
             if (!enviando) {
         		enviando= true;
         		return true;
             } else {
                 //Si llega hasta aca significa que pulsaron 2 veces el boton submit
                
               
                 return false;
             }
         }
