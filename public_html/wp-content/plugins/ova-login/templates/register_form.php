

<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
	<?php foreach ( $attributes['errors'] as $error ) : ?>
		<p>
			<?php echo $error; ?>
		</p>
	<?php endforeach; ?>
<?php endif; ?>


<div id="register-form" class="widecolumn ova_register_user">

	<h3 class="title"><?php _e( 'Register User', 'ova-login' ); ?></h3>
	
	<form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post">

		<p class="form-row ova-email-icon">
			<input placeholder="<?php _e( 'Email *', 'ova-login' ); ?>" type="text" name="email" id="email" class="required" data-msg="<?php esc_html_e( 'Please insert email', 'ova-login' ); ?>">
		</p>

		<?php if( apply_filters( 'meup_show_email_confirm', true ) ){ ?>
		<p class="form-row ova-email-icon">
			<input placeholder="<?php _e( 'Confirm Email *', 'ova-login' ); ?>" type="text" name="email_confirm" id="email_confirm" class="required"
			data-msg="<?php esc_html_e( 'Please insert confirm email', 'ova-login' ); ?>"	
			>
		</p>
		<?php } ?>

		<p class="form-row ova-user-icon">
			<input placeholder="<?php _e( 'Username *', 'ova-login' ); ?>" type="text" name="username" id="username" class="required"
			data-msg="<?php esc_html_e( 'Please insert Username', 'ova-login' ); ?>"	
			>
		</p>
		
		<p class="form-row ova-user-icon">
			<input placeholder="<?php _e( 'First name', 'ova-login' ); ?>" type="text" name="first_name" id="first-name" class="required"
			data-msg="<?php esc_html_e( 'Please insert First name', 'ova-login' ); ?>"
			>
		</p>
		
		<p class="form-row ova-user-icon">
			<input placeholder="<?php _e( 'Last name', 'ova-login' ); ?>" type="text" name="last_name" id="last-name" class="required"
			data-msg="<?php esc_html_e( 'Please insert Last name', 'ova-login' ); ?>"
			>
		</p>
		
		<?php if( !apply_filters( 'meup_active_account_via_mail', true ) ){ ?>

			<p class="form-row password">
				<input placeholder="<?php _e( 'Password *', 'ova-login' ); ?>" type="password" name="password" id="password" autocomplete="new-password" class="required"
				data-msg="<?php esc_html_e( 'Please insert Password', 'ova-login' ); ?>"
				data-error="<?php esc_html_e( 'Password is greater than 8 characters and must include at least one number and must include at least one letter', 'ova-login' ); ?>"
				>
			</p>

			<p class="form-row password">
				<input placeholder="<?php _e( 'Confirm Password *', 'ova-login' ); ?>" type="password" name="password_confirm" id="password_confirm" autocomplete="new-password" class="required"
				data-msg="<?php esc_html_e( 'Please insert Confirm Password', 'ova-login' ); ?>"
				data-error="<?php esc_html_e( 'Password is greater than 8 characters and must include at least one number and must include at least one letter', 'ova-login' ); ?>"
				>
			</p>

		<?php } ?>

		<?php if( apply_filters( 'ovalg_register_user_show_phone', true ) ){ ?>
			<p class="form-row ova-phone-icon">
				<input 
					placeholder="<?php _e( 'Phone', 'ova-login' ); ?>" 
					type="text" name="user_phone" 
					id="user_phone" 
					class="<?php echo apply_filters( 'ovalg_register_require_phone', false ) == true ? 'required' : ''; ?>"
					data-msg="<?php esc_html_e( 'Please insert Phone', 'ova-login' ); ?>"
				>
			</p>
		<?php } ?>

		<?php if( apply_filters( 'ovalg_register_user_show_job', true ) ){ ?>
			<p class="form-row ova-job-icon">
				<input 
					placeholder="<?php _e( 'Job', 'ova-login' ); ?>" 
					type="text" name="user_job" 
					id="user_job" 
					class="<?php echo apply_filters( 'ovalg_register_require_job', false ) == true ? 'required' : ''; ?>"
					data-msg="<?php esc_html_e( 'Please insert Job', 'ova-login' ); ?>"
				>
			</p>
		<?php } ?>

		<?php if( apply_filters( 'ovalg_register_user_show_address', true ) ){ ?>
			<p class="form-row ova-address-icon">
				<input 
					placeholder="<?php _e( 'Address', 'ova-login' ); ?>" 
					type="text" name="user_address" 
					id="user_address" 
					class="<?php echo apply_filters( 'ovalg_register_require_address', false ) == true ? 'required' : ''; ?>"
					data-msg="<?php esc_html_e( 'Please insert Address', 'ova-login' ); ?>"
				>
			</p>
		<?php } ?>

		<?php if( apply_filters( 'ovalg_register_user_show_description', true ) ){ ?>
			<p class="form-row ova-desc-icon">
				<textarea name="user_description" id="user_description" 
					class="<?php echo apply_filters( 'ovalg_register_require_description', false ) == true ? 'required' : ''; ?>"
					data-msg="<?php esc_html_e( 'Please insert Description', 'ova-login' ); ?>" 
					placeholder="<?php esc_html_e( 'Description', 'ova-login' ); ?>" 
					></textarea>
				
			</p>
		<?php } ?>

		<p class="form-row">

			<?php 
				$vendor_checked = apply_filters( 'meup_register_vendor_account_checked', false ) ? 'checked' : '' ; 
				$vendor_user = apply_filters( 'meup_register_user_account_checked', true ) ? 'checked' : '' ; 
			?>
			
			<?php if( apply_filters( 'meup_register_vendor_account', true ) ){ ?>
				<span class="raido_input">
					<input type="radio" name="type_user" value="vendor" id="vendor" <?php echo $vendor_checked; ?>>
					<label for="vendor"><?php _e( 'Vendor', 'ova-login' ); ?></label>
				</span>
			<?php } ?>

			<?php if( apply_filters( 'meup_register_user_account', true ) ){ ?>


				<span class="raido_input">
					<input type="radio" name="type_user" value="user" <?php echo $vendor_user; ?> id="user">
					<label for="user"><?php _e( 'User', 'ova-login' ); ?></label>
				</span>
			<?php } ?>

		</p>
		
		<?php if( apply_filters( 'el_show_register_account_terms', true ) ){ ?>
			<p class="form-row el-register-dcma">
				
				<input type="checkbox" name="el_dcma" value="dcma" class="register_term  <?php echo apply_filters( 'el_register_account_require_terms', 'required' ); ?> " 
				data-msg="<?php esc_html_e( 'Please check terms and conditions', 'ova-login' ); ?>"
				/>

				<span class="terms-and-conditions-checkbox-text">

					<?php esc_html_e( 'I have read and agree to the website', 'ova-login' ); ?>

					<?php if( $term_page = ovalg_term_condition_url() ){ ?>

						<a href="<?php echo $term_page; ?>" class="terms-and-conditions-link" target="<?php echo apply_filters( 'el_reg_terms_target', '_blank' ); ?>">
							<?php esc_html_e( 'terms and conditions', 'ova-login' ); ?>
						</a>

					<?php } ?>
					
				</span>
			</p>
		<?php } ?>

		<p class="signup-submit">
			<input type="submit" name="submit" class="ova-btn ova-btn-main-color"
			value="<?php _e( 'Register', 'ova-login' ); ?>"/>
		</p>

	</form>
</div>