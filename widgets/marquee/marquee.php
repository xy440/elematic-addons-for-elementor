<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Marquee extends Widget_Base {

    public function get_name() {
        return 'elematic-marquee';
    }

    public function get_title() {
       return ELEMATIC . esc_html__( 'Marquee', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-carousel';
    }
    public function get_keywords() {
        return [ 'marquee','scroll', 'text', 'scroll text', 'animation'];
    }
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }
    public function get_style_depends() {
        return [ 'elematic-marquee' ];
    }
	protected function register_controls() {
        $this->start_controls_section(
            'marq_settings',
            [
                'label' => esc_html__('Settings', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'title_tags',
            [
                'label'   => esc_html__('Title HTML Tag', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => Helper::elematic_html_tags(),
            ]
        );
        $this->add_responsive_control(
            'animation_play_state',
            [
                'label'   => esc_html__('Animation', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'running',
                'options' => [
                    'running'    => esc_html__('Start', 'elematic-addons-for-elementor'),
                    'paused'   => esc_html__('Stop', 'elematic-addons-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-content' => 'animation-play-state: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'stop_on_hover',
            [
                'label'   => esc_html__('Stop on hover', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'paused',
                'options' => [
                    'running'    => esc_html__('No', 'elematic-addons-for-elementor'),
                    'paused'   => esc_html__('Yes', 'elematic-addons-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-wrap:hover .elematic-marquee-content' => 'animation-play-state: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'animation_direction',
            [
                'label'   => esc_html__('Direction', 'elematic-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal'    => esc_html__('Normal', 'elematic-addons-for-elementor'),
                    'reverse'   => esc_html__('Reverse', 'elematic-addons-for-elementor'),
                    'alternate'   => esc_html__('Alternate', 'elematic-addons-for-elementor'),
                    'alternate-reverse'   => esc_html__('Alternate Reverse', 'elematic-addons-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-content' => 'animation-direction: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'animation_speed',
            [
                'label' => esc_html__( 'Speed', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_unit' => [ 's' ],        
                'range' => [
                    's' => [
                        'step' => 1,
                        'max' => 300,
                    ],

                ],
                'default' => [
                    'unit' => 's',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-content' => 'animation-duration: {{SIZE}}{{UNIT}};',
                ],       

            ]
        );
        $this->end_controls_section();
		$this->start_controls_section(
            'marq_repeater',
            [
                'label' => esc_html__( 'Marquee', 'elematic-addons-for-elementor' )
            ]
        );
       
        $repeater = new Repeater();

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
            'marq_icon',
            [
                'label'   => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
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
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'full',
                'condition' => [
                    'select_type' => 'image'
                ]
            ]
        );
        $repeater->add_control(
            'marq_title', [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'marquee' , 'elematic-addons-for-elementor' ),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'marq_title_link',
            [
                'label'       => esc_html__('Button Link', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => ['active' => true],
                'placeholder' => 'http://your-link.com',
            ]
        );

        $this->add_control(
            'marquee',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'marq_title'      => esc_html('Nail Gel Refill' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Acrylic Nail Extension' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Natural Nail Gel' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Different Nail Art' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Manicure Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Pedicure Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Hair Oil Massage' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Hair extension Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Hair Gloss' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Different Facial Service' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Face Bleaching' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Cleansing' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Skin Treatment' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Waxing' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Oil Massage' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Threading' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyebrow Tint' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyebrow Microblading' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyelash Extension' ),
                    ],
                    [
                        'marq_title'      => esc_html( 'Eyelash Tint' ),
                    ],
   


                ],
                'title_field' => '{{{ marq_title }}}',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'marq_style',
            [
                'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );
        $this->add_control(
            'marq_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-item *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'marq_text_hov_color',
            [
                'label'     => esc_html__( 'Text Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-item:hover *' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'marq_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-item .elematic-marquee-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-marquee-item .elematic-marquee-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'marq_icon_img_size',
            [
                'label' => esc_html__( 'Icon / Image Size', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-item .elematic-marquee-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-marquee-item .elematic-marquee-icon img, {{WRAPPER}} .elematic-marquee-item .elematic-marquee-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
             'name' => 'marq_title_typography',
             'label' => esc_html__( 'Typography', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-marquee-item *',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name' => 'text_stroke',
                'selector' => '{{WRAPPER}} .elematic-marquee-item *',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .elematic-marquee-item *',
            ]
        );
        $this->add_responsive_control(
            'marq_icon_margin',
            [
                'label' => esc_html__( 'Icon Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                // 'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-marquee-item .elematic-marquee-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
       
        $this->end_controls_section();
    }

	protected function render() {
		$settings = $this->get_settings_for_display();
        
    ?>

<div class="elematic-marquee-wrap">
    <div class="elematic-marquee-content">
    <?php foreach ($settings['marquee'] as $marquee) {
            $this->add_render_attribute('elematic-marquee', 'class', 'elematic-marquee-item', true);
            $this->add_render_attribute(
                        [
                            'elematic-marquee-link' => [
                                'class' => [
                                    'elematic-marquee-link',
                                ],
                                'href'   => isset($marquee['marq_title_link']['url']) ? esc_url($marquee['marq_title_link']['url']) : '',
                                'target' => $marquee['marq_title_link']['is_external'] ? '_blank' : '_self'
                            ]
                        ],
                        '',
                        '',
                        true
                    );
          
    ?>     
        <div <?php $this->print_render_attribute_string('elematic-marquee'); ?>>

            <?php if ( !empty( $marquee['marq_title_link']['url'] ) ): ?>
                    <a <?php $this->print_render_attribute_string('elematic-marquee-link'); ?>>

                        <?php helper::elematic_render_heading( $settings['title_tags'], $marquee['marq_title'] ); ?>

                        <?php if ( 'icon' === $marquee['select_type'] ) : ?>
                          <span class="elematic-marquee-icon">
                             <?php Icons_Manager::render_icon( $marquee['marq_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                          </span>
                        <?php endif; ?>

                        <?php if ( 'image' === $marquee['select_type'] ) : ?>
                          <span class="elematic-marquee-icon">
                            <?php Group_Control_Image_Size::print_attachment_image_html( $marquee, 'image', 'image' ); ?>
                          </span>
                        <?php endif; ?>

                    </a>

            <?php else: ?>

                <?php helper::elematic_render_heading( $settings['title_tags'], $marquee['marq_title'] ); ?>

                <?php if ( 'icon' === $marquee['select_type'] ) : ?>
                  <span class="elematic-marquee-icon">
                     <?php Icons_Manager::render_icon( $marquee['marq_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                  </span>
                <?php endif; ?>
                
                <?php if ( 'image' === $marquee['select_type'] ) : ?>
                  <span class="elematic-marquee-icon">
                    <?php Group_Control_Image_Size::print_attachment_image_html( $marquee, 'image', 'image' ); ?>
                  </span>
                <?php endif; ?>

            <?php endif; ?>

        </div><!-- elematic-marquee-item -->

    <?php } ?>

    </div><!-- elematic-marquee-container -->
</div><!-- elematic-marquee-wrap -->    


<?php	} // render()
} // class 
