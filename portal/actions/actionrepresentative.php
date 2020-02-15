<?PHP
include "../inc/header.php";

$name 		= mysqli_real_escape_string($conn, isset($_POST['name']) ? $_POST['name'] : "");
$email 		= mysqli_real_escape_string($conn, isset($_POST['email']) ? $_POST['email'] : "");
$username 	= mysqli_real_escape_string($conn, isset($_POST['username']) ? $_POST['username'] : "");
$password	= md5(mysqli_real_escape_string($conn, isset($_POST['password']) ? $_POST['password'] : ""));
$role		= mysqli_real_escape_string($conn, isset($_POST['role']) ? $_POST['role'] : "");

$extra = "&name=$name&email=$email&username=$username&role=$role";


// form handler
if($_POST && !isset($_POST['id'])){
	
	$sql1 = "SELECT * FROM representative WHERE username='$username'";
	$sql2 = "SELECT * FROM representative WHERE email='$email'";
	
	$error1 = false;
	$error2 = false;
	
	$result = $conn->query($sql1);
    while ($row = $result->fetch_assoc()) {
    	$error1 = true;
    }
    
    $result = $conn->query($sql2);
    while ($row = $result->fetch_assoc()) {
    	$error2 = true;
    }
    
    if ($email === ""){
    	header("Location: ../representative.php?err=noemail$extra");
    }
    else if ($username === ""){
    	header("Location: ../representative.php?err=nousr$extra");
    }
  	else if ($error1 === true){
  		header("Location: ../representative.php?err=usr$extra");
  	}
  	else if ($error2 === true){
  		header("Location: ../representative.php?err=email$extra");
  	}
  	else {
  		$sql = "INSERT INTO representative (name, email, username, password, role) VALUES ('$name', '$email', '$username', '$password', '$role')";
  		//echo $sql;
  		// Now insert the new form into DB
  		if ($conn->query($sql) === FALSE){
  			echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  			exit();
  		}
  		
  		$roleText = $role === "admin" ? "Administrator" : ($role === "supplier" ? "Supplier" :
  				$role === "delivery" ? "Delivery Agent" : "Sales Representative");
  				
  		$mail->addAddress($_POST['email']);
  		$mail->Subject = "Welcome";
  		$mail->Body    = "Hi $name,\n\nYou have been added as a $roleText at Natural Farms!
  				\n\nUsername: $username\nPassword: $_POST[password]\nURL: http://".$_SERVER['SERVER_NAME'].
  				"\n\nRegards,\nNatual Farms Team";
  		
  		$mail->send();
  		 
  		$last_id = $conn->insert_id;
  		header("Location: ../representative.php?id=".$last_id."&act=add".$staff);
  	}
}
else if($_POST && isset($_POST['id'])){

	if ($email == ""){
		header("Location: ../representative.php?err=noemail&id=".$_POST['id']);
	}
	else if ($username == ""){
		header("Location: ../representative.php?err=nousr&id=".$_POST['id']);
	}
	else {
		$password = $password == ""?"":",		password='$password'";
		$sql = "UPDATE representative SET
	  	
		  		name='$name',				email='$email',			role='$role',	
		  		username='$username'        $password
	  	
	  			WHERE id=".$_POST['id'];	
		
		$staff = "";
		$file = "representative";
		//echo $sql;
		
	  	// Now insert the new form into DB
	  	if ($conn->query($sql) === FALSE){
	  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
	  		exit();
	  	}
	  		
	  	header("Location: ../representative.php?id=".$_POST['id']."&act=upd".$staff);
	}
}
?>