$(document).ready(function(){
	
	cargaGenero();
	cargaEstadoCivil();
	cargaProvincias();
	cargaCantones();
	cargaParroquias();
	cargaBancos();
	
})




function cargaGenero(){
	
	let $ddlGenero = $("#id_sexo");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudPrestaciones&action=cargaGenero",
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

function cargaEstadoCivil(){
	
	let $ddlEsCivil = $("#id_estado_civil");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudPrestaciones&action=cargaEstadoCivil",
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

function cargaProvincias(){
	
	let $ddlProvincias = $("#id_provincias");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudPrestaciones&action=cargaProvincias",
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
function cargaCantones(id_provincias){
	
	let $dllCantones = $("#id_cantones");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudPrestaciones&action=cargaCantones",
		type:"POST",
		dataType:"json",
		data:{id_provincias:id_provincias}
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

$("#id_provincias").change(function() {
	

	
      var id_provincias = $(this).val();
      let $dllCantones = $("#id_cantones");
      $dllCantones.empty();
      cargaCantones(id_provincias);
      
      
   
   });
	

// cargar parroquias


function cargaParroquias(id_cantones){
	
	let $dllParroquias = $("#id_parroquias");
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudPrestaciones&action=cargaParroquias",
		type:"POST",
		dataType:"json",
		data:{id_cantones:id_cantones}
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

$("#id_cantones").change(function() {
	

	
      var id_cantones = $(this).val();
      let $dllParroquias = $("#id_parroquias");
      $dllParroquias.empty();
      cargaParroquias(id_cantones);
      
      
   
   });


function cargaBancos(){
	
	let $ddlBancos = $("#id_bancos");

	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudPrestaciones&action=cargaBancos",
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

$("#frm_solicitudes").on("submit",function(event){
	
	event.preventDefault();
	
	let _apellidos_solicitud_prestaciones = document.getElementById('apellidos_solicitud_prestaciones').value;
	let _nombres_solicitud_prestaciones = document.getElementById('nombres_solicitud_prestaciones').value;
	let _cedula_participes = document.getElementById('cedula_participes').value;
	let _id_sexo = document.getElementById('id_sexo').value;
	let _fecha_nacimiento_solicitud_prestaciones = document.getElementById('fecha_nacimiento_solicitud_prestaciones').value;
	let _id_estado_civil = document.getElementById('id_estado_civil').value;
	let _id_provincias = document.getElementById('id_provincias').value;
	let _id_cantones = document.getElementById('id_cantones').value;
	let _id_parroquias = document.getElementById('id_parroquias').value;
	let _barrio_solicitud_prestaciones = document.getElementById('barrio_solicitud_prestaciones').value;
	let _ciudadela_solicitud_prestaciones = document.getElementById('ciudadela_solicitud_prestaciones').value;
	let _calle_solicitud_prestaciones = document.getElementById('calle_solicitud_prestaciones').value;
	let _numero_calle_solicitud_prestaciones = document.getElementById('numero_calle_solicitud_prestaciones').value;
	let _interseccion_solicitud_prestaciones = document.getElementById('interseccion_solicitud_prestaciones').value;
	let _tipo_vivienda_solicitud_prestaciones = document.getElementById('tipo_vivienda_solicitud_prestaciones').value;
	let _vivienda_hipotecada_solicitud_prestaciones = document.getElementById('vivienda_hipotecada_solicitud_prestaciones').value;
	let _referencia_dir_solicitud_prestaciones = document.getElementById('referencia_dir_solicitud_prestaciones').value;
	let _telefono_solicitud_prestaciones = document.getElementById('telefono_solicitud_prestaciones').value;
	let _celular_solicitud_prestaciones = document.getElementById('celular_solicitud_prestaciones').value;
	let _correo_solicitud_prestaciones = document.getElementById('correo_solicitud_prestaciones').value;
	let _nivel_educativo_solicitud_prestaciones = document.getElementById('nivel_educativo_solicitud_prestaciones').value;
	let _nombres_referencia_familiar = document.getElementById('nombres_referencia_familiar').value;
	let _apellidos_referencia_familiar = document.getElementById('apellidos_referencia_familiar').value;
	let _parentesco_referencia_familiar = document.getElementById('parentesco_referencia_familiar').value;
	let _primer_telefono_referencia_familiar = document.getElementById('primer_telefono_referencia_familiar').value;
	let _segundo_telefono_referencia_familiar = document.getElementById('segundo_telefono_referencia_familiar').value;
	let _nombres_referencia_personal = document.getElementById('nombres_referencia_personal').value;
	let _apellidos_referencia_personal = document.getElementById('apellidos_referencia_personal').value;
	let _parentesco_referencia_personal = document.getElementById('parentesco_referencia_personal').value;
	let _primer_telefono_referencia_personal = document.getElementById('primer_telefono_referencia_personal').value;
	let _segundo_telefono_referencia_personal = document.getElementById('segundo_telefono_referencia_personal').value;
	let _ultimo_cargo_solicitud_prestaciones = document.getElementById('ultimo_cargo_solicitud_prestaciones').value;
	let _fecha_salida_solicitud_prestaciones = document.getElementById('fecha_salida_solicitud_prestaciones').value;
	let _id_bancos = document.getElementById('id_bancos').value;
	let _numero_cuenta_ahorros_bancaria = document.getElementById('numero_cuenta_ahorros_bancaria').value;
	let _numero_cuenta_corriente_bancaria = document.getElementById('numero_cuenta_corriente_bancaria').value;
	let _id_codigo_verificacion = document.getElementById('id_codigo_verificacion').value;
	let _id_solicitud_prestaciones = document.getElementById('id_solicitud_prestaciones').value;

	
	
	var parametros = {apellidos_solicitud_prestaciones:_apellidos_solicitud_prestaciones,nombres_solicitud_prestaciones:_nombres_solicitud_prestaciones,cedula_participes:_cedula_participes,id_sexo:_id_sexo,fecha_nacimiento_solicitud_prestaciones:_fecha_nacimiento_solicitud_prestaciones,id_estado_civil:_id_estado_civil,id_provincias:_id_provincias,id_cantones:_id_cantones,id_parroquias:_id_parroquias,barrio_solicitud_prestaciones:_barrio_solicitud_prestaciones,ciudadela_solicitud_prestaciones:_ciudadela_solicitud_prestaciones,calle_solicitud_prestaciones:_calle_solicitud_prestaciones,numero_calle_solicitud_prestaciones:_numero_calle_solicitud_prestaciones,interseccion_solicitud_prestaciones:_interseccion_solicitud_prestaciones,tipo_vivienda_solicitud_prestaciones:_tipo_vivienda_solicitud_prestaciones,vivienda_hipotecada_solicitud_prestaciones:_vivienda_hipotecada_solicitud_prestaciones,referencia_dir_solicitud_prestaciones:_referencia_dir_solicitud_prestaciones,telefono_solicitud_prestaciones:_telefono_solicitud_prestaciones,celular_solicitud_prestaciones:_celular_solicitud_prestaciones,correo_solicitud_prestaciones:_correo_solicitud_prestaciones,nivel_educativo_solicitud_prestaciones:_nivel_educativo_solicitud_prestaciones,nombres_referencia_familiar:_nombres_referencia_familiar,apellidos_referencia_familiar:_apellidos_referencia_familiar,parentesco_referencia_familiar:_parentesco_referencia_familiar,primer_telefono_referencia_familiar:_primer_telefono_referencia_familiar,segundo_telefono_referencia_familiar:_segundo_telefono_referencia_familiar,nombres_referencia_personal:_nombres_referencia_personal,apellidos_referencia_personal:_apellidos_referencia_personal,parentesco_referencia_personal:_parentesco_referencia_personal,primer_telefono_referencia_personal:_primer_telefono_referencia_personal,segundo_telefono_referencia_personal:_segundo_telefono_referencia_personal,ultimo_cargo_solicitud_prestaciones:_ultimo_cargo_solicitud_prestaciones,fecha_salida_solicitud_prestaciones:_fecha_salida_solicitud_prestaciones,id_bancos:_id_bancos,numero_cuenta_ahorros_bancaria:_numero_cuenta_ahorros_bancaria,numero_cuenta_corriente_bancaria:_numero_cuenta_corriente_bancaria,id_codigo_verificacion:_id_codigo_verificacion,id_solicitud_prestaciones:_id_solicitud_prestaciones}
	
	
	
	$.ajax({
		beforeSend:function(){},
		url:"index.php?controller=SolicitudPrestaciones&action=InsertarSolicitud",
		type:"POST",
		dataType:"json",
		data:parametros
	}).done(function(datos){
		document.getElementById("frm_solicitudes").reset();     
		console.log(datos);
	swal({
  		  title: "SolicitudPrestaciones",
  		  text: datos.mensaje,
  		  icon: "success",
  		  button: "Aceptar",
  		});
	
		
	}).fail(function(xhr,status,error){
		
		var err = xhr.responseText
		console.log(err);
		
	}).always(function(){
		//$("#id_solicitud_prestaciones").val(0);
		//document.getElementById("frm_solicitudes").reset();	
		
	})

	
})

$("#Guardar").click(function() {
	//selecionarTodos();
	
	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	var validaFecha = /([0-9]{4})\-([0-9]{2})\-([0-9]{2})/;
	
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
	var numero_cuenta_ahorros_bancaria  = $("#numero_cuenta_ahorros_bancaria").val();
	var numero_cuenta_corriente_bancaria  = $("#numero_cuenta_corriente_bancaria").val();
	var id_codigo_verificacion        			     = $("#id_codigo_verificacion").val();
	var numero_codigo_verificacion                     = $("#numero_codigo_verificacion").val();
	

	if (cedula_participes  == "")
	{    	
		$("#mensaje_cedula_participes").text("Ingrese un número de cédula");
		$("#mensaje_cedula_participes").fadeIn("slow"); //Muestra mensaje de error
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
        return false
    }    
	
	else
		{
		
		$("#mensaje_id_bancos").fadeOut("slow"); //Muestra mensaje de error
	    	
		
     }
	
	
                    				
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
		 
		
