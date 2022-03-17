<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php
global $event;
global $el_message_cart;
$id_event = (isset($_GET['ide'])) ? $_GET['ide'] : '';
$id_calendar = (isset($_GET['idcal'])) ? $_GET['idcal'] : '';

$list_type_ticket = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true);


$seat_option = get_seat_option( $id_event );
$data_settings = EL_Cart::instance()->get_setting_price();

$flag_sold_out = [];

$enable_tax = EL()->options->tax_fee->get('enable_tax');
$check_allow_change_tax = check_allow_change_tax_by_event($id_event);

$percent_tax = '';
if ( $check_allow_change_tax == "yes" ) {
	$percent_tax =get_post_meta( $id_event, OVA_METABOX_EVENT . 'event_tax', true );
}

if ( ! empty($percent_tax) || $percent_tax === '0' ) {
	$percent_tax = $percent_tax;
} else {
	$percent_tax = EL()->options->tax_fee->get('pecent_tax');
}

$percent_tax = ($enable_tax == 'yes') ? $percent_tax : 0;


?>

<?php if (!empty( $list_type_ticket ) && is_array($list_type_ticket) && $seat_option != 'map') : ?>
<?php if ($el_message_cart == "") : ?>
	<div class="cart-ticket-info" data-enable-tax="<?php echo esc_attr($enable_tax) ?>" data-percent-tax="<?php echo esc_attr($percent_tax) ?>" data-seat-option="<?php echo esc_attr($seat_option) ?>" data-id-cal="<?php echo esc_attr($id_calendar) ?>" data-id-event="<?php echo esc_attr($id_event) ?>" data-setting="<?php echo esc_attr($data_settings) ?>" >
		
		<div class="error-empty-cart">
			
			<span class="empty-item-cart">
				<?php esc_html_e("Please Select Your Ticket", "eventlist") ?>
			</span>

			<span class="error-empty">
				<?php esc_html_e("Please select seat", "eventlist") ?>
			</span>

			<span class="error-duplicate">
				<?php esc_html_e("Error seat duplicate", "eventlist") ?>
			</span>

		</div>
		
		<div class="item-ticket-type header">
			<div class="ticket-name">
				<p><?php esc_html_e("Ticket Type", "eventlist") ?></p>
			</div>
			<div class="price-ticket">
				<p><?php esc_html_e("Unit Price", "eventlist") ?></p>
			</div>
			<div class="quanty-ticket">
				<p><?php esc_html_e("Quantity", "eventlist") ?></p>
			</div>
		</div>

		<?php 
		$i = 0;
		foreach ( $list_type_ticket as $ticket ) : 
			
			$i++;
			
			$price_display = $price_calc = "";
			 
			$is_open = EL_Cart::instance()->is_booking_ticket_by_date_time($ticket['start_ticket_date'], $ticket['start_ticket_time'], $ticket['close_ticket_date'], $ticket['close_ticket_time']);

			if ( ! $is_open ) {
				continue;
			}

			$list_seat_rest = EL_Booking::instance()->get_list_seat_rest($id_event, $id_calendar, $ticket['ticket_id']);

			switch ( $ticket['type_price'] ) {
				case 'paid' : {
					$price_display = el_price( $ticket['price_ticket'] );
					$price_calc = $ticket['price_ticket'];
					break;
				}
				case 'free' : {
					$price_display = el_price( 0 );
					$price_calc = 0;
					break;
				}
			}
			?>
			<div class="item-ticket-type item-<?php echo esc_attr($ticket['ticket_id']) ?>" 
				data-setup_seat="<?php echo esc_attr($ticket['setup_seat']) ?>" 
				data-list-seat-rest="<?php echo esc_attr(json_encode($list_seat_rest)) ?>" 
				data-select-seat-text="<?php esc_html_e( 'Select seat', 'eventlist' ); ?>"
			>

				<div class="ticket-name">
					<p><?php echo esc_html( $ticket['name_ticket'] ) ?></p>
				</div>

				<div class="wp-select-seat">
					
				</div>

				<div class="price-ticket">
					<p><?php echo $price_display ?></p>
				</div>

				<div class="quanty-ticket">
					<?php
					$setting_min_num = (int)$ticket['number_min_ticket'];
					$setting_max_num = (int)$ticket['number_max_ticket'];
					$number_ticket_rest = EL_Booking::instance()->get_number_ticket_rest($id_event, $id_calendar,  $ticket['ticket_id']);

					$min_num = $setting_min_num;
					$max_num = min( $number_ticket_rest, $setting_max_num );

					if ($seat_option == 'simple') {
						$max_num = min( $setting_max_num, count($list_seat_rest) );
					}

					?>

					

					<span class="error error-min-num">
						<?php echo  esc_html__("Min number ticket is ", "eventlist") . $min_num ?>
					</span>

					<div class="control">

						<?php 
							$sold_out = true; 
							if ( $max_num > 0 && $min_num <= $max_num ) : 

								$flag_sold_out[] = "" ; 
								$sold_out = false; ;
						?>
						



						<span class="minus" data-min-num="<?php esc_attr_e($min_num) ?>" data-price="<?php echo esc_attr( $price_calc ) ?>" data-title="<?php echo esc_attr( $ticket['name_ticket'] ) ?>" data-id-ticket="<?php echo esc_attr($ticket['ticket_id']) ?>">
								<i class="fas fa-minus"></i>
						</span>

						<span class="qty qty-<?php echo esc_attr($ticket['ticket_id']) ?>">0</span>

						<span class="plus" data-mark="0" data-max-num="<?php echo esc_attr($max_num) ?>" data-price="<?php echo esc_attr( $price_calc ) ?>" data-title="<?php echo esc_attr( $ticket['name_ticket'] ) ?>" data-id-ticket="<?php echo esc_attr($ticket['ticket_id']) ?>">
							<i class="fas fa-plus"></i>
						</span>

						<?php else : ?>

							<?php $flag_sold_out[] = 'sold_out'; ?>

							<span class="sold-out"><?php esc_html_e("Sold out", "eventlist") ?></span>

						<?php endif ?>

					</div>

					<span class="error error-max-num">
						<?php echo  esc_html__("Max number ticket is ", "eventlist") . $max_num ?>
					</span>

					<?php if ( ! $sold_out ) : ?>
						<a id="btn-delete-item-cart" title="<?php esc_attr_e("Delete item to cart", "eventlist") ?>" data-min="<?php echo esc_attr($min_num) ?>" data-id="<?php echo esc_attr($ticket['ticket_id']) ?>" href="javascript: void(0)" class="btn-delete-item-cart">
							<i class="fas fa-times"></i>
						</a>
					<?php endif ?>
				</div>

			</div>
		<?php endforeach; ?>
		<?php 

		$number_item = count($flag_sold_out);
		$arr_value_count = array_count_values($flag_sold_out);
		$sold_out_all = 0;
		if ( isset($arr_value_count['sold_out']) && $number_item == $arr_value_count['sold_out']) {
			$sold_out_all = 1;
		}
		?>

	</div>
	<input type="hidden" name="sold_all" value="<?php echo esc_attr($sold_out_all) ?>">
