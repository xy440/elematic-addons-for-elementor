<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Lottie extends Widget_Base {

    public function get_name() {
        return 'elematic-lottie';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Lottie', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-lottie';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_script_depends() {
        return [ 'elematic-lottie','lottie' ];
    }

    public function get_style_depends() {
        return [ 'elematic-lottie' ];
    }

	protected function register_controls() {


		$this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'source',
            [
                'label'   => esc_html__( 'Source', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'json_file' => [
                        'title' => esc_html__( 'JSON file', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-document-file',
                    ],
                    'external_url' => [
                        'title' => esc_html__( 'External URL', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-link',
                    ],
                ],
                'default' => 'json_file',
                'toggle'  => false,
            ]
        );
		
		
		$desc = sprintf(
			/* translators: 1: opening <a> link tag to LottieFiles, 2: closing </a> tag. */
			esc_html__( 'Get %1$sLottie animations%2$s', 'elematic-addons-for-elementor' ),
			'<a href="https://lottiefiles.com/featured" target="_blank" rel="noopener noreferrer">',
			'</a>'
		);

        $this->add_control(
            'json_file',
            [
                'show_label'    => false,
                'description'   => $desc,
                'type'       => Controls_Manager::MEDIA,
                'media_type' => 'application/json',
                'condition'  => [
                    'source' => 'json_file',
                ],
            ]
        );
		
		$desc = sprintf(
			/* translators: 1: opening <a> link tag to LottieFiles, 2: closing </a> tag. */
			esc_html__( 'Get %1$sLottie animations%2$s', 'elematic-addons-for-elementor' ),
			'<a href="https://lottiefiles.com/featured" target="_blank" rel="noopener noreferrer">',
			'</a>'
		);

        $this->add_control(
            'external_url',
            [
                'show_label'    => false,
                'description'   => $desc,
                'label_block' => true,
                'placeholder' => esc_html__( 'Enter your URL', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active'     => true,
                ],
                'condition'   => [
                    'source' => 'external_url',
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'     => esc_html__( 'Link', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [ 'active' => true ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'ltt_alignment',
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
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .elematic-lottie-wrap' => 'text-align: {{value}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'renderer',
            [
                'label'   => esc_html__( 'Renderer', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'svg',
                'options' => [
                    'svg'    => 'SVG',
                    'canvas' => 'Canvas',
                ],
            ]
        );

        $this->add_control(
            'action_start',
            [
                'label'   => esc_html__( 'Play Action', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'autoplay',
                'options' => [
                    'autoplay'    => esc_html__( 'Autoplay', 'elematic-addons-for-elementor' ),
                    'on_hover'    => esc_html__( 'On Hover', 'elematic-addons-for-elementor' ),
                    'on_click'    => esc_html__( 'On Click', 'elematic-addons-for-elementor' ),
                    'on_scroll'   => esc_html__( 'Scroll', 'elematic-addons-for-elementor' ),
                    'on_viewport' => esc_html__( 'Viewport', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'delay',
            [
                'label'     => esc_html__( 'Autoplay Delay (ms)', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'step'      => 1,
                'condition' => [
                    'action_start' => 'autoplay',
                ],
            ]
        );

        $this->add_control(
            'on_hover_out',
            [
                'label'   => esc_html__( 'On Hover Out', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'No Action', 'elematic-addons-for-elementor' ),
                    'pause'   => esc_html__( 'Pause', 'elematic-addons-for-elementor' ),
                    'stop'    => esc_html__( 'Stop', 'elematic-addons-for-elementor' ),
                    'reverse' => esc_html__( 'Reverse', 'elematic-addons-for-elementor' ),
                ],
                'condition' => [
                    'action_start' => 'on_hover',
                ],
            ]
        );

        $this->add_control(
            'redirect_timeout',
            [
                'label'     => esc_html__( 'Redirect Timeout (ms)', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'step'      => 1,
                'condition' => [
                    'action_start' => 'on_click',
                    'link[url]!'   => '',
                ],
            ]
        );

        $this->add_control(
            'viewport',
            array(
                'label'   => esc_html__( 'Viewport', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'scales'  => 1,
                'handles' => 'range',
                'default' => [
                    'sizes' => [
                        'start' => 0,
                        'end'   => 100,
                    ],
                    'unit'  => '%',
                ],
                'labels'  => [
                    esc_html__( 'Bottom', 'elematic-addons-for-elementor' ),
                    esc_html__( 'Top', 'elematic-addons-for-elementor' ),
                ],
                'condition' => [
                    'action_start' => [ 'on_viewport', 'on_scroll' ],
                ],
            )
        );

        $this->add_control(
            'loop',
            [
                'label'     => esc_html__( 'Loop', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'condition' => [
                    'action_start!' => 'on_scroll',
                ],
            ]
        );

        $this->add_control(
            'reversed',
            [
                'label'     => esc_html__( 'Reversed', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
                'condition' => [
                    'action_start!' => 'on_scroll',
                ],
            ]
        );

        $this->add_control(
            'play_speed',
            [
                'label'       => esc_html__( 'Play Speed', 'elematic-addons-for-elementor' ),
                'description' => esc_html__( '1 is normal speed', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 0,
                'step'        => 0.1,
                'default'     => 1,
                'condition'   => [
                    'action_start!' => 'on_scroll',
                ],
            ]
        );

        
        $this->add_responsive_control(
            'lottie_width',
            [
                'label'      => esc_html__( 'Width', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-lottie-elem' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'lottie_max_width',
            [
                'label'      => esc_html__( 'Max Width', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-lottie-elem' => 'max-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_lottie_style',
            [
                'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'tabs_lottie' );

        $this->start_controls_tab(
            'tab_lottie_normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => esc_html__( 'Opacity', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-lottie-elem' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters',
                'selector' => '{{WRAPPER}} .elematic-lottie-elem',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_lottie_hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'opacity_hover',
            [
                'label' => esc_html__( 'Opacity', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-lottie-elem:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elematic-lottie-elem:hover',
            ]
        );

        $this->add_control(
            'hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-lottie-elem' => 'transition-duration: {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'lottie_border',
                'selector'  => '{{WRAPPER}} .elematic-lottie-elem',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'lottie_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-lottie-elem' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'    => 'lottie_box_shadow',
                // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_exclude
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elematic-lottie-elem',
            )
        );

        $this->end_controls_section();

	}

	protected function render() {

        $settings = $this->get_settings_for_display();
        $source   = ! empty( $settings['source'] ) ? $settings['source'] : 'json_file';

        switch ( $source ) {
            case 'json_file';
                $path = esc_url( $settings['json_file']['url'] );
                break;

            case 'external_url';
                $path = esc_url( $settings['external_url'] );
                break;

            default:
                $path = '';
        };

        if ( empty( $path ) ) {
            $path = ELEMATIC_URL . '/assets/animation/lottie.json';
        }

        $viewport = !empty($settings['viewport']['sizes']) ? $settings['viewport']['sizes'] : null;

        $this->add_render_attribute( 'elematic-lottie', 'class', 'elematic-lottie-wrap' );
        $this->add_render_attribute(
            [
                'elematic-lottie' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'path'             => $path,
                            'renderer'         => $settings['renderer'],
                            'action_start'     => $settings['action_start'],
                            'delay'            => $settings['delay'],
                            'on_hover_out'     => $settings['on_hover_out'],
                            'redirect_timeout' => $settings['redirect_timeout'],
                            'viewport'         => $viewport,
                            'loop'             => filter_var( $settings['loop'], FILTER_VALIDATE_BOOLEAN ),
                            'reversed'         => filter_var( $settings['reversed'], FILTER_VALIDATE_BOOLEAN ),
                            'play_speed'       => $settings['play_speed'],
                        ]))
                    ]
                ]
            ]
        );

        if ( ! empty( $settings['link']['url'] ) ) : 
            $this->add_link_attributes( 'link', $settings['link'] );
        ?>

        <a class="elematic-lottie-link" <?php $this->print_render_attribute_string( 'link' ); ?>>
            <div <?php $this->print_render_attribute_string( 'elematic-lottie' ); ?> >
                <div class="elematic-lottie-elem"></div>
            </div>
        </a>

        <?php endif; ?>

        <div <?php $this->print_render_attribute_string( 'elematic-lottie' ); ?> >
            <div class="elematic-lottie-elem"></div>
        </div>


<?php        

    } // render()
} // class 
