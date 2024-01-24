<?php 

remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_headline', 10, 3 );
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//Container Around Posts
add_action( 'genesis_before_loop', 'template_do_post_container', 11 );
function template_do_post_container(){
	
	$taxonomy = get_queried_object();
	
		echo '<div class="wp-container-1 wp-block-group alignfull has-accent-2-background-color has-background"><div class="wp-block-group__inner-container"><h1 class="has-accent-1-color has-text-color has-h-1-font-size">'.$taxonomy->name.'</h1><p class="has-accent-1-color has-text-color has-large-font-size">Ellie locations in '.$taxonomy->name.'</p></div></div>';

	if($taxonomy->description != '') :
		echo '<div class="wp-block-group"><div class="wp-block-group__inner-container">'.$taxonomy->description.'</div></div>';
	endif;
	
	echo '<div class="post-container">';
}

add_action( 'genesis_after_loop', 'template_do_post_container_close', 50 );
function template_do_post_container_close(){
	echo '</div>';
}

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'template_do_post_title', 7 );
function template_do_post_title(){
	$location_details = theme_get_field('google_maps_iframe');
							
	echo '<div class="location-details"><p class="marker">'.theme_get_icon(array('icon' => 'map-marker-alt', 'size' => 16, 'label' => 'Map marker icon' )). $location_details['city'] . ', '. $location_details['state'] . '</p>';


	echo '<h2 class="entry-title" itemprop="headline">'.get_the_title().'</h2>';
	
	echo '<p>'.theme_get_field('address_line_1', $location->ID).' ' . theme_get_field('address_line_2', $location->ID). '<br> '.theme_get_field('city_state_zip', $location->ID).'</p><p class="more-link"><a href="'.get_permalink($location->ID).'">View this location</a></p></div>';

}

//Move image up
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'template_do_post_image', 6 );
function template_do_post_image() {
	echo '<div class="location-image">';
	if(!empty(theme_get_field('redirect'))) echo '<a class="post-link" href="'. theme_get_field('redirect') . '" target="_blank">';
	else echo '<a class="post-link location-image" href="'. get_permalink() . '">';
	
	if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(), 'location');
	else echo '<img width="500" height="500" src="/wp-content/themes/ellie/assets/images/no-location-image.jpg" class="attachment-thumbnail size-thumbnail wp-post-image" alt="Ellie Logo - No image available" loading="lazy">';
	
	echo '</a></div>';
}




genesis();