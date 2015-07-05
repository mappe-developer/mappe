/* javascript for mapping tool */

/*global variable to share map */
var map = null; var info_window = new google.maps.InfoWindow();

/* handles the initial settings and styling for google maps */
function initialize() {
	  var map_options = {
		zoom: 7,
		center: new google.maps.LatLng(1.290270, 103.851959),
		mapTypeControl: true,
		mapTypeControlOptions: { style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR, position: google.maps.ControlPosition.BOTTOM_CENTER },
		panControl: false,
		scaleControl: true,
		streetViewControl: true,
		streetViewControlOptions: { position: google.maps.ControlPosition.RIGHT_BOTTOM },
		zoomControl: true,
		zoomControlOptions: { style: google.maps.ZoomControlStyle.SMALL, position: google.maps.ControlPosition.RIGHT_BOTTOM }
	  }
	  
	 map = new google.maps.Map(document.getElementById('map-canvas'), map_options); 
	 google.maps.event.addListener(map, 'click', function(event) { add_marker(event.latLng); });
} 

function add_marker(location) {
	map.markers = [];  
	if(map != null) { //ensure that map is initialized
    	var marker = new google.maps.Marker({ position: location, map: map, animation: google.maps.Animation.DROP });
		
    	google.maps.event.addListener(marker, 'rightclick', function(event) { marker.setMap(null); });
		google.maps.event.addListener(marker, 'click', function() { show_info(marker, location) });
    	map.markers.push(marker); 
	}
}

function show_info(marker, location) {
	if(map != null) {
		var content = '<div class="info_window">' + 
					  '<input type="text" placeholder="Location" /><hr/>' + 
					  '<input type="textarea" placeholder="Comments" cols="40" rows="5" />' + 
					  '<p>Latitude= ' + location.lat() + ' Longitude = ' + location.lng() + '</p>' + 
					  '</div>';
		info_window.setContent(content);
   		info_window.open(map, marker);  
	}
}

google.maps.event.addDomListener(window, 'load', initialize);

