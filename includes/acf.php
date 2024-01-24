<?php

//Create Theme Blocks category
add_filter( 'block_categories', 'theme_block_category', 10, 2);
function theme_block_category( $categories, $post ) {

	if ( $post->post_type == 'page' || $post->post_type == 'post' ) { 

		$theme_blocks = array_merge(
			$categories,
			array(
				array(
					'slug' => 'beacon',
					'title' => 'Theme Blocks',
					'icon' => 'smiley',
				)
			)
		);

	} else {

		return $categories;

	}

	return $theme_blocks;
}



// ACF:  Register blocks
add_action('acf/init', 'theme_register_blocks' );
function theme_register_blocks() {
	if( ! function_exists('acf_register_block') )
		return;
		
	  acf_add_options_page(array(
	 	'page_title'    => __('Location Options'),
        'menu_title'    => __('Location Options'),
        'menu_slug'     => 'theme-options',
        'position' => '8',
	 ));	
	
		acf_register_block( array(
		'name'			=> 'people-block',
		'title'			=> 'People Block',
		'render_callback'   => 'theme_render_people_block',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'people', 'department', 'team', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'reviews-carousel',
		'title'			=> 'Reviews Carousel',
		'render_callback'   => 'theme_render_reviews_carousel',
		'enqueue_assets' => function(){
  						wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/assets/css/slick.css' );
  						wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '', false );
		},
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'reviews', 'testimonials', 'carousel', 'slider', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'video-block',
		'title'			=> 'Video Block',
		'render_callback'   => 'theme_render_video_block',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'link', 'video', 'vimeo', 'youtube', 'lightbox','beacon' )
	));
	
	acf_register_block( array(
		'name'			=> 'video-carousel',
		'title'			=> 'Video Carousel',
		'render_callback'   => 'theme_render_video_carousel',
		'enqueue_assets' => function(){
  						wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/assets/css/slick.css' );
  						wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '', false );
		},
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'videos', 'youtube', 'vimeo', 'carousel', 'slider', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'link-boxes',
		'title'			=> 'Link Boxes',
		'render_callback'   => 'theme_render_link_boxes',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'link', 'box', 'form', 'grid', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'assets-block',
		'title'			=> 'Assets Gallery',
		'render_callback'   => 'theme_render_assets_block',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'assets', 'franchise', 'zees', 'social', 'media', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'news-block',
		'title'			=> 'News Block',
		'render_callback'   => 'theme_render_news_block',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'news', 'press releases', 'beacon' )
	));
	
	acf_register_block( array(
		'name'			=> 'blog-block',
		'title'			=> 'Blog Block',
		'render_callback'   => 'theme_render_blog_block',
		'enqueue_assets' => function(){
  							wp_enqueue_script( 'ajax-pagination',  get_stylesheet_directory_uri() . '/assets/js/ajax-pagination.js', array( 'jquery' ), '1.0', true );	
	wp_localize_script( 'ajax-pagination', 'ajaxpagination', array(	'ajaxurl' => admin_url( 'admin-ajax.php' ),	'query_vars' => json_encode( $wp_query->query )));
		},
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'blog', 'posts', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'coming-soon-map',
		'title'			=> 'Coming Soon Map',
		'render_callback'   => 'theme_render_coming_soon_map',
		'enqueue_assets' => function(){
  						wp_enqueue_script( 'map-scripts',  get_stylesheet_directory_uri() . '/assets/js/coming-soon-map-scripts.js', array( 'jquery' ), '1.1', true );
  						wp_enqueue_script(  'google_map_api' );
		},
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'map', 'locations', 'coming soon', 'beacon' )
	));
	
	acf_register_block( array(
		'name'			=> 'landing-page-map',
		'title'			=> 'Landing Page Map',
		'render_callback'   => 'theme_render_landing_page_map',
		'enqueue_assets' => function(){
  				wp_enqueue_script( 'map-scripts',  get_stylesheet_directory_uri() . '/assets/js/landing-map-scripts.js', array( 'jquery' ), '3.6.1', true );
  				wp_enqueue_script(  'google_map_api' );
		},
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'map', 'locations', 'state', 'landing page',  'beacon' )
	));
	
	acf_register_block( array(
		'name'			=> 'lightbox-block',
		'title'			=> 'Lightbox Block',
		'render_callback'   => 'theme_render_lightbox',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'lightbox', 'popup', 'beacon' )
	));
	
	acf_register_block( array(
		'name'			=> 'alert-carousel',
		'title'			=> 'Alert Carousel',
		'render_callback'   => 'theme_render_alert_carousel',
		'enqueue_assets' => function(){
  						wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/assets/css/slick.css' );
  						wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '', false );
		},
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'alert', 'announcement', 'carousel', 'slider', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'service-carousel',
		'title'			=> 'Services Carousel',
		'render_callback'   => 'theme_render_services_carousel',
		'enqueue_assets' => function(){
  						wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/assets/css/slick.css' );
  						wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array('jquery'), '', false );
		},
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'services', 'carousel', 'slider', 'beacon' )
	));	
	
	acf_register_block( array(
		'name'			=> 'services-block',
		'title'			=> 'Services Block',
		'render_callback'   => 'theme_render_services_block',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'services', 'beacon' )
	));
	
	acf_register_block( array(
		'name'			=> 'home-collage',
		'title'			=> 'Home Collage',
		'render_callback'   => 'theme_render_home_collage',
		'category'		=> 'beacon',
		'icon'			=> 'smiley',
		'mode'			=> 'edit',
		'keywords'		=> array( 'collage', 'because', 'beacon' )
	));
	
}



