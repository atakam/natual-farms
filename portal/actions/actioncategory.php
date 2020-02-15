<?PHP
  // form handler
  if($_POST){
  	
  	include "../inc/config.php";
  	
  	/**************************************
  	 *		Customer's informations
  	 **************************************/

  	$cat_name_en 			= mysqli_real_escape_string($conn, isset($_POST['name_en']) ? $_POST['name_en'] : "");
  	$cat_name_fr 			= mysqli_real_escape_string($conn, isset($_POST['name_fr']) ? $_POST['name_fr'] : "");
  	$cat_slug	 			= mysqli_real_escape_string($conn, isset($_POST['slug']) ? $_POST['slug'] : "");
  	$cat_id		 			= mysqli_real_escape_string($conn, isset($_POST['id']) ? $_POST['id'] : "0");
  	

	/********************************************
	 *		Insert new category in the database
	 ********************************************/
  	echo "catID:".$cat_id;
  		if ($cat_id == '0'){
  			$sqlStatement = "INSERT INTO products_category (
  		name_en,				name_fr,			slug
  		  		) VALUES (
  		  		'$cat_name_en',		'$cat_name_fr',	'$cat_slug'
  		  		)";
  				
  			// Check and add the product_order
  			if ($conn->query($sqlStatement) === FALSE){
  				echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n".$sqlStatement;
  				exit();
  			}
  			
  			$cat_id = $conn->insert_id;
  			echo "New category added successfully";
  		}
  		else {
  			 
  			$sqlStatement = "UPDATE products_category SET
  		
  			name_en='$cat_name_en',	name_fr='$cat_name_fr',
  			slug='$cat_slug'
  			 
  			WHERE id=$cat_id";
  		
  			//echo $sqlStatement_customer;
  		
  			// Now insert the new form into DB
  			if ($conn->query($sqlStatement) === FALSE){
  				echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  				exit();
  			}
  			 
  			echo "Category edited successfully";
  		}
  	
  	
  	header("Location: ../category.php?id=".$cat_id);
}
?>