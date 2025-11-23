<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Gallery extends Widget_Base {

    public function get_name() {
        return 'elematic-gallery';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Gallery', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_script_depends() {
        return [ 'elematic-gallery', 'isotope', 'imagesloaded' ];
    }

    public function get_style_depends() {
        return [ 'elematic-gallery' ];
    }

    public function get_keywords() {
        return [
            'gallery',
            'filter',
            'filterable',
            'image',
            'media',
            'photo',
            'picture',
            'portfolio',
            'grid',
            'masonry',
            'responsive',
            'isotope',
            'search'
        ];
    }

    protected function register_controls() {
        // gallery item
        $this->start_controls_section(
            'gallery_settings',
            [
                'label' => esc_html__('Gallery', 'elematic-addons-for-elementor'),
            ]
        );
              
        $repeater = new Repeater();
        
        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => ELEMATIC_URL . 'assets/images/gallery/gall-1.jpg',
                ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'full',
            ]
        );
        $repeater->add_control(
            'gall_img_name',
            [
                'label' => esc_html__('Image Name', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => esc_html__('Image Name', 'elematic-addons-for-elementor'),
            ]
        );
        $repeater->add_control(
            'gall_img_link_url',
            [
                'label'       => esc_html__( 'Image Link URL', 'elematic-addons-for-elementor' ),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
            ]
        );
        $repeater->add_control(
            'gall_filter_name',
            [
                'label' => esc_html__('Filter Name', 'elematic-addons-for-elementor'),
                'description' => esc_html__('Add the filter name from "Filters" section', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => '',
            ]
        );
        $repeater->add_control(
            'gall_desc',
            [
                'label' => esc_html__('Description', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'default' => '',
            ]
        );
        $this->add_control(
            'gall_items',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [
                        'gall_img_name' => 'Alpha',
                        'gall_filter_name' => 'Mono',
                        'image' => ['url' => ELEMATIC_URL . 'assets/images/gallery/gall-1.jpg'],
                        'gall_img_link_url' => ['url' => '#'],
                    ],
                    [
                        'gall_img_name' => 'Beta',
                        'gall_filter_name' => 'Di',
                        'image' => ['url' => ELEMATIC_URL . 'assets/images/gallery/gall-2.jpg'],
                        'gall_img_link_url' => ['url' => '#'],
                    ],
                    [
                        'gall_img_name' => 'Gamma',
                        'gall_filter_name' => 'Tri',
                        'image' => ['url' => ELEMATIC_URL . 'assets/images/gallery/gall-3.jpg'],
                        'gall_img_link_url' => ['url' => '#'],
                    ],
                    [
                        'gall_img_name' => 'Delta',
                        'gall_filter_name' => 'Tetra',
                        'image' => ['url' => ELEMATIC_URL . 'assets/images/gallery/gall-4.jpg'],
                        'gall_img_link_url' => ['url' => '#'],
                    ],
                    [
                        'gall_img_name' => 'Epsilon',
                        'gall_filter_name' => 'Penta',
                        'image' => ['url' => ELEMATIC_URL . 'assets/images/gallery/gall-5.jpg'],
                        'gall_img_link_url' => ['url' => '#'],
                    ],
                    [
                        'gall_img_name' => 'Zeta',
                        'gall_filter_name' => 'Hexa',
                        'image' => ['url' => ELEMATIC_URL . 'assets/images/gallery/gall-6.jpg'],
                        'gall_img_link_url' => ['url' => '#'],
                    ],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{gall_img_name}}',
            ]
        );
        
        $this->end_controls_section();

        // Filter
        $this->start_controls_section(
            'eael_section_fg_control_settings',
            [
                'label' => esc_html__('Filters', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'gall_filter_controls',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => 
                    [
                        ['gall_filter_item' => 'Mono'],
                        ['gall_filter_item' => 'Di'],
                        ['gall_filter_item' => 'Tri'],
                        ['gall_filter_item' => 'Tetra'],
                        ['gall_filter_item' => 'Penta'],
                        ['gall_filter_item' => 'Hexa'],
                    ],
                'fields' => [
                    [
                        'name' => 'gall_filter_item',
                        'label' => esc_html__('Filter Item', 'elematic-addons-for-elementor'),
                        'type' => Controls_Manager::TEXT,
                        'dynamic'   => ['active' => true],
                        'label_block' => false,
                        'default' => [],
                        'description' => esc_html__('Add the filter name here and set the same name on "Gallery" section', 'elematic-addons-for-elementor'),
                    ],
                ],
                'condition' => [
                    'gall_filter' => 'yes'
                ],
                'title_field' => '{{gall_filter_item}}',
            ]
        );
        
        $this->end_controls_section();

        // settings
        $this->start_controls_section(
            'gall_settings',
            [
                'label' => esc_html__('Settings', 'elematic-addons-for-elementor'),
            ]
        );
        $this->add_responsive_control(
            'gall_cols',
            [
                'label' => esc_html__( 'Columns', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,             
                'desktop_default' => '33.333%',
                'tablet_default' => '50%',
                'mobile_default' => '100%',
                'options' => [
                    '100%' => esc_html__( '1 Column', 'elematic-addons-for-elementor' ),
                    '50%' => esc_html__( '2 Column', 'elematic-addons-for-elementor' ),
                    '33.333%' => esc_html__( '3 Columns', 'elematic-addons-for-elementor' ),
                    '25%' => esc_html__( '4 Columns', 'elematic-addons-for-elementor' ),
                    '20%' => esc_html__( '5 Columns', 'elematic-addons-for-elementor' ),
                    '16.666%' => esc_html__( '6 Columns', 'elematic-addons-for-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-item' => 'width: {{VALUE}};',
                ],
                'render_type' => 'template'
            ]
        );
        $this->add_control(
            'layoutMode',
            [
                'label' => esc_html__('Layout', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fitRows',
                'options' => [
                    'fitRows' => esc_html__('Grid', 'elematic-addons-for-elementor'),
                    'masonry' => esc_html__('Masonry', 'elematic-addons-for-elementor'),
                ],
            ]
        );
        $this->add_control(
            'gall_img_style',
            [
                'label' => esc_html__('Style', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'elematic-gallery-style-1',
                'options' => [
                    'elematic-gallery-style-1' => esc_html__('Normal', 'elematic-addons-for-elementor'),
                    'elematic-gallery-style-2' => esc_html__('Hover', 'elematic-addons-for-elementor'),
                    'elematic-gallery-style-3' => esc_html__('Whole Image Clickable', 'elematic-addons-for-elementor'),
                    'elematic-gallery-style-4' => esc_html__('Whole Image Lightbox', 'elematic-addons-for-elementor'),
                ],
            ]
        );
        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Image Hover Animation', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'transitionDuration',
            [
                'label' => esc_html__( 'Filter Animation', 'elematic-addons-for-elementor' ),
                'description' => esc_html__( 'If hover animation conflicts with Filter animation then you can set it OFF', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'elematic-addons-for-elementor' ),
                'label_off' => esc_html__( 'Off', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'gall_filter',
            [
                'label' => esc_html__( 'Filters', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Enable', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'Disable', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'gall_all_label_text',
            [
                'label' => esc_html__('Filter All Label Text', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic'     => [ 'active' => true ],
                'default' => 'All',
                'condition' => [
                    'gall_filter' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'gall_search',
            [
                'label' => esc_html__( 'Search', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Enable', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'Disable', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'yes',
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'gall_search_position',
            [
                'label' => esc_html__('Layout', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'above',
                'options' => [
                    'above' => esc_html__('Above Filter', 'elematic-addons-for-elementor'),
                    'below' => esc_html__('Below Filter', 'elematic-addons-for-elementor'),
                ],
                'condition' => [
                    'gall_search' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'gall_search_text',
            [
                'label' => esc_html__('Search Text', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'dynamic'     => [ 'active' => true ],
                'default' => 'Search...',
                'condition' => [
                    'gall_search' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'tx_lightbox',
            [
                'label' => esc_html__( 'Display Lightbox Icon', 'elematic-addons-for-elementor' ),
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
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'gall_link_switch',
            [
                'label' => esc_html__( 'Display Link Icon', 'elematic-addons-for-elementor' ),
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
            'gall_img_name_switch',
            [
                'label' => esc_html__( 'Display Image Name', 'elematic-addons-for-elementor' ),
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
            'gall_filter_switch',
            [
                'label' => esc_html__( 'Display Filter Name', 'elematic-addons-for-elementor' ),
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
        $this->end_controls_section();
        
        // Styles
        $this->start_controls_section(
            'img_styles',
            [
              'label'   => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'gall_img_spacing',
            [
                'label'   => esc_html__( 'Image Spacing', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 50,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-item'   => 'padding: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-gallery-overlay'   => 'margin: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'gall_img_border',
                'label' => esc_html__( 'Image Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-gallery-item img',
            ]
        );
        $this->add_responsive_control(
            'gall_img_border_radius',
            [
                'label'   => esc_html__( 'Image Border Radius', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-item img, {{WRAPPER}} .elematic-gallery-overlay'   => 'border-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-gallery-title-bar'   => 'border-bottom-left-radius: {{SIZE}}{{UNIT}};border-bottom-right-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'gall_img_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-gallery-item img',
            ]
        );
        $this->end_controls_section();
       
        $this->start_controls_section(
            'gall_name_desc_styles',
            [
              'label'   => esc_html__( 'Name & Description', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'img_name_bar_color',
            [
                'label'     => esc_html__( 'Image Name Bar Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-title-bar' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_img_name_switch' => 'show'
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'img_name_bar_position',
            [
                'label'   => esc_html__( 'Image Name Bar Position', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 100,
                        'min'  => -100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-style-1 .elematic-gallery-title-bar, {{WRAPPER}} .elematic-gallery-style-2 .elematic-gallery-title-bar'   => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-gallery-style-3 .elematic-gallery-title-bar, {{WRAPPER}} .elematic-gallery-style-4 .elematic-gallery-title-bar'   => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gall_img_name_switch' => 'show'
                ],
            ]
        );
        $this->add_control(
            'img_name_color',
            [
                'label'     => esc_html__( 'Image Name Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-name, {{WRAPPER}} .elematic-gallery-name a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_img_name_switch' => 'show'
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'img_name_color_hover',
            [
                'label'     => esc_html__( 'Image Name Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-name:hover, {{WRAPPER}} .elematic-gallery-name a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_img_name_switch' => 'show'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'img_name_typography',
                   'label'     => esc_html__( 'Image Name Typography', 'elematic-addons-for-elementor' ),
                   'selector'  => '{{WRAPPER}} .elematic-gallery-name, {{WRAPPER}} .elematic-gallery-name a',
                   'condition' => [
                    'gall_img_name_switch' => 'show'
                ]
              ]
        );
        $this->add_responsive_control(
          'gall_name_alignment',
          [
            'label' => esc_html__( 'Image Name Alignment', 'elematic-addons-for-elementor' ),
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
              '{{WRAPPER}} .elematic-gallery-name' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                          'gall_filter_switch' => 'hide',
                        ],
          ]
        );
        $this->add_control(
            'img_filter_name_color',
            [
                'label'     => esc_html__( 'Image Filter Name Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-categoy' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_filter_switch' => 'show'
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'img_filter_name_typography',
                   'label'     => esc_html__( 'Image Filter Name Typography', 'elematic-addons-for-elementor' ),
                   'selector'  => '{{WRAPPER}} .elematic-gallery-categoy',
                   'condition' => [
                        'gall_filter_switch' => 'show'
                    ]
              ]
        );
        $this->add_control(
            'img_desc_color',
            [
                'label'     => esc_html__( 'Image Description Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-desc > *' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'img_desc_typography',
                   'label'     => esc_html__( 'Image Description Typography', 'elematic-addons-for-elementor' ),
                   'selector'  => '{{WRAPPER}} .elematic-gallery-desc > *',
              ]
        );
        $this->add_responsive_control(
          'gall_desc_alignment',
          [
            'label' => esc_html__( 'Image Description Alignment', 'elematic-addons-for-elementor' ),
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
              '{{WRAPPER}} .elematic-gallery-desc > *' => 'text-align: {{VALUE}};',
            ],
           
          ]
        );
        $this->end_controls_section();
        
        $this->start_controls_section(
            'overlay_styles',
            [
              'label'   => esc_html__( 'Overlay', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'gall_overlay_color',
            [
                'label'     => esc_html__( 'Overlay Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => 'rgba(0,0,0,.2)',
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-overlay' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'gall_overlay_margin',
            [
                'label' => esc_html__('Overlay Margin', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-overlay' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'icons_styles',
            [
              'label'   => esc_html__( 'Icons', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'gall_icon_font_size',
            [
                'label'   => esc_html__( 'Icons Size', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-icons i'   => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'gall_icons_position',
            [
                'label'   => esc_html__( 'Icon Position (Y)', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-icons'   => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );  
        $this->add_responsive_control(
            'gall_icons_spacing',
            [
                'label'   => esc_html__( 'Icon Spacing', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 50,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-popup'   => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-gallery-link'   => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );
        $this->add_control(
            'gall_lb_icon_color',
            [
                'label'     => esc_html__( 'Lightbox Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-popup i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_popup_switch' => 'show'
                ]
            ]
        );
        $this->add_control(
            'gall_lb_icon_hov_color',
            [
                'label'     => esc_html__( 'Lightbox Icon Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-popup i:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_popup_switch' => 'show'
                ]
            ]
        );
        $this->add_control(
            'gall_link_icon_color',
            [
                'label'     => esc_html__( 'Link Icon Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-link i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_link_switch' => 'show'
                ]
            ]
        );
        $this->add_control(
            'gall_link_icon_hov_color',
            [
                'label'     => esc_html__( 'Link Icon Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-link i:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gall_link_switch' => 'show'
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'filter_styles',
            [
              'label'   => esc_html__( 'Filters', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
              'condition' => [
                            'gall_filter' => 'yes'
                        ],
            ]
        );
        $this->add_responsive_control(
          'gall_filter_alignment',
          [
            'label' => esc_html__( 'Filter Alignment', 'elematic-addons-for-elementor' ),
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
            'default' => 'center',
            'selectors' => [
              '{{WRAPPER}} .elematic-gallery-filters' => 'text-align: {{VALUE}};',
            ],
       
          ]
        );
        $this->add_responsive_control(
            'gall_filter_margin',
            [
                'label' => esc_html__('Margin', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-filters' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
                    Group_Control_Border::get_type(),
                    [
                        'name' => 'gall_filter_border',
                        'label' => esc_html__( 'Filter Item Border', 'elematic-addons-for-elementor' ),
                        'selector' => '{{WRAPPER}} .elematic-gallery-filter-item',
                        
                    ]
                );
                $this->add_responsive_control(
                    'gall_filter_item_radius',
                    [
                        'label' => esc_html__('Filter Item Border Radius', 'elematic-addons-for-elementor'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        
                    ]
                );
                $this->add_responsive_control(
                    'gall_filter_item_padding',
                    [
                        'label' => esc_html__('Filter Item Padding', 'elematic-addons-for-elementor'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        
                    ]
                );
                $this->add_responsive_control(
                    'gall_filter_item_margin',
                    [
                        'label' => esc_html__('Filter Item Margin', 'elematic-addons-for-elementor'),
                        'type' => Controls_Manager::DIMENSIONS,
                        'size_units' => ['px', 'em', '%'],
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                        
                    ]
                );
                $this->add_group_control(
                    Group_Control_Typography::get_type(),
                      [
                           'name'    => 'gall_filter_item_typography',
                           'selector'  => '{{WRAPPER}} .elematic-gallery-filter-item',
                      ]
                );
        $this->start_controls_tabs('style_filter_tabs');

            $this->start_controls_tab( 
                'style_filter_normal', 
                [ 
                    'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ) 
                ] 
            );
                $this->add_control(
                    'gall_filter_item_color',
                    [
                        'label'     => esc_html__( 'Filter Item Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item' => 'color: {{VALUE}};',
                        ],
                        
                        'separator' => 'before'
                    ]
                );
                $this->add_control(
                    'gall_filter_item_bg_color',
                    [
                        'label'     => esc_html__( 'Filter Item Background Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item' => 'background-color: {{VALUE}};',
                        ],

                    ]
                );
                $this->add_control(
                    'gall_filter_item_border_color',
                    [
                        'label'     => esc_html__( 'Filter Item Border Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item' => 'border-color: {{VALUE}};',
                        ],

                    ]
                );
                
            $this->end_controls_tab();

            $this->start_controls_tab( 
                'style_filter_hover', 
                [ 
                    'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ) 
                ] 
            );
                $this->add_control(
                    'gall_filter_item_hov_color',
                    [
                        'label'     => esc_html__( 'Filter Item Hover Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item:hover' => 'color: {{VALUE}};',
                        ],
                       
                    ]
                );
                $this->add_control(
                    'gall_filter_item_bg_hov_color',
                    [
                        'label'     => esc_html__( 'Filter Item Background Hover Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item:hover' => 'background-color: {{VALUE}};',
                        ],
                        
                    ]
                );
                $this->add_control(
                    'gall_filter_item_border_hov_color',
                    [
                        'label'     => esc_html__( 'Filter Item Border Hover Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item:hover' => 'border-color: {{VALUE}};',
                        ],
                        
                    ]
                );
            $this->end_controls_tab();

            $this->start_controls_tab( 
                'style_filter_active', 
                [ 
                    'label' => esc_html__( 'Active', 'elematic-addons-for-elementor' ) 
                ] 
            );
                $this->add_control(
                    'gall_filter_item_active_color',
                    [
                        'label'     => esc_html__( 'Filter Item Active Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item.active' => 'color: {{VALUE}};',
                        ],
                       
                    ]
                );
                $this->add_control(
                    'gall_filter_item_active_bg_color',
                    [
                        'label'     => esc_html__( 'Filter Item Active Background Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item.active' => 'background-color: {{VALUE}};',
                        ],
                        
                    ]
                );
                $this->add_control(
                    'gall_filter_item_active_border_color',
                    [
                        'label'     => esc_html__( 'Filter Item Active Border Color', 'elematic-addons-for-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .elematic-gallery-filter-item.active' => 'border-color: {{VALUE}};',
                        ],
                        
                    ]
                );

            $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'gall_search_styles',
            [
              'label'   => esc_html__( 'Search', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
              'condition' => [
                    'gall_search' => 'yes'
                ],
            ]
        );
        $this->add_responsive_control(
          'gall_search_alignment',
          [
            'label' => esc_html__( 'Search Alignment', 'elematic-addons-for-elementor' ),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
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
              '{{WRAPPER}} .elematic-gallery-search' => 'text-align: {{VALUE}};',
            ],
       
          ]
        );
        $this->add_responsive_control(
            'gall_search_width',
            [
                'label'   => esc_html__( 'Search Width', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'size_units' => [ '%', 'px', 'em', ],
                'default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'tablet_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                 'mobile_default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search-input'   => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'gall_search_height',
            [
                'label'   => esc_html__( 'Search Height', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', ],
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 300,
                        'min'  => 0,
                    ],
                ],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'tablet_default' => [
                    // 'size' => 100,
                    'unit' => 'px',
                ],
                 'mobile_default' => [
                    // 'size' => 100,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search-input'   => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'gall_search_radius',
            [
                'label'   => esc_html__( 'Search Border Radius', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'max'  => 100,
                        'min'  => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search-input'   => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'gall_search_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-gallery-search-input'
            ]
        );
        $this->add_control(
            'gall_search_color',
            [
                'label'     => esc_html__( 'Search Input Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search-input' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'gall_search_bg_color',
            [
                'label'     => esc_html__( 'Search Input Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'gall_search_placeholder_color',
            [
                'label'     => esc_html__( 'Search Placeholder Text Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search-input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'gall_search_typography',
                   'selector'  => '{{WRAPPER}} .elematic-gallery-search-input',
              ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'gall_search_border',
                'label' => esc_html__( 'Search Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-gallery-search-input',
            ]
        );
        $this->add_responsive_control(
            'gall_search_margin',
            [
                'label' => esc_html__('Margin', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'gall_search_padding',
            [
                'label' => esc_html__('Padding', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elematic-gallery-search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
          'gall_search_input_alignment',
          [
            'label' => esc_html__( 'Search Text Alignment', 'elematic-addons-for-elementor' ),
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
              '{{WRAPPER}} .elematic-gallery-search-input' => 'text-align: {{VALUE}};',
            ],
       
          ]
        );
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->get_id();

        $this->add_render_attribute(
            [
                'elematic-gallery' => [
                    'class' => [
                        'elematic-gallery-wrap',
                        $settings['gall_img_style']
                    ],
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'columnWidth' => $settings['gall_cols'],
                            'layoutMode'  => $settings['layoutMode'],
                            'transitionDuration' => $settings["transitionDuration"] ? 400:0,
                        ]))
                    ]
                ]
            ]
        );

    ?>
        
    <div <?php $this->print_render_attribute_string( 'elematic-gallery' ); ?>>
        
        <?php if('above' === $settings['gall_search_position']): ?>
            <?php if( 'yes' === $settings['gall_search'] ) : ?>
            <div class="elematic-gallery-search">
                <?php if(is_rtl()): ?>
                <input id="elematic-gallery-search-<?php echo esc_attr($id); ?>" class="elematic-gallery-search-input" name="search" type="text"  placeholder="<?php echo esc_attr( $settings['gall_search_text'] ); ?>" onfocus="this.placeholder = ''"onblur="this.placeholder = '<?php echo esc_attr( $settings['gall_search_text'] ); ?>'" >
                <?php else : ?>
                    <input id="elematic-gallery-search-<?php echo esc_attr($id); ?>" class="elematic-gallery-search-input" name="search" type="text"  placeholder="<?php echo esc_attr( $settings['gall_search_text'] ); ?>" onfocus="this.placeholder = ''"onblur="this.placeholder = '<?php echo esc_attr( $settings['gall_search_text'] ); ?>'"  >
                <?php endif; ?>
            </div><!-- elematic-gallery-search -->
            <?php endif; ?>
        <?php endif; ?>
    
        <?php if( 'yes' === $settings['gall_filter'] ) : ?>
            <ul id="elematic-gallery-filters-<?php echo esc_attr($id); ?>" class="elematic-gallery-filters">
                <li id="elematic-gallery-filter-item-<?php echo esc_attr($id); ?>" class="elematic-gallery-filter-item" data-filter="*"><?php echo esc_attr( $settings['gall_all_label_text'] ); ?></li>
                <?php foreach ($settings['gall_filter_controls'] as $item ) :
                    $filter = $item['gall_filter_item'];
                            $sps = preg_replace('/\s+/', '', $filter);
                            $filt = strtolower($sps);
                if(!empty($item['gall_filter_item'])) :
                ?>
                <li id="elematic-gallery-filter-item-<?php echo esc_attr($id); ?>" class="elematic-gallery-filter-item" data-filter=".<?php echo esc_attr($filt); ?>"><?php echo esc_attr($item['gall_filter_item']); ?></li>
                <?php
                endif; 
                endforeach; 
                ?>
            </ul><!-- elematic-gallery-filter -->
        <?php endif; ?>

        <?php if('below' === $settings['gall_search_position']): ?>
        <?php if( 'yes' === $settings['gall_search'] ) : ?>
            <div class="elematic-gallery-search">
                <?php if(is_rtl()): ?>
                <input id="elematic-gallery-search-<?php echo esc_attr($id); ?>" class="elematic-gallery-search-input" name="search" type="text"  placeholder="<?php echo esc_attr( $settings['gall_search_text'] ); ?> &#61442;" onfocus="this.placeholder = ''"onblur="this.placeholder = '<?php echo esc_attr( $settings['gall_search_text'] ); ?> &#61442;'" >
                <?php else : ?>
                    <input id="elematic-gallery-search-<?php echo esc_attr($id); ?>" class="elematic-gallery-search-input" name="search" type="text"  placeholder=" &#61442; <?php echo esc_attr( $settings['gall_search_text'] ); ?>" onfocus="this.placeholder = ''"onblur="this.placeholder = ' &#61442; <?php echo esc_attr( $settings['gall_search_text'] ); ?>'"  >
                <?php endif; ?>
            </div><!-- elematic-gallery-search -->
        <?php endif; ?>
        <?php endif; ?>

            <div id="elematic-gallery-grid-<?php echo esc_attr($id); ?>" class="elematic-gallery-grid">
                <?php 
                    foreach ($settings['gall_items'] as $index => $item ) :

                        $cat = $item['gall_filter_name'];
                        $ns = preg_replace('/\s+/', '', $cat);
                        $fil = strtolower($ns);
                        $fill_expl = explode(',', $fil );
                        $fill_cat = implode(' ', $fill_expl);

                        $in = $item['gall_img_name'];
                        $rs = preg_replace('/\s+/', '', $in);
                        $data = strtolower($rs);

                        $target = $item['gall_img_link_url']['is_external'] ? '_blank' : '_self';
                        $img_url = $item['image']['url'];
                        $lightbox = 'tx_lightbox' . $index;
                        $this->add_render_attribute(
                            [
                                $lightbox => [
                                    'data-elementor-open-lightbox' => $settings['tx_lightbox'],
                                    'data-elementor-lightbox-slideshow' => $this->get_id(),
                                    'href' => $img_url,
                                ]
                            ]
                        );

                        ?>
                    <?php if( 'elematic-gallery-style-1' === $settings['gall_img_style'] || 'elematic-gallery-style-2' === $settings['gall_img_style'] ) : ?>
                        <div id="elematic-gallery-item-<?php echo esc_attr($id); ?>" class="elematic-gallery-item <?php echo esc_attr($fill_cat); ?> elementor-animation-<?php echo esc_attr($settings['hover_animation']); ?>" data-category="<?php echo esc_attr($fill_cat); ?>">

                            <?php Group_Control_Image_Size::print_attachment_image_html( $item, 'image', 'image' ); ?>

                            <?php if( 'yes' === $settings['gall_search'] ) : ?>
                            <span class="d-none"><?php echo esc_attr($item['gall_img_name']); ?></span>
                            <span class="d-none"><?php echo esc_attr($item['gall_filter_name']); ?></span>
                            <?php endif; ?><!-- gallery search as keyword -->

                            <div class="elematic-gallery-overlay">  
                                <?php if( 'show' === $settings['tx_lightbox'] || 'show' === $settings['gall_link_switch'] ) : ?>
                                <div class="elematic-gallery-icons">
                                    <?php if ( 'show' === $settings['tx_lightbox'] ) : ?>
                                        <a
                                            <?php $this->print_render_attribute_string( $lightbox ); ?>
                                            aria-label="<?php echo esc_attr(
                                                sprintf(
                                                    /* translators: %s: image name */
                                                    __( 'Open %s in lightbox', 'elematic-addons-for-elementor' ),
                                                    $item['gall_img_name']
                                                )
                                            ); ?>"
                                        >
                                            <span class="elementor-screen-only">
                                                <?php esc_html_e( 'Open image in lightbox', 'elematic-addons-for-elementor' ); ?>
                                            </span>
                                            <i aria-hidden="true" class="fas fa-search-plus"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if( !empty($item['gall_img_link_url']['url']) && 'show' === $settings['gall_link_switch'] ) : ?>
                                    <a
                                        class="elematic-gallery-link"
                                        href="<?php echo esc_url( $item['gall_img_link_url']['url'] ); ?>"
                                        target="<?php echo esc_attr( $target ); ?>"
                                        aria-label="<?php echo esc_attr(
                                            sprintf(
                                                /* translators: %s: image name */
                                                __( 'Open link for %s', 'elematic-addons-for-elementor' ),
                                                $item['gall_img_name']
                                            )
                                        ); ?>"
                                    >
                                        <span class="elementor-screen-only">
                                            <?php esc_html_e( 'Open related link', 'elematic-addons-for-elementor' ); ?>
                                        </span>
                                        <i aria-hidden="true" class="fas fa-link"></i>
                                    </a>
                                    <?php endif; ?>
                                </div><!-- .elematic-gallery-icons -->
                                <?php endif; ?>

                                <?php if( !empty($item['gall_desc']) ): ?>
                                <div class="elematic-gallery-desc">
                                    <?php echo wp_kses_post( $item['gall_desc'] ); ?>
                                </div><!-- elematic-gallery-desc -->
                                <?php endif; ?>
                                
                                <?php if( 'show' === $settings['gall_img_name_switch'] || 'show' === $settings['gall_filter_switch'] ) : ?>
                                <div class="elematic-gallery-title-bar">
                                    <h3 class="elematic-gallery-name">
                                    <?php if( !empty($item['gall_img_link_url']['url']) ) : ?>
                                    <a href="<?php echo esc_url($item['gall_img_link_url']['url']); ?>" target="<?php echo esc_attr($target); ?>">
                                    <?php endif; ?>
                                    <?php if( !empty($item['gall_img_name']) && 'show' === $settings['gall_img_name_switch'] ) : ?>
                                        <?php echo esc_attr($item['gall_img_name']); ?>
                                    <?php endif; ?>    
                                    <?php if(!empty($item['gall_img_link_url']['url']) || $settings['gall_link_switch']) : ?></a><?php endif; ?>
                                    </h3><!-- elematic-gallery-name -->

                                    <?php if( !empty($item['gall_filter_name']) && 'show' === $settings['gall_filter_switch'] ) : ?>
                                    <h3 class="elematic-gallery-categoy"><?php echo esc_html($item['gall_filter_name']); ?></h3>
                                    <?php endif; ?>
                                </div><!-- elematic-gallery-title-bar -->
                                <?php endif; ?>

                            </div><!-- elematic-gallery-overlay -->
                          
                                                     
                        </div><!-- elematic-gallery-item -->
                    <?php endif; ?>

                        <?php if( 'elematic-gallery-style-3' === $settings['gall_img_style'] || 'elematic-gallery-style-4' === $settings['gall_img_style'] ) : ?>
                        <div id="elematic-gallery-item-<?php echo esc_attr($id); ?>" class="elematic-gallery-item <?php echo esc_attr($fill_cat); ?> elementor-animation-<?php echo esc_attr($settings['hover_animation']); ?>" data-category="<?php echo esc_attr($fill_cat); ?>">

                           <?php Group_Control_Image_Size::print_attachment_image_html( $item, 'image', 'image' ); ?>

                            <?php if( 'yes' === $settings['gall_search'] ) : ?>
                            <span class="d-none"><?php echo esc_attr($item['gall_img_name']); ?></span>
                            <span class="d-none"><?php echo esc_attr($item['gall_filter_name']); ?></span>
                            <?php endif; ?><!-- gallery search as keyword -->

                            <?php if ( ! empty( $item['gall_img_link_url']['url'] ) && 'elematic-gallery-style-3' === $settings['gall_img_style'] ) : ?>
                                <a
                                    href="<?php echo esc_url( $item['gall_img_link_url']['url'] ); ?>"
                                    target="<?php echo esc_attr( $target ); ?>"
                                    aria-label="<?php echo esc_attr(
                                        sprintf(
                                            /* translators: %s: image name */
                                            __( 'Open %s', 'elematic-addons-for-elementor' ),
                                            $item['gall_img_name']
                                        )
                                    ); ?>"
                                >
                            <?php endif; ?>
                            <?php if ( 'elematic-gallery-style-4' === $settings['gall_img_style'] ) : ?>
                                <a
                                    <?php $this->print_render_attribute_string( $lightbox ); ?>
                                    aria-label="<?php echo esc_attr(
                                        sprintf(
                                            /* translators: %s: image name */
                                            __( 'Open %s in lightbox', 'elematic-addons-for-elementor' ),
                                            $item['gall_img_name']
                                        )
                                    ); ?>"
                                >
                            <?php endif; ?>
                                <div class="elematic-gallery-overlay"></div>
                                    <?php if( !empty($item['gall_img_link_url']['url']) ) : ?>
                                    <div class="elematic-gallery-desc">
                                        <?php echo wp_kses_post( $item['gall_desc'] ); ?>
                                    </div><!-- elematic-gallery-desc -->
                                    <?php endif; ?>
                                
                            <?php if( 'elematic-gallery-style-3' === $settings['gall_img_style'] || 'elematic-gallery-style-4' === $settings['gall_img_style'] ) : ?>
                                </a>
                            <?php endif; ?>

                            <?php if( 'show' === $settings['gall_img_name_switch'] && !empty($item['gall_img_name']) || 'show' === $settings['gall_filter_switch'] && !empty($item['gall_filter_name'])) : ?>
                                <div class="elematic-gallery-title-bar">
                                    <h3 class="elematic-gallery-name">
                                    <?php if( !empty($item['gall_img_link_url']['url']) ) : ?>
                                    <a href="<?php echo esc_url($item['gall_img_link_url']['url']); ?>" target="<?php echo esc_attr($target); ?>">
                                    <?php endif; ?>
                                    <?php if( !empty($item['gall_img_name']) && 'show' === $settings['gall_img_name_switch'] ) : ?>
                                        <?php echo esc_attr($item['gall_img_name']); ?>
                                    <?php endif; ?>    
                                    <?php if(!empty($item['gall_img_link_url']['url']) || $settings['gall_link_switch']) : ?></a><?php endif; ?>
                                    </h3><!-- elematic-gallery-name -->

                                    <?php if( !empty($item['gall_filter_name']) && 'show' === $settings['gall_filter_switch'] ) : ?>
                                    <h3 class="elematic-gallery-categoy"><?php echo esc_html($item['gall_filter_name']); ?></h3>
                                    <?php endif; ?>
                                </div><!-- elematic-gallery-title-bar -->
                            <?php endif; ?>

                        </div><!-- elematic-gallery-item -->
                        <?php endif; ?>

                <?php endforeach; ?>
            </div><!-- elematic-gallery-grid -->
    </div><!-- elematic-gallery-wrap -->

<?php
    } // render end


} // class end

