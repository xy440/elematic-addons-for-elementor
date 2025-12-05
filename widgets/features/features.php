<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Frontend;
use Elementor\Utils;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Features extends Widget_Base {

    public function get_name() {
        return 'elematic-features';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Features', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-apps';
    }
    public function get_style_depends() {
        return [ 'elematic-features' ];
    }
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }
	protected function register_controls() {
        $this->start_controls_section(
            'ft_settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );

        $this->add_control(
          'ft_source',
            [
            'label'         => esc_html__( 'Source', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'custom',
                'label_block'   => false,
                'options'       => [
                    'custom'    => esc_html__( 'Custom', 'elematic-addons-for-elementor' ),
                    'dynamic'   => esc_html__( 'Dynamic', 'elematic-addons-for-elementor' ),
                ],
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label' => esc_html__( 'Post Type', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => Helper::get_all_post_types(),
                'default' => 'post',
                'condition' => [
                    'ft_source' => 'dynamic'
                ]

            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'medium_large',

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
                    'ft_source' => 'dynamic'
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
                    'ft_source' => 'dynamic'
                ]
            ]
        );
        $this->add_control(
            'offset',
            [
                'label' => esc_html__( 'Offset', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'ft_source' => 'dynamic'
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
                    'ft_source' => 'dynamic'
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
                        'mostdiscussed'    => esc_html__( 'Most discussed', 'elematic-addons-for-elementor' ),
                    ],
                    'condition' => [
                    'ft_source' => 'dynamic'
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
                    'ft_source' => 'dynamic',
                    'post_sortby' => ['latestpost'],
                ]
            ]
        );
        $this->add_control(
            'ft_date_display',
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
                'default' => 'show',
                'condition' => [
                    'ft_source' => 'dynamic'
                ],
                'separator' => 'before'
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
                'default' => 'show',
                'condition' => [
                    'ft_source' => 'dynamic'
                ],
            ]
        );
        $this->add_control(
          'title_limit',
          [
            'label'         => esc_html__( 'Title Letter Limit', 'elematic-addons-for-elementor' ),
            'type'          => Controls_Manager::NUMBER,
            'default'       => 50,
            'condition' => [
                'title' => 'show',
                'ft_source' => 'dynamic'
            ],
          ]
        );
        $this->add_control(
            'desc',
            [
                'label' => esc_html__( 'Description', 'elematic-addons-for-elementor' ),
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
                'condition' => [
                    'ft_source' => 'dynamic'
                ]
            ]
        );
        $this->add_control(
          'desc_limit',
          [
            'label'         => esc_html__( 'Description Letter Limit', 'elematic-addons-for-elementor' ),
            'type'          => Controls_Manager::NUMBER,
            'default'       => 12,
            'condition' => [
                'desc' => 'show',
                'ft_source' => 'dynamic'
            ],
          ]
        );
        $this->add_control(
            'ft_read_more',
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
                'condition' => [
                    'ft_source' => 'dynamic'
                ]
            ]
        );
        $this->add_control(
            'ft_read_more_text', 
            [
                'label' => esc_html__('Read More Text', 'elematic-addons-for-elementor'),
                'default' => esc_html__('Read More','elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'ft_source' => 'dynamic',
                    'ft_read_more' => 'show'
                ],
            ]
        );
        $this->add_control(
            'ft_read_more_link',
            [
                'label' => esc_html__('Read More Link URL', 'elematic-addons-for-elementor'),
                'default'     => [
                    'url' => '#',
                ],
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-site.com',
                'condition' => [
                    'ft_source' => 'dynamic',
                    'ft_read_more' => 'show',
                    'ft_read_more_text!' => ''
                ],
            ]
        );
        $repeater = new Repeater();
        
        $repeater->add_control(
            'ft_title', 
            [
                'label' => esc_html__('Title', 'elematic-addons-for-elementor'),
                'default' => esc_html__('Tristique sapien accum','elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'ft_title_link',
            [
                'label' => esc_html__('Title Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-site.com',
            ]
        );
        $repeater->add_control(
            'ft_subtitle', 
            [
                'label' => esc_html__('Subtitle', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Ligula ultrices','elematic-addons-for-elementor'),
            ]
        );
        $repeater->add_control(
            'ft_image',
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
                'default' => 'full',
            ]
        );
        $repeater->add_control(
            'ft_desc', 
            [
                'type' => Controls_Manager::WYSIWYG,
                "label" => esc_html__("Text", 'elematic-addons-for-elementor'),
                "default" => esc_html__("Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquat enim ad minim veniam quis.", 'elematic-addons-for-elementor'),
                'show_label' => true,
            ]
        );
        $repeater->add_control(
            'ft_readmore', 
            [
                'label' => esc_html__('Read More', 'elematic-addons-for-elementor'),
                'default' => esc_html__('Read More','elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'ft_readmore_link',
            [
                'label' => esc_html__('Read More Link URL', 'elematic-addons-for-elementor'),
                'default'     => [
                    'url' => '#',
                ],
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
                'condition' => [
                    'ft_source' => 'custom'
                ],
                'default' => [
                    [
                        'ft_title' => 'Ut enim ad minim veniam',
                        'ft_subtitle' => 'Lioula ulsrices',
                        'ft_desc' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliquat enim ad minim veniam quis.',
                    ],
                    [
                        'ft_title' => 'Felis eros vehicula leo ato',
                        'ft_subtitle' => 'Ltrices semper',
                        'ft_desc' => 'Nostrud exercitation ullamco laboris nisi ut aliquip avas-core ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
                    ],
                    [
                        'ft_title' => 'Nullam tinci dunt adip',
                        'ft_subtitle' => 'Pellentesque laoreet',
                        'ft_desc' => 'Cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim.',
                    ],
                    [
                        'ft_title' => 'Tristique sapien accum',
                        'ft_subtitle' => 'Ligula ultrices',
                        'ft_desc' => 'Suspendisse potenti Phasellus euismod libero in neque molestie et elementum libero maximus. Etiam in enim vestibulum suscipit sem quis molestie nibh.',
                    ],
                ],

                'title_field' => '{{{ft_title}}}',
            ]
        );
        
        $this->add_control(
            'ft_tiled',
            [
                'label' => esc_html__( 'Tiled', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'yes' => [
                        'title' => esc_html__( 'Yes', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-check',
                    ],
                    'no' => [
                        'title' => esc_html__( 'No', 'elematic-addons-for-elementor' ),
                        'icon' => 'eicon-ban',
                    ]
                ],
                'default' => 'no',
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'ft_spacing',
            [
                'label' => esc_html__('Space', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'condition' => [
                    'ft_tiled' => 'no'
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-ft-container:not(.elematic-ft-tiled) .elematic-ft-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'image_hover',
            [
                'label'     => esc_html__('Image Hover Zoom', 'elematic-addons-for-elementor'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'ft_style',
            [
                'label' => esc_html__('Styles', 'elematic-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'ft_img_size',
            [
                'label'   => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
                'type'    => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max'  => 1200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-ft-image-content img'   => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'ft_source' => 'custom'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'ft_img_border',
                'selector'    =>    '{{WRAPPER}} .elematic-ft-image-content img',
            ]
        );
        $this->add_responsive_control(
            'ft_img_border_radius',
            [
                'label'         => esc_html__( 'Image Border Radius', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic-ft-image-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'ft_title_color',
            [
                'label' => esc_html__('Title Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ft-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'ft_title_hov_color',
            [
                'label' => esc_html__('Title Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ft-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ft_title_typography',
                'selector' => '{{WRAPPER}} .elematic-ft-title',
            ]
        );
        $this->add_control(
            'ft_subtitle_color',
            [
                'label' => esc_html__('Sub Title', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ft-subtitle' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'ft_source' => 'custom'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ft_subtitle_typography',
                'selector' => '{{WRAPPER}} .elematic-ft-subtitle',
                'condition' => [
                    'ft_source' => 'custom'
                ]
            ]
        );
        $this->add_control(
            'ft_date_color',
            [
                'label' => esc_html__('Date Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .post-time' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'ft_source' => 'dynamic'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ft_date_typography',
                'selector' => '{{WRAPPER}} .post-time',
                'condition' => [
                    'ft_source' => 'dynamic'
                ]
            ]
        );
        $this->add_control(
            'ft_desc_color',
            [
                'label' => esc_html__('Description Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-ft-desc' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ft_desc_typography',
                'selector' => '{{WRAPPER}} .elematic-ft-desc',
            ]
        );
        $this->add_control(
            'ft_readmore_color',
            [
                'label' => esc_html__('Read More Text Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic--read-more' => 'color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'ft_readmore_hover_color',
            [
                'label' => esc_html__('Read More Text Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic--read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ft_readmore_bg_color',
            [
                'label' => esc_html__('Read More Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic--read-more' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'ft_readmore_bg_hover_color',
            [
                'label' => esc_html__('Read More Background Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic--read-more:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ft_readmore_typography',
                'selector' => '{{WRAPPER}} .elematic--read-more',
            ]
        );
        $this->add_responsive_control(
            'ft_readmore_border_radius',
            [
                'label'         => esc_html__( 'Read More Border Radius', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic--read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'ft_readmore_padding',
            [
                'label'         => esc_html__( 'Read More Padding', 'elematic-addons-for-elementor' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px', 'em', '%' ],
                'selectors'     => [
                    '{{WRAPPER}} .elematic--read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();
        $ft_tiled = ($settings['ft_tiled'] == 'yes') ? 'elematic-ft-tiled' : ''; 
        $paged = Helper::get_current_page();
        $query_args = Helper::setup_query_args( $settings, $paged );
        $post_query = new \WP_Query( $query_args );
        $post_query = Helper::fix_query_offset_pagination( $post_query, $settings );
        $img_hover  = $settings['image_hover'] ? 'elematic-img-zoom' : '';
        $target_read_more = $settings['ft_read_more_link']['is_external'] ? '_blank' : '_self';
        ?>

        <?php if( $settings['ft_source'] == 'dynamic' ) : ?>
        <div class="elematic-ft-container <?php echo esc_attr($ft_tiled) ?>">
            <?php
            if ($post_query->have_posts()) : 
                while ($post_query->have_posts()) : $post_query->the_post();
            ?>

            <div class="elematic-ft-wrapper <?php echo esc_attr($img_hover); ?>">
                <div class="elematic-ft-image-content">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" title="<?php echo esc_attr( get_the_title() ); ?>">
                            <?php the_post_thumbnail($settings['image_size']); ?>
                        </a>
                    <?php endif; ?>
                </div><!-- elematic-ft-image-content -->

                <div class="elematic-ft-text-content">

                    <div class="elematic-ft-subtitle"><?php echo wp_kses_post(Helper::elematic_date()); ?></div>
                    <?php if('show' === $settings['title'] ) : ?>
                    <a href="<?php echo esc_url( get_permalink() ); ?>"><h3 class="elematic-ft-title"><?php echo wp_kses_post(Helper::title_length($settings['title_limit'])); ?></h3></a>
                    <?php endif; ?>

                    <?php if('show' === $settings['desc'] ) : ?>
                    <div class="elematic-ft-desc">
                        <?php
                                global $post;
                                $elementor  = get_post_meta( $post->ID, '_elementor_edit_mode', true );                          
                                if ( $elementor ) {
                                    $frontend = new Frontend;
                                    echo wp_kses_post($frontend->get_builder_content( $post->ID, true ));
                                } else {
                                    echo wp_kses_post(Helper::excerpt_limit($settings['desc_limit']));
                                }
                        ?>
                    </div>
                    <?php if( 'show' === $settings['ft_read_more'] ): ?>
                        <a href="<?php echo esc_url( $settings['ft_read_more_link']['url'] ); ?>" class="elematic--read-more" target="<?php echo esc_attr($target_read_more); ?>"><?php echo esc_html($settings['ft_read_more_text']); ?></a>
                        <?php endif; ?>
                    <?php endif; ?>

                </div><!-- elematic-ft-text-content -->
            </div><!-- elematic-ft-wrapper -->
        <?php endwhile;
             wp_reset_postdata();
            endif;
        ?>
        </div><!-- elematic-ft-container -->
        <?php endif; ?>

        <?php if( $settings['ft_source'] == 'custom'  ) : ?>
        <div class="elematic-ft-container <?php echo esc_attr($ft_tiled) ?>">
            <?php foreach ($settings['features'] as $feature): 
                $target = $feature['ft_title_link']['is_external'] ? '_blank' : '_self';
                $target_readmore = $feature['ft_readmore_link']['is_external'] ? '_blank' : '_self';
            ?>

                <div class="elematic-ft-wrapper <?php echo esc_attr($img_hover); ?>">
                    <div class="elematic-ft-image-content">
                        <?php if (!empty($feature['ft_image'])) : ?>
                              <?php Group_Control_Image_Size::print_attachment_image_html( $feature, 'image', 'ft_image' ); ?>
                        <?php endif; ?>
                    </div><!-- elematic-ft-image-content -->
                    <div class="elematic-ft-text-content">
                        <div class="elematic-ft-subtitle"><?php echo esc_html($feature['ft_subtitle']) ?></div>
                        <?php if(!empty($feature['ft_title_link']['url'])) : ?>
                        <a href="<?php echo esc_url( $feature['ft_title_link']['url'] ); ?>" target="<?php echo esc_attr($target); ?>">
                        <h3 class="elematic-ft-title"><?php echo esc_html($feature['ft_title']); ?></h3>
                        </a>
                        <?php else: ?>
                        <h3 class="elematic-ft-title"><?php echo esc_html($feature['ft_title']); ?></h3>
                        <?php endif; ?>
                        <div class="elematic-ft-desc"><?php echo wp_kses_post($this->parse_text_editor($feature['ft_desc'])); ?></div>
                        <?php if(!empty($feature['ft_readmore_link']['url'])): ?>
                        <a href="<?php echo esc_url( $feature['ft_readmore_link']['url'] ); ?>" class="elematic--read-more" target="<?php echo esc_attr($target_readmore); ?>"><?php echo esc_html($feature['ft_readmore']); ?></a>
                        <?php endif; ?>
                    </div><!-- elematic-ft-text-content -->
                </div><!-- elematic-ft-wrapper -->

            <?php endforeach; ?>
        </div><!-- elematic-ft-container -->
        <?php endif; ?>


<?php   } // render()
} // class 
