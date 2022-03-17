<?php 
if ( !defined( 'ABSPATH' ) ) exit();

?>

<div class="vendor_wrap"> 

	<?php echo el_get_template( '/vendor/sidebar.php' ); ?>

	<div class="contents">
		<?php echo el_get_template( '/vendor/heading.php' ); ?>

		<?php
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$list_bookings = EL_Booking::instance()->get_list_booking_user_current($paged);

		
		?>
		<div class="table-list-booking">
			<div class="el-notify">
				<p class="success status"></p>
				<p class="error status"></p>
			</div>
			<table>
				<thead class="event_head">
					<tr>
						<td class="id"><?php esc_html_e("ID", "eventlist") ?></td>
						<td><?php esc_html_e("Event", "eventlist") ?></td>
						<td><?php esc_html_e("Calendar Date", "eventlist") ?></td>
						<td><?php esc_html_e("Total", "eventlist") ?></td>
						<td><?php esc_html_e("Ticket Type", "eventlist") ?></td>
						<td><?php esc_html_e("Date Created", "eventlist") ?></td>
						<td><?php esc_html_e("Status", "eventlist") ?></td>
						<td><?php esc_html_e("Action", "eventlist") ?></td>
					</tr>
				</thead>
				<tbody class="event_body">
					<?php 
					if($list_bookings->have_posts() ) : while ( $list_bookings->have_posts() ) : $list_bookings->the_post();

						$id_booking = get_the_id();

						$status_booking = get_post_meta( $id_booking, OVA_METABOX_EVENT . 'status', true );
						switch( $status_booking ) {

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
								$status = esc_html( $status_booking );
								break;
							}
						}

						$id_event = get_post_meta( $id_booking, OVA_METABOX_EVENT . 'id_event', true );

						?>
						<tr class="<?php echo 'booking_'.get_the_id(); ?> ">
							<td data-colname="<?php esc_attr_e('ID', 'eventlist'); ?>" class="id"><?php echo esc_html(get_the_id()) ?></td>
							<td data-colname="<?php esc_attr_e('Event', 'eventlist'); ?>" >
								
								<a href=" <?php echo get_the_permalink( $id_event ); ?> " target="_blank">
									<?php echo esc_html(get_post_meta( $id_booking, OVA_METABOX_EVENT . 'title_event', true )) ?>
								</a>
									
							</td>
							<td data-colname="<?php esc_attr_e('Calendar Date', 'eventlist'); ?>" ><?php echo esc_html(get_post_meta( $id_booking, OVA_METABOX_EVENT . 'date_cal', true )); ?></td>
							
							<td data-colname="<?php esc_attr_e('Total', 'eventlist'); ?>" ><?php echo esc_html(el_price(get_post_meta( $id_booking, OVA_METABOX_EVENT . 'total_after_tax', true ))) ?></td>

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
							<td data-colname="<?php esc_attr_e('Date Created', 'eventlist'); ?>" >
								<?php
								$date_format = get_option('date_format');
								$time_format = get_option('time_format');
								echo get_the_date($date_format, $id_booking) . " - " . get_the_date($time_format, $id_booking);
								?>
							</td>
							<td data-colname="<?php esc_attr_e('Status', 'eventlist'); ?>" >
								<?php echo $status; ?>
							</td>
							<td>
								<?php if( get_post_meta( $id_booking, OVA_METABOX_EVENT.'status', true ) != 'Canceled' ){ ?>
									<div class="wp-button-my-booking">

										<div class="button-sendmail">
											<div class="submit-load-more sendmail">
												<div class="load-more">
													<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
												</div>
											</div>
											<button class="button create-ticket-send-mail" data-nonce="<?php echo wp_create_nonce( 'el_create_send_ticket_nonce' ); ?>" data-id-booking="<?php echo esc_attr($id_booking) ?>"><?php esc_html_e( "Send mail", "eventlist" ); ?></button>
										</div>

										<div class="button-dowload-ticket">
											<div class="submit-load-more dowload-ticket">
												<div class="load-more">
													<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
												</div>
											</div>
											<button class="button download-ticket" data-nonce="<?php echo wp_create_nonce( 'el_download_ticket_nonce' ); ?>" data-id-booking="<?php echo esc_attr($id_booking) ?>"><?php esc_html_e( "Download", "eventlist" ); ?></button>
										</div>

										<?php if( el_cancellation_booking_valid( $id_booking ) ){ ?>	
											<div class="button-cancel-booking">
												<div class="submit-load-more cancel-booking">
													<div class="load-more">
														<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
													</div>
												</div>
												<button class="button cancel-booking" data-nonce="<?php echo wp_create_nonce( 'el_cancel_booking_nonce' ); ?>" data-id-booking="<?php echo esc_attr($id_booking) ?>"><?php esc_html_e( "Cancel", "eventlist" ); ?></button>	
											</div>
										<?php } ?>	

									</div>
								<?php } ?>
							</td>
						</tr>
					<?php endwhile; else : ?> 
					<td colspan="8"><?php esc_html_e( 'Not Found Bookings', 'eventlist' ); ?></td> 
					<?php ; endif; wp_reset_postdata(); ?>

					
					<?php $total = $list_bookings->max_num_pages; ?>
					<?php if ( $total > 1 ) { ?>
						<td colspan="8">
							<?php echo pagination_vendor($total); ?>
						</td>			
					<?php } ?>

				</tbody>
			</table>
			
		</div>

	</div>
	
</div>
