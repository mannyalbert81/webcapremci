<?php

	require_once '../core/DB_Functions.php';
	$db = new DB_Functions();
	$resultado="";
	$accion=(isset($_POST['action']))?$_POST['action']:'';
	$_cedula_usuarios  = (isset($_POST['cedula_usuarios']))?$_POST['cedula_usuarios']:'';	
	$_clave_usuarios  = (isset($_POST['clave_usuarios']))?$_POST['clave_usuarios']:'';

	if($accion=="consulta"){
		
		if($_cedula_usuarios!="" && $_clave_usuarios!=""){
			
			$_clave=$db->encriptar($_clave_usuarios);
			$tabla="usuarios";
			$where = "cedula_usuarios = '$_cedula_usuarios' AND clave_usuarios ='$_clave'";
			$resultado=$db->getBy($tabla, $where);
			
			if(!empty($resultado)){
				// existe el usuario va lleno.
				
					$listUsr = [];
				
					foreach ($resultado as $res)
					{
						$rowfoto = new stdClass();
						
						$rowfoto->id_usuarios = $res->id_usuarios;
						$rowfoto->cedula_usuarios = $res->cedula_usuarios;
						$rowfoto->nombre_usuarios = $res->nombre_usuarios;
						$rowfoto->correo_usuarios = $res->correo_usuarios;
						$rowfoto->id_rol = $res->id_rol;
						$rowfoto->id_estado = $res->id_estado;
						$rowfoto->fotografia_usuarios=base64_encode(pg_unescape_bytea($res->fotografia_usuarios));//$res->foto_fichas_fotos;
						$listUsr[]=$rowfoto;
					}
				
					echo json_encode($listUsr);
				die();
				
			}else{
				// no existe el usuarios va vacio.
				$resultadosJson = "";
				die();
			}
			
		}else{
			// no vienen los datos
			$resultadosJson = "";
			die();
		}
	   
		
		
		
	}
	
	
	
	
	
	if($accion=="banner"){
		
		
		$columnas = "id_publicidad_movil, id_usuarios, imagen_baner";
		$tablas   = "publicidad_movil";
		$where    = "1=1";
		$id       = "id_publicidad_movil";
		$resultSet = $db->getCondiciones($columnas ,$tablas ,$where, $id);
		
		
		
		$i=count($resultSet);
		
		$html="";
		if($i>0)
		{
		
		
			$html .= "<div  class='col-xs-12 col-md-12 col-lg-12'>";
			$html .= "<div class='col-xs-12 col-md-4 col-lg-4'>";
			$html .= "</div>";
			$html .= "<div class='col-xs-12 col-md-3 col-lg-3'>";
			$html .= "<div id='myCarousel2' class='carousel slide' data-ride='carousel'>";
			$html .= "<ol class='carousel-indicators'>";
			$html .= "<li data-target='#myCarousel1' data-slide-to='0' class='active'></li>";
			$html .= "<li data-target='#myCarousel2' data-slide-to='0' ></li>";
			$html .= "</ol>";
				
			$html .= "<div class='carousel-inner' role='listbox'>";
				
			if(!empty($resultSet)){
		
				$numero=0;
				foreach ($resultSet as $res){
						
					$numero++;
					
						
					if($numero==1){
		
						$foto=base64_encode(pg_unescape_bytea($res->imagen_baner));
						$imgficha = 'data:image/png;base64,'.$foto;
						
						$html .= "<div class='item active'>";
						$html.='<img src="'.$imgficha.'" >';
						$html .= "</div>";
		
					}else{
						$foto=base64_encode(pg_unescape_bytea($res->imagen_baner));
						$imgficha = 'data:image/png;base64,'.$foto;
						
						$html .= "<div class='item'>";
						$html.='<img src="'.$imgficha.'" >';
						$html .= "</div>";
		
					}
					$foto="";
					$imgficha="";
				}
		
		
			}
				
				
		
				
				
			$html .= "<a class='left carousel-control' href='#myCarousel2' role='button' data-slide='prev'>";
			$html .= "<span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>";
			$html .= "<span class='sr-only'>Previous</span>";
			$html .= "</a>";
			$html .= "<a class='right carousel-control' href='#myCarousel2' role='button' data-slide='next'>";
			$html .= "<span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>";
			$html .= "<span class='sr-only'>Next</span>";
			$html .= "</a>";
			$html .= "</div>";
			$html .= "</div>";
			$html .= "</div>";
			$html .= "<div class='col-xs-12 col-md-4 col-lg-4'>";
			$html .= "</div>";
			$html .= "</div>";
				
				
		
		
		}else{
		
			$html = "<b>Actualmente no hay publicidad registrada...</b>";
		}
		
		
		echo json_encode($html);
		
	}




	