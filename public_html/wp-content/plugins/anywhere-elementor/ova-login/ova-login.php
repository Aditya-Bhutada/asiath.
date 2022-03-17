<?php
/**
 * Plugin Name:       Ova Login
 * Description:       A plugin that replaces the WordPress login flow with a custom page.
 * Version:           1.1.2
 * Author:            Ovatheme
 * License:           GPL-2.0+
 * Text Domain:       ova-login
 */

defined( 'ABSPATH' ) || exit;

class Ova_Login_Plugin {

	/**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
	public function __construct() {

		// Functions
		include_once dirname( __FILE__ ) . '/ova-login-functions.php';


		// Settings
		include_once dirname( __FILE__ ) . '/settings/settings.php';
		include_once dirname( __FILE__ ) . '/settings/admin_settings.php';
		

		// language
		load_plugin_textdomain( 'ova-login', false, basename( dirname( __FILE__ ) ) .'/languages' ); 


    	// Add css
		add_action( 'wp_enqueue_scripts', array( $this, 'login_enqueue_scripts' ), 10 ,0 );

    	// Make Form
		add_shortcode( 'custom-login-form', array( $this, 'render_login_form' ) );

		
		// If choose Login page in Login Setting Plugin
		$allow_custom_login = ovalg_allow_custom_login();

		if( apply_filters( 'ovalg_allow_custom_login', $allow_custom_login ) ){

			add_action( 'login_form_login', array( $this, 'redirect_to_custom_login' ) );	
     		// Check Login user     	
			add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
			// Check logout user
			add_action( 'wp_logout', array( $this, 'redirect_after_logout' ) );

		}


		// Redirect to page when logged in
		add_filter( 'login_redirect', array( $this, 'redirect_after_login' ), 10, 3 );


		/* Register User */
		add_shortcode( 'custom-register-form', array( $this, 'render_register_form' ) );

		$allow_custom_register = ovalg_allow_custom_register();

		if( apply_filters( 'ovalg_allow_custom_register', $allow_custom_register ) ){

			add_action( 'login_form_register', array( $this, 'redirect_to_custom_register' ) );
			add_action( 'login_form_register', array( $this, 'do_register_user' ) );

		}
		
		


		/* Forgot Password */
		add_shortcode( 'custom-password-lost-form', array( $this, 'render_password_lost_form' ) );

		$allow_custom_forgot_pw = ovalg_allow_custom_forgot_pw();
		if( $allow_custom_forgot_pw ){
			add_action( 'login_form_lostpassword', array( $this, 'redirect_to_custom_lostpassword' ) );
			add_action( 'login_form_lostpassword', array( $this, 'do_password_lost' ) );
		}

		add_filter( 'retrieve_password_message', array( $this, 'replace_retrieve_password_message' ), 10, 4 );


		/* Reset Password */
		add_shortcode( 'custom-password-reset-form', array( $this, 'render_password_reset_form' ) );

		$allow_custom_reset_pw = ovalg_allow_custom_reset_pw();

		if( $allow_custom_reset_pw ){

			add_action( 'login_form_rp', array( $this, 'redirect_to_custom_password_reset' ) );
			add_action( 'login_form_resetpass', array( $this, 'redirect_to_custom_password_reset' ) );
			add_action( 'login_form_rp', array( $this, 'do_password_reset' ) );
			add_action( 'login_form_resetpass', array( $this, 'do_password_reset' ) );
		}


