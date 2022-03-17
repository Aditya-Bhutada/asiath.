<?php
$id_user = get_current_user_id();
$list_membership = EL_Package::instance()->get_info_membership_by_user_id($id_user);
?>

<h3 class="vendor_heading"><?php esc_html_e("Your package", "eventlist") ?></h3>
<div class="list-package-user">
	<table>
		<thead class="event_head">
			<tr>
				<td><?php esc_html_e('ID', 'eventlist') ?></td>
				<td><?php esc_html_e('Package', 'eventlist') ?></td>
				<td><?php esc_html_e( 'Expiration date', 'eventlist' ); ?></td>
				<td><?php esc_html_e( 'Total', 'eventlist' ); ?></td>
				<td><?php esc_html_e( 'Status', 'eventlist' ); ?></td>
			</tr>
		</thead>
		<tbody class="event_body">
			<tr>
				<td><?php echo $list_membership['id']; ?></td>
				<td><?php echo $list_membership['package']; ?></td>
				<td><?php echo $list_membership['end_date']; ?></td>
				<td><?php echo $list_membership['total']; ?></td>
				<td><?php echo $list_membership['status'].'<br/>'.$list_membership['renew_link']; ?></td>
			</tr>
		</tbody>
	</table>
</div>
