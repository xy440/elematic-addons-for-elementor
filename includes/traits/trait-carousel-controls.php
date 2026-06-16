<?php
namespace Elematic\Traits;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Trait Carousel_Controls
 *
 * Provides shared carousel behaviour controls reusable across
 * any Elematic carousel/slider widget.
 *
 * Usage inside a widget:
 *   use \Elematic\Traits\Carousel_Controls;
 *
 * Then inside register_controls():
 *   $this->register_carousel_controls();
 *
 * Optionally pass a config array to enable/disable specific groups:
 *   $this->register_carousel_controls([
 *       'dimensions' => false,   // skip width/height/gap controls
 *       'easing'     => false,   // skip transition easing
 *   ]);
 */
trait Carousel_Controls {

    /**
     * Register shared carousel controls into the current widget.
     *
     * @param array $config Flags to enable/disable control groups.
     */
    protected function register_carousel_controls( $config = [] ) {

        $defaults = [
            'autoplay'   => true,  // autoplay on/off, speed, direction
            'loop'       => true,  // infinite loop toggle
            'drag'       => true,  // drag / swipe toggle
            'hover'      => true,  // pause on hover
            'dimensions' => true,  // slide width, height, gap
            'transition'  => true, // duration + easing
        ];

        $config = array_merge( $defaults, $config );

        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label' => esc_html__( 'Carousel Settings', 'elematic-addons-for-elementor' ),
            ]
        );

        // ── Autoplay ────────────────────────────────────────────────────────
        if ( $config['autoplay'] ) {

            $this->add_control(
                'autoplay',
                [
                    'label'        => esc_html__( 'Autoplay', 'elematic-addons-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'default'      => 'yes',
                    'return_value' => 'yes',
                ]
            );

            $this->add_control(
                'autoplay_speed',
                [
                    'label'     => esc_html__( 'Autoplay Speed (ms)', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 3000,
                    'min'       => 500,
                    'step'      => 100,
                    'condition' => [ 'autoplay' => 'yes' ],
                ]
            );

            $this->add_control(
                'autoplay_direction',
                [
                    'label'   => esc_html__( 'Direction', 'elematic-addons-for-elementor' ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'left'  => [
                            'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                            'icon'  => 'eicon-arrow-left',
                        ],
                        'right' => [
                            'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                            'icon'  => 'eicon-arrow-right',
                        ],
                    ],
                    'default'   => 'left',
                    'condition' => [ 'autoplay' => 'yes' ],
                ]
            );

        }

        // ── Loop ────────────────────────────────────────────────────────────
        if ( $config['loop'] ) {

            $this->add_control(
                'loop',
                [
                    'label'        => esc_html__( 'Infinite Loop', 'elematic-addons-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'default'      => 'yes',
                    'return_value' => 'yes',
                    'separator'    => 'before',
                ]
            );

        }

        // ── Drag ────────────────────────────────────────────────────────────
        if ( $config['drag'] ) {

            $this->add_control(
                'draggable',
                [
                    'label'        => esc_html__( 'Drag / Swipe', 'elematic-addons-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'default'      => 'yes',
                    'return_value' => 'yes',
                    'separator'    => 'before',
                ]
            );

        }

        // ── Pause on hover ───────────────────────────────────────────────────
        if ( $config['hover'] ) {

            $this->add_control(
                'pause_on_hover',
                [
                    'label'        => esc_html__( 'Pause on Hover', 'elematic-addons-for-elementor' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'default'      => 'yes',
                    'return_value' => 'yes',
                    'condition'    => [ 'autoplay' => 'yes' ],
                ]
            );

        }

        // ── Dimensions ──────────────────────────────────────────────────────
        if ( $config['dimensions'] ) {

            $this->add_responsive_control(
                'slide_width',
                [
                    'label'      => esc_html__( 'Slide Width', 'elematic-addons-for-elementor' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range'      => [ 'px' => [ 'min' => 100, 'max' => 1200 ] ],
                    'default'    => [ 'size' => 480, 'unit' => 'px' ],
                    'separator'  => 'before',
                ]
            );

            $this->add_responsive_control(
                'slide_height',
                [
                    'label'      => esc_html__( 'Slide Height', 'elematic-addons-for-elementor' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => [ 'px' ],
                    'range'      => [ 'px' => [ 'min' => 100, 'max' => 800 ] ],
                    'default'    => [ 'size' => 320, 'unit' => 'px' ],
                ]
            );

            $this->add_control(
                'slide_gap',
                [
                    'label'   => esc_html__( 'Gap Between Slides', 'elematic-addons-for-elementor' ),
                    'type'    => Controls_Manager::SLIDER,
                    'range'   => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
                    'default' => [ 'size' => 24 ],
                ]
            );

        }

        // ── Transition ──────────────────────────────────────────────────────
        if ( $config['transition'] ) {

            $this->add_control(
                'transition_duration',
                [
                    'label'     => esc_html__( 'Transition Duration (ms)', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::NUMBER,
                    'default'   => 800,
                    'min'       => 100,
                    'step'      => 50,
                    'separator' => 'before',
                ]
            );

            $this->add_control(
                'transition_easing',
                [
                    'label'   => esc_html__( 'Easing', 'elematic-addons-for-elementor' ),
                    'type'    => Controls_Manager::SELECT,
                    'default' => 'power2.inOut',
                    'options' => [
                        'power1.inOut' => esc_html__( 'Smooth (Subtle)', 'elematic-addons-for-elementor' ),
                        'power2.inOut' => esc_html__( 'Smooth (Default)', 'elematic-addons-for-elementor' ),
                        'power3.inOut' => esc_html__( 'Smooth (Strong)', 'elematic-addons-for-elementor' ),
                        'power2.out'   => esc_html__( 'Decelerate', 'elematic-addons-for-elementor' ),
                        'back.out'     => esc_html__( 'Overshoot', 'elematic-addons-for-elementor' ),
                        'elastic.out'  => esc_html__( 'Elastic', 'elematic-addons-for-elementor' ),
                        'bounce.out'   => esc_html__( 'Bounce', 'elematic-addons-for-elementor' ),
                        'none'         => esc_html__( 'Linear', 'elematic-addons-for-elementor' ),
                    ],
                ]
            );

        }

        $this->end_controls_section();

    }

    /**
     * Helper: build a JS-ready settings array from carousel control values.
     * Call from render() and pass to data-settings on the wrapper element.
     *
     * @param  array $settings  Widget settings from get_settings_for_display().
     * @param  array $extra     Any extra widget-specific keys to merge in.
     * @return array
     */
    protected function get_carousel_js_settings( $settings, $extra = [] ) {
        $js = [];

        if ( isset( $settings['autoplay'] ) ) {
            $js['autoplay']   = $settings['autoplay'] === 'yes';
            $js['speed']      = (int) ( $settings['autoplay_speed'] ?? 3000 );
            $js['direction']  = $settings['autoplay_direction'] ?? 'left';
        }

        if ( isset( $settings['loop'] ) ) {
            $js['loop'] = $settings['loop'] === 'yes';
        }

        if ( isset( $settings['draggable'] ) ) {
            $js['draggable'] = $settings['draggable'] === 'yes';
        }

        if ( isset( $settings['pause_on_hover'] ) ) {
            $js['pauseOnHover'] = $settings['pause_on_hover'] === 'yes';
        }

        if ( isset( $settings['slide_width']['size'] ) ) {
            $js['slideWidth']  = (int) $settings['slide_width']['size'];
            $js['slideHeight'] = (int) ( $settings['slide_height']['size'] ?? 320 );
            $js['slideGap']    = (int) ( $settings['slide_gap']['size'] ?? 24 );
        }

        if ( isset( $settings['transition_duration'] ) ) {
            $js['duration'] = (int) $settings['transition_duration'] / 1000; // ms → seconds
            $js['easing']   = $settings['transition_easing'] ?? 'power2.inOut';
        }

        return array_merge( $js, $extra );
    }

}