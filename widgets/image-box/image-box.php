<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Icons_Manager;
use Elementor\Utils;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class ImageBox extends Widget_Base {

	public function get_name() {
		return 'elematic-image-box';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Image Box', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'box' ];
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_style_depends() {
		return [ 'elematic-image-box'];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image Box', 'elematic-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_control(
			'title_text',
			[
				'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'This is the heading', 'elematic-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your title', 'elematic-addons-for-elementor' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text',
			[
				'label' => esc_html__( 'Description', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elematic-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your description', 'elematic-addons-for-elementor' ),
				// 'rows' => 10,
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_size',
			[
				'label' => esc_html__( 'Title HTML Tag', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
			]
		);
		$this->add_control(
			'image_box_btn',
			[
				'label'        => esc_html__( 'Button', 'elematic-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'image_box_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'elematic-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'elematic-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter Text', 'elematic-addons-for-elementor' ),
				'condition' => [
				'image_box_btn' => 'yes'
				]
			]

		);

		$this->add_control(
			'image_box_btn_link',
			[
				'label'     => esc_html__( 'Button Link', 'elematic-addons-for-elementor' ),
				'type'      => Controls_Manager::URL,
				'dynamic'   => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'elematic-addons-for-elementor' ),
				'default'     => [
					'url' => '#',
				],
				'condition' => [
				'image_box_btn' => 'yes'
				]
			]
		);
		$this->add_control(
			'image_box_btn_icon',
			[
				'label' => esc_html__( 'Button Icon', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin'             => 'inline',
                'exclude_inline_options' => ['svg'],
                'label_block'      => false,
				'condition' => [
					'image_box_btn' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_box',
			[
				'label' => esc_html__( 'Box', 'elematic-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'position',
			[
				'label' => esc_html__( 'Image Position', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => esc_html__( 'Top', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor-position-',
				'toggle' => false,
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'content_vertical_alignment',
			[
				'label' => esc_html__( 'Vertical Alignment', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'top',
				'toggle' => false,
				'prefix_class' => 'elementor-vertical-align-',
				'condition' => [
					'position!' => 'top',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label' => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justified', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-wrapper' => 'text-align: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'image_space',
			[
				'label' => esc_html__( 'Image Spacing', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-position-right .elematic-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-left .elematic-image-box-img' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-position-top .elematic-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .elematic-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'title_bottom_space',
			[
				'label' => esc_html__( 'Content Spacing', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
					],
					'rem' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image[url]!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'image_size',
			[
				'label' => esc_html__( 'Width', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-wrapper .elematic-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .elematic-image-box-img img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-img img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab(
			'normal',
			[
				'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .elematic-image-box-img img',
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => esc_html__( 'Opacity', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover .elematic-image-box-img img',
			]
		);

		$this->add_control(
			'image_opacity_hover',
			[
				'label' => esc_html__( 'Opacity', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .elematic-image-box-img img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'elematic-addons-for-elementor' ) . ' (s)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-img img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .elematic-image-box-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[
				'name' => 'title_stroke',
				'selector' => '{{WRAPPER}} .elematic-image-box-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selector' => '{{WRAPPER}} .elematic-image-box-title',
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => esc_html__( 'Description', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} .elematic-image-box-description',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'description_shadow',
				'selector' => '{{WRAPPER}} .elematic-image-box-description',
			]
		);

		$this->add_control(
			'heading_btn',
			[
				'label' => esc_html__( 'Button', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tx_image_box_btn_color',
			[
				'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-btn a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elematic-image-box-btn svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'tx_image_box_btn_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-btn a:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elematic-image-box-btn a:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tx_image_box_btn_typography',
				'selector' => '{{WRAPPER}} .elematic-image-box-btn a',
			]
		);
		$this->add_control(
			'image_box_btn_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-image-box-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elematic-image-box-btn svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
            'image_box_btn_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-box-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_box_btn_margin',
            [
                'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-box-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

		$this->end_controls_section();
	}

	/**
	 * Render image box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
    $settings = $this->get_settings_for_display();

    $has_image = ! empty( $settings['image']['url'] );
    $has_content = ! Utils::is_empty( $settings['title_text'] ) || ! Utils::is_empty( $settings['description_text'] );
    $has_button = ! empty( $settings['image_box_btn'] ) && $settings['image_box_btn'] === 'yes';

    if ( ! $has_image && ! $has_content && ! $has_button ) {
        return;
    }

    $html = '<div class="elematic-image-box-wrapper">';

    if ( ! empty( $settings['link']['url'] ) ) {
        $this->add_link_attributes( 'link', $settings['link'] );
    }

    if ( ! empty( $settings['image_box_btn_link']['url'] ) ) {
        $this->add_link_attributes( 'btn_link', $settings['image_box_btn_link'] );
    }

    // Render the image
    if ( $has_image ) {
        $image_html = wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ) );

        if ( ! empty( $settings['link']['url'] ) ) {
            $image_html = '<a ' . $this->get_render_attribute_string( 'link' ) . ' tabindex="-1">' . $image_html . '</a>';
        }

        $html .= '<figure class="elematic-image-box-img">' . $image_html . '</figure>';
    }

    // Render content (title, description, button)
    if ( $has_content ) {
        $html .= '<div class="elematic-image-box-content">';

        // Render title
        if ( ! Utils::is_empty( $settings['title_text'] ) ) {
            $this->add_render_attribute( 'title_text', 'class', 'elematic-image-box-title' );
            $this->add_inline_editing_attributes( 'title_text', 'none' );

            $title_html = $settings['title_text'];

            if ( ! empty( $settings['link']['url'] ) ) {
                $title_html = '<a ' . $this->get_render_attribute_string( 'link' ) . '>' . $title_html . '</a>';
            }

            $html .= sprintf( '<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag( $settings['title_size'] ), $this->get_render_attribute_string( 'title_text' ), $title_html );
        }

        // Render description
        if ( ! Utils::is_empty( $settings['description_text'] ) ) {
            $this->add_render_attribute( 'description_text', 'class', 'elematic-image-box-description' );
            $this->add_inline_editing_attributes( 'description_text' );

            $html .= sprintf( '<p %1$s>%2$s</p>', $this->get_render_attribute_string( 'description_text' ), $settings['description_text'] );
        }

        // Render button
        if ( $has_button ) {
            $btn_html = $settings['image_box_btn_text'];

            // Render the button icon
            $icon_html = '';
            if ( ! empty( $settings['image_box_btn_icon']['value'] ) ) {
                ob_start(); // Start capturing the output
                Icons_Manager::render_icon( $settings['image_box_btn_icon'], [ 'aria-hidden' => 'true' ] );
                $icon_html = ob_get_clean(); // Store the rendered icon into a variable
            }

            $btn_html = $btn_html . $icon_html;

            if ( ! empty( $settings['image_box_btn_link']['url'] ) ) {
                $btn_html = '<a ' . $this->get_render_attribute_string( 'btn_link' ) . '>' . $btn_html . '</a>';
            }

            $html .= '<div class="elematic-image-box-btn">' . $btn_html . '</div>';
        }

        $html .= '</div>'; // Close .elematic-image-box-content
    }

    $html .= '</div>'; // Close .elematic-image-box-wrapper

    Utils::print_unescaped_internal_string( $html );
}

}