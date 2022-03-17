<?php if( ! defined( 'ABSPATH' ) ) exit(); 

get_header();

$author_id = get_query_var( 'author' );
$display_name = get_user_meta( $author_id, 'display_name', true ) ? get_user_meta( $author_id, 'display_name', true ) : get_the_author_meta( 'display_name', $author_id );

$orderby = EL()->options->event->get( 'archive_order_by' );
$order = $orderby == 'start_date' ? 'DESC' : EL()->options->event->get( 'archive_order' );

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$listing_events = get_vendor_events( $order , $orderby, 'publish', $author_id, $paged );

?>

<div class="author_page">
	
	<div class="author_page_sidebar">
		<?php do_action( 'el_author_info' ); ?>
	</div>

	<!-- Event List -->
	<div class="event_list">
		<h3 class="heading second_font"><?php echo esc_html( $display_name ); esc_html_e( '\'s Listing ', 'eventlist' ); ?></h3>
		<?php if($listing_events->have_posts() ) : while ( $listing_events->have_posts() ) : $listing_events->the_post(); 
			$post_id = get_the_ID();
			if (has_image_size( 'el_img_squa' ) && has_post_thumbnail() && get_the_post_thumbnail()) {
				$url_img = wp_get_attachment_image_url( get_post_thumbnail_id() , 'el_img_squa' );
			} else {
				$url_img = EL_PLUGIN_URI.'assets/img/no_tmb_square.png';
			}

			?>
			<div class="item_event">
				<div class="image_feature" style="background-image: url(<?php echo $url_img ?>)">
					<img src="<?php echo esc_url($url_img) ?>" alt="<?php echo get_the_title() ?>">
					<div class="categories">
						<?php 
						$get_cat = get_the_terms( $post_id, 'event_cat' );
						if ( !empty( $get_cat ) ) {
							foreach ( $get_cat as $v_cat ) { 
								$color_cat = get_term_meta($v_cat->term_id, '_category_color', true);
								$style = "";
								if ( $color_cat !== "" ) {
									$style = "style= 'background-color: #" . $color_cat . "'" ;
								}
								?>
								<a <?php echo $style ?> href="<?php echo esc_url(get_term_link($v_cat->term_id)) ?>"><?php echo esc_html($v_cat->name) ?></a>
								<?php
							}
						} ?>
					</div>
				</div>

				<div class="info_event">
					<div class="status-title">
						<?php 
							do_action( 'el_loop_event_title' );
							
							do_action( 'el_loop_event_status' );
						?>
					</div>
					<?php

					do_action( 'el_loop_event_ratting' );

					do_action( 'el_loop_event_time' );

					do_action( 'el_loop_event_location' );
					
					do_action( 'el_loop_event_price' );

					do_action( 'el_loop_event_favourite' );

					?>

				</div>

				
			</div>


		<?php endwhile; else : ?> 

		<p><?php esc_html_e( 'Not Found Event', 'eventlist' ); ?></p>

		<?php ; endif; wp_reset_postdata(); ?>

		<?php if ($listing_events->max_num_pages > 1) { ?>
			<nav class="el-pagination">
				<?php
				echo paginate_links( apply_filters( 'el_pagination_args', array(
					'base'         => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
					'format'       => '',
					'add_args'     => '',
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'total'        => $listing_events->max_num_pages,
					'prev_text'    => __( 'Previous', 'eventlist' ),
					'next_text'    => __( 'Next', 'eventlist' ),
					'type'         => 'list',
					'end_size'     => 3,
					'mid_size'     => 3
				) ) );
				?>
			</nav>
		<?php } ?>

	</div>

</div>


<?php

get_footer();