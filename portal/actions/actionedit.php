<?PHP
  // form handler
  if($_POST && isset($_POST['fid'])){
  	
  	include '../inc/header.php';
  	require("../phpToPDF/phpToPDF.php");
  	
  	$fid 			= mysqli_real_escape_string($conn, isset($_POST['fid']) ? $_POST['fid'] : "");
  	$edited_points 	= mysqli_real_escape_string($conn, isset($_POST['edited_points']) ? $_POST['edited_points'] : "");
  	$edited_price 	= mysqli_real_escape_string($conn, isset($_POST['edited_price']) ? $_POST['edited_price'] : "");
  	$edited_rebate 	= mysqli_real_escape_string($conn, isset($_POST['edited_rebate']) ? $_POST['edited_rebate'] : "");
  	$edited_deposit = mysqli_real_escape_string($conn, isset($_POST['edited_deposit']) ? $_POST['edited_deposit'] : "");
  	$edited_subtotal= mysqli_real_escape_string($conn, isset($_POST['edited_subtotal']) ? $_POST['edited_subtotal'] : "");
  	$edited_total 	= mysqli_real_escape_string($conn, isset($_POST['edited_total']) ? $_POST['edited_total'] : "");
  	$edited_status 	= mysqli_real_escape_string($conn, isset($_POST['edited_status']) && $_POST['edited_status'] == 'on' ? "1" : "0");
  	$allow_modification = mysqli_real_escape_string($conn, isset($_POST['allow_modification']) && $_POST['allow_modification'] == 'on' ? "1" : "0");
  	$send_email 	= mysqli_real_escape_string($conn, isset($_POST['send_email']) ? $_POST['send_email'] : "0");
  	
  	if($edited_status == '1' && $send_email == 'on') {
  		$mail->addAddress($_POST["email"]);
  		$sqlT = "SELECT * FROM email_templates WHERE id=4 LIMIT 1";
  		$resultT = $conn->query($sqlT);
  		$rowTemp = $resultT->fetch_assoc();
  		
  		$subject = $rowTemp['subject_fr'] . '/' . $rowTemp['subject_en'];
  		$mail->Subject = $subject;
  		
  		$message = $rowTemp['content_fr'] . '<br><br>--------ENGLISH VERSION--------'.$rowTemp['content_en'];
  		$message = str_replace("{customer_phone}", $_POST['phone'], $message);
  		$message = str_replace("{customer_email}", $_POST['email'], $message);
  		$message = str_replace("{customer_nff}", $_POST['formid'], $message);
  		$message = str_replace("{customer_name}", $_POST['name'], $message);
  		
  		$mail->isHTML(true);
  		$mail->Body    = $message;
  		
  		if (!isset($_GET['ajax'])){
  			$mail->send();
  		}
  		
  		if ($customer_flag == '0' && $supplier_flag == '0' && $delivery_flag == '0'){
	  		// Adding Notification
	  		$sql = "INSERT INTO notifications (userid, iscustomer, date, message, isread) VALUES ('$user_id', 0, '".date("Y-m-d")."',
	  				'Updated Order Approved! <a href=\'orders.php\'>View</a>', 0)";
	  		if ($conn->query($sql) === FALSE){
	  			echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
	  			exit();
	  		}
  		}
  	}
  	if ($customer_flag == '1' && !isset($_GET['ajax'])){
  		
  		$sqlT = "SELECT * FROM email_templates WHERE id=3 LIMIT 1";
  		$resultT = $conn->query($sqlT);
  		$rowTemp = $resultT->fetch_assoc();
  		$mail->addAddress($_POST["email"]);
  		
  		$subject = $rowTemp['subject_fr'] . '/' . $rowTemp['subject_en'];
  		$mail->Subject = $subject;
  		
  		$message = $rowTemp['content_fr'] . '<br><br>--------ENGLISH VERSION--------'.$rowTemp['content_en'];
  		$message = str_replace("{customer_phone}", $_POST['phone'], $message);
  		$message = str_replace("{customer_email}", $_POST['email'], $message);
  		$message = str_replace("{customer_nff}", $_POST['formid'], $message);
  		$message = str_replace("{customer_name}", $_POST['name'], $message);
  		
  		$url2 = baseurl().'/order/orderList.php?id='.$fid.'&rid=1&edited=yes&sprint=katchebehsibwosihampomodimandrehnahponteh'; 
  		
  		$timestamp = date("Y-m-d-s",$t);
  		//Set Your Options -- see documentation for all options
        $pdf_options = array(
              "source_type" => 'url',
              "source" => $url2,
              "save_directory" => '/pdfs',
              "file_name" => $_POST['name'].'_'.$timestamp.'pdf',
              "action" => 'view');
    
        //Code to generate PDF file from options above
        phptopdf($pdf_options);
        $mail->addAttachment('/pdfs/'.$_POST['name'].'_'.$timestamp.'pdf');
        
  		$message = str_replace("{order_url}", $url2, $message);
  		
  		$mail->isHTML(true);
  		$mail->Body    = $message;
  		$mail->send();
  		
  		// Adding Notification
  		$sql = "INSERT INTO notifications (userid, iscustomer, date, message, isread) VALUES ('$user_id', 1, '".date("Y-m-d")."',
  				'Order Modified! <a href=\'orders.php\'>View</a>', 0)";
  		if ($conn->query($sql) === FALSE){
  			echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  			exit();
  		}
  	}
  	
  // Products ordered in this form
  	$products 	= array();
  	$quantity1 	= array();
  	$quantity2 	= array();
  	$quantity3 	= array();
  	// index
  	$index = 0;
  	foreach($_POST as $key => $value) {
  		if (strpos($key, 'product') === 0) {
  			array_push($products, $value);
  			$index++;
  		}
  		if (strpos($key, 'qty1') === 0) {
  			array_push($quantity1, $value);
  		}
  		if (strpos($key, 'qty2') === 0) {
  			array_push($quantity2, $value);
  		}
  		if (strpos($key, 'qty3') === 0) {
  			array_push($quantity3, $value);
  		}
  	}

	$product_count = $index;
	
	if (isset($_POST['edited_points'])) {

		$sqlStatement_form = "UPDATE form_completion SET
		
		edited_points='$edited_points', edited_price='$edited_price',
		edited_rebate='$edited_rebate', edited_deposit='$edited_deposit',
		edited_subtotal='$edited_subtotal', edited_total='$edited_total',
		edited_status='$edited_status', send_email='$send_email', edited=1,
		allow_modification='$allow_modification'
		WHERE id=$fid";
		//echo $sqlStatement_form;
		
		// Check and add the product_order
		if ($conn->query($sqlStatement_form) === FALSE){
			echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
			exit();
		}
	}
	
	if(isset($_POST['fid'])) {
		$sqlSelect = "SELECT * FROM orders_updates WHERE form_id=$fid";
		$results = mysqli_query($conn, $sqlSelect) or die ($sqlSelect."<br>".mysqli_error($conn));
		$productsIds 	= array();
		
		while ($row = mysqli_fetch_array($results))
		{
			array_push($productsIds, $row['product_details_id']);
		}
		
		foreach ($productsIds as $k){
			$sqlDel = "DELETE FROM orders_updates WHERE form_id=$fid AND product_details_id=$k";
			mysqli_query($conn, $sqlDel) or die ($sqlDel."<br>".mysqli_error($conn));
		}
			
		$x = 0;
		// tant qu'il y a des produits: on ins�re
		while ($x<$product_count)
		{
			if ($quantity1[$x] == 0 && $quantity2[$x] == 0 && $quantity3[$x] == 0) {
				$x++;
				continue;
			}
			$sqlStatement_order = "INSERT INTO orders_updates (
		
			form_id,		product_details_id,			quantity1,			quantity2,			quantity3
		
			) VALUES (
		
			'$fid',		'$products[$x]',	'$quantity1[$x]', 	'$quantity2[$x]', 	'$quantity3[$x]'
		
			) ON DUPLICATE KEY UPDATE
		
			quantity1='$quantity1[$x]',		quantity2='$quantity2[$x]',		quantity3='$quantity3[$x]'";
		
			echo $sqlStatement_order;
		
			// Check and add the product_order
			if ($conn->query($sqlStatement_order) === FALSE){
				echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
				exit();
			}
		
			echo "Order edited successfully";
			$x++;
		}
	}
	
  	header("Location: ../orders.php");
}
?>