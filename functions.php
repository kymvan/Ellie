<?php


add_action( 'genesis_setup', 'theme_child_theme_setup', 15 );
function theme_child_theme_setup() {

	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );
	
	//Add editor styles
	add_editor_style( 'editor-styles.css' );
	add_theme_support( 'editor-styles' );

	// Includes
	include_once( get_stylesheet_directory() . '/includes/wordpress-cleanup.php' );
	include_once( get_stylesheet_directory() . '/includes/genesis-changes.php' );
	include_once( get_stylesheet_directory() . '/includes/helper-functions.php' );
	include_once( get_stylesheet_directory() . '/includes/shortcodes.php' );
	include_once( get_stylesheet_directory() . '/includes/navigation.php' );
	include_once( get_stylesheet_directory() . '/includes/acf.php' );


	// Gutenberg
	// -- Wide Images
	add_theme_support( 'align-wide' );
	
	//Logo in customizer
	add_theme_support( 'genesis-custom-logo' );

	// -- Editor Font Styles
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => 'small',
			'shortName' => 'S',
			'size'      => 16,
			'slug'      => 'small'
		),
		array(
			'name'      => 'regular',
			'shortName' => 'M',
			'size'      => 18,
			'slug'      => 'regular'
		),
		array(
			'name'      => 'large',
			'shortName' => 'L',
			'size'      => 22,
			'slug'      => 'large'
		),
		array(
			'name'      => 'h1',
			'shortName' => 'H1',
			'size'      => 65,
			'slug'      => 'h1'
		),
		array(
			'name'      => 'h2',
			'shortName' => 'H2',
			'size'      => 36,
			'slug'      => 'h2'
		),
		array(
			'name'      => 'h3',
			'shortName' => 'H3',
			'size'      => 24,
			'slug'      => 'h3'
		),
			) );

	// -- Editor Color Palette
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => 'Ellie Teal',
			'slug'  => 'accent1',
			'color'	=> '#245970',
		),
		array(
			'name'  => 'Ellie Mint',
			'slug'  => 'accent2',
			'color' => '#0fe0d9',
		),
		array(
			'name'  => 'Green',
			'slug'  => 'accent3',
			'color' => '#ced92b',
		),
		array(
			'name'  => 'Purple',
			'slug'  => 'accent4',
			'color' => '#cc61c7',
		),
		array(
			'name'  => 'Red',
			'slug'  => 'accent5',
			'color' => '#ff6352',
		),	
		array(
			'name'  => 'Light Mint',
			'slug'  => 'accent6',
			'color' => '#a9fff8',
		),	
		array(
			'name'  => 'Light Blue',
			'slug'  => 'accent7',
			'color' => '#327d9b',
		),		
		array(
			'name'  => 'Grey',
			'slug'  => 'grey',
			'color' => '#F5FCFC',
		),
		
		array(
			'name'  => 'Off White',
			'slug'  => 'off-white',
			'color' => '#FAFCFD',
		),
		
		array(
			'name'  => 'White',
			'slug'  => 'white',
			'color' => '#FFFFFF',
		),
		
		array(
			'name'  => 'Black',
			'slug'  => 'black',
			'color' => '#364952',
		),
	) );
	
	remove_theme_support( 'core-block-patterns' );

}