function theme_render_reviews_carousel($block, $content = '', $is_preview = false){
		$reviews = theme_get_field('reviews');
		
		if(empty($reviews)) $reviews = get_posts(array('post_type' => 'review', 'numberposts' => -1));
		
		echo '<div class="reviews-carousel';
				
		if(array_key_exists('className', $block)) echo ' ' . $block['className'];
				
		echo '">';
		
		foreach ($reviews as $review) {				
		
			$review_post = get_post($review);

						
			echo '<div class="review">';
			
			echo '<div class="therapist">'. $review_post->post_title . '</div>';
			
			echo '<blockquote>';
			
				
				echo apply_filters('the_content', $review_post->post_content);
								
				echo '</blockquote>';
			
			
			echo '</div>';

		
		}
		
		echo '</div>';
		
		if(count($reviews) > 1 ) echo '<script type="text/javascript">jQuery(document).ready(function(){ jQuery(".reviews-carousel").slick({ slidesToShow: 2, slidesToScroll: 1, arrows: false, dots: true, autoplay: true, autoplaySpeed: 8000, infinite: true, centerMode: false, focusOnSelect: true, responsive: [ { breakpoint: 767, settings: { slidesToShow: 1 } }]});  });</script>';
		
	}
	
function theme_render_video_block($block, $content = '', $is_preview = false){
	echo '<div class="video-block ';
			
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
			
	echo '"><a class="featherlight-link"  href="'.theme_get_field('embed_link').'" data-featherlight="iframe" data-featherlight-iframe-width="1120" data-featherlight-iframe-height="630" data-featherlight-iframe-frameborder="0" data-featherlight-iframe-allow="autoplay; encrypted-media" data-featherlight-iframe-allowfullscreen="true">';
	
	echo '<div class="player">' . theme_get_icon(array('icon'=>'play-circle', 'size' => 80, 'label' => 'Play Icon')) . '<span>Play Video</span></div>';
	
	if(theme_get_field('thumbnail_image')) echo wp_get_attachment_image(theme_get_field('thumbnail_image'), 'full');
	
	echo '</a></div>';
	
	
	}	
	
