<?php
include 'inc/header.php';
?>
<title>Product</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
	
	$pdtCount = 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM products WHERE id=$id";
    $sql2 = "SELECT * FROM products_details WHERE product_id=$id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
    $result2 = $conn->query($sql2);
    
?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="products.php" title="All Products" class="tip-bottom">Products</a> 
    	<a href="#" class="current">Product<?= " : " . $row["name_en"]." / ". $row["name_fr"] ?></a> 
    </div>
  </div>
  
  <div class="container-fluid">
  
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Product</h5>
          </div>
          <div class="widget-content nopadding">

<div class="form-style-2">
	<form enctype="multipart/form-data" class="form-horizontal" autocomplete="off" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate" action="actions/actionproduct.php"> <!-- onsubmit="return validateForm()" -->
			<div class="control-group">
				<label class="control-label">Name (En)</label>
				<div class="controls">
        		<input type="text"  name="name_en" value="<?php echo $row["name_en"];?>" />
        	</div>
				<div class="controls">
        		<input type="hidden"  name="id" value="<?php echo $row["id"];?>" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Name (Fr)</label>
				<div class="controls">
        		<input type="text"  name="name_fr" value="<?php echo $row["name_fr"];?>" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Product Category</label>
				<div class="controls">
				<select  name="category">
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
			</div>
			<div class="control-group">
				<label class="control-label">Product Image</label>
				<div class="controls">
        		<input type="file"  name="image"/>
        		<span id="imageString">value="<?php echo $row["image_name"];?>"</span>
        		</div>
			</div>
			<div class="control-group">
				<label class="control-label">Active</label>
				<div class="controls">
				<?php if ($row["active"] === '1') { ?>
        		    <input type="checkbox"  name="active" checked />
        		<?php }else { ?>
        		    <input type="checkbox"  name="active" />
        		<?php } ?>
        		</div>
			</div>
			
				<div class="control-group packaging-title">
					<div class="section section-33">
							<label class="control-label">Product Packaging</label>
					</div>
					<div class="section section-33">
							<label class="control-label">Product Code</label>
					</div>
					<div class="section section-33">
							<label class="control-label">Point Value</label>
					</div>
					<div class="section section-33">
							<label class="control-label">Purchase Price</label>
					</div>
					<div class="section section-33">
							<label class="control-label"><a href="#" onclick="addPackaging()" class="button"><i class="fa fa-plus"> Add Packaging</i></a></label>
					</div>
				</div>
				<div id="packages">
				<?php 
						while ($rowDet = $result2->fetch_assoc()){
							if ($rowDet["product_id"])
							{
					?>
						<div class="control-group" id="package<?= $pdtCount ?>">
							<div class="control-label section section-33">
							<select class="input-field packaging" name="packaging<?= $pdtCount ?>">
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
							<div class="control-label section section-33">
        		<input type="text" class="input-field code" name="code<?= $pdtCount ?>" value="<?php echo $rowDet["code"];?>" />
							</div>
							<div class="control-label section section-33">
        		<input type="text" class="input-field points" name="points<?= $pdtCount ?>" value="<?php echo $rowDet["point"];?>" />
							</div>
							<div class="control-label section section-10">
        		<input type="text" class="input-field price" name="price<?= $pdtCount++ ?>" value="<?php echo $rowDet["purchase_price"];?>" />
							</div>
							<div class="control-label section section-10">
								<a href="#" style="float: left;" onclick="deleteAction('prdtpack', <?php echo $rowDet["id"];?>)"><i class="fa fa-trash"></i></a>
							</div>
						</div>
						
				<?php } 
					}
				?>
				</div>
		
			<div class="control-group">
	              <div class="form-actions">
	                <input type="submit" name="submitform" value="Save" class="btn btn-success">
	              </div>
              </div>
		
	</form>
