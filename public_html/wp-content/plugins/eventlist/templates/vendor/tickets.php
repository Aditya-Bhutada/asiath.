<?php  if ( !defined( 'ABSPATH' ) ) exit(); ?>

<div class="vendor_wrap"> 

	<?php echo el_get_template( '/vendor/manage_event_sidebar.php' ); ?>
	
	<div class="contents">

		<?php
			
			$id_event = isset($_GET['eid']) ? sanitize_text_field($_GET['eid']) : "";

			$qrcode = isset($_GET['qrcode']) ? sanitize_text_field($_GET['qrcode']) : "";

			//Check capacity of user
			if( !el_can_manage_ticket() || !verify_current_user_post( $id_event ) || empty($id_event) ){
				esc_html_e( 'You don\'t have permission view tickets', 'eventlist' );
				exit();
			}

			echo el_get_template( '/vendor/heading.php' );

			echo el_get_template( '/vendor/__event_info.php' );

		
			$slug_event = get_post_field( 'post_name', $id_event);
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

			$check_allow_get_list_tickets = check_allow_get_list_tickets_by_event($id_event);
			$check_allow_export_tickets = check_allow_export_tickets_by_event($id_event);

		 	if ( $check_allow_get_list_tickets =='yes' ) :

		 		$agrs_basic = $agrs_qrcode = array();
			
				$agrs_basic = [
					'post_type' => 'el_tickets',
					'post_status' => 'publish',
					"meta_query" => [
						'relation' => 'AND',
						[
							"key" => OVA_METABOX_EVENT . 'event_id',
							"value" => $id_event,
						],
					],
					'paged'          => $paged,
				];

				if( $qrcode ){
					$agrs_qrcode = [
						"meta_query" => [

							[
								"key" => OVA_METABOX_EVENT . 'qr_code',
								"value" => $qrcode,
								'compare' => 'LIKE'
							],
						],
						
					];
				}

				$agrs = array_merge_recursive( $agrs_basic, $agrs_qrcode );

				$list_ticket_record_by_id_event = new WP_Query( $agrs );

				$list_ckf_output = get_option( 'ova_booking_form', array() );
				?>
				<div class="table-list-ticket">
					
					<?php $current_link = add_query_arg( array(
								'vendor' => 'manage_event',
								'tab' => 'tickets',
								'eid' => $id_event,
							), get_myaccount_page() );
					?>

					<form class="search_ticket" action="<?php echo esc_url( $current_link ); ?>" method="GET">
						
						<input type="text" value="<?php echo $qrcode; ?>" placeholder="<?php esc_html_e( 'Enter some characters in QR Code', 'eventlist' ); ?>" name="qrcode" style="width: 350px;" />
						
						<input type="hidden" name="vendor" value="manage_event" >
						<input type="hidden" name="tab" value="tickets" >
						<input type="hidden" name="eid" value="<?php echo $id_event; ?>" >
						<button type="submit" class="search_ticket_btn button">
							<?php esc_html_e( 'Find Ticket', 'eventlist' ); ?>
						</button>
						
					</form>

					

					<?php if ($check_allow_export_tickets == 'yes') : ?>
						<div class="el-export-csv">

							<a href="#" id="export-csv-extra-ticket"><?php esc_html_e("Choose fields to export", "eventlist") ?></a>
							<div class="list-check-export-csv">
								<ul>
									<li>
										<input name="event"  value="event" type="checkbox" id="id-event" checked="checked">
										<label for="id-event"><?php esc_html_e("Event", "eventlist") ?></label>
									</li>
									<li>
										<input name="ticket_type"  value="ticket_type" type="checkbox" id="ticket_type" checked="checked">
										<label for="ticket_type"><?php esc_html_e("Ticket Type", "eventlist") ?></label>
									</li>
									<li>
										<input name="name"  value="name" type="checkbox" id="name-customer" checked="checked">
										<label for="name-customer"><?php esc_html_e("Name Customer", "eventlist") ?></label>
									</li>

									<li>
										<input name="venue"  value="venue" type="checkbox" id="venue" checked="checked">
										<label for="venue"><?php esc_html_e("Venue", "eventlist") ?></label>
									</li>

									<li>
										<input name="address"  value="address" type="checkbox" id="address" checked="checked">
										<label for="address"><?php esc_html_e("Address", "eventlist") ?></label>
									</li>

									<li>
										<input name="seat"  value="seat" type="checkbox" id="seat" checked="checked">
										<label for="seat"><?php esc_html_e("Seat", "eventlist") ?></label>
									</li>
									<li>
										<input name="qr_code"  value="qr_code" type="checkbox" id="qr_code" checked="checked">
										<label for="qr_code"><?php esc_html_e("Qr code", "eventlist") ?></label>
									</li>

									<li>
										<input name="start_date"  value="start_date" type="checkbox" id="start_date" checked="checked">
										<label for="start_date"><?php esc_html_e("Start Date", "eventlist") ?></label>
									</li>

									<li>
										<input name="end_date"  value="end_date" type="checkbox" id="end_date" checked="checked">
										<label for="end_date"><?php esc_html_e("End Date", "eventlist") ?></label>
									</li>

									<li>
										<input name="date_create"  value="date_create" type="checkbox" id="date_create" checked="checked">
										<label for="date_create"><?php esc_html_e("Date created", "eventlist") ?></label>
									</li>

									<?php
										$list_name_ckf = [];
										if( ! empty( $list_ckf_output ) && is_array( $list_ckf_output ) ) {
											foreach( $list_ckf_output as $key_1 => $val ) {
												if( array_key_exists('enabled', $val) &&  $val['enabled'] == 'on' ) {
													$list_name_ckf[] = esc_html( $key_1 );
													?>
													<li>
														<input name="<?php echo esc_attr( $key_1 ) ?>"  value="<?php echo esc_attr( $key_1 ) ?>" type="checkbox" id="<?php echo esc_attr( $key_1 ) ?>" checked="checked">
														<label for="<?php echo esc_attr( $key_1 ) ?>"><?php echo esc_html( $val['label'] ) ?></label>
													</li>
													<?php
												}
												
											}
										}
									?>

								</ul>
								<input type="hidden" name="id_event" value="<?php echo esc_attr($id_event) ?>">
								<input type="hidden" name="el_list_ckf" id="el_list_ckf" value="<?php echo esc_attr( json_encode( $list_name_ckf ) ) ?>" />

								<button id="button-submit-ticket-export-csv" data-slug-event="<?php echo esc_attr($slug_event) ?>" data-id-event="<?php echo esc_attr($id_event) ?>"  name="export" class="export-csv-extra"><i class="fas fa-file-download"></i><?php esc_html_e("Export CSV", "eventlist") ?></button>


							</div>
						</div>
					<?php  endif; ?>

					<table>
						<thead class="event_head">
							<tr>
								<td><?php esc_html_e("Event", "eventlist") ?></td>
								<td><?php esc_html_e("Ticket Type", "eventlist") ?></td>
								<td><?php esc_html_e("Customer", "eventlist") ?></td>
								<td><?php esc_html_e("Seat", "eventlist") ?></td>
								<td><?php esc_html_e("Address", "eventlist") ?></td>
								<td style="width: 120px"><?php esc_html_e("Qr code", "eventlist") ?></td>
								<td><?php esc_html_e("Start date", "eventlist") ?></td>
								<td><?php esc_html_e("End date", "eventlist") ?></td>
								<td><?php esc_html_e("Created", "eventlist") ?></td>
								<td><?php esc_html_e( "Check-in", "eventlist" ) ?></td>
							</tr>
						</thead>
						<tbody class="event_body">
							<?php 
							if($list_ticket_record_by_id_event->have_posts() ) : while ( $list_ticket_record_by_id_event->have_posts() ) : $list_ticket_record_by_id_event->the_post(); 
								$id_ticket_record = get_the_id();
								$qr_code = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'qr_code', true );
								?>
								<tr>
									
									<td data-colname="<?php esc_attr_e('Event', 'eventlist'); ?>">
										<?php echo esc_html(get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'name_event', true )) ?>
									</td>

									<td data-colname="<?php esc_attr_e('Ticket Type', 'eventlist'); ?>">
										<?php echo esc_html(get_the_title($id_ticket_record)) ?> 
									</td>
									
									<td data-colname="<?php esc_attr_e('Customer', 'eventlist'); ?>">
										<?php echo esc_html(get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'name_customer', true )) ?>
									</td>
									
									<td data-colname="<?php esc_attr_e('Seat', 'eventlist'); ?>">
										<?php
										$seat = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'seat', true );
										$seat = $seat ? $seat : esc_html__("none", "eventlist");
										echo $seat;
										?>
									</td>

									<td data-colname="<?php esc_attr_e('Address', 'eventlist'); ?>">
										<?php
										$arr_venue = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'venue', true );
										$address = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'address', true );

										$venue = is_array( $arr_venue ) ? implode(", ", $arr_venue) : $arr_venue;
										if( $venue ){
											echo esc_html__("Venue: ", "eventlist") . $venue . '<br>';
										}
										if( $address ){
											echo esc_html__("Address: ", "eventlist") . $address . '<br>';
										}
										?>
									</td>

									<td data-colname="<?php esc_attr_e('Qr code', 'eventlist'); ?>" class="qr_code" style="width: 120px; word-break: break-all;">
										<?php echo $qr_code; ?>
									</td>

									<td data-colname="<?php esc_attr_e('Start date', 'eventlist'); ?>">
										<?php
										$start_date = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'date_start', true );
										$date_format = get_option('date_format');
										$time_format = get_option('time_format');

										echo date($date_format, $start_date) . ' <br/>@ ' . date($time_format, $start_date);
										?>
									</td>

									<td data-colname="<?php esc_attr_e('End date', 'eventlist'); ?>">
										<?php
										$end_date = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT . 'date_end', true );
										$date_format = get_option('date_format');
										$time_format = get_option('time_format');

										echo date($date_format, $end_date) . ' <br/>@ ' . date($time_format, $end_date);
										?>
									</td>

									<td data-colname="<?php esc_attr_e('Created', 'eventlist'); ?>">
										<?php
										$date_format = get_option('date_format');
										$time_format = get_option('time_format');
										echo get_the_date($date_format, $id_ticket_record) . " <br/>@ " . get_the_date($time_format, $id_ticket_record);
										?>
									</td>

									<td data-colname="<?php esc_attr_e('Check-in', 'eventlist'); ?>">
										<?php 
											$ticket_status = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT.'ticket_status', true );
											$checkin_time_tmp = get_post_meta( $id_ticket_record, OVA_METABOX_EVENT.'checkin_time', true ) ;
											$checkin_time =  $checkin_time_tmp ? date_i18n( get_option( 'date_format' ).' '. get_option( 'time_format' ), $checkin_time_tmp ) : '';

											if( $ticket_status == 'checked' ){ ?>
													<span class="error">

														<?php echo esc_html__( 'Check-in', 'eventlist' ); ?>
														<span class="wrap_info" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html__( 'Check-in at ', 'eventlist' ).' '.$checkin_time; ?>">
															<i class="icon_info_alt"></i>
														</span>
													</span>	
											<?php }else{ ?>
													<a href="#" class="update_ticket_status" data-qr_code="<?php echo $qr_code; ?>" title="<?php echo esc_html__( 'Update Ticket Status', 'eventlist' ); ?>">
														<i class="icon_check"></i>
													</a>
											<?php } ?>
										 
									</td>

								</tr>
								
							<?php endwhile; else : ?> 
							<td colspan="9"><?php esc_html_e( 'Not Found Tickets', 'eventlist' ); ?></td> 
							<?php ; endif; wp_reset_postdata(); ?>


						</tbody>
					</table>
					<!-- Tickets -->

					<?php 
					$total = $list_ticket_record_by_id_event->max_num_pages;
					if ( $total > 1 ) {
						echo pagination_vendor($total);
					} ?>
				</div>

			<?php endif; ?>

	</div>
	
	
</div>