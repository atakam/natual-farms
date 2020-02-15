<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='0') {
include 'inc/menu.php';
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Dummy Orders</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <a href="actions/delete.php?demoformidall=yes" class="btn btn-inverse btn-mini">Delete All Demo Content</a>
	  </div>
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <table class="legend">
	      	<tr><td><div class='dot view1'></div></td><td>View recent dummy order</td><td><div class='dot delete'></div></td><td>Delete dummy order</td></tr>
	      </table>
	  </div>
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th-list"></i></span>
            <h5>Dummy Orders: List View</h5>
          </div>
          <div class="widget-content nopadding">
	<?php 
	
	$sql = "SELECT * FROM form_completion_demo ORDER BY signature_date DESC";
	
	$result = $conn->query($sql);
	echo "<table id='table-orders' class='table table-bordered data-table'>";
	echo "<thead><tr>";
	echo "<th>Customer Name</th><th>Phone Number</th><th id='orderlist'>Date</th><th>Total Points</th>
    			<th><div class='dot view1'></div></th>";
	if ($admin_flag == '1'){
		echo "<th><div class='dot delete'></div></th>";
	}
	echo "</tr></thead><tbody>";
	
	while ($row = $result->fetch_assoc())
	{
		$sql2 = "SELECT * FROM customer_demo WHERE id=".$row['customer_id']." LIMIT 1";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();
		
		if($row2['isactive'] == '0')
		{
			continue;
		}
		
		$status = "<span style='color: green;'><i class='fa fa-check'></i></span>";
		if ($row['status'] === "0")
		{
			$status = "<span style='color: red;'>NO ID</span>";
		}
		
		$sql3 = "SELECT * FROM representative WHERE id=".$row['representative_id']." LIMIT 1";
		$result3 = $conn->query($sql3);
		$row3 = $result3->fetch_assoc();
		$representative = $row3['name'];
		$delete = "";
		$editurl = "edit.php?edit=yes&";
		$editurl2 = "#";
		if ($admin_flag == '1'){
			$delete = "<td><a href='#' onclick=\"deleteAction('demoformid', $row[id])\"><i class='fa fa-trash'></i></a></td>";
			$editurl = "adminedit.php?";
			
			$editurl2 = "edit.php?edit=yes&edited=yes&";
			$editurl2 = "order/".$editurl2."id=".$row['id']."&rid=".$row['representative_id'];
		}
		$points = $row['total_points'];
		$price = $row['price'];
		$rebate = $row['rebate'];
		$deposit = $row['deposit'];
		$subtotal = $row['subtotal'];
		$total = $row['total'];
		
// 		$edited = $row['edited_points'] != 0 ? "<i style='color: red; font-weight: bold;'>FORM EDITED</i>": "";
		$edited = "";	// For now we don't need to handle the customer edit
		if ($row['edited_status'] == '1')
		{
			$edited = "<i class='fa fa-star' style='color: green;'></i>";
			$points = $row['edited_points'];
			$price = $row['edited_price'];
			$rebate = $row['edited_rebate'];
			$deposit = $row['edited_deposit'];
			$subtotal = $row['edited_subtotal'];
			$total = $row['edited_total'];
		}
		else {
			$sql22 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
			$result22 = $conn->query($sql22);
			while($row22 = $result22->fetch_assoc())
			{
				$edited = "<i class='fa fa-star' style='color: red;'></i>";
				break;
			}
		}
		
		$editRep = "";
		$repSelect = "";
		
		$id = $row['id'];
		
		if ($admin_flag){
			$editRep = "<span id='edit$id'><a href='#' onclick='changeRep(this,\"$id\")' style='float:right'><i class='fa fa-pencil'></i></a></span>";
			
			$repSelect = "<select style='width:80%' id='$row[id]'>";
			$sql4 = "SELECT * FROM representative";
			$result4 = $conn->query($sql4);
			while($row4 = $result4->fetch_assoc())
			{
				$selected = $row4['id']==$row3['id']?"selected":"";
				$repSelect .= "<option value='$row4[id]' $selected>$row4[name]</option>";
			}
			$repSelect .= "</select>";
			$repSelect .= "<span id='save$id' style='display:none; float:right'><a href='#' onclick='saveRep(this,\"$id\")' style='float:right'><i class='fa fa-save'></i></a></span>";
		}
		
		$type = $row['cc_flag']=='1'?"CC":"N/A";
		if ($type != 'CC')
		{
			$type = $row['preauthorized_flag']=='1'?"PP":"N/A";
		}
		if ($type != 'CC' && $type != 'PP')
		{
			$type = $row['cash_flag']=='1'?"CQ":"N/A";
		}
		
		$nextdate = $row['conditions_firstdeliverydate'];
		$append = " (<b>1</b>)";
		
		$color = "inherit";
		if ($row['notconfirm1'] == '1'){
			$color = '#ee5f5b';
		}if ($row['confirm1'] == '1'){
			$color = '#62c462';
		}if($row['deliver1']){
			$color = '#08c';
		}
		
		if(strtotime($nextdate) < strtotime('now') ) {
			$nextdate = $row['conditions_seconddeliverydate'];
			$append = " (<b>2</b>)";
			
			$color = "inherit";
			if ($row['notconfirm2'] == '1'){
				$color = '#ee5f5b';
			}if ($row['confirm2'] == '1'){
				$color = '#62c462';
			}if($row['deliver2']){
				$color = '#08c';
			}
		}
		if(strtotime($nextdate) < strtotime('now') ) {
			$nextdate = $row['conditions_thirddeliverydate'];
			$append = " (<b>3</b>)";
			
			$color = "inherit";
			if ($row['notconfirm3'] == '1'){
				$color = '#ee5f5b';
			}if ($row['confirm3'] == '1'){
				$color = '#62c462';
			}if($row['deliver3']){
				$color = '#08c';
			}
		}
		
		$editConfirm = $admin_flag=='1'?" <a href='#conf$nextdate' data-toggle='modal'><i class='fa fa-volume-control-phone' style='float:right;color:$color'></i></a>":"";
		$nextdate .= $append . $editConfirm;
		
		echo "<td>$row2[firstname] $row2[lastname]</td><td>$row2[phone]</td><td>$row[signature_date]</td><td>$points</td>
						<td><a title='View Contract' href='demo/contract_demo.php?id=$row[id]&edited=yes&rid=$row[representative_id]' target='_blank'><i class='fa fa-search'></i></a></td>
						$delete";
		echo "</tr>";
	}
	echo "</tbody></table></div>";
	?>
		</div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function orderList(){
	document.getElementById("orderlist").click();
	document.getElementById("orderlist").click();
}
window.onload = orderList;
</script>

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
