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

<?php
$msg = '';

if (isset ( $_POST ['login'] )) {
	if(! empty ( $_POST ['username'] ) && ! empty ( $_POST ['password'] )) {
		
		$sql = "SELECT * FROM supplier WHERE username='" . $_POST ['username'] . "' LIMIT 1;";
		
		$result = mysqli_query ( $conn, $sql ) or die ( $sql . "<br>" . mysqli_error ( $conn ) );
		while ( $row = $result->fetch_assoc () ) {
			
			if ($row ['password'] == md5 ( $_POST ['password'] )) {
				
				$sql2 = "SELECT * FROM settings LIMIT 1;";
				$result2 = mysqli_query ( $conn, $sql2 ) or die ( $sql2 . "<br>" . mysqli_error ( $conn ) );
				$row2 = $result2->fetch_assoc ();
				
				$_SESSION ['userid'] = $row ['id'];
				$_SESSION ['fullname'] = $row ['name'];
				$_SESSION ['email'] = $row['email'];
				$_SESSION ['adminflag'] = '0';
				$_SESSION ['customerflag'] = '0';
				$_SESSION ['supplierflag'] = '1';
				$_SESSION ['deliveryflag'] = '0';
				
				$_SESSION ["adminemail1"] = $row2 ["admin_email"];
				$_SESSION ["adminemail2"] = $row2 ["admin_email2"];
				header ( "Location: ." );
				break;
			}
		}
		$msg = '<div class="alert alert-error">'.
		'<button class="close" data-dismiss="alert">×</button>'.
		'<strong>Error!</strong> Wrong username and password! </div>';
	} else {
		$msg = '<div class="alert alert-error">'.
				'<button class="close" data-dismiss="alert">×</button>'.
				'<strong>Error!</strong> Please fill in username and password! </div>';
	}
}
else if (isset($_GET['pass'])){
	$msg = '<div class="alert alert-success">'.
			'<button class="close" data-dismiss="alert">×</button>'.
			'<strong>Success! </strong> A new password has been sent to you by email! </div>';
}
?>
<div id="loginbox">
	<h3 style="background-color: rgba(255,255,255,0.8); padding: 0 5px;">Supplier Login</h3>
	<select style="width: 100%" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
	    <option value="login.php">Connexion Client / Customer Login</option>
		<option value="replogin.php">Admin / Sales Rep</option>
		<option selected>Supplier</option>
		<option value="dellogin.php">Delivery Agent</option>
	</select>
	<span><?php echo $msg;?></span>
	<form id="loginform" class="form-vertical" action="suplogin.php" method="post">
		<div class="control-group normal_text">
			<h3>
				<img src="img/logo.png" alt="Logo" />
			</h3>
		</div>
		<div class="control-group">
			<div class="controls">
				<div class="main_input_box">
					<span class="add-on bg_lg"><i class="icon-user"> </i></span><input
						type="text" placeholder="Username" name="username" />
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
				id="to-recover">Lost password?</a></span> <span class="pull-right"><input
				type="submit" class="btn btn-success" name="login" /></span>
		</div>
	</form>
	<form id="recoverform" action="actions/reppassword.php" method="post" class="form-vertical">
		<p class="normal_text">Entrez votre E-mail. / Enter your email.</p>

		<div class="controls">
			<div class="main_input_box">
				<span class="add-on bg_lo"><i class="icon-envelope"></i></span><input
					type="tel" placeholder="Enter your email" name="email"/>
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

