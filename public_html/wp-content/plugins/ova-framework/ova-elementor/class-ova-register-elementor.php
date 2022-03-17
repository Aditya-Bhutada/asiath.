<?php

namespace ova_framework;

use ova_framework\widgets\ova_menu;
use ova_framework\widgets\ova_logo;
use ova_framework\widgets\ova_header;
use ova_framework\widgets\ova_blog_slider;
use ova_framework\widgets\ova_social;
use ova_framework\widgets\ova_instagram;
use ova_framework\widgets\ova_heading;
use ova_framework\widgets\ova_feature;
use ova_framework\widgets\ova_feature_2;
use ova_framework\widgets\ova_testimonial;
use ova_framework\widgets\ova_offer_banner_1;
use ova_framework\widgets\ova_offer_banner_2;
use ova_framework\widgets\ova_skill_bar;
use ova_framework\widgets\ova_about_team;
use ova_framework\widgets\ova_contact;
use ova_framework\widgets\ova_step_plan;
use ova_framework\widgets\ova_menu_account;




if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly




/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Ova_Register_Elementor {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {

		// Register Header Footer Category in Pane
	    add_action( 'elementor/elements/categories_registered', array( $this, 'add_hf_category' ) );

	     // Register Ovatheme Category in Pane
	    add_action( 'elementor/elements/categories_registered', array( $this, 'add_ovatheme_category' ) );
	    
		
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
		

	}

	
	public  function add_hf_category(  ) {
	    \Elementor\Plugin::instance()->elements_manager->add_category(
	        'hf',
	        [
	            'title' => __( 'Header Footer', 'ova-framework' ),
	            'icon' => 'fa fa-plug',
	        ]
	    );

	}

	
	public function add_ovatheme_category(  ) {

	    \Elementor\Plugin::instance()->elements_manager->add_category(
	        'ovatheme',
	        [
	            'title' => __( 'Ovatheme', 'ova-framework' ),
	            'icon' => 'fa fa-plug',
	        ]
	    );

	}


	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova-menu.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova-logo.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova-header.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_blog_slider.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_social.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_instagram.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_heading.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_feature.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_feature_2.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_testimonial.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_offer_banner_1.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_offer_banner_2.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_skill_bar.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_about_team.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_contact.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_step_plan.php';
		require OVA_PLUGIN_PATH . 'ova-elementor/widgets/ova_menu_account.php';

		
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_menu() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_logo() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_header() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_blog_slider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_social() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_instagram() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_heading() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_feature() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_feature_2() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_testimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_offer_banner_1() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_offer_banner_2() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_skill_bar() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_about_team() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_contact() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_step_plan() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new ova_menu_account() );
		
	}
	    
	

}

new Ova_Register_Elementor();





