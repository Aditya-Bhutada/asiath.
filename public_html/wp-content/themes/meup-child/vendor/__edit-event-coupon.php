<?php 
if ( !defined( 'ABSPATH' ) ) exit();

$post_id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';

$_prefix = OVA_METABOX_EVENT;

$time = el_calendar_time_format();
$format = el_date_time_format_js();

$placeholder_dateformat = el_placeholder_dateformat();
$placeholder_timeformat = el_placeholder_timeformat();

$coupon = get_post_meta( $post_id, $_prefix.'coupon', true) ? get_post_meta( $post_id, $_prefix.'coupon', true) : '';
$ticket = get_post_meta( $post_id, $_prefix.'ticket', true) ? get_post_meta( $post_id, $_prefix.'ticket', true) : '';

?>

<div class="coupon">

	<div class="list_coupon">
		<?php if ( $coupon ){ ?>
			<?php foreach ( $coupon as $key => $value ) { ?>

				<?php if ($value['discount_code'] != '') : ?>
					<div class="item_coupon">

						<input type="hidden" 
						class="coupon_id" 
						name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][coupon_id]' ); ?>"
						value="<?php echo esc_attr( isset( $value['coupon_id'] ) ? $value['coupon_id'] : '' ); ?>"
						/>

						<div class="wrap_discount_code">
							<input 
							type="text" 
							class="discount_code" 
							value="<?php echo esc_attr( $value['discount_code'] ); ?>" 
							name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][discount_code]' ); ?>" 
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
							<?php $discount_amout_number = !empty($value['discount_amout_number']) ? $value['discount_amout_number'] : '' ?> 
							value="<?php echo esc_attr( $discount_amout_number ); ?>" 
							name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][discount_amout_number]' ); ?>" 
							autocomplete="nope" autocorrect="off" autocapitalize="none"
							placeholder="<?php esc_attr_e( '5', 'eventlist' ); ?>" 
							/>

							<span><?php esc_html_e( '$', 'eventlist' ); ?></span>&nbsp;

							<span><?php esc_html_e( 'or', 'eventlist' ); ?></span>&nbsp;

							<input 
							type="text" 
							class="discount_amount_percent" 
							<?php $discount_amount_percent = !empty($value['discount_amount_percent']) ? $value['discount_amount_percent'] : '' ?> 
							value="<?php echo esc_attr( $discount_amount_percent ); ?>" 
							name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][discount_amount_percent]' ); ?>" 
							autocomplete="nope" autocorrect="off" autocapitalize="none"
							placeholder="<?php esc_attr_e( '10', 'eventlist' ); ?>" 
							/>

							<span><?php esc_html_e( '% of ticket price', 'eventlist' ); ?></span>
						</div>

						<div class="discount_time">

							<div class="start_time">
								<span><strong><?php esc_html_e( 'Start', 'eventlist' ); ?></strong></span>

								<input type="text" 
								class="coupon_start_date" 
								value="<?php echo esc_attr( $value['start_date'] ); ?>"
								name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][start_date]' ); ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none"
								placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
								data-format="<?php echo esc_attr( $format ); ?>"
								/>

								<input type="text" 
								class="coupon_start_time" 
								value="<?php echo esc_attr( $value['start_time'] ); ?>" 
								name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][start_time]' ); ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none"
								placeholder="<?php echo esc_attr( $placeholder_timeformat ); ?>" 
								data-time="<?php echo esc_attr( $time ); ?>" 
								/>
							</div>

							<div class="end_time">
								<span><strong><?php esc_html_e( 'End', 'eventlist' ); ?></strong></span>

								<input type="text" 
								class="coupon_end_date" 
								value="<?php echo esc_attr( $value['end_date'] ); ?>"
								name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][end_date]' ); ?>" 
								autocomplete="nope" autocorrect="off" autocapitalize="none"
								placeholder="<?php echo esc_attr( $placeholder_dateformat ); ?>" 
								data-format="<?php echo esc_attr( $format ); ?>"
								/>

								<input type="text" 
								class="coupon_end_time" 
								value="<?php echo esc_attr( $value['end_time'] ); ?>" 
								name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][end_time]' ); ?>" 
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
									value="<?php echo esc_attr( isset( $value['all_ticket'] ) ? $value['all_ticket'] : '' ); ?>"
									name="<?php echo esc_attr(  $_prefix.'coupon['.$key.'][all_ticket]' ); ?>" 
									<?php echo esc_attr( isset( $value['all_ticket'] ) ? $value['all_ticket'] : '' ); ?> 
									/>
									<label for="coupon_all_ticket"><?php esc_html_e( 'All ticket types', 'eventlist' ); ?></label>
								</div>

								<div class="all_quantity vendor_field">
									<label for="coupon_quantity"><?php esc_html_e( 'Quantity', 'eventlist' ); ?></label>
									<input 
									type="number" 
									id="coupon_quantity" 
									class="coupon_quantity" 
									value="<?php echo esc_attr( isset( $value['quantity'] ) ? $value['quantity'] : '' ); ?>" 
									min="0" 
									name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][quantity]' ); ?>" 
									placeholder="<?php echo esc_attr( '100' ); ?>" 
									autocomplete="false"
									/>
								</div>

								<div class="wrap_list_ticket">
									<?php 
									if ( $ticket ) {
										foreach ( $ticket as $key_ticket => $value_ticket) { 
											if ($value_ticket['name_ticket'] != '') { 
												?>
												<div class="item_ticket">

													<label>
														<input 
														type="checkbox"
														class="list_ticket" 
														name="<?php echo esc_attr( $_prefix.'coupon['.$key.'][ticket]['.$key_ticket.']' ); ?>" 
														value="<?php echo esc_attr( isset( $value_ticket['ticket_id'] ) ? $value_ticket['ticket_id'] : '' ); ?>" 
														<?php if (isset($value['list_ticket'])) {
															echo esc_attr( in_array( $value_ticket['ticket_id'], $value['list_ticket']) ? 'checked' : '' );
														} ?>
														/>

														<?php echo $value_ticket['name_ticket'] ?>
													</label>

												</div>
											<?php }
										}
									} ?>
								</div>
							</div>
						</div>

						<button class="button remove_coupon"><?php esc_html_e( 'Remove Coupon', 'eventlist' ); ?></button>

					</div>
				<?php endif ?>
			<?php } ?>
		<?php } ?>
	</div>
	<button class="button add_coupon" data-post_id="<?php echo esc_attr($post_id); ?>">
		<?php esc_html_e( 'Add Coupon', 'eventlist' ); ?>
		<div class="submit-load-more sendmail">
			<div class="load-more">
				<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			</div>
		</div>
	</button>


</div>