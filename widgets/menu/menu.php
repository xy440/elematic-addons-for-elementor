<?php
namespace Elematic\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Menu extends Widget_Base {

    public function get_name() {
        return 'elematic-menu';
    }

    public function get_title() {
        return ELEMATIC . esc_html__( 'Menu', 'elematic-addons-for-elementor' );
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_style_depends() {
        return [ 'elematic-menu' ];
    }

    public function get_script_depends() {
        return [ 'elematic-menu' ];
    }

    public function get_categories() {
        return [ 'elematic-widgets' ];
    }

    private function get_available_menus() {
        $menus = wp_get_nav_menus();

        $options = [];

        foreach ( $menus as $menu ) {
            $options[ $menu->slug ] = $menu->name;
        }

        return $options;
    }

	protected function register_controls() {

        $this->start_controls_section(
            'settings_tab',
            [
                'label' => esc_html__( 'Settings', 'elematic-addons-for-elementor' )
            ]
        );

        $menus = $this->get_available_menus();

        if ( ! empty( $menus ) ) {
            $this->add_control(
                'menu',
                [
                    'label'       => esc_html__( 'Chose Menu', 'elematic-addons-for-elementor' ),
                    'type'        => Controls_Manager::SELECT,
                    'options'     => $menus,
                    'default'     => array_keys( $menus )[0],
                    /* translators: %s: URL to the Menus screen in WP admin.  */
                    'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'elematic-addons-for-elementor' ), admin_url( 'nav-menus.php' ) ),
                ]
            );
        } else {
            $this->add_control(
                'menu',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    
					'raw' => wp_kses_post(
						sprintf(
                            /* translators: %s: URL to the Menus screen in WP admin. */
							__( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'elematic-addons-for-elementor' ),
							esc_url( admin_url( 'nav-menus.php?action=edit&menu=0' ) )
						)
					),
                ]
            );
        }

        $this->add_control(
            'submenu_arrow_switch',
            [
                'label' => esc_html__( 'Sub Menu Arrow Display', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'elematic-addons-for-elementor' ),
                'label_off' => esc_html__( 'Hide', 'elematic-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'dropdown_icon',
            [
                'label' => esc_html__( 'Dropdown Icon', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'submenu_arrow_switch' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'submenu_arrow_size',
            [
                'label' => esc_html__( 'Sub Menu Arrow Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic--mb-dropdown-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elematic--mb-dropdown-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'submenu_arrow_switch' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'submenu_arrow_y',
            [
                'label' => esc_html__( 'Sub Menu Arrow Position Y', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic--mb-dropdown-icon' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'submenu_arrow_switch' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'submenu_arrow_x',
            [
                'label' => esc_html__( 'Sub Menu Arrow Position X', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic--mb-dropdown-icon' => 'margin-left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'submenu_arrow_switch' => 'yes'
                ]
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'tx_menu_icons',
                [ 
                    'label' => esc_html__( 'Responsive Menu Icons', 'elematic-addons-for-elementor' ),

                ]
            );

        $this->add_control(
            'hamburger_icon',
            [
                'label' => esc_html__( 'Hamburger Icon', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-bars',
                    'library' => 'fa-solid',
                ],
            ]
        );
        
        $this->add_control(
            'close_icon',
            [
                'label' => esc_html__( 'Close Icon', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-times',
                    'library' => 'fa-solid',
                ],
            ]
        );
        $this->add_control(
            'hamburger_icon_size',
            [
                'label' => esc_html__( 'Hamburger Icon Size', 'elematic-addons-for-elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elematic-mobile-nav-show i, {{WRAPPER}} .elematic-mobile-nav-hide i' => 'font-size: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elematic-mobile-nav-show svg, {{WRAPPER}} .elematic-mobile-nav-hide svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
                ],
                
            ]
        );
        $this->add_control(
            'dropdown_icon_open',
            [
                'label' => esc_html__( 'Dropdown Icon (Closed)', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'dropdown_icon_close',
            [
                'label' => esc_html__( 'Dropdown Icon (Opened)', 'elematic-addons-for-elementor' ),
                'type'  => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_tab',
            [
                'label' => esc_html__( 'Style', 'elematic-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs( 'style_tabs' );

            $this->start_controls_tab( 
                'style_normal', 
                [ 
                    'label' => esc_html__( 'Main Menu', 'elematic-addons-for-elementor' ) 
                ] 
            );

            $this->add_responsive_control(
                'menu_item_color',
                [
                    'label' => esc_html__( 'Color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar a, {{WRAPPER}} .elematic-navbar a:focus, {{WRAPPER}} .elematic--mb-dropdown-icon i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .elematic--mb-dropdown-icon svg' => 'fill: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'menu_item_hov_color',
                [
                    'label' => esc_html__( 'Hover color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar a:hover, {{WRAPPER}} .elematic-navbar li:hover>a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'menu_bg_color',
                [
                    'label' => esc_html__( 'Background color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar>ul>li' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'menu_bg_hover_color',
                [
                    'label' => esc_html__( 'Background Hover color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar>ul>li:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'menu_item_active_color',
                [
                    'label' => esc_html__( 'Active color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar>ul>li.current-menu-item>a, {{WRAPPER}} .elematic-navbar>ul>li.current_page_parent>a, {{WRAPPER}} .current-page-ancestor>a' => 'color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'menu_bg_active_color',
                [
                    'label' => esc_html__( 'Background Hover color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar>ul>li:hover' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'menu_item_typo',
                    'selector'  => '{{WRAPPER}} .elematic-navbar a',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name'      => 'menu_item_text_shadow',
                    'label'     => esc_html__( 'Text Shadow', 'elematic-addons-for-elementor' ),
                    'selector'  => '{{WRAPPER}} .elematic-navbar a',
                ]
            );
            $this->add_responsive_control(
                'menu_item_padding',
                [
                    'label' => esc_html__( 'Padding', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar>ul>li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'menu_item_margin',
                [
                    'label' => esc_html__( 'Margin', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar>ul>li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'menu_item_border',
                    'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-navbar>ul>li',
                ]
            );
            $this->add_responsive_control(
                'menu_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar>ul>li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            $this->end_controls_tab();

            $this->start_controls_tab( 
                'style_sub_menu', 
                [ 
                    'label' => esc_html__( 'Sub Menu', 'elematic-addons-for-elementor' ) 
                ] 
            );
            $this->add_responsive_control(
                'menu_sub_item_color',
                [
                    'label' => esc_html__( 'Sub menu color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar .menu-item-has-children ul a, {{WRAPPER}} .elematic-navbar .menu-item-has-children ul .elematic--mb-dropdown-icon i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .elematic-navbar .menu-item-has-children ul .elematic--mb-dropdown-icon svg' => 'fill: {{VALUE}};',
                    ],
                ]
            );
            $this->add_responsive_control(
                'menu_sub_item_hov_color',
                [
                    'label' => esc_html__( 'Sub menu hover color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar .menu-item-has-children ul a:hover, {{WRAPPER}} .elematic-navbar .menu-item-has-children ul li:hover a, {{WRAPPER}} .elematic-navbar .menu-item-has-children>a:hover:after' => 'color: {{VALUE}};',
                         
                    ],
                ]
            );
            $this->add_responsive_control(
                'sub_menu_bg_color',
                [
                    'label' => esc_html__( 'Sub menu background color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar .menu-item-has-children:hover>ul, {{WRAPPER}} .elematic-navbar .menu-item-has-children .menu-item-has-children ul' => 'background-color: {{VALUE}};',
                    ],
                ]
            );
            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name' => 'sub_menu_border',
                    'label' => esc_html__( 'Border', 'elematic-addons-for-elementor' ),
                    'selector' => '{{WRAPPER}} .elematic-navbar .menu-item-has-children:hover>ul, {{WRAPPER}} .elematic-navbar .menu-item-has-children .menu-item-has-children ul',
                ]
            );
            $this->add_responsive_control(
                'sub_menu_border_radius',
                [
                    'label' => esc_html__( 'Border Radius', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', 'em', '%' ],
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar .menu-item-has-children:hover>ul, {{WRAPPER}} .elematic-navbar .menu-item-has-children .menu-item-has-children ul' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name'      => 'menu_sub_item_typo',
                    'selector'  => '{{WRAPPER}} .elematic-navbar .menu-item-has-children ul a',
                ]
            );
            $this->add_group_control(
                Group_Control_Text_Shadow::get_type(),
                [
                    'name'      => 'menu_sub_item_text_shadow',
                    'label'     => esc_html__( 'Text Shadow', 'elematic-addons-for-elementor' ),
                    'selector'  => '{{WRAPPER}} .main-menu li ul li a',
                ]
            );
            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'menu_sub_box_shadow',
                    'selector' => '{{WRAPPER}} .main-menu li>ul',
                ]
            );
            $this->end_controls_tab();

            
        $this->end_controls_tab();
        $this->start_controls_tab( 
                'style_res_tab', 
                [ 
                    'label' => esc_html__( 'Resposive Menu', 'elematic-addons-for-elementor' ) 
                ] 
            );
        $this->add_control(
            'responsive_note',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => '<strong>'.esc_html__( 'Please enable Resposive mode to see the resposive menu changes.', 'elematic-addons-for-elementor' ).'</strong>',
            ]
        );
        $this->add_responsive_control(
            'menu_hamburger_color',
                [
                    'label' => esc_html__( 'Hamburger color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-mobile-nav-show i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .elematic-mobile-nav-show svg' => 'fill: {{VALUE}};',
                    ],
                ]
        );
        $this->add_responsive_control(
            'menu_hamburger_close_color',
                [
                    'label' => esc_html__( 'Hamburger close color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-mobile-nav-hide i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .elematic-mobile-nav-hide svg' => 'fill: {{VALUE}};',
                    ],
                ]
        );
        $this->add_responsive_control(
            'menu_res_item_border_color',
                [
                    'label' => esc_html__( 'Border color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar li' => 'border-color: {{VALUE}};',
                    ],
                ]
        );
        $this->add_responsive_control(
            'menu_res_bg_color',
                [
                    'label' => esc_html__( 'Background color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar' => 'background-color: {{VALUE}};',
                    ],
                ]
        );
        $this->add_responsive_control(
            'menu_res_sub_icon_color',
                [
                    'label' => esc_html__( 'Dropdown icon color', 'elematic-addons-for-elementor' ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .elematic-navbar .elematic--mb-dropdown-icon i' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .elematic-navbar .elematic--mb-dropdown-icon svg' => 'fill: {{VALUE}};',
                    ],
                ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

	protected function render() {
    $available_menus = $this->get_available_menus();
    if ( ! $available_menus ) return;

    $settings = $this->get_settings_for_display();
    if ( empty( $settings['menu'] ) ) return;

    $nav_id = 'elematic-navbar-' . $this->get_id();
    
    // Check if arrows should be shown
    $show_arrows = ( $settings['submenu_arrow_switch'] === 'yes' );

    $args = [
        'echo'            => false,
        'menu'            => $settings['menu'],
        'container'       => 'nav',
        'container_class' => 'elematic-navbar',
        'container_id'    => $nav_id,
        'menu_id'         => 'main-menu-' . $this->get_id(),
        'menu_class'      => 'main-menu',
        'fallback_cb'     => '__return_empty_string',
    ];

    $markup = wp_nav_menu( $args );
    if ( empty( $markup ) ) return;

    // Add class to wrapper based on arrow setting
    $wrapper_class = 'elematic-menu-wrap';
    if ( ! $show_arrows ) {
        $wrapper_class .= ' elematic-hide-arrows';
    }

    echo '<div class="' . esc_attr( $wrapper_class ) . '">';

    // Open (hamburger) button
    echo '<button class="elematic-mobile-nav-show" aria-controls="main-menu-' . esc_attr( $this->get_id() ) . '" aria-expanded="false" aria-label="' . esc_attr__( 'Open menu', 'elematic-addons-for-elementor' ) . '">';
    Icons_Manager::render_icon( $settings['hamburger_icon'], [ 'aria-hidden' => 'true' ], 'i' ); 
    echo '</button>';

    // Close button
    echo '<button class="elematic-mobile-nav-hide" aria-controls="main-menu-' . esc_attr( $this->get_id() ) . '" aria-expanded="true" aria-label="' . esc_attr__( 'Close menu', 'elematic-addons-for-elementor' ) . '">';
    Icons_Manager::render_icon( $settings['close_icon'], [ 'aria-hidden' => 'true' ], 'i' );
    echo '</button>';

    // Only render dropdown icons if arrows are enabled
    if ( $show_arrows ) {
        if( wp_is_mobile() ):
            // Hidden dropdown template with two states
            echo '<span class="elematic--mb-dropdown-template" style="display:none">';
            echo '<span class="icon-closed">';
            Icons_Manager::render_icon( $settings['dropdown_icon_open'], [ 'aria-hidden' => 'true' ], 'i' );
            echo '</span>';
            echo '<span class="icon-opened" style="display:none">';
            Icons_Manager::render_icon( $settings['dropdown_icon_close'], [ 'aria-hidden' => 'true' ], 'i' );
            echo '</span>';
            echo '</span>';
        else:
            // Hidden dropdown template (JS clones inner HTML)
            echo '<span class="elematic--mb-dropdown-template" style="display:none">';
            Icons_Manager::render_icon( $settings['dropdown_icon'], [ 'aria-hidden' => 'true' ] );
            echo '</span>';
        endif;
    }

    echo wp_kses_post( $markup );
    echo '</div>';
}

}