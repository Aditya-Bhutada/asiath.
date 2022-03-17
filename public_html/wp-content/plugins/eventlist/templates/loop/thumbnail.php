<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>
<?php

	$archive_type = EL_Setting::instance()->event->get( 'archive_type', 'type1' );
	$archive_column = EL_Setting::instance()->event->get( 'archive_column', 'two-column' );

	$archive_type = isset ( $_GET['type_event'] ) ? sanitize_text_field( $_GET['type_event'] ) : $archive_type;

	$archive_column = isset ( $_GET['layout_event'] ) ? sanitize_text_field( $_GET['layout_event'] ) : $archive_column;

	if ( $archive_type === 'type1' ||  $archive_type === 'type2' || $archive_type === 'type3' ) {
		$no_img_tmb = apply_filters( 'el_img_no_tmb', EL_PLUGIN_URI.'assets/img/no_tmb_square.png' );
		$img_tmb = apply_filters( 'el_img_tmb_squa', 'el_img_squa' );
	}else if ( $archive_type === 'type4' || $archive_type === 'type5' ) {
		$no_img_tmb = apply_filters( 'el_img_no_tmb', EL_PLUGIN_URI.'assets/img/no_tmb_rec.png' );
		$img_tmb = apply_filters( 'el_img_tmb_rec', 'el_img_rec' );
	}

	if( $archive_column == 'two-column' ){
		$no_img_tmb = apply_filters( 'el_img_no_tmb', EL_PLUGIN_URI.'assets/img/no_tmb_rec.png' );
		$img_tmb = apply_filters( 'el_img_tmb_rec', 'el_img_rec' );
	}
	
	
	

	if( has_post_thumbnail() && get_the_post_thumbnail() ){

		$post_thumbnail_url = has_image_size( $img_tmb ) ?  get_the_post_thumbnail_url( get_the_id(), $img_tmb ) : get_the_post_thumbnail_url( get_the_id(), 'full' );
	}else{
		$post_thumbnail_url = $no_img_tmb;
	}
?>

	<div class="thumbnail_figure">

		<!-- Thumbnail -->
		<a href="<?php the_permalink(); ?>">
			<img src="<?php echo esc_url( $post_thumbnail_url ); ?> " alt="<?php the_title(); ?>" />
		</a>
		
	</div>


	
	