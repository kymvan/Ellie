<?php 

remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_headline', 10, 3 );
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );

//Container Around Posts
add_action( 'genesis_before_loop', 'template_do_post_container', 11 );
function template_do_post_container(){
	
	$taxonomy = get_queried_object();
	
		echo '<div class="wp-container-1 wp-block-group alignfull has-accent-2-background-color has-background"><div class="wp-block-group__inner-container"><h1 class="has-accent-1-color has-text-color has-h-1-font-size">'.$taxonomy->name.'</h1><p class="has-accent-1-color has-text-color has-large-font-size">The latest updates and media coverage</p></div></div>';

	
	echo '<div class="post-container">';
}

add_action( 'genesis_after_loop', 'template_do_post_container_close', 50 );
function template_do_post_container_close(){
	echo '</div>';
}

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'template_do_post_title', 7 );
function template_do_post_title(){
	echo '<h2 class="entry-title" itemprop="headline">'.get_the_title().'</h2>';
	if(!empty(theme_get_field('author'))) echo '<p class="author">By '.theme_get_field('author').'</p>';
}

//Move image up
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'template_do_post_image', 6 );
function template_do_post_image() {
	if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
	else echo '<img width="1000" height="527" src="'.get_stylesheet_directory_uri().'/assets/images/no-post-image.jpg" class="attachment-thumbnail size-thumbnail wp-post-image" alt="Ellie Logo - No image available" loading="lazy">';
}

//Add link
add_action( 'genesis_entry_header', 'template_do_post_link', 1 );
function template_do_post_link(){
	if(!empty(theme_get_field('redirect'))) echo '<a class="post-link" href="'. theme_get_field('redirect') . '" target="_blank">';
	else echo '<a class="post-link" href="'. get_permalink() . '">';
}

add_action( 'genesis_after_entry', 'template_do_post_link_close', 55 );
function template_do_post_link_close(){
	echo '</a>';
}

//Full content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'template_do_post_content' );
function template_do_post_content(){
	the_content();
	
}

genesis();