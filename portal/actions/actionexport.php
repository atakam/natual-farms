<?PHP
  // form handler
  if($_POST && isset($_POST['orderexport'])){
  	
  	include "../inc/config.php";
  	include "../inc/functions.php";
  	
  	$nff 			= isset($_POST['nff']) ? "on" : "off";
  	$name			= isset($_POST['name']) ? "on" : "off";
  	$phonec 			= isset($_POST['cphone']) ? "on" : "off";
  	$jodate 			= isset($_POST['jodate']) ? "on" : "off";
  	$codate 			= isset($_POST['codate']) ? "on" : "off";
  	$points 			= isset($_POST['points']) ? "on" : "off";
  	$price 			= isset($_POST['price']) ? "on" : "off";
  	$payment 			= isset($_POST['payment']) ? "on" : "off";
  	$delivery1 			= isset($_POST['delivery1']) ? "on" : "off";
  	$delivery2 			= isset($_POST['delivery2']) ? "on" : "off";
  	$delivery3 			= isset($_POST['delivery3']) ? "on" : "off";
  	$rep 			= isset($_POST['rep']) ? "on" : "off";
  	$datefrom 			= isset($_POST['datefrom']) ? $_POST['datefrom'] : "";
  	$dateto 			= isset($_POST['dateto']) ? $_POST['dateto'] : "";
  	
  	
  	$sqlVar  = $nff=='on'?"o.id,":"";
  	$sqlVar .= $name=='on'?"c.firstname, c.lastname,":"";
  	$sqlVar .= $phonec=='on'?"c.phone,":"";
  	$sqlVar .= $jodate=='on'?"c.dateSince,":"";
  	$sqlVar .= $codate=='on'?"o.conditions_startcontractdate,":"";
  	$sqlVar .= $points=='on'?"o.total_points,":"";
  	$sqlVar .= $price=='on'?"o.price,":"";
  	$sqlVar .= $payment=='on'?"o.cc_flag, o.preauthorized_flag, o.cash_flag,":"";
  	$sqlVar .= $delivery1=='on'?"o.conditions_firstdeliverydate,":"";
  	$sqlVar .= $delivery2=='on'?"o.conditions_seconddeliverydate,":"";
  	$sqlVar .= $delivery3=='on'?"o.conditions_thirddeliverydate,":"";
  	$sqlVar .= $rep=='on'?"r.name,":"";
  	
  	$sqlVar = rtrim($sqlVar, ',');
  	//echo  $sqlVar;
  	
  	$sqlWhere = "";
  	$prefix = "-All";
  	
  	if ($datefrom !== "" && $dateto !== "")
  	{
  		$sqlWhere = "WHERE o.conditions_startcontractdate BETWEEN '$datefrom' AND '$dateto'";
  		$prefix = "-$datefrom:$dateto";
  	}
  	else if ($datefrom !== "" && $dateto === "")
  	{
  		$sqlWhere = "WHERE o.conditions_startcontractdate >= '$datefrom'";
  		$prefix = "-$datefrom:now";
  	}
  	else if ($datefrom === "" && $dateto !== "")
  	{
  		$sqlWhere = "WHERE o.conditions_startcontractdate <= '$dateto'";
  		$prefix = "-beginning:$dateto";
  	}
  	
  	$sql = "SELECT 
  			
  			$sqlVar
  			
  			FROM form_completion AS o
			LEFT JOIN customer AS c
			ON o.customer_id = c.id
  		
			LEFT JOIN representative AS r
			ON o.representative_id = r.id
  	
  	        $sqlWhere";
  	
  			
  	
  	export_excel_csv($conn, $sql, "contracts-".$prefix);
  	//echo $_POST['nff'] . $name . $sql;
  		//echo	$sql;
  	
  }
  else if($_POST && isset($_POST['customerexport'])){
  	 
  	include "../inc/config.php";
  	include "../inc/functions.php";
  	 
  	$fname 			= isset($_POST['fname']) ? "on" : "off";
  	$lname			= isset($_POST['lname']) ? "on" : "off";
  	$phone			= isset($_POST['phone']) ? "on" : "off";
  	$email 			= isset($_POST['email']) ? "on" : "off";
  	$address 			= isset($_POST['address']) ? "on" : "off";
  	$city 		    	= isset($_POST['city']) ? "on" : "off";
  	$province 			= isset($_POST['province']) ? "on" : "off";
  	$postal 			= isset($_POST['postal']) ? "on" : "off";
  	$active 			= isset($_POST['active']) ? "on" : "off";
  	$datesince 			= isset($_POST['datesince']) ? "on" : "off";
  	$secondary 			= isset($_POST['secondary']) ? "on" : "off";
  	$datefrom 			= isset($_POST['datefrom']) ? $_POST['datefrom'] : "";
  	$dateto 			= isset($_POST['dateto']) ? $_POST['dateto'] : "";
  	 
  	 
  	$sqlVar  = $fname=='on'?"firstname, ":"";
  	$sqlVar  .= $lname=='on'?"lastname, ":"";
  	$sqlVar  .= $phone=='on'?"phone, ":"";
  	$sqlVar  .= $phone=='on'?"workphone, ":"";
  	$sqlVar  .= $email=='on'?"email, ":"";
  	$sqlVar  .= $address=='on'?"streetaddress1, ":"";
  	$sqlVar  .= $address=='on'?"streetaddress2, ":"";
  	$sqlVar  .= $city=='on'?"city, ":"";
  	$sqlVar  .= $province=='on'?"province, ":"";
  	$sqlVar  .= $postal=='on'?"postalcode, ":"";
  	$sqlVar  .= $postal=='on'?"sector, ":"";
  	$sqlVar  .= $active=='on'?"isactive, ":"";
  	$sqlVar  .= $datesince=='on'?"dateSince, ":"";
  	
  	$sqlVar  .= $secondary=='on'?"firstname2, ":"";
  	$sqlVar  .= $secondary=='on'?"lastname2, ":"";
  	$sqlVar  .= $secondary=='on'?"phone2, ":"";
  	$sqlVar  .= $secondary=='on'?"email2, ":"";
  	 
  	$sqlVar = rtrim($sqlVar, ' ');
  	$sqlVar = rtrim($sqlVar, ',');
  	//echo  $sqlVar;
  	
  	$sqlWhere = "";
  	$prefix = "-All";
  	 
  	if ($datefrom !== "" && $dateto !== "")
  	{
  		$sqlWhere = "WHERE dateSince BETWEEN '$datefrom' AND '$dateto'";
  		$prefix = "-$datefrom:$dateto";
  	}
  	else if ($datefrom !== "" && $dateto === "")
  	{
  		$sqlWhere = "WHERE dateSince >= '$datefrom'";
  		$prefix = "-$datefrom:now";
  	}
  	else if ($datefrom === "" && $dateto !== "")
  	{
  		$sqlWhere = "WHERE dateSince <= '$dateto'";
  		$prefix = "-beginning:$dateto";
  	}
  	 
  	$sql = "SELECT
  		
  	$sqlVar
  		
  	FROM customer
  	
  	$sqlWhere";
  	 
  	export_excel_csv($conn, $sql, "customers-".$prefix);
  }
  
  //echo "<script>window.location.href = '../export.php';</script>";
?>