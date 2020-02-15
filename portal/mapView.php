<?php
include 'inc/header.php';
?>
<title>Map View</title>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    
<!-- Sidebar -->
<?php
if ($customer_flag=='0') {
include 'inc/menu.php';

$customers = array();

if ($admin_flag=='1' || $delivery_flag=='1') {
	$sql = "SELECT * FROM form_completion";
	
	$result = $conn->query($sql);
	
	while ($row = $result->fetch_assoc())
	{
		$sql2 = "SELECT * FROM customer WHERE id=".$row['customer_id']." LIMIT 1";
		$result2 = $conn->query($sql2);
		$row2 = $result2->fetch_assoc();
		
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
		
		$curlSession = curl_init();
    curl_setopt($curlSession, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?address='.$row2['postalcode']);
    curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

    $output = json_decode(curl_exec($curlSession));
    curl_close($curlSession);
		
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		
		array_push($customers, [$row2['firstname'].' '.$row2['lastname'], $nextdate, $delivery, $row2['postalcode'], $row2['streetaddress1']." ".$row2['streetaddress2'], $row2['phone']]);
	}
}

$jsonVal = json_encode($customers);
$jsonVal = str_replace("'"," ",$jsonVal);

?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
    	<a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
    	<a href="#" class="current">Map View</a> 
    </div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
	  <div class="buttons"> 
	      <a href="customers.php" class="btn btn-inverse btn-mini"><i class="icon-th-list icon-white"></i> List View</a>
	  </div>
  	</div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-calendar">
          <div class="widget-title"> <span class="icon"><i class="icon-calendar"></i></span>
            <h5>Customers Map View</h5>
          </div>
          <div class="widget-content">
            <div class="panel-left" style="margin-top:27px">
              <div id="map"></div>
			    <script>
			    var jsonVal = '<?= $jsonVal;?>';
			    var parsed = JSON.parse(jsonVal);

			    var arr = [];

			    for(var x in parsed){
			      arr.push(parsed[x]);
			    }
			  	//alert(jsonVal);
			    
			      function initMap() {
			
			        var map = new google.maps.Map(document.getElementById('map'), {
			          zoom: 11,
			          center: {lat: 45.4765458, lng: -75.701272}
			        });

			        
			        
			
			        // Add some markers to the map.
			        // Note: The code uses the JavaScript Array.prototype.map() method to
			        // create an array of markers based on a given "locations" array.
			        // The map() method here has nothing to do with the Google Maps API.
			        var markers = arr.map(function(location, i) {
			        	var name = location[0];
						var date = location[1];
						var order = location[2];
						var postal = location[3];
						var address = location[4];
						var phone = location[5];
				        
			        	var geocoder= new google.maps.Geocoder();
			        	geocoder.geocode({
			                'address': postal
			            }, function (results, status) {

			                if (status == google.maps.GeocoderStatus.OK) {

			                    // Center map on location
			                    map.setCenter(results[0].geometry.location);

			                    var contentString = '<div class="infowindow">'+
							    '<i class="fa fa-user"></i> <b>'+name+'</b><br>'+
							    '<i class="fa fa-map-marker"></i> <i>'+address+' '+postal+'</i><br>'+
							    '<i class="fa fa-phone"></i> <i>'+phone+'</i><br>'+
								//'<a href="#cf'+dateVal2Global+'" data-dismiss="modal">Go to Order Summary</a>'+
								'</div>';
								
			                    var infowindow = new google.maps.InfoWindow({
			                        content: contentString
			                      });
			                    // Add marker on location
			                    var marker = new google.maps.Marker({
			                        position: results[0].geometry.location,
			                        map: map,
			                        title: name
			                    });
			                    marker.addListener('click', function() {
			                        infowindow.open(map, marker);
			                      });

			                    //alert(results[0].geometry.location);

			                } else {

			                    //alert("Geocode was not successful for the following reason: " + status);
			                }
			            });
			          
			        });
			
			        // Add a marker clusterer to manage the markers.
			        var markerCluster = new MarkerClusterer(map, markers,
			            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
			      }
			    </script>
			    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
			    </script>
			    <script async defer
			    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG96uvI2VSpkjz2bcUz0rmGE5LAHroAOc&callback=initMap">
			    </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- footer -->
<?php
}

include 'inc/footer.php';
?>
