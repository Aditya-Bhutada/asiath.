<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php
	

	$el_get_event_type = el_get_event_type();

	if( $el_get_event_type == 'online' ){ ?>

		<div class="event_location">
			<span class="event-icon"><i class="icon_pin_alt"></i></span>
			<?php esc_html_e( 'Online', 'eventlist' ); ?>
		</div>

	<?php } else{

		$location = get_the_terms( get_the_id(), 'event_loc' );
		$link = $name = "";
		$count_loc = 0;
		if (is_array($location)) {
			$count_loc = count( $location );
	?>

			<div class="event_location">
				<?php
				
				if ( !empty( $location ) && is_array( $location ) ) {

					$i = 0; $separator = ",";
					?>
					
					<span class="event-icon"><i class="icon_pin_alt"></i></span>

					<?php
						foreach ($location as $loc) {
							$i++;
							$separator = ( $count_loc !== $i ) ? "," : "";
							$link = get_term_link($loc->term_id);
							$name = $loc->name;
							?>
							<a href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( $name ) ?></a><span class="separator"><?php echo esc_html( $separator ) ?></span>
							<?php
						}
				}

				?>
			</div>
	<?php } } ?>

	