<?php 

/**
* Template Name: Med Management Landing Page
*/

remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

//Add menus
remove_action('genesis_before_header', 'theme_do_before_header_menu');
add_action('genesis_before_header', 'template_do_before_header_menu');
function template_do_before_header_menu(){
	echo '<div class="header">';
			
	if ( genesis_nav_menu_supported( 'utilities-medmanagement-menu' ) && has_nav_menu( 'utilities-medmanagement-menu' ) ) {
         echo '<div class="before-header"><div class="wrap">';
    
	    genesis_nav_menu( array(
        'theme_location' => 'social-menu',
        'menu_class'     => 'menu genesis-nav-menu social'
    	) );
    	
    	genesis_nav_menu( array(
        'theme_location' => 'utilities-medmanagement-menu',
        'menu_class'     => 'menu genesis-nav-menu utilities medmanagement'
    	) );
    	
    	  echo '</div></div>';
    } 	

}

remove_action( 'genesis_header', 'theme_do_header_nav', 6 );
add_action( 'genesis_header', 'template_do_header_nav', 6 );
function template_do_header_nav(){
		echo '<button class="menu-toggle" aria-label="Menu" aria-pressed="false"><span>Menu</span></button><div class="main-menu">';
			
		genesis_nav_menu( array(
        'theme_location' => 'medmanagement',
        'menu_class'     => 'menu genesis-nav-menu medmanagement'
    	) );
		
		echo '</div>';
						
}

genesis();