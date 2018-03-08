<?php

class RegularizacionController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}


	public function index(){
	
	
		//Creamos el objeto usuario
		$regularizacion = new RegularizacionModel();
		$parametros = "";
		//Conseguimos todos los usuarios
		$columnas = "documentos_legal.id_documentos_legal, cliente_proveedor.nombre_cliente_proveedor, cliente_proveedor.ruc_cliente_proveedor, documentos_legal.numero_credito_documentos_legal, documentos_legal.monto_documentos_legal, documentos_legal.plazo_meses_documentos_legal, documentos_legal.destino_documentos_legal, documentos_legal.fecha_documentos_legal, documentos_legal.regularizado";
		$tablas = " public.documentos_legal, public.cliente_proveedor";
		$where   = "cliente_proveedor.id_cliente_proveedor = documentos_legal.id_cliente_proveedor AND id_subcategorias='37'  ";
		$id = " documentos_legal.numero_credito_documentos_legal";
	
		$where_1 = "";
		$where_2 = "";
		$where_3 = "";
	
		$seleccionado = "NO";
	
		$resultEdit = "";
	
	
		$_id_documentos_legal = 0;
		$_fecha_presentacion_regularizacion = '01/01/2017';
		$_deudor_regularizacion  = "FALSE";
		$_garante_regularizacion = "FALSE";
		$_id_documentos_legal = 0;
	
		$_nombre_regularizacion = "";
		$_identificacion_regularizacion = "";
		$_monto_dolares_regularizacion = 0;
		$_plazo_meses_regularizacion = 0;
		$_destino_dinero_regularizacion = "";
		$_numero_regularizacion = "";
		$_id_usuario = 0;
		$_fecha_regularizacion = '01/01/2017';
	
	
		session_start();
	
		$resultSet = "";
	
		if (isset(  $_SESSION['usuario_usuario']) )
		{
	
			$nombre_controladores = "Regularizacion";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $regularizacion->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
	
			if (!empty($resultPer))
			{
	
				if (isset($_POST["criterio_busqueda"]))
				{
					$criterio = $_POST["criterio_busqueda"];
					$contenido = $_POST["contenido_busqueda"];
						
					if ($contenido !="")
					{
							
							
						switch ($criterio) {
							case 1:
								//Ruc Cliente/Proveedor
								$where_1 = " AND documentos_legal.id_documentos_legal = '$contenido'  ";
								break;
							case 2:
								//Ruc Cliente/Proveedor
								$where_2 = " AND documentos_legal.numero_credito_documentos_legal LIKE '$contenido'  ";
								break;
							case 3:
								//Nombre Cliente/Proveedor
								$where_3 = " AND cliente_proveedor.ruc_cliente_proveedor LIKE '$contenido'  ";
								break;
						}
							
						$where_to  = $where  . $where_1 . $where_2 . $where_3  ;
	
						$resultSet=$regularizacion-> getCondiciones($columnas ,$tablas , $where_to, $id);
	
							
					}
						
	
	
				}
				if (    isset ($_GET["id_documentos_legal"])   )
				{
						
	
						
						
					//ins_regularizacion(_id_documentos_legal integer, _fecha_presentacion_regularizacion date, _deudor_regularizacion boolean, _garante_regularizacion boolean, _nombre_regularizacion character varying, _identificacion_regularizacion character varying, _monto_dolares_regularizacion numeric, _plazo_meses_regularizacion integer, _destino_dinero_regularizacion character varying, _numero_regularizacion character varying, _id_usuario integer)
						
					$_id_documentos_legal = $_GET["id_documentos_legal"];
					$where_get = " AND documentos_legal.id_documentos_legal = '$_id_documentos_legal' ";
						
					$where_to  = $where . $where_get;
						
					$seleccionado = "SI";
					$resultSet=$regularizacion-> getCondiciones($columnas ,$tablas , $where_to, $id);
	
				}
	
	
	
				if (isset($_POST["btnGuardar"]))
				{
					
					
					$columnas = "cliente_proveedor.ruc_cliente_proveedor, 
  								cliente_proveedor.nombre_cliente_proveedor, 
  								documentos_legal.id_documentos_legal, 
  								documentos_legal.numero_credito_documentos_legal, 
								documentos_legal.fecha_documentos_legal, 
  								documentos_legal.monto_documentos_legal, 
  								documentos_legal.plazo_meses_documentos_legal, 
  								documentos_legal.destino_documentos_legal";
					$tablas  = "public.cliente_proveedor, 
  								public.documentos_legal"; 
					$where_to = "cliente_proveedor.id_cliente_proveedor = documentos_legal.id_cliente_proveedor AND  documentos_legal.id_subcategorias = '37' ";
					$id   = "documentos_legal.id_documentos_legal";
					$resultReg=$regularizacion-> getCondiciones($columnas ,$tablas , $where_to, $id);
				
					if (!empty($resultReg))
					{
						foreach($resultReg as $res)
						{
							
							$_id_documentos_legal = $res->id_documentos_legal;
							$_nombre_regularizacion = $res->nombre_cliente_proveedor;
							$_identificacion_regularizacion = $res->ruc_cliente_proveedor;
							$_monto_dolares_regularizacion = $res->monto_documentos_legal;
							$_plazo_meses_regularizacion = 0;
							$_destino_dinero_regularizacion = $res->destino_documentos_legal;
							$_numero_regularizacion = $res->numero_credito_documentos_legal;
							$_id_usuario  = $_SESSION['id_usuario'];
							$_fecha_presentacion_regularizacion = substr($res->fecha_documentos_legal, 0, 10); 
							$_fecha_regularizacion = substr($res->fecha_documentos_legal, 0, 10);
							try
							{
							
								$funcion = "ins_regularizacion";
								$parametros = " '$_id_documentos_legal', '$_fecha_presentacion_regularizacion' , '$_deudor_regularizacion' , '$_garante_regularizacion' , '$_nombre_regularizacion' , '$_identificacion_regularizacion' , '$_monto_dolares_regularizacion' , '$_plazo_meses_regularizacion'  , '$_destino_dinero_regularizacion' , '$_numero_regularizacion' , '$_id_usuario' , '$_fecha_regularizacion' ";
								$regularizacion->setFuncion($funcion);
								$regularizacion->setParametros($parametros);
								$resultado=$regularizacion->Insert();
							
							
								///update documentos
							
								$colval = " regularizado = 'TRUE' ";
								$tabla  = "documentos_legal";
								$where = "id_documentos_legal = '$_id_documentos_legal' ";
								$regularizacion->UpdateBy($colval, $tabla, $where);
									
							
								//echo '<script>window.open("http://186.4.241.148:5001/contRegularizacion.aspx?id=' .$_id_documentos_legal  .  '");</script>';
							
							}
							catch (Exception $e)
							{
									
							}
							
							
					
						}
					}
						
						
						
						}
	
				$this->view("Regularizacion",array(
						"resultSet"=>$resultSet, "seleccionado"=>$seleccionado, "parametros"=>$parametros
							
				));
	
	
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No Tiene Permisos a Regularizacion"
				));
	
	
			}
	
		}
		else
		{
			$this->view("ErrorSesion",array(
					"resultSet"=>""
	
			));
	
		}
	
	
	}
	
	public function Update()
	{
		$resultado = null;
		$carton_documentos = new CartonDocumentosModel();
		$documentos_legal = new  DocumentosLegalModel();
		session_start();
	
		$nombre_controladores = "CartonDocumentos";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $carton_documentos->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
	
			$_destino_id = "";
			$_destino_numero = "";
				
	
	
			if (isset ($_POST["btn_guardar"]) )
			{
	
				if ($_POST["destino_id"])
				{
					$destino_new_id = $_POST["destino_new_id"];
					$destino_id = $_POST["destino_id"];
					$destino_numero = $_POST["destino_numero"];
						
	
	
					if(count($destino_id) != count($destino_numero))
					{
						$resNumero = array_combine(array_intersect_key($destino_id, $destino_numero), array_intersect_key($destino_numero, $destino_id) );
					}
					else
					{
						$resNumero =  array_combine($destino_id, $destino_numero);
					}
	
						
					foreach($resNumero  as $id => $numero )
					{
						if (!empty($id) || !empty($numero))
						{
								
							$colval = "numero_carton_documentos = rtrim('$numero') ";
							$tabla = "carton_documentos";
							$where = "id_carton_documentos = '$id' ";
							$carton_documentos->UpdateBy($colval, $tabla, $where);
						}
	
					}
	
	
	
					if(count($destino_id) != count($destino_new_id))
					{
						$resId = array_combine(array_intersect_key($destino_id, $destino_new_id), array_intersect_key($destino_new_id, $destino_id) );
					}
					else
					{
						$resId =  array_combine($destino_id, $destino_new_id);
					}
	
	
					foreach($resId  as $id => $id_new )
					{
						if (!empty($id_new) )
						{
							//busco si exties este nuevo id
	
							try {
								$resCar = $carton_documentos->getBy("id_carton_documentos = '$id_new' ");
							} catch (Exception $e) {
	
							}
	
							if (count($resCar) > 0)
							{
								///act documentos
								$colval = " id_carton_documentos = '$id_new' ";
								$tabla  = "documentos_legal";
								$where = "id_carton_documentos = '$id' ";
								$documentos_legal->UpdateBy($colval, $tabla, $where);
	
								//delete los proveedores
								$carton_documentos->deleteBy("id_carton_documentos", $id);
							}
	
	
						}
							
							
					}
	
	
	
				}
	
			}
	
			$resultCar=$carton_documentos->getAll("numero_carton_documentos");
			$resultEdit = "";
			if (isset($_POST["btn_index_id"]))
			{
				$resultCar=$carton_documentos->getAll("id_carton_documentos");
			}
	
			if (isset($_POST["btn_index_numero"]))
			{
				$resultCar=$carton_documentos->getAll("numero_carton_documentos");
			}
				
	
	
			$this->view("CartonDocumentos",array(
					"resultCar"=>$resultCar, "resultEdit" =>$resultEdit
	
			));
	
	
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Editar Clientes/Proveedor"
	
			));
	
	
		}
	
	}
	
	
	
	public function Reporte(){
	
		//Creamos el objeto usuario
		$categorias=new CategoriasModel();
		//Conseguimos todos los usuarios
	
	
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $categorias->getByPDF("id_categorias, nombre_categorias, path_categorias", " nombre_categorias != '' ");
			$this->report("Categorias",array(	"resultRep"=>$resultRep));
	
		}
			
	
	}
	
	
	public function ReporteTotal(){
	
	
		//Creamos el objeto usuario
		$categorias=new CategoriasModel();
		//Conseguimos todos los usuarios
	
		$documentos_legal=new DocumentosLegalModel();
	
	
		$columnas = " categorias.nombre_categorias, COUNT(documentos_legal.paginas_documentos_legal) AS lecturas_documentos, SUM(documentos_legal.paginas_documentos_legal)  AS paginas_documentos";
		$tablas   = " public.categorias, public.subcategorias, public.documentos_legal";
		$where    = " subcategorias.id_categorias = categorias.id_categorias AND subcategorias.id_subcategorias = documentos_legal.id_subcategorias GROUP BY categorias.nombre_categorias";
		$id       = "categorias.nombre_categorias";
	
	
		$columnas2 = " 'TOTALES' AS totales,  SUM(paginas_documentos_legal) AS total_paginas, COUNT(id_documentos_legal) AS total_documentos";
		$where2 = "id_documentos_legal > 0";
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $categorias->getCondicionesPDF($columnas, $tablas, $where, $id);
	
			$resultRep2 = $documentos_legal->getByPDF($columnas2, $where2);
				
	
				
				
			$this->report("CategoriasDocumentos",array(	"resultRep"=>$resultRep, "resultRep2"=>$resultRep2));
	
		}
			
	
	
	}
	
	
	
