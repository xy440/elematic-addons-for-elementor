<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PostTab extends Widget_Base {

    public function get_name() {
        return 'elematic-post-tab';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Post Tab', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-posts-group';
    }
    public function get_style_depends() {
        return [ 'elematic-post-tab' ];
    }
    public function get_script_depends() {
        return [ 'elematic-post-tab' ];
    }
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }
    protected function register_controls() {

        // =====================
        // SECTION: Query
        // =====================
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__( 'Query', 'elematic-addons-for-elementor' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label'   => esc_html__( 'Post Type', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => Helper::get_all_post_types(),
            ]
        );

        $this->add_control(
            'taxonomy',
            [
                'label'   => esc_html__( 'Taxonomy', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'category',
                'options' => Helper::get_all_taxonomies(),
            ]
        );

        $this->add_control(
            'posts_per_tab',
            [
                'label'   => esc_html__( 'Posts Per Tab', 'elematic-addons-for-elementor' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min'     => 1,
                'max'     => 20,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__( 'Order By', 'elematic-addons-for-elementor' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'          => esc_html__( 'Date', 'elematic-addons-for-elementor' ),
                    'title'         => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                    'modified'      => esc_html__( 'Modified', 'elematic-addons-for-elementor' ),
                    'comment_count' => esc_html__( 'Comment Count', 'elematic-addons-for-elementor' ),
                    'rand'          => esc_html__( 'Random', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__( 'Order', 'elematic-addons-for-elementor' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__( 'Descending', 'elematic-addons-for-elementor' ),
                    'ASC'  => esc_html__( 'Ascending', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->end_controls_section();

        // =====================
        // SECTION: Layout
        // =====================
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__( 'Layout', 'elematic-addons-for-elementor' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tab_position',
            [
                'label'   => esc_html__( 'Tab Position', 'elematic-addons-for-elementor' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                    'top'   => esc_html__( 'Top', 'elematic-addons-for-elementor' ),
                    'right' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_control(
            'tab_trigger',
            [
                'label'   => esc_html__( 'Tab Trigger', 'elematic-addons-for-elementor' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'click',
                'options' => [
                    'click'     => esc_html__( 'Click', 'elematic-addons-for-elementor' ),
                    'mouseover' => esc_html__( 'Mouse Over (Hover)', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'          => esc_html__( 'Columns', 'elematic-addons-for-elementor' ),
                'type'           => \Elementor\Controls_Manager::SELECT,
                'default'        => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options'        => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-posts-tab-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label'        => esc_html__( 'Show Featured Image', 'elematic-addons-for-elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'medium',
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'        => esc_html__( 'Show Title', 'elematic-addons-for-elementor' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label'        => esc_html__( 'Show Excerpt', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_control(
            'excerpt_words',
            [
                'label' => esc_html__( 'Excerpt Words', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '12',
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label'        => esc_html__( 'Show Date & Author', 'elematic-addons-for-elementor' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                'label_off'    => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();

        // =====================
        // STYLE: Tab Nav
        // =====================
        $this->start_controls_section(
            'style_tab_nav',
            [
                'label' => esc_html__( 'Tab Navigation', 'elematic-addons-for-elementor' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tab_width',
            [
                'label'      => esc_html__( 'Tab Nav Width', 'elematic-addons-for-elementor' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px' => [ 'min' => 100, 'max' => 400 ],
                    '%'  => [ 'min' => 10, 'max' => 50 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 180 ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-tab-position-left .elematic-posts-tab-nav,
                     {{WRAPPER}} .elematic-tab-position-right .elematic-posts-tab-nav' => 'width: {{SIZE}}{{UNIT}}; flex-shrink: 0;',
                ],
                'condition' => [
                    'tab_position' => [ 'left', 'right' ],
                ],
            ]
        );

        $this->add_control(
            'tab_item_padding',
            [
                'label'      => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top' => 12, 'right' => 20, 'bottom' => 12, 'left' => 20,
                    'unit' => 'px', 'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-tab-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tab_item_margin',
            [
                'label'      => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'       => controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-tab-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tab_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-tab-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_typography',
                'label'    => esc_html__( 'Typography', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-tab-item',
            ]
        );

        $this->start_controls_tabs( 'tab_nav_states' );

        $this->start_controls_tab(
            'tab_nav_normal',
            [ 'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ) ]
        );

        $this->add_control(
            'tab_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .elematic-tab-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .elematic-tab-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_nav_active',
            [ 'label' => esc_html__( 'Active / Hover', 'elematic-addons-for-elementor' ) ]
        );

        $this->add_control(
            'tab_active_text_color',
            [
                'label'     => esc_html__( 'Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .elematic-tab-item.elematic-active,
                     {{WRAPPER}} .elematic-tab-item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_active_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elematic-tab-item.elematic-active,
                     {{WRAPPER}} .elematic-tab-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_active_indicator_color',
            [
                'label'     => esc_html__( 'Active Indicator Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .elematic-tab-position-left .elematic-tab-item.elematic-active'  => 'border-left: 3px solid {{VALUE}};',
                    '{{WRAPPER}} .elematic-tab-position-right .elematic-tab-item.elematic-active' => 'border-right: 3px solid {{VALUE}};',
                    '{{WRAPPER}} .elematic-tab-position-top .elematic-tab-item.elematic-active'   => 'border-bottom: 3px solid {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // =====================
        // STYLE: Post Card
        // =====================
        $this->start_controls_section(
            'style_post_card',
            [
                'label' => esc_html__( 'Post Card', 'elematic-addons-for-elementor' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_bg',
            [
                'label'     => esc_html__( 'Card Background', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'card_shadow',
                'selector' => '{{WRAPPER}} .elematic-post-card',
            ]
        );

        $this->add_control(
            'card_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-post-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-post-card .elematic-post-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
                ],
            ]
        );

        $this->add_control(
            'image_height',
            [
                'label'      => esc_html__( 'Image Height', 'elematic-addons-for-elementor' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 100, 'max' => 600 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 200 ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-post-thumb' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_padding',
            [
                'label'      => esc_html__( 'Content Padding', 'elematic-addons-for-elementor' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em' ],
                'default'    => [
                    'top' => 12, 'right' => 15, 'bottom' => 15, 'left' => 15,
                    'unit' => 'px', 'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-card-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'card_gap',
            [
                'label'      => esc_html__( 'Gap Between Cards', 'elematic-addons-for-elementor' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
                'default'    => [ 'unit' => 'px', 'size' => 20 ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-posts-tab-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // =====================
        // STYLE: Post Title
        // =====================
        $this->start_controls_section(
            'style_post_title',
            [
                'label'     => esc_html__( 'Post Title', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elematic-post-title a',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // =====================
        // STYLE: Post Excerpt
        // =====================
        $this->start_controls_section(
            'style_post_excerpt',
            [
                'label'     => esc_html__( 'Post Excerpt', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_excerpt' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .tx-excerpt',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tx-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // =====================
        // STYLE: Post Meta
        // =====================
        $this->start_controls_section(
            'style_post_meta',
            [
                'label'     => esc_html__( 'Post Meta', 'elematic-addons-for-elementor' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_meta' => 'yes' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_typography',
                'selector' => '{{WRAPPER}} .elematic-post-meta',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // =====================
    // RENDER
    // =====================
    protected function render() {
        $settings = $this->get_settings_for_display();

        $taxonomy     = ! empty( $settings['taxonomy'] ) ? $settings['taxonomy'] : 'category';
        $post_type    = ! empty( $settings['post_type'] ) ? $settings['post_type'] : 'post';
        $posts_per    = ! empty( $settings['posts_per_tab'] ) ? intval( $settings['posts_per_tab'] ) : 3;
        $tab_position = ! empty( $settings['tab_position'] ) ? $settings['tab_position'] : 'left';
        $tab_trigger  = ! empty( $settings['tab_trigger'] ) ? $settings['tab_trigger'] : 'click';

        $terms = get_terms( [
            'taxonomy'   => $taxonomy,
            'hide_empty' => true,
        ] );

        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            echo '<p>' . esc_html__( 'No categories found.', 'elematic-addons-for-elementor' ) . '</p>';
            return;
        }

        $widget_id = $this->get_id();
        ?>
        <div class="elematic-posts-tab-wrapper elematic-tab-position-<?php echo esc_attr( $tab_position ); ?>"
             data-trigger="<?php echo esc_attr( $tab_trigger ); ?>"
             id="elematic-posts-tab-<?php echo esc_attr( $widget_id ); ?>">

            <!-- Tab Navigation -->
            <nav class="elematic-posts-tab-nav">
                <?php foreach ( $terms as $index => $term ) : ?>
                    <div class="elematic-tab-item <?php echo ( $index === 0 ) ? 'elematic-active' : ''; ?>"
                         data-tab="<?php echo esc_attr( $term->term_id ); ?>">
                        <?php echo esc_html( $term->name ); ?>
                    </div>
                <?php endforeach; ?>
            </nav>

            <!-- Tab Content -->
            <div class="elematic-posts-tab-content">
                <?php foreach ( $terms as $index => $term ) : ?>
                    <div class="elematic-tab-pane <?php echo ( $index === 0 ) ? 'elematic-active' : ''; ?>"
                         data-tab-content="<?php echo esc_attr( $term->term_id ); ?>">

                        <?php
                        $query_args = [
                            'post_type'      => $post_type,
                            'posts_per_page' => $posts_per,
                            'orderby'        => $settings['orderby'],
                            'order'          => $settings['order'],
                            'tax_query'      => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
                                [
                                    'taxonomy' => $taxonomy,
                                    'field'    => 'term_id',
                                    'terms'    => $term->term_id,
                                ],
                            ],
                        ];

                        $query = new \WP_Query( $query_args );

                        if ( $query->have_posts() ) : ?>
                            <div class="elematic-posts-tab-grid">
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                    <div class="elematic-post-card">
                                        <?php if ( 'yes' === $settings['show_image'] && has_post_thumbnail() ) : ?>
                                            <a href="<?php the_permalink(); ?>" class="elematic-post-thumb">
                                                <?php the_post_thumbnail( $settings['image_size'] ); ?>
                                            </a>
                                        <?php endif; ?>

                                        <div class="elematic-post-card-body">
                                            <?php if ( 'yes' === $settings['show_meta'] ) : ?>
                                                <div class="elematic-post-meta">
                                                    <span class="elematic-post-author"><?php the_author(); ?></span>
                                                    <span class="elematic-post-date"><?php echo get_the_date(); ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ( 'yes' === $settings['show_title'] ) : ?>
                                                <h3 class="elematic-post-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h3>
                                            <?php endif; ?>

                                            <?php if ( 'yes' === $settings['show_excerpt'] ) : ?>
                                                <div class="tx-excerpt"><?php echo wp_kses_post(Helper::excerpt_limit($settings['excerpt_words'])); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        <?php else : 
                            echo '<p>' . esc_html__( 'Sorry, nothing found.', 'elematic-addons-for-elementor' ) . '</p>';
                        endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
        </div>
        <?php
    }
} // class 