<?php if( ! defined( 'ABSPATH' ) ) exit();
get_header();

$ticket_info = EL_Ticket::validate_qrcode( $_REQUEST ); 


?>
<div class="ticket_info">
	<div class="container">

		<div class="message">
			<h3 class="<?php echo $ticket_info['status']; ?>">

				<?php echo $ticket_info['msg']; ?>

				<?php if( $ticket_info['status'] == 'checked-in' ){ ?>
						<?php echo ' '.esc_html_e( 'at', 'eventlist' ).' '.$ticket_info['checkin_time']; ?>
				<?php } ?>
			</h3>
		</div>
		
		

		<!-- if the qrcode is valid -->
		<?php 
			if( $ticket_info['status'] == 'valid' || $ticket_info['status'] == 'checked-in' ){ ?>

				<div class="info">
					<ul>
						
						<li>
							<label>
								<?php esc_html_e( 'Customer', 'eventlist' ); ?>
							</label>
							<div class="value">
								<?php echo $ticket_info['name_customer']; ?>
							</div>
						</li>
						<li>
							<label>
								<?php esc_html_e( 'Event', 'eventlist' ); ?>
							</label>
							<div class="value">
								<?php echo $ticket_info['name_event']; ?>
							</div>
						</li>
						<li>
							<label>
								<?php esc_html_e( 'Date time', 'eventlist' ); ?>
							</label>
							<div class="value">
								<?php echo $ticket_info['e_cal']; ?>
							</div>
						</li>

						<?php if( $ticket_info['seat'] ){ ?>
							<li>
							<label>
								<?php esc_html_e( 'Seat', 'eventlist' ); ?>
							</label>
							<div class="value">
								<?php echo $ticket_info['seat']; ?>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div>
				
			<?php }
		 ?>

	</div>
</div>
<?php get_footer();