<?php
/* Genesis Changes */

// Theme Supports
add_theme_support( 'html5', array( 'search-form','gallery', 'caption' ) );
add_theme_support( 'genesis-responsive-viewport' );
add_theme_support( 'genesis-footer-widgets', 1 );
add_theme_support( 'genesis-structural-wraps', array( 'header' ) );
add_theme_support( 'genesis-menus', array( 'primary' => 'Main Menu', 'utilities-menu' => 'Utilities Menu',  'social-menu' => 'Social Menu', 'utilities-medmanagement-menu' => 'Minnesota - Utilities Menu', 'medmanagement' => 'Med Mangement - Main Menu', 'tms' => 'TMS - Main Menu'  ) );
add_theme_support( 'genesis-lazy-load-images' );

//Add widget areas
genesis_register_sidebar( array(
	'id'		=> 'after-footer',
	'name'		=> __( 'After Footer Widget', 'theme' ),
	'description'	=> __( 'This is the widget area after the footer.', 'theme' ),
) );

//Add menus
add_action('genesis_before_header', 'theme_do_before_header_menu');
function theme_do_before_header_menu(){
	echo '<div class="header">';
	
	echo '<div class="search-box"><div class="wrap"><button class="search-toggle" aria-label="Search" aria-pressed="false"><span>Search Close</span></button>'.get_search_form(false). '</div></div>';
		
	if ( genesis_nav_menu_supported( 'utilities-menu' ) && has_nav_menu( 'utilities-menu' ) ) {
         echo '<div class="before-header"><div class="wrap">';
    
	    genesis_nav_menu( array(
        'theme_location' => 'social-menu',
        'menu_class'     => 'menu genesis-nav-menu social'
    	) );
    	
    	genesis_nav_menu( array(
        'theme_location' => 'utilities-menu',
        'menu_class'     => 'menu genesis-nav-menu utilities'
    	) );
    	
    	  echo '</div></div>';
    } 	
    
    

}

add_action('genesis_after_header', 'theme_do_header_markup_close');
function theme_do_header_markup_close(){
	echo '</div>';
}

//Add footer container
add_action('genesis_before_footer', 'theme_do_footer_markup', 1);
function theme_do_footer_markup(){
	echo '<div class="footer"><div class="wrap">';
    
}

add_action('genesis_after_footer', 'theme_do_footer_markup_close', 50);
function theme_do_footer_markup_close(){
	
	genesis_widget_area ('after-footer', array(
			    'before' => '<div class="after-footer">',
			    'after' => '</div>',
			) );
		echo '</div></div>';
		
}

// Accessibility.
add_theme_support(
	'genesis-accessibility', array(
		'404-page',
		'drop-down-menu',
		'headings',
		'rems',
		'search-form',
		'skip-links',
		'screen-reader-text',
	)
);


// Remove Genesis Favicon (use site icon instead)
remove_action( 'wp_head', 'genesis_load_favicon' );

// Remove Header Description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Remove unused sidebar layouts
unregister_sidebar( 'header-right' );
unregister_sidebar( 'sidebar-alt' );
remove_theme_support( 'genesis-archive-layouts' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );


// Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'What can we help you find?' );
}


//Remove Genesis Templates
add_filter( 'theme_page_templates', 'theme_remove_genesis_templates' );
function theme_remove_genesis_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}


//Change '.content-sidebar-wrap' to '.content-area'
//@author Bill Erickson
add_filter( 'genesis_attr_content-sidebar-wrap', 'theme_change_content_sidebar_wrap' );
function theme_change_content_sidebar_wrap( $attributes ) {
	$attributes['class'] = 'content-area';
	return $attributes;
}

//Change '.content' to '.site-main'
//@author Bill Erickson
add_filter( 'genesis_attr_content', 'theme_change_content' );
function theme_change_content( $attributes ) {
	$attributes['class'] = 'site-main';
	return $attributes;
}

// Add #main-content to .site-inner
//@author Bill Erickson
add_filter( 'genesis_attr_site-inner', 'theme_site_inner_id' );
function theme_site_inner_id( $attributes ) {
	$attributes['id'] = 'main-content';
	return $attributes;
}

//Change skip link to #main-content
//@author Bill Erickson
add_filter( 'genesis_skip_links_output', 'theme_main_content_skip_link' );
function theme_main_content_skip_link( $skip_links ) {

	$old = $skip_links;
	$skip_links = array();

	foreach( $old as $id => $label ) {
		if( 'genesis-content' == $id )
			$id = 'main-content';
		$skip_links[ $id ] = $label;
	}

	return $skip_links;
}
