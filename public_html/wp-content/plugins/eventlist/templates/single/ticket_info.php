<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php
global $event;
$list_type_ticket = get_post_meta( get_the_ID(), OVA_METABOX_EVENT . 'ticket', true);


$seat_option = get_post_meta( get_the_ID(), OVA_METABOX_EVENT . 'seat_option', true);
$list_calendar_ticket = get_post_meta( get_the_ID(), OVA_METABOX_EVENT . 'calendar', true);
$option_calendar = get_post_meta( get_the_ID(), OVA_METABOX_EVENT . 'option_calendar', true);
$calendar_recurrence = get_post_meta( get_the_ID(), OVA_METABOX_EVENT . 'calendar_recurrence', true);

?>
<?php if (!empty( $list_type_ticket ) && is_array($list_type_ticket) && ((!empty($list_calendar_ticket) && $option_calendar == "manual") || (!empty($calendar_recurrence) && $option_calendar == "auto")) && $seat_option != 'map' ) : ?>
<div class="ticket-info event_section_white">
	<h3 class="heading second_font"><?php esc_html_e("Ticket Information", "eventlist") ?></h3>
	<?php 
	foreach ( $list_type_ticket as $ticket ) : 
		$html_price = "";
		if (is_array($ticket) && array_key_exists('type_price', $ticket)) {
			switch ( $ticket['type_price'] ) {
				case 'paid' : {
					$html_price = el_price($ticket['price_ticket']);
					$html_price = ( $ticket['price_ticket'] == 0 ) ? esc_html__( 'Free', 'eventlist' ) : $html_price;

					break;
				}
				case 'free' : {
					$html_price = esc_html__( 'Free', 'eventlist' );
					break;
				}
				
				
			}
		}
		$data_empty_desc = empty($ticket['desc_ticket']) ? 'true' : 'false';
		$class_empty = empty($ticket['desc_ticket']) ? 'empty-desc' : '';
		?>
		<div class="item-info-ticket">
			<div class="heading-ticket <?php echo esc_attr($class_empty) ?>" data-desc="<?php echo esc_attr($data_empty_desc) ?>" >
				<p class="title-ticket"><i class="arrow_carrot-down"></i><?php echo esc_html( $ticket['name_ticket'] ) ?></p>
				<div class="wp-price-status">
					<p class="price"><?php echo $html_price ?></p>
					<span class="stattus">
						<?php echo esc_html($event->get_status_ticket_info_by_date_and_time( $ticket['start_ticket_date'], $ticket['start_ticket_time'], $ticket['close_ticket_date'], $ticket['close_ticket_time'] )) ?>
					</span>
				</div>
			</div>
			<div class="desc-ticket" >
				<div class="desc">
					<p><?php echo esc_html( $ticket['desc_ticket'] ) ?></p>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<?php endif ?>