<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php
$post_id = get_the_ID();

$url_img = wp_get_attachment_image_url( get_post_thumbnail_id() , 'el_img_squa' );

if (has_image_size( 'el_img_squa' ) && has_post_thumbnail() && get_the_post_thumbnail()) {
	$url_img = wp_get_attachment_image_url( get_post_thumbnail_id() , 'el_img_squa' );
} else {
	$url_img = EL_PLUGIN_URI.'assets/img/no_tmb_square.png';
}

?>
<li class="item_event type3">
	<div class="image_feature" style="background-image: url(<?php echo $url_img ?>)" >
		<img src="<?php echo esc_url($url_img) ?>" alt="<?php echo get_the_title() ?>">
		<div class="categories">
			<?php 
			$get_cat = get_the_terms( $post_id, 'event_cat' );
			if ( !empty( $get_cat ) ) {
				foreach ( $get_cat as $v_cat ) { 
					$color_cat = get_term_meta($v_cat->term_id, '_category_color', true);
					$style = "";
					if ( $color_cat !== "" ) {
						$style = "style= 'background-color: #" . $color_cat . "'" ;
					}
					?>
					<a <?php echo $style ?> href="<?php echo esc_url(get_term_link($v_cat->term_id)) ?>"><?php echo esc_html($v_cat->name) ?></a>
					<?php
				}
			} ?>
		</div>
	</div>

	<div class="info_event">
		<div class="status-title">
			<?php 
				do_action( 'el_loop_event_title' );
				
				do_action( 'el_loop_event_status' );
			?>
		</div>
		<?php

		do_action( 'el_loop_event_ratting' );

		do_action( 'el_loop_event_time' );

		do_action( 'el_loop_event_location' );
		
		do_action( 'el_loop_event_price' );

		do_action( 'el_loop_event_favourite' );

		?>

	</div>

	
</li>



