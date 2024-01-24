<?php 

add_action( 'wp_enqueue_scripts', 'template_global_enqueues' );
function template_global_enqueues() {
	global $wp_query;
	
	wp_enqueue_script( 'jquery-ui-autocomplete' );

	
   	wp_enqueue_script( 'map-scripts',  get_stylesheet_directory_uri() . '/assets/js/map-scripts.js', array( 'jquery' ), '3.6.1', true );	
   	
   		wp_enqueue_script(  'google_map_api' );
}

remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'template_do_loop');
function template_do_loop(){

	echo '<div class="find-location"><div class="map"><div id="map_canvas"></div></div><div class="search">';
	
	echo '<div class="search-box"><div class="inner"><h1>Find your <strong>Ellie</strong></h1>';
		echo '<div class="search-form ui-widget"><input id="searchLocations" name="searchLocations" placeholder="Search by zip code or city…"><button  id="searchLocationsButton" onclick="searchForLocations();">Go</button></div>';

  echo ' <script> var locations = [' ;
		
		$locations = get_posts(array('post_type'=>'locations', 'numberposts' => -1, 'has_password' => false));
		
		foreach ($locations as $location) {
			$location_details = theme_get_field('google_maps_iframe', $location->ID);
			
			echo '{ url: "'. get_the_permalink($location->ID) . '", name:"'.get_the_title($location->ID) . ' ' . $location_details['state'] . ' Clinic", label: "' . get_the_title($location->ID) . '  ';
			 if($location_details['city'] == '') echo get_the_title($location->ID); else echo $location_details['city'];
			 echo ' '. $location_details['state'] .' '. $location_details['state_short'] .' ' .$location_details['post_code']. '"},';
		}

		echo ' ]; </script>';

	
	echo '</div></div>';
	
	echo '<div id="message"></div><div class="locations" id="results-list"></div>';
	
	echo '</div>';
	
	echo '</div>';
	
	echo '<div class="freaking wp-block-group alignfull has-background has-accent-2-background-color narrow"><div class="wp-block-group__inner-container"><div class="wp-block-columns valign"><div class="wp-block-column"><div class="wp-block-image"><img src="/wp-content/themes/ellie/assets/images/locations-coming-soon.png" width="432" height="454" alt="Happy therapist working at Ellie Mental Health"></div></div><div class="wp-block-column"><h2 class="has-accent-1-color has-text-color">New locations coming!</h2><h3 class="has-accent-1-color has-text-color">Ellie’s family is growing!</h3><p>Ellie wants to make it as easy as possible for everyone to get the care they need. We are looking forward to locations in these cities joining us in the coming months. We can’t wait to get to know all of you!</p><div class="wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link has-accent-4-background-color has-white-color" href="/locations-coming-soon/">View Coming Locations</a></div></div></div></div></div></div>';
}

genesis();