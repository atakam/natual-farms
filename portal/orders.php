<script type="text/javsacript">
    //Set the cursor ASAP to "Wait"
    document.body.style.cursor='wait';

    //When the window has finished loading, set it back to default...
    window.onload=function(){document.body.style.cursor='default';}
</script>
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
    	<a href="#" class="current">Orders</a> 
    </div>
  </div>
  
  <div class="container-fluid">
  	<?php 
  	if ($delivery_flag=='0' && $supplier_flag=='0') {
		$pending = 0;
		$sql = "SELECT * FROM form_completion WHERE edited_status=0";
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$sql2 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
			$result2 = $conn->query($sql2);
			while($row2 = $result2->fetch_assoc())
			{
				$pending++;
				break;
			}
		}
		if ($pending > 0){
			$msg = '<div class="alert alert-error">'.
					'<button class="close" data-dismiss="alert">×</button>'.
					'<strong>Warning!</strong> You have '.$pending.' pending modified orders! <a href="modifiedorders.php">Verify</a> them now! </div>';
			echo $msg;
		}
	}
		
	?>
    <div class="row-fluid">
	  <div class="buttons"> 
	      
	      <?php if ($delivery_flag=='0' && $supplier_flag=='0') {?>
	      <a href="ordersCal.php" class="btn btn-inverse btn-mini"><i class="icon-calendar icon-white"></i> Calendar View</a>
	      <div style="float: right;border: 1px solid #fff;">
		      <a href="#" id="openlegend" onclick="showHelp()" style="float: right"><i class="fa fa-question-circle"></i> HELP</a>
		      <div id="closelegend" style="display: none;"><a style="float: right" href="#" onclick="closeHelp()"><i class="fa fa-times"></i> CLOSE</a></div>
		      <table class="legend" id="legend" style="display: none">
		      	<tr><td><i class='fa fa-phone'></i></td><td>Phone Number</td><td>CC</td><td>Credit Card</td><td><i class='fa fa-star star-edit'></i></td><td>Edit orders modified by customer</td><td><div class='dot edit'></div></td><td>Edit most recent contract version</td></tr>
		      	<tr><td><i class='fa fa-calendar'></i></td><td>Customer Since date</td><td>PP</td><td>Preauthorized Payment</td><td>View most recent contract version</td><td><div class='dot view2'></div></td><td>View original versions</td></tr>
		      	<tr><td><i class='fa fa-volume-control-phone' style='color:#00ffa5'></i></td><td>Confirmed Order</td><td>CQ</td><td>Cash or Cheque</td><td><div class='dot send'></div></td><td>Resend initial emails</td><td><div class='dot delete'></div></td><td>Delete contract</td></tr>
		      	<tr><td><i class='fa fa-volume-control-phone' style='color:#08c'></i></td><td>Delivered Order</td><td>N/A</td><td>Not Applicable</td></tr>
		      </table>
	      </div>
	      <?php }else{?>
	      <a href="staffordersCal.php" class="btn btn-inverse btn-mini"><i class="icon-calendar icon-white"></i> Calendar View</a>
	      <?php }?>
	      
	  </div>
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th-list"></i></span>
          
          	<?php 
              	$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
              	if ($admin_flag=='1' || $delivery_flag == 1 || $supplier_flag == 1) {
              		$sql = "SELECT * FROM form_completion";
              	}
              	
              	$result = $conn->query($sql);
              	$count = 0;
              	while ($row = $result->fetch_assoc())
              	{
              		$count++;
              	}
            ?>
          
            <h5>Orders: List View</h5> <h6>[ <?= $count ?> - Total Orders]</h6>
            <?php if ($delivery_flag=='0' && $supplier_flag=='0') {?>
            <div class="buttons"> 
            	<a href="order/start.php?lang=en" target="_blank" class="btn btn-inverse btn-mini"><i class="icon-plus icon-white"></i> Add Order</a>
            </div>
            <?php }?>
          </div>
          <div class="widget-content nopadding">
          
              <?php 
              	$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
              	if ($admin_flag=='1' || $delivery_flag == 1 || $supplier_flag == 1) {
              		$sql = "SELECT * FROM form_completion";
              	}
              	
              	$result = $conn->query($sql);
              	
              	
              	echo "<table id='table-orders' class='table table-bordered data-table'>";
              	echo "<thead><tr>";
              	if ($delivery_flag == 1 || $supplier_flag == 1) {
              		echo "<th>NFF</th><th>Customer Name</th><th><i class='fa fa-phone'></i></th><th>First Delivery</th><th>Second Delivery</th><th>Third Delivery</th><th></th>";
              	}
              	else {
              		echo "<th>NFF</th><th>Customer Name</th><th><i class='fa fa-phone'></i></th><th><i class='fa fa-calendar'></i></th><th>Date</th><th>T. Points</th><th>T. Price</th><th>$ Type</th><th>Next Date</th><th>Open</th><th>Status</th><th>Sales Rep</th><th>ID</th>
		  	<th><i class='fa fa-star star-edit'></i></th><th><div class='dot edit'></div></th><th><div class='dot view2'></div></th><th><div class='dot send'></div></th>";
              	}
              	if ($admin_flag == '1'){
              		echo "<th><div class='dot delete'></div></th>";
              	}
              	echo "</tr></thead><tbody>";
              	
              	while ($row = $result->fetch_assoc())
              	{
              		$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
              		$result2 = $conn->query($sql2);
              		$row2 = $result2->fetch_assoc();
              	
              		if($row2['isactive'] == '0')
              		{
              			continue;
              		}
              	
              		$status = "<span style='color: green;'><i class='fa fa-check'></i></span>";
              		if ($row2['nff'] === "")
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
              			$delete = "<td><a href='#' onclick=\"deleteAction('formid', $row[id])\"><i class='fa fa-trash'></i></a></td>";
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
              		else if ($row['edited'] == '1'){
              			$edited = "<i class='fa fa-star' style='color: red;'></i>";
              		}
              		else {
              			$edited = "<i class='fa fa-star'></i>";
              			$editurl2 = "edit.php?id=".$row['id']."&edit=yes&uid=".$row['customer_id'];
              			$editurl2 = "order/".$editurl2;
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
              	
              	
              		$nextFlagged = false;
              		$nextdate = $row['conditions_firstdeliverydate'];
              		$nextdate2 = $row['conditions_firstdeliverydate'];
              		$append = " (<b>1</b>)";
              	
              		$color = "inherit";
              		$confirmed = false;
              		$delivered = false;
              		if ($row['notconfirm1'] == '1'){
              			$color = '#ee5f5b';
              		}if ($row['confirm1'] == '1'){
              			$color = '#00ffa5';
              			$confirmed = true;
              		}if($row['deliver1']){
              			$color = '#08c';
              			$delivered = true;
              		}
              		$nextdateId = 'orders'.$row['id'].'conditions_firstdeliverydate';
              	
              		if(strtotime($nextdate) <= strtotime('now') ) {
              				
              			if ($row['deliver1'] == '1') {
              				$nextdate = $row['conditions_seconddeliverydate'];
              				$nextdate2 = $row['conditions_seconddeliverydate'];
              				$append = " (<b>2</b>)";
              				$confirmed = false;
              				$delivered = false;
              				$color = "inherit";
              				if ($row['notconfirm2'] == '1'){
              					$color = '#ee5f5b';
              				}if ($row['confirm2'] == '1'){
              					$color = '#00ffa5';
              					$confirmed = true;
              				}if($row['deliver2']){
              					$color = '#08c';
              					$delivered = true;
              				}
              				$nextdateId = 'orders'.$row['id'].'conditions_seconddeliverydate';
              			}
              			else {
              				$nextFlagged = true;
              			}
              		}
              		if(strtotime($nextdate) <= strtotime('now') ) {
              			if ($row['deliver1'] == '1' && $row['deliver2'] == '1') {
              				$nextdate = $row['conditions_thirddeliverydate'];
              				$nextdate2 = $row['conditions_thirddeliverydate'];
              				$append = " (<b>3</b>)";
              				$confirmed = false;
              				$delivered = false;
              				$color = "inherit";
              				if ($row['notconfirm3'] == '1'){
              					$color = '#ee5f5b';
              				}if ($row['confirm3'] == '1'){
              					$color = '#00ffa5';
              					$confirmed = true;
              				}if($row['deliver3']){
              					$color = '#08c';
              					$delivered = true;
              				}
              				$nextdateId = 'orders'.$row['id'].'conditions_thirddeliverydate';
              			}
              			else {
              				$nextFlagged = true;
              			}
              		}
              	
              		$color1 = $row['conditions_firstdeliverydate']==$nextdate?"style=background-color:#62c462":"";
              		$color2 = $row['conditions_seconddeliverydate']==$nextdate?"style=background-color:#62c462":"";
              		$color3 = $row['conditions_thirddeliverydate']==$nextdate?"style=background-color:#62c462":"";
              	
              		if ($delivery_flag == 1 || $supplier_flag == 1) {
              			$confirm = false;
              			if ($row['confirm1'] == '1' && $row['deliver1'] != '1') {
              				$confirm = true;
              				$color1 = "style=background-color:#62c462";
              			}if ($row['confirm2'] == '1' && $row['deliver2'] != '1') {
              				$confirm = true;
              				$color2 = "style=background-color:#62c462";
              			}if ($row['confirm3'] == '1' && $row['deliver3'] != '1') {
              				$confirm = true;
              				$color3 = "style=background-color:#62c462";
              			}
              				
              			if ($confirm == false){
              				continue;
              			}
              		}
              	
              		$nextdate .= $append;
              		$nextdate  = $nextFlagged==true?"<span style='color:#ee5f5b'>".$nextdate."<span>":$nextdate;
              	
              		$isedit = "";
              		$sql3 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
              		$result3 = $conn->query($sql3);
              		$row3 = $result3->fetch_assoc();
              		$canEdit = false;
              		if ($row3['form_id'] != ''){
              			if ($row['edited_status'] == '1')
              			{
              				$isedit = "&edited=yes";
              				$canEdit = true;
              			}
              		}
              		if ($admin_flag == 1){
              			$canEdit = true;
              		}
              		$editOrNot = $canEdit == true ?
              		"<td><a target='_blanck' href='order/".$editurl."id=$row[id]$isedit&rid=$row[representative_id]' title='Edit'><i class='fa fa-edit'></i></a></td>":
              		"<td><a href='#' onclick='alert(\"Cannot edit order when Pending Approval.\")' title='Edit'><i class='fa fa-edit'></i></a></td>";
              	
              		$confirmedImg = "";
              		if ($confirmed == true) {
              			$confirmedImg = "<span class='confirm-order'>CONFIRMED</span>";
              		}
              		if ($row['deliver3'] === '1') {
              			$from = strtotime($nextdate2);
              			$today = time();
              			$difference = $today - $from;
              			$dd =  floor($difference / 86400);  // (60 * 60 * 24)
              			$confirmedImg = "<a href='customer.php?id=$row2[id]' class='expired-order-1'>3rd Del ($dd)</a>";
              			
              			if ($dd >= 90) {
              				$confirmedImg = "<a href='customer.php?id=$row2[id]' class='expired-order-2'>EXPIRED</a>";
              			}
              		}
              		
              		if ($delivery_flag == 1 || $supplier_flag == 1) {
              			echo "<tr><td>$row2[nff]</td>";
              			echo "<td>$row2[firstname] $row2[lastname]</td>
              			<td>
              			<span class='popup' onclick='popuptext($row2[phone])'>
              				<i class='fa fa-phone' ></i>
              				<span class='popuptext' id='$row2[phone]'>$row2[phone]</span>
						</span>
              			</td>
              			<td $color1>$row[conditions_firstdeliverydate]</td>
              			<td $color2>$row[conditions_seconddeliverydate]</td>
              			<td $color3>$row[conditions_thirddeliverydate]</td>
              			<td><a href='#conf$row[id]' data-toggle='modal'><i class='fa fa-list' style='color:$color'></i></a></td>";
              		}
              		else {
              			$dateSince = $row2['dateSince'];
              			if ($dateSince == "0000-00-00"){
              				$dateSince = $row['signature_date'];
              			}
              			$dropdown = '<span class="dropdown">
									  <i class="i-button">VIEW O/C</i>
									  <span class="dropdown-content">
									    <a href="order/contract.php?id='.$row['id'].$isedit.'&rid='.$row['representative_id'].'">Original Contract</a>
									    <a href="#orig_conf'.$row['id'].'" data-toggle="modal">Original Order</a>
									  </span>
									</span>';
              			
              			$orig = '<a href="order/contract.php?id='.$row['id'].$isedit.'&rid='.$row['representative_id'].'">O. Contract</a> |
									    <a href="#orig_conf'.$row['id'].'" data-toggle="modal">O. Order</a>';
              			
              			
              			$hasUpdates = false;
              			$sql31 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
              			$result31 = $conn->query($sql31);
              			$row31 = $result31->fetch_assoc();
              			if ($row31['form_id']){
              				$hasUpdates = true;
              			}
              			
              			$modalId = "#orig_conf".$row['id'];
              			if ($hasUpdates) {
              				$modalId = "#conf".$row['id'];
              			}
              			
              			$dropdown= "<span class='popup' onclick='popuptext(\"op$row[id]\")'>
			              				<i class='i-button'>VIEW O/C</i>
			              				<span class='popuptext' id='op$row[id]'>$orig</span>
									</span>";
              			echo "<tr><td>$row2[nff]</td>";
              			echo "<td><a href='customer.php?id=".$row2['id']."'>$row2[firstname] $row2[lastname]</a></td>
              			<td>
              			<span class='popup' onclick='popuptext(\"$row2[phone]\")'>
              				<i class='fa fa-phone' ></i>
              				<span class='popuptext' id='$row2[phone]'>$row2[phone]</span>
						</span>
              			</td>
              			<td>
              			<span class='popup' onclick='popuptext(\"$dateSince\")'>
              				<i class='fa fa-calendar' ></i>
              				<span class='popuptext' id='$dateSince'>$dateSince</span>
						</span>
              			</td>
              			<td>$row[signature_date]</td><td>$points</td><td>$ $price</td><td>$type</td><td><span id='$nextdateId'>$nextdate</span></td>
              			<td><a href='$modalId' data-toggle='modal'><span class='open-order'>OPEN</span></a></td>
              			<td>$confirmedImg</td>
              			<td><span id='rep$id' style='float: left'>$representative</span><span id='select$id' style='display:none'>$repSelect</span> $editRep</td><td>$status</td>
              			<td><a href='$editurl2' title='Verify Changes (Admin only)'>$edited</a></td>".
              			//	<td><a href='edit.php?id=$row[id]' title='Customer Edit'><i class='fa fa-edit'></i></a></td>	// For now we don't need to handle the customer edit
              			$editOrNot.
              			"<td>$dropdown</td>
              			<td><a title='Resend Emails' href='order/print.php?id=$row[id]&email=$row2[email]&phone=$row2[phone]&lang=fr&password=(your password)&name=$row2[firstname]$row2[lastname]'><i class='fa fa-envelope'></i></a>
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

<?php 

$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
//if ($admin_flag=='1') {
	$sql = "SELECT * FROM form_completion";
//}
$readonly = $delivery_flag == 1 ? "disabled readonly" : "";

//generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, 0);
//generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, 1);
?>
<div id="generatedModals">
</div>

<script>
function changeRep(lThis, id){
	var rf = document.getElementById('rep'+id);
	rf.style.display = "none";

	var ef = document.getElementById('edit'+id);
	ef.style.display = "none";
	
	var sf = document.getElementById('save'+id);
	sf.style.display = "block";
	var slf = document.getElementById('select'+id);
	slf.style.display = "block";
}
function saveRep(lThis, id){
	var rf = document.getElementById('rep'+id);
	rf.style.display = "block";

	var ef = document.getElementById('edit'+id);
	ef.style.display = "block";
	
	var sf = document.getElementById('save'+id);
	sf.style.display = "none";
	var slf = document.getElementById('select'+id);
	slf.style.display = "none";

	var select = document.getElementById(id);
	var rid = select.options[select.selectedIndex].value;

	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
           if (xmlhttp.status == 200) {
        	   document.getElementById('rep'+id).innerHTML = xmlhttp.responseText;
           }
           else{
              alert('There was an error updating representative');
           }
        }
    };

    xmlhttp.open("GET", "actions/changerep.php?cid=" + id + "&repid=" + rid, true);
    xmlhttp.send();
}


        function changeDate(lThis, id){
        	var rf = document.getElementById('date'+id);
        	rf.style.display = "none";

        	var ef = document.getElementById('edit'+id);
        	ef.style.display = "none";
        	
        	var sf = document.getElementById('save'+id);
        	sf.style.display = "block";
        	var slf = document.getElementById('select'+id);
        	slf.style.display = "block";
        }
        function saveDate(lThis, id, del, index){
        	var rf = document.getElementById('date'+id+del);
        	rf.style.display = "block";

        	var ef = document.getElementById('edit'+id+del);
        	ef.style.display = "block";
        	
        	var sf = document.getElementById('save'+id+del);
        	sf.style.display = "none";
        	var slf = document.getElementById('select'+id+del);
        	slf.style.display = "none";

        	var val = document.getElementById(id+del).value;

        	var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
                   if (xmlhttp.status == 200) {
                	   document.getElementById('date'+id+del).innerHTML = xmlhttp.responseText;
                	   del = del.replace(/m\s*$/, "");
                	   document.getElementById('orders'+id+del).innerHTML = xmlhttp.responseText + " (<b>" + index + "</b>)";
                   }
                   else{
                      alert('There was an error updating representative');
                   }
                }
            };

            xmlhttp.open("GET", "actions/changedate.php?fid=" + id + "&datetag=" + del + "&date=" + val, true);
            xmlhttp.send();
        }
        function toggleAllow(id, lthis) {
            if (lthis.checked)
            {
               value = 1;
            }
            else {
               value = 0;
            }
        	$.ajax({
                type: "POST",
                url: "actions/updateAllow.php",
                async: true,
                data: "fid="+id+"&value="+value,
                success: function (msg) {
                    if (msg == "1" || msg == "0")
                    	alert('Customer access changed!');
                    else
                    	alert('Error!');
                }
            });
        }

        function showHelp(){
			document.getElementById("legend").style.display = "block";
			document.getElementById("closelegend").style.display = "block";
			document.getElementById("openlegend").style.display = "none";
        }

        function closeHelp(){
			document.getElementById("legend").style.display = "none";
			document.getElementById("closelegend").style.display = "none";
			document.getElementById("openlegend").style.display = "block";
        }

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
               if (xmlhttp.status == 200) {
            	   document.getElementById('generatedModals').innerHTML = xmlhttp.responseText;
               }
            }
        };

        xmlhttp.open("GET", "inc/ordersOpenView.php", true);
        xmlhttp.send();
</script>

<!-- footer -->
<?php
include 'inc/footer.php';
?>

<?php 
}
else {
    echo "<script>window.location.href = 'customer_orders.php';</script>";
}
?>

