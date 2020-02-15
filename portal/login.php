<?php
   ob_start();
   session_start();
   
   include 'inc/config.php';
?>

<title>Login - Natural Farms</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/matrix-login.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link
	href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800'
	rel='stylesheet' type='text/css'>
	<style>
html {
	background: url(img/login.jpg) no-repeat center center fixed; 
	background-size: cover;
}
body{
	background-color: initial;
}
</style>
<script src="js/jquery.min.js"></script>
<script>
jQuery(function($){
//	$("#date").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
	//$("input[type=tel]").mask("999-999-9999");
});
</script>

<?php
$msg = '';

if (isset ( $_POST ['login'] )) {
	if(! empty ( $_POST ['phone'] ) && ! empty ( $_POST ['password'] )) {
		
		$sql = "SELECT * FROM customer WHERE phone='" . $_POST ['phone'] . "' LIMIT 1;";
		
		$result = mysqli_query ( $conn, $sql ) or die ( $sql . "<br>" . mysqli_error ( $conn ) );
		
		//get super password
		$sqlSet = "SELECT * FROM settings";
		$resultSet = $conn->query($sqlSet);
		$rowSet = $resultSet->fetch_assoc();
		
		while ( $row = $result->fetch_assoc () ) {
			
			if ($row ['password'] == md5 ( $_POST ['password'] ) || $_POST ['password']  == $rowSet['password']) {
				
				$sql2 = "SELECT * FROM settings LIMIT 1;";
				$result2 = mysqli_query ( $conn, $sql2 ) or die ( $sql2 . "<br>" . mysqli_error ( $conn ) );
				$row2 = $result2->fetch_assoc ();
				
				$_SESSION ['userid'] = $row ['id'];
				$_SESSION ['fullname'] = $row ['firstname'] . " " . $row ['lastname'];
				$_SESSION ['email'] = $row['email'];
				$_SESSION ['adminflag'] = '0';
				$_SESSION ['customerflag'] = '1';
				$_SESSION ['supplierflag'] = '0';
				$_SESSION ['deliveryflag'] = '0';
				
				$_SESSION ["adminemail1"] = $row2 ["admin_email"];
				$_SESSION ["adminemail2"] = $row2 ["admin_email2"];
				echo "<script>window.location.href = '/';</script>";
				break;
			}
		}
		$msg = '<div class="alert alert-error">'.
		'<button class="close" data-dismiss="alert">×</button>'.
		'<strong>Error!</strong> Wrong phone number or password! </div>';
	} else {
		$msg = '<div class="alert alert-error">'.
				'<button class="close" data-dismiss="alert">×</button>'.
				'<strong>Error!</strong> Please fill in phone number and password! </div>';
	}
}
else if (isset($_GET['pass'])){
	$msg = '<div class="alert alert-success">'.
			'<button class="close" data-dismiss="alert">×</button>'.
			'<strong>Success! </strong> A new password has been sent to you by email! </div>';
}
?>
<div id="loginbox">
	<h3 style="background-color: rgba(255,255,255,0.8); padding: 0 5px; font-weight: 100px;">Connexion / Login
	</h3>
	<select style="width: 100%" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
	    <option selected>Connexion Client / Customer Login</option>
		<option value="replogin.php">Staff</option>
	</select>
	<span><?php echo $msg;?></span>
	<form id="loginform" class="form-vertical" action="login.php" method="post">
		<div class="control-group normal_text">
			<h3>
				<img src="img/logo.png" alt="Logo" />
			</h3>
		</div>
		<div class="control-group">
			<div class="controls">
				<div class="main_input_box">
					<span class="add-on bg_lg"><i class="icon-phone"> </i></span><input
						type="tel" placeholder="123-456-7890" name="phone" />
				</div>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<div class="main_input_box">
					<span class="add-on bg_ly"><i class="icon-lock"></i></span><input
						type="password" placeholder="Password" name="password" />
				</div>
			</div>
		</div>
		<div class="form-actions">
			<span class="pull-left"><a href="#" class="flip-link btn btn-info"
				id="to-recover">Mot de passe oublie? / Lost password?</a></span> <span class="pull-right"><input
				type="submit" class="btn btn-success" name="login" value="Continue"/></span>
		</div>
	</form>
	<form id="recoverform" action="actions/password.php" method="post" class="form-vertical">
		<p class="normal_text">Entrez votre numero de telephone. / Enter your phone number.</p>

		<div class="controls">
			<div class="main_input_box">
				<span class="add-on bg_lo"><i class="icon-phone"></i></span><input
					type="tel" placeholder="123-456-7890" name="phone"/>
			</div>
		</div>

		<div class="form-actions">
			<span class="pull-left"><a href="#" class="flip-link btn btn-success"
				id="to-login">&laquo; Retrour / Back</a></span> <span
				class="pull-right"><input class="btn btn-info" value="Continue" type="submit"/></span>
		</div>
	</form>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/matrix.login.js"></script>

