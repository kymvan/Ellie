<?php 

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_content_sidebar' );

add_action('genesis_before_content_sidebar_wrap', 'template_do_before_content_sidebar_wrap');
function template_do_before_content_sidebar_wrap(){
	
		
		echo '<div class="wp-container-1 wp-block-group alignfull has-accent-2-background-color"><div class="wp-block-group__inner-container"><p class="has-h-1-font-size has-accent-1-color has-text-color">'.get_the_title( get_option('page_for_posts', true) ).'</p><p class="has-large-font-size has-accent-1-color has-text-color">Mental health tips and insights </p></div></div>';



}

add_action('genesis_entry_header', 'template_do_post_image', 6);
function template_do_post_image(){
	
	
	if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(), 'thumbnail');
}

add_action( 'genesis_entry_footer', 'template_post_author');
function template_post_author(){

	$author = theme_get_field('bio', 'user_' . get_the_author_ID());
  
   if(!empty($author)):
   
   $person = get_post($author);
   
   echo '<div class="author"><h2 class="has-text-color has-accent-1-color">About the author</h2><div class="wp-block-columns" style="gap: 30px;"><div class="wp-block-column" style="flex-basis: 30%;">';
   
  if(has_post_thumbnail($person->ID)) echo '<a class="post-link featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content">' . get_the_post_thumbnail($person->ID, 'team', array('alt' => get_the_title($person->ID). ' headshot')) . '</a>';
					
	else echo '<a class="post-link featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content"><img  width="400" height="400" src="/wp-content/themes/ellie/assets/images/placeholder.jpg" class="attachment-location size-location wp-post-image" alt="'. get_the_title($person->ID) . ' Headshot" /></a>';
   
   echo '</div><div class="wp-block-column"><h3 class="entry-title has-text-color has-accent-1-color nomargin" itemprop="headline">'.get_the_title($person->ID);
					
	if(!empty(theme_get_field('credentials', $person->ID))) echo ', '.theme_get_field('credentials', $person->ID);
															
	echo '</h3>';
	
	if(!empty(theme_get_field('title_1', $person->ID))) echo '<p class="has-text-color has-accent-4-color">'.theme_get_field('title_1', $person->ID).'</p>';
	
	$bio = substrwords(strip_tags($person->post_content), 335, '');
															
					if(strlen($bio) <= 300) echo '<p>' . strip_tags($person->post_content) . '</p>';
					
					else echo '<p>' . $bio . '… <a class="post-link featherlight-link more-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content">Read more</a></p>';
	echo '</div></div></div>';
   
   endif;

}


genesis();