/*
	public function index(){
		

		//Creamos el objeto usuario
		$regularizacion = new RegularizacionModel();
		
		//Conseguimos todos los usuarios
		$columnas = "documentos_legal.id_documentos_legal, cliente_proveedor.nombre_cliente_proveedor, cliente_proveedor.ruc_cliente_proveedor, documentos_legal.numero_credito_documentos_legal, documentos_legal.monto_documentos_legal, documentos_legal.plazo_meses_documentos_legal, documentos_legal.destino_documentos_legal, documentos_legal.fecha_documentos_legal, documentos_legal.regularizado"; 
	    $tablas = " public.documentos_legal, public.cliente_proveedor";
		$where   = "cliente_proveedor.id_cliente_proveedor = documentos_legal.id_cliente_proveedor AND id_subcategorias='37'  ";
		$id = " documentos_legal.numero_credito_documentos_legal";
		
		$where_1 = "";
		$where_2 = "";
		$where_3 = "";
		
		$seleccionado = "NO";
		
		$resultEdit = "";
		
		
		$_id_documentos_legal = 0;
		$_fecha_presentacion_regularizacion = null;
		$_deudor_regularizacion  = "FALSE";
		$_garante_regularizacion = "FALSE";
		$_id_documentos_legal = 0;
		
		$_nombre_regularizacion = "";
		$_identificacion_regularizacion = "";
		$_monto_dolares_regularizacion = 0;
		$_plazo_meses_regularizacion = 0;
		$_destino_dinero_regularizacion = "";
		$_numero_regularizacion = "";
		$_id_usuario = 0;
		$_fecha_regularizacion = null;
		
		
		session_start();
		
		$resultSet = "";
		
		if (isset(  $_SESSION['usuario_usuario']) )
		{
				
			$nombre_controladores = "Regularizacion";
			$id_rol= $_SESSION['id_rol'];
			$resultPer = $regularizacion->getPermisosVer("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
		
			if (!empty($resultPer))
			{
				
				if (isset($_POST["criterio_busqueda"]))
				{
					$criterio = $_POST["criterio_busqueda"];
					$contenido = $_POST["contenido_busqueda"];
					
					if ($contenido !="")
					{
							
					
						switch ($criterio) {
							case 1:
								//Ruc Cliente/Proveedor
								$where_1 = " AND documentos_legal.id_documentos_legal = '$contenido'  ";
								break;
							case 2:
								//Ruc Cliente/Proveedor
								$where_2 = " AND documentos_legal.numero_credito_documentos_legal LIKE '$contenido'  ";
								break;
							case 3:
								//Nombre Cliente/Proveedor
								$where_3 = " AND cliente_proveedor.ruc_cliente_proveedor LIKE '$contenido'  ";
								break;
								}
					
								$where_to  = $where  . $where_1 . $where_2 . $where_3  ;
								
								$resultSet=$regularizacion-> getCondiciones($columnas ,$tablas , $where_to, $id);
								
					
					}
					
				
		
				}
				if (    isset ($_GET["id_documentos_legal"])   )
				{	
					
										
					
					
					//ins_regularizacion(_id_documentos_legal integer, _fecha_presentacion_regularizacion date, _deudor_regularizacion boolean, _garante_regularizacion boolean, _nombre_regularizacion character varying, _identificacion_regularizacion character varying, _monto_dolares_regularizacion numeric, _plazo_meses_regularizacion integer, _destino_dinero_regularizacion character varying, _numero_regularizacion character varying, _id_usuario integer)
					
					$_id_documentos_legal = $_GET["id_documentos_legal"];
					$where_get = " AND documentos_legal.id_documentos_legal = '$_id_documentos_legal' ";
					
					$where_to  = $where . $where_get;
					
					$seleccionado = "SI";
					$resultSet=$regularizacion-> getCondiciones($columnas ,$tablas , $where_to, $id);
						
				}
				
				
				
				if (isset($_POST["btnGuardar"]))
				{
				
					
					
					
					
					$_id_documentos_legal = $_POST["id_documentos_legal"];
					$_fecha_presentacion_regularizacion = $_POST["fecha_presentacion_regularizacion"];
					
					$_id_documentos_legal = $_POST["id_documentos_legal"];
					
					if  ( $_POST["deudor_regularizacion"] == 'TRUE')
					{
						$_deudor_regularizacion = "TRUE";
					}
					else 
					{
						$_garante_regularizacion = "FALSE";
					}
					
					$_nombre_regularizacion = $_POST["nombre_regularizacion"];
					$_identificacion_regularizacion = $_POST["identificacion_regularizacion"];
					$_monto_dolares_regularizacion = $_POST["monto_dolares_regularizacion"];
					$_plazo_meses_regularizacion = $_POST["plazo_meses_regularizacion"];
					$_destino_dinero_regularizacion = $_POST["destino_dinero_regularizacion"];
					$_numero_regularizacion = $_POST["numero_regularizacion"];
					$_id_usuario  = $_SESSION['id_usuario'];
					$_fecha_regularizacion = $_POST["fecha_regularizacion"];
					
					try 
					{
						
						$funcion = "ins_regularizacion";
						$parametros = " '$_id_documentos_legal', '$_fecha_presentacion_regularizacion' , '$_deudor_regularizacion' , '$_garante_regularizacion' , '$_nombre_regularizacion' , '$_identificacion_regularizacion' , '$_monto_dolares_regularizacion' , '$_plazo_meses_regularizacion'  , '$_destino_dinero_regularizacion' , '$_numero_regularizacion' , '$_id_usuario' , '$_fecha_regularizacion' ";
						$regularizacion->setFuncion($funcion);
						$regularizacion->setParametros($parametros);
						$resultado=$regularizacion->Insert();
						
		
						///update documentos
						
						$colval = " regularizado = 'TRUE' ";
						$tabla  = "documentos_legal";
						$where = "id_documentos_legal = '$_id_documentos_legal' ";
						$regularizacion->UpdateBy($colval, $tabla, $where);
							
						
						echo '<script>window.open("http://186.4.241.148:5001/contRegularizacion.aspx?id=' .$_id_documentos_legal  .  '");</script>';
						
					} 
					catch (Exception $e) 
					{
					
					}
					
				}
				
				$this->view("Regularizacion",array(
						"resultSet"=>$resultSet, "seleccionado"=>$seleccionado
							
				));
		
		
			}
			else
			{
				$this->view("Error",array(
						"resultado"=>"No Tiene Permisos a Regularizacion"
				));
		
		
			}
		
		}
		else
		{
			$this->view("ErrorSesion",array(
					"resultSet"=>""
		
			));
		
		}
		
	
	}
	
	public function Update()
	{
		$resultado = null;
		$carton_documentos = new CartonDocumentosModel();
		$documentos_legal = new  DocumentosLegalModel();
		session_start();
		
		$nombre_controladores = "CartonDocumentos";
		$id_rol= $_SESSION['id_rol'];
		$resultPer = $carton_documentos->getPermisosEditar("   controladores.nombre_controladores = '$nombre_controladores' AND permisos_rol.id_rol = '$id_rol' " );
			
		if (!empty($resultPer))
		{
		
			$_destino_id = "";
			$_destino_numero = "";
			
				
				
			if (isset ($_POST["btn_guardar"]) )
			{
		
				if ($_POST["destino_id"])
				{
					$destino_new_id = $_POST["destino_new_id"];
					$destino_id = $_POST["destino_id"];
					$destino_numero = $_POST["destino_numero"];
					
					 
						
					if(count($destino_id) != count($destino_numero))
					{
						$resNumero = array_combine(array_intersect_key($destino_id, $destino_numero), array_intersect_key($destino_numero, $destino_id) );
					}
					else
					{
						$resNumero =  array_combine($destino_id, $destino_numero);
					}
						
					
					foreach($resNumero  as $id => $numero )
					{
						if (!empty($id) || !empty($numero))
						{
							
							$colval = "numero_carton_documentos = rtrim('$numero') ";
							$tabla = "carton_documentos";
							$where = "id_carton_documentos = '$id' ";
							$carton_documentos->UpdateBy($colval, $tabla, $where);
						}
		
					}
					 
					 
						
					if(count($destino_id) != count($destino_new_id))
					{
						$resId = array_combine(array_intersect_key($destino_id, $destino_new_id), array_intersect_key($destino_new_id, $destino_id) );
					}
					else
					{
						$resId =  array_combine($destino_id, $destino_new_id);
					}
						
						
					foreach($resId  as $id => $id_new )
					{
						if (!empty($id_new) )
						{
							//busco si exties este nuevo id
							 
							try {
								$resCar = $carton_documentos->getBy("id_carton_documentos = '$id_new' ");
							} catch (Exception $e) {
		
							}
		
							if (count($resCar) > 0)
							{
								///act documentos
								$colval = " id_carton_documentos = '$id_new' ";
								$tabla  = "documentos_legal";
								$where = "id_carton_documentos = '$id' ";
								$documentos_legal->UpdateBy($colval, $tabla, $where);
		
								//delete los proveedores
								$carton_documentos->deleteBy("id_carton_documentos", $id);
							}
		
							 
						}
							
							
					}
						
						
						
				}
		
			}
		
			$resultCar=$carton_documentos->getAll("numero_carton_documentos");
			$resultEdit = "";
			if (isset($_POST["btn_index_id"]))
			{
				$resultCar=$carton_documentos->getAll("id_carton_documentos");
			}
				
			if (isset($_POST["btn_index_numero"]))
			{
				$resultCar=$carton_documentos->getAll("numero_carton_documentos");
			}
			
				
		
			$this->view("CartonDocumentos",array(
					"resultCar"=>$resultCar, "resultEdit" =>$resultEdit
						
			));
		
				
		}
		else
		{
			$this->view("Error",array(
					"resultado"=>"No tiene Permisos de Editar Clientes/Proveedor"
		
			));
		
		
		}		
	
	}
	
	
	
	public function Reporte(){
	
		//Creamos el objeto usuario
		$categorias=new CategoriasModel();
		//Conseguimos todos los usuarios
		
	
	
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $categorias->getByPDF("id_categorias, nombre_categorias, path_categorias", " nombre_categorias != '' ");
			$this->report("Categorias",array(	"resultRep"=>$resultRep));
	
		}
					
	
	}
	

	public function ReporteTotal(){
	
	
		//Creamos el objeto usuario
		$categorias=new CategoriasModel();
		//Conseguimos todos los usuarios
	
		$documentos_legal=new DocumentosLegalModel();
		
	
		$columnas = " categorias.nombre_categorias, COUNT(documentos_legal.paginas_documentos_legal) AS lecturas_documentos, SUM(documentos_legal.paginas_documentos_legal)  AS paginas_documentos";
		$tablas   = " public.categorias, public.subcategorias, public.documentos_legal";
		$where    = " subcategorias.id_categorias = categorias.id_categorias AND subcategorias.id_subcategorias = documentos_legal.id_subcategorias GROUP BY categorias.nombre_categorias";
		$id       = "categorias.nombre_categorias";
	
	
		$columnas2 = " 'TOTALES' AS totales,  SUM(paginas_documentos_legal) AS total_paginas, COUNT(id_documentos_legal) AS total_documentos";
		$where2 = "id_documentos_legal > 0";
		
		session_start();
	
	
		if (isset(  $_SESSION['usuario']) )
		{
			$resultRep = $categorias->getCondicionesPDF($columnas, $tablas, $where, $id);

			$resultRep2 = $documentos_legal->getByPDF($columnas2, $where2);
			
				
			
			
			$this->report("CategoriasDocumentos",array(	"resultRep"=>$resultRep, "resultRep2"=>$resultRep2));
	
		}
			
	
	
	}
	
	*/
}
?>
