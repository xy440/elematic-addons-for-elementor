<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PostGrid extends Widget_Base {

    public function get_name() {
        return 'elematic-post-grid';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Post Grid', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }
    public function get_script_depends() {
        return [ 'elematic-load-more-btn' ];
    }
    public function get_style_depends() {
        return [ 'elematic-post-grid' ];
    }
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }
    protected function register_controls() {
        $this->start_controls_section(
            'settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Types', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => Helper::get_all_post_types(),
            ]
        );
        $this->add_control(
            'tax_query',
            [
                'label' => esc_html__( 'Categories', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => Helper::get_all_categories(),
                
            ]
        );
        $this->add_control(
            'grid_style',
            [
                'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__( 'Style 1', 'elematic-addons-for-elementor' ),
                    'style-2' => esc_html__( 'Style 2',   'elematic-addons-for-elementor' ),
                    'style-3' => esc_html__( 'Style 3',   'elematic-addons-for-elementor' ),
                    'style-4' => esc_html__( 'Style 4',   'elematic-addons-for-elementor' ),
                ],
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,             
                'desktop_default' => '33.33%',
                'tablet_default'  => '50%',
                'mobile_default'  => '100%',
                'options' => [
                    '100%' => esc_html__( '1 Column', 'elematic-addons-for-elementor' ),
                    '50%' => esc_html__( '2 Columns', 'elematic-addons-for-elementor' ),
                    '33.33%' => esc_html__( '3 Columns', 'elematic-addons-for-elementor' ),
                    '25%' => esc_html__( '4 Columns', 'elematic-addons-for-elementor' ),
                    '20%' => esc_html__( '5 Columns', 'elematic-addons-for-elementor' ),
                    '16.66%' => esc_html__( '6 Columns', 'elematic-addons-for-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-item' => 'width: {{VALUE}};',
                ],
                'render_type' => 'template'
            ]
        );
        $this->add_responsive_control(
            'custom_width',
            [
                'label' => esc_html__( 'Custom Width', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'em'],
                'range' => [
                    '%' => [
                        'max' => 100,
                        'step' => .1
                    ],
                   
                ],
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-item' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'columns!' => ''
                ]
            ]
        );
        $this->add_responsive_control(
            'item_padding',
            [
                'label'             => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_margin',
            [
                'label'             => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-grid-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                // 'exclude' => [ 'custom' ],
                'default' => 'medium',
            ]
        );
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'ASC' => esc_html__('Ascending', 'elematic-addons-for-elementor'),
                    'DESC' => esc_html__('Descending', 'elematic-addons-for-elementor'),
                ),
                'default' => 'DESC',
            ]
        );
        $this->add_control(
            'post_sortby',
            [
                'label'     => esc_html__( 'Post sort by', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'latestpost',
                'options'   => [
                        'latestpost'      => esc_html__( 'Latest posts', 'elematic-addons-for-elementor' ),
                        'mostdiscussed'    => esc_html__( 'Most discussed', 'elematic-addons-for-elementor' ),
                    ],
            ]
        );
        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'none' => esc_html__('No order', 'elematic-addons-for-elementor'),
                    'ID' => esc_html__('Post ID', 'elematic-addons-for-elementor'),
                    'author' => esc_html__('Author', 'elematic-addons-for-elementor'),
                    'title' => esc_html__('Title', 'elematic-addons-for-elementor'),
                    'date' => esc_html__('Published date', 'elematic-addons-for-elementor'),
                    'modified' => esc_html__('Modified date', 'elematic-addons-for-elementor'),
                    'parent' => esc_html__('By parent', 'elematic-addons-for-elementor'),
                    'rand' => esc_html__('Random order', 'elematic-addons-for-elementor'),
                    'comment_count' => esc_html__('Comment count', 'elematic-addons-for-elementor'),
                    'menu_order' => esc_html__('Menu order', 'elematic-addons-for-elementor'),
                    'post__in' => esc_html__('By include order', 'elematic-addons-for-elementor'),
                ),
                'default' => 'date',
                'condition' => [
                    'post_sortby' => ['latestpost'],
                ],
            ]
        );
        $this->add_control(
            'number_of_posts',
            [
                'label' => esc_html__( 'Number of Posts', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 3
            ]
        );
        $this->add_responsive_control(
            'min_height',
            [
                'label' => esc_html__( 'Min Height', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px','rem' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 700,
                    ],
                   
                ],
                'default' => [
                    'size' => 250,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-content' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
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
                'toggle' => false,
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-content'   => 'text-align: {{VALUE}};',
                ],
                'separator' => 'after',
            ]
        );
        $this->add_control(
            'date',
            [
                'label' => esc_html__( 'Date', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show'
            ]
        );
        $this->add_control(
            'author',
            [
                'label' => esc_html__( 'Author', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show'
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show'
            ]
        );
        $this->add_control(
            'title_lenth',
            [
                'label' => esc_html__( 'Title Lenth', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '50',
                'condition' => [
                    'title' => 'show',
                ]

            ]
        );
        $this->add_control(
            'post_category',
            [
                'label' => esc_html__( 'Category', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'hide',
            ]
        );
        $this->add_control(
            'comments',
            [
                'label' => esc_html__( 'Comments', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
            ]
        );
        $this->add_control(
            'desc',
            [
                'label' => esc_html__( 'Excerpt', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show'
            ]
        );
        $this->add_control(
            'excerpt_words',
            [
                'label' => esc_html__( 'Excerpt Words', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '15',
                'condition' => [
                    'desc' => 'show',
                ],
            ]
        );
        $this->add_control(
            'read_more',
            [
                'label' => esc_html__( 'Read More', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
               
            ]
        );
        $this->add_control(
            'read_more_txt',
            [
                'label' => esc_html__( 'Read More text', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'Read More',
                'condition' => [
                    'read_more' => 'show',
                ],
            ]
        );
        $this->add_control(
            'pagination',
            [
                'label' => esc_html__( 'Pagination', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'hide',
                'separator' => 'before'
               
            ]
        );
        $this->add_control(
            'pagination_style',
            [
                'label' => esc_html__( 'Pagination', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'default' => 'loadmore',
                'options' => [
                    'loadmore' => esc_html__( 'Load More', 'elematic-addons-for-elementor' ),
                    'numbering' => esc_html__( 'Numbering', 'elematic-addons-for-elementor' ),
                    
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__('Load More Text', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Load More', 'elematic-addons-for-elementor'),
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'loadmore'
                ],
            ]
        );
        $this->add_control(
            'loading_text',
            [
                'label' => esc_html__('Loading Text', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Loading...', 'elematic-addons-for-elementor'),
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'loadmore'
                ],
            ]
        );
        $this->add_control(
            'no_more_text',
            [
                'label' => esc_html__('No More Posts Text', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('No more posts', 'elematic-addons-for-elementor'),
                'condition' => [
                    'pagination' => 'show',
                    'pagination_style' => 'loadmore'
                ],
            ]
        );

        $this->add_responsive_control(
          'pagination_alignment',
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
              ]
            ],
            'selectors' => [
              '{{WRAPPER}} .elematic-pagination, {{WRAPPER}} .elematic-load-more' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                    'pagination' => 'show'
                ]

          ]
        );

        $this->end_controls_section();

        // Style section started
        $this->start_controls_section(
            'styles',
            [
              'label'   => esc_html__( 'Styles', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'content_bg_color',
            [
                'label'     => esc_html__( 'Content Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-content' => 'background-color: {{VALUE}}',
                ],
                
            ]
        );
        $this->add_responsive_control(
            'cont_padding',
            [
                'label'             => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'cont_brd_radius',
            [
                'label'             => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'cont_shadow',
                'selector' => '{{WRAPPER}} .elematic-post-content'
            ]
        );
        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__( 'Date Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-content .post-time, {{WRAPPER}} .elematic-post-content .post-time i, {{WRAPPER}} .elematic-post-grid-style-2 .elematic-date-style, {{WRAPPER}} .elematic-post-grid-style-3 .elematic-date-style' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'date' => 'show',
                    'grid_style' => 'style-3'
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'date_bg_color',
            [
                'label'     => esc_html__( 'Date Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-content .post-time, {{WRAPPER}} .elematic-post-grid-style-2 .elematic-date-style, {{WRAPPER}} .elematic-post-grid-style-3 .elematic-date-style' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'date' => 'show',
                    'grid_style' => 'style-3'
                ],
            ]
        );
        $this->add_control(
            'date_bg_hov_color',
            [
                'label'     => esc_html__( 'Date Background Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-style-3:hover .elematic-date-style' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'date' => 'show',
                    'grid_style' => 'style-3',
                ],
            ]
        );
        $this->add_responsive_control(
            'date_position_x',
            [
                'label'   => esc_html__( 'Date Position X', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 500,
                        'min'  => -500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-style-2 .elematic-date-style, {{WRAPPER}} .elematic-post-content .post-time'   => 'left:{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-post-grid-style-3 .elematic-date-style'   => 'right:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'date' => 'show',
                    'grid_style' => 'style-3',
                ],
            ]
        );
        $this->add_responsive_control(
            'date_position_y',
            [
                'label'   => esc_html__( 'Date Position Y', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 500,
                        'min'  => -500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-content .post-time, {{WRAPPER}} .elematic-post-grid-style-2 .elematic-date-style, {{WRAPPER}} .elematic-post-grid-style-3 .elematic-date-style'   => 'top:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'date' => 'show',
                    'grid_style' => 'style-3',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'date_typography',
                   'selector'  => '{{WRAPPER}} .elematic-post-content .post-time, {{WRAPPER}} .elematic-post-grid-style-2 .elematic-date-style span, {{WRAPPER}} .elematic-post-grid-style-3 .elematic-date-style span',
                   'condition' => [
                      'date' => 'show',
                    ],
              ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__( 'Title Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-title:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'title_typography',
                   'selector'  => '{{WRAPPER}} .elematic-post-title',
                   'condition' => [
                      'title' => 'show',
                    ],
              ]
        );
        $this->add_responsive_control(
            'title_padding',
            [
                'label'             => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'desc_color',
            [
                'label'     => esc_html__( 'Description Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-excerpt' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'desc' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'desc_typography',
                   'selector'  => '{{WRAPPER}} .elematic-excerpt',
                   'condition' => [
                      'desc' => 'show',
                    ],
              ]
        );
        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__( 'Meta Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-meta-comments, {{WRAPPER}} .elematic-post-meta-comments a, {{WRAPPER}} .elematic-post-meta .nickname, {{WRAPPER}} .elematic-post-meta .nickname a, {{WRAPPER}} .elematic-post-category, {{WRAPPER}} .elematic-post-category a, {{WRAPPER}} .elematic-post-meta-date' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'meta_hov_color',
            [
                'label'     => esc_html__( 'Meta Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-meta-comments a:hover, {{WRAPPER}} .elematic-post-category a:hover, {{WRAPPER}} .elematic-post-meta .nickname a:hover,' => 'color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'meta_typography',
                   'selector' => '{{WRAPPER}} .elematic-post-meta-comments, {{WRAPPER}} .elematic-post-meta-comments a, {{WRAPPER}} .elematic-post-meta .nickname, {{WRAPPER}} .elematic-post-category, {{WRAPPER}} .elematic-post-category a, {{WRAPPER}} .elematic-post-meta-date',
              ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_readmore',
            [
              'label'   => esc_html__( 'Read More', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
              'condition' => [
                    'read_more' => 'show',
                ],
            ]
        );
        $this->add_control(
            'read_more_color',
            [
                'label'     => esc_html__( 'Read More Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-read-more' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'read_more' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'read_more_hov_color',
            [
                'label'     => esc_html__( 'Read More Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-read-more:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'read_more' => 'show',
                ],
            ]
        );
        $this->add_control(
            'read_more_bg_color',
            [
                'label'     => esc_html__( 'Read More Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-read-more' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'read_more' => 'show',
                ],
            ]
        );
        $this->add_control(
            'read_more_bg_hov_color',
            [
                'label'     => esc_html__( 'Read More Background Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-grid-read-more:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'read_more' => 'show',
                ],
            ]
        );
        $this->add_responsive_control(
            'read_more_padding',
            [
                'label'             => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-grid-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'read_more_border_radius',
            [
                'label'             => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-grid-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'read_more_border',
                'selector' => '{{WRAPPER}} .elematic-post-grid-read-more'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'read_more_typography',
                   'selector'  => '{{WRAPPER}} .elematic-post-grid-read-more',
              ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_pagination',
            [
              'label'   => esc_html__( 'Pagination', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
              'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        $this->add_control(
            'pagination_color',
            [
                'label'     => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination a,{{WRAPPER}} .elematic-load-more-btn' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'pagination_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination a:hover, {{WRAPPER}} .elematic-load-more-btn:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
      );
        $this->add_control(
            'pagination_active_color',
            [
                'label'     => esc_html__( 'Active Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination .current, {{WRAPPER}} .elematic-load-more-btn.elematic__loading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        $this->add_control(
            'pagination_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination a, {{WRAPPER}} .elematic-load-more-btn' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        $this->add_control(
            'pagination_active_bg_color',
            [
                'label'     => esc_html__( 'Active Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination .current, {{WRAPPER}} .elematic-pagination .page-numbers.dots, {{WRAPPER}} .elematic-load-more-btn.elematic__loading' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        $this->add_control(
            'paginations_active_border_color',
            [
                'label'     => esc_html__( 'Active Border Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination .current, {{WRAPPER}} .elematic-load-more-btn.elematic__loading' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
        );
        
       $this->add_control(
            'pagination_hover_border_color',
            [
                'label'     => esc_html__( 'Hover Border Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination a:hover, {{WRAPPER}} .elematic-load-more-btn:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
       );
       $this->add_control(
            'pagination_hover_bg_color',
            [
                'label'     => esc_html__( 'Hover Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination a:hover, {{WRAPPER}} .elematic-load-more-btn:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',
                ],
            ]
       );
       $this->add_responsive_control(
            'pagination_current_bg_color',
            [
                'label'     => esc_html__( 'Active Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination .current, {{WRAPPER}} .elematic-load-more-btn.elematic__loading' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'pagination' => 'show',

                ],
            ]
        );
       $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'pagination_typography',
                   'selector'  => '{{WRAPPER}} .elematic-pagination .page-numbers, {{WRAPPER}} .elematic-load-more-btn',
                   'condition' => [
                      'pagination' => 'show',
                    ],
              ]
       );
       $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'pagination_border',
                'selector' => '{{WRAPPER}} .elematic-pagination .page-numbers, {{WRAPPER}} .elematic-load-more-btn'
            ]
        );
        $this->add_responsive_control(
            'pagination_border_radius',
            [
                'label' => esc_html__( 'Pagination Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination .page-numbers, {{WRAPPER}} .elematic-load-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_padding',
            [
                'label' => esc_html__( 'Pagination Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination .page-numbers, {{WRAPPER}} .elematic-load-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'pagination_margin',
            [
                'label' => esc_html__( 'Pagination Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .elematic-pagination .page-numbers, {{WRAPPER}} .elematic-load-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

      $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();
        $style = $settings['grid_style']; // Get the selected style.
        $pagination = $settings['pagination'];
        $columns = $settings['columns'];

        if ( get_query_var('paged') ) :
            $paged = get_query_var('paged');
        elseif ( get_query_var('page') ) :
            $paged = get_query_var('page');
        else :
            $paged = 1;
        endif;

        $query_args = [
            'post_type' => $settings['post_type'],
            'posts_per_page' => $settings['number_of_posts'],
            'ignore_sticky_posts' => true,
            'post_status' => 'publish',
            'paged' => $paged,
        ];

        // Add orderby and order for most discussed posts
        if (!empty($settings['post_sortby']) && 'mostdiscussed' === $settings['post_sortby']) {
            $query_args['orderby'] = 'comment_count';
            $query_args['order'] = $settings['order'];
        } else {
            // Latest posts
            $query_args['orderby'] = $settings['orderby'];
            $query_args['order'] = $settings['order'];
        }

        // Add the tax_query dynamically if provided in settings
        // Using term_id instead of slug for optimal database performance
        if (!empty($settings['tax_query']) && is_array($settings['tax_query'])) {
            $tax_queries = $settings['tax_query'];
            $prepared_tax_query = array('relation' => 'OR');
            $term_ids_by_taxonomy = array(); // Group term IDs by taxonomy for better performance

            foreach ($tax_queries as $taxquery) {
                // Validate format
                if (!is_string($taxquery) || empty($taxquery) || strpos($taxquery, ':') === false) {
                    continue;
                }

                // Parse taxonomy and term
                list($tax, $term_slug) = explode(':', $taxquery, 2);
                $tax = trim($tax);
                $term_slug = trim($term_slug);
                
                // Validate taxonomy and term
                if (empty($tax) || empty($term_slug) || !taxonomy_exists($tax)) {
                    continue;
                }

                // Get term object - cached by WordPress and cache plugins
                $term_obj = get_term_by('slug', sanitize_title($term_slug), $tax);
                
                if ($term_obj && !is_wp_error($term_obj)) {
                    // Group terms by taxonomy for optimization
                    if (!isset($term_ids_by_taxonomy[$tax])) {
                        $term_ids_by_taxonomy[$tax] = array();
                    }
                    $term_ids_by_taxonomy[$tax][] = (int) $term_obj->term_id;
                }
            }

            // Build optimized tax_query - one query per taxonomy with multiple term_ids
            foreach ($term_ids_by_taxonomy as $taxonomy => $term_ids) {
                if (!empty($term_ids)) {
                    $prepared_tax_query[] = array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id', // Using term_id is more performant than slug
                        'terms'    => $term_ids,
                        'operator' => 'IN',
                    );
                }
            }

            // Only add tax_query if we have valid queries
            if (count($prepared_tax_query) > 1) {
                // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- Optimized with term_id and grouped by taxonomy
                $query_args['tax_query'] = $prepared_tax_query;
            }
        }

        $post_query = new \WP_Query( $query_args );

        // Remove unnecessary fields from the settings
        $settings = array_filter($settings, function($key) {
            // List of keys that are necessary for Load More functionality
            $necessary_keys = [
                'number_of_posts',
                'read_more_txt',
                'pagination',
                'load_more_text',
                'loading_text',
                'no_more_text',
                'grid_style',
                'tax_query',
                'columns',
                'image_size',
                'order',
                'post_sortby',
                'orderby',
                'date',
                'author',
                'title',
                'title_lenth',
                'post_category',
                'comments',
                'desc',
                'excerpt_words',
                'read_more',
                'pagination_style'
            ];
            return in_array($key, $necessary_keys);
        }, ARRAY_FILTER_USE_KEY);

        // Create a smaller JSON for data-settings
        $settings_json = json_encode($settings);
        ?>

        <div id="elematic-post-grid-wrapper-<?php echo esc_attr( $this->get_id() ); ?>" class="elematic-post-grid-wrapper">
            <?php
                if ($post_query->have_posts()) : 
                    while ($post_query->have_posts()) : $post_query->the_post();
                        // Render the post template based on the selected style.
                        $this->render_post_template( $style, $settings );
                    endwhile;
                    wp_reset_postdata();
                else:  
                    echo '<p>' . esc_html__( 'Sorry, nothing found.', 'elematic-addons-for-elementor' ) . '</p>';
                endif; ?>
        </div><!-- /elematic-post-grid-wrapper -->
        <div class="clearfix"></div>


            <!-- pagination -->
            <?php if( 'show' === $settings['pagination'] && 'loadmore' === $settings['pagination_style'] ) : ?>
                <div id="elematic_pagination_load_more" class="elematic-load-more">
                    <button 
                        id="elematic-load-more-btn-<?php echo esc_attr($this->get_id()); ?>" 
                        class="elematic-load-more-btn" 
                        type="button" 
                        data-widget-id="<?php echo esc_attr($this->get_id()); ?>"
                        data-loading-text="<?php echo esc_attr($settings['loading_text']); ?>" 
                        data-load-more-text="<?php echo esc_attr($settings['load_more_text']); ?>" 
                        data-no-more-text="<?php echo esc_attr($settings['no_more_text']); ?>" 
                        data-settings='<?php echo esc_attr( $settings_json ); ?>' 
                        data-page="1">
                        <?php echo esc_html($settings['load_more_text']); ?>
                    </button>
                </div>
            <?php elseif( 'show' === $settings['pagination'] && 'numbering' === $settings['pagination_style'] ) :
                Helper::elematic_pagination_number($post_query->max_num_pages,"",$paged);
            endif;
            

    } // function render()


    // Function to render the post template based on style.
    public static function render_post_template( $style, $settings ) {
        $template_file = __DIR__ . '/templates/' . $style . '.php';
        
        if ( file_exists( $template_file ) ) {
            include $template_file;
        } else {
            echo '<p>' . esc_html__( 'Template not found for the selected style.', 'elematic-addons-for-elementor' ) . '</p>';
        }
    }

} // class 
