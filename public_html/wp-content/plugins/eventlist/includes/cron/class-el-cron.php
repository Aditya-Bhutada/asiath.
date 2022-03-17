<?php defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'EL_Cron' ) ) {

	/**
	 * Class EL_Mail
	 */
	class EL_Cron {

		// Remind
		public $hook_remind_event_time = 'el_cron_hook_remind_event_time';
		public $time_repeat_remind_event_time = 'time_repeat_remind_event_time';

		// Update Start event for event
		public $hook_update_start_date_event = 'el_cron_hook_update_start_date_event';
		public $time_repeat_update_start_date_event = 'time_repeat_update_start_date_event';

		/**
		 * EL_Cron constructor.
		 */
		public function __construct() {

			add_filter( 'cron_schedules', array( $this, 'el_add_cron_interval' ) );
			add_action( 'init', array( $this, 'el_check_scheduled' ) );
			register_deactivation_hook( __FILE__, array( $this, 'el_deactivate_cron' ) ); 

			add_action( $this->hook_remind_event_time, array( $this, 'el_remind_event_time' ) );
			add_action( $this->hook_update_start_date_event, array( $this, 'el_update_start_event_event_time' ) );
			
		}

		

		public function el_check_scheduled(){

			// Remind
			if ( ! wp_next_scheduled( $this->hook_remind_event_time ) ) {
			    wp_schedule_event( time(), $this->time_repeat_remind_event_time, $this->hook_remind_event_time );
			}

			// Update start date
			if ( ! wp_next_scheduled( $this->hook_update_start_date_event ) ) {
			    wp_schedule_event( time(), $this->time_repeat_update_start_date_event, $this->hook_update_start_date_event );
			}

		}

		/**
		 * init time repeat hook
		 * @param  array $schedules 
		 * @return array schedule
		 */
		public function el_add_cron_interval( $schedules ) {

			// Remind
			$remind_mail_send_per_seconds = intval( EL()->options->mail->get( 'remind_mail_send_per_seconds', 86400 ) );

		    $schedules[$this->time_repeat_remind_event_time] = array(
		        'interval' => $remind_mail_send_per_seconds,
		        'display' => sprintf( esc_html__( 'Every % seconds', 'eventlist' ), $remind_mail_send_per_seconds )
		    );

		    // Update start date event
			$update_start_date_send_per_seconds = intval( apply_filters( 'el_time_repeat_update_start_date_event', 86400 ) );

		    $schedules[$this->time_repeat_update_start_date_event] = array(
		        'interval' => $update_start_date_send_per_seconds,
		        'display' => sprintf( esc_html__( 'Every % seconds', 'eventlist' ), $update_start_date_send_per_seconds )
		    );		    

		    return $schedules;
		}


		public function el_deactivate_cron() {
		    $timestamp = wp_next_scheduled( $this->hook_remind_event_time );
		    wp_unschedule_event( $timestamp, $this->hook_remind_event_time );

		    $timestamp_update_start_date = wp_next_scheduled( $this->hook_update_start_date_event );
		    wp_unschedule_event( $timestamp_update_start_date, $this->hook_update_start_date_event );

		    
		}


		public function el_remind_event_time(){

			if( EL()->options->mail->get( 'remind_mail_enable', 'yes' ) !== 'yes' ) return;

			$send_x_day = intval( EL()->options->mail->get( 'remind_mail_before_xday', 3 ) );

			$curren_time = current_time('timestamp');

			$args = array(
				'post_type' 	=> 'el_tickets',
				'post_status'    => 'publish',
				'numberposts'	 => -1,
				'meta_query' 	=> array(
					array(
						'relation' => 'AND',
						array(
							'key' => OVA_METABOX_EVENT.'date_start',
							'value' => array( $curren_time, $curren_time + $send_x_day*24*60*60 ),
							'compare' => 'BETWEEN'
						),
						array(
							'key' => OVA_METABOX_EVENT.'ticket_status',
							'value' => '',
							'compare' => '='
						)
						
					)
				)

			);

			$tickets = get_posts( $args );

			$date = get_option( 'date_format' ).' '.get_option( 'time_format' );

			if ( ! empty($tickets) && is_array($tickets) ) {

				foreach( $tickets as $ticket ) {

					$booking_id =  get_post_meta( $ticket->ID, OVA_METABOX_EVENT . 'booking_id', true);
					$mail_customer = get_post_meta( $booking_id, OVA_METABOX_EVENT . 'email', true);
					$event_id = get_post_meta( $ticket->ID, OVA_METABOX_EVENT . 'event_id', true);
					$event_name = get_post_meta( $ticket->ID, OVA_METABOX_EVENT . 'name_event', true);
					$event_start_time =  date_i18n( $date, get_post_meta( $ticket->ID, OVA_METABOX_EVENT . 'date_start', true) );

					el_mail_remind_event_time( $mail_customer, $event_id, $event_name, $event_start_time );

				}
			}

		}

		public function el_update_start_event_event_time(){

			$today_tmp = strtotime( date( 'Y-m-d', current_time( 'timestamp' ) ) );

			 $args = array(
			 	'post_type' => 'event',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'fields' => 'ids',
				'meta_query'	=> array(
					array(
						'key' => OVA_METABOX_EVENT . 'end_date_str',
						'value' => current_time('timestamp'),
						'compare' => '>',
					),
				)
			 );
			 $events = get_posts( $args );

			 foreach ($events as $key => $id) {

			 	$option_calendar = get_post_meta( $id, OVA_METABOX_EVENT.'option_calendar', true );
			 	$calendar = get_post_meta( $id, OVA_METABOX_EVENT.'calendar', true );
			 	$calendar_recurrence = get_post_meta( $id, OVA_METABOX_EVENT.'calendar_recurrence', true );

			 	$arr_start_date = array();

				if ($option_calendar == 'manual') {
					if ( $calendar ) {
						foreach ($calendar as $value) {
							$start_date = strtotime( $value['date'] .' '. $value['start_time'] );
							if( $start_date >= $today_tmp ){
								$arr_start_date[] = $start_date;	
							}
							
						}
					}
				} else if ( $calendar_recurrence ) {

					foreach ($calendar_recurrence as $value) {

						$start_date = strtotime( $value['date'] .' '. $value['start_time'] );
						if( $start_date >= $today_tmp ){
							$arr_start_date[] = $start_date;	
						}
					}
				}

				$start_date_str = min($arr_start_date);
				
			 	update_post_meta( $id, OVA_METABOX_EVENT.'start_date_str', $start_date_str );
			 	

			 }

		}

	}
}

new EL_Cron();














