<?PHP
  // form handler
  if($_POST && isset($_POST['email'])){
  	include '../inc/config.php';
  	 
  	$sql = "SELECT * FROM representative WHERE email='" . $_POST ['email'] . "' LIMIT 1;";
  	$result = mysqli_query ( $conn, $sql ) or die ( $sql . "<br>" . mysqli_error ( $conn ) );
  	while ( $row = $result->fetch_assoc () ) {
  	
  		$password_ = $row["name"] . substr(time(), 7);
  	
  		// Before inserting a new customer, validation on all form fields must be done.
  		$sqlStatement_customer = "UPDATE representative SET password='".md5($password_)."'
  	
	  		WHERE email='".$_POST['email']."'";
  			
  		//echo $sqlStatement_customer;
  	
  		// Now insert the new form into DB
  		if ($conn->query($sqlStatement_customer) === FALSE){
  			echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n".$sqlStatement_customer;
  			exit();
  		}
  	
  		$mail->addAddress($row["email"]);
  		$subject = gettext("Password recovery");
  		$mail->Subject = $subject;
  			
  		$cred = "<br><br>You have requested a new password." .
  				"<br>Website: <a href='http://portal.naturalfamrs.ca'>Click here</a>" .
  				"<br>Username: " . $_POST['username'] .
  				"<br>Password: " . $password_;
  			
  		//die($cred);
  		$message = "<p>Hi ".$row['name'].", <br><br>$cred<br><br>Contact us immediately if you did not make this request.<br><br>Management,<br>Natural Farms</p>";
  			
  		$mail->isHTML(true);
  		$mail->Body    = $message;
  		$mail->send();
  	}
  
  	header("Location: ../replogin.php?pass=rec");
  }
  else {
  	header("Location: ../replogin.php");
  }
 
?>