function theme_render_people_block($block, $content = '', $is_preview = false){
	echo '<div class="people-block ';
			
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
			
	echo '">';
		
	if(!empty(theme_get_field('department'))) 	
		$people = get_posts(array('post_type'=>'people', 'numberposts' => -1, 'orderby' => array('menu_order' => 'ASC', 'title' => 'ASC'), 'tax_query' => array(array('taxonomy'=>'people-department','field' => 'term_id','terms' => theme_get_field('department')))));
	else 
		$people = get_posts(array('post_type'=>'people', 'numberposts' => -1, 'include' => theme_get_field('people'), 'orderby' => 'post__in' ));


	
	theme_do_department_grid($people);
	
	echo '</div>';
	
}		

function theme_do_department_grid($people){

	
	if(count($people) > 1) :
		
		echo '<div class="post-container">';
		
		foreach ($people as $person) {
			echo '<article class="people type-people has-post-thumbnail entry" aria-label="'.get_the_title($person->ID).'"><a class="featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content"><header class="entry-header">';
			
			if(has_post_thumbnail($person->ID)) echo get_the_post_thumbnail($person->ID, 'team', array('alt' => get_the_title($person->ID). ' headshot'));
			else echo '<img src="/wp-content/themes/ellie/assets/images/no-location-image.jpg" alt="No headshot available" width="500" height="500" />';
			
			echo '<h2 class="entry-title" itemprop="headline">'.get_the_title($person->ID).'</h2>';
			
			if(!empty(theme_get_field('credentials', $person->ID))) echo '<p class="credentials">'.theme_get_field('credentials', $person->ID).'</p>';
			if(!empty(theme_get_field('title_1', $person->ID))) echo '<p class="title">'.theme_get_field('title_1', $person->ID).'</p>';
			
			echo '</header><div class="entry-content"></div><footer class="entry-footer"></footer></a></article>';
		}
		
		echo '</div>';
	
	elseif (count($people) == 1):
		echo '<div class="wp-block-group single-person"><div class="wp-block-group__inner-container">';
			
			foreach ($people as $person) {
					
					echo '<div class="people type-people has-post-thumbnail entry"><div class="entry-header">';
					
					if(has_post_thumbnail($person->ID)) echo '<a class="post-link featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content">' . get_the_post_thumbnail($person->ID, 'team', array('alt' => get_the_title($person->ID). ' headshot')) . '</a>';
					
					else echo '<a class="post-link featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content"><img  width="400" height="400" src="/wp-content/themes/ellie/assets/images/placeholder.jpg" class="attachment-location size-location wp-post-image" alt="'. get_the_title() . ' Headshot" /></a>';
					
					echo '<div class="inner">';
					
					if(!empty(theme_get_field('title_1', $person->ID))) echo '<h2 class="has-text-color has-accent-4-color">Meet the '.theme_get_field('title_1', $person->ID).'</h2>';					
					
					
					echo '<h3 class="entry-title has-text-color has-accent-1-color" itemprop="headline">'.get_the_title($person->ID);
					
					if(!empty(theme_get_field('credentials', $person->ID))) echo ', '.theme_get_field('credentials', $person->ID);
															
					echo '</h3>';
					
					$bio = substrwords(strip_tags($person->post_content), 385, '');
															
					if(strlen($bio) <= 300) echo '<p>' . strip_tags($person->post_content) . '</p>';
					
					else echo '<p>' . $bio . '… <a class="post-link featherlight-link more-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content">Read More</a></p>';
										
					echo '</div></div></div>';
			}
			
		echo '</div></div>';	
		
	endif;
}

