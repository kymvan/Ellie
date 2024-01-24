
//global variables
var map;
var markers = [];   
	
// declare namespace
var projectMap = {};

projectMap.initialize = function() {
			
	var latlng = new google.maps.LatLng(centerLat,centerLong);
	
	var screenSize = jQuery( window ).width();
	
	switch(true) {
	    case (screenSize < 768):
	        zoomNumber = 6;
	        break;
	    default:
	        zoomNumber = 7;
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

	//create the map
    var latlngbounds = new google.maps.LatLngBounds();
	var infoWindow = new google.maps.InfoWindow({pixelOffset: new google.maps.Size(-15, -5)});
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	

		
	jQuery.getJSON('/wp-json/landing-page-map-markers?term='+term,function(data){
            console.log('success');
            jQuery.each(data.locations,function(i,loc){
				
			var myLatlng = new google.maps.LatLng(parseFloat(loc.lat), parseFloat(loc.lng));
			
			
			if(loc.type == 'in-person'){
				var iconImage = "/wp-content/themes/ellie/assets/images/map-icon.png";

			} else {
				var iconImage = "/wp-content/themes/ellie/assets/images/map-telehealth-icon.png";
			}
			
			const image = {
					url: iconImage,
					size: new google.maps.Size(48, 64),
					scaledSize: new google.maps.Size(18, 24),
					origin: new google.maps.Point(0, 0),
					anchor: new google.maps.Point(0, 0),
				};
			
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: loc.title,
				icon: image,
				description: loc.description
            });
			markers.push(marker);
          (function (marker, loc) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent('<div class="info-window">'+loc.description+'</div>');
                    infoWindow.open(map, marker);
					map.panTo(marker.position);
					map.setZoom(17);
                });
            })(marker, loc);
           
		   latlngbounds.extend(marker.position);
		  var results =  showMapResults();
            });
        }).error(function(){
            console.log('error');
        });	
	

	
	
	

}




function showMapResults(){
	var current_marker;
	jQuery('#results-list').empty();
		bounds = map.getBounds();
		var results = 0;
		var boundsMarkers = []
		
		for ( i = 0, l = markers.length; i < l; i++ ) {
			current_marker = markers[ i ];
			boundsMarkers.push([google.maps.geometry.spherical.computeDistanceBetween(current_marker.position, map.getCenter()), current_marker.description]);
	
		}	
		
		
		boundsMarkers.sort(function(a, b) {
			return a[0] - b[0];
		});
		
		for ( i = 0, l = boundsMarkers.length; i < l; i++ ) {
			current_marker = boundsMarkers[ i ];
			
			if ( 0 === jQuery( '#map-marker-' + i ).length ) {
		
		        jQuery( '#results-list' ).append(
		          jQuery( '<div class="location" />' )
		           .attr( 'id', 'map-marker-' + i )
		           .html( '<div class="inner">' + current_marker[1] + '</div>' )
		        );
						
		     }
			
		}	

	
		
		return boundsMarkers.length;
	
}



window.initMap = function(){
	projectMap.initialize(); 
	
}