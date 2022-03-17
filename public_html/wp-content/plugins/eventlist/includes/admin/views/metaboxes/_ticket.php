<?php if( !defined( 'ABSPATH' ) ) exit(); 
global $post;

$time = el_calendar_time_format();
$format = el_date_time_format_js();

$placeholder_dateformat = el_placeholder_dateformat();
$placeholder_timeformat = el_placeholder_timeformat();

$seat_option = $this->get_mb_value( 'seat_option', 'none' );
$value_ticket_map = $this->get_mb_value( 'ticket_map' );
$currency = _el_symbol_price();


$ticket_link = $this->get_mb_value( 'ticket_link', '' );
$ticket_external_link = $this->get_mb_value( 'ticket_external_link', '' );

?>
<div class="edit_ticket_info">
	<p><?php esc_html_e( 'if you don\'t want to sell ticket, you don\'t need to make ticket', 'eventlist' ); ?></p>
</div>

<?php if( apply_filters( 'el_show_ticket_link_opt', true ) ){ ?>
	<div class="ticket_link">

		<label><strong><?php esc_html_e( 'Buy ticket at', 'eventlist' ); ?>:</strong></label>

		
		<input type="radio" value="ticket_internal_link" name="<?php echo esc_attr( $this->get_mb_name( 'ticket_link' ) ) ?>" <?php if ( $ticket_link == 'ticket_internal_link' || $ticket_link == '') echo esc_attr('checked') ; ?> />
		<span><?php esc_html_e( 'Internal link', 'eventlist' ); ?></span>

		
		<input type="radio" value="ticket_external_link" name="<?php echo esc_attr( $this->get_mb_name( 'ticket_link' ) ) ?>" <?php if ( $ticket_link == 'ticket_external_link') echo esc_attr('checked') ; ?> />
		<span><?php esc_html_e( 'External Link', 'eventlist' ); ?></span>

	</div>
<?php } ?>

<?php if( apply_filters( 'el_show_ticket_external_link_field', true ) ){ ?>

	<div class="ticket_external_link">
		<label><?php esc_html_e( 'Insert external link', 'eventlist' ); ?></label>
		<input type="text" name="<?php echo esc_attr( $this->get_mb_name( 'ticket_external_link' ) ) ?>" value="<?php echo esc_url( $ticket_external_link ); ?>" placeholder="<?php esc_html_e( 'https://', 'eventlist' ); ?>">
	</div>

<?php } ?>


