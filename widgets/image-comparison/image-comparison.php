<?php
namespace Elematic\widgets;
use elementor\Widget_Base;
use elementor\Controls_Manager;
use elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ImageComparison extends Widget_Base {

	public function get_name() {
		return 'elematic-image-comparison';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Image Comparison', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-image-before-after';
	}
    
	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

	public function get_keywords() {
		return [ 'image', 'comparison', 'compare', 'before', 'after', 'difference' ];
	}
    public function get_style_depends() {
        return [ 'elematic-image-comparison' ];
    }
    public function get_script_depends() {
        return [ 'elematic-image-comparison','image-compare-viewer' ];
    }

	protected function register_controls() {
		$this->start_controls_section(
			'ic_image',
			[
				'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
			]
		);
		$this->add_control(
            'before_image',
            [
                'label'   => esc_html__( 'Before Image', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => ELEMATIC_URL . 'assets/images/image-comparison/before.jpg',
                ],
                'dynamic' => [ 'active' => true ],
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'before_img',
                'default' => 'full',
                'condition' => [
                    'before_image[url]!' => '',
                ],
            ]
        );
        $this->add_control(
            'after_image',
            [
                'label'   => esc_html__( 'After Image', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => ELEMATIC_URL . 'assets/images/image-comparison/after.jpg',
                ],
                'dynamic' => [ 'active' => true ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'after_img',
                'default' => 'full',
                'condition' => [
                    'after_image[url]!' => '',
                ],
            ]
        );
         $this->end_controls_section();

        $this->start_controls_section(
            'ic_labels',
            [
                'label' => esc_html__( 'Labels', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'show_labels',
            [
                'label'       => esc_html__( 'Show Labels', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
            ]
        );
        $this->add_control(
            'on_hover',
            [
                'label'       => esc_html__( 'On Hover', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'condition'   => [
                    'show_labels' => 'yes'
                ]
            ]
        );
        $this->add_control(
            'before_label',
            [
                'label'       => esc_html__( 'Before Label', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Before Label', 'elematic-addons-for-elementor' ),
                'default'     => esc_html__( 'Before', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'dynamic'     => [ 'active' => true ],
                'condition'   => [
                    'show_labels' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'after_label',
            [
                'label'       => esc_html__( 'After Label', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'After Label', 'elematic-addons-for-elementor' ),
                'default'     => esc_html__( 'After', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'dynamic'     => [ 'active' => true ],
                'condition'   => [
                    'show_labels' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'ic_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'orientation',
            [
                'label'   => esc_html__( 'Orientation', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal', 'elematic-addons-for-elementor' ),
                    'vertical'   => esc_html__( 'Vertical', 'elematic-addons-for-elementor' ),
                ],
            ]
        );
        $this->add_control(
            'starting_point',
            [
                'label'   => esc_html__( 'Control Line Start (%)', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 40,
                ],
                'range' => [
                    'px' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
            ]
        );
        
        $this->add_control(
            'move_slider_on_hover',
            [
                'label'       => esc_html__( 'Slide on Hover', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'add_circle',
            [
                'label'       => esc_html__( 'Control Line Circle', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'add_circle_blur',
            [
                'label'       => esc_html__( 'Circle Blur', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
                'condition'   => [
                    'add_circle' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'add_circle_shadow',
            [
                'label'       => esc_html__( 'Circle Shadow', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
                'condition'   => [
                    'add_circle' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'smoothing',
            [
                'label'       => esc_html__( 'Smoothing', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::SWITCHER,
                'default'     => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'smoothing_amount',
            [
                'label'   => esc_html__( 'Smoothing Amount', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 400,
                ],
                'range' => [
                    'px' => [
                        'max'  => 1000,
                        'min'  => 100,
                        'step' => 10,
                    ],
                ],
                
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
		$this->add_control(
            'control_line',
            [
                'label'     => esc_html__( 'Control Line Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#fff',
            ]
        );
        $this->add_control(
            'labels_bg_color',
            [
                'label'     => esc_html__( 'Label Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ic-wrap .icv__label.icv__label-before, {{WRAPPER}} .elematic-ic-wrap .icv__label.icv__label-after' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'labels_color',
            [
                'label'     => esc_html__( 'Label Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ic-wrap .icv__label.icv__label-before, {{WRAPPER}} .elematic-ic-wrap .icv__label.icv__label-after' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'labels_typography',
                'label'     => esc_html__( 'Label Typography', 'elematic-addons-for-elementor' ),
                'selector'  => '{{WRAPPER}} .elematic-ic-wrap .icv__label',
            ]
        );
        $this->add_responsive_control(
            'labels_padding',
            [
                'label'      => esc_html__( 'Label Padding', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-ic-wrap .icv__label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'labels_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-ic-wrap .icv__label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
		
        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

        if ($settings['starting_point']['size'] < 1) :
            $settings['starting_point']['size'] = $settings['starting_point']['size'] * 100;
        endif;

        $this->add_render_attribute(
            [
                'elematic-ic-content' => [
                    'id'        => 'elematic-ic-content-' . $this->get_id(),
                    'class'     => [ 'elematic-ic-content' ],
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'id'                    => 'elematic-ic-content-' . $this->get_id(),
                            'starting_point'       => $settings['starting_point']['size'],
                            'orientation'           => ($settings['orientation'] == 'horizontal') ? false : true,
                            'before_label'          => $settings['before_label'],
                            'after_label'           => $settings['after_label'],
                            'show_labels'            => ('yes' == $settings['show_labels']) ? true : false, 
                            'on_hover'              => ('yes' == $settings['on_hover']) ? true : false, 
                            'move_slider_on_hover'  => ('yes' == $settings['move_slider_on_hover']) ? true : false,
                            'add_circle'            => ('yes' == $settings['add_circle']) ? true : false,
                            'add_circle_blur'       => ('yes' == $settings['add_circle_blur']) ? true : false,
                            'add_circle_shadow'     => ('yes' == $settings['add_circle_shadow']) ? true : false,
                            'smoothing'             => ('yes' == $settings['smoothing']) ? true : false,
                            'smoothing_amount'      => $settings['smoothing_amount']['size'],
                            'control_line'          => $settings['control_line'],
                            ])
                        ),
                    ],
                ],
            ]
        );

		?>

		<div class="elematic-ic-wrap">
			<div <?php $this->print_render_attribute_string( 'elematic-ic-content' ); ?>>
                <?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'before_img', 'before_image' ); ?>
                <?php Group_Control_Image_Size::print_attachment_image_html( $settings, 'after_img', 'after_image' ); ?>
            </div><!-- elematic-is-content -->
		</div><!-- elematic-is-wrap -->
		
<?php }

}
