<?php if( ! defined( 'ABSPATH' ) ) exit(); 

$id = get_the_ID();
$url = get_permalink($id);
$author_id = get_the_author_meta('ID');

$no_img_tmb = apply_filters( 'el_img_no_tmb', EL_PLUGIN_URI.'assets/img/no_tmb_square.png' );

if( has_post_thumbnail() && get_the_post_thumbnail() ){
	$image = has_image_size( 'el_img_squa' ) ?  get_the_post_thumbnail_url( $id, 'el_img_squa' ) : get_the_post_thumbnail_url( $id, 'el_img_squa' );
}else{
	$image = $no_img_tmb;
}

$price = get_price_ticket_by_id_event( $id );
$priceCurrency = __( EL()->options->general->get( 'currency','USD' ), 'eventlist' );


$title = get_the_title();
$description = strip_tags( get_the_content() );

$address = get_post_meta($id, OVA_METABOX_EVENT.'map_address', true) ? get_post_meta($id, OVA_METABOX_EVENT.'map_address', true) : '';
$name_address = get_post_meta($id, OVA_METABOX_EVENT.'address', true) ? get_post_meta($id, OVA_METABOX_EVENT.'address', true) : '';
$start_date = get_post_meta($id, OVA_METABOX_EVENT.'start_date_str', true) ? date('Y-m-d', get_post_meta($id, OVA_METABOX_EVENT.'start_date_str', true)) : '';
$end_date = get_post_meta($id, OVA_METABOX_EVENT.'end_date_str', true) ? date('Y-m-d', get_post_meta($id, OVA_METABOX_EVENT.'end_date_str', true)) : '';

$tickets = array();
if( $ticket_arr = get_post_meta($id, OVA_METABOX_EVENT.'ticket', true) ){
	foreach ($ticket_arr as $key => $value) {
		$tickets[] = [ 
			"@type"=> "Offer", 
			'name' => $value['name_ticket'],
			"validFrom" => $value['start_ticket_date'] . ' T ' . $value['start_ticket_time'],
			'availability' => 'http://schema.org/InStock',
			'url' => $url,
			'price' => isset($value['price_ticket']) ? $value['price_ticket'] : 0, 
			'priceCurrency' => $priceCurrency
		];
	}
}

$info_organizer = get_post_meta($id, OVA_METABOX_EVENT.'info_organizer', true) ? get_post_meta($id, OVA_METABOX_EVENT.'info_organizer', true) : '';

if ($info_organizer == 'checked') {
	$display_name = get_post_meta($id, OVA_METABOX_EVENT.'name_organizer', true) ? get_post_meta($id, OVA_METABOX_EVENT.'name_organizer', true) : get_the_author_meta( 'display_name', $author_id );
} else {
	$display_name = get_user_meta( $author_id, 'display_name', true ) ? get_user_meta( $author_id, 'display_name', true ) : get_the_author_meta( 'display_name', $author_id );
}


$event_type = get_post_meta($id, OVA_METABOX_EVENT.'event_type', true) ? get_post_meta($id, OVA_METABOX_EVENT.'event_type', true) : 'classic';

?>

<script type="application/ld+json">
	[
	{
		"@context": "http://schema.org",
		"@type": "Event",
		<?php if( $event_type == 'online' ){ ?>
		"eventAttendanceMode": "https://schema.org/OnlineEventAttendanceMode",	
		<?php } ?>
		"image": "<?php echo $image; ?>",
		"description": "<?php echo $description; ?>",
		"location": 
		{
			"@type": "Place",
			"address": 
			{
				"@type": "PostalAddress",
				"streetAddress": "<?php echo $address; ?>"
			},
			"name": "<?php echo $name_address; ?>"
		},
		
		"name": "<?php echo $title; ?>",
		"offers": <?php echo json_encode($tickets); ?>,
		"performer": 
		{
			"@type": "Organization",
			"name": "<?php echo $display_name; ?>"
		},
		"startDate": "<?php echo $start_date; ?>",
		"endDate": "<?php echo $end_date; ?>"
	}
	]
</script>