<?php

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//Add Search Archive title
add_action( 'genesis_before_loop', 'theme_do_search_title' );
function theme_do_search_title() {
	
			echo '<div class="wp-container-1 wp-block-group alignfull has-accent-2-background-color has-background"><div class="wp-block-group__inner-container"><h1 class="has-accent-1-color has-text-color has-h-1-font-size">Search Results</h1><p class="has-accent-1-color has-text-color has-large-font-size">Results for: <em>'.get_search_query().'</em></p></div></div>';


	echo apply_filters( 'genesis_search_title_output', $title ) . "\n"; 
	

}

//Move image up
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'template_do_post_image', 3 );
function template_do_post_image(){
	if(has_post_thumbnail()) echo '<a href="'.get_permalink().'">' . get_the_post_thumbnail($person->ID, 'team', array('alt' => get_the_title($person->ID) . ' headshot')) . '</a>';
}




genesis();