function theme_render_link_boxes($block, $content = '', $is_preview = false){
	echo '<div class="link-boxes ';
			
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
			
	echo '">';
	
	if(have_rows('boxes')) :
	
		while ( have_rows('boxes') ) : the_row();
		
		echo '<a class="box" href="'.get_sub_field('form_link').'"';
		
		if(!empty(get_sub_field('new_window'))) echo ' target="_blank"';
		
		
		echo '><div><h3>'. get_sub_field('title') . '</h3>';
		
		if(!empty(get_sub_field('description'))) echo '<p>' . get_sub_field('description') . '</p>';
		
		echo '</div></a>';
		
		endwhile;
	
	endif;
	
	echo '</div>';
	
}



function theme_render_assets_block($block, $content = '', $is_preview = false){

	echo '<div class="assets ';
			
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
			
	echo '">';
	
	if(have_rows('assets')) :
	
		while ( have_rows('assets') ) : the_row();
		
		echo '<div class="asset">';
		
			echo '<div class="image"><a href="'.wp_get_attachment_url(get_sub_field('image')).'" data-featherlight="image">' . wp_get_attachment_image(get_sub_field('image'), 'medium') . '</a></div>';
			
			echo '<div class="label"><span class="title">' . get_sub_field('title') . '</span>';
			
			$download_file_name = strtolower(str_replace(' ', '-', get_sub_field('title')));
			
			echo '<div class="actions"><span class="preview"><a href="'.wp_get_attachment_url(get_sub_field('image')).'" data-featherlight="image">Preview</a></span>';
						
			echo '<span class="download"><a href="'.wp_get_attachment_url(get_sub_field('image')).'" download="ellie-'.$download_file_name.'">Download</a></span></div></div>';

		
		echo '</div>';
		
		endwhile;
	
	endif;
	
	
	echo'</div>';

}

function theme_render_news_block($block, $content = '', $is_preview = false){

	echo '<div class="news-block ';
			
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
			
	echo '">';
	
		
	$news = get_posts(array('post_type'=>'news', 'numberposts' => 6, 'tax_query' => array(array('taxonomy'=>'news-category','field' => 'term_id','terms' => theme_get_field('news_category')))));
		
	if(count($news) > 0) :
		
		echo '<div class="post-container">';
		
		foreach ($news as $article) {
			echo '<article class="news type-news has-post-thumbnail entry" aria-label="'.get_the_title($article->ID).'">';
			
			if(!empty(theme_get_field('redirect', $article->ID))) echo '<a class="post-link" href="'. theme_get_field('redirect', $article->ID) . '" target="_blank">';
			else echo '<a class="post-link" href="'. get_permalink($article->ID) . '">';
			
			echo '<header class="entry-header">';
			
			if(has_post_thumbnail($article->ID)) echo get_the_post_thumbnail($article->ID, 'thumbnail');
			else echo '<img width="1000" height="527" src="'.get_stylesheet_directory_uri().'/assets/images/no-post-image.jpg" class="attachment-thumbnail size-thumbnail wp-post-image" alt="Ellie Logo - No image available" loading="lazy">';			
			
			echo '<h2 class="entry-title" itemprop="headline">'.get_the_title($article->ID).'</h2>';
			if(!empty(theme_get_field('author', $article->ID))) echo '<p class="author">By '.theme_get_field('author', $article->ID).'</p>';
			
			echo '</header><div class="entry-content">';
			echo $article->post_content;
			
			echo '</div><footer class="entry-footer"></footer></a></article>';
		}
		
		echo '</div>';
		
	endif;
	
	echo '</div>';
	
	if(count($news) == 6) :
		
		$category = get_term(theme_get_field('news_category'), 'news-category');
		
		echo '<div class="wp-block-buttons has-text-align-center"><div class="wp-block-button"><a class="wp-block-button__link" href="/news-category/'.$category->slug.'/">See All '.$category->name.'s</a></div></div>';
	endif;
}

function theme_render_blog_block($block, $content = '', $is_preview = false){

	echo '<div class="blog-block ';
			
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
			
	echo '">';
	
	echo '<div id="cat-id" style="display:none;">-87</div><div class="post-container">';
		get_franchise_blog_posts($site_id, 1, -106);
		
		
	echo '</div></div>';
	

}

