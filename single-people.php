<?php 

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

add_action( 'genesis_entry_header', 'template_do_post_title' );
function template_do_post_title(){
	echo '<h1 class="entry-title">'.get_the_title();
	
	if(!empty(theme_get_field('credentials'))) echo ', '.theme_get_field('credentials');
	
	echo '</h1>';
	
	
	if(!empty(theme_get_field('title_1'))) echo '<h2 class="title">'.theme_get_field('title_1'). '</h2>';
	

	
}



	
genesis();