<?php
include 'inc/header.php';
?>
<title>Staff</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
	
	$name1 = "";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		
		$sql = "SELECT * FROM representative WHERE id=$id";
		if (isset($_GET['staff']) && $_GET['staff']=="supplier") {
			$sql = "SELECT * FROM supplier WHERE id=$id";
		}
		else if (isset($_GET['staff']) && $_GET['staff']=="delivery") {
			$sql = "SELECT * FROM delivery_man WHERE id=$id";
		}
	
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$name1 = " : " . $row['name'];
	}
    
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="representatives.php" title="All Representatives" class="tip-bottom">Staff</a>
    	<a href="#" class="current">Staff<?= $name1 ?></a> 
    </div>
  </div>
  
  <div class="container-fluid">
  
  <?php if (isset($_GET["act"])){ ?>
  <div class="alert alert-success alert-block" style="margin-top:10px"> <a class="close" data-dismiss="alert" href="#">×</a>
       	<h4 class="alert-heading">Success!</h4>
       	You have successfully <?= $_GET["act"]=="add"?"added a new":"updated the" ?> representative!
  </div>
  <?php } ?>
  <?php if (isset($_GET["err"])){ ?>
  <div class="alert alert-error alert-block" style="margin-top:10px"> <a class="close" data-dismiss="alert" href="#">×</a>
       	<h4 class="alert-heading">Error!</h4>
       	<?php 
       	$err = "";
       	if($_GET["err"]=="usr") {
       		$err = "Username already exist!";
       	}
       	else if ($_GET["err"]=="email") {
       		$err = "Email already exist!";
       	}
       	else if ($_GET["err"]=="noemail") {
       		$err = "Email cannot be empty!";
       	}
       	else if ($_GET["err"]=="nousr") {
       		$err = "Username cannot be empty!";
       	}
       	echo $err;
       	?>
  </div>
  <?php } ?>
   
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Staff</h5>
          </div>
          <div class="widget-content nopadding">

<?php 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM representative WHERE id=$id";
    if (isset($_GET['staff']) && $_GET['staff']=="supplier") {
    	$sql = "SELECT * FROM supplier WHERE id=$id";
    }
    else if (isset($_GET['staff']) && $_GET['staff']=="delivery") {
    	$sql = "SELECT * FROM delivery_man WHERE id=$id";
    }
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

?>
<div class="form-style-2">
	<form class="form-horizontal" method="post" action="actions/actionrepresentative.php" autocomplete="off" name="basic_validate" id="basic_validate" novalidate="novalidate">
              <input type="hidden" class="input-field" name="id" value="<?= $row["id"];?>" />
              <div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="required" value="<?= $row["name"];?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                  <input type="text" name="email" id="email" value="<?= $row["email"];?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                  <input type="text" name=username id="username" value="<?= $row["username"];?>" >
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Change Password</label>
                <div class="controls">
                  <input type="password" name="password" id="password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Role</label>
                <div class="controls">
                	<select name="role">
                		<option value="none" selected>Sales Representative</option>
                		<option value="admin" <?= $row["role"]=='admin'?"selected":"";?>>Administrator</option>
                		<option value="supplier" <?= $row["role"]=='supplier'?"selected":"";?>>Supplier</option>
                		<option value="delivery" <?= $row["role"]=='delivery'?"selected":"";?>>Delivery Agent</option>
                	</select>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Save" class="btn btn-success">
              </div>
       </form>
</div>
<?php 
}
else {
?>

<div class="form-style-2">
	<form class="form-horizontal" method="post" action="actions/actionrepresentative.php" autocomplete="off" name="basic_validate" id="basic_validate" novalidate="novalidate">
			<div class="control-group">
                <label class="control-label">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="required" value="<?= isset($_GET["err"])?$_GET['name']:"";?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                  <input type="text" name="email" id="email" value="<?= isset($_GET["err"])?$_GET['email']:"";?>">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                  <input type="text" name=username id="username" value="<?= isset($_GET["err"])?$_GET['username']:"";?>" >
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Change Password</label>
                <div class="controls">
                  <input type="password" name="password" id="password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Role</label>
                <div class="controls">
                  <select name="role">
                		<option value="none" selected>Sales Representative</option>
                		<option value="admin">Administrator</option>
                		<option value="supplier">Supplier</option>
                		<option value="delivery">Delivery Agent</option>
                	</select>
                </div>
              </div>
              <div class="control-group">
	              <div class="form-actions">
	                <input type="submit" value="Save" class="btn btn-success">
	              </div>
              </div>
	</form>
</div>
<?php	
}
echo "</div>";
?>
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