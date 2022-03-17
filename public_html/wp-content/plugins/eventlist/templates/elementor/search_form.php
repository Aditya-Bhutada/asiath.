<?php if( ! defined( 'ABSPATH' ) ) exit();

$format = el_date_time_format_js();

$get_time = isset( $_GET['time'] ) ? sanitize_text_field($_GET['time']) : '';

$event_loc = is_tax('event_loc') ? get_queried_object()->slug : '';
$event_cat = is_tax('event_cat') ? get_queried_object()->slug : '';


$selected_name_event = isset( $_GET['name_event'] ) ? sanitize_text_field($_GET['name_event']) : '';
$selected_cat = isset( $_GET['cat'] ) ? sanitize_text_field($_GET['cat']) : $event_cat;
$selected_event_state = isset( $_GET['event_state'] ) ? sanitize_text_field($_GET['event_state']) : $event_loc;
$selected_event_city = isset( $_GET['event_city'] ) ? sanitize_text_field($_GET['event_city']) : $event_loc;
$selected_loc_input = isset( $_GET['loc_input'] ) ? sanitize_text_field($_GET['loc_input']) : '';
$selected_name_venue = isset( $_GET['name_venue'] ) ? sanitize_text_field($_GET['name_venue']) : '';

$selected_event_cat = isset(get_queried_object()->slug) ? sanitize_text_field(get_queried_object()->slug) : '';

$start_date = isset( $_GET["start_date"] ) ? sanitize_text_field($_GET["start_date"]) : '';
$end_date = isset( $_GET["end_date"] ) ? sanitize_text_field($_GET["end_date"]) : '';

$list_taxonomy_register = EL_Post_Types::register_taxonomies_customize();

if ($args['type'] == 'type1') {
	for ($i = 4; $i <= 8; $i++) {
		unset($args['pos'.$i]);
		unset($args['icon'.$i]);
	}
}


