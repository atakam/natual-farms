<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='0') {
include 'inc/menu.php';

include 'commonMap.php';
?>



<div id="content" onclick='hideContextMenu()'>
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Orders</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <a href="orders.php" class="btn btn-inverse btn-mini"><i class="icon-th-list icon-white"></i> List View</a>
	  </div>
	  If a date seems off after you drag and drop, please refresh the page.
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-calendar">
          <div class="widget-title"> <span class="icon"><i class="icon-calendar"></i></span>
            <h5>Calendar: Calendar View</h5>
          </div>
          <div class="widget-content">
            <div class="panel-left" style="margin-top:27px">
              <div id="fullcalendar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id='calendar-load'></div>
<?php 
$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
if ($admin_flag=='1') {
	$sql = "SELECT * FROM form_completion";
}
$result = $conn->query($sql);

$delivery1 = array();
$delivery2 = array();
$delivery3 = array();
$deliveryMonths = array();

echo '<script type="text/javascript">';
echo '$(document).ready(function(){';
while ($row = $result->fetch_assoc())
{
	$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
	$result2 = $conn->query($sql2);
	$row2 = $result2->fetch_assoc();

	if($row2['isactive'] == '0')
	{
		continue;
	}

	$status = "Completed";
	if ($row['status'] === "0")
	{
		$status = "ID not assigned";
	}


	// 		$edited = $row['edited_points'] != 0 ? "<i style='color: red; font-weight: bold;'>FORM EDITED</i>": "";
	$edited = "";	// For now we don't need to handle the customer edit

	$name = "$row2[firstname] $row2[lastname]";
	$date = $row['conditions_firstdeliverydate'] . "GMT-0500";
	$date2 = $row['conditions_seconddeliverydate'] . "GMT-0500";
	$date3 = $row['conditions_thirddeliverydate'] . "GMT-0500";

	if (!in_array($row['conditions_firstdeliverydate'], $delivery1))
	{
		array_push($delivery1, $row['conditions_firstdeliverydate']);
	}
	if (!in_array($row['conditions_seconddeliverydate'], $delivery2))
	{
		array_push($delivery2, $row['conditions_seconddeliverydate']);
	}
	if (!in_array($row['conditions_thirddeliverydate'], $delivery3))
	{
		array_push($delivery3, $row['conditions_thirddeliverydate']);
	}

	// For monthly map view
	$month1 = explode("-", $row['conditions_firstdeliverydate'])[0] ."-". explode("-", $row['conditions_firstdeliverydate'])[1];
	$month2 = explode("-", $row['conditions_seconddeliverydate'])[0] ."-". explode("-", $row['conditions_seconddeliverydate'])[1];
	$month3 = explode("-", $row['conditions_thirddeliverydate'])[0] ."-". explode("-", $row['conditions_thirddeliverydate'])[1];
	if (!in_array($month1, $deliveryMonths))
	{
		array_push($deliveryMonths, $month1);
	}
	if (!in_array($month2, $deliveryMonths))
	{
		array_push($deliveryMonths, $month2);
	}
	if (!in_array($month3, $deliveryMonths))
	{
		array_push($deliveryMonths, $month3);
	}

	$confirm1 = $row['confirm1']==1?'C':'N';
	$confirm2 = $row['confirm2']==1?'C':'N';
	$confirm3 = $row['confirm3']==1?'C':'N';

	if ($row['deliver1'] == 0) {
		echo 'addEventToCalendar("('.$confirm1.') 1 - '.$name.'", "'.$date.'", "#f'.$row['id'].'", "#62c462");';
	}
	if ($row['deliver2'] == 0) {
		echo 'addEventToCalendar("('.$confirm2.') 2 - '.$name.'", "'.$date2.'", "#s'.$row['id'].'", "#fb7a2c");';
	}
	if ($row['deliver3'] == 0) {
		echo 'addEventToCalendar("('.$confirm3.') 3 - '.$name.'", "'.$date3.'", "#t'.$row['id'].'", "#ee5f5b");';
	}
}
echo '});';
echo '</script>';
?>
<script>
var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == XMLHttpRequest.DONE ) {
       if (xmlhttp.status == 200) {
    	   document.getElementById('calendar-load').innerHTML = xmlhttp.responseText;
       }
    }
};

xmlhttp.open("GET", "inc/ordersCalView.php", true);
xmlhttp.send();
</script>

<!-- footer -->
<?php
}
include 'inc/footer.php';
?>
