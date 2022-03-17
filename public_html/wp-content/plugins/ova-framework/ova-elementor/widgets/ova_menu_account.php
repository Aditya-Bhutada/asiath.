<?php

namespace ova_framework\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ova_menu_account extends Widget_Base {

	public function get_name() {
		return 'ova_menu_account';
	}

	public function get_title() {
		return __( 'Menu Account', 'ova-framework' );
	}

	public function get_icon() {
		return 'fa fa-user-o';
	}

	public function get_categories() {
		return [ 'ovatheme' ];
	}

	public function get_script_depends() {
		return [ 'script-elementor' ];
	}

	protected function _register_controls() {


		$this->start_controls_section(
			'section_heading_content',
			[
				'label' => __( 'Content', 'ova-framework' ),
			]
		);


		$this->add_control(
			'icon_login',
			[
				'label'   => __( 'Icon my account', 'ova-framework' ),
				'type'    => Controls_Manager::TEXT,
				'default' => "fa fa-user-o",
			]
		);


		$this->add_control(
			'text_login',
			[
				'label'   => __( 'Text Login', 'ova-framework' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __("Login", "ova-framework"),
			]
		);

		

		$this->add_control(
			'icon_register',
			[
				'label'   => __( 'Icon Register', 'ova-framework' ),
				'type'    => Controls_Manager::TEXT,
			]
		);

		
		$this->add_control(
			'text_register',
			[
				'label'   => __( 'Text Register', 'ova-framework' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __("Register", "ova-framework"),
			]
		);

		

		
		$this->add_control(
			'text_my_account',
			[
				'label'   => __( 'Text my account', 'ova-framework' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __("My account", "ova-framework"),
			]
		);

		$this->add_control(
			'link_login',
			[
				'label' => __( 'Custom Login Link', 'ova-framework' ),
				'description' => __( 'You can empty this field', 'ova-framework' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'ova-framework' ),
				'show_external' => false,
			]
		);

		$this->add_control(
			'link_register',
			[
				'label' => __( 'Custom Register Link', 'ova-framework' ),
				'description' => __( 'You can empty this field', 'ova-framework' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'ova-framework' ),
				'show_external' => false,
				
			]
		);


		

		$this->end_controls_section();


		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon', 'ova-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'font-size-ion',
			[
				'label' => __( 'Font size icon', 'ova-framework' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ova-menu-acount .login i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ova-menu-acount .register i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ova-menu-acount .my-account i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'color_icon',
			[
				'label' => __( 'Color ', 'ova-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ova-menu-acount .login i' => 'color : {{VALUE}};',
					'{{WRAPPER}} .ova-menu-acount .register i' => 'color : {{VALUE}};',
					'{{WRAPPER}} .ova-menu-acount .my-account i' => 'color : {{VALUE}};',
				],
			]
		);


		$this->add_responsive_control(
			'margin_icon',
			[
				'label' => __( 'Margin', 'ova-framework' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ova-menu-acount .login i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ova-menu-acount .register i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ova-menu-acount .my-account i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'ova-framework' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ova-menu-acount .login a, {{WRAPPER}} .ova-menu-acount .register a, {{WRAPPER}} .ova-menu-acount .my-account a',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'color_title',
			[
				'label' => __( 'Color', 'ova-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ova-menu-acount .login a, 
					{{WRAPPER}} .ova-menu-acount .register a, 
					{{WRAPPER}} .ova-menu-acount .my-account a' => 'color : {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'color_title_hover',
			[
				'label' => __( 'Color hover', 'ova-framework' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ova-menu-acount .login a:hover, 
					{{WRAPPER}} .ova-menu-acount .register a:hover, 
					{{WRAPPER}} .ova-menu-acount .my-account a:hover' => 'color : {{VALUE}};',
				],
			]
		);


		$this->add_responsive_control(
			'margin_title',
			[
				'label' => __( 'Margin', 'ova-framework' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ova-menu-acount .login a, {{WRAPPER}} .ova-menu-acount .register a, {{WRAPPER}} .ova-menu-acount .my-account a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings();


		// Register
		$icon_register = $settings['icon_register'];
		$text_register = $settings['text_register'];
		$link_register_attr = '';
		if( $settings['link_register']['url'] ){
			$link_register = $settings['link_register']['url'];
			$this->add_link_attributes( 'link_register', $settings['link_register'] );
			$link_register_attr = $this->get_render_attribute_string( 'link_register' );
		}else{
			$link_register = wp_registration_url();
		}

		
		// Login
		$icon_login = $settings['icon_login'];
		$text_login = $settings['text_login'];
		$link_login_attr = '';
		if( $settings['link_login']['url'] ){
			$link_login = $settings['link_login']['url'];
			$this->add_link_attributes( 'link_login', $settings['link_login'] );
			$link_login_attr = $this->get_render_attribute_string( 'link_login' );
		}else{
			$link_login = wp_login_url();
		}
		
		
		$text_my_account = $settings['text_my_account'];
		$link_my_account = '#';
		if( function_exists( 'EL' ) ){

			$my_account_id = EL()->options->general->get( 'myaccount_page_id' );
			$link_my_account = get_the_permalink( $my_account_id );
		}

		?>
		<div class="ova-menu-acount">
			<?php if (!is_user_logged_in()) { ?>
				<span class="login">
					
					<?php if($text_login && $link_login) : ?>
						<a href="<?php echo esc_attr($link_login) ?>" <?php echo $link_login_attr; ?> >
							<?php if($icon_login) : ?>
								<i class="<?php echo $icon_login ?>"></i>
							<?php endif ?>
							<?php echo esc_html($text_login) ?>
						</a>
					<?php endif ?>
				</span>
				<span class="slash">|</span>
				<span class="register">
					
					<?php if($text_register && $link_register) : ?>
						<a href="<?php echo esc_attr($link_register) ?>" <?php echo $link_register_attr; ?> >
							<?php if($icon_register) : ?>
								<i class="<?php echo $icon_login ?>"></i>
							<?php endif ?>
							<?php echo esc_html($text_register) ?>
						</a>
					<?php endif ?>
				</span>
			<?php } else { ?>

				<?php 

					$author_id = get_current_user_id();
					
					$author_id_image = get_user_meta( $author_id, 'author_id_image', true ) ? get_user_meta( $author_id, 'author_id_image', true ) : '';
					if ( $author_id_image ) {
						$img_path = wp_get_attachment_image_url($author_id_image, 'el_thumbnail') ? wp_get_attachment_image_url($author_id_image, 'el_thumbnail') : wp_get_attachment_image_url($author_id_image, 'full');
					} else {

						$img_path = get_avatar_url($author_id);

					}

				 ?>
				<span class="my-account">
					
					<?php if($text_my_account && $link_my_account) : ?>
						<a href="<?php echo esc_attr($link_my_account) ?>">

							<img src="<?php echo esc_url( $img_path ); ?> " alt="<?php echo esc_html($text_my_account) ?>" width="30" height="30" class="author_img">
							
							<?php echo esc_html($text_my_account) ?>
						</a>
					<?php endif ?>
				</span>
			<?php } ?>

		</div>
		<?php
	}
}


