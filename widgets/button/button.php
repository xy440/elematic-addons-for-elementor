<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Button extends Widget_Base {

	public function get_name() {
		return 'elematic-button';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Button', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'button', 'link' ];
	}

    public function get_style_depends() {
        return [ 'elematic-button' ];
    }
	
	protected function register_controls() {
        $this->start_controls_section(
            'btn_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'btn_style',
            [
                'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style-0'  => esc_html__( 'Style 0', 'elematic-addons-for-elementor' ),
                    'style-1'  => esc_html__( 'Style 1', 'elematic-addons-for-elementor' ),
                    'style-2'  => esc_html__( 'Style 2', 'elematic-addons-for-elementor' ),
                    'style-3'  => esc_html__( 'Style 3', 'elematic-addons-for-elementor' ),
                    'style-4'  => esc_html__( 'Style 4', 'elematic-addons-for-elementor' ),
                    'style-5'  => esc_html__( 'Style 5', 'elematic-addons-for-elementor' ),
                    'style-6'  => esc_html__( 'Style 6', 'elematic-addons-for-elementor' ),
                    'style-7'  => esc_html__( 'Style 7', 'elematic-addons-for-elementor' ),
                    'style-8'  => esc_html__( 'Style 8', 'elematic-addons-for-elementor' ),
                    'style-9'  => esc_html__( 'Style 9', 'elematic-addons-for-elementor' ),
                    'style-10'  => esc_html__( 'Style 10', 'elematic-addons-for-elementor' ),
                ],
                'default' => 'style-1',

            ]
        );
        $this->add_control(
            'btn_txt',
            [
                'label'             => esc_html__( 'Button Text', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__( 'HOVER ME', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'btn_txt_2',
            [
                'label'             => esc_html__( 'Hover Text', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::TEXT,
                'default'           => esc_html__( 'CLICK ME', 'elematic-addons-for-elementor' ),
                'condition'         => [            
                    'btn_style' => [
                        'style-3',
                        'style-5',
                        'style-6',
                        'style-7',
                        'style-8',
                        'style-9',
                        'style-10',
                    ]

                ]
            ]
        );
        $this->add_control(
            'btn_link_url',
            [
                'label'       => esc_html__( 'Link URL', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
                'default'     => [
                    'url' => '#',
                ],
            ]
        );
        $this->add_control(
            'selected_icon',
            [
                'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label' => esc_html__( 'Icon Position', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                    'em' => [
                        'max' => 25,
                    ],
                    'rem' => [
                        'max' => 25,
                    ],
                ],
                'default' => [
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-btn-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_indent',
            [
                'label' => esc_html__( 'Icon Spacing', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                    'em' => [
                        'max' => 25,
                    ],
                    'rem' => [
                        'max' => 25,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-align-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-btn-align-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'icon_vertical_alignment',
            [
                'label' => esc_html__( 'Icon Vertical Alignment', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-icon i' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-btn-icon svg' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [ 
                    'selected_icon[value]!' => '' 
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_width',
            [
                'label'                 => esc_html__( 'Width', 'elematic-addons-for-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'max'   => 500,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .elematic-btn-link' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before'

            ]
        );
        $this->add_responsive_control(
            'btn_height',
            [
                'label'                 => esc_html__( 'Height', 'elematic-addons-for-elementor' ),
                'description'                 => esc_html__( 'Adjust the Line Height from Typography to set the text middle', 'elematic-addons-for-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'range'                 => [
                    'px' => [
                        'max'   => 300,
                    ],
                ],
                'size_units'            => [ 'px', '%' ],
                'selectors'             => [
                    '{{WRAPPER}} .elematic-btn-link' => 'height: {{SIZE}}{{UNIT}}',
                ],

            ]
        );
        $this->add_responsive_control(
            'btn_alignment',
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
                    '{{WRAPPER}} .elematic-btn-wrap'   => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .elematic-btn-wrap'   => 'justify-content: {{VALUE}};',
                ],
                'separator' => 'before'

            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'btn_styles',
            [
                'label'                 => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'btn_tabs' );

        $this->start_controls_tab(
            'btn_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'btn_color',
            [
                'label' => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-wrap .elematic-btn-link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-btn-wrap .elematic-btn-link svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'btn_bg_color',
            [
                'label' => esc_html__('Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-link' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_style!' => ['style-2']
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ], // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                'selector' => '{{WRAPPER}} .elematic-btn-link',
                'condition' => [
                    'btn_style!' => ['style-2']
                ],
            ]
        );
        $this->add_control(
            'btn_broder_color',
            [
                'label' => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-wrap.style-1 .elematic-btn-link' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_style' => 'style-1'
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_broder_size',
            [
                'label' => esc_html__( 'Border Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 20,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-wrap.style-1 .elematic-btn-link' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style' => 'style-1'
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'btn_typo',
                'selector'  => '{{WRAPPER}} .elematic-btn-link',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'      => 'btn_text_shadow',
                'label'     => esc_html__( 'Text Shadow', 'elematic-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .elematic-btn-link, {{WRAPPER}} .elematic-btn-icon i',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'btn_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-btn-link'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'btn_border',
                'selector'    =>    '{{WRAPPER}} .elematic-btn-link',
                'condition' => [
                    'btn_style!' => ['style-1','style-3','style-5']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-btn-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style!' => ['style-1','style-2','style-3','style-5']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_padding',
            [
                'label'         => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-btn-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style!' => ['style-3','style-5']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_margin',
            [
                'label'         => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-btn-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'btn_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'btn_hov_color',
            [
                'label' => esc_html__('Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-wrap .elematic-btn-link:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-btn-wrap .elematic-btn-link:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'btn_bg_hov_color',
            [
                'label' => esc_html__('Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-wrap.style-0 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-1 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-2 .elematic-btn-link:after, {{WRAPPER}} .elematic-btn-wrap.style-3:hover .elematic-btn-link, {{WRAPPER}} .elematic-btn-wrap.style-3 .elematic-btn-link:before, {{WRAPPER}} .elematic-btn-wrap.style-4 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-5 .elematic-btn-link:before, {{WRAPPER}} .elematic-btn-wrap.style-6 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-7 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-8 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-9 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-10 a:hover' => 'background-color: {{VALUE}};',
                ],
                
            ]
        );
         $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'btn_hov_background',
                'types' => [ 'classic', 'gradient' ],
                'exclude' => [ 'image' ], // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                ],
                'selector' => '{{WRAPPER}} .elematic-btn-wrap.style-0 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-1 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-2 .elematic-btn-link:after, {{WRAPPER}} .elematic-btn-wrap.style-3:hover .elematic-btn-link, {{WRAPPER}} .elematic-btn-wrap.style-3 .elematic-btn-link:before, {{WRAPPER}} .elematic-btn-wrap.style-4 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-5 .elematic-btn-link:before, {{WRAPPER}} .elematic-btn-wrap.style-6 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-7 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-8 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-9 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-10 a:hover',
            ]
        );
        $this->add_control(
            'btn_broder_hover_color',
            [
                'label' => esc_html__('Border Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-wrap.style-1 .line-1, {{WRAPPER}} .elematic-btn-wrap.style-1 .line-2, {{WRAPPER}} .elematic-btn-wrap.style-1 .line-3, {{WRAPPER}} .elematic-btn-wrap.style-1 .line-4' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-btn-wrap.style-0 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-4 .elematic-btn-link:hover, {{WRAPPER}} .elematic-btn-wrap.style-6 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-7 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-8 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-9 a:hover, {{WRAPPER}} .elematic-btn-wrap.style-10 a:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'btn_style' => ['style-0', 'style-1', 'style-4', 'style-6', 'style-7', 'style-8', 'style-9', 'style-10']
                ],
            ]
        );
        $this->add_responsive_control(
            'btn_broder_hover_size',
            [
                'label' => esc_html__( 'Border Hover Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 20,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-btn-wrap.style-1 .line-1, {{WRAPPER}} .elematic-btn-wrap.style-1 .line-3' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-btn-wrap.style-1 .line-2, {{WRAPPER}} .elematic-btn-wrap.style-1 .line-4' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'btn_style' => 'style-1'
                ],
            ]
        );
        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'condition' => [
                    'btn_style' => ['style-0']
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
        $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
        $target = $settings['btn_link_url']['is_external'] ? '_blank' : '_self';

        if ( ! empty( $settings['btn_link_url']['url'] ) ) :
            $this->add_render_attribute( 'btn-link', 'href', $settings['btn_link_url']['url'] );
        endif;

        if ( ! empty( $settings['hover_animation'] ) ) {
            $this->add_render_attribute( 'btn-link', 'class', 'elementor-animation-' . $settings['hover_animation'] );
        }

        $this->add_render_attribute( [
            'button-wrapper' => [
                'class' => [
                    'elematic-btn-wrap',
                    $settings['btn_style'],
                ]
            ],
            'icon-align' => [
                'class' => [
                    'elematic-btn-icon',
                    'elematic-btn-align-' . $settings['icon_align'],
                ],
            ],
            'btn-link' => [
                'class' => [
                    'elematic-btn-link',
                ],
            ]

        ] );


        ?>

        <div <?php $this->print_render_attribute_string( 'button-wrapper' ); ?>>
            
           <a data-hover="<?php echo esc_attr($settings['btn_txt_2']); ?>" <?php $this->print_render_attribute_string( 'btn-link' ); ?> target="<?php echo esc_attr($target); ?>" >

            <?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) && ('left' === $settings['icon_align']) ) : ?>
            <span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                <?php endif; ?>
            </span>
            <?php endif; ?>

            <?php
                if( 'style-6' === $settings['btn_style'] || 'style-7' === $settings['btn_style'] || 'style-8' === $settings['btn_style'] || 'style-9' === $settings['btn_style'] || 'style-10' === $settings['btn_style'] ): echo '<span class="elematic-btn-anim">'; endif;
                echo esc_attr( $settings['btn_txt'] );
                if( 'style-6' === $settings['btn_style'] || 'style-7' === $settings['btn_style'] || 'style-8' === $settings['btn_style'] || 'style-9' === $settings['btn_style'] || 'style-10' === $settings['btn_style']): echo '</span>'; endif;
            ?>

            <?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) && ('right' === $settings['icon_align']) ) : ?>
            <span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
                <?php if ( $is_new || $migrated ) :
                    Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
                else : ?>
                    <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                <?php endif; ?>
            </span>
            <?php endif; ?>

            <?php if( 'style-1' === $settings['btn_style'] ): ?>
                <span class="line-1"></span>
                <span class="line-2"></span>
                <span class="line-3"></span>
                <span class="line-4"></span>
            <?php endif; ?>

           </a>
          
        </div><!-- elematic-btn-wrap -->
        
        
<?php } // render()

} // class
