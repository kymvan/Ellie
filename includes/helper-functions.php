<?php 

//Return Icon SVG
function theme_get_icon( $atts = array() ) {
	$atts = shortcode_atts( array(
		'icon'	=> false,
		'size'	=> 36,
		'class'	=> false,
		'label'	=> false,
	), $atts );
	if( empty( $atts['icon'] ) )
		return;
	$icon_path = get_stylesheet_directory() . '/assets/icons/' . $atts['icon'] . '.svg';
	if( ! file_exists( $icon_path ) )
		return;
	$icon = file_get_contents( $icon_path );
	$class = 'svg-icon';
	if( !empty( $atts['class'] ) )
		$class .= ' ' . esc_attr( $atts['class'] );
	$repl = sprintf( '<svg class="' . $class . '" width="%d" height="%d" aria-hidden="true" role="img" focusable="false" ', $atts['size'], $atts['size'] );
	$svg  = preg_replace( '/^<svg /', $repl, trim( $icon ) ); // Add extra attributes to SVG code.
	$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
	$svg  = preg_replace( '/>\s*</', '><', $svg ); // Remove white space between SVG tags.
	if( !empty( $atts['label'] ) ) {
		$svg = str_replace( '<svg class', '<svg alt="' . esc_attr( $atts['label'] ) . '" class', $svg );
		$svg = str_replace( 'aria-hidden="true"', '', $svg );
	}
	return $svg;
}

//Return ACF field
function theme_get_field( $selector = '', $post_id = false, $format_value = true ) {
  if( function_exists( 'get_field' ) )
    return get_field( $selector, $post_id, $format_value );
}

//Return ACF option field
function theme_get_option_field( $selector = '', $post_id = false, $format_value = true ) {
  if( function_exists( 'get_field' ) )
    return get_field( $selector,'option' );
}

//Dynamically populate dropdown select in Font Awesome Icon block, Menu Item icon
add_filter( 'acf/load_field/name=font_awesome_icon', 'theme_acf_select_icon' );
function theme_acf_select_icon( $field ) {

	$field['choices'] = array( 0 => '(None)' );
	$icons = theme_get_theme_icons( );
	foreach( $icons as $icon ) {
		$field['choices'][ $icon ] = $icon;
	}

	return $field;
}

function theme_get_theme_icons( ) {
	$icons = get_option( 'ea_theme_icons' );
	$version = get_option( 'ea_theme_icons_version' );
	if( empty( $icons ) || ( defined( 'CHILD_THEME_VERSION' ) && version_compare( CHILD_THEME_VERSION, $version ) ) ) {
		$icons = scandir( get_stylesheet_directory() . '/assets/icons' );
		$icons = array_diff( $icons, array( '..', '.' ) );
		$icons = array_values( $icons );
		if( empty( $icons ) )
			return $icons;
		// remove the .svg
		foreach( $icons as $i => $icon ) {
			$icons[ $i ] = substr( $icon, 0, -4 );
		}
		update_option( 'ea_theme_icons', $icons );
		if( defined( 'CHILD_THEME_VERSION' ) )
			update_option( 'ea_theme_icons_version', CHILD_THEME_VERSION );
	}
	return $icons;
}

//*** JSON Endpoint ***//
add_action( 'rest_api_init', function ( $server ) {
    $server->register_route( 'map-markers', '/map-markers', array(
        'methods'  => 'GET',
        'callback' => function () {
            return map_marker_data();
        },
    ) );
    
     $server->register_route( 'coming-markers', '/coming-markers', array(
        'methods'  => 'GET',
        'callback' => function () {
            return coming_soon_map_marker_data();
        },
    ) );
    
    $server->register_route( 'landing—page-map-markers', '/landing-page-map-markers', array(
        'methods'  => 'GET',
        'callback' => function () {
            return landing_page_map_marker_data($_GET["term"]);
        },
    ) );
    
} );



