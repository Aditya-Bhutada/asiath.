<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php
	$price = get_price_ticket_by_id_event( get_the_id() );
?>
<span class="event_loop_price second_font"><?php echo esc_html($price) ?></span>