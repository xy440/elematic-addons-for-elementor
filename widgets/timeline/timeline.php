<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\REPEATER;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Timeline extends Widget_Base {

    public function get_name() {
        return 'elematic-timeline';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Timeline', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-time-line';
    }
    
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }
    public function get_style_depends() {
        return [ 'elematic-timeline' ];
    }
    public function get_script_depends() {
        return [ 'elematic-timeline' ];
    }
	protected function register_controls() {
        $this->start_controls_section(
            'settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_control(
          'content_source',
            [
                'label'         => esc_html__( 'Content Source', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'dynamic',
                'label_block'   => false,
                'options'       => [
                    'custom'    => esc_html__( 'Custom', 'elematic-addons-for-elementor' ),
                    'dynamic'   => esc_html__( 'Dynamic', 'elematic-addons-for-elementor' ),
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'custom_img',
            [
                'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                            'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                            'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'toggle' => false,

            ],
        );
        $repeater->add_control(
            'custom_img_url',
            [
                        'label' => esc_html__('Image', 'elematic-addons-for-elementor'),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'label_block' => true,
                        'condition' => [
                            'custom_img' => 'show'
                        ]
                    ],
        );
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'medium_large',
            ]
        );
        $repeater->add_control(
            'custom_title',
            [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__( 'Your title goes here', 'elematic-addons-for-elementor' ),
            ],
        );
        $repeater->add_control(
            'custom_excerpt',
            [
                        'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::TEXTAREA,
                        'label_block' => true,
                        'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'elematic-addons-for-elementor' ),
                    ]

        );
        $repeater->add_control(
            'custom_post_date',
            [
                        'label' => esc_html__( 'Post Date', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => esc_html__( 'January 01, 2019', 'elematic-addons-for-elementor' ),
                    ]
                );

        $repeater->add_control(
            'custom_image_or_icon',
            [
                        'label' => esc_html__( 'Circle Image / Icon', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            'img' => [
                                'title' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                                'icon' => 'far fa-image',
                            ],
                            'icon' => [
                                'title' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                                'icon' => 'fa fa-info',
                            ],
                            
                        ],
                        'default' => 'icon',
                    ]
        );
        $repeater->add_control(
            'custom_icon_image',
            [
                        'label' => esc_html__( 'Circle Image', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::MEDIA,
                        'default' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'condition' => [
                            'custom_image_or_icon' => 'img',
                        ]
                    ]
        );
        $repeater->add_control(
            'custom_icon_image_size',
            [
                        'label' => esc_html__( 'Icon Image Size', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::NUMBER,
                        'default' => 24,
                        'condition' => [
                            'custom_image_or_icon' => 'img',
                        ],
                    ]
        );
        $repeater->add_control(
            'custom_circle_icon',
            [
                        'label' => esc_html__( 'Circle Icon', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::ICONS,
                        'fa4compatibility' => 'icon',
                        'default' => [
                            'value' => 'far fa-star',
                            'library' => 'fa-solid',
                        ],
                        'condition' => [
                            'custom_image_or_icon' => 'icon',
                        ]
                    ]
        );
        $repeater->add_control(
            'custom_circle_icon_size',
                [
                    'label' => esc_html__( 'Icon Size', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-timeline-icon svg' => 'width: {{SIZE}}px;',
                        '{{WRAPPER}} .elematic-timeline-icon i' => 'font-size: {{SIZE}}px;',
                    ],
                    'condition' => [
                    'custom_image_or_icon' => 'icon',
                ],
                ]
        );
        $repeater->add_control(
            'custom_btn',
            [
                        'label' => esc_html__( 'Button Text', 'elematic-addons-for-elementor' ),
                        'type' => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default' => esc_html__( 'Read More', 'elematic-addons-for-elementor' ),
                    ],
        );
         $repeater->add_control(
            'custom_btn_link',
            [
                'label'     => esc_html__( 'Button Link', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'elematic-addons-for-elementor' ),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );
        
        $this->add_control(
            'custom_content',
            [
                'type' => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'condition' => [
                    'content_source' => 'custom'
                ],
                'default' => [
                    [
                        'custom_title' => esc_html__( 'Lorem ipsum dolor sit amet', 'elematic-addons-for-elementor' ),
                        'custom_excerpt' => esc_html__( 'Consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'elematic-addons-for-elementor' ),
                        'custom_post_date' => 'January 01, 2019',
                        'custom_btn' => 'Read More',
                        'custom_btn_link' => '#',
                        
                    ],
                    [
                        'custom_title' => esc_html__( 'Lorem ipsum dolor sit amet', 'elematic-addons-for-elementor' ),
                        'custom_excerpt' => esc_html__( 'Consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'elematic-addons-for-elementor' ),
                        'custom_post_date' => 'February 14, 2019',
                        'custom_btn' => 'Read More',
                        'custom_btn_link' => '#',
                        
                    ],
                    [
                        'custom_title' => esc_html__( 'Lorem ipsum dolor sit amet', 'elematic-addons-for-elementor' ),
                        'custom_excerpt' => esc_html__( 'Consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'elematic-addons-for-elementor' ),
                        'custom_post_date' => 'March 26, 2019',
                        'custom_btn' => 'Read More',
                        'custom_btn_link' => '#',
                        
                    ],
                    [
                        'custom_title' => esc_html__( 'Lorem ipsum dolor sit amet', 'elematic-addons-for-elementor' ),
                        'custom_excerpt' => esc_html__( 'Consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'elematic-addons-for-elementor' ),
                        'custom_post_date' => 'April 14, 2019',
                        'custom_btn' => 'Read More',
                        'custom_btn_link' => '#',
                        
                    ]
                ],
                
                'title_field' => '{{{custom_title}}}',
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label' => esc_html__('Post Types', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post',
                'options' => Helper::get_all_post_types(),
                'condition' => [
                    'content_source' => 'dynamic'
                ]
                
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
                'condition' => [
                    'content_source' => 'dynamic'
                ]
                
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'medium_large',
                'condition' => [
                    'content_source' => 'dynamic'
                ]
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
                'condition' => [
                    'content_source' => 'dynamic'
                ]
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
                        'popularposts'    => esc_html__( 'Popular posts', 'elematic-addons-for-elementor' ),
                        'mostdiscussed'    => esc_html__( 'Most discussed', 'elematic-addons-for-elementor' ),
                    ],
                    'condition' => [
                    'content_source' => 'dynamic'
                ]
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
                    'content_source' => 'dynamic',
                    'post_sortby' => ['latestpost'],
                ]
            ]
        );
        $this->add_control(
            'number_of_posts',
            [
                'label' => esc_html__( 'Number of Posts', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '4',
                'condition' => [
                    'content_source' => 'dynamic'
                ]
            ]
        );
        $this->add_control(
            'offset',
            [
                'label' => esc_html__( 'Offset', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'content_source' => 'dynamic'
                ]
               
            ]
        );
        $this->add_control(
            'dynamic_circle_icon_choose',
            [
                'label' => esc_html__( 'Circle Image / Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'img' => [
                        'title' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                        'icon' => 'far fa-image',
                    ],
                    'icon' => [
                        'title' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                        'icon' => 'fa fa-info',
                    ],
                            
                ],
                'default' => 'icon',
                'condition' => [
                        'content_source' => 'dynamic'
                    ]
            ]
        );
        $this->add_control(
            'dy_circle_image',
            [
                'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'dynamic_circle_icon_choose' => 'img',
                    'content_source' => 'dynamic'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_dyn',
                'default' => 'full',
                'condition' => [
                    // 'image[url]!' => '',
                    'dynamic_circle_icon_choose' => 'img',
                    'content_source' => 'dynamic'
                ],
            ]
        );
        $this->add_control(
            'dy_circle_icon',
            [
                'label' => esc_html__( 'Icon', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'far fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'dynamic_circle_icon_choose' => 'icon',
                    'content_source' => 'dynamic'
                ]
            ]
        );
        $this->add_control(
            'dy_circle_icon_size',
                [
                    'label' => esc_html__( 'Icon Size', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 50,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-timeline-icon svg' => 'width: {{SIZE}}px;',
                        '{{WRAPPER}} .elematic-timeline-icon i' => 'font-size: {{SIZE}}px;',
                    ],
                    'condition' => [
                    'dynamic_circle_icon_choose' => 'icon',
                    'content_source' => 'dynamic'
                ],
                ]
        );
        $this->add_control(
            'dy_image',
            [
                'label' => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
                'separator' => 'before',
                'condition' => [
                    'content_source' => 'dynamic'
                ]
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show'
            ]
        );
        $this->add_control(
            'excerpt',
            [
                'label' => esc_html__( 'Excerpt', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show',
            ]
        );
        $this->add_control(
          'desc_limit',
          [
            'label'         => esc_html__( 'Description Letter Limit', 'elematic-addons-for-elementor' ),
            'type'          => Controls_Manager::NUMBER,
            'default'       => 12,
            'condition' => [
                'excerpt' => 'show',
                'content_source' => 'dynamic'
            ],
          ]
        );
        $this->add_control(
            'date',
            [
                'label' => esc_html__( 'Date', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'show' => [
                        'title' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'hide' => [
                        'title' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'show'
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
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'              => 'content_bg',
                'label'             => esc_html__( 'Content Background', 'elematic-addons-for-elementor' ),
                'types'             => [ 'classic', 'gradient' ],
                'selector'          => '{{WRAPPER}} .elematic-timeline-content',
            ]
        );
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Content Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                        '{{WRAPPER}} .elematic-timeline-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'content_border',
                    'label' => esc_html__( 'Content Border', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-timeline-content',
                ]
            );

        $this->add_control(
            'content_border_radius',
                [
                    'label' => esc_html__( 'Content Border Radius', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::SLIDER,
                    'range' => [
                        'px' => [
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-timeline-content' => 'border-radius: {{SIZE}}px;',
                    ],
                ]
        );
        $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'content_shadow',
                    'selector' => '{{WRAPPER}} .elematic-timeline-content',
                ]
        );
        $this->add_control(
            'content_arrow_color',
            [
                'label'     => esc_html__( 'Content Arrow Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-container:nth-child(even) .elematic-timeline-content::before' => 'border-right-color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-timeline-container:nth-child(odd) .elematic-timeline-content::before' => 'border-left-color: {{VALUE}};',
                    
                ],
            ]
        );
        
        $this->add_control(
            'line_color',
            [
                'label'     => esc_html__( 'Line Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-line' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before'
                
            ]
        );
        $this->add_control(
            'overline_color',
            [
                'label'     => esc_html__( 'Over Line Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-line-over.elematic-highlighted, {{WRAPPER}} .elematic-timeline-line .elematic-timeline-line-over' => 'background-color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            'line_icon_color',
            [
                'label'     => esc_html__( 'Line Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-timeline-icon svg' => 'fill: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            'line_icon_bg_color',
            [
                'label'     => esc_html__( 'Line Icon Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-icon' => 'background-color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-content h3' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'title_typography',
                   'selector'  => '{{WRAPPER}} .elematic-timeline-content h3',
                   'condition' => [
                      'title' => 'show',
                    ],
              ]
        );
        $this->add_control(
            'excerpt_color',
            [
                'label'     => esc_html__( 'Excerpt Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
               
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-custom-excerpt, {{WRAPPER}} .elematic-excerpt' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                      'excerpt' => 'show',
                    ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'excerpt_typography',
                   'selector'  => '{{WRAPPER}} .elematic-timeline-custom-excerpt, {{WRAPPER}} .elematic-excerpt',
                    'condition' => [
                      'excerpt' => 'show',
                    ],
              ]
        );
        $this->add_control(
            'date_color',
            [
                'label'     => esc_html__( 'Date Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-date' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'date' => 'show',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'date_typography',
                   'selector'  => '{{WRAPPER}} .elematic-timeline-date, {{WRAPPER}} .elematic-timeline-date .post-time',
                   'condition' => [
                      'date' => 'show',
                    ],
              ]
        );
        $this->add_control(
            'btn_color',
            [
                'label'     => esc_html__( 'Button Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-btn a, {{WRAPPER}} .elematic-read-more a' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
                
            ]
        );
        $this->add_control(
            'btn_hov_color',
            [
                'label'     => esc_html__( 'Button Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-btn a:hover, {{WRAPPER}} .elematic-read-more:hover a' => 'color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_control(
            'btn_bg_color',
            [
                'label'     => esc_html__( 'Button Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-btn a, {{WRAPPER}} .elematic-read-more' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'btn_bg_hov_color',
            [
                'label'     => esc_html__( 'Button Background Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-timeline-btn a:hover, {{WRAPPER}} .elematic-read-more:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'btn_typography',
                   'selector'  => '{{WRAPPER}} .elematic-timeline-btn a, {{WRAPPER}} .elematic-read-more a',
              ]
        );
        $this->add_responsive_control(
            'btn_spacing',
            [
                'label' => esc_html__( 'Button Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} elematic-timeline-btn a, {{WRAPPER}} .elematic-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
      $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        // $taxonomy_filter = $settings['taxonomy_filter'];
        // $showposts = '';
        // $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
        // $query_args = TX_Helper::setup_query_args($settings, $showposts);
        // $post_query = new \WP_Query( $query_args );
        $paged = Helper::get_current_page();
        $query_args = Helper::setup_query_args( $settings, $paged );
        $post_query = new \WP_Query( $query_args );
        $post_query = Helper::fix_query_offset_pagination( $post_query, $settings );
        ?>


        <?php if($settings['content_source'] == 'dynamic') : ?>
        <div id="elematic-timeline-<?php echo esc_attr( $this->get_id() ); ?>" class="elematic-timeline-wrap">
            <?php if ($post_query->have_posts()) : ?>
                <?php while ($post_query->have_posts()) : $post_query->the_post(); ?>
                    <div class="elematic-timeline-container">
                        <div class="elematic-timeline-line">
                            <div class="elematic-timeline-line-over"></div>
                        </div>
                        <div class="elematic-timeline-icon">
                            <?php if( 'img' === $settings['dynamic_circle_icon_choose'] ) : ?>

                            <?php Group_Control_Image_Size::print_attachment_image_html($settings, 'image_dyn', 'dy_circle_image'); ?>

                            <?php elseif( $settings['dynamic_circle_icon_choose'] == 'icon' ) : 
                                Icons_Manager::render_icon( $settings['dy_circle_icon'], [ 'aria-hidden' => 'true' ] );
                            endif; ?>
                        </div>
                        <div class="elematic-timeline-content">

                            <?php if (has_post_thumbnail() && $settings['dy_image'] == 'show') : ?>
                                <div class="zoom-thumb featured-thumb">
                                    <?php
                                        print(wp_get_attachment_image(
                                            get_post_thumbnail_id(),
                                            $settings['image_size'],
                                            false,
                                            [
                                                'alt' => esc_html(get_the_title())
                                            ]
                                        ));
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if($settings['title'] == 'show') : ?>
                                <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                            <?php endif; ?>

                            <?php if($settings['excerpt'] == 'show') : ?>
                                <div class="elematic-timeline-custom-excerpt">
                                    <?php
                                        global $post;
                                        $elementor  = get_post_meta( $post->ID, '_elementor_edit_mode', true );                          
                                        if ( $elementor ) {
                                            $frontend = new Frontend;
                                            echo wp_kses_post( $frontend->get_builder_content( $post->ID, true ) );
                                        } else {
                                            echo esc_html( Helper::excerpt_limit($settings['desc_limit']) );
                                        }
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($settings['date'] == 'show') : ?>
                                <span class="elematic-timeline-date"><?php echo wp_kses_post(Helper::elematic_date()); ?></span>
                            <?php endif; ?>

                        </div><!-- elematic-timeline-content -->
                    </div><!-- elematic-timeline-container -->
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
                <?php endif; ?>
        </div><!-- elematic-timeline-wrap -->
        

        <?php elseif($settings['content_source'] == 'custom') : ?>
        <div id="elematic-timeline-<?php echo esc_attr( $this->get_id() ); ?>" class="elematic-timeline-wrap">
                <?php foreach ($settings['custom_content'] as $custom_content) : ?>
                    <div class="elematic-timeline-container">
                        <div class="elematic-timeline-line">
                            <div class="elematic-timeline-line-over"></div>
                        </div>
                       <div class="elematic-timeline-icon">
                            <?php if( 'img' === $custom_content['custom_image_or_icon'] ) : ?>
                            <img src="<?php echo esc_attr($custom_content['custom_icon_image']['url']); ?>" style="width: <?php echo esc_attr($custom_content['custom_icon_image_size']); ?>px;" alt="Timeline Image" >
                            <?php elseif( $custom_content['custom_image_or_icon'] == 'icon' ) : 
                                Icons_Manager::render_icon( $custom_content['custom_circle_icon'], [ 'aria-hidden' => 'true' ] );
                            endif; ?>
                        </div>
                        <div class="elematic-timeline-content">

                            <?php if( 'show' === $custom_content['custom_img'] ) : ?>
                                <?php Group_Control_Image_Size::print_attachment_image_html( $custom_content, 'image', 'custom_img_url' ); ?>
                            <?php endif; ?>

                            <?php if( 'show' === $settings['title'] ) : ?>
                                <h3><?php echo wp_kses_post($custom_content['custom_title']); ?></h3>
                            <?php endif; ?>

                            <?php if( 'show' === $settings['excerpt'] ) : ?>
                                <div class="elematic-timeline-custom-excerpt"><?php echo wp_kses_post($custom_content['custom_excerpt']); ?></div>
                            <?php endif; ?>

                            <?php if ( $custom_content['custom_btn_link']['is_external'] && !empty($custom_content['custom_btn'])) : ?>
                                <div class="elematic-timeline-btn">
                                <a href="<?php echo esc_url($custom_content['custom_btn_link']['url']); ?>" target="_blank"><?php echo esc_html( $custom_content['custom_btn'] ); ?></a>
                                </div>
                            <?php elseif(!empty($custom_content['custom_btn'])) : ?>
                                <div class="elematic-timeline-btn">
                                <a href="<?php echo esc_url($custom_content['custom_btn_link']['url']); ?>"><?php echo esc_html( $custom_content['custom_btn'] ); ?></a>
                                </div>
                            <?php endif; ?>

                            <?php if( 'show' === $settings['date'] ) : ?>
                                <span class="elematic-timeline-date"><?php echo wp_kses_post($custom_content['custom_post_date']); ?></span>
                            <?php endif; ?>

                        </div><!-- elematic-timeline-content -->
                    </div><!-- elematic-timeline-container -->
                <?php endforeach; ?>
        </div><!-- elematic-timeline-wrap -->
        <?php endif; ?>


<?php   } // function render()
} // class 
