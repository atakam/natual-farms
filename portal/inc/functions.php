<?php
function baseurl(){
	return sprintf(
			"%s://%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME']
			);
}

function createTable($row, $conn, $t, $admin, $supplier, $orig)
{
	$pointVH = $admin == 1 || $supplier ==1 ? "<th>Point Value</th>" : "";
	$pointTH = $admin == 1 || $supplier ==1 ? "<th>Total Points</th>" : "";
	$pointSH = $admin == 1 || $supplier ==1 ? "<th>Supplier Price</th>" : "";
	echo '<table style="font-size:small" class="table table-bordered">';
	echo '<thead><tr><th>Product Name</th><th>Packaging</th>'.$pointVH.'<th>Quantity</th>'.$pointTH.$pointSH.'</tr></thead>';
	
	$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
	//echo $sqlOrd . '<br><br>';
	
	if ($orig == 0){
		$sqlOrd = "SELECT * FROM orders_updates WHERE form_id=".$row["id"];
	} else if ($orig == 1) {
		$sqlOrd = "SELECT * FROM orders WHERE form_id=".$row["id"];
	}
	$resultsOrd = $conn->query($sqlOrd);

	$totalPoints = 0;
	$totalPrice = 0;

	while ($rowOrd = $resultsOrd->fetch_assoc())
	{
		$sqlPtl = "SELECT * FROM products_details WHERE id=".$rowOrd['product_details_id']." LIMIT 1";
		//echo $sqlPtl . '<br><br>';
		$resultsPtl = $conn->query($sqlPtl);
		$rowPtl = $resultsPtl->fetch_assoc();

		$sqlPtl = "SELECT * FROM product_packaging WHERE id=".$rowPtl['packaging_id']." LIMIT 1";
		//echo $sqlPtl . '<br><br>';
		$resultsPtl2 = $conn->query($sqlPtl);
		$rowPtl2 = $resultsPtl2->fetch_assoc();

		$pointVH = $admin == 1 || $supplier ==1 ? "<td>".$rowPtl['point']."</td>" : "";
		$tp = ((int)$rowOrd["quantity".$t]) * ((int)$rowPtl['point']);
		$totalPoints = $totalPoints + $tp;

		$pointTH = $admin == 1 || $supplier ==1 ? "<td class='pointsColumn'>".$tp."</td>" : "";
		$tp = ((int)$rowOrd["quantity".$t]) * ((float)$rowPtl['purchase_price']);
		$tp = number_format((float)$tp, 2, '.', '');
		$totalPrice = $totalPrice + $tp;
		$pointSH = $admin == 1 || $supplier ==1 ? "<td class='priceColumn'>$ ".$tp."</td>" : "";

		$sqlPtl = "SELECT * FROM products WHERE id=".$rowPtl['product_id']." LIMIT 1";
		$resultsPtl3 = $conn->query($sqlPtl);
		$rowPtl3 = $resultsPtl3->fetch_assoc();
		echo "<tr>";
		echo "<td>". $rowPtl['code'] . " - " .$rowPtl3["name_fr"]." / ".$rowPtl3["name_en"]."</td>";
		echo "<td>".$rowPtl2["type"]." : ".$rowPtl2["quantity"]."</td>";
		echo $pointVH;
		echo "<td>".$rowOrd["quantity".$t]."</td>";
		echo $pointTH.$pointSH;
		echo "</tr>";
	}
	$totalPrice = number_format((float)$totalPrice, 2, '.', '');
	$summary = $admin == 1 || $supplier ==1 ? "<tr><th colspan='4'>TOTAL</th><th style='background-color: #d3c6de'><b>".$totalPoints."</b></th><th style='background-color: #d4ce77'><b>$ ".$totalPrice."</b></th></tr>" : "";
	echo $summary;

	echo '</table>';

	return array($totalPoints, $totalPrice);
}

function getSupplierPrice($conn, $sql)
{
	$result = $conn->query($sql);
	$total = 0;
	while ($row = $result->fetch_assoc())
	{
		$pdtdt = $row['product_details_id'];
		$qty = ((int)$row['quantity1']) + ((int)$row['quantity2']) + ((int)$row['quantity3']);
		
		$sql2 = "SELECT * FROM products_details WHERE id=".$pdtdt." LIMIT 1";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();
		
		$price = (float)$row2['purchase_price'];
		
		$price = $price * $qty;
		
		$total = $total + $price;
	}
	
	return $total;
}

function generateOrderModal($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, $orig = 0, $display = false, $autoOrig = false)
{
	$result = $conn->query($sql);
	while ($row = $result->fetch_assoc())
	{
		generateOrderModalSpecific($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, $orig, $row, $display, $autoOrig);
	}
}

