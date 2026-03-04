<?php
namespace Elematic\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;

class HorizontalTimeline extends Widget_Base {

    public function get_name() {
        return 'elematic-horizontal-timeline';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Horizontal Timeline', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-time-line';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_keywords() {
        return [ 'timeline', 'horizontal', 'history', 'events', 'elematic' ];
    }

    public function get_style_depends() {
        return [ 'elematic-horizontal-timeline' ];
    }

    public function get_script_depends() {
        return [ 'elematic-horizontal-timeline' ];
    }

    protected function register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*  Content Tab
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_timeline_items',
            [
                'label' => esc_html__( 'Timeline Items', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'timeline_date',
            [
                'label'       => esc_html__( 'Date/Year', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( '2026', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'timeline_title',
            [
                'label'       => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Timeline Title', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'timeline_content',
            [
                'label'       => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'elematic-addons-for-elementor' ),
                'rows'        => 4,
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'timeline_image',
            [
                'label'   => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'timeline_icon',
            [
                'label'   => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-circle',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'timeline_link',
            [
                'label'       => esc_html__( 'Link', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'elematic-addons-for-elementor' ),
                'dynamic'     => [ 'active' => true ],
            ]
        );

        $repeater->add_control(
            'item_icon_bg_color',
            [
                'label'     => esc_html__( 'Icon/Border Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .elematic-htl-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .elematic-htl-avatar-img' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'item_card_bg_color',
            [
                'label'     => esc_html__( 'Card Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .elematic-htl-content' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elematic-htl-style-4 {{CURRENT_ITEM}} .elematic-htl-content::after' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'timeline_items',
            [
                'label'       => esc_html__( 'Timeline Items', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'timeline_date'    => esc_html__( 'April 2, 2024', 'elematic-addons-for-elementor' ),
                        'timeline_title'   => esc_html__( 'Store Opened', 'elematic-addons-for-elementor' ),
                        'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'elematic-addons-for-elementor' ),
                    ],
                    [
                        'timeline_date'    => esc_html__( 'May 3, 20124', 'elematic-addons-for-elementor' ),
                        'timeline_title'   => esc_html__( 'Joined Facebook', 'elematic-addons-for-elementor' ),
                        'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'elematic-addons-for-elementor' ),
                    ],
                    [
                        'timeline_date'    => esc_html__( 'June 4, 2024', 'elematic-addons-for-elementor' ),
                        'timeline_title'   => esc_html__( 'New Office', 'elematic-addons-for-elementor' ),
                        'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'elematic-addons-for-elementor' ),
                    ],
                    [
                        'timeline_date'    => esc_html__( 'July 5, 2024', 'elematic-addons-for-elementor' ),
                        'timeline_title'   => esc_html__( 'Award Winning', 'elematic-addons-for-elementor' ),
                        'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'elematic-addons-for-elementor' ),
                    ],
                    [
                        'timeline_date'    => esc_html__( 'August 5, 2024', 'elematic-addons-for-elementor' ),
                        'timeline_title'   => esc_html__( 'Award Winning', 'elematic-addons-for-elementor' ),
                        'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'elematic-addons-for-elementor' ),
                    ],
                    [
                        'timeline_date'    => esc_html__( 'September 5, 2024', 'elematic-addons-for-elementor' ),
                        'timeline_title'   => esc_html__( 'Award Winning', 'elematic-addons-for-elementor' ),
                        'timeline_content' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'elematic-addons-for-elementor' ),
                    ],
                ],
                'title_field' => '{{{ timeline_date }}} - {{{ timeline_title }}}',
            ]
        );

        $this->end_controls_section();

        // Settings Section
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label'   => esc_html__( 'Layout Style', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__( 'Style 1 - Basic (Content Below)', 'elematic-addons-for-elementor' ),
                    'style-2' => esc_html__( 'Style 2 - Avatar Highlighted', 'elematic-addons-for-elementor' ),
                    'style-3' => esc_html__( 'Style 3 - Content Above', 'elematic-addons-for-elementor' ),
                    'style-4' => esc_html__( 'Style 4 - Card with Pointer', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'show_navigation',
            [
                'label'        => esc_html__( 'Show Navigation Arrows', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_scrollbar',
            [
                'label'        => esc_html__( 'Show Scrollbar', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_responsive_control(
            'items_gap',
            [
                'label'      => esc_html__( 'Items Gap', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 350,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-item' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_alignment',
            [
                'label'     => esc_html__( 'Content Alignment', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-content, {{WRAPPER}} .elematic-htl-card-body' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image',
                'default'   => 'medium',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Tab
        /*-----------------------------------------------------------------------------------*/

        // Line Style
        $this->start_controls_section(
            'section_line_style',
            [
                'label' => esc_html__( 'Timeline Line', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'line_color',
            [
                'label'     => esc_html__( 'Line Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'line_active_color',
            [
                'label'     => esc_html__( 'Line Progress Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6c5ce7',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-line-progress' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'line_height',
            [
                'label'      => esc_html__( 'Line Height', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-line, {{WRAPPER}} .elematic-htl-line-progress' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Icon/Marker Style
        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__( 'Icon/Marker', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__( 'Container Size', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 150,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    // 'size' => 50,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-htl-avatar-img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_font_size',
            [
                'label'      => esc_html__( 'Icon Size', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 8,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-htl-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-htl-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color',
            [
                'label'     => esc_html__( 'Icon Background', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6c5ce7',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'icon_border',
                'selector' => '{{WRAPPER}} .elematic-htl-icon, {{WRAPPER}} .elematic-htl-avatar-img',
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '50',
                    'right'  => '50',
                    'bottom' => '50',
                    'left'   => '50',
                    'unit'   => '%',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-icon, {{WRAPPER}} .elematic-htl-avatar-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'icon_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-htl-icon, {{WRAPPER}} .elematic-htl-avatar-img',
            ]
        );

        $this->end_controls_section();

        // Date Style
        $this->start_controls_section(
            'section_date_style',
            [
                'label' => esc_html__( 'Date', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__( 'Date Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#636e72',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'date_typography',
                'selector' => '{{WRAPPER}} .elematic-htl-date',
            ]
        );

        $this->add_responsive_control(
            'date_spacing',
            [
                'label'      => esc_html__( 'Spacing', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-date' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2d3436',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-title, {{WRAPPER}} .elematic-htl-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elematic-htl-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => esc_html__( 'Spacing', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_highlight_color',
            [
                'label'     => esc_html__( 'First Word Highlight Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#e91e8c',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-highlight' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'layout_style' => 'style-2',
                ],
            ]
        );

        $this->end_controls_section();

        // Content Style
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => esc_html__( 'Content Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#636e72',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .elematic-htl-desc',
            ]
        );

        $this->end_controls_section();

        // Content Box Style
        $this->start_controls_section(
            'section_content_box_style',
            [
                'label' => esc_html__( 'Content Box', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style!' => 'style-2',
                ],
            ]
        );

        $this->add_control(
            'content_box_bg',
            [
                'label'     => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-content' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elematic-htl-style-4 .elematic-htl-content::after' => 'border-top-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_box_padding',
            [
                'label'      => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20',
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-htl-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_box_width',
            [
                'label'      => esc_html__( 'Max Width', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 150,
                        'max' => 400,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-content' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_box_border',
                'selector' => '{{WRAPPER}} .elematic-htl-content',
            ]
        );

        $this->add_control(
            'content_box_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px' ],
                'default'    => [
                    'top'    => '8',
                    'right'  => '8',
                    'bottom' => '8',
                    'left'   => '8',
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-htl-card-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-htl-content',
            ]
        );

        $this->end_controls_section();

        // Card Image Style
        $this->start_controls_section(
            'section_card_image_style',
            [
                'label'     => esc_html__( 'Card Image', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'layout_style!' => 'style-2',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_image_height',
            [
                'label'      => esc_html__( 'Image Height', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 80,
                        'max' => 300,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 160,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-card-image' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Navigation Style
        $this->start_controls_section(
            'section_nav_style',
            [
                'label'     => esc_html__( 'Navigation', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_navigation' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_size',
            [
                'label'      => esc_html__( 'Size', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px' => [
                        'min' => 30,
                        'max' => 60,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-nav' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'nav_tabs' );

        $this->start_controls_tab(
            'nav_normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'nav_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#b2b2b2',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-nav' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_bg_color',
            [
                'label'     => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-nav' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'nav_hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'nav_hover_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#6c5ce7',
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-nav:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_hover_bg_color',
            [
                'label'     => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-htl-nav:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'nav_border',
                'selector'  => '{{WRAPPER}} .elematic-htl-nav',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'nav_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'top'    => '50',
                    'right'  => '50',
                    'bottom' => '50',
                    'left'   => '50',
                    'unit'   => '%',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-htl-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items    = $settings['timeline_items'];

        if ( empty( $items ) ) {
            return;
        }

        $layout_style   = $settings['layout_style'];
        $show_nav       = $settings['show_navigation'] === 'yes';
        $show_scrollbar = $settings['show_scrollbar'] === 'yes';

        $wrapper_class = 'elematic-htl-wrapper elematic-htl-' . esc_attr( $layout_style );
        if ( ! $show_scrollbar ) {
            $wrapper_class .= ' elematic-htl-hide-scrollbar';
        }

        ?>
        <div class="<?php echo esc_attr( $wrapper_class ); ?>">

            <?php if ( $show_nav ) : ?>
            <button class="elematic-htl-nav elematic-htl-nav-prev" aria-label="<?php esc_attr_e( 'Previous', 'elematic-addons-for-elementor' ); ?>">
                <i class="eicon-chevron-left"></i>
            </button>
            <?php endif; ?>

            <div class="elematic-htl-container">
                <div class="elematic-htl-track">
                    
                    <div class="elematic-htl-line-wrapper">
                        <div class="elematic-htl-line"></div>
                        <div class="elematic-htl-line-progress"></div>
                    </div>

                    <div class="elematic-htl-items">
                        <?php foreach ( $items as $index => $item ) : 
                            $item_class = 'elematic-htl-item elementor-repeater-item-' . esc_attr( $item['_id'] );
                            $has_link   = ! empty( $item['timeline_link']['url'] );
                            $has_image  = ! empty( $item['timeline_image']['url'] );

                            $image_url = '';
                            if ( $has_image ) {
                                $image_url = Group_Control_Image_Size::get_attachment_image_src( 
                                    $item['timeline_image']['id'], 
                                    'image', 
                                    $settings 
                                );
                                if ( empty( $image_url ) ) {
                                    $image_url = $item['timeline_image']['url'];
                                }
                            }
                        ?>
                        <div class="<?php echo esc_attr( $item_class ); ?>">
                            
                            <?php if ( $layout_style === 'style-1' ) : ?>
                                <!-- Style 1: Basic Content Below with Image -->
                                <div class="elematic-htl-marker">
                                    <div class="elematic-htl-icon">
                                        <?php if ( ! empty( $item['timeline_icon']['value'] ) ) :
                                            Icons_Manager::render_icon( $item['timeline_icon'], [ 'aria-hidden' => 'true' ] );
                                        else : ?>
                                            <i class="fas fa-circle"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="elematic-htl-content">
                                    <?php if ( $has_image ) : ?>
                                        <div class="elematic-htl-card-image">
                                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $item['timeline_title'] ); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <div class="elematic-htl-card-body">
                                        <?php if ( ! empty( $item['timeline_date'] ) ) : ?>
                                            <div class="elematic-htl-date"><?php echo esc_html( $item['timeline_date'] ); ?></div>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['timeline_title'] ) ) : ?>
                                            <?php if ( $has_link ) : ?>
                                                <a href="<?php echo esc_url( $item['timeline_link']['url'] ); ?>"
                                                   <?php echo ! empty( $item['timeline_link']['is_external'] ) ? 'target="_blank"' : ''; ?>
                                                   <?php echo ! empty( $item['timeline_link']['nofollow'] ) ? 'rel="nofollow"' : ''; ?>>
                                            <?php endif; ?>
                                            <h4 class="elematic-htl-title"><?php echo esc_html( $item['timeline_title'] ); ?></h4>
                                            <?php if ( $has_link ) : ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['timeline_content'] ) ) : ?>
                                            <p class="elematic-htl-desc"><?php echo esc_html( $item['timeline_content'] ); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php elseif ( $layout_style === 'style-2' ) : ?>
                                <!-- Style 2: Avatar Highlighted -->
                                <?php if ( ! empty( $item['timeline_date'] ) ) : ?>
                                    <div class="elematic-htl-date"><?php echo esc_html( $item['timeline_date'] ); ?></div>
                                <?php endif; ?>

                                <div class="elematic-htl-marker">
                                    <?php if ( $has_image ) : ?>
                                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $item['timeline_title'] ); ?>" class="elematic-htl-avatar-img">
                                    <?php else : ?>
                                        <div class="elematic-htl-icon">
                                            <?php if ( ! empty( $item['timeline_icon']['value'] ) ) :
                                                Icons_Manager::render_icon( $item['timeline_icon'], [ 'aria-hidden' => 'true' ] );
                                            else : ?>
                                                <i class="fas fa-user"></i>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="elematic-htl-content">
                                    <?php if ( ! empty( $item['timeline_title'] ) ) : 
                                        $title_words = explode( ' ', $item['timeline_title'], 2 );
                                        $first_word = isset( $title_words[0] ) ? $title_words[0] : '';
                                        $rest_words = isset( $title_words[1] ) ? ' ' . $title_words[1] : '';
                                    ?>
                                        <?php if ( $has_link ) : ?>
                                            <a href="<?php echo esc_url( $item['timeline_link']['url'] ); ?>"
                                               <?php echo ! empty( $item['timeline_link']['is_external'] ) ? 'target="_blank"' : ''; ?>
                                               <?php echo ! empty( $item['timeline_link']['nofollow'] ) ? 'rel="nofollow"' : ''; ?>>
                                        <?php endif; ?>
                                        <h4 class="elematic-htl-title"><span class="elematic-htl-highlight"><?php echo esc_html( $first_word ); ?></span><?php echo esc_html( $rest_words ); ?></h4>
                                        <?php if ( $has_link ) : ?>
                                            </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                            <?php elseif ( $layout_style === 'style-3' ) : ?>
                                <!-- Style 3: Content Above with Image -->
                                <div class="elematic-htl-content">
                                    <?php if ( $has_image ) : ?>
                                        <div class="elematic-htl-card-image">
                                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $item['timeline_title'] ); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <div class="elematic-htl-card-body">
                                        <?php if ( ! empty( $item['timeline_date'] ) ) : ?>
                                            <div class="elematic-htl-date"><?php echo esc_html( $item['timeline_date'] ); ?></div>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['timeline_title'] ) ) : ?>
                                            <?php if ( $has_link ) : ?>
                                                <a href="<?php echo esc_url( $item['timeline_link']['url'] ); ?>"
                                                   <?php echo ! empty( $item['timeline_link']['is_external'] ) ? 'target="_blank"' : ''; ?>
                                                   <?php echo ! empty( $item['timeline_link']['nofollow'] ) ? 'rel="nofollow"' : ''; ?>>
                                            <?php endif; ?>
                                            <h4 class="elematic-htl-title"><?php echo esc_html( $item['timeline_title'] ); ?></h4>
                                            <?php if ( $has_link ) : ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['timeline_content'] ) ) : ?>
                                            <p class="elematic-htl-desc"><?php echo esc_html( $item['timeline_content'] ); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="elematic-htl-marker">
                                    <div class="elematic-htl-icon">
                                        <?php if ( ! empty( $item['timeline_icon']['value'] ) ) :
                                            Icons_Manager::render_icon( $item['timeline_icon'], [ 'aria-hidden' => 'true' ] );
                                        else : ?>
                                            <i class="fas fa-circle"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            <?php elseif ( $layout_style === 'style-4' ) : ?>
                                <!-- Style 4: Card with Pointer + Icon on Line -->
                                <div class="elematic-htl-content">
                                    <?php if ( $has_image ) : ?>
                                        <div class="elematic-htl-card-image">
                                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $item['timeline_title'] ); ?>">
                                        </div>
                                    <?php endif; ?>

                                    <div class="elematic-htl-card-body">
                                        <?php if ( ! empty( $item['timeline_date'] ) ) : ?>
                                            <div class="elematic-htl-date"><?php echo esc_html( $item['timeline_date'] ); ?></div>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['timeline_title'] ) ) : ?>
                                            <?php if ( $has_link ) : ?>
                                                <a href="<?php echo esc_url( $item['timeline_link']['url'] ); ?>"
                                                   <?php echo ! empty( $item['timeline_link']['is_external'] ) ? 'target="_blank"' : ''; ?>
                                                   <?php echo ! empty( $item['timeline_link']['nofollow'] ) ? 'rel="nofollow"' : ''; ?>>
                                            <?php endif; ?>
                                            <h4 class="elematic-htl-title"><?php echo esc_html( $item['timeline_title'] ); ?></h4>
                                            <?php if ( $has_link ) : ?>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['timeline_content'] ) ) : ?>
                                            <p class="elematic-htl-desc"><?php echo esc_html( $item['timeline_content'] ); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="elematic-htl-marker">
                                    <div class="elematic-htl-icon">
                                        <?php if ( ! empty( $item['timeline_icon']['value'] ) ) :
                                            Icons_Manager::render_icon( $item['timeline_icon'], [ 'aria-hidden' => 'true' ] );
                                        else : ?>
                                            <i class="fas fa-calendar-alt"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>


                                

                            <?php endif; ?>

                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

            <?php if ( $show_nav ) : ?>
            <button class="elematic-htl-nav elematic-htl-nav-next" aria-label="<?php esc_attr_e( 'Next', 'elematic-addons-for-elementor' ); ?>">
                <i class="eicon-chevron-right"></i>
            </button>
            <?php endif; ?>

        </div>
        <?php
    }


}