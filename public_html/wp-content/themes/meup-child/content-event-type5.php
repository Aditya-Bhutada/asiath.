<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<li class="event_entry">
	<div class="event_item type5">
		
		<div class="event_thumbnail">
			<?php 
				/**
				 * Display thumbnail
				 * Hook: el_loop_event_thumbnail
				 * @hookeds: el_loop_event_thumbnail - 10
				 */
				do_action( 'el_loop_event_thumbnail' );

				/**
				 * Display share
				 * Hook: el_loop_event_share
				 * @hookeds: el_loop_event_share
				 */
				// do_action( 'el_loop_event_share' );

				/**
				 * Display favourite
				 * Hook: el_loop_event_favourite
				 * @hookeds: el_loop_event_favourite
				 */
				// do_action( 'el_loop_event_favourite' );

			 ?>
		</div>

		<div class="event_detail">
			<?php 
			/**
			 * Display Title
			 * Hook: el_loop_event_title
			 * @hooked: el_loop_event_title
			 */
			do_action( 'el_loop_event_title' );

			?>
			<div class="el-wp-content">
				<div class="content-event">
					<div class="ova-price">
						<?php
					 	/**
						 * Display Price
						 * Hook: el_loop_event_price
						 * @hooked: el_loop_event_price
						 */
						do_action( 'el_loop_event_price' );
						?>
					</div>
					 <div class="event-location-time">
						<?php

						/**
						 * Display location event
						 * Hook: el_loop_event_location
						 * @Hooked: el_loop_event_location
						 */
						do_action( 'el_loop_event_location' );

						/**
						 * Display Category
						 * Hook: el_loop_event_cat
						 * @hooked: el_loop_event_cat
						 */
						do_action( 'el_loop_event_cat' );

						?>

					</div>
				</div>
				<div class="date-event">
					<?php 
					/**
					 * Display date
					 * Hook: el_loop_event_date
					 * @hooked: el_loop_event_date
					 */
					do_action( 'el_loop_event_date' );
					?>
				</div>
			</div>	

		</div>

	</div>
	
</li>



