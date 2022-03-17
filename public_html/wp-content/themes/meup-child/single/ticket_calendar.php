<?php if( ! defined( 'ABSPATH' ) ) exit(); 
global $event;

$id = get_the_ID();

$list_calendar_ticket = get_post_meta( $id, OVA_METABOX_EVENT . 'calendar', true);
$option_calendar = get_post_meta( $id, OVA_METABOX_EVENT . 'option_calendar', true);
$calendar_recurrence = get_post_meta( $id, OVA_METABOX_EVENT . 'calendar_recurrence', true);
$calendar_recurrence_start_time = get_post_meta( $id, OVA_METABOX_EVENT . 'calendar_recurrence_start_time', true);
$calendar_recurrence_end_time = get_post_meta( $id, OVA_METABOX_EVENT . 'calendar_recurrence_end_time', true);

$check_tiket_selling = $event->check_ticket_in_event_selling( $id );
$class_ticket_selling = 'un-selling';
$href_link = '';

$current_time = current_time('timestamp');
$array_event = array();
$initdate = date( 'Y-m-d',$current_time );
$finding_initdate = true;
$i = 0;
if ($calendar_recurrence) {
	foreach ($calendar_recurrence as $value) {
		$array_event[$i]['id'] = $value['calendar_id'];
		$array_event[$i]['date'] = isset($value['date']) ? $value['date'] : '' ;
		$time_value = strtotime( $array_event[$i]['date'] );



		if ( ( (($time_value >= $current_time) || ( date('d/m/Y', $time_value) === date('d/m/Y', $current_time) )) && $check_tiket_selling ) ) {
			$array_event[$i]['url'] = add_query_arg( array( 'ide' => $id, 'idcal' => $value['calendar_id'] ), get_cart_page()  );

			if( $finding_initdate ){
				$initdate = date('Y-m-d', $time_value);
				$finding_initdate = false;
			}
		}

		if ( EL()->options->event->get('show_hours_single', 'yes') == 'yes' ) {
			$array_event[$i]['title'] = date( get_option('time_format') , strtotime($calendar_recurrence_start_time)).' - '.date(get_option('time_format'), strtotime($calendar_recurrence_end_time));
		} else {
			$array_event[$i]['title'] = '';
		}
		
		$i++;
	}
}

$date_format = get_option('date_format');
$time_format = get_option('time_format');
$lang = el_calendar_language();


$ticket_link = get_post_meta( $id, OVA_METABOX_EVENT . 'ticket_link', true);

?>

<?php if ( !post_password_required( $id ) ) { ?>
	
	<?php if ($option_calendar == 'manual') {
		if (!empty( $list_calendar_ticket ) && is_array($list_calendar_ticket) ) :  ?>
			<div class="ticket-calendar event_section_white" id="booking_event">
				<h3 class="ticket-calendar second_font heading">
					<?php esc_html_e("Event Calendar", "eventlist") ?>
				</h3>
				<?php if ( !post_password_required( $id ) ) { ?>
					<?php
					foreach ( $list_calendar_ticket as $ticket ) : 
						$start_time = isset( $ticket['date'] ) ? el_get_time_int_by_date_and_hour($ticket['date'], $ticket['start_time']) : '';
						$end_time = isset( $ticket['end_date'] ) ? el_get_time_int_by_date_and_hour($ticket['end_date'], $ticket['end_time']) : '';
						$status = false;
						

						if ( el_validate_selling_ticket( $start_time, $end_time ) ) {
							$status = true;
						}

						if ( $check_tiket_selling ) {
							$href_link =  'href="'. add_query_arg( array( 'ide' => $id, 'idcal' => $ticket['calendar_id'] ), get_cart_page()  ) . '"';
							$class_ticket_selling = '';
						}

						?>
						<div class="item-calendar-ticket">
							<div class="date-time">
								<?php if ( isset($ticket['end_date']) && ( $ticket['date'] && $ticket['end_date'] && $ticket['date'] != $ticket['end_date'] ) ) { ?>
									<p class="date">
										<span class="day"><?php echo esc_html($event->get_date_by_format_and_date_time( "l", $ticket['date'] )) ?>, </span>
										<?php echo esc_html($event->get_date_by_format_and_date_time( $date_format, $ticket['date'] )) ?>
										-
										<span class="day"><?php echo esc_html($event->get_date_by_format_and_date_time( "l", $ticket['end_date'] )) ?>, </span>
										<?php echo esc_html($event->get_date_by_format_and_date_time( $date_format, $ticket['end_date'] )) ?>
									</p>
								<?php } else { ?>
									<p class="date">
										<span class="day"><?php echo esc_html($event->get_date_by_format_and_date_time( "l", $ticket['date'] )) ?>, </span>
										<?php echo esc_html($event->get_date_by_format_and_date_time( $date_format, $ticket['date'] )) ?>
									</p>
								<?php } ?>

								<?php if ( EL()->options->event->get('show_hours_single', 'yes') == 'yes' ) { ?>
									<div class="time">
										<span class="start-time"><?php echo isset( $ticket['date'] ) ? esc_html($event->get_date_by_format_and_date_time( $time_format, $ticket['date'], $ticket['start_time'] )) : '' ?></span>
										<span class="separator">-</span>
										<span class="start-time"><?php echo  isset( $ticket['end_date'] ) ? esc_html($event->get_date_by_format_and_date_time( $time_format, $ticket['end_date'], $ticket['end_time'] )) : '' ?></span>
										<span class="timezone">
											<?php echo '&nbsp;'.el_get_timezone_event( $id ); ?>
										</span>
									</div>
								<?php } ?>
							</div>

							<div class="button-book">
								<?php
								if ($status) {
									?>
									<?php if( $ticket_link != 'ticket_external_link' ){ ?>
										<a class="<?php echo esc_attr($class_ticket_selling) ?>" <?php echo $href_link ?>><?php echo esc_html__( "Book Now", "eventlist" ) ?></a>
									<?php } ?>
									<?php
								} else {
									?>
									<span class="close-booking"><?php echo $event->get_status_event_calendar($start_time, $end_time) ?></span>
									<?php
								}
								?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php } ?>
			</div>
		<?php endif;
	} else { 
		if (!empty($array_event) && is_array($array_event)) {
			?>
			<div class="ticket-calendar event_section_white" id="booking_event">
				<h3 class="title-ticket-calendar-single-event second_font heading">
					<?php esc_html_e("Event Calendar", "eventlist") ?>
					<div class="sub-title ">
						<?php esc_html_e( "Choose a date to booking event", 'eventlist' ); ?>
					</div>
				</h3>

				<?php if ( !post_password_required( $id ) ) { ?>
					<div 
					class="fullcalendar" 
					data-local="<?php echo esc_attr($lang); ?>" 
					data-initdate = '<?php echo esc_attr( $initdate ); ?>'
					data-listevent = '<?php echo esc_attr( json_encode($array_event) ); ?>'
					></div>
				<?php } ?>
				
			</div>

		<?php } 
	} ?>

<?php } ?>
