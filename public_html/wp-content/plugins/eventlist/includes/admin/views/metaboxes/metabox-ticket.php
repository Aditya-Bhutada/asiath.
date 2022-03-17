<?php if ( !defined( 'ABSPATH' ) ) exit();

global $post;
 

?>
<div class="el_ticket_detail">
	<div class="ova_row">
		<label>

			<div class="ova_row">
				<label>
					<strong><?php esc_html_e( "Ticket Number",  "eventlist" ); ?>: </strong>
					#<?php echo $post->ID ?>
				</label>
				<br><br>
			</div>

		</label>
	</div>

	<div class="ova_row">
		<label>

			<div class="ova_row">
				<label>
					<strong><?php esc_html_e( "Booking ID",  "eventlist" ); ?>: </strong>
					#<?php echo $this->get_mb_value( 'booking_id' ); ?>
				</label>
				<br><br>
			</div>

		</label>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Ticket Type",  "eventlist" ); ?>: </strong>
			<?php echo get_the_title(); ?>
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Event Name",  "eventlist" ); ?>: </strong>
			<input type="text" value="<?php echo esc_attr($this->get_mb_value('name_event')); ?>" name="<?php echo esc_attr($this->get_mb_name('name_event')); ?>" />

		</label>
		<br><br>
	</div>


	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Customer Name",  "eventlist" ); ?>: </strong>
			<input type="text" value="<?php echo esc_attr($this->get_mb_value('name_customer')); ?>" name="<?php echo esc_attr($this->get_mb_name('name_customer')); ?>" />
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Seat",  "eventlist" ); ?>: </strong>
			<input type="text" value="<?php echo esc_attr($this->get_mb_value('seat')); ?>" name="<?php echo esc_attr($this->get_mb_name('seat')); ?>" />
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Venue",  "eventlist" ); ?>: </strong>
			<?php 
			$arr_venue = $this->get_mb_value( 'venue' ); 
			$venue = is_array( $arr_venue ) ? implode( ", ", $arr_venue ) : $arr_venue;
			?>
			<input type="text" value="<?php echo $venue ?>" name="<?php echo esc_attr($this->get_mb_name('venue')); ?>" />
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Address",  "eventlist" ); ?>: </strong>
			<input type="text" value="<?php echo esc_attr($this->get_mb_value('address')); ?>" name="<?php echo esc_attr($this->get_mb_name('address')); ?>" />
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Qr Code",  "eventlist" ); ?>: </strong>
			<?php echo $this->get_mb_value( 'qr_code' ); ?>
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Start Date",  "eventlist" ); ?>: </strong>
			<?php
			$start_date = $this->get_mb_value( 'date_start' ); 
			$date_format = get_option('date_format');	
			$time_format = get_option('time_format');
			if( $start_date ){
				echo date_i18n($date_format, $start_date) . ' - ' . date_i18n($time_format, $start_date);
			}
			?>
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "End Date",  "eventlist" ); ?>: </strong>
			<?php 
			$end_date = $this->get_mb_value( 'date_end' );
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
			if( $end_date ){
				echo date_i18n($date_format, $end_date) . ' - ' . date_i18n($time_format, $end_date);
			}
			?>
		</label>
		<br><br>
	</div>


</div>

<?php wp_nonce_field( 'ova_metaboxes', 'ova_metaboxes' ); ?>
