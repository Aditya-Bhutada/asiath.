<?php  if ( !defined( 'ABSPATH' ) ) exit(); ?>

<div class="vendor_wrap"> 

	<?php echo el_get_template( '/vendor/manage_event_sidebar.php' ); ?>
	
	<div class="contents">

		<!-- Check capacity of user -->
		<?php

		$id_event = isset($_GET['eid']) ? sanitize_text_field($_GET['eid']) : "";

		if( !el_can_manage_booking() || !verify_current_user_post( $id_event ) || empty($id_event) ){
			esc_html_e( 'You don\'t have permission view bookings', 'eventlist' );
			exit();
		}
		
		echo el_get_template( '/vendor/heading.php' );

		echo el_get_template( '/vendor/__event_info.php' );

		$slug_event = get_post_field( 'post_name', $id_event);

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		// Check capacity of event
		$check_allow_get_list_attendees = check_allow_get_list_attendees_by_event($id_event);
		$check_allow_export_attendees = check_allow_export_attendees_by_event($id_event);

		?>

		<?php if ($check_allow_get_list_attendees == 'yes') : ?>

			<?php
			if(empty($id_event) || !verify_current_user_post($id_event)) return;



			



			//get list booking by id event

			if( is_array( apply_filters( 'el_manage_bookings_show_status_vendor', array( 'Completed', 'Pending', 'Canceled' ) ) ) ){
				$agrs = [
					'post_type' => 'el_bookings',
					'post_status' => 'publish',
					"meta_query" => [
						'relation' => 'AND',
						[
							"key" => OVA_METABOX_EVENT . 'id_event',
							"value" => $id_event,
						],
						[
							"key" => OVA_METABOX_EVENT . 'status',
							"value" => apply_filters( 'el_manage_bookings_show_status_vendor', array( 'Completed', 'Pending', 'Canceled' ) ),
							'compare' => 'IN'
						]
					],
					"paged" => $paged,
				];	
			}else{
				$agrs = [
					'post_type' => 'el_bookings',
					'post_status' => 'publish',
					"meta_query" => [
						'relation' => 'AND',
						[
							"key" => OVA_METABOX_EVENT . 'id_event',
							"value" => $id_event,
						],
						[
							"key" => OVA_METABOX_EVENT . 'status',
							"value" => apply_filters( 'el_manage_bookings_show_status_vendor', array( 'Completed', 'Pending', 'Canceled' ) ),
							'compare' => '='
						]
					],
					"paged" => $paged,
				];
			}
			
			
			$list_booking_by_id_event = new WP_Query( $agrs );
			$list_ckf_output = get_option( 'ova_booking_form', array() );
			

			?>
			<div class="table-list-booking">
				<?php if( $check_allow_export_attendees == 'yes' ) : ?>
					<div class="el-export-csv">
						<a href="javascript:void(0)" id="export-csv-extra"><?php esc_html_e("Choose fields to export", "eventlist") ?></a>
						<div class="list-check-export-csv">
							<ul>
								<li>
									<input name="id_booking"  value="id_booking" type="checkbox" id="id-booking" checked="checked">
									<label for="id-booking"><?php esc_html_e("ID Booking", "eventlist") ?></label>
								</li>
								<li>
									<input name="event"  value="event" type="checkbox" id="id-event" checked="checked">
									<label for="id-event"><?php esc_html_e("Event", "eventlist") ?></label>
								</li>
								<li>
									<input name="calendar"  value="calendar" type="checkbox" id="calendar" checked="checked">
									<label for="calendar"><?php esc_html_e("Calendar", "eventlist") ?></label>
								</li>
								<li>
									<input name="name"  value="name" type="checkbox" id="name-customer" checked="checked">
									<label for="name-customer"><?php esc_html_e("Name Customer", "eventlist") ?></label>
								</li>
								<li>
									<input name="phone"  value="phone" type="checkbox" id="phone" checked="checked">
									<label for="phone"><?php esc_html_e("Phone", "eventlist") ?></label>
								</li>
								<li>
									<input name="email"  value="email" type="checkbox" id="email" checked="checked">
									<label for="email"><?php esc_html_e("Email", "eventlist") ?></label>
								</li>
								
								<li>
									<input name="total"  value="total_after_tax" type="checkbox" id="total" checked="checked">
									<label for="total"><?php esc_html_e("Total", "eventlist") ?></label>
								</li>
								<li>
									<input name="status"  value="status" type="checkbox" id="status" checked="checked">
									<label for="status"><?php esc_html_e("Status", "eventlist") ?></label>
								</li>
								<li>
									<input name="ticket_type"  value="ticket_type" type="checkbox" id="type-ticket" checked="checked">
									<label for="type-ticket"><?php esc_html_e("Ticket Type", "eventlist") ?></label>
								</li>
								<li>
									<input name="date_create"  value="date_create" type="checkbox" id="date-created" checked="checked">
									<label for="date-created"><?php esc_html_e("Date created", "eventlist") ?></label>
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

							<button id="button-submit-export-csv" data-slug-event="<?php echo esc_attr($slug_event) ?>" data-id-event="<?php echo esc_attr($id_event) ?>"  name="export" class="export-csv-extra"><i class="fas fa-file-download"></i><?php esc_html_e("Export CSV", "eventlist") ?></button>


						</div>
					</div>
				<?php endif; ?>

				<table>
					<thead class="event_head">
						<tr>
							<td class="id"><?php esc_html_e("ID", "eventlist") ?></td>
							<td><?php esc_html_e("Event", "eventlist") ?></td>
							<td><?php esc_html_e("Calendar Date", "eventlist") ?></td>
							<td><?php esc_html_e("Info", "eventlist") ?></td>
							<td><?php esc_html_e("Total", "eventlist") ?></td>
							<td><?php esc_html_e("Status", "eventlist") ?></td>
							<td><?php esc_html_e("Ticket Type", "eventlist") ?></td>
							<td><?php esc_html_e("Date Created", "eventlist") ?></td>
						</tr>
					</thead>
					<tbody class="event_body">
						<?php 
						if($list_booking_by_id_event->have_posts() ) : while ( $list_booking_by_id_event->have_posts() ) : $list_booking_by_id_event->the_post();

							$id_booking = get_the_id();
							$status_post = get_post_meta( $id_booking, OVA_METABOX_EVENT . 'status', true );
							switch( $status_post ) {

								case 'Completed':{
									$status = esc_html__('Completed', 'eventlist');
									break;
								}
								case 'Pending':{
									$status = esc_html__('Pending', 'eventlist');
									break;
								}
								case 'Canceled':{
									$status = esc_html__('Canceled', 'eventlist');
									break;
								}

								default : {
									$status = $status_post;
									break;
								}
							}
							?>
							<tr>
								<td data-colname="<?php esc_attr_e('ID', 'eventlist'); ?>" class="id" ><?php echo $id_booking; ?></td>
								<td data-colname="<?php esc_attr_e('Event', 'eventlist'); ?>" ><?php echo get_post_meta( $id_booking, OVA_METABOX_EVENT . 'title_event', true ); ?></td>
								<td data-colname="<?php esc_attr_e('Calendar Date', 'eventlist'); ?>" ><?php echo get_post_meta( $id_booking, OVA_METABOX_EVENT . 'date_cal', true ); ?></td>
								<td data-colname="<?php esc_attr_e('Info', 'eventlist'); ?>" >
									<?php
									$html = esc_html__("Name: ", "eventlist") . get_post_meta( $id_booking, OVA_METABOX_EVENT . 'name', true ) . '<br>';
									$html .= esc_html__("Phone: ", "eventlist") . get_post_meta( $id_booking, OVA_METABOX_EVENT . 'phone', true ) . '<br>';
									$html .= esc_html__("Email: ", "eventlist") . get_post_meta( $id_booking, OVA_METABOX_EVENT . 'email', true ) . '<br>';
									echo $html;
									?>
								</td>
								<td data-colname="<?php esc_attr_e('Total', 'eventlist'); ?>" ><?php echo el_price(get_post_meta( $id_booking, OVA_METABOX_EVENT . 'total_after_tax', true )); ?></td>
								<td data-colname="<?php esc_attr_e('Status', 'eventlist'); ?>" ><?php echo $status ?></td>
								<td data-colname="<?php esc_attr_e('Ticket Type', 'eventlist'); ?>" >
									<?php
									$list_ticket_in_event = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true);

									$list_ticket = get_post_meta( $id_booking, OVA_METABOX_EVENT . 'list_id_ticket', true );
									$list_ticket = json_decode($list_ticket);

									$list_qty_ticket_by_id_ticket = get_post_meta( $id_booking, OVA_METABOX_EVENT . 'list_qty_ticket_by_id_ticket', true );


									$html = "";
									if ( ! empty($list_ticket_in_event) && is_array($list_ticket_in_event) ) {
										foreach ($list_ticket_in_event as $ticket) {
											if ( in_array($ticket['ticket_id'], $list_ticket) ) {
												
												$html .= $ticket['name_ticket'] .' - '.$list_qty_ticket_by_id_ticket[ $ticket['ticket_id'] ].' '.esc_html__( 'ticket(s)', 'eventlist' ). '<br>';
											}
										}
									}
									echo $html;
									?>
								</td>
								<td data-colname="<?php esc_attr_e('Date Created', 'eventlist'); ?>" class="last-colname">
									<?php
									$date_format = get_option('date_format');
									$time_format = get_option('time_format');
									echo get_the_date($date_format, $id_booking) . " - " . get_the_date($time_format, $id_booking);
									?>
								</td>
							</tr>
						<?php endwhile; else : ?> 
						<td colspan="8"><?php esc_html_e( 'Not Found Bookings', 'eventlist' ); ?></td> 
						<?php ; endif; wp_reset_postdata(); ?>

						
					</tbody>
				</table>
				<?php 
				$total = $list_booking_by_id_event->max_num_pages;
				if ( $total > 1 ) {
					echo pagination_vendor($total);
				}
				?>
			</div>

		<?php endif; ?>

	</div>
	
</div>