</div>
</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
}
else {
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="products.php" title="All Products" class="tip-bottom">Products</a> 
    	<a href="#" class="current">New Product</a> 
    </div>
  </div>
  
  <div class="container-fluid">
  
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Product</h5>
          </div>
          <div class="widget-content nopadding">

<div class="form-style-2">
	<form enctype="multipart/form-data" class="form-horizontal" autocomplete="off" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate" action="actions/actionproduct.php"> <!-- onsubmit="return validateForm()" -->
			<div class="control-group">
				<label class="control-label">Name (En)</label>
				<div class="controls">
        		<input type="text"  name="name_en" value="" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Name (Fr)</label>
				<div class="controls">
        		<input type="text"  name="name_fr" value="" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Product Category</label>
				<div class="controls">
				<select  name="category">
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
			</div>
			<div class="control-group">
				<label class="control-label">Product Image</label>
				<div class="controls">
        		<input type="file"  name="image"/>
        		<span id="imageString">value=""</span>
        		</div>
			</div>
			
				<div class="control-group packaging-title">
					<div class="section section-33">
							<label class="control-label">Product Packaging</label>
					</div>
					<div class="section section-33">
							<label class="control-label">Product Code</label>
					</div>
					<div class="section section-33">
							<label class="control-label">Point Value</label>
					</div>
					<div class="section section-33">
							<label class="control-label">Purchase Price</label>
					</div>
					<div class="section section-33">
							<label class="control-label"><a href="#" onclick="addPackaging()" class="button"><i class="fa fa-plus"> Add Packaging</i></a></label>
					</div>
				</div>
				<div id="packages">
					<div class="control-group" id="package<?= $pdtCount ?>">
							<div class="control-label section section-33">
							<select class="input-field packaging" name="packaging<?= $pdtCount ?>">
								<?php 
									$sqlPack = "SELECT * FROM product_packaging";
									$resultPack = $conn->query($sqlPack);
			    					while ($rowPack = $resultPack->fetch_assoc()){
								?>
							  	<option value='<?php echo $rowPack["id"];?>'><?php echo $rowPack["type"] . " - " . $rowPack["quantity"];?></option>
							    <?php 
			    					}
							    ?>
							</select>
							</div>
							<div class="control-label section section-33">
        		<input type="text" class="input-field code" name="code<?= $pdtCount ?>" value="" />
							</div>
							<div class="control-label section section-33">
        		<input type="text" class="input-field points" name="points<?= $pdtCount ?>" value="" />
							</div>
							<div class="control-label section section-10">
        		<input type="text" class="input-field price" name="price<?= $pdtCount ?>" value="" />
							</div>
						</div>
				</div>
		
			<div class="control-group">
	              <div class="form-actions">
	                <input type="submit" name="submitform" value="Save" class="btn btn-success">
	              </div>
              </div>
		
	</form>
</div>
</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php	
}
?>
<script>

var pdtCount = <?php echo $pdtCount;?>;

function addPackaging() {

var html = '<div class="control-group" id="package'+pdtCount+'">'+
	'<div class="control-label section section-33">'+
'<select class="input-field packaging" name="packaging'+pdtCount+'">'+
'		<?php 
			$sqlPack = "SELECT * FROM product_packaging";
			$resultPack = $conn->query($sqlPack);
			while ($rowPack = $resultPack->fetch_assoc()){
		?>'+
'	  	<option value="<?php echo $rowPack["id"];?>"><?php echo $rowPack["type"] . " - " . $rowPack["quantity"];?></option>'+
'	    <?php } ?> '+
'</select>'+
'</div>'+
'<div class="control-label section section-33">'+
'<input type="text" class="input-field code" name="code'+pdtCount+'" value="" />'+
'</div>'+
'<div class="control-label section section-33">'+
'<input type="text" class="input-field points" name="points'+pdtCount+'" value="" />'+
'</div>'+
'<div class="control-label section section-10">'+
'<input type="text" class="input-field price" name="price'+pdtCount+'" value="" />'+
'</div>'+
'<div class="control-label section section-10">'+
'	<a href="#" style="float: left;" onclick="remove(' + pdtCount + ')"><i class="fa fa-trash"></i></a>'+
'</div>'+
'</div>';

pdtCount++;

document.getElementById("packages").innerHTML = document.getElementById("packages").innerHTML + html;

updatePackageNames();
}

function remove(id) {
	document.getElementById("package" + id).parentNode.removeChild(document.getElementById("package" + id));
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
}
include 'inc/footer.php';
?>