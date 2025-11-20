<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid extends Widget_Base {

    public function get_name() {
        return 'elematic-grid';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Grid', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_style_depends() {
        return [ 'elematic-grid' ];
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

	protected function register_controls() {
       
		$this->start_controls_section(
            'sec_content',
            [
                'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' )
            ]
        );
       
        $repeater = new Repeater();
        
        $repeater->add_control(
            'grid_image',
            [
                'label' => esc_html__('Image', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true,
            ]
        );
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'full',
            ]
        );
        $repeater->add_control(
            'icon_switch',
            [
                'label'        => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_control(
            'icon_select',
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
                'condition' => [
                    'icon_switch' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'grid_icon',
            [
                'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-snowflake',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_select' => 'icon',
                    'icon_switch' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'grid_icon_image',
            [
                'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_select' => 'image',
                    'icon_switch' => 'yes'
                ]
            ]
        );
        $repeater->add_control(
            'title', 
            [
                'label' => esc_html__('Title', 'elematic-addons-for-elementor'),
                'default' => 'Curabitur ligula sapien tincidunt',
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link_url', 
            [
                'label' => esc_html__('Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'condition' => [
                    'title!' => ''
                ]
            ]
        );
        $repeater->add_control(
            'description', 
            [
                'label' => esc_html__('Descripton', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'elematic-addons-for-elementor' ),
            ]
        );
        $repeater->add_control(
            'read_more_switch',
            [
                'label'        => esc_html__( 'Read More', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_control(
            'read_more_text',
            [
                'label'       => esc_html__( 'Read More Text', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Read More', 'elematic-addons-for-elementor' ),
                'placeholder' => esc_html__( 'Enter Text', 'elematic-addons-for-elementor' ),
                'condition' => [
                    'read_more_switch' => 'yes'
                ]
            ]

        );

        $repeater->add_control(
            'read_more_link',
            [
                'label'     => esc_html__( 'Read More Link', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'elematic-addons-for-elementor' ),
                'default'     => [
                    'url' => '#',
                ],
                
            ]
        );
        $repeater->add_control(
            'read_more_icon',
            [
                'label' => esc_html__( 'Read More Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin'             => 'inline',
                'label_block'      => false,
                'condition' => [
                    'read_more_switch' => 'yes',
                    'read_more_text!' => ''
                ]
            ]
        );

       
        $this->add_control(
            'items',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [

                    [
                        'title' => wp_kses_post('Tristique senectus et netus'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'title' => wp_kses_post('Mauris ultricies pulvinar abitant', 'elematic-addons-for-elementor'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'title' => wp_kses_post('Arcu purus lacinia sed diam', 'elematic-addons-for-elementor'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'title' => wp_kses_post('Sollicitudin dolor diam vitae', 'elematic-addons-for-elementor'),
                        'description' => wp_kses_post('Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'elematic-addons-for-elementor'),
                    ],
                ],

                'title_field' => '{{{ title }}}',
            ]
        );
        
        $this->end_controls_section();

        // settings
        $this->start_controls_section(
            'sec_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,             
                'desktop_default' => '33.333%',
                'tablet_default' => '50%',
                'mobile_default' => '100%',
                'options' => [
                    '100%' => esc_html__( '1 Column', 'elematic-addons-for-elementor' ),
                    '50%' => esc_html__( '2 Columns', 'elematic-addons-for-elementor' ),
                    '33.333%' => esc_html__( '3 Columns', 'elematic-addons-for-elementor' ),
                    '25%' => esc_html__( '4 Columns', 'elematic-addons-for-elementor' ),
                    '20%' => esc_html__( '5 Columns', 'elematic-addons-for-elementor' ),
                    '16.666%' => esc_html__( '6 Columns', 'elematic-addons-for-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-grid-item' => 'width: {{VALUE}};',
                ],
                'render_type' => 'template'
            ]
        );
        $this->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__( 'Gap', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-grid-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                
            ]
        );
        $this->add_control(
            'image_hover',
            [
                'label'     => esc_html__('Image Hover Zoom', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'elematic_lightbox',
            [
                'label' => esc_html__( 'Lightbox', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'no',
            ]
        );
        $this->end_controls_section();


        // Style section started
        $this->start_controls_section(
            'styles_section_grid',
            [
              'label'   => esc_html__( 'Styles', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->start_controls_tabs( 'sec_grid_tabs' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sec_grid_background',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-grid-container',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sec_grid_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-grid-container',
            ]
        );
        $this->add_responsive_control(
            'sec_grid_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-grid-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sec_grid_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-grid-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sec_grid_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-grid-container'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'sec_grid_hov_background',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-grid-container:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sec_grid_hov_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-grid-container:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sec_grid_hov_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-grid-container:hover'
            ]
        );
        $this->add_control(
            'sec_grid_background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'elematic-addons-for-elementor' ) . ' (s)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-grid-container:hover' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_image',
            [
              'label'   => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'img_width',
            [
                'label' => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_img_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-car-grid-image img',
            ]
        );
        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'elematic_image_effects_normal',
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
                    '{{WRAPPER}} .elematic-car-grid-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .elematic-car-grid-image img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'elematic_image_effects_hover',
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
                    '{{WRAPPER}} .elematic-grid-container:hover .elematic-car-grid-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elematic-grid-container:hover .elematic-car-grid-image img',
            ]
        );
        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'elematic-addons-for-elementor' ) . ' (s)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-grid-container:hover .elematic-car-grid-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_icon',
            [
              'label'   => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon / Image Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-car-grid-icon-wrap img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-car-grid-icon-wrap svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_x',
            [
                'label' => esc_html__( 'Offset X', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-icon-wrap' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_y',
            [
                'label' => esc_html__( 'Offset Y', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-icon-wrap' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-icon-wrap i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-car-grid-icon-wrap svg' => 'fill: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            'icon_hover_color',
            [
                'label'     => esc_html__( 'Icon Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-grid-container:hover .elematic-car-grid-icon-wrap i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-grid-container:hover .elematic-car-grid-icon-wrap svg' => 'fill: {{VALUE}};',
                ],
                
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_content',
            [
              'label'   => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'alignment',
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
                ],
                'toggle' => false,
                'selectors'         => [
                    '{{WRAPPER}} .elematic-grid-container'   => 'text-align: {{VALUE}};',
                ],

            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'car_grid_cont_background',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-car-grid-content',
            ]
        );
        $this->add_responsive_control(
            'cont_pad',
            [
                'label' => esc_html__( 'Content Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cont_margin',
            [
                'label' => esc_html__( 'Content Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'cont_only_border',
                'label' => esc_html__( 'Content Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-car-grid-content',
            ]
        );
        $this->add_responsive_control(
            'cont_border_radius',
            [
                'label' => esc_html__( 'Content Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'content_only_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-car-grid-content'
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-title' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_hov_color',
            [
                'label'     => esc_html__( 'Title Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-title:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'title_typography',
                   'selector'  => '{{WRAPPER}} .elematic-car-grid-title',
                   
              ]
        );
        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'title_text_stroke',
                'label'     => esc_html__( 'Title Text Stroke', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-car-grid-title',
            ]
        );
        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__( 'Descripton Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-description' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'description_typography',
                   'selector'  => '{{WRAPPER}} .elematic-car-grid-description',
                   
              ]
        );
        $this->add_control(
            'readmore_color',
            [
                'label'     => esc_html__( 'Read More Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-read-more a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-car-grid-read-more svg' => 'fill: {{VALUE}};',
                ],
               
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'readmore_hover_color',
            [
                'label'     => esc_html__( 'Read More Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-read-more a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-car-grid-read-more a:hover svg' => 'fill: {{VALUE}};',
                ],
                
                 
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'readmore_typography',
                   'selector'  => '{{WRAPPER}} .elematic-car-grid-read-more a',
                  
              ]
        );
        $this->add_control(
            'readmore_icon_size',
            [
                'label' => esc_html__( 'Read More Icon Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-read-more i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-car-grid-read-more svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'read_more_icon_indent',
            [
                'label' => esc_html__( 'Icon Spacing', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-read-more i, {{WRAPPER}} .elematic-car-grid-read-more svg' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'readmore_padding',
            [
                'label' => esc_html__( 'Read More Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                
            ]
        );
        $this->add_responsive_control(
            'readmore_margin',
            [
                'label' => esc_html__( 'Read More Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-car-grid-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                
            ]
        );
        $this->end_controls_section();
    
    }
    
    public function render() {
        $settings = $this->get_settings_for_display();
        $img_hover = $settings['image_hover'] ? 'elematic-img-zoom' : '';

        $this->add_render_attribute(
            [
                'item' => [
                    'class' => [
                        'elematic-grid-item',
                        $img_hover
                    ]
                ]
            ]
        );
    ?>
    <div class="elematic-grid-wrapper">
    <?php foreach ( $settings['items'] as $index => $item ) :
        $target_title = !empty($item['link_url']['is_external']) ? '_blank' : '_self';
        $target_readmore = $item['read_more_link']['is_external'] ? '_blank' : '_self';
        $image = $item['grid_image']['url'];
        $lightbox = 'elematic_lightbox' . $index;
 
        $this->add_render_attribute(
            [
                $lightbox => [
                    'data-elementor-open-lightbox' => $settings['elematic_lightbox'],
                    'data-elementor-lightbox-slideshow' => $this->get_id(),
                    'href' => $image,
                ]
            ]
        );
    ?>
        <div <?php $this->print_render_attribute_string('item') ?>>
            <div class="elematic-grid-container">
                <?php if(!empty($image)) : ?>
                    <div class="elematic-car-grid-image">
                        <?php if('yes' === $settings['elematic_lightbox']) : ?>
                            <a <?php $this->print_render_attribute_string( $lightbox ); ?>>
                                <?php Group_Control_Image_Size::print_attachment_image_html( $item, 'image', 'grid_image' ); ?>
                            </a>
                        <?php else: ?>
                            <?php Group_Control_Image_Size::print_attachment_image_html( $item, 'image', 'grid_image' ); ?>
                        <?php endif; ?>
                    </div><!-- elematic-car-grid-image -->
                <?php endif; ?>
                <?php 
                    if ( 'icon' === $item['icon_select'] && 'yes' === $item['icon_switch'] ) : ?>
                        <span class="elematic-car-grid-icon-wrap">
                            <?php Icons_Manager::render_icon( $item['grid_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                <?php
                    elseif ( 'image' === $item['icon_select'] && 'yes' === $item['icon_switch'] ) : ?>
                        <span class="elematic-car-grid-icon-wrap">
                            <img src="<?php echo esc_attr($item['grid_icon_image']['url']); ?>">
                        </span>
                <?php endif; ?>

                <div class="elematic-car-grid-content">
                <?php if ( !empty($item['link_url']['url']) ) : ?>
                    <a href="<?php echo esc_url( $item['link_url']['url'] ); ?>" target="<?php echo esc_attr($target_title); ?>"><h3 class="elematic-car-grid-title"><?php echo wp_kses_post( $item['title'] ); ?></h3></a>
                <?php elseif(!empty($item['title'])) : ?>
                    <h3 class="elematic-car-grid-title"><?php echo wp_kses_post( $item['title'] ); ?></h3> 
                <?php endif; ?>
                <?php if(!empty($item['description'])): ?>
                    <div class="elematic-car-grid-description">
                        <?php echo wp_kses_post( $item['description'] ); ?>
                    </div>
                <?php endif; ?>
                    <?php if ( !empty($item['read_more_link']['url']) && 'yes' === $item['read_more_switch'] ) : ?>
                        <div class="elematic-car-grid-read-more">
							<a href="<?php echo esc_url( $item['read_more_link']['url'] ); ?>" target="<?php echo esc_attr( $target_readmore ); ?>">
    <?php echo esc_html( $item['read_more_text'] ); ?>
    <?php Icons_Manager::render_icon( $item['read_more_icon'], [ 'aria-hidden' => 'true' ] ); ?>
</a>
                        </div>
                    <?php endif; ?> 
                </div><!-- elematic-car-grid-content -->
            </div><!-- elematic-grid-container -->
        </div><!-- elematic-grid-item -->
    <?php endforeach; ?>
    </div>
    <?php
    }


} // class end