<?PHP
  // form handler
  if($_POST && isset($_POST['lastname'])){
  	
  	include "../inc/config.php";
  	
  	/**************************************
  	 *		Customer's informations
  	 **************************************/
/*  	
  	echo (
  			'lastname:			'.$_POST['lastname'].		'<br/>'.  			
  			'firstname:			'.$_POST['firstname'].		'<br/>'.
  			'maritalstatus:		'.$_POST['maritalstatus'].	'<br/>'.
  			'numdependent:		'.$_POST['dependent'].		'<br/>'.
  			'streetnumber:		'.$_POST['streetnumber'].	'<br/>'.
  			'streetname:		'.$_POST['streetname'].		'<br/>'.
  			'city:				'.$_POST['city'].			'<br/>'.
  			'province:			'.$_POST['province'].		'<br/>'.
  			'postalcode:		'.$_POST['postal'].			'<br/>'.
  			'sector:			'.$_POST['sector'].			'<br/>'.
  			'owner:				'.$_POST['owner'].			'<br/>'.
  			'howlong:			'.$_POST['howlong'].		'<br/>'.
  			'phone:				'.$_POST['phone'].			'<br/>'.
  			'workphone:			'.$_POST['workphone'].		'<br/>'.
  			'email:				'.$_POST['email'].			'<br/>'.
  			'fax:				'.$_POST['fax'].			'<br/>'.
  			'lastname2:			'.$_POST['lastname2'].		'<br/>'.
  			'firstname2:		'.$_POST['firstname2'].		'<br/>'.
  			'phone2:			'.$_POST['phone2'].			'<br/>'.
  			'email2:			'.$_POST['email2'].			'<br/>'.
  			'fax2:				'.$_POST['fax2'].			'<br/>'.'<br/>'
  	);
 */
  	
  	$lastname 		= mysqli_real_escape_string($conn, $_POST['lastname'] ? $_POST['lastname'] : "");
  	$firstname 		= mysqli_real_escape_string($conn, $_POST['firstname'] ? $_POST['firstname'] : "");
  	$maritalstatus 	= mysqli_real_escape_string($conn, $_POST['maritalstatus'] ? $_POST['maritalstatus'] : "");
  	$numdependent 	= $_POST['dependent'] ? $_POST['dependent'] : "";
  	// Customer's Address
  	$streetaddress1 = mysqli_real_escape_string($conn, $_POST['streetaddress1'] ? $_POST['streetaddress1'] : "");
  	$streetaddress2	= mysqli_real_escape_string($conn, $_POST['streetaddress2'] ? $_POST['streetaddress2'] : "");
  	$city 			= mysqli_real_escape_string($conn, $_POST['city'] ? $_POST['city'] : "");
  	$province 		= mysqli_real_escape_string($conn, $_POST['province'] ? $_POST['province'] : "");
  	$postalcode 	= mysqli_real_escape_string($conn, $_POST['postal'] ? $_POST['postal'] : "");
  	$sector 		= mysqli_real_escape_string($conn, $_POST['sector'] ? $_POST['sector'] : "");
  	// 
  	$owner 			= isset($_POST['owner']) ? $_POST['owner'] : "NULL";
  	$howlong 		= isset($_POST['howlong']) ? $_POST['howlong'] : "NULL";
  	
  	$phone 			= mysqli_real_escape_string($conn, $_POST['phone'] ? $_POST['phone'] : "");
  	$workphone 		= mysqli_real_escape_string($conn, $_POST['workphone'] ? $_POST['workphone'] : "");
  	$email 			= mysqli_real_escape_string($conn, $_POST['email'] ? $_POST['email'] : "");
  	$fax 			= mysqli_real_escape_string($conn, $_POST['fax'] ? $_POST['fax'] : "");
  	  	  	
  	$lastname2 		= mysqli_real_escape_string($conn, $_POST['lastname2'] ? $_POST['lastname2'] : "");
  	$firstname2 	= mysqli_real_escape_string($conn, $_POST['firstname2'] ? $_POST['firstname2'] : "");
  	$phone2 		= mysqli_real_escape_string($conn, $_POST['phone2'] ? $_POST['phone2'] : "");
  	$email2 		= mysqli_real_escape_string($conn, $_POST['email2'] ? $_POST['email2'] : "");
  	$fax2 			= mysqli_real_escape_string($conn, $_POST['fax2'] ? $_POST['fax2'] : "");
  	
  	
  	/**************************************
  	 *		Form's other informations
  	 **************************************/
  	$total_points 		= mysqli_real_escape_string($conn, $_POST['points'] ? $_POST['points'] : "");
  	$price 				= mysqli_real_escape_string($conn, $_POST['price'] ? $_POST['price'] : "");
  	$rebate 			= mysqli_real_escape_string($conn, $_POST['rebate'] ? $_POST['rebate'] : "");
  	$subtotal 			= mysqli_real_escape_string($conn, $_POST['subtotal'] ? $_POST['subtotal'] : "");
  	$deposit 			= mysqli_real_escape_string($conn, $_POST['deposit'] ? $_POST['deposit'] : "");
  	$total 				= mysqli_real_escape_string($conn, $_POST['total'] ? $_POST['total'] : "");
  	$notice 			= mysqli_real_escape_string($conn, $_POST['notice'] ? $_POST['notice'] : "");
  	$notice 			= mysqli_real_escape_string($conn, $_POST['notice2'] ? $_POST['notice2'] : "");
  	// Payment by Credit card
  	$cc_flag 			= isset($_POST['hascredit']) ? (int)$_POST['hascredit'] : 0;
  	$cc_notes 			= mysqli_real_escape_string($conn, $_POST['notes1'] ? $_POST['notes1'] : "");
  	$cc_number 			= mysqli_real_escape_string($conn, $_POST['creditcard'] ? $_POST['creditcard'] : "");
  	$cc_month 			= mysqli_real_escape_string($conn, $_POST['creditmonth'] ? $_POST['creditmonth'] : "");
  	$cc_year 			= mysqli_real_escape_string($conn, $_POST['credityear'] ? $_POST['credityear'] : "");
  	$cc_ccv 			= mysqli_real_escape_string($conn, $_POST['creditccv'] ? $_POST['creditccv'] : "");
  	$cc_name 			= mysqli_real_escape_string($conn, $_POST['creditname'] ? $_POST['creditname'] : "");
  	// Authorized payment
  	$preauthorized_flag = isset($_POST['haspreauthorized']) ? (int)$_POST['haspreauthorized'] : 0;
  	$preauthorized_notes= mysqli_real_escape_string($conn, $_POST['notes2'] ? $_POST['notes2'] : "");
  	// Cash payment
  	$cash_flag 			= isset($_POST['hascash']) ? (int)$_POST['hascash'] : 0;
  	$cash_notes 		= mysqli_real_escape_string($conn, $_POST['notes3'] ? $_POST['notes3'] : "");
  	// Payment's conditions
  	$conditions_nummonths 			= mysqli_real_escape_string($conn, $_POST['conditionsmonths'] ? $_POST['conditionsmonths'] : "");
  	$conditions_startcontractdate 	= mysqli_real_escape_string($conn, $_POST['conditionsstartcontractdate'] ? $_POST['conditionsstartcontractdate'] : "");
  	$conditions_firstdeliverydate 	= mysqli_real_escape_string($conn, isset($_POST['conditionsfirstdeliverydate']) ? $_POST['conditionsfirstdeliverydate'] : "");
  	$conditions_numwithdrawals 		= mysqli_real_escape_string($conn, $_POST['conditionspaymentmonths'] ? $_POST['conditionspaymentmonths'] : "");
  	$conditions_withdralawamount 	= mysqli_real_escape_string($conn, $_POST['conditionsmonthlypayment'] ? $_POST['conditionsmonthlypayment'] : "");
  	$conditions_firstwithdrawaldate = mysqli_real_escape_string($conn, $_POST['conditionsfirstpaymentdate'] ? $_POST['conditionsfirstpaymentdate'] : "");
  	// Signature parameters
  	$signature_date 				= mysqli_real_escape_string($conn, $_POST['signeddate'] ? $_POST['signeddate'] : "");
  	$signature_address 				= mysqli_real_escape_string($conn, $_POST['signedaddress'] ? $_POST['signedaddress'] : "");
	$signature_merchant_name 		= mysqli_real_escape_string($conn, $_POST['signedmerchant'] ? $_POST['signedmerchant'] : "");
  	$signature_merchant_url 		= mysqli_real_escape_string($conn, $_POST['signed1'] ? $_POST['signed1'] : "");
  	$signature_consumer_name 		= mysqli_real_escape_string($conn, $_POST['signedconsumer1'] ? $_POST['signedconsumer1'] : "");
  	$signature_consumer_url 		= mysqli_real_escape_string($conn, $_POST['signed2'] ? $_POST['signed2'] : "");
  	$signature_consumer2_name 		= mysqli_real_escape_string($conn, $_POST['signedconsumer2'] ? $_POST['signedconsumer2'] : "");
  	$signature_consumer2_url 		= mysqli_real_escape_string($conn, $_POST['signed3'] ? $_POST['signed3'] : "");
  	
/*
  	 echo (
	  	 'total_points:			'.$total_points.'<br/>'.
	  	 'price:				'.$price.		'<br/>'.
	  	 'rebate:				'.$rebate.		'<br/>'.
	  	 'subtotal:				'.$subtotal.	'<br/>'.
	  	 'deposit:				'.$deposit.		'<br/>'.
	  	 'total:				'.$total.		'<br/>'.
	  	 'notice:				'.$notice.		'<br/><br/>'.
	  	 'cc_flag:				'.$cc_flag.		'<br/>'.
	  	 'cc_notes:				'.$cc_notes.	'<br/>'.
	  	 'cc_number:			'.$cc_number.	'<br/>'.
	  	 'cc_month:				'.$cc_month.	'<br/>'.
	  	 'cc_year:				'.$cc_year.		'<br/>'.
	  	 'cc_ccv:				'.$cc_ccv.		'<br/>'.
	  	 'cc_name:				'.$cc_name.		'<br/><br/>'.
	  	 	
	  	 'preauthorized_flag:	'.$preauthorized_flag.		'<br/>'.
	  	 'preauthorized_notes:	'.$preauthorized_notes.		'<br/><br/>'.
	  	 	
	  	 'cash_flag:			'.$cash_flag.	'<br/>'.
	  	 'cash_notes:			'.$cash_notes.	'<br/>'
  	 );
*/

  	// Products ordered in this form  	 	
  	$products 	= array();
  	$quantity1 	= array();
  	$quantity2 	= array();
  	$quantity3 	= array();
  	
  	// index
  	$index = 0;
  	if ( !isset($_POST['product' . $index]) ){
  		echo 'No product ordered ! ';
  		exit();
  	}
	while(isset($_POST['product' . $index]))
	{
		array_push($products, $_POST['product' . $index]);
	  	array_push($quantity1, $_POST['qty1' . $index]);
	 	array_push($quantity2, $_POST['qty2' . $index]);
	 	array_push($quantity3, $_POST['qty3' . $index++]);
	}

	
	$product_count = $index;
	
	/********************************************
	 *		Insert new customer in the database
	 ********************************************/
  		
	// Before inserting a new customer, validation on all form fields must be done.
  	$sqlStatement_customer = "INSERT INTO customer (
  	
	  		lastname,		firstname,		maritalstatus, 		numdependent,
	  		streetaddress1, streetaddress2, city, 				province, 			postalcode,			sector,
	  		owner, 			howlongyear,
	  		phone, 			workphone, 		email,				fax,
	  		lastname2, 		firstname2, 	phone2, 			fax2, 				email2	
	  	
	  	) VALUES (
  			
	  		'$lastname', 		'$firstname', 		'$maritalstatus', 	'$numdependent',
	  		'$streetaddress1',	'$streetaddress2', 	'$city', 			'$province', 		'$postalcode', 		'$sector',
	  		'$owner', 			'$howlong',
	  		'$phone',			'$workphone',		'$email',			'$fax',
	  		'$lastname2', 		'$firstname2', 		'$phone2', 			'$fax2', 			'$email2'		
  		)";	
  	
  	//echo $sqlStatement_customer;

  	// Now insert the new form into DB
  	if ($conn->query($sqlStatement_customer) === FALSE){
  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  		exit();
  	}
  		
  	echo "New customer added successfully";
  			
  	// retrieve the customer id
  	$customer_id = $conn->insert_id;  		
  		
  	// Create the new statement for the form_completion DB
  	$sqlStatement_form = "INSERT INTO form_completion (
  		
  		customer_id,
  		total_points,				 price,				rebate,			subtotal,		deposit,		total,			notice,
  		cc_flag, 					 cc_notes, 			cc_number, 		cc_month, 		cc_year, 		cc_ccv,			cc_name, 
  		preauthorized_flag,			 preauthorized_notes, notice2,
  		cash_flag, 					 cash_notes,
  		
  		conditions_nummonths,		 conditions_startcontractdate, 		conditions_firstdeliverydate, 	
  		conditions_numwithdrawals,	 conditions_withdrawalamount,		conditions_firstwithdrawaldate,
  		
  		signature_date, 			 signature_address, 	
  		signature_merchant_name, 	 signature_merchant_url, 
  		signature_consumer_name, 	 signature_consumer_url, 
  		signature_consumer2_name, 	 signature_consumer2_url
  		
  	) VALUES (
  			
  		'$customer_id',
  		'$total_points',			 '$price',			'$rebate', 		'$subtotal',	'$deposit', 	'$total',		'$notice',
  		'$cc_flag',					 '$cc_notes',		'$cc_number',	'$cc_month', 	'$cc_year', 	'$cc_ccv',		'$cc_name',
  		'$preauthorized_flag',		 '$preauthorized_notes',  '$notice2',
  		'$cash_flag', 				 '$cash_notes',
  			
  		'$conditions_nummonths',	 '$conditions_startcontractdate', 	'$conditions_firstdeliverydate', 	
  		'$conditions_numwithdrawals','$conditions_withdralawamount',	'$conditions_firstwithdrawaldate',
  		    
  		'$signature_date', 			 '$signature_address', 	
  		'$signature_merchant_name',  '$signature_merchant_url', 
  		'$signature_consumer_name',  '$signature_consumer_url', 
  		'$signature_consumer2_name', '$signature_consumer2_url'

  	)"; 
  	
  	// echo $sqlStatement_form;

  	
  	// Check and add the product_order
  	if ($conn->query($sqlStatement_form) === FALSE){
  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  		exit();
  	}
  			
  	//Get the last form id
  	$form_id = $conn->insert_id;
  			
  	$x = 0;
  	// tant qu'il y a des produits: on ins�re
 	while ($x<$product_count)
  	{
  		$sqlStatement_order = "INSERT INTO orders (
  				
  				form_id,		product_details_id,			quantity1,			quantity2,			quantity3
  				
  			) VALUES (
  				
  				'$form_id',		'$products[$x]',	'$quantity1[$x]', 	'$quantity2[$x]', 	'$quantity3[$x]'
  				
  			)";
  		
  		echo $sqlStatement_order;
  		
  		// Check and add the product_order
  		if ($conn->query($sqlStatement_order) === FALSE){
  			echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  			exit();
  		}
  		
  		echo "New order added successfully";
	  	$x++;
  	}		
}
?>