<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php
$id_event = (isset($_GET['ide'])) ? $_GET['ide'] : '';
$date = (isset($_GET['idcal'])) ? $_GET['idcal'] : '';

$venue_arr = get_post_meta($id_event, OVA_METABOX_EVENT . 'venue', true);
$venue = is_array($venue_arr) ? implode(", ", $venue_arr) : "";

$venue = !empty($venue) ? $venue . ' - ' : "";

$address = get_post_meta($id_event, OVA_METABOX_EVENT . 'address', true);

$option_calendar = get_post_meta($id_event, OVA_METABOX_EVENT . 'option_calendar', true);

$calendar = get_post_meta( $id_event, OVA_METABOX_EVENT . 'calendar', true);

if ($option_calendar == 'auto') {
	$start_time = get_post_meta($id_event, OVA_METABOX_EVENT.'calendar_recurrence_start_time', true);
	$end_time = get_post_meta($id_event, OVA_METABOX_EVENT.'calendar_recurrence_end_time', true);

} else {
	foreach ($calendar as $value) {
		if ($date == $value['calendar_id']) {
			$date = strtotime($value['date']);
			$end_date = isset($value['end_date']) ? strtotime($value['end_date']) : '';
			$start_time = $value['start_time'];
			$end_time = $value['end_time'];
		}
	}
}

$date_format = get_option('date_format');
$time_format = get_option('time_format');

?>

<div class="el_wrap_site cart-header">
	<h1 class="title-event"><a href="<?php the_permalink($id_event) ?>"><?php echo get_the_title($id_event) ?></a></h1>
	<?php if ( !empty($venue) || !empty($address) ) : ?>
	<p class="venue">
		<?php if( apply_filters( 'el_e_detail_show_venue', true ) ) echo esc_html($venue); ?>
		<?php if( apply_filters( 'el_e_detail_show_address', true ) ) echo esc_html($address) ?>
	</p>
<?php endif ?>

<?php if ( EL()->options->event->get('show_hours_single', 'yes') == 'yes' ) { ?>
	<p class="date">
		<?php if ( isset($end_date) && ($date && $end_date && $date != $end_date) ) { 
			echo date_i18n('l', $date).', '.date_i18n($date_format, $date) . ' - ' . date_i18n('l', $end_date).', '.date_i18n($date_format, $end_date) ;
		} else {
			echo date_i18n('l', $date).', '.date_i18n($date_format, $date);
		} ?>
		@ 
		<?php echo esc_html($start_time); ?> - <?php echo esc_html($end_time); ?>
	</p>
<?php } else { ?>
	<p class="date"><?php echo date_i18n('l', $date).', '.date_i18n($date_format, $date); ?></p>
<?php } ?>
</div>

