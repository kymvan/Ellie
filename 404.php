<?php

// Remove default loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'theme_404' );
function theme_404() {

	genesis_markup( array(
		'open' => '<article class="entry">',
		'context' => 'entry-404',
	) );

		
		echo '<div class="wp-container-1 wp-block-group alignfull has-accent-2-background-color has-background"><div class="wp-block-group__inner-container"><h1 class="has-accent-1-color has-text-color has-h-1-font-size">Not Found, Error 404</h1><p class="has-accent-1-color has-text-color has-large-font-size">Uh oh!  The page you are looking for no longer exists. </p></div></div>';
		
		
		echo '<div class="entry-content">';

			if ( genesis_html5() ) :

				echo apply_filters( 'genesis_404_entry_content', '<p>' . sprintf( 'Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for or try looking through the sitemap below.', trailingslashit( home_url() ) ) . '</p>' );

			else :
	?>

			<p><?php printf( 'Uh oh!  The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking foror try looking through the sitemap below.', trailingslashit( home_url() ) ); ?></p>



	<?php
			endif;

			if ( genesis_a11y( '404-page' ) ) {
				echo '<hr /><h2>' . 'Sitemap' . '</h2><div class="site-map">';
				$sitemap  = sprintf( '<%2$s>%1$s</%2$s>', __( 'Pages:', 'genesis' ), 'h3' );
				$sitemap .= sprintf( '<ul>%s</ul>', wp_list_pages( 'title_li=&echo=0' ) );
				
				$post_counts = wp_count_posts();
				if ( $post_counts->publish > 0 ) {
					$sitemap .= sprintf( '<%2$s>%1$s</%2$s>', __( 'Blog Categories:', 'genesis' ),  'h3' );
					$sitemap .= sprintf( '<ul>%s</ul>', wp_list_categories( 'sort_column=name&title_li=&echo=0' ) );
			
					$sitemap .= sprintf( '<%2$s>%1$s</%2$s>', __( 'Recent Blog Posts:', 'genesis' ),  'h3' );
					$sitemap .= sprintf( '<ul>%s</ul>', wp_get_archives( 'type=postbypost&limit=100&echo=0' ) );
				}
				
				echo $sitemap;
				echo '</div>';
			} else {
				genesis_sitemap( 'h4' );
			}

		echo '</div>';

	genesis_markup( array(
		'close' => '</article>',
		'context' => 'entry-404',
	) );

}

genesis();