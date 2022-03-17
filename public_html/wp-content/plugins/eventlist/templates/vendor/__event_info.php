<?php if ( !defined( 'ABSPATH' ) ) exit(); ?>
<?php 
$eid = isset( $_GET['eid'] ) ? (int)$_GET['eid'] : '';

if( $eid ){
	$post = get_post( $eid );
	$_prefix = OVA_METABOX_EVENT;
	$venue = get_post_meta( $eid, $_prefix.'venue', true );
	if( is_array( $venue ) ) $venue = implode( ',', $venue );

	$start_date = get_post_meta( $eid, $_prefix.'start_date_str', true ) ? date( get_option( 'date_format' ), get_post_meta( $eid, $_prefix.'start_date_str', true ) ) : '';
	
	$start_time = get_post_meta( $eid, $_prefix.'start_date_str', true ) ? date( get_option( 'time_format' ), get_post_meta( $eid, $_prefix.'start_date_str', true ) ) : '';

	$end_date = get_post_meta( $eid, $_prefix.'end_date_str', true ) ? date( get_option( 'date_format') , get_post_meta( $eid, $_prefix.'end_date_str', true ) ) : '';
	
	$end_time = get_post_meta( $eid, $_prefix.'end_date_str', true ) ? date( get_option( 'time_format' ), get_post_meta( $eid, $_prefix.'end_date_str', true ) ) : '';
	
	$address = get_post_meta( $eid, $_prefix.'address', true ) ? get_post_meta( $eid, $_prefix.'address', true ) : '';
	?>

	<div class="event_info">
		
		<h3 class="event_title">
			<?php echo $post->post_title; ?>
			<span class="status">
				<?php
				$status_event = get_status_event_without_loop($eid);
				echo $status_event;
				?>
			</span>
		</h3>

		<ul class="meta_event">

			<li class="date">
				<i class="icon_calendar"></i>
				<?php 
				EL_Vendor::instance()->display_date_event( $start_date, $start_time, $end_date, $end_time );
				?>
			</li>

			<?php if( $venue ){ ?>
				<li class="venue">
					<i class="icon_pin_alt"></i>
					<?php echo $venue; ?>
				</li>
			<?php } ?>

			<?php if( $address ){ ?>
				<li>
					<i class="icon_building"></i>
					<?php echo $address; ?>
				</li>
			<?php } ?>
			
			<li class="package">
				<i class="icon_gift"></i>
				
				<?php $package = EL_Package::instance()->get_package( get_post_meta( $eid, $_prefix.'package', true ) ); 
				echo $package['title'].' '.esc_html__( 'Package', 'eventlist' );
				?>
			</li>

			<li>
				<i class="icon_currency_alt"></i>
				<?php esc_html_e( 'Payouts','eventlist' ); ?>

				<?php $status_pay = get_post_meta( $eid, OVA_METABOX_EVENT.'status_pay', true ); 
				if( $status_pay == 'paid' ){ ?>
					<span class="status "><span class="status closed"><?php esc_html_e( 'Paid','eventlist' ); ?></span>
					<?php $date_update = get_post_meta( $eid, OVA_METABOX_EVENT.'date_update', true  ); ?>
					<span class="date"><?php echo $date_update ? date( get_option( 'date_format' ), $date_update ) : ''; ?></span></span>
				<?php }else{ ?>
					<span class="status"><span class="status upcomming"><?php esc_html_e( 'Pending','eventlist' ); ?></span></span>
				<?php }
				?>
				
			</li>

		</ul>
		
		
	</div>

<?php } ?>
