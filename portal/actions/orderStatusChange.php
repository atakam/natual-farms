<?php 
include '../inc/config.php';
if (isset($_GET["id"]))
{
	$id = $_GET["id"];
	$tag = $_GET["status"].$_GET["pos"];
	$ssql = "UPDATE form_completion SET
	$tag='1'
	WHERE id=$id";
	
	if ($conn->query($ssql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
}

?>