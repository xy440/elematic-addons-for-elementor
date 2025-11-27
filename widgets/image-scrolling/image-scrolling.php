<?php
namespace Elematic\widgets;
use elementor\Widget_Base;
use elementor\Controls_Manager;
use elementor\Group_Control_Border;
use elementor\Group_Control_Typography;
use elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ImageScrolling extends Widget_Base {

	public function get_name() {
		return 'elematic-image-scrolling';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Image Scrolling', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

    public function get_style_depends() {
        return [ 'elematic-image-scrolling' ];
    }

	public function get_keywords() {
		return [ 'image', 'scrolling', 'scroll' ];
	}
	protected function register_controls() {
		$this->start_controls_section(
			'is_settings',
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
            'is_img_size',
            [
                'label'   => esc_html__( 'Image Height', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 400,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 1200,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-is-container, {{WRAPPER}} .elematic-is-wrap .elematic-is-container img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'is_img_speed',
            [
                'label'   => esc_html__( 'Srolling Speed(in seconds)', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 5,
                ],
                'range' => [
                    'px' => [
                        'max'  => 20,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-is-wrap .elematic-is-container img' => '-webkit-transition: {{SIZE}}s all linear;transition: {{SIZE}}s all linear;',
                ],
            ]
        );
		$this->add_control(
			'is_link_url',
			[
				'label'       => esc_html__( 'Link URL', 'elematic-addons-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'https://your-link.com',

			]
		);
		$this->add_control(
			'caption',
			[
				'label' => esc_html__( 'Caption', 'elematic-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter Image caption', 'elematic-addons-for-elementor' ),
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
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
                'default' => 'center',
                'toggle' => false,
                'selectors'         => [
                    '{{WRAPPER}} .elematic-is-caption'   => 'text-align: {{VALUE}};',
                ],
                'separator' => 'before'
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
		$this->start_controls_tabs( 'btn_tabs' );

		$this->start_controls_tab(
			'btn_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
			]
		);
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'is_border',
                'selector'    =>    '{{WRAPPER}} .elematic-is-wrap'
            ]
        );
        $this->add_responsive_control(
            'is_border_radius',
            [
                'label'         => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-is-wrap, {{WRAPPER}} .elematic-is-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'is_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-is-wrap',
                'separator' => '',
            ]
        );
        $this->add_control(
            'caption_color',
            [
                'label'     => esc_html__( 'Caption Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-is-caption' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'caption_color_hover',
            [
                'label'     => esc_html__( 'Caption Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-is-container:hover .elematic-is-caption' => 'color: {{VALUE}};',
                ],
            ]
        );
         $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'caption_typography',
				'selector' => '{{WRAPPER}} .elematic-is-caption',
			]
		);
        $this->add_responsive_control(
            'caption_padding',
            [
                'label'         => esc_html__( 'Caption Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-is-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector'    =>    '{{WRAPPER}} .elematic-is-wrap:hover'
            ]
        );
		$this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'is_hov_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-is-wrap:hover',
                'separator' => '',
            ]
        );
		$this->end_controls_tab();
        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$link = $settings['is_link_url']['url'];
		$target = $settings['is_link_url']['is_external'] ? '_blank' : '_self';
		$this->add_render_attribute( 'link', 'href', esc_url($link) );
		?>

		<div class="elematic-is-wrap">
			<div class="elematic-is-container">
				<?php if ( ''!== $link ) : ?>
					<a <?php $this->print_render_attribute_string( 'link' ); ?> target="<?php echo esc_attr($target); ?>">
						<?php Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>
						<div class="elematic-is-caption"><?php echo esc_html( $settings['caption'] ); ?></div>
					</a>
				<?php else: ?>
					<?php Group_Control_Image_Size::print_attachment_image_html( $settings ); ?>
					<div class="elematic-is-caption"><?php echo esc_html( $settings['caption'] ); ?></div>
				<?php endif; ?>
			</div><!-- elematic-is-container -->
		</div><!-- elematic-is-wrap -->
		
<?php }

}
