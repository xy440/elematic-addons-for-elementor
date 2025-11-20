<?php
namespace Elematic\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AnimatedShape extends Widget_Base {

    public function get_name() {
        return 'elematic-animated-shape';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Animated Shape', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-shape';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_style_depends() {
        return [ 'elematic-animated-shape' ];
    }

    protected function register_controls() {
        // Content
        $this->start_controls_section( 'section_content', [
            'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
        ] );

        $this->add_control( 'image', [
            'label'   => esc_html__( 'Shape Image', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ] );

        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'    => 'image_size',
            'default' => 'large',
        ] );

        $this->add_control( 'animation_style', [
            'label'   => esc_html__( 'Animation Style', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'style_1',
            'options' => [
                'style_1' => esc_html__( 'Style 1', 'elematic-addons-for-elementor' ),
                'style_2' => esc_html__( 'Style 2', 'elematic-addons-for-elementor' ),
                'style_3' => esc_html__( 'Style 3', 'elematic-addons-for-elementor' ),
                'style_4' => esc_html__( 'Style 4', 'elematic-addons-for-elementor' ),
                'style_5' => esc_html__( 'Style 5', 'elematic-addons-for-elementor' ),
                'style_6' => esc_html__( 'Style 6', 'elematic-addons-for-elementor' ),
                'style_7' => esc_html__( 'Style 7', 'elematic-addons-for-elementor' ),
                'style_8' => esc_html__( 'Style 8', 'elematic-addons-for-elementor' ),
            ],
        ] );
        
        $this->add_responsive_control( 'alignment', [
            'label'     => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [ 'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),   'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),  'icon' => 'eicon-text-align-right' ],
            ],
            'toggle'         => false,
            'default'        => 'center',
            'selectors'      => [
                '{{WRAPPER}} .elematic-animated-shape-image' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();

        // Style
        $this->start_controls_section( 'section_style', [
            'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        

        $this->start_controls_tabs( 'tabs_effects' );

            $this->start_controls_tab( 'tab_normal', [ 'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ) ] );

                $this->add_control( 'opacity', [
                    'label'     => esc_html__( 'Opacity', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [ 'px' => [ 'min'=>0, 'max'=>1, 'step'=>0.05 ] ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-animated-shape-image img' => 'opacity: {{SIZE}};',
                    ],
                ] );

                $this->add_group_control( Group_Control_Css_Filter::get_type(), [
                    'name'     => 'css_filters',
                    'selector' => '{{WRAPPER}} .elematic-animated-shape-image img',
                ] );

            $this->end_controls_tab();

            $this->start_controls_tab( 'tab_hover', [ 'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ) ] );

                $this->add_control( 'opacity_hover', [
                    'label'     => esc_html__( 'Opacity (Hover)', 'elematic-addons-for-elementor' ),
                    'type'      => Controls_Manager::SLIDER,
                    'range'     => [ 'px' => [ 'min'=>0, 'max'=>1, 'step'=>0.05 ] ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-animated-shape-image:hover img' => 'opacity: {{SIZE}};',
                    ],
                ] );

                $this->add_group_control( Group_Control_Css_Filter::get_type(), [
                    'name'     => 'css_filters_hover',
                    'selector' => '{{WRAPPER}} .elematic-animated-shape-image:hover img',
                ] );

            $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $image_src = ! empty( $s['image']['url'] ) ? esc_url( $s['image']['url'] ) : Utils::get_placeholder_image_src();
        $size_attr = Group_Control_Image_Size::get_attachment_image_html( $s, 'image_size', 'image' );

        ?>
        <div class="elematic-animated-shape">
            <div class="elematic-animated-shape-image <?php echo esc_attr( $s['animation_style'] ); ?>">
                <?php 
                // Print the IMG tag with size from Group_Control_Image_Size:
                echo wp_kses(
					$size_attr,
					array(
						'img' => array(
							'src'    => true,
							'alt'    => true,
							'class'  => true,
							'id'     => true,
							'width'  => true,
							'height' => true,
							'srcset' => true,
							'sizes'  => true,
						),
					)
				);
                ?>
            </div>
        </div>
        <?php
    }
}