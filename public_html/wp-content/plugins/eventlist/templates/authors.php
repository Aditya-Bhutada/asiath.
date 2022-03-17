<?php if( ! defined( 'ABSPATH' ) ) exit();
	get_header();

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$user_query = el_get_all_authors( 'el_event_manager', $paged );
	// Get the results
	$authors = $user_query->get_results();
?>
	<?php $global_layout = apply_filters( 'meup_theme_sidebar','' ); ?>
	<div class="wrap_site <?php echo esc_attr($global_layout); ?>">
		<div id="main-content" class="main authors_page">
			<?php 
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					the_content();
				endwhile;endif;

			 ?>
			<?php 
				// Check for results
				if (!empty($authors)) { ?>

				    <ul class="authors">
				   
					    <?php foreach ($authors as $author) {
					        // get all the user's data
					        $author_id = $author->ID;

					        $author_info = el_get_author_info( $author_id );
					        ?>
					        
					        <li>
					        	<a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?> ">
					        		<img src="<?php echo esc_url($author_info['img_path']) ?>" alt="<?php echo esc_attr( $author_info['display_name'] ); ?>" class="author_img">
					        	</a>
								
								<div class="ova-content">

									<a href="<?php echo esc_url( get_author_posts_url( $author->ID ) ); ?> ">
										<h2 class="title second_font">
											<?php echo esc_html( $author_info['display_name'] ); ?>
										</h2>
									</a>
									
									<?php if( $author_info['user_job'] ){ ?>	
										<div class="job"> <?php echo esc_html( $author_info['user_job'] ); ?></div>
									<?php } ?>

									<div class="contact">
										
										<?php if( $author_info['user_phone'] && apply_filters( 'el_show_phone_info', true ) ){ ?>	
											<a class="phone" href="tel:<?php echo esc_attr( $author_info['user_phone'] ); ?>">
												<i class="icon_mobile"></i><?php echo esc_html( $author_info['user_phone'] ); ?>
											</a>
										<?php } ?>

										<?php if( $author_info['user_email'] && $author_info['user_phone'] && apply_filters( 'el_show_phone_info', true ) && apply_filters( 'el_show_mail_info', true ) ){ ?>	
											<span class="slack">/</span> 
										<?php } ?>

										<?php if( $author_info['user_email'] && apply_filters( 'el_show_mail_info', true ) ){ ?>	
											<a class="email" href="mailto:<?php echo esc_attr( $author_info['user_email'] ); ?>"> 
												<i class="icon_mail_alt"></i><?php esc_html_e( 'E-mail', 'eventlist' ); ?> 
											</a>
										<?php } ?>

									</div>
								</div>

					        </li>	
					        <?php
					    } ?>

				    </ul>

				<?php } else {

				    esc_html_e( 'No authors found', 'eventlist' );
				}

				$total = $user_query->get_total();

				if ( $total > 1 ) {
					echo pagination_vendor( CEIL( $total/apply_filters( 'number_authors_per_page', 18 ) ) );
				}

				wp_reset_postdata(); wp_reset_query();

			?>

		</div> <!-- #main-content -->
		<?php get_sidebar(); ?>
	</div> <!-- .wrap_site -->

<?php

get_footer();