function theme_render_coming_soon_map($block, $content = '', $is_preview = false){

	$locations = get_posts(array('post_type' =>'locations-coming', 'posts_per_page'  =>'-1', 'orderby'=> array('meta_value' => 'ASC', 'title' => 'ASC'), 'meta_key' => 'state', 'has_password'=> FALSE ));

	if($locations) :

	echo '<div id="map_canvas" class="coming-soon-map ';
			
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
			
	echo '"></div>';
	
	echo '<div class="wp-block-group coming-soon-locations"><div class="wp-block-group__inner-container">';	
	
	$state = '';
	
	foreach ($locations as $location) :
	
	$location_details = theme_get_field('location', $location->ID);
	
	if($state == '') echo '<button onclick="jQuery(this).attr( \'aria-pressed\', function( index, value ) { return \'false\' === value ? \'true\' : \'false\'; }); jQuery(this).toggleClass( \'activated\' ); jQuery(this).next( \'.hidden\' ).slideToggle( \'fast\' );" class="stateToggle">'.theme_get_field('state', $location->ID).'</button><div class="locations hidden" style="display: none;">';
	
	elseif($state != theme_get_field('state', $location->ID) ) echo '</div><button onclick="jQuery(this).attr( \'aria-pressed\', function( index, value ) { return \'false\' === value ? \'true\' : \'false\'; }); jQuery(this).toggleClass( \'activated\' ); jQuery(this).next( \'.hidden\' ).slideToggle( \'fast\' );" class="stateToggle">'.theme_get_field('state', $location->ID).'</button><div class="locations hidden" style="display: none;">';
	
	
echo '<div class="coming-location"><p class="marker">'.theme_get_icon(array('icon' => 'map-marker-alt', 'size' => 16, 'label' => 'Map marker icon' ));
	
	 if(!empty($location_details['city'])) echo $location_details['city'] . ', ';
	 
	 echo $location_details['state_short'] . '</p><h2>'.$location->post_title.'</h2>';	
	
	if(!empty(theme_get_field('address', $location->ID))) echo  '<p>' . theme_get_field('address', $location->ID) . '</p>'; 
			
	if(!empty(theme_get_field('coming_date', $location->ID))) echo  '<p><em>Coming ' . theme_get_field('coming_date', $location->ID) . '</em></p>'; 
			
	echo '</div>'; 
		
	$state = theme_get_field('state', $location->ID);
	
	endforeach;
		
	echo '</div></div></div>';
	
	endif;

}

function theme_render_landing_page_map($block, $content = '', $is_preview = false){
	$state = theme_get_field('state_landing_page');
		
	echo '<div id="locations" class="find-location"><div class="map"><div id="map_canvas"></div></div><div class="search">';
	
	if(!empty(theme_get_field('map_title'))) echo '<div class="search-box"><div class="inner"><h2>'.theme_get_field('map_title').'</h2></div></div>';
	
	echo ' <script>  var term = '.$state->term_id.'; var centerLat = '.theme_get_field('center_latitude').'; var centerLong = '.theme_get_field('center_longitude').'; </script>';


  	echo '<div class="locations" id="results-list"></div>';
	
	echo '</div>';
	
	echo '</div>';
	
}

function theme_render_lightbox($block, $content = '', $is_preview = false){
	echo '<p class="more-link"><a class="featherlight-link" href="#" data-featherlight="#'.$block['id'].'">'.theme_get_field('link_text').'</a></p>';
	echo '<div id="'.$block['id'].'" class="lightbox lightbox-block">'.theme_get_field('lightbox').'</div>';
	
}

