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
  	$nff 		    = mysqli_real_escape_string($conn, isset($_POST['nff']) ? $_POST['nff'] : "");
  	$language 		= mysqli_real_escape_string($conn, isset($_POST['lang']) ? $_POST['lang'] : "fr");
  	$lastname 		= mysqli_real_escape_string($conn, isset($_POST['lastname']) ? $_POST['lastname'] : "");
  	$firstname 		= mysqli_real_escape_string($conn, isset($_POST['firstname']) ? $_POST['firstname'] : "");
  	$maritalstatus 	= mysqli_real_escape_string($conn, isset($_POST['maritalstatus']) ? $_POST['maritalstatus'] : "");
  	$numdependent 	= isset($_POST['dependent']) ? $_POST['dependent'] : "";
  	// Customer's Address
  	$streetaddress1 = mysqli_real_escape_string($conn, isset($_POST['streetaddress1']) ? $_POST['streetaddress1'] : "");
  	$streetaddress2	= mysqli_real_escape_string($conn, isset($_POST['streetaddress2']) ? $_POST['streetaddress2'] : "");
  	$city 			= mysqli_real_escape_string($conn, isset($_POST['city']) ? $_POST['city'] : "");
  	$province 		= mysqli_real_escape_string($conn, isset($_POST['province']) ? $_POST['province'] : "");
  	$postalcode 	= mysqli_real_escape_string($conn, isset($_POST['postal']) ? $_POST['postal'] : "");
  	$sector 		= mysqli_real_escape_string($conn, isset($_POST['sector']) ? $_POST['sector'] : "");
  	// 
  	$owner 			= isset($_POST['owner']) ? $_POST['owner'] : "NULL";
  	$howlong 		= isset($_POST['howlong']) ? $_POST['howlong'] : "NULL";
  	
  	$phone 			= mysqli_real_escape_string($conn, isset($_POST['phone']) ? $_POST['phone'] : "");
  	$workphone 		= mysqli_real_escape_string($conn, isset($_POST['workphone']) ? $_POST['workphone'] : "");
  	$email 			= mysqli_real_escape_string($conn, isset($_POST['email']) ? $_POST['email'] : "");
  	$fax 			= mysqli_real_escape_string($conn, isset($_POST['fax']) ? $_POST['fax'] : "");
  	  	  	
  	$lastname2 		= mysqli_real_escape_string($conn, isset($_POST['lastname2']) ? $_POST['lastname2'] : "");
  	$firstname2 	= mysqli_real_escape_string($conn, isset($_POST['firstname2']) ? $_POST['firstname2'] : "");
  	$phone2 		= mysqli_real_escape_string($conn, isset($_POST['phone2']) ? $_POST['phone2'] : "");
  	$email2 		= mysqli_real_escape_string($conn, isset($_POST['email2']) ? $_POST['email2'] : "");
  	$fax2 			= mysqli_real_escape_string($conn, isset($_POST['fax2']) ? $_POST['fax2'] : "");
  	
  	$dateSince 		= mysqli_real_escape_string($conn, isset($_POST['since']) ? $_POST['since'] : "");
  	
  	$password_ = md5("abc123");
  	
  	/**************************************
  	 *		Form's other informations
  	 **************************************/
  	$fid 				= mysqli_real_escape_string($conn, isset($_POST['fid']) ? $_POST['fid'] : "");
  	$total_points 		= mysqli_real_escape_string($conn, isset($_POST['points']) ? $_POST['points'] : "");
  	$price 				= mysqli_real_escape_string($conn, isset($_POST['price']) ? $_POST['price'] : "");
  	$rebate 			= mysqli_real_escape_string($conn, isset($_POST['rebate']) ? $_POST['rebate'] : "");
  	$subtotal 			= mysqli_real_escape_string($conn, isset($_POST['subtotal']) ? $_POST['subtotal'] : "");
  	$deposit 			= mysqli_real_escape_string($conn, isset($_POST['deposit']) ? $_POST['deposit'] : "");
  	$total 				= mysqli_real_escape_string($conn, isset($_POST['total']) ? $_POST['total'] : "");
  	$notice 			= mysqli_real_escape_string($conn, isset($_POST['notice']) ? $_POST['notice'] : "");
  	$notice2 			= mysqli_real_escape_string($conn, isset($_POST['notice2']) ? $_POST['notice2'] : "");
  	// Payment by Credit card
  	$cc_flag 			= isset($_POST['payment']) && $_POST['payment']==1 ? 1 : 0;
  	$cc_notes 			= mysqli_real_escape_string($conn, isset($_POST['notes1']) ? $_POST['notes1'] : "");
  	$cc_number 			= mysqli_real_escape_string($conn, isset($_POST['creditcard']) ? $_POST['creditcard'] : "");
  	$cc_month 			= mysqli_real_escape_string($conn, isset($_POST['creditmonth']) ? $_POST['creditmonth'] : "");
  	$cc_year 			= mysqli_real_escape_string($conn, isset($_POST['credityear']) ? $_POST['credityear'] : "");
  	$cc_ccv 			= mysqli_real_escape_string($conn, isset($_POST['creditccv']) ? $_POST['creditccv'] : "");
  	$cc_name 			= mysqli_real_escape_string($conn, isset($_POST['creditname']) ? $_POST['creditname'] : "");
  	// Authorized payment
  	$preauthorized_flag = isset($_POST['payment']) && $_POST['payment']==2 ? 1 : 0;
  	$preauthorized_notes= mysqli_real_escape_string($conn, isset($_POST['notes2']) ? $_POST['notes2'] : "");
  	// Cash payment
  	$cash_flag 			= isset($_POST['payment']) && $_POST['payment']==3 ? 1 : 0;
  	$cash_notes 		= mysqli_real_escape_string($conn, isset($_POST['notes3']) ? $_POST['notes3'] : "");
  	
  	$payment1           = mysqli_real_escape_string($conn, isset($_POST['payment1']) ? $_POST['payment1'] : "");
  	$payment2           = mysqli_real_escape_string($conn, isset($_POST['payment2']) ? $_POST['payment2'] : "");
  	$payment3           = mysqli_real_escape_string($conn, isset($_POST['payment3']) ? $_POST['payment3'] : "");
  	
  	$oneonly            = isset($_POST['oneonly']) ? true : false;
  	
  	// Payment's conditions
  	$conditions_nummonths 			= mysqli_real_escape_string($conn, isset($_POST['conditionsmonths']) ? $_POST['conditionsmonths'] : "");
  	$conditions_startcontractdate 	= mysqli_real_escape_string($conn, isset($_POST['conditionsstartcontractdate']) ? $_POST['conditionsstartcontractdate'] : "");
  	$conditions_firstdeliverydate 	= mysqli_real_escape_string($conn, isset($_POST['conditionsfirstdeliverydate']) ? $_POST['conditionsfirstdeliverydate'] : "");
  	$conditions_numwithdrawals 		= mysqli_real_escape_string($conn, isset($_POST['conditionspaymentmonths']) ? $_POST['conditionspaymentmonths'] : "");
  	$conditions_withdralawamount 	= mysqli_real_escape_string($conn, isset($_POST['conditionsmonthlypayment']) ? $_POST['conditionsmonthlypayment'] : "");
  	$conditions_firstwithdrawaldate = mysqli_real_escape_string($conn, isset($_POST['conditionsfirstpaymentdate']) ? $_POST['conditionsfirstpaymentdate'] : "");
  	// Signature parameters
  	$signature_date 				= mysqli_real_escape_string($conn, isset($_POST['signeddate']) ? $_POST['signeddate'] : "");
  	$signature_address 				= mysqli_real_escape_string($conn, isset($_POST['signedaddress']) ? $_POST['signedaddress'] : "");
	$signature_merchant_name 		= mysqli_real_escape_string($conn, isset($_POST['signedmerchant']) ? $_POST['signedmerchant'] : "");
  	$signature_merchant_url 		= mysqli_real_escape_string($conn, isset($_POST['signed1']) ? $_POST['signed1'] : "");
  	$signature_consumer_name 		= mysqli_real_escape_string($conn, isset($_POST['signedconsumer1']) ? $_POST['signedconsumer1'] : "");
  	$signature_consumer_url 		= mysqli_real_escape_string($conn, isset($_POST['signed2']) ? $_POST['signed2'] : "");
  	$signature_consumer2_name 		= mysqli_real_escape_string($conn, isset($_POST['signedconsumer2']) ? $_POST['signedconsumer2'] : "");
  	$signature_consumer2_url 		= mysqli_real_escape_string($conn, isset($_POST['signed3']) ? $_POST['signed3'] : "");
  	
  	$representative_id 				= isset($_POST['userid']) ? (int)$_POST['userid'] : 0;
  	
  	$customer_id = isset($_POST['customerid']) ? $_POST['customerid'] : "";
  	
  	// Now insert the new form into DB
  	if ($representative_id == 0){
  		echo '<br/>Error DB: Representative not set correctly<br/>';
  		exit();
  	}
  	
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
	  	 'cash_notes:			'.$cash_notes.	'<br/>'.
  	 		
  	 	 'signature_consumer_name: '.$signature_consumer_name.		'<br/>'.
  	 	 'signature_consumer_url:  '.$signature_consumer_url.		'<br/>'.
  	     	 'signature_consumer2_name: '.$signature_consumer2_name.	'<br/>'.
  	 	 'signature_consumer2_url:  '.$signature_consumer2_url.		'<br/>'
  	 );
