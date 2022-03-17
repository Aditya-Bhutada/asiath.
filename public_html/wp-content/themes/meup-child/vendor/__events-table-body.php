<?php 
if ( !defined( 'ABSPATH' ) ) exit();
$format = get_option( 'date_format' );

$listing_type = isset( $_GET['listing_type'] ) ? sanitize_text_field( $_GET['listing_type'] ) : '';
$order = isset( $_GET['order'] ) ? sanitize_text_field( $_GET['order'] ) : 'DESC';
$orderby = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'ID';
$user_id = wp_get_current_user()->ID;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

switch ($listing_type) {
	case 'all':
	$listing_events = get_vendor_events( $order , $orderby, 'any', $user_id, $paged );
	break;

	case 'publish':
	$listing_events = get_vendor_events( 'DESC' , 'start_date', 'publish', $user_id, $paged );
	break;

	case 'pending':
	$listing_events = get_vendor_events( 'DESC' , 'start_date', 'pending', $user_id, $paged );
	break;

	case 'trash':
	$listing_events = get_vendor_events( 'DESC' , 'start_date', 'trash', $user_id, $paged );
	break;

	case 'open':
	$listing_events = get_vendor_events( 'ASC' , 'start_date', 'open', $user_id, $paged );
	break;

	case 'closed':
	$listing_events = get_vendor_events( 'DESC' , 'end_date', 'closed', $user_id, $paged );
	break;
	
	default:
	$listing_events = get_vendor_events( $order , $orderby, 'any', $user_id, $paged );
	break;
}
?>
<tbody class="event_body">

	<?php if($listing_events->have_posts() ) : while ( $listing_events->have_posts() ) : $listing_events->the_post(); 
		$post_id = get_the_ID();
		$_prefix = OVA_METABOX_EVENT;

		$event_active = get_post_meta( $post_id, $_prefix.'event_active', true ) ? get_post_meta( $post_id, $_prefix.'event_active', true ) : '0';

		$start_date = get_post_meta( $post_id, $_prefix.'start_date_str', true ) ? date_i18n( get_option( 'date_format' ), get_post_meta( $post_id, $_prefix.'start_date_str', true ) ) : '';
		
		$start_time = get_post_meta( $post_id, $_prefix.'start_date_str', true ) ? date( get_option( 'time_format' ), get_post_meta( $post_id, $_prefix.'start_date_str', true ) ) : '';

		$end_date = get_post_meta( $post_id, $_prefix.'end_date_str', true ) ? date_i18n( get_option( 'date_format') , get_post_meta( $post_id, $_prefix.'end_date_str', true ) ) : '';
		
		$end_time = get_post_meta( $post_id, $_prefix.'end_date_str', true ) ? date( get_option( 'time_format' ), get_post_meta( $post_id, $_prefix.'end_date_str', true ) ) : '';

		$status_post = get_post_status();
		
		$address = get_post_meta( $post_id, $_prefix.'address', true );

		switch( $status_post ) {
			case 'private':{
				$status = esc_html__('private', 'eventlist');
				break;
			}
			case 'publish':{
				$status = esc_html__('publish', 'eventlist');
				break;
			}
			case 'pending':{
				$status = esc_html__('pending', 'eventlist');
				break;
			}
			case 'trash':{
				$status = esc_html__('trash', 'eventlist');
				break;
			}
			case 'draft':{
				$status = esc_html__('draft', 'eventlist');
				break;
			}
			default : {
				$status = $status_post;
				break;
			}
		}

		?>
		
		<tr>
			<!-- Check Event -->
			<th>
				<div class="check_event idcheck">
					<input id="<?php  echo esc_attr( 'select-'.$post_id ); ?>" type="checkbox" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
				</div>
			</th>

			<!-- Title -->
			<td class="column-title">
				<input type="hidden" id="<?php echo esc_attr( $_prefix.'event_active' ); ?>" class="<?php echo esc_attr( $_prefix.'event_active' ); ?>" value="<?php echo esc_attr( $event_active ); ?>" name="<?php echo esc_attr( $_prefix.'event_active' ); ?>" />
				<div class="title">

					<div class="info">
						<h4 class="title">
							<a href="<?php the_permalink(); ?>" target="_blank"><?php echo get_the_title(); ?></a>

							<small> - <?php echo $status; ?></small>

							<span class="status">
								<?php 
								global $event;
								$status_event = $event->get_status_event();
								echo $status_event;
								?>
							</span>
							
						</h4>

						<div class="date">
							<i class="icon_calendar"></i>
							<?php 
							EL_Vendor::instance()->display_date_event( $start_date, $start_time, $end_date, $end_time );
							?>
						</div>
						<div class="address">
							<i class="icon_building"></i>
							<?php echo $address; ?>
						</div>
					</div>

					<div class="action">
						<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
						<ul>
							<li>
								<a class="edit" href="<?php echo add_query_arg( array( 'vendor' => 'listing-edit', 'id' => $post_id  ), get_myaccount_page() ); ?>"><?php esc_html_e( 'Edit', 'eventlist' ); ?></a>		
							</li>

							<?php if ($status_post != 'pending' && $status_post != 'trash') { ?>
								<li>
									<a class="pending" href="#"><?php esc_html_e( 'Pending', 'eventlist' ); ?></a>
									<?php wp_nonce_field( 'el_pending_post_nonce', 'el_pending_post_nonce' ); ?>
								</li>
							<?php } ?>


							<?php if ($status_post == 'pending') { ?>
								<li>
									<a class="publish" href="#"><?php esc_html_e( 'Publish', 'eventlist' ); ?></a>
									<?php wp_nonce_field( 'el_publish_post_nonce', 'el_publish_post_nonce' ); ?>
								</li>
							<?php } ?>


							<?php if ($status_post != 'trash') { ?>
								<li>
									<a class="trash" href="#"><?php esc_html_e( 'Trash', 'eventlist' ); ?></a>
									<?php wp_nonce_field( 'el_trash_post_nonce', 'el_trash_post_nonce' ); ?>
								</li>
							<?php } ?>



							<?php if ($status_post == 'trash') { ?>
								<li>
									<a class="delete" href="#"><?php esc_html_e( 'Delete Permanently', 'eventlist' ); ?></a>
									<?php wp_nonce_field( 'el_delete_post_nonce', 'el_delete_post_nonce' ); ?>
								</li>
								<li>
									<a class="restore" href="#"><?php esc_html_e( 'Restore', 'eventlist' ); ?></a>
									<?php wp_nonce_field( 'el_pending_post_nonce', 'el_pending_post_nonce' ); ?>
								</li>
							<?php } ?>
							

						</ul>

					</div>
				</div>
			</td>


			<!-- Sales -->
			<td class="column-sales" data-colname="<?php esc_attr_e('Sales', 'eventlist'); ?>">
				<?php
					ob_start();
			
					el_get_template( '/vendor/__events_table_tickets.php', array( 'post_id' => $post_id ) );
					
					echo ob_get_clean();
				?>
				
			</td>

			
			<!-- Action -->
			<td class="column-action" data-colname="<?php esc_attr_e('Action', 'eventlist'); ?>">
				<a href="<?php echo add_query_arg(
				array( 
				'vendor' => 'manage_event',
				'eid'	=> $post_id
				),
				get_myaccount_page() ); ?>" class="button">

				<?php esc_html_e( 'Manage Event', 'eventlist' ); ?>
				</a>
			</td>



		</tr>

	<?php endwhile; else : ?> 
		<tr>
			<th></th>
			<td colspan="3">
				
				<?php esc_html_e( 'Not Found Event', 'eventlist' ); ?>
				
			</td>
		</tr>
	<?php ; endif; wp_reset_postdata(); ?>



</tbody>

</table>

<?php 
$total = $listing_events->max_num_pages;
if ( $total > 1 ) {
	?>
	<div colspan="4" class="my_list_pagination">
		<?php echo pagination_vendor($total) ?>
	</div>
<?php } ?>
