<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

class EL_Elementor_Search_Map extends EL_Abstract_Elementor {

	protected $name 	= 'el_search_map';
	protected $title 	= 'Search Map';
	protected $icon 	= 'fas fa-map-marked-alt';
	
	public function get_title(){
		return __('Search Map', 'eventlist');
	}

	public function get_script_depends() {

		/* Google Maps */
		if( EL()->options->general->get('event_google_key_map') ){
			wp_enqueue_script( 'google','//maps.googleapis.com/maps/api/js?key='.EL()->options->general->get('event_google_key_map').'&libraries=places', array('jquery'), false, true);
		}else{
			wp_enqueue_script( 'google','//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places', array('jquery'), false, true);
		}
		wp_enqueue_script( 'google-marker',EL_PLUGIN_URI.'assets/libs/markerclusterer.js', array('jquery'), false, true);
		wp_enqueue_script( 'google-richmarker', EL_PLUGIN_URI.'assets/libs/richmarker-compiled.js', array('jquery'), false, true);
		
		return [ 'script-elementor' ];
	}
	
	protected function _register_controls() {

		$search_fields = array(
			'' => __('Select Search', 'eventlist'),
			'name_event' => __('Name Event', 'eventlist'),
			'location' => __('Location', 'eventlist'),
			'cat' => __('Categories', 'eventlist'),
			'all_time' => __('All Time', 'eventlist'),
			'start_event' => __('Start Date', 'eventlist'),
			'end_event' => __('End Date', 'eventlist'),
			'venue' => __('Venue', 'eventlist'),
			'loc_state' => __('State', 'eventlist'),
			'loc_city' => __('City', 'eventlist'),
		);

		$this->start_controls_section(
			'section_setting',
			[
				'label' => esc_html__( 'Settings', 'eventlist' ),
			]
		);

		$this->add_control(
			'type',
			[
				'label'   => __( 'Type', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'type1',
				'options' => [
					'type1' => __('Type 1', 'eventlist'),
					'type2' => __('Type 2', 'eventlist'),
					'type3' => __('Type 3', 'eventlist'),
					'type4' => __('Type 4', 'eventlist'),
					'type5' => __('Type 5', 'eventlist'),
				],
			]
		);

		$this->add_control(
			'column',
			[
				'label'   => __( 'Column', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'two-column',
				'options' => [
					'one-column' => __('1 Column', 'eventlist'),
					'two-column' => __('2 Columns', 'eventlist'),
					'three-column' => __('3 Columns', 'eventlist'),
				],
			]
		);

		$this->add_control(
			'show_filter',
			[
				'label' => __( 'Show Filters', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eventlist' ),
				'label_off' => __( 'Hide', 'eventlist' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'show_map',
			[
				'label' => __( 'Show Map', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eventlist' ),
				'label_off' => __( 'Hide', 'eventlist' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => __( 'Zoom Map', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 4,
				'condition' => [
					'show_map' => 'yes'
				]
			]
		);

		$this->add_control(
			'marker_option',
			[
				'label'   => __( 'Marker Select', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'icon' => __('Icon', 'eventlist'),
					'price' => __('Price', 'eventlist'),
					'date' => __('Start Date', 'eventlist'),
				],
			]
		);

		$this->add_control(
			'marker_icon',
			[
				'label' => __( 'Choose Image', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				// 'default' => [
					// 'url' => \Elementor\Utils::get_placeholder_image_src(),
				// ],
				'condition' => [
					'marker_option' => 'icon'
				]
			]
		);

		$this->add_control(
			'pos1',
			[
				'label'   => __( 'Postition 1', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'pos2',
			[
				'label'   => __( 'Postition 2', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);

		$this->add_control(
			'pos3',
			[
				'label'   => __( 'Postition 3', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'pos4',
			[
				'label'   => __( 'Postition 4', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'pos5',
			[
				'label'   => __( 'Postition 5', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);

		$this->add_control(
			'pos6',
			[
				'label'   => __( 'Postition 6', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);

		$this->add_control(
			'pos7',
			[
				'label'   => __( 'Postition 7', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);

		$this->add_control(
			'pos8',
			[
				'label'   => __( 'Postition 8', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);

		$this->add_control(
			'pos9',
			[
				'label'   => __( 'Postition 9', 'eventlist' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $search_fields,
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);


		$list_taxonomy = EL_Post_Types::register_taxonomies_customize();

		$select_list_taxonomy[''] = esc_html__( 'Select Taxonomy', 'eventlist' );
		if( ! empty( $list_taxonomy ) && is_array( $list_taxonomy ) ) {
			foreach( $list_taxonomy as $value ) {
				$select_list_taxonomy[$value['slug']] = $value['name'];
			}
		}

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'taxonomy_custom', [
				'label' => __( 'Taxonomy Custom', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $select_list_taxonomy,
			]
		);


		$this->add_control(
			'list_taxonomy_custom',
			[
				'label' => __( 'List Taxonomy Custom', 'eventlist' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'condition' => [
					'show_filter' => 'yes'
				]
			]
		);


		$this->end_controls_section();

	}

	protected function render() {

		$args = $this->get_settings();

		$template = apply_filters( 'el_elementor_search_form', 'elementor/search_map.php' );

		ob_start();
		el_get_template( $template, $args );
		echo ob_get_clean();
	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new EL_Elementor_Search_Map() );
