<?php 

include '../inc/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM products WHERE id=$id";
    $sql2 = "SELECT * FROM products_details WHERE product_id=$id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    $result2 = $conn->query($sql2);

?>

<div class="form-style-2">
	<a href="." class="button"><i class="fa fa-arrow-left"> BACK</i></a>
	<div class="row">
		<div class="space1"></div>
	</div>
	<div class="form-style-2-heading"><?php echo $row["name_en"]." / ". $row["name_fr"];?></div>
	<form enctype="multipart/form-data" method="post" id="validate1" action="../actions/actionproduct.php"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading">Product Details</div>
		<div class="row">
			<div class="section section-50">
				<p>Name (En)</p>
				<input type="text" class="input-field" name="name_en" value="<?php echo $row["name_en"];?>" />
				<input type="hidden" class="input-field" name="id" value="<?php echo $row["id"];?>" />
			</div>
			<div class="section section-50">
				<p>Name (Fr)</p>
				<input type="text" class="input-field" name="name_fr" value="<?php echo $row["name_fr"];?>" />
			</div>
			<div class="section section-50">
				<p>Product Category</p>
				<select class="input-field" name="category">
					<?php 
						$sqlCat = "SELECT * FROM products_category";
						$resultCat = $conn->query($sqlCat);
    					while ($rowCat = $resultCat->fetch_assoc()){
					?>
				  	<option value='<?php echo $rowCat["id"];?>' <?php if ($row["category_id"]===$rowCat["id"]) echo "selected";?>><?php echo $rowCat["name_en"];?></option>
				    <?php 
    					}
				    ?>
				</select>
			</div>
			<div class="section section-50">
				<p>Product Image</p>
				<input type="file" class="input-field" name="image"/><span id="imageString">value="<?php echo $row["image_name"];?>"</span>
			</div>
			
			<div class="section section-100">
				<div class="section section-50">
					<p>Product Packaging</p>
				</div>
				<div class="section section-50">
					<div class="section section-33">
							<p>Product Code</p>
					</div>
					<div class="section section-33">
							<p>Point Value</p>
					</div>
					<div class="section section-33">
							<p>Purchase Price</p>
					</div>
				</div>
				<div id="packages">
				<?php 
						while ($rowDet = $result2->fetch_assoc()){
							if ($rowDet["product_id"])
							{
					?>
					<div class="package">
						<div class="section section-50">
						
							<select class="input-field packaging" name="packaging">
								<?php 
									$sqlPack = "SELECT * FROM product_packaging";
									$resultPack = $conn->query($sqlPack);
			    					while ($rowPack = $resultPack->fetch_assoc()){
								?>
							  	<option value='<?php echo $rowPack["id"];?>' <?php if ($rowDet["packaging_id"]=== $rowPack["id"]) echo "selected";?>><?php echo $rowPack["type"] . " - " . $rowPack["quantity"];?></option>
							    <?php 
			    					}
							    ?>
							</select>
						</div>
						
						<div class="section section-50">
							<div class="section section-30">
								<input type="text" class="input-field code" name="code" value="<?php echo $rowDet["code"];?>" />
							</div>
							
							<div class="section section-30">
								<input type="text" class="input-field points" name="points" value="<?php echo $rowDet["point"];?>" />
							</div>
							
							<div class="section section-30">
								<input type="text" class="input-field price" name="price" value="<?php echo $rowDet["purchase_price"];?>" />
							</div>
							<div class="section section-10">
								<a href="#" onclick="deleteAction('prdtpack', <?php echo $rowDet["id"];?>)"><i class="fa fa-trash"></i></a>
							</div>
						</div>
						<div class="row">
							<div class="space1"></div>
						</div>
					</div>
						
				<?php } 
					}
				?>
				</div>
				<a href="#" onclick="addPackaging()" class="button"><i class="fa fa-plus"> Add Packaging</i></a>
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
	<form method="post"  action="../actions/actionproduct.php" autocomplete="on" id="validate2"> <!-- onsubmit="return validateForm()" -->
		<div class="form-style-2-heading">Product Details</div>
		<div class="row">
			<div class="section section-50">
				<p>Name (En)</p>
				<input type="text" class="input-field" name="name_en" value="" />
			</div>
			<div class="section section-50">
				<p>Name (Fr)</p>
				<input type="text" class="input-field" name="name_fr" value="" />
			</div>
			<div class="section section-50">
				<p>Product Category</p>
				<select class="input-field" name="category">
					<option selected></option>
					<?php 
						$sqlCat = "SELECT * FROM products_category";
						$resultCat = $conn->query($sqlCat);
    					while ($rowCat = $resultCat->fetch_assoc()){
					?>
				  	<option value='<?php echo $rowCat["id"];?>'><?php echo $rowCat["name_en"];?></option>
				    <?php 
    					}
				    ?>
				</select>
			</div>
			<div class="section section-50">
				<p>Product Image</p>
				<input type="file" class="input-field" name="image" />
			</div>
			
			
			<div class="section section-100">
				<div class="section section-50">
					<p>Product Packaging</p>
				</div>
				<div class="section section-50">
					<div class="section section-33">
							<p>Product Code</p>
					</div>
					<div class="section section-33">
							<p>Point Value</p>
					</div>
					<div class="section section-33">
							<p>Purchase Price</p>
					</div>
				</div>
				<div id="packages">
				</div>
				<div class="row">
					<div class="space1"></div>
				</div>
				<a href="#" onclick="addPackaging()" class="button"><i class="fa fa-plus"> Add Packaging</i></a>
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
?>
<script>


function addPackaging(detId) {

	var html = '<div class="package" ><div class="section section-50">'+
'	<select class="input-field packaging" name="packaging">'+
'		<?php 
			$sqlPack = "SELECT * FROM product_packaging";
			$resultPack = $conn->query($sqlPack);
			while ($rowPack = $resultPack->fetch_assoc()){
		?>'+
'	  	<option value="<?php echo $rowPack["id"];?>"><?php echo $rowPack["type"] . " - " . $rowPack["quantity"];?></option>'+
'	    <?php } ?> '+
'	</select>'+
'</div>'+
'<div class="section section-50">'+
'	<div class="section section-30">'+
'		<input type="text" class="input-field code" name="code" value="" />'+
'	</div>'+
'	<div class="section section-30">'+
'		<input type="text" class="input-field points" name="points" value="" />'+
'	</div>'+
'	<div class="section section-30">'+
'		<input type="text" class="input-field price" name="price" value="" />'+
	'</div>'+
	'<div class="section section-10">'+
		'<a href="#" onclick="deleteAction(\'prdtpack\', \'' + detId + '\')"><i class="fa fa-trash"></i></a>'+
	'</div>'+
'</div>'+
'<div class="row">'+
	'<div class="space1"></div>'+
'</div>';

document.getElementById("packages").innerHTML = document.getElementById("packages").innerHTML + html;

updatePackageNames();
}

function updatePackageNames() {
	var elems = document.getElementsByClassName("package"); var i;
	for (i=0; i<elems.length; i++) {
		var p = elems[i].querySelector(".packaging");
		var c = elems[i].querySelector(".code");
		var pts = elems[i].querySelector(".points");
		var pr = elems[i].querySelector(".price");
		p.setAttribute("name", "packaging" + i);
		c.setAttribute("name", "code" + i);
		pts.setAttribute("name", "points" + i);
		pr.setAttribute("name", "price" + i);
	}
}

updatePackageNames();
</script>
<?php 
echo "</div>";
?>