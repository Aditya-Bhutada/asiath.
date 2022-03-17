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

class EL_Elementor_Menu_Event_Price extends EL_Abstract_Elementor {

	protected $name 	= 'el_menu_event_price';
	protected $title 	= 'Menu event price';
	protected $icon 	= 'fas fa-bars';
	
	public function get_title(){
		return __('Menu event price', 'eventlist');
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
			'section_setting',
			[
				'label' => esc_html__( 'Settings', 'eventlist' ),
			]
		);

		$this->add_control(
			'type_format',
			[
				'label'   => __( 'Format display', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'min',
				'options' => [
					'min' => __('Min', 'eventlist'),
					'max' => __('Max', 'eventlist'),
					'min-max' => __('Min to Max', 'eventlist'),
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$args = $this->get_settings();

		$template = apply_filters( 'el_elementor_menu_event_price', 'elementor/menu_event_price.php' );

		ob_start();
		el_get_template( $template, $args );
		echo ob_get_clean();

		
	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new EL_Elementor_Menu_Event_Price() );
