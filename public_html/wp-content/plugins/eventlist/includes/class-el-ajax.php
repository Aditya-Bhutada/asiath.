<?php defined( 'ABSPATH' ) || exit;

if( !class_exists( 'El_Ajax' ) ){
	class El_Ajax{

		/**
		 * @var bool
		 */
		protected static $_loaded = false;

		public function __construct(){

			if ( self::$_loaded ) {
				return;
			}
			
			if (!defined('DOING_AJAX') || !DOING_AJAX)
				return;

			$this->init();

			self::$_loaded = true;
		}

		public function init(){

			// Define All Ajax function
			$arr_ajax =  array(
				'el_update_profile',
				'el_add_social',
				'el_save_social',
				'el_check_password',
				'el_change_password',
				'el_update_role',
				'el_process_checkout',
				'el_check_user_login',
				'el_check_login_report',

				'el_pending_post',
				'el_publish_post',
				'el_trash_post',
				'el_delete_post',
				'el_bulk_action',

				'el_check_discount',
				'add_image_gallery',
				'change_image_gallery',

				'el_load_location',
				'el_save_edit_event',

				
				'el_export_csv',
				'export_csv_ticket',
				'el_add_package',
				'el_add_wishlist',
				'el_remove_wishlist',
				'el_update_bank',
				'el_load_location_search',
				'el_search_map',
				'el_filter_elementor_grid',
				'el_single_send_mail_vendor',
				'el_single_send_mail_report',
				'el_update_ticket_status',
				'el_cancel_booking'

			);

			foreach($arr_ajax as $val){
				add_action( 'wp_ajax_'.$val, array( $this, $val ) );
				add_action( 'wp_ajax_nopriv_'.$val, array( $this, $val ) );
			}
		}

		// Update Ticket Status
		public static function el_update_ticket_status() {

			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];

			$qr_code = $post_data['qr_code'];
			$ticket_info = EL_Ticket::validate_qrcode( array( 'check_qrcode' => $qr_code ) );

			echo json_encode( $ticket_info );
			wp_die();

		}

		/* Save Profile */
		public static function el_update_profile() {

			if( !isset( $_POST['data'] ) ) wp_die();
			
			$post_data = $_POST['data'];
			$user_id = wp_get_current_user()->ID;
			if( !isset( $post_data['el_update_profile_nonce'] ) || !wp_verify_nonce( $post_data['el_update_profile_nonce'], 'el_update_profile_nonce' ) ) return ;
			
			$author_id_image = isset( $post_data['author_id_image'] ) ? sanitize_text_field( $post_data['author_id_image'] ) : '';
			$display_name    = isset( $post_data['display_name'] ) ? sanitize_text_field( $post_data['display_name'] ) : '';
			$user_job        = isset( $post_data['user_job'] ) ? sanitize_text_field( $post_data['user_job'] ) : '';
			$user_phone      = isset( $post_data['user_phone'] ) ? sanitize_text_field( $post_data['user_phone'] ) : '';
			$user_address    = isset( $post_data['user_address'] ) ? sanitize_text_field( $post_data['user_address'] ) : '';
			$description     = isset( $post_data['description'] ) ? sanitize_textarea_field( $post_data['description'] ) : '';


			$post_data = array( 
				'author_id_image' => $author_id_image,
				'display_name'    => $display_name,
				'user_job'        => $user_job,
				'user_phone'      => $user_phone,
				'user_address'    => $user_address,
				'description'     => $description,
			);

			foreach($post_data as $key => $value) {
				update_user_meta( $user_id, $key, $value );
			}
			
			return true;
			wp_die();
		}

		/* Add Social */
		public static function el_add_social() {

			if( !isset( $_POST['data'] ) ) wp_die();
			
			$post_data = $_POST['data'];
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : '';

			?>
			<div class="social_item vendor_field">
				<input type="text" name="<?php echo esc_attr('user_profile_social['.$index.'][link]'); ?>" class="link_social" value="" placeholder="<?php echo esc_attr( 'https://' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
				<select name="<?php echo esc_attr('user_profile_social['.$index.'][icon]'); ?>" class="icon_social">
					<?php foreach (el_get_social() as $key => $value) { ?>
						<option value="<?php echo esc_attr($key); ?>"><?php echo esc_html( $value ); ?></option>
					<?php } ?>
				</select>
				<button class="button remove_social">x</button>
			</div>
			<?php

			wp_die();
		}

		/* Save Social */
		public static function el_save_social() {

			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];
			$user_id = wp_get_current_user()->ID;
			if( !isset( $post_data['el_update_social_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_update_social_nonce'] ), 'el_update_social_nonce' ) ) return ;

			$post_data_sanitize = array();

			foreach ($post_data as $key => $value) {
				if ( is_array($value) ) {
					foreach ($value as $k1 => $v1) {
						$post_data_sanitize[$key][$k1][0] = esc_url_raw( $post_data[$key][$k1][0] );
						$post_data_sanitize[$key][$k1][1] = sanitize_text_field( $post_data[$key][$k1][1] );
					}
				} else {
					$post_data_sanitize[$key] = sanitize_text_field( $post_data[$key] );
				}
			}

			if ( !isset( $post_data_sanitize['user_profile_social'] ) ) {
				$post_data_sanitize['user_profile_social'] = array();
			}

			foreach($post_data_sanitize as $key => $value) {
				update_user_meta( $user_id, $key, $value );
			}

			wp_die();
		}

		/* Check password */
		public static function el_check_password() {

			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];
			$user_id = wp_get_current_user()->ID;
			$password_database = wp_get_current_user()->user_pass;
			
			$old_password = isset( $post_data['old_password'] ) ? sanitize_text_field( $post_data['old_password'] ) : '';

			if( wp_check_password( $old_password, $password_database, $user_id ) == true && $old_password != '' ) {
				echo ('true');
			} else {
				echo 'false';
			}
			wp_die();
		}

		/* Change password */
		public static function el_change_password() {

			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];
			
			if( !isset( $post_data['el_update_password_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_update_password_nonce'] ), 'el_update_password_nonce' ) ) return ;
			
			$user_id = wp_get_current_user()->ID;
			$password_database = wp_get_current_user()->user_pass;

			// if ( $user_id == username_exists('demo') ) return;

			$old_password = isset( $post_data['old_password'] ) ? sanitize_text_field( $post_data['old_password'] ) : '';
			$new_password = isset( $post_data['new_password'] ) ? sanitize_text_field( $post_data['new_password'] ) : '';
			
			if( wp_check_password( $old_password, $password_database, $user_id ) ) {
				wp_set_password( $new_password, $user_id );
				echo 'true';
			}
			wp_die();
		}

		/* Pending post */
		public static function el_pending_post() {

			$post_data = $_POST['data'];
			
			if( !isset( $_POST['data'] ) ) wp_die();

			if( !isset( $post_data['el_pending_post_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_pending_post_nonce'] ), 'el_pending_post_nonce' ) ) return ;
			
			$post_id = isset( $post_data['post_id'] ) ? sanitize_text_field( $post_data['post_id'] ) : '';

			if( !verify_current_user_post( $post_id ) || !el_can_edit_event() ) return false;

			$my_post = array(
				'ID'          => $post_id,
				'post_status' => 'pending',
			);
			wp_update_post( $my_post );

			return true;
		}

		/* Pending post */
		public static function el_trash_post() {

			$post_data = $_POST['data'];
			
			if( !isset( $_POST['data'] ) ) wp_die();

			if( !isset( $post_data['el_trash_post_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_trash_post_nonce'] ), 'el_trash_post_nonce' ) ) return ;

			$post_id = isset( $post_data['post_id'] ) ? sanitize_text_field( $post_data['post_id'] ) : '';

			if( !verify_current_user_post( $post_id ) || !el_can_edit_event() ) return false;

			wp_trash_post( $post_id );

			return true;
		}

		/* Pending post */
		public static function el_delete_post() {

			$post_data = $_POST['data'];
			
			if( !isset( $_POST['data'] ) ) wp_die();

			if( !isset( $post_data['el_delete_post_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_delete_post_nonce'] ), 'el_delete_post_nonce' ) ) return ;

			$post_id = isset( $post_data['post_id'] ) ? sanitize_text_field( $post_data['post_id'] ) : '';

			if( !verify_current_user_post( $post_id ) || !el_can_delete_event() ) return false;

			wp_delete_post( $post_id, false );

			return true;
		}

		/* Publish post */
		public static function el_publish_post() {

			$post_data = $_POST['data'];
			$_prefix = OVA_METABOX_EVENT;
			
			if( !isset( $_POST['data'] ) ) wp_die();

			if( !isset( $post_data['el_publish_post_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_publish_post_nonce'] ), 'el_publish_post_nonce' ) ) return ;
			
			$post_id = isset( $post_data['post_id'] ) ? sanitize_text_field( $post_data['post_id'] ) : '';
			

			if( !verify_current_user_post( $post_id ) ) return false;

			if ( el_can_publish_event() ) {

				$my_post = array(
					'ID'          => $post_id,
					'post_status' => 'publish',
				);
				wp_update_post( $my_post );

			} else {

				$event_active = get_post_meta( $post_id, $_prefix.'event_active', true );

				switch ( $event_active ) {
					case '1': 
					$my_post = array(
						'ID'          => $post_id,
						'post_status' => 'publish',
					);
					wp_update_post( $my_post );
					break;

					default:
					$my_post = array(
						'ID'          => $post_id,
						'post_status' => 'pending',
					);
					wp_update_post( $my_post );
					break;
				}
			}
			return true;
		}

		/* Delete post */
		public static function el_bulk_action() {

			$post_data = $_POST['data'];
			$_prefix = OVA_METABOX_EVENT;
			
			if( !isset( $_POST['data'] ) ) wp_die();
			
			if( !isset( $post_data['el_bulk_action_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_bulk_action_nonce'] ), 'el_bulk_action_nonce' ) ) return ;

			$post_id = array();
			foreach ($post_data['post_id'] as $key => $value) {
				$post_id[$key] = sanitize_text_field( $post_data['post_id'][$key] );
			}

			$value_select = isset( $post_data['value_select'] ) ? sanitize_text_field( $post_data['value_select'] ) : '';
			
			foreach ($post_id as $key => $value) {

				if( !verify_current_user_post( $value ) ) return false;

				if ( ( $value_select == 'pending' || $value_select == 'restore' ) && el_can_edit_event() ) {
					$my_post = array(
						'ID'          => $value,
						'post_status' => 'pending',
					);
					wp_update_post( $my_post );

				} elseif( $value_select == 'trash' && el_can_edit_event() ) {
					$my_post = array(
						'ID'          => $value,
						'post_status' => 'trash',
					);
					wp_update_post( $my_post );

				} elseif( $value_select == 'publish' ) {

					if ( el_can_publish_event() ) {

						$my_post = array(
							'ID'          => $value,
							'post_status' => 'publish',
						);
						wp_update_post( $my_post );

					} else {
						
						$event_active = get_post_meta( $post_id, $_prefix.'event_active', true );

						switch ( $event_active ) {
							case '1': 
							$my_post = array(
								'ID'          => $value,
								'post_status' => 'publish',
							);
							wp_update_post( $my_post );
							break;

							default:
							$my_post = array(
								'ID'          => $value,
								'post_status' => 'pending',
							);
							wp_update_post( $my_post );
							break;
						}
					}

				} elseif( $value_select == 'delete' && el_can_delete_event() ) {
					wp_delete_post( $value );
				}
			}
			return true;
		}

		/* Add image gallery */
		public static function add_image_gallery() {

			if( !isset( $_POST['data'] ) ) wp_die();
			
			$post_data = $_POST['data'];
			$attachment = $post_data['attachment'];
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : '';
			$_prefix = OVA_METABOX_EVENT;
			
			$el_thumbnail_path =  isset($attachment['sizes']['el_thumbnail']['url']) && $attachment['sizes']['el_thumbnail']['url'] ? $attachment['sizes']['el_thumbnail']['url'] : '';
			?>
			<div class="gallery_item">
				<input type="hidden" class="gallery_id" name="<?php echo esc_attr( $_prefix.'gallery['.$index.']' ); ?>" value="<?php echo esc_attr($attachment['id']); ?>">
				<?php if( $el_thumbnail_path ){ ?>
					<img class="image-preview" src="<?php echo esc_url($attachment['sizes']['el_thumbnail']['url']); ?>">
				<?php } ?>
				<a class="change_image_gallery button" href="#" data-uploader-title="<?php esc_attr_e( "Change image", 'eventlist' ); ?>" data-uploader-button-text="<?php esc_attr_e( "Change image", 'eventlist' ); ?>"><i class="fas fa-edit"></i></a>
				<a class="remove_image" href="#"><i class="far fa-trash-alt"></i></a>
			</div>
			<?php

			wp_die();
		}

		/* Change Image Gallery */
		public static function change_image_gallery() {

			if( !isset( $_POST['data'] ) ) wp_die();
			
			$post_data = $_POST['data'];
			$attachment = $post_data['attachment'];
			$index = isset( $post_data['index'] ) ? sanitize_text_field( $post_data['index'] ) : '';
			$_prefix = OVA_METABOX_EVENT;

			$el_thumbnail_path =  isset($attachment['sizes']['el_thumbnail']['url']) && $attachment['sizes']['el_thumbnail']['url'] ? $attachment['sizes']['el_thumbnail']['url'] : '';
			
			?>
			<input type="hidden" class="gallery_id" name="<?php echo esc_attr( $_prefix.'gallery['.$index.']' ); ?>" value="<?php echo esc_attr($attachment['id']); ?>">
			<?php if( $el_thumbnail_path ){ ?>
				<img class="image-preview" src="<?php echo esc_url($attachment['sizes']['el_thumbnail']['url']); ?>">
			<?php } ?>
			<a class="change_image_gallery button" href="#" data-uploader-title="<?php esc_attr_e( "Change image", 'eventlist' ); ?>" data-uploader-button-text="<?php esc_attr_e( "Change image", 'eventlist' ); ?>">
				<i class="fas fa-edit"></i></a>
			<a class="remove_image" href="#"><i class="far fa-trash-alt"></i></a>
			<?php

			wp_die();
		}

		/* Load location */
		public static function el_load_location() {
			
			if( !isset( $_POST['data'] ) ) wp_die();
			
			$post_data = $_POST['data'];
			$country = isset( $post_data['country'] ) ? sanitize_text_field( $post_data['country'] ) : '';
			$city_selected = isset( $post_data['city_selected'] ) ? sanitize_text_field( $post_data['city_selected'] ) : '';

			if ($country != '') {

				$country = get_term_by( 'slug', $country, 'event_loc' );
				
				$get_city = get_terms( 'event_loc', array( 'parent' => $country->term_id, 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false ) );
				
				?>	
				<option value=""><?php esc_html_e( 'All Cities', 'eventlist' ); ?></option> 
				<?php

				foreach ($get_city as $v_city) { ?>

					<option value="<?php echo esc_attr($v_city->slug); ?>" <?php echo esc_attr( $city_selected == $v_city->slug ? 'selected' : '' ); ?> ><?php echo esc_html($v_city->name); ?></option>

				<?php }

			} else {

				$parent_terms = get_terms( 'event_loc', array( 'parent' => 0, 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false ) ); 
				?>	
				<option value=""><?php esc_html_e( 'All Cities', 'eventlist' ); ?></option> 
				<?php

				foreach ( $parent_terms as $pterm ) {

					$terms = get_terms( 'event_loc', array( 'parent' => $pterm->term_id, 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false ) );
					?>

					<?php
					foreach ( $terms as $term ) { 
						?>
						<option value="<?php echo esc_attr($term->slug); ?>" <?php echo esc_attr( $city_selected == $term->slug ? 'selected' : '' ); ?> ><?php echo esc_html($term->name); ?></option>

					<?php	}
				}
			}

			wp_die();
		}

		/* Save Edit Event */
		public static function el_save_edit_event() {

			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];

			$_prefix = OVA_METABOX_EVENT;

			if( !isset( $post_data['el_edit_event_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_edit_event_nonce'] ), 'el_edit_event_nonce' ) ) return ;

			$current_user = get_current_user_id();

			$post_data_sanitize = array();
			foreach ($post_data as $key => $value) {

				if (!is_array($value)) {
					$post_data_sanitize[$_prefix.$key] = sanitize_text_field( $post_data[$key] );
				} else {
					foreach ($post_data[$key] as $k1 => $v1) {
						if (!is_array($v1)) {
							$post_data_sanitize[$_prefix.$key][$k1] = sanitize_text_field( $post_data[$key][$k1] );
						} else {
							foreach ($v1 as $k2 => $v2) {
								if (!is_array($v2)) {
									$post_data_sanitize[$_prefix.$key][$k1][$k2] = sanitize_text_field( $post_data[$key][$k1][$k2] );
								} else {
									foreach ($v2 as $k3 => $v3) {
										if (!is_array($v3)) {
											$post_data_sanitize[$_prefix.$key][$k1][$k2][$k3] = sanitize_text_field( $post_data[$key][$k1][$k2][$k3] );
										} else {
											foreach ($v3 as $k4 => $v4) {
												if (!is_array($v4)) {
													$post_data_sanitize[$_prefix.$key][$k1][$k2][$k3][$k4] = sanitize_text_field( $post_data[$key][$k1][$k2][$k3][$k4] );
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}

			$content_event = isset( $post_data['content_event'] ) ? wp_kses_post( $post_data['content_event'] ) : '';

			$post_id = isset( $post_data_sanitize[$_prefix.'post_id'] ) ? $post_data_sanitize[$_prefix.'post_id'] : '';
			$author_id = get_post_field( 'post_author', $post_id ) ? get_post_field( 'post_author', $post_id ) : '';

			$name_event = isset( $post_data_sanitize[$_prefix.'name_event'] ) ?  $post_data_sanitize[$_prefix.'name_event']  : '';
			
			$event_cat = isset( $post_data_sanitize[$_prefix.'event_cat'] ) ? $post_data_sanitize[$_prefix.'event_cat'] : '';

			$time_zone = isset( $post_data_sanitize[$_prefix.'time_zone'] ) ? $post_data_sanitize[$_prefix.'time_zone'] : '';

			$data_taxonomy = isset( $post_data_sanitize[$_prefix.'data_taxonomy'] ) ? $post_data_sanitize[$_prefix.'data_taxonomy'] : [];


			
			$check_allow_change_tax = check_allow_change_tax_by_event($post_id);
			$check_allow_change_tax_user = check_allow_change_tax_by_user_login();
			$enable_tax = EL()->options->tax_fee->get('enable_tax');

			
			
			$event_tag = isset( $post_data_sanitize[$_prefix.'event_tag'] ) ? $post_data_sanitize[$_prefix.'event_tag'] : array();

			$event_state = isset( $post_data_sanitize[$_prefix.'event_state'] ) ? $post_data_sanitize[$_prefix.'event_state'] : '';
			$event_city = isset( $post_data_sanitize[$_prefix.'event_city'] ) ? $post_data_sanitize[$_prefix.'event_city'] : '';
			
			$img_thumbnail = isset( $post_data_sanitize[$_prefix.'img_thumbnail'] ) ? sanitize_text_field( $post_data_sanitize[$_prefix.'img_thumbnail'] ) : '';

			
			if( isset( $post_data_sanitize[$_prefix.'venue'] ) && $post_data_sanitize[$_prefix.'venue'] ){
				foreach ( $post_data_sanitize[$_prefix.'venue'] as $value ) {

					$value = isset( $value ) ? sanitize_text_field( $value ) : '';

					if (!get_page_by_title( $value, OBJECT, 'venue' )) {
						$venue_info = array(
							'post_author' => $current_user,
							'post_title' => sanitize_text_field( $value ),
							'post_content' => '',
							'post_type' => 'venue',
							'post_status' => 'publish',
							'_thumbnail_id' => '',
						);

						wp_insert_post( $venue_info, true ); 
					}
				}
			}

			/* Check image thumbnail exits */
			if (!$img_thumbnail) {
				delete_post_thumbnail($post_id);
			}


			/* Check event_tax exits */
			if ( ( isset( $post_data_sanitize[$_prefix.'event_tax'] ) && !$post_data_sanitize[$_prefix.'event_tax'] ) || $check_allow_change_tax_user != 'yes' || $enable_tax != 'yes' ) {
				$post_data_sanitize[$_prefix.'event_tax'] = 0;
			}

			/* Check event_type exits */
			if ( ( isset( $post_data_sanitize[$_prefix.'event_type'] ) && !$post_data_sanitize[$_prefix.'event_type'] ) ) {
				$post_data_sanitize[$_prefix.'event_type'] = 'classic';
			}

			if ( ( isset( $post_data_sanitize[$_prefix.'ticket_link'] ) && !$post_data_sanitize[$_prefix.'ticket_link'] ) ) {
				$post_data_sanitize[$_prefix.'ticket_link'] = 'ticket_internal_link';
			}

			if ( ( isset( $post_data_sanitize[$_prefix.'ticket_external_link'] ) && !$post_data_sanitize[$_prefix.'ticket_external_link'] ) ) {
				$post_data_sanitize[$_prefix.'ticket_external_link'] = '';
			}

			/* Check social exits */
			if ( !isset( $post_data_sanitize[$_prefix.'social_organizer'] ) || !$post_data_sanitize[$_prefix.'social_organizer'] ) {
				$post_data_sanitize[$_prefix.'social_organizer'] = array();
			}

			/* Check image gallery exits */
			if ( !isset( $post_data_sanitize[$_prefix.'gallery'] ) || !$post_data_sanitize[$_prefix.'gallery'] ) {
				$post_data_sanitize[$_prefix.'gallery'] = array();
			}

			/* Check image banner exits */
			if ( !isset( $post_data_sanitize[$_prefix.'image_banner'] ) || !$post_data_sanitize[$_prefix.'image_banner'] ) {
				$post_data_sanitize[$_prefix.'image_banner'] = '';
			}		

			/* Check Ticket exits */
			if( !isset( $post_data_sanitize[$_prefix.'ticket'] ) || !$post_data_sanitize[$_prefix.'ticket'] ){
				$post_data_sanitize[$_prefix.'ticket'] = array();
			}

			/* Check calendar exits */
			if ( !isset( $post_data_sanitize[$_prefix.'calendar'] ) || !$post_data_sanitize[$_prefix.'calendar'] ) {
				$post_data_sanitize[$_prefix.'calendar'] = array();
			}

			/* Check Disable Date exits */
			if ( !isset( $post_data_sanitize[$_prefix.'disable_date'] ) || !$post_data_sanitize[$_prefix.'disable_date'] ) {
				$post_data_sanitize[$_prefix.'disable_date'] = array();
			}

			/* Check coupon exits */
			if ( !isset( $post_data_sanitize[$_prefix.'coupon'] ) || !$post_data_sanitize[$_prefix.'coupon'] ) {
				$post_data_sanitize[$_prefix.'coupon'] = array();
			}


			/* Check Venue exits */
			if( !isset( $post_data_sanitize[$_prefix.'venue'] ) || !$post_data_sanitize[$_prefix.'venue'] ){
				$post_data_sanitize[$_prefix.'venue'] = array();
			}

			/* Check recurrence bydays exits */
			if( !isset( $post_data_sanitize[$_prefix.'recurrence_bydays'] ) || !$post_data_sanitize[$_prefix.'recurrence_bydays'] ){
				$post_data_sanitize[$_prefix.'recurrence_bydays'] = array();
			}

			/* Check recurrence interval exits */
			if( !isset( $post_data_sanitize[$_prefix.'recurrence_interval'] ) || !$post_data_sanitize[$_prefix.'recurrence_interval'] ){
				$post_data_sanitize[$_prefix.'recurrence_interval'] = '1';
			}

			$k = 0;

			if( isset( $post_data_sanitize[$_prefix.'ticket'] ) && $post_data_sanitize[$_prefix.'ticket'] ){
				foreach ($post_data_sanitize[$_prefix.'ticket'] as $key => $value) {
					if ($value['ticket_id'] == '') {
						$post_data_sanitize[$_prefix.'ticket'][$key]['ticket_id'] = FLOOR(microtime(true)) + $k;
						$k++;
					}

					if ($value['setup_seat'] == '') {

						$post_data_sanitize[$_prefix.'ticket'][$key]['setup_seat'] =  'yes';

					}
				}
			}

			if( isset( $post_data_sanitize[$_prefix.'calendar'] ) && $post_data_sanitize[$_prefix.'calendar'] ){
				foreach ($post_data_sanitize[$_prefix.'calendar'] as $key => $value) {
					if ($value['calendar_id'] == '') {
						$post_data_sanitize[$_prefix.'calendar'][$key]['calendar_id'] = FLOOR(microtime(true)) + $k;
						$k++;
					}
					if ($value['date'] == '') {
						unset($post_data_sanitize[$_prefix.'calendar'][$key]);
					}
				}
			}

			if( isset( $post_data_sanitize[$_prefix.'coupon'] ) && $post_data_sanitize[$_prefix.'coupon'] ){
				foreach ($post_data_sanitize[$_prefix.'coupon'] as $key => $value) {
					if ($value['coupon_id'] == '') {
						$post_data_sanitize[$_prefix.'coupon'][$key]['coupon_id'] = FLOOR(microtime(true)) + $k;
						$k++;
					}
				}
			}

			/* Check checbox info organizer exits */
			if( !isset( $post_data_sanitize[$_prefix.'info_organizer'] ) || !$post_data_sanitize[$_prefix.'info_organizer'] ){
				$post_data_sanitize[$_prefix.'info_organizer'] = '';
			}else{
				$post_data_sanitize[$_prefix.'info_organizer'] = 'checked';
			}

			/* Check checbox info organizer exits */
			if( !isset( $post_data_sanitize[$_prefix.'edit_full_address'] ) || !$post_data_sanitize[$_prefix.'edit_full_address'] ){
				$post_data_sanitize[$_prefix.'edit_full_address'] = '';
			}else{
				$post_data_sanitize[$_prefix.'edit_full_address'] = 'checked';
			}

			/* Check Calendar Auto */ 
			if ( isset( $post_data_sanitize[$_prefix.'option_calendar'] ) && $post_data_sanitize[$_prefix.'option_calendar'] == 'auto' ) {
				$recurrence_days = get_recurrence_days(
					$post_data_sanitize[$_prefix.'recurrence_frequency'], 
					$post_data_sanitize[$_prefix.'recurrence_interval'], 
					$post_data_sanitize[$_prefix.'recurrence_bydays'], 
					$post_data_sanitize[$_prefix.'recurrence_byweekno'], 
					$post_data_sanitize[$_prefix.'recurrence_byday'], 
					$post_data_sanitize[$_prefix.'calendar_start_date'], 
					$post_data_sanitize[$_prefix.'calendar_end_date'] 
				);

				$post_data_sanitize[$_prefix.'calendar_recurrence'] = array();
				foreach ($recurrence_days as $value) {
					$post_data_sanitize[$_prefix.'calendar_recurrence'][] = [
						'calendar_id' => $value,
						'date' => date_i18n('Y-m-d', $value),
						'start_time' => $post_data_sanitize[$_prefix.'calendar_recurrence_start_time'],
						'end_time' => $post_data_sanitize[$_prefix.'calendar_recurrence_end_time'],
					];  
				}
			}


			/* Disable Date */
			$arr_disable_date = array();
			$total_key_disable_date = 0;
			if ( isset( $post_data_sanitize[$_prefix.'disable_date'] ) ) {
				foreach ($post_data_sanitize[$_prefix.'disable_date'] as $key => $value) {

					if ( $value['start_date'] == '' && $value['end_date'] != '' ) {
						$post_data_sanitize[$_prefix.'disable_date'][$key]['start_date'] =  $post_data_sanitize[$_prefix.'disable_date'][$key]['end_date'];
					}

					if ( $value['start_date'] != '' && $value['end_date'] == '' ) {
						$post_data_sanitize[$_prefix.'disable_date'][$key]['end_date'] =  $post_data_sanitize[$_prefix.'disable_date'][$key]['start_date'];
					}

					if ( $value['start_date'] == '' && $value['end_date'] == '' ) {
						unset( $post_data_sanitize[$_prefix.'disable_date'][$key] );
					}

					$total_key_disable_date = $key;
				}

				if( $total_key_disable_date ){
					for ($i = 0; $i <= $total_key_disable_date; $i++) {

						$number_date = ( strtotime( $post_data_sanitize[$_prefix.'disable_date'][$i]['end_date'] ) - strtotime( $post_data_sanitize[$_prefix.'disable_date'][$i]['start_date'] ) ) / 86400;

						for ( $x = 0; $x <= $number_date; $x++ ) {
							$arr_disable_date[] = strtotime( ($x).' days' , strtotime( $post_data_sanitize[$_prefix.'disable_date'][$i]['start_date'] ) );
						}

					}
				}
			}


			/* Remove date disabled */
			if( isset($post_data_sanitize[$_prefix.'calendar_recurrence']) && $post_data_sanitize[$_prefix.'calendar_recurrence'] ){
				foreach ($post_data_sanitize[$_prefix.'calendar_recurrence'] as $key => $value) {
					foreach ($arr_disable_date as $v_date) {
						if( $v_date == $value['calendar_id'] )	{
							unset($post_data_sanitize[$_prefix.'calendar_recurrence'][$key]);
						}
					}
				}
			}
			

			/* Date strtotime */
			$arr_start_date = array();
			$event_days = '';
			$arr_end_date = array();
			if ($post_data_sanitize[$_prefix.'option_calendar'] == 'manual') {
				if ( isset( $post_data_sanitize[$_prefix.'calendar'] ) ) {
					foreach ($post_data_sanitize[$_prefix.'calendar'] as $value) {
						$arr_start_date[] = strtotime( $value['date'] .' '. $value['start_time'] );
						$arr_end_date[] = strtotime( $value['date'] .' '. $value['end_time'] );
						$all_date_betweens_day = el_getDatesFromRange( date( 'Y-m-d', strtotime( $value['date'] ) ), date( 'Y-m-d', strtotime( $value['end_date'] )+24*60*60 ) );
						foreach ($all_date_betweens_day as $v) {
							$event_days .= $v.'-';
						}
					}
				}
			} else {
				if ( isset( $post_data_sanitize[$_prefix.'calendar_recurrence'] ) ) {
					foreach ($post_data_sanitize[$_prefix.'calendar_recurrence'] as $value) {
						$arr_start_date[] = strtotime( $value['date'] .' '. $value['start_time'] );
						$arr_end_date[] = strtotime( $value['date'] .' '. $value['end_time'] );
						$event_days .= strtotime( $value['date'] ).'-';
					}
				}
			}

			// store all days of event
			$post_data_sanitize[$_prefix.'event_days'] = $event_days;

			if ( $arr_start_date != array() )  {
				$post_data_sanitize[$_prefix.'start_date_str'] = max($arr_start_date);
			} else {
				$post_data_sanitize[$_prefix.'start_date_str'] = '';
			}
			

			if ( $arr_end_date != array() ) {
				$post_data_sanitize[$_prefix.'end_date_str'] = max($arr_end_date);
			} else {
				$post_data_sanitize[$_prefix.'end_date_str'] = '';
			}


			/* Remove empty field seat map */
			if( isset( $post_data_sanitize[$_prefix.'ticket_map']['seat'] ) && $post_data_sanitize[$_prefix.'ticket_map']['seat'] ){
				foreach ($post_data_sanitize[$_prefix.'ticket_map']['seat'] as $key => $value) {
					if ( $value['id'] == '' || $value['price'] == '' ) {
						unset($post_data_sanitize[$_prefix.'ticket_map']['seat'][$key]);
					}
				}
			}

			/* Remove empty field description seat map */
			if( isset( $post_data_sanitize[$_prefix.'ticket_map']['desc_seat'] ) && $post_data_sanitize[$_prefix.'ticket_map']['desc_seat'] ){
				foreach ($post_data_sanitize[$_prefix.'ticket_map']['desc_seat'] as $key => $value) {
					if ( $value['map_price_type_seat'] == '' || $value['map_type_seat'] == '' ) {
						unset($post_data_sanitize[$_prefix.'ticket_map']['desc_seat'][$key]);
					}
				}
			}

			/* Save Edit Post */
			if ( $post_id != '' ) {

				if( !el_can_edit_event() ) {echo 'error'; wp_die();}

				/* Location */
				$event_loc = array();
				if( $event_state && $event_state_obj = get_term_by('slug', $event_state, 'event_loc') ){
					$event_loc[] = $event_state_obj->term_id ? $event_state_obj->term_id : '';
				}

				if( $event_city && $event_city_obj = get_term_by('slug', $event_city, 'event_loc') ){
					$event_loc[] = $event_city_obj->term_id ? $event_city_obj->term_id : '';
				}
				

				if( !empty( $event_loc ) ){
					wp_set_post_terms( $post_id, array_filter( $event_loc ) , 'event_loc' );	
				}
				

				/* Cat */
				if( !empty( $event_cat ) ){
					wp_set_post_terms( $post_id, $event_cat , 'event_cat' );
				}


				/* Custom Taxonomy */
				if( ! empty( $data_taxonomy ) ){
					foreach( $data_taxonomy as $slug_taxonomy => $val_taxonomy ) {
						wp_set_post_terms( $post_id, $val_taxonomy , $slug_taxonomy );
					}
				}


				/* Tags */
				if( !empty( $event_tag ) ){
					wp_set_post_terms( $post_id, $event_tag , 'event_tag' );
				}

				/* Check event_tax exits */
				if ( !$post_data_sanitize[$_prefix.'event_tax'] || $check_allow_change_tax != 'yes' || $enable_tax != 'yes' ) {
					$post_data_sanitize[$_prefix.'event_tax'] = 0;
				}

				/* Update Pay Status */
				$post_data_sanitize[$_prefix.'status_pay'] = get_post_meta( $post_id, $_prefix.'status_pay', true ) ? get_post_meta( $post_id, $_prefix.'status_pay', true ) : 'pending';
				

				foreach ($post_data_sanitize as $key => $value) {

					update_post_meta( $post_id, $key, $value );
				}

				$post_info = get_post( $post_id );

				$post_information = array(
					'ID' => $post_id,
					'post_title' =>  $name_event,
					'post_name' => '',
					'post_content' => $content_event,
					'post_type' => 'event',
					'post_status' => $post_info->post_status,
					'_thumbnail_id' => $img_thumbnail,
				);

				if( wp_update_post( $post_information ) ){
					echo 'updated';	
				}else{
					echo 'error';
				}
				
				wp_die();

			} else { // Add new post

				// Check create event
				$check_create_event = el_check_create_event();
				switch ( $check_create_event['status'] ) {

					case 'false_total_event':
						echo 'false_total_event';
						wp_die();
						break;

					case 'false_time_membership':
						echo 'false_time_membership';
						wp_die();
						break;
						
					case 'error':
						echo 'error';
						wp_die();
						break;		
					
					default:
						break;
				}

				if( !el_can_publish_event() ){
					$event_status = 'pending';
					$post_data_sanitize[$_prefix.'event_active']   = 0;
				}else{
					$event_status = 'publish';
					$post_data_sanitize[$_prefix.'event_active']   = 1;
				}
				
				$post_data_sanitize['post_author']   = $current_user;
				$post_data_sanitize['post_title']    = $name_event;
				$post_data_sanitize['post_content']  = $content_event;
				$post_data_sanitize['post_type']     = 'event';
				$post_data_sanitize['post_status']   = apply_filters( 'el_admin_review_event', $event_status );
				$post_data_sanitize['_thumbnail_id'] = $img_thumbnail;

				$user_package = get_user_meta( $current_user, 'package', true );
				$post_data_sanitize[$_prefix.'package'] = $user_package;
				
				$new_post_id = wp_insert_post( $post_data_sanitize, true ); 

				//Cat
				if( !empty( $event_cat ) ){
					wp_set_post_terms( $new_post_id, $event_cat , 'event_cat' );
				}

				/* Custom Taxonomy */
				if( ! empty( $data_taxonomy ) ){
					foreach( $data_taxonomy as $slug_taxonomy => $val_taxonomy ) {
						wp_set_post_terms( $new_post_id, $val_taxonomy , $slug_taxonomy );
					}
				}

				// Tags
				if( !empty( $event_tag ) ){
					wp_set_post_terms( $new_post_id, $event_tag , 'event_tag' );
				}

				// Location
				$event_loc = array();
				if( $event_state && $event_state_obj = get_term_by('slug', $event_state, 'event_loc') ){
					$event_loc[] = $event_state_obj->term_id ? $event_state_obj->term_id : '';
				}

				if( $event_city && $event_city_obj = get_term_by('slug', $event_city, 'event_loc') ){
					$event_loc[] = $event_city_obj->term_id ? $event_city_obj->term_id : '';
				}

				wp_set_post_terms( $new_post_id, array_filter($event_loc) , 'event_loc' );

				/* Add New Status Pay */
				$post_data_sanitize[$_prefix.'status_pay'] = 'pending';

				foreach ($post_data_sanitize as $name => $value) {
					update_post_meta( $new_post_id, $name, $value );
				}

				// Send Mail Create Event
				$receive_email_after_create_event = EL()->options->mail->get('receive_email_after_create_event', 'no');
				if ( $receive_email_after_create_event != 'no' ) {
					el_sendmail_create_event( $new_post_id );
				}

				echo $new_post_id;
				wp_die();
			}
		}

		public function el_check_login_report(){
			$id_event = isset( $_POST['id_event'] ) ? sanitize_text_field( $_POST['id_event'] ) : '';
			if( is_user_logged_in() && $id_event ) {
				?>
				<div class="el_form_report">
				<form action="" >
					<div class="el_close">
						<span class="icon_close"></span>
					</div>
					<div class="el_row_input">
						<label for="el_message"><?php esc_html_e('Message', 'eventlist') ?></label>
						<textarea name="el_message" id="el_message" cols="30" rows="10"></textarea>
					</div>
					
					<div class="el-notify">
						<p class="success"><?php esc_html_e('Send mail success', 'eventlist') ?></p>
						<p class="error"><?php esc_html_e('Send mail failed', 'eventlist') ?></p>
						<p class="error-require"><?php esc_html_e('Please enter input field', 'eventlist') ?></p>
					</div>

					<div class="el_row_input">
						<button type="submit" class="submit-sendmail-report" data-id_event="<?php echo esc_attr( $id_event ) ?>" >
							<?php esc_html_e('Submit', 'eventlist') ?>
							<div class="submit-load-more">
								<div class="load-more">
									<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
								</div>
							</div>
						</button>
					</div>
				</form>
			</div>
			<?php
			} else {
				echo 'false';
			}
			wp_die();
		}

		/**
		 * Process Checkout
		 */
		public function el_check_user_login(){

			if( ! isset($_POST['data']) ) return false;
			if( !isset( $_POST['data']['el_next_event_nonce'] ) || !wp_verify_nonce( sanitize_text_field($_POST['data']['el_next_event_nonce']), 'el_next_event_nonce' ) ) return ;

			$setting_checkout_login = EL()->options->general->get('el_login_booking', 'no');

			if( $setting_checkout_login == 'yes' ) {
				if( is_user_logged_in() ) {
					echo 'true';
				} else {
					echo 'false';
				}
			} else {
				echo 'true';
			}

			wp_die();
		}

		/**
		 * Process Checkout
		 */
		public function el_process_checkout(){

			if( !isset( $_POST['data'] ) ) wp_die();
			return EL()->checkout->process_checkout( $_POST['data'] );
			wp_die();
		}

		/**
		 * Check discount
		 */
		public function el_check_discount() {

			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];
			$code_discount = sanitize_text_field( $post_data['code_discount'] );
			$id_event = sanitize_text_field( $post_data['id_event'] );
			$data = EL_Cart::instance()->check_code_discount($id_event, $code_discount);
			echo $data;
			wp_die();
		}

		public function el_export_csv() {
			if( ! isset( $_POST['data'] ) ) {
				return false;
				wp_die();
			}

			$data = isset($_POST['data']) ? $_POST['data'] : [];
			$id_event = isset($data['id_event']) ? sanitize_text_field($data['id_event']) : '';
			$check_allow_export_attendees = check_allow_export_attendees_by_event($id_event);
			if (!$id_event || !verify_current_user_post($id_event) || $check_allow_export_attendees != 'yes' || !el_can_manage_booking() ) wp_die();

			$check_id_booking = isset($data['check_id_booking']) ? sanitize_text_field($data['check_id_booking']) : false;
			$check_event = isset($data['check_event']) ? sanitize_text_field($data['check_event']) : false;
			$check_calendar = isset($data['check_calendar']) ? sanitize_text_field($data['check_calendar']) : false;
			$check_name = isset($data['check_name']) ? sanitize_text_field($data['check_name']) : false;
			$check_phone = isset($data['check_phone']) ? sanitize_text_field($data['check_phone']) : false;
			$check_email = isset($data['check_email']) ? sanitize_text_field($data['check_email']) : false;
			$check_total = isset($data['check_total']) ? sanitize_text_field($data['check_total']) : false;
			$check_status = isset($data['check_status']) ? sanitize_text_field($data['check_status']) : false;
			$check_ticket_type = isset($data['check_ticket_type']) ? sanitize_text_field($data['check_ticket_type']) : false;
			$check_date_create = isset($data['check_date_create']) ? sanitize_text_field($data['check_date_create']) : false;

			$list_ckf_check = isset($data['list_ckf_check']) ? $data['list_ckf_check'] : [];

			$list_ckf_output = get_option( 'ova_booking_form', array() );

			$csv_row = [];

			if ($check_id_booking != 'false') {
				$csv_row[0][] = esc_html__("Booking ID", "eventlist");
			}

			if ($check_event != 'false') {
				$csv_row[0][] = esc_html__("Event", "eventlist");
			}

			if ($check_calendar != 'false') {
				$csv_row[0][] = esc_html__("Calendar", "eventlist");
			}

			if ($check_name != 'false') {
				$csv_row[0][] = esc_html__("Name", "eventlist");
			}

			if ($check_phone != 'false') {
				$csv_row[0][] = esc_html__("Phone", "eventlist");
			}

			if ($check_email != 'false') {
				$csv_row[0][] = esc_html__("Email", "eventlist");
			}

			if ($check_total != 'false') {
				$csv_row[0][] = esc_html__("Total", "eventlist");
			}

			if ($check_status != 'false') {
				$csv_row[0][] = esc_html__("Status", "eventlist");
			}

			if ($check_ticket_type != 'false') {
				$csv_row[0][] = esc_html__("Ticket Type", "eventlist");
			}

			if ($check_date_create != 'false') {
				$csv_row[0][] = esc_html__("Date Created", "eventlist");
			}

			if( ! empty( $list_ckf_check ) && is_array( $list_ckf_check ) ) {
				$data_checkout_field = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'data_checkout_field', true );
				$arr_data_checkout_field = json_decode( $data_checkout_field, true );
				foreach( $list_ckf_check as $name_ckf ) {
					if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {
						foreach( $list_ckf_output as $key => $field ) {
							if(array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' && $name_ckf == $key ) {
								$csv_row[0][] = $field['label'];
							}
						}
					}
				}
				
			}


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
						"value" => apply_filters( 'el_export_booking_status', array( 'Completed' ) ),
						"between" => 'IN'
					],
				],
				'posts_per_page' => -1,
			];

			$list_booking_by_id_event = new WP_Query( $agrs );

			/* Write Data */
			$i = 0;
			if( $list_booking_by_id_event->have_posts() ): while( $list_booking_by_id_event->have_posts() ): $list_booking_by_id_event->the_post();

				global $post;
				$i++;

				if( $check_id_booking != 'false' ){
					$csv_row[$i][]= get_the_id();
				}

	    		// Event Name
				if( $check_event != 'false' ){
					$csv_row[$i][] = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'title_event', true );

				}

				// Calendar
				if( $check_calendar != 'false' ){
					$date = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'date_cal', true );
					$date = str_replace(",", " ", $date);
					$csv_row[$i][] = $date;
				}

				//Name Customer
				if( $check_name != 'false' ){
					$name = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'name', true );
					$name = str_replace(",", " ", $name);
					$csv_row[$i][] = $name;
				}

				//Phone Customer
				if( $check_phone != 'false' ){
					$phone = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'phone', true );
					$phone = str_replace(",", " ", $phone);
					$csv_row[$i][] = $phone;

				}

				//Email Customer
				if( $check_email != 'false' ){
					$email = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'email', true );
					$email = str_replace(",", " ", $email);
					$csv_row[$i][] = $email;

				}


				//Total Customer
				if( $check_total != 'false' ){
					$total_after_tax = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'total_after_tax', true );
					$total_after_tax = str_replace(",", " ", $total_after_tax);
					$csv_row[$i][] = $total_after_tax;

				}

				//status
				if( $check_status != 'false' ){
					$status = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'status', true );
					$status = str_replace(",", " ", $status);
					$csv_row[$i][] = $status;

				}

				//Ticket type
				if( $check_ticket_type != 'false' ){

					$list_ticket_in_event = get_post_meta( $id_event, OVA_METABOX_EVENT . 'ticket', true);

					$list_ticket = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'list_id_ticket', true );
					$list_ticket = json_decode($list_ticket);


					$ticket_name = "";
					if ( ! empty($list_ticket_in_event) && is_array($list_ticket_in_event) ) {
						foreach ($list_ticket_in_event as $ticket) {
							if ( in_array($ticket['ticket_id'], $list_ticket) ) {
								$ticket_name .= $ticket['name_ticket']."; ";
							}
						}
					}
					$ticket_name = str_replace(",", " ", $ticket_name);
					$ticket_name = substr(trim($ticket_name), 0, -1);
					$csv_row[$i][] = $ticket_name;

				}

				if( $check_date_create != 'false' ){
					$date_format = get_option('date_format');
					$time_format = get_option('time_format');
					$time = get_the_date($date_format, $id_booking) . " - " . get_the_date($time_format, $id_booking);

					$time = str_replace(",", " ", $time);

					$csv_row[$i][] = $time;
				}

				if( ! empty( $list_ckf_check ) && is_array( $list_ckf_check ) ){

					$data_checkout_field = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'data_checkout_field', true );
					$arr_data_checkout_field = json_decode( $data_checkout_field, true );

					foreach( $list_ckf_check as $name_ckf ) {
						if( ! empty( $arr_data_checkout_field ) && is_array( $arr_data_checkout_field ) ) {
							foreach( $list_ckf_output as $key => $field ) {
								if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {
									foreach( $arr_data_checkout_field as $key_1 => $value_1 ) {
										if( array_key_exists($key, $arr_data_checkout_field)  && array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' && $key_1 == $key && $name_ckf == $key ) {
											$csv_row[$i][] = $value_1;
										}
									}
								}
							}
						}
					}
				
				}

			endwhile;endif;

			echo json_encode($csv_row);
			wp_die();
		}

		public function export_csv_ticket() {
			if( ! isset( $_POST['data'] ) ) {
				return false;
				wp_die();
			}

			$data = isset($_POST['data']) ? $_POST['data'] : [];
			$id_event = isset($data['id_event']) ? sanitize_text_field($data['id_event']) : '';
			$check_allow_export_tickets = check_allow_export_tickets_by_event($id_event);

			if (!$id_event || !verify_current_user_post($id_event) || !el_can_manage_ticket() ) wp_die();

			$check_event = isset($data['check_event']) ? sanitize_text_field($data['check_event']) : false;
			$check_ticket_type = isset($data['check_ticket_type']) ? sanitize_text_field($data['check_ticket_type']) : false;
			$check_name = isset($data['check_name']) ? sanitize_text_field($data['check_name']) : false;
			$check_venue = isset($data['check_venue']) ? sanitize_text_field($data['check_venue']) : false;
			$check_address = isset($data['check_address']) ? sanitize_text_field($data['check_address']) : false;
			$check_seat = isset($data['check_seat']) ? sanitize_text_field($data['check_seat']) : false;
			$check_qr_code = isset($data['check_qr_code']) ? sanitize_text_field($data['check_qr_code']) : false;
			$check_start_date = isset($data['check_start_date']) ? sanitize_text_field($data['check_start_date']) : false;
			$check_end_date = isset($data['check_end_date']) ? sanitize_text_field($data['check_end_date']) : false;
			$check_date_create = isset($data['check_date_create']) ? sanitize_text_field($data['check_date_create']) : false;
			// $check_checkout_field = isset($data['check_checkout_field']) ? sanitize_text_field($data['check_checkout_field']) : false;

			$list_ckf_check = isset($data['list_ckf_check']) ? $data['list_ckf_check'] : [];

			$list_ckf_output = get_option( 'ova_booking_form', array() );


			$csv_row = [];

			if ($check_event != 'false') {
				$csv_row[0][] = esc_html__("Event", "eventlist");
			}

			if ($check_ticket_type != 'false') {
				$csv_row[0][] = esc_html__("Ticket Type", "eventlist");
			}

			if ($check_name != 'false') {
				$csv_row[0][] = esc_html__("Name", "eventlist");
			}

			if ($check_venue != 'false') {
				$csv_row[0][] = esc_html__("Venue", "eventlist");
			}

			if ($check_address != 'false') {
				$csv_row[0][] = esc_html__("Address", "eventlist");
			}

			if ($check_seat != 'false') {
				$csv_row[0][] = esc_html__("Seat", "eventlist");
			}

			if ($check_qr_code != 'false') {
				$csv_row[0][] = esc_html__("Qr Code", "eventlist");
			}

			if ($check_start_date != 'false') {
				$csv_row[0][] = esc_html__("Start date", "eventlist");
			}

			if ($check_end_date != 'false') {
				$csv_row[0][] = esc_html__("End date", "eventlist");
			}

			if ($check_date_create != 'false') {
				$csv_row[0][] = esc_html__("Date Created", "eventlist");
			}

			if( ! empty( $list_ckf_check ) && is_array( $list_ckf_check ) ) {
				$data_checkout_field = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'data_checkout_field', true );
				$arr_data_checkout_field = json_decode( $data_checkout_field, true );
				foreach( $list_ckf_check as $name_ckf ) {
					if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {
						foreach( $list_ckf_output as $key => $field ) {
							if(array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' && $name_ckf == $key ) {
								$csv_row[0][] = $field['label'];
							}
						}
					}
				}
				
			}




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
			];

			$list_ticket_record_by_id_event = new WP_Query( $agrs );


			/* Write Data */
			$i = 0;
			$date_format = get_option('date_format');
			$time_format = get_option('time_format');
			$str_data_ckf = '';

			if( $list_ticket_record_by_id_event->have_posts() ): while( $list_ticket_record_by_id_event->have_posts() ): $list_ticket_record_by_id_event->the_post();

				global $post;
				$i++;


	    		// Event Name
				if( $check_event != 'false' ){
					$csv_row[$i][] = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'name_event', true );

				}

				//Ticket type
				if( $check_ticket_type != 'false' ){
					$ticket_name = get_the_title( $post->ID );
					$ticket_name = str_replace(",", " ", $ticket_name);
					$csv_row[$i][] = $ticket_name;
				}

				//Name Customer
				if( $check_name != 'false' ){
					$name = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'name_customer', true );
					$name = str_replace(",", " ", $name);
					$csv_row[$i][] = $name;
				}

				//Venue
				if( $check_venue != 'false' ){
					$arr_venue = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'venue', true );
					$venue = is_array( $arr_venue ) ? implode("; ", $arr_venue) : $arr_venue;
					$venue = str_replace(",", " ", $venue);
					$csv_row[$i][] = $venue;
				}

				//Address
				if( $check_address != 'false' ){
					$address = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'address', true );
					$address = str_replace(",", " ", $address);
					$csv_row[$i][] = $address;
				}

				//Seat
				if( $check_seat != 'false' ){
					$seat = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'seat', true );
					$seat = str_replace(",", " ", $seat);
					$csv_row[$i][] = $seat;
				}

				//Qr code
				if( $check_qr_code != 'false' ){
					$qr_code = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'qr_code', true );
					$qr_code = str_replace(",", " ", $qr_code);
					$csv_row[$i][] = $qr_code;
				}

				//Date start
				if( $check_start_date != 'false' ){
					$date_start = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'date_start', true );
					$time_start = date_i18n($date_format, $date_start). " - " . date_i18n($time_format, $date_start);

					$time_start = str_replace(",", " ", $time_start);
					$csv_row[$i][] = $time_start;
				}

				//Date end
				if( $check_end_date != 'false' ){
					$date_end = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'date_end', true );
					$time_end = date_i18n($date_format, $date_end) . " - " . date_i18n($time_format, $date_end);

					$time_end = str_replace(",", " ", $time_end);
					$csv_row[$i][] = $time_end;
				}


				if( $check_date_create != 'false' ){

					$time = get_the_date($date_format, $post->ID) . " - " . get_the_date($time_format, $post->ID);

					$time = str_replace(",", " ", $time);

					$csv_row[$i][] = $time;
				}

				if( ! empty( $list_ckf_check ) && is_array( $list_ckf_check ) ){

					$data_checkout_field = get_post_meta( $post->ID, OVA_METABOX_EVENT . 'data_checkout_field', true );
					$arr_data_checkout_field = json_decode( $data_checkout_field, true );

					foreach( $list_ckf_check as $name_ckf ) {
						if( ! empty( $arr_data_checkout_field ) && is_array( $arr_data_checkout_field ) ) {
							foreach( $list_ckf_output as $key => $field ) {
								if( is_array( $list_ckf_output ) && ! empty( $list_ckf_output ) ) {
									foreach( $arr_data_checkout_field as $key_1 => $value_1 ) {
										if( array_key_exists($key, $arr_data_checkout_field)  && array_key_exists('enabled', $field) &&  $field['enabled'] == 'on' && $key_1 == $key && $name_ckf == $key ) {
											$csv_row[$i][] = $value_1;
										}
									}
								}
							}
						}
					}
				
				}


				

			endwhile;endif;
			echo json_encode($csv_row);
			wp_die();
		}

		public function el_add_package() {

			if( !isset( $_POST['data'] ) ) wp_die();


			$post_data = $_POST['data'];
			$user_id = wp_get_current_user()->ID;

			if( !$user_id ) { 
				echo json_encode( array(
					'code' => 0, 
					'status' => esc_html__('You have to login','eventlist'),
					'url'	=> wp_login_url()
				) ); wp_die(); 
			}

			$pid = isset( $post_data['pid'] ) ? (int)$post_data['pid'] : '';
			$package = get_post_meta( $pid, OVA_METABOX_EVENT.'package_id', true );


			if( $pid ){

				// Add to membership table
				$membership_id = EL_Package::instance()->add_membership( $pid, $user_id );

				if( $membership_id ){

					$fee_register_package = get_post_meta( $pid, OVA_METABOX_EVENT.'fee_register_package', true );

					if( $fee_register_package ){
						EL()->cart_session->remove();
						
						$product_id = EL()->options->package->get('product_payment_package'); //replace with your own product id

						if( class_exists('WooCommerce') ){
							WC()->cart->empty_cart();
						}

						$url = class_exists( 'WooCommerce' ) ? get_permalink( wc_get_page_id( 'cart' ) ): home_url('/');

						echo json_encode( array(
							'code' => $package,
							'status' => esc_html__('Added to membership table','eventlist'), 
							'url'	=>  add_query_arg( array(
								'add-to-cart' => $product_id,
								'membership_id' => $membership_id
							),
							$url )
						) );

					}else{
						
						update_user_meta( $user_id, 'package', $package );
						echo json_encode( array(
							'code' => $package,
							'status' => esc_html__('Update Success','eventlist'), 
							'url'	=>  add_query_arg( array( 
								'vendor' => 'package'
							),
							get_myaccount_page() )
						) );
					}



				}else{
					echo json_encode( array(
						'code' => 0, 
						'status' => esc_html__('Can\'t add membership' ,'eventlist'),
						'url'	=> get_myaccount_page()
					) );
				}
			}


			wp_die();
		}

		public function el_add_wishlist() {
			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = isset($_POST['data']) ? $_POST['data'] : [];
			$id_event = sanitize_text_field($post_data['id_event']);
			if (empty($id_event)) wp_die();

			$cookie_name = "el_wl_event";
			$cookie_value = json_encode([$id_event]);
			$current_time = current_time("timestamp");


			if (!isset($_COOKIE['el_wl_event'])) {
				setcookie($cookie_name, $cookie_value, $current_time + (86400 * 30), "/");
			} else {
				$value_cookie = $_COOKIE['el_wl_event'];
				$value_cookie = str_replace("\\", "", $value_cookie);
				$value_cookie = json_decode($value_cookie, true);

				if (!empty($value_cookie) && is_array($value_cookie) && !in_array($id_event, $value_cookie)) {
					array_push($value_cookie, $id_event);
				}

				$cookie_value = json_encode($value_cookie);
				setcookie($cookie_name, $cookie_value, $current_time + (86400 * 30), "/");

			}

			wp_die(); 
		}

		public function el_remove_wishlist() {
			if( !isset( $_POST['data'] ) ) wp_die();
			$post_data = isset($_POST['data']) ? $_POST['data'] : [];
			$id_event = sanitize_text_field($post_data['id_event']);

			$cookie_name = "el_wl_event";
			$current_time = current_time("timestamp");

			if (empty($id_event)) wp_die();

			if (isset($_COOKIE['el_wl_event'])) {

				$value_cookie = $_COOKIE['el_wl_event'];
				$value_cookie = str_replace("\\", "", $value_cookie);
				$value_cookie = json_decode($value_cookie, true);

				if (!empty($value_cookie) && is_array($value_cookie) && in_array($id_event, $value_cookie)) {
					$value_cookie = array_diff($value_cookie, [$id_event]);
				}
				if (empty($value_cookie)) {
					setcookie($cookie_name, $cookie_value, -3600, "/");
				} else {
					$cookie_value = json_encode($value_cookie);
					setcookie($cookie_name, $cookie_value, $current_time + (86400 * 30), "/");
				}

			}

			wp_die();
		}

		/* Update Bank */
		public static function el_update_bank() {

			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];

			$user_id = wp_get_current_user()->ID;

			if( !isset( $post_data['el_update_bank_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_update_bank_nonce'] ), 'el_update_bank_nonce' ) ) return ;

			$user_bank_owner  = isset( $post_data['user_bank_owner'] ) ? sanitize_text_field( $post_data['user_bank_owner'] ) : '';
			$user_bank_number = isset( $post_data['user_bank_number'] ) ? sanitize_user( $post_data['user_bank_number'] ) : '';
			$user_bank_name   = isset( $post_data['user_bank_name'] ) ? sanitize_text_field( $post_data['user_bank_name'] ) : '';
			$user_bank_branch = isset( $post_data['user_bank_branch'] ) ? sanitize_text_field( $post_data['user_bank_branch'] ) : '';
			$user_bank_routing = isset( $post_data['user_bank_routing'] ) ? sanitize_text_field( $post_data['user_bank_routing'] ) : '';
			$user_bank_paypal_email = isset( $post_data['user_bank_paypal_email'] ) ? sanitize_text_field( $post_data['user_bank_paypal_email'] ) : '';
			$user_bank_stripe_account = isset( $post_data['user_bank_stripe_account'] ) ? sanitize_text_field( $post_data['user_bank_stripe_account'] ) : '';

			$post_data = array( 
				'user_bank_owner'  => $user_bank_owner,
				'user_bank_number' => $user_bank_number,
				'user_bank_name'   => $user_bank_name,
				'user_bank_branch' => $user_bank_branch,
				'user_bank_routing' => $user_bank_routing,
				'user_bank_paypal_email' => $user_bank_paypal_email,
				'user_bank_stripe_account' => $user_bank_stripe_account,
			);

			foreach($post_data as $key => $value) {
				update_user_meta( $user_id, $key, $value );
			}
			echo true;
			wp_die();
		}

		/* Load Location Search */
		public static function el_load_location_search() {
			$keyword = isset($_POST['keyword']) ? sanitize_text_field( $_POST['keyword'] ) : '';

			$args = array(
				'taxonomy'   => 'event_loc',
				'orderby'    => 'id', 
				'order'      => 'ASC',
				'hide_empty' => false,
				'fields'     => 'all',
				'name__like' => $keyword,
			); 

			$terms = get_terms( $args );

			$count = count($terms);
			if($count > 0){
				$value = array();
				foreach ($terms as $term) {
					$value[] = $term->name;
				}
			}

			echo json_encode($value);

			wp_die();
		}

		public static function el_search_map() {
			if( !isset( $_POST['data'] ) ) wp_die();
			$_prefix = OVA_METABOX_EVENT;

			$post_data = $_POST['data'];

			$map_lat = isset( $post_data['map_lat'] ) ? (float) $post_data['map_lat'] : '';
			$map_lng = isset( $post_data['map_lng'] ) ? (float) $post_data['map_lng'] : '';
			$radius = isset( $post_data['radius'] ) ? (float)$post_data['radius'] : '';

			/***** Query Radius *****/
			$args_query_radius = array(
				'post_type' => 'event',
				'posts_per_page' => -1,
			);

			$the_query = new WP_Query( $args_query_radius );

			$results = array();

			$arr_distance = array();

			$posts = $the_query->get_posts();

			if ($map_lat != '' || $map_lng != '') {
				foreach($posts as $post)  {
					/* Latitude Longitude Search */
					$lat_search = deg2rad($map_lat);
					$lng_search = deg2rad($map_lng);

					/* Latitude Longitude Post */
					$lat_post = deg2rad(get_post_meta( $post->ID, OVA_METABOX_EVENT.'map_lat', true ));
					$lng_post = deg2rad(get_post_meta( $post->ID, OVA_METABOX_EVENT.'map_lng', true ));

					$lat_delta = $lat_post - $lat_search;
					$lon_delta = $lng_post - $lng_search;

					// $angle = 2 * asin(sqrt(pow(sin($lat_delta / 2), 2) + cos($lat_search) * cos($lat_post) * pow(sin($lon_delta / 2), 2)));
					$angle = acos(sin($lat_search) * sin($lat_post) + cos($lat_search) * cos($lat_post) * cos($lng_search - $lng_post));

					/* 6371 = the earth's radius in km */
					/* 3959 = the earth's radius in mi */
					$distance =  6371 * $angle;

					if( $distance <= $radius || !$map_lat ) {
						array_push($arr_distance, $distance);
						array_push( $results, $post->ID );
					}
				}

				wp_reset_postdata();
				array_multisort($arr_distance, $results);

			} else {
				foreach($posts as $post)  {
					array_push( $results, $post->ID );
				}
			}

			if ( $map_lat && !$results ) {
				$results = array('');
			}
			/***** End Query Radius *****/


			/***** Query Post in Radius *****/
			$orderby = EL()->options->event->get('archive_order_by') ? EL()->options->event->get('archive_order_by') : 'title';
			$order = EL()->options->event->get('archive_order') ? EL()->options->event->get('archive_order') : 'DESC';
			$listing_posts_per_page = EL()->options->event->get('listing_posts_per_page');
			$choose_week_end = EL()->options->general->get('choose_week_end') != null ? EL()->options->general->get('choose_week_end') : array('saturday', 'sunday');

			$keyword = isset( $post_data['keyword'] ) ? sanitize_text_field( $post_data['keyword'] ) : '';
			$cat = isset( $post_data['cat'] ) ? sanitize_text_field( $post_data['cat'] ) : '';
			$sort = isset( $post_data['sort'] ) ? sanitize_text_field( $post_data['sort'] ) : '';

			$name_venue = isset( $post_data['name_venue'] ) ? esc_html( $post_data['name_venue'] ) : '' ;
			$time = isset( $post_data['time'] ) ? sanitize_text_field( $post_data['time'] ) : '';
			$start_date = isset( $post_data['start_date'] ) ? sanitize_text_field( $post_data['start_date'] ) : '';
			$end_date = isset( $post_data['end_date'] ) ? sanitize_text_field( $post_data['end_date'] ) : '';

			$event_state = isset( $post_data['event_state'] ) ? esc_html( $post_data['event_state'] ) : '' ;
			$event_city = isset( $post_data['event_city'] ) ? esc_html( $post_data['event_city'] ) : '' ;

			$type = isset( $post_data['type'] ) ? sanitize_text_field( $post_data['type'] ) : '';
			$column = isset( $post_data['column'] ) ? sanitize_text_field( $post_data['column'] ) : '';

			$el_data_taxonomy_custom = isset( $post_data['el_data_taxonomy_custom'] ) ? sanitize_text_field( $post_data['el_data_taxonomy_custom'] )  : '';

			$el_data_taxonomy_custom = str_replace( '\\', '',  $el_data_taxonomy_custom);
			if( $el_data_taxonomy_custom ){
				$el_data_taxonomy_custom = json_decode($el_data_taxonomy_custom, true);

			}




			$paged = isset( $post_data['paged'] ) ? (int)$post_data['paged']  : 1;

			$filter_events = EL()->options->event->get('filter_events', 'all');
			$current_time = current_time('timestamp');

			$args_base = array(
				'post_type'      => 'event',
				'post_status'    => 'publish',
				'paged'          => $paged,
				'posts_per_page' => $listing_posts_per_page,
			);

			$args_order =  array( 'order' => 'DESC' );

			switch ($sort) {

				case '':
				switch ( $orderby ) {
					case 'title':
					$args_orderby =  array( 'orderby' => 'title' );
					break;

					case 'start_date':
					$args_orderby =  array( 'orderby' => 'meta_value_num', 'meta_key' => $_prefix.'start_date_str' );
					break;

					case 'ID':
					$args_orderby =  array( 'orderby' => 'ID');
					break;

					default:
					break;
				}
				$args_order =  array( 'order' => $order );
				break;

				case 'date-desc':
				$args_orderby =  array( 'orderby' => 'date' );
				break;

				case 'date-asc':
				$args_orderby = array( 'orderby' => 'date' );
				$args_order = array( 'order' => 'ASC' );
				break;

				case 'near':
				$args_orderby = array( 'orderby' => 'post__in');
				$args_order = array( 'order' => 'ASC' );
				break;

				case 'start-date':
				$args_orderby = array( 'orderby' => 'meta_value', 'meta_key' => $_prefix.'start_date_str' );
				$args_order = array( 'order' => 'ASC' );
				break;

				case 'end-date':
				$args_orderby = array( 'orderby' => 'meta_value', 'meta_key' => $_prefix.'end_date_str' );
				$args_order = array( 'order' => 'ASC' );
				break;

				case 'a-z':
				$args_orderby = array( 'orderby' => 'title');
				$args_order = array( 'order' => 'ASC' );
				break;

				case 'z-a':
				$args_orderby = array( 'orderby' => 'title');
				break;

				default:
				break;
			}

			$args_basic = array_merge_recursive( $args_base, $args_order, $args_orderby );

			$args_radius = $args_name = $args_cat = $args_time = $args_date = $args_venue = $args_state = $args_city = $args_filter_events = array();

			// Query Result
			if ( $results ) {
				$args_radius = array( 'post__in' => $results );
			}

			// Query Keyword
			if( $keyword ){
				$args_name = array( 's' => $keyword );
			}

			// Query Categories
			if($cat){
				$args_cat = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'event_cat',
							'field'    => 'slug',
							'terms' => $cat
						)
					)
				);
			}


			//Query Custom Taxonomy
			$arg_taxonomy_arr = [];
			if( $el_data_taxonomy_custom ) {
				$arg_taxonomy_arr = [];
			    if ( ! empty( $el_data_taxonomy_custom ) ) {
			        foreach( $el_data_taxonomy_custom as $taxo => $value_taxo ) {
			        	if( ! empty( $value_taxo ) ) {
			        		$arg_taxonomy_arr[] = array(
		                		'taxonomy' => $taxo,
			                    'field' => 'slug',
			                    'terms' => $value_taxo
			                );
			        	}
			        }
			    }

			    if( !empty($arg_taxonomy_arr) ){
			        $arg_taxonomy_arr = array(
			            'tax_query' => $arg_taxonomy_arr
			        );
			    }
			}


			// Query Time
			if($time){

				$date_format = 'Y-m-d 00:00';
				$today_day = current_time( $date_format);

				// Return number of current day
				$num_day_current = date('w', strtotime( $today_day ) );

				// Check start of week in wordpress
				$start_of_week = get_option('start_of_week');

				// This week
				$week_start = date( 'Y-m-d', strtotime($today_day) - ( ($num_day_current - $start_of_week) *24*60*60) );
				$week_end = date( 'Y-m-d', strtotime($today_day)+ (7 - $num_day_current + $start_of_week )*24*60*60 );
				$this_week = el_getDatesFromRange( $week_start, $week_end );
				$this_week_regexp = implode($this_week, '|');
				

				// Get Saturday in this week
				$saturday = strtotime( date($date_format, strtotime('this Saturday')));
				// Get Sunday in this week
				$sunday = strtotime( date( $date_format, strtotime('this Sunday')));
				// Weekend
				$week_end = el_getDatesFromRange( date( 'Y-m-d', $saturday ), date( 'Y-m-d', $sunday ) );
				$week_end_regexp = implode($week_end, '|');
				


				// Next week Start
				$next_week_start = strtotime($today_day)+ (7 - $num_day_current + $start_of_week )*24*60*60;
				// Next week End
				$next_week_end = $next_week_start+7*24*60*60;
				
				// Next week
				$next_week = el_getDatesFromRange( date( 'Y-m-d', $next_week_start ), date( 'Y-m-d', $next_week_end ) );
				$next_week_regexp = implode($next_week, '|');
				

				// Month Current
				$num_day_current = date('n', strtotime( $today_day ) );

				// First day of next month
				$first_day_next_month = strtotime( date( $date_format, strtotime('first day of next month') ) );
				$last_day_next_month = strtotime ( date( $date_format, strtotime('last day of next month') ) )+24*60*60+1;
				// Next month
				$next_month = el_getDatesFromRange( date( 'Y-m-d', $first_day_next_month ), date( 'Y-m-d', $last_day_next_month ) );
				$next_month_regexp = implode($next_month, '|');
				
				
				

				switch ($time) {
					case 'today':
					$args_time = array(
						'meta_query' => array(
							array(
								'key' => $_prefix.'event_days',
								'value' => strtotime($today_day),
								'compare' => 'LIKE'	
							),
						)
					);

					break;

					case 'tomorrow':
					$args_time = array(
						'meta_query' => array(
							array(
								'key' => $_prefix.'event_days',
								'value' => strtotime($today_day) + 24*60*60,
								'compare' => 'LIKE'	
							),
						)
					);
					break;

					case 'this_week':
					$args_time = array(
						'meta_query' => array(
							array(
								'key' => $_prefix.'event_days',
								'value' => $this_week_regexp,
								'compare' => 'REGEXP'	
							),
						)
					);
					break;

					case 'this_week_end':
					$args_time = array(
						'meta_query' => array(
							array(
								'key' => $_prefix.'event_days',
								'value' => $week_end_regexp,
								'compare' => 'REGEXP'	
							),
						)
					);
					break;

					case 'next_week':
					$args_time = array(
						'meta_query' => array(
							array(
								'key' => $_prefix.'event_days',
								'value' => $next_week_regexp,
								'compare' => 'REGEXP'	
							),
						)
					);
					break;

					case 'next_month':
					$args_time = array(
						'meta_query' => array(
							array(
								'key' => $_prefix.'event_days',
								'value' => $next_month_regexp,
								'compare' => 'REGEXP'	
							),
						)
					);
					break;

					default:
						# code...
					break;
				}
			}

			// Query Date
			if( $start_date && $end_date ){

				$between_dates = el_getDatesFromRange( date( 'Y-m-d', strtotime( $start_date ) ), date( 'Y-m-d', strtotime( $end_date ) + 24*60*60 ) );
				$between_dates_regexp = implode($between_dates, '|');

				$args_date = array(
					'meta_query' => array(
						array(
							'key' => $_prefix.'event_days',
							'value' => $between_dates_regexp,
							'compare' => 'REGEXP'
						),
					)
				);

			}else if( $start_date || $end_date ){

				$args_date = array(
					'meta_query' => array(
						array(
							'relation' => 'OR',
							array(
								'key' => $_prefix.'event_days',
								'value' => strtotime( $start_date ),
								'compare' => 'LIKE'
							),
							array(
								'key' => $_prefix.'event_days',
								'value' => strtotime( $end_date ),
								'compare' => 'LIKE'
							),
						)
					)	
				);

			}

			// Query Venue
			if($name_venue){
				$args_venue = array(
					'meta_query' => array(
						array(
							'key' => $_prefix.'venue',
							'value' => $name_venue,
							'compare' => 'LIKE'
						)
					)
				);
			}

			// Query State
			if($event_state){
				$args_state = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'event_loc',
							'field'    => 'slug',
							'terms' => $event_state
						)
					)
				);
			}

			// Query City
			if($event_city){
				$args_city = array(
					'tax_query' => array(
						array(
							'taxonomy' => 'event_loc',
							'field'    => 'slug',
							'terms' => $event_city
						)
					)
				);
			}

			

			// Query filter
			$args_filter_events = el_sql_filter_status_event( $filter_events );

			$args = array_merge_recursive( $args_basic, $args_radius, $args_name, $args_cat, $args_time , $args_date, $args_venue, $args_state, $args_city, $args_filter_events, $arg_taxonomy_arr );
			
			$events = new WP_Query( apply_filters( 'el_search_map_event_query', $args, $post_data  ) );

			/***** End Query Post in Radius *****/
			
			ob_start();
			?>

			<div class="event_archive <?php echo esc_attr($type . ' ' . $column); ?> " style="display: grid;">
				<?php
				if($events->have_posts() ) : while ( $events->have_posts() ) : $events->the_post();

					el_get_template_part( 'content', 'event-'.$type );
					$id = get_the_id();
					?>
					<div class="data_event" style="display: none;"
					data-link_event="<?php echo esc_attr( get_the_permalink() ); ?>"
					data-title_event="<?php echo esc_attr( get_the_title() ); ?>"
					data-date="<?php echo get_event_date_el('simple'); ?>"
					data-average_rating="<?php echo get_average_rating_by_id_event( get_the_id() ); ?>"
					data-number_comment="<?php echo get_number_coment_by_id_event( get_the_id() ); ?>"
					data-map_lat_event="<?php echo get_post_meta( get_the_ID(), OVA_METABOX_EVENT.'map_lat', true ); ?>"
					data-map_lng_event="<?php echo get_post_meta( get_the_ID(), OVA_METABOX_EVENT.'map_lng', true ); ?>"
					data-thumbnail_event="<?php echo esc_attr( ( has_post_thumbnail() && get_the_post_thumbnail() ) ? wp_get_attachment_image_url( get_post_thumbnail_id() , 'el_img_squa' ) : EL_PLUGIN_URI.'assets/img/no_tmb_square.png' ); ?>"
					data-marker_price="<?php echo esc_attr(get_price_ticket_by_id_event( $id )); ?>"
					data-marker_date="<?php echo esc_attr(get_event_date_el('map_simple')); ?>"
					></div>

				<?php endwhile; wp_reset_postdata(); else: ?>

				<div class="not_found_event"> <?php esc_html_e( 'Not found event', 'eventlist' ); ?> </div>

				<?php ; endif; ?>
			</div>

			<?php 
			$total = $events->max_num_pages;

			if ( $total > 1 ) {  ?>
				<div class="el-pagination">
					<?php 
					el_pagination_event_ajax($events->found_posts, $events->query_vars['posts_per_page'], $paged);
					?>
				</div>
			<?php }
			$result = ob_get_contents(); 
			ob_end_clean();

			ob_start(); ?>
			<div class="listing_found">
				<?php if ($events->found_posts == 1) { ?>
					<span><?php echo sprintf( esc_html__( '%s Result Found', 'eventlist' ), esc_html( $events->found_posts ) ); ?></span>
				<?php } else { ?>
					<span><?php echo sprintf( esc_html__( '%s Results Found', 'eventlist' ), esc_html( $events->found_posts ) ); ?></span>
				<?php } ?>

				<?php if ( $paged == ceil($events->found_posts/$events->query_vars['posts_per_page']) ) { ?>
					<span>
						<?php echo sprintf( esc_html__( '(Showing %s-%s)', 'eventlist' ), esc_html( (($paged - 1) * $events->query_vars['posts_per_page'] + 1)), esc_html($events->found_posts) ); ?>
					</span>
				<?php } elseif( !$events->have_posts() ) { ?>
					<span></span>
				<?php } else { ?>
					<span>
						<?php echo sprintf( esc_html__( '(Showing %s-%s)', 'eventlist' ), esc_html(($paged - 1) * $events->query_vars['posts_per_page'] + 1), esc_html($paged * $events->query_vars['posts_per_page']) ); ?>
					</span>
				<?php } ?>
			</div>

			<?php
			$pagination = ob_get_contents();
			ob_end_clean();

			echo json_encode(array("result"=>$result, "pagination"=>$pagination));

			wp_die();
		}

		public function el_filter_elementor_grid () {

			if( !isset( $_POST ) ) wp_die();

			$filter = isset($_POST['filter']) ? sanitize_text_field($_POST['filter']) : "";
			$status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : "";
			$order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : "";
			$orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : "";
			$number_post = isset($_POST['number_post']) ? sanitize_text_field($_POST['number_post']) : "";
			$term_id_filter_string = isset($_POST['term_id_filter_string']) ? sanitize_text_field($_POST['term_id_filter_string']) : "";
			$type_event = isset($_POST['type_event']) ? sanitize_text_field($_POST['type_event']) : "";

			$term_id_filter = explode(',', $term_id_filter_string);

			$current_time = current_time('timestamp');

			$agrs_base = [
				'post_type' => 'event',
				'post_status' => 'publish',
				'posts_per_page' => $number_post,
				'order' => $order,
				// 'orderby' => $orderby,
			];


			switch ($orderby) {
				case 'date':
				$args_orderby =  array( 'orderby' => 'date' );

				break;
				case 'title':
				$args_orderby =  array( 'orderby' => 'title' );
				break;

				case 'start_date':
				$args_orderby =  array( 'orderby' => 'meta_value_num', 'meta_key' => OVA_METABOX_EVENT.'start_date_str' );
				break;

				case 'id':
				$args_orderby =  array( 'orderby' => 'ID');
				break;

				default:
				break;
			}

			if ($filter == 'all') {
				$agrs_filter = [
					'tax_query' => [
						[
							'taxonomy' => 'event_cat',
							'field'    => 'id',
							'terms'    => $term_id_filter,
						]
					]
				];
			} else {
				$agrs_filter = [
					'tax_query' => [
						[
							'taxonomy' => 'event_cat',
							'field'    => 'id',
							'terms'    => $filter,
						]
					]
				];
			}

			switch ( $status ) {
				case 'feature' : {
					$agrs_status = [
						'meta_query' => [
							[
								'key' => OVA_METABOX_EVENT . 'event_feature',
								'value' => 'yes',
								'compare' => '=',
							],
						],
					];
					break;
				}
				case 'upcoming' : {
					$agrs_status = [
						'meta_query' => [
							'relation' => 'OR',
							[
								'key' => OVA_METABOX_EVENT . 'start_date_str',
								'value' => $current_time,
								'compare' => '>',
							],
							[
								'relation' => 'AND',
								[
									'key' => OVA_METABOX_EVENT . 'end_date_str',
									'value' => $current_time,
									'compare' => '>'
								],
								[
									'key' => OVA_METABOX_EVENT . 'option_calendar',
									'value' => 'auto'
								],
							],
						],
					];
					break;
				}
				case 'selling' : {
					$agrs_status = [
						'meta_query' => [
							'relation' => 'AND',
							[
								'key' => OVA_METABOX_EVENT . 'start_date_str',
								'value' => $current_time,
								'compare' => '<=',
							],
							[
								'key' => OVA_METABOX_EVENT . 'end_date_str',
								'value' => $current_time,
								'compare' => '>='
							]
						],
					];
					break;
				}

				case 'upcoming_selling': {
					$agrs_status = [
						'meta_query' => [
							'key'      => OVA_METABOX_EVENT . 'end_date_str',
							'value'    => $current_time,
							'compare'  => '>'
						],
					];
					break;
				}

				case 'closed' : {
					$agrs_status = [
						'meta_query' => [
							[
								'key' => OVA_METABOX_EVENT . 'end_date_str',
								'value' => $current_time,
								'compare' => '<',
							]
						],
					];
					break;
				}

				default : {
					$agrs_status = [];
				}
			}

			$agrs = array_merge($agrs_base, $agrs_filter, $agrs_status, $args_orderby);

			$events = new WP_Query( $agrs );
			?>
			<div class="wrap_loader">
				<svg class="loader" width="50" height="50">
					<circle cx="25" cy="25" r="10" stroke="#a1a1a1"/>
					<circle cx="25" cy="25" r="20" stroke="#a1a1a1"/>
				</svg>
			</div>

			<?php
			if($events->have_posts()) : 
				while($events->have_posts()) : $events->the_post();
					el_get_template_part( 'content', 'event-'.$type_event );
				endwhile; wp_reset_postdata(); 
			else:
				?>
				<h3 class="event-notfound"><?php esc_html_e('Event not found', 'eventlist'); ?></h3>
				<?php 
			endif;

			wp_die();
		}

		public function el_single_send_mail_report() {

			if( ! is_user_logged_in() ) {
				echo 'false';
				wp_die();
			} 

			$data = $_POST['data'];

			$id_event = (isset($data['id_event'])) ? sanitize_text_field($data['id_event']) : wp_die();
			$message = (isset($data['message'])) ? sanitize_text_field($data['message']) : "";
			
			$name_event = get_the_title($id_event);
			$link_event = get_the_permalink($id_event);

			$subject = EL()->options->mail->get( 'mail_report_event_subject', esc_html__( 'Report event', 'eventlist' ) );

			$body = EL()->options->mail->get('mail_report_event_content');

			if( !$body ) $body = 'The link event: [el_link_event]. [el_message]';

			$body = str_replace( '[el_link_event]', '<a href="'.$link_event.'">'. $name_event . '</a><br>', $body);
			$body = str_replace( '[el_message]', esc_html( $message ) . "<br>", $body);

			if(el_submit_sendmail_report( $id_event, $subject, $body)) {
				echo 'true';
			} else {
				echo 'false';
			}

			wp_die();
		}

		public function el_single_send_mail_vendor() {
			
			if(!isset($_POST['data'])) wp_die();

			$data = $_POST['data'];

			$id_event = (isset($data['id_event'])) ? sanitize_text_field($data['id_event']) : wp_die();
			$name_event = get_the_title($id_event);


			$name = (isset($data['name'])) ? sanitize_text_field($data['name']) : "";
			$email = (isset($data['email'])) ? sanitize_email($data['email']) : "";
			$phone = (isset($data['phone'])) ? sanitize_text_field($data['phone']) : "";
			$subject = (isset($data['subject'])) ? sanitize_text_field($data['subject']) : esc_html__( 'The guest contact ', 'eventlist' ).$name_event;
			$content = (isset($data['content'])) ? sanitize_text_field($data['content']) : "[el_content]";
			

			$body = EL()->options->mail->get('mail_vendor_email_template');
			if( !$body ){
				$body = 'Name: [el_name]<br/>Email: [el_mail]<br/>Phone: [el_phone]<br/>Email: [el_content]';
			}
			$body = str_replace( '[el_name]', esc_html( $name ) . '<br>', $body);
			$body = str_replace( '[el_mail]',esc_html( $email ) . '<br>', $body);
			$body = str_replace( '[el_phone]',esc_html( $phone ) . '<br>', $body);
			$body = str_replace( '[el_content]',esc_html( $content ) . '<br>', $body);

			if(el_custom_send_mail_vendor( $email, $id_event, $subject, $body)) {
				echo 'true';
			} else {
				echo 'false';
			}

			wp_die();
		}

		/* Change password */
		public static function el_update_role() {

			if( !apply_filters( 'el_is_update_vendor_role', true ) ) wp_die();
			if( !isset( $_POST['data'] ) ) wp_die();

			$post_data = $_POST['data'];
			
			if( !isset( $post_data['el_update_role_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $post_data['el_update_role_nonce'] ), 'el_update_role_nonce' ) ) return ;

			$role = isset( $post_data['role'] ) ? sanitize_text_field( $post_data['role'] ) : '';
		
			$user_id = wp_get_current_user()->ID;

			if ( $role == 'vendor' ) {
				
				$user = new WP_User( $user_id );
				$user->set_role( 'el_event_manager' );
				$member_account_id = EL()->options->general->get( 'myaccount_page_id', '' );
				$redirect_page = get_the_permalink( $member_account_id );

				$enable_package = EL()->options->package->get( 'enable_package', 'yes' );
				$default_package = EL()->options->package->get( 'package' );
				
				if( $enable_package == 'yes' && $default_package ){

					$pid = EL_Package::instance()->get_package( $default_package );

					if( EL_Package::instance()->add_membership( $pid['id'], $user_id, $status = 'new' ) ){
						$redirect_page = add_query_arg( 'vendor', 'package', $redirect_page );		
					}
					
				}
				
				echo $redirect_page;
				wp_die();

			} 

			wp_die();
			
		}

		// Cancel Booking
		public static function el_cancel_booking(){

			if(!isset( $_POST )) wp_die();
			
			$id_booking = isset( $_POST['id_booking'] ) ? $_POST['id_booking'] : '';

			if( !isset( $_POST['el_cancel_booking_nonce'] ) || !wp_verify_nonce( sanitize_text_field( $_POST['el_cancel_booking_nonce'] ), 'el_cancel_booking_nonce' ) ) return ;

			if( $id_booking && el_cancellation_booking_valid( $_POST['id_booking'] ) ){

				$id_customer_booking = get_post_meta( $id_booking, OVA_METABOX_EVENT.'id_customer', true );
				$current_user_id = get_current_user_id();

				// Check exactly customer who buy event
				if( $current_user_id == $id_customer_booking || current_user_can( 'administrator' ) ){
					
						$booking_update = array(
							'ID'           => $id_booking,
							'post_date'		=> current_time('mysql'),
							'meta_input'	=> array(
								OVA_METABOX_EVENT.'status' => 'Canceled',
							)
						);

						if( wp_update_post( $booking_update ) ){

							do_action( 'el_cancel_booking_succesfully', $id_booking );

							echo json_encode( array( 'status' => 'success', 'msg' => esc_html__( 'Cancel Sucessfully', 'eventlist' ) ) );
							wp_die();
						}

				}
				
			}

			echo json_encode( array( 'status' => 'error', 'msg' => esc_html__( 'Error Cancellation', 'eventlist' ) ) );
			wp_die();
		}

	}

	new El_Ajax();
}

?>
