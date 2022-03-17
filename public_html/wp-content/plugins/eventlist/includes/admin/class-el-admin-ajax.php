<?php 

defined( 'ABSPATH' ) || exit();

if( !class_exists( 'El_Admin_Ajax' ) ){

	class El_Admin_Ajax{
		
		public function __construct(){
			$this->init();
		}

		public function init(){

			// Define All Ajax function
			$arr_ajax =  array(
				'mb_add_social',
				'mb_add_ticket',
				'add_seat_map',
				'add_desc_seat_map',
				'mb_add_calendar',
				'mb_add_disable_date',
				'mb_add_coupon',
				'el_load_venue',
				'el_load_checklist_venue',
				'create_ticket_send_mail',
				'download_ticket',
				'unlink_download_ticket',
				'update_status_proccess',
				'add_custom_booking',
				'el_get_idcal_seatopt'
			);

			foreach($arr_ajax as $val){
				add_action( 'wp_ajax_'.$val, array( $this, $val ) );
				add_action( 'wp_ajax_nopriv_'.$val, array( $this, $val ) );
			}
		}

		public function update_status_proccess() {
			$id_event = isset($_POST['id_event']) ? sanitize_text_field($_POST['id_event']) : '';
			$status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '';

			if (empty($id_event) || empty($status) ) wp_die();

			if ($status == 'paid') {
				$status = 'paid';
			} else {
				$status = 'pending';
			}

			$time_current = current_time('timestamp');
			if (current_user_can('administrator')) {
				update_post_meta($id_event, OVA_METABOX_EVENT . 'status_pay', $status);
				update_post_meta($id_event, OVA_METABOX_EVENT . 'date_update', $time_current);
			}

			echo "success";
			
			wp_die();
		}


		public function download_ticket() {

			$id_booking = isset($_POST['id_booking']) ? sanitize_text_field($_POST['id_booking']) : "";

			$data = [];

			$status = get_post_meta($id_booking, OVA_METABOX_EVENT . "status", true);
			if ($status !== "Completed") {
				$data['status'] = 'error';
				$data['message'] = __("Please update booking status to Complete to send mail", "eventlist"); 
				echo json_encode($data);
				wp_die();
			}

			$arr_upload = wp_upload_dir();
			$base_url_upload = $arr_upload['baseurl'];

			if( empty($id_booking) || !isset( $_POST['el_download_ticket_nonce'] ) || !wp_verify_nonce( sanitize_text_field($_POST['el_download_ticket_nonce']), 'el_download_ticket_nonce' ) ) wp_die() ;

			$list_ticket_pdf_png = EL_Ticket::instance()->make_pdf_ticket_by_booking_id( $id_booking ) ;

			$list_url_ticket = [];
			if (is_array($list_ticket_pdf_png) && !empty($list_ticket_pdf_png)) {
				foreach($list_ticket_pdf_png as $ticket_pdf) {
					$position = strrpos($ticket_pdf, '/');
					$name = substr($ticket_pdf, $position);
					$list_url_ticket[] = $base_url_upload . $name;
				}
			}
			
			$data['status'] = 'success';
			$data['list_url_ticket'] = $list_url_ticket;

			echo json_encode($data);

			wp_die();
		}


		public function unlink_download_ticket() {
			$data = $_POST['data_url'];
			$arr_upload = wp_upload_dir();
			$basedir = $arr_upload['basedir'];

			$list_uri_ticket = [];
			if (is_array($data) && !empty($data)) {
				foreach($data as $ticket_pdf) {
					$position = strrpos($ticket_pdf, '/');
					$name = substr($ticket_pdf, $position);
					$list_uri_ticket[] = $basedir . $name;
				}
			}

			if (empty($list_uri_ticket) || !is_array($list_uri_ticket)) wp_die();
			$total_ticket_pdf = count($list_uri_ticket);
			if (!empty($list_uri_ticket) && is_array($list_uri_ticket)) {
				foreach ($list_uri_ticket as $key => $value) {
					if( $key < $total_ticket_pdf ){
						if (file_exists($value)) unlink($value);
					} 
				}
			}
			wp_die();
		}


		public function create_ticket_send_mail() {
			
			$id_booking = isset($_POST['id_booking']) ? sanitize_text_field($_POST['id_booking']) : "";

			if( empty($id_booking) || !isset( $_POST['el_create_send_ticket_nonce'] ) || !wp_verify_nonce( sanitize_text_field($_POST['el_create_send_ticket_nonce']), 'el_create_send_ticket_nonce' ) ) wp_die() ;

			$data = [];
			$status = get_post_meta($id_booking, OVA_METABOX_EVENT . "status", true);
			if ($status !== "Completed") {
				$data['status'] = 'error';
				$data['message'] = __("Please update booking status to Complete to send mail", "eventlist"); 
				echo json_encode($data);
				wp_die();
			}

			$list_id_ticket_by_booking = get_post_meta($id_booking, OVA_METABOX_EVENT . "list_id_ticket", true);
			
			$list_id_ticket_by_booking = json_decode($list_id_ticket_by_booking);
			$number_ticket_in_booking = count($list_id_ticket_by_booking);

			$args = [
				'post_type' => 'el_tickets',
				'post_status' => 'publish',
				'meta_query' => [
					[
						'key' => OVA_METABOX_EVENT . 'booking_id',
						'value' => $id_booking,
					],
				],
				'posts_per_page' => -1, 
				'numberposts' => -1,
				'nopaging' => true,
			];

			$ticket_record = get_posts($args);
			$number_ticket_record = count($ticket_record);
			if ($number_ticket_record == 0 && $number_ticket_in_booking > 0) {
				$data['message'] = __("Add Ticket and send mail success", "eventlist");
				EL_Ticket::instance()->add_ticket($id_booking);
				$result = el_sendmail_by_booking_id($id_booking, $order_status="", $receiver='customer');
			} else {
				$data['message'] = __("Send mail success", "eventlist");
				$result = el_sendmail_by_booking_id($id_booking, $order_status="", $receiver='customer');
			}

			if ($result) {
				$data['status'] = "success";
			} else {
				$data['status'] = "error";
				$data['message'] = __("Send mail failed", "eventlist");
			}
			
			echo json_encode($data);
			wp_die();
		}


		/* Load Venue */
		public static function el_load_venue() {
			$keyword = isset($_POST['keyword']) ? sanitize_text_field( $_POST['keyword'] ) : '';

			$the_query = new WP_Query( array( 'post_type' => 'venue' , 's' => $keyword, 'posts_per_page'=> '10') );
			?>

			<?php

			if( $the_query->have_posts() ) :
				while( $the_query->have_posts() ): $the_query->the_post();

					$title[] = get_the_title();

				endwhile;
				wp_reset_postdata();  
			endif;

			echo json_encode($title);

			wp_die();
		}


		/* Load checklist Venue */
		public static function el_load_checklist_venue() {
			$add_venue = isset( $_POST['add_venue'] ) ? sanitize_text_field( $_POST['add_venue'] ) : '';
			$list_venue = isset( $_POST['list_venue'] ) ? sanitize_text_field( $_POST['list_venue'] ) : '';

			$list_venue = substr($list_venue, 0, -1);

			$add_venue = array_map('ucwords', explode(', ', $add_venue));
			$list_venue = array_map('ucwords', explode(', ', $list_venue));

			foreach($add_venue as $key => $value) {
				$add_venue[$key] = str_replace(',', '', $value);
			}

			$result = array_unique(array_merge($add_venue, $list_venue));

			$_prefix = OVA_METABOX_EVENT;
			
			// remove empty array elements
			foreach($result as $key => $value) {
				if(empty($value)) {
					unset($result[$key]);
				}
			}

			foreach ($result as $key => $value) {
				
				?>
				<li>
					<input type="hidden" name="<?php echo esc_attr($_prefix.'venue['.$key.']'); ?>" value="<?php echo esc_attr($value); ?>">
					<i class="dashicons dashicons-dismiss remove_venue"></i>
					<span><?php echo esc_html($value); ?></span>
				</li>
				<?php
			}

			wp_die();
		}


		/* Add Social */
		public static function mb_add_social(){
			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = $_POST['data'];
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : '';
			$_prefix = OVA_METABOX_EVENT;
			?>
			<div class="social_item">
				<input type="text" name="<?php echo esc_attr($_prefix.'social_organizer['.$index.'][link_social]'); ?>" class="link_social" value="" placeholder="<?php echo esc_attr( 'https://' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
				<select name="<?php echo esc_attr($_prefix.'social_organizer['.$index.'][icon_social]'); ?>" class="icon_social">
					<?php foreach (el_get_social() as $key => $value) { ?>
						<option value="<?php echo esc_attr($key); ?>"><?php echo esc_html( $value ); ?></option>
					<?php } ?>
				</select>
				<a href="#" class="button remove_social"><?php esc_html_e( 'x', 'eventlist' ); ?></a>
			</div>

			<?php
			wp_die();
		}


		/* Add Ticket */
		public static function mb_add_ticket(){
			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = $_POST['data'];

			$seat_option = isset($post_data['seat_option']) ? sanitize_text_field( $post_data['seat_option'] ) : 'simple';

			$key = isset($post_data['count_tickets']) ? sanitize_text_field( $post_data['count_tickets'] ) : '1';

			$_prefix = OVA_METABOX_EVENT;
			$ticket = OVA_METABOX_EVENT.'ticket';

			

			$time = el_calendar_time_format();
			$format = el_date_time_format_js();
			
			$placeholder_dateformat = el_placeholder_dateformat();
			$placeholder_timeformat = el_placeholder_timeformat();

			?>

			<div class="ticket_item" data-prefix="<?php echo esc_attr($_prefix); ?>">

				<!-- Headding Ticket -->
				<div class="heading_ticket">
					<div class="left">
						<i class=" dashicons dashicons-tickets-alt"></i>
						<input type="text" 
						name="<?php echo esc_attr( $ticket.'['.$key.'][name_ticket]' ); ?>" 
						id="name_ticket" 
						value="" 
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
						name="<?php echo esc_attr( $ticket.'['.$key.'][ticket_id]' ); ?>"
						value=""
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
									<span> <input type="radio" name="<?php echo esc_attr( $ticket.'['.$key.'][type_price]' ) ?>" id="type_price" class="type_price" value="<?php echo esc_attr('paid'); ?>" <?php echo esc_attr('checked'); ?> > <?php esc_html_e( 'Paid', 'eventlist' ); ?> </span>

									<span> <input type="radio" name="<?php echo esc_attr( $ticket.'['.$key.'][type_price]' ) ?>" id="type_price" class="type_price" value="<?php echo esc_attr('free'); ?>"> <?php esc_html_e( 'Free', 'eventlist' ); ?> </span>

								</div>
							</div>

							<input type="text" 
							name="<?php echo esc_attr( $ticket.'['.$key.'][price_ticket]' ); ?>" 
							id="price_ticket" 
							value="<?php echo esc_attr(''); ?>" 
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
							name="<?php echo esc_attr( $ticket.'['.$key.'][number_total_ticket]' ); ?>" 
							id="number_total_ticket" 
							value="<?php echo esc_attr(''); ?>" 
							placeholder="<?php echo esc_attr('10'); ?>" 
							min="0"
							autocomplete="nope" autocorrect="off" autocapitalize="none"
							/>
						</div>

						<div class="col_min_number_ticket col">
							<div class="top">
								<strong><?php esc_html_e( 'Minimum ', 'eventlist' ); ?></strong>
								<span><?php esc_html_e( 'number of tickets for one purchase', 'eventlist' ); ?></span>
							</div>
							<input type="number" 
							name="<?php echo esc_attr( $ticket.'['.$key.'][number_min_ticket]' ); ?>"
							id="number_min_ticket" 
							value="<?php echo esc_attr( '' ); ?>" 
							placeholder="<?php echo esc_attr( '1' ); ?>" 
							min="0"
							autocomplete="nope" autocorrect="off" autocapitalize="none"
							/>
						</div>

						<div class="col_max_number_ticket col">
							<div class="top">
								<strong><?php esc_html_e( 'Maximum ', 'eventlist' ); ?></strong>
								<span><?php esc_html_e( 'number of tickets for one purchase', 'eventlist' ); ?></span>
							</div>
							<input type="number" 
							name="<?php echo esc_attr( $ticket.'['.$key.'][number_max_ticket]' ); ?>"
							id="number_max_ticket"
							value="<?php echo esc_attr( '' ); ?>" 
							placeholder="<?php echo esc_attr( '10' ); ?>" 
							min="0"
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
									name="<?php echo esc_attr( $ticket.'['.$key.'][start_ticket_date]' ); ?>" 
									class="start_ticket_date" 
									value="" 
									data-format="<?php echo esc_attr( $format ); ?>" 
									placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
									autocomplete="nope" autocorrect="off" autocapitalize="none"
									/>

									<input type="text" 
									name="<?php echo esc_attr( $ticket.'['.$key.'][start_ticket_time]' ); ?>" 
									id="start_ticket_time" 
									class="start_ticket_time" 
									value="" 
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
									name="<?php echo esc_attr( $ticket.'['.$key.'][close_ticket_date]' ); ?>" 
									class="close_ticket_date" 
									value="" 
									data-format="<?php echo esc_attr( $format ); ?>" 
									placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
									autocomplete="nope" autocorrect="off" autocapitalize="none"
									/>

									<input type="text" 
									name="<?php echo esc_attr( $ticket.'['.$key.'][close_ticket_time]' ); ?>" 
									id="close_ticket_time" 
									class="close_ticket_time" 
									value="" 
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
									name="<?php echo esc_attr( $ticket.'['.$key.'][color_ticket]' ); ?>" 
									id="color_ticket" 
									class="color_ticket" 
									value="<?php echo esc_attr( '#fff' ); ?>" 
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
									name="<?php echo esc_attr( $ticket.'['.$key.'][color_label_ticket]' ); ?>" 
									id="color_label_ticket" 
									class="color_label_ticket" 
									value="<?php echo esc_attr( '#fff' ); ?>" 
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
									name="<?php echo esc_attr( $ticket.'['.$key.'][color_content_ticket]' ); ?>" 
									id="color_content_ticket" 
									class="color_content_ticket" 
									value="<?php echo esc_attr( '#fff' ); ?>" 
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
						</div>
						<div class="content_desc">
							<textarea 
							name="<?php echo esc_attr( $ticket.'['.$key.'][desc_ticket]' ); ?>" 
							id="desc_ticket" 
							cols="30" rows="5"></textarea>

							<div class="image_ticket" data-index="<?php echo esc_attr($key); ?>">

								<div class="add_image_ticket">
									<input type="hidden" 
									name="<?php echo esc_attr($ticket.'['.$key.'][image_ticket]'); ?>" 
									id="image_ticket" 
									class="image_ticket" 
									value="" />
									<i class="icon_plus_alt2"></i>
									<?php esc_html_e('Add ticket logo (.jpg, .png)', 'eventlist') ?>
									<br/><span><?php esc_html_e( 'Recommended size: 130x50px','eventlist' ); ?></span>
								</div>
								<div class="remove_image_ticket"></div>
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
							name="<?php echo esc_attr( $ticket.'['.$key.'][private_desc_ticket]' ); ?>" 
							id="private_desc_ticket" 
							cols="30" rows="5"></textarea>
						</div>

						<div class="setting_ticket_online">
							<div class="title_add_desc">
								<small class="text_title"><?php esc_html_e( 'These info only display in mail', 'eventlist' ); ?><i class="arrow_triangle-down"></i></small>
							</div>
							<div class="online_field link">
								<label><?php esc_html_e( 'Link', 'eventlist' ); ?></label>
								<input type="text" id="online_link" name="<?php echo esc_attr( $ticket.'['.$key.'][online_link]' ); ?>" value="" />
							</div>
							<div class="online_field password">
								<label><?php esc_html_e( 'Password', 'eventlist' ); ?></label>
								<input type="text" id="online_password" name="<?php echo esc_attr( $ticket.'['.$key.'][online_password]' ); ?>" value="" />
							</div>
							<div class="online_field other">
								<label><?php esc_html_e( 'Other info', 'eventlist' ); ?></label>
								<input type="text" id="online_other" name="<?php echo esc_attr( $ticket.'['.$key.'][online_other]' ); ?>" value="" />
							</div>
							
						</div>
					</div>


					<!-- Seat List -->
					<div class="wrap_seat_list" style="<?php if ( $seat_option == 'simple' ) echo esc_attr('display: flex;') ?>">
						<label class="label"><strong><?php esc_html_e( 'Seat Code List:', 'eventlist' ); ?></strong></label>

						<textarea name="<?php echo esc_attr( $ticket.'['.$key.'][seat_list]' ); ?>" id="seat_list" class="seat_list" cols="30" rows="5" placeholder="<?php echo esc_attr( 'A1, B2, C3, ...' ); ?>" ></textarea>
					</div>


					<!-- The customer choose seat -->
					<div class="wrap_setup_seat" style="<?php if ( $seat_option == 'simple' ) echo esc_attr('display: flex;') ?>">
						<label class="label" for="setup_seat"><strong><?php esc_html_e( 'The customer choose seat:', 'eventlist' ); ?></strong></label>

						<span>
							<input type="radio" 
							name="<?php echo esc_attr($ticket.'['.$key.'][setup_seat]'); ?>"
							id="setup_seat" 
							value="yes" 
							<?php echo esc_attr('checked'); ?>
							/>
							<?php esc_html_e( 'Yes', 'eventlist' ); ?>
						</span>

						<span>
							<input 
							type="radio" 
							name="<?php echo esc_attr($ticket.'['.$key.'][setup_seat]'); ?>" 
							id="setup_seat" 
							value="no" 
							/>
							<?php esc_html_e( 'No', 'eventlist' ); ?>
						</span>
					</div>


					<!-- Save Ticket -->
					<a href="#" class="save_ticket"><?php esc_html_e('Done', 'eventlist') ?></a>
				</div>

			</div>

			<?php wp_die();		
		}


		/* Add Seat Map */
		public static function add_seat_map(){
			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = $_POST['data'];
			$key = isset($post_data['count_seat']) ? sanitize_text_field( $post_data['count_seat'] ) : '1';

			$_prefix = OVA_METABOX_EVENT;
			
			$currency = _el_symbol_price();


			?>
			<div class="item_seat" data-prefix="<?php echo esc_attr( $_prefix ); ?>">
				<div class="name_seat_map">
					<label><?php esc_html_e( 'Seat :', 'eventlist' ) ?></label>
					<input type="text" 
					class="map_name_seat" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'ticket_map[seat]['.$key.'][id]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( 'A1, A2, A3, ...', 'eventlist' ); ?>" 
					/>
				</div>

				<div class="price_seat_map">

					<label><?php esc_html_e( 'Price', 'eventlist' ) ?><?php echo ' ('. $currency .'):'; ?></label>
					<input type="text" 
					class="map_price_seat" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'ticket_map[seat]['.$key.'][price]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( '50.00', 'eventlist' ); ?>" 
					/>
				</div>

				<a href="#" class="button remove_seat_map"><?php esc_html_e( 'x', 'eventlist' ); ?></a>

			</div>
			<?php
			wp_die();
		}


		/* Add Description Seat Map */
		public static function add_desc_seat_map(){
			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = $_POST['data'];
			$key = isset($post_data['count_seat']) ? sanitize_text_field( $post_data['count_seat'] ) : '1';

			$_prefix = OVA_METABOX_EVENT;
			$currency = _el_symbol_price();

			?>

			<div class="item_desc_seat" data-prefix="<?php echo esc_attr( $_prefix ); ?>">
				<div class="item-col">
					<label><?php esc_html_e( 'Type Seat:', 'eventlist' ) ?></label>
					<input type="text" 
					class="map_type_seat" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'ticket_map[desc_seat]['.$key.'][map_type_seat]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr__( 'Standard', 'eventlist' ); ?>" 
					/>
				</div>

				<div class="item-col">
					<label>
						<?php esc_html_e( 'Price', 'eventlist' ) ?>
						<?php echo ' ('. $currency .'):'; ?>
					</label>
					<input type="text" 
					class="map_price_type_seat" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'ticket_map[desc_seat]['.$key.'][map_price_type_seat]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr__( '50.00', 'eventlist' ); ?>" 
					/>
				</div>

				<div class="item-col">
					<label><?php esc_html_e( 'Description:', 'eventlist' ) ?></label>
					<input type="text" 
					class="map_desc_type_seat" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'ticket_map[desc_seat]['.$key.'][map_desc_type_seat]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr__( 'Description of type seat', 'eventlist' ); ?>" 
					/>
				</div>

				<div class="item-col">
					<label><?php esc_html_e( 'Color:', 'eventlist' ) ?></label>
					<input type="text" 
					class="map_color_type_seat" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'ticket_map[desc_seat]['.$key.'][map_color_type_seat]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( '#ffffff', 'eventlist' ); ?>" 
					/>
				</div>
				<a href="#" class="button remove_desc_seat_map"><?php esc_html_e( 'x', 'eventlist' ); ?></a>
			</div>

			<?php
			wp_die();
		}


		/* Add Calendar */
		public static function mb_add_calendar(){
			if( !isset( $_POST['data'] ) ) wp_die();
			$_prefix = OVA_METABOX_EVENT;
			$post_data = $_POST['data'];
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : '';
			
			$time = el_calendar_time_format();
			$format = el_date_time_format_js();

			$placeholder_dateformat = el_placeholder_dateformat();
			$placeholder_timeformat = el_placeholder_timeformat();

			?>

			<div class="item_calendar">
				<input type="hidden" 
				class="calendar_id" 
				name="<?php echo esc_attr( $_prefix.'calendar['.$index.'][calendar_id]' ); ?>"
				value=""
				/>

				<div class="date">

					<label class="label"><strong><?php esc_html_e( 'Start Date:', 'eventlist' ); ?></strong></label>

					<input type="text" 
					class="calendar_date" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'calendar['.$index.'][date]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
					data-format="<?php echo esc_attr( $format ); ?>"
					/>

				</div>

				<div class="end_date">

					<label class="label"><strong><?php esc_html_e( 'End Date:', 'eventlist' ); ?></strong></label>

					<input type="text" 
					class="calendar_end_date" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'calendar['.$index.'][end_date]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
					data-format="<?php echo esc_attr( $format ); ?>"
					/>

				</div>


				<div class="start_time">
					<label class="label"><strong><?php esc_html_e( 'From:', 'eventlist' ); ?></strong></label>

					<input type="text" 
					class="calendar_start_time" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'calendar['.$index.'][start_time]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" data-time="<?php echo esc_attr( $time ); ?>" 
					data-time="<?php echo esc_attr( $time ); ?>"/>

				</div>


				<div class="end_time">
					<label class="label"><strong><?php esc_html_e( 'To:', 'eventlist' ); ?></strong></label>

					<input type="text" 
					class="calendar_end_time" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'calendar['.$index.'][end_time]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" data-time="<?php echo esc_attr( $time ); ?>" 
					data-time="<?php echo esc_attr( $time ); ?>"/>

				</div>
				<button class="button remove_calendar">x</button>
			</div>

			<?php
			wp_die();
		}


		/* Add Disable Date */
		public static function mb_add_disable_date(){
			if( !isset( $_POST['data'] ) ) wp_die();
			$_prefix = OVA_METABOX_EVENT;
			$post_data = $_POST['data'];
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : '';
			
			$time = el_calendar_time_format();
			$format = el_date_time_format_js();
			$placeholder_dateformat = el_placeholder_dateformat();
			$placeholder_timeformat = el_placeholder_timeformat();

			?>
			<div class="item_disable_date">

				<span>
					<?php esc_html_e( 'Form:', 'eventlist' ); ?>
					<input type="text" 
					class="start_date" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'disable_date['.$index.'][start_date]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
					data-format="<?php echo esc_attr( $format ); ?>"
					/>
				</span>

				<span>
					<?php esc_html_e( 'To:', 'eventlist' ); ?>
					<input type="text" 
					class="end_date" 
					value="" 
					name="<?php echo esc_attr( $_prefix.'disable_date['.$index.'][end_date]' ); ?>" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
					data-format="<?php echo esc_attr( $format ); ?>"
					/>
				</span>

				<button class="button remove_disable_date"><?php esc_html_e( 'x', 'eventlist' ) ?></button>
			</div>
			<?php
			wp_die();
		}


		/* Add Coupon */
		public static function mb_add_coupon() {
			if( !isset( $_POST['data'] ) ) wp_die();
			$_prefix = OVA_METABOX_EVENT;
			$post_data = $_POST['data'];
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : '';
			$post_id = isset( $post_data['post_id'] ) ? sanitize_text_field( $post_data['post_id'] ) : '';
			
			$time = el_calendar_time_format();
			$format = el_date_time_format_js();
			$placeholder_dateformat = el_placeholder_dateformat();
			$placeholder_timeformat = el_placeholder_timeformat();

			?>

			<div class="item_coupon">

				<input 
				type="hidden"  
				class="coupon_id" 
				name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][coupon_id]' ); ?>" 
				value="" 
				/>

				<div class="wrap_discount_code">
					<input 
					type="text"  
					class="discount_code" 
					name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][discount_code]' ); ?>" 
					value="" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php esc_attr_e( 'DISCOUNT CODE', 'eventlist' ); ?>" 
					/>

					<span class="least_char"><?php esc_html_e( 'Discount code must have at least 5 characters', 'eventlist' ); ?></span>

					<small class="comment_discount_code"><?php esc_html_e( 'Only alphanumeric characters allowed (A-Z and 0-9)', 'eventlist' ); ?></small>
				</div>

				<div class="discount_amount">
					<span><strong><?php esc_html_e( 'Discount Amount', 'eventlist' ); ?></strong></span>:&nbsp;

					<input 
					type="text" 
					class="discount_amout_number" 
					name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][discount_amout_number]' ); ?>" 
					value="" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php esc_attr_e( '5', 'eventlist' ); ?>" 
					/>
					
					<span><?php esc_html_e( '$', 'eventlist' ); ?></span>&nbsp;

					<span><?php esc_html_e( 'or', 'eventlist' ); ?></span>&nbsp;

					<input 
					type="text" 
					class="discount_amount_percent" 
					name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][discount_amount_percent]' ); ?>" 
					value="" 
					autocomplete="nope" autocorrect="off" autocapitalize="none" 
					placeholder="<?php esc_attr_e( '10', 'eventlist' ); ?>" />

					<span><?php esc_html_e( '% of ticket price', 'eventlist' ); ?></span>
				</div>

				<div class="discount_time">

					<div class="start_time">
						<span><strong><?php esc_html_e( 'Start', 'eventlist' ); ?></strong></span>

						<input type="text" 
						class="coupon_start_date" 
						name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][start_date]' ); ?>" 
						value=""
						autocomplete="nope" autocorrect="off" autocapitalize="none" 
						placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
						data-format="<?php echo esc_attr( $format ); ?>"
						/>

						<input type="text" 
						class="coupon_start_time" 
						name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][start_time]' ); ?>" 
						value="" 
						autocomplete="nope" autocorrect="off" autocapitalize="none" 
						placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" 
						data-time="<?php echo esc_attr( $time ); ?>" 
						/>
					</div>

					<div class="end_time">
						<span><strong><?php esc_html_e( 'End', 'eventlist' ); ?></strong></span>

						<input type="text" 
						class="coupon_end_date" 
						name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][end_date]' ); ?>" 
						value=""
						autocomplete="nope" autocorrect="off" autocapitalize="none" 
						placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
						data-format="<?php echo esc_attr( $format ); ?>"
						/>

						<input type="text" 
						class="coupon_end_time" 
						name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][end_time]' ); ?>" 
						value="" 
						autocomplete="nope" autocorrect="off" autocapitalize="none" 
						placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" 
						data-time="<?php echo esc_attr( $time ); ?>" 
						/>
					</div>
				</div>

				<div class="number_coupon_ticket">
					<span><strong><?php esc_html_e( 'Ticket types', 'eventlist' ); ?></strong></span>

					<div class="ticket">

						<div class="all_ticket">
							<input 
							type="checkbox"
							id="coupon_all_ticket" 
							class="coupon_all_ticket" 
							name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][all_ticket]' ); ?>" 
							value=""
							/>
							<label><?php esc_html_e( 'All ticket types', 'eventlist' ); ?></label>
						</div>

						<div class="all_quantity vendor_field">
							<label for="coupon_quantity"><?php esc_html_e( 'Quantity', 'eventlist' ); ?></label>
							<input 
							type="number"
							id="coupon_quantity" 
							class="coupon_quantity" 
							value="" 
							min="0" 
							name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][quantity]' ); ?>" 
							placeholder="<?php echo esc_attr( '100' ); ?>" 
							autocomplete="nope" autocorrect="off" autocapitalize="none"
							/>
						</div>

						<div class="wrap_list_ticket">
							<?php 
							$ticket = get_post_meta( $post_id, $_prefix.'ticket', true );
							if( $ticket ){
								foreach ($ticket as $key_ticket => $value_ticket) { ?>
									<div class="item_ticket">

										<label>
											<input 
											type="checkbox"
											class="list_ticket" 
											name="<?php echo esc_attr( $_prefix.'coupon['.$index.'][ticket]['.$key_ticket.']' ); ?>" 
											value="<?php echo esc_attr( isset( $value_ticket['ticket_id'] ) ? $value_ticket['ticket_id'] : '' ); ?>" 
											/> 

											<?php echo $value_ticket['name_ticket'] ?>
										</label>

									</div>
								<?php	} 
							} ?>
						</div>

					</div>

				</div>

				<button class="button remove_coupon"><?php esc_html_e( 'Remove Coupon', 'eventlist' ); ?></button>
			</div>

			<?php

			wp_die();
		}


		/* Add Booking */
		public function add_custom_booking() {
			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = $_POST['data'];
			$type_seat = isset( $post_data['type_seat'] ) ? sanitize_text_field( $post_data['type_seat'] ) : 'none';
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : 0;
			$_prefix = OVA_METABOX_EVENT;
			
			?>
			<tr class="cart-item">

				<td class="name">

					<a href="#" class="delete_item">x</a>

					<?php if ($type_seat == 'map') { ?>

						<input type="text" class="name" value="" name="<?php echo esc_attr( $_prefix.'cart['.$index.'][id]' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="<?php esc_html_e( 'seat code', 'eventlist' ) ?> " />

					<?php } else { ?>

						<input type="text" class="name" value="" name="<?php echo esc_attr( $_prefix.'cart['.$index.'][name]' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="<?php esc_html_e( 'ticket name', 'eventlist' ) ?> " />

					<?php } ?>
				</td>

				<td class="qty" <?php if($type_seat == 'map') echo esc_attr('style=display:none;'); ?> >
					
					<input type="number" class="qty" value="" min="1" name="<?php echo esc_attr( $_prefix.'cart['.$index.'][qty]' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="1" />

					<input type="text" class="seat" value="" name="<?php echo esc_attr( $_prefix.'cart['.$index.'][seat]' ); ?>" placeholder="<?php esc_attr_e('A1, A2, A3, ...', 'eventlist') ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" <?php if($type_seat == 'simple') echo esc_attr('required'); ?> <?php if($type_seat == 'none') echo esc_attr('style=display:none;'); ?> />

				</td>

				<td class="sub-total">

					<input type="text" class="price" value="" name="<?php echo esc_attr( $_prefix.'cart['.$index.'][price]' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" placeholder="<?php esc_html_e( '10.5', 'eventlist' ) ?> " />
					
				</td>
			</tr>

			<?php  

			wp_die();
		}

		public function el_get_idcal_seatopt(){

			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = $_POST['data'];
			$id_event = $post_data['id_event'];
			$id_cal = $post_data['id_cal'];

			$_prefix = OVA_METABOX_EVENT;

			$list_calendar =  get_arr_list_calendar_by_id_event( $id_event );

			$seat_option = get_post_meta( $id_event, $_prefix.'seat_option', true );
			
			?>
			<?php if( $list_calendar ){ ?>
				<label>
					<strong><?php esc_html_e( "Event Calendar",  "eventlist" ); ?>: </strong>
						<select name="<?php echo $_prefix.'id_cal' ?>" >
							<?php foreach ($list_calendar as $key => $value) { ?>
								<option value="<?php echo $value['calendar_id']; ?>" <?php echo selected( $value['calendar_id'], $id_cal ) ?>>
									<?php echo date_i18n( get_option( 'date_format' ), strtotime($value['date']) ); ?>
								</option>
							<?php } ?>
						</select>
					</label>
				<br><br>
				<input type="hidden" name="seat_option" class="seat_option" value="<?php echo $seat_option; ?>" />

				
					<?php if ( $seat_option == 'none' || $seat_option == 'simple' ) { ?>
						<div 
							class="detail_booking_head_cart" 
							data-name="<?php esc_html_e( 'Ticket', 'eventlist' ); ?>"
							data-qty="<?php esc_html_e( 'Quantity', 'eventlist' ); ?>"
							data-sub_total="<?php esc_html_e( 'Sub Total', 'eventlist' ); ?>"
						>
								
						</div>
						
					<?php } elseif ( $seat_option == 'map' ) { ?>

						<div 
							class="detail_booking_head_cart" 
							data-name="<?php esc_html_e( 'Seat Code', 'eventlist' ); ?>"
							data-sub_total="<?php esc_html_e( 'Sub Total', 'eventlist' ); ?>"
						>		
						</div>

						
					<?php } ?>
				

			<?php }else{ echo esc_html__( 'Please make Calendar for event', 'eventlist' ).'<br/><br/>'; } ?>

			<?php
			wp_die();
		}

	}

	new El_Admin_Ajax();

}

?>