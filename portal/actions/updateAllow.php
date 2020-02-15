<?php 
include '../inc/config.php';
if (isset($_POST["fid"]))
{
	$id = $_POST["fid"];
	$value = $_POST["value"];

	$ssql = "UPDATE form_completion SET

	allowAccess='$value'
	WHERE id=$id";
	
	if ($conn->query($ssql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	echo $value;
}
?>