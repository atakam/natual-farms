<?PHP
  // form handler
  if($_POST){
  	
  	include "../inc/config.php";
  	$admin_email 		= mysqli_real_escape_string($conn, isset($_POST['email']) ? $_POST['email'] : "");
  	$provider_email 	= mysqli_real_escape_string($conn, isset($_POST['email2']) ? $_POST['email2'] : "");
  	$provider_email2	= mysqli_real_escape_string($conn, isset($_POST['email3']) ? $_POST['email3'] : "");
 
  	$sql = "UPDATE settings SET
  	
	  		admin_email='$admin_email',				admin_email2='$admin_email',	
	  		provider_email='$provider_email',		provider_email2='$provider_email2'";
  	
  	$superpassword	= mysqli_real_escape_string($conn, isset($_POST['superpassword']) ? $_POST['superpassword'] : "");
  	
  	if ($superpassword !== "")
  	{
  		$sql = "UPDATE settings SET
  		 
  		admin_email='$admin_email',				admin_email2='$admin_email',
  		provider_email='$provider_email',		provider_email2='$provider_email2',
  		password='$superpassword'";
  	}
  	
  	$_SESSION ["adminemail1"] = $admin_email;
  	
  	//echo $sqlStatement_customer;

  	// Now insert the new form into DB
  	if ($conn->query($sql) === FALSE){
  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  		exit();
  	}
  		
  	echo "Settings edited successfully";
  	
  	header("Location: ..");
  	
  	$url= "..";
  	//header('Location: ' . $_SERVER['HTTP_REFERER']);
  	echo "<script>window.location.href = '$url';</script>";
}
?>