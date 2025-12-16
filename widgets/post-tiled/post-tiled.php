<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PostTiled extends Widget_Base {

    public function get_name() {
        return 'elematic-post-tiled';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Post Tiled', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-posts-group';
    }
    public function get_style_depends() {
        return [ 'elematic-post-tiled' ];
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
            'layout',
            [
                'label'             => esc_html__( 'Styles', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'layout-1'       => esc_html__( 'Style 1', 'elematic-addons-for-elementor' ),
                   'layout-2'       => esc_html__( 'Style 2', 'elematic-addons-for-elementor' ),
                   'layout-3'       => esc_html__( 'Style 3', 'elematic-addons-for-elementor' ),
                   'layout-4'       => esc_html__( 'Style 4', 'elematic-addons-for-elementor' ),
                   'layout-5'       => esc_html__( 'Style 5', 'elematic-addons-for-elementor' ),
                   'layout-6'       => esc_html__( 'Style 6', 'elematic-addons-for-elementor' ),
                   'layout-7'       => esc_html__( 'Style 7', 'elematic-addons-for-elementor' ),
                   'layout-8'       => esc_html__( 'Style 8', 'elematic-addons-for-elementor' ),
                   'layout-9'       => esc_html__( 'Style 9', 'elematic-addons-for-elementor' ),
                   'layout-10'      => esc_html__( 'Style 10', 'elematic-addons-for-elementor' ),
                   'layout-11'      => esc_html__( 'Style 11', 'elematic-addons-for-elementor' ),
                   'layout-12'      => esc_html__( 'Style 12', 'elematic-addons-for-elementor' ),
                   'layout-13'      => esc_html__( 'Style 13', 'elematic-addons-for-elementor' ),
                ],
                'default'           => 'layout-13',
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
                'multiple' => true,
                'options' => Helper::get_all_categories(),
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
            'offset',
            [
                'label' => esc_html__( 'Offset', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
               
            ]
        );
        $this->add_control(
            'number_of_posts',
            [
                'label' => esc_html__( 'Number of Posts', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'layout' => ['layout-0'],
                ],
            ]
        );
        $this->add_control(
            'category',
            [
                'label' => esc_html__( 'Category', 'elematic-addons-for-elementor' ),
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
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'elematic-addons-for-elementor' ),
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
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'title_lenth',
            [
                'label' => esc_html__( 'Title Lenth', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '50',
                'condition' => [
                    'title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'author',
            [
                'label' => esc_html__( 'Author', 'elematic-addons-for-elementor' ),
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
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'date',
            [
                'label' => esc_html__( 'Date', 'elematic-addons-for-elementor' ),
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
                'default' => 'yes',

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
                'selector'          => '{{WRAPPER}} .elematic-post-tiled .elematic-post-tiled-content',
            ]
        );
        $this->add_control(
            'content_padding',
            [
                'label'             => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-tiled .elematic-post-tiled-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'category_bg_color',
            [
                'label'     => esc_html__( 'Category Background Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-tiled-category a' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                      'category' => 'yes',
                    ],

            ]
        );
        $this->add_control(
            'category_bg_hov_color',
            [
                'label'     => esc_html__( 'Category BG Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-tiled-category a:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                      'category' => 'yes',
                    ],

            ]
        );
        $this->add_control(
            'category_color',
            [
                'label'     => esc_html__( 'Category Font Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-tiled-category a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                      'category' => 'yes',
                    ],

            ]
        );
        $this->add_control(
            'category_hov_color',
            [
                'label'     => esc_html__( 'Category Font Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-tiled-category a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                      'category' => 'yes',
                    ],

            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__( 'Title Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-tiled-title a' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                      'title' => 'yes',
                    ],

            ]
        );
        $this->add_control(
            'title_hov_color',
            [
                'label'     => esc_html__( 'Title Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-tiled-title a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                      'title' => 'yes',
                    ],

            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'title_typography',
                   'selector'  => '{{WRAPPER}} .elematic-post-tiled-title',
                   'condition' => [
                      'title' => 'yes',
                    ],
              ]
        );
        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__( 'Meta Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-tiled-meta *' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',

            ]
        );


        $this->end_controls_section();
    }

        protected function render() {
        $settings     = $this->get_settings_for_display();
        $thumb        = $settings['image_size'];
        $layout       = $settings['layout'];
        $offset       = $settings['offset'];
        $category     = $settings['category'];
        $title        = $settings['title'];
        $title_lenth  = $settings['title_lenth'];
        $author       = $settings['author'];
        $date         = $settings['date'];

        $paged      = Helper::get_current_page();
        $query_args = Helper::setup_query_args( $settings, $paged );

        // determine how many posts to show per layout
        if ( $layout == 'layout-12' ) {
            $showposts = 2;
        } elseif ( in_array( $layout, [ 'layout-2', 'layout-3', 'layout-7', 'layout-9', 'layout-10' ], true ) ) {
            $showposts = 3;
        } elseif ( in_array( $layout, [ 'layout-1', 'layout-6', 'layout-8' ], true ) ) {
            $showposts = 4;
        } elseif ( in_array( $layout, [ 'layout-4', 'layout-5', 'layout-13' ], true ) ) {
            $showposts = 5;
        } elseif ( $layout == 'layout-11' ) {
            $showposts = 6;
        } else {
            $showposts = 3;
        }

        // enforce layout-specific count
        $query_args['posts_per_page'] = $showposts;

        $post_query = new \WP_Query( $query_args );
        $post_query = Helper::fix_query_offset_pagination( $post_query, $settings );

        // title length limit
        if ( $title_lenth ) {
            $title_lenth = $title_lenth;
        } else {
            $title_lenth = 50;
        }

        $this->add_render_attribute( 'elematic-post-tiled', 'class', 'elematic-post-tiled clearfix' );

        if ( $layout ) :
            $this->add_render_attribute( 'elematic-post-tiled', 'class', 'elematic-post-tiled-' . $layout );
        endif;

        $position = 1;
        ?>

        <div <?php $this->print_render_attribute_string( 'elematic-post-tiled' ); ?>>

            <?php if ( $post_query->have_posts() ) : while ( $post_query->have_posts() ) : $post_query->the_post(); ?>

                <?php
                if ( $layout == 'layout-1' || $layout == 'layout-2' || $layout == 'layout-3' || $layout == 'layout-4' ) {
                    if ( $position == 2 ) { ?><div class="elematic-post-tiled-block-right"><?php }
                } elseif ( $layout == 'layout-13' ) {
                    if ( $position == 1 ) { ?><div class="elematic-post-tiled-block-left"><?php }
                }
                ?>
                <div class="elematic-post-tiled-block elematic-post-tiled-block-<?php echo intval( $position ); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php $thumb_url = get_the_post_thumbnail_url( get_the_ID(), $thumb ); ?>
                        <div class="elematic-post-tiled-block-bg" <?php echo 'style="background-image:url(' . esc_url( $thumb_url ) . ')"'; ?>></div>
                    <?php endif; ?>

                    <div class="elematic-post-tiled-content">
                        <?php if ( $category == 'yes' ) : ?>
                        <div class="elematic-post-tiled-category">
                            <?php echo wp_kses_post( Helper::elematic_category() ); ?>
                        </div>
                        <?php endif; ?>
                        <?php if ( $title == 'yes' ) : ?>
                        <h3 class="elematic-post-tiled-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(Helper::title_length( $title_lenth )); ?></a></h3>
                        <?php endif; ?>
                        <div class="elematic-post-tiled-meta">
                            <?php if ( $author == 'yes' ) : ?>
                            <?php echo wp_kses_post(Helper::elematic_author()); ?>
                            <?php endif; ?>
                            <?php if ( $date == 'yes' ) : ?>
                            <?php echo wp_kses_post(Helper::elematic_date()); ?>
                            <?php endif; ?>
                        </div><!-- elematic-post-tiled-meta  -->
                    </div><!-- elematic-post-tiled-content -->
                </div><!-- elematic-post-tiled-block -->
            <?php
                    if ( $layout == 'layout-1' ) {
                        if ( $position == 4 ) { ?></div><?php }
                    } elseif ( $layout == 'layout-2' || $layout == 'layout-3' ) {
                        if ( $position == 3 ) { ?></div><?php }
                    }
                    if ( $layout == 'layout-4' ) {
                        if ( $position == 5 ) { ?></div><?php }
                    } elseif ( $layout == 'layout-11' ) {
                        if ( $position == 6 ) { ?><?php }
                    } elseif ( $layout == 'layout-13' ) {
                        if ( $position == 2 ) { ?></div><?php }
                    }
                $position++; endwhile; endif; wp_reset_postdata();
            ?>

        </div><!-- elematic-post-tiled -->
        <div class="clearfix"></div>

<?php
    } //render()

} //class