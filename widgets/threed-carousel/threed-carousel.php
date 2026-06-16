<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit;

class ThreedCarousel extends Widget_Base {

    use \Elematic\Traits\Carousel_Controls;

    public function get_name() {
        return 'elematic-threed-carousel';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( '3D Carousel', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-carousel-loop';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_keywords() {
        return [ '3d', 'carousel', 'slider', 'gallery', 'image' ];
    }

    public function get_style_depends() {
        return [ 'elematic-threed-carousel' ];
    }

    public function get_script_depends() {
        return [ 'elematic-gsap', 'elematic-threed-carousel' ];
    }

    protected function register_controls() {

        // ── Slides ──────────────────────────────────────────────────────────
        $this->start_controls_section( 'section_slides', [
            'label' => esc_html__( 'Slides', 'elematic-addons-for-elementor' ),
        ] );

        $repeater = new Repeater();

        $repeater->add_control( 'slide_image', [
            'label'   => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => Utils::get_placeholder_image_src() ],
        ] );

        $repeater->add_control( 'slide_title', [
            'label'       => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '',
            'label_block' => true,
            'dynamic'     => [ 'active' => true ],
        ] );

        $repeater->add_control( 'slide_desc', [
            'label'   => esc_html__( 'Description', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => '',
            'rows'    => 3,
            'dynamic' => [ 'active' => true ],
        ] );

        $repeater->add_control( 'slide_link', [
            'label'       => esc_html__( 'Link', 'elematic-addons-for-elementor' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => 'https://example.com',
            'dynamic'     => [ 'active' => true ],
        ] );

        $this->add_control( 'slides', [
            'label'   => esc_html__( 'Slides', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::REPEATER,
            'fields'  => $repeater->get_controls(),
            'default' => [
                [ 'slide_title' => esc_html__( 'Slide One', 'elematic-addons-for-elementor' ) ],
                [ 'slide_title' => esc_html__( 'Slide Two', 'elematic-addons-for-elementor' ) ],
                [ 'slide_title' => esc_html__( 'Slide Three', 'elematic-addons-for-elementor' ) ],
                [ 'slide_title' => esc_html__( 'Slide Four', 'elematic-addons-for-elementor' ) ],
                [ 'slide_title' => esc_html__( 'Slide Five', 'elematic-addons-for-elementor' ) ],
            ],
            'title_field' => '{{{ slide_title || "Slide" }}}',
        ] );

        $this->end_controls_section();

        // ── Shared carousel settings (autoplay, loop, drag, dimensions, transition)
        $this->register_carousel_controls( [
            'dimensions' => false, // 3D carousel uses its own card_width/height controls below
        ] );

        // ── 3D-specific Settings ─────────────────────────────────────────────
        $this->start_controls_section( 'section_3d_settings', [
            'label' => esc_html__( '3D Settings', 'elematic-addons-for-elementor' ),
        ] );

        $this->add_responsive_control( 'card_width', [
            'label'      => esc_html__( 'Card Width', 'elematic-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 200, 'max' => 800 ] ],
            'default'    => [ 'size' => 480, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .e3dc-card' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'card_height', [
            'label'      => esc_html__( 'Card Height', 'elematic-addons-for-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 150, 'max' => 600 ] ],
            'default'    => [ 'size' => 320, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .e3dc-card'     => 'height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .e3dc-track'    => 'height: calc({{SIZE}}{{UNIT}} + 80px);',
                '{{WRAPPER}} .e3dc-card img' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'card_gap', [
            'label'   => esc_html__( 'Card Gap', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
            'default' => [ 'size' => 60 ],
        ] );

        $this->add_control( 'rotation_angle', [
            'label'   => esc_html__( 'Side Card Rotation', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::SLIDER,
            'range'   => [ 'deg' => [ 'min' => 0, 'max' => 60 ] ],
            'default' => [ 'size' => 35 ],
        ] );

        $this->add_control( 'side_scale', [
            'label'   => esc_html__( 'Side Card Scale', 'elematic-addons-for-elementor' ),
            'type'    => Controls_Manager::SLIDER,
            'range'   => [ 'px' => [ 'min' => 50, 'max' => 100, 'step' => 1 ] ],
            'default' => [ 'size' => 82 ],
        ] );

        $this->add_control( 'perspective', [
            'label'     => esc_html__( 'Perspective', 'elematic-addons-for-elementor' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [ 'px' => [ 'min' => 400, 'max' => 2000 ] ],
            'default'   => [ 'size' => 1200 ],
            'selectors' => [
                '{{WRAPPER}} .e3dc-track' => 'perspective: {{SIZE}}px;',
            ],
        ] );

        $this->end_controls_section();

        // ── Card Style ───────────────────────────────────────────────────────
        $this->start_controls_section( 'section_style_card', [
            'label' => esc_html__( 'Card', 'elematic-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'card_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'default'    => [
                'top'    => 12, 'right' => 12,
                'bottom' => 12, 'left'  => 12,
                'unit'   => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .e3dc-card-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .e3dc-card-inner',
        ] );

        $this->end_controls_section();

        // ── Caption Style ────────────────────────────────────────────────────
        $this->start_controls_section( 'section_style_caption', [
            'label' => esc_html__( 'Caption', 'elematic-addons-for-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'caption_bg',
            'selector' => '{{WRAPPER}} .e3dc-caption',
        ] );

        $this->add_responsive_control( 'caption_padding', [
            'label'      => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'default'    => [
                'top'    => 20, 'right' => 24,
                'bottom' => 20, 'left'  => 24,
                'unit'   => 'px', 'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .e3dc-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Title Color', 'elematic-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .e3dc-title, {{WRAPPER}} .e3dc-title-link' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .e3dc-title',
        ] );

        $this->add_control( 'desc_color', [
            'label'     => esc_html__( 'Description Color', 'elematic-addons-for-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(255,255,255,0.8)',
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .e3dc-desc' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'desc_typography',
            'selector' => '{{WRAPPER}} .e3dc-desc',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $slides   = $settings['slides'];

        if ( empty( $slides ) ) return;

        $js_settings = $this->get_carousel_js_settings( $settings, [
            'cardWidth'  => (int) ( $settings['card_width']['size']      ?? 480 ),
            'cardGap'    => (int) ( $settings['card_gap']['size']         ?? 60 ),
            'rotation'   => (float) ( $settings['rotation_angle']['size'] ?? 35 ),
            'sideScale'  => (float) ( $settings['side_scale']['size']     ?? 82 ) / 100,
        ] );
        ?>

        <div class="elematic-3d-carousel" data-settings="<?php echo esc_attr( wp_json_encode( $js_settings ) ); ?>">
            <div class="e3dc-stage">
                <div class="e3dc-track">

                    <?php foreach ( $slides as $i => $item ) :
                        $has_title   = ! empty( $item['slide_title'] );
                        $has_desc    = ! empty( $item['slide_desc'] );
                        $has_link    = ! empty( $item['slide_link']['url'] );
                        $has_caption = $has_title || $has_desc;
                        $target      = ( isset( $item['slide_link']['is_external'] ) && $item['slide_link']['is_external'] ) ? '_blank' : '_self';
                        $nofollow    = ( isset( $item['slide_link']['nofollow'] ) && $item['slide_link']['nofollow'] ) ? 'nofollow' : '';
                        $img_url     = ! empty( $item['slide_image']['url'] ) ? $item['slide_image']['url'] : Utils::get_placeholder_image_src();
                        $img_alt     = ! empty( $item['slide_image']['alt'] ) ? $item['slide_image']['alt'] : esc_html( $item['slide_title'] ?? '' );
                    ?>
                    <div class="e3dc-card" data-index="<?php echo esc_attr( $i ); ?>">
                        <div class="e3dc-card-inner">

                            <?php if ( ! $has_caption && $has_link ) : ?>
                                <a href="<?php echo esc_url( $item['slide_link']['url'] ); ?>"
                                   target="<?php echo esc_attr( $target ); ?>"
                                   <?php if ( $nofollow ) echo 'rel="nofollow"'; ?>
                                   class="e3dc-image-link">
                                    <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy" draggable="false" />
                                </a>
                            <?php else : ?>
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy" draggable="false" />
                            <?php endif; ?>

                            <?php if ( $has_caption ) : ?>
                            <div class="e3dc-caption">
                                <?php if ( $has_title ) : ?>
                                    <?php if ( $has_link ) : ?>
                                        <a href="<?php echo esc_url( $item['slide_link']['url'] ); ?>"
                                           target="<?php echo esc_attr( $target ); ?>"
                                           <?php if ( $nofollow ) echo 'rel="nofollow"'; ?>
                                           class="e3dc-title-link">
                                            <h3 class="e3dc-title"><?php echo wp_kses_post( $item['slide_title'] ); ?></h3>
                                        </a>
                                    <?php else : ?>
                                        <h3 class="e3dc-title"><?php echo wp_kses_post( $item['slide_title'] ); ?></h3>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ( $has_desc ) : ?>
                                    <p class="e3dc-desc"><?php echo wp_kses_post( $item['slide_desc'] ); ?></p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                        </div><!-- .e3dc-card-inner -->
                    </div><!-- .e3dc-card -->
                    <?php endforeach; ?>

                </div><!-- .e3dc-track -->
            </div><!-- .e3dc-stage -->
        </div><!-- .elematic-3d-carousel -->

        <?php
    }
}