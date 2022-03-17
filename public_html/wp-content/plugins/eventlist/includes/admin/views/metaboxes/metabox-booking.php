<?php if ( !defined( 'ABSPATH' ) ) exit();

global $post;

$id_booking = get_the_ID();

$id_event = $this->get_mb_value('id_event') ? $this->get_mb_value('id_event') : '';

$id_cal = $this->get_mb_value('id_cal') ? $this->get_mb_value('id_cal') : '';

$seat_option = get_post_meta( $id_event, OVA_METABOX_EVENT . 'seat_option', true ) ? get_post_meta( $id_event, OVA_METABOX_EVENT . 'seat_option', true ) : 'none';


$format = el_date_time_format_js();
$placeholder = date_i18n(el_date_time_format_js_reverse($format), '1577664000' );

// Get all events no pagination
$events = el_all_events();

$screen = get_current_screen();

?>
<div class="el_booking_detail">
	

	<div class="ova_row">
		<p class="success status"></p>
		<p class="error status"></p>
	</div>

	<div class="ova_row">
		

		<div class="ova_row">
			<label>
				<strong><?php esc_html_e( "Booking ID",  "eventlist" ); ?>: </strong>
				#<?php echo $post->ID ?>
			</label>
			<br><br>
		</div>

		<div class="ova_row">
			<label>
				<strong><?php esc_html_e( "Select Event *",  "eventlist" ); ?>: </strong>
				
				<select name="<?php echo $this->get_mb_name('id_event'); ?>" class="id_event">
					<option value="">-------------------</option>
					<?php foreach ($events as $key => $value) { ?>
						<option value="<?php echo $value->ID; ?>" <?php echo selected( $value->ID, $id_event ) ?> >
							<?php echo $value->post_title; ?>
						</option>
					<?php } ?>
				</select>

			</label>
			<br><br>
		</div>

		<div class="ova_row id_cal" data-id_cal="<?php echo $id_cal; ?>">
			<?php if( $post->ID ){ ?>
				<?php $list_calendar =  get_arr_list_calendar_by_id_event( $id_event ); ?>
				<label>
				<strong><?php esc_html_e( "Event Calendar *",  "eventlist" ); ?>: </strong>
					<select name="<?php echo OVA_METABOX_EVENT.'id_cal' ?>" >
						<?php foreach ($list_calendar as $key => $value) { ?>
							<option value="<?php echo $value['calendar_id']; ?>" <?php echo selected( $value['calendar_id'], $id_cal ) ?>>
								<?php echo date_i18n( get_option( 'date_format' ), strtotime($value['date']) ); ?>
							</option>
						<?php } ?>
					</select>
				</label>
				<br><br>
			<?php } ?>
		</div>

		
		<div class="ova_row" >
			<label for="">
				<strong><?php esc_html_e( "Status", "eventlist" ); ?>: </strong>
				<?php
				$status_booking = $this->get_mb_value( 'status');
				?>
				<select name="<?php echo esc_attr($this->get_mb_name( 'status' )) ?>">

					<option value="Completed" <?php selected( 'Completed', $status_booking, 'selected' ); ?> ><?php esc_html_e( 'Completed', 'eventlist' ); ?></option>

					<option value="Pending" <?php selected( 'Pending', $status_booking, 'selected' ); ?> ><?php esc_html_e( 'Pending', 'eventlist' ); ?></option>

					<option value="Canceled" <?php selected( 'Canceled', $status_booking, 'selected' ); ?> ><?php esc_html_e( 'Canceled', 'eventlist' ); ?></option>

				</select>
			</label>
			<br><br>
		</div>
		
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Name",  "eventlist" ); ?>: </strong>
			
			<input type="text" class="name" value="<?php echo esc_attr($this->get_mb_value('name')); ?>" placeholder="<?php esc_attr_e( 'Customer Name', 'eventlist' ); ?>"  name="<?php echo esc_attr($this->get_mb_name('name')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Phone", "eventlist" ); ?>: </strong>
			
			<input type="text" class="phone" value="<?php echo esc_attr($this->get_mb_value('phone')); ?>" placeholder="<?php esc_attr_e( '+1 234 567 99', 'eventlist' ); ?>"  name="<?php echo esc_attr($this->get_mb_name('phone')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
		</label>
		<br><br>
	</div>
	
	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Email *", "eventlist" ); ?>: </strong>
			
			<input type="text" class="email" value="<?php echo esc_attr($this->get_mb_value('email')); ?>" placeholder="<?php esc_attr_e( 'example@email.com', 'eventlist' ); ?>"  name="<?php echo esc_attr($this->get_mb_name('email')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
		</label>
		<br><br>
	</div>

	<div class="ova_row">
		<label>
			<strong><?php esc_html_e( "Address", "eventlist" ); ?>: </strong>
			
			<input type="text" class="address" value="<?php echo esc_attr($this->get_mb_value('address')); ?>" placeholder="<?php esc_attr_e( 'New York, NY, USA', 'eventlist' ); ?>"  name="<?php echo esc_attr($this->get_mb_name('address')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
		</label>
		<br><br>
	</div>
	


	<?php
		$id_booking = $post->ID;
		$list_ckf_output = get_option( 'ova_booking_form', array() );
		$data_checkout_field = $this->get_mb_value( 'data_checkout_field' );


		if( $screen->action == 'add' ) {
			$data_checkout_field = [];
			foreach( $list_ckf_output as $key_1 => $val ) {
				if( array_key_exists('enabled', $val) &&  $val['enabled'] == 'on' ) {
					$data_checkout_field[$key_1] = $val['default'];
				}
				
			}
		} else {
			$data_checkout_field = ! empty( $data_checkout_field ) ? json_decode( $data_checkout_field , true) : [];
		}


		$list_key_checkout_field = [];

		if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {

			foreach( $list_ckf_output as $key => $field ) {

				if( array_key_exists($key, $data_checkout_field)  && array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' ) {

					$list_key_checkout_field[] = $key;
					if( array_key_exists('required', $field) &&  $field['required'] == 'on' ) {
						$class_required = 'required';
					} else {
						$class_required = '';
					}

			?>

				
				<div class="ova_row">

					<label for="<?php echo esc_attr( $key ) ?>">
						<strong><?php echo esc_html( $field['label'] ); ?>: </strong>

					<?php if( $field['type'] !== 'textarea' && $field['type'] !== 'select' ) { ?>
						<input id="<?php echo esc_attr( $key ) ?>" type="text" name="<?php echo esc_attr( $key ) ?>"  class="<?php echo esc_attr( $key ) ?> <?php echo esc_attr( $field['class'] ) . ' ' . $class_required ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"   value="<?php echo esc_attr( $data_checkout_field[$key] ); ?>"  />
					<?php } ?>

					<?php if( $field['type'] === 'textarea' ) { ?>
						<textarea  id="<?php echo esc_attr( $key ) ?>" name="<?php echo esc_attr( $key ) ?>"  class=" <?php echo esc_attr( $key ) ?> <?php echo esc_attr( $field['class'] ) . ' ' . $class_required ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"   value="<?php echo $data_checkout_field[$key]; ?>" cols="50" rows="8"><?php echo esc_html( $data_checkout_field[$key] ) ?></textarea>
					<?php } ?>

					<?php if( $field['type'] === 'select' ) { 



						$ova_options_key = $ova_options_text = [];
						if( array_key_exists( 'ova_options_key', $field ) ) {
							$ova_options_key = $field['ova_options_key'];
						}

						if( array_key_exists( 'ova_options_text', $field ) ) {
							$ova_options_text = $field['ova_options_text'];
						}


						?>
						<select  id="<?php echo esc_attr( $key ) ?>" name="<?php echo esc_attr( $key ) ?>"  class=" ova_select <?php echo esc_attr( $key ) ?> <?php echo esc_attr( $field['class'] ) . ' ' . $class_required ?>" >
							<?php 

							if( ! empty( $ova_options_text ) && is_array( $ova_options_text ) ) { 
								foreach( $ova_options_text as $key_2 => $value ) { 
									$selected = '';
									if( $ova_options_key[$key_2] == $data_checkout_field[$key] ) {
										$selected = 'selected';
									}
									?>
									<option <?php echo  $selected ?> value="<?php echo esc_attr( $ova_options_key[$key_2] ) ?>"><?php echo esc_html( $value ) ?></option>
							<?php 

								} //end foreach
							}//end if
						?>
							
						</select>
					<?php } ?>
					</label>
					<br><br>

				</div>
			<?php
				}//endif
			}//end foreach
		}//end if



	?>
	<input type="hidden" id="el_meta_booking_list_key_checkout_field" value="<?php echo esc_attr( json_encode( $list_key_checkout_field ) ) ?>" >
	<input type="hidden" id="bk_data_checkout_field" name="<?php echo $this->get_mb_name( 'data_checkout_field' ) ?>" value="<?php echo esc_attr( json_encode($data_checkout_field) ) ?>">






	<?php if ($this->get_mb_value( 'title_event' ) == '' || !empty($this->get_mb_value('coupon')) ) { ?>
		<div class="ova_row">
			<label>
				<strong><?php esc_html_e( "Coupon", "eventlist" ); ?>: </strong>
				
				<input type="text" class="coupon" placeholder="<?php esc_html_e( 'code', 'eventlist' ) ?>" value="<?php echo esc_attr($this->get_mb_value('coupon')); ?>" name="<?php echo esc_attr($this->get_mb_name('coupon')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
			</label>
			<br><br>
		</div>
	<?php } ?>

	<div class="ova_row">
		<label>
			
			<strong><?php esc_html_e( "Payment Method", "eventlist" ); ?>: </strong>

			<?php if ($this->get_mb_value( 'title_event' )) { ?>

				<?php echo $this->get_mb_value( 'payment_method' ); ?>
				<input type="hidden" class="payment_method" value="<?php echo esc_attr($this->get_mb_value( 'payment_method' )); ?>" name="<?php echo esc_attr($this->get_mb_name('payment_method')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />

			<?php } else { ?>
				
				<?php esc_html_e('Manual', 'eventlist') ?>
				<input type="hidden" class="payment_method" value="<?php echo esc_attr('Manual'); ?>" name="<?php echo esc_attr($this->get_mb_name('payment_method')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />

			<?php } ?>

		</label>
		<br>
		<br>
	</div>

	<div class="ova_row">
		
		
		
		<strong><?php esc_html_e( "Cart",  "eventlist" ); ?>: </strong>
		<?php $cart = $this->get_mb_value( 'cart' ); ?>
		
		<input type="hidden" name="seat_option_type" value="<?php echo $seat_option; ?>" class="seat_option_type">
		<table class="cart">
			
			<thead>
				
				<?php if ( $seat_option == 'none' ) { ?>
					<tr class="seat_option_none">
						<th class="name"><?php esc_html_e( 'Ticket', 'eventlist' ); ?></th>
						<th class="qty"><?php esc_html_e( 'Quantity', 'eventlist' ); ?></th>
						<th class="sub-total"><?php esc_html_e( 'Sub Total', 'eventlist' ); ?></th>
					</tr>
				<?php } elseif ( $seat_option == 'simple' ) { ?>
					<tr class="seat_option_simple">
						<th class="name"><?php esc_html_e( 'Ticket', 'eventlist' ); ?></th>
						<th class="qty"><?php esc_html_e( 'Quantity', 'eventlist' ); ?></th>
						<th class="sub-total"><?php esc_html_e( 'Sub Total', 'eventlist' ); ?></th>
					</tr>
				<?php } else { ?>
					<tr class="seat_option_map">
						<th class="name"><?php esc_html_e( 'Seat Code', 'eventlist' ); ?></th>
						<th class="sub-total"><?php esc_html_e( 'Sub Total', 'eventlist' ); ?></th>
					</tr>
				<?php } ?>
				
			</thead>
			<tbody>
				<?php 

				if ( !empty($cart) && is_array($cart) ) {
					$total = 0; ?>

					<?php if ( $seat_option == 'none' ) {
						
						foreach ($cart as $key => $item) {
							$total += $item['qty'] * $item['price'];
							?>
							<tr class="cart-item seat_option_none">
								<td class="name">
									<a href="#" class="delete_item">x</a>

									<input type="text" class="name" value="<?php echo esc_attr($item['name']) ?>" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[name]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="<?php esc_html_e( 'ticket name', 'eventlist' ) ?> " />

								</td>
								<td class="qty">
									<input type="number" class="qty" value="<?php echo esc_attr($item['qty']) ?>" min="1" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[qty]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="1" />
								</td>
								<td class="sub-total">
									<input type="text" class="price" value="<?php echo esc_attr($item['qty'] * $item['price']) ?>" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[price]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="10.1"  />
								</td>
							</tr>
						<?php }

					} elseif ( $seat_option == 'simple' ) {
						foreach ($cart as $key => $item) {

							$total += $item['qty'] * $item['price'];

							if ( is_array($item['seat']) ) {
								$list_seat = implode(", ", $item['seat']);
							} else {
								$list_seat = $item['seat'];
							}

							?>
							<tr class="cart-item seat_option_none">
								<td class="name">
									<a href="#" class="delete_item">x</a>
									<input type="text" class="name" value="<?php echo esc_attr($item['name']) ?>" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[name]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder=" <?php esc_html_e( 'seat code', 'eventlist' ) ?> " />
								</td>

								<td class="qty">

									<input type="number" class="qty" value="<?php echo esc_attr($item['qty']) ?>" min="1" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[qty]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none"  placeholder="1"/>

									<input type="text" class="seat" value="<?php echo esc_attr($list_seat) ?>" placeholder="<?php esc_attr_e('A1, A2, A3, ...', 'eventlist') ?>" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[seat]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" required/>

								</td>

								<td class="sub-total">
									<input type="text" class="price" value="<?php echo esc_attr($item['price']) ?>" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[price]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="10.5" />
								</td>
							</tr>
						<?php }
					} else {
						foreach ($cart as $key => $item) {
							$total += $item['price'];
							?>
							<tr class="cart-item seat_option_map">
								<td class="name">
									<a href="#" class="delete_item">x</a>
									<input type="text" class="name" value="<?php echo esc_attr($item['id']) ?>" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[id]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
								</td>

								<td class="sub-total">
									<input type="text" class="price" value="<?php echo esc_attr($item['price']) ?>" name="<?php echo esc_attr($this->get_mb_name('cart').'['.$key.']'.'[price]'); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
								</td>
							</tr>
						<?php }
					}
				}
				?>

			</tbody>
			<tfoot>
				<tr class="cart-total">
					<th colspan="3" class="add_ticket"><a href="#"><?php esc_html_e('Add Item', 'eventlist'); ?></a></th>
				</tr>
				<tr class="cart-total">
					<th><?php esc_html_e('Total before tax', 'eventlist' ); ?></th>
					<td colspan="2" >
						<strong><?php echo el_price( $this->get_mb_value( 'total' ) ) ?></strong>
						<input type="text" class="total" value="<?php echo esc_attr( $this->get_mb_value( 'total' ) ); ?>" name="<?php echo esc_attr($this->get_mb_name('total')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="<?php esc_html_e( '10.5', 'eventlist' ); ?>" />
					</td>
				</tr>
				<tr class="cart-total">
					<th><?php esc_html_e('Total after tax', 'eventlist' ); ?></th>
					<td colspan="2" >
						<strong><?php echo el_price( $this->get_mb_value( 'total_after_tax' ) ) ?></strong>
						<input type="text" class="total_after_tax" value="<?php echo esc_attr( $this->get_mb_value( 'total_after_tax' ) ); ?>" name="<?php echo esc_attr($this->get_mb_name('total_after_tax')); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="<?php esc_html_e( '10.5', 'eventlist' ); ?>" />
					</td>
				</tr>
			</tfoot>
		</table>
		<br><br>
	</div>

	<div class="ova_row">
		<div class="wp-button">
			<button class="button create-ticket-send-mail" data-nonce="<?php echo wp_create_nonce( 'el_create_send_ticket_nonce' ); ?>" data-id-booking="<?php echo esc_attr($post->ID) ?>"><?php esc_html_e( "Create And Send Ticket", "eventlist" ); ?></button>
		</div>
		<br><br>
	</div>

</div>

<?php wp_nonce_field( 'ova_metaboxes', 'ova_metaboxes' ); ?>





