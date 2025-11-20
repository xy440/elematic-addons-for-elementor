<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ImageAnimate extends Widget_Base {

    public function get_name() {
        return 'elematic-image-animate';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Image Animate', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-image';
    }

    public function get_style_depends() {
        return [ 'elematic-image-animate' ];
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_keywords() {
        return [ 'animated', 'animate', 'animation', 'image', 'swing', 'moving', 'move' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
            'ib_settings',
            [
                'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'image',
            [
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'full',
                'condition' => [
                    'image[url]!' => '',
                ],
            ]
        );
        $this->add_responsive_control(
            'ia_img_size',
            [
                'label'   => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 3500,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-animate-wrap img'   => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'ia_animate',
            [
                'label'   => esc_html__( 'Animate', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'floatY', // keep "Up/Down" as default
                'options' => [
                    'floatY'   => esc_html__( 'Up / Down', 'elematic-addons-for-elementor' ),
                    'floatX'   => esc_html__( 'Left / Right', 'elematic-addons-for-elementor' ),
                    'floatDiag'=> esc_html__( 'Diagonal', 'elematic-addons-for-elementor' ),
                    'pulse'    => esc_html__( 'Pulse (Scale)', 'elematic-addons-for-elementor' ),
                    'tilt'     => esc_html__( 'Tilt (Alternate Rotate)', 'elematic-addons-for-elementor' ),
                    'spin'     => esc_html__( 'Spin (Continuous)', 'elematic-addons-for-elementor' ),
                    'bounce'   => esc_html__( 'Bounce', 'elematic-addons-for-elementor' ),
                    'wiggle'   => esc_html__( 'Wiggle', 'elematic-addons-for-elementor' ),
                    'fade'     => esc_html__( 'Fade In / Out', 'elematic-addons-for-elementor' ),
                ],
            ]
        );
        $this->add_control(
            'ia_moving',
            [
                'label'       => esc_html__( 'Movement Distance', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
                ],
                'default'     => [ 'unit' => 'px', 'size' => 25 ],
                'render_type' => 'template',
            ]
        );
        $this->add_control(
            'ia_rotate_deg',
            [
                'label' => esc_html__( 'Rotate Amount', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'deg' ],
                'range' => [ 'deg' => [ 'min' => 0, 'max' => 45 ] ],
                'default' => [ 'unit' => 'deg', 'size' => 8 ],
                'condition' => [ 'ia_animate' => [ 'tilt', 'wiggle' ] ],
            ]
        );

        $this->add_control(
            'ia_scale_amount',
            [
                'label' => esc_html__( 'Scale Amount', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::NUMBER,
                'min'   => 1.02,
                'max'   => 2,
                'step'  => 0.01,
                'default' => 1.08,
                'condition' => [ 'ia_animate' => 'pulse' ],
            ]
        );
        $this->add_control(
          'ia_spin_direction',
          [
            'label'   => esc_html__( 'Spin Direction', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'cw',
            'options' => [
              'cw'  => esc_html__( 'Clockwise', 'elematic-addons-for-elementor' ),
              'ccw' => esc_html__( 'Anti-clockwise', 'elematic-addons-for-elementor' ),
            ],
            'condition' => [ 'ia_animate' => 'spin' ],
          ]
        );
        $this->add_control(
            'ia_speed',
            [
                'label'       => esc_html__( 'Speed (seconds)', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 's' ],
                'range'       => [
                    's' => [ 'min' => 0.1, 'max' => 60, 'step' => 0.1 ],
                ],
                'default'     => [ 'unit' => 's', 'size' => 2.5 ],
                'render_type' => 'template',
            ]
        );
        $this->add_control(
            'ia_link_url',
            [
                'label'       => esc_html__( 'Link URL', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'https://your-link.com',
            ]
        );
        $this->add_responsive_control(
            'alignment',
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
                'selectors'         => [
                    '{{WRAPPER}} .elematic-image-animate-wrap'   => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

	}

	protected function render() {
        $settings = $this->get_settings_for_display();

        $anim    = $settings['ia_animate'] ?? 'floatY';
        $dist = ! empty( $settings['ia_moving']['size'] ) ? (float) $settings['ia_moving']['size'] : 25;
        $speedS = isset($settings['ia_speed']['size']) ? (float) $settings['ia_speed']['size'] : 2.5;
        $rotDeg  = ! empty($settings['ia_rotate_deg']['size']) ? (float) $settings['ia_rotate_deg']['size'] : 8;
        $scale   = isset($settings['ia_scale_amount']) ? (float) $settings['ia_scale_amount'] : 1.08;
        $spinDir = ! empty($settings['ia_spin_direction']) ? $settings['ia_spin_direction'] : 'cw';

        // wrapper attrs
        $this->add_render_attribute('wrap', 'id', 'elematic-ia-' . $this->get_id());
        $this->add_render_attribute('wrap', 'class', 'elematic-image-animate-wrap elematic-ia-anim-' . $anim);
        $this->add_render_attribute(
            'wrap',
            'style',
            sprintf('--ia-dist:%spx;--ia-speed:%ss;--ia-rotate:%sdeg;--ia-scale:%s;', $dist, $speedS, $rotDeg, $scale)
        );

        if ($anim === 'spin') {
            $this->add_render_attribute('wrap', 'data-spin-dir', ($spinDir === 'ccw') ? 'ccw' : 'cw');
        }

        $link_url = ! empty($settings['ia_link_url']['url']) ? $settings['ia_link_url']['url'] : '';
        if ($link_url) {
            $this->add_render_attribute('link', 'href', esc_url($link_url));
            $this->add_render_attribute('link', 'target', ! empty($settings['ia_link_url']['is_external']) ? '_blank' : '_self');
            $rel = [];
            if (!empty($settings['ia_link_url']['is_external'])) { $rel[] = 'noopener'; }
            if (!empty($settings['ia_link_url']['nofollow']))     { $rel[] = 'nofollow'; }
            if ($rel) { $this->add_render_attribute('link', 'rel', implode(' ', $rel)); }
        }
        ?>
        <div <?php $this->print_render_attribute_string('wrap'); ?>>
            <?php if ($link_url) : ?>
                <a <?php $this->print_render_attribute_string('link'); ?>>
                    <span class="elematic-ia-inner">
                        <?php Group_Control_Image_Size::print_attachment_image_html($settings, 'image', 'image'); ?>
                    </span>
                </a>
            <?php else : ?>
                <span class="elematic-ia-inner">
                    <?php Group_Control_Image_Size::print_attachment_image_html($settings, 'image', 'image'); ?>
                </span>
            <?php endif; ?>
        </div>
        <?php
    }
} // class