<?php if( apply_filters( 'el_show_ticket_internal_link_field', true ) ){ ?>

	<div class="ticket_internal_link">

		<!-- Seat Option -->
		<div class="wrap_seat_option">
			<label class="label"><strong><?php esc_html_e( 'Type:', 'eventlist' ); ?></strong></label>
			<div class="radio_seat_option">
				<span> <input type="radio" name="<?php echo esc_attr( $this->get_mb_name( 'seat_option' ) ) ?>" class="seat_option" value="<?php echo esc_attr('none'); ?>"  <?php if ( $seat_option == 'none' ||  $seat_option == '') echo esc_attr('checked') ; ?>  > <?php esc_html_e( 'No Seat', 'eventlist' ); ?> </span>

				<span> <input type="radio" name="<?php echo esc_attr( $this->get_mb_name( 'seat_option' ) ) ?>" class="seat_option" value="<?php echo esc_attr('simple'); ?>" <?php if ( $seat_option == 'simple') echo esc_attr('checked') ; ?> > <?php esc_html_e( 'Simple Seat', 'eventlist' ); ?> </span>

				<span> <input type="radio" name="<?php echo esc_attr( $this->get_mb_name( 'seat_option' ) ) ?>" class="seat_option" value="<?php echo esc_attr('map'); ?>" <?php if ( $seat_option == 'map') echo esc_attr('checked') ; ?> > <?php esc_html_e( 'Map', 'eventlist' ); ?> </span>
			</div>
		</div>


		<!-- Ticket items -->
		<div class="wrap">

			<!-- None - Simple -->
			<div class="ticket_none_simple" style="<?php echo esc_attr( $seat_option !== 'map' ? 'display: block;' : 'display: none;' ); ?>">
				<?php if ($this->get_mb_value( 'ticket' )) {
					foreach ($this->get_mb_value( 'ticket' ) as $key => $value) { 
						/* Check Name Ticket */
						if ( isset( $value['name_ticket'] ) ) { ?>

							<div class="ticket_item" data-prefix="<?php echo esc_attr(OVA_METABOX_EVENT); ?>" >

								<!-- Headding Ticket -->
								<div class="heading_ticket">
									<div class="left">
										<i class=" dashicons dashicons-tickets-alt"></i>
										<input type="text" 
										name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][name_ticket]' )); ?>" 
										id="name_ticket" 
										value="<?php echo esc_attr($value['name_ticket']); ?>" 
										placeholder="<?php esc_attr_e( 'Click to edit ticket name', 'eventlist' ); ?>" 
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										/>
									</div>
									<div class="right">
										<!-- <i class="dashicons dashicons-move move_ticket"></i> -->
										<i class="dashicons dashicons-edit edit_ticket"></i>
										<i class="dashicons dashicons-trash delete_ticket"></i>
									</div>
								</div>


								<!-- Content Ticket -->
								<div class="content_ticket">

									<!-- ID Ticket -->
									<div class="id_ticket">
										<label><strong><?php esc_html_e( 'SKU: *', 'eventlist' ); ?></strong></label>
										<input type="text" 
										id="ticket_id" 
										name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][ticket_id]' )); ?>"
										value="<?php echo esc_attr( isset( $value['ticket_id'] ) ? $value['ticket_id'] : '' ); ?>"
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										/>
										<span><?php esc_html_e( 'Auto render if empty', 'eventlist' ); ?></span>
									</div>

									<!-- Top Ticket -->
									<div class="top_ticket">

										<div class="col_price_ticket col">
											<div class="top">
												<span><strong><?php esc_html_e( 'Price', 'eventlist' ); ?></strong></span>

												<div class="radio_type_price">
													<span> <input type="radio" name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][type_price]' )) ?>" id="type_price" class="type_price" value="<?php echo esc_attr('paid'); ?>"  <?php checked( $value['type_price'], 'paid', 'checked' ); ?> > <?php esc_html_e( 'Paid', 'eventlist' ); ?> </span>

													<span> <input type="radio" name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][type_price]' )) ?>" id="type_price" class="type_price" value="<?php echo esc_attr('free'); ?>" <?php checked( $value['type_price'], 'free', 'checked' ); ?> > <?php esc_html_e( 'Free', 'eventlist' ); ?> </span>

												</div>
											</div>

											<input type="text" 
											name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][price_ticket]' )); ?>" 
											id="price_ticket" 
											<?php $price_ticket = !empty($value['price_ticket']) ? $value['price_ticket'] : 0 ?> 
											value="<?php echo esc_attr( $price_ticket ); ?>" 
											<?php if ($value['type_price'] == 'free') echo esc_attr('disabled'); ?>
											placeholder ="<?php esc_attr_e( '0', 'eventlist' ); ?>"
											autocomplete="nope" autocorrect="off" autocapitalize="none" 
											/>

										</div>

										<div class="col_total_number_ticket col">
											<div class="top">
												<strong><?php esc_html_e( 'Total ', 'eventlist' ); ?></strong>
												<span><?php esc_html_e( 'number of tickets', 'eventlist' ); ?></span>
											</div>
											<input type="number" 
											name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][number_total_ticket]' )); ?>" 
											id="number_total_ticket" 
											<?php $number_total_ticket = !empty($value['number_total_ticket']) ? $value['number_total_ticket'] : 1 ?> 
											value="<?php echo esc_attr( $number_total_ticket ); ?>" 
											placeholder="<?php echo esc_attr( '10', 'eventlist' ); ?>" 
											
											/>
										</div>

										<div class="col_min_number_ticket col">
											<div class="top">
												<strong><?php esc_html_e( 'Minimum ', 'eventlist' ); ?></strong>
												<span><?php esc_html_e( 'number of tickets for one purchase', 'eventlist' ); ?></span>
											</div>
											<input type="number" 
											name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][number_min_ticket]' )); ?>" 
											id="number_min_ticket"
											<?php $number_min_ticket = !empty($value['number_min_ticket']) ? $value['number_min_ticket'] : 1 ?> 
											value="<?php echo esc_attr( $number_min_ticket ); ?>" 
											placeholder="<?php echo esc_attr( '1', 'eventlist' ); ?>" 
											autocomplete="nope" autocorrect="off" autocapitalize="none" 
											/>
										</div>

										<div class="col_max_number_ticket col">
											<div class="top">
												<strong><?php esc_html_e( 'Maximum ', 'eventlist' ); ?></strong>
												<span><?php esc_html_e( 'number of tickets for one purchase', 'eventlist' ); ?></span>
											</div>
											<input type="number" 
											name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][number_max_ticket]' )); ?>" 
											id="number_max_ticket"
											<?php $number_max_ticket = !empty($value['number_max_ticket']) ? $value['number_max_ticket'] : 1 ?>
											value="<?php echo esc_attr( $number_max_ticket ); ?>" 
											placeholder="<?php echo esc_attr( '10', 'eventlist' ); ?>" 
											autocomplete="nope" autocorrect="off" autocapitalize="none" 
											/>
										</div>
									</div>


									<!-- Middle Ticket -->
									<div class="middle_ticket">
										<div class="date_ticket">
											<div class="start_date">
												<span><?php esc_html_e( 'Start date for selling tickets', 'eventlist' ); ?></span>
												<div>

													<input type="text" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][start_ticket_date]' )); ?>" 
													class="start_ticket_date" 
													value="<?php echo esc_attr( $value['start_ticket_date'] ); ?>" 
													data-format="<?php echo esc_attr( $format ); ?>" 
													placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
													autocomplete="nope" autocorrect="off" autocapitalize="none" 
													/>

													<input type="text" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][start_ticket_time]' )); ?>" 
													id="start_ticket_time" 
													class="start_ticket_time" 
													value="<?php echo esc_attr( $value['start_ticket_time'] ); ?>" 
													data-time="<?php echo esc_attr($time); ?>" 
													placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" 
													autocomplete="nope" autocorrect="off" autocapitalize="none" 
													/>
												</div>
											</div>

											<div class="end_date">
												<span><?php esc_html_e( 'End date for selling tickets', 'eventlist' ); ?></span>
												<div>

													<input type="text" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][close_ticket_date]' )); ?>" 
													class="close_ticket_date" 
													value="<?php echo esc_attr( $value['close_ticket_date'] ); ?>" 
													data-format="<?php echo esc_attr( $format ); ?>" 
													placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
													autocomplete="nope" autocorrect="off" autocapitalize="none" 
													/>

													<input type="text" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][close_ticket_time]' )); ?>" 
													id="close_ticket_time" 
													class="close_ticket_time" 
													value="<?php echo esc_attr( $value['close_ticket_time'] ); ?>" 
													data-time="<?php echo esc_attr($time); ?>" 
													placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" 
													autocomplete="nope" autocorrect="off" autocapitalize="none" 
													/>
												</div>
											</div>
										</div>

										<div class="wrap_color_ticket">
											<div>
												<div class="span9">
													<span><?php esc_html_e( 'Ticket border color', 'eventlist' ); ?></span>
													<small><?php esc_html_e( '(Color border in ticket)', 'eventlist' ); ?></small>
												</div>
												<div class="span3">
													<input type="text" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][color_ticket]' )); ?>" 
													id="color_ticket" 
													class="color_ticket" 
													value="<?php echo esc_attr( $value['color_ticket'] ); ?>" 
													autocomplete="nope" autocorrect="off" autocapitalize="none" 
													/>
												</div>

											</div>

											<div>
												<div class="span9">
													<span><?php esc_html_e( 'Ticket label color', 'eventlist' ); ?></span>
													<small><?php esc_html_e( '(Color label in ticket)', 'eventlist' ); ?></small>
												</div>
												<div class="span3">
													<input type="text" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][color_label_ticket]' )); ?>" 
													id="color_label_ticket" 
													class="color_label_ticket" 
													value="<?php echo esc_attr( $value['color_label_ticket'] ); ?>" 
													autocomplete="nope" autocorrect="off" autocapitalize="none" 
													/>
												</div>

											</div>

											<div>
												<div class="span9">
													<span><?php esc_html_e( 'Ticket content color', 'eventlist' ); ?></span>
													<small><?php esc_html_e( '(Color content in ticket)', 'eventlist' ); ?></small>
												</div>
												<div class="span3">
													<input type="text" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][color_content_ticket]' )); ?>" 
													id="color_content_ticket" 
													class="color_content_ticket" 
													value="<?php echo esc_attr( $value['color_content_ticket'] ); ?>" 
													autocomplete="nope" autocorrect="off" autocapitalize="none" 
													/>
												</div>

											</div>
										</div>
									</div>


									<!-- Bottom Ticket -->
									<div class="bottom_ticket">
										<div class="title_add_desc">
											<small class="text_title"><?php esc_html_e( 'Description display at frontend and PDF Ticket', 'eventlist' ); ?><i class="arrow_triangle-down"></i></small>
											<div>
												<small><?php esc_html_e( 'Description limited 230 character in ticket', 'eventlist' ); ?></small>
											</div>
										</div>
										<div class="content_desc">
											<textarea 
											name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][desc_ticket]' )); ?>" 
											id="desc_ticket" 
											cols="30" rows="5"><?php echo esc_attr( $value['desc_ticket'] ); ?></textarea>


											<div class="image_ticket" data-index='<?php echo esc_attr($key); ?>' >

												<div class="add_image_ticket">
													<input type="hidden" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][image_ticket]' )); ?>" 
													id="image_ticket" 
													value="<?php echo esc_attr( isset($value['image_ticket'])) ? $value['image_ticket'] : ''; ?>" 
													/>
													<?php if ( isset($value['image_ticket']) && $value['image_ticket'] != '' ) { ?>
														<img  class="image-preview-ticket" src="<?php echo esc_url(wp_get_attachment_url($value['image_ticket'])) ?>" alt="<?php esc_attr_e( 'image ticket', 'eventlist' ); ?>">
													<?php } else { ?>
														<i class="icon_plus_alt2"></i>
														<?php esc_html_e('Add ticket logo (.jpg, .png)', 'eventlist') ?>
														<br/><span><?php esc_html_e( 'Recommended size: 130x50px','eventlist' ); ?></span>
													<?php } ?>
												</div>
												<div class="remove_image_ticket">
													<?php if ( isset($value['image_ticket']) && $value['image_ticket'] != '' ) { ?>
														<span><?php esc_html_e( 'x', 'eventlist' ); ?></span>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="private_desc_ticket">
											<div class="title_add_desc">
												<small class="text_title">
													<?php esc_html_e( 'Private Description in Ticket - Only see when bought ticket', 'eventlist' ); ?>
													<i class="arrow_triangle-down"></i>
												</small>
											</div>
											<textarea 
											name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][private_desc_ticket]' )); ?>" 
											id="private_desc_ticket" 
											cols="30" rows="5"><?php echo isset( $value['private_desc_ticket'] ) ? $value['private_desc_ticket'] : ''; ?></textarea>
										</div>

										<div class="setting_ticket_online">
											<div class="title_add_desc">
												<small class="text_title"><?php esc_html_e( 'These info only display in mail', 'eventlist' ); ?><i class="arrow_triangle-down"></i></small>
											</div>
											<div class="online_field link">
												<label><?php esc_html_e( 'Link', 'eventlist' ); ?></label>
												<input type="text" id="online_link" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][online_link]' )); ?>"
													value="<?php echo isset( $value['online_link'] ) ? $value['online_link'] : ''; ?>" 
												/>
											</div>
											<div class="online_field password">
												<label><?php esc_html_e( 'Password', 'eventlist' ); ?></label>
												<input type="text" id="online_password" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][online_password]' )); ?>"
													value="<?php echo isset( $value['online_link'] ) ? $value['online_password'] : ''; ?>"
												/>
											</div>
											<div class="online_field other">
												<label><?php esc_html_e( 'Other info', 'eventlist' ); ?></label>
												<input type="text" id="online_other" 
													name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][online_other]' )); ?>"
													value="<?php echo isset( $value['online_link'] ) ? $value['online_other'] : ''; ?>"
												/>
											</div>
											
										</div>

									</div>


									<!-- Seat List -->
									<div class="wrap_seat_list" style="<?php if ( $this->get_mb_value( 'seat_option' ) == 'simple' ) echo esc_attr('display: flex;') ?>">
										<label class="label" for="seat_list"><strong><?php esc_html_e( 'Seat Code List:', 'eventlist' ); ?></strong></label>

										<textarea name="<?php echo esc_attr($this->get_mb_name( 'ticket['.$key.'][seat_list]' )); ?>" id="seat_list" class="seat_list" cols="30" rows="5" placeholder="<?php echo esc_attr( 'A1, B2, C3, ...' ); ?>" ><?php echo isset($value['seat_list']) ? esc_html( $value['seat_list'] ) : ''; ?></textarea>
									</div>


									<!-- The customer choose seat -->
									<div class="wrap_setup_seat" style="<?php if ( $this->get_mb_value( 'seat_option' ) == 'simple' ) echo esc_attr('display: flex;') ?>">
										<label class="label" for="setup_seat"><strong><?php esc_html_e( 'The customer choose seat:', 'eventlist' ); ?></strong></label>

										<span>
											<input type="radio" 
											name="<?php echo esc_attr($this->get_mb_name('ticket['.$key.'][setup_seat]')); ?>"
											id="setup_seat" 
											class="setup_seat" 
											value="yes" 
											<?php if(isset($value['setup_seat'])) checked( $value['setup_seat'], 'yes', 'checked' ); ?> 
											/>
											<?php esc_html_e( 'Yes', 'eventlist' ); ?>
										</span>

										<span>
											<input 
											type="radio" 
											name="<?php echo esc_attr($this->get_mb_name('ticket['.$key.'][setup_seat]')); ?>" 
											id="setup_seat" 
											class="setup_seat" 
											value="no" 
											<?php if(isset($value['setup_seat'])) checked( $value['setup_seat'], 'no', 'checked' ); ?> 
											/>
											<?php esc_html_e( 'No', 'eventlist' ); ?>
										</span>
									</div>

									<!-- Save Ticket -->
									<a href="#" class="save_ticket"><?php esc_html_e('Done', 'eventlist') ?></a>
								</div>
							</div>
						<?php }
					}
				} ?>
			</div>

			<!-- Map -->
			<div class="ticket_map" style="<?php echo esc_attr( $seat_option == 'map' ? 'display: block;' : 'display: none;' ); ?>" >
				
				<div class="top_content">
					<div class="short_code_map item-col">
						<label for="short_code_map"><?php esc_html_e( 'Map Shortcode', 'eventlist' ); ?></label>
						<input type="text" 
						name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[short_code_map]' ) ); ?>" 
						id="short_code_map"
						class="short_code_map"
						value="<?php echo esc_attr( isset($value_ticket_map['short_code_map'] ) ? $value_ticket_map['short_code_map'] : '' ); ?>" 
						placeholder="<?php echo esc_attr( '[short_code_map]', 'eventlist' ); ?>" 
						autocomplete="nope" autocorrect="off" autocapitalize="none" 
						/>
					</div>

					<div class="col_min_number_ticket item-col">
						<div class="top">
							<strong><?php esc_html_e( 'Minimum ', 'eventlist' ); ?></strong>
							<span><?php esc_html_e( 'number of tickets for one purchase', 'eventlist' ); ?></span>
						</div>
						<input type="number" 
						name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[number_min_ticket]' ) ); ?>" 
						id="number_min_ticket_map"
						id="number_min_ticket_map"
						value="<?php echo esc_attr( isset($value_ticket_map['number_min_ticket'] ) ? $value_ticket_map['number_min_ticket'] : 1 ); ?>" 
						placeholder="<?php echo esc_attr( '1', 'eventlist' ); ?>" 
						autocomplete="nope" autocorrect="off" autocapitalize="none" 
						min= "1"
						/>
					</div>

					<div class="col_max_number_ticket item-col">
						<div class="top">
							<strong><?php esc_html_e( 'Maximum ', 'eventlist' ); ?></strong>
							<span><?php esc_html_e( 'number of tickets for one purchase', 'eventlist' ); ?></span>
						</div>
						<input type="number" 
						name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[number_max_ticket]' ) ); ?>" 
						id="number_max_ticket_map"
						class="number_max_ticket_map"
						value="<?php echo esc_attr( isset($value_ticket_map['number_max_ticket'] ) ? $value_ticket_map['number_max_ticket'] : 1 ); ?>" 
						placeholder="<?php echo esc_attr( '10', 'eventlist' ); ?>" 
						autocomplete="nope" autocorrect="off" autocapitalize="none" 
						/>
					</div>
				</div>
				

				<hr>
				<div class="middle_content">
					<div class="date_ticket ova_row">
						<div class="start_date">
							<span><?php esc_html_e( 'Start date for selling tickets', 'eventlist' ); ?></span>
							<div>

								<input type="text" 
								name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[start_ticket_date]' ) ); ?>" 
								class="start_ticket_date_map" 
								value="<?php echo esc_attr( isset($value_ticket_map['start_ticket_date'] ) ? $value_ticket_map['start_ticket_date'] : '' ); ?>" 
								data-format="<?php echo esc_attr( $format ); ?>" 
								placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none" 
								/>

								<input type="text" 
								name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[start_ticket_time]' ) ); ?>" 
								class="start_ticket_time_map" 
								value="<?php echo esc_attr( isset($value_ticket_map['start_ticket_time'] ) ? $value_ticket_map['start_ticket_time'] : '' ); ?>" 
								data-time="<?php echo esc_attr($time); ?>" 
								placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none" 
								/>
							</div>
						</div>

						<div class="end_date">
							<span><?php esc_html_e( 'End date for selling tickets', 'eventlist' ); ?></span>
							<div>

								<input type="text" 
								name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[close_ticket_date]' ) ); ?>" 
								class="close_ticket_date_map" 
								value="<?php echo esc_attr( isset($value_ticket_map['close_ticket_date'] ) ? $value_ticket_map['close_ticket_date'] : '' ); ?>" 
								data-format="<?php echo esc_attr( $format ); ?>" 
								placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none" 
								/>

								<input type="text" 
								name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[close_ticket_time]' ) ); ?>" 
								class="close_ticket_time_map" 
								value="<?php echo esc_attr( isset($value_ticket_map['close_ticket_time'] ) ? $value_ticket_map['close_ticket_time'] : '' ); ?>" 
								data-time="<?php echo esc_attr($time); ?>" 
								placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none" 
								/>
							</div>
						</div>
					</div>

					<div class="wrap_color_ticket ova_row">
						<div>
							<div class="span9">
								<span><?php esc_html_e( 'Ticket border color', 'eventlist' ); ?></span>
								<small><?php esc_html_e( '(Color border in ticket)', 'eventlist' ); ?></small>
							</div>
							<div class="span3">
								<input type="text" 
								name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[color_ticket]' ) ); ?>" 
								id="color_ticket_map" 
								class="color_ticket_map" 
								value="<?php echo ( isset( $value_ticket_map['color_ticket'] ) && $value_ticket_map['color_ticket'] ) ? esc_attr($value_ticket_map['color_ticket']) : ''; ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none" 
								/>
							</div>
						</div>

						<div>
							<div class="span9">
								<span><?php esc_html_e( 'Ticket label color', 'eventlist' ); ?></span>
								<small><?php esc_html_e( '(Color label in ticket)', 'eventlist' ); ?></small>
							</div>
							<div class="span3">
								<input type="text" 
								name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[color_label_ticket]' ) ); ?>" 
								id="color_label_ticket_map" 
								class="color_label_ticket_map" 
								value="<?php echo isset( $value_ticket_map['color_label_ticket'] ) && $value_ticket_map['color_label_ticket'] ? $value_ticket_map['color_label_ticket'] : '' ; ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none" 
								/>
							</div>
						</div>

						<div>
							<div class="span9">
								<span><?php esc_html_e( 'Ticket content color', 'eventlist' ); ?></span>
								<small><?php esc_html_e( '(Color content in ticket)', 'eventlist' ); ?></small>
							</div>
							<div class="span3">
								<input type="text" 
								name="<?php echo esc_attr($this->get_mb_name( 'ticket_map[color_content_ticket]' )); ?>" 
								id="color_content_ticket_map" 
								class="color_content_ticket_map" 
								value="<?php echo isset( $value_ticket_map['color_content_ticket'] ) && $value_ticket_map['color_content_ticket'] ? $value_ticket_map['color_content_ticket'] : ''; ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none" 
								/>
							</div>
						</div>
					</div>
				</div>
				<hr>

				<!-- Bottom Ticket -->
				<div class="bottom_ticket">
					<div class="title_add_desc">
						<small class="text_title"><?php esc_html_e( 'Description display at frontend and PDF Ticket', 'eventlist' ); ?><i class="arrow_triangle-down"></i></small>
						<div>
							<small><?php esc_html_e( 'Description limited 230 character in ticket', 'eventlist' ); ?></small>
						</div>
					</div>
					<div class="content_desc">
						<textarea 
						name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[desc_ticket]' ) ); ?>" 
						class="desc_ticket_map" 
						cols="30" rows="5"><?php echo esc_attr( isset( $value_ticket_map['desc_ticket'] ) ? $value_ticket_map['desc_ticket'] : '' ) ; ?></textarea>


						<div class="image_ticket_map">

							<div class="add_image_ticket_map">
								<input type="hidden" 
								name="<?php echo esc_attr($this->get_mb_name( 'ticket_map[image_ticket]' )); ?>" 
								class="map_image_ticket" 
								value="<?php echo esc_attr( isset($value_ticket_map['image_ticket'])) ? $value_ticket_map['image_ticket'] : ''; ?>" 
								/>

								<?php if ( isset( $value_ticket_map['image_ticket'] ) && $value_ticket_map['image_ticket'] != '' ) { ?>
									<img  class="image-preview-ticket-map" src="<?php echo esc_url(wp_get_attachment_url( $value_ticket_map['image_ticket'] )) ?>" alt="<?php esc_attr_e( 'image ticket', 'eventlist' ); ?>">
								<?php } else { ?>
									<i class="icon_plus_alt2"></i>
									<?php esc_html_e('Add ticket logo (.jpg, .png)', 'eventlist') ?>
									<br/><span><?php esc_html_e( 'Recommended size: 130x50px','eventlist' ); ?></span>
								<?php } ?>
							</div>
							<div class="remove_image_ticket_map">
								<?php if ( isset( $value_ticket_map['image_ticket'] ) && $value_ticket_map['image_ticket'] != '' ) { ?>
									<span><?php esc_html_e( 'x', 'eventlist' ); ?></span>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="private_desc_ticket">
						<div class="title_add_desc">
							<small class="text_title">
								<?php esc_html_e( 'Private Description in Ticket - Only see when bought ticket', 'eventlist' ); ?>
								<i class="arrow_triangle-down"></i>
							</small>
						</div>
						<textarea 
						name="<?php echo esc_attr( $this->get_mb_name( 'ticket_map[private_desc_ticket_map]' ) ); ?>" 
						class="private_desc_ticket_map" 
						cols="30" rows="5">
						<?php echo esc_attr( isset( $value_ticket_map['private_desc_ticket_map'] ) ? $value_ticket_map['private_desc_ticket_map'] : '' ) ; ?>
						</textarea>
					</div>
				</div>
				<hr>
				
				<div class="container_desc_seat_map">
					<p style="font-weight: bold"><?php esc_html_e('Add description to these seat type:', 'eventlist'); ?></p>
					<div class="wrap_desc_seat_map">
						<?php if ( isset( $value_ticket_map['desc_seat'] ) && $value_ticket_map['desc_seat'] ) {
							foreach ( $value_ticket_map['desc_seat'] as $key => $value) { ?>
								<div class="item_desc_seat" data-prefix="<?php echo esc_attr( OVA_METABOX_EVENT ); ?>">
									<div class="item-col">
										<label><?php esc_html_e( 'Type Seat:', 'eventlist' ) ?></label>
										<input type="text" 
										class="map_type_seat" 
										value="<?php echo esc_attr( isset( $value['map_type_seat'] ) ? $value['map_type_seat'] : '' ); ?>" 
										name="<?php echo esc_attr( $this->get_mb_name('ticket_map[desc_seat]['.$key.'][map_type_seat]') ); ?>" 
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										placeholder="<?php echo esc_attr( 'Standard', 'eventlist' ); ?>" 
										/>
									</div>

									<div class="item-col">
										<label><?php esc_html_e( 'Price', 'eventlist' ) ?><?php echo ' ('. $currency .'):'; ?></label>
										<input type="text" 
										class="map_price_type_seat" 
										value="<?php echo esc_attr( isset( $value['map_price_type_seat'] ) ? $value['map_price_type_seat'] : '' ); ?>" 
										name="<?php echo esc_attr( $this->get_mb_name('ticket_map[desc_seat]['.$key.'][map_price_type_seat]') ); ?>" 
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										placeholder="<?php echo esc_attr( '50.00', 'eventlist' ); ?>" 
										/>
									</div>

									<div class="item-col">
										<label><?php esc_html_e( 'Description:', 'eventlist' ) ?></label>
										<input type="text" 
										class="map_desc_type_seat" 
										value="<?php echo esc_attr( isset( $value['map_desc_type_seat'] ) ? $value['map_desc_type_seat'] : '' ); ?>" 
										name="<?php echo esc_attr( $this->get_mb_name('ticket_map[desc_seat]['.$key.'][map_desc_type_seat]') ); ?>" 
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										placeholder="<?php echo esc_attr( 'Description of type seat', 'eventlist' ); ?>" 
										/>
									</div>

									<div class="item-col">
										<label><?php esc_html_e( 'Color:', 'eventlist' ) ?></label>
										<input type="text" 
										class="map_color_type_seat" 
										value="<?php echo esc_attr( isset( $value['map_color_type_seat'] ) ? $value['map_color_type_seat'] : '#fff' ); ?>" 
										name="<?php echo esc_attr( $this->get_mb_name('ticket_map[desc_seat]['.$key.'][map_color_type_seat]') ); ?>" 
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										placeholder="<?php echo esc_attr( '#ffffff', 'eventlist' ); ?>" 
										/>
									</div>

									<a href="#" class="button remove_desc_seat_map"><?php esc_html_e( 'x', 'eventlist' ); ?></a>
								</div>
							<?php }
						} ?>
					</div>

					<button class="button add_desc_seat_map">
						<?php esc_html_e( 'Add description seat', 'eventlist' ); ?>
						<div class="submit-load-more">
							<div class="load-more">
								<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
							</div>
						</div>
					</button>
				</div>
				<hr>

				<div class="container_seat_map">
					<div class="wrap_seat_map">
						<p style="font-weight: bold"><?php esc_html_e('Add Seat:', 'eventlist'); ?></p>
						<?php if ( isset( $value_ticket_map['seat'] ) && $value_ticket_map['seat'] ) {
							foreach ( $value_ticket_map['seat'] as $key => $value) { ?>
								<div class="item_seat" data-prefix="<?php echo esc_attr( OVA_METABOX_EVENT ); ?>">
									<div class="name_seat_map">
										<label><?php esc_html_e( 'Seat:', 'eventlist' ) ?></label>
										<input type="text" 
										class="map_name_seat" 
										value="<?php echo esc_attr($value['id']); ?>" 
										name="<?php echo esc_attr( $this->get_mb_name('ticket_map[seat]['.$key.'][id]') ); ?>" 
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										placeholder="<?php echo esc_attr( 'A1, A2, A3, ...', 'eventlist' ); ?>" 
										/>
									</div>

									<div class="price_seat_map">
										<label><?php esc_html_e( 'Price', 'eventlist' ) ?><?php echo ' ('. $currency .'):'; ?></label>
										<input type="text" 
										class="map_price_seat" 
										value="<?php echo esc_attr($value['price']); ?>" 
										name="<?php echo esc_attr( $this->get_mb_name('ticket_map[seat]['.$key.'][price]') ); ?>" 
										autocomplete="nope" autocorrect="off" autocapitalize="none" 
										placeholder="<?php echo esc_attr( '50.00', 'eventlist' ); ?>" 
										/>
									</div>

									<a href="#" class="button remove_seat_map"><?php esc_html_e( 'x', 'eventlist' ); ?></a>

								</div>
							<?php }
						} ?>
					</div>

					<button class="button add_seat_map">
						<?php esc_html_e( 'Add new seat', 'eventlist' ); ?>
						<div class="submit-load-more">
							<div class="load-more">
								<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
							</div>
						</div>
					</button>
				</div>
			</div>

		</div>

		<button class="button add_ticket" data-event_id="<?php echo esc_attr($post->ID) ?>" data-seat_option="<?php echo esc_attr($this->get_mb_value( 'seat_option' )); ?>" style="<?php echo esc_attr( $seat_option !== 'map' ? 'display: block;' : 'display: none;' ); ?>" >
			<?php esc_html_e( 'Add new ticket', 'eventlist' ); ?>
			<div class="submit-load-more">
				<div class="load-more">
					<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
				</div>
			</div>
		</button>

	</div>

<?php } ?>