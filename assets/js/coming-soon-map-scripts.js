
//global variables
var map;
	
// declare namespace
var projectMap = {};

projectMap.initialize = function() {
	//center lat/long
	var centerLat = 38.535276;
	var centerLong = -100.141988;
  		
	var latlng = new google.maps.LatLng(centerLat,centerLong);
	
	var screenSize = jQuery( window ).width();
	
	switch(true) {
	    case (screenSize < 768):
	        zoomNumber = 3;
	        break;
	    default:
	        zoomNumber = 5;
	} 

	//map configutations
	var mapOptions = {
		zoom: zoomNumber,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		minZoom: 1,
		streetViewControl: false,
		mapTypeControl: false,
		disableDoubleClickZoom: true,
		styles: [{
		    "featureType": "poi",
		     "elementType": 'labels',
		    "stylers": [
		      { "visibility": "off" }
		    ]
		  }],
	};
	
	var infowindow = new google.maps.InfoWindow();

	//create the map
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	map.data.loadGeoJson('/wp-json/coming-markers');
	
	// When the user clicks, open an infowindow
	map.data.addListener('click', function(event) {
		
		infowindow.setContent('<div class="info-window">'+ event.feature.getProperty('description') +'</div>');
	
		// position the infowindow on the marker
		infowindow.setPosition(event.feature.getGeometry().get());
		
		// anchor the infowindow on the marker
		infowindow.setOptions({pixelOffset: new google.maps.Size(0,-30), maxWidth: 360});
		infowindow.open(map);
		map.setZoom(7);
		 map.setCenter(event.latLng); 
	});
	
	map.data.setStyle(function(feature) {
		 const image = {
	    url:
	      "/wp-content/themes/ellie/assets/images/map-icon.png",
	    // This marker is 20 pixels wide by 32 pixels high.
	     size: new google.maps.Size(48, 64),
		scaledSize: new google.maps.Size(18, 24),
	    // The origin for this image is (0, 0).
	    origin: new google.maps.Point(0, 0),
	    // The anchor for this image is the base of the flagpole at (0, 32).
	    anchor: new google.maps.Point(13, 28),
	  };
	    return {icon:image};
	  });

}


window.initMap = function(){
	projectMap.initialize(); 	
}