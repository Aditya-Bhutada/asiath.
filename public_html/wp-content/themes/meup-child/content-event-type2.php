<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<li class="event_entry ">
	<div class="event_item type2">
		
		<div class="event_thumbnail">
			<?php 
				/**
				 * Display thumbnail
				 * Hook: el_loop_event_thumbnail
				 * @hookeds: el_loop_event_thumbnail - 10
				 */
				do_action( 'el_loop_event_thumbnail' );

				/**
				 * Display image author
				 * Hook: el_loop_event_author
				 * @hookeds: el_loop_event_author
				 */
				do_action( 'el_loop_event_author' );


				/**
				 * Display favourite
				 * Hook: el_loop_event_favourite
				 * @hookeds: el_loop_event_favourite
				 */
				do_action( 'el_loop_event_favourite' );

			 ?>
		</div>

		<div class="event_detail">
			<div class="event-meta">
				<?php
				/**
				 * Display Category
				 * Hook: el_loop_event_cat
				 * @hooked: el_loop_event_cat
				 */
				do_action( 'el_loop_event_cat' );

				/**
				 * Display Price
				 * Hook: el_loop_event_price
				 * @hooked: el_loop_event_price
				 */
				do_action( 'el_loop_event_price' );
				?>
			</div>
			
			<?php 

				/**
				 * Display Title
				 * Hook: el_loop_event_title
				 * @hooked: el_loop_event_title
				 */
				do_action( 'el_loop_event_title' );

				?>

				<?php
				/**
				 * Display excerpt
				 * Hook: el_loop_event_excerpt
				 */
				do_action( 'el_loop_event_excerpt' );

			 ?>

			 <div class="event-location-time">
			 	
				<?php
				/**
				 * Display location event
				 * Hook: el_loop_event_location
				 * @Hooked: el_loop_event_location
				 */
				do_action( 'el_loop_event_location' );

				/**
				 * Display time event
				 * Hook: el_loop_event_time
				 * @Hooked: el_loop_event_time
				 */
				do_action( 'el_loop_event_time' );

				?>

			 </div>

			 <div class="meta-footer">
			 	
			 	<?php


			 	/**
				 * Display Ratting
				 * Hook: el_loop_event_ratting
				 * @hooked: el_loop_event_ratting
				 */
				do_action( 'el_loop_event_ratting' );

			 	
			 	/**
			 	 * Display button readmore event
			 	 * Hook: el_loop_event_buttun
			 	 * @Hooked: el_loop_event_button
			 	 */
			 	do_action( 'el_loop_event_button' );

			 	
			 	?>

			 </div>

		</div>

	</div>
	
</li>



