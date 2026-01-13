<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elematic\Helper;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Team extends Widget_Base {

    public function get_name() {
        return 'elematic-team';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Team', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-user-circle-o';
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    public function get_style_depends() {
        return [ 'elematic-team' ];
    }

	protected function register_controls() {
       
		$this->start_controls_section(
            'settings',
            [
                'label' => esc_html__( 'Content', 'elematic-addons-for-elementor' )
            ]
        );
        $this->add_control(
            'team_style',
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
        $repeater = new Repeater();
        $repeater->add_control(
            'user_name', 
            [
                'label' => esc_html__('Name', 'elematic-addons-for-elementor'),
                'default' => 'John Doe',
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'link_url', 
            [
                'label' => esc_html__('Link URL', 'elematic-addons-for-elementor'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
            ]
        );
        $repeater->add_control(
            'position', 
            [
                'label' => esc_html__('Position', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
            ]
        );
        $repeater->add_control(
            'user_image', 
            [
                'label' => esc_html__('Image', 'elematic-addons-for-elementor'),
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
            'team_details', 
            [
                'label' => esc_html__('Details', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.', 'elematic-addons-for-elementor' ),
            ]
        );

        $repeater->add_control(
            'social_profile', 
            [
                'label' => esc_html__('Social Profile', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Create a nested repeater for social profiles
        $social_repeater = new Repeater();

        $social_repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__('Icon', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'default' => [
                    'value' => 'fab fa-facebook',
                    'library' => 'fa-brands',
                ],
                'recommended' => [
                    'fa-brands' => [
                        'android',
                        'apple',
                        'behance',
                        'bitbucket',
                        'codepen',
                        'delicious',
                        'deviantart',
                        'digg',
                        'dribbble',
                        'discord',
                        'elementor',
                        'facebook',
                        'flickr',
                        'foursquare',
                        'free-code-camp',
                        'github',
                        'gitlab',
                        'google',
                        'houzz',
                        'instagram',
                        'jsfiddle',
                        'linkedin',
                        'medium',
                        'meetup',
                        'mix',
                        'mixcloud',
                        'odnoklassniki',
                        'pinterest',
                        'product-hunt',
                        'reddit',
                        'skype',
                        'slideshare',
                        'snapchat',
                        'soundcloud',
                        'spotify',
                        'stack-overflow',
                        'steam',
                        'telegram',
                        'threads',
                        'tiktok',
                        'tripadvisor',
                        'tumblr',
                        'twitch',
                        'twitter',
                        'viber',
                        'vimeo',
                        'vk',
                        'weibo',
                        'weixin',
                        'whatsapp',
                        'wordpress',
                        'x-twitter',
                        'xing',
                        'yelp',
                        'youtube',
                        '500px',
                    ],
                    'fa-solid' => [
                        'envelope',
                        'link',
                        'rss',
                        'phone',
                    ],
                ],
            ]
        );

        $social_repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'is_external' => 'true',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'elematic-addons-for-elementor'),
            ]
        );

        // Add the nested repeater to the main team repeater
        $repeater->add_control(
            'social_icon_list',
            [
                'label' => esc_html__('Social Icons', 'elematic-addons-for-elementor'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $social_repeater->get_controls(),
                'default' => [
                    [
                        'social_icon' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => '#',
                            'is_external' => true,
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-x-twitter',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => '#',
                            'is_external' => true,
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-linkedin',
                            'library' => 'fa-brands',
                        ],
                        'link' => [
                            'url' => '#',
                            'is_external' => true,
                        ],
                    ],
                ],
                'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
            ]
        );

        $this->add_control(
            'team',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [

                    [
                        'user_name' => esc_html__('John Doe', 'elematic-addons-for-elementor'),
                        'position' => esc_html__('Web Developer', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'user_name' => esc_html__('Sharon Brinson', 'elematic-addons-for-elementor'),
                        'position' => esc_html__('Graphics Designer', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'user_name' => esc_html__('Felix Mercer', 'elematic-addons-for-elementor'),
                        'position' => esc_html__('Marketing Expert', 'elematic-addons-for-elementor'),
                    ],
                    [
                        'user_name' => esc_html__('Carla Houston', 'elematic-addons-for-elementor'),
                        'position' => esc_html__('Finance Manager', 'elematic-addons-for-elementor'),
                    ],
                ],
                
                'title_field' => '{{{ user_name }}}',
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__( 'Columns', 'elematic-addons-for-elementor' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,     
                'desktop_default' => '25%',
                'tablet_default' => '50%',
                'mobile_default' => '100%',
                'options' => [
                    '100%' => esc_html__( '1 Column', 'elematic-addons-for-elementor' ),
                    '50%' => esc_html__( '2 Column', 'elematic-addons-for-elementor' ),
                    '33.33%' => esc_html__( '3 Columns', 'elematic-addons-for-elementor' ),
                    '25%' => esc_html__( '4 Columns', 'elematic-addons-for-elementor' ),
                    '20%' => esc_html__( '5 Columns', 'elematic-addons-for-elementor' ),
                    '16.66%' => esc_html__( '6 Columns', 'elematic-addons-for-elementor' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-container' => 'width: {{VALUE}};',
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
                    '{{WRAPPER}} .elematic-team-container' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'columns!' => ''
                ]
            ]
        );
        $this->add_responsive_control(
            'team_padding',
            [
                'label'             => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-team-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'team_margin',
            [
                'label'             => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => [ 'px', 'em', '%' ],
                'selectors'         => [
                    '{{WRAPPER}} .elematic-team-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elematic-team-container'   => 'text-align: {{VALUE}};',
                ],
                

            ]
        );

        $this->end_controls_section();

        // Style section started
        $this->start_controls_section(
            'styles',
            [
              'label'   => esc_html__( 'Image', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'img_width',
            [
                'label' => esc_html__( 'Image Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'team_img_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-team-image img',
            ]
        );
        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__( 'Image Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'opacity',
            [
                'label' => esc_html__( 'Opacity', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .elematic-team-image img',
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'elematic-addons-for-elementor' ),
            ]
        );
        $this->add_control(
            'opacity_hover',
            [
                'label' => esc_html__( 'Opacity', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-container:hover .elematic-team-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elematic-team-container:hover .elematic-team-image img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'elematic-addons-for-elementor' ) . ' (s)',
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-container:hover .elematic-team-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'styles_content',
            [
              'label'   => esc_html__( 'Content', 'elematic-addons-for-elementor' ),
              'tab'     => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'cont_background',
                'label' => esc_html__( 'Background', 'elematic-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-team-container',
            ]
        );
        $this->add_responsive_control(
            'cont_width',
            [
                'label' => esc_html__( 'Width', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'cont_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-team-container',
            ]
        );
        $this->add_responsive_control(
            'cont_border_radius',
            [
                'label'      => esc_html__( 'Content Border Radius', 'elematic-addons-for-elementor' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elematic-team-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .elematic-team-container'
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'label' => esc_html__( 'Content Background', 'elematic-addons-for-elementor' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .elematic-team-content',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'cont_pad',
            [
                'label' => esc_html__( 'Content Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                
            ]
        );
        $this->add_control(
            'cont_min_height',
            [
                'label' => esc_html__( 'Minimum Height', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_unit' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-content' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'name_color',
            [
                'label'     => esc_html__( 'Name Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-name' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'name_hov_color',
            [
                'label'     => esc_html__( 'Name Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-name:hover' => 'color: {{VALUE}};',
                ],
                
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'name_typography',
                   'selector'  => '{{WRAPPER}} .elematic-team-name',
                   
              ]
        );
        $this->add_control(
            'position_color',
            [
                'label'     => esc_html__( 'Position Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-position' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'position_typography',
                   'selector'  => '{{WRAPPER}} .elematic-team-position',
                   
              ]
        );
        $this->add_control(
            'team_details_color',
            [
                'label'     => esc_html__( 'team Details Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-team-details' => 'color: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
              [
                   'name'    => 'team_details_typography',
                   'selector'  => '{{WRAPPER}} .elematic-team-details',
                   
              ]
        );
        $this->add_control(
            'sp_color',
            [
                'label'     => esc_html__( 'Social Profile Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-social-profile a i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-social-profile a svg' => 'fill: {{VALUE}};',
                ],
                
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'sp_hov_color',
            [
                'label'     => esc_html__( 'Social Profile Hover Color', 'elematic-addons-for-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elematic-social-profile a:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elematic-social-profile a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sp_typography',
            [
                'label'                 => esc_html__( 'Icon Size', 'elematic-addons-for-elementor' ),
                'type'                  => Controls_Manager::SLIDER,
                'default'               => [
                    // 'size' => 100,
                    'unit' => 'px',
                ],
                'size_units'            => [ 'px' ],
                'range'                 => [
                    // '%' => [
                    //     'min' => 1,
                    //     'max' => 100,
                    // ],
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'             => [
                    '{{WRAPPER}} .elematic-social-profile a i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elematic-social-profile a svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'sp_border',
                'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                'selector' => '{{WRAPPER}} .elematic-social-profile a',
            ]
        );
        $this->add_control(
            'sp_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-social-profile a' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sp_padding',
            [
                'label' => esc_html__( 'Social Profile Icon Padding', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-social-profile a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'sp_margin',
            [
                'label' => esc_html__( 'Social Profile Icon Margin', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-social-profile a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }


    // Render social profiles method
    private function render_social_profiles($social_icon_list, $team_index = 0) {
        if (empty($social_icon_list)) {
            return;
        }
        
        $migration_allowed = Icons_Manager::is_migration_allowed();
        ?>
        <div class="elematic-social-profile">
            <?php foreach ($social_icon_list as $index => $item) : ?>
                <?php if (!empty($item['link']['url'])) : 
                    $migrated = isset($item['__fa4_migrated']['social_icon']);
                    $is_new = empty($item['social']) && $migration_allowed;
                    $social = '';
                    
                    // Get social network name for screen readers
                    if (!empty($item['social'])) {
                        $social = str_replace('fa fa-', '', $item['social']);
                    }
                    
                    if (($is_new || $migrated) && 'svg' !== $item['social_icon']['library']) {
                        $social_parts = explode(' ', $item['social_icon']['value'], 2);
                        if (!empty($social_parts[1])) {
                            $social = str_replace('fa-', '', $social_parts[1]);
                        }
                    }
                    
                    if ('svg' === $item['social_icon']['library']) {
                        $social = get_post_meta($item['social_icon']['value']['id'], '_wp_attachment_image_alt', true);
                    }
                    
                    $link_key = 'social_link_' .  $team_index . '_' . $index;
                    
                    $this->add_render_attribute($link_key, [
                        'href' => $item['link']['url'],
                        'class' => 'elematic-social-icon',
                        'aria-label' => ucwords($social),
                    ]);
                    
                    if (!empty($item['link']['is_external'])) {
                        $this->add_render_attribute($link_key, 'target', '_blank');
                    }
                    
                    if (!empty($item['link']['nofollow'])) {
                        $this->add_render_attribute($link_key, 'rel', 'nofollow');
                    }
                    
                    if (! empty($item['link']['is_external']) || !empty($item['link']['nofollow'])) {
                        $rel_parts = [];
                        if (!empty($item['link']['is_external'])) {
                            $rel_parts[] = 'noopener noreferrer';
                        }
                        if (!empty($item['link']['nofollow'])) {
                            $rel_parts[] = 'nofollow';
                        }
                        $this->add_render_attribute($link_key, 'rel', implode(' ', $rel_parts));
                    }
                ?>
                    <a <?php $this->print_render_attribute_string($link_key); ?>>
                        <span class="elementor-screen-only"><?php echo esc_html(ucwords($social)); ?></span>
                        <?php
                        if($is_new || $migrated) {
                            Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true']);
                        } else {
                            echo '<i class="' . esc_attr($item['social']) . '" aria-hidden="true"></i>';
                        }
                        ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $img_hover = $settings['image_hover'] ? 'elematic-img-zoom' : '';
        $this->add_render_attribute(
            [
                'elematic-container' => [
                    'class' => [
                        'elematic-team-container',
                        $settings['team_style'],
                        $img_hover,
                    ]
                ]
            ]
        );
    ?>  
        <div class="elematic-team-wrap">
            <?php foreach ( $settings['team'] as $team_index => $team ) : ?>
                <div <?php $this->print_render_attribute_string('elematic-container'); ?>>
                    <?php if(!empty($team['user_image']['url'])) : ?>
                        <div class="elematic-team-image">
                            <?php Group_Control_Image_Size::print_attachment_image_html( $team, 'image', 'user_image' ); ?>
                            <?php if('style-2' === $settings['team_style']): ?>
                                <?php $this->render_social_profiles($team['social_icon_list'], $team_index); ?>
                            <?php endif; ?>
                        </div><!-- elematic-team-image -->
                    <?php endif; ?>

                    <div class="elematic-team-content">
                        <?php if ( ! empty($team['link_url']['url']) ) : 
                            $target = $team['link_url']['is_external'] ? ' target="_blank"' : '';
                            $nofollow = $team['link_url']['nofollow'] ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($team['link_url']['url']); ?>"<?php echo esc_attr($target) . esc_attr($nofollow); ?>>
                                <h3 class="elematic-team-name"><?php echo esc_html( $team['user_name'] ); ?></h3>
                            </a>
                        <?php else : ?>
                            <h3 class="elematic-team-name"><?php echo esc_html( $team['user_name'] ); ?></h3>    
                        <?php endif; ?>
                        
                        <?php if (!empty($team['position'])) : ?>
                            <div class="elematic-team-position"><?php echo esc_html( $team['position'] ); ?></div>
                        <?php endif; ?>
                        
                        <?php if (!empty($team['team_details'])) : ?>
                            <div class="elematic-team-details"><?php echo wp_kses_post( $team['team_details'] ); ?></div>
                        <?php endif; ?>
                        
                        <?php if( $settings['team_style'] != 'style-2' ): ?>
                            <?php $this->render_social_profiles($team['social_icon_list'], $team_index); ?>
                        <?php endif; ?>
                    </div><!-- elematic-team-content -->
                </div>
            <?php endforeach; ?>    
        </div><!-- wrap -->
    <?php
    }

} // class