//Enqueue scripts, icon fonts, etc
add_action( 'wp_enqueue_scripts', 'theme_global_enqueues' );
function theme_global_enqueues() {

	// javascript
	wp_enqueue_script( 'theme-scripts', get_stylesheet_directory_uri() . '/assets/js/theme-scripts.js', array( 'jquery' ), '1.4', true );
	
	//Google Maps
	wp_register_script('google_map_api', 'https://maps.google.com/maps/api/js?callback=initMap&libraries=geometry&key=AIzaSyDoYBhlg_03GU1bDPWudx2eKMO9Ao1fdR4', '','', true );

			
	//Featherlight
	wp_enqueue_script( 'featherlight', get_stylesheet_directory_uri() . '/assets/js/featherlight.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'featherlight-css', get_stylesheet_directory_uri() . '/assets/css/featherlight.css' );
	
	wp_enqueue_script( 'featherlight-gallery', get_stylesheet_directory_uri() . '/assets/js/featherlight.gallery.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'featherlight-gallery-css', get_stylesheet_directory_uri() . '/assets/css/featherlight.gallery.css' );

	// fonts
	wp_enqueue_style( 'theme-fonts', 'https://use.typekit.net/wmb3ayh.css' );
	
	
	
	
}



//Load Google Fonts with preload
add_action( 'wp_head', 'theme_prefix_load_fonts' ); 
function theme_prefix_load_fonts() { 
    ?> 
	<link rel="preload" href="/wp-content/themes/ellie/assets/fonts/Cambon-BoldItalic.otf" as="font" crossorigin>
<style>

/* latin */
 @font-face {
    font-family: 'Cambon';
    font-style: italic;
    font-weight: bold;
    src:  url('/wp-content/themes/ellie/assets/fonts/Cambon-BoldItalic.otf') format('opentype');
    }


</style>
    <?php
} 

//Change number of posts
add_action( 'pre_get_posts', 'template_tax_post_count' );
function template_tax_post_count($query) {
	if(!is_admin()) : 
		if ($query->is_tax('people-department')):
			$query->set( 'orderby', array('menu_order' => 'ASC', 'title' => 'ASC') );
	        $query->set( 'posts_per_page', '-1' );
	         
	    elseif($query->is_tax('locations-page')):
	    
	    	$query->set( 'posts_per_page', '-1' );
	        $query->set( 'orderby', array('title' => 'ASC'));
	        $query->set('has_password', FALSE);
	    	
	         
	    endif;
	  endif;
    
}

//Add Google API key for locations maps
function theme_acf_init( $api ){
     acf_update_setting('google_api_key', 'AIzaSyDoYBhlg_03GU1bDPWudx2eKMO9Ao1fdR4');
}
add_action('acf/init', 'theme_acf_init');


//Image Sizes
add_image_size('team', 400, 400, TRUE);
add_image_size('location', 500, 500, TRUE);
add_image_size('location_thumb', 190, 190, TRUE);
add_image_size('gallery', 480, 254, TRUE);

add_action( 'wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'my_ajax_pagination' );
function my_ajax_pagination() {
    $query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );

    $query_vars['paged'] = $_POST['page'];
  
    get_franchise_blog_posts($_POST['site'], $_POST['page'], $_POST['cat']);
    
    die();
}

function get_franchise_blog_posts($site_id, $paged, $notin){
		
		//switch_to_blog($site_id);
		
		global $wp_query;
		
		if($site_id == 1) $wp_query = new WP_Query(array('post_type'=> 'post', 'post_status' =>'publish', 'posts_per_page'=>'3','paged' => $paged, 'category__not_in' => $notin)); 
		else $wp_query = new WP_Query(array('post_type'=> 'post', 'post_status' =>'publish', 'posts_per_page'=>'3', 'paged' => $paged)); 
		
		if ( have_posts() ) {
				
			while ( have_posts() ) {
				the_post();
				
				echo '<article class="post-'. get_the_ID() .' post type-post status-publish format-standard entry" aria-label="'. get_the_title() .'"><a class="post-link" href="'.get_permalink().'">';
				
				echo '<header class="entry-header">';
				
				if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
				
				echo '<h2 class="entry-title">' . get_the_title(get_the_ID()) . '</h2>';
				
				genesis_post_info();
				
				echo '</header>';
								
				do_action( 'genesis_before_entry_content' );
				
				echo '<div class="entry-content">';
				
				genesis_do_post_content();
				
				echo '</div>';
				
				do_action( 'genesis_after_entry_content' );
				
				do_action( 'genesis_entry_footer' );

				echo '</a></article>';
			}
			
			do_action( 'genesis_after_endwhile' );
		
			
		}
		
		
		wp_reset_query();
		
		//restore_current_blog();	
		
}
