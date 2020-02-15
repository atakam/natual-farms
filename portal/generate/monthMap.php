<?php 

include '../inc/config.php';

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
$confirm = isset($_GET['confirm']) ? $_GET['confirm'] === 'true' : false;

$sql = "SELECT * FROM form_completion WHERE (conditions_firstdeliverydate LIKE '%$date%') OR
(conditions_seconddeliverydate LIKE '%$date%') OR
(conditions_thirddeliverydate LIKE '%$date%')";
if ($confirm == true){
	$sql = "SELECT * FROM form_completion WHERE (conditions_firstdeliverydate LIKE '%$date%' AND confirm1=1) OR
	(conditions_seconddeliverydate LIKE '%$date%' AND confirm2=1) OR
	(conditions_thirddeliverydate LIKE '%$date%' AND confirm3=1)";
}
//echo $sql;
$result = $conn->query($sql);
$customers = array();
$found = false;

while ($row = $result->fetch_assoc())
{
	$found = true;
	$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();

	if($row2['isactive'] == '0')
	{
		continue;
	}

	$nextdate = $row['conditions_firstdeliverydate'];
	$delivery = 1;
	if(strtotime($nextdate) < strtotime('now') ) {
		$nextdate = $row['conditions_seconddeliverydate'];
		$delivery = 2;
	}
	if(strtotime($nextdate) < strtotime('now') ) {
		$nextdate = $row['conditions_thirddeliverydate'];
		$delivery = 3;
	}
	// Get lat and long by address
	//$geocode=file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$row2['postalcode']);

	array_push($customers, [$row2['firstname']." ".$row2['lastname'],
			$nextdate, $delivery, $row2['postalcode'],
			$row2['streetaddress1']." ".addslashes($row2['streetaddress2']),
			$row2['phone']]);
}

if ($found == false)
{
	return;
}

$jsonVal = json_encode($customers);
$idx = $date.$date.$date;

// 	echo '<div id="area'.$date.'" class="maparea"></div>';

// 	//$jsonVal = addslashes($jsonVal);
// 	// storing json object
// 	echo '<div id="'.$date.$date.$date.'" style="display: none;">'.$jsonVal.'</div>';
//echo '</div></div>';
echo $jsonVal;

$jsonVal = json_encode($customers);

?>