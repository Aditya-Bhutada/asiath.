<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php
global $event;
$embed = $event->get_video_single_event();
?>
<?php if ( ! empty ( $embed ) ) : ?>
	<div class="event-video event_section_white">
		<h3 class="second_font heading"><?php esc_html_e("Video", "eventlist") ?></h3>
		<div id="video-event-single"><?php echo $embed ?></div>
	</div>
<?php endif ?>