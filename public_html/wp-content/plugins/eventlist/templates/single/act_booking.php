<?php if( ! defined( 'ABSPATH' ) ) exit(); 

$id = get_the_ID();

$list_type_ticket = get_post_meta( $id, OVA_METABOX_EVENT . 'ticket', true);
$seat_option = get_post_meta( $id, OVA_METABOX_EVENT . 'seat_option', true);
$start_date_str = get_post_meta( $id, OVA_METABOX_EVENT . 'start_date_str', true);

$ticket_link = get_post_meta( $id, OVA_METABOX_EVENT . 'ticket_link', true);

if( $ticket_link == 'ticket_external_link' ){ ?>
	<?php $external_link = get_post_meta( $id, OVA_METABOX_EVENT . 'ticket_external_link', true); ?>
	<div class="act_booking">
		<a href="<?php echo esc_url($external_link); ?>" target="_blank" >
			<?php echo esc_html__( 'Booking Now', 'eventlist' ); ?>
		</a>
	</div>	

<?php }else if ( (! empty( $list_type_ticket )  && ! empty($start_date_str)) || ( $seat_option === 'map' ) ) { ?>

<div class="act_booking">
	<a href="javascrit: void(0)" id="event_booking_single_button">
		<?php echo esc_html__( 'Booking Now', 'eventlist' ); ?>
	</a>
</div>

<?php } ?>
