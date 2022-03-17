<?php if( ! defined( 'ABSPATH' ) ) exit();
	
	get_header();

	$event_info = new WP_Query(
		array(
			'post_type'      => 'event',
			'p'	=> $_GET['p'],
			'post_status'    => 'pending',
		)
	);

		
		/**
		 * Hook: el_before_main_content
		 * @hooked: el_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked el_breadcrumb - 20
		 */
		remove_action( 'el_before_main_content','el_output_content_wrapper' );
		do_action( 'el_before_main_content' );


			if( $event_info->have_posts() ):

				while ( $event_info->have_posts() ) : $event_info->the_post();

					
						el_get_template_part( 'content', 'single-event' ); 
					

				endwhile; // end of the loop.

			endif; wp_reset_postdata(); wp_reset_query();


	/**
	 * Hook: el_after_main_content.
	 *
	 * @hooked el_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	remove_action( 'el_before_main_content','el_output_content_wrapper' );
	do_action( 'el_after_main_content' );


get_footer();
