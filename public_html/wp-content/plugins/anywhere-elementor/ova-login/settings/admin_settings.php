<?php 

if( !defined( 'ABSPATH' ) ) exit();


if( !class_exists( 'OVALG_Admin_Settings' ) ){

	/**
	 * Make Admin Class
	 */
	class OVALG_Admin_Settings{

		/**
		 * Construct Admin
		 */
		public function __construct(){
			add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
			add_action( 'admin_init', array( $this, 'register_options' ) );
		}


		public function load_media() {
			wp_enqueue_media();
		}


		public function print_options_section(){
			return true;
		}


		public function register_options(){

			register_setting(
				'ovalg_options_group', // Option group
				'ovalg_options', // Name Option
				array( $this, 'settings_callback' ) // Call Back
			);

			/**
			 * General Settings
			 */
			// Add Section: General Settings
			add_settings_section(
				'ovalg_general_section_id', // ID
				esc_html__('General Setting', 'ova-login'), // Title
				array( $this, 'print_options_section' ),
				'ovalg_general_settings' // Page
			);

		

			add_settings_field(
				'login_page', // ID
				esc_html__('Sign In Page','ova-login'),
				array( $this, 'login_page' ),
				'ovalg_general_settings', // Page
				'ovalg_general_section_id' // Section ID
			);

			add_settings_field(
				'login_success_page', // ID
				esc_html__('Sign in Successfully Page','ova-login'),
				array( $this, 'login_success_page' ),
				'ovalg_general_settings', // Page
				'ovalg_general_section_id' // Section ID
			);

			add_settings_field(
				'register_page', // ID
				esc_html__('Sign up Page','ova-login'),
				array( $this, 'register_page' ),
				'ovalg_general_settings', // Page
				'ovalg_general_section_id' // Section ID
			);

			add_settings_field(
				'forgot_password_page', // ID
				esc_html__('Forgot Your Password Page','ova-login'),
				array( $this, 'forgot_password_page' ),
				'ovalg_general_settings', // Page
				'ovalg_general_section_id' // Section ID
			);

			add_settings_field(
				'pick_new_password_page', // ID
				esc_html__('Pick a New Password Page','ova-login'),
				array( $this, 'pick_new_password_page' ),
				'ovalg_general_settings', // Page
				'ovalg_general_section_id' // Section ID
			);


			add_settings_field(
				'term_condition_page_id', // ID
				esc_html__('Term Condition Page','ova-login'),
				array( $this, 'term_condition_page_id' ),
				'ovalg_general_settings', // Page
				'ovalg_general_section_id' // Section ID
			);
			
			



		}

		public function settings_callback( $input ){

			$new_input = array();
			

			if( isset( $input['login_page'] ) )
				$new_input['login_page'] = sanitize_text_field( $input['login_page'] ) ? sanitize_text_field( $input['login_page'] ) : '';

			if( isset( $input['login_success_page'] ) )
				$new_input['login_success_page'] = sanitize_text_field( $input['login_success_page'] ) ? sanitize_text_field( $input['login_success_page'] ) : '';

			if( isset( $input['term_condition_page_id'] ) )
				$new_input['term_condition_page_id'] = sanitize_text_field( $input['term_condition_page_id'] ) ? sanitize_text_field( $input['term_condition_page_id'] ) : '';

			

			if( isset( $input['register_page'] ) )
				$new_input['register_page'] = sanitize_text_field( $input['register_page'] ) ? sanitize_text_field( $input['register_page'] ) : '';

			if( isset( $input['forgot_password_page'] ) )
				$new_input['forgot_password_page'] = sanitize_text_field( $input['forgot_password_page'] ) ? sanitize_text_field( $input['forgot_password_page'] ) : '';

			if( isset( $input['pick_new_password_page'] ) )
				$new_input['pick_new_password_page'] = sanitize_text_field( $input['pick_new_password_page'] ) ? sanitize_text_field( $input['pick_new_password_page'] ) : '';

		
			return $new_input;
		}
		


		public function login_page(){ ?>
		
			<select name="ovalg_options[login_page]">

			<?php if ( $dropdownpages = ovalg_dropdown_pages_login() ): ?>

				<?php foreach ( $dropdownpages as $key => $value ): ?>

					<?php
						$ovalg_login_page = OVALG_Settings::login_page();
					?>

					<option value="<?php echo esc_attr( $key ) ?>"<?php echo $ovalg_login_page == $key ? ' selected="selected"' : '' ?> >
						<?php printf( '%s', $value ).$ovalg_login_page ?>
					</option>

					
					<?php endforeach; ?>

				<?php endif; ?>

			</select>
			<br>
			<?php esc_html_e( 'Include shortcode in page: [custom-login-form]', 'ova-login' ) ?>

		<?php }

		public function login_success_page(){ ?>
		
			<select name="ovalg_options[login_success_page]">

			<?php if ( $dropdownpages = ovalg_dropdown_pages() ): ?>

				<?php
					$ovalg_login_page = OVALG_Settings::login_success_page();
				?>

				<?php foreach ( $dropdownpages as $key => $value ): ?>

					<option value="<?php echo esc_attr( $key ) ?>"<?php echo $ovalg_login_page == $key ? ' selected="selected"' : '' ?> >
						<?php printf( '%s', $value ).$ovalg_login_page ?>
					</option>

					
					<?php endforeach; ?>

				<?php endif; ?>

			</select>
			

		<?php }


		public function register_page(){ ?>
		
			<select name="ovalg_options[register_page]">

			<?php if ( $dropdownpages = ovalg_dropdown_pages_register() ): ?>

				<?php foreach ( $dropdownpages as $key => $value ): ?>

					<?php
						$ovalg_login_page = OVALG_Settings::register_page();
					?>

					<option value="<?php echo esc_attr( $key ) ?>"<?php echo $ovalg_login_page == $key ? ' selected="selected"' : '' ?> >
						<?php printf( '%s', $value ).$ovalg_login_page ?>
					</option>

					
					<?php endforeach; ?>

				<?php endif; ?>

			</select>

			<br>
			<?php esc_html_e( 'Include shortcode in page: [custom-register-form]', 'ova-login' ) ?>

		<?php }


		public function forgot_password_page(){ ?>
		
			<select name="ovalg_options[forgot_password_page]">

			<?php if ( $dropdownpages = ovalg_dropdown_pages_forgot_pw() ): ?>

				<?php foreach ( $dropdownpages as $key => $value ): ?>

					<?php
						$ovalg_login_page = OVALG_Settings::forgot_password_page();
					?>

					<option value="<?php echo esc_attr( $key ) ?>"<?php echo $ovalg_login_page == $key ? ' selected="selected"' : '' ?> >
						<?php printf( '%s', $value ).$ovalg_login_page ?>
					</option>

					
					<?php endforeach; ?>

				<?php endif; ?>

			</select>

			<br>
			<?php esc_html_e( 'Include shortcode in page: [custom-password-lost-form]', 'ova-login' ) ?>

		<?php }

		public function pick_new_password_page(){ ?>
		
			<select name="ovalg_options[pick_new_password_page]">

			<?php if ( $dropdownpages = ovalg_dropdown_pages_reset_pw() ): ?>

				<?php foreach ( $dropdownpages as $key => $value ): ?>

					<?php
						$ovalg_login_page = OVALG_Settings::pick_new_password_page();
					?>

					<option value="<?php echo esc_attr( $key ) ?>"<?php echo $ovalg_login_page == $key ? ' selected="selected"' : '' ?> >
						<?php printf( '%s', $value ).$ovalg_login_page ?>
					</option>

					
					<?php endforeach; ?>

				<?php endif; ?>

			</select>

			<br>
			<?php esc_html_e( 'Include shortcode in page: [custom-password-reset-form]', 'ova-login' ) ?>

		<?php }


		

		public static function create_admin_setting_page() { ?>
			<div class="wrap">
				<h1><?php esc_html_e( "Login Settings", "ovaev" ); ?></h1>

				<form method="post" action="options.php">

					<div id="tabs">

						<?php settings_fields( 'ovalg_options_group' ); // Options group ?>

						<!-- Menu Tab -->
						<ul>
							<li><a href="#ovalg_general_settings"><?php esc_html_e( 'General Settings', 'ova-login' ); ?></a></li>
							
						</ul>

						<!-- General Settings -->  
						<div id="ovalg_general_settings" class="OVALG_Admin_Settings">
							<?php do_settings_sections( 'ovalg_general_settings' ); // Page ?>
						</div>

						

					</div>

					<?php submit_button(); ?>
				</form>
			</div>

		<?php }


		public function term_condition_page_id(){ ?>
		
			<select name="ovalg_options[term_condition_page_id]">

			<?php if ( $dropdownpages = ovalg_dropdown_pages() ): ?>

				<?php
					$ovalg_term_condition_page = OVALG_Settings::term_condition_page_id();
				?>

				<?php foreach ( $dropdownpages as $key => $value ): ?>

					<option value="<?php echo esc_attr( $key ) ?>"<?php echo $ovalg_term_condition_page == $key ? ' selected="selected"' : '' ?> >
						<?php printf( '%s', $value ).$ovalg_term_condition_page ?>
					</option>

					
					<?php endforeach; ?>

				<?php endif; ?>

			</select>
			

		<?php }


	}
	new OVALG_Admin_Settings();
}
