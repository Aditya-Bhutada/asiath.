<?php if( ! defined( 'ABSPATH' ) ) exit(); ?>

<?php
$id = get_the_id();
$banner_url = [];

$banner_opt =  get_post_meta( $id, OVA_METABOX_EVENT.'single_banner', true );

$img_tmb = has_image_size( 'thumbnail_single_page' ) ? 'thumbnail_single_page' : 'full';

if( $banner_opt == 'thumbnail' ){
	
	$banner_url[] = get_the_post_thumbnail_url( $id, $img_tmb );

}else if( $banner_opt == 'gallery' ){

	$id_images = get_post_meta( $id, OVA_METABOX_EVENT.'gallery', true );

	if( is_array($id_images) && count($id_images) > 0 ){
		$img_tmb = has_image_size( 'el_img_squa' ) ? 'el_img_squa' : 'full';
		foreach ($id_images as $key => $value) {
			$banner_url[] = wp_get_attachment_image_src( $value, $img_tmb );
		}
	}else{
		$banner_url[] = get_the_post_thumbnail_url( $id, $img_tmb );
	}

}else if( has_post_thumbnail() ){
	$banner_url[] = get_the_post_thumbnail_url( $id, $img_tmb );
}

?>
<?php if( count( $banner_url ) == 1 && $banner_url[0] ){ ?>
	<div class="event-banner">
		<div class="single-banner" style="background-image: url( <?php echo esc_url( $banner_url[0] ); ?> ) "></div>
	</div>
	
<?php }else if ( count( $banner_url ) > 1  ){ ?>
	<div class="event-banner">
		<div class="gallery-banner">
			<?php if( !empty($banner_url) ): ?>

				<ul class="wrap_event owl-carousel owl-theme">
					<?php foreach ($banner_url as $url) : ?>
						<li>
							<img src="<?php echo esc_url($url[0]) ?>" alt="<?php the_title(); ?>">
						</li>
					<?php endforeach;// end foreach. ?>
				</ul>

			<?php endif; ?>
		</div>
	</div>
<?php } ?>

