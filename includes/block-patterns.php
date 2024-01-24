<?php 

add_action( 'init', 'theme_custom_wp_block_patterns' );

function theme_custom_wp_block_patterns() {

    register_block_pattern('page-intro-block',
        array(
            'title'       => __( 'Beacon Page Intro Block', 'page-intro-block' ),
            
            'description' => _x( 'Includes a cover block, introductory text, heading text, and a call to action button.', 'Block pattern description', 'page-intro-block' ),
            
            'content'     => "<!-- wp:cover {\"url\":\"".site_url()."/wp-content/uploads/home.jpg\",\"id\":44,\"hasParallax\":true,\"dimRatio\":0,\"align\":\"full\"} -->\n<div class=\"wp-block-cover alignfull has-parallax page-intro-block\" style=\"background-image:url(".site_url()."/wp-content/uploads/home.jpg)\"><div class=\"wp-block-cover__inner-container\"><!-- wp:paragraph {\"align\":\"center\",\"fontSize\":\"small\"} -->\n<p class=\"has-text-align-center has-small-font-size\">Introductory text goes here.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:heading {\"textAlign\":\"center\",\"level\":1} -->\n<h1 class=\"has-text-align-center\">Home Page</h1>\n<!-- /wp:heading -->\n\n<!-- wp:buttons {\"align\":\"center\"} -->\n<div class=\"wp-block-buttons aligncenter\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link\" href=\"".site_url()."/contact/\">Call to Action</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons --></div></div>\n<!-- /wp:cover -->",
            
            'categories'  => array('header'),
        )
    );

} 
