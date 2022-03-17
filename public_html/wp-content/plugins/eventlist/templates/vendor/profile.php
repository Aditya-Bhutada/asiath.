<?php 
if ( !defined( 'ABSPATH' ) ) exit();
$user_id = wp_get_current_user()->ID;

$author_id_image = get_user_meta( $user_id, 'author_id_image', true ) ? get_user_meta( $user_id, 'author_id_image', true ) : '';
$display_name    = get_user_meta( $user_id, 'display_name', true ) ? get_user_meta( $user_id, 'display_name', true ) : get_the_author_meta('display_name', $user_id);

$user_job        = get_user_meta( $user_id, 'user_job', true ) ? get_user_meta( $user_id, 'user_job', true ) : '';
$user_phone      = get_user_meta( $user_id, 'user_phone', true ) ? get_user_meta( $user_id, 'user_phone', true ) : '';
$user_address    = get_user_meta( $user_id, 'user_address', true ) ? get_user_meta( $user_id, 'user_address', true ) : '';
$description     = get_user_meta( $user_id, 'description', true ) ? get_user_meta( $user_id, 'description', true ) : '';

$user_profile_social = get_user_meta( $user_id, 'user_profile_social', true ) ? get_user_meta( $user_id, 'user_profile_social', true ) : '';

$user_old_pass     = get_user_meta( $user_id, 'user_old_pass', true ) ? get_user_meta( $user_id, 'user_old_pass', true ) : '';

$user_bank_owner = get_user_meta( $user_id, 'user_bank_owner', true ) ? get_user_meta( $user_id, 'user_bank_owner', true ) : '';
$user_bank_number = get_user_meta( $user_id, 'user_bank_number', true ) ? get_user_meta( $user_id, 'user_bank_number', true ) : '';
$user_bank_name = get_user_meta( $user_id, 'user_bank_name', true ) ? get_user_meta( $user_id, 'user_bank_name', true ) : '';
$user_bank_branch = get_user_meta( $user_id, 'user_bank_branch', true ) ? get_user_meta( $user_id, 'user_bank_branch', true ) : '';
$user_bank_routing = get_user_meta( $user_id, 'user_bank_routing', true ) ? get_user_meta( $user_id, 'user_bank_routing', true ) : '';
$user_bank_paypal_email = get_user_meta( $user_id, 'user_bank_paypal_email', true ) ? get_user_meta( $user_id, 'user_bank_paypal_email', true ) : '';
$user_bank_stripe_account = get_user_meta( $user_id, 'user_bank_stripe_account', true ) ? get_user_meta( $user_id, 'user_bank_stripe_account', true ) : '';
?>

