<?php 

include '../inc/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM representative WHERE id=$id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

?>
<div class="form-style-2">
	<form method="post" id="validate1" action="../actions/actionrepresentative.php" autocomplete="off"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading"><?php echo $row["name"];?></div>
		<div class="row">
			<input type="hidden" class="input-field" name="id" value="<?php echo $row["id"];?>" />
			<div class="section section-50">
				<p>Name</p>
				<input type="text" class="input-field" name="name" value="<?php echo $row["name"];?>" />
			</div>
			<div class="section section-50">
				<p>Email</p>
				<input type="text" class="input-field" name="email" value="<?php echo $row["email"];?>" />
			</div>
			<div class="section section-50">
				<p>Username</p>
				<input type="text" class="input-field" name="username" value="<?php echo $row["username"];?>" />
			</div>
			<div class="section section-50">
				<p>Change Password</p>
				<input type="password" class="input-field" name="password" value="" />
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p> </p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitedit" value="Save" class="right"/>
			</div>
		</div>
	</form>
</div>
<?php 
}
else {
?>

<div class="form-style-2">
	<form method="post"  action="../actions/actionrepresentative.php" autocomplete="on" id="validate2" autocomplete="off"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading">Product Category Details</div>
		<div class="row">
			<div class="section section-50">
				<p>Name</p>
				<input type="text" class="input-field" name="name" value="" />
			</div>
			<div class="section section-50">
				<p>Email</p>
				<input type="text" class="input-field" name="email" value="" />
			</div>
			<div class="section section-50">
				<p>Username</p>
				<input type="text" class="input-field" name="username" value="" />
			</div>
			<div class="section section-50">
				<p>Change Password</p>
				<input type="password" class="input-field" name="password" value="" />
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p> </p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitcreate" value="Submit" class="right"/>
			</div>
		</div>
	</form>
</div>
<?php	
}
echo "</div>";
?>