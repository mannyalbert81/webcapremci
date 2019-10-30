<?php

class GenerarApsController extends ControladorBase{

	public function __construct() {
		parent::__construct();
	}

	
	
	
	


	public function index(){
	
	
	    $exportar_aps = new GenerarApsModel();
	   
	    $texto="";
	    
		
	    $columnas="*";
	    $tablas="exportar_aps";
	    $where="1=1 AND anio='2018'";
	    $id="cedula";
	    
	    $resulSet =  $exportar_aps->getCondiciones($columnas, $tablas, $where, $id);
	    
	    
	    if(!empty($resulSet)){
	        
	        
	        $texto .='<?xml version="1.0" encoding="UTF-8"?>';
	        $texto .= '<aps>';
	        $texto .= '<TipoIDInformante>R</TipoIDInformante>';
	        $texto .= '<IdInformante>1791700376001</IdInformante>';
	        $texto .= '<TipoSociedad>07</TipoSociedad>';
	        $texto .= '<Anio>2016</Anio>';
	        $texto .= '<Mes>00</Mes>';
	        $texto .= '<PorcentajeAccionarioNoBolsa>0.00</PorcentajeAccionarioNoBolsa>';
	        $texto .= '<codigoOperativo>APS</codigoOperativo>';
	        $texto .= '<PorcentajeAccionarioBolsa>0.00</PorcentajeAccionarioBolsa>';
	        $texto .= '<Anticipada>NO</Anticipada>';
	        
	        $texto .= '<accionistas>';
	        
	        
	        foreach ($resulSet as $res){
	        
    	        $texto .= '<accionista>';
    	        
        	        $texto .= '<tipoIdentificacion>C</tipoIdentificacion>';
        	        $texto .= '<numeroIdentificacion>'.$res->cedula.'</numeroIdentificacion>';
        	        $texto .= '<nombresRazonSocial>'.$res->nombres.'</nombresRazonSocial>';
        	        $texto .= '<tipoSociedadExt>NA</tipoSociedadExt>';
        	        $texto .= '<figuraJuridicaExt>NA</figuraJuridicaExt>';
        	        $texto .= '<esSociedadPublicaExt>NO</esSociedadPublicaExt>';
        	        $texto .= '<porcentajeAccionarioNoBolsaExt>0.0</porcentajeAccionarioNoBolsaExt>';
        	        $texto .= '<porcentajeAccionarioBolsaExt>0.0</porcentajeAccionarioBolsaExt>';
        	        $texto .= '<identificacionInformantePadre>1791700376001</identificacionInformantePadre>';
        	        $texto .= '<tipoRegimenFiscal>01</tipoRegimenFiscal>';
        	        
        	        $texto .= '<infoParticipacionAccionaria>';
        	        $texto .= '<codigoNivel>1</codigoNivel>';
        	        $texto .= '<tipoRelacionadoSociedad>03</tipoRelacionadoSociedad>';
        	        $texto .= '<porcentajeParticipacion>'.$res->porcentaje.'</porcentajeParticipacion>';
        	        $texto .= '<parteRelacionadaInformante>NO</parteRelacionadaInformante>';
        	        $texto .= '</infoParticipacionAccionaria>';
        	        
        	        
        	        $texto .= '<ubicacionResidenciaFiscal>';
        	        $texto .= '<paisRegimenFiscal>593</paisRegimenFiscal>';
        	        $texto .= '</ubicacionResidenciaFiscal>';
        	        
    	        
    	        $texto .= '</accionista>';
    	        
	        }
	        
	        
	        $texto .= '</accionistas>';
	        
	        
	        
	        $texto .= '</aps>';
	        
	        
	       
	        
	        
	        $textoXML = mb_convert_encoding($texto, "UTF-8");
	        
	        // Grabamos el XML en el servidor como un fichero plano, para
	        // poder ser leido por otra aplicación.
	        $gestor = fopen("C:\PRUEBA_TWAIN\miXML.xml", 'w');
	        fwrite($gestor, $textoXML);
	        fclose($gestor);
	        
	        
	    }
	    
	    
	    
	    
	    
	    
	
	}
	
	
	
	
		
}
?>