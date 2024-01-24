
//global variables
var map;
var markers = [];   
    
	
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
	        zoomNumber = 4;
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

	//create the map
    var latlngbounds = new google.maps.LatLngBounds();
	var infoWindow = new google.maps.InfoWindow({pixelOffset: new google.maps.Size(-15, -5)});
	map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	
	

		
	jQuery.getJSON('/wp-json/map-markers',function(data){
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
	
	

	
	
	google.maps.event.addListener( map, 'tilesloaded', function() {
			var results = showMapResults();
			if(results == 0){
				jQuery( '#results-list' ).append(
		          jQuery( '<div class="location" />' )
		           .html( '<div class="inner message">Sorry!  There are no Ellies in this area.  <a href="/locations-coming-soon/">Check out our locations coming soon!</a></div>' )
		        );
			}else if( jQuery('#searchLocations').val() != ''){
				if(results== 1){
				jQuery( '#results-list' ).prepend(
					jQuery( '<div class="location" />' )
		           .html( '<div class="inner message">Your search found 1 Ellie within 20 miles of <span class="searchQuery">' + jQuery('#searchLocations').val() + '</span>!</div>' )
		        );
				
				
				}else {
				jQuery( '#results-list' ).prepend(
					jQuery( '<div class="location" />' )
		           .html( '<div class="inner message">Your search found ' + results + ' Ellies within 20 miles of <span class="searchQuery">' + jQuery('#searchLocations').val() + '!</span></div>' )
		        );
				jQuery('#searchLocations').val('');
				}
			}	
	});
	
	
	

}


function searchForLocations(){
	jQuery.getJSON('https://maps.googleapis.com/maps/api/geocode/json?address='+jQuery('#searchLocations').val()+'&key=AIzaSyDLBNwZfRrX8oKcL4sMY4OzccEc6ZgakUE', function(data) {
				if(data.status != 'OK'){ 
					alert('Please enter a more specific search term.');
				}
				else if(data.results[0].types[0] == 'administrative_area_level_1' || data.results[0].types[0] == 'country'){ 
					alert('Please enter a zip code or city.');}
				else{
					var latlng = new google.maps.LatLng(
					data.results[0].geometry.location.lat,data.results[0].geometry.location.lng);  
					map.setCenter(latlng);
					map.setZoom(11);
				}
				
     }).error(function(){
            alert('Please enter a more specific search term.');
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
			
			try {
			  if ( bounds.contains( current_marker.getPosition() ) ) {
	
	       		boundsMarkers.push([google.maps.geometry.spherical.computeDistanceBetween(current_marker.position, map.getCenter()), current_marker.description]);
	
				}
			}
			catch(err) {
			  //alert('map is not yet loaded');
			}
	
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

function showLocation(position) {
           var latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
			map.setCenter(latlng);
			map.setZoom(11);
}

window.initMap = function(){
	projectMap.initialize(); 
	
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showLocation);
    }
	
	 jQuery( "#searchLocations" ).autocomplete({
      minLength: 0,
      source: locations,
      focus: function( event, ui ) {
        return false;
      },
      select: function( event, ui ) {
 
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return jQuery( "<li>" )
        .append( "<div><a href=\"" + item.url + "\">" + item.name + "</a></div>" )
        .appendTo( ul );
    };
	
	jQuery( "#searchLocations" ).on( "keypress", function(event) {
	  if (event.key === "Enter") {
	    event.preventDefault();
		jQuery( "#searchLocationsButton" ).click();
	  }
	});
}