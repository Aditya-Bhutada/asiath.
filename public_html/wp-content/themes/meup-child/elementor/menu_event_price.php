<?php if( ! defined( 'ABSPATH' ) ) exit();

$format = $args['type_format'];

$price = get_price_ticket_by_id_event( get_the_id(), $format );

?>
<div class="el-menu-event-price">
	<span class="event_loop_price"><?php echo esc_html($price) ?></span>
</div>