		// My account
		add_shortcode( 'account-info', array( $this, 'account_info' ) );

	}

	/**
     * Add css
     */
	public function login_enqueue_scripts(){

		wp_enqueue_style('ova_login', plugin_dir_url( __FILE__ ).'assets/css/login.css' );
		wp_enqueue_script('login-script', plugin_dir_url( __FILE__ ).'assets/js/login-script.js', array('jquery'), false, true );
	}

	/**
	 * Plugin activation hook.
	 *
	 * Creates all WordPress pages needed by the plugin.
	 */
	public static function plugin_activated() {
	   // Information needed for creating the plugin's pages
		$page_definitions = array(
			'member-login' => array(
				'title' => __( 'Sign In', 'ova-login' ),
				'content' => '[custom-login-form]'
			),
			'member-account' => array(
				'title' => __( 'Member Account', 'ova-login' ),
				'content' => '[account-info]'
			),
			'member-register' => array(
				'title' => __( 'Register', 'ova-login' ),
				'content' => '[custom-register-form]'
			),
			'member-password-lost' => array(
				'title' => __( 'Forgot Your Password?', 'ova-login' ),
				'content' => '[custom-password-lost-form]'
			),
			'member-password-reset' => array(
				'title' => __( 'Pick a New Password', 'ova-login' ),
				'content' => '[custom-password-reset-form]'
			)
		);

		foreach ( $page_definitions as $slug => $page ) {
        	// Check that the page doesn't exist already
			$query = new WP_Query( 'pagename=' . $slug );
			if ( ! $query->have_posts() ) {
            // Add the page using the data from the array above
				wp_insert_post(
					array(
						'post_content'   => $page['content'],
						'post_name'      => $slug,
						'post_title'     => $page['title'],
						'post_status'    => 'publish',
						'post_type'      => 'page',
						'ping_status'    => 'closed',
						'comment_status' => 'closed',
					)
				);
			}
		}
	}

	/**
	 * A shortcode for rendering the login form.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	

	public function render_login_form( $attributes, $content = null ) {

    	// Parse shortcode attributes
		$default_attributes = array( 'show_title' => false );
		$attributes = shortcode_atts( $default_attributes, $attributes );
		$show_title = $attributes['show_title'];

		if ( is_user_logged_in() ) {
			return __( 'You are already signed in.', 'ova-login' );
		}

    	// Pass the redirect parameter to the WordPress login functionality: by default,
    	// don't specify a redirect, but if a valid redirect URL has been passed as
    	// request parameter, use it.
		$attributes['redirect'] = ovalg_login_success_url();

		if ( isset( $_REQUEST['redirect_to'] ) ) {
			$attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
		}


		$errors = array();
		if ( isset( $_REQUEST['login'] ) ) {
			$error_codes = explode( ',', $_REQUEST['login'] );

			foreach ( $error_codes as $code ) {
				$errors []= $this->get_error_message( $code );
			}
		}

    	// Check if user just logged out
		$attributes['logged_out'] = isset( $_REQUEST['logged_out'] ) && $_REQUEST['logged_out'] == true;
		$attributes['errors'] = $errors;

    	// Check if the user just registered
		$attributes['registered'] = isset( $_REQUEST['registered'] );

		// Check if the user just requested a new password 
		$attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';

		// Check if user just updated password
		$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';

    	// Render the login form using an external template
		return $this->get_template_html( 'login_form', $attributes );
	}


	/**
	 * Renders the contents of the given template to a string and returns it.
	 *
	 * @param string $template_name The name of the template to render (without .php)
	 * @param array  $attributes    The PHP variables for the template
	 *
	 * @return string               The contents of the template.
	 */
	private function get_template_html( $template_name, $attributes = null ) {
		if ( ! $attributes ) {
			$attributes = array();
		}

		ob_start();

		do_action( 'ova_login_before_' . $template_name );

		require( 'templates/' . $template_name . '.php');

		do_action( 'ova_login_after_' . $template_name );

		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	
	/**
	 * Redirect the user to the custom login page instead of wp-login.php.
	 */
	function redirect_to_custom_login() {

		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

			$redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : null;

			if ( is_user_logged_in() ) {
				$this->redirect_logged_in_user( $redirect_to );
				exit;
			}

        	// Get Login Page
    		$login_url = ovalg_login_url();
			
			if ( ! empty( $redirect_to ) ) {
				$login_url = add_query_arg( 'redirect_to', $redirect_to, $login_url );
			}

			wp_redirect( $login_url );
			exit;
		}
		
	}


	/**
	 * Redirects the user to the correct page depending on whether he / she
	 * is an admin or not.
	 *
	 * @param string $redirect_to   An optional redirect_to URL for admin users
	 */
	private function redirect_logged_in_user( $redirect_to = null ) {

		$user = wp_get_current_user();

		if ( user_can( $user, 'manage_options' ) ) {

			if ( $redirect_to ) {
				wp_safe_redirect( $redirect_to );
			} else {
				wp_redirect( admin_url() );
			}

		} else {

			$login_sucess_url = ovalg_login_success_url();

			wp_redirect( $login_sucess_url );

		}
	}
	

	/**
	 * Redirect the user after authentication if there were any errors.
	 *
	 * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
	 * @param string            $username   The user name used to log in.
	 * @param string            $password   The password used to log in.
	 *
	 * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
	 */
	function maybe_redirect_at_authenticate( $user, $username, $password ) {
    	// Check if the earlier authenticate filter (most likely, 
    	// the default WordPress authentication) functions have found errors

		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

			if ( is_wp_error( $user ) ) {

				$error_codes = join( ',', $user->get_error_codes() );

				// Get Login Page
    			$login_url = ovalg_login_url();

    			// Get current language
    			$current_lang = isset( $_POST['lang'] ) ? $_POST['lang'] : '';

    			// Add language to login url
    			if( $current_lang ){
    				$login_url = add_query_arg( 'lang', $current_lang, $login_url );
    			}

				$redirect_url = add_query_arg( 'login', $error_codes, $login_url );

				wp_redirect( $redirect_url );
				exit;
			}
		}

		return $user;
	}

	/**
	 * Finds and returns a matching error message for the given error code.
	 *
	 * @param string $error_code    The error code to look up.
	 *
	 * @return string               An error message.
	 */
	private function get_error_message( $error_code ) {

		switch ( $error_code ) {

			case 'empty_username':
			return __( 'You do have an email address, right?', 'ova-login' );

			case 'empty_password':
			return __( 'You need to enter a password to login.', 'ova-login' );

			case 'invalid_username':
			return __(
				"We don't have any users with that email address. Maybe you used a different one when signing up?",
				'ova-login'
			);

			case 'incorrect_password':
			$err = __(
				"The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
				'ova-login'
			);
			return sprintf( $err, site_url('/wp-login.php?action=lostpassword') );

        	// Registration errors

			case 'username':
			return __( 'The username you entered is not valid.', 'ova-login' );

			case 'username_exists':
			return __( 'An account exists with this username. please try again', 'ova-login' );

			case 'email':
			return __( 'The email address you entered is not valid.', 'ova-login' );

			case 'email_confirm':
			return __( 'The email confirm not match.', 'ova-login' );

			case 'email_exists':
			return __( 'Email address exists. Please try again', 'ova-login' );

			case 'password_format':
			return __( 'Password is greater than 8 characters and must include at least one number and must include at least one letter. Please try again', 'ova-login' );

			case 'password_not_match':
			return __( 'Password not match. Please try again', 'ova-login' );

			case 'closed':
			return __( 'Registering new users is currently not allowed.', 'ova-login' );

			case 'invalid_email':
			case 'invalidcombo':
			return __( 'There are no users registered with this email address.', 'ova-login' );

			case 'expiredkey':
			case 'invalidkey':
			return __( 'The password reset link you used is not valid anymore.', 'ova-login' );

			case 'password_reset_mismatch':
			return __( "The two passwords you entered don't match.", 'ova-login' );

			case 'password_reset_empty':
			return __( "Sorry, we don't accept empty passwords.", 'ova-login' );

			case 'dcma':
			return __( "You have to tick terms and conditions", 'ova-login' );

			default:
			break;

		}

		return __( 'An unknown error occurred. Please try again later.', 'ova-login' );
	}


	/**
	 * Redirect to custom login page after the user has been logged out.
	 */
	public function redirect_after_logout() {


		// Get Login Page
    	$login_url = ovalg_login_url();

		$redirect_url = add_query_arg( 'logged_out', true , $login_url );

		wp_safe_redirect( $redirect_url );

		exit;
	}


	/**
	 * Returns the URL to which the user should be redirected after the (successful) login.
	 *
	 * @param string           $redirect_to           The redirect destination URL.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
	 *
	 * @return string Redirect URL
	 */
	public function redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {

		$redirect_url = '';

		if( isset( $_POST['redirect_to'] ) && array_key_exists('redirect_to', $_POST) ) {

			$redirect_url = esc_url( $_POST['redirect_to'] );
			
		}

			
		if(  $redirect_url ) {
			return $redirect_url;
		}

		$redirect_url = site_url();
		
		if ( ! isset( $user->ID ) ) {
			return $redirect_url;
		}

		if ( user_can( $user, 'manage_options' ) ) {
        	// Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
			if ( $requested_redirect_to == '' ) {
				$redirect_url = admin_url();
			} else {
				$redirect_url = $requested_redirect_to;
			}
		} else {
        	// Non-admin users always go to their account page after login
			$redirect_url = ovalg_login_success_url();
		}

		return wp_validate_redirect( $redirect_url, site_url() );

	}


	/**
	 * A shortcode for rendering the new user registration form.
	 *
	 * @param  array   $attributes  Shortcode attributes.
	 * @param  string  $content     The text content for shortcode. Not used.
	 *
	 * @return string  The shortcode output
	 */
	public function render_register_form( $attributes, $content = null ) {
    	// Parse shortcode attributes
		$default_attributes = array( 'show_title' => false );
		$attributes = shortcode_atts( $default_attributes, $attributes );

		if ( is_user_logged_in() ) {
			return __( 'You are already signed in.', 'ova-login' );
		} elseif ( ! get_option( 'users_can_register' ) ) {
			return __( 'Registering new users is currently not allowed.', 'ova-login' );
		} else {

	     	// Retrieve possible errors from request parameters
			$attributes['errors'] = array();
			if ( isset( $_REQUEST['register-errors'] ) ) {
				$error_codes = explode( ',', $_REQUEST['register-errors'] );

				foreach ( $error_codes as $error_code ) {
					$attributes['errors'] []= $this->get_error_message( $error_code );
				}
			}	


			return $this->get_template_html( 'register_form', $attributes );
		}
	}



	/**
	 * Redirects the user to the custom registration page instead
	 * of wp-login.php?action=register.
	 */
	public function redirect_to_custom_register() {

		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {

			if ( is_user_logged_in() ) {

				$this->redirect_logged_in_user();

			} else {

				$regsiter_url = ovalg_register_url();

				wp_redirect( $regsiter_url );

			}

			exit;

		}

	}


	/**
	 * Validates and then completes the new user signup process if all went well.
	 *
	 * @param string $email         The new user's email address
	 * @param string $first_name    The new user's first name
	 * @param string $last_name     The new user's last name
	 *
	 * @return int|WP_Error         The id of the user that was created, or error if failed.
	 */
	private function register_user( $username, $email, $email_confirm,  $first_name, $last_name, $passwrod, $password_confirm, $type_user, $dcma, $extra_data ) {
		$errors = new WP_Error();

    	// Email address is used as both username and email. It is also the only
    	// parameter we need to validate

		if ( ! validate_username( $username ) ) {
			$errors->add( 'username', $this->get_error_message( 'username') );
			return $errors;
		}

		if ( username_exists( $username ) ) {
			$errors->add( 'username_exists', $this->get_error_message( 'username_exists') );
			return $errors;
		}

		if ( ! is_email( $email ) ) {
			$errors->add( 'email', $this->get_error_message( 'email' ) );
			return $errors;
		}

		if ( $email != $email_confirm && apply_filters( 'meup_show_email_confirm', true ) ) {
			$errors->add( 'email_confirm', $this->get_error_message( 'email_confirm' ) );
			return $errors;
		}

		if ( email_exists( $email ) ) {
			$errors->add( 'email_exists', $this->get_error_message( 'email_exists') );
			return $errors;
		}

		if( apply_filters( 'meup_active_account_via_mail', true ) ){

			// Generate the password so that the subscriber will have to check email...
	    	$passwrod = wp_generate_password( 12, false );

			

		}else{

			if ( ! $this->checkPassword($passwrod) ) {
				$errors->add( 'password_format', $this->get_error_message( 'password_format') );
				return $errors;
			}

			if ( $passwrod !== $password_confirm ) {
				$errors->add( 'password_not_match', $this->get_error_message( 'pass_word_not_match') );
				return $errors;
			}

		}
		

		if ( $type_user !== 'vendor' && $type_user !== 'user' ) {
			$errors->add( 'type_user', $this->get_error_message( 'type_user') );
			return $errors;
		}

		if ($type_user === 'vendor') {
			$role = 'el_event_manager';
		} else {
			$role = 'subscriber';
		}

		if ( ! $dcma ) {
			$errors->add( 'dcma', $this->get_error_message( 'dcma') );
			return $errors;
		}
		
		$user_phone = isset( $extra_data['user_phone'] ) ? $extra_data['user_phone'] : '';

		if ( $user_phone == '' && apply_filters( 'ovalg_register_require_phone', false ) ) {
			$errors->add( 'user_phone', $this->get_error_message( 'user_phone') );
			return $errors;
		}

		$user_job = isset( $extra_data['user_job'] ) ? $extra_data['user_job'] : '';

		if ( $user_job == '' && apply_filters( 'ovalg_register_require_job', false ) ) {
			$errors->add( 'user_job', $this->get_error_message( 'user_job') );
			return $errors;
		}

		$user_address = isset( $extra_data['user_address'] ) ? $extra_data['user_address'] : '';

		if ( $user_address == '' && apply_filters( 'ovalg_register_require_address', false ) ) {
			$errors->add( 'user_address', $this->get_error_message( 'user_address') );
			return $errors;
		}

		$user_description = isset( $extra_data['user_description'] ) ? $extra_data['user_description'] : '';

		if ( $user_description == '' && apply_filters( 'ovalg_register_require_description', false ) ) {
			$errors->add( 'user_description', $this->get_error_message( 'user_description') );
			return $errors;
		}

		$user_data = array(
			'user_login'    => $username,
			'user_email'    => $email,
			'first_name'    => $first_name,
			'last_name'     => $last_name,
			'nickname'      => $first_name,
			'user_pass'		=> $passwrod,
			'user_phone'	=> $user_phone,
			'user_job'		=> $user_job,
			'user_address'	=> $user_address,
			'description'	=> $user_description,
			'role'			=> $role,
		);

		$user_id = wp_insert_user( $user_data );

		if( apply_filters( 'meup_active_account_via_mail', true ) ){

			wp_new_user_notification( $user_id, $passwrod );

		}
		

		return $user_id;
	}


	/*
	 * Function check password
	 */
	public function checkPassword($passwrod) {
		if (strlen($passwrod) < 8  || !preg_match("#[0-9]+#", $passwrod) || !preg_match("#[a-zA-Z]+#", $passwrod) ) {
			return false;
		}
		return true;
	}


	/**
	 * Handles the registration of a new user.
	 *
	 * Used through the action hook "login_form_register" activated on wp-login.php
	 * when accessed through the registration action.
	 */
	public function do_register_user() {

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

			$redirect_url = ovalg_register_url();
			

			if ( ! get_option( 'users_can_register' ) ) {

            	// Registration closed, display error
				$redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );

			} else {

				$username = sanitize_text_field( $_POST['username'] ) ;
				$email = sanitize_text_field($_POST['email']);
				$email_confirm = sanitize_text_field($_POST['email_confirm']);
				$first_name = sanitize_text_field( $_POST['first_name'] );
				$last_name = sanitize_text_field( $_POST['last_name'] );
				$password = isset($_POST['password']) ? sanitize_text_field( $_POST['password'] ) : '';
				$password_confirm = isset($_POST['password_confirm']) ? sanitize_text_field( $_POST['password_confirm'] ) : '';
				$type_user = sanitize_text_field( $_POST['type_user'] );

				$user_phone = sanitize_text_field( $_POST['user_phone'] ) ;
				$user_job = sanitize_text_field( $_POST['user_job'] ) ;
				$user_address = sanitize_text_field( $_POST['user_address'] ) ;
				$user_description = sanitize_text_field( $_POST['user_description'] ) ;
				
				$extra_data = array(
					'user_phone'	=> $user_phone,
					'user_job'	=> $user_job,
					'user_address'	=> $user_address,
					'user_description'	=> $user_description,
				);
				

				$dcma = sanitize_text_field( $_POST['el_dcma'] );

				$result = $this->register_user( $username, $email, $email_confirm, $first_name, $last_name, $password, $password_confirm, $type_user, $dcma, $extra_data );


				if ( is_wp_error( $result ) ) {

             		// Parse errors into a string and append as parameter to redirect
					$errors = join( ',', $result->get_error_codes() );
					$redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );

				} else {
					
					// Send email to user after resgister success
					if( !apply_filters( 'meup_active_account_via_mail', true ) && EL()->options->mail->get('enable_send_new_account_email', 'yes') == 'yes' ){

						ova_register_mailto_user( $email );
							
					}
					
					// Send email to admin after resgister success
					if( apply_filters( 'el_reg_user_sendmail_admin', true ) && EL()->options->mail->get('enable_send_new_account_email', 'yes') == 'yes' ){

						ova_register_mailto_admin( $type_user, $email );
						
					}
					
					$login_url = ovalg_login_url();
					$redirect_url = add_query_arg( 'registered', $email, $login_url );
						

				}
			}

			wp_redirect( $redirect_url );

			exit;
		}
	}

	


	/**
	 * Account Info
	 */
	public function account_info( $attributes, $content = null ) {

		if ( !is_user_logged_in() ) {

	    	// Pass the redirect parameter to the WordPress login functionality: by default,
		   // don't specify a redirect, but if a valid redirect URL has been passed as
		   // request parameter, use it.
			$attributes['redirect'] = '';
			if ( isset( $_REQUEST['redirect_to'] ) ) {
				$attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
			}

			return $this->get_template_html( 'login_form', $attributes);
		}


	   // Render the login form using an external template
		return $this->get_template_html( 'account_info', $attributes );
	}


	/**
	 * Lost Password
	 */
	public function render_password_lost_form( $attributes, $content = null ) {
   	// Parse shortcode attributes
		$default_attributes = array( 'show_title' => false );
		$attributes = shortcode_atts( $default_attributes, $attributes );

		$attributes['errors'] = array();
		if ( isset( $_REQUEST['errors'] ) ) {
			$error_codes = explode( ',', $_REQUEST['errors'] );

			foreach ( $error_codes as $error_code ) {
				$attributes['errors'] []= $this->get_error_message( $error_code );
			}
		}

		if ( is_user_logged_in() ) {
			return __( 'You are already signed in.', 'ova-login' );
		} else {
			return $this->get_template_html( 'password_lost_form', $attributes );
		}
	}

	/* Redirects the user to the custom forgot password page instead of wp-login.php?action=lostpassword. */
	public function redirect_to_custom_lostpassword() {

		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {

			if ( is_user_logged_in() ) {

				$this->redirect_logged_in_user();
				exit;

			}

			$forgot_pw_url = ovalg_password_lost_url();

			wp_redirect( $forgot_pw_url );
			exit;
		}

	}

	/* Initiates password reset. */
	public function do_password_lost() {

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

			$errors = retrieve_password();

			if ( is_wp_error( $errors ) ) {
            // Errors found
				$lost_pw_url = ovalg_password_lost_url();
				$redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $lost_pw_url );
			} else {
            // Email sent
				$login_url = ovalg_login_url();
				$redirect_url = add_query_arg( 'checkemail', 'confirm', $login_url );
			}

			wp_redirect( $redirect_url );
			exit;
		}

	}

	/* Create new message reset password */
	public function replace_retrieve_password_message( $message, $key, $user_login, $user_data ) {

		$msg  = __( 'Hello!', 'ova-login' ) . "\r\n\r\n";
		$msg .= sprintf( __( 'You asked us to reset your password for your account using the email address %s.', 'ova-login' ), $user_login ) . "\r\n\r\n";
		$msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", 'ova-login' ) . "\r\n\r\n";
		$msg .= __( 'To reset your password, visit the following address:', 'ova-login' ) . "\r\n\r\n";
		$msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
		$msg .= __( 'Thanks!', 'ova-login' ) . "\r\n";

		return $msg;
	}


	/**
	 * Reset Password
	 */
	public function render_password_reset_form( $attributes, $content = null ) {
    	// Parse shortcode attributes
		$default_attributes = array( 'show_title' => false );
		$attributes = shortcode_atts( $default_attributes, $attributes );

		if ( is_user_logged_in() ) {
			return __( 'You are already signed in.', 'ova-login' );
		} else {
			if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
				$attributes['login'] = $_REQUEST['login'];
				$attributes['key'] = $_REQUEST['key'];

            // Error messages
				$errors = array();
				if ( isset( $_REQUEST['error'] ) ) {
					$error_codes = explode( ',', $_REQUEST['error'] );

					foreach ( $error_codes as $code ) {
						$errors []= $this->get_error_message( $code );
					}
				}
				$attributes['errors'] = $errors;

				return $this->get_template_html( 'password_reset_form', $attributes );
			} else {
				return __( 'Invalid password reset link.', 'ova-login' );
			}
		}
	}

	public function redirect_to_custom_password_reset() {

		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {

        	// Verify key / login combo
			$user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );

			if ( ! $user || is_wp_error( $user ) ) {

				if ( $user && $user->get_error_code() === 'expired_key' ) {

					$login_url = ovalg_login_url();
					$redirect_login_expired_url = add_query_arg( 'login', 'expiredkey', $login_url );

					wp_redirect( $redirect_login_expired_url );

				} else {

					$login_url = ovalg_login_url();
					$redirect_login_invalidkey_url = add_query_arg( 'login', 'invalidkey', $login_url );

					wp_redirect( $redirect_login_invalidkey_url );

				}

				exit;

			}

			$redirect_url = ovalg_password_reset_url();
			$redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
			$redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );

			wp_redirect( $redirect_url );
			exit;
		}
	}

	public function do_password_reset() {

		if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {

			$rp_key = $_REQUEST['rp_key'];
			$rp_login = $_REQUEST['rp_login'];

			$user = check_password_reset_key( $rp_key, $rp_login );
			
			if ( ! $user || is_wp_error( $user ) ) {

				if ( $user && $user->get_error_code() === 'expired_key' ) {

					$login_url = ovalg_login_url();
					$redirect_login_expired_url = add_query_arg( 'login', 'expiredkey', $login_url );

					wp_redirect( $redirect_login_expired_url );

				} else {

					$login_url = ovalg_login_url();
					$redirect_login_expired_url = add_query_arg( 'login', 'invalidkey', $login_url );

					wp_redirect( $redirect_login_expired_url );

				}

				exit;

			}

			if ( isset( $_POST['pass1'] ) ) {

				if ( $_POST['pass1'] != $_POST['pass2'] ) {
					// Passwords don't match
					$redirect_url = ovalg_password_reset_url();
					$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
					wp_redirect( $redirect_url );
					exit;
				}
				if ( empty( $_POST['pass1'] ) ) {
					// Password is empty
					$redirect_url = ovalg_password_reset_url();
					$redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
					$redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
					$redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
					wp_redirect( $redirect_url );
					exit;
				}
				// Parameter checks OK, reset password
				reset_password( $user, $_POST['pass1'] );

				$login_url = ovalg_login_url();
				$login_url_changed = add_query_arg( 'password', 'changed', $login_url );

				wp_redirect( $login_url_changed );

			} else {

				echo esc_html__( 'Invalid request.', 'ova-login' );

			}

			exit;

		}

	}
	


}

// Initialize the plugin
add_action('init', 'ovameup_login');
function ovameup_login(){
	$personalize_login_pages_plugin = new Ova_Login_Plugin();
}

// Create the custom pages at plugin activation
register_activation_hook( __FILE__, array( 'Ova_Login_Plugin', 'plugin_activated' ) );



