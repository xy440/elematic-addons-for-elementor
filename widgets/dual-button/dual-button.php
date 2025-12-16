<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class DualButton extends Widget_Base {

	public function get_name() {
		return 'elematic-dual-button';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Dual Button', 'elematic-addons-for-elementor');
	}

	public function get_icon() {
		return 'eicon-dual-button';
	}
    public function get_style_depends() {
        return [ 'elematic-dual-button' ];
    }
	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'button', 'dual', 'multi', 'primary', 'secondary' ];
	}
	
	protected function register_controls() {
        $this->start_controls_section(
            'btn_content',
            [
                'label' => esc_html__( 'Buttons', 'elematic-addons-for-elementor'),
            ]
        );
        $this->start_controls_tabs( 'btn_tabs' );

        $this->start_controls_tab(
            'btn_primary',
            [
                'label' => esc_html__( 'Primary', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
                'btn_primary_text',
                [
                    'label'       => esc_html__( 'Primary Button Text', 'elematic-addons-for-elementor'),
                    'type'        => Controls_Manager::TEXT,
                    'label_block'   => true,
                    'default'     => 'Primary',
                    'placeholder' => esc_html__( 'Enter primary button text', 'elematic-addons-for-elementor'),
                ]
        );
        $this->add_control(
            'btn_primary_link_url',
            [
                'label'       => esc_html__( 'Primary Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'default'     => [
                    'url' => '#',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_primary_width',
            [
                'label' => esc_html__( 'Primary Button Width', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 1200,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_primary_height',
            [
                'label' => esc_html__( 'Primary Button Height', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'btn_primary_icon',
                [
                    'label'            => esc_html__( 'Primary Button Icon', 'elematic-addons-for-elementor'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-angle-right',
                        'library' => 'fa-solid',
                    ],
                ]
        );
        $this->add_responsive_control(
            'btn_primary_icon_size',
            [
                'label' => esc_html__( 'Primary Button Icon Size', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'btn_primary_icon_position',
            [
                'label' => esc_html__( 'Primary Button Icon Position', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => esc_html__( 'Before', 'elematic-addons-for-elementor'),
                    'after' => esc_html__( 'After', 'elematic-addons-for-elementor'),
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'btn_primary_icon[value]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_primary_icon_indent',
            [
                'label' => esc_html__( 'Primary Button Icon Spacing', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-pri-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-dual-btn-pri-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'btn_primary_icon[value]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_primary_icon_top',
            [
                'label' => esc_html__( 'Primary Button Icon Top', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                        'min' => -50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-pri-icon-before' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-dual-btn-pri-icon-after' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'btn_primary_icon[value]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'btn_secondary',
            [
                'label' => esc_html__( 'Secondary', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
                'btn_secondary_text',
                [
                    'label'       => esc_html__( 'Secondary Button Text', 'elematic-addons-for-elementor'),
                    'type'        => Controls_Manager::TEXT,
                    'label_block'   => true,
                    'default'     => 'Secondary',
                    'placeholder' => esc_html__( 'Enter secondary button text', 'elematic-addons-for-elementor'),
                ]
        );
        $this->add_control(
            'btn_secondary_link_url',
            [
                'label'       => esc_html__( 'Secondary Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'default'     => [
                    'url' => '#',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_secondary_width',
            [
                'label' => esc_html__( 'Secondary Button Width', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 1200,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_secondary_height',
            [
                'label' => esc_html__( 'Secondary Button Height', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
                'btn_secondary_icon',
                [
                    'label'            => esc_html__( 'Secondary Button Icon', 'elematic-addons-for-elementor'),
                    'type'             => Controls_Manager::ICONS,
                    'fa4compatibility' => 'icon',
                    'default' => [
                        'value' => 'fas fa-angle-right',
                        'library' => 'fa-solid',
                    ],
                ]
        );
        $this->add_responsive_control(
            'btn_secondary_icon_size',
            [
                'label' => esc_html__( 'Secondary Button Icon Size', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'btn_secondary_icon_position',
            [
                'label' => esc_html__( 'Secondary Button Icon Position', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before' => esc_html__( 'Before', 'elematic-addons-for-elementor'),
                    'after' => esc_html__( 'After', 'elematic-addons-for-elementor'),
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'btn_secondary_icon[value]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_secondary_icon_indent',
            [
                'label' => esc_html__( 'Secondary Button Icon Spacing', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-sec-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-dual-btn-sec-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'btn_secondary_icon[value]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_secondary_icon_top',
            [
                'label' => esc_html__( 'Secondary Button Icon Top', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                        'min' => -50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-sec-icon-before' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-dual-btn-sec-icon-after' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'btn_secondary_icon[value]',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
            ]
        );
        $this->end_controls_tab();   
        $this->end_controls_tabs();
        
        $this->add_responsive_control(
            'btn_alignment',
            [
                'label' => esc_html__( 'Alignment', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elematic-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors'         => [
                    '{{WRAPPER}} .elematic-dual-btn-wrap'   => 'justify-content: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        if(!is_rtl()):
        $this->add_responsive_control(
            'btn_gap',
            [
                'label' => esc_html__( 'Gap', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        endif;
        if(is_rtl()):
            $this->add_responsive_control(
            'btn_gap_rtl',
            [
                'label' => esc_html__( 'Gap', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        endif;
        $this->end_controls_section();

        $this->start_controls_section(
            'btn_styles_primary',
            [
                'label'                 => esc_html__( 'Primary Button Style', 'elematic-addons-for-elementor'),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'btn_primary_tabs_style' );

        $this->start_controls_tab(
            'btn_primary_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'btn_pri_gradient',
            [
                'label' => esc_html__( 'Gradient Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'color-0'  => esc_html__( 'None', 'elematic-addons-for-elementor'),
                    'color-1'  => esc_html__( 'Color 1', 'elematic-addons-for-elementor'),
                    'color-2'  => esc_html__( 'Color 2', 'elematic-addons-for-elementor'),
                    'color-3'  => esc_html__( 'Color 3', 'elematic-addons-for-elementor'),
                    'color-4'  => esc_html__( 'Color 4', 'elematic-addons-for-elementor'),
                    'color-5'  => esc_html__( 'Color 5', 'elematic-addons-for-elementor'),
                    'color-6'  => esc_html__( 'Color 6', 'elematic-addons-for-elementor'),
                    'color-7'  => esc_html__( 'Color 7', 'elematic-addons-for-elementor'),
                    'color-8'  => esc_html__( 'Color 8', 'elematic-addons-for-elementor'),
                    'color-9'  => esc_html__( 'Color 9', 'elematic-addons-for-elementor'),
                    'color-10'  => esc_html__( 'Color 10', 'elematic-addons-for-elementor'),
                    'color-11'  => esc_html__( 'Color 11', 'elematic-addons-for-elementor'),
                    'color-12'  => esc_html__( 'Color 12', 'elematic-addons-for-elementor'),
                    'color-13'  => esc_html__( 'Color 13', 'elematic-addons-for-elementor'),
                    'color-14'  => esc_html__( 'Color 14', 'elematic-addons-for-elementor'),
                    'color-15'  => esc_html__( 'Color 15', 'elematic-addons-for-elementor'),
                    'color-16'  => esc_html__( 'Color 16', 'elematic-addons-for-elementor'),
                    'color-17'  => esc_html__( 'Color 17', 'elematic-addons-for-elementor'),
                    'color-18'  => esc_html__( 'Color 18', 'elematic-addons-for-elementor'),
                    'color-19'  => esc_html__( 'Color 19', 'elematic-addons-for-elementor'),
                    'color-20'  => esc_html__( 'Color 20', 'elematic-addons-for-elementor'),
                    'color-21'  => esc_html__( 'Color 21', 'elematic-addons-for-elementor'),
                    'color-22'  => esc_html__( 'Color 22', 'elematic-addons-for-elementor'),
                    'color-23'  => esc_html__( 'Color 23', 'elematic-addons-for-elementor'),
                    'color-24'  => esc_html__( 'Color 24', 'elematic-addons-for-elementor'),
                    'color-25'  => esc_html__( 'Color 25', 'elematic-addons-for-elementor'),
                    'color-26'  => esc_html__( 'Color 26', 'elematic-addons-for-elementor'),
                    'color-27'  => esc_html__( 'Color 27', 'elematic-addons-for-elementor'),
                    'color-28'  => esc_html__( 'Color 28', 'elematic-addons-for-elementor'),
                    'color-29'  => esc_html__( 'Color 29', 'elematic-addons-for-elementor'),
                    'color-30'  => esc_html__( 'Color 30', 'elematic-addons-for-elementor'),
                    'color-31'  => esc_html__( 'Color 31', 'elematic-addons-for-elementor'),
                    'color-32'  => esc_html__( 'Color 32', 'elematic-addons-for-elementor'),
                    'color-33'  => esc_html__( 'Color 33', 'elematic-addons-for-elementor'),
                    'color-34'  => esc_html__( 'Color 34', 'elematic-addons-for-elementor'),
                    'color-35'  => esc_html__( 'Color 35', 'elematic-addons-for-elementor'),
                    'color-36'  => esc_html__( 'Color 36', 'elematic-addons-for-elementor'),
                    'color-37'  => esc_html__( 'Color 37', 'elematic-addons-for-elementor'),
                    'color-38'  => esc_html__( 'Color 38', 'elematic-addons-for-elementor'),
                    'color-39'  => esc_html__( 'Color 39', 'elematic-addons-for-elementor'),
                    'color-40'  => esc_html__( 'Color 40', 'elematic-addons-for-elementor'),
                    'color-41'  => esc_html__( 'Color 41', 'elematic-addons-for-elementor'),
                    'color-42'  => esc_html__( 'Color 42', 'elematic-addons-for-elementor'),
                    'color-43'  => esc_html__( 'Color 43', 'elematic-addons-for-elementor'),
                    'color-44'  => esc_html__( 'Color 44', 'elematic-addons-for-elementor'),
                    'color-45'  => esc_html__( 'Color 45', 'elematic-addons-for-elementor'),
                    'color-46'  => esc_html__( 'Color 46', 'elematic-addons-for-elementor'),
                    'color-47'  => esc_html__( 'Color 47', 'elematic-addons-for-elementor'),
                    'color-48'  => esc_html__( 'Color 48', 'elematic-addons-for-elementor'),
                    'color-49'  => esc_html__( 'Color 49', 'elematic-addons-for-elementor'),
                    'color-50'  => esc_html__( 'Color 50', 'elematic-addons-for-elementor'),
                ],
                'default' => 'color-0',
            ]
        );
        $this->add_control(
            'btn_primary_bg_color',
            [
                'label' => esc_html__('Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_pri_gradient' => 'none'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_pri_custom_bg',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor'),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-dual-btn-primary',
            ]
        );
        $this->add_control(
            'btn_primary_color',
            [
                'label' => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-dual-btn-primary svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_primary_typo',
                'selector'  => '{{WRAPPER}} .elematic-dual-btn-primary',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_primary_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-dual-btn-primary',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'btn_primary_border',
                'selector'    =>    '{{WRAPPER}} .elematic-dual-btn-primary'
            ]
        );
        $this->add_responsive_control(
            'btn_primary_border_radius',
            [
                'label'   => esc_html__( 'Border Radius', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary'   => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_primary_padding',
            [
                'label'         => esc_html__( 'Padding', 'elematic-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-dual-btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'btn_primary_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'btn_primary_hov_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );
        $this->add_control(
            'btn_pri_bg_hov_color',
            [
                'label' => esc_html__('Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_pri_gradient' => 'none'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_pri_custom_bg_hov',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor'),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-dual-btn-primary:hover',
            ]
        );
        $this->add_control(
            'btn_pri_hov_color',
            [
                'label' => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-primary:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-dual-btn-primary:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'btn_pri_hov_border',
                'selector'    =>    '{{WRAPPER}} .elematic-dual-btn-primary:hover'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_primary_hov_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-dual-btn-primary:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'btn_styles_secondary',
            [
                'label'                 => esc_html__( 'Secondary Button Style', 'elematic-addons-for-elementor'),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'btn_secondary_tabs_style' );
        $this->start_controls_tab(
            'btn_secondary_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'btn_sec_gradient',
            [
                'label' => esc_html__( 'Gradient Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none'  => esc_html__( 'None', 'elematic-addons-for-elementor'),
                    'color-1'  => esc_html__( 'Color 1', 'elematic-addons-for-elementor'),
                    'color-2'  => esc_html__( 'Color 2', 'elematic-addons-for-elementor'),
                    'color-3'  => esc_html__( 'Color 3', 'elematic-addons-for-elementor'),
                    'color-4'  => esc_html__( 'Color 4', 'elematic-addons-for-elementor'),
                    'color-5'  => esc_html__( 'Color 5', 'elematic-addons-for-elementor'),
                    'color-6'  => esc_html__( 'Color 6', 'elematic-addons-for-elementor'),
                    'color-7'  => esc_html__( 'Color 7', 'elematic-addons-for-elementor'),
                    'color-8'  => esc_html__( 'Color 8', 'elematic-addons-for-elementor'),
                    'color-9'  => esc_html__( 'Color 9', 'elematic-addons-for-elementor'),
                    'color-10'  => esc_html__( 'Color 10', 'elematic-addons-for-elementor'),
                    'color-11'  => esc_html__( 'Color 11', 'elematic-addons-for-elementor'),
                    'color-12'  => esc_html__( 'Color 12', 'elematic-addons-for-elementor'),
                    'color-13'  => esc_html__( 'Color 13', 'elematic-addons-for-elementor'),
                    'color-14'  => esc_html__( 'Color 14', 'elematic-addons-for-elementor'),
                    'color-15'  => esc_html__( 'Color 15', 'elematic-addons-for-elementor'),
                    'color-16'  => esc_html__( 'Color 16', 'elematic-addons-for-elementor'),
                    'color-17'  => esc_html__( 'Color 17', 'elematic-addons-for-elementor'),
                    'color-18'  => esc_html__( 'Color 18', 'elematic-addons-for-elementor'),
                    'color-19'  => esc_html__( 'Color 19', 'elematic-addons-for-elementor'),
                    'color-20'  => esc_html__( 'Color 20', 'elematic-addons-for-elementor'),
                    'color-21'  => esc_html__( 'Color 21', 'elematic-addons-for-elementor'),
                    'color-22'  => esc_html__( 'Color 22', 'elematic-addons-for-elementor'),
                    'color-23'  => esc_html__( 'Color 23', 'elematic-addons-for-elementor'),
                    'color-24'  => esc_html__( 'Color 24', 'elematic-addons-for-elementor'),
                    'color-25'  => esc_html__( 'Color 25', 'elematic-addons-for-elementor'),
                    'color-26'  => esc_html__( 'Color 26', 'elematic-addons-for-elementor'),
                    'color-27'  => esc_html__( 'Color 27', 'elematic-addons-for-elementor'),
                    'color-28'  => esc_html__( 'Color 28', 'elematic-addons-for-elementor'),
                    'color-29'  => esc_html__( 'Color 29', 'elematic-addons-for-elementor'),
                    'color-30'  => esc_html__( 'Color 30', 'elematic-addons-for-elementor'),
                    'color-31'  => esc_html__( 'Color 31', 'elematic-addons-for-elementor'),
                    'color-32'  => esc_html__( 'Color 32', 'elematic-addons-for-elementor'),
                    'color-33'  => esc_html__( 'Color 33', 'elematic-addons-for-elementor'),
                    'color-34'  => esc_html__( 'Color 34', 'elematic-addons-for-elementor'),
                    'color-35'  => esc_html__( 'Color 35', 'elematic-addons-for-elementor'),
                    'color-36'  => esc_html__( 'Color 36', 'elematic-addons-for-elementor'),
                    'color-37'  => esc_html__( 'Color 37', 'elematic-addons-for-elementor'),
                    'color-38'  => esc_html__( 'Color 38', 'elematic-addons-for-elementor'),
                    'color-39'  => esc_html__( 'Color 39', 'elematic-addons-for-elementor'),
                    'color-40'  => esc_html__( 'Color 40', 'elematic-addons-for-elementor'),
                    'color-41'  => esc_html__( 'Color 41', 'elematic-addons-for-elementor'),
                    'color-42'  => esc_html__( 'Color 42', 'elematic-addons-for-elementor'),
                    'color-43'  => esc_html__( 'Color 43', 'elematic-addons-for-elementor'),
                    'color-44'  => esc_html__( 'Color 44', 'elematic-addons-for-elementor'),
                    'color-45'  => esc_html__( 'Color 45', 'elematic-addons-for-elementor'),
                    'color-46'  => esc_html__( 'Color 46', 'elematic-addons-for-elementor'),
                    'color-47'  => esc_html__( 'Color 47', 'elematic-addons-for-elementor'),
                    'color-48'  => esc_html__( 'Color 48', 'elematic-addons-for-elementor'),
                    'color-49'  => esc_html__( 'Color 49', 'elematic-addons-for-elementor'),
                    'color-50'  => esc_html__( 'Color 50', 'elematic-addons-for-elementor'),
                ],
                'default' => 'none',
            ]
        );
        $this->add_control(
            'btn_secondary_bg_color',
            [
                'label' => esc_html__('Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_sec_gradient' => 'none'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_secondary_custom_bg',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor'),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-dual-btn-secondary',
            ]
        );
        $this->add_control(
            'btn_secondary_color',
            [
                'label' => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-dual-btn-secondary svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_secondary_typo',
                'selector'  => '{{WRAPPER}} .elematic-dual-btn-secondary',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_secondary_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-dual-btn-secondary',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'btn_secondary_border',
                'selector'    =>    '{{WRAPPER}} .elematic-dual-btn-secondary'
            ]
        );
        $this->add_responsive_control(
            'btn_secondary_border_radius',
            [
                'label'   => esc_html__( 'Border Radius', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => '',
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary'   => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_secondary_padding',
            [
                'label'         => esc_html__( 'Padding', 'elematic-addons-for-elementor'),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'btn_secondary_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'btn_secondary_hov_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );
        $this->add_control(
            'btn_secondary_bg_hov_color',
            [
                'label' => esc_html__('Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_sec_gradient' => 'none'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_secondary_custom_bg_hov',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor'),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-dual-btn-secondary:hover',
            ]
        );
        $this->add_control(
            'btn_secondary_hov_color',
            [
                'label' => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-dual-btn-secondary:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-dual-btn-secondary:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'btn_secondary_hov_border',
                'selector'    =>    '{{WRAPPER}} .elematic-dual-btn-secondary:hover'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_secondary_hov_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-dual-btn-secondary:hover',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $target_primary = $settings['btn_primary_link_url']['is_external'] ? '_blank' : '_self';
        $target_secondary = $settings['btn_secondary_link_url']['is_external'] ? '_blank' : '_self';

            $this->add_render_attribute( 'btn-primary-link', 'href', $settings['btn_primary_link_url']['url'] );
            $this->add_render_attribute( 'btn-primary-link', 'class', 'elematic-dual-btn-primary ' . $settings['btn_pri_gradient'] . ' elementor-animation-' . $settings['btn_primary_hov_animation'] );
            $this->add_render_attribute( 'btn-secondary-link', 'href', $settings['btn_secondary_link_url']['url'] );
            $this->add_render_attribute( 'btn-secondary-link', 'class', 'elematic-dual-btn-secondary ' . $settings['btn_sec_gradient'] . ' elementor-animation-' . $settings['btn_secondary_hov_animation'] );
        ?>

        <div class="elematic-dual-btn-wrap">

            <?php if ($settings['btn_primary_text'] !='') : ?>
                <a <?php $this->print_render_attribute_string( 'btn-primary-link' ); ?> target="<?php echo esc_attr($target_primary); ?>" >
                    <?php if( $settings['btn_primary_icon'] !='' && $settings['btn_primary_icon_position'] =='before'  ) : ?>
                        <span class="elematic-dual-btn-pri-icon-before"><?php Icons_Manager::render_icon( $settings['btn_primary_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                    <?php endif; ?>
                    <?php echo esc_attr( $settings['btn_primary_text'] ); ?>
                    <?php if( $settings['btn_primary_icon'] !='' && $settings['btn_primary_icon_position'] =='after'  ) : ?>
                        <span class="elematic-dual-btn-pri-icon-after"><?php Icons_Manager::render_icon( $settings['btn_primary_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?><!-- primary button end -->

            <?php if ($settings['btn_secondary_text'] !='') : ?>
                <a <?php $this->print_render_attribute_string( 'btn-secondary-link' ); ?> target="<?php echo esc_attr($target_secondary); ?>" >
                    <?php if( $settings['btn_secondary_icon'] !='' && $settings['btn_secondary_icon_position'] =='before'  ) : ?>
                        <span class="elematic-dual-btn-sec-icon-before"><?php Icons_Manager::render_icon( $settings['btn_secondary_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                    <?php endif; ?>
                    <?php echo esc_attr( $settings['btn_secondary_text'] ); ?>
                    <?php if( $settings['btn_secondary_icon'] !='' && $settings['btn_secondary_icon_position'] =='after'  ) : ?>
                        <span class="elematic-dual-btn-sec-icon-after"><?php Icons_Manager::render_icon( $settings['btn_secondary_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?><!-- secondary button end -->
            
        </div><!-- elematic-dual-btn-wrap -->
        
        
<?php } // render()

} // class
