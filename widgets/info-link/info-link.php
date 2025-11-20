<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Icons_Manager;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class InfoLink extends Widget_Base {

    public function get_name() {
        return 'elematic-info-link';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Info Link', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-post-list';
    }
    public function get_style_depends() {
        return ['elematic-info-link'];
    }
    public function get_script_depends() {
        return ['elematic-info-link'];
    }
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }
    
    protected function register_controls() {

        $this->start_controls_section(
            'section_tabs_item',
            [
                'label' => __('Items', 'elematic-addons-for-elementor'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'icon_type',
            [
                'label'        => esc_html__('Icon Type', 'elematic-addons-for-elementor'),
                'type'         => Controls_Manager::CHOOSE,
                'toggle'       => false,
                'default'      => 'icon',
                'render_type'  => 'template',
                'options'      => [
                    'icon' => [
                        'title' => esc_html__('Icon', 'elematic-addons-for-elementor'),
                        'icon'  => 'fas fa-star'
                    ],
                    'image' => [
                        'title' => esc_html__('Image', 'elematic-addons-for-elementor'),
                        'icon'  => 'far fa-image',
                    ],
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label'            => __('Icon', 'elematic-addons-for-elementor'),
                'type'             => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition'        => [
                    'icon_type' => 'icon',
                ],
            ]
        );

        $repeater->add_control(
            'icon_image',
            [
                'label'       => __('Image Icon', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::MEDIA,
                'render_type' => 'template',
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_type' => 'image',
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'icon_image_size',
                'default' => 'full',
                'condition' => [
                    'icon_image[url]!' => '',
                    'icon_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'tab_info',
            [
                'label'       => __('Info', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'default'     => __('Info', 'elematic-addons-for-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'tab_info_link',
            [
                'label'         => esc_html__('Link', 'elematic-addons-for-elementor'),
                'type'          => Controls_Manager::URL,
                'default'       => ['url' => '#'],
                'show_external' => false,
                'dynamic'       => ['active' => true],
                'condition'     => [
                    'tab_info!' => ''
                ]
            ]
        );
        $repeater->add_control(
            'info_tags',
            [
                'label'   => __('HTML Tag', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => Helper::elematic_html_tags(),
                
            ]
        );

        $repeater->add_control(
            'tab_image',
            [
                'label' => esc_html__( 'Tab Image', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'tab_image_size',
                'default' => 'full',
                'condition' => [
                    'tab_image[url]!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'tab_title',
            [
                'label'       => __('Tab Title', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'default'     => __('Tab Title', 'elematic-addons-for-elementor'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_sub_title',
            [
                'label'       => __('Tab Sub Title', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tabs_button',
            [
                'label'       => esc_html__('Tab Button Text', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Read More', 'elematic-addons-for-elementor'),
                'label_block' => true,
                'dynamic'     => ['active' => true],
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label'         => esc_html__('Button Link', 'elematic-addons-for-elementor'),
                'type'          => Controls_Manager::URL,
                'default'       => ['url' => '#'],
                'show_external' => false,
                'dynamic'       => ['active' => true],
                'condition'     => [
                    'tabs_button!' => ''
                ]
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'type'       => Controls_Manager::WYSIWYG,
                'dynamic'    => ['active' => true],
                'default'    => __('Tab Content', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'tabs',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_sub_title'   => __('Subtitle Goes Here', 'elematic-addons-for-elementor'),
                        'tab_title'       => __('Item One', 'elematic-addons-for-elementor'),
                        'tab_content'     => __('Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi.', 'elematic-addons-for-elementor'),
                        'selected_icon'   => ['value' => 'far fa-laugh', 'library' => 'fa-regular'],
                        'tab_info'        => __('Info One', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'tab_sub_title'   => __('Subtitle Goes Here', 'elematic-addons-for-elementor'),
                        'tab_title'   => __('Item Two', 'elematic-addons-for-elementor'),
                        'tab_content' => __('Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi.', 'elematic-addons-for-elementor'),
                        'selected_icon'  => ['value' => 'fas fa-cog', 'library' => 'fa-solid'],
                        'tab_info'        => __('Info Two', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'tab_sub_title'   => __('Subtitle Goes Here', 'elematic-addons-for-elementor'),
                        'tab_title'   => __('Item Three', 'elematic-addons-for-elementor'),
                        'tab_content' => __('Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi.', 'elematic-addons-for-elementor'),
                        'selected_icon'  => ['value' => 'fas fa-dice-d6', 'library' => 'fa-solid'],
                        'tab_info'        => __('Info Three', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'tab_sub_title'   => __('Subtitle Goes Here', 'elematic-addons-for-elementor'),
                        'tab_title'   => __('Item Four', 'elematic-addons-for-elementor'),
                        'tab_content' => __('Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi.', 'elematic-addons-for-elementor'),
                        'selected_icon'  => ['value' => 'fas fa-ring', 'library' => 'fa-solid'],
                        'tab_info'        => __('Info Four', 'elematic-addons-for-elementor'),
                    ],
                ],

                'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) }}} {{{ tab_info }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_layout_elematic_info_links',
            [
                'label' => esc_html__('Settings', 'elematic-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'tabs_item_cutom_width',
            [
                'label' => esc_html__('Area Width(%)', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links .elematic-info-link-custom-width' => 'width: {{SIZE}}%;',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'          => esc_html__('Link Columns', 'elematic-addons-for-elementor'),
                'type'           => Controls_Manager::SELECT,
                'desktop_default' => '100%',
                'tablet_default' => '100%',
                'mobile_default' => '100%',
                'options' => [
                    '100%' => esc_html__( '1', 'elematic-addons-for-elementor' ),
                    '50%' => esc_html__( '2', 'elematic-addons-for-elementor' ),
                    '33.333%' => esc_html__( '3', 'elematic-addons-for-elementor' ),
                    '25%' => esc_html__( '4', 'elematic-addons-for-elementor' ),
                    '20%' => esc_html__( '5', 'elematic-addons-for-elementor' ),
                    '16.666%' => esc_html__( '6', 'elematic-addons-for-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-link-item-container' => 'width: {{VALUE}};',
                ],
                'render_type' => 'template'
            ]
        );

        $this->add_control(
            'elematic_info_links_event',
            [
                'label'   => __('Select Event', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'mouseover',
                'options' => [
                    'click'     => __('Click', 'elematic-addons-for-elementor'),
                    'mouseover' => __('Hover', 'elematic-addons-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'elematic_info_links_position',
            [
                'label'   => __('Select Tabs Position', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => __('Left', 'elematic-addons-for-elementor'),
                    'right' => __('Right', 'elematic-addons-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'tabs_content_height_show',
            [
                'label' => __('Content Fixed Height', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'tabs_content_height',
            [
                'label' => esc_html__('Height', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                       
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-height-fixed .elematic-info-links-content' => 'max-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-info-links-height-fixed' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'tabs_content_height_show' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'tabs_content_align',
            [
                'label'   => __('Alignment', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'elematic-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'elematic-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'elematic-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'elematic-addons-for-elementor'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label'   => esc_html__('Show Image', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_sub_title',
            [
                'label'   => esc_html__('Show Sub Title', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'sub_title_tags',
            [
                'label'   => __('HTML Tag', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h4',
                'options' => Helper::elematic_html_tags(),
                'condition' => [
                    'show_sub_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => esc_html__('Show Title', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_tags',
            [
                'label'   => __('HTML Tag', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => Helper::elematic_html_tags(),
                'condition' => [
                    'show_title' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_content',
            [
                'label'   => esc_html__('Show Text', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label'   => esc_html__('Show Button', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'elematic_info_links_active_item',
            [
                'label'       => __('Active Item', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 1,
                'description' => 'Type your item number.',
            ]
        );

        $this->end_controls_section();

        //Style
        $this->start_controls_section(
            'section_elematic_info_links_style',
            [
                'label' => __('Styles', 'elematic-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_content_padding',
            [
                'label'      => __('Tab Padding', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_item_style');

        $this->start_controls_tab(
            'tabs_item_normal',
            [
                'label' => __('Normal', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'tabs_item_color',
            [
                'label'     => __('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-item *'  => 'color: {{VALUE}};fill: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_item_background',
                'selector'  => '{{WRAPPER}} .elematic-info-links-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'tabs_item_typography',
                   'selector'  => '{{WRAPPER}} .elematic-info-links-item *',
                   
              ]
        );

        $this->add_responsive_control(
            'tabs_item_icon_size',
            [
                'label' => __('Icon Size', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'vh', 'vw'],
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-info-links-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tabs_item_image_size',
            [
                'label' => __('Image Size', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'vh', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-icon img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'icon_rotate',
            [
                'label'   => __('Rotate', 'elematic-addons-for-elementor'),
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
                    '{{WRAPPER}} .elematic-info-links-icon i, {{WRAPPER}} .elematic-info-links-icon svg, {{WRAPPER}} .elematic-info-links-icon img'   => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_padding',
            [
                'label'      => esc_html__('Icon Padding', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'icon_border',
                'selector'    => '{{WRAPPER}} .elematic-info-links-icon'
            ]
        );

        $this->add_control(
            'icon_radius',
            [
                'label'      => esc_html__('Icon Border Radius', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'separator'  => 'after',
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_item_padding',
            [
                'label'      => esc_html__('Item Padding', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'tabs_item_margin',
            [
                'label'      => esc_html__('Item Margin', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'tabs_item_border',
                'selector'    => '{{WRAPPER}} .elematic-info-links-item',
            ]
        );

        $this->add_control(
            'tabs_item_radius',
            [
                'label'      => esc_html__('Border Radius', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
                
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'tabs_item_shadow',
                'selector' => '{{WRAPPER}} .elematic-info-links-item'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_item_hover',
            [
                'label' => __('hover', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'tabs_item_hover_color',
            [
                'label'     => __('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-item:hover *'  => 'color: {{VALUE}};fill: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_item_hover_background',
                'selector'  => '{{WRAPPER}} .elematic-info-links-item:hover',
            ]
        );

        $this->add_control(
            'tabs_item_hover_border_color',
            [
                'label'     => __('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-item:hover'  => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'tabs_item_border_border!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'tabs_item_hover_shadow',
                'selector' => '{{WRAPPER}} .elematic-info-links-item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_item_active',
            [
                'label' => __('Active', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'tabs_item_active_color',
            [
                'label'     => __('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-item.active *'  => 'color: {{VALUE}};fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tabs_item_active_background',
                'selector'  => '{{WRAPPER}} .elematic-info-links-item.active',
            ]
        );

        $this->add_control(
            'tabs_item_active_border_color',
            [
                'label'     => __('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-item.active'  => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'tabs_item_border_border!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'tabs_item_active_shadow',
                'selector' => '{{WRAPPER}} .elematic-info-links-item.active',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_tab_image',
            [
                'label'     => esc_html__('Tab Image', 'elematic-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_image' => ['yes'],
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tab_img_border',
                'selector' => '{{WRAPPER}} .elematic-info-links-image img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'tab_img_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'tab_img_radius_advanced_show',
            [
                'label' => __('Advanced Radius', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );
		
		$example = '75% 25% 43% 57% / 46% 29% 71% 54%';
		$url     = esc_url( 'https://9elements.github.io/fancy-border-radius/' );

		
		$desc = sprintf(
			/* translators: 1: example border-radius value, 2: URL to a border-radius generator tool. */
			__( 'For example: <b>%1$s</b> or go <a href="%2$s" target="_blank" rel="noopener noreferrer">this link</a> and copy and paste the radius value.', 'elematic-addons-for-elementor' ),
			esc_html( $example ),
			$url
		);

		// Allow only safe tags.
		$desc = wp_kses(
			$desc,
			array(
				'b' => array(),
				'a' => array(
					'href'   => array(),
					'target' => array(),
					'rel'    => array(),
				),
			)
		);

        $this->add_control(
            'tab_img_radius_advanced',
            [
                'label'       => esc_html__('Radius', 'elematic-addons-for-elementor'),
                'description' => $desc,
                'type'        => Controls_Manager::TEXT,
                'size_units'  => ['px', '%'],
                'default'     => '75% 25% 43% 57% / 46% 29% 71% 54%',
                'selectors'   => [
                    '{{WRAPPER}} .elematic-info-links-image img'     => 'border-radius: {{VALUE}}; overflow: hidden;',
                ],
                'condition' => [
                    'tab_img_radius_advanced_show' => 'yes',
                ],
            ]
        );
		
        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'tab_img_css_filters',
                'selector' => '{{WRAPPER}} .elematic-info-links-image img',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'tab_img_shadow',
                'selector' => '{{WRAPPER}} .elematic-info-links-image'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_title',
            [
                'label'     => esc_html__('Tab Title', 'elematic-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-title *' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'     => esc_html__('Spacing', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-title' => 'padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'elematic-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .elematic-info-links-title *',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'title_text_stroke',
                'label' => __('Text Stroke', 'elematic-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .elematic-info-links-title *',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_sub_title',
            [
                'label'     => esc_html__('Tab Sub Title', 'elematic-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_sub_title' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-sub-title *' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_title_spacing',
            [
                'label'     => esc_html__('Spacing', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_title_typography',
                'label'    => esc_html__('Typography', 'elematic-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .elematic-info-links-sub-title *',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_description',
            [
                'label'     => esc_html__('Tab Description', 'elematic-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_content' => ['yes'],
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_spacing',
            [
                'label'     => esc_html__('Spacing', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-text' => 'padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'label'    => esc_html__('Typography', 'elematic-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .elematic-info-links-text',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label'     => esc_html__('Tab Button', 'elematic-addons-for-elementor'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-button a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'button_background',
                'selector'  => '{{WRAPPER}} .elematic-info-links-button a',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-info-links-button a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'button_border',
                'label'       => esc_html__('Border', 'elematic-addons-for-elementor'),
                'selector'    => '{{WRAPPER}} .elematic-info-links-button a',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'border_radius_advanced_show!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'border_radius_advanced_show',
            [
                'label' => __('Advanced Radius', 'elematic-addons-for-elementor'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'border_radius_advanced',
            [
                'label'       => esc_html__('Radius', 'elematic-addons-for-elementor'),
				/* translators: 1: example border-radius value, 2: URL to a border-radius generator tool. */
                'description' => sprintf(__('For example: <b>%1$1s</b> or Go <a href="%2$2s" target="_blank">this link</a> and copy and paste the radius value.', 'elematic-addons-for-elementor'), '30% 70% 82% 18% / 46% 62% 38% 54%', 'https://9elements.github.io/fancy-border-radius/'),
                'type'        => Controls_Manager::TEXT,
                'size_units'  => ['px', '%'],
                'separator'   => 'after',
                'default'     => '30% 70% 82% 18% / 46% 62% 38% 54%',
                'selectors'   => [
                    '{{WRAPPER}} .elematic-info-links-button a'     => 'border-radius: {{VALUE}}; overflow: hidden;',
                ],
                'condition' => [
                    'border_radius_advanced_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label'      => esc_html__('Padding', 'elematic-addons-for-elementor'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-info-links-button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typography',
                'label'     => esc_html__('Typography', 'elematic-addons-for-elementor'),
                'selector'  => '{{WRAPPER}} .elematic-info-links-button a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'elematic-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-button a:hover'  => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'button_hover_background',
                'selector'  => '{{WRAPPER}} .elematic-info-links-button a:hover',
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'button_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-info-links-button a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function activeItem($active_item, $totalItem) {
        $active_item = (int) $active_item;
        return $active_item = ($active_item <= 0 || $active_item > $totalItem ? 1 : $active_item);
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ($settings['elematic_info_links_event']) {
            $event = $settings['elematic_info_links_event'];
        } else {
            $event = false;
        }

        $this->add_render_attribute(
            [
                'tabs' => [
                    'id' => 'elematic-info-links-' . $this->get_id(),
                    'class' => 'elematic-info-links',
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'tabs_id' => 'elematic-info-links-' . $this->get_id(),
                            'mouse_event' => $event,
                        ]))
                    ]
                ]
            ]
        );

?>
        <div <?php $this->print_render_attribute_string('tabs'); ?>>
            <div class="elematic-info-link-grid align-items-center">

                <?php if ('left' == $settings['elematic_info_links_position']) : ?>
                    <div class="elematic-info-link-custom-width align-items-center">
                        <?php $this->tab_items(); ?>
                    </div>
                    <div class="elematic-info-link-content-container">
                        <?php $this->tabs_content(); ?>
                    </div>
                <?php endif; ?>

                <?php if ('right' == $settings['elematic_info_links_position']) : ?>
                    <div class="elematic-info-link-content-container">
                        <?php $this->tabs_content(); ?>
                    </div>
                    <div class="align-items-center elematic-info-link-custom-width <?php echo esc_attr($settings['elematic_info_links_position']);?>">
                        <?php $this->tab_items(); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    <?php
    }

    public function tabs_content() {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();

        if ($settings['tabs_content_height_show'] == 'yes') {
            $this->add_render_attribute('tabs-content-wrapper', 'class', 'elematic-info-links-height-fixed');
        }
        $this->add_render_attribute('tabs-content-wrapper', 'class', 'elematic-info-links-content-wrap');

    ?>
        <div <?php $this->print_render_attribute_string('tabs-content-wrapper'); ?>>
            <?php foreach ($settings['tabs'] as $index => $item) :
                $tab_count = $index + 1;
                $tab_id    = 'elematic-infolink-' . $tab_count . esc_attr($id);

                $active_item = $this->activeItem($settings['elematic_info_links_active_item'], count($settings['tabs']));

                if ($tab_id    == 'elematic-infolink-' . $active_item . esc_attr($id)) {
                    $this->add_render_attribute('tabs-content', 'class', 'elematic-info-links-content active', true);
                } else {
                    $this->add_render_attribute('tabs-content', 'class', 'elematic-info-links-content', true);
                }

            ?>

                <div id="<?php echo esc_attr($tab_id); ?>" <?php $this->print_render_attribute_string('tabs-content'); ?>>

                    <?php if ($item['tab_image'] && ('yes' == $settings['show_image'])) : ?>
                        <div class="elematic-info-links-image">
                            <?php Group_Control_Image_Size::print_attachment_image_html( $item, 'tab_image_size', 'tab_image' ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($item['tab_sub_title'] && ('yes' == $settings['show_sub_title'])) : ?>
                        <div class="elematic-info-links-sub-title">
                            <<?php echo esc_attr($settings['sub_title_tags']); ?>><?php echo esc_html($item['tab_sub_title']); ?></<?php echo esc_attr($settings['sub_title_tags']); ?>>
                        </div>
                    <?php endif; ?>

                    <?php if ($item['tab_title'] && ('yes' == $settings['show_title'])) : ?>
                        <div class="elematic-info-links-title">
                            <<?php echo esc_attr($settings['title_tags']); ?>>
                                <?php echo esc_html($item['tab_title']); ?>
                            </<?php echo esc_attr($settings['title_tags']); ?>>
                        </div>
                    <?php endif; ?>

                    <?php if ($item['tab_content'] && ('yes' == $settings['show_content'])) : ?>
                        <div class="elematic-info-links-text">
                            <?php echo wp_kses_post($this->parse_text_editor($item['tab_content'])); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($item['tabs_button'] && ('yes' == $settings['show_button'])) : ?>
                        <div class="elematic-info-links-button">
                            <?php if ('' !== $item['button_link']['url']) : ?>
                                <?php 
                                $link_key = 'link_key_' . $index;
                                $this->add_link_attributes($link_key, $item['button_link']);
                                ?>
                                <a <?php $this->print_render_attribute_string($link_key); ?>>
                                <?php endif; ?>
                                <?php echo wp_kses_post($item['tabs_button']); ?>
                                <?php if ('' !== $item['button_link']['url']) : ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </div>

    <?php
    }

    public function tab_items() {
        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();

        $this->add_render_attribute('tab-settings', 'data-elematic-info-links-items', 'connect: #elematic-infolink-content-' .  esc_attr($id) . ';');

    ?>
        <div <?php $this->print_render_attribute_string('tab-settings'); ?>>
            <div class="elematic-info-link-grid-item">

                <?php foreach ($settings['tabs'] as $index => $item) :

                    $tab_count = $index + 1;
                    $tab_id    = 'elematic-infolink-' . $tab_count . esc_attr($id);
                    $active_item = $this->activeItem($settings['elematic_info_links_active_item'], count($settings['tabs']));
                    if ($tab_id    == 'elematic-infolink-' . $active_item . esc_attr($id)) {
                        $this->add_render_attribute('tabs-item', 'class', 'elematic-info-links-item active', true);
                    } else {
                        $this->add_render_attribute('tabs-item', 'class', 'elematic-info-links-item', true);
                    }

                    $has_icon  = !empty($item['selected_icon']);
                    $has_image = !empty($item['icon_image']['url']);

                ?>
                    <div class="elematic-info-link-item-container">
                        <div <?php $this->print_render_attribute_string('tabs-item'); ?> data-id="<?php echo esc_attr($tab_id); ?>">
                            <<?php echo esc_attr($item['info_tags']); ?> class="elematic-info-links-info" data-tab-index="<?php echo esc_attr($index); ?>">

                                <?php if ($has_icon or $has_image) : ?>
                                    <span class="elematic-info-links-icon">
                                        <?php if ($has_icon and 'icon' == $item['icon_type']) { ?>

                                            <?php Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']); ?>

                                        <?php } elseif ($has_image and 'image' == $item['icon_type']) {
                                                Group_Control_Image_Size::print_attachment_image_html( $item, 'icon_image_size', 'icon_image' );
                                            }
                                        ?>
                                    </span>
                                <?php endif; ?>
                                <?php 

                                $info_link = $item['tab_info_link']['url'];

                                if (!empty($info_link) && $settings['elematic_info_links_event'] !== 'click') {
                                    $this->add_link_attributes("info_link_$index", $item['tab_info_link']);
                                    echo '<a ' . wp_kses_post( $this->get_render_attribute_string( "info_link_$index" ) ) . '>' 
   . esc_html( $item['tab_info'] ) 
   . '</a>';
                                } else {
                                    echo esc_html($item['tab_info']);
                                }
                                ?>

                            </<?php echo esc_attr($item['info_tags']); ?>>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
<?php
    }
}