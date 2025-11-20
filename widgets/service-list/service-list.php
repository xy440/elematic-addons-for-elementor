<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use elementor\Icons_Manager;
use Elementor\Utils;
use elementor\Group_Control_Border;
use elementor\Group_Control_Background;
use elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class ServiceList extends Widget_Base {

    public function get_name() {
        return 'elematic-service-list';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Service List', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-editor-list-ol';
    }

    public function get_style_depends() {
        return ['elematic-service-list'];
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'elematic_sl_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );

        $repeater = new Repeater();
        
        $repeater->add_control(
            'elematic_sl_title', 
            [
                'label' => esc_html__('Title', 'elematic-addons-for-elementor'),
                'default' => esc_html__('Tristique sapien accum','elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'elematic_sl_title_link',
            [
                'label' => esc_html__('Title Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-site.com',
            ]
        );
        $repeater->add_control(
            'elematic_sl_subtitle', 
            [
                'label' => esc_html__('Subtitle', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Ligula ultrices','elematic-addons-for-elementor'),
            ]
        );
        $repeater->add_control(
            'elematic_sl_image',
            [
                'library' => 'image',
                'label' => esc_html__('Image.', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                    ],
                'label_block' => true,
            ]
        );
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'medium',
            ]
        );
        $repeater->add_control(
            'elematic_sl_desc', 
            [
                'type' => Controls_Manager::WYSIWYG,
                "label" => esc_html__("Text", 'elematic-addons-for-elementor'),
                "default" => esc_html__("Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquat enim ad minim veniam quis.", 'elematic-addons-for-elementor'),
                'show_label' => true,
            ]
        );

        $repeater->add_control(
            'sl_icon',
            [
                'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater->add_control(
            'sl_icon_link',
            [
                'label' => esc_html__('Icon Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-site.com',
            ]
        );

        $this->add_control(
            'features',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'elematic_sl_title' => 'Design',
                        'elematic_sl_subtitle' => '01.',
                        'elematic_sl_desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquat enim ad minim veniam quis.',
                    ],
                    [
                        'elematic_sl_title' => 'Marketing',
                        'elematic_sl_subtitle' => '02.',
                        'elematic_sl_desc' => 'Nostrud exercitation ullamco laboris nisi ut aliquip ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
                    ],
                    [
                        'elematic_sl_title' => 'Website',
                        'elematic_sl_subtitle' => '03.',
                        'elematic_sl_desc' => 'Cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.',
                    ],
                    [
                        'elematic_sl_title' => 'Branding',
                        'elematic_sl_subtitle' => '04.',
                        'elematic_sl_desc' => 'Suspendisse potenti Phasellus euismod libero in neque molestie et elementum libero maximus. Etiam in enim vestibulum suscipit sem quis molestie nibh.',
                    ],
                ],

                'title_field' => '{{{elematic_sl_title}}}',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'sl_style',
            [
                'label' => esc_html__('Styles', 'elematic-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'sl_column_gap',
            [
                'label' => esc_html__( 'Gap', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 1500,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-text-content' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sl_title_width',
            [
                'label' => esc_html__( 'Title Width', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 1500,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-title' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sl_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-text-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sl_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-text-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sl_margin',
            [
                'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-text-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sl_image_size',
            [
                'label' => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 1500,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-image-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'sl_image_spacing',
            [
                'label' => esc_html__( 'Image Spacing', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                    'px' => [
                        'max' => 1500,
                    ],
                ],
                'size_units' => ['%', 'px'],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-image-content' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sl_icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-serv-list-icon svg' => 'width: {{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'sl_icon_rotate',
            [
                'label' => esc_html__( 'Icon Rotate', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'deg' => [
                        'min' => -360,
                        'max' => 360,
                    ],
                ],
                'size_units' => ['deg'],
                'default' => [
                    'unit' => 'deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon i, {{WRAPPER}} .elematic-serv-list-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
                    
                ],
            ]
        );
        $this->add_responsive_control(
            'sl_icon_padding',
            [
                'label' => esc_html__( 'Icon Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'sl_icon_border',
                'selector'    =>    '{{WRAPPER}} .elematic-serv-list-icon'
            ]
        );
        $this->add_responsive_control(
            'sl_icon_border_radius',
            [
                'label' => esc_html__( 'Icon Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after'
            ]
        );
        $this->start_controls_tabs( 'sl_style_tabs' );
        $this->start_controls_tab(
            'sl_normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'sl_bg',
                'selector'  => '{{WRAPPER}} .elematic-serv-list-text-content',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'sl_border',
                'selector'    =>    '{{WRAPPER}} .elematic-serv-list-text-content'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sl_shadow',
                'selector' => '{{WRAPPER}} .elematic-serv-list-text-content'
            ]
        );

        $this->add_control(
            'sl_title_color',
            [
                'label' => esc_html__('Title Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sl_title_typography',
                'selector' => '{{WRAPPER}} .elematic-serv-list-title',
            ]
        );
        $this->add_control(
            'sl_subtitle_color',
            [
                'label' => esc_html__('Sub Title', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-subtitle' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sl_subtitle_typography',
                'selector' => '{{WRAPPER}} .elematic-serv-list-subtitle',
            ]
        );
        $this->add_control(
            'sl_desc_color',
            [
                'label' => esc_html__('Description Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-desc' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sl_desc_typography',
                'selector' => '{{WRAPPER}} .elematic-serv-list-desc',
            ]
        );
        $this->add_control(
            'sl_icon_color',
            [
                'label' => esc_html__('Icon Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-serv-list-icon svg' => 'fill: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'sl_icon_bg_color',
            [
                'label' => esc_html__('Icon Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sl_icon_brd_color',
            [
                'label' => esc_html__('Icon Border Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sl_hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'sl_hov_bg',
                'selector'  => '{{WRAPPER}} .elematic-serv-list-wrapper:hover .elematic-serv-list-text-content',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'sl_hov_border',
                'selector'    =>    '{{WRAPPER}} .elematic-serv-list-wrapper:hover .elematic-serv-list-text-content'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sl_hov_shadow',
                'selector' => '{{WRAPPER}} .elematic-serv-list-wrapper:hover .elematic-serv-list-text-content'
            ]
        );

        $this->add_control(
            'sl_title_hov_color',
            [
                'label' => esc_html__('Title Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sl_icon_hov_color',
            [
                'label' => esc_html__('Icon Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elematic-serv-list-icon:hover, {{WRAPPER}} .elematic-serv-list-icon:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} a.elematic-serv-list-icon svg:hover, {{WRAPPER}} .elematic-serv-list-icon svg:hover' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sl_icon_bg_hov_color',
            [
                'label' => esc_html__('Icon Background Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-serv-list-icon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'sl_icon_bord_hov_color',
            [
                'label' => esc_html__('Icon Border Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.elematic-serv-list-icon:hover, {{WRAPPER}} .elematic-serv-list-icon:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $visit_label = static function( $title ) {
			$title = wp_strip_all_tags( (string) $title );

			/* translators: %s: site or post title. */
			$text = sprintf( __( 'Visit %s', 'elematic-addons-for-elementor' ), $title );

			return esc_attr( $text );
		};
        ?>

        <div class="elematic-serv-list-container">
            <?php foreach ($settings['features'] as $feature): 
                $target = $feature['elematic_sl_title_link']['is_external'] ? '_blank' : '_self';
                $target_icon = $feature['sl_icon_link']['is_external'] ? '_blank' : '_self';
                $title_text = $feature['elematic_sl_title'];
                $label_for_title = $visit_label( $title_text );
            ?>

                <div class="elematic-serv-list-wrapper">
                    <div class="elematic-serv-list-image-content">
                        <?php if (!empty($feature['elematic_sl_image'])) :
                             $image_html = Group_Control_Image_Size::get_attachment_image_html( $feature, 'image', 'elematic_sl_image' );
                             echo wp_kses_post($image_html);
                        endif; ?>
                    </div><!-- elematic-serv-list-image-content -->
                    <div class="elematic-serv-list-text-content">
                        <?php if(!empty($feature['elematic_sl_subtitle'])): ?>
                            <h3 class="elematic-serv-list-subtitle"><?php echo esc_html($feature['elematic_sl_subtitle']) ?></h3>
                        <?php endif; ?>
                        <?php if(!empty($feature['elematic_sl_title_link']['url'])) : ?>
                        <h2 class="elematic-serv-list-title"><a href="<?php echo esc_url( $feature['elematic_sl_title_link']['url'] ); ?>" target="<?php echo esc_attr($target); ?>" aria-label="<?php echo esc_attr($label_for_title); ?>"><?php echo esc_html($feature['elematic_sl_title']); ?></a></h2>
                        <?php else: ?>
                        <h2 class="elematic-serv-list-title"><?php echo esc_html($feature['elematic_sl_title']); ?></h2>
                        <?php endif; ?>
                        <?php if(!empty($feature['elematic_sl_desc'])): ?>
                            <div class="elematic-serv-list-desc"><?php echo $this->parse_text_editor($feature['elematic_sl_desc']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
                        <?php endif; ?>
                        <?php if(!empty($feature['sl_icon_link']['url'])) : ?>
                            <a href="<?php echo esc_url( $feature['sl_icon_link']['url'] ); ?>" target="<?php echo esc_attr($target_icon); ?>" aria-label="<?php echo esc_attr($visit_label( $title_text )); ?>">
                            <div class="elematic-serv-list-icon"><?php Icons_Manager::render_icon( $feature['sl_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
                            </a>
                        <?php else: ?>
                            <div class="elematic-serv-list-icon"><?php Icons_Manager::render_icon( $feature['sl_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
                        <?php endif; ?>
                    </div><!-- elematic-serv-list-text-content -->
                </div><!-- elematic-serv-list-wrapper -->
            <?php endforeach; ?>
        </div><!-- elematic-serv-list-container -->


<?php   } // render()
} // class 