*/

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
	
	/********************************************
	 *		Insert new customer in the database
	 ********************************************/
  		
	// Before inserting a new customer, validation on all form fields must be done.
  	$sqlStatement_customer = "INSERT INTO customer (
  	
	  		lastname,		firstname,		maritalstatus, 		numdependent,		nff,
	  		streetaddress1, streetaddress2, city, 				province, 			postalcode,			sector,
	  		owner, 			howlongyear,
	  		phone, 			workphone, 		email,				fax,
	  		lastname2, 		firstname2, 	phone2, 			fax2, 				email2	, dateSince, password
	  	
	  	) VALUES (
  			
	  		'$lastname', 		'$firstname', 		'$maritalstatus', 	'$numdependent',	'$nff',
	  		'$streetaddress1',	'$streetaddress2', 	'$city', 			'$province', 		'$postalcode', 		'$sector',
	  		'$owner', 			'$howlong',
	  		'$phone',			'$workphone',		'$email',			'$fax',
	  		'$lastname2', 		'$firstname2', 		'$phone2', 			'$fax2', 			'$email2'	, '$dateSince'	 , '$password_'
  		)";	
  	
  	if ($customer_id !== "") {
	  	$sqlStatement_customer = "UPDATE customer SET
	  	 
	  	lastname='$lastname',				firstname='$firstname',				maritalstatus='$maritalstatus', 		numdependent='$numdependent',
	  	streetaddress1='$streetaddress1', 	streetaddress2='$streetaddress2', 	city='$city', 							nff='$nff',
	  	province='$province', 				postalcode='$postalcode',			sector='$sector',
	  	owner='$owner', 					howlongyear='$howlong',	
	  	phone='$phone', 					workphone='$workphone', 			email='$email',							fax='$fax',
	  	lastname2='$lastname2', 			firstname2='$firstname2', 			phone2='$phone2', 						fax2='$fax2',
	  	email2='$email2'
	  	
	  	WHERE id=$customer_id";
  	}
  	 
  	
  	echo $sqlStatement_customer;

  	// Now insert the new form into DB
  	if ($conn->query($sqlStatement_customer) === FALSE){
  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
  		
  		$sql = "SELECT * FROM customer WHERE phone='$phone' LIMIT 1";
  		$results = mysqli_query($conn, $sql) or die ($sql."<br>".mysqli_error($conn));
  		 
  		while ($row = mysqli_fetch_array($results))
  		{
  			$customer_id = $row['id'];
  		}
  		echo "$sql.id:$customer_id";
  		exit();
  	}
  	else {
  		echo "New customer added successfully";
  		
  		// retrieve the customer id
  		if ($customer_id === "") {
  			$customer_id = $conn->insert_id;
  		}
  	}
  	
  	if ( !isset($_POST['product' . 0]) ){
  		echo 'No product ordered ! ';
  		//exit();
  	}
  	echo "customer_id:".$customer_id;
  	//exit();
  	
  	$conditions_seconddeliverydate = addDayswithdate($conditions_firstdeliverydate,"120");
  	$conditions_thirddeliverydate  = addDayswithdate($conditions_firstdeliverydate,"240");
  	if ($oneonly) {
  		$conditions_seconddeliverydate = $conditions_firstdeliverydate;
  		$conditions_thirddeliverydate = $conditions_firstdeliverydate;
  	}
  		
  	// Create the new statement for the form_completion DB
  	$sqlStatement_form = "INSERT INTO form_completion (
  		
  		customer_id,
  		total_points,				 price,				rebate,			subtotal,		deposit,		total,			notice,
  		cc_flag, 					 cc_notes, 			cc_number, 		cc_month, 		cc_year, 		cc_ccv,			cc_name, 
  		preauthorized_flag,			 preauthorized_notes,	notice2,
  		cash_flag, 					 cash_notes,
  		
  		conditions_nummonths,		 conditions_startcontractdate, 		conditions_firstdeliverydate,          
  		conditions_seconddeliverydate,	conditions_thirddeliverydate,
  		conditions_numwithdrawals,	 conditions_withdrawalamount,		conditions_firstwithdrawaldate,        
  		
  		signature_date, 			 signature_address, 	
  		signature_merchant_name, 	 signature_merchant_url, 
  		signature_consumer_name, 	 signature_consumer_url, 
  		signature_consumer2_name, 	 signature_consumer2_url, 
  		representative_id,
  		payment1,                    payment2,                          payment3
  		
  	) VALUES (
  			
  		'$customer_id',
  		'$total_points',			 '$price',			'$rebate', 		'$subtotal',	'$deposit', 	'$total',		'$notice',
  		'$cc_flag',					 '$cc_notes',		'$cc_number',	'$cc_month', 	'$cc_year', 	'$cc_ccv',		'$cc_name',
  		'$preauthorized_flag',		 '$preauthorized_notes',  '$notice2',
  		'$cash_flag', 				 '$cash_notes',
  			
  		'$conditions_nummonths',	 '$conditions_startcontractdate', 	'$conditions_firstdeliverydate', 	 
  		'$conditions_seconddeliverydate', '$conditions_thirddeliverydate',
  		'$conditions_numwithdrawals','$conditions_withdralawamount',	'$conditions_firstwithdrawaldate',   
  		    
  		'$signature_date', 			 '$signature_address', 	
  		'$signature_merchant_name',  '$signature_merchant_url', 
  		'$signature_consumer_name',  '$signature_consumer_url', 
  		'$signature_consumer2_name', '$signature_consumer2_url', 
  		'$representative_id',
  		'$payment1',                 '$payment2',                        '$payment3'

  	)"; 
  	
  	// echo '<br/>'.$sqlStatement_form;

  	
  	// Check and add the product_order
  	if ($conn->query($sqlStatement_form) === FALSE){
  		echo $customer_id.'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
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

  	$url = "../order/preview.php?id=".$form_id."&rid=".$representative_id."&lang=".$language;
  	echo "<script>window.location.href = '$url';</script>";
}
?>