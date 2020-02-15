<?php
include 'inc/header.php';
?>
<title>Email Template</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {
	
	$pdtCount = 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM email_templates WHERE id=$id";
    
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    
?>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="templates.php" title="All Templates" class="tip-bottom">Email Template</a> 
    	<a href="#" class="current">Email Template<?= " : " . $row["name"] ?></a> 
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <table class="legend">
	      	<tr><th>Dynamic Content</th></tr>
	      	<tr>
	      		<td><b>{customer_name</b>}</td><td>Customer Name</td>
	      		<td><b>{sales_rep_name</b>}</td><td>Sales Representative Name</td>
	      	</tr>
	      	<tr>
	      		<td><b>{contract_url</b>}</td><td>Custumer Contract 'Click here' link</td>
	      		<td><b>{customer_credentials</b>}</td><td>Custumer Login Credentials</td>
	      	</tr>
	      </table>
	  </div>
  	</div>
  </div>
  
  <div class="container-fluid">
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Email Template</h5>
          </div>
          <div class="widget-content nopadding">

<div class="form-style-2">
	<form enctype="multipart/form-data" class="form-horizontal" autocomplete="off" method="post" name="basic_validate" id="basic_validate" novalidate="novalidate" action="actions/actiontemplate.php"> <!-- onsubmit="return validateForm()" -->
			<div class="control-group">
				<label class="control-label">Name</label>
				<div class="controls">
	        		<input type="text"  name="name" value="<?php echo $row["name"];?>" readonly/>
	        	</div>
				<div class="controls">
	        		<input type="hidden"  name="id" value="<?php echo $row["id"];?>" />
	        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Subject (French)</label>
				<div class="controls">
	        		<input type="text"  name="subjectfr" value="<?php echo $row["subject_fr"];?>"/>
	        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Subject (English)</label>
				<div class="controls">
	        		<input type="text"  name="subject" value="<?php echo $row["subject_en"];?>"/>
	        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Content (French)</label>
				<div class="controls">
	        		<textarea name="contentfr" rows="10" cols="100"><?php echo $row["content_fr"];?></textarea>
	        	</div>
			</div>
			<div class="control-group">
				<label class="control-label">Content (English)</label>
				<div class="controls">
	        		<textarea name="content" rows="10" cols="100"><?php echo $row["content_en"];?></textarea>
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