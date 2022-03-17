<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Get list event
if( !function_exists( 'get_vendor_events' ) ){

	function get_vendor_events( $order = 'DESC', $orderby = 'ID', $status = 'public', $user_id = '', $paged = '' ){

		return EL_Vendor::instance()->get_vendor_events( $order, $orderby, $status, $user_id, $paged );
		
	}

}


// Get taxonomy
if( !function_exists( 'el_get_taxonomy' ) ){

	function el_get_taxonomy( $taxonomy = '' ){

		return EL_Vendor::instance()->el_get_taxonomy( $taxonomy );

	}

}


// Get country
if( !function_exists( 'el_get_state' ) ){

	function el_get_state( $selected = '' ){

		return EL_Vendor::instance()->el_get_state( $selected );

	}

}


// Get city
if( !function_exists( 'el_get_city' ) ){

	function el_get_city( $selected = '' ){

		return EL_Vendor::instance()->el_get_city( $selected );
		
	}

}

//check allow get list attendees
if ( !function_exists( 'check_allow_get_list_attendees_by_event' ) ) {
	function check_allow_get_list_attendees_by_event ( $id_event ) {
		return EL_Vendor::instance()->check_allow_get_list_attendees_by_event( $id_event );
	}
}

//check allow export attendees
if ( !function_exists( 'check_allow_export_attendees_by_event' ) ) {
	function check_allow_export_attendees_by_event ($id_event) {
		return EL_Vendor::instance()->check_allow_export_attendees_by_event($id_event);
	}
}

//check allow get list tickets
if ( !function_exists( 'check_allow_get_list_tickets_by_event' ) ) {
	function check_allow_get_list_tickets_by_event ($id_event) {
		return EL_Vendor::instance()->check_allow_get_list_tickets_by_event($id_event);
	}
}

//check allow export tickets
if ( !function_exists( 'check_allow_export_tickets_by_event' ) ) {
	function check_allow_export_tickets_by_event ($id_event) {
		return EL_Vendor::instance()->check_allow_export_tickets_by_event($id_event);
	}
}

//check allow change tax
if ( !function_exists( 'check_allow_change_tax_by_event' ) ) {
	function check_allow_change_tax_by_event ($id_event) {
		return EL_Vendor::instance()->check_allow_change_tax_by_event($id_event);
	}
}

if ( !function_exists( 'get_post_id_package_by_event' ) ) {
	function get_post_id_package_by_event ($id_event) {
		return EL_Vendor::instance()->get_post_id_package_by_event($id_event);
	}
}

//check allow change tax
if ( !function_exists( 'check_allow_change_tax_by_user_login' ) ) {
	function check_allow_change_tax_by_user_login () {
		return EL_Vendor::instance()->check_allow_change_tax_by_user_login();
	}
}