<?php 

remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_action('genesis_before_content_sidebar_wrap', 'template_do_before_content_sidebar_wrap');
function template_do_before_content_sidebar_wrap(){

$taxonomy = get_queried_object();
	
			echo '<div class="has-accent-2-background-color wp-block-group alignfull has-background"><div class="wp-block-group__inner-container"><p class="has-h-1-font-size has-accent-1-color has-text-color">'.get_the_title( get_option('page_for_posts', true) ).'</p><h1 class="has-large-font-size has-accent-1-color has-text-color">'.$taxonomy->name.' tips and insights</h1></div></div>';

}

//Container Around Posts and Heading
add_action( 'genesis_before_loop', 'template_do_post_container', 11 );
function template_do_post_container(){

		
	echo '<div class="post-container">';
}

add_action( 'genesis_after_loop', 'template_do_post_container_close', 50 );
function template_do_post_container_close(){
	echo '</div>';
}


//Move image up
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'template_do_post_image', 6 );
function template_do_post_image() {
	if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
}

//Add link
add_action( 'genesis_entry_header', 'template_do_post_link', 1 );
function template_do_post_link(){
	echo '<a class="post-link" href="'. get_permalink() . '">';
}

add_action( 'genesis_after_entry', 'template_do_post_link_close', 55 );
function template_do_post_link_close(){
	echo '</a>';
}

genesis();