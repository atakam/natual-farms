<?php
include 'inc/header.php';
?>
<title>Customers</title>

<!-- Sidebar -->
<?php
include 'inc/menu.php';

$extra = "";
if (isset($_GET['filter'])) {
	if ($_GET['filter'] === 'active') {
		$extra = ' WHERE isactive=1';
	}
	else if ($_GET['filter'] === 'inactive') {
		$extra = ' WHERE isactive=0';
	}
}

$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
$count1 = 0;
$count2 = 0;
$count3 = 0;
while ($row = $result->fetch_assoc())
{
	$count1++;
	if ($row['isactive'] === '1') {
		$count2++;
	}
	else {
		$count3++;
	}
}
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Customers</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <a href="mapView.php" class="btn btn-inverse btn-mini"><i class="icon-map-marker icon-white"></i> Map View</a>
	  </div>
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>
	            <a href="customers.php"><span class="<?= (isset($_GET['filter']) && ($_GET['filter']==='active' || $_GET['filter']==='inactive')) ? 'grey-button' : 'download-button' ?>">All Customers (<?= $count1 ?>)</span></a> | 
	            <a href="customers.php?filter=active"><span class="<?= isset($_GET['filter']) && $_GET['filter']==='active' ? 'modify-button' : 'grey-button' ?>">Active Customers (<?= $count2 ?>)</span></a> | 
	            <a href="customers.php?filter=inactive"><span class="<?= isset($_GET['filter']) && $_GET['filter']==='inactive' ? 'delete-button' : 'grey-button' ?>">Inactive Customers (<?= $count3 ?>)</span></a>
            </h5> 
          </div>
          <div class="widget-content nopadding">
	<?php 
	
	$sql = "SELECT * FROM customer ".$extra;
	
	$result = $conn->query($sql);
	echo "<table id='table-customers' class='table table-bordered data-table'>";
	echo "<thead><tr>";
	echo "<th>NFF</th><th>First Name</th><th>Last Name</th><th>Expired</th><th>Phone Number</th><th>Email</th><th>City</th><th>Province</th><th>Active</th><th></th><th></th>";
	echo "</tr></thead>";
	
	while ($row = $result->fetch_assoc())
	{
		$sql2 = "SELECT * FROM form_completion WHERE customer_id=".$row['id']." ORDER BY id DESC";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();
		$expired = '';
		if ($row2['deliver3'] === '1') {
			$from = strtotime($row2['conditions_thirddeliverydate']);
			$today = time();
			$difference = $today - $from;
			$dd =  floor($difference / 86400);  // (60 * 60 * 24)
			 
			$m = floor($dd/30);
			$w = floor(($dd%30)/7);
			$d = (($dd%30)%7);
			$expired = "<span class='expired-order' title='[".$m." month(s) ".$w." week(s) ".$d." day(s) ago]'>EXPIRED</span>";
		}
		
		$activetext = $row["isactive"]=='1'?"class='fa fa-check' style='color:#62c462'":"class='fa fa-times' style='color:#ee5f5b'";
		echo "<tr>";
		echo "<td>".$row['nff']."</td><td>".$row['firstname']."</td><td>".$row['lastname']."</td><td>".$expired."</td><td>".$row['phone']."</td><td>".$row['email'].
		     "</td><td>".$row['city']."</td><td>".$row['province']."</td><td><i $activetext><span style='visibility:hidden'>".$row['isactive']."</span></i></td>
          		<td><a href='customer.php?id=".$row['id']."'><i class='fa fa-edit'></i></a></td>".
		     "<td><a href='#' onclick=\"deleteAction('custid', $row[id])\"><i class='fa fa-trash'></i></a></td>";
		echo "</tr>";
	}
	echo "</table></div>";
	
 	?>
		</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php
include 'inc/footer.php';
?>