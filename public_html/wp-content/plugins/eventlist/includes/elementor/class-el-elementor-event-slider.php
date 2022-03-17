<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

class EL_Elementor_Event_Slider extends EL_Abstract_Elementor {

	protected $name 	= 'ova_event_slider';
	protected $title 	= 'Event Slider';
	protected $icon 	= 'fa fa-calendar-o';

	
	public function get_title(){
		return __('Event Slider', 'eventlist');
	}

	public function get_script_depends() {
		wp_enqueue_style( 'owl-carousel', EL_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.css' );
		wp_enqueue_script( 'owl-carousel', EL_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.js', array('jquery'), false, true );
		return [ 'script-elementor' ];
	}
	
	protected function _register_controls() {

		$args = array(
			'taxonomy' => 'event_cat',
			'orderby' => 'name',
			'order' => 'ASC'
		);

		$categories=get_categories($args);
		$cate_array = array();
		$arrayCateAll = array( 'all' => 'All categories ' );
		if ($categories) {
			foreach ( $categories as $cate ) {
				$cate_array[$cate->slug] = $cate->cat_name;
			}
		} else {
			$cate_array["No content Category found"] = 0;
		}



		$this->start_controls_section(
			'section_social_icon',
			[
				'label' => __( 'Event', 'eventlist' ),
			]
		);

		$this->add_control(
			'type_event',
			[
				'label' => __('Type Event', 'eventlist'),
				'type' => Controls_Manager::SELECT,
				'default' => 'type1',
				'options' => [
					'type1' => __('Type 1', 'eventlist'),
					'type2' => __('Type 2', 'eventlist'),
					'type4' => __('Type 4', 'eventlist'),
					'type5' => __('Type 5', 'eventlist'),
				]
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'eventlist' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'all',
				'options' => array_merge($arrayCateAll,$cate_array),
			]
		);

		$this->add_control(
			'total_count',
			[
				'label' => __( 'Total post', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 5,
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order Post', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => __( 'Ascending', 'eventlist' ),
					'DESC'  => __( 'Descending', 'eventlist' ),
				],
			]
		);

		$this->add_control(
			'order_by',
			[
				'label' => __( 'OrderBy Post', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __( 'Date', 'eventlist' ),
					'id'  => __( 'ID', 'eventlist' ),
					'title' => __( 'Title', 'eventlist' ),
					'start_date' => __( 'Start Date', 'eventlist' ),
				],
			]
		);


		$this->add_control(
			'filter_event',
			[
				'label' => __( 'Event status', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'all',
				'options' => [
					'all' => __( 'All', 'eventlist' ),
					'upcoming' => __( 'Upcoming', 'eventlist' ),
					'selling' => __( 'Selling', 'eventlist' ),
					'upcoming_selling' => __( 'Upcoming & Selling', 'eventlist' ),
					'closed'  => __( 'Closed', 'eventlist' ),
					'feature'  => __( 'Featured', 'eventlist' ),
				],
			]
		);

		
		$this->end_controls_section();

		/*****************************************************************
		START SECTION ADDITIONAL VERSIONT 1 TESTIMONIAL
		******************************************************************/

		$this->start_controls_section(
			'section_additional_options',
			[
				'label' => __( 'Additional Options', 'eventlist' ),
			]
		);


		$this->add_control(
			'margin_items',
			[
				'label' => __( 'Margin Right Items', 'eventlist' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 45,
			]

		);


		$this->add_control(
			'slides_to_scroll',
			[
				'label' => __( 'Slides to Scroll', 'eventlist' ),
				'type' => Controls_Manager::NUMBER,
				'description' => __( 'Set how many slides are scrolled per swipe.', 'eventlist' ),
				'default' => '1',
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __( 'Pause on Hover', 'eventlist' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'eventlist' ),
					'no' => __( 'No', 'eventlist' ),
				],
				'frontend_available' => true,
			]
		);


		$this->add_control(
			'infinite',
			[
				'label' => __( 'Infinite Loop', 'eventlist' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'eventlist' ),
					'no' => __( 'No', 'eventlist' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'eventlist' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'eventlist' ),
					'no' => __( 'No', 'eventlist' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => __( 'Autoplay Speed', 'eventlist' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'step' => 500,
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'smartspeed',
			[
				'label'   => __( 'Smart Speed', 'eventlist' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,

			]
		);

		$this->add_control(
			'nav',
			[
				'label' => __('Show Navigation', 'eventlist'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'   => __('Show dot', 'eventlist'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_elementor_event_slider', 'elementor/event_slider.php' );

		ob_start();
		
		el_get_template( $template, $settings );
		
		echo ob_get_clean();

		
	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new EL_Elementor_Event_Slider() );
