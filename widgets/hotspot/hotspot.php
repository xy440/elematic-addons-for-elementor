<?php
namespace Elematic\widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Hotspot extends Widget_Base {

    public function get_name() {
        return 'elematic-hotspot';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Hotspot', 'elematic-addons-for-elementor' );
    }
    public function get_style_depends() {
        return [ 'elematic-hotspot' ];
    }
    public function get_icon() {
        return 'eicon-image-hotspot';
    }
    public function get_keywords() {
        return [ 'hotspot', 'marker', 'pointer', 'map', 'path', 'image' ];
    }
    public function get_script_depends() {
        return [ 'elematic-hotspot' ];
    }
    public function get_categories() {
        return [ 'elematic-elements' ];
    }

	protected function register_controls() {
        $this->start_controls_section(
            'hs_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );

        $this->add_control(
            'image', [
                'label'      => esc_html__( 'Background Image', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::MEDIA,
                'default'    => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'image',
                'label'   => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
                'default' => 'full',
            ]
        );
        $repeater = new Repeater();

        $repeater->start_controls_tabs( 'tabs_markers' );

        $repeater->start_controls_tab(
            'tab_marker',
            [
                'label' => esc_html__( 'Marker', 'elematic-addons-for-elementor' )
            ]
        );
        $repeater->add_control(
            'select_type',
            [
                'label' => esc_html__( 'Select Type', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-star',
                    ],
                    'text' => [
                        'title' => esc_html__( 'Text', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-text-area',
                    ],
                    'image' => [
                        'title' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-image',
                    ],
                ],
                'default' => 'icon',
                'toggle' => false,
            ]
        );

        $repeater->add_control(
            'hs_text',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__( 'Text', 'elematic-addons-for-elementor' ),
                'default' => '9',
                'dynamic' => [
                    'active' => true,
                ],
                'condition' => [
                    'select_type'   => 'text'
                ]
            ]
        );

        $repeater->add_control(
            'hs_select_icon',
            [
                'label'   => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'select_type'   => 'icon'
                ]
            ]
        );
        $repeater->add_control(
            'image',
            [
                'type' => Controls_Manager::MEDIA,
                'show_label' => false,
                'dynamic' => [
                    'active' => true
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'select_type' => 'image'
                ],
            ]
        );
        $repeater->add_control(
            'marker_title', [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Marker' , 'elematic-addons-for-elementor' ),
                'label_block' => true,
            ]
        );
        $repeater->add_responsive_control(
            'hs_x_position',
            [
                'label'   => esc_html__( 'X Postion', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 0.1
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx_hotspot_container {{CURRENT_ITEM}}.elematic-hs-item' => 'left: {{SIZE}}%;',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'hs_y_position',
            [
                'label'   => esc_html__( 'Y Postion', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 0.1
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tx_hotspot_container {{CURRENT_ITEM}}.elematic-hs-item' => 'top: {{SIZE}}%;',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'hs_marker_size',
            [
                'label' => esc_html__( 'Marker Size', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'hs_marker_icon_size',
            [
                'label' => esc_html__( 'Icon / Text / Image Size', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker i, {{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker-text' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'hs_marker_icon_padding',
            [
                'label' => esc_html__( 'Icon / Text / Image Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker i, {{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker img, {{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $repeater->add_control(
            'hs_marker_bg_color',
            [
                'label'     => esc_html__( 'Marker Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'hs_marker_icon_color',
            [
                'label'     => esc_html__( 'Marker Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker i, {{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-marker-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->end_controls_tab();

        $repeater->start_controls_tab(
            'tab_tooltip',
            [
                'label' => esc_html__( 'Tooltip', 'elematic-addons-for-elementor' )
            ]
        );
        $repeater->add_control(
            'hs_tooltip',
            [
                'label' => esc_html__( 'Display Tooltip', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',
            ]
        );
        $repeater->add_control(
            'marker_tt_title',
            [
                'label'       => esc_html__( 'Tooltip Title', 'elematic-addons-for-elementor' ),
                'default'     => esc_html__( 'Tooltip Title' , 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
                'condition'   => [
                    'hs_tooltip' => 'yes',
                ],
            ]
        );
        $repeater->add_control(
            'marker_details',
            [
                'label'       => esc_html__( 'Tooltip Text', 'elematic-addons-for-elementor' ),
                'default'     => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit.' , 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::WYSIWYG,
                'dynamic'     => [ 'active' => true ],
                'label_block' => true,
                'condition'   => [
                    'hs_tooltip' => 'yes',
                ],
            ]
        );
        $repeater->add_responsive_control(
            'hs_tooltip_position',                     
            [
                'label'   => esc_html__( 'Position', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'         => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                    'right'        => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                    'top'          => esc_html__( 'Top', 'elematic-addons-for-elementor' ),
                    'bottom'       => esc_html__( 'Bottom', 'elematic-addons-for-elementor' ),
                ],
                'prefix_class'     => 'elematic-hs-popup',
                'render_type' => 'template',
                'condition'   => [
                    'hs_tooltip' => 'yes',
                ],
            ]
        );
        $repeater->add_control(
            'hs_tooltip_margin',
            [
                'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.elematic-hs-item .elematic-hs-popup' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'   => [
                    'hs_tooltip' => 'yes',
                ],
            ]
        );
        $repeater->end_controls_tab();
        $repeater->end_controls_tabs();

        $this->add_control(
            'markers',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'marker_title'      => esc_html__( 'Marker 1', 'elematic-addons-for-elementor' ),
                        'hs_x_position' => [
                            'size' => 10,
                            'unit' => '%',
                        ],
                        'hs_y_position' => [
                            'size' => 70,
                            'unit' => '%',
                        ]
                    ],
                    [
                        'marker_title'      => esc_html__( 'Marker 2', 'elematic-addons-for-elementor' ),
                        'hs_x_position' => [
                            'size' => 50,
                            'unit' => '%',
                        ],
                        'hs_y_position' => [
                            'size' => 50,
                            'unit' => '%',
                        ],
                    ],
                    [
                        'marker_title'      => esc_html__( 'Marker 3', 'elematic-addons-for-elementor' ),
                        'hs_x_position' => [
                            'size' => 70,
                            'unit' => '%',
                        ],
                        'hs_y_position' => [
                            'size' => 20,
                            'unit' => '%',
                        ],
                    ],
                ],
                'title_field' => '{{{ marker_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'hs_style',
            [
                'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_responsive_control(
            'hs_marker_size_all',
            [
                'label' => esc_html__( 'Marker Size', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'hs_marker_icon_size_all',
            [
                'label' => esc_html__( 'Icon / Text / Image Size', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15
                    ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker i, {{WRAPPER}} .elematic-hs-item .elematic-hs-marker-text' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'hs_marker_bg_color_all',
            [
                'label'     => esc_html__( 'Marker Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hs_marker_icon_color_all',
            [
                'label'     => esc_html__( 'Marker Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker i, {{WRAPPER}} .elematic-hs-item .elematic-hs-marker-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'hs_marker_icon_padding_all',
            [
                'label' => esc_html__( 'Icon / Text / Image Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-item .elematic-hs-marker i, {{WRAPPER}} .elematic-hs-item .elematic-hs-marker img, {{WRAPPER}} .elematic-hs-item .elematic-hs-marker-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'hs_tt_bg_color',
            [
                'label' => esc_html__( 'Tooltip Background Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-popup' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-hs-popup.left:before' => 'border-color: transparent transparent transparent {{VALUE}};',
                    '{{WRAPPER}} .elematic-hs-popup.right:before' => 'border-color: transparent {{VALUE}} transparent transparent;',
                    '{{WRAPPER}} .elematic-hs-popup.top:before' => 'border-color: {{VALUE}} transparent transparent transparent;',
                    '{{WRAPPER}} .elematic-hs-popup.bottom:before' => 'border-color: transparent transparent {{VALUE}} transparent;',
                ],
            ]
        );
        $this->add_control(
            'hs_tt_title_color',
            [
                'label' => esc_html__( 'Tooltip Title Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-tt-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => 'hs_tt_title_typography',
             'label' => esc_html__( 'Tooltip Title Typography', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-hs-tt-title',
            ]
        );
        $this->add_control(
            'hs_tt_desc_color',
            [
                'label' => esc_html__( 'Tooltip Description Color', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-hs-tt-desc, {{WRAPPER}} .elematic-hs-tt-desc div, {{WRAPPER}} .elematic-hs-tt-desc p, {{WRAPPER}} .elematic-hs-tt-desc h1, {{WRAPPER}} .elematic-hs-tt-desc h2, {{WRAPPER}} .elematic-hs-tt-desc h3, {{WRAPPER}} .elematic-hs-tt-desc h4, {{WRAPPER}} .elematic-hs-tt-desc h5, {{WRAPPER}} .elematic-hs-tt-desc h6, {{WRAPPER}} .elematic-hs-tt-desc span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => 'hs_tt_desc_typography',
             'label' => esc_html__( 'Tooltip Description Typography', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-hs-tt-desc, {{WRAPPER}} .elematic-hs-tt-desc div, {{WRAPPER}} .elematic-hs-tt-desc p, {{WRAPPER}} .elematic-hs-tt-desc h1, {{WRAPPER}} .elematic-hs-tt-desc h2, {{WRAPPER}} .elematic-hs-tt-desc h3, {{WRAPPER}} .elematic-hs-tt-desc h4, {{WRAPPER}} .elematic-hs-tt-desc h5, {{WRAPPER}} .elematic-hs-tt-desc h6, {{WRAPPER}} .elematic-hs-tt-desc span',
            ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        
       
    ?>

<div class="tx_hotspot_container">

    <?php Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>

    <?php foreach ($settings['markers'] as $marker) {
            $this->add_render_attribute('elematic-hs-marker', 'class', 'elematic-hs-item elementor-repeater-item-' . esc_attr($marker['_id']), true);
          
    ?>     
        <div <?php $this->print_render_attribute_string('elematic-hs-marker'); ?>>

            <?php if ( 'icon' === $marker['select_type'] ) : ?>
              <span class="elematic-hs-marker">
                 <?php Icons_Manager::render_icon( $marker['hs_select_icon'], [ 'aria-hidden' => 'true' ] ); ?>
              </span>
            <?php endif; ?>
            
            <?php if ( 'text' === $marker['select_type']  ) : ?>
            <span class="elematic-hs-marker">
                <span class="elematic-hs-marker-text"><?php echo esc_html($marker['hs_text']); ?></span>
            </span>
            <?php endif; ?>

            <?php if ( 'image' === $marker['select_type'] ) : ?>
              <span class="elematic-hs-marker">
                <?php echo wp_get_attachment_image( $marker['image']['id'] ); ?>
              </span>
            <?php endif; ?>

            <?php if('yes' === $marker['hs_tooltip']) { ?>
            <aside id="hs-mark" class="elematic-hs-popup <?php echo esc_attr( $marker['hs_tooltip_position'] ); ?>">
             <div class="elematic-hs-tt-title"><?php echo esc_html($marker['marker_tt_title']); ?></div>
             <div class="elematic-hs-tt-desc"><?php echo wp_kses_post($marker['marker_details']); ?></div>
            </aside>
            <?php } ?>

        </div><!-- elematic-hs-marker -->

    <?php } ?>

</div><!-- tx_hotspot_container -->


<?php   } // render()
} // class 
