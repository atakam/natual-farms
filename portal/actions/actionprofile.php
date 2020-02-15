<?PHP
include "../inc/header.php";

$name 		= mysqli_real_escape_string($conn, isset($_POST['name']) ? $_POST['name'] : "");
$email 		= mysqli_real_escape_string($conn, isset($_POST['email']) ? $_POST['email'] : "");
$username 	= mysqli_real_escape_string($conn, isset($_POST['username']) ? $_POST['username'] : "");
$password	= md5(mysqli_real_escape_string($conn, isset($_POST['password']) ? $_POST['password'] : ""));
$adminflag	= mysqli_real_escape_string($conn, isset($_POST['role']) ? $_POST['role'] : "");

$extra = "&name=$name&email=$email&username=$username&adminflag=$adminflag";

if($_POST && isset($_POST['id'])){

	if ($email == ""){
		header("Location: ../profile.php?err=noemail&id=".$_POST['id']);
	}
	else if ($username == ""){
		header("Location: ../profile.php?err=nousr&id=".$_POST['id']);
	}
	else {
		$password = $password !== ""?",		password='$password'":"";
		$sql = "UPDATE representative SET
	  	
		  		name='$name',				email='$email',	
		  		username='$username'        $password
	  	
	  			WHERE id=".$_POST['id'];	
		
		$staff = "";
		
		if ($supplier_flag == "1"){
			$sql = "UPDATE supplier SET
	  	
		  		name='$name',				email='$email',	
		  		username='$username'        $password 
	  	
	  			WHERE id=".$_POST['id'];
		}
		else if ($delivery_flag == "1"){
			$sql = "UPDATE delivery_man SET
	  	
		  		name='$name',				email='$email',	
		  		username='$username'        $password
	  	
	  			WHERE id=".$_POST['id'];
		}
	  	
	  	//echo $sqlStatement_customer;
	
	  	// Now insert the new form into DB
	  	//echo $sql;
	  	if ($conn->query($sql) === FALSE){
	  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
	  		exit();
	  	}
	  		
	  	header("Location: ../profile.php?id=".$_POST['id']."&act=upd".$staff);
	}
}
?>