<?php 

require("phpToPDF/phpToPDF.php");

$filename = time().".pdf";

$pdf_options = array(
		"source_type" => 'url',
		"source" => 'http://google.com',
		"action" => 'save',
		"save_directory" => '',
		"file_name" => $filename);

// CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
phptopdf($pdf_options);

?>
