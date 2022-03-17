<?php defined( 'ABSPATH' ) || exit;

// Send mail to User
function ova_register_mailto_user ( $mail_to ) {


	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

	// Body
	if( function_exists( 'EL' ) ){

		$body = EL()->options->mail->get( 'mail_new_acocunt_content', esc_html__( 'You registered user [el_link_profile] successfully at [el_link_home_page]', 'ova-login' ) );

	}else{

		$body = esc_html__( 'You registered user [el_link_profile] successfully at [el_link_home_page]', 'ova-login' );

	}

	$body = str_replace( '[el_link_home_page]', get_site_url(), $body);
	$body = str_replace( '[el_link_profile]', '<a href="'.esc_url( get_author_posts_url( get_user_by('email', $mail_to)->ID ) ).'">'.esc_html( get_author_posts_url( get_user_by('email', $mail_to)->ID ) ).'</a>', $body);
	

	// Subject
	$subject = esc_html__( 'Register user successlly', 'ova-login' );
	

	add_filter( 'wp_mail_from', 'wp_mail_from_new_account' );
	add_filter( 'wp_mail_from_name', 'wp_mail_from_name_new_account_user' );

	if( wp_mail( $mail_to, $subject, $body, $headers ) ){
		$result = true;
	}else{
		$result = false;
	}

	remove_filter( 'wp_mail_from', 'wp_mail_from_new_account' );
	remove_filter( 'wp_mail_from_name','wp_mail_from_name_new_account_user' );

	return $result;

}



// Send mail to Admin
function ova_register_mailto_admin ( $type_user, $mail_to ) {


	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=".get_bloginfo( 'charset' )."\r\n";

	// Body
	if( function_exists( 'EL' ) ){

		$body = EL()->options->mail->get( 'mail_new_acocunt_content', esc_html__( 'You registered user [el_link_profile] successfully at [el_link_home_page]', 'ova-login' ) );

	}else{

		$body = esc_html__( 'You registered user [el_link_profile] successfully at [el_link_home_page]', 'ova-login' );

	}

	$body = str_replace( '[el_link_home_page]', get_site_url(), $body);
	$body = str_replace( '[el_link_profile]', '<a href="'.esc_url( get_author_posts_url( get_user_by('email', $mail_to)->ID ) ).'">'.esc_html( get_author_posts_url( get_user_by('email', $mail_to)->ID ) ).'</a>', $body);
	

	// Subject
	if ($type_user == 'vendor') {
		$subject = esc_html__( 'New Vendor', 'ova-login' );
	}else{
		$subject = esc_html__( 'New User', 'ova-login' );
	}

	// Mail To
	$mails = wp_mail_from_new_account();

	$mail_new_event_recipient = function_exists( 'EL' ) ? EL()->options->mail->get('mail_new_event_recipient') : '';

	if( $mail_new_event_recipient ){
		$mails = $mails.','.$mail_new_event_recipient;
	}
	
	add_filter( 'wp_mail_from', 'wp_mail_from_new_account' );
	if ($type_user == 'vendor') {
		add_filter( 'wp_mail_from_name', 'wp_mail_from_name_new_account_type_vendor' );
	}else{
		add_filter( 'wp_mail_from_name', 'wp_mail_from_name_new_account_type_user' );	
	}
	

	if( wp_mail( $mails, $subject, $body, $headers ) ){
		$result = true;
	}else{
		$result = false;
	}


	remove_filter( 'wp_mail_from', 'wp_mail_from_new_account' );
	if ($type_user == 'vendor') {
		remove_filter( 'wp_mail_from_name', 'wp_mail_from_name_new_account_type_vendor' );
	} else {
		remove_filter( 'wp_mail_from_name','wp_mail_from_name_new_account_type_user' );
	}

	return $result;
}

function wp_mail_from_name_new_account_type_vendor(){
	return esc_html__( 'New Vendor', 'ova-login' );
}

function wp_mail_from_name_new_account_type_user(){
	return esc_html__( 'New User', 'ova-login' );	
}


function wp_mail_from_new_account(){

	if( function_exists( 'EL' ) && EL()->options->mail->get('mail_new_acocunt_from_email') ){

		return EL()->options->mail->get('mail_new_acocunt_from_email');

	}else{

		return get_option('admin_email');	

	}

}


