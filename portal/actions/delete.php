<?php 
include "../inc/config.php";

if (isset($_GET["custid"]))
{
	$id = $_GET["custid"];
	
	$sql = "DELETE FROM customer WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	echo "Customer deleted";
}

if (isset($_GET["formid"]))
{
	$id = $_GET["formid"];
	
	$sql = "DELETE FROM orders WHERE form_id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	$sql = "DELETE FROM orders_updates WHERE form_id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	$sql = "DELETE FROM form_completion WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Form deleted";
}

if (isset($_GET["demoformid"]))
{
	$id = $_GET["demoformid"];

	$sql = "DELETE FROM orders_demo WHERE form_id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	$sql = "DELETE FROM form_completion_demo WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Form deleted";
}

if (isset($_GET["demoformidall"]))
{
	$sql = "DELETE FROM orders_demo";
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	$sql = "DELETE FROM form_completion_demo";
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "<script>window.location.href = '../orders_demo.php';</script>";
}

if (isset($_GET["edited_formid"]))
{
	$id = $_GET["edited_formid"];

	$sql = "DELETE FROM orders_updates WHERE form_id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	$sqlStatement_form = "UPDATE form_completion SET
	
	edited_status='0', send_email='0', edited='0', edited_points='0', 
	edited_price='0', edited_rebate='0', edited_deposit='0', edited_subtotal='0', edited_total='0'
	WHERE id=$id";
	// echo $sqlStatement_form;
	
		
	// Check and add the product_order
	if ($conn->query($sqlStatement_form) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Form updates deleted";
}

if (isset($_GET["catid"]))
{
	$id = $_GET["catid"];

	$sql = "DELETE FROM products_category WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo "Error deleting category\n";
		exit();
	}

	echo "Category deleted";
}
if (isset($_GET["pdtid"]))
{
	$id = $_GET["pdtid"];

	$sql = "DELETE FROM products_details WHERE product_id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	$sql = "DELETE FROM products WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Product deleted";
}
if (isset($_GET["prdtpack"]))
{
	$id = $_GET["prdtpack"];
	
	$sql = "DELETE FROM products_details WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	echo "Product deleted";
}
if (isset($_GET["repid"]))
{
	$id = $_GET["repid"];

	$sql = "DELETE FROM representative WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Representative deleted";
}
if (isset($_GET["supid"]))
{
	$id = $_GET["supid"];

	$sql = "DELETE FROM supplier WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Supplier deleted";
}
if (isset($_GET["notifications"]))
{

	$sql = "TRUNCATE notifications";
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Notifications cleared";
}
if (isset($_GET["delid"]))
{
	$id = $_GET["delid"];

	$sql = "DELETE FROM delivery_man WHERE id=".$id;
	if ($conn->query($sql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}

	echo "Delivery Agent deleted";
}
//header('Location: ' . $_SERVER['HTTP_REFERER']);
?>