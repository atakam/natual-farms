<?php 
include "../inc/config.php";

if (isset($_GET["fid"]))
{
	$id = $_GET["fid"];
	$del = $_GET["del"];
	$date = $_GET["date"];
	
	$sqlStatement_customer = "UPDATE form_completion SET
  	
		conditions_".$del."deliverydate='$date'
	  	
	    WHERE id=$id";	
  	
  	//echo $sqlStatement_customer;

  	// Now insert the new form into DB
  	if ($conn->query($sqlStatement_customer) === FALSE){
  		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n".$sqlStatement_customer;
  		exit();
  	}
}
//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>