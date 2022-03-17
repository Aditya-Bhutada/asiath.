<?php if( ! defined( 'ABSPATH' ) ) exit();

$category = $args['category'];
$filter_event = $args['filter_event'];
$show_count_event = $args['show_count_event'];

$term = get_term_cat_event_by_slug_cat($category);
$catName = $term['cat_name'];
$link_taxonomy = $term['link'];

?>
<a href="<?php echo add_query_arg( array('status' => $filter_event), $link_taxonomy ) ?>" class="el-event-category">
	<div class="el-media">
		<?php if ($args['type'] === 'icon') : ?>
			<?php $icon = $args['icon']; ?>
			<i class="<?php echo esc_attr($icon); ?>"></i>
		<?php endif ?>

		<?php if ($args['type'] === 'image') : ?>
			<?php $image = $args['image']['url']; ?>
			<img src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr($catName) ?>">
		<?php endif ?>
	</div>
	<div class="content-cat">
		<h3 class="cate-name second_font"><?php echo esc_html($catName) ?></h3>
		<?php
		if ( $show_count_event === 'yes' ) {
			$number_event = get_number_event_by_seting_element_cat($category, $filter_event);
			?>
			<p class="count-event"><?php echo esc_html($number_event) ?><span><?php esc_html_e('Events', 'eventlist') ?></span></p>
			<?php
		}
		?>
	</div>
</a>
