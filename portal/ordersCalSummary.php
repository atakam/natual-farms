<?php
include 'inc/header.php';
?>
<title>Orders</title>

<!-- Sidebar -->
<?php
if ($customer_flag=='0') {
include 'inc/menu.php';
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Orders</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <a href="orders.php" target="_blank" class="btn btn-inverse btn-mini"><i class="icon-th-list icon-white"></i> List View</a>
	  </div>
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

<!-- footer -->
<?php
include 'inc/footer.php';
?>

<?php 
//$sql = "SELECT * FROM form_completion WHERE representative_id=".$user_id;
if ($admin_flag=='1') {
	$sql = "SELECT * FROM form_completion";
}
$sql = "SELECT * FROM form_completion";
$result = $conn->query($sql);

$delivery1 = array();
$delivery2 = array();
$delivery3 = array();

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
	
	echo 'addEventToCalendar("'.$name.'", "'.$date.'", "#f'.$row['id'].'", "#62c462");';
	echo 'addEventToCalendar("'.$name.'", "'.$date2.'", "#s'.$row['id'].'", "#fb7a2c");';
	echo 'addEventToCalendar("'.$name.'", "'.$date3.'", "#t'.$row['id'].'", "#ee5f5b");';
	
}
echo '});';
echo '</script>';
}
else {
	header("Location: customer_orders.php");
}



?>
