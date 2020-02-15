<?php 
require("../phpToPDF/phpToPDF.php");

include '../inc/header.php';
$sql = "SELECT * FROM email_templates WHERE id=8 LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$time = time();
$filename2 = "Orders_".$time.".pdf";

$url2 = baseurl().'/order/orderList.php?id='.$_GET['id'].'&rid=1&edited=yes&sprint=katchebehsibwosihampomodimandrehnahponteh';

$pdf_options2 = array(
		"source_type" => 'url',
		"source" => $url2,
		"action" => 'save',
		"save_directory" => 'contracts',
		"file_name" => $filename2);

// CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
    phptopdf($pdf_options2);

	$mail->addAddress($_GET["email"]);
	$subject = $row['subject_fr'] . ' / ' . $row['subject_en'];
	$mail->Subject = $subject;
	$mail->AddAttachment("contracts/".$filename2, "contracts/".$filename2);

	$message = $row['content_fr'];
	$message .= "<br><br>>>>>>ENGLISH VERSION<<<<<<br><br>";
	$message .= $row['content_en'];

	$message = str_replace("{customer_name}", $_GET['name'], $message);
	
	$mail->isHTML(true);
	$mail->Body    = $message;
	
	$mail->send();
?>