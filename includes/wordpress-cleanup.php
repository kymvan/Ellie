<?php
/* WordPress Cleanup */

//Clean Nav Menu Classes
//@author Bill Erickson
add_filter( 'nav_menu_css_class', 'theme_clean_nav_menu_classes', 5 );
function theme_clean_nav_menu_classes( $classes ) {
	if( ! is_array( $classes ) )
		return $classes;

	foreach( $classes as $i => $class ) {

		// Remove class with menu item id
		$id = strtok( $class, 'menu-item-' );
		if( 0 < intval( $id ) )
			unset( $classes[ $i ] );

		// Remove menu-item-type-*
		if( false !== strpos( $class, 'menu-item-type-' ) )
			unset( $classes[ $i ] );

		// Remove menu-item-object-*
		if( false !== strpos( $class, 'menu-item-object-' ) )
			unset( $classes[ $i ] );

		// Change page ancestor to menu ancestor
		if( 'current-page-ancestor' == $class ) {
			$classes[] = 'current-menu-ancestor';
			unset( $classes[ $i ] );
		}
	}

	// Remove submenu class if depth is limited
	if( isset( $args->depth ) && 1 === $args->depth ) {
		$classes = array_diff( $classes, array( 'menu-item-has-children' ) );
	}

	return $classes;
}

//Disable pingbacks
add_filter( 'xmlrpc_methods', 'theme_disable_pingbacks');
function theme_disable_pingbacks($methods){
	unset( $methods['pingback.ping'] );
   	return $methods;
}


//Excerpt Read More
add_filter( 'excerpt_more', 'theme_excerpt_more' );
add_filter( 'get_the_content_more_link', 'theme_excerpt_more' );
add_filter( 'the_content_more_link', 'theme_excerpt_more' );
function theme_excerpt_more() {
	return '&hellip;';
}

