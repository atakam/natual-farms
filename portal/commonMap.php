<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 400px;
      }
      .infowindow {
        margin: 4px;
        
      }
    </style>
<script>
var items = {};
var dateValGlobal;
var dateVal2Global;
var scriptAdded = false;
function generateMap(dateVal, dateVal2, dateVal3)
{
	var monthly = dateVal2.length === 6;
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (!document.getElementById("map"+dateVal2)) {
				return;
			}
			if (document.getElementById(dateVal+dateVal+dateVal)) {
				document.getElementById(dateVal+dateVal+dateVal).innerHTML = this.responseText;
			}

			var areas = document.getElementsByClassName("maparea");
			var i;
			for (i=0; i<areas.length; i++)
			{
				areas[i].innerHTML = "";
			}
// 			var area = document.getElementById("area"+dateVal);
// 			if (area == null)
// 			{
// 				return;
// 			}

			var area = document.getElementById("map"+dateVal2);

			var div1 = document.createElement('div');
			div1.setAttribute( 'id', "map"+dateVal2 );
			div1.setAttribute( 'class', "modal hide" );
			area.appendChild( div1 );

			var div2 = document.createElement('div');
			div2.setAttribute( 'class', "modal-header" );
			div1.appendChild( div2 );

			var button = document.createElement('button');
			button.setAttribute( 'data-dismiss', "modal" );
			button.setAttribute( 'class', "close" );
			button.setAttribute( 'type', "button" );
			button.appendChild(document.createTextNode("x"));
			div2.appendChild( button );

			var h = document.createElement('h3');
			h.appendChild(document.createTextNode("Map View for "+dateVal3));
			div2.appendChild( h );

			var div3 = document.createElement('div');
			div3.setAttribute( 'class', "modal-body" );
			div1.appendChild( div3 );

			var div4 = document.createElement('div');
			div4.setAttribute( 'id', "map" );
			div3.appendChild( div4 );
			
		 	var html = '<div>';
		 	html += '<div class="modal-header">';
		 	html += '<button data-dismiss="modal" class="close" type="button">×</button>';
		 	html += '<h3>Map View for '+dateVal+'</h3>';
		 	html += '</div>';
		 	html += '<div class="modal-body" style="height:100vh">';
		 	html += '<div id="map"></div>';
		 	html += '</div>';
		 	html += '</div>';

		 	area.innerHTML = html;

			dateValGlobal = dateVal;
			dateVal2Global = dateVal2;

//		 	var arr = [];
			
//		 	for(var x in parsed){
//		 		arr.push(parsed[x]);
//		 	}
			//alert(jsonVal);

			addScript("https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js", "map"+dateVal2);
			addAsycScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyCG96uvI2VSpkjz2bcUz0rmGE5LAHroAOc&callback=initMap", "map"+dateVal2);
		}
	};
	var url = 'generate/map.php?date='+dateVal+'&confirm=false';
	if (monthly) {
		url = 'generate/monthMap.php?date='+dateVal+'&confirm=false';
	}
	xhttp.open('GET', url, true);
	xhttp.send();

	return true;
}

function initMap() {
	var json = document.getElementById(dateValGlobal+dateValGlobal+dateValGlobal).innerHTML;
	arr = JSON.parse(json);
	var arra = [];

    for(var x in arr){
      arra.push(arr[x]);
    }
    
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 11,
		center: {lat: 45.4765458, lng: -75.701272}
	});

			
		// Add some markers to the map.
		// Note: The code uses the JavaScript Array.prototype.map() method to
		// create an array of markers based on a given "locations" array.
		// The map() method here has nothing to do with the Google Maps API.
		var markers = arra.map(function(location, i) {
			var name = location[0];
			var date = location[1];
			var order = location[2];
			var postal = location[3];
			var address = location[4];
			var phone = location[5];

			var geocoder= new google.maps.Geocoder();
			setTimeout(function(){
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

					alert("Geocode was not successful for the following reason: " + status);
				}
			});
			}, 800 * i);
				 
		});
				
			// Add a marker clusterer to manage the markers.
			var markerCluster = new MarkerClusterer(map, markers,
			{imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
}

function addScript( src , id) {
	  var s = document.createElement( 'script' );
	  s.setAttribute( 'src', src );
	  document.getElementById(id).appendChild( s );
}
function addAsycScript( src , id) {
	  var s = document.createElement( 'script' );
	  s.setAttribute( 'src', src );
	  s.setAttribute( 'async', '');
	  s.setAttribute( 'defer', '');
	  document.getElementById(id).appendChild( s );
}
</script>