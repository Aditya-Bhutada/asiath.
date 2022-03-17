<?php if( ! defined( 'ABSPATH' ) ) exit();

// List All Payment Gateways Actived
$payments = el_payment_gateways_active();
if( $payments ){ ?>
	
	<?php do_action( 'el_before_payments_checkout' ); ?>
	<div class="el_payments">
		<h3 class="cart_title"> <?php esc_html_e( 'Payment Method', 'eventlist' ); ?> </h3>
		<div class="error-empty-input error-payment">
			<span ><?php esc_html_e("field is required ", "eventlist") ?></span>
		</div>
		<ul>
			<?php 
			$i = 0;
			$checked = "";
			foreach ($payments as $key => $payment) { 
				$i++;
				$checked = ($i == 1) ? "checked" : "";

				?>
				<li class="<?php echo esc_attr($payment->id) ?>">
					<div class="type-payment">
						<input class="circle-<?php echo esc_attr($i) ?>" id="payment-<?php echo esc_attr($i) ?>" type="radio" name="payment" value="<?php echo esc_attr( $payment->id ); ?>" <?php echo esc_attr($checked) ?> />
						<label for="payment-<?php echo esc_attr($i) ?>"><?php echo esc_html( $payment->get_title() ); ?></label>
						<div class="outer-circle"></div>
					</div>

					<div class="payment_form">
						<?php echo $payment->render_form(); ?>	
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php do_action( 'el_before_payments_checkout' ); ?>
<?php }


