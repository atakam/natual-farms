<?php
include 'inc/header.php';
?>
<title>Export</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';
if ($admin_flag=='1') {

?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="customers.php" title="All Customers" class="current">Export</a> 
    </div>
  </div>
  
  <div class="container-fluid">
  
  <?php if (isset($_GET["act"])){ ?>
  <div class="alert alert-success alert-block" style="margin-top:10px"> <a class="close" data-dismiss="alert" href="#">×</a>
       	<h4 class="alert-heading">Success!</h4>
       	You have successfully executed the export query!
  </div>
  <?php } ?>
  <?php if (isset($_GET["err"])){ ?>
  <div class="alert alert-error alert-block" style="margin-top:10px"> <a class="close" data-dismiss="alert" href="#">×</a>
       	<h4 class="alert-heading">Error!</h4>
       	<?php 
       	$err = "Error occured during export!";
       	echo $err;
       	?>
  </div>
  <?php } ?>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
	        <form method="post" action="actions/actionexport.php">
	          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	            <h5>Order Summary</h5>
	            <span style="float: right">
	            	From <input type="date" name="datefrom" style="width: 150px;"/>
	            	To <input type="date" name="dateto" style="width: 150px;"/>
	            </span>
	          </div>
	          <div class="widget-content nopadding">
				<table class="export-table">
					<tr>
						<th>NFF</th>
						<th>NAME</th>
						<th>PHONE NUMBER</th>
						<th>DATE JOINED</th>
						<th>CONTRACT DATE</th>
						<th>TOTAL POINTS</th>
						<th>TOTAL PRICE</th>
						<th>PAYMENT TYPE</th>
						<th>DELIVERY 1</th>
						<th>DELIVERY 2</th>
						<th>DELIVERY 3</th>
						<th>REPRESENTATIVE</th>
					</tr>
					<tr>
						<th><input type="checkbox" name="nff" checked/></th>
						<th><input type="checkbox" name="name" checked/></th>
						<th><input type="checkbox" name="cphone" checked/></th>
						<th><input type="checkbox" name="jodate" checked/></th>
						<th><input type="checkbox" name="codate" checked/></th>
						<th><input type="checkbox" name="points" checked/></th>
						<th><input type="checkbox" name="price" checked/></th>
						<th><input type="checkbox" name="payment" checked/></th>
						<th><input type="checkbox" name="delivery1" checked/></th>
						<th><input type="checkbox" name="delivery2" checked/></th>
						<th><input type="checkbox" name="delivery3" checked/></th>
						<th><input type="checkbox" name="rep" checked/></th>
					</tr>
				</table>
				<input type="submit" name="orderexport"/>
			  </div>
		  </form>
        </div>
      </div>
    </div>
    
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
        	<form method="post" action="actions/actionexport.php">
	          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	            <h5>Customer Summary</h5>
	            <span style="float: right">
	            	From <input type="date" name="datefrom" style="width: 150px;"/>
	            	To <input type="date" name="dateto" style="width: 150px;"/>
	            </span>
	          </div>
	          <div class="widget-content nopadding">
				<table class="export-table">
					<tr>
						<th>FIRST NAME</th>
						<th>LAST NAME</th>
						<th>PHONE NUMBER</th>
						<th>EMAIL</th>
						<th>ADDRESS</th>
						<th>CITY</th>
						<th>PROVINCE</th>
						<th>POSTAL CODE</th>
						<th>ACTIVE</th>
						<th>DATE SINCE</th>
						<th>SECONDARY INFORMATION</th>
					</tr>
					<tr>
						<th><input type="checkbox" name="fname" checked/></th>
						<th><input type="checkbox" name="lname" checked/></th>
						<th><input type="checkbox" name="phone" checked/></th>
						<th><input type="checkbox" name="email" checked/></th>
						<th><input type="checkbox" name="address" checked/></th>
						<th><input type="checkbox" name="city" checked/></th>
						<th><input type="checkbox" name="province" checked/></th>
						<th><input type="checkbox" name="postal" checked/></th>
						<th><input type="checkbox" name="active" checked/></th>
						<th><input type="checkbox" name="datesince" checked/></th>
						<th><input type="checkbox" name="secondary" checked/></th>
					</tr>
				</table>
				<input type="submit" name="customerexport"/>
			  </div>
			</form>
        </div>
      </div>
    </div>
    
  </div>
  
</div>
<?php 
}
include 'inc/footer.php';
?>