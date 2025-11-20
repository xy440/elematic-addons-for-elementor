<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ProgressBar extends Widget_Base {

    public function get_name() {
        return 'elematic-progress-bar';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Progress Bar', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-skill-bar';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_style_depends() {
        return [ 'elematic-progress-bar' ];
    }

    public function get_script_depends() {
        return [ 'elematic-progress-bar'];
    }

    public function get_keywords() {
        return [ 'progress', 'bar', 'skill' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'progressbar_content',
            [
                'label' => esc_html__( 'Progress Bar', 'elematic-addons-for-elementor' ),
            ]
        );
        
            $this->add_control(
                'elematic_progress_bar_style',
                [
                    'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'horizontal',
                    'options' => [
                        'horizontal' => esc_html__( 'Horizontal', 'elematic-addons-for-elementor' ),
                        'vertical'   => esc_html__( 'Vertical', 'elematic-addons-for-elementor' ),
                    ],
                ]
            );

            $this->add_control(
                'elematic_progress_bar_type',
                [
                    'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'normal',
                    'options' => [
                        'normal'   => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
                        'striped' => esc_html__( 'Striped', 'elematic-addons-for-elementor' ),
                    ],
                ]
            );


            $repeater = new Repeater();

            $repeater->add_control(
                'elematic_progressbar_title', 
                [
                    'label'       => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                    'type'        => Controls_Manager::TEXT,
                    'default'     => esc_html__( 'WordPress' , 'elematic-addons-for-elementor' ),
                ]
            );

            $repeater->add_control(
                'elematic_progressbar_value', 
                [
                    'label' => esc_html__( 'Progress Bar Value', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 75,
                    ]
                ]
            );

            $repeater->add_control(
                'elematic_progressbar_color', 
                [
                    'label'     => esc_html__( 'Progress bar color', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .elematic-progress-bar' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $repeater->add_control(
                'elematic_progressbar_value_color', 
                [
                    'label'     => esc_html__( 'Progress bar value color', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .percent-label' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $repeater->add_control(
                'elematic_progressbar_value_bg_color', 
                [
                    'label'     => esc_html__( 'Progress bar value background color', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .percent-label' => 'background-color: {{VALUE}};',
                    ],
                ]
            );

            $repeater->add_control(
                'elematic_progressbar_indicator_color', 
                [
                    'label'     => esc_html__( 'Progress Indicator', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-progress-indicator .elematic-progressbar-content .elematic-progress-bar::after' => 'background-color: {{VALUE}};border-color: {{VALUE}};'
                    ],
                ]
            );

            $repeater->add_control(
                'progressbar_before_after', 
                [
                    'label'         => esc_html__( 'Value Indicator', 'elematic-addons-for-elementor' ),
                    'type'          => Controls_Manager::SWITCHER,
                    'return_value'  => 'yes',
                    'default'       => 'no',
                ]
            );
            $repeater->add_control(
                'progressbar_value_before_after_color', 
                [
                    'label'     => esc_html__( 'Indicator color', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-progressbar-value-bottom .elematic-progressbar-content .percent-label::after' => 'border-top: 5px solid {{VALUE}};',
                    ],
                    'condition' => [
                        'progressbar_before_after' =>'yes',
                    ],
                    'separator' => 'before',
                ]
            );      


            $this->add_control(
            'elematic_progressbar_list',
            [
                'label'     => esc_html__( 'Progress Bar', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'prevent_empty'=>false,
                'default' => [
                    [
                        'elematic_progressbar_title'         => esc_html__('WordPress','elematic-addons-for-elementor'),
                        'elematic_progressbar_color'         => '#111',
                        'elematic_progressbar_value_color'   => '#111',
                        
                    ],

                ],
                'title_field' => '{{{ elematic_progressbar_title }}}',
            ]
        );

        $this->end_controls_section();

        // Progress Bar value style tab start
        $this->start_controls_section(
            'elematic_progressbar_items_style',
            [
                'label'     => esc_html__( 'Items Style', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_responsive_control(
                'elematic_progress_height',
                [
                    'label' => esc_html__( 'Height', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 300,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                        
                    ],
                    'default' => [
                        'size' => 10,
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content' => 'height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'elematic_progress_bar_style' =>'horizontal',
                    ],

                ]
            );

            $this->add_responsive_control(
                'elematic_progress_position',
                [
                    'label' => esc_html__( 'Progress Position Top-Bottom', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progress-bar' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'elematic_progress_bar_style' =>'horizontal',
                    ],

                ]
            );
            $this->add_responsive_control(
                'elematic_progress_spacing',
                [
                    'label' => esc_html__( 'Spacing btween two bars', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 300,
                        ],
                        
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-bar-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'elematic_progress_bar_style' =>'horizontal',
                    ],

                ]
            );
            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'progressbarbackground',
                    'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_items_border',
                    'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content', 
                ]
            );

            $this->add_responsive_control(
                'progressbar_items_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                        '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progress-bar' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'progressbar_items_box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_items_padding',
                [
                    'label' => esc_html__( 'Item Padding', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-bar-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_items_inner_padding',
                [
                    'label' => esc_html__( 'Item Inner Padding', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'progress_bar_indicator',
                [
                    'label' => esc_html__( 'Progress Indicator', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default' => 'no',
                    'separator' => 'before',
                ]
            );


            $this->add_control(
                'indicatordimention',
                [
                    'label' => esc_html__( 'Indicator Size', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 200,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => 'px',
                        'size' => 24,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-indicator .elematic-progressbar-content .elematic-progress-bar::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'indicatorbackground',
                    'label' => esc_html__( 'Indicator Background', 'elematic-addons-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .elematic-progress-indicator .elematic-progressbar-content .elematic-progress-bar::after',
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_indicator_border',
                    'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-progress-indicator .elematic-progressbar-content .elematic-progress-bar::after',
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );

            $this->add_responsive_control(
                'progressbar_indicator_border_radius',
                [
                    'label' => esc_html__( 'Indicator Border Radius', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-indicator .elematic-progressbar-content .elematic-progress-bar::after' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'condition' => [
                        'progress_bar_indicator' =>'yes',
                    ],
                ]
            );            
            

        $this->end_controls_section(); // Progress Bar value style tab end        

        // Style tab Title section
        $this->start_controls_section(
            'elematic_progressbar_title_style',
            [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'progress_text_postion',
                [
                    'label' => esc_html__( 'Position', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Inner', 'elematic-addons-for-elementor' ),
                    'label_off' => esc_html__( 'Outer', 'elematic-addons-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

            $this->add_group_control(
                Group_Control_Background::get_type(),
                [
                    'name' => 'titlebackground',
                    'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                    'types' => [ 'classic', 'gradient' ],
                    'selector' => '{{WRAPPER}} .elematic_progress_title',
                ]
            );

            $this->add_responsive_control(
                'progressbar_title_padding',
                [
                    'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic_progress_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_title_margin',
                [
                    'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic_progress_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_title_border',
                    'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic_progress_title',
                ]
            );

            $this->add_responsive_control(
                'progressbar_title_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .elematic_progress_title' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'progressbar_title_box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic_progress_title',
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'progressbar_progressbar_title_color',
                [
                    'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic_progress_title' => 'color: {{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'progressbar_title_typography',
                    'label' => esc_html__( 'Typography', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic_progress_title',
                    'separator' => 'before',
                ]
            );

        $this->end_controls_section(); // Progress Bar title style tab end

        // Progress Bar value style tab start
        $this->start_controls_section(
            'elematic_progressbar_value_style',
            [
                'label'     => esc_html__( 'Value', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

            $this->add_control(
                'progress_value_postion',
                [
                    'label' => esc_html__( 'Position', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Inner', 'elematic-addons-for-elementor' ),
                    'label_off' => esc_html__( 'Outer', 'elematic-addons-for-elementor' ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );
            $this->add_control(
                'progressbar_value_color',
                [
                    'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progressbar-content .percent-label' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'progressbar_value_padding',
                [
                    'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progressbar-content .percent-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'progressbar_value_border',
                    'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-progressbar-content .percent-label',
                ]
            );

            $this->add_responsive_control(
                'progressbar_value_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progressbar-content .percent-label' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    ],
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'progressbar_value_box_shadow',
                    'label' => esc_html__( 'Box Shadow', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-progressbar-content .percent-label',
                    'separator' => 'before',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'progressbar_value_typography',
                    'label' => esc_html__( 'Typography', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content .percent-label',
                    'separator' => 'before',
                ]
            );

            $this->add_responsive_control(
                'progressbar_value_position',
                [
                    'label' => esc_html__( 'Position', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => -100,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-progress-bar-wrapper .elematic-progressbar-content .percent-label' => 'top: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'elematic_progress_bar_style' =>'horizontal',
                        'progress_value_postion!' => 'yes'
                    ],

                ]
            );

        $this->end_controls_section();


    }

    protected function render( $instance = [] ) {
    $settings         = $this->get_settings_for_display();
    $progressbar_list = $settings['elematic_progressbar_list'];
    $progress_type_class = ( $settings['elematic_progress_bar_type'] === 'striped' ) ? 'elematic-progress-bar-striped ' : '';

    if ( ! $progressbar_list ) {
        return;
    }

    // group wrapper so we can control layout (row for vertical)
    $group_class = 'elematic-progressbar-list elematic-progressbar-list-' . esc_attr( $settings['elematic_progress_bar_style'] );

    echo '<div class="' . esc_attr($group_class) . '">';

    foreach ( $progressbar_list as $key => $item ) {

        $column_repeater_key = $this->get_repeater_setting_key( 'elematic_progressbar_title', 'elematic_progressbar_list', $key );

        $this->add_render_attribute( $column_repeater_key, 'class', 'elematic-progress-bar-wrapper' );
        $this->add_render_attribute( $column_repeater_key, 'class', 'elematic-progress-bar-style-' . esc_attr( $settings['elematic_progress_bar_style'] ) );

        if ( $settings['progress_value_postion'] === 'yes' ) {
            $this->add_render_attribute( $column_repeater_key, 'class', 'elematic-progress-value-inner' );
        }

        if ( $settings['progress_text_postion'] === 'yes' ) {
            $this->add_render_attribute( $column_repeater_key, 'class', 'elematic-progress-text-inner' );
        }

        $this->add_render_attribute( $column_repeater_key, 'class', 'elementor-repeater-item-' . esc_attr( $item['_id'] ) );

        if ( isset( $item['progressbar_before_after'] ) && $item['progressbar_before_after'] === 'yes' ) {
            $this->add_render_attribute( $column_repeater_key, 'class', 'elematic-progressbar-value-bottom' );
        }

        if ( $settings['progress_bar_indicator'] === 'yes' ) {
            $this->add_render_attribute( $column_repeater_key, 'class', 'elematic-progress-indicator' );
        }

        // value / style per item
        $percent = isset( $item['elematic_progressbar_value']['size'] )
            ? (float) $item['elematic_progressbar_value']['size']
            : 0;

        // start from 0; JS/IO will animate to target
        $bar_style = '';
        if ( 'vertical' === $settings['elematic_progress_bar_style'] ) {
            $bar_style = sprintf( '--elematic-target:%s%%; height:0;', $percent );
        } else {
            $bar_style = sprintf( '--elematic-target:%s%%; width:0;', $percent );
        }
        ?>
        <div <?php $this->print_render_attribute_string( $column_repeater_key ); ?>>
            <p class="elematic_progress_title"><?php echo wp_kses_post( $item['elematic_progressbar_title'] ); ?></p>
            <div class="elematic-progressbar-content">
                <div class="elematic-progress-bar <?php echo esc_attr( $progress_type_class ); ?>"
                     role="progressbar"
                     style="<?php echo esc_attr( $bar_style ); ?>"
                     aria-valuenow="<?php echo esc_attr( $percent ); ?>"
                     aria-valuemin="0"
                     aria-valuemax="100">
                    <span class="percent-label"><?php echo esc_html( $percent ) . '%'; ?></span>
                </div>
            </div>
        </div>
        <?php
    }

    echo '</div><!-- .elematic-progressbar-list -->';
}
}