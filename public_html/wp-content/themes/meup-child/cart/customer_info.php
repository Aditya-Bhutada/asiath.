<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<div class="cart-customer-infor">
	<h3 class="cart_title"> <?php esc_html_e( 'Ticket Receiver', 'eventlist' ); ?> </h3>

	<?php 
	$fullname = $email = $phone = '';
	if( is_user_logged_in() ) {
		if( !wp_get_current_user()->first_name && !wp_get_current_user()->last_name ){
			$fullname = wp_get_current_user()->nickname;
		}
		$email = wp_get_current_user()->user_email;
		
	}
	?>

	<ul class="info_ticket_receiver">
		<li>
			<div class="label">
				<i class="fas fa-user"></i>
				<?php esc_html_e( 'Full Name','eventlist' ); ?>
			</div>
			<div class="span fullname">
				<?php echo esc_html($fullname); ?>
			</div>
		</li>

		<li>
			<div class="label">
				<i class="far fa-envelope"></i>
				<?php esc_html_e( 'Email','eventlist' ); ?>
			</div>
			<div class="span email">
				<?php echo esc_html($email); ?>
			</div>
		</li>

		<li>
			<div class="label">
				<i class="fas fa-phone-volume"></i>
				<?php esc_html_e( 'Phone','eventlist' ); ?>
			</div>
			<div class="span phone">
				
			</div>
		</li>

		<li>
			<div class="label">
				<i class="fas fa-map-marker-alt"></i>
				<?php esc_html_e( 'Address','eventlist' ); ?>
			</div>
			
			<input type="hidden" name="address_required" value="<?php echo apply_filters( 'el_checkout_required_address', 'false' ); ?>" class="address_required">
			<input type="hidden" name="phone_required" value="<?php echo apply_filters( 'el_checkout_required_phone', 'false' ); ?>" class="phone_required">
			

			<div class="span address">
				
			</div>
		</li>


		<?php
			$id_event = (isset($_GET['ide'])) ? $_GET['ide'] : '';
			$list_ckf_output = get_option( 'ova_booking_form', array() );

			$list_key_checkout_field = [];

			if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {

				foreach( $list_ckf_output as $key => $field ) {

					if( array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' ) {

						$list_key_checkout_field[] = $key;

						if( array_key_exists('required', $field) &&  $field['required'] == 'on' ) {
							$class_required = 'required';
						} else {
							$class_required = '';
						}

				?>

					
					<li>
						<div class="label">
							<i class="fas fa-plus"></i>
							<?php echo esc_html( $field['label'] ); ?>
						</div>

						<div class="span <?php echo esc_attr( $key ) ?>">
							<?php echo esc_html( $field['default'] ); ?>
						</div>





					</li>
				<?php
					}//endif
				}//end foreach
			}//end if

		?>
		
	</ul>
</div>


