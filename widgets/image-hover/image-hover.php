<?php
namespace Elematic\Widgets;
use elementor\Widget_Base;
use elementor\Controls_Manager;
use elementor\Group_Control_Border;
use elementor\Group_Control_Typography;
use elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ImageHover extends Widget_Base {

	public function get_name() {
		return 'elematic-image-hover';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Image Hover', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}
	public function get_style_depends() {
        return [ 'elematic-image-hover' ];
    }
	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'image', 'hover' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'ih_settings',
			[
				'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
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
            'ih_img_size',
            [
                'label'   => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
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
                    '{{WRAPPER}} .elematic-ih-wrap, {{WRAPPER}} .elematic-ih-wrap img'   => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
		$this->add_control(
			'ih_effect',
			[
				'label' => esc_html__( 'Effects', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'effect-1'  => esc_html__( 'Effect 1', 'elematic-addons-for-elementor' ),
					'effect-2'  => esc_html__( 'Effect 2', 'elematic-addons-for-elementor' ),
					'effect-3'  => esc_html__( 'Effect 3', 'elematic-addons-for-elementor' ),
					'effect-4'  => esc_html__( 'Effect 4', 'elematic-addons-for-elementor' ),
					'effect-5'  => esc_html__( 'Effect 5', 'elematic-addons-for-elementor' ),
					'effect-6'  => esc_html__( 'Effect 6', 'elematic-addons-for-elementor' ),
					'effect-7'  => esc_html__( 'Effect 7', 'elematic-addons-for-elementor' ),
					'effect-8'  => esc_html__( 'Effect 8', 'elematic-addons-for-elementor' ),
					'effect-9'  => esc_html__( 'Effect 9', 'elematic-addons-for-elementor' ),
					'effect-10' => esc_html__( 'Effect 10', 'elematic-addons-for-elementor' ),
					'effect-11' => esc_html__( 'Effect 11', 'elematic-addons-for-elementor' ),
					'effect-12' => esc_html__( 'Effect 12', 'elematic-addons-for-elementor' ),
					'effect-13' => esc_html__( 'Effect 13', 'elematic-addons-for-elementor' ),
					'effect-14' => esc_html__( 'Effect 14', 'elematic-addons-for-elementor' ),
					'effect-15' => esc_html__( 'Effect 15', 'elematic-addons-for-elementor' ),
					'effect-16' => esc_html__( 'Effect 16', 'elematic-addons-for-elementor' ),
					'effect-17' => esc_html__( 'Effect 17', 'elematic-addons-for-elementor' ),
					'effect-18' => esc_html__( 'Effect 18', 'elematic-addons-for-elementor' ),
					'effect-19' => esc_html__( 'Effect 19', 'elematic-addons-for-elementor' ),
					'effect-20' => esc_html__( 'Effect 20', 'elematic-addons-for-elementor' ),
					'effect-21' => esc_html__( 'Effect 21', 'elematic-addons-for-elementor' ),
					'effect-22' => esc_html__( 'Effect 22', 'elematic-addons-for-elementor' ),
					'effect-23' => esc_html__( 'Effect 23', 'elematic-addons-for-elementor' ),
					'effect-24' => esc_html__( 'Effect 24', 'elematic-addons-for-elementor' ),
					'effect-25' => esc_html__( 'Effect 25', 'elematic-addons-for-elementor' ),
					'effect-26' => esc_html__( 'Effect 26', 'elematic-addons-for-elementor' ),
					'effect-27' => esc_html__( 'Effect 27', 'elematic-addons-for-elementor' ),
					'effect-28' => esc_html__( 'Effect 28', 'elematic-addons-for-elementor' ),
					'effect-29' => esc_html__( 'Effect 29', 'elematic-addons-for-elementor' ),
					'effect-30' => esc_html__( 'Effect 30', 'elematic-addons-for-elementor' ),
					'effect-31' => esc_html__( 'Effect 31', 'elematic-addons-for-elementor' ),
					'effect-32' => esc_html__( 'Effect 32', 'elematic-addons-for-elementor' ),
				],
				'default' => 'effect-1',
			]
		);
		$this->add_control(
			'ih_title',
			[
				'label'   => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'This is the title', 'elematic-addons-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
            'ih_html_tag',
            [
                'label'     => esc_html__( 'HTML Tag', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'h4',
                'options'   => [
                        'h1'    => 'H1',
                        'h2'    => 'H2',
                        'h3'    => 'H3',
                        'h4'    => 'H4',
                        'h5'    => 'H5',
                        'h6'    => 'H6',
                        'div'   => 'div',
                        'span'  => 'Span',
                        'p'     => 'P'
                    ],
            ]
        );
		$this->add_control(
			'ih_link',
			[
				'label'        => esc_html__( 'Title Link', 'elematic-addons-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
			]
		);
		$this->add_control(
			'ih_link_url',
			[
				'label'       => esc_html__( 'Title Link URL', 'elematic-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'condition'   => [
				 'ih_link' => 'yes'
				]
			]
		);
		$this->add_control(
			'ih_desc',
			[
				'label'   => esc_html__( 'Description', 'elematic-addons-for-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'Suspendisse potenti Phasellus euismod libero in neque molestie et mentum libero maximus. Etiam in enim vestibulum suscipit sem quis.', 'elematic-addons-for-elementor' ),
				'placeholder' => esc_html__( 'Enter your description', 'elematic-addons-for-elementor' ),
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
            'ih_styles',
            [
                'label'                 => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'ih_background',
				'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
				'selector' => '{{WRAPPER}} .elematic-ih-wrap.effect-1:before, {{WRAPPER}} .elematic-ih-wrap.effect-2:before, {{WRAPPER}} .elematic-ih-wrap.effect-3:hover:before, {{WRAPPER}} .elematic-ih-wrap.effect-4:hover, {{WRAPPER}} .elematic-ih-wrap.effect-5:before, {{WRAPPER}} .elematic-ih-wrap.effect-5:after, {{WRAPPER}} .elematic-ih-wrap.effect-5 .elematic-ih-content:before, {{WRAPPER}} .elematic-ih-wrap.effect-5 .elematic-ih-content:after, {{WRAPPER}} .elematic-ih-wrap.effect-6:before, {{WRAPPER}} .elematic-ih-wrap.effect-7:before, {{WRAPPER}} .elematic-ih-wrap.effect-8:before, {{WRAPPER}} .elematic-ih-wrap.effect-8, {{WRAPPER}} .elematic-ih-wrap.effect-9 .elematic-ih-content, {{WRAPPER}} .elematic-ih-wrap.effect-10:before, {{WRAPPER}} .elematic-ih-wrap.effect-10:after, {{WRAPPER}} .elematic-ih-wrap.effect-10 .elematic-ih-content:before, {{WRAPPER}} .elematic-ih-wrap.effect-10 .elematic-ih-content:after, {{WRAPPER}} .elematic-ih-wrap.effect-11:before, {{WRAPPER}} .elematic-ih-wrap.effect-11:after,{{WRAPPER}} .elematic-ih-wrap.effect-12:hover .elematic-ih-content,{{WRAPPER}} .elematic-ih-wrap.effect-15,{{WRAPPER}} .elematic-ih-wrap.effect-21,{{WRAPPER}} .elematic-ih-wrap.effect-23,{{WRAPPER}} .elematic-ih-wrap.effect-25,{{WRAPPER}} .elematic-ih-wrap.effect-26,{{WRAPPER}} .elematic-ih-wrap.effect-27,{{WRAPPER}} .elematic-ih-wrap.effect-28,{{WRAPPER}} .elematic-ih-wrap.effect-29,{{WRAPPER}} .elematic-ih-wrap.effect-30 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-31,{{WRAPPER}} .elematic-ih-wrap.effect-32',
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'ih_img_border',
                'selector'    =>    '{{WRAPPER}} .elematic-ih-wrap'
            ]
        );
        $this->add_responsive_control(
            'ih_img_border_radius',
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
                    '{{WRAPPER}} .elematic-ih-wrap'   => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'ih_line_color',
            [
                'label'     => esc_html__( 'Line / Border Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ih-wrap.effect-3 .elematic-ih-title:after,{{WRAPPER}} .elematic-ih-wrap.effect-4:before,{{WRAPPER}} .elematic-ih-wrap.effect-4:after,{{WRAPPER}} .elematic-ih-wrap.effect-4 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-4 .elematic-ih-content:after,{{WRAPPER}} .elematic-ih-wrap.effect-16 .elematic-ih-title:after,{{WRAPPER}} .elematic-ih-wrap.effect-20 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-20 .elematic-ih-content:after,{{WRAPPER}} .elematic-ih-wrap.effect-28 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-28 .elematic-ih-desc' => 'background: {{VALUE}};',

                    '{{WRAPPER}} .elematic-ih-wrap.effect-11:hover .elematic-ih-content:before, {{WRAPPER}} .elematic-ih-wrap.effect-11:hover .elematic-ih-content:after, {{WRAPPER}} .elematic-ih-wrap.effect-12:hover .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-14 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-14 .elematic-ih-content:after,{{WRAPPER}} .elematic-ih-wrap.effect-15 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-17 .elematic-ih-desc,{{WRAPPER}} .elematic-ih-wrap.effect-18 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-19 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-19 .elematic-ih-content:after,{{WRAPPER}} .elematic-ih-wrap.effect-21 .elematic-ih-content:after,{{WRAPPER}} .elematic-ih-wrap.effect-22 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-23 .elematic-ih-desc,{{WRAPPER}} .elematic-ih-wrap.effect-27 .elematic-ih-desc,{{WRAPPER}} .elematic-ih-wrap.effect-29 .elematic-ih-content:after,{{WRAPPER}} .elematic-ih-wrap.effect-30 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-31 .elematic-ih-content:before,{{WRAPPER}} .elematic-ih-wrap.effect-32 .elematic-ih-desc' => 'border-color: {{VALUE}};',
                ],
			    'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-3'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-4'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-11'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-12'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-14'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-15'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-16'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-17'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-18'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-19'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-20'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-21'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-22'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-23'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-27'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-28'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-29'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-30'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-31'],
							]
						],
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-32'],
							]
						],
					]
				],

            ]
        );
		$this->add_control(
            'ih_title_color',
            [
                'label'     => esc_html__( 'Title Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ih-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'ih_title_hov_color',
            [
                'label'     => esc_html__( 'Title Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ih-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ih_title_bg_color',
            [
                'label'     => esc_html__( 'Title Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ih-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'ih_title_typo',
                'selector'  => '{{WRAPPER}} .elematic-ih-title',
            ]
        );
        $this->add_responsive_control(
            'ih_title_padding',
            [
                'label'         => esc_html__( 'Title Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-ih-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'ih_desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ih-desc' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'ih_desc_bg_color',
            [
                'label'     => esc_html__( 'Description Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ih-desc' => 'background: {{VALUE}};',
                ],
                'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'terms' => [
								['name' => 'ih_effect', 'operator' => '===', 'value' => 'effect-24'],
							]
						],
					]
				],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'ih_desc_typo',
                'selector'  => '{{WRAPPER}} .elematic-ih-desc>*',
            ]
        );
        $this->add_responsive_control(
            'ih_desc_padding',
            [
                'label'         => esc_html__( 'Description Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-ih-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings();
		if ( empty( $settings['image']['url'] ) ) {
			return;
		}
		// $this->add_render_attribute( 'image', 'src', $settings['ih_image']['url'] );
		$target = $settings['ih_link_url']['is_external'] ? '_blank' : '_self';


		?>	
		<div class="elematic-ih-wrap <?php echo esc_attr( $settings['ih_effect'] ); ?>">
			
            <?php Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>
			
            <div class="elematic-ih-content">
            	<div class="elematic-ih-inner-content">
		            <div class="elematic-ih-title-wrap">
			            <?php if($settings['ih_link'] == 'yes') : ?>
			            <a class="elematic-ih-title-link" href="<?php echo esc_url($settings['ih_link_url']['url']); ?>" target="<?php echo esc_attr($target); ?>">
						<<?php echo esc_attr( $settings['ih_html_tag'] ); ?> class="elematic-ih-title"><?php echo esc_html( $settings['ih_title'] ); ?></<?php echo esc_attr( $settings['ih_html_tag'] ); ?>>
						</a>
						<?php else : ?>
						<<?php echo esc_attr( $settings['ih_html_tag'] ); ?> class="elematic-ih-title"><?php echo esc_html( $settings['ih_title'] ); ?></<?php echo esc_attr( $settings['ih_html_tag'] ); ?>>
						<?php endif; ?>
					</div><!-- elematic-ih-title-wrap -->
					<div class="elematic-ih-desc">
						<?php echo wp_kses_post( $settings['ih_desc'] ); ?>
					</div>
				</div><!-- elematic-ih-inner-content -->
			</div><!-- elematic-ih-content-wrap -->
			
		</div><!-- elematic-ih-wrap -->
		
<?php }

}
