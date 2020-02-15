<?php 
require("../phpToPDF/phpToPDF.php");
include '../inc/functions.php';
include '../inc/config.php';

$sql = "SELECT * FROM email_templates WHERE id=7 LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$filename = time().".pdf";

$pdf_options = array(
		"source_type" => 'url',
		"source" => baseurl().'/demo/contract_demo.php?id='.$_GET['id'],
		"action" => 'save',
		"save_directory" => '',
		"file_name" => $filename);

// CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
//phptopdf($pdf_options);

$mail->ClearAllRecipients(); // clear all
$mail->setFrom("demo@naturalfarms.ca", "La Ferme au Naturel / Natural Farms Inc");
$mail->addBCC("demo@naturalfarms.ca");

$mail->addAddress($_GET["email"]);
$subject = $row['subject_fr'];
if ($_GET['lang'] == "en")
{
	$subject = $row['subject_en'];
}

$mail->Subject = $subject;

//$mail->AddAttachment("contracts/".$filename, "contracts/".$filename);

$url = "<a href='".baseurl()."/demo/contract_demo.php?id=".$_GET['id']."'>Cliquez ici</a>";
$message = $row['content_fr'];
if ($_GET['lang'] == "en")
{
	$message = $row['content_en'];
	$url = "<a href='".baseurl()."/demo/contract_demo.php?id=".$_GET['id']."'>Click here</a>";
}

$message = str_replace("{customer_name}", $_GET['name'], $message);
$message = str_replace("{sales_rep_name}", $salesman, $message);
$message = str_replace("{contract_url}", $url, $message);
$message = str_replace("{customer_credentials}", $cred, $message);

$mail->isHTML(true);
$mail->Body    = $message;
if(!$mail->send()) {
	echo 'Message could not be sent. '. $mail->ErrorInfo;
}

header("Location: ".$_GET['redirect']);
echo "<script>window.location.href = '".$_GET['redirect']."';</script>";
?>