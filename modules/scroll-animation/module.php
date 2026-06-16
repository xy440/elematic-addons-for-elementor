<?php
namespace Elematic\Modules\ScrollAnimation;

use Elematic\Base\Module_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) exit;

class Module extends Module_Base {

	public function __construct() {

		// ── Register controls panel on every element type ─────────────────
		// section, column, common (widgets), and Elementor 3.x containers
		$hooks = [
			'section'    => 'section_advanced',
			'column'     => 'section_advanced',
			'common'     => '_section_style',   // all widgets
			'e-con'      => 'section_layout',   // Flexbox Container (Elementor 3.6+)
			'e-con-inner'=> 'section_layout',   // Inner Container
		];

		foreach ( $hooks as $element_type => $after_section ) {
			add_action(
				"elementor/element/{$element_type}/{$after_section}/after_section_end",
				[ $this, 'register_section' ]
			);
			add_action(
				"elementor/element/{$element_type}/sec_elematic_scroll_anim/before_section_end",
				[ $this, 'register_controls' ],
				10, 2
			);
		}

		// ── Output data-attributes on frontend only ────────────────────────
		add_action( 'elementor/frontend/before_render', [ $this, 'before_render' ], 10, 1 );
	}

	public function get_name() {
		return 'elematic-scroll-animation';
	}

	// ─────────────────────────────────────────────────────────────────────
	// Open the Advanced tab panel section
	// ─────────────────────────────────────────────────────────────────────
	public function register_section( $element ) {
		$element->start_controls_section(
			'sec_elematic_scroll_anim',
			[
				'tab'   => Controls_Manager::TAB_ADVANCED,
				'label' => ELEMATIC . esc_html__( 'Scroll Animation', 'elematic-addons-for-elementor' ),
			]
		);
		$element->end_controls_section();
	}

