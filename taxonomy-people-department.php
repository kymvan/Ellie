<?php 

remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_headline', 10, 3 );
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

//Container Around Posts
add_action( 'genesis_before_loop', 'template_do_post_container', 15);
function template_do_post_container(){
	
	$taxonomy = get_queried_object();
	
		echo '<div class="wp-container-1 wp-block-group alignfull has-accent-2-background-color has-background"><div class="wp-block-group__inner-container"><h1 class="has-accent-1-color has-text-color has-h-1-font-size">Meet our Teams</h1><p class="has-accent-1-color has-text-color has-large-font-size">Blending innovation and compassion</p></div></div>';
		
		echo '<div class="wp-block-group alignfull has-off-white-background-color has-background"><div class="wp-block-group__inner-container">';
	
	//Terms
	$departments = get_terms('people-department');
	
	echo '<div class="department-nav"><ul class="menu">';
	
	$departments_nav = array();
	$departments_order = array();
	
	foreach ($departments as $department) {
		if($department->parent < 1 && theme_get_field('department_order', $department) != 0 && theme_get_field('department_order', $department) != '') :
			array_push($departments_nav, array( $department->name, get_term_link($department->term_id, 'people-department')));

			array_push($departments_order, theme_get_field('department_order', $department));
		endif;
	}

		
	array_multisort($departments_order, $departments_nav);
	
	foreach ($departments_nav as $key => $department) {
		echo '<li><a href="'.$department[1].'">'.$department[0].'</a></li>';
	}
	
	echo '</ul></div>';
	
	echo '<h2 class="has-accent-1-color has-text-color">Ellie\'s '.$taxonomy->name.' Team </h2><p class="has-large-font-size">Ellie Mental Health brings together an exceptional team of creative and caring humans, dedicated to providing the best mental health services for everyone in our community.</p>';

	
	$term = get_queried_object();
	
	
	 if ( count( get_term_children( $term->term_id, 'people-department' ) ) < 1 ) {
    	echo '<div class="people-block"><div class="post-container">';
  	}
	
	
}

add_action( 'genesis_after_loop', 'template_do_post_container_close', 50 );
function template_do_post_container_close(){
	$term = get_queried_object();
		
	 if ( count( get_term_children( $term->term_id, 'people-department' ) ) < 1 ) {
    		echo '</div></div>';
  	}
  	
  	echo '</div></div>';
  
}

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_entry_header', 'template_do_post_title', 7 );
function template_do_post_title(){
	echo '<h2 class="entry-title" itemprop="headline">'.get_the_title().'</h2>';
	if(!empty(theme_get_field('credentials'))) echo '<p class="credentials">'.theme_get_field('credentials').'</p>';
	if(!empty(theme_get_field('title_1'))) echo '<p class="title">'.theme_get_field('title_1').'</p>';
	/*if(!empty(theme_get_field('title_2'))) echo '<p class="title">'.theme_get_field('title_2').'</p>';
	if(!empty(theme_get_field('title_3'))) echo '<p class="title">'.theme_get_field('title_3').'</p>';
	if(!empty(theme_get_field('title_4'))) echo '<p class="title">'.theme_get_field('title_4').'</p>';*/
	
}

//Move image up
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'template_do_post_image', 6 );
function template_do_post_image() {
	if(has_post_thumbnail()) echo get_the_post_thumbnail($person->ID, 'team', array('alt' => get_the_title($person->ID) . ' headshot'));
	else echo '<img src="/wp-content/themes/ellie/assets/images/no-location-image.jpg" alt="No headshot available" width="500" height="500" />';
}

//Add link
add_action( 'genesis_entry_header', 'template_do_post_link', 1 );
function template_do_post_link(){
	echo '<a class="featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content">';
}

add_action( 'genesis_after_entry', 'template_do_post_link_close', 55 );
function template_do_post_link_close(){
	echo '</a>';
}

//Exception for subdepartments
remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'template_do_loop');
function template_do_loop() {
	global $wp_query;
	$term = get_queried_object();
	
	 if ( count( get_term_children( $term->term_id, 'people-department' ) ) < 1 ) {
    	genesis_do_loop();
  	}else {
  		
  		$children = get_term_children( $term->term_id, 'people-department' );
  		$children_ids = array();
		$children_order = array();
		
		foreach ($children as $child) {
			$child_term = get_term($child, 'people-department' );
			array_push($children_ids, $child);
			array_push($children_order, theme_get_field('department_order', $child_term->taxonomy . '_' . $child_term->term_id));
		}
  		
  		array_multisort($children_order, $children_ids);
  			
		foreach ($children_ids as $child) {
	  		wp_reset_query();
	  		$child_term = get_term($child, 'people-department' );
	  		echo '<div class="people-block"><div class="post-container">';
	  		$args = array_merge(array( 'post_type' => 'people', 'orderby' => array('menu_order' => 'ASC', 'title' => 'ASC'), 'tax_query' => array( array( 'taxonomy' => 'people-department', 'terms'=> $child, ), ), ) );
			$wp_query = new WP_Query( $args );
			genesis_do_loop();	
			echo '</div></div>';
	  	}
  	}

}



genesis();