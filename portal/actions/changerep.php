<?php 
include '../inc/header.php';
if (isset($_GET["cid"]))
{
	$id = $_GET["cid"];
	$rid = $_GET["repid"];

	$ssql = "UPDATE form_completion SET

	representative_id='$rid'
	WHERE id=$id";
	
	if ($conn->query($ssql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	$sql3 = "SELECT * FROM representative WHERE id=".$rid." LIMIT 1";
	$result3 = $conn->query($sql3);
	$row3 = $result3->fetch_assoc();
	$representative = $row3['name'];

	echo $representative;
}

?>