<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class AnimatedHeading extends Widget_Base {

    public function get_name() {
        return 'elematic-animated-heading';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Animated Heading', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-animation-text';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_style_depends() {
        return ['elematic-animated-heading', 'animation'];
    }
    public function get_script_depends() {
        return [ 'elematic-animated-heading', 'typed', 'morphext' ];
    }
    public function get_keywords() {
        return [ 'animated', 'heading', 'headline', 'vivid', 'title', 'text', 'animation', 'typing' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
            'settings',
            [
                'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_control(
            'txt_style',
            [
                'label'   => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'typed' => esc_html__( 'Typed', 'elematic-addons-for-elementor' ),
                    'animated'    => esc_html__( 'Animated', 'elematic-addons-for-elementor' ),
                ],
                'default' => 'typed',
            ]
        );
        $this->add_control(
            'type_speed',
            [
                'label'     => esc_html__( 'Type Speed', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 70,
                'condition' => [
                    'txt_style' => 'typed',
                ],
            ]
        );
        $this->add_control(
            'start_delay',
            [
                'label'     => esc_html__( 'Start Delay', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 500,
                'step'      => 100,
                'condition' => [
                    'txt_style' => 'typed',
                ],
            ]
        );

        $this->add_control(
            'back_speed',
            [
                'label'     => esc_html__( 'Back Speed', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 40,
                'condition' => [
                    'txt_style' => 'typed',
                ],
            ]
        );

        $this->add_control(
            'back_delay',
            [
                'label'     => esc_html__( 'Back Delay', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 500,
                'step'      => 50,
                'condition' => [
                    'txt_style' => 'typed',
                ],
            ]
        );
        $this->add_control(
            'txt_animation',
            [
                'label'   => esc_html__( 'Animation', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'elematic-addons-for-elementor' ),
                    'fadeIn' => esc_html__( 'Fade In', 'elematic-addons-for-elementor' ),
                    'fadeInUp' => esc_html__( 'Fade In Up', 'elematic-addons-for-elementor' ),
                    'fadeInDown' => esc_html__( 'Fade In Down', 'elematic-addons-for-elementor' ),
                    'fadeInLeft' => esc_html__( 'Fade In Left', 'elematic-addons-for-elementor' ),
                    'fadeInRight' => esc_html__( 'Fade In Right', 'elematic-addons-for-elementor' ),
                    'zoomIn'    => esc_html__( 'Zoom In', 'elematic-addons-for-elementor' ),
                    'zoomInUp'    => esc_html__( 'Zoom In Up', 'elematic-addons-for-elementor' ),
                    'zoomInDown'    => esc_html__( 'Zoom In Down', 'elematic-addons-for-elementor' ),
                    'zoomInLeft'    => esc_html__( 'Zoom In Left', 'elematic-addons-for-elementor' ),
                    'zoomInRight'    => esc_html__( 'Zoom In Right', 'elematic-addons-for-elementor' ),
                    'bounceIn'    => esc_html__( 'Bounce In', 'elematic-addons-for-elementor' ),
                    'bounceInUp'    => esc_html__( 'Bounce In Up', 'elematic-addons-for-elementor' ),
                    'bounceInDown'    => esc_html__( 'Bounce In Down', 'elematic-addons-for-elementor' ),
                    'bounceInLeft'    => esc_html__( 'Bounce In Left', 'elematic-addons-for-elementor' ),
                    'bounceInRight'    => esc_html__( 'Bounce In Right', 'elematic-addons-for-elementor' ),
                    'slideIn'    => esc_html__( 'Slide In', 'elematic-addons-for-elementor' ),
                    'slideInUp'    => esc_html__( 'Slide In Up', 'elematic-addons-for-elementor' ),
                    'slideInDown'    => esc_html__( 'Slide In Down', 'elematic-addons-for-elementor' ),
                    'slideInLeft'    => esc_html__( 'Slide In Left', 'elematic-addons-for-elementor' ),
                    'slideInRight'    => esc_html__( 'Slide In Right', 'elematic-addons-for-elementor' ),
                    'rotateIn'    => esc_html__( 'Rotate In', 'elematic-addons-for-elementor' ),
                    'rotateInUpLeft'    => esc_html__( 'Rotate In Up Left', 'elematic-addons-for-elementor' ),
                    'rotateInUpRight'    => esc_html__( 'Rotate In Up Right', 'elematic-addons-for-elementor' ),
                    'rotateInDownLeft'    => esc_html__( 'Rotate In Down Left', 'elematic-addons-for-elementor' ),
                    'rotateInDownRight'    => esc_html__( 'Rotate In Down Right', 'elematic-addons-for-elementor' ),
                    'bounce'    => esc_html__( 'Bounce', 'elematic-addons-for-elementor' ),
                    'flash'    => esc_html__( 'Flash', 'elematic-addons-for-elementor' ),
                    'pulse'    => esc_html__( 'Pulse', 'elematic-addons-for-elementor' ),
                    'rubberBand'    => esc_html__( 'Rubber Band', 'elematic-addons-for-elementor' ),
                    'shake'    => esc_html__( 'Shake', 'elematic-addons-for-elementor' ),
                    'headShake'    => esc_html__( 'Head Shake', 'elematic-addons-for-elementor' ),
                    'swing'    => esc_html__( 'Swing', 'elematic-addons-for-elementor' ),
                    'tada'    => esc_html__( 'Tada', 'elematic-addons-for-elementor' ),
                    'wobble'    => esc_html__( 'Wobble', 'elematic-addons-for-elementor' ),
                    'jello'    => esc_html__( 'Jello', 'elematic-addons-for-elementor' ),
                    'lightSpeedIn'    => esc_html__( 'Light Speed In', 'elematic-addons-for-elementor' ),
                    'rollIn'    => esc_html__( 'Roll In', 'elematic-addons-for-elementor' ),
                ],
                'default' => 'fadeIn',
                'condition' => [
                    'txt_style' => 'animated',
                ]
            ]
        );
        $this->add_control(
            'speed',
            [
                'label'     => esc_html__( 'Delay', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 2000,
                'step'      => 100,
                'condition' => [
                   'txt_style' => 'animated',
                ],
            ]
        );
        $this->add_control(
            'before_txt',
            [
                'label' => esc_html__( 'Before Text', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'This is', 'elematic-addons-for-elementor' ),
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'animated_txt',
            [
                'label' => esc_html__( 'Animated Text', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default' => esc_html__( 'Animated, Typing, Dynamic', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'after_txt',
            [
                'label' => esc_html__( 'After Text', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'Heading', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'html_tag',
            [
                'label'     => esc_html__( 'HTML Tag', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'options' => Helper::elematic_html_tags(),
                'default'   => 'h2',
                'separator' => 'before'
            ]
        );
        
        $this->add_control(
            'link_url',
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
                'toggle' => false,
                'selectors'         => [
                    '{{WRAPPER}} .elematic-animated-heading'   => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        
		$this->start_controls_section(
			'elematic_styles',
			[
				'label' 	=> esc_html__( 'Default Styles', 'elematic-addons-for-elementor' ),
				'tab' 		=> Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
            'ah_txt_color',
            [
                'label'     => esc_html__( 'Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-heading' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ah_txt_hov_color',
            [
                'label'     => esc_html__( 'Text Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-heading:hover span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ah_txt_bg_color',
            [
                'label'     => esc_html__( 'Text Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-heading' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'ah_txt_typo',
                'selector'  => '{{WRAPPER}} .elematic-animated-heading',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'ah_txt_shadow',
                'selector' => '{{WRAPPER}} .elematic-animated-heading'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'ah_border',
                'selector'    =>    '{{WRAPPER}} .elematic-animated-heading'
            ]
        );
        $this->add_responsive_control(
            'ah_padding',
            [
                'label'         => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ah_margin',
            [
                'label'         => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'elematic_before_style',
            [
                'label'     => esc_html__( 'Before Text', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ah_before_txt_color',
            [
                'label'     => esc_html__( 'Before Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-heading-before-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ah_before_txt_bg_color',
            [
                'label'     => esc_html__( 'Before Text Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-heading-before-text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'ah_before_txt_typo',
                'selector'  => '{{WRAPPER}} .elematic-animated-heading-before-text',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'ah_before_txt_shadow',
                'selector' => '{{WRAPPER}} .elematic-animated-heading-before-text'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'ah_before_txt_border',
                'selector'    =>    '{{WRAPPER}} .elematic-animated-heading-before-text'
            ]
        );
        $this->add_responsive_control(
            'ah_before_txt_padding',
            [
                'label'         => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-heading-before-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ah_before_txt_margin',
            [
                'label'         => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-heading-before-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'elematic_animated_style',
            [
                'label'     => esc_html__( 'Animated Text', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ah_animated_txt_color',
            [
                'label'     => esc_html__( 'Animated Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-txt' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ah_animated_txt_bg_color',
            [
                'label'     => esc_html__( 'Animated Text Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-txt' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'ah_animated_txt_typo',
                'selector'  => '{{WRAPPER}} .elematic-animated-txt',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'ah_animated_txt_shadow',
                'selector' => '{{WRAPPER}} .elematic-animated-txt'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'ah_animated_txt_border',
                'selector'    =>    '{{WRAPPER}} .elematic-animated-txt'
            ]
        );
        $this->add_responsive_control(
            'ah_animated_txt_padding',
            [
                'label'         => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ah_animated_txt_margin',
            [
                'label'         => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-txt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'elematic_after_style',
            [
                'label'     => esc_html__( 'After Text', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ah_after_txt_color',
            [
                'label'     => esc_html__( 'After Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-heading-after-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ah_after_txt_bg_color',
            [
                'label'     => esc_html__( 'After Text Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-animated-heading-after-text' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'ah_after_txt_typo',
                'selector'  => '{{WRAPPER}} .elematic-animated-heading-after-text',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'ah_after_txt_shadow',
                'selector' => '{{WRAPPER}} .elematic-animated-heading-after-text'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'ah_after_txt_border',
                'selector'    =>    '{{WRAPPER}} .elematic-animated-txt'
            ]
        );
        $this->add_responsive_control(
            'ah_after_txt_padding',
            [
                'label'         => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-heading-after-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ah_after_txt_margin',
            [
                'label'         => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-animated-heading-after-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();
        $target = $settings['link_url']['is_external'] ? '_blank' : '_self';
        $id = $this->get_id();
        $animated_txt = explode(",", esc_html($settings['animated_txt']) );

        $this->add_render_attribute( 'animated-txt', 'id', 'elematic-ah-' . $id );
        $this->add_render_attribute( 'animated-txt', 'class', 'elematic-animated-txt' );

        if($settings['txt_style'] == 'typed') :
            $this->add_render_attribute(
                [
                    'animated-heading' => [
                        'data-settings' => [
                            wp_json_encode([
                                'styles'     => $settings['txt_style'],
                                'strings'    => $animated_txt,
                                'typeSpeed'  => $settings['type_speed'],
                                'startDelay' => $settings['start_delay'],
                                'backSpeed'  => $settings['back_speed'],
                                'backDelay'  => $settings['back_delay'],
                                'loop'       => true,
                                'loopCount'  => 'infinity',
                            ])
                        ]
                    ]
                ]
            );
        elseif($settings['txt_style'] == 'animated') :
            $this->add_render_attribute(
                [
                    'animated-heading' => [
                        'data-settings' => [
                            wp_json_encode([
                                'styles'    => $settings['txt_style'],
                                'animation' => $settings['txt_animation'],
                                'speed'     => $settings['speed'],
                            ])
                        ]
                    ]
                ]
            );
        endif;
        ?>

    <div class="elematic-animated-heading-wrap" <?php $this->print_render_attribute_string( 'animated-heading' ); ?> >

        <?php if( !empty($settings['link_url']['url']) ) : ?>

            <a class="elematic-ah-title-link" href="<?php echo esc_url($settings['link_url']['url']); ?>" target="<?php echo esc_attr($target); ?>">
            <<?php echo esc_attr($settings['html_tag']); ?> class="elematic-animated-heading">
                <span class="elematic-animated-heading-before-text"><?php echo esc_html( $settings['before_txt']); ?></span>
                <?php if($settings['txt_style'] == 'animated') : ?>
                <span <?php $this->print_render_attribute_string( 'animated-txt' ); ?>><?php echo esc_html($settings['animated_txt']); ?></span>
                <?php elseif($settings['txt_style'] == 'typed') : ?>
                <span <?php $this->print_render_attribute_string( 'animated-txt' ); ?>></span>
                <?php endif; ?>
                <span class="elematic-animated-heading-after-text"><?php echo esc_html( $settings['after_txt'] ); ?></span>
            </<?php echo esc_attr($settings['html_tag']); ?>>
            </a>

            <?php else: ?>

            <<?php echo esc_attr($settings['html_tag']); ?> class="elematic-animated-heading">
                <span class="elematic-animated-heading-before-text"><?php echo esc_html( $settings['before_txt']); ?></span>
                <?php if($settings['txt_style'] == 'animated') : ?>
                <span <?php $this->print_render_attribute_string( 'animated-txt' ); ?>><?php echo esc_html($settings['animated_txt']); ?></span>
                <?php elseif($settings['txt_style'] == 'typed') : ?>
                <span <?php $this->print_render_attribute_string( 'animated-txt' ); ?>></span>
                <?php endif; ?>
                <span class="elematic-animated-heading-after-text"><?php echo esc_html( $settings['after_txt'] ); ?></span>
            </<?php echo esc_attr($settings['html_tag']); ?>>

        <?php endif; ?>

    </div>



<?php
	}
}