function theme_render_video_carousel($block, $content = '', $is_preview = false){

if(have_rows('videos')) :
	
	echo '<div class="video-carousel ';
	
	if(array_key_exists('className', $block)) echo ' ' . $block['className'];
				
	echo '"><div class="video-slider">';
		
	while ( have_rows('videos') ) : the_row();
				echo '<div class="slide"><div class="video-block">';
				
				if(!empty(get_sub_field('embed_url'))) echo '<a class="featherlight-link"  href="'.get_sub_field('embed_url').'?autoplay=1" data-featherlight="iframe" data-featherlight-iframe-width="1120" data-featherlight-iframe-height="630" data-featherlight-iframe-frameborder="0" data-featherlight-iframe-allow="autoplay; encrypted-media" data-featherlight-iframe-allowfullscreen="true">';
				
				echo '<div class="thumbnail-wrap"><div class="player">' . theme_get_icon(array('icon'=>'play-circle', 'size' => 80, 'label' => 'Play Icon')) . '<span>Play Video</span></div>';

				
				if(!empty(get_sub_field('thumbnail'))) echo wp_get_attachment_image(get_sub_field('thumbnail'), 'full');
				
				echo '</div>';

				if(!empty(get_sub_field('embed_url'))) echo '</a>';
				
								
				
				echo '</div></div>';
	endwhile;
	
	echo '</div>';
	
	if(!empty(theme_get_field('caption'))) echo '<div class="caption">'.theme_get_field('caption').'</div>';
	
	echo '</div><script type="text/javascript">jQuery(document).ready(function(){ jQuery(".video-slider").slick({ slidesToShow: 2, slidesToScroll: 1, arrows: false, dots: true, autoplay: true, autoplaySpeed: 8000, infinite: true, centerMode: false, focusOnSelect: true,  responsive: [{breakpoint: 767, settings:{slidesToShow: 1}}]});  });</script>';
	
	endif;

}

function theme_render_alert_carousel($block, $content = '', $is_preview = false){
		if( have_rows('alerts')) : 
		
		echo '<div class="carousel-wrapper"><div class="alerts-carousel';
		
		if(array_key_exists('className', $block)) echo ' ' . $block['className'];
				
		echo '">';
		
		while ( have_rows('alerts') ) : the_row();
		
		echo '<div class="alert">'. get_sub_field('alert_message') .'</div>';
		
		endwhile;
		
		
		echo '</div><div class="slick-arrows alert"><button type="button" class="slick-prev">'.theme_get_icon(array('icon' => 'chevron-left','size' =>  24,'label' => 'Left Arrow icon')).' <span>Previous</span></button> <button type="button" class="slick-next"><span>Next</span> '.theme_get_icon(array('icon' => 'chevron-right','size' =>  24,'label' => 'Right Arrow icon')).'</button></div><script type="text/javascript">jQuery(document).ready(function(){ jQuery(".alerts-carousel").slick({ slidesToShow: 1, slidesToScroll: 1, arrows: true, dots: false, autoplay: true, autoplaySpeed: 8000, infinite: true, centerMode: false, focusOnSelect: true, prevArrow: ".alert .slick-prev", nextArrow: ".alert .slick-next"});  });</script></div>';
		
		
		endif;
	}
	
	
	function theme_render_services_carousel($block, $content = '', $is_preview = false){
		if( have_rows('services')) : 
		
		echo '<div class="carousel-wrapper"><div class="slick-title-dots"></div><div class="services-carousel';
		
		if(array_key_exists('className', $block)) echo ' ' . $block['className'];
				
		echo '">';
		
		$dot_titles = '';
		$counter = 1;
		
		while ( have_rows('services') ) : the_row();
		
		echo '<div class="service">';
		
		if(!empty(get_sub_field('service_image')))  echo '<div class="wp-block-columns valign"><div class="wp-block-column"><a href="'.get_sub_field('service_link').'">' .  wp_get_attachment_image(get_sub_field('service_image'), 'large'). '</a></div><div class="wp-block-column">';
		
		echo '<h3>' . get_sub_field('service_title') . '</h3>';
		
		if(!empty(get_sub_field('service_description'))) echo '<p>' . get_sub_field('service_description') . '</p>';
		
		echo '<div class="wp-block-buttons is-layout-flex"><div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-white-color has-text-color wp-element-button" href="'.get_sub_field('service_link').'">Learn More</a></div></div>';
		
		if(!empty(get_sub_field('service_image'))) echo '</div></div>';
		
		echo '</div>';
		
		$dot_titles .= '.slick-title-dots li:nth-child('.$counter.') button::before { content: "' . get_sub_field('nav_title') . '"; } ';

		$counter++;
		
		endwhile;
		
		
		echo '</div><div class="slick-arrows services"><button type="button" class="slick-prev">'.theme_get_icon(array('icon' => 'chevron-left','size' =>  24,'label' => 'Left Arrow icon')).' <span>Previous</span></button> <button type="button" class="slick-next"><span>Next</span> '.theme_get_icon(array('icon' => 'chevron-right','size' =>  24,'label' => 'Right Arrow icon')).'</button></div><script type="text/javascript">jQuery(document).ready(function(){ jQuery(".services-carousel").slick({ slidesToShow: 1, slidesToScroll: 1, arrows: true, dots: true, appendDots: ".slick-title-dots", autoplay: true, autoplaySpeed: 8000, infinite: true, centerMode: false, focusOnSelect: true, prevArrow: ".services .slick-prev", nextArrow: ".services .slick-next"});  });</script><style type="text/css">'.$dot_titles.'</style></div>';
		
		
		endif;
	}
	
