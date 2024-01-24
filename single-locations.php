<?php 


add_action( 'wp_enqueue_scripts', 'template_global_enqueues' );
function template_global_enqueues() {
	global $wp_query;
	
	wp_enqueue_script(  'google_map_api' );
	
   	wp_enqueue_script( 'ajax-pagination',  get_stylesheet_directory_uri() . '/assets/js/ajax-pagination.js', array( 'jquery' ), '1.0', true );	
	wp_localize_script( 'ajax-pagination', 'ajaxpagination', array(	'ajaxurl' => admin_url( 'admin-ajax.php' ),	'query_vars' => json_encode( $wp_query->query )));
}

remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'template_do_post_content' );
function template_do_post_content(){
 	global $post;
 	 	
 	if(!post_password_required()) :
 	
 	$directors = get_posts(array('post_type'=>'people', 'numberposts' => 1, 'tax_query' => array(array('taxonomy'=>'people-location','field' => 'slug','terms' => $post->post_name), array('taxonomy'=>'people-department','field' => 'slug','terms' => 'clinic-directors'))));

	$people = get_posts(array('post_type'=>'people', 'numberposts' => -1, 'orderby' => array('menu_order' => 'ASC', 'title' => 'ASC'), 'tax_query' => array(array('taxonomy'=>'people-location','field' => 'slug','terms' => $post->post_name))));
	
	$location = theme_get_field('google_maps_iframe');
	
	$location_title = str_replace("'", "&#039;", $post->post_title);
	
	/** Anchor Nav **/
	echo '<div id="anchor-menu"  class="wp-block-group alignfull has-background has-accent-6-background-color"><div class="wp-block-group__inner-container"><div class="label"><strong>Quick Links: </strong></div><nav class="nav-location" aria-label="Main"><button class="menu-toggle" aria-label="Menu" aria-pressed="false"><span>Menu</span></button><ul class="menu genesis-nav-menu"><li class="menu-item"><a href="#services">Services</a></li><li class="menu-item"><a href="#payment">Payment</a></li><li class="menu-item"><a href="#location">Directions</a></li>';
	
		if(count($people) > 0) echo '<li class="menu-item"><a href="#team">Team</a></li>';
	
	echo '<li class="menu-item"><a href="#blog">Blog</a></li><li class="menu-item"><a href="#careers">Careers</a></li>';
	
	if(!empty(theme_get_field('bill_pay'))) echo  '<li class="menu-item billpay"><a target="_blank" href="'.theme_get_field('bill_pay').'">Client Portal</a></li>';
	
	echo '</ul></nav></div></div>';
	
	
 
	/** Header **/
	echo '<div id="header" class="wp-block-group alignfull has-background has-accent-2-background-color"><div class="wp-block-group__inner-container"><div class="narrow"><div class="heading-text">';
	
	if(theme_get_field('clinic_type') == 'original') echo '<img class="badge" src="'.get_site_url().'/wp-content/uploads/2022/05/Original-16-400x400.png" alt="The Original Sixteen badge" width="140" height="140" />';
	
	if(!empty(theme_get_field('address_line_1'))) : 
	
		echo '<p class="marker">' . theme_get_icon(array('icon' => 'map-marker-alt', 'size' => 18, 'label' => 'Map marker icon' ));
		if($location['city'] == '') echo $post->post_title; else echo $location['city'];
		echo ', ' . $location['state_short'] . '</p>';
	
	else : 
		echo '<p class="marker telehealth">' . theme_get_icon(array('icon' => 'map-marker-alt', 'size' => 18, 'label' => 'Map marker icon' )) . 'Telehealth Only</p>';
		
	endif;	
	
		echo '<h1>' . $location['state'] . ' <br />' . $location_title . ' <span>';
		if(empty(theme_get_field('address_line_1'))) echo 'Telehealth ';
		
		if(!empty(theme_get_field('h1_title'))) echo theme_get_field('h1_title').'</span>';
		else echo theme_get_field('h1', 'option').'</span>';
	
	echo '</h1>';
	
	echo '<h2>'.theme_get_field('h2', 'option').'</h2>';
	
	echo '<div class="is-content-justification-center wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link has-accent-4-background-color" href="';
	
		if(theme_get_field('clinic_type') == 'location' || theme_get_field('clinic_type') == 'original') echo theme_get_field('location_url', 'option') . '">';
		else if(theme_get_field('clinic_type') == 'waitlist') echo theme_get_field('waitlist_url', 'option') . '" target="_blank">';
		else echo theme_get_field('franchise_url', 'option') . '" target="_blank">';
	
		echo 'Request My Appointment</a></div><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-accent-4-color" href="tel:1-'.theme_get_field('clinic_phone_number').'">Or Call: '.theme_get_field('clinic_phone_number').'</a></div>';
		
	echo '</div></div>';
	
	echo '<div class="heading-image';
	
		if(!empty(theme_get_field('video_embed_url'))) echo " video-block";
		
		echo '">';

		if(!empty(theme_get_field('video_embed_url'))) echo '<a class="featherlight-link"  href="'.theme_get_field('video_embed_url').'" data-featherlight="iframe" data-featherlight-iframe-width="1120" data-featherlight-iframe-height="630" data-featherlight-iframe-frameborder="0" data-featherlight-iframe-allow="autoplay; encrypted-media" data-featherlight-iframe-allowfullscreen="true"><div class="player">' . theme_get_icon(array('icon'=>'play-circle', 'size' => 60, 'label' => 'Play Icon')) . '<span>Play Video</span></div>';
		
		if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(), 'location', array('class' => 'location-image', 'alt' => $location['state'] . ' ' . get_the_title() . ' Therapy Clinic'));
		
		else echo '<img class="location-image" src="/wp-content/themes/ellie/assets/images/nolocation.jpg" width="500" height="500" alt="Ellie placeholder logo image" />';
		
		if(!empty(theme_get_field('video_embed_url'))) echo '</a>'; 
				
		echo '</div>';
	
	echo '</div></div></div>';
	
	/** Services **/
	echo '<div id="services" class="wp-block-group alignfull has-background has-off-white-background-color"><div class="wp-block-group__inner-container"><div class="wp-block-columns"><div class="wp-block-column"><h2 class="nomargin has-accent-1-color has-text-color">Mental health therapy services at '. $location_title .'</h2><h3 class="has-large-font-size">#LiveAuthentic with professional counseling services</h3></div><div class="wp-block-column"><p>Ellie Mental Health in  '. $location_title .',  '. $location['state'] .' isn’t your average therapy clinic. We’ve created a comfy, judgment-free zone where you can be authentic, get real about where you’re at in your mental health, and receive the compassionate care you deserve. We strive to break down treatment barriers and provide you with customized counseling services that meet your therapy needs.</p></div></div><div class="services">';
		
		$services = theme_get_field('services_offered');
		
		$descriptions = '';
	
			if(!empty($services)) :
				foreach ($services as $service) {
					$service_excerpt = substrwords(theme_get_field($service, 'option'), 115, ' ...');
					echo '<div class="service-box '.$service.'">'.$service_excerpt.' </p><p><a class="more-link featherlight-link" href="#" data-featherlight="#'.$service.'">Read More</a></p></div>';
					$descriptions .= '<div id="'.$service.'" class="lightbox '.$service.'">'.theme_get_field($service, 'option').'</div>';
				}
			
			endif;	
	
	echo '</div></div></div>' . $descriptions;
	
	echo '<div class="wp-block-group alignfull has-background has-accent-2-background-color banner narrow talk-cta"><div class="wp-block-group__inner-container"><div class="wp-block-columns valign"><div class="wp-block-column" style="flex-basis: 55%;"><h3 class="has-text-color has-accent-1-color">Time to get it off your chest and talk it out</h3></div><div class="wp-block-column"><div class="wp-block-buttons has-text-align-center"><div class="wp-block-button"><a class="wp-block-button__link has-accent-4-background-color has-white-color" href="';
	
	if(theme_get_field('clinic_type') == 'location' || theme_get_field('clinic_type') == 'original') echo theme_get_field('location_url', 'option') . '">';
		else if(theme_get_field('clinic_type') == 'waitlist') echo theme_get_field('waitlist_url', 'option') . '" target="_blank">';
		else echo theme_get_field('franchise_url', 'option') . '" target="_blank">';
		
	 echo 'Request My Appointment</a></div></div></div></div></div></div>';
	 
	 /** Group Therapy **/
	 if(have_rows('therapy_groups')) :
	 
	 	echo '<div id="groups" class="wp-block-group alignfull mint-rainbow-left circle-right "><div class="wp-block-group__inner-container"><div class="wp-block-columns"><div class="wp-block-column"><h2 class="has-accent-1-color has-text-color nomargin">Group therapy for those that enjoy growing with others!</h2><p class="has-large-font-size">Get out and make friends in similar<br /> situations.  We are here to help.</p></div><div class="wp-block-column"><p>Find group therapy near you in  '. $location_title .',  '. $location['state'] .' that is catered to your unique demographic, history, and mental health needs.  Group therapy provides a nuturing space to heal and grow in community with others.</p></div></div><div class="groups">';

		$counter = 1;
		
		while ( have_rows('therapy_groups') ) : the_row();
		
			echo '<div class="group">';
			
			if(!empty(get_sub_field('group_name'))) echo '<h3 class="has-accent-1-color has-text-color nomargin">' . get_sub_field('group_name') . '</h3>';
			
			if(!empty(get_sub_field('group_restrictions'))) echo '<p class="has-large-font-size has-accent-1-color has-text-color">' . get_sub_field('group_restrictions') . '</p>';


			
			if(!empty(get_sub_field('group_description'))) echo '<p>' . get_sub_field('group_description') . '</p>';
			
			if(!empty(get_sub_field('leader_email'))) echo '<p><a class="more-link email-link" href="mailto:'.get_sub_field('leader_email') .'">Email ' . get_sub_field('group_leader') . ' to learn more</a></p>';
			
			if(!empty(get_sub_field('signup_url'))) echo '<p><a class="more-link email-link" target="_blank" href="'.get_sub_field('signup_url') .'">Learn more</a></p>';

			
			echo '</div>';
			
			$counter++;
					
		endwhile;
		
	echo '</div></div></div>';

		
	endif;
	
	/** Conditions & Specialities **/
	echo '<div id="conditions" class="wp-block-group alignfull has-background has-accent-1-background-color"><div class="wp-block-group__inner-container">';
	
		echo '<h2 class="has-text-align-center has-white-color has-text-color">Conditions &amp; Specialities</h2><p class="has-text-align-center  has-white-color has-text-color very-narrow">We provide support for a wide range of mental disorders and common mental health issues at our Ellie Mental Health Clinic in '.$location_title.'. No matter your concerns, your compassionate Ellie therapist will provide you with the non-judgmental care you deserve.</p>';
	
		if(!empty(theme_get_field('conditions'))) echo theme_get_field('conditions');
	
	
	echo '<div class="wp-block-group has-background has-accent-2-background-color"><div class="wp-block-group__inner-container"><h3 class="has-text-align-center has-accent-1-color has-text-color">Want to learn more about our mental health services?</h3><div class="wp-block-buttons has-text-align-center"><div class="wp-block-button"><a class="wp-block-button__link  has-accent-4-background-color" href="tel:1-'.theme_get_field('clinic_phone_number').'">Call: '.theme_get_field('clinic_phone_number').'</a></div></div></div></div></div></div>';
	
	
	/** Payment **/
	echo '<div id="payment" class="wp-block-group alignfull has-background has-white-background-color"><div class="wp-block-group__inner-container"><div class="wp-block-columns"><div class="wp-block-column"><h2 class="has-accent-1-color has-text-color nomargin">Accepted payment at the '.$location_title.' clinic</h2><p class="has-accent-1-color has-text-color has-large-font-size">We strive to make our care accessible and affordable to everyone. Review our full list of payment types and insurances accepted at this location.</p><div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex"><div class="wp-block-button"><a class="wp-block-button__link has-accent-4-background-color" href="tel:1-'.theme_get_field('clinic_phone_number').'">Have Questions?</a></div>';
	
	if(!empty(theme_get_field('bill_pay'))) echo  '<div class="wp-block-button"><a class="wp-block-button__link has-accent-2-background-color" href="'.theme_get_field('bill_pay').'" target="_blank">Pay My Bill</a></div>';

	
	echo '</div></div><div class="wp-block-column">';
	
	if(!empty(theme_get_field('payment_options_list'))) :

	$options = theme_get_field('payment_options_list');
		echo '<p class="has-large-font-size">Currently accepting:</p><ul>';
	
		foreach( $options as $i => $row ):
		
		
		echo '<li>' .$row['option'] . '</li>'; 
		
		
		endforeach;
		
		echo '</ul>';
		
	else :
	
		echo '<p>This Ellie location is currently a fee-for-service clinic and is not accepting insurance. We are working on expanding our list of accepted insurance providers. Please check-in soon to see an updated list of payment options accepted at the '.$location_title.'  clinic. </p><p><strong>Currently Accepting:</strong></p><ul><li>Fee-for-Service</li><ul>';
	
	
	endif;
	
	echo '</div></div></div></div>';
	
	/** Map & Directions **/
	echo '<div id="location" class="wp-block-group alignfull has-background has-accent-2-background-color"><div class="wp-block-group__inner-container"><h2 class="has-text-align-center has-accent-1-color has-text-color">Find the '.$location_title.' therapy clinic</h2>';
	
	if(!empty(theme_get_field('google_maps_iframe')) && !empty(theme_get_field('address_line_1'))) :
		
		echo '<div class="acf-map" data-zoom="16"><div class="marker" data-lat="'. esc_attr($location['lat']) .'" data-lng="'.esc_attr($location['lng']) .'"></div></div>';
	
	?>
		<script type="text/javascript"> (function( $ ) { function initMap( $el ) { 			
			    var $markers = $el.find('.marker');
			
			    var mapArgs = {
			        zoom        : $el.data('zoom') || 16,
			        mapTypeId   : google.maps.MapTypeId.ROADMAP
			    };
			    var map = new google.maps.Map( $el[0], mapArgs );
			
			    map.markers = [];
			    $markers.each(function(){
			        initMarker( $(this), map );
			    });
			
			    centerMap( map );
				 
				 return map;
			}
		
			function initMarker( $marker, map ) {
			
			    var lat = $marker.data('lat');
			    var lng = $marker.data('lng');
			    var latLng = {
			        lat: parseFloat( lat ),
			        lng: parseFloat( lng )
			    };
			
			    var marker = new google.maps.Marker({
			        position : latLng,
			        map: map
			    });
			
			    map.markers.push( marker );
				
			        var infowindow = new google.maps.InfoWindow({
			            content: '<div class="info_window"><?php echo '<a href="https://www.google.com/maps/dir//'.esc_attr($location['address']).'" target="_blank"><strong>Ellie Mental Health <br />' . $location_title;
						if(!empty($location['state'])) echo ' '.$location['state'];
						echo ' Clinic</strong></a>';
			            ?></div>'
			        });
			
			       infowindow.open( map, marker );
			    
			}
			
			
			function centerMap( map ) {
			    var bounds = new google.maps.LatLngBounds();
			    map.markers.forEach(function( marker ){
			        bounds.extend({
			            lat: marker.position.lat(),
			            lng: marker.position.lng()
			        });
			    });
			
			    if( map.markers.length == 1 ){
			        map.setCenter( bounds.getCenter() );
			
			    } else{
			        map.fitBounds( bounds );
			    }
			}
			
			$(document).ready(function(){
			    $('.acf-map').each(function(){
			        var map = initMap( $(this) );
			    });
			});
			
			})(jQuery);
			</script><?php
	
	endif;
	
	echo '<div class="wp-block-columns"><div class="wp-block-column">';
	
	echo theme_get_icon(array('icon' => 'map-marker-alt', 'size' => 30, 'label' => 'Map marker icon' )) . '<h3 class="has-accent-1-color has-text-color">Address</h3><p>';
	
	if(!empty(theme_get_field('address_line_1'))) echo theme_get_field('address_line_1');
	else echo 'Telehealth available now. In-person therapy coming soon!';
	
	if(!empty(theme_get_field('address_line_2'))) echo '<br /> '. theme_get_field('address_line_2');
		
	if(!empty(theme_get_field('city_state_zip'))) echo '<br /> '. theme_get_field('city_state_zip');
		
	echo '</p>';
	
	if(!empty(theme_get_field('address_line_1'))) echo '<p><a href="https://www.google.com/maps/dir//'.esc_attr($location['address']).'" target="_blank"><strong>Get Directions</strong></a></p>';
	
	echo '</div>';
	
	if(!empty(theme_get_field('office_hours'))) echo '<div class="wp-block-column">'.theme_get_icon(array('icon' => 'clock', 'size' => 30, 'label' => 'Map marker icon' )).'<h3 class="has-accent-1-color has-text-color">Clinic Hours</h3>'. theme_get_field('office_hours') . '</div>';
	
		
	echo '<div class="wp-block-column">'.theme_get_icon(array('icon' => 'users', 'size' => 30, 'label' => 'Map marker icon' )).'<h3 class="has-accent-1-color has-text-color">Contact Us</h3><p>';	
		
	if(!empty(theme_get_field('clinic_phone_number'))) echo '<a href="tel:1-'.theme_get_field('clinic_phone_number').'">'.theme_get_field('clinic_phone_number').'</a>';
	
	if(!empty(theme_get_field('clinic_fax_number'))) echo '<br /><a href="tel:1-'.theme_get_field('clinic_fax_number').'">'.theme_get_field('clinic_fax_number').' FAX</a>';
	
	if(!empty(theme_get_field('clinic_email'))) echo '<br /><a href="mailto:'.theme_get_field('clinic_email').'">'.theme_get_field('clinic_email').'</a>';
	
	echo '</p>';

	//Social Icons
		if(!empty(theme_get_field('facebook')) || !empty(theme_get_field('twitter')) || !empty(theme_get_field('youtube')) || !empty(theme_get_field('instagram')) || !empty(theme_get_field('linkedin')) || !empty(theme_get_field('google_reviews'))):
		
		echo '<div class="menu-shortcode"><div class="menu-social-menu-container"><ul class="menu">';
	
		
		if(!empty(theme_get_field('google_reviews'))) : 
			echo '<li class="menu-item menu-item-has-icon"><a href="'.theme_get_field('google_reviews').'" target="_blank">'.theme_get_icon(array('icon' => 'google', 'size' => 18, 'label' => 'Ellie Mental Health '.$location_title . ' ' . $location['state'].' on Google' )).'<span class="menu-item-text hide-label">Google Reviews</span></a></li>';
		endif;
		
		if(!empty(theme_get_field('facebook'))) : 
			echo '<li class="menu-item menu-item-has-icon"><a href="'.theme_get_field('facebook').'" target="_blank">'.theme_get_icon(array('icon' => 'facebook-f', 'size' => 18, 'label' => 'Ellie Mental Health '.$location_title . ' ' . $location['state'].' on Facebook' )).'<span class="menu-item-text hide-label">Facebook</span></a></li>';
		endif;
		
		if(!empty(theme_get_field('twitter'))) : 
			echo '<li class="menu-item menu-item-has-icon"><a href="'.theme_get_field('twitter').'" target="_blank">'.theme_get_icon(array('icon' => 'twitter', 'size' => 18, 'label' => 'Ellie Mental Health '.$location_title . ' ' . $location['state'].' on Twitter ' )).'<span class="menu-item-text hide-label">Twitter</span></a></li>';
		endif;
		
		if(!empty(theme_get_field('youtube'))) : 
			echo '<li class="menu-item menu-item-has-icon"><a href="'.theme_get_field('youtube').'" target="_blank">'.theme_get_icon(array('icon' => 'youtube', 'size' => 18, 'label' => 'Ellie Mental Health '.$location_title . ' ' . $location['state'].' on YouTube' )).'<span class="menu-item-text hide-label">YouTube</span></a></li>';
		endif;
		
		if(!empty(theme_get_field('instagram'))) : 
			echo '<li class="menu-item menu-item-has-icon"><a href="'.theme_get_field('instagram').'" target="_blank">'.theme_get_icon(array('icon' => 'instagram', 'size' => 18, 'label' => 'Ellie Mental Health '.$location_title . ' ' . $location['state'].' on Instagram' )).'<span class="menu-item-text hide-label">Instagram</span></a></li>';
		endif;
		
		if(!empty(theme_get_field('linkedin'))) : 
			echo '<li class="menu-item menu-item-has-icon"><a href="'.theme_get_field('linkedin').'" target="_blank">'.theme_get_icon(array('icon' => 'linkedin-in', 'size' => 18, 'label' => 'Ellie Mental Health '.$location_title . ' ' . $location['state'].' on LinkedIn' )).'<span class="menu-item-text hide-label">LinkedIn</span></a></li>';
		endif;
	
		echo '</ul></div></div>';
		
		endif;

	echo '</div></div></div></div>';
	
	/** Office Gallery **/
	if(!empty(theme_get_field('office_photos'))) :
	
		echo '<div id="gallery" class="wp-block-group alignfull has-background has-accent-6-background-color"><div class="wp-block-group__inner-container"><h2 class="has-text-align-center has-accent-1-color has-text-color">Tour the '.$location_title.' therapy clinic</h2><div class="gallery">';
		
		$photos = theme_get_field('office_photos');
		
		foreach ($photos as $image) {
			echo '<a class="gallery-item" href="'.wp_get_attachment_url($image).'" data-featherlight="image">' . wp_get_attachment_image($image, 'gallery'). '</a>';
		}
		
		echo '</div></div></div>';
	
	endif;
	
	/** Ellie Match **/
	echo '<div id="match" class="wp-block-group alignfull has-background has-accent-1-background-color"><div class="wp-block-group__inner-container"><div class="wp-block-columns valign"><div class="wp-block-column"><div class="wp-block-image"><img src="/wp-content/themes/ellie/assets/images/ellie-match.png" width="630" height="590" alt="Ellie therapists ready to be matched with you!" /></div></div><div class="wp-block-column"><h2 class="has-text-color has-white-color nomargin"><span class="line ellie">Ellie</span> Match</h2>';
	
		if(!empty(theme_get_field('ellie_match', 'option'))) echo theme_get_field('ellie_match', 'option');
		
		echo '<div class="wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-accent-1-color" href="';
		
		if(theme_get_field('clinic_type') == 'location' || theme_get_field('clinic_type') == 'original') echo theme_get_field('location_url', 'option') . '">';
		else if(theme_get_field('clinic_type') == 'waitlist') echo theme_get_field('waitlist_url', 'option') . '" target="_blank">';
		else echo theme_get_field('franchise_url', 'option') . '" target="_blank">';
			
	echo 'Get Matched</a></div></div></div></div></div></div>';
	
	/** Meet Your Therapist **/	
	
	if(count($people) > 0) :
	
	echo '<div id="team" class="wp-block-group alignfull has-background has-white-background-color"><div class="wp-block-group__inner-container"><h2 class="has-text-align-center has-text-color has-accent-1-color">Get to know the Ellie team at '.$location_title.'</h2><p class="has-text-align-center very-narrow">We have an incredible group of therapists who are encouraged to be unique and creative while offering customized care. To learn more about the team, check out their bios below!</p>';
	
	/** Director **/
			if($directors) :
		
			echo '<div class="wp-block-group director single-person"><div class="wp-block-group__inner-container">';
			
			foreach ($directors as $person) {
					
					echo '<div class="people type-people has-post-thumbnail entry"><div class="entry-header">';
					
					if(has_post_thumbnail($person->ID)) echo '<a class="post-link featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content">' . get_the_post_thumbnail($person->ID, 'team', array('alt' => get_the_title($person->ID). ' headshot')) . '</a>';
					
					else echo '<a class="post-link featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content"><img  width="400" height="400" src="/wp-content/themes/ellie/assets/images/placeholder.jpg" class="attachment-location size-location wp-post-image" alt="'. get_the_title() . ' Headshot" /></a>';
					
					echo '<div class="inner"><h2 class="has-text-color has-accent-1-color has-large-font-size">Meet the '.$location_title.' clinic director</h2><h3 class="entry-title has-text-color has-accent-1-color" itemprop="headline">'.get_the_title($person->ID);
					
					if(!empty(theme_get_field('credentials', $person->ID))) echo ', '.theme_get_field('credentials', $person->ID);
															
					echo '</h3>';
					
					$bio = substrwords(strip_tags($person->post_content), 335, '');
															
					if(strlen($bio) <= 300) echo '<p>' . strip_tags($person->post_content) . '</p>';
					
					else echo '<p>' . $bio . '… <a class="post-link featherlight-link more-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content">Read More</a></p>';
										
					echo '</div></div></div>';
			}
			
			echo '</div></div>';
			
			endif;
			
	
	if(count($people) > 1 || count($directors) == 0) :
	
		if(count($people) > 1) echo '<h2 class="has-text-align-center has-text-color has-accent-1-color">Meet your therapist at '.$location_title.'</h2>';
		
		echo '<div class="people-block"><div class="post-container">';

	
		foreach ($people as $person) {
				if(!in_array($person, $directors)) :
				
					echo '<div class="people type-people has-post-thumbnail entry  "><a class="post-link featherlight-link" href="#" data-featherlight="'. get_permalink($person->ID) . ' #genesis-content"><div class="entry-header">';
					
					if(has_post_thumbnail($person->ID)) echo get_the_post_thumbnail($person->ID, 'team', array('alt' => get_the_title($person->ID). ' headshot'));
					
					else echo '<img  width="400" height="400" src="/wp-content/themes/ellie/assets/images/placeholder.jpg" class="attachment-location size-location wp-post-image" alt="'. get_the_title($person->ID) . ' Headshot" />';
		
					
					echo '<h3 class="entry-title" itemprop="headline">'.get_the_title($person->ID).'</h3>';
					
					if(!empty(theme_get_field('credentials', $person->ID))) echo '<p class="credentials">'.theme_get_field('credentials', $person->ID).'</p>';
					if(!empty(theme_get_field('title_1', $person->ID))) echo '<p class="title">'.theme_get_field('title_1', $person->ID).'</p>';
					
					echo '</div></a></div>';
				
				endif;
		}
			
		echo '</div></div>';
		
		endif;
	
	echo '</div></div>';

	
	echo '<div class="wp-block-group alignfull has-background has-accent-1-background-color banner very-narrow therapist-cta"><div class="wp-block-group__inner-container"><h2 class="has-text-align-center has-white-color has-text-color nomargin">We know! It’s hard to pick.</h2><p class="has-text-align-center has-text-align-center has-accent-6-color has-text-color">All of our therapists are a great choice – but you can’t pick them all. Let us help!</p><div class="wp-block-buttons has-text-align-center"><div class="wp-block-button"><a class="wp-block-button__link  has-accent-4-background-color" href="tel:1-'.theme_get_field('clinic_phone_number').'">Call: '.theme_get_field('clinic_phone_number').'</a></div></div></div></div></div>';
	
	endif;
	
	/** Blog **/	
	if(theme_get_field('site_id') == 1 || theme_get_field('site_id') == '') $site_id = 1;
	else $site_id = theme_get_field('site_id');
	
	echo '<div id="blog" class="wp-block-group alignfull mint-rainbow triangle-top-left"><div class="wp-block-group__inner-container"><h2 class="has-text-align-center has-accent-1-color has-text-color nomargin">Check out ';
	
	if($site_id == 1 ) echo 'Ellie';
	else echo $location_title;
	
	echo '\'s mental health blog</h2><h3 class="has-text-align-center has-large-font-size">Tips and tricks to living a more authentic life.</h3><div class="blog-block"><div id="blog-id" style="display:none;">'.$site_id.'</div>';
	
	
	
	if(theme_get_field('clinic_type') == 'location' || theme_get_field('clinic_type') == 'original' || $site_id != 1): 
		echo '<div id="cat-id" style="display:none;">0</div><div class="post-container">'; 
		get_franchise_blog_posts($site_id, 1, 0);
	else:  
		echo '<div id="cat-id" style="display:none;">-87</div><div class="post-container">';
		get_franchise_blog_posts($site_id, 1, -106);
	
	endif;
	
	
	echo '</div></div></div></div>';

	/** Careers **/
	echo '<div id="careers" class="wp-block-group alignfull has-background has-accent-2-background-color narrow freaking"><div class="wp-block-group__inner-container"><div class="wp-block-columns  is-layout-flex wp-block-columns-is-layout-flex"><div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis: 60%;"><div class="wp-block-image"><img src="/wp-content/themes/ellie/assets/images/location-careers.png" width="645" height="430" alt="Happy therapists working at Ellie Mental Health" /></div></div><div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow"><h2 class="has-accent-1-color has-text-color nomargin">Looking for a therapy job in '.$location_title.'?</h2><p>Ellie has created an employment model that prioritizes creativity, culture, and compensation. If you’re looking for a place you can thrive in your professional life and make a difference in your community, you’ve found it!</p><div class="wp-block-buttons"><div class="wp-block-button"><a class="wp-block-button__link  has-accent-4-background-color has-white-color" href="https://ellie-careers.careerplug.com/jobs?z='.esc_attr($location['post_code']) .'&d=10#job_filters" target="_blank">Search for My Ellie Career </a></div></div></div></div></div></div>';
	
	else : 
	
	echo get_the_password_form();
	
	endif;
	
	

}
	
genesis();