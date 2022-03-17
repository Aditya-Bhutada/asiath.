<?php 
if ( !defined( 'ABSPATH' ) ) exit();
$user_id = wp_get_current_user()->ID;


$orderby = '';
$orderby = isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'ID';

$order = '';
(!isset($_GET['order']) || $_GET['order'] == 'DESC' ) ?  $order = 'ASC' :  $order = 'DESC';


$listing_type = '';
if(isset( $_GET['listing_type']) ) $listing_type = $_GET['listing_type'];

?>
<table>

	<thead class="event_head">
		<tr>
			<th class="idcheck"><input type="checkbox" class="check_all_event"></th>

			<td>
				<a href="<?php echo add_query_arg( array( 'vendor' => 'listing', 'listing_type' => $listing_type, 'orderby' => 'title', 'order' => $order  ), get_myaccount_page() ); ?>">
					<?php esc_html_e( 'Event', 'eventlist' ); ?>
					&nbsp; <i class="fas fa-sort"></i>
				</a>
			</td>

			<td><?php esc_html_e( 'Sales', 'eventlist' ); ?></td>

			<td><?php esc_html_e( 'Action', 'eventlist' ); ?></td>

		</tr>
	</thead>