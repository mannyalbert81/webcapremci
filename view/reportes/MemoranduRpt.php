<?php
 
include('view/mpdf60/mpdf.php'); 

//echo getcwd().'\n'; //para ver ubicacion de directorio

$template = file_get_contents('view/reportes/template/Memorandu.html');

//para la numeracion de pagina
$footer = file_get_contents('view/reportes/template/Footer.html');


//$template = str_replace('{detalle}', $detalle, $template);

//cuando ya viene el diccionario de datos
if(!empty($dicContenido))
{
	
	foreach ($dicContenido as $clave=>$valor) {
		$template = str_replace('{'.$clave.'}', $valor, $template);
	}
}
// var_dump($template);

// echo $template; 
// die();
ob_end_clean();


//creacion del pdf
//$mpdf=new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);

$mpdf=new mPDF();
$mpdf->SetDisplayMode('fullpage');
$mpdf->allow_charset_conversion = true;
$mpdf->charset_in = 'UTF-8';

$mpdf->SetHTMLFooter($footer);
$mpdf->WriteHTML($template);
$mpdf->debug = true;
 
$mpdf->Output();

exit();

?>