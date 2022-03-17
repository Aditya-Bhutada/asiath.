<?php 
if ( !defined( 'ABSPATH' ) ) exit();

$post_id = isset( $_GET['id'] ) ? (int)$_GET['id'] : '';

?>


<div class="vendor_wrap">

	<div class="sidebar">
		<?php echo el_get_template( 'vendor/sidebar.php' ); ?>
	</div>

	<div class="contents">

		<?php echo el_get_template( '/vendor/heading.php' ); ?>

		<?php if( $post_id ){ ?>
			<a target="_blank" href="<?php echo get_preview_post_link( $post_id ); ?>">
				<?php esc_html_e( 'Preview Event','eventlist' ); ?>
			</a>
			<br><br>
		<?php } ?>

		<div class="vendor_edit_event">

			<?php if( $post_id ){
				$action_event = el_can_edit_event();
			}else{
				$action_event = el_can_add_event();
			}?>
			<?php if( $action_event ) : ?>


				<form action="<?php echo esc_url( home_url('/') ); ?>" method="post" enctype="multipart/form-data" class="content" autocomplete="nope" autocorrect="off" autocapitalize="none">
					<input type="hidden" value="<?php echo esc_attr( $post_id ); ?>" id="el_post_id" name="el_post_id"/>

					<ul class="vendor_tab">
						
						<li><a href="#mb_basic"><?php esc_html_e( 'Basic', 'eventlist' ); ?></a></li>

						<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
							<li><a href="#mb_ticket"><?php esc_html_e( 'Ticket', 'eventlist' ); ?></a></li>
						<?php	} ?>

						<?php if( apply_filters( 'el_create_event_show_calendar_tab', true ) ){ ?>
							<li><a href="#mb_calendar"><?php esc_html_e( 'Calendar', 'eventlist' ); ?></a></li>
						<?php } ?>
						
						<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
							<li><a href="#mb_coupon"><?php esc_html_e( 'Coupon', 'eventlist' ); ?></a></li>
						<?php } ?>
						
						<?php if( apply_filters( 'el_create_event_show_member_tab', true ) ){ ?>
							<li><a href="#mb_api_key"><?php esc_html_e( 'Staff Member', 'eventlist' ); ?></a></li>
						<?php } ?>

						<?php if ( EL()->options->cancel->get('cancel_enable', 1 ) ) { ?>
							<li><a href="#mb_cancel_booking"><?php esc_html_e( 'Cancel booking', 'eventlist' ); ?></a></li>
						<?php } ?>

					</ul>

					<div id="mb_basic">
						<?php echo el_get_template( '/vendor/__edit-event-basic.php' ); ?>
					</div>


					<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
						<div id="mb_ticket">
							<?php echo el_get_template( '/vendor/__edit-event-ticket.php' ); ?>
						</div>
					<?php	} ?>

					<?php if( apply_filters( 'el_create_event_show_calendar_tab', true ) ){ ?>
						<div id="mb_calendar">
							<?php echo el_get_template( '/vendor/__edit-event-calendar.php' ); ?>
						</div>
					<?php } ?>

					<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
						<div id="mb_coupon">
							<?php echo el_get_template( '/vendor/__edit-event-coupon.php' ); ?>
						</div>
					<?php	} ?>
					
					<?php if( apply_filters( 'el_create_event_show_member_tab', true ) ){ ?>
						<div id="mb_api_key">
							<?php  echo el_get_template( '/vendor/__edit-event-api-key.php' ); ?>
						</div>
					<?php } ?>

					<?php if ( EL()->options->cancel->get('cancel_enable', 1) ) { ?>
						<div id="mb_cancel_booking">
							<?php  echo el_get_template( '/vendor/__edit-event-cancel-booking.php' ); ?>
						</div>
					<?php } ?>


					<div class="wrap_btn_submit">
						<input class="el_edit_event_submit el_btn_add" name="el_edit_event_submit" type="submit" value="<?php esc_html_e( 'Save Event', 'eventlist' ); ?>" />
						<?php wp_nonce_field( 'el_edit_event_nonce', 'el_edit_event_nonce' ); ?>
						<div class="submit-load-more sendmail">
							<div class="load-more">
								<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
							</div>
						</div>
					</div>

					<p class="error-total-event"><?php echo esc_html_e('You should upgrade to high package because your current package is limit number events', 'eventlist') ?></p>
					<p class="error-time-limit"><?php echo esc_html_e('Your package time is expired', 'eventlist') ?></p>
				</form>

			<?php else: 
				esc_html_e( 'You don\'t have permission add new event', 'eventlist' );
			endif; ?>

		</div>

	</div>

</div>