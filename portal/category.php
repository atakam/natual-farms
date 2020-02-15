<?php
include 'inc/header.php';
?>
<title>Product</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
	
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM products_category WHERE id=$id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="categories.php" title="All Categories" class="tip-bottom">Categories</a> 
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
	<form enctype="multipart/form-data" class="form-horizontal" autocomplete="off" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate" action="actions/actioncategory.php"> <!-- onsubmit="return validateForm()" -->
		
			<input type="hidden" class="input-field" name="id" value="<?= $row["id"];?>" />
              <div class="control-group">
                <label class="control-label">Name (En)</label>
                <div class="controls">
                  <input type="text" name="name_en" id="name_en" value="<?= $row["name_en"];?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Name (Fr)</label>
                <div class="controls">
                  <input type="text" name="name_fr" id="name_fr" value="<?= $row["name_fr"];?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Slug (One word, no special characters)</label>
                <div class="controls">
                  <input type="text" name="slug" id="slug" value="<?= $row["slug"];?>">
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
else {
?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="categories.php" title="All Categories" class="tip-bottom">Categories</a> 
    	<a href="#" class="current">New Category</a> 
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
	<form enctype="multipart/form-data" class="form-horizontal" autocomplete="off" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate" action="actions/actioncategory.php"> <!-- onsubmit="return validateForm()" -->
		
              <div class="control-group">
                <label class="control-label">Name (En)</label>
                <div class="controls">
                  <input type="text" name="name_en" id="name_en" value="<?= $row["name_en"];?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Name (Fr)</label>
                <div class="controls">
                  <input type="text" name="name_fr" id="name_fr" value="<?= $row["name_fr"];?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Slug (One word, no special characters)</label>
                <div class="controls">
                  <input type="text" name="slug" id="slug" <?= $row["slug"];?>>
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
}
include 'inc/footer.php';
?>