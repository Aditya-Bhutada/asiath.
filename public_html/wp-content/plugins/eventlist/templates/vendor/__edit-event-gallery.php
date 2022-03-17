<?php if ( !defined( 'ABSPATH' ) ) exit();


$post_id = isset( $_REQUEST['id'] ) ? $_REQUEST['id'] : '';

$_prefix = OVA_METABOX_EVENT;

$gallery = get_post_meta( $post_id, $_prefix.'gallery', true) ? get_post_meta( $post_id, $_prefix.'gallery', true) : '';


$link_video = get_post_meta( $post_id, $_prefix.'link_video', true) ? get_post_meta( $post_id, $_prefix.'link_video', true) : '';


$single_banner = get_post_meta( $post_id, $_prefix.'single_banner', true) ? get_post_meta( $post_id, $_prefix.'single_banner', true) : 'thumbnail';
$image_banner = get_post_meta( $post_id, $_prefix.'image_banner', true) ? get_post_meta( $post_id, $_prefix.'image_banner', true) : '';
?>

<!-- Image Gallery -->
<div class="image_gallery">
	
	
	
	<div class="gallery_list">
		<?php if ($gallery) : foreach ($gallery as $key => $value) : $image = wp_get_attachment_image_src($value, 'el_thumbnail'); ?>
			<div class="gallery_item">
				<input type="hidden" class="gallery_id" name="<?php echo esc_attr( $_prefix.'gallery['.$key.']' ); ?>" value="<?php echo esc_attr($value); ?>">
				
				<img class="image-preview" src="<?php echo esc_url($image[0]); ?>">
				
				
				<a class="change_image_gallery button" href="#" data-uploader-title="<?php esc_attr_e( "Change image", 'eventlist' ); ?>" data-uploader-button-text="<?php esc_attr_e( "Change image", 'eventlist' ); ?>">
					<i class="fas fa-edit"></i>
				</a>

				<a class="remove_image" href="#">
					<i class="far fa-trash-alt"></i>
				</a>
			
				

			</div>
		<?php endforeach; endif; ?>
	</div>

	<a class="add_image_gallery button" href="#" data-uploader-title="<?php esc_attr_e( "Add Gallery", 'eventlist' ); ?>" data-uploader-button-text="<?php esc_attr_e( "Add image(s)", 'eventlist' ); ?>"><?php esc_html_e( "Add Gallery", 'eventlist' ); ?></a>
	


</div>


<!-- Video -->
<div class="link_video vendor_field">

	<h4 class="heading_section">
		<?php esc_html_e( 'Video', 'eventlist' ); ?>
	</h4>
	
	<div class="wrap_link">
		<input type="text" id="link_video" name="<?php echo esc_attr($_prefix.'link_video'); ?>" value="<?php echo esc_attr( $link_video ); ?>" placeholder="<?php esc_html_e( 'https://', 'eventlist' ); ?>" autocomplete="nope" autocorrect="off" autocapitalize="none" />
		

		
	</div>
	<label class="label"><?php esc_html_e( 'Embed Link Video:', 'eventlist' ); ?>
		<?php esc_html_e( '(Ex: https://www.youtube.com/watch?v=5wZ9LcEbulg )', 'eventlist' );  ?>
		<br>
		<?php esc_html_e( 'or Vimeo: https://player.vimeo.com/video/23534361', 'eventlist' ); ?></label>
</div>


<!-- Single Banner -->
<div class="wrap_single_banner vendor_field">
	<label class="label"><?php esc_html_e( 'Display Top Banner of event detailt at frontend:', 'eventlist' ); ?></label>
	
	<div class="radio_single_banner">
		<span> <input type="radio" name="<?php echo esc_attr( $_prefix.'single_banner' ) ?>" class="single_banner" id="single_banner" value="<?php echo esc_attr('thumbnail'); ?>"  <?php if ($single_banner == 'thumbnail' || $single_banner == '') echo esc_attr('checked') ; ?>  > <?php esc_html_e( 'Image', 'eventlist' ); ?> </span>
	
		<span> <input type="radio" name="<?php echo esc_attr( $_prefix.'single_banner' ) ?>" class="single_banner" id="single_banner" value="<?php echo esc_attr('gallery'); ?>" <?php if ($single_banner == 'gallery') echo esc_attr('checked') ; ?> > <?php esc_html_e( 'Gallery', 'eventlist' ); ?> </span>
	</div>

</div>