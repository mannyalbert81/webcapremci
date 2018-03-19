
	
 <?php
 
$directorio = $_SERVER ['DOCUMENT_ROOT'] . '/webcapremci';
$dom=$directorio.'/view/dompdf/dompdf_config.inc.php';

require_once( $dom);

$html =$resultSet;
 

$dompdf = new DOMPDF();
$dompdf->load_html(utf8_decode($html));
$dompdf->set_paper("A4", "portrait");

$dompdf->render();
$dompdf->stream("mipdf.pdf", array("Attachment" => 0));
?>


