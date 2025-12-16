<?php
namespace Elematic\Widgets;
use elementor\Widget_Base;
use elementor\Controls_Manager;
use elementor\Group_Control_Typography;
use elementor\Icons_Manager;
use elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Breadcrumbs extends Widget_Base {

	public function get_name() {
		return 'elematic-breadcrumbs';
	}

	public function get_title() {
		return ELEMATIC . esc_html__( 'Breadcrumbs', 'elematic-addons-for-elementor' );
	}

	public function get_icon() {
		return 'eicon-product-breadcrumbs';
	}

	public function get_categories() {
		return [ 'elematic-widgets' ];
	}

    public function get_style_depends() {
        return ['elematic-breadcrumbs'];
    }

	public function get_keywords() {
		return [ 'breadcrumbs' ];
	}
	
	protected function register_controls() {
        $this->start_controls_section(
            'brc_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'home_text',
            [
                'label'     => esc_html__( 'Home Text', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Home', 'elematic-addons-for-elementor' ),
                'dynamic'   => [
                    'active'     => true,
                ],
            ]
        );

        $this->add_control(
            'select_home_icon',
            [
                'label'            => esc_html__( 'Home Icon', 'elematic-addons-for-elementor' ),
                'type'             => Controls_Manager::ICONS,
                'label_block'      => false,
                'skin'             => 'inline',
                'default'          => [
                    'value'   => 'fas fa-home',
                    'library' => 'fa-solid',
                ],
            ]
        );
        $this->add_control(
            'blog_text',
            [
                'label'     => esc_html__( 'Blog Text', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__( 'Blog', 'elematic-addons-for-elementor' ),
                'dynamic'   => [
                    'active'     => true,
                ],

            ]
        );
        $this->add_control(
            'separator_type',
            array(
                'label'     => __( 'Separator Type', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'icon',
                'options'   => array(
                    'text' => __( 'Text', 'elematic-addons-for-elementor' ),
                    'icon' => __( 'Icon', 'elematic-addons-for-elementor' ),
                ),
                'condition' => array(
                    'breadcrumbs_type' => 'elematic-addons-for-elementor',
                ),
            )
        );
        $this->add_control(
            'separator_text',
            array(
                'label'     => __( 'Separator', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( '>', 'elematic-addons-for-elementor' ),
                'condition' => array(
                    'breadcrumbs_type' => 'elematic-addons-for-elementor',
                    'separator_type'   => 'text',
                ),
            )
        );
        $this->add_control(
            'select_separator_icon',
            [
                'label'            => esc_html__( 'Separator', 'elematic-addons-for-elementor' ),
                'type'             => Controls_Manager::ICONS,
                'label_block'      => false,
                'skin'             => 'inline',
                'default'          => [
                    'value'   => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'recommended'      => [
                    'fa-regular' => [
                        'circle',
                        'square',
                        'window-minimize',
                    ],
                    'fa-solid'   => [
                        'angle-right',
                        'angle-double-right',
                        'caret-right',
                        'chevron-right',
                        'bullseye',
                        'circle',
                        'dot-circle',
                        'genderless',
                        'greater-than',
                        'grip-lines',
                        'grip-lines-vertical',
                        'minus',
                    ],
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label'                => esc_html__( 'Alignment', 'elematic-addons-for-elementor' ),
                'type'                 => Controls_Manager::CHOOSE,
                'default'              => 'center',
                'options'              => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'elematic-addons-for-elementor' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors_dictionary' => [
                    'left'   => 'flex-start',
                    'center' => 'center',
                    'right'  => 'flex-end',
                ],
                
                'selectors'            => [
                    '{{WRAPPER}} .elematic-breadcrumbs' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'brc_styles',
            [
                'label'                 => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs( 'tabs_breadcrumbs_style' );

        $this->start_controls_tab(
            'brc_tab_normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
            ]
        );

        $this->add_control(
            'brc_item_color',
            [
                'label'     => esc_html__( 'Item Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elematic-breadcrumbs-item, {{WRAPPER}} .elematic-breadcrumbs-item a, {{WRAPPER}} .elematic-breadcrumbs-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elematic-breadcrumbs-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'brc_item_typography',
                'label'    => esc_html__( 'Typography', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-breadcrumbs-item, {{WRAPPER}} .elematic-breadcrumbs-separator-icon',
            ]
        );
        $this->add_responsive_control(
            'brc_item_svg_size',
            [
                'label'     => esc_html__( 'SVG Icon Size', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => '',
                ],
                'range'     => [
                    'px' => [
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-breadcrumbs-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'brc_tab_hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'brc_item_hov_color',
            [
                'label'     => esc_html__( 'Item Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elematic-breadcrumbs-item:hover a, {{WRAPPER}} .elematic-breadcrumbs-item:hover span, {{WRAPPER}} .elematic-breadcrumbs-item:hover .elematic-breadcrumbs-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elematic-breadcrumbs-item:hover .elematic-breadcrumbs-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'brc_tab_current',
            [
                'label' => esc_html__( 'Current', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'brc_current_item_color',
            [
                'label'     => esc_html__( 'Current Item Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elematic-breadcrumbs-item-current' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'brc_separators',
            [
                'label'                 => esc_html__( 'Separator', 'elematic-addons-for-elementor' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'brc_item_gap',
            [
                'label'     => esc_html__( 'Separator Gap', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => '',
                ],
                'range'     => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-breadcrumbs-separator' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'brc_separator_icon_color',
            [
                'label'     => esc_html__( 'Separator Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elematic-breadcrumbs-separator-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elematic-breadcrumbs-separator-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'brc_separator_typography',
                'label'    => esc_html__( 'Typography', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-breadcrumbs-separator',
            ]
        );
        $this->add_control(
            'brc_separator_svg_size',
            [
                'label'     => esc_html__( 'SVG Icon Size', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => '',
                ],
                'range'     => [
                    'px' => [
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-breadcrumbs-separator-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-breadcrumbs-separator-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

        protected function render_breadcrumbs( $query = false ) {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'breadcrumbs', 'class', array( 'elematic-breadcrumbs' ) );
        $this->add_render_attribute( 'breadcrumbs-item', 'class', 'elematic-breadcrumbs-item' );

        // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
        $custom_taxonomy = 'product_cat';

        // Get the query & post information
        global $post, $wp_query;

        if ( false === $query ) {
            // Reset post data to parent query
            $wp_query->reset_postdata();

            // Set active query to native query
            $query = $wp_query;
        }

        // Do not display on the homepage
        if ( ! $query->is_front_page() ) {

            // Build the breadcrums
            echo '<ul ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs' ) ) . '>';

            // Home page
          if( !empty($settings['home_text']) ) :
                $this->render_home_link();
            endif;

            if ( $query->is_archive() && ! $query->is_tax() && ! $query->is_category() && ! $query->is_tag() ) {

                $this->add_render_attribute(
                    'breadcrumbs-item-archive',
                    'class',
                    array(
                        'elematic-breadcrumbs-item',
                        'elematic-breadcrumbs-item-current',
                        'elematic-breadcrumbs-item-archive',
                    )
                );

                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-archive' ) ) . '><span class="bread-current bread-archive">' . post_type_archive_title( '', false ) . '</span></li>';

            } elseif ( $query->is_archive() && $query->is_tax() && ! $query->is_category() && ! $query->is_tag() ) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if ( 'post' !== $post_type ) {

                    $post_type_object  = get_post_type_object( $post_type );
                    $post_type_archive = get_post_type_archive_link( $post_type );

                    $this->add_render_attribute(
                        array(
                            'breadcrumbs-item-cpt'       => array(
                                'class' => array(
                                    'elematic-breadcrumbs-item',
                                    'elematic-breadcrumbs-item-cat',
                                    'elematic-breadcrumbs-item-custom-post-type-' . $post_type,
                                ),
                            ),
                            'breadcrumbs-item-cpt-crumb' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-crumb',
                                    'elematic-breadcrumbs-crumb-link',
                                    'elematic-breadcrumbs-crumb-cat',
                                    'elematic-breadcrumbs-crumb-custom-post-type-' . $post_type,
                                ),
                                'href'  => $post_type_archive,
                                'title' => $post_type_object->labels->name,
                            ),
                        )
                    );

                    echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-cpt' ) ) . '><a ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-cpt-crumb' ) ) . '>' . esc_attr( $post_type_object->labels->name ) . '</a></li>';

                    $this->render_separator();

                }

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-tax'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-archive',
                            ),
                        ),
                        'breadcrumbs-item-tax-crumb' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                            ),
                        ),
                    )
                );

                $custom_tax_name = get_queried_object()->name;

                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-tax' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-tax-crumb' ) ) . '>' . esc_attr( $custom_tax_name ) . '</span></li>';

            } elseif ( $query->is_single() ) {

                // If post is a custom post type
                $post_type = get_post_type();

                // If it is a custom post type display name and link
                if ( 'post' !== $post_type ) {

                    $post_type_object  = get_post_type_object( $post_type );
                    $post_type_archive = get_post_type_archive_link( $post_type );

                    $this->add_render_attribute(
                        array(
                            'breadcrumbs-item-cpt'       => array(
                                'class' => array(
                                    'elematic-breadcrumbs-item',
                                    'elematic-breadcrumbs-item-cat',
                                    'elematic-breadcrumbs-item-custom-post-type-' . $post_type,
                                ),
                            ),
                            'breadcrumbs-item-cpt-crumb' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-crumb',
                                    'elematic-breadcrumbs-crumb-link',
                                    'elematic-breadcrumbs-crumb-cat',
                                    'elematic-breadcrumbs-crumb-custom-post-type-' . $post_type,
                                ),
                                'href'  => $post_type_archive,
                                'title' => $post_type_object->labels->name,
                            ),
                        )
                    );

                    echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-cpt' ) ) . '><a ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-cpt-crumb' ) ) . '>' . esc_attr( $post_type_object->labels->name ) . '</a></li>';

                    $this->render_separator();

                }

                // Get post category info
                $category = get_the_category();

                if ( ! empty( $category ) ) {

                    // Get last category post is in
                    $values = array_values( $category );

                    $last_category = reset( $values );

                    $categories      = array();
                    $get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
                    $cat_parents     = explode( ',', $get_cat_parents );
                    foreach ( $cat_parents as $parent ) {
                        $categories[] = get_term_by( 'name', $parent, 'category' );
                    }

                    // Loop through parent categories and store in variable $cat_display
                    $cat_display = '';

                    foreach ( $categories as $parent ) {
                        if ( ! is_wp_error( get_term_link( $parent ) ) ) {
                            $cat_display .= '<li class="elematic-breadcrumbs-item elematic-breadcrumbs-item-cat"><a class="elematic-breadcrumbs-crumb elematic-breadcrumbs-crumb-link elematic-breadcrumbs-crumb-cat" href="' . get_term_link( $parent ) . '">' . $parent->name . '</a></li>';
                            $cat_display .= $this->render_separator( false );
                        }
                    }
                }

                // If it's a custom post type within a custom taxonomy
                $taxonomy_exists = taxonomy_exists( $custom_taxonomy );
                $taxonomy_terms = array();

                if ( empty( $last_category ) && ! empty( $custom_taxonomy ) && $taxonomy_exists ) {
                    $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                }

                // Check if the post is in a category
                if ( ! empty( $last_category ) ) {
                    echo wp_kses_post( $cat_display );

                    $this->add_render_attribute(
                        array(
                            'breadcrumbs-item-post-cat' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-item',
                                    'elematic-breadcrumbs-item-current',
                                    'elematic-breadcrumbs-item-' . $post->ID,
                                ),
                            ),
                            'breadcrumbs-item-post-cat-bread' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-crumb',
                                    'elematic-breadcrumbs-crumb-current',
                                    'elematic-breadcrumbs-crumb-' . $post->ID,
                                ),
                                'title' => get_the_title(),
                            ),
                        )
                    );

                    echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post-cat' ) ) . '"><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post-cat-bread' ) ) . '">' . wp_kses_post( get_the_title() ) . '</span></li>';

                    // Else if post is in a custom taxonomy
                } elseif ( ! empty( $taxonomy_terms ) ) {

                    foreach ( $taxonomy_terms as $index => $taxonomy ) {
                        $cat_id       = $taxonomy->term_id;
                        $cat_nicename = $taxonomy->slug;
                        $cat_link     = get_term_link( $taxonomy->term_id, $custom_taxonomy );
                        $cat_name     = $taxonomy->name;

                        $this->add_render_attribute(
                            array(
                                'breadcrumbs-item-post-cpt-' . $index => array(
                                    'class' => array(
                                        'elematic-breadcrumbs-item',
                                        'elematic-breadcrumbs-item-cat',
                                        'elematic-breadcrumbs-item-cat-' . $cat_id,
                                        'elematic-breadcrumbs-item-cat-' . $cat_nicename,
                                    ),
                                ),
                                'breadcrumbs-item-post-cpt-crumb-' . $index => array(
                                    'class' => array(
                                        'elematic-breadcrumbs-crumb',
                                        'elematic-breadcrumbs-crumb-link',
                                        'elematic-breadcrumbs-crumb-cat',
                                        'elematic-breadcrumbs-crumb-cat-' . $cat_id,
                                        'elematic-breadcrumbs-crumb-cat-' . $cat_nicename,
                                    ),
                                    'href'  => $cat_link,
                                    'title' => $cat_name,
                                ),
                            )
                        );

                        echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post-cpt-' . $index ) ) . '"><a ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post-cpt-crumb-' . $index ) ) . '>' . esc_attr( $cat_name ) . '</a></li>';

                        $this->render_separator();
                    }

                    $this->add_render_attribute(
                        array(
                            'breadcrumbs-item-post'       => array(
                                'class' => array(
                                    'elematic-breadcrumbs-item',
                                    'elematic-breadcrumbs-item-current',
                                    'elematic-breadcrumbs-item-' . $post->ID,
                                ),
                            ),
                            'breadcrumbs-item-post-crumb' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-crumb',
                                    'elematic-breadcrumbs-crumb-current',
                                    'elematic-breadcrumbs-crumb-' . $post->ID,
                                ),
                                'title' => get_the_title(),
                            ),
                        )
                    );

                    echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post' ) ) . '"><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post-crumb' ) ) . '">' . wp_kses_post( get_the_title() ) . '</span></li>';

                } else {

                    $this->add_render_attribute(
                        array(
                            'breadcrumbs-item-post'       => array(
                                'class' => array(
                                    'elematic-breadcrumbs-item',
                                    'elematic-breadcrumbs-item-current',
                                    'elematic-breadcrumbs-item-' . $post->ID,
                                ),
                            ),
                            'breadcrumbs-item-post-crumb' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-crumb',
                                    'elematic-breadcrumbs-crumb-current',
                                    'elematic-breadcrumbs-crumb-' . $post->ID,
                                ),
                                'title' => get_the_title(),
                            ),
                        )
                    );

                    echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post' ) ) . '"><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-post-crumb' ) ) . '">' . wp_kses_post( get_the_title() ) . '</span></li>';

                }
            } elseif ( $query->is_category() ) {

                    $this->add_render_attribute(
                        array(
                            'breadcrumbs-item-cat'       => array(
                                'class' => array(
                                    'elematic-breadcrumbs-item',
                                    'elematic-breadcrumbs-item-current',
                                    'elematic-breadcrumbs-item-cat',
                                ),
                            ),
                            'breadcrumbs-item-cat-bread' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-crumb',
                                    'elematic-breadcrumbs-crumb-current',
                                    'elematic-breadcrumbs-crumb-cat',
                                ),
                            ),
                        )
                    );

                // Category page
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-cat' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-cat-bread' ) ) . '>' . single_cat_title( '', false ) . '</span></li>';

            } elseif ( $query->is_page() ) {

                // Standard page
                if ( $post->post_parent ) {

                    // If child page, get parents
                    $anc = get_post_ancestors( $post->ID );

                    // Get parents in the right order
                    $anc = array_reverse( $anc );

                    // Parent page loop
                    if ( ! isset( $parents ) ) {
                        $parents = null;
                    }
                    foreach ( $anc as $ancestor ) {
                        $parents .= '<li class="elematic-breadcrumbs-item elematic-breadcrumbs-item-parent elematic-breadcrumbs-item-parent-' . $ancestor . '"><a class="elematic-breadcrumbs-crumb elematic-breadcrumbs-crumb-link elematic-breadcrumbs-crumb-parent elematic-breadcrumbs-crumb-parent-' . $ancestor . '" href="' . get_permalink( $ancestor ) . '" title="' . get_the_title( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';

                        $parents .= $this->render_separator( false );
                    }

                    // Display parent pages
                    echo wp_kses_post( $parents );

                }

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-page'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-' . $post->ID,
                            ),
                        ),
                        'breadcrumbs-item-page-crumb' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                                'elematic-breadcrumbs-crumb-' . $post->ID,
                            ),
                            'title' => get_the_title(),
                        ),
                    )
                );

                // Just display current page if not parents
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-page' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-page-crumb' ) ) . '>' . wp_kses_post( get_the_title() ) . '</span></li>';

            } elseif ( $query->is_tag() ) {

                // Tag page

                // Get tag information
                // new: pass a single args array (or use WP_Term_Query)
                $taxonomy = 'post_tag';
                $term_id  = absint( get_query_var( 'tag_id' ) );

                if ( $term_id ) {
                    $term_args = [
                        'taxonomy' => $taxonomy,
                        'include'  => [ $term_id ],
                        'hide_empty' => false,
                    ];

                    $terms = get_terms( $term_args );

                    if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                        $term       = $terms[0];
                        $get_term_id   = $term->term_id;
                        $get_term_slug = $term->slug;
                        $get_term_name = $term->name;
                    } else {
                        $get_term_id = $get_term_slug = $get_term_name = '';
                    }
                } else {
                    $get_term_id = $get_term_slug = $get_term_name = '';
                }

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-tag'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-tag-' . $get_term_id,
                                'elematic-breadcrumbs-item-tag-' . $get_term_slug,
                            ),
                        ),
                        'breadcrumbs-item-tag-bread' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                                'elematic-breadcrumbs-crumb-tag-' . $get_term_id,
                                'elematic-breadcrumbs-crumb-tag-' . $get_term_slug,
                            ),
                            'title' => get_the_title(),
                        ),
                    )
                );

                // Display the tag name
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-tag' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-tag-bread' ) ) . '>' . wp_kses_post( $get_term_name ) . '</span></li>';

            } elseif ( $query->is_day() ) {

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-year'        => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-year',
                                'elematic-breadcrumbs-item-year-' . get_the_time( 'Y' ),
                            ),
                        ),
                        'breadcrumbs-item-year-crumb'  => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-link',
                                'elematic-breadcrumbs-crumb-year',
                                'elematic-breadcrumbs-crumb-year-' . get_the_time( 'Y' ),
                            ),
                            'href'  => get_year_link( get_the_time( 'Y' ) ),
                            'title' => get_the_time( 'Y' ),
                        ),
                        'breadcrumbs-item-month'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-month',
                                'elematic-breadcrumbs-item-month-' . get_the_time( 'm' ),
                            ),
                        ),
                        'breadcrumbs-item-month-crumb' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-link',
                                'elematic-breadcrumbs-crumb-month',
                                'elematic-breadcrumbs-crumb-month-' . get_the_time( 'm' ),
                            ),
                            'href'  => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
                            'title' => get_the_time( 'M' ),
                        ),
                        'breadcrumbs-item-day'         => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-' . get_the_time( 'j' ),
                            ),
                        ),
                        'breadcrumbs-item-day-crumb'   => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                                'elematic-breadcrumbs-crumb-' . get_the_time( 'j' ),
                            ),
                        ),
                    )
                );

                // Year link
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-year' ) ) . '><a ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-year-crumb' ) ) . '>' . wp_kses_post( get_the_time( 'Y' ) ) . ' ' . esc_attr__( 'Archives', 'elematic-addons-for-elementor' ) . '</a></li>';

                $this->render_separator();

                // Month link
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-month' ) ) . '><a ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-month-crumb' ) ) . '>' . wp_kses_post( get_the_time( 'M' ) ) . ' ' . esc_attr__( 'Archives', 'elematic-addons-for-elementor' ) . '</a></li>';

                $this->render_separator();

                // Day display
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-day' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-day-crumb' ) ) . '> ' . wp_kses_post( get_the_time( 'jS' ) ) . ' ' . wp_kses_post( get_the_time( 'M' ) ) . ' ' . esc_attr__( 'Archives', 'elematic-addons-for-elementor' ) . '</span></li>';

            } elseif ( $query->is_month() ) {

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-year'        => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-year',
                                'elematic-breadcrumbs-item-year-' . get_the_time( 'Y' ),
                            ),
                        ),
                        'breadcrumbs-item-year-crumb'  => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-year',
                                'elematic-breadcrumbs-crumb-year-' . get_the_time( 'Y' ),
                            ),
                            'href'  => get_year_link( get_the_time( 'Y' ) ),
                            'title' => get_the_time( 'Y' ),
                        ),
                        'breadcrumbs-item-month'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-month',
                                'elematic-breadcrumbs-item-month-' . get_the_time( 'm' ),
                            ),
                        ),
                        'breadcrumbs-item-month-crumb' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-month',
                                'elematic-breadcrumbs-crumb-month-' . get_the_time( 'm' ),
                            ),
                            'title' => get_the_time( 'M' ),
                        ),
                    )
                );

                // Year link
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-year' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-year-crumb' ) ) . '>' . wp_kses_post( get_the_time( 'Y' ) ) . ' ' . esc_attr__( 'Archives', 'elematic-addons-for-elementor' ) . '</span></li>';

                $this->render_separator();

                // Month display
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-month' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-month-crumb' ) ) . '>' . wp_kses_post( get_the_time( 'M' ) ) . ' ' . esc_attr__( 'Archives', 'elematic-addons-for-elementor' ) . '</span></li>';

            } elseif ( $query->is_year() ) {

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-year'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-current-' . get_the_time( 'Y' ),
                            ),
                        ),
                        'breadcrumbs-item-year-crumb' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                                'elematic-breadcrumbs-crumb-current-' . get_the_time( 'Y' ),
                            ),
                            'title' => get_the_time( 'Y' ),
                        ),
                    )
                );

                // Display year archive
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-year' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-year-crumb' ) ) . '>' . wp_kses_post( get_the_time( 'Y' ) ) . ' ' . esc_attr__( 'Archives', 'elematic-addons-for-elementor' ) . '</span></li>';

            } elseif ( $query->is_author() ) {

                // Get the author information
                global $author;
                $userdata = get_userdata( $author );

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-author'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-current-' . $userdata->user_nicename,
                            ),
                        ),
                        'breadcrumbs-item-author-bread' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                                'elematic-breadcrumbs-crumb-current-' . $userdata->user_nicename,
                            ),
                            'title' => $userdata->display_name,
                        ),
                    )
                );

                // Display author name
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-author' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-author-bread' ) ) . '>' . esc_attr__( 'Author:', 'elematic-addons-for-elementor' ) . ' ' . esc_attr( $userdata->display_name ) . '</span></li>';

            } elseif ( get_query_var( 'paged' ) ) {

                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-paged'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-current-' . get_query_var( 'paged' ),
                            ),
                        ),
                        'breadcrumbs-item-paged-bread' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                                'elematic-breadcrumbs-crumb-current-' . get_query_var( 'paged' ),
                            ),
                            'title' => __( 'Page', 'elematic-addons-for-elementor' ) . ' ' . get_query_var( 'paged' ),
                        ),
                    )
                );

                // Paginated archives
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-paged' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-paged-bread' ) ) . '>' . esc_attr__( 'Page', 'elematic-addons-for-elementor' ) . ' ' . wp_kses_post( get_query_var( 'paged' ) ) . '</span></li>';

            } elseif ( $query->is_search() ) {

                // Search results page
                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-search'       => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                                'elematic-breadcrumbs-item-current-' . get_search_query(),
                            ),
                        ),
                        'breadcrumbs-item-search-crumb' => array(
                            'class' => array(
                                'elematic-breadcrumbs-crumb',
                                'elematic-breadcrumbs-crumb-current',
                                'elematic-breadcrumbs-crumb-current-' . get_search_query(),
                            ),
                            'title' => __( 'Search results for:', 'elematic-addons-for-elementor' ) . ' ' . get_search_query(),
                        ),
                    )
                );

                // Search results page
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-search' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-search-crumb' ) ) . '>' . esc_attr__( 'Search results for:', 'elematic-addons-for-elementor' ) . ' ' . get_search_query() . '</span></li>';

            } elseif ( $query->is_home() ) {

                $blog_label = $settings['blog_text'];

                if ( $blog_label ) {
                    $this->add_render_attribute(
                        array(
                            'breadcrumbs-item-blog'       => array(
                                'class' => array(
                                    'elematic-breadcrumbs-item',
                                    'elematic-breadcrumbs-item-current',
                                ),
                            ),
                            'breadcrumbs-item-blog-crumb' => array(
                                'class' => array(
                                    'elematic-breadcrumbs-crumb',
                                    'elematic-breadcrumbs-crumb-current',
                                ),
                                'title' => $blog_label,
                            ),
                        )
                    );

                    // Just display current page if not parents
                    echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-blog' ) ) . '><span ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-blog-crumb' ) ) . '>' . esc_attr( $blog_label ) . '</span></li>';
                }
            } elseif ( $query->is_404() ) {
                $this->add_render_attribute(
                    array(
                        'breadcrumbs-item-error' => array(
                            'class' => array(
                                'elematic-breadcrumbs-item',
                                'elematic-breadcrumbs-item-current',
                            ),
                        ),
                    )
                );

                // 404 page
                echo '<li ' . wp_kses_post( $this->get_render_attribute_string( 'breadcrumbs-item-error' ) ) . '>' . esc_attr__( 'Error 404', 'elematic-addons-for-elementor' ) . '</li>';
            }

            echo '</ul>';

        }

    }

    protected function get_separator() {
        $settings = $this->get_settings_for_display();

        ob_start(); ?>
        <li class="elematic-breadcrumbs-separator">
            <span class='elematic-breadcrumbs-separator-icon'>
                <?php Icons_Manager::render_icon( $settings['select_separator_icon'], [ 'aria-hidden' => 'true' ] ); ?>
            </span>
        </li>
        <?php
        $separator = ob_get_contents();
        ob_end_clean();

        return $separator;
    }

    protected function render_home_link() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute(
            array(
                'home_item' => array(
                    'class' => array(
                        'elematic-breadcrumbs-item',
                        'elematic-breadcrumbs-item-home',
                    ),
                ),
                'home_link' => array(
                    'class' => array(
                        'elematic-breadcrumbs-crumb',
                        'elematic-breadcrumbs-crumb-link',
                        'elematic-breadcrumbs-crumb-home',
                    ),
                    'href'  => get_home_url(),
                    'title' => $settings['home_text'],
                ),
                'home_text' => array(
                    'class' => array(
                        'elematic-breadcrumbs-text',
                    ),
                ),
            )
        );

        if ( ! isset( $settings['home_icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
            // add old default
            $settings['home_icon'] = 'fa fa-home';
        }

        $has_home_icon = ! empty( $settings['home_icon'] );

        if ( $has_home_icon ) {
            $this->add_render_attribute( 'i', 'class', $settings['home_icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        if ( ! $has_home_icon && ! empty( $settings['select_home_icon']['value'] ) ) {
            $has_home_icon = true;
        }
        $migrated_home_icon = isset( $settings['__fa4_migrated']['select_home_icon'] );
        $is_new_home_icon   = ! isset( $settings['home_icon'] ) && Icons_Manager::is_migration_allowed();
        ?>
        <li <?php echo wp_kses_post( $this->get_render_attribute_string( 'home_item' ) ); ?>>
            <a <?php echo wp_kses_post( $this->get_render_attribute_string( 'home_link' ) ); ?>>
                <span <?php echo wp_kses_post( $this->get_render_attribute_string( 'home_text' ) ); ?>>
                    <?php if ( ! empty( $settings['home_icon'] ) || ( ! empty( $settings['select_home_icon']['value'] ) && $is_new_home_icon ) ) { ?>
                        <span class="elematic-breadcrumbs-icon">
                            <?php
                            if ( $is_new_home_icon || $migrated_home_icon ) {
                                Icons_Manager::render_icon( $settings['select_home_icon'], array( 'aria-hidden' => 'true' ) );
                            } elseif ( ! empty( $settings['home_icon'] ) ) {
                                ?>
                                <i <?php echo wp_kses_post( $this->get_render_attribute_string( 'i' ) ); ?>></i>
                                <?php
                            }
                            ?>
                        </span>
                    <?php } ?>
                    <?php echo esc_attr( $settings['home_text'] ); ?>
                </span>
            </a>
        </li>
        <?php

        $this->render_separator();
    }

    protected function render_separator( $output = true ) {
        $settings = $this->get_settings_for_display();

        $html  = '<li class="elematic-breadcrumbs-separator">';
        $html .= $this->get_separator();
        $html .= '</li>';

        if ( true === $output ) {
            \Elementor\Utils::print_unescaped_internal_string( $html );
            return;
        }

        return $html;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->render_breadcrumbs();
    ?>  
        
<?php } // render()

} // class
