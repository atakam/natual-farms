<?php 
require("../phpToPDF/phpToPDF.php");

include '../inc/header.php';
$sql = "SELECT * FROM email_templates WHERE id=1 LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$salesman = "";
if (isset($_GET["salesname"]))
{
	$salesman = $_GET['salesname'];
}

$time = time();
$filename = "Contract_".$_GET['name']."_".$time.".pdf";
$filename2 = "Orders_".$_GET['name']."_".$time.".pdf";

$url = baseurl().'/order/contract.php?id='.$_GET['id'].'&rid=1&edited=yes&sprint=katchebehsibwosihampomodimandrehnahponteh';
$url2 = baseurl().'/order/orderList.php?id='.$_GET['id'].'&rid=1&edited=yes&sprint=katchebehsibwosihampomodimandrehnahponteh';
echo $url;
$pdf_options = array(
		"source_type" => 'url',
        "source" => $url,
		"action" => 'save',
		"save_directory" => 'contracts',
		"file_name" => $filename);

$pdf_options2 = array(
		"source_type" => 'url',
		"source" => $url2,
		"action" => 'save',
		"save_directory" => 'contracts',
		"file_name" => $filename2);

// CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
    phptopdf($pdf_options);
    phptopdf($pdf_options2);

	$mail->addAddress($_GET["email"]);
	$subject = $row['subject_fr'];
	if ($_GET['lang'] == "en")
	{
		$subject = $row['subject_en'];
	}
	$mail->Subject = $subject;
	
	$mail->AddAttachment("contracts/".$filename, "contracts/".$filename);
	$mail->AddAttachment("contracts/".$filename2, "contracts/".$filename2);
	
	$cred = "";
	if (isset($_GET['phone'])){
		$cred = "<br>Site: <a href='http://portal.naturalfarms.ca'>Click here</a>" .
				"<br>Telephone: " . $_GET['phone'] .
				"<br>Mot de passe / Password: " . $_GET['password']."<br>";
	}
	
	

	$url = "<a href='".baseurl()."/order/contract.php?id=".$_GET['id'].'&rid=1&edited=yes&sprint=katchebehsibwosihampomodimandrehnahponteh'."'>Cliquez ici</a>";
	$message = $row['content_fr'];
	if ($_GET['lang'] == "en")
	{
		$message = $row['content_en'];
		$url = "<a href='".baseurl()."/order/contract.php?id=".$_GET['id'].'&rid=1&edited=yes&sprint=katchebehsibwosihampomodimandrehnahponteh'."'>Click here</a>";
	}

	$message = str_replace("{customer_name}", $_GET['name'], $message);
	$message = str_replace("{sales_rep_name}", $salesman, $message);
	$message = str_replace("{contract_url}", $url, $message);
	$message = str_replace("{customer_credentials}", $cred, $message);
	
	
	$mail->isHTML(true);
	$mail->Body    = $message;
	$mail->send();
	
	//************************************************//
	// Send email to sales representative
	//************************************************//
	if (isset($_GET["sales"]))
	{
		$sql = "SELECT * FROM email_templates WHERE id=2 LIMIT 1";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		
		$mail->clearAddresses();
		$mail->addAddress($_GET["sales"]);
		$subject = $row['subject'];
		$mail->Subject = $subject;
		
		//$mail->AddAttachment("contracts/".$filename, "contracts/".$filename);
		
		$message = $row['content'];
		$message = str_replace("{customer_name}", $_GET['name'], $message);
		$message = str_replace("{sales_rep_name}", $salesman, $message);
		$message = str_replace("{contract_url}", $url, $message);
		$message = str_replace("{customer_credentials}", $cred, $message);
		
		$mail->isHTML(true);
		$mail->Body    = $message;
		if(!$mail->send()) {
			echo 'Message could not be sent. '. $mail->ErrorInfo;
		}
	}
	
	header("Location: ../orders.php");
?>