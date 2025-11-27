<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ImageSlide extends Widget_Base {

	public function get_name() {
		return 'elematic-image-slide';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Image Slide', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-carousel';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'image', 'scrolling', 'scroll', 'gallery', 'slide', 'infinite', 'scroller', 'carousel' ];
	}
    public function get_style_depends() {
        return [ 'elematic-image-slide' ];
    }
    public function get_script_depends() {
        return [ 'infiniteslidev2','elematic-image-slide' ];
    }
	protected function register_controls() {
		$this->start_controls_section(
			'is_settings',
			[
				'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
			]
		);

        $repeater = new Repeater();

        $repeater->add_control(
            'is_image',
            [
                'label_block' => true,
                'label' => esc_html__('Image.', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => ELEMATIC_URL . '/assets/images/image-slide.jpg',
                ],
            ]

        );
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'medium',
            ]
        );
        $repeater->add_control(
            'is_title', 
            [
                'label' => esc_html__('Caption', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic'     => [ 'active' => true ],
            ]
        );
        $repeater->add_control(
            'is_title_link',
            [
                'label' => esc_html__('Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-site.com',
            ]
        );

        $this->add_control(
            'is_images',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-1.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-2.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-3.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-4.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-5.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-6.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-7.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-8.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-9.jpg' ],
                    ],
                    [
                        'is_title' => '',
                        'is_image' => [ 'url' => ELEMATIC_URL . 'assets/images/image-slide/image-slide-10.jpg' ],
                    ],
                ],

                'title_field' => '{{{is_title}}}',
            ]
        );
		$this->add_responsive_control(
            'is_img_width',
            [
                'label'   => esc_html__( 'Image Width', 'elematic-addons-for-elementor' ),
                'description'   => esc_html__( 'If you do not have same width for all images then adjust width and set the height empty.', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'range' => [
                    'px' => [
                        'max'  => 2000,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-slide-container img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'is_img_height',
            [
                'label'   => esc_html__( 'Image Height', 'elematic-addons-for-elementor' ),
                'description'   => esc_html__( 'If you do not have same height for all images then adjust height and set the width empty.', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                   
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 1200,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-slide-container img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'is_img_margin',
            [
                'label'         => esc_html__( 'Image Margin', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-image-slide-container img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'direction',
            [
                'label' => esc_html__( 'Direction', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                    'right' => esc_html__( 'Right',   'elematic-addons-for-elementor' ),
                    'up' => esc_html__( 'Up',   'elematic-addons-for-elementor' ),
                    'down' => esc_html__( 'Down',   'elematic-addons-for-elementor' ),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
    'container_height',
    [
        'label' => esc_html__( 'Widget Height (for Up/Down)', 'elematic-addons-for-elementor' ),
        'type'  => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 100,
                'max' => 1200,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .elematic-image-slide-viewport' => 'height: {{SIZE}}{{UNIT}}; overflow:hidden;',
        ],
        'condition' => [
            'direction' => ['up','down'],
        ],
    ]
);
        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
                'step'    => 50,
            ]
        );
        $this->add_control(
            'clone',
            [
                'label' => esc_html__('Clone', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
            ]
        );
        $this->add_control(
            'pauseonhover',
            [
                'label' => esc_html__( 'Pause on hover', 'elematic-addons-for-elementor' ),
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
                'toggle' => false,
             ]
        );
        $this->add_control(
            'elematic_masking',
            [
                'label' => esc_html__('Masking?', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}}' => 'mask-image: linear-gradient(to right,transparent 8%,#000 30%,#000 70%,transparent 96%);',
                ],
            ]
        );
        $this->add_control(
            'elematic_masking_bottom',
            [
                'label' => esc_html__('Masking Vertical?', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}}' => 'mask-image: linear-gradient(to bottom,transparent 8%,#000 30%,#000 70%,transparent 96%);',
                ],
                'condition' => [
                    'direction' => [ 'up', 'down' ],
                    'elematic_masking' => 'yes'
                ]
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
            'is_styles',
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
            'is_img_overlay',
            [
                'label'     => esc_html__( 'Overlay Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-slide-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'is_border',
                'selector'    =>    '{{WRAPPER}} .elematic-image-slide-container'
            ]
        );
        $this->add_responsive_control(
            'is_border_radius',
            [
                'label'   => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-slide-container, {{WRAPPER}} .elematic-image-slide-container img'   => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'is_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-image-slide-container',
                'separator' => '',
            ]
        );
        $this->add_control(
            'caption_bg_color',
            [
                'label'     => esc_html__( 'Caption Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-slide-title' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'caption_color',
            [
                'label'     => esc_html__( 'Caption Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-slide-title' => 'color: {{VALUE}};',
                ],
                
            ]
        );
        
        $this->add_control(
            'caption_color_hover',
            [
                'label'     => esc_html__( 'Caption Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-image-slide-container:hover .elematic-image-slide-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
    			Group_Control_Typography::get_type(),
    			[
                 'name' => 'caption_typography',
    				'selector' => '{{WRAPPER}} .elematic-image-slide-title',
    			]
    		);
        $this->add_responsive_control(
            'caption_padding',
            [
                'label'         => esc_html__( 'Caption Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-image-slide-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
    		$this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'        => 'is_hov_border',
                    'selector'    =>    '{{WRAPPER}} .elematic-image-slide-container:hover'
                ]
            );
    		$this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'is_hov_box_shadow',
                    'selector' => '{{WRAPPER}} .elematic-image-slide-container:hover',
                    'separator' => '',
                ]
            );
		    $this->end_controls_tab();
        $this->end_controls_section();
	}

	protected function render() {
    $settings = $this->get_settings_for_display();

    // Guard: nothing to render
    if ( empty( $settings['is_images'] ) || ! is_array( $settings['is_images'] ) ) {
        return;
    }

    // Data attributes for JS (JSON string is the attribute value)
    $data = [
        'direction'     => $settings['direction'] ?? 'left',
        'speed'         => isset( $settings['speed'] ) ? absint( $settings['speed'] ) : 100,
        'clone'         => isset( $settings['clone'] ) ? absint( $settings['clone'] ) : 1,
        'pauseonhover'  => ( isset( $settings['pauseonhover'] ) && 'yes' === $settings['pauseonhover'] ),
    ];

    $this->add_render_attribute( 'elematic-image-slide', 'class', 'elematic-image-slide-wrap' );
    $this->add_render_attribute( 'elematic-image-slide', 'data-settings', wp_json_encode( $data ) );
    ?>

    <!-- ✅ Viewport wrapper: controls visible height -->
    <div class="elematic-image-slide-viewport">
        <div <?php $this->print_render_attribute_string( 'elematic-image-slide' ); ?>>
            <?php foreach ( $settings['is_images'] as $slide ) :
                $link = $slide['is_title_link'] ?? [];
                $url  = isset( $link['url'] ) ? esc_url( $link['url'] ) : '';
                $target   = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
                $nofollow = ! empty( $link['nofollow'] ) ? ' rel="nofollow noopener noreferrer"' : ( $target ? ' rel="noopener noreferrer"' : '' );

                $caption = isset( $slide['is_title'] ) ? $slide['is_title'] : '';
                $alt     = $caption ? esc_attr( $caption ) : '';
                ?>
                <div class="elematic-image-slide-container">
                    <?php if ( $url ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>"<?php echo esc_attr($target . $nofollow); ?>>
                            <?php Group_Control_Image_Size::print_attachment_image_html(
                                $slide,
                                'image_size',
                                'is_image',
                                [ 'alt' => $alt, 'loading' => 'lazy' ]
                            ); ?>
                            <span class="elematic-image-slide-overlay" aria-hidden="true"></span>
                            <?php if ( $caption ) : ?>
                                <h3 class="elematic-image-slide-title"><?php echo esc_html( $caption ); ?></h3>
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <?php Group_Control_Image_Size::print_attachment_image_html(
                            $slide,
                            'image_size',
                            'is_image',
                            [ 'alt' => $alt, 'loading' => 'lazy' ]
                        ); ?>
                        <span class="elematic-image-slide-overlay" aria-hidden="true"></span>
                        <?php if ( $caption ) : ?>
                            <h3 class="elematic-image-slide-title"><?php echo esc_html( $caption ); ?></h3>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
}