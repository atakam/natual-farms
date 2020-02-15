<?php
include 'inc/header.php';
?>
<title>Products</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Settings</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Settings</h5>
          </div>
          <div class="widget-content nopadding">
          <?php 
			$sql = "SELECT * FROM settings";
			
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
		  ?>
            <form class="form-horizontal" method="post" action="actions/actionsettings.php" autocomplete="off" name="basic_validate" id="basic_validate" novalidate="novalidate">
              <div class="control-group">
                <label class="control-label">Super Admin Email</label>
                <div class="controls">
                  <input type="text" name="email" id="email" value="<?php echo $row["admin_email"];?>">
                </div>
              </div>
               
              <div class="control-group">
                <label class="control-label">Customer Super Password</label>
                <div class="controls">
                  <input type="text" name="superpassword" id="superpassword" value="<?php echo $row["password"];?>">
                </div>
              </div>
              <!--
              <div class="control-group">
                <label class="control-label">Delivery Email</label>
                <div class="controls">
                  <input type="text" name="email3" id="email3" value="<?php echo $row["provider_email2"];?>">
                </div>
              </div>
               -->
              <div class="form-actions">
                <input type="submit" value="Save" class="btn btn-success">
              </div>
              
            </form>
		</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php
}
include 'inc/footer.php';
?>