function wp_mail_from_name_new_account_user(){

	return esc_html__("Register user Successfully", 'ova-login');	
	
}




// Get full list page
if ( ! function_exists( 'ovalg_get_pages' ) ) {

	function ovalg_get_pages() {
		global $wpdb;
		$sql   = $wpdb->prepare( "
			SELECT ID, post_title FROM $wpdb->posts
			WHERE $wpdb->posts.post_type = %s AND $wpdb->posts.post_status = %s
			GROUP BY $wpdb->posts.post_name
			", 'page', 'publish' );
		$pages = $wpdb->get_results( $sql );

		return apply_filters( 'ovalg_get_pages', $pages );
	}
}

// Get dropdown pages
if ( ! function_exists( 'ovalg_dropdown_pages' ) ) {

	function ovalg_dropdown_pages() {
		
		$list_page = ovalg_get_pages();
		$list_page_arr[''] = __( '---Select page---', 'ova-login' );

		foreach ( $list_page as $id => $value_page ) {
			
			$list_page_arr[$value_page->ID] = $value_page->post_title;
		}
		return apply_filters( 'ovalg_dropdown_pages', $list_page_arr );
	}

}

// Get list Login Page
if ( ! function_exists( 'ovalg_dropdown_pages_login' ) ) {

	function ovalg_dropdown_pages_login() {
		
		$list_page = ovalg_get_pages();

		$list_page_arr[''] = __( '---Select page---', 'ova-login' );

		foreach ( $list_page as $id => $value_page ) {
			
			$page_object = get_page( $value_page->ID );

			if ( has_shortcode( $page_object->post_content, 'custom-login-form' ) ) {

				$list_page_arr[$value_page->ID] = $value_page->post_title;	
				

			}
			
			
		}
		
		return apply_filters( 'ovalg_dropdown_pages_login', $list_page_arr );
	}

}

// Get list Register Page
if ( ! function_exists( 'ovalg_dropdown_pages_register' ) ) {

	function ovalg_dropdown_pages_register() {
		
		$list_page = ovalg_get_pages();
		
		$list_page_arr[''] = __( '---Select page---', 'ova-login' );

		foreach ( $list_page as $id => $value_page ) {
			
			$page_object = get_page( $value_page->ID );

			if ( has_shortcode( $page_object->post_content, 'custom-register-form' ) ) {

				$list_page_arr[$value_page->ID] = $value_page->post_title;	
				

			}
			
			
		}
		
		return apply_filters( 'ovalg_dropdown_pages_register', $list_page_arr );
	}

}

// Get list Forgot Page
if ( ! function_exists( 'ovalg_dropdown_pages_forgot_pw' ) ) {

	function ovalg_dropdown_pages_forgot_pw() {
		
		$list_page = ovalg_get_pages();
		
		$list_page_arr[''] = __( '---Select page---', 'ova-login' );

		foreach ( $list_page as $id => $value_page ) {
			
			$page_object = get_page( $value_page->ID );

			if ( has_shortcode( $page_object->post_content, 'custom-password-lost-form' ) ) {

				$list_page_arr[$value_page->ID] = $value_page->post_title;	
				

			}
			
			
		}
		
		return apply_filters( 'ovalg_dropdown_pages_forgot_pw', $list_page_arr );
	}

}

// Get list Reset Page
if ( ! function_exists( 'ovalg_dropdown_pages_reset_pw' ) ) {

	function ovalg_dropdown_pages_reset_pw() {
		
		$list_page = ovalg_get_pages();
		
		$list_page_arr[''] = __( '---Select page---', 'ova-login' );

		foreach ( $list_page as $id => $value_page ) {
			
			$page_object = get_page( $value_page->ID );

			if ( has_shortcode( $page_object->post_content, 'custom-password-reset-form' ) ) {

				$list_page_arr[$value_page->ID] = $value_page->post_title;	
				

			}
			
			
		}
		
		return apply_filters( 'ovalg_dropdown_pages_reset_pw', $list_page_arr );
	}

}


/**
 * Add Setting Menu
 */
add_action( 'admin_menu',  'OVALG_register_menu' );
function OVALG_register_menu(){
	

	add_submenu_page( 
		'options-general.php', 
		__( 'Login Settings', 'ova-login' ),
		__( 'Login Settings', 'ova-login' ),
		'manage_options',
		'ovalg_general_settings',
		array( 'OVALG_Admin_Settings', 'create_admin_setting_page' )
	);

}




/* LOGIN FORM */
/*************************************************************************************/

/**
 * Allow display custom login form
*/
function ovalg_allow_custom_login(){

	$allow_custom_login = false;

	if( OVALG_Settings::login_page() ){

		$allow_custom_login = true;

	}else if( get_option('permalink_structure') ){

		$member_login = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-login' ) );

		if ( has_shortcode( $member_login[0]->post_content, 'custom-login-form' ) ) {
		
			$allow_custom_login = true;

		}
	}

	return $allow_custom_login;
}





// Get Member Login URL
function ovalg_login_url(){

	// The rest are redirected to the login page
	if( $login_page = OVALG_Settings::login_page() ){

		$login_page_wpml = apply_filters( 'wpml_object_id', $login_page, 'page' );
		$login_url = get_permalink( $login_page_wpml );

	}else if( get_option('permalink_structure') ){

			$member_login = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-login' ) );

			if ( has_shortcode( $member_login[0]->post_content, 'custom-login-form' ) ) {

				$login_url = site_url( 'member-login' );

			}else{

				$login_url = wp_login_url();

			}

	}else{

		$login_url = wp_login_url();

	}
	

	return $login_url;

}



/* LOGIN FORM SUCESSFULLY */
/*************************************************************************************/

function ovalg_login_success_url(){

	$login_success_page_url = home_url('/');

	// The rest are redirected to the login page
	if( $login_success_page = OVALG_Settings::login_success_page() ){

		$login_success_page_wpml = apply_filters( 'wpml_object_id', $login_success_page, 'page' );
		$login_success_page_url = get_permalink( $login_success_page_wpml );
		

	}else if( class_exists('EventList') ){

		$login_success_page_url = get_myaccount_page();

	}else if( get_option('permalink_structure') ){

			$member_account = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-account' ) );

			if ( has_shortcode( $member_account[0]->post_content, 'el_member_account' ) ) {	

				$login_success_page_url = site_url( 'member-account' );

			}else{

				$login_success_page_url = home_url();

			}

	}else{

		$login_success_page_url = home_url();

	}
	

	return $login_success_page_url;

}




/* REGISTER FORM */
/*************************************************************************************/

/**
 * Allow display custom register form 
 */
function ovalg_allow_custom_register(){

	$allow_custom_register = false;

	if( OVALG_Settings::register_page() ){

		$allow_custom_register = true;

	}else if( get_option('permalink_structure') ){

		$member_register = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-register' ) );

		if ( has_shortcode( $member_register[0]->post_content, 'custom-register-form' ) ) {
		
			$allow_custom_register = true;

		}
	}

	return $allow_custom_register;

}


/**
 * Register URL
 * @return URL
 */
function ovalg_register_url(){

	// The rest are redirected to the login page
	if( $register_page = OVALG_Settings::register_page() ){

		$register_page_wpml = apply_filters( 'wpml_object_id', $register_page, 'page' );
		$register_url = get_permalink( $register_page_wpml );

	}else if( get_option('permalink_structure') ){

			$member_register = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-register' ) );

			if ( has_shortcode( $member_register[0]->post_content, 'custom-register-form' ) ) {	

				$register_url = site_url( 'member-register' );

			}else{

				$register_url = wp_registration_url();

			}

	}else{

		$register_url = wp_registration_url();

	}

	return $register_url;

}



/* FOR GOT PASSWORD */
/*************************************************************************************/

/**
 * Allow display custom forgot password
 */
function ovalg_allow_custom_forgot_pw(){

	$allow_custom_forgot_pw = false;

	if( OVALG_Settings::forgot_password_page() ){

		$allow_custom_forgot_pw = true;

	}else if( get_option('permalink_structure') ){

		$member_forgot_pw = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-password-lost' ) );

		if ( has_shortcode( $member_forgot_pw[0]->post_content, 'custom-password-lost-form' ) ) {	
		
			$allow_custom_forgot_pw = true;

		}
	}

	return $allow_custom_forgot_pw;

}

/**
 * Password Lost URL
 * @return URL
 */
function ovalg_password_lost_url(){

	// The rest are redirected to the login page
	if( $forgot_password_page = OVALG_Settings::forgot_password_page() ){

		$forgot_password_page_wpml = apply_filters( 'wpml_object_id', $forgot_password_page, 'page' );
		$forgot_password_url = get_permalink( $forgot_password_page_wpml );

	}else if( get_option('permalink_structure') ){

			$member_forgot_pw = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-password-lost' ) );

			if ( has_shortcode( $member_forgot_pw[0]->post_content, 'custom-password-lost-form' ) ) {	

				$forgot_password_url = site_url( 'member-password-lost' );

			}else{

				$forgot_password_url = wp_lostpassword_url();

			}

	}else{

		$forgot_password_url = wp_lostpassword_url();

	}

	
	return $forgot_password_url;

}



/* RESET PASSWORD */
/*************************************************************************************/

/**
 * Allow display custom reset password
 */
function ovalg_allow_custom_reset_pw(){

	$allow_custom_reset_pw = false;

	if( OVALG_Settings::pick_new_password_page() ){

		$allow_custom_reset_pw = true;

	}else if( get_option('permalink_structure') ){

		$member_reset_pw = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-password-reset' ) );

		if ( has_shortcode( $member_reset_pw[0]->post_content, 'custom-password-reset-form' ) ) {	
		
			$allow_custom_reset_pw = true;

		}
	}

	return $allow_custom_reset_pw;

}

/**
 * Reset URL
 * @return URL
 */
function ovalg_password_reset_url(){

	// The rest are redirected to the login page
	if( $reset_pw_page = OVALG_Settings::pick_new_password_page() ){

		$reset_password_page_wpml = apply_filters( 'wpml_object_id', $reset_pw_page, 'page' );
		$reset_password_url = get_permalink( $reset_password_page_wpml );

	}else if( get_option('permalink_structure') ){

			$member_reset_pw = get_posts( array( 'post_type' => 'page', 'pagename' => 'member-password-reset' ) );

			if ( has_shortcode( $member_reset_pw[0]->post_content, 'custom-password-reset-form' ) ) {	

				$reset_password_url = site_url( 'member-password-reset' );

			}else{

				$reset_password_url = wp_lostpassword_url();

			}

	}else{

		$reset_password_url = wp_lostpassword_url();

	}

	
	return $reset_password_url;

}


add_filter( 'login_form_bottom', 'ovalg_login_form_bottom', 10, 1 );
function ovalg_login_form_bottom( $args ){

	$lang = '';
	if( defined( 'ICL_LANGUAGE_CODE' ) ){
		$lang = ICL_LANGUAGE_CODE;
	}

	if( $lang ){
		$args .= '<input type="hidden" value="'.$lang.'" name="lang" >';	
	}
	

	return $args;

}



/* Term Condition URL */
/*************************************************************************************/
function ovalg_term_condition_url(){

	// The rest are redirected to the login page
	if( $term_page = OVALG_Settings::term_condition_page_id() ){

		$term_page_page_wpml = apply_filters( 'wpml_object_id', $term_page, 'page' );
		$term_page_page_url = get_permalink( $term_page_page_wpml );
		

	}else{

		$term_page_page_url = apply_filters( 'ovalg_term_url', '' );

	}
	

	return $term_page_page_url;

}



add_filter( 'register_url', 'ovalg_my_register_page', 10, 1 );
function ovalg_my_register_page( $register_url ) {

	$url = site_url( 'wp-login.php?action=register', 'login' );

	$lang = '';
	if( defined( 'ICL_LANGUAGE_CODE' ) ){
		$lang = ICL_LANGUAGE_CODE;

		global $sitepress;
		if ($sitepress->get_default_language() != $lang ){
			$register_url = add_query_arg( 'lang', $lang, $url );
		}
		
	}

	

	

    return $register_url;
}


