<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class IconBox extends Widget_Base {

	public function get_name() {
		return 'elematic-icon-box';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Icon Box', 'elematic-addons-for-elementor' );
	}
	public function get_style_depends() {
        return [ 'elematic-icon-box' ];
    }
	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'icon', 'box' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'ib_settings',
			[
				'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
			]
		);
		$this->add_responsive_control(
			'ib_select',
			[
				'label' => esc_html__( 'Select Icon or Image', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'icon' => [
						'title' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
						'icon' => 'far fa-smile-beam',
					],
					'image' => [
						'title' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
						'icon' => 'far fa-image',
					]
				],
				'default' => 'icon',
			]
		);
		$this->add_control(
			'ib_icon',
			[
				'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-snowflake',
					'library' => 'fa-solid',
				],
				'condition' => [
					'ib_select' => 'icon'
				]
			]
		);
		$this->add_control(
			'ib_image',
			[
				'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'ib_select' => 'image'
				]
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'full',
                'condition' => [
					'ib_select' => 'image'
				]
            ]
        );
		$this->add_control(
			'ib_style',
			[
				'label' => esc_html__( 'Layout', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-1' => esc_html__( 'Style 1', 'elematic-addons-for-elementor' ),
					'style-2' => esc_html__( 'Style 2', 'elematic-addons-for-elementor' ),
					'style-3' => esc_html__( 'Style 3', 'elematic-addons-for-elementor' ),
				],
				'default' => 'style-1',
			]
		);
		$this->add_control(
			'ib_position',
			[
				'label' => esc_html__( 'Position', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-v-align-middle',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'toggle' => false,
			]
		);
		$this->add_control(
			'ib_icon_space_vertical_left',
			[
				'label' => esc_html__( 'Icon Spacing Vertical', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 300,
					],
				],
				'condition' => [
					'ib_position' => 'left',
					'ib_style' => 'style-2',
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-wrap.style-2.left .elematic-icon-box-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'ib_icon_space_horizontal_left',
			[
				'label' => esc_html__( 'Icon Spacing Horizontal', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 300,
					],
				],
				'condition' => [
					'ib_position' => 'left',
					'ib_style' => 'style-2'
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-wrap.style-2.left .elematic-icon-box-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'ib_icon_space_vertical_right',
			[
				'label' => esc_html__( 'Icon Spacing Vertical', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 300,
					],
				],
				'condition' => [
					'ib_position' => 'right',
					'ib_style' => 'style-2'
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-wrap.style-2.right .elematic-icon-box-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'ib_icon_space_horizontal_right',
			[
				'label' => esc_html__( 'Icon Spacing Horizontal', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 300,
					],
				],
				'default' => [
					'size' => 20,
				],
				'condition' => [
					'ib_position' => 'right',
					'ib_style' => 'style-2'
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-wrap.style-2.right .elematic-icon-box-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'ib_title',
			[
				'label'   => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default'     => esc_html__( 'This is the title', 'elematic-addons-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
            'ib_html_tag',
            [
                'label'     => esc_html__( 'HTML Tag', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h3',
                'options'   => [
                        'h1'    => 'H1',
                        'h2'    => 'H2',
                        'h3'    => 'H3',
                        'h4'    => 'H4',
                        'h5'    => 'H5',
                        'h6'    => 'H6',
                        'div'   => 'div',
                        'span'  => 'Span',
                        'p'     => 'P'
                    ],
            ]
        );
		$this->add_control(
			'ib_link',
			[
				'label'        => esc_html__( 'Title Link', 'elematic-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'ib_link_url',
			[
				'label'       => esc_html__( 'Title Link URL', 'elematic-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'condition'   => [
				 'ib_link' => 'yes'
				]
			]
		);

		$this->add_control(
			'ib_desc',
			[
				'label'   => esc_html__( 'Description', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'default'     => esc_html__( 'Suspendisse potenti hasellus euismod libero in neque molestie et mentum libero maximus. Etiam in enim vestibulum suscipit sem quis molestie nibh.', 'elematic-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your description', 'elematic-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'ib_btn',
			[
				'label'        => esc_html__( 'Button', 'elematic-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'ib_btn_text',
			[
				'label'       => esc_html__( 'Button Text', 'elematic-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Read More', 'elematic-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter Text', 'elematic-addons-for-elementor' ),
				'condition' => [
				'ib_btn' => 'yes'
				]
			]

		);

		$this->add_control(
			'ib_btn_link',
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
				'ib_btn' => 'yes'
				]
			]
		);
		$this->add_control(
			'ib_btn_icon',
			[
				'label' => esc_html__( 'Button Icon', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'tx_selected_icon',
                'skin'             => 'inline',
                'exclude_inline_options' => ['svg'],
                'label_block'      => false,
				'condition' => [
					'ib_btn' => 'yes'
				]
			]
		);

		$this->add_control(
			'ib_btn_icon_position',
			[
				'label' => esc_html__( 'Button Icon Position', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'before' => esc_html__( 'Before', 'elematic-addons-for-elementor' ),
					'after' => esc_html__( 'After', 'elematic-addons-for-elementor' ),
				],
				'condition' => [
					'ib_btn' => 'yes'
				],
			]
		);

		$this->add_control(
			'ib_btn_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 500,
					],
				],
				'condition' => [
					'ib_btn' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-ib-btn-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elematic-ib-btn-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'ib_styles',
            [
                'label'                 => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'ib_normal',
			[
				'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
			]
		);
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'ib_bg',
				'selector'  => '{{WRAPPER}} .elematic-icon-box-wrap',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ib_bg_border',
				'selector'    => 	'{{WRAPPER}} .elematic-icon-box-wrap'
			]
		);
		$this->add_responsive_control(
			'ib_bg_border_radius',
			[
				'label'      => esc_html__( 'Background Border Radius', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elematic-icon-box-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ib_bg_shadow',
				'selector' => '{{WRAPPER}} .elematic-icon-box-wrap'
			]
		);
		$this->add_control(
			'ib_bg_rotate',
			[
				'label'   => esc_html__( 'Rotate', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-wrap'   => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);
		$this->add_responsive_control(
            'ib_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'ib_icon_color',
            [
                'label' => esc_html__('Icon Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-icon-box-icon svg' => 'fill: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'ib_icon_bg_color',
            [
                'label' => esc_html__('Icon Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-icon img, {{WRAPPER}} .elematic-icon-box-icon svg' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ib_icon_size',
            [
                'label' => esc_html__('Icon Size', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'max' => 999,
                    ],
                
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-icon img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-icon-box-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-icon-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );
        $this->add_control(
			'ib_icon_rotate',
			[
				'label'   => esc_html__( 'Icon Rotate', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-icon img'   => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .elematic-icon-box-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
					'{{WRAPPER}} .elematic-icon-box-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ib_icon_border',
				'selector'    => 	'{{WRAPPER}} .elematic-icon-box-icon img, {{WRAPPER}} .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-icon svg'
			]
		);
		$this->add_responsive_control(
			'ib_icon_border_radius',
			[
				'label'      => esc_html__( 'Icon Border Radius', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elematic-icon-box-icon img, {{WRAPPER}} .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-icon svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
            'ib_icon_padding',
            [
                'label' => esc_html__( 'Icon Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-icon img, {{WRAPPER}} .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-icon svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		$this->add_responsive_control(
			'ib_icon_margin',
			[
				'label'      => esc_html__( 'Icon Margin', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elematic-icon-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ib_icon_shadow',
				'selector' => '{{WRAPPER}} .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-icon img, {{WRAPPER}} .elematic-icon-box-icon svg'
			]
		);
        $this->add_control(
            'ib_title_color',
            [
                'label' => esc_html__('Title Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'ib_title_typography',
				'selector'  => '{{WRAPPER}} .elematic-icon-box-title',
			]
		);
        $this->add_control(
            'ib_desc_color',
            [
                'label' => esc_html__('Description Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-desc' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'ib_desc_typography',
				'selector'  => '{{WRAPPER}} .elematic-icon-box-desc, {{WRAPPER}} .elematic-icon-box-desc p, {{WRAPPER}} .elematic-icon-box-desc div, {{WRAPPER}} .elematic-icon-box-desc span, {{WRAPPER}} .elematic-icon-box-desc h1, {{WRAPPER}} .elematic-icon-box-desc h2, {{WRAPPER}} .elematic-icon-box-desc h3, {{WRAPPER}} .elematic-icon-box-desc h4, {{WRAPPER}} .elematic-icon-box-desc h5, {{WRAPPER}} .elematic-icon-box-desc h6',
			]
		);
		$this->add_control(
            'ib_btn_color',
            [
                'label' => esc_html__('Button Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-icon-box-btn svg' => 'fill: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'ib_btn_bg_color',
            [
                'label' => esc_html__('Button Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'ib_btn_typography',
				'selector'  => '{{WRAPPER}} .elematic-icon-box-btn',
			]
		);
		$this->add_responsive_control(
            'ib_btn_icon_size',
            [
                'label' => esc_html__('Button Icon Size', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em' ],
                'range' => [
                    'px' => [
                        'max' => 150,
                    ],
                
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-btn svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ib_btn_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => 	'{{WRAPPER}} .elematic-icon-box-btn'
			]
		);
		$this->add_responsive_control(
			'ib_btn_border_radius',
			[
				'label'      => esc_html__( 'Button Border Radius', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elematic-icon-box-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_responsive_control(
            'ib_btn_padding',
            [
                'label' => esc_html__( 'Button Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ib_btn_margin',
            [
                'label' => esc_html__( 'Button Space', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-btn-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
			'ib_hover',
			[
				'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
			]
		);
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'ib_bg_hov',
				'selector'  => '{{WRAPPER}} .elematic-icon-box-wrap:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ib_bg_border_hov',
				'selector'    => 	'{{WRAPPER}} .elematic-icon-box-wrap:hover'
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ib_bg_hov_shadow',
				'selector' => '{{WRAPPER}} .elematic-icon-box-wrap:hover'
			]
		);
		$this->add_control(
			'ib_bg_rotate_hov',
			[
				'label'   => esc_html__( 'Hover Rotate', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-wrap:hover'   => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);
		$this->add_control(
            'ib_icon_hov_color',
            [
                'label' => esc_html__('Icon Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon svg' => 'fill: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'ib_icon_bg_hov_color',
            [
                'label' => esc_html__('Icon Background Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon svg,{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ib_icon_border_hov',
				'selector'    => 	'{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon svg, {{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon img'
			]
		);
		$this->add_control(
			'ib_icon_rotate_hov',
			[
				'label'   => esc_html__( 'Icon Rotate Hover', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'range' => [
					'deg' => [
						'max'  => 360,
						'min'  => -360,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon i, {{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon svg, {{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-icon img'   => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);
        $this->add_control(
            'ib_title_hov_color',
            [
                'label' => esc_html__('Title Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'ib_desc_hov_color',
            [
                'label' => esc_html__('Description Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-wrap:hover .elematic-icon-box-desc' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ib_btn_hov_color',
            [
                'label' => esc_html__('Button Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-btn:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-icon-box-btn:hover svg' => 'fill: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'ib_btn_bg_hov_color',
            [
                'label' => esc_html__('Button Background Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-icon-box-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ib_btn_hov_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => 	'{{WRAPPER}} .elematic-icon-box-btn:hover'
			]
		);



		$this->end_controls_tab();



        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$target = isset( $settings['ib_link_url']['is_external'] ) && $settings['ib_link_url']['is_external'] ? '_blank' : '_self';
		$target_btn = isset( $settings['ib_btn_link']['is_external'] ) && $settings['ib_btn_link']['is_external'] ? '_blank' : '_self';
		$migrated  = isset( $settings['__fa4_migrated']['ib_btn_icon'] );
        $is_new    = empty( $settings['tx_selected_icon'] ) && Icons_Manager::is_migration_allowed();

		?>	
		<div class="elematic-icon-box-wrap <?php echo esc_attr($settings['ib_style'] . ' ' . $settings['ib_position']); ?>">

			<div class="elematic-icon-box-icon">
				<?php 
					if ($settings['ib_select'] == 'icon') { 
						Icons_Manager::render_icon( $settings['ib_icon'], [ 'aria-hidden' => 'true' ] );
					}
					if ($settings['ib_select'] == 'image') { ?>
						<?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'image', 'ib_image' ); ?>
					<?php }
				?>

				<?php if($settings['ib_style'] == 'style-3') : ?>
				<?php if($settings['ib_link'] == 'yes') : ?>
				<a href="<?php echo esc_url($settings['ib_link_url']['url']); ?>" target="<?php echo esc_attr($target); ?>">
				<<?php echo esc_attr($settings['ib_html_tag']); ?> class="elematic-icon-box-title">
				<?php echo wp_kses_post($settings['ib_title']); ?>
				</<?php echo esc_attr($settings['ib_html_tag']); ?>>
				</a>
				<?php else : ?>
				<<?php echo esc_attr($settings['ib_html_tag']); ?> class="elematic-icon-box-title">
				<?php echo wp_kses_post($settings['ib_title']); ?>
				</<?php echo esc_attr($settings['ib_html_tag']); ?>>
				<?php endif; ?>
				<?php endif; ?>

			</div><!-- elematic-icon-box-icon -->

			<div class="elematic-icon-box-content-wrap">

				<?php if($settings['ib_style'] == 'style-1' || $settings['ib_style'] == 'style-2') : ?>
				<?php if($settings['ib_link'] == 'yes') : ?>
				<a href="<?php echo esc_url($settings['ib_link_url']['url']); ?>" target="<?php echo esc_attr($target); ?>">
				<<?php echo esc_attr($settings['ib_html_tag']); ?> class="elematic-icon-box-title">
				<?php echo wp_kses_post($settings['ib_title']); ?>
				</<?php echo esc_attr($settings['ib_html_tag']); ?>>
				</a>
				<?php else : ?>
				<<?php echo esc_attr($settings['ib_html_tag']); ?> class="elematic-icon-box-title">
				<?php echo wp_kses_post($settings['ib_title']); ?>
				</<?php echo esc_attr($settings['ib_html_tag']); ?>>
				<?php endif; ?>
				<?php endif; ?>

				<div class="elematic-icon-box-desc"><?php echo wp_kses_post($settings['ib_desc']); ?></div>
				<?php if($settings['ib_btn'] == 'yes') : ?>
				<div class="elematic-icon-box-btn-wrap">
					<a class="elematic-icon-box-btn" href="<?php echo esc_url($settings['ib_btn_link']['url']); ?>" target="<?php echo esc_attr($target_btn); ?>">
						

						<?php if ( ! empty( $settings['ib_btn_icon']['value'] ) && $settings['ib_btn_icon_position'] =='before' ) :
			                if ( $is_new || $migrated ) :
			                    Icons_Manager::render_icon( $settings['ib_btn_icon'], [ 'aria-hidden' => 'true', 'class' => 'elematic-ib-btn-icon-before'] );
			                else :
			             ?>
			                <i class="<?php echo esc_attr($settings['tx_selected_icon']); ?> elematic-ib-btn-icon-before" aria-hidden="true"></i>
			            <?php endif; ?>
			            <?php endif; ?>


						<?php echo esc_html($settings['ib_btn_text']); ?>

						<?php if ( ! empty( $settings['ib_btn_icon']['value'] ) && $settings['ib_btn_icon_position'] =='after' ) :
			                if ( $is_new || $migrated ) :
			                    Icons_Manager::render_icon( $settings['ib_btn_icon'], [ 'aria-hidden' => 'true', 'class' => 'elematic-ib-btn-icon-after'] );
			                else :
			             ?>
			                <i class="<?php echo esc_attr($settings['tx_selected_icon']); ?> elematic-ib-btn-icon-after" aria-hidden="true"></i>
			            <?php endif; ?>
			            <?php endif; ?>

					</a>
				</div><!-- elematic-icon-box-btn-wrap -->
				<?php endif; ?>
			</div><!-- elematic-icon-box-content-wrap -->

		</div><!-- elematic-icon-box-wrap -->

<?php }

}
