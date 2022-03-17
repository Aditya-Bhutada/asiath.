<?php
defined( 'ABSPATH' ) || exit;
if( !function_exists('get_total') ){
	function get_total( $id_event = null, $id_cal = null, $cart = [], $coupon = null ){
		return EL_Cart::instance()->get_total( $id_event, $id_cal, $cart, $coupon );
	}
}

if( !function_exists('get_total_after_tax') ){
	function get_total_after_tax( $total = 0, $id_event  = null ){
		return EL_Cart::instance()->get_total_after_tax( $total, $id_event );
	}
}

if( !function_exists('sanitize_cart') ){
	function sanitize_cart( $cart = [] ){
		return EL_Cart::instance()->sanitize_cart( $cart );
	}
}

if( !function_exists('sanitize_cart_map') ){
	function sanitize_cart_map( $cart = [] ){
		return EL_Cart::instance()->sanitize_cart_map( $cart );
	}
}

if( !function_exists('sanitize_list_checkout_field') ){
	function sanitize_list_checkout_field( $arr_list_ckf = [] ){
		return EL_Cart::instance()->sanitize_list_checkout_field( $arr_list_ckf );
	}
}