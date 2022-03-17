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

class EL_Elementor_Location_Event extends EL_Abstract_Elementor {

	protected $name 	= 'el_location_event';
	protected $title 	= 'Location Event';
	protected $icon 	= 'fas fa-map-marker-alt';

	public function get_title(){
		return __('Location Event', 'eventlist');
	}
	
	public function get_script_depends() {
		wp_enqueue_style( 'owl-carousel', EL_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.css' );
		wp_enqueue_script( 'owl-carousel', EL_PLUGIN_URI.'assets/libs/owl-carousel/owl.carousel.min.js', array('jquery'), false, true );
		return [ 'script-elementor' ];
	}

	protected function _register_controls() {

		$args = array(
			'orderby' => 'name',
			'order' => 'ASC'
		);

		$locations = get_terms('event_loc', $args);
		$loc_array = array();
		if ($locations) {
			foreach ( $locations as $loc ) {
				$loc_array[$loc->term_id] = $loc->name;
			}
		}


		$this->start_controls_section(
			'section_setting',
			[
				'label' => __( 'Settings', 'eventlist' ),
			]
		);

		$this->add_control(
			'filter_event',
			[
				'label' => __( 'Event status', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'upcoming',
				'options' => [
					'upcoming' => __( 'Upcoming', 'eventlist' ),
					'selling' => __( 'Selling', 'eventlist' ),
					'closed'  => __( 'Closed', 'eventlist' ),
					'feature'  => __( 'Featured', 'eventlist' ),
					'all' => __( 'All', 'eventlist' ),
				],
			]
		);

		$this->add_control(
			'show_count_event',
			[
				'label' => __( 'Show number event', 'eventlist' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Yes', 'eventlist' ),
					'no' => __( 'No', 'eventlist' ),
				],
				
			]
		);


		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'location',
			[
				'label' => __( 'Location', 'eventlist' ),
				'type' => Controls_Manager::SELECT,
				'options' => $loc_array,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => __( 'Image', 'eventlist' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);


		$this->add_control(
			'tabs',
			[
				'label'       => 'Item',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();



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
				'default' => 30,
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
				'default' => 'no',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'   => __('Show dot', 'eventlist'),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);



		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings();

		$template = apply_filters( 'el_elementor_event_location', 'elementor/event_location.php' );

		ob_start();
		
		el_get_template( $template, $settings );
		
		echo ob_get_clean();

		
	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new EL_Elementor_Location_Event() );
