<?php
/* Shortcodes */

//Add Site Name shortcode
add_shortcode("blog_author", "theme_blog_author");
function theme_blog_author($atts, $content = null) {
$author = theme_get_field('bio', 'user_' . get_the_author_ID());
   if(!empty($author)) :
    $person = get_post($author);
    $name = get_the_title($person->ID);
    if(!empty(theme_get_field('credentials', $person->ID))) $name .= ', '.theme_get_field('credentials', $person->ID);

    return ' • '. $name;
    endif;
}
 
//Add Menu shortcode
add_shortcode("menu", "theme_do_menu");
function theme_do_menu($atts, $content = null) {
	extract(shortcode_atts(array(
	      "menu_id" => '',
	      "menu_title" => '',
	   ), $atts));
	   
   $menuHTML = '<div class="menu-shortcode">';
   
   if($menu_title != '') $menuHTML .= '<h3 class="widgettitle">' . $menu_title . '</h3>';
   
   $menuHTML .= wp_nav_menu(array('menu'=> $menu_id,'echo'=>false)) . '</div>';
   
   return $menuHTML;
}

//Add Site Name shortcode
add_shortcode("sitename", "theme_sitename");
function theme_sitename($atts, $content = null) {
   return get_bloginfo('name');
}

add_shortcode("siteurl", "theme_siteurl");
function theme_siteurl($atts, $content = null) {
   return get_site_url();
}

add_shortcode("linked_sitename", "theme_linked_sitename");
function theme_linked_sitename($atts, $content = null) {
   return '<a href="'.get_site_url().'">'.get_bloginfo('name').'</a>';
}

//Add Privacy Policy shortcode
add_shortcode("privacy", "theme_privacy");
function theme_privacy($atts, $content = null) {
   $policy_page_id = (int) get_option( 'wp_page_for_privacy_policy' );
   return '<a href="'.get_privacy_policy_url().'">'.get_the_title($policy_page_id).'</a>';
}

//Add Beacon Creds shortcode
add_shortcode("sitecreds", "theme_sitecreds");
function theme_sitecreds($atts, $content = null) {
	$creds = 'Website by ';
	
	if(is_front_page()):
		$creds .= '<a target="_blank" href="https://www.beaconmm.com/" >Beacon Media + Marketing</a>.';
	else:
		$creds .= 'Beacon Media + Marketing.';
	endif;
	
	
	return $creds;
}