function map_marker_data(){
	
	$markers = array();
	
	$locations = get_posts(array('post_type' =>'locations', 'posts_per_page'  =>'-1', 'orderby'=> array('title' => 'ASC'), 'has_password'=> FALSE ));
	
	foreach ($locations as $location) :
	
			if(!empty(theme_get_field('address_line_1', $location->ID))) $location_type = 'in-person';			
			else $location_type = 'telehealth';
		
			$location_details = theme_get_field('google_maps_iframe', $location->ID);
							
			if(has_post_thumbnail($location->ID)) $post_image =  get_the_post_thumbnail_url($location->ID, 'location');			
			else $post_image = '/wp-content/themes/ellie/assets/images/nolocation.jpg';
			
			$location_description = '<div class="location-image"><a href="'.get_permalink($location->ID).'"><img src="'.$post_image.'" alt="'.$location->post_title.' picture" /></a></div><div class="location-details"><p class="marker';
			
			if(empty(theme_get_field('address_line_1', $location->ID))) $location_description .= ' telehealth';
			
			$location_description .= '">'.theme_get_icon(array('icon' => 'map-marker-alt', 'size' => 16, 'label' => 'Map marker icon' ));
			
			if(!empty(theme_get_field('address_line_1', $location->ID))) $location_description .= $location_details['city'] . ', '. $location_details['state_short'];
			else $location_description .= 'Telehealth only';
			
			$location_description .= '</p><h2><a href="'.get_permalink($location->ID).'">'.$location->post_title.'</a></h2><p>';
			
			if(!empty(theme_get_field('address_line_1', $location->ID))) :$location_description .= theme_get_field('address_line_1', $location->ID);
			 if(!empty(theme_get_field('address_line_2', $location->ID))) $location_description .= ' <br/>' . theme_get_field('address_line_2', $location->ID);
			 $location_description .= ' <br/>'.theme_get_field('city_state_zip', $location->ID);		
			else : $location_description .= 'Telehealth available now. In-person therapy coming soon!';
			
			endif;
			
			$location_description .= '</p><p class="more-link"><a href="'.get_permalink($location->ID).'">View this location</a></p></div>'; 
			
			$location_data = array('title'=> $location->post_title, 'type'=> $location_type, 'lat'=> floatval($location_details['lat']), 'lng'=> floatval($location_details['lng']), 'description' => $location_description);

			
			array_push($markers, $location_data);
		
		
		
	endforeach;
	
	return array('locations' => $markers);

}

function landing_page_map_marker_data($term_id){
	
	$markers = array();
	
	$locations = get_posts(array('post_type' =>'locations', 'posts_per_page'  =>'-1', 'has_password'=> FALSE, 'tax_query' => array(array('taxonomy'=>'locations-page','field' => 'term_id','terms' => $term_id))));
	
	foreach ($locations as $location) :
	
			if(!empty(theme_get_field('address_line_1', $location->ID))) $location_type = 'in-person';			
			else $location_type = 'telehealth';
		
			$location_details = theme_get_field('google_maps_iframe', $location->ID);
							
			if(has_post_thumbnail($location->ID)) $post_image =  get_the_post_thumbnail_url($location->ID, 'location');			
			else $post_image = '/wp-content/themes/ellie/assets/images/nolocation.jpg';
			
			$location_description = '<div class="location-image"><a href="'.get_permalink($location->ID).'"><img src="'.$post_image.'" alt="'.$location->post_title.' picture" /></a></div><div class="location-details"><p class="marker';
						
			if(empty(theme_get_field('address_line_1', $location->ID))) $location_description .= ' telehealth';
			
			$location_description .= '">'.theme_get_icon(array('icon' => 'map-marker-alt', 'size' => 16, 'label' => 'Map marker icon' ));
			
			if(!empty(theme_get_field('address_line_1', $location->ID))) $location_description .= $location_details['city'] . ', '. $location_details['state_short'];
			else $location_description .= 'Telehealth only';
			
			$location_description .= '</p><h2><a href="'.get_permalink($location->ID).'">'.$location->post_title.'</a></h2><p>';
			
			$location_description .= '</p><p class="more-link"><a href="'.get_permalink($location->ID).'">View this location</a></p></div>'; 
			
			$location_data = array('title'=> $location->post_title, 'type'=> $location_type, 'lat'=> floatval($location_details['lat']), 'lng'=> floatval($location_details['lng']), 'description' => $location_description);

			
			array_push($markers, $location_data);
		
		
		
	endforeach;
	
	return array('term_id' => $term_id, 'locations' => $markers);

}

function coming_soon_map_marker_data(){
	
	$markers = array();
	
	$locations = get_posts(array('post_type' =>'locations-coming', 'posts_per_page'  =>'-1', 'orderby'=> array('meta_value' => 'ASC', 'title' => 'ASC'), 'meta_key' => 'state', 'has_password'=> FALSE ));
	
	foreach ($locations as $location) :
	
			$location_details = theme_get_field('location', $location->ID);
			
			$location_description = '<div class="location-details"><h2>'.$location->post_title.'</h2>';
			
			
			if(!empty(theme_get_field('address', $location->ID))) $location_description .=  '<p class="address">' . theme_get_field('address', $location->ID) . '</p>'; 
			
			$location_description .= '<p>' . $location_details['city'] . ', ' . $location_details['state_short'] . '</p>'; 
			
			if(!empty(theme_get_field('coming_date', $location->ID))) $location_description .= '<p><em>Coming ' . theme_get_field('coming_date', $location->ID) . '</em></p>'; 
			
			$location_description .= '</div>'; 
							
						
			$location_data = array('type'=>'Feature', 'properties' => array('title'=> $location->post_title, 'description'=> $location_description,'id'=> $location->post_name), 'geometry' => array('type' => 'Point', 'coordinates' => array(floatval($location_details['lng']), floatval($location_details['lat']))));


			
			array_push($markers, $location_data);
		
		
		
	endforeach;
	
	//return array('locations' => $markers);
	return array('type'=> 'FeatureCollection', 'features' => $markers);

}



function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
 }

//Search WP
add_filter( 'searchwp_and_logic_only', '__return_true' );