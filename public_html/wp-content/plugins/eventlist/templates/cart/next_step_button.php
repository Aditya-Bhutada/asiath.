<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php
	global $el_message_cart;

	$myaccount_page = get_myaccount_page();
?>
<?php if ($el_message_cart == "") : ?>
<div class="next_step_button">
	<input type="hidden" name="el_next_event_nonce" id="el_next_event_nonce" value="<?php echo wp_create_nonce( 'el_next_event_nonce' ); ?>">
	<input type="hidden" name="el_next_myaccount_page" id="el_next_myaccount_page" value="<?php echo esc_url( $myaccount_page ) ?>">
	<a id="cart-next-step" href="javascript:void(0)"><?php esc_html_e("Next", "eventlist") ?></a>
</div>
<?php endif ?>