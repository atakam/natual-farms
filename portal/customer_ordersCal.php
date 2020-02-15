<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='1') {
include 'inc/menu.php';
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Orders</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <a href="customer_orders.php" class="btn btn-inverse btn-mini"><i class="icon-th-list icon-white"></i> List View</a>
	  </div>
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-calendar">
          <div class="widget-title"> <span class="icon"><i class="icon-calendar"></i></span>
            <h5>Calendar: Calendar View</h5>
          </div>
          <div class="widget-content">
            <div class="panel-left" style="margin-top:27px">
              <div id="fullcalendar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- footer -->
<?php
include 'inc/footer.php';
?>

<?php 
$sql = "SELECT * FROM form_completion WHERE customer_id=".$user_id;
if ($admin_flag=='1') {
	$sql = "SELECT * FROM form_completion";
}

$result = $conn->query($sql);

echo '<script type="text/javascript">';
echo '$(document).ready(function(){';
while ($row = $result->fetch_assoc())
{
	$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	$status = "Completed";
	if ($row['status'] === "0")
	{
		$status = "ID not assigned";
	}


	// 		$edited = $row['edited_points'] != 0 ? "<i style='color: red; font-weight: bold;'>FORM EDITED</i>": "";
	$edited = "";	// For now we don't need to handle the customer edit

	$name = "$row2[firstname] $row2[lastname]";
	$date = $row['conditions_firstdeliverydate'] . "GMT-0500";
	$date2 = $row['conditions_seconddeliverydate'] . "GMT-0500";
	$date3 = $row['conditions_thirddeliverydate'] . "GMT-0500";
	
	if ($row['deliver1'] == 0) {
		echo 'addEventToCalendar("1 - '.$name.'", "'.$date.'", "#f'.$row['id'].'", "#62c462");';
	}
	if ($row['deliver2'] == 0) {
		echo 'addEventToCalendar("2 - '.$name.'", "'.$date2.'", "#s'.$row['id'].'", "#fb7a2c");';
	}
	if ($row['deliver3'] == 0) {
		echo 'addEventToCalendar("3 - '.$name.'", "'.$date3.'", "#t'.$row['id'].'", "#ee5f5b");';
	}
}
echo '});';
echo '</script>';
}
else {
	header("Location: orders.php");
}

$sql = "SELECT * FROM form_completion";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc())
{
	$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
	// First Delivery details
	echo '<div id="f'.$row['id'].'" class="modal hide">';
			echo '<div class="modal-header">';
            echo '<button data-dismiss="modal" class="close" type="button">×</button>';
            echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_firstdeliverydate'].' (First Delivery)</h3>';
            echo '</div>';
			echo '<div class="modal-body"><table style="font-size:small" class="table table-bordered">';
			echo '<thead><tr><th>Product Name</th><th>Packaging</th><th>Quatity</th></tr></thead>';
			
			$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
			$resultsOrd = $conn->query($sqlOrd);
			
	while ($rowOrd = $resultsOrd->fetch_assoc())
	{
		$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
		$resultsPtl = $conn->query($sqlPtl);
		$rowPtl = $resultsPtl->fetch_assoc();
		
		$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
		$resultsPtl2 = $conn->query($sqlPtl);
		$rowPtl2 = $resultsPtl2->fetch_assoc();
	
		$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
		$resultsPtl3 = $conn->query($sqlPtl);
		$rowPtl3 = $resultsPtl3->fetch_assoc();
		echo "<tr>";
		echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
		echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
		echo "<td>".$rowOrd["quantity1"]."</td>";
		echo "</tr>";
	}
	echo '</table></div></div>';
	
	// Second Delivery details
	echo '<div id="s'.$row['id'].'" class="modal hide">';
	echo '<div class="modal-header">';
	echo '<button data-dismiss="modal" class="close" type="button">×</button>';
	echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_seconddeliverydate'].' (Second Delivery)</h3>';
	echo '</div>';
	echo '<div class="modal-body"><table style="font-size:small" class="table table-bordered">';
	echo '<thead><tr><th>Product Name</th><th>Packaging</th><th>Quatity</th></tr></thead>';
		
	$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
	$resultsOrd = $conn->query($sqlOrd);
		
	while ($rowOrd = $resultsOrd->fetch_assoc())
	{
		$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
		$resultsPtl = $conn->query($sqlPtl);
		$rowPtl = $resultsPtl->fetch_assoc();
	
		$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
		$resultsPtl2 = $conn->query($sqlPtl);
		$rowPtl2 = $resultsPtl2->fetch_assoc();
	
		$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
		$resultsPtl3 = $conn->query($sqlPtl);
		$rowPtl3 = $resultsPtl3->fetch_assoc();
		echo "<tr>";
		echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
		echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
		echo "<td>".$rowOrd["quantity2"]."</td>";
		echo "</tr>";
	}
	echo '</table></div></div>';
	
	// Third Delivery details
	echo '<div id="f'.$row['id'].'" class="modal hide">';
	echo '<div class="modal-header">';
	echo '<button data-dismiss="modal" class="close" type="button">×</button>';
	echo '<h3>Orders for: '.$row2['firstname'].' '.$row2['lastname'].' on '.$row['conditions_thirddeliverydate'].'  (Third Delivery)</h3>';
	echo '</div>';
	echo '<div class="modal-body"><table style="font-size:small" class="table table-bordered">';
	echo '<thead><tr><th>Product Name</th><th>Packaging</th><th>Quatity</th></tr></thead>';
		
	$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
	$resultsOrd = $conn->query($sqlOrd);
		
	while ($rowOrd = $resultsOrd->fetch_assoc())
	{
		$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
		$resultsPtl = $conn->query($sqlPtl);
		$rowPtl = $resultsPtl->fetch_assoc();
	
		$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
		$resultsPtl2 = $conn->query($sqlPtl);
		$rowPtl2 = $resultsPtl2->fetch_assoc();
	
		$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
		$resultsPtl3 = $conn->query($sqlPtl);
		$rowPtl3 = $resultsPtl3->fetch_assoc();
		echo "<tr>";
		echo "<td>".$rowPtl["code"]." - ".$rowPtl3["name_fr"]." ".$rowPtl3["name_en"]."</td>";
		echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
		echo "<td>".$rowOrd["quantity3"]."</td>";
		echo "</tr>";
	}
	echo '</table></div></div>';
}
?>
