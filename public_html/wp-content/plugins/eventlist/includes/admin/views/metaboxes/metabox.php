<?php if( !defined( 'ABSPATH' ) ) exit(); ?>

<div class="row">

	<div id="tabs">

		<ul>
			<li><a href="#mb_basic" class="active"><?php esc_html_e( 'Basic', 'eventlist' ); ?> </a></li>
			<li><a href="#mb_gallery" class=""><?php esc_html_e( 'Gallery & Video', 'eventlist' ); ?></a></li>

			<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
				<li><a href="#mb_ticket" class=""><?php esc_html_e( 'Ticket', 'eventlist' ); ?></a></li>
			<?php	} ?>

			<li><a href="#mb_calendar" class=""><?php esc_html_e( 'Calendar', 'eventlist' ); ?></a></li>
			
			<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
				<li><a href="#mb_coupon" class=""><?php esc_html_e( 'Coupon', 'eventlist' ); ?></a></li>
			<?php	} ?>

			<li><a href="#mb_api_key" class=""><?php esc_html_e( 'Staff Member', 'eventlist' ); ?></a></li>
			
			<?php if ( EL()->options->cancel->get('cancel_enable', 1) ) { ?>
				<li><a href="#mb_cancel_booking" class=""><?php esc_html_e( 'Cancel Booking', 'eventlist' ); ?></a></li>
			<?php } ?>

		</ul>

		<!-- Basic -->  
		<div id="mb_basic">
			<?php require_once( EL_PLUGIN_PATH.'/includes/admin/views/metaboxes/_basic.php' ); ?>
		</div>


		<!-- Gallery -->  
		<div id="mb_gallery">
			<?php require_once( EL_PLUGIN_PATH.'/includes/admin/views/metaboxes/_gallery.php' ); ?>
		</div>


		<!-- Ticket -->  
		<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
			<div id="mb_ticket">
				<?php require_once( EL_PLUGIN_PATH.'/includes/admin/views/metaboxes/_ticket.php' ); ?>
			</div>
		<?php	} ?>


		<!-- Calendar  -->  
		<div id="mb_calendar">
			<?php require_once( EL_PLUGIN_PATH.'/includes/admin/views/metaboxes/_calendar.php' ); ?>
		</div>


		<!-- Coupon  -->  
		<?php if ( EL()->options->general->get('allow_to_selling_ticket', 'yes') == 'yes' ) { ?>
			<div id="mb_coupon">
				<?php require_once( EL_PLUGIN_PATH.'/includes/admin/views/metaboxes/_coupon.php' ); ?>
			</div>
		<?php	} ?>


		<!-- Coupon  -->  
		<div id="mb_api_key">
			<?php require_once( EL_PLUGIN_PATH.'/includes/admin/views/metaboxes/_api_key.php' ); ?>
		</div>
	
		<?php if ( EL()->options->cancel->get('cancel_enable', 1) ) { ?>
			<div id="mb_cancel_booking">
				<?php require_once( EL_PLUGIN_PATH.'/includes/admin/views/metaboxes/_cancel.php' ); ?>
			</div>
		<?php } ?>

	</div>

	<br/> 
</div>

<?php wp_nonce_field( 'ova_metaboxes', 'ova_metaboxes' ); ?>
