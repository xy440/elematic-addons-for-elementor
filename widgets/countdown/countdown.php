<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Countdown extends Widget_Base {

    public function get_name() {
        return 'elematic-countdown';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Countdown', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-countdown';
    }

    public function get_categories() {
        return [ 'elematic-elements' ];
    }
    public function get_style_depends() {
        return [ 'elematic-countdown' ];
    }
    public function get_script_depends() {
        return [ 'elematic-countdown','countdown' ];
    }
    public function get_keywords() {
        return [ 'countdown', 'timer' ];
    }

	protected function register_controls() {

        
        $this->start_controls_section(
            'tx_cd_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_control(
            'tx_cd_due_date_time',
            [
                'label'   => esc_html__( 'Set Date and Time', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::DATE_TIME,
                'default' => gmdate(
                    'Y-m-d',
                    current_time( 'timestamp', true ) + DAY_IN_SECONDS * 2
                ),
            ]
        );
        $this->add_control(
            'tx_cd_label_style',
            [
                'label' => esc_html__( 'Label', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'elematic-cd-label-block',
                'options' => [
                    'elematic-cd-label-block' => esc_html__( 'Block', 'elematic-addons-for-elementor' ),
                    'elematic-cd-label-inline' => esc_html__( 'Inline', 'elematic-addons-for-elementor' ),
                ],
            ]
        );
        $this->add_responsive_control(
            'tx_cd_label_spacing',
            [
                'label' => esc_html__( 'Label Spacing', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-label' => 'padding-left:{{SIZE}}px;',
                ],
                'condition' => [
                    'tx_cd_label_style' => 'elematic-cd-label-inline',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_separator',
            [
                'label' => esc_html__( 'Separator', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '-separator' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    '-none' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => '-none',
                'toggle' => false,
                'prefix_class' => 'elematic-cd'
            ]
        );
        $this->add_control(
            'tx_cd_days',
            [
                'label' => esc_html__( 'Days', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'separator' => 'before',
                'toggle' => false
            ]
        );
        $this->add_control(
            'tx_cd_days_label',
            [
                'label' => esc_html__( 'Label', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Days', 'elematic-addons-for-elementor' ),
                'condition' => [
                    'tx_cd_days' => 'show',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_hours',
            [
                'label' => esc_html__( 'Hours', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'separator' => 'before',
                'toggle' => false
            ]
        );
        $this->add_control(
            'tx_cd_hours_label',
            [
                'label' => esc_html__( 'Label', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Hours', 'elematic-addons-for-elementor' ),
                'condition' => [
                    'tx_cd_hours' => 'show',
                ],
            ]
        );       
        $this->add_control(
            'tx_cd_mins',
            [
                'label' => esc_html__( 'Minutes', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'separator' => 'before',
                'toggle' => false
            ]
        );
        $this->add_control(
            'tx_cd_mins_label',
            [
                'label' => esc_html__( 'Label', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Minutes', 'elematic-addons-for-elementor' ),
                'condition' => [
                    'tx_cd_mins' => 'show',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_secs',
            [
                'label' => esc_html__( 'Seconds', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'separator' => 'before',
                'toggle' => false
            ]
        );
        $this->add_control(
            'tx_cd_secs_label',
            [
                'label' => esc_html__( 'Label', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Seconds', 'elematic-addons-for-elementor' ),
                'condition' => [
                    'tx_cd_secs' => 'show',
                ],
            ]
        );           
        $this->end_controls_section();
        
        $this->start_controls_section(
            'tx_cd_styles',
            [
                'label' => esc_html__( 'Styles', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'tx_cd_background',
            [
                'label' => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'tx_cd_spacing',
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
                    '{{WRAPPER}} .elematic-cd-content > div' => 'margin-right:{{SIZE}}px; margin-left:{{SIZE}}px;',
                    '{{WRAPPER}} .elematic-countdown-container' => 'margin-right: -{{SIZE}}px; margin-left: -{{SIZE}}px;',
                ],
            ]
        );        
        $this->add_responsive_control(
            'tx_cd_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tx_cd_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-cd-content > div',
            ]
        );
        $this->add_control(
            'tx_cd_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tx_cd_shadow',
                'selector' => '{{WRAPPER}} .elematic-cd-content > div',
            ]
        );
        $this->add_control(
            'tx_cd_digits_color',
            [
                'label' => esc_html__( 'Digits Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-digits' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => 'tx_cd_digit_typography',
                'selector' => '{{WRAPPER}} .elematic-cd-digits',
            ]
        );
        $this->add_control(
            'tx_cd_label_color',
            [
                'label' => esc_html__( 'Label Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-label' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => 'tx_cd_label_typography',
                'selector' => '{{WRAPPER}} .elematic-cd-label',
            ]
        );
        $this->end_controls_section();       
        $this->start_controls_section(
            'tx_cd_block_styles',
            [
                'label' => esc_html__( 'Block Styles', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'tx_cd_days_bg_color',
            [
                'label' => esc_html__( 'Days Background Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-days' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_days_digit_color',
            [
                'label' => esc_html__( 'Days Digit Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-days .elematic-cd-digits' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_days_label_color',
            [
                'label' => esc_html__( 'Days Label Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-days .elematic-cd-label' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_days_border_color',
            [
                'label' => esc_html__( 'Border Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-days' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_hours_bg_color',
            [
                'label' => esc_html__( 'Hours Background Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-hours' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'tx_cd_hours_hours_digit_color',
            [
                'label' => esc_html__( 'Hours Digit Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-hours .elematic-cd-digits' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_hours_label_color',
            [
                'label' => esc_html__( 'Hours Label Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-hours .elematic-cd-label' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_hours_border_color',
            [
                'label' => esc_html__( 'Border Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-hours' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_minutes_bg_color',
            [
                'label' => esc_html__( 'Minutes Background Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-minutes' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'tx_cd_minutes_digit_color',
            [
                'label' => esc_html__( 'Minutes Digit Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-minutes .elematic-cd-digits' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_minutes_label_color',
            [
                'label' => esc_html__( 'Minutes Label Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-minutes .elematic-cd-label' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_minutes_border_color',
            [
                'label' => esc_html__( 'Minutes Border Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-minutes' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_seconds_bg_color',
            [
                'label' => esc_html__( 'Seconds Background Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-seconds' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'tx_cd_seconds_digit_color',
            [
                'label' => esc_html__( 'Seconds Digit Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-seconds .elematic-cd-digits' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_seconds_label_color',
            [
                'label' => esc_html__( 'Seconds Label Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-seconds .elematic-cd-label' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'tx_cd_seconds_border_color',
            [
                'label' => esc_html__( 'Seconds Border Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-cd-content > div.elematic-cd-seconds' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

	protected function render( ) {
        $settings = $this->get_settings();
        $get_due_date =  esc_attr($settings['tx_cd_due_date_time']);
        $timestamp = strtotime( $get_due_date );
        $due_date  = wp_date( 'M d Y G:i:s', $timestamp );
        $id = $this->get_id();
        $this->add_render_attribute( 'elematic-cd-container', 'class', 'elematic-countdown-container ' . $settings['tx_cd_label_style'] );
        $this->add_render_attribute( 'elematic-cd-content', 'id', 'elematic-cd-' . $id );
        $this->add_render_attribute( 'elematic-cd-content', 'class', 'elematic-countdown-content' );
        $this->add_render_attribute( 'elematic-cd-content', 'data-date', $due_date );
        $this->add_render_attribute( 'elematic-cd-digits', 'class', 'elematic-cd-digits' );
        $this->add_render_attribute( 'elematic-cd-label', 'class', 'elematic-cd-label' );
        
    ?>

    <div class="elematic-countdown-wrapper">
        <div <?php $this->print_render_attribute_string( 'elematic-cd-container' ); ?> >
            <ul <?php $this->print_render_attribute_string( 'elematic-cd-content' ); ?>>
                <?php if ( $settings['tx_cd_days'] == 'show' ) : ?>
                    <li class="elematic-cd-content">
                        <div class="elematic-cd-days">
                            <span data-days <?php $this->print_render_attribute_string( 'elematic-cd-digits' ); ?>><?php echo esc_html__( '00', 'elematic-addons-for-elementor' ); ?></span>
                            <?php if ( ! empty($settings['tx_cd_days_label']) ) : ?>
                                <span class="elematic-cd-label"><?php echo esc_attr($settings['tx_cd_days_label'] ); ?></span>
                            <?php endif; ?>
                        </div><!-- elematic-cd-days -->
                    </li><!-- elematic-cd-content -->
                <?php endif; ?>
                <?php if ( $settings['tx_cd_hours'] == 'show' ) : ?>
                    <li class="elematic-cd-content">
                        <div class="elematic-cd-hours">
                            <span data-hours <?php $this->print_render_attribute_string( 'elematic-cd-digits' ); ?>><?php echo esc_html__( '00', 'elematic-addons-for-elementor' ); ?></span>
                            <?php if ( ! empty( $settings['tx_cd_hours_label'] ) ) : ?>
                                <span <?php $this->print_render_attribute_string( 'elematic-cd-label' ); ?>><?php echo esc_attr($settings['tx_cd_hours_label'] ); ?></span>
                            <?php endif; ?>
                        </div><!-- elematic-cd-hours -->
                    </li><!-- elematic-cd-content -->
                <?php endif; ?>
                <?php if ( $settings['tx_cd_mins'] == 'show' ) : ?>
                    <li class="elematic-cd-content">
                        <div class="elematic-cd-minutes">
                            <span data-minutes <?php $this->print_render_attribute_string( 'elematic-cd-digits' ); ?>><?php echo esc_html__( '00', 'elematic-addons-for-elementor' ); ?></span>
                            <?php if ( ! empty( $settings['tx_cd_mins_label'] ) ) : ?>
                                <span <?php $this->print_render_attribute_string( 'elematic-cd-label' ); ?>><?php echo esc_attr($settings['tx_cd_mins_label'] ); ?></span>
                            <?php endif; ?>
                        </div><!-- elematic-cd-minutes -->
                    </li><!-- elematic-cd-content -->
                <?php endif; ?>
                <?php if ( $settings['tx_cd_secs'] == 'show' ) : ?>
                    <li class="elematic-cd-content">
                        <div class="elematic-cd-seconds">
                            <span data-seconds <?php $this->print_render_attribute_string( 'elematic-cd-digits' ); ?>><?php echo esc_html__( '00', 'elematic-addons-for-elementor' ); ?></span>
                            <?php if ( ! empty( $settings['tx_cd_secs_label'] ) ) : ?>
                                <span <?php $this->print_render_attribute_string( 'elematic-cd-label' ); ?>><?php echo esc_attr($settings['tx_cd_secs_label'] ); ?></span>
                            <?php endif; ?>
                        </div><!-- elematic-cd-seconds -->
                    </li><!-- elematic-cd-content -->
                <?php endif; ?>
            </ul><!-- elematic-countdown-content -->
            <div class="clearfix"></div>
        </div><!-- elematic-countdown-container -->
    </div><!-- elematic-countdown-wrapper -->
    
    <?php   
    }
} // class
