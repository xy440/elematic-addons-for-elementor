<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elematic\Helper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PostAlter extends Widget_Base {

    public function get_name() {
        return 'elematic-post-alter';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Post Alter', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-post-list';
    }
    public function get_style_depends() {
        return [ 'elematic-post-alter' ];
    }
    public function get_categories() {
        return [ 'elematic-widgets' ];
    }
	protected function register_controls() {
        $this->start_controls_section(
            '__settings',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_control(
            'post_type',
            [
                'label' => esc_html__( 'Post Type', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => Helper::get_all_post_types(),
                'default' => 'post',
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
            ]
        );
        $this->add_control(
            'number_of_posts',
            [
                'label' => esc_html__( 'Number of Posts', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '3',
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
                'default' => 'show',
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
                'default' => '24',
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
        
        $this->end_controls_section();

        $this->start_controls_section(
            'pa_style',
            [
                'label' => esc_html__('Styles', 'elematic-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'pa_image_radius',
            [
                'label'      => esc_html__( 'Image Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-post-alter-image-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
         $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'pa_image_border',
                'selector'    =>    '{{WRAPPER}} .elematic-post-alter-image-content img'
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'pa_image_shadow',
                'selector' => '{{WRAPPER}} .elematic-post-alter-image-content img'
            ]
        );
       
        $this->add_responsive_control(
            'pa_spacing',
            [
                'label' => esc_html__('Space between post', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-alter-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'pa_transform',
            [
                'label' => esc_html__('Content Position(X)', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-alter-wrap:nth-child(odd) .elematic-post-alter-text-content, {{WRAPPER}} .elematic-post-alter-wrap:nth-child(even) .elematic-post-alter-image-content' => 'transform: translateX({{SIZE}}{{UNIT}});',
                ],

            ]
        );
        $this->add_control(
            'pa_content_bg_color',
            [
                'label' => esc_html__('Content Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-alter-text-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'pa_content_shadow',
                'selector' => '{{WRAPPER}} .elematic-post-alter-text-content'
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'pa_content_border',
                'selector'    =>    '{{WRAPPER}} .elematic-post-alter-text-content'
            ]
        );
        $this->add_responsive_control(
            'pa_content_radius',
            [
                'label'      => esc_html__( 'Content Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-post-alter-text-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'pa_content_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-alter-text-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'pa_title_color',
            [
                'label' => esc_html__('Title Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-alter-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show'
                ],
                'separator' => 'before'
            ]
        );
        $this->add_control(
            'pa_title_hov_color',
            [
                'label' => esc_html__('Title Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-alter-title:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'title' => 'show'
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pa_title_typography',
                'selector' => '{{WRAPPER}} .elematic-post-alter-title',
                'condition' => [
                    'title' => 'show'
                ]
            ]
        );
        $this->add_control(
            'pa_meta_color',
            [
                'label' => esc_html__('Meta Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic--post-meta-comments, {{WRAPPER}} .elematic--post-meta-comments a, {{WRAPPER}} .elematic--post-meta-author, {{WRAPPER}} .elematic--post-category, {{WRAPPER}} .elematic--post-category a, {{WRAPPER}} .elematic--post-meta-date' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'pa_meta_hov_color',
            [
                'label' => esc_html__('Meta Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic--post-meta-comments a:hover, {{WRAPPER}} .elematic--post-category a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pa_meta_typography',
                'selector' => '{{WRAPPER}} .elematic--post-meta-comments, {{WRAPPER}} .elematic--post-meta-comments a, {{WRAPPER}} .elematic--post-meta-author, {{WRAPPER}} .elematic--post-category, {{WRAPPER}} .elematic--post-category a, {{WRAPPER}} .elematic--post-meta-date',
            ]
        );
        $this->add_control(
            'pa_desc_color',
            [
                'label' => esc_html__('Description Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-alter-desc' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'desc' => 'show',
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pa_desc_typography',
                'selector' => '{{WRAPPER}} .elematic-post-alter-desc',
                'condition' => [
                    'desc' => 'show',
                ]
            ]
        );
        $this->add_control(
            'pa_read_more_txt_color',
            [
                'label' => esc_html__('Read More Text Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-read-more' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_control(
            'pa_read_more_txt_hov_color',
            [
                'label' => esc_html__('Read More Text Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-read-more:hover, {{WRAPPER}} .elematic-post-read-more:focus' => 'color: {{VALUE}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_control(
            'pa_read_more_bg_color',
            [
                'label' => esc_html__('Read More Background Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-read-more' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_control(
            'pa_read_more_bg_hov_color',
            [
                'label' => esc_html__('Read More Background Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-read-more:hover, {{WRAPPER}} .elematic-post-read-more:focus' => 'background-color: {{VALUE}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_control(
            'pa_read_more_br_color',
            [
                'label' => esc_html__('Read More Border Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-read-more' => 'border-color: {{VALUE}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_control(
            'pa_read_more_br_hov_color',
            [
                'label' => esc_html__('Read More Border Hover Color', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-post-read-more:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pa_read_more_typography',
                'selector' => '{{WRAPPER}} .elematic-post-read-more',
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'pa_read_more_border',
                'selector'    =>    '{{WRAPPER}} .elematic-post-read-more',
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_responsive_control(
            'pa_read_more_border_radius',
            [
                'label'      => esc_html__( 'Read More Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-post-read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_responsive_control(
            'pa_read_more_padding',
            [
                'label'             => esc_html__( 'Read More Padding', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->add_responsive_control(
            'pa_read_more_margin',
            [
                'label'             => esc_html__( 'Read More Margin', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-post-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [ 
                    'read_more' => 'show' 
                ]
            ]
        );
        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $title = $settings['title'];
        $title_lenth = $settings['title_lenth'];
        $desc = $settings['desc'];
        $post_category = $settings['post_category'];

        // title lenth limit
        if( $title_lenth ){
            $title_lenth = $title_lenth;
        } else {
            $title_lenth = 50;
        }

        $paged = Helper::get_current_page();
        $query_args = Helper::setup_query_args( $settings, $paged );
        $post_query = new \WP_Query( $query_args );
        $post_query = Helper::fix_query_offset_pagination( $post_query, $settings );

        if ($post_query->have_posts()) : 
            while ($post_query->have_posts()) : $post_query->the_post();
        ?>
            <div class="elematic-post-alter-wrap">

                <div class="elematic-post-alter-image-content">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-thumb">
                            <?php the_post_thumbnail($settings['image_size']); ?>
                        </div><!-- featured-thumb -->
                    <?php endif; ?>
                </div><!-- elematic-post-alter-image-content -->

                <?php if( $title == 'show' || $settings['date'] == 'show' || $post_category == 'show' || $settings['comments'] == 'show' || $desc == 'show' || 'show' === $settings['read_more'] ) : ?>
                <div class="elematic-post-alter-text-content">
                    <?php if($title == 'show') : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark">
                            <h2 class="elematic-post-alter-title"><?php echo wp_kses_post( Helper::title_length($title_lenth) ); ?></h2>
                        </a>
                    <?php endif; ?>

                    <?php if ('post' == get_post_type()) : ?>
                        <div class="elematic-post-meta">
                            <?php if($settings['date'] == 'show') : echo wp_kses_post( Helper::elematic_date() ); endif; ?>
                            <?php if($post_category == 'show') : echo wp_kses_post( Helper::elematic_category() ); endif ?>
                            <?php if($settings['comments'] == 'show') : echo wp_kses_post( Helper::elematic_comments() ); endif; ?>
                        </div>
                    <?php endif; ?><!-- .entry-meta -->
                    <?php if($desc == 'show') : ?>
                        <div class="elematic-post-alter-desc"><?php echo wp_kses_post(Helper::excerpt_limit( $settings['excerpt_words']) ); ?></div>
                    <?php endif; ?>
                    <?php if( 'show' === $settings['read_more'] ): ?>
                        <a class="elematic-post-read-more" href="<?php the_permalink(); ?>"><?php echo esc_html( $settings['read_more_txt'] ); ?></a>
                    <?php endif; ?>
                </div><!-- elematic-post-alter-text-content -->
                <?php endif; ?>

            </div><!-- elematic-post-alter-wrap -->
        <?php endwhile;
                wp_reset_postdata();
            else:  
                echo '<p>' . esc_html__( 'Sorry, nothing found.', 'elematic-addons-for-elementor' ) . '</p>';
            endif; ?>
        
            <div class="clearfix"></div>


<?php   } // render()
} // class 
