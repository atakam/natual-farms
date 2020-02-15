<?PHP
  // form handler
  if($_POST){
  	
  	include "../inc/header.php";
  	$id			 		= mysqli_real_escape_string($conn, isset($_POST['id']) ? $_POST['id'] : "");
  	$index			 	= mysqli_real_escape_string($conn, isset($_POST['index']) ? $_POST['index'] : "");
  	$notconfirm	 		= mysqli_real_escape_string($conn, isset($_POST['notconfirmed']) && $_POST['notconfirmed']=='on' ? "1" : "0");
  	$confirm		 	= mysqli_real_escape_string($conn, isset($_POST['confirmed']) && $_POST['confirmed']=='on' ? "1" : "0");
  	$deliver			= mysqli_real_escape_string($conn, isset($_POST['delivered']) && $_POST['delivered']=='on' ? "1" : "0");
  	$sendemail			= mysqli_real_escape_string($conn, isset($_POST['sendemail']) && $_POST['sendemail']=='on' ? "1" : "0");
 
  	$sql = "UPDATE form_completion SET
  	
	  		notconfirm$index='$notconfirm',
	  		confirm$index='$confirm',	
	  		deliver$index='$deliver'
	  		WHERE id=$id";
  	
  	echo $sql;

  	// Now insert the new form into DB
  	if ($conn->query($sql) === FALSE){
  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  		exit();
  	}

  	if ($sendemail == '1' && ($confirm == '1' || $deliver == 'on')){
	  	$sqlT = "SELECT * FROM email_templates WHERE id=5 LIMIT 1";
	  	$resultT = $conn->query($sqlT);
	  	$rowTemp = $resultT->fetch_assoc();
	  	 
	  	$subject = $rowTemp['subject_fr'] . '/' . $rowTemp['subject_en'];
	  	$mail->Subject = $subject;
	  	
	  	$mail->addBCC($user_email);
	  	$mail->addAddress($_POST["email"]);
	  	
	  	$action = "";
	  	if ($_POST['confirmed']=='on') {
	  		$action = "<b>Confirmé / Confirmed</b>";
	  	}
	  	if ($_POST['delivered']=='on') {
	  			$action = "<b>Livré / Delivered</b>";
	  	}
	  	
	  	$message = $rowTemp['content_fr'] . '<br><br>--------ENGLISH VERSION--------'.$rowTemp['content_en'];
	  	$message = str_replace("{customer_name}", $_POST['name'], $message);
	  	$message = str_replace("{customer_nextdelivery}", $_POST['nextdelivery'], $message);
	  	$message = str_replace("{customer_action}", $action, $message);
	  	 
	  	echo $message;
	  	
	  	$mail->isHTML(true);
	  	$mail->Body    = $message;
	  	$mail->send();
  	}
  	//die ($sql);
  	//echo "Settings edited successfully";
  	echo $_POST['redirect'];
  	if(isset($_POST['redirect'])) {
  		header("Location: ../". $_POST['redirect']);
  	}
  	else {
  		header("Location: ../orders.php");
  	}
  	
  	
}
?>