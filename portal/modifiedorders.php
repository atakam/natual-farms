<?php
include 'inc/header.php';
?>
<title>Modified Orders</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='0') {
include 'inc/menu.php';
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Modified Orders</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th-list"></i></span>
            <h5>Modified Orders: List View</h5>
          </div>
          <div class="widget-content nopadding">
	<?php 
	
	$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
	if ($admin_flag=='1') {
		$sql = "SELECT * FROM form_completion";
	}
	
	$result = $conn->query($sql);
	echo "<table id='table-orders' class='table table-bordered data-table'>";
	echo "<thead><tr>";
	echo "<th>NFF</th><th>Customer Name</th><th>Phone Number</th><th>Date</th><th>Total Points</th><th>Total Price</th><th>First Delivery Date</th><th>Sales Representative</th><th>Status</th>
		  <th></th>";
	if ($admin_flag == '1'){
		echo "<th></th>";
	}
	echo "</tr></thead><tbody>";
	
	while ($row = $result->fetch_assoc())
	{
		$sql3 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
		$result3 = $conn->query($sql3);
		$row3 = $result3->fetch_assoc();
		if ($row3['form_id'] != ''){
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
		
			$status = "<span style='color:green'>Approved</span>";
			if ($row['edited_status'] === "0")
			{
				$status = "<span style='color:red'>Pending Approval</span>";
			}
			
			$sql3 = "SELECT * FROM representative WHERE id=".$row['representative_id']." LIMIT 1";
			$result3 = $conn->query($sql3);
			$row3 = $result3->fetch_assoc();
			$representative = $row3['name'];
			$delete = "";
			$editurl = "edit.php?edit=yes&edited=yes&";
			if ($admin_flag == '1'){
				$delete = "<td><a href='#' onclick=\"deleteAction('edited_formid', $row[id])\"><i class='fa fa-trash'></i></a></td>";
			}
			
	// 		$edited = $row['edited_points'] != 0 ? "<i style='color: red; font-weight: bold;'>FORM EDITED</i>": "";
			$edited = "";	// For now we don't need to handle the customer edit
			
			echo "<tr><td>$row2[nff]</td>";
			echo "<td>$row2[firstname] $row2[lastname]</td><td>$row2[phone]</td><td>$row[signature_date]</td><td>$row[edited_points]</td><td>$row[edited_price]</td><td>$row[conditions_firstdeliverydate]</td><td>".
							"$representative</td><td>$status</td>".
						//	<td><a href='edit.php?id=$row[id]' title='Customer Edit'><i class='fa fa-edit'></i></a></td>	// For now we don't need to handle the customer edit
							"<td><a href='order/".$editurl."id=$row[id]&rid=$row[representative_id]' title='Verify Changes'><i class='fa fa-edit'></i></a></td>
							$delete";
			echo "</tr>";
		}
	}
	echo "</tbody></table></div>";
	
	?>
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
}
else {
	header("Location: customer_orders.php");
}
?>
