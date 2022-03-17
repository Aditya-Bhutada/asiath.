<?php
defined( 'ABSPATH' ) || exit;

if ( !class_exists( 'EL_Ticket', false ) ) {

	class EL_Ticket{


		protected static $_instance = null;

		protected $_prefix = OVA_METABOX_EVENT;

		/**
		 * Constructor
		 */
		public function __construct(){

			require_once EL_PLUGIN_INC . 'ticket/mpdf/vendor/autoload.php';

			if( apply_filters( 'el_filter_attach_qrcode_mail', true ) ){
				require_once	EL_PLUGIN_INC.'ticket/qrcode/qrcode.class.php';
			}
			
			require_once	EL_PLUGIN_INC.'ticket/class-el-pdf.php';
			
		}

		

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		public function add_ticket( $booking_id = null ){
			
			if ( $booking_id == null ) return false;
			$status_booking = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'status', true);
			

			if ( $status_booking != 'Completed' ) return false;

			$id_event = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'id_event', true);
			$idcal = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'id_cal', true);
			$name_customer = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'name', true);

			$event_obj = el_get_event( $id_event );
			
			$list_title_ticket = $list_url_image_ticket = $list_color_ticket = $list_price_ticket = $list_color_label_ticket = $list_color_content_ticket = $list_desc_ticket = $list_private_desc_title = [];

			// Get data from Event
			$list_type_ticket = get_post_meta( $event_obj->ID, OVA_METABOX_EVENT . 'ticket', true);
			$list_type_ticket_map = get_post_meta( $event_obj->ID, OVA_METABOX_EVENT . 'ticket_map', true);
			$seat_option = get_post_meta( $event_obj->ID, OVA_METABOX_EVENT . 'seat_option', true);
			
			$event_type = get_post_meta( $event_obj->ID, OVA_METABOX_EVENT . 'event_type', true);
			$venue = get_post_meta( $event_obj->ID, OVA_METABOX_EVENT . 'venue', true);
			$address = get_post_meta( $event_obj->ID, OVA_METABOX_EVENT . 'address', true);
			if( $event_type == 'online' ){
				$address = esc_html__( 'Online', 'eventlist' );
			}

			$name_event =  $event_obj->post_title;



			if ( $seat_option != 'map') {



				if ( !empty($list_type_ticket) && is_array($list_type_ticket) ) {

					foreach ( $list_type_ticket as $ticket ) {

						$list_title_ticket[$ticket['ticket_id']] = $ticket['name_ticket'];
						$list_url_image_ticket[$ticket['ticket_id']] = $ticket['image_ticket'];
						$list_color_ticket[$ticket['ticket_id']] = $ticket['color_ticket'];
						$list_color_label_ticket[$ticket['ticket_id']] = $ticket['color_label_ticket'];
						$list_color_content_ticket[$ticket['ticket_id']] = $ticket['color_content_ticket'];
						$list_desc_ticket[$ticket['ticket_id']] = $ticket['desc_ticket'];
						$list_private_desc_ticket[$ticket['ticket_id']] = $ticket['private_desc_ticket'];
						$list_price_ticket[$ticket['ticket_id']] = !empty($ticket['price_ticket']) ? $ticket['price_ticket'] : 0;

					}

				}

			} else {

				if ( !empty($list_type_ticket_map) && is_array($list_type_ticket_map) ) {
					
					$list_title_ticket[0] = esc_html__('Map', 'eventlist');
					$list_url_image_ticket[0] = $list_type_ticket_map['image_ticket'];
					$list_color_ticket[0] = $list_type_ticket_map['color_ticket'];
					$list_color_label_ticket[0] = $list_type_ticket_map['color_label_ticket'];
					$list_color_content_ticket[0] = $list_type_ticket_map['color_content_ticket'];
					$list_desc_ticket[0] = $list_type_ticket_map['desc_ticket'];
					$list_private_desc_ticket[0] = $list_type_ticket_map['private_desc_ticket_map'];

				}
				
				

			}
			
			

			$post_data['post_type'] = 'el_tickets';
			$post_data['post_status'] = 'publish';

			// Add Author of event for Ticket
			$booking_obj = get_post( $booking_id );
			$booking_author_id = $booking_obj->post_author;
			$post_data['post_author'] = $booking_author_id;

			$date_event = self::el_get_calendar_date_time($id_event, $idcal);
			$list_qty_ticket = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'list_qty_ticket_by_id_ticket', true);
			$list_seat_in_booking = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'list_seat_book', true);
			$data_checkout_field = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'data_checkout_field', true);
			
			$arr_list_id_ticket = [];
			if ( !empty($list_qty_ticket) && is_array($list_qty_ticket) ) {
				foreach ($list_qty_ticket as $id => $qty) {
					for( $i=0 ; $i < $qty; $i++ ) {
						$mix_id = $booking_id . '-ova-el-' . $id_event . '-ova-el-' . $id . '-ova-el-' . $i . EL()->options->general->get('serect_key_qrcode');
						$qr_code = md5( $mix_id );
						
						if ( $seat_option != 'map') {
							$post_data['post_title'] = $list_title_ticket[strtolower($id)];
							$meta_input = array(
								$this->_prefix.'booking_id' => $booking_id,
								$this->_prefix.'event_id' => $id_event,
								$this->_prefix.'name_event' => $name_event,
								$this->_prefix.'qr_code' => $qr_code,
								$this->_prefix.'name_customer' 	=> $name_customer,
								$this->_prefix.'venue' 	=> $venue,
								$this->_prefix.'address' 	=> $address,
								$this->_prefix.'data_checkout_field' 	=> $data_checkout_field,
								$this->_prefix.'seat' 	=> isset( $list_seat_in_booking[$id][$i] ) ? $list_seat_in_booking[$id][$i] : '',
								$this->_prefix.'date_start' => $date_event['start_time'],
								$this->_prefix.'date_end' => $date_event['end_time'],
								$this->_prefix.'img' => $list_url_image_ticket[$id],
								$this->_prefix.'color_ticket' => $list_color_ticket[$id],
								$this->_prefix.'color_label_ticket' => $list_color_label_ticket[$id],
								$this->_prefix.'color_content_ticket' => $list_color_content_ticket[$id],
								$this->_prefix.'price_ticket' => $list_price_ticket[$id],
								$this->_prefix.'desc_ticket' => $list_desc_ticket[$id],
								$this->_prefix.'private_desc_ticket' => $list_private_desc_ticket[$id],
								$this->_prefix.'ticket_status' => '',
								$this->_prefix.'checkin_time' => '',
							);
						} else {
							$post_data['post_title'] = $list_title_ticket[0];
							$meta_input = array(
								$this->_prefix.'booking_id' => $booking_id,
								$this->_prefix.'event_id' => $id_event,
								$this->_prefix.'name_event' => $name_event,
								$this->_prefix.'qr_code' => $qr_code,
								$this->_prefix.'name_customer' => $name_customer,
								$this->_prefix.'venue' => $venue,
								$this->_prefix.'address' => $address,
								$this->_prefix.'data_checkout_field' => $data_checkout_field,
								$this->_prefix.'seat' => $id ? $id : '',
								$this->_prefix.'date_start' => $date_event['start_time'],
								$this->_prefix.'date_end' => $date_event['end_time'],
								$this->_prefix.'img' => $list_url_image_ticket[0],
								$this->_prefix.'color_ticket' => $list_color_ticket[0],
								$this->_prefix.'color_label_ticket' => $list_color_label_ticket[0],
								$this->_prefix.'color_content_ticket' => $list_color_content_ticket[0],
								$this->_prefix.'desc_ticket' => $list_desc_ticket[0],
								$this->_prefix.'private_desc_ticket' => $list_private_desc_ticket[0],
								$this->_prefix.'ticket_status' => '',
								$this->_prefix.'checkin_time' => '',
							);
						}

						$post_data['meta_input'] = apply_filters( 'el_ticket_metabox_input', $meta_input );
						$ticket_id = wp_insert_post( $post_data, true );
						$arr_list_id_ticket[] = $ticket_id;
					}
				}
			}

			return $arr_list_id_ticket;
		}

		public function el_get_calendar_date_time( $id_event, $id_cal ){
			if( !$id_event || !$id_cal ) ['start_time' => 0, 'end_time' => 0];

			$list_calendar = get_arr_list_calendar_by_id_event($id_event);

			
			if( is_array($list_calendar) && !empty($list_calendar) ){
				foreach ( $list_calendar as $cal ) {
					if( $cal['calendar_id'] == $id_cal ) {
						$date = $cal['date'];
						$end_date = (isset($cal['end_date']) && $cal['end_date']) ? $cal['end_date'] : $cal['date'];
						$time_start = $cal['start_time'];
						$end_time = $cal['end_time'];
						break;
					}
				}
			}
			$total_time_start = el_get_time_int_by_date_and_hour($date, $time_start);
			$total_time_end = el_get_time_int_by_date_and_hour($end_date, $end_time);

			return ['start_time' => $total_time_start, 'end_time' => $total_time_end];
		}


		public function make_pdf_ticket_by_booking_id ( $booking_id = null ) {
			if ($booking_id == null) return [];

			$args = array(
				'post_type' => 'el_tickets',
				'post_status' => 'publish',
				'posts_per_page' => '-1',
				'meta_query' => array(
					array(
						'key' => $this->_prefix . 'booking_id',
						'value' => $booking_id,
						'compare' => '='
					)
				)
			);
			$tickets = new WP_Query( $args );
			$ticket_pdf = array();
			$k = 0;

			if( $tickets->have_posts() ): while( $tickets->have_posts() ): $tickets->the_post();

				$pdf = new EL_PDF();
				$ticket_id = get_the_id();

				$ticket_pdf[$k] = $pdf->make_pdf_ticket( $ticket_id );	
				$k++;

				if( apply_filters( 'el_filter_attach_qrcode_mail', true ) ){
					$qrcode_str = get_post_meta( $ticket_id, OVA_METABOX_EVENT . 'qr_code', true );

					$qrcode = new QRcode($qrcode_str, 'H');
					$qr_image = WP_CONTENT_DIR.'/uploads/ticket_qr_'.$qrcode_str.'.png';
					$qrcode->displayPNG('100',array(255,255,255), array(0,0,0), $qr_image , 0);
					$ticket_pdf[$k] = $qr_image;
					$k++;
				}

			endwhile; endif; wp_reset_postdata();
			return $ticket_pdf;
		}

		public  function get_list_ticket_by_id_event ($id_event = null) {
			if ($id_event == null) return;
			$agrs = [
				'post_type' => 'el_tickets',
				'post_status' => 'publish',
				"meta_query" => [
					'relation' => 'AND',
					[
						"key" => OVA_METABOX_EVENT . 'event_id',
						"value" => $id_event,
					],
				],
				'posts_per_page' => -1, 
				'numberposts' => -1,
				'nopaging' => true,
			];

			return get_posts( $agrs );

		}

		public  function get_number_ticket_free_by_id_event ($id_event = null) {
			if ($id_event == null) return;
			$agrs = [
				'post_type' => 'el_tickets',
				'post_status' => 'publish',
				"meta_query" => [
					'relation' => 'AND',
					[
						"key" => OVA_METABOX_EVENT . 'event_id',
						"value" => $id_event,
					],
					[
						"key" => OVA_METABOX_EVENT . 'price_ticket',
						"value" => 0,
					],
				],
				'posts_per_page' => -1, 
				'numberposts' => -1,
				'nopaging' => true,
			];

			$tickets = get_posts( $agrs );
			return count($tickets);

		}

		public  function get_number_ticket_checkin ($id_event = null) {
			if ($id_event == null) return;
			$args = array(
				'post_type' => 'el_tickets',
				'post_status' => 'publish',
				'posts_per_page' => '-1',
				'fields'	=> 'ids',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						"key" => OVA_METABOX_EVENT . 'event_id',
						"value" => $id_event,
						'compare'	=> '='
					),
					array(
						"key" => OVA_METABOX_EVENT . 'ticket_status',
						"value" => 'checked',
						'compare'	=> '='
					)
				)
			);
			$tickets = new WP_Query( $args );
			return $tickets;
		}

		public static function validate_qrcode( $request ){

			
			$qrcode =  sanitize_text_field( $request['check_qrcode'] );

			$ticket_info = array();

			$args = array(
				'post_type' => 'el_tickets',
				'post_status' => 'publish',
				'numberposts' => '1',
				'fields'	=> 'ids',
				'meta_query' => array(

					array(
						'key' => OVA_METABOX_EVENT . 'qr_code',
						'value' => $qrcode,
						'compare'	=> '=',
					)
				)
				
			);

			$ticket_id = get_posts ( $args );

			if( !$ticket_id ){

				$ticket_info['status'] = 'error';
				$ticket_info['msg'] = esc_html__( 'Not found ticket', 'eventlist' );

				return $ticket_info;
			}
			
			// Get id of event
			$event_id = get_post_meta( $ticket_id[0], OVA_METABOX_EVENT.'event_id', true );

			// Get staff member of event who can check qr code
			$staff_member = get_post_meta( $event_id, OVA_METABOX_EVENT.'api_key', true );

			// Get nickname of current user
			$current_user_nickname = EL_User::el_get_current_user('nickname');

			if( !$current_user_nickname ){

				$ticket_info['status'] = 'error';
				$ticket_info['msg'] = esc_html__( 'Please login to check QR Code', 'eventlist' );

				return $ticket_info;
			}


			// If current user can't check QR Code
			if( !( ( $current_user_nickname && $current_user_nickname == $staff_member ) || verify_current_user_post( $event_id ) ) ){

				$ticket_info['status'] = 'error';
				$ticket_info['msg'] = esc_html__( 'You don\'t have permission to check qr code', 'eventlist' );

				return $ticket_info;
			}

			// Validate and update ticket status

			if( $ticket_id && !get_post_meta( $ticket_id[0], OVA_METABOX_EVENT.'ticket_status', true ) ){

				$ticket = array(
					'ID'           => $ticket_id[0],
					'meta_input'	=> array(
						OVA_METABOX_EVENT.'ticket_status' => 'checked',
						OVA_METABOX_EVENT.'checkin_time' => current_time('timestamp')
					)
				);
				if( wp_update_post( $ticket ) ){

					$ticket_info['status'] = 'valid';
					$ticket_info['msg'] = esc_html__( 'The QR Code is Valid', 'eventlist' );
					$ticket_info['msg_show'] = esc_html__( 'Update successful', 'eventlist' );

				}else{

					$ticket_info['status'] = 'error';
					$ticket_info['msg'] = esc_html__( 'Can\'t update ticket status', 'eventlist' );

					return $ticket_info;

				}

			}


			$name_event = get_post_meta( $ticket_id[0], OVA_METABOX_EVENT.'name_event', true ) ;
			$checkin_time_tmp = get_post_meta( $ticket_id[0], OVA_METABOX_EVENT.'checkin_time', true ) ;
			$checkin_time =  $checkin_time_tmp ? date_i18n( get_option( 'date_format' ).' '. get_option( 'time_format' ), $checkin_time_tmp ) : '';

			$name_customer = get_post_meta( $ticket_id[0], OVA_METABOX_EVENT.'name_customer', true ) ;
			$seat = get_post_meta( $ticket_id[0], OVA_METABOX_EVENT.'seat', true ) ;

			// Event Calendar
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');

			$start_date = get_post_meta( $ticket_id[0], OVA_METABOX_EVENT . 'date_start', true );
			$start_date_day = date_i18n($date_format, $start_date);
			$start_date_time = date_i18n($time_format, $start_date);

			$end_date = get_post_meta( $ticket_id[0], OVA_METABOX_EVENT . 'date_end', true );
			$end_date_day = date_i18n($date_format, $end_date);
			$end_date_time = date_i18n($time_format, $end_date);
			

			$event_calendar = $start_date_day === $end_date_day ? $start_date_day.' '.$start_date_time.'-'.$end_date_time : $start_date_day.'-'.$end_date_day.' '.$start_date_time.'-'.$end_date_time;

			if( !isset( $ticket_info['status'] ) ) $ticket_info['status'] = 'checked-in';

			if( $ticket_info['status'] == 'checked-in' ){
				$ticket_info['msg'] = esc_html__( 'Already Checked In', 'eventlist' );
			}

			$ticket_info['checkin_time'] = $checkin_time;
			$ticket_info['name_customer'] = $name_customer;
			$ticket_info['seat'] = $seat;
			$ticket_info['e_cal'] = $event_calendar;
			$ticket_info['ticket_id'] = $ticket_id[0];
			$ticket_info['name_event'] = $name_event;
			

			return $ticket_info;

		}

		

	}

}
