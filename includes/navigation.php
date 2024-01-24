<?php
/*  Navigation */


// Place Primary Nav in Header
remove_action('genesis_after_header', 'genesis_do_nav');
add_action( 'genesis_header', 'theme_do_header_nav', 6 );
function theme_do_header_nav(){
		echo '<button class="menu-toggle" aria-label="Menu" aria-pressed="false"><span>Menu</span></button><div class="main-menu">';
	
		genesis_do_nav();
		
		genesis_nav_menu( array(
        'theme_location' => 'utilities-menu',
        'menu_class'     => 'menu genesis-nav-menu utilities'
    	) );
		
		echo '</div>';
						
}




// Add Mobile Buttons for Submenus
add_filter( 'walker_nav_menu_start_el', 'theme_add_submenu_mobile_buttons', 10, 4 );
function theme_add_submenu_mobile_buttons( $item_output, $item, $depth, $args ) {

	$args = (array) $args;

	if ( $args['theme_location'] == 'primary' ) {
		
		if(in_array('menu-item-has-children', $item->classes)) :
			$item_output .= '<button class="sub-menu-toggle" aria-label="Submenu" aria-pressed="false"><span>Submenu</span></button>';
		endif;
	}
	
	return $item_output;

}


//Disable Superfish
add_action( 'wp_enqueue_scripts', 'theme_disable_superfish' );
function theme_disable_superfish() {
	wp_deregister_script( 'superfish' );
	wp_deregister_script( 'superfish-args' );
}


//Add ACF icons to menu items
add_filter('wp_nav_menu_objects', 'theme_add_icons_to_menu_item', 10, 2);
function theme_add_icons_to_menu_item( $items, $args ) {
	
	// loop
	foreach( $items as &$item ) {
		
		// vars
		$icon = theme_get_field('font_awesome_icon', $item);
		$desc = theme_get_field('icon_description', $item);
		
		$show_label_class = ' hide-label ';
		if(theme_get_field('show_label', $item)) $show_label_class = '';
		
				
		// append icon
		if( $icon ) {
			
			$item->title = theme_get_icon(array('icon' => $icon, 'size' => 20, 'label' => esc_html($desc)) ) . '<span class="menu-item-text'.$show_label_class.'">' . $item->title . '</span>';
			array_push($item->classes, 'menu-item-has-icon');
			
		}
		
	}
	
	
	// return
	return $items;
	
}