<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "naturalfarms_new";

// natural farms settins
// $servername = "tzrepottawa.netfirmsmysql.com";
// $username = "orVwv0ximQ1NlT2";
// $password = "wordpress_kifc4i5e3ewordpress_kifc4i5e3e";
// $dbname = "wordpress_kifc4i5e3e";

$servername = "localhost";
$username = "natural_natural";
$password = "=1!G5Qzp.El8";
$dbname = "natural_portal";
 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn, "UTF8");

$numOfColumns = 3;
$numOfRows = 2;

require 'phpmailer/PHPMailerAutoload.php';
	
$mail = new PHPMailer;
	
$mail->isSMTP();

$mail->Host = "vps28348.inmotionhosting.com";  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = "portal@naturalfarms.ca";                 // SMTP username
$mail->Password = "#destinY74";                           // SMTP password
$mail->Port = "465";
$mail->SMTPSecure = "ssl";
$mail->CharSet = 'UTF-8';

$mail->Sender = 'portal@naturalfarms.ca';

$mail->setFrom("portal@naturalfarms.ca", "La Ferme au Naturel / Natural Farms Inc");
$mail->addBCC("portal@naturalfarms.ca");

date_default_timezone_set('America/New_York');

if (isset($_SESSION ["adminemail1"])) {
	$mail->addReplyTo($_SESSION ["adminemail1"]);
	$mail->addBCC($_SESSION ["adminemail1"]);
}

function addDayswithdate($date,$days){

	$datev = strtotime("+".$days." days", strtotime($date));
	$datev = date("Y-m-d", $datev);
	$dw = date('w', strtotime($datev));
	$diff = '+0';
	if ($dw == 0) $diff = '+3';
	if ($dw == 1) $diff = '+2';
	if ($dw == 2) $diff = '+1';
	if ($dw == 5) $diff = '-1';
	if ($dw == 6) $diff = '-2';
	$date = strtotime($diff." days", strtotime($datev));
	return  date("Y-m-d", $date);

}

?>