<?php else : //if message ?>
	<p class="error-item"><?php echo esc_html($el_message_cart) ?></p>
<?php endif //if message ?>
<?php endif //if wrapper ?>


<!-- Display Ticket Map Type -->
<?php if( $seat_option === 'map' ){ 

	$ticket_map = get_post_meta( $id_event, OVA_METABOX_EVENT.'ticket_map', true ) ? get_post_meta( $id_event, OVA_METABOX_EVENT.'ticket_map', true ) : array();
	$max_ticket = $ticket_map['number_max_ticket'];
	$min_ticket = $ticket_map['number_min_ticket'];

	$list_seat_booked = array(); 
	?>
	
	<div class="seat-types">
		<?php 
		if ( isset( $ticket_map['desc_seat'] ) && $ticket_map['desc_seat'] ) {
			foreach ( $ticket_map['desc_seat'] as $value ) { 
				?>
				<div class="seat-type">
					<table class="w-100">
						<tbody class="w-100">
							<tr>
								<td width="30">
									<div style="background-color: <?php echo esc_attr( $value['map_color_type_seat'] ); ?>; border: 1px solid #aaa; width: 30px; height: 30px;" class="color"></div>
								</td>
								<td>
									<p class="name_type"><?php echo esc_html( $value['map_type_seat'] ); ?></p>
									<p class="price"><?php echo esc_html( el_price($value['map_price_type_seat']) ); ?></p>
								</td>
								<td width="30" >
									<div class="text-right">
										<i class="fas fa-info-circle"></i>
										<span class=""><?php echo esc_html( $value['map_desc_type_seat'] ); ?></span>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?php	
			}
		} 
		?>
	</div>

	<div class="cart-ticket-info event_ticket_map_type" data-enable-tax="<?php echo esc_attr($enable_tax) ?>" data-percent-tax="<?php echo esc_attr($percent_tax) ?>" data-seat-option="<?php echo esc_attr($seat_option) ?>" data-id-cal="<?php echo esc_attr($id_calendar) ?>" data-id-event="<?php echo esc_attr($id_event) ?>" data-setting="<?php echo esc_attr($data_settings) ?>" data-max_ticket="<?php echo esc_attr($max_ticket); ?>" data-min_ticket="<?php echo esc_attr($min_ticket); ?>" >
		<input type="hidden" name="sold_all" value="0">
		<div class="error-empty-cart">
			<span class="empty-item-cart"><?php esc_html_e("Please select seat", "eventlist") ?></span>
		</div>
		<div class="error-number-seat" style="display: none;">
			<span class="error error-max-num"><?php esc_html_e("Max number seat is ", "eventlist"); echo $max_ticket; ?></span>
			<span class="error error-min-num"><?php esc_html_e("Min number seat is ", "eventlist"); echo $min_ticket; ?></span>
		</div>
		<?php
		if ( $ticket_map['short_code_map'] ) {
			echo do_shortcode($ticket_map['short_code_map']);
		}
		$seat_booked = EL_Booking::instance()->get_list_seat_map_booked($id_event, $id_calendar);

		?>

		<div class="data-seat" data-seat="<?php echo esc_attr( wp_json_encode($ticket_map['seat']) ) ; ?>"></div>
		<div class="data-seat_booked" data-seat_booked="<?php echo esc_attr( wp_json_encode($seat_booked) ) ; ?>"></div>

		<!-- <?php esc_html_e( 'We are working this feature', 'eventlist' ); ?> -->

	</div>
	
<?php } ?>