function generateOrderModalSpecific($conn, $sql, $admin_flag, $delivery_flag, $supplier_flag, $orig, $row, $display, $autoOrig)
{

	$nextdate    = $row['conditions_firstdeliverydate'];
	$nextFlagged = false;
	$del = "First";
	$delN = 1;
	if(strtotime($nextdate) <= strtotime('now') ) {
		if ($row['deliver1'] == '1')
		{
			$nextdate = $row['conditions_seconddeliverydate'];
			$del = "Second";
			$delN = 2;
		}
		else
		{
			$nextFlagged = true;
		}
	}
	if(strtotime($nextdate) <= strtotime('now') ) {
		if ($row['deliver1'] == '1' && $row['deliver2'] == '1')
		{
			$nextdate = $row['conditions_thirddeliverydate'];
			$del = "Third";
			$delN = 3;
		}
		else
		{
			$nextFlagged = true;
		}
	}
	
	$checked1 = $row['notconfirm'.$delN]=="1"?"checked":"";
	$checked2 = $row['confirm'.$delN]=="1"?"checked":"";
	$checked3 = $row['deliver'.$delN]=="1"?"checked":"";
	
	$style = $display ? '' : 'style="float:left"';
	
	$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();
	
	$firstline = '<div id="conf'.$row['id'].'" class="modal hide">';
	$word = "";
	$pending = "";
	$idprfx = '';
	if ($autoOrig === true) {
	    $sql3 = "SELECT * FROM orders_updates WHERE form_id=".$row['id'];
		$result3 = $conn->query($sql3);
		$row3 = $result3->fetch_assoc();
		if ($row3['form_id'] != ''){
            $orig = 0;
		} else {
		    $orig = 1;
		}
	}
	if ($orig == 1){
		$firstline = '<div id="orig_conf'.$row['id'].'" class="modal hide">';
		$word = "Original ";
	}else if ($orig == 0){
		$word = "Modified ";
		$idprfx = 'm';
		if ($row['edited_status']=="0"){
			$pending = "<span style='color:#ee5f5b'>(".gettext("Pending Approval").")</span>";
		}
	}
	$style1 = "";
	if (strtotime($row['conditions_firstdeliverydate']) < time()) {
		$style1 = "style='color:#ee5f5b'";
	}
	
	echo $firstline;
	echo '<div class="modal-header">';
	if (!$display) {
	echo '<button data-dismiss="modal" class="close" type="button">×</button>';
	}
	echo '<h3>'.$word.'Orders for: '.$row2['firstname'].' '.$row2['lastname'].' '.$pending;
	if (!$display) {
		echo '<a style="float: right; margin-bottom: 10px; margin-right: 10px" href="#" title="Print" onclick="printDiv(\'f'.$row['id'].$idprfx.'\')"><i class="fa fa-print"></i> Print</a>';
	}
	echo ' </h3></div>';
	
	echo '<div class="modal-body" id="f'.$row['id'].$idprfx.'">';
	echo '<div class="open" id="fg'.$row['id'].$idprfx.'">';
	
	$checked1 = $row['notconfirm1']=="1"?"checked":"";
	$checked2 = $row['confirm1']=="1"?"checked":"";
	$checked3 = $row['deliver1']=="1"?"checked":"";
	
	if ($admin_flag == 1 && !$display) {
		$allowed = $row['allowAccess'] == '1'?'checked':'';
		echo '<h5 style="float:left">Allow customer to edit future orders: <input type="checkbox" onclick="toggleAllow('.$row['id'] . ', this)" '.$allowed.'/></h5><br><br><div style="clear:both"></div>';
	}
	
	$dateSelect = "<input type='date' style='width:80%' id='$row[id]conditions_firstdeliverydate$idprfx' value='$row[conditions_firstdeliverydate]'>";
	$dateSelect .= "<span id='save".$row['id']."conditions_firstdeliverydate$idprfx' style='display:none; float:right'><a href='#' onclick='saveDate(this,\"".$row['id']."\", \"conditions_firstdeliverydate$idprfx\", 1)' style='float:right'><i class='fa fa-save'></i></a></span>";
	
	//1
	echo '<h4 '.$style.'>First Delivery: </h4><h5 '.$style.'><span id="date'.$row['id'].'conditions_firstdeliverydate'.$idprfx.'" '.$style1.'>'. $row['conditions_firstdeliverydate'] . '</span>';
	
	if (($delivery_flag == 1 || $admin_flag == 1) && !$display) {
		echo "<span id='select".$row['id']."conditions_firstdeliverydate$idprfx' style='display:none'>$dateSelect</span><span id='edit$row[id]conditions_firstdeliverydate$idprfx'>
		<a href='#' onclick='changeDate(this,\"".$row['id']."conditions_firstdeliverydate$idprfx\")' style='float:right'> <i class='fa fa-pencil' style='padding-left:10px'></i></a></span>";
	}
	echo "</h5>";
	if (($delivery_flag == 1 || $admin_flag == 1) && !$display) {
		echo '<form method="post"  action="actions/actionconfirm.php">';
		echo '<table style="width:100%;font-size:small"><tr>
						<td>Not Confirmed: <input type="checkbox" name="notconfirmed" '.$checked1.'/>
								<input type="hidden" name="id" value="'.$row['id'].'"/>
			      				<input type="hidden" name="index" value="1"/>
			      				<input type="hidden" name="nextdelivery" value="'.$row['conditions_firstdeliverydate'].'"/>
			      				<input type="hidden" name="email" value="'.$row2['email'].'"/>
			      				<input type="hidden" name="name" value="'.$row2['firstname']." ".$row2['lastname'].'"/>
			      		</td>
						<td>Confirmed: <input type="checkbox" name="confirmed" '.$checked2.' /></td>
						<td>Delivered: <input type="checkbox" name="delivered" '.$checked3.'/></td>
			      		<td>Send Email: <input type="checkbox" name="sendemail" /></td>
						<td><input type="submit"/></td>
				</tr></table><br>';
		if ($delivery_flag == 1)
		{
			echo '<input type="hidden" name="notconfirmed" value="on"/>';
			echo '<input type="hidden" name="confirmed" value="on"/>';
		}
		echo '</form>';
	}
	
	//create order table
	$arr1 = createTable($row, $conn, 1, $admin_flag, $supplier_flag, $orig);
	
	$checked1 = $row['notconfirm2']=="1"?"checked":"";
	$checked2 = $row['confirm2']=="1"?"checked":"";
	$checked3 = $row['deliver2']=="1"?"checked":"";
	
	$dateSelect = "<input type='date' style='width:80%' id='$row[id]conditions_seconddeliverydate$idprfx' value='$row[conditions_seconddeliverydate]'>";
	$dateSelect .= "<span id='save".$row['id']."conditions_seconddeliverydate$idprfx' style='display:none; float:right'><a href='#' onclick='saveDate(this,\"".$row['id']."\", \"conditions_seconddeliverydate$idprfx\", 2)' style='float:right'><i class='fa fa-save'></i></a></span>";
	
	//2
	echo '<h4 '.$style.'>Second Delivery: </h4><h5 '.$style.'><span id="date'.$row['id'].'conditions_seconddeliverydate'.$idprfx.'">'. $row['conditions_seconddeliverydate'] . '</span>';
	if (($delivery_flag == 1 || $admin_flag == 1) && !$display) {
		echo "<span id='select".$row['id']."conditions_seconddeliverydate$idprfx' style='display:none'>$dateSelect</span><span id='edit$row[id]conditions_seconddeliverydate$idprfx'>
		<a href='#' onclick='changeDate(this,\"".$row['id']."conditions_seconddeliverydate$idprfx\")' style='float:right'> <i class='fa fa-pencil' style='padding-left:10px'></i></a></span>";
	}
	echo "</h5>";
	if (($delivery_flag == 1 || $admin_flag == 1) && !$display) {
		echo '<form method="post"  action="actions/actionconfirm.php">';
		echo '<table style="width:100%;font-size:small"><tr>
						<td>Not Confirmed: <input type="checkbox" name="notconfirmed" '.$checked1.' />
								<input type="hidden" name="id" value="'.$row['id'].'"/>
			      				<input type="hidden" name="index" value="2"/>
			      				<input type="hidden" name="nextdelivery" value="'.$row['conditions_seconddeliverydate'].'"/>
			      				<input type="hidden" name="email" value="'.$row2['email'].'"/>
			      				<input type="hidden" name="name" value="'.$row2['firstname']." ".$row2['lastname'].'"/>
			      		</td>
						<td>Confirmed: <input type="checkbox" name="confirmed" '.$checked2.' /></td>
						<td>Delivered: <input type="checkbox" name="delivered" '.$checked3.'/></td>
			      		<td>Send Email: <input type="checkbox" name="sendemail" /></td>
						<td><input type="submit"/></td>
				</tr></table><br>';
		if ($delivery_flag == 1)
		{
			echo '<input type="hidden" name="notconfirmed" value="on"/>';
			echo '<input type="hidden" name="confirmed" value="on"/>';
		}
		echo '</form>';
	}
	
	//create order table
	$arr2 = createTable($row, $conn, 2, $admin_flag, $supplier_flag, $orig);
	
	$checked1 = $row['notconfirm3']=="1"?"checked":"";
	$checked2 = $row['confirm3']=="1"?"checked":"";
	$checked3 = $row['deliver3']=="1"?"checked":"";
	
	$dateSelect = "<input type='date' style='width:80%' id='$row[id]conditions_thirddeliverydate$idprfx' value='$row[conditions_thirddeliverydate]'>";
	$dateSelect .= "<span id='save".$row['id']."conditions_thirddeliverydate$idprfx' style='display:none; float:right'><a href='#' onclick='saveDate(this,\"".$row['id']."\", \"conditions_thirddeliverydate$idprfx\", 3)' style='float:right'><i class='fa fa-save'></i></a></span>";
	
	//3
	echo '<h4 '.$style.'>Third Delivery: </h4><h5 '.$style.'><span id="date'.$row['id'].'conditions_thirddeliverydate'.$idprfx.'">'. $row['conditions_thirddeliverydate'] . '</span>';
	if (($delivery_flag == 1 || $admin_flag == 1) && !$display) {
		echo "<span id='select".$row['id']."conditions_thirddeliverydate$idprfx' style='display:none'>$dateSelect</span><span id='edit$row[id]conditions_thirddeliverydate$idprfx'>
		<a href='#' onclick='changeDate(this,\"".$row['id']."conditions_thirddeliverydate$idprfx\")' style='float:right'> <i class='fa fa-pencil' style='padding-left:10px'></i></a></span>";
	}
	echo "</h5>";
	if (($delivery_flag == 1 || $admin_flag == 1) && !$display) {
		echo '<form method="post"  action="actions/actionconfirm.php">';
		echo '<table style="width:100%;font-size:small"><tr>
						<td>Not Confirmed: <input type="checkbox" name="notconfirmed" '.$checked1.' />
								<input type="hidden" name="id" value="'.$row['id'].'"/>
			      				<input type="hidden" name="index" value="3"/>
			      				<input type="hidden" name="nextdelivery" value="'.$row['conditions_thirddeliverydate'].'"/>
			      				<input type="hidden" name="email" value="'.$row2['email'].'"/>
			      				<input type="hidden" name="name" value="'.$row2['firstname']." ".$row2['lastname'].'"/>
			      		</td>
						<td>Confirmed: <input type="checkbox" name="confirmed" '.$checked2.' /></td>
						<td>Delivered: <input type="checkbox" name="delivered" '.$checked3.'/></td>
			      		<td>Send Email: <input type="checkbox" name="sendemail" /></td>
						<td><input type="submit"/></td>
				</tr></table><br>';
		if ($delivery_flag == 1)
		{
			echo '<input type="hidden" name="notconfirmed" value="on"/>';
			echo '<input type="hidden" name="confirmed" value="on"/>';
		}
		echo '</form>';
	}
	
	//create order table
	$arr3 = createTable($row, $conn, 3, $admin_flag, $supplier_flag, $orig);
	
	if ($admin_flag == 1 || $supplier_flag == 1) {
		echo '<table style="font-size:small" class="table table-bordered">';
		echo '<thead><tr><th>Delivery #</th><th>Total Points</th><th>Total Supplier Price</th></tr></thead>';
		echo '<tr><td>1</td><td class="pointsColumn">'.$arr1[0].'</td><td class="priceColumn">$ '.$arr1[1].'</td></tr>';
		echo '<tr><td>2</td><td class="pointsColumn">'.$arr2[0].'</td><td class="priceColumn">$ '.$arr2[1].'</td></tr>';
		echo '<tr><td>3</td><td class="pointsColumn">'.$arr3[0].'</td><td class="priceColumn">$ '.$arr3[1].'</td></tr>';
		echo '<tr><th>TOTAL</th><th style="background-color: #d3c6de"><b>'.($arr1[0] + $arr2[0] + $arr3[0]).'</b></th><th style="background-color: #d4ce77"><b>$ '.number_format((float)($arr1[1] + $arr2[1] + $arr3[1]), 2, '.', '').'</b></th></tr>';
		echo '</table>';
	}
	
	echo '</div></div></div></div>';
	
}

function export_excel_csv($conn, $sql, $filename)
{
	//echo $sql;
	$rec = $conn->query($sql);
	
	$num_fields = mysqli_num_fields($rec);

	$header = "";
	
	$fields = mysqli_fetch_fields($rec);
	foreach ($fields as $field)  $header .= $field->name."\t";

	while( $row = mysqli_fetch_row( $rec ) )
	{
	    $line = '';
	    foreach( $row as $value )
	    {                                            
	        if ( ( !isset( $value ) ) || ( $value == "" ) )
	        {
	            $value = "\t";
	        }
	        else
	        {
	            $value = str_replace( '"' , '""' , $value );
	            $value = '"' . $value . '"' . "\t";
	        }
	        $line .= $value;
	    }
	    $data .= trim( $line ) . "\n";
	}
	$data = str_replace( "\r" , "" , $data );
	
	if ( $data == "" )
	{
	    $data = "\n(0) Records Found!\n";                        
	}
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$filename.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$data";
}

?>
<script>
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
</script>