?>
<div class="elementor_search_form">
	<div class="el_search_filters wrap_form_search <?php echo ' '.esc_attr($args['type']); ?> <?php echo ' '.esc_attr($args['column']); ?> " >

		<form enctype="multipart/form-data" method="GET" name="search_event" action="<?php echo esc_attr(get_search_result_page()); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" >
			<?php

			foreach ($args as $key => $value) {
				
				$pos = $key[-1];

				if( strpos($key,'pos') !== false ){
					switch ( $args[$key] ) {


						/* Name Event */
						case 'name_event':
						?>
						<div class="name_event field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<input type="text" class="form-control" placeholder="<?php esc_attr_e('Enter name ...', 'eventlist'); ?>" name="name_event" value="<?php echo esc_attr($selected_name_event); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
						</div>
						<?php
						break;

						/* Categories */
						case 'cat':
						?>
						<div class="categories field_search">
							<?php $cats = el_get_taxonomy('event_cat'); ?>
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<select name="cat" class="selectpicker">
								<option value=""><?php esc_html_e('All Categories ...', 'eventlist'); ?></option>
								<?php foreach ($cats as $cat) { ?>
									<option value="<?php echo esc_attr( $cat->slug ); ?>" <?php echo esc_attr( ($cat->slug == $selected_cat) ? 'selected' : '' ); ?> <?php echo esc_attr( ($cat->slug == $selected_event_cat) ? 'selected' : '' ); ?> ><?php echo esc_html( $cat->name ); ?></option>
								<?php } ?>
							</select>

						</div>
						<?php
						break;

						/* Location Autocomplete */
						case 'loc_input':
						?>
						<div class="loc_input field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<input type="text" class="form-control" placeholder="<?php esc_attr_e('State, City ...', 'eventlist'); ?>" name="loc_input" value="<?php echo esc_attr($selected_loc_input); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
						</div>
						<?php
						break;

						/* Location State */
						case 'loc_state':
						?>
						<div class="loc_state field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<?php el_get_state($selected_event_state); ?>
						</div>
						<?php
						break;

						/* Location City */
						case 'loc_city':
						?>
						<div class="loc_city field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<?php el_get_city($selected_event_city); ?>
						</div>
						<?php
						break;

						/* Venue */
						case 'venue':
						?>
						<div class="venue field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<input type="text" class="form-control" placeholder="<?php esc_html_e('Venue ...', 'eventlist'); ?>" name="name_venue" value="<?php echo esc_attr($selected_name_venue); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
						</div>
						<?php
						break;

						/* All Time */
						case 'all_time':
						$select_today = ($get_time == 'today') ? 'selected="selected"' : '';
						$select_tomorrow = ($get_time == 'tomorrow') ? 'selected="selected"' : '';
						$select_this_week = ($get_time == 'this_week') ? 'selected="selected"' : '';
						$select_this_week_end = ($get_time == 'this_week_end') ? 'selected="selected"' : '';
						$select_next_week = ($get_time == 'next_week') ? 'selected="selected"' : '';
						$select_next_month = ($get_time == 'next_month') ? 'selected="selected"' : '';
						?>
						<div class="el_all_time field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<select name="time">
								<option value="" ><?php esc_html_e('All Time', 'eventlist'); ?></option>
								<option value="today" <?php echo esc_attr( $select_today ); ?> ><?php esc_html_e('Today', 'eventlist'); ?></option>
								<option value="tomorrow" <?php echo esc_attr( $select_tomorrow ); ?> ><?php esc_html_e('Tomorrow', 'eventlist'); ?></option>
								<option value="this_week" <?php echo esc_attr( $select_this_week ); ?> ><?php esc_html_e('This Week', 'eventlist'); ?></option>
								<option value="this_week_end" <?php echo esc_attr( $select_this_week_end ); ?> ><?php esc_html_e('This Weekend', 'eventlist'); ?></option>
								<option value="next_week" <?php echo esc_attr( $select_next_week ); ?> ><?php esc_html_e('Next Week', 'eventlist'); ?></option>
								<option value="next_month" <?php echo esc_attr( $select_next_month ); ?> ><?php esc_html_e('Next Month', 'eventlist'); ?></option>
							</select>
						</div>
						<?php
						break;

						/* Start Event */
						case 'start_event':
						?>
						<div class="el_start_date field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<input type="text" class="el_select_date form-control" placeholder="<?php esc_attr_e('Start date ...', 'eventlist'); ?>" name="start_date" data-format="<?php echo esc_attr( $format ); ?>" value="<?php echo esc_attr($start_date); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
						</div>
						<?php
						break;

						/* End Event */
						case 'end_event':
						?>
						<div class="el_end_date field_search">
							<?php if ( $args['icon'.$pos] ) { ?>
								<i class="icon_field <?php echo esc_attr( $args['icon'.$pos] ); ?>"></i>
							<?php } ?>
							<input type="text" class="el_select_date form-control" placeholder="<?php esc_attr_e('End date ...', 'eventlist'); ?>" name="end_date" data-format="<?php echo esc_attr( $format ); ?>" value="<?php echo esc_attr($end_date); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
						</div>
						<?php
						break;

						default:
						// code...
						break;
					}
				}
			}
			$list_taxonomy_custom = $args['list_taxonomy_custom'];


			$arr_list_taxonomy = [];
			if( $list_taxonomy_custom && is_array( $list_taxonomy_custom ) ) {
				foreach( $list_taxonomy_custom as $taxo ) {
					$taxos = el_get_taxonomy($taxo['taxonomy_custom']);

					$name_taxos_register = '';
					if( ! empty( $list_taxonomy_register ) && is_array( $list_taxonomy_register ) ) {
						foreach( $list_taxonomy_register as $taxonomy_register ) {
							if( $taxonomy_register['slug'] == $taxo['taxonomy_custom'] ) {
								$name_taxos_register = $taxonomy_register['name'];
							}
						}
					}

					if( $taxo['taxonomy_custom'] ) { 
						$data_taxonomy_custom[$taxo['taxonomy_custom']] = '';
						$arr_list_taxonomy[] = $taxo['taxonomy_custom'];
					?>
					<div class="field_search ">
						<select name="<?php echo esc_attr( $taxo['taxonomy_custom'] ) ?>" class="selectpicker">
							<option value=""><?php echo sprintf( esc_html__( 'Select %s', 'eventlist' ), $name_taxos_register ); ?></option>
							<?php foreach( $taxos as $tax ) { 
								?>
								<option value="<?php echo esc_attr( $tax->slug ); ?>"   ><?php echo esc_html( $tax->name ); ?></option>
							<?php } ?>
						</select>
					</div>
					<?php
					}
				}
			}
			$str_json_list_taxonomy = json_encode( $arr_list_taxonomy );
			?>


			<div class="el_submit_search">
				<input type="submit" value="<?php echo esc_html($args['button_text']); ?>" class="second_font" />
			</div>

		</form>

	</div>
</div>