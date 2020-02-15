<?PHP
  // form handler
  if($_POST){
  	
  	include "../inc/config.php";
  	
  	/**************************************
  	 *		Customer's informations
  	 **************************************/

  	$product_name_en 			= mysqli_real_escape_string($conn, isset($_POST['name_en']) ? $_POST['name_en'] : "");
  	$product_name_fr 			= mysqli_real_escape_string($conn, isset($_POST['name_fr']) ? $_POST['name_fr'] : "");
  	$product_category 			= mysqli_real_escape_string($conn, isset($_POST['category']) ? $_POST['category'] : "");
  	//$product_packaging_id 		= mysqli_real_escape_string($conn, isset($_POST['fax2']) ? $_POST['fax2'] : "");
  	$product_image 				= isset($_FILES['image']) ? $_FILES['image'] : '';
  	$product_id 				= mysqli_real_escape_string($conn, isset($_POST['id']) ? $_POST['id'] : 0);
  	$product_active 			= mysqli_real_escape_string($conn, isset($_POST['active']) ? 1 : 0);
  	 
  	$packaging 	= array();
  	$code 	= array();
  	$points 	= array();
  	$price 	= array();
  	 
  	// index
  	$index = 0;
  	while(isset($_POST['packaging' . $index]))
  	{
  		array_push($packaging, $_POST['packaging' . $index]);
  		array_push($code, $_POST['code' . $index]);
  		array_push($points, $_POST['points' . $index]);
  		array_push($price, $_POST['price' . $index++]);
  	}
  	
  	if ( !isset($_POST['packaging0']) ){
  		echo 'You must add a package. Choose No Package if none exist! ';
  		exit();
  	}

	/********************************************
	 *		Insert new product in the database
	 ********************************************/
  	
  	if ($_FILES['image']['name']=="")
  	{
  		if ($product_id === '0'){
  			$sqlStatement = "INSERT INTO products (
  		name_en,				name_fr,			category_id
  		  		) VALUES (
  		  		'$product_name_en',		'$product_name_fr',	'$product_category'
  		  		)";
  				
  			// Check and add the product_order
  			if ($conn->query($sqlStatement) === FALSE){
  				echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  				exit();
  			}
  			
  			$product_id = $conn->insert_id;
  			echo "New product added successfully";
  		}
  		else {
  			 
  			$sqlStatement = "UPDATE products SET
  		
  			name_en='$product_name_en',	name_fr='$product_name_fr',
  			category_id='$product_category', active='$product_active'
  			 
  			WHERE id=$product_id";
  		
  			//echo $sqlStatement_customer;
  		
  			// Now insert the new form into DB
  			if ($conn->query($sqlStatement) === FALSE){
  				echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  				exit();
  			}
  			 
  			echo "Product edited successfully without image";
  		}
  	}
  	else {
  		if ($product_id === '0'){
  			$sqlStatement = "INSERT INTO products (
  		name_en,				name_fr,			category_id,				image_name
  		  		) VALUES (
  		  		'$product_name_en',		'$product_name_fr',	'$product_category', 	'$product_image'
  		  		)";
  				
  			// Check and add the product_order
  			if ($conn->query($sqlStatement) === FALSE){
  				echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  				exit();
  			}
  				
  			$product_id = $conn->insert_id;
  			echo "New product added successfully";
  		}
  		else {
  			 
  			$sqlStatement = "UPDATE products SET
  		
  			name_en='$product_name_en',	name_fr='$product_name_fr',
  			category_id='$product_category', image_name='$product_image[name]', active='$product_active'
  			 
  			WHERE id=$product_id";
  		
  			//echo $sqlStatement_customer;
  		
  			// Now insert the new form into DB
  			if ($conn->query($sqlStatement) === FALSE){
  				echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  				exit();
  			}
  			 
  			echo "Product edited successfully";
  		}
  		
  		$uploaddir  = '../order/images/products/';
  		
  		$uploadfile = $uploaddir . basename($_FILES['image']['name']);
  		
  		if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
  			echo "File is valid, and was successfully uploaded.\n";
  		} else {
  			echo "Upload failed";
  		}
  	}
  	
  	$x = 0;
  	// tant qu'il y a des produits: on ins�re
  	while ($x<$index)
  	{
  		$sqlStatement_pack = "INSERT INTO products_details (
  			
  		product_id,		packaging_id,			code,			point,			purchase_price
  			
  		) VALUES (
  			
  		'$product_id',		'$packaging[$x]',	'$code[$x]', 	'$points[$x]', 	'$price[$x]'
  			
  		) ON DUPLICATE KEY UPDATE
  			
  		packaging_id='$packaging[$x]',		code='$code[$x]',		point='$points[$x]' ,		purchase_price='$price[$x]'";
  			
  		echo $sqlStatement_pack;
  			
  		// Check and add the product_order
  		if ($conn->query($sqlStatement_pack) === FALSE){
  			echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  			exit();
  		}
  			
  		$x++;
  	}
  	$url = '/product.php?id='.$product_id;
  	echo "<script>window.location.href = '$url';</script>";
  	//header('Location: ' . $_SERVER['HTTP_REFERER']);
  	//exit();
}
//header("Location: ../");
//exit();
?>