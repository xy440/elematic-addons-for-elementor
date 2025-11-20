<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;

class CircleText extends Widget_Base {

    public function get_name() {
        return 'elematic-circle-text';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Circle Text', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-circle';
    }

    public function get_style_depends() {
        return [ 'elematic-circle-text' ];
    }

    public function get_script_depends() {
        return [ 'elematic-circle-text' ];
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_keywords() {
        return [ 'circle', 'text', 'rotate', 'logo' ];
    }

    protected function register_controls() {

        // Content Controls
        $this->start_controls_section('content_section', [
            'label' => esc_html__('Content', 'elematic-addons-for-elementor'),
        ]);

        $this->add_control('elematic_circle_text', [
            'label'   => esc_html__('Text', 'elematic-addons-for-elementor'),
            'type'    => Controls_Manager::TEXTAREA,
            'dynamic' => ['active' => true],
            'default' => 'Some Text - Animated Circle Text -',
        ]);

        $this->add_control('elematic_circle_text_html_tag', [
            'label'   => esc_html__('HTML Tag', 'elematic-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'p',
            'options' => Helper::elematic_html_tags(),
        ]);

        $this->add_control('elematic_circle_text_image', [
            'label'   => esc_html__('Image', 'elematic-addons-for-elementor'),
            'type'    => Controls_Manager::MEDIA,
            'default' => ['url' => Utils::get_placeholder_image_src()],
        ]);

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'elematic_circle_text_image',
                'default' => 'thumbnail',
                'condition' => [
                    'elematic_circle_text_image[url]!' => '',
                ],
            ]
        );

        $this->add_control('elematic_ct_circle_size', [
            'label' => esc_html__('Circle Size (px)', 'elematic-addons-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 100,
                    'max' => 600,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 200,
            ],
        ]);

        $this->add_control('elematic_ct_animation_speed', [
            'label' => esc_html__('Rotation Speed (sec)', 'elematic-addons-for-elementor'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 60,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 15,
            ],
        ]);

        $this->add_control('elematic_ct_rotate_direction', [
            'label'   => esc_html__('Rotation Direction', 'elematic-addons-for-elementor'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'normal',
            'options' => [
                'normal'  => esc_html__('Left to Right (Clockwise)', 'elematic-addons-for-elementor'),
                'reverse' => esc_html__('Right to Left (Counter-Clockwise)', 'elematic-addons-for-elementor'),
            ],
        ]);

        $this->end_controls_section();

        // Style Controls
        $this->start_controls_section('style_section', [
            'label' => esc_html__('Text Style', 'elematic-addons-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        $this->add_control('text_color', [
            'label' => esc_html__('Text Color', 'elematic-addons-for-elementor'),
            'type'  => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elematic-circle-text-txt' => 'color: {{VALUE}}',
            ],
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name'     => 'typography',
            'label'    => esc_html__('Typography', 'elematic-addons-for-elementor'),
            'selector' => '{{WRAPPER}} .elematic-circle-text-txt',
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings     = $this->get_settings_for_display();
        $text         = $settings['elematic_circle_text'];
        $tag          = $settings['elematic_circle_text_html_tag'];
        $direction    = ($settings['elematic_ct_rotate_direction'] === 'reverse') ? 'elematic-reverse' : '';
        $circle_size  = isset($settings['elematic_ct_circle_size']['size']) ? intval($settings['elematic_ct_circle_size']['size']) : 200;
        $speed        = isset($settings['elematic_ct_animation_speed']['size']) ? floatval($settings['elematic_ct_animation_speed']['size']) : 15;
        $logo_url = '';
        if ( ! empty( $settings['elematic_circle_text_image']['id'] ) ) {
            $logo_url = Group_Control_Image_Size::get_attachment_image_src(
                $settings['elematic_circle_text_image']['id'],
                'elematic_circle_text_image',
                $settings
            );
        } elseif ( ! empty( $settings['elematic_circle_text_image']['url'] ) ) {
            $logo_url = $settings['elematic_circle_text_image']['url']; // fallback to URL (e.g., placeholder)
        }

        ?>
		<div class="elematic-circle-text-wrap" style="width:<?php echo esc_attr( $circle_size ); ?>px; height:<?php echo esc_attr( $circle_size ); ?>px;">
            <div class="elematic-circle-text-image" 
                 style="background-image:url('<?php echo esc_url( $logo_url ); ?>'); 
                        width:<?php echo esc_attr( $circle_size * 0.7 ); ?>px; 
                        height:<?php echo esc_attr( $circle_size * 0.7 ); ?>px;">
            </div>
            <div class="elematic-circle-text-txt <?php echo esc_attr($direction) ?>" style="animation-duration: <?php echo esc_attr($speed) ?>s; animation-timing-function: linear; animation-iteration-count: infinite;">
                <?php printf('<%1$s>%2$s</%1$s>', esc_attr($tag), wp_kses_post($text)); ?>
            </div>
        </div>
        <?php
    }
}