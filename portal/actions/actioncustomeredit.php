<?PHP
  // form handler
  if($_POST && isset($_POST['lastname'])){
  	
  	include "../inc/config.php";
  	
  	/**************************************
  	 *		Customer's informations
  	 **************************************/
/*  	
  	echo (
  			'id:			    '.$_POST['nff'].            '<br/>'.
  			'lastname:			'.$_POST['lastname'].		'<br/>'.  			
  			'firstname:			'.$_POST['firstname'].		'<br/>'.
  			'maritalstatus:		'.$_POST['maritalstatus'].	'<br/>'.
  			'numdependent:		'.$_POST['dependent'].		'<br/>'.
  			'streetnumber:		'.$_POST['streetnumber'].	'<br/>'.
  			'streetname:		'.$_POST['streetname'].		'<br/>'.
  			'city:				'.$_POST['city'].			'<br/>'.
  			'province:			'.$_POST['province'].		'<br/>'.
  			'postalcode:		'.$_POST['postal'].			'<br/>'.
  			'sector:			'.$_POST['sector'].			'<br/>'.
  			'owner:				'.$_POST['owner'].			'<br/>'.
  			'howlong:			'.$_POST['howlong'].		'<br/>'.
  			'phone:				'.$_POST['phone'].			'<br/>'.
  			'workphone:			'.$_POST['workphone'].		'<br/>'.
  			'email:				'.$_POST['email'].			'<br/>'.
  			'fax:				'.$_POST['fax'].			'<br/>'.
  			'lastname2:			'.$_POST['lastname2'].		'<br/>'.
  			'firstname2:		'.$_POST['firstname2'].		'<br/>'.
  			'phone2:			'.$_POST['phone2'].			'<br/>'.
  			'email2:			'.$_POST['email2'].			'<br/>'.
  			'fax2:				'.$_POST['fax2'].			'<br/>'.'<br/>'
  	);
 */
  	$linkPage = "customer";
  	if (isset($_POST['profile']))
  	{
  		$linkPage = "profile";
  	}
  	$id 			= mysqli_real_escape_string($conn, isset($_POST['id']) ? $_POST['id'] : "");
  	$lastname 		= mysqli_real_escape_string($conn, isset($_POST['lastname']) ? $_POST['lastname'] : "");
  	$firstname 		= mysqli_real_escape_string($conn, isset($_POST['firstname']) ? $_POST['firstname'] : "");
  	// Customer's Address
  	$streetaddress1 = mysqli_real_escape_string($conn, isset($_POST['streetaddress1']) ? $_POST['streetaddress1'] : "");
  	$streetaddress2	= mysqli_real_escape_string($conn, isset($_POST['streetaddress2']) ? $_POST['streetaddress2'] : "");
  	$city 			= mysqli_real_escape_string($conn, isset($_POST['city']) ? $_POST['city'] : "");
  	$province 		= mysqli_real_escape_string($conn, isset($_POST['province']) ? $_POST['province'] : "");
  	$postalcode 	= mysqli_real_escape_string($conn, isset($_POST['postal']) ? $_POST['postal'] : "");
  	$sector 		= mysqli_real_escape_string($conn, isset($_POST['sector']) ? $_POST['sector'] : "");
  	 
  	$phone 			= mysqli_real_escape_string($conn, isset($_POST['phone']) ? $_POST['phone'] : "");
  	$email 			= mysqli_real_escape_string($conn, isset($_POST['email']) ? $_POST['email'] : "");
  	
  	$password 		= md5(mysqli_real_escape_string($conn, isset($_POST['password']) ? $_POST['password'] : ""));
  	$active 		= mysqli_real_escape_string($conn, isset($_POST['active']) && $_POST['active']=='on' ? "1" : "0");
  	 
  	$dateSince 		= mysqli_real_escape_string($conn, isset($_POST['since']) ? $_POST['since'] : "");
  	/*
  	$lastname2 		= mysqli_real_escape_string($conn, isset($_POST['lastname2']) ? $_POST['lastname2'] : "");
  	$firstname2 	= mysqli_real_escape_string($conn, isset($_POST['firstname2']) ? $_POST['firstname2'] : "");
  	$phone2 		= mysqli_real_escape_string($conn, isset($_POST['phone2']) ? $_POST['phone2'] : "");
  	$email2 		= mysqli_real_escape_string($conn, isset($_POST['email2']) ? $_POST['email2'] : "");
  	$fax2 			= mysqli_real_escape_string($conn, isset($_POST['fax2']) ? $_POST['fax2'] : "");
  	*/
  	 
  	if ($_POST['password'] != "")
  	{
  		$password = ", password='$password'";
  	}
  	else {
  		$password = "";
  	}
  	
  	if ($lastname == ""){
  		header("Location: ../$linkPage.php?err=ln&id=$id");
  	}
  	else if ($firstname == ""){
  		header("Location: ../$linkPage.php?err=fn&id=$id");
  	}
  	else if ($streetaddress1 == ""){
  		header("Location: ../$linkPage.php?err=st&id=$id");
  	}
  	else if ($city == ""){
  		header("Location: ../$linkPage.php?err=ci&id=$id");
  	}
  	else if ($province == ""){
  		header("Location: ../$linkPage.php?err=pr&id=$id");
  	}
  	else if ($postalcode == ""){
  		header("Location: ../$linkPage.php?err=pc&id=$id");
  	}
  	else {
		/********************************************
		 *		Update new customer in the database
		 ********************************************/
	  		
		// Before inserting a new customer, validation on all form fields must be done.
	  	$sqlStatement_customer = "UPDATE customer SET
	  	
		  		lastname='$lastname',				firstname='$firstname',	
		  		streetaddress1='$streetaddress1', 	streetaddress2='$streetaddress2', 	city='$city',
		  		province='$province', 				postalcode='$postalcode',			sector='$sector',
		  		phone='$phone', 					email='$email', 					isactive='$active',
		  		dateSince='$dateSince'                  $password
		  		WHERE id=$id";	
	  	
	  	//echo $sqlStatement_customer;
	
	  	// Now insert the new form into DB
	  	if ($conn->query($sqlStatement_customer) === FALSE){
	  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n".$sqlStatement_customer;
	  		exit();
	  	}
	  		
	  	echo "Customer edited successfully";
	  	
	  	if ($_POST['sendemail'] == 'on'){
	  		$sqlT = "SELECT * FROM email_templates WHERE id=6 LIMIT 1";
	  		$resultT = $conn->query($sqlT);
	  		$rowTemp = $resultT->fetch_assoc();
	  		 
	  		$subject = $rowTemp['subject'];
	  		$mail->Subject = $subject;
	  	
	  		$mail->addBCC($user_email);
	  		$mail->addAddress($email);
	  	
	  		$action = "";
	  		if ($active == '0') {
	  			$action = "<b>Compte Suspendu / Account Suspended";
	  		}
	  		else {
	  			$action = "<b>Modifié / Modified</b>";
	  		}
	  	
	  		$message = $rowTemp['content'];
	  		$message = str_replace("{customer_name}", $_POST['name'], $message);
	  		$message = str_replace("{customer_nextdelivery}", $_POST['nextdelivery'], $message);
	  		$message = str_replace("{customer_action}", $action, $message);
	  		 
	  		echo $message;
	  	
	  		$mail->isHTML(true);
	  		$mail->Body    = $message;
	  		$mail->send();
	  	}
	  			
	  	
	  	header("Location: ../$linkPage.php?id=$id.&act=upd");
  	}
  }
?>