	// ─────────────────────────────────────────────────────────────────────
	// Add controls inside the section
	// ─────────────────────────────────────────────────────────────────────
	public function register_controls( $element, $args ) {

		// ── ENTRANCE ANIMATION ────────────────────────────────────────────

		$element->add_control(
			'elematic_sa_entrance_heading',
			[
				'label' => esc_html__( '🎭 Entrance Animation', 'elematic-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$element->add_control(
			'elematic_sa_entrance_type',
			[
				'label'   => esc_html__( 'Animation Type', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''            => esc_html__( '— None —', 'elematic-addons-for-elementor' ),
					'fade-up'     => esc_html__( 'Fade Up', 'elematic-addons-for-elementor' ),
					'fade-down'   => esc_html__( 'Fade Down', 'elematic-addons-for-elementor' ),
					'fade-left'   => esc_html__( 'Fade Left', 'elematic-addons-for-elementor' ),
					'fade-right'  => esc_html__( 'Fade Right', 'elematic-addons-for-elementor' ),
					'zoom-in'     => esc_html__( 'Zoom In', 'elematic-addons-for-elementor' ),
					'zoom-out'    => esc_html__( 'Zoom Out', 'elematic-addons-for-elementor' ),
					'flip-up'     => esc_html__( 'Flip Up', 'elematic-addons-for-elementor' ),
					'flip-left'   => esc_html__( 'Flip Left', 'elematic-addons-for-elementor' ),
					'slide-up'    => esc_html__( 'Slide Up', 'elematic-addons-for-elementor' ),
					'slide-left'  => esc_html__( 'Slide Left', 'elematic-addons-for-elementor' ),
					'slide-right' => esc_html__( 'Slide Right', 'elematic-addons-for-elementor' ),
					'bounce-in'   => esc_html__( 'Bounce In', 'elematic-addons-for-elementor' ),
					'rotate-in'   => esc_html__( 'Rotate In', 'elematic-addons-for-elementor' ),
					'skew-in'     => esc_html__( 'Skew In', 'elematic-addons-for-elementor' ),
				],
			]
		);

		$element->add_control(
			'elematic_sa_entrance_duration',
			[
				'label'      => esc_html__( 'Duration (s)', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 0.1, 'max' => 3, 'step' => 0.05 ] ],
				'default'    => [ 'size' => 0.7, 'unit' => 's' ],
				'condition'  => [ 'elematic_sa_entrance_type!' => '' ],
			]
		);

		$element->add_control(
			'elematic_sa_entrance_delay',
			[
				'label'      => esc_html__( 'Delay (s)', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 0, 'max' => 3, 'step' => 0.05 ] ],
				'default'    => [ 'size' => 0, 'unit' => 's' ],
				'condition'  => [ 'elematic_sa_entrance_type!' => '' ],
			]
		);

		$element->add_control(
			'elematic_sa_entrance_ease',
			[
				'label'     => esc_html__( 'Easing', 'elematic-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'power2.out',
				'options'   => [
					'power1.out'         => 'Power 1 (Subtle)',
					'power2.out'         => 'Power 2 (Default)',
					'power3.out'         => 'Power 3 (Strong)',
					'power4.out'         => 'Power 4 (Heavy)',
					'back.out(1.7)'      => 'Back (Overshoot)',
					'elastic.out(1,0.3)' => 'Elastic',
					'bounce.out'         => 'Bounce',
					'circ.out'           => 'Circular',
					'expo.out'           => 'Expo',
					'sine.out'           => 'Sine (Smooth)',
					'linear'             => 'Linear',
				],
				'condition' => [ 'elematic_sa_entrance_type!' => '' ],
			]
		);

		$element->add_control(
			'elematic_sa_entrance_offset',
			[
				'label'      => esc_html__( 'Trigger Point (%)', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 0, 'max' => 100, 'step' => 1 ] ],
				'default'    => [ 'size' => 85, 'unit' => '%' ],
				'description'=> esc_html__( 'Triggers when element top reaches this % from the viewport top.', 'elematic-addons-for-elementor' ),
				'condition'  => [ 'elematic_sa_entrance_type!' => '' ],
			]
		);

		$element->add_control(
			'elematic_sa_auto_stagger',
			[
				'label'        => esc_html__( 'Auto Stagger Children', 'elematic-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [ 'elematic_sa_entrance_type!' => '' ],
			]
		);

		$element->add_control(
			'elematic_sa_stagger_delay',
			[
				'label'      => esc_html__( 'Stagger Delay (s)', 'elematic-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 's' ],
				'range'      => [ 's' => [ 'min' => 0.05, 'max' => 0.8, 'step' => 0.05 ] ],
				'default'    => [ 'size' => 0.15, 'unit' => 's' ],
				'condition'  => [
					'elematic_sa_entrance_type!' => '',
					'elematic_sa_auto_stagger'   => 'yes',
				],
			]
		);

		$element->add_control( 'elematic_sa_divider_1', [ 'type' => Controls_Manager::DIVIDER ] );

		// ── WHILE SCROLLING (SCRUB) ───────────────────────────────────────

		$element->add_control(
			'elematic_sa_scroll_heading',
			[
				'label' => esc_html__( '📜 While Scrolling', 'elematic-addons-for-elementor' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$element->add_control(
			'elematic_sa_scroll_effect',
			[
				'label'   => esc_html__( 'Scroll Effect', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''           => esc_html__( '— None —', 'elematic-addons-for-elementor' ),
					'parallax-y' => esc_html__( 'Parallax (Vertical)', 'elematic-addons-for-elementor' ),
					'parallax-x' => esc_html__( 'Parallax (Horizontal)', 'elematic-addons-for-elementor' ),
					'fade'       => esc_html__( 'Fade on Scroll', 'elematic-addons-for-elementor' ),
					'scale'      => esc_html__( 'Scale on Scroll', 'elematic-addons-for-elementor' ),
					'rotate'     => esc_html__( 'Rotate on Scroll', 'elematic-addons-for-elementor' ),
					'skew'       => esc_html__( 'Skew on Scroll', 'elematic-addons-for-elementor' ),
					'blur'       => esc_html__( 'Blur on Scroll', 'elematic-addons-for-elementor' ),
				],
			]
		);

		$element->add_control(
			'elematic_sa_scroll_start_val',
			[
				'label'       => esc_html__( 'Start Value', 'elematic-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '-80',
				'description' => esc_html__( 'px for parallax/move, 0–1 for fade, multiplier for scale, deg for rotate/skew, px for blur.', 'elematic-addons-for-elementor' ),
				'condition'   => [ 'elematic_sa_scroll_effect!' => '' ],
			]
		);

		$element->add_control(
			'elematic_sa_scroll_end_val',
			[
				'label'     => esc_html__( 'End Value', 'elematic-addons-for-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '80',
				'condition' => [ 'elematic_sa_scroll_effect!' => '' ],
			]
		);

		$element->add_control(
			'elematic_sa_scroll_scrub',
			[
				'label'     => esc_html__( 'Scrub Smoothness', 'elematic-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => [
					'true' => esc_html__( 'Instant', 'elematic-addons-for-elementor' ),
					'0.5'  => esc_html__( 'Very Fast', 'elematic-addons-for-elementor' ),
					'1'    => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
					'2'    => esc_html__( 'Smooth', 'elematic-addons-for-elementor' ),
					'4'    => esc_html__( 'Very Smooth', 'elematic-addons-for-elementor' ),
				],
				'condition' => [ 'elematic_sa_scroll_effect!' => '' ],
			]
		);
	}

	// ─────────────────────────────────────────────────────────────────────
	// Output data-attributes on the element wrapper (frontend only)
	// ─────────────────────────────────────────────────────────────────────
	public function before_render( $element ) {

		// BUG FIX: Skip this in the Elementor editor — only run on frontend
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			return;
		}

		$settings = $element->get_settings_for_display();

		$entrance_type = ! empty( $settings['elematic_sa_entrance_type'] ) ? $settings['elematic_sa_entrance_type'] : '';
		$scroll_effect = ! empty( $settings['elematic_sa_scroll_effect'] ) ? $settings['elematic_sa_scroll_effect'] : '';

		// Nothing set → nothing to do
		if ( ! $entrance_type && ! $scroll_effect ) {
			return;
		}

		// ── Entrance animation data ────────────────────────────────────────
		if ( $entrance_type ) {
			$entrance_data = [
				'type'          => sanitize_key( $entrance_type ),
				'duration'      => isset( $settings['elematic_sa_entrance_duration']['size'] )
					? (float) $settings['elematic_sa_entrance_duration']['size'] : 0.7,
				'delay'         => isset( $settings['elematic_sa_entrance_delay']['size'] )
					? (float) $settings['elematic_sa_entrance_delay']['size']    : 0,
				'ease'          => isset( $settings['elematic_sa_entrance_ease'] )
					? $settings['elematic_sa_entrance_ease']                     : 'power2.out',
				'offset'        => isset( $settings['elematic_sa_entrance_offset']['size'] )
					? (int) $settings['elematic_sa_entrance_offset']['size']     : 85,
				'stagger'       => ! empty( $settings['elematic_sa_auto_stagger'] )
					? $settings['elematic_sa_auto_stagger']                      : '',
				'stagger_delay' => isset( $settings['elematic_sa_stagger_delay']['size'] )
					? (float) $settings['elematic_sa_stagger_delay']['size']     : 0.15,
			];

			$element->add_render_attribute(
				'_wrapper',
				'data-elematic-sa-entrance',
				wp_json_encode( $entrance_data )
			);
		}

		// ── While-scrolling data ───────────────────────────────────────────
		if ( $scroll_effect ) {
			$scroll_data = [
				'effect'    => sanitize_key( $scroll_effect ),
				'start_val' => isset( $settings['elematic_sa_scroll_start_val'] )
					? $settings['elematic_sa_scroll_start_val'] : '-80',
				'end_val'   => isset( $settings['elematic_sa_scroll_end_val'] )
					? $settings['elematic_sa_scroll_end_val']   : '80',
				'scrub'     => isset( $settings['elematic_sa_scroll_scrub'] )
					? $settings['elematic_sa_scroll_scrub']     : '1',
			];

			$element->add_render_attribute(
				'_wrapper',
				'data-elematic-sa-scroll',
				wp_json_encode( $scroll_data )
			);
		}
	}
}
