<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class CircleInfo extends Widget_Base {

    public function get_name() {
        return 'elematic-circle-info';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( ' Circle Info', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-info-circle-o';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_script_depends() {
        return [ 'elematic-circle-info' ];
    }
    public function get_style_depends() {
        return [ 'elematic-circle-info' ];
    }
    public function get_keywords() {
        return [ 'circle', 'info', 'about' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'section_layouts',
            [
                'label' => esc_html__('Item Lists', 'elematic-addons-for-elementor'),
            ]
        );

        $repeater = new Repeater();

        $repeater->start_controls_tabs(
            'item_info_tab'
        );

        $repeater->start_controls_tab(
            'item_info_tab_content',
            [
                'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'circle_info_item_title',
            [
                'label'       => esc_html__('Title', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_html__('Title Item', 'elematic-addons-for-elementor'),
                'default'     => esc_html__('Title Item', 'elematic-addons-for-elementor'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'circle_info_item_details',
            [
                'label'       => esc_html__('Details', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => esc_html__("Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.   ", 'elematic-addons-for-elementor'),
                'placeholder' => esc_html__('Type your description here', 'elematic-addons-for-elementor'),
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'circle_info_item_icon',
            [
                'label'       => esc_html__('Icon', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::ICONS,
                'label_block' => false,
                'default'     => [
                    'value'   => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline'
            ]
        );
        $repeater->add_control(
            'circle_info_item_icon_text',
            [
                'label'       => esc_html__('Icon Text', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => '',
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'circle_info_item_icon_text_tags',
            [
                'label'   => esc_html__( 'HTML Tag', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'span',
                 'options' => Helper::elematic_html_tags(),
            ]
        );
        $repeater->add_control(
            'circle_info_title_link',
            [
                'label'       => esc_html__('Link', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'label_block' => true,
                'placeholder' => esc_html__('https://your-link.com', 'elematic-addons-for-elementor'),
            ]
        );

        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'item_info_tab_bg',
            [
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' )
            ]
        );

        $repeater->add_group_control(
             Group_Control_Background::get_type(),
            [
                'name' => 'item_background',
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
            ]
        );

        $repeater->end_controls_tab();

        $repeater->end_controls_tabs();

        $this->add_control(
            'circle_info_icon_list',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'separator'   => 'before',
                'default'     => [
                    [
                        'circle_info_item_title'   => esc_html__('Circle Info One', 'elematic-addons-for-elementor'),
                        'circle_info_item_details' => esc_html__('Suspendisse potenti Phasellus euismod libero in neque molestie et elementum libero maximus. Etiam in enim vestibulum suscipit sem quis molestie nibh.', 'elematic-addons-for-elementor'),
                        'circle_info_item_icon'    => [
                            'value'   => 'far fa-heart',
                            'library' => 'fa-regular'],
                    ],
                    [
                        'circle_info_item_title'   => esc_html__('Circle Info Two', 'elematic-addons-for-elementor'),
                        'circle_info_item_details' => esc_html__('Donec ac lacus nec diam gravida pellentesque. Morbi viverra facilisis massa a ullamcorper eivamus egestas tincidunt faucibus.', 'elematic-addons-for-elementor'),
                        'circle_info_item_icon'    => [
                            'value'   => 'far fa-gem',
                            'library' => 'fa-regular'],
                    ],
                    [
                        'circle_info_item_title'   => esc_html__('Circle Info Three', 'elematic-addons-for-elementor'),
                        'circle_info_item_details' => esc_html__('Nulla tristique urna id lacinia egestas sapien arcu convallis velit id porta turpis velit molestie enim.', 'elematic-addons-for-elementor'),
                        'circle_info_item_icon'    => [
                             'value'   => 'far fa-life-ring',
                            'library' => 'fa-regular'],
                    ],
                    [
                        'circle_info_item_title'   => esc_html__('Circle Info Four', 'elematic-addons-for-elementor'),
                        'circle_info_item_details' => esc_html__('Ullamcorper nisi lorem condimentum tellus vitae semper quam enim vitae justo. Vestibulum vulputate posuere nunc sit amet ultrices.', 'elematic-addons-for-elementor'),
                        'circle_info_item_icon'    => [
                            'value'   => 'far fa-paper-plane',
                            'library' => 'fa-regular'],
                    ],
                    [
                        'circle_info_item_title'   => esc_html__('Circle Info Five', 'elematic-addons-for-elementor'),
                        'circle_info_item_details' => esc_html__('Nam non lectus orci in nibh elit blandit et velit vel sodales vulputate tellus. Koes mattis neque ante vel suscipit odio tristique vel.', 'elematic-addons-for-elementor'),
                        'circle_info_item_icon'    => [
                             'value'   => 'far fa-star',
                            'library' => 'fa-regular'],
                    ],
                    [
                        'circle_info_item_title'   => esc_html__('Circle Info Six', 'elematic-addons-for-elementor'),
                        'circle_info_item_details' => esc_html__('Hasellus tempus diam et est tristique eget aliquam quam vestibulum. Donec congue enim volutpat sagittis nunc non consectetur exes.', 'elematic-addons-for-elementor'),
                        'circle_info_item_icon'    => [
                             'value'   => 'far fa-bell',
                            'library' => 'fa-regular'],
                    ],
                ],
               'title_field' => '{{{ circle_info_item_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layouts1',
            [
                'label' => esc_html__('Settings', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_responsive_control(
            'circle_info_size',
            [
                'label'     => esc_html__('Circle Size ', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 400,
                ],
                'range'     => [
                    'px' => [
                        'min' => 200,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-wrap' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'circle_info_content_size',
            [
                'label'     => esc_html__('Content Size ', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-content' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_control(
            'hide_content',
            [
                'label' => esc_html__('Hide Content', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SWITCHER,
                'prefix_class' => 'elematic-content-hide-', 
            ]
        );

        $this->add_control(
            'title_tags',
            [
                'label'   => esc_html__( 'Title HTML Tag', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'span',
                 'options' => Helper::elematic_html_tags(),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'circle_info_custom_margin',
            [
                'label' => esc_html__('Custom Margin', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'circle_info_margin',
            [
                'label'     => esc_html__('Margin', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'condition' => [
                    'circle_info_custom_margin' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'circle_info_icon_area_size',
            [
                'label'     => esc_html__('Icon Area Size', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle, {{WRAPPER}} .elematic-circle-info-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}' => '--ep-icon-info-margin: calc({{SIZE}}px + 20px);' 
                ],
            ]
        );

        $this->add_responsive_control(
            'circle_info_icon_size',
            [
                'label'     => esc_html__('Icon Size', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle i, {{WRAPPER}} .elematic-circle-info-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elematic-circle-info-sub-circle, {{WRAPPER}} .elematic-circle-info-icon'  => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'circle_info_event',
            [
                'label'   => esc_html__('Select Event ', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mouseover',
                'options' => [
                    'click'     => esc_html__('Click', 'elematic-addons-for-elementor'),
                    'mouseover' => esc_html__('Hover', 'elematic-addons-for-elementor'),
                ],
            ]
        );

         $this->add_control(
            'link_on_icon',
            [
                'label' => esc_html__('Link On Icon', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'circle_info_auto_mode',
            [
                'label' => esc_html__('Auto Mode', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SWITCHER,
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'circle_info_auto_time',
            [
                'label'     => esc_html__('Time (ms)', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 3000,
                ],
                'range'     => [
                    'px' => [
                        'min' => 1000,
                        'max' => 10000,
                    ],
                ],
                'condition' => [
                    'circle_info_auto_mode' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'circle_info_content_style',
            [
                'label' => esc_html__('Content', 'elematic-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_mode_content_style');

        $this->start_controls_tab(
            'circle_info_tab_content_normal',
            [
                'label' => esc_html__('Normal  ', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'circle_info_content_background_normal',
                'selector'  => '{{WRAPPER}} .elematic-circle-info-item',
            ]
        );

        $this->add_responsive_control(
            'circle_info_content_padding_normal',
            [
                'label'     => esc_html__('Padding', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'circle_item_border',
                'selector' => '{{WRAPPER}} .elematic-circle-info-item',
            ]
        );

        $this->add_responsive_control(
            'circle_item_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-circle-info-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'circle_info_tab_content_hover',
            [
                'label' => esc_html__('Hover  ', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'circle_info_content_background_hover',
                'selector'  => '{{WRAPPER}} .elematic-circle-info-item:hover',
            ]
        );

        $this->add_control(
            'circle_item_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'circle_item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-item:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'circle_info_icon_style',
            [
                'label' => esc_html__('Icon', 'elematic-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_mode_style');

        $this->start_controls_tab(
            'circle_info_tab_icon_normal',
            [
                'label' => esc_html__('Normal  ', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'circle_info_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle, {{WRAPPER}} .elematic-circle-info-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elematic-circle-info-sub-circle svg, {{WRAPPER}} .elematic-circle-info-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'circle_info_icon_background',
            [
                'label'     => esc_html__('Background', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle, {{WRAPPER}} .elematic-circle-info-icon' => 'background-color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'circle_icon_border',
                'selector' => '{{WRAPPER}} .elematic-circle-info-sub-circle, {{WRAPPER}} .elematic-circle-info-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name'     => 'circle_info_icon_box_shadow',
                'label'    => esc_html__('Shadow', 'elematic-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .elematic-circle-info-sub-circle, {{WRAPPER}} .elematic-circle-info-icon',
            ]
        );
        $this->add_control(
            'circle_info_icon_text_color',
            [
                'label'     => esc_html__('Text Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle, {{WRAPPER}} .elematic-circle-info-icon-text' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'circle_info_icon_text_typography',
                   'selector'  => '{{WRAPPER}} .elematic-circle-info-icon-text',
                   
              ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'circle_info_tab_icon_hover',
            [
                'label' => esc_html__('Hover  ', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_icon_color_hover',
            [
                'label'     => esc_html__('Icon Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle:hover, {{WRAPPER}} .elematic-circle-info-icon:hover' => 'color: {{VALUE}} ',
                    '{{WRAPPER}} .elematic-circle-info-sub-circle:hover svg, {{WRAPPER}} .elematic-circle-info-icon:hover svg' => 'fill: {{VALUE}} ',
                ],
            ]
        );

        $this->add_control(
            'circle_info_icon_background_hover',
            [
                'label'     => esc_html__('Background', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle:hover, {{WRAPPER}} .elematic-circle-info-icon:hover' => 'background-color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_control(
            'circle_info_icon_border_hover',
            [
                'label'     => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle:hover, {{WRAPPER}} .elematic-circle-info-icon:hover' => 'border-color: {{VALUE}} ',
                ],
                'condition' => [
                    'circle_icon_border_border!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'circle_info_icon_box_shadow_hover',
                'label'    => esc_html__('Shadow', 'elematic-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .elematic-circle-info-sub-circle:hover, {{WRAPPER}} .elematic-circle-info-icon:hover',

            ]
        );
        $this->add_control(
            'circle_info_icon_text_color_hover',
            [
                'label'     => esc_html__('Text Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle:hover, {{WRAPPER}} .elematic-circle-info-icon-text:hover' => 'color: {{VALUE}} ',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'circle_info_tab_icon_active',
            [
                'label' => esc_html__('Active  ', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_icon_color_active',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle.active, {{WRAPPER}} .elematic-circle-info-icon.active' => 'color: {{VALUE}} ',
                    '{{WRAPPER}} .elematic-circle-info-sub-circle.active svg, {{WRAPPER}} .elematic-circle-info-icon.active svg' => 'fill: {{VALUE}} ',
                ],
            ]
        );

        $this->add_control(
            'circle_info_icon_background_active',
            [
                'label'     => esc_html__('Background', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle.active, {{WRAPPER}} .elematic-circle-info-icon.active' => 'background-color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_control(
            'circle_info_icon_border_active',
            [
                'label'     => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle:active, {{WRAPPER}} .elematic-circle-info-icon:active' => 'border-color: {{VALUE}} ',
                ],
                'condition' => [
                    'circle_icon_border_border!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'circle_info_icon_box_shadow_active',
                'label'    => esc_html__('Shadow', 'elematic-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .elematic-circle-info-sub-circle.active, {{WRAPPER}} .elematic-circle-info-sub-circle.active',
            ]
        );
        $this->add_control(
            'circle_info_icon_text_color_active',
            [
                'label'     => esc_html__('Text Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-sub-circle.active .elematic-circle-info-icon-text' => 'color: {{VALUE}} ',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'circle_info_title_style',
            [
                'label' => esc_html__('Title', 'elematic-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_mode_style0');

        $this->start_controls_tab(
            'circle_info_tab_title_normal',
            [
                'label' => esc_html__('Normal  ', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_title_color_normal',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#5f6671',
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-title, {{WRAPPER}} .elematic-circle-info-item a ' => 'color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'circle_info_title_typography',
                'selector' => '{{WRAPPER}} .elematic-circle-info-title, {{WRAPPER}} .elematic-circle-info-item a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'circle_info_tab_title_hover', [
                'label' => esc_html__('Hover  ', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_title_color_hover',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1e87f0',
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-title:hover, {{WRAPPER}} .elematic-circle-info-item a:hover ' => 'color: {{VALUE}} ',
                ],
            ]
        );

        $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'circle_info_description_style',
            [
                'label' => esc_html__('Text', 'elematic-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_description_style');

        $this->start_controls_tab(
            'circle_info_tab_description_normal',
            [
                'label' => esc_html__('Normal', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_description_color_normal',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#a3adb5',
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-desc' => 'color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'circle_info_description_typography',
                'selector' => '{{WRAPPER}} .elematic-circle-info-desc',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'circle_info_tab_description_hover',
            [
                'label' => esc_html__('Hover  ', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_description_color_hover',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-desc:hover' => 'color: {{VALUE}} ',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'circle_info_additional_style',
            [
                'label' => esc_html__('Additional', 'elematic-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('circle_info_border_style');

        $this->start_controls_tab(
            'circle_info_border_style_1',
            [
                'label' => esc_html__('Border 1', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_border_style1',
            [
                'label'   => esc_html__( 'Border Style', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'  => esc_html__( 'None', 'elematic-addons-for-elementor' ),
                    'solid'  => esc_html__( 'Solid', 'elematic-addons-for-elementor' ),
                    'dotted' => esc_html__( 'Dotted', 'elematic-addons-for-elementor' ),
                    'dashed' => esc_html__( 'Dashed', 'elematic-addons-for-elementor' ),
                    'double' => esc_html__( 'Double', 'elematic-addons-for-elementor' ),
                    'groove' => esc_html__( 'Groove', 'elematic-addons-for-elementor' ),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-inner:before' => 'border-style: {{VALUE}} ',
                ],
            ]
        );

        $this->add_responsive_control(
            'circle_info_border_width1',
            [
                'label'     => esc_html__('Border Width', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-inner:before' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'circle_info_border_color1',
            [
                'label'     => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-inner:before' => 'border-color: {{VALUE}} ',
                ],
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'circle_info_border_style_2',
            [
                'label' => esc_html__('Border 2', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'circle_info_border_style2',
            [
                'label'   => esc_html__( 'Border Style', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'  => esc_html__( 'None', 'elematic-addons-for-elementor' ),
                    'solid'  => esc_html__( 'Solid', 'elematic-addons-for-elementor' ),
                    'dotted' => esc_html__( 'Dotted', 'elematic-addons-for-elementor' ),
                    'dashed' => esc_html__( 'Dashed', 'elematic-addons-for-elementor' ),
                    'double' => esc_html__( 'Double', 'elematic-addons-for-elementor' ),
                    'groove' => esc_html__( 'Groove', 'elematic-addons-for-elementor' ),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-inner:after' => 'border-style: {{VALUE}} ',
                ],
            ]
        );

        $this->add_responsive_control(
            'circle_info_border_width2',
            [
                'label'     => esc_html__('Border Width', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-inner:after' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'circle_info_border_color2',
            [
                'label'     => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-circle-info-inner:after' => 'border-color: {{VALUE}} ',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if ($settings['circle_info_auto_mode'] == 'yes') {
            $autoMode = true;
            if ($settings['circle_info_auto_time']['size']) {
                $autoModeTime = $settings['circle_info_auto_time']['size'];
            } else {
                $autoModeTime = 0;
            }
        } else {
            $autoMode     = false;
            $autoModeTime = 0;
        }

        if ($settings['circle_info_event']) {
            $circleInfoEvent = $settings['circle_info_event'];
        } else {
            $circleInfoEvent = false;
        }

        $this->add_render_attribute(
            [
                'circle_info' => [
                    'class' => 'elematic-circle-info ',
                    'data-settings' => [
                        wp_json_encode([
                            "id"           => 'elematic-circle-info-' . $this->get_id(),
                            "circleMoving" => $autoMode,
                            "movingTime"   => $autoModeTime,
                            "mouseEvent"   => $circleInfoEvent,
                        ]),
                    ],
                ],
            ]
        );

        ?> 

        <div <?php $this->print_render_attribute_string('circle_info'); ?>>
            <div class="elematic-circle-info-wrap" id="<?php echo esc_attr( 'elematic-circle-info-' . $this->get_id() ); ?>">

                <div class="elematic-circle-info-inner">
                    <?php
                    $i = 1;
                    foreach ($settings['circle_info_icon_list'] as $index => $item):

                        $this->add_render_attribute('sub_circle', 'class', 'elematic-circle-info-sub-circle', true);
                        if ($i == 1) {
                            $this->add_render_attribute('sub_circle', 'class', 'active');
                        }
                        $this->add_render_attribute('sub_circle', 'data-circle-index', $i++, true);

                        
                         $link_key_lg = 'link_' . $index; 
                        if (!empty($item['circle_info_title_link']['url'])) {

                            $this->add_render_attribute($link_key_lg, 'href', $item['circle_info_title_link']['url'], true);

                            if ($item['circle_info_title_link']['is_external']) {
                                $this->add_render_attribute($link_key_lg, 'target', '_blank', true);
                            }

                            if ($item['circle_info_title_link']['nofollow']) {
                                $this->add_render_attribute($link_key_lg, 'rel', 'nofollow', true);
                            }
                        } else {
                            $this->add_render_attribute($link_key_lg, 'href', '#', true);
                        }


                        ?>
                        <div <?php $this->print_render_attribute_string('sub_circle'); ?>>
                           <?php if($settings['link_on_icon'] == 'yes'): ?> 
                            <a <?php $this->print_render_attribute_string($link_key_lg); ?> >
                            <?php endif;?>    
                                <?php if (!empty($item['circle_info_item_icon']['value'])): ?>
                                <?php 
                                    Icons_Manager::render_icon($item['circle_info_item_icon'], ['aria-hidden' => 'true']); 
                                ?>
                                <?php endif;?>
                                <?php if (!empty($item['circle_info_item_icon_text'])): ?>
                                    <<?php echo esc_attr($item['circle_info_item_icon_text_tags']);?> class="elematic-circle-info-icon-text"><?php echo wp_kses_post($item['circle_info_item_icon_text']); ?></<?php echo esc_attr($item['circle_info_item_icon_text_tags']);?> >
                                <?php endif;?>
                            
                            <?php if($settings['link_on_icon'] == 'yes'): ?>
                            </a>
                           <?php endif;?>

                        </div>
                    <?php endforeach;?>
                </div>

                <div class="elematic-circle-info-content">
                    <?php
                    $i = 1;
                    foreach ($settings['circle_info_icon_list'] as $index => $item):
                        
                        $this->add_render_attribute('circle_content', 'class', 'elematic-circle-info-item icci'. $i++ .' elementor-repeater-item-'.esc_attr($item['_id']), true); 
                    
                        if ($i == 2) {
                            $this->add_render_attribute('circle_content', 'class', 'active');
                        }
                        $this->add_render_attribute('circle_title_tags', 'class', 'elematic-circle-info-title');


                        $link_key = 'link_' . $index;
                        if (!empty($item['circle_info_title_link']['url'])) {

                            $this->add_render_attribute($link_key, 'href', $item['circle_info_title_link']['url'], true);
 
                            if ($item['circle_info_title_link']['is_external']) {
                                $this->add_render_attribute($link_key, 'target', '_blank', true);
                            }

                            if ($item['circle_info_title_link']['nofollow']) {
                                $this->add_render_attribute($link_key, 'rel', 'nofollow', true);
                            }
                        } else {
                            $this->add_render_attribute($link_key, 'href', '#', true);
                        }


                        ?>

                        <div <?php $this->print_render_attribute_string('circle_content'); ?>>
    
                            <?php if (!empty($item['circle_info_item_icon']['value'])): ?>
                                <div class="elematic-circle-info-icon d-md-none">
                                    <?php if($settings['link_on_icon'] == 'yes'): ?>
                                        <a <?php $this->print_render_attribute_string($link_key); ?> >
                                    <?php endif;?>
                                    <?php 
                                        Icons_Manager::render_icon($item['circle_info_item_icon'], ['aria-hidden' => 'true']);
                                    ?>
                                    <<?php echo esc_attr($item['circle_info_item_icon_text_tags']);?> class="elematic-circle-info-icon-text"><?php echo wp_kses_post($item['circle_info_item_icon_text']); ?></<?php echo esc_attr($item['circle_info_item_icon_text_tags']);?> >
                                    <?php if($settings['link_on_icon'] == 'yes'): ?>
                                        </a>
                                    <?php endif;?>
                                </div>
                            <?php endif;?>

                            <div class="elematic-circle-info-content-inner">
                                <div>
                                    <a <?php $this->print_render_attribute_string($link_key); ?> >
                                        <<?php echo esc_attr($settings['title_tags']); ?> <?php $this->print_render_attribute_string('circle_title_tags'); ?>>
                                            <?php echo wp_kses_post($item['circle_info_item_title']); ?>
                                        </<?php echo esc_attr($settings['title_tags']); ?>>
                                    </a>
                                </div>

                                <div class="elematic-circle-info-desc">
                                    <?php echo wp_kses_post( $item['circle_info_item_details'] ); ?>
                                </div>
                            </div>

                        </div>

                    <?php endforeach;?>

                </div>

            </div>
        </div>

        <?php
    }
}