function theme_render_services_block($block, $content = '', $is_preview = false) {

	echo '<div id="services" class="services-block';
		
		if(array_key_exists('className', $block)) echo ' ' . $block['className'];
				
		echo '">';
		
	echo '<div class="services">';
		
		$services = theme_get_field('services_offered');
		$descriptions = '';
	
			if(!empty($services)) :
				foreach ($services as $service) {
					$service_excerpt = substrwords(theme_get_field($service, 'option'), 115, ' ...');
					echo '<div class="service-box '.$service.'">'.$service_excerpt.' </p><p><a class="more-link featherlight-link" href="#" data-featherlight="#'.$service.'">Read More</a></p></div>';
					$descriptions .= '<div id="'.$service.'" class="lightbox service-box '.$service.'">'.theme_get_field($service, 'option').'</div>';
				}
			
			endif;	
	
	echo '</div></div>' . $descriptions;
		
		
}	

function theme_render_home_collage($block, $content = '', $is_preview = false) {

	echo '<div class="home-collage';
		
		if(array_key_exists('className', $block)) echo ' ' . $block['className'];
				
		echo '"><div class="column-1">';
		
		echo '<div class="block-1"><div class="image">'.wp_get_attachment_image(theme_get_field('image_1'), 'large').'</div><div class="text">'.theme_get_field('text_1').'</div></div>';
	
		echo '</div><div class="column-2"><div class="row-1"><div class="block-2"><div class="text">'.theme_get_field('text_2').'</div><div class="image">'.wp_get_attachment_image(theme_get_field('image_2'), 'large').'</div></div>';

		echo '<div class="block-3"><div class="text">'.theme_get_field('text_3').'</div><div class="image">'.wp_get_attachment_image(theme_get_field('image_3'), 'large').'</div></div></div>';

		echo '<div class="row-2"><div class="block-4"><div class="text">'.theme_get_field('text_4').'</div><div class="image">'.wp_get_attachment_image(theme_get_field('image_4'), 'large').'</div></div>';

		echo '<div class="block-5"><div class="text">'.theme_get_field('text_5').'<div class="wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link has-accent-4-background-color has-background wp-element-button" href="'.theme_get_field('button_link').'">'.theme_get_field('button_text').'</a></div></div></div></div></div>';

	echo '</div></div>';
		
		
}