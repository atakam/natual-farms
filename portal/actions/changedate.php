<?php 
include '../inc/config.php';
if (isset($_GET["fid"]))
{
	$id = $_GET["fid"];
	$datetag = $_GET["datetag"];
	$datetag = rtrim($datetag, 'm');
	$date = $_GET["date"];

	$ssql = "UPDATE form_completion SET

	$datetag='$date'
	WHERE id=$id";
	
	if ($conn->query($ssql) === FALSE){
		echo 'DB Error ' . mysqli_errno($conn) . ": " . mysqli_error($conn). "\n";
		exit();
	}
	
	if (strtotime($date) < time()) {
		?>
			<span style='color:#ee5f5b'><?php echo $date?></span>
	    <?php 
	} 
	else {
		?>
			<span style='color:#666'><?php echo $date?></span>
	    <?php 
	}
}

?>