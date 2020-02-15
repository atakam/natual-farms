<?php 

include '../inc/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM products_category WHERE id=$id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

?>
<div class="form-style-2">
	<div class="form-style-2-heading"><?php echo $row["name_en"]." / ". $row["name_fr"];?></div>
	<form method="post" id="validate1" action="../actions/actioncategory.php"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading">Product Category Details</div>
		<div class="row">
			<div class="section section-50">
				<p>Name (En)</p>
				<input type="text" class="input-field" name="name_en" value="<?php echo $row["name_en"];?>" />
			</div>
			<div class="section section-50">
				<p>Name (Fr)</p>
				<input type="text" class="input-field" name="name_fr" value="<?php echo $row["name_fr"];?>" />
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p> </p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitform" value="Save" class="right"/>
			</div>
		</div>
	</form>
</div>
<?php 
}
else {
?>

<div class="form-style-2">
	<form method="post"  action="../actions/actioncategory.php" autocomplete="on" id="validate2"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading">Product Category Details</div>
		<div class="row">
			<div class="section section-50">
				<p>Name (En)</p>
				<input type="text" class="input-field" name="name_en" value="" />
			</div>
			<div class="section section-50">
				<p>Name (Fr)</p>
				<input type="text" class="input-field" name="name_fr" value="" />
			</div>
		</div>
		
		<div class="row">
			<div class="space1"></div>
		</div>
		
		<div class="row">
			<div class="section section-100">
				<p> </p>
				<!--<input type="button" value="Validate" />-->
				<input type="submit" name="submitform" value="Submit" class="right"/>
			</div>
		</div>
	</form>
</div>
<?php	
}
echo "</div>";
?>