<div class="vendor_wrap">
	<?php echo el_get_template( 'vendor/sidebar.php' ); ?>

	<div class="contents">

		<?php echo el_get_template( '/vendor/heading.php' ); ?>

		<div class="vendor_profile">
			
			

			
			<!-- Content -->
			<div class="content">

				<ul class="vendor_tab">
					<li>
						<a class="active" href="#author_profile"><?php esc_html_e( 'Profile', 'eventlist' ); ?></a>
					</li>
					<?php if( el_is_vendor() ){ ?>
						<li>
							<a href="#author_social"><?php esc_html_e( 'Social', 'eventlist' ); ?></a>
						</li>
					<?php } ?>
					<li>
						<a href="#author_password"><?php esc_html_e( 'Password', 'eventlist' ); ?></a>
					</li>
					<?php if( el_is_vendor() && apply_filters( 'el_profile_show_bank', true ) ){ ?>
						<li>
							<a href="#author_bank"><?php esc_html_e( 'Bank', 'eventlist' ); ?></a>
						</li>
					<?php } ?>
					
				</ul>


				<!-- Profile -->
				<div id="author_profile">
					
					<?php if( !el_is_vendor() && apply_filters( 'el_is_update_vendor_role', true ) ){ ?>
						<div class="author_role">
							<div id="author_role">
								<form id="el_save_role" enctype="multipart/form-data" method="post" autocomplete="nope" autocorrect="off" autocapitalize="none">
									
									
									
										<?php esc_html_e( 'Click here:', 'eventlist' ); ?>
										<input type="submit" name="el_update_role" data-role="vendor" value="<?php esc_html_e( 'upgrade to Vendor Role', 'eventlist' ); ?>" />
										<br>
										<?php esc_html_e( 'After update to Vendor, you have to register a package to submit event. ', 'eventlist' ); ?>
										<br>
										<?php esc_html_e( 'Note: You can\'t downgrade after update to vendor role.', 'eventlist' ); ?>
									
									
									<?php wp_nonce_field( 'el_update_role_nonce', 'el_update_role_nonce' ); ?>

								</form>
							</div>
						</div>
					<?php } ?>

					<form id="el_save_profile" enctype="multipart/form-data" method="post" autocomplete="nope" autocorrect="off" autocapitalize="none">

						<!-- Image -->
						<?php if( ( isset( $_GET['vendor'] ) && $_GET['vendor'] != '' && is_user_logged_in() ) || ( is_user_logged_in() && EL()->options->role->get( 'user_upload_files', 1 ) ) ) { ?>
							<div class="author_image">

								<div class="wrap">
									<?php if ($author_id_image !== ''){ ?>
										<img class="image-preview" src="<?php echo esc_url(wp_get_attachment_image_url($author_id_image, 'el_thumbnail')); ?>" alt="<?php esc_html_e( 'author', 'eventlist' ); ?>">
										<button class=" remove_image"><?php esc_html_e( 'Remove Image', 'eventlist' ); ?></button>
									<?php }else{ ?>
										<img class="image-preview" src="<?php echo EL_PLUGIN_URI.'assets/img/unknow_user.png'; ?>" alt="<?php esc_html_e( 'author', 'eventlist' ); ?>">
										<br><br>
									<?php } ?>
								</div>

								<button class="button add_image" data-uploader-title="<?php esc_html_e( "Add image to profile", 'eventlist' ); ?>" data-uploader-button-text="<?php esc_html_e( "Add image", 'eventlist' ); ?>"><?php esc_html_e( "Add image", 'eventlist' ); ?></button>
								<span><?php esc_html_e( 'Recommended size: 400x400px','eventlist' ); ?></span>
								<input type="hidden" id="author_id_image" class="author_id_image" name="author_id_image" value="<?php echo esc_attr( $author_id_image ); ?>">
								
							</div>
						<?php } ?>

						<!-- username -->
						<div class="vendor_field">
							<label class="control-label" for="display_name"><?php esc_html_e( 'Username', 'eventlist' ); ?></label>
							<?php echo the_author_meta('nickname', $user_id); ?>
						</div>
						<!-- Name -->
						<div class="vendor_field">
							<label class="control-label" for="display_name"><?php esc_html_e( 'Name', 'eventlist' ); ?></label>
							<input id="display_name" value="<?php echo esc_attr( $display_name ); ?>" name="display_name" type="text" placeholder="<?php esc_attr_e( 'William Smith', 'eventlist' ); ?>" required>
						</div>

						<!-- Email -->
						<div class="vendor_field">
							<label class="control-label" for="user_email"><?php esc_html_e( 'Email', 'eventlist' ); ?></label>
							<input id="user_email" value="<?php the_author_meta('user_email', $user_id) ?>" name="user_email" type="text" placeholder="<?php esc_attr_e( 'example@email.com', 'eventlist' ); ?>" disabled>
						</div>

						<!-- Website -->
						<div class="vendor_field">
							<label class="control-label" for="user_job"><?php esc_html_e( 'Job', 'eventlist' ); ?></label>
							<input id="user_job" value="<?php echo esc_attr( $user_job ); ?>" name="user_job" type="text" placeholder="<?php esc_attr_e( 'CEO', 'eventlist' ); ?>" >
						</div>

						<!-- Phone -->
						<div class="vendor_field">
							<label class="control-label" for="user_phone"><?php esc_html_e( 'Phone', 'eventlist' ); ?></label>
							<input id="user_phone" value="<?php echo esc_attr( $user_phone ); ?>" name="user_phone" type="text" placeholder="<?php esc_attr_e( '(+123) 456 7890', 'eventlist' ); ?>" >
						</div>

						<!-- Address -->
						<div class="vendor_field">
							<label class="control-label" for="user_address"><?php esc_html_e( 'Address', 'eventlist' ); ?></label>
							<input id="user_address" value="<?php echo esc_attr( $user_address ); ?>" name="user_address" type="text" placeholder="<?php esc_attr_e( '123 New York', 'eventlist' ); ?>" >
						</div>

						<!-- Description -->
						<div class="vendor_field">
							<label class="control-label" for="description"><?php esc_html_e( 'Description', 'eventlist' ); ?></label>
							<textarea id="description" value="<?php echo esc_attr( $description ); ?>" name="description" type="text" placeholder="<?php esc_attr_e( 'Insert Description', 'eventlist' ); ?>" class="description form-control input-md "><?php echo esc_html( $description ); ?></textarea>
						</div>
						
						<div class="vendor_field">
							<input type="submit" name="el_update_profile" class="button el_submit_btn" value="<?php esc_attr_e( 'Update Profile', 'eventlist' ); ?>" />
						</div>

						<!-- <input type="hidden" name="el_update_profile" value="yes"> -->
						<?php wp_nonce_field( 'el_update_profile_nonce', 'el_update_profile_nonce' ); ?>
					</form>




				</div>


				<!-- Social -->
				<?php if( el_is_vendor() ){ ?>
					<div id="author_social">
						<form id="el_save_social" enctype="multipart/form-data" method="post" autocomplete="nope" autocorrect="off" autocapitalize="none">

							<div class="wrap_social">
								<div class="social_list">
									<?php if ($user_profile_social) { 
										foreach ($user_profile_social as $k_social => $v_social) { 
											if ($v_social[0] != '') { ?>
												
												<div class="social_item vendor_field">
													<input type="text" name="<?php echo esc_attr('user_profile_social['.$k_social.'][link]'); ?>" class="link_social" value="<?php echo esc_attr($v_social[0]); ?>" placeholder="<?php echo esc_attr( 'https://' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
													<select name="<?php echo esc_attr('user_profile_social['.$k_social.'][icon]'); ?>" class="icon_social">
														<?php foreach (el_get_social() as $k_icon => $v_icon) { ?>
															<option value="<?php echo esc_attr($k_icon); ?>" <?php echo esc_attr($k_icon == $v_social[1] ? 'selected' : ''); ?> ><?php echo esc_html( $v_icon ); ?></option>
														<?php } ?>
													</select>
													<button class="button remove_social">x</button>
												</div>
											<?php } 
										} 
									} ?>
								</div>
								<button class="button add_social"><i class="icon_plus"></i>&nbsp;<?php esc_html_e( 'Add Social', 'eventlist' ); ?></button>
							</div>

							<input type="submit" name="el_update_social" class="el_submit_btn" value="<?php esc_attr_e( 'Update Social', 'eventlist' ); ?>" class="el_update_social" />
							<!-- <input type="hidden" name="ovem_update_social" value="yes"> -->
							<?php wp_nonce_field( 'el_update_social_nonce', 'el_update_social_nonce' ); ?>
						</form>
						<div class="success_social" style="display: none;"><?php esc_html_e( 'Update Success', 'eventlist' ); ?></div>
					</div>
				<?php } ?>


				<!-- Password -->
				<div id="author_password">
					<form id="el_save_password" enctype="multipart/form-data" method="post" autocomplete="nope" autocorrect="off" autocapitalize="none">

						<!-- Old Password -->
						<div class="wrap_old_password vendor_field">
							<label class="control-label" for="old_password"><?php esc_html_e( 'Old Password', 'eventlist' ); ?></label>
							<div class="show_pass">
								<i class="dashicons dashicons-hidden"></i>
							</div>
							<input id="old_password" value="" name="old_password" type="password" placeholder="<?php esc_html_e( 'Old Password', 'eventlist' ) ?>" required>
							<div class="check_old_pass" style="display: none;"><?php esc_html_e( 'Please Check Again', 'eventlist' ); ?></div>
						</div>

						<!--New Password -->
						<div class="wrap_new_password vendor_field">
							<label class="control-label" for="new_password"><?php esc_html_e( 'New Password', 'eventlist' ); ?></label>
							<div class="show_pass">
								<i class="dashicons dashicons-hidden"></i>
							</div>
							<input id="new_password" value="" name="new_password" type="password" placeholder="<?php esc_html_e( 'New Password', 'eventlist' ) ?>" required>
						</div>

						<!-- Confirm Password -->
						<div class="wrap_confirm_password vendor_field">
							<label class="control-label" for="confirm_password"><?php esc_html_e( 'Confirm Password', 'eventlist' ); ?></label>
							<div class="show_pass">
								<i class="dashicons dashicons-hidden"></i>
							</div>
							<input id="confirm_password" value="" name="confirm_password" type="password" placeholder="<?php esc_html_e( 'Confirm Password', 'eventlist' ) ?>" required>
							<div class="check"></div>
						</div>
						<input type="submit" name="el_update_password" class="el_submit_btn" value="<?php esc_html_e( 'Update Password', 'eventlist' ); ?>" class="el_update_password" />
						
						<?php wp_nonce_field( 'el_update_password_nonce', 'el_update_password_nonce' ); ?>

					</form>
				</div>
				
				<?php if( el_is_vendor() && apply_filters( 'el_profile_show_bank', true ) ){ ?>
					<div id="author_bank">
						<form id="el_save_bank" enctype="multipart/form-data" method="post" autocomplete="nope" autocorrect="off" autocapitalize="none">
							
							<?php if( apply_filters( 'el_profile_show_bank_info', true ) ){ ?>

								<p class="heading"><?php esc_html_e('Your Bank Account', 'eventlist'); ?></p>
								<!-- Account owner -->
								<div class="vendor_field">
									<label class="control-label" for="user_bank"><?php esc_html_e( 'Account owner *', 'eventlist' ); ?></label>
									<input id="user_bank_owner" value="<?php echo esc_attr( $user_bank_owner ); ?>" name="user_bank_owner" type="text" placeholder="<?php esc_html_e( 'John Michael Doe', 'eventlist' ); ?>" >
								</div>

								<!-- Account owner -->
								<div class="vendor_field">
									<label class="control-label" for="user_number"><?php esc_html_e( 'Account number *', 'eventlist' ); ?></label>
									<input id="user_bank_number" value="<?php echo esc_attr( $user_bank_number ); ?>" name="user_bank_number" type="text" placeholder="<?php esc_html_e( '123456789', 'eventlist' ); ?>">
								</div>

								<!-- Account owner -->
								<div class="vendor_field">
									<label class="control-label" for="user_number"><?php esc_html_e( 'Bank Name *', 'eventlist' ); ?></label>
									<input id="user_bank_name" value="<?php echo esc_attr( $user_bank_name ); ?>" name="user_bank_name" type="text"  placeholder="<?php esc_html_e( 'HSBC Bank USA', 'eventlist' ); ?>"  >
								</div>

								<!-- Account owner -->
								<div class="vendor_field">
									<label class="control-label" for="user_number"><?php esc_html_e( 'Branch *', 'eventlist' ); ?></label>
									<input id="user_bank_branch" value="<?php echo esc_attr( $user_bank_branch ); ?>" name="user_bank_branch" type="text" placeholder="<?php esc_html_e( 'HSBC', 'eventlist' ); ?>" >
								</div>

								<!-- Account owner -->
								<div class="vendor_field">
									<label class="control-label" for="user_number"><?php esc_html_e( 'Routing Number', 'eventlist' ); ?></label>
									<input id="user_bank_routing" value="<?php echo esc_attr( $user_bank_routing ); ?>" name="user_bank_routing" type="text" >
								</div>

							<?php } ?>

							
							<?php if( apply_filters( 'el_profile_show_paypal', true ) ){ ?>
								<p class="heading"><?php esc_html_e('Your Paypal Account', 'eventlist'); ?></p>
								<div class="vendor_field">
									<label class="control-label" for="user_bank"><?php esc_html_e( 'Paypal Email', 'eventlist' ); ?></label>
									<input id="user_bank_paypal_email" value="<?php echo esc_attr( $user_bank_paypal_email ); ?>" name="user_bank_paypal_email" type="text" >
								</div>
							<?php } ?>
							
							<?php if( apply_filters( 'el_profile_show_stripe', true ) ){ ?>
								<p class="heading"><?php esc_html_e('Your Stripe Account', 'eventlist'); ?></p>
								<div class="vendor_field">
									<label class="control-label" for="user_bank"><?php esc_html_e( 'Stripe Email', 'eventlist' ); ?></label>
									<input id="user_bank_stripe_account" value="<?php echo esc_attr( $user_bank_stripe_account ); ?>" name="user_bank_stripe_account" type="text" >
								</div>
							<?php } ?>

							<input type="submit" name="el_update_bank" class="el_submit_btn el_update_bank" value="<?php esc_html_e( 'Update Bank', 'eventlist' ); ?>" class="el_save_bank" />
							
							
							<?php wp_nonce_field( 'el_update_bank_nonce', 'el_update_bank_nonce' ); ?>

						</form>
					</div>
				<?php } ?>

				


			</div> <!-- End Content -->

		</div>

	</div>
</div>