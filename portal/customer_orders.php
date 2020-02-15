<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
if (isset($_GET['lang']) && $_GET['lang']=="en")
{
	$language = "en_US";
	putenv("LANG=".$language);
	setlocale(LC_ALL, $language);

	$locale = "en_US.UTF-8";
	setlocale(LC_ALL, $locale);

	$domain = "messages";
	bindtextdomain($domain, "order/Locale");
	textdomain($domain);
	//echo "English";
}
else{
	$language = "fr_FR";
	putenv("LANG=".$language);
	setlocale(LC_ALL, $language);

	$locale = "fr_FR.UTF-8";
	setlocale(LC_ALL, $locale);

	$domain = "messages";
	bindtextdomain($domain, "order/Locale");
	textdomain($domain);

	//echo "French";
}

if ($customer_flag=='1') {
include 'inc/menu.php';

?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> <?= gettext("Home"); ?></a> 
    	<a href="#" class="current"><?= gettext("Orders"); ?></a> 
    </div>
  </div>
  <div class='content-left'>
	  <div class="container-fluid">
	    <div class="row-fluid">
		  <div class="buttons"> 
		      <a href="customer_ordersCal.php" class="btn btn-inverse btn-mini"><i class="icon-calendar icon-white"></i>  <?= gettext("Calendar View"); ?></a>
		  	 <a href="?lang=en" style="float: right">English</a>
	    	<a href="?lang=fr" style="float: right">Français|</a> 
		  </div>
	  	</div>
	  </div>
	  <div class="container-fluid">
	    <div class="row-fluid">
	      <div class="span12">
	      <div class="widget-box">
	          <div class="widget-title"> <span class="icon"><i class="icon-th-list"></i></span>
	            <h5> <?= gettext("Original Orders: List View"); ?></h5>
	          </div>
	          <div class="widget-content nopadding">
		<?php 
		
		$sql = "SELECT * FROM form_completion WHERE customer_id=".$user_id;
		
		$result = $conn->query($sql);
		echo "<table id='table-orders' class='table table-bordered data-table'>";
		echo "<thead><tr>";
		echo "<th>NFF</th><th>".gettext("Name")."</th><th>".gettext("Date")."</th><th>".gettext("Points")."</th>
				<th>".gettext("Price")."</th><th>".gettext("Next Delivery")."</th><th>".gettext("Representative")."</th>
				<th>".gettext("Status")."</th><th></th><th></th><th></th><th></th>";
		echo "</tr></thead><tbody>";
		
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
			$result2 = $conn->query($sql2);
			$row2 = $result2->fetch_assoc();
			$status = "Completed";
			$editText = "<a class='modify-button' href='order/edit.php?id=$row[id]&edit=yes&uid=$row[customer_id]' title='Edit Order'><i class='fa fa-edit'></i> ".gettext("Modify Order")."</a>";
			$editText = $row['deliver3']==='0' ? $editText : '';
			if ($row['status'] === "0")
			{
				$status = "<span style='color:#ee5f5b'>".gettext("Pending Review")."</span>";
				$editText = "<a href='#' onclick='alert(\"Cannot Edit Order. Order has not been reviewed by Administration yet.\")' title='Cannot Edit. Wait for Approval.'><i class='fa fa-edit'></i></a>";
			}
			$sql3 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
			$result3 = $conn->query($sql3);
			$row3 = $result3->fetch_assoc();
			if ($row3['form_id'] != ''){
				$status = "<span style='color:#f89406'>".gettext("Modified")."</span>";
				$editText = "";
			}
			
				$nextFlagged=false;
				
				$nextdate = $row['conditions_firstdeliverydate'];
				$append = " (<b>1</b>)";
				
				if(strtotime($nextdate) < strtotime('now') ) {
					if ($row['deliver1'] == '1') {
						$nextdate = $row['conditions_seconddeliverydate'];
						$append = " (<b>2</b>)";
					}
					else {
						$nextFlagged=true;
					}
				}
				if(strtotime($nextdate) < strtotime('now') ) {
					if ($row['deliver1'] == '1' && $row['deliver2'] == '1') {
						$nextdate = $row['conditions_thirddeliverydate'];
						$append = " (<b>3</b>)";
					}
					else {
						$nextFlagged=true;
					}
				}
			$nextdate .= $append;
			$nextdate  = $nextFlagged==true?"<span style='color:#ee5f5b'>".$nextdate."<span>":$nextdate;
			
			echo "<tr><td>$row2[nff]</td>";
			echo "<td>$row2[firstname] $row2[lastname]</td><td>$row[signature_date]</td><td>$row[total_points]</td><td>$row[price]</td><td>$nextdate</td><td>".
							"$row[signature_merchant_name]</td><td>$status</td>".
						//	<td><a href='edit.php?id=$row[id]' title='Customer Edit'><i class='fa fa-edit'></i></a></td>	// For now we don't need to handle the customer edit
						    "<td><a class='view-button' title='View Contract' href='order/contract.php?id=$row[id]&uid=$row[customer_id]&edited=yes'><i class='fa fa-search'></i> ".gettext("View Contract")."</a></td>".
							"<td><a class='view-button' data-toggle='modal' title='View Order' href='#orig_conf$row[id]'><i class='fa fa-search'></i> ".gettext("View Original")."</a></td>".
							"<td><a class='download-button' title='Download Contract' target='_blank' href='/order/contracts/NFCT_".$row['id'].".pdf'><i class='fa fa-download'></i> ".gettext("Download")."</a></td>
							 <td>$editText</td>";
			echo "</tr>";
		}
		echo "</tbody></table></div>";
		
		?>
			</div>
	        </div>
	        
	        <?php 
	        $sql = "SELECT * FROM form_completion WHERE customer_id=".$user_id;
	        $result = $conn->query($sql);
	        $hasUpdates = false;
	        
	        while ($row = $result->fetch_assoc())
	        {
		        $sql3 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
		        $result3 = $conn->query($sql3);
		        $row3 = $result3->fetch_assoc();
		        if ($row3['form_id']){
		        	$hasUpdates = true;
		        }
	        }
	        
	        if ($hasUpdates) {
	        ?>
	        
	        <div class="widget-box">
	          <div class="widget-title"> <span class="icon"><i class="icon-th-list"></i></span>
	            <h5> <?= gettext("Modified Orders: List View"); ?></h5>
	          </div>
	          <div class="widget-content nopadding">
		<?php 
		
		$sql = "SELECT * FROM form_completion WHERE customer_id=".$user_id;
		$result = $conn->query($sql);
		
		echo "<table id='table-orders' class='table table-bordered data-table'>";
		echo "<thead><tr>";
		echo "<th>NFF</th><th>".gettext("Name")."</th><th>".gettext("Date")."</th>
				<th>".gettext("Points")."</th><th>".gettext("Price")."</th>
				<th>".gettext("Next Delivery")."</th><th>".gettext("Representative")."</th>
			<th>".gettext("Status")."</th><th></th><th></th>";
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
				$status = "<span style='color:#62c462'>Approved</span>";
				$editText = "";
				if ($row['edited_status'] === "0")
				{
					$status = "<span style='color:#ee5f5b'>".gettext("Pending Approval")."</span>";
				}
				$editText = "<a class='modify-button' href='order/edit.php?id=$row[id]&edit=yes&edited=yes&uid=$row[customer_id]' title='Edit'><i class='fa fa-edit'></i> ".gettext("Modify Order")."</a>";
				$nextFlagged=false;
				
				
				$nextdate = $row['conditions_firstdeliverydate'];
				$append = " (<b>1</b>)";
				
				if(strtotime($nextdate) < strtotime('now') ) {
					if ($row['deliver1'] == '1') {
						$nextdate = $row['conditions_seconddeliverydate'];
						$append = " (<b>2</b>)";
					}
					else {
						$nextFlagged=true;
					}
				}
				if(strtotime($nextdate) < strtotime('now') ) {
					if ($row['deliver1'] == '1' && $row['deliver2'] == '1') {
						$nextdate = $row['conditions_thirddeliverydate'];
						$append = " (<b>3</b>)";
					}
					else {
						$nextFlagged=true;
					}
				}
				$nextdate .= $append;
				$nextdate  = $nextFlagged==true?"<span style='color:#ee5f5b'>".$nextdate."<span>":$nextdate;
				
		// 		$edited = $row['edited_points'] != 0 ? "<i style='color: red; font-weight: bold;'>FORM EDITED</i>": "";
				$edited = "";	// For now we don't need to handle the customer edit
				$editText = $row['deliver3']==='0' ? $editText : '';
				
				if ($row['allow_modification'] == '0' && $row['edited_status'] == "1") {
				    $editText = "";         
				}
				
				echo "<tr><td>$row2[nff]</td>";
				echo "<td>$row2[firstname] $row2[lastname]</td><td>$row[signature_date]</td><td>$row[edited_points]</td><td>$row[edited_price]</td><td>$nextdate</td><td>".
								"$row[signature_merchant_name]</td><td>$status</td>".
							//	<td><a href='edit.php?id=$row[id]' title='Customer Edit'><i class='fa fa-edit'></i></a></td>	// For now we don't need to handle the customer edit
								"<td><a class='view-button' data-toggle='modal' title='View Order' href='#conf$row[id]'><i class='fa fa-search'></i> ".gettext("View Order")."</a></td>
								<td>$editText</td>";
				echo "</tr>";
			}
		}
		echo "</tbody></table></div>";
		
		?>
			</div>
	        </div>
	        
	        <?php } ?>
	        
	      </div>
	    </div>
	  </div>
	</div>
  	<div class="promobanner">
	</div>
</div>

<?php 
$sql = "SELECT * FROM form_completion WHERE customer_id=".$user_id;
generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, 0, 1);
generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, 0, 0);
?>


<script>
$(document).ready(function(){
	if (getCookie("openmenu") != "yes") {
		document.getElementById("content").classList.add("expand-content");
		document.getElementById("sidebar").children[1].classList.add("collapse-menu");
		document.getElementById("header").children[0].style.display = "none";
		createCookie("openmenu", "no", 365);
	}
});	
</script>

<!-- footer -->
<?php
include 'inc/footer.php';
?>

<?php 
}
else {
	header("Location: orders.php");
}
?>
