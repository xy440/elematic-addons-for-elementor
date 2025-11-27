<?php
namespace Elematic\widgets;
use elementor\Widget_Base;
use Elementor\Controls_Manager;
use elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use elementor\Group_Control_Border;
use elementor\Group_Control_Typography;
use elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use elementor\Utils;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ImageMask extends Widget_Base {

	public function get_name() {
		return 'elematic-image-mask';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Image Mask', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-image-bold';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'image', 'mask', 'shape' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
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
				'name' => 'image',
				'default' => 'large',
				'separator' => 'none',
			]
		);

        $this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
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

				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_source',
			[
				'label' => esc_html__( 'Caption', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'elematic-addons-for-elementor' ),
					'attachment' => esc_html__( 'Attachment Caption', 'elematic-addons-for-elementor' ),
					'custom' => esc_html__( 'Custom Caption', 'elematic-addons-for-elementor' ),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Custom Caption', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter your image caption', 'elematic-addons-for-elementor' ),
				'condition' => [
					'caption_source' => 'custom',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => esc_html__( 'Link', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'elematic-addons-for-elementor' ),
					'file' => esc_html__( 'Media File', 'elematic-addons-for-elementor' ),
					'custom' => esc_html__( 'Custom URL', 'elematic-addons-for-elementor' ),
				],
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
				'placeholder' => esc_html__( 'https://your-link.com', 'elematic-addons-for-elementor' ),
				'condition' => [
					'link_to' => 'custom',
				],
				'show_label' => false,
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label' => esc_html__( 'Lightbox', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'elematic-addons-for-elementor' ),
					'yes' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
					'no' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
            'masking_settings',
            [
                'label' => esc_html__( 'Masking', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_control(
            'image_mask_shape',
            [
                'label'     => esc_html__('Masking Shape', 'elematic-addons-for-elementor'),
                'title'     => esc_html__('Masking Shape', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'default',
                'options'   => [
                    'default' => [
                        'title' => esc_html__('Default Shapes', 'elematic-addons-for-elementor'),
                        'icon'  => 'eicon-star',
                    ],
                    'custom'  => [
                        'title' => esc_html__('Custom Shape', 'elematic-addons-for-elementor'),
                        'icon'  => 'eicon-image-bold',
                    ],
                ],
                'toggle'    => false,
            ]
        );
        $this->add_control(
			'masking_default_shapes',
			[
				'label' => esc_html__('Choose Shape', 'elematic-addons-for-elementor'),
				'type' => 'elematic-image-choose',
				'default' => 'shape-1',
				'options' => Helper::elematic_get_svg_shapes(),
				'selectors'      => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-image: url(' . ELEMATIC_URL . 'assets/images/image-mask/{{VALUE}}.svg); mask-image: url(' . ELEMATIC_URL . 'assets/images/image-mask/{{VALUE}}.svg);',
                ],
				'condition' => [
					'image_mask_shape' => 'default',
				],
			]
		);

        $this->add_control(
            'image_mask_shape_custom',
            [
                'label'      => esc_html__('Custom Shape', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
                'selectors'  => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-image: url({{URL}}); mask-image: url({{URL}});',
                ],
                'condition'  => [
                    'image_mask_shape'   => 'custom',
                ],
            ]
        );

        $this->add_control(
            'image_mask_shape_position',
            [
                'label'                => esc_html__('Position', 'elematic-addons-for-elementor'),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'center-center',
                'options'              => [
                    'center-center' => esc_html__('Center Center', 'elematic-addons-for-elementor'),
                    'center-left'   => esc_html__('Center Left', 'elematic-addons-for-elementor'),
                    'center-right'  => esc_html__('Center Right', 'elematic-addons-for-elementor'),
                    'top-center'    => esc_html__('Top Center', 'elematic-addons-for-elementor'),
                    'top-left'      => esc_html__('Top Left', 'elematic-addons-for-elementor'),
                    'top-right'     => esc_html__('Top Right', 'elematic-addons-for-elementor'),
                    'bottom-center' => esc_html__('Bottom Center', 'elematic-addons-for-elementor'),
                    'bottom-left'   => esc_html__('Bottom Left', 'elematic-addons-for-elementor'),
                    'bottom-right'  => esc_html__('Bottom Right', 'elematic-addons-for-elementor'),
                    'custom'  		=> esc_html__('Custom', 'elematic-addons-for-elementor'),
                ],
                'selectors_dictionary' => [
                    'center-center' => 'center center',
                    'center-left'   => 'center left',
                    'center-right'  => 'center right',
                    'top-center'    => 'top center',
                    'top-left'      => 'top left',
                    'top-right'     => 'top right',
                    'bottom-center' => 'bottom center',
                    'bottom-left'   => 'bottom left',
                    'bottom-right'  => 'bottom right',
                    'custom'  		=> 'custom',
                ],
                'selectors'            => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-position: {{VALUE}}; mask-position: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
			'image_mask_position_x',
			[
				'label' => esc_html__('Position X', 'elematic-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%', 'vw'],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'em' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => '%',
				],
				'selectors'            => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-position-x: {{SIZE}}{{UNIT}}; mask-position-x: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
					'image_mask_shape_position' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'image_mask_position_y',
			[
				'label' => esc_html__('Position Y', 'elematic-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em', '%', 'vw'],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
					'em' => [
						'min' => -100,
						'max' => 100,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
					],
					'vw' => [
						'min' => -100,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 0,
					'unit' => '%',
				],
				'selectors'            => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-position-y: {{SIZE}}{{UNIT}}; mask-position-y: {{SIZE}}{{UNIT}};',
                ],
				'condition' => [
					'image_mask_shape_position' => 'custom',
				],
			]
		);
        $this->add_control(
            'image_mask_shape_size',
            [
                'label'     => esc_html__('Size', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'contain',
                'options'   => [
                    'auto'    => esc_html__('Auto', 'elematic-addons-for-elementor'),
                    'cover'   => esc_html__('Cover', 'elematic-addons-for-elementor'),
                    'contain' => esc_html__('Contain', 'elematic-addons-for-elementor'),
                    'initial' => esc_html__('Custom', 'elematic-addons-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-size: {{VALUE}}; mask-size: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'image_mask_shape_custom_size',
            [
                'label'      => esc_html__('Custom Size', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::SLIDER,
                'responsive' => true,
                'size_units' => ['px', 'em', '%', 'vw'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'required'   => true,
                'selectors'  => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-size: {{SIZE}}{{UNIT}}; mask-size: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'image_mask_shape_size' => 'initial',
                ],
            ]
        );

        $this->add_control(
            'image_mask_shape_repeat',
            [
                'label'                => esc_html__('Repeat', 'elematic-addons-for-elementor'),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'no-repeat',
                'options'              => [
                    'repeat'          => esc_html__('Repeat', 'elematic-addons-for-elementor'),
                    'repeat-x'        => esc_html__('Repeat-x', 'elematic-addons-for-elementor'),
                    'repeat-y'        => esc_html__('Repeat-y', 'elematic-addons-for-elementor'),
                    'space'           => esc_html__('Space', 'elematic-addons-for-elementor'),
                    'round'           => esc_html__('Round', 'elematic-addons-for-elementor'),
                    'no-repeat'       => esc_html__('No-repeat', 'elematic-addons-for-elementor'),
                    'repeat-space'    => esc_html__('Repeat Space', 'elematic-addons-for-elementor'),
                    'round-space'     => esc_html__('Round Space', 'elematic-addons-for-elementor'),
                    'no-repeat-round' => esc_html__('No-repeat Round', 'elematic-addons-for-elementor'),
                ],
                'selectors_dictionary' => [
                    'repeat'          => 'repeat',
                    'repeat-x'        => 'repeat-x',
                    'repeat-y'        => 'repeat-y',
                    'space'           => 'space',
                    'round'           => 'round',
                    'no-repeat'       => 'no-repeat',
                    'repeat-space'    => 'repeat space',
                    'round-space'     => 'round space',
                    'no-repeat-round' => 'no-repeat round',
                ],
                'selectors'            => [
                    '{{WRAPPER}} .elematic-image-mask' => '-webkit-mask-repeat: {{VALUE}}; mask-repeat: {{VALUE}};',
                ],
                
            ]
        );


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__( 'Width', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'space',
			[
				'label' => esc_html__( 'Max Width', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'elematic-addons-for-elementor' ),
					'fill' => esc_html__( 'Fill', 'elematic-addons-for-elementor' ),
					'cover' => esc_html__( 'Cover', 'elematic-addons-for-elementor' ),
					'contain' => esc_html__( 'Contain', 'elematic-addons-for-elementor' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_panel_style',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'opacity',
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
					'{{WRAPPER}} img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
			]
		);

		$this->add_control(
			'opacity_hover',
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
					'{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hover',
				'selector' => '{{WRAPPER}}:hover img',
			]
		);

		$this->add_control(
			'background_hover_transition',
			[
				'label' => esc_html__( 'Transition Duration', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'transition-duration: {{SIZE}}s',
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

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'exclude' => [ // phpcs:ignore 
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_caption',
			[
				'label' => esc_html__( 'Caption', 'elematic-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'caption_source!' => 'none',
				],
			]
		);

		$this->add_control(
			'caption_align',
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
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'caption_background_color',
			[
				'label' => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .widget-image-caption',

			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'caption_text_shadow',
				'selector' => '{{WRAPPER}} .widget-image-caption',
			]
		);

		$this->add_responsive_control(
			'caption_space',
			[
				'label' => esc_html__( 'Spacing', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function has_caption( $settings ) {
		return ( ! empty( $settings['caption_source'] ) && 'none' !== $settings['caption_source'] );
	}

	private function get_caption( $settings ) {
		$caption = '';
		if ( ! empty( $settings['caption_source'] ) ) {
			switch ( $settings['caption_source'] ) {
				case 'attachment':
					$caption = wp_get_attachment_caption( $settings['image']['id'] );
					break;
				case 'custom':
					$caption = ! Utils::is_empty( $settings['caption'] ) ? $settings['caption'] : '';
			}
		}
		return $caption;
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-image elematic-image-mask' );
		

		$has_caption = $this->has_caption( $settings );

		$link = $this->get_link_url( $settings );

		if ( $link ) {
			$this->add_link_attributes( 'link', $link );

			
				$this->add_render_attribute( 'link', [
					'class' => 'elementor-clickable',
				] );
			

			if ( 'custom' !== $settings['link_to'] ) {
				$this->add_lightbox_data_attributes( 'link', $settings['image']['id'], $settings['open_lightbox'] );
			}
		} ?>
		
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
		
			<?php if ( $has_caption ) : ?>
				<figure class="wp-caption">
			<?php endif; ?>
			<?php if ( $link ) : ?>
					<a <?php $this->print_render_attribute_string( 'link' ); ?>>
			<?php endif; ?>
				<?php Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>
			<?php if ( $link ) : ?>
					</a>
			<?php endif; ?>
			<?php if ( $has_caption ) : ?>
					<figcaption class="widget-image-caption wp-caption-text"><?php echo esc_html( $this->get_caption( $settings ) ); ?></figcaption>
			<?php endif; ?>
			<?php if ( $has_caption ) : ?>
				</figure>
			<?php endif; ?>
		
			</div>
		
		<?php
	}

	private function get_link_url( $settings ) {
		if ( 'none' === $settings['link_to'] ) {
			return false;
		}

		if ( 'custom' === $settings['link_to'] ) {
			if ( empty( $settings['link']['url'] ) ) {
				return false;
			}

			return $settings['link'];
		}

		return [
			'url' => $settings['image']['url'],
		];
	}
}
