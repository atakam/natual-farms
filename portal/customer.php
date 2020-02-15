<?php
include 'inc/header.php';
?>
<title>Customer</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
	
	if (isset($_GET['id'])) {
	    $id = $_GET['id'];
	    
	    $sql = "SELECT * FROM customer WHERE id=$id";
	    $sql2 = "SELECT * FROM form_completion WHERE customer_id=$id";
	    
	    $result = $conn->query($sql);
	    $row = $result->fetch_assoc();

		$name1 = "";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$name1 = " : " . $row['firstname'] . " " . $row['lastname'];
    
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="customers.php" title="All Customers" class="tip-bottom">Customers</a> 
    	<a href="#" class="current">Customer<?= $name1 ?></a>
    </div>
  </div>
  
  <div class="container-fluid">
  
  <?php if (isset($_GET["act"])){ ?>
  <div class="alert alert-success alert-block" style="margin-top:10px"> <a class="close" data-dismiss="alert" href="#">×</a>
       	<h4 class="alert-heading">Success!</h4>
       	You have successfully <?= $_GET["act"]=="add"?"added a new":"updated the" ?> customer!
  </div>
  <?php } ?>
  <?php if (isset($_GET["err"])){ ?>
  <div class="alert alert-error alert-block" style="margin-top:10px"> <a class="close" data-dismiss="alert" href="#">×</a>
       	<h4 class="alert-heading">Error!</h4>
       	<?php 
       	$err = "";
       	if($_GET["err"]=="fn") {
       		$err = "First name cannot be empty!";
       	}
       	else if ($_GET["err"]=="ln") {
       		$err = "Last name cannot be empty!";
       	}
       	else if ($_GET["err"]=="st") {
       		$err = "Adddress Line 1 cannot be empty!";
       	}
       	else if ($_GET["err"]=="ci") {
       		$err = "City cannot be empty!";
       	}
       	else if ($_GET["err"]=="pr") {
       		$err = "Province cannot be empty!";
       	}
       	else if ($_GET["err"]=="pc") {
       		$err = "Postal Code cannot be empty!";
       	}
       	echo $err;
       	?>
  </div>
  <?php } ?>
   
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Customer</h5>
          </div>
          <div class="widget-content nopadding">
          
<div class="form-style-2">
	<form class="form-horizontal" method="post" action="actions/actioncustomeredit.php" autocomplete="off" name="basic_validate" id="basic_validate" novalidate="novalidate">
		<div class="form-style-2-heading">Personal Information</div>
			<input type="hidden" class="input-field disabled" name="id" value="<?= $row["id"];?>"/>
			<div class="control-group">
				<label class="control-label">Last Name <span class="required">*</span></label>
				<div class="controls">
        		<input type="text"  name="lastname" value="<?= $row["lastname"];?>" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">First Name <span class="required">*</span></label>
				<div class="controls">
        		<input type="text"  name="firstname" value="<?= $row["firstname"];?>" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Email <span class="required">*</span></label>
				<div class="controls">
        		<input type="email"  name="email" value="<?= $row["email"];?>" />
        	</div>
			</div>	
			<div class="control-group">
				<label class="control-label">Tel Home <span class="required">*</span></label>
				<div class="controls">
        		<input type="tel"  name="phone" value="<?= $row["phone"];?>" maxlength="10" />
        		</div>
			</div>
			<div class="control-group">
                <label class="control-label">Change Password</label>
                <div class="controls">
                  <input type="password" name="password" id="password">
                </div>
              </div>
            <div class="control-group">
				<label class="control-label">Is Active?</label>
				<div class="controls">
        		<input type="checkbox"  name="active" <?= $row["isactive"]=='1'?"checked":"";?> />
        		</div>
			</div>
			<div class="control-group">
			    <label class="control-label">Customer Since</label>
			    <div class="controls">
        			<input type="date" name="since" value="<?php echo $row["dateSince"];?>"/>	
        		</div>
			</div>
		
		<div class="form-style-2-heading">Address Information</div>
		
			<div class="control-group">
				<label class="control-label">Address Line 1<span class="required">*</span></label>
				<div class="controls">
        		<input type="text"  name="streetaddress1" value="<?= $row["streetaddress1"];?>" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Address Line 2</label>
				<div class="controls">
        		<input type="text"  name="streetaddress2" value="<?= $row["streetaddress2"];?>" />
        	</div>
			</div>
		
			<div class="control-group">
				<label class="control-label">City <span class="required">*</span></label>
				<div class="controls">
        		<input type="text"  name="city" value="<?= $row["city"];?>" />
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Province <span class="required">*</span></label>
				<div class="controls">
					<select name="province" class="select-field mandatory">
					  	<option selected></option>
					  	<option <?php if ($row["province"]==="AB") echo "selected";?>>AB</option>
					  	<option <?php if ($row["province"]==="BC") echo "selected";?>>BC</option>
					  	<option <?php if ($row["province"]==="MB") echo "selected";?>>MB</option>
					  	<option <?php if ($row["province"]==="NB") echo "selected";?>>NB</option>
					  	<option <?php if ($row["province"]==="NL") echo "selected";?>>NL</option>
					    <option <?php if ($row["province"]==="NS") echo "selected";?>>NS</option>
					    <option <?php if ($row["province"]==="ON") echo "selected";?>>ON</option>
					    <option <?php if ($row["province"]==="PE") echo "selected";?>>PE</option>
					    <option <?php if ($row["province"]==="QC") echo "selected";?>>QC</option>
					    <option <?php if ($row["province"]==="SK") echo "selected";?>>SK</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Postal Code <span class="required">*</span></label>
				<div class="controls">
        		<input type="text"  name="postal" value="<?= $row["postalcode"];?>"/>
        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Sector</label>
				<div class="controls">
        		<input type="text"  name="sector" value="<?= $row["sector"];?>" />
        		</div>
			</div>	
			<div class="form-style-2-heading">Send Email to Customer</div>
			<div class="control-group">
				<label class="control-label">Send Email?</label>
				<div class="controls">
        		<input type="checkbox"  name="sendemail" checked />
        		</div>
			</div>
			<div class="control-group">
	              <div class="form-actions">
	                <input type="submit" value="Save" class="btn btn-success">
	              </div>
           	</div>	
	</form>
</div>
</div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Orders</h5>
          </div>
          <div class="widget-content nopadding">
            <?php

				$result2 = $conn->query($sql2);
				echo "<table class='table table-bordered data-table'>";
				echo "<thead><tr>";
				echo "<th>Date</th><th>Total Points</th><th>Total Price</th><th>First Delivery Date</th><th>Sales Representative</th><th></th><th></th>";
				echo "</tr></thead>";
				
				while ($row2 = $result2->fetch_assoc())
				{
					echo "<tr>";
					echo "<td>$row2[signature_date]</td><td>$row2[total_points]</td><td>$row2[price]</td><td>$row2[conditions_firstdeliverydate]</td><td>".
					"$row2[signature_merchant_name]</td><td><a href='edit.php?id=$row2[id]'><i class='fa fa-edit'></i></a></td>".
					"<td><a href='print.php?id=$row2[id]'><i class='fa fa-file-pdf-o'></i></a></td>";
					echo "</tr>";
				}
				echo "</table>";
			?>
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