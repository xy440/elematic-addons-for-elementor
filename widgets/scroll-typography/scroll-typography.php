<?php
/**
 * Scroll Typography Widget
 *
 * @package Elematic
 */

namespace Elematic\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Scroll Typography widget class.
 */
class ScrollTypography extends Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'elematic-scroll-typography';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return ELEMATIC . esc_html__( 'Scroll Typography', 'elematic-addons-for-elementor' );
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-animated-headline';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return [ 'text', 'scroll', 'animation', 'typography', 'reveal', 'webflow', 'framer' ];
    }

    /**
     * Get style dependencies.
     */
    public function get_style_depends() {
        return [ 'elematic-scroll-typography' ];
    }

    /**
     * Get script dependencies.
     */
    public function get_script_depends() {
        return [ 'elematic-scroll-typography' ];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {

        // ─── Content ─────────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_type',
            [
                'label'   => esc_html__( 'Content Type', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'heading',
                'options' => [
                    'heading'   => esc_html__( 'Heading', 'elematic-addons-for-elementor' ),
                    'paragraph' => esc_html__( 'Paragraph', 'elematic-addons-for-elementor' ),
                    'custom'    => esc_html__( 'Custom HTML', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label'       => esc_html__( 'Text', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Your animated heading goes here', 'elematic-addons-for-elementor' ),
                'placeholder' => esc_html__( 'Enter your text', 'elematic-addons-for-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [
                    'content_type' => 'heading',
                ],
            ]
        );

        $this->add_control(
            'paragraph_text',
            [
                'label'       => esc_html__( 'Text', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Your animated paragraph text goes here.', 'elematic-addons-for-elementor' ),
                'dynamic'     => [ 'active' => true ],
                'condition'   => [
                    'content_type' => 'paragraph',
                ],
            ]
        );

        $this->add_control(
            'html_tag',
            [
                'label'     => esc_html__( 'HTML Tag', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h2',
                'options'   => [
                    'h1'  => 'H1',
                    'h2'  => 'H2',
                    'h3'  => 'H3',
                    'h4'  => 'H4',
                    'h5'  => 'H5',
                    'h6'  => 'H6',
                    'p'   => 'p',
                    'div' => 'div',
                    'span' => 'span',
                ],
                'condition' => [
                    'content_type' => 'heading',
                ],
            ]
        );

        $this->add_control(
            'custom_html',
            [
                'label'       => esc_html__( 'Custom HTML', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::CODE,
                'language'    => 'html',
                'default'     => '<p>Your <strong>animated</strong> text goes here.</p>',
                'condition'   => [
                    'content_type' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

        // ─── Animation ───────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_animation',
            [
                'label' => esc_html__( 'Animation', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'animation_style',
            [
                'label'   => esc_html__( 'Animation Style', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'word-fade-up',
                'options' => [
                    'word-fade-up'  => esc_html__( '1. Word Fade Up', 'elematic-addons-for-elementor' ),
                    'flow-in'       => esc_html__( '2. Flow In', 'elematic-addons-for-elementor' ),
                    'words-move'    => esc_html__( '3. Words Move In', 'elematic-addons-for-elementor' ),
                    'split-reveal'  => esc_html__( '4. Split Reveal', 'elematic-addons-for-elementor' ),
                    'blur-in'       => esc_html__( '5. Blur In', 'elematic-addons-for-elementor' ),
                    'emerge-up'     => esc_html__( '6. Emerge Up', 'elematic-addons-for-elementor' ),
                    'wave-roll'     => esc_html__( '7. Wave Roll', 'elematic-addons-for-elementor' ),
                    'char-fade'     => esc_html__( '8. Char Fade', 'elematic-addons-for-elementor' ),
                    // 'scale-appear'  => esc_html__( '9. Scale Appear', 'elematic-addons-for-elementor' ),
                    // 'line-reveal'   => esc_html__( '10. Line Reveal', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label'      => esc_html__( 'Duration (ms)', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [ 'size' => 600 ],
                'range'      => [
                    'px' => [
                        'min'  => 200,
                        'max'  => 2000,
                        'step' => 50,
                    ],
                ],
                'size_units' => [],
            ]
        );

        $this->add_control(
            'stagger_delay',
            [
                'label'      => esc_html__( 'Stagger Delay (ms)', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [ 'size' => 60 ],
                'range'      => [
                    'px' => [
                        'min'  => 10,
                        'max'  => 300,
                        'step' => 5,
                    ],
                ],
                'size_units' => [],
            ]
        );

        $this->add_control(
            'trigger_offset',
            [
                'label'      => esc_html__( 'Trigger Offset (%)', 'elematic-addons-for-elementor' ),
                'description'=> esc_html__( 'How much of the element must be visible before triggering. 0 = as soon as 1px enters viewport.', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [ 'size' => 15 ],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 60,
                        'step' => 5,
                    ],
                ],
                'size_units' => [],
            ]
        );

        $this->add_control(
            'replay_on_enter',
            [
                'label'        => esc_html__( 'Replay on Re-enter', 'elematic-addons-for-elementor' ),
                'description'  => esc_html__( 'Re-trigger the animation each time the element enters the viewport.', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => '',
            ]
        );

        $this->add_control(
            'animate_in_editor',
            [
                'label'        => esc_html__( 'Preview in Editor', 'elematic-addons-for-elementor' ),
                'description'  => esc_html__( 'Play the animation inside the Elementor editor for preview.', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->end_controls_section();

        // ─── Style ────────────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Typography', 'elematic-addons-for-elementor' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .elematic-scroll-typography',
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-scroll-typography' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-scroll-typography' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'max_width',
            [
                'label'      => esc_html__( 'Max Width', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range'      => [
                    'px' => [ 'min' => 200, 'max' => 2000 ],
                    '%'  => [ 'min' => 10,  'max' => 100 ],
                    'vw' => [ 'min' => 10,  'max' => 100 ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-scroll-typography' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $style      = ! empty( $settings['animation_style'] ) ? $settings['animation_style'] : 'word-fade-up';
        $duration   = ! empty( $settings['animation_duration']['size'] ) ? (int) $settings['animation_duration']['size'] : 600;
        $stagger    = ! empty( $settings['stagger_delay']['size'] ) ? (int) $settings['stagger_delay']['size'] : 60;
        $offset     = ! empty( $settings['trigger_offset']['size'] ) ? (int) $settings['trigger_offset']['size'] : 15;
        $replay     = ! empty( $settings['replay_on_enter'] ) && 'yes' === $settings['replay_on_enter'] ? 'true' : 'false';
        $in_editor  = ! empty( $settings['animate_in_editor'] ) && 'yes' === $settings['animate_in_editor'] ? 'true' : 'false';

        $data_attrs = sprintf(
            'data-elematic-style="%s" data-elematic-duration="%d" data-elematic-stagger="%d" data-elematic-offset="%d" data-elematic-replay="%s" data-elematic-editor="%s"',
            esc_attr( $style ),
            $duration,
            $stagger,
            $offset,
            esc_attr( $replay ),
            esc_attr( $in_editor )
        );

        if ( 'custom' === $settings['content_type'] ) {
            printf(
                '<div class="elematic-scroll-typography" data-elematic-split="whole" %s>%s</div>',
                $data_attrs, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                wp_kses_post( $settings['custom_html'] )
            );
            return;
        }

        if ( 'paragraph' === $settings['content_type'] ) {
            $paragraph_text = ! empty( $settings['paragraph_text'] ) ? $settings['paragraph_text'] : '';
            printf(
                '<p class="elematic-scroll-typography" %s>%s</p>',
                $data_attrs, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                esc_html( $paragraph_text )
            );
            return;
        }

        $tag  = sanitize_key( $settings['html_tag'] );
        $text = ! empty( $settings['text'] ) ? $settings['text'] : '';

        printf(
            '<%1$s class="elematic-scroll-typography elematic-st-heading" %2$s>%3$s</%1$s>',
            esc_attr( $tag ),
            $data_attrs, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            esc_html( $text )
        );
    }

    /**
     * Render widget output in the editor (live preview).
     */
    protected function content_template() {
        ?>
        <#
        var style     = settings.animation_style || 'word-fade-up';
        var duration  = settings.animation_duration.size || 600;
        var stagger   = settings.stagger_delay.size || 60;
        var offset    = settings.trigger_offset.size || 15;
        var replay    = settings.replay_on_enter === 'yes' ? 'true' : 'false';
        var inEditor  = settings.animate_in_editor === 'yes' ? 'true' : 'false';
        var dataAttrs = 'data-elematic-style="' + style + '" data-elematic-duration="' + duration + '" data-elematic-stagger="' + stagger + '" data-elematic-offset="' + offset + '" data-elematic-replay="' + replay + '" data-elematic-editor="' + inEditor + '"';

        if ( 'custom' === settings.content_type ) {
            #>
            <div class="elematic-scroll-typography" data-elematic-split="whole" {{{ dataAttrs }}}>{{{ settings.custom_html }}}</div>
            <#
        } else if ( 'paragraph' === settings.content_type ) {
            #>
            <p class="elematic-scroll-typography" {{{ dataAttrs }}}>{{{ settings.paragraph_text }}}</p>
            <#
        } else {
            var tag = settings.html_tag;
            #>
            <{{{ tag }}} class="elematic-scroll-typography elematic-st-heading" {{{ dataAttrs }}}>{{{ settings.text }}}</{{{ tag }}}>
        <# } #>
        <?php
    }
}