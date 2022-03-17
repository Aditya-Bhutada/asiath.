<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<div class="cart-customer-input">
	<h3 class="cart_title"> <?php esc_html_e( 'Ticket Receiver', 'eventlist' ); ?> </h3>

	<?php 

	$fullname = $email = $user_phone = $user_address = '';

	if( is_user_logged_in() ) {
		$user_id = wp_get_current_user()->ID;
		$fullname = get_user_meta( $user_id, 'display_name', true ) ? get_user_meta( $user_id, 'display_name', true ) : get_the_author_meta('display_name', $user_id);
		$email = wp_get_current_user()->user_email;

		$user_phone      = get_user_meta( $user_id, 'user_phone', true ) ? get_user_meta( $user_id, 'user_phone', true ) : '';
		$user_address    = get_user_meta( $user_id, 'user_address', true ) ? get_user_meta( $user_id, 'user_address', true ) : '';
		
	}

	?>

	<ul class="input_ticket_receiver">
		<div class="error-empty-input error-fullname">
			<span ><?php esc_html_e("field is required ", "eventlist") ?></span>
		</div>
		<li class="fullname">
			<div class="label">
				<label for="fullname"><?php esc_html_e( 'Full Name','eventlist' ); ?></label>
			</div>
			<div class="span fullname">
				<input id="fullname" type="text" name="ticket_receiver_fullname" value="<?php echo esc_attr($fullname); ?>">
			</div>
		</li>

		<div class="error-empty-input error-email">
			<span ><?php esc_html_e("field is required ", "eventlist") ?></span>
		</div>
		<li>
			<div class="label">
				<label for="email"><?php esc_html_e( 'Email','eventlist' ); ?></label>
			</div>
			<div class="span email">
				<input id="email" type="email" name="ticket_receiver_email" value="<?php echo esc_attr($email) ?>">
			</div>
		</li>

		<div class="error-empty-input error-email-confirm-require">
			<span ><?php esc_html_e("field is required ", "eventlist") ?></span>
		</div>
		<div class="error-empty-input error-email-confirm-not-match">
			<span ><?php esc_html_e("The email doesn't match ", "eventlist") ?></span>
		</div>

		<li>
			<div class="label">
				<label for="email"><?php esc_html_e( 'Confirm Email','eventlist' ); ?></label>
			</div>
			<div class="span email">
				<input id="email_confirm" type="email" name="ticket_receiver_email_confirm" value="<?php echo esc_attr($email) ?>">
			</div>
		</li>
		
		<div class="error-empty-input error-phone">
			<span ><?php esc_html_e("field is required ", "eventlist") ?></span>
		</div>
		<li>
			<div class="label">
				<label for="phone"><?php esc_html_e( 'Phone','eventlist' ); ?></label>
			</div>
			<div class="span phone">
				<input id="phone" type="text" name="ticket_receiver_phone" value="<?php echo esc_attr($user_phone) ?>">
			</div>
		</li>
		
		<div class="error-empty-input error-address">
			<span ><?php esc_html_e("field is required ", "eventlist") ?></span>
		</div>
		<li>
			<div class="label">
				<label for="address"><?php esc_html_e( 'Address','eventlist' ); ?></label>
			</div>
			<div class="span address">
				<input id="address" type="text" name="ticket_receiver_address" value="<?php echo esc_attr($user_address) ?>">
			</div>
		</li>

		<?php
			$id_event = (isset($_GET['ide'])) ? $_GET['ide'] : '';
			$list_ckf_output = get_option( 'ova_booking_form', array() );

			$k = 0;
			foreach( $list_ckf_output as $key => $field ) {
				if( array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' ) {
					$k++;
				}
			}


			$list_key_checkout_field = [];
			$i = 0;
			if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {

				foreach( $list_ckf_output as $key => $field ) {
					$i++;
					if( array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' ) {

						$list_key_checkout_field[] = $key;

						if( array_key_exists('required', $field) &&  $field['required'] == 'on' ) {
							$class_required = 'required';
						} else {
							$class_required = '';
						}

						$class_last = ( $i == $k ) ? 'ova-last' : '';

				?>

					<div class="error-empty-input error-<?php echo esc_attr( $key ) ?>">
						<span ><?php esc_html_e("field is required ", "eventlist") ?></span>
					</div>
					<li class="rental_item <?php echo esc_attr( $class_last ) ?>">


						<div class="label">
							<label for="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $field['label'] ); ?></label>
						</div>

						<?php if( $field['type'] !== 'textarea' && $field['type'] !== 'select' ) { ?>
							<input id="<?php echo esc_attr( $key ) ?>" type="<?php echo esc_attr( $field['type'] ) ?>" name="<?php echo esc_attr( $key ) ?>"  class="<?php echo esc_attr( $key ) ?> <?php echo esc_attr( $field['class'] ) . ' ' . $class_required ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"   value="<?php echo $field['default']; ?>"  />
						<?php } ?>

						<?php if( $field['type'] === 'textarea' ) { ?>
							<textarea  id="<?php echo esc_attr( $key ) ?>" name="<?php echo esc_attr( $key ) ?>"  class=" <?php echo esc_attr( $key ) ?> <?php echo esc_attr( $field['class'] ) . ' ' . $class_required ?>" placeholder="<?php echo esc_attr( $field['placeholder'] ); ?>"   value="<?php echo $field['default']; ?>" cols="10" rows="5"></textarea>
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
									foreach( $ova_options_text as $key => $value ) { 
										$selected = '';
										if( $ova_options_key[$key] == $field['default'] ) {
											$selected = 'selected';
										}
										?>
										<option <?php echo  $selected ?> value="<?php echo esc_attr( $ova_options_key[$key] ) ?>"><?php echo esc_html( $value ) ?></option>
								<?php 

									} //end foreach
								}//end if
							?>
								
							</select>
						<?php } ?>

					</li>
				<?php
					}//endif
				}//end foreach
			}//end if

		?>
		<input type="hidden" id="el_list_key_checkout_field" value="<?php echo esc_attr( json_encode( $list_key_checkout_field ) ) ?>" >

	</